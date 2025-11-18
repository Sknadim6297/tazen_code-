<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Availability;
use App\Models\Booking;
use App\Models\BookingTimedate;
use App\Models\McqAnswer;
use App\Models\Professional;
use App\Models\ProfessionalOtherInformation;
use App\Models\ProfessionalService;
use App\Models\Profile;
use App\Models\Rate;
use App\Models\SubService;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use App\Models\Service;
use App\Models\Banner;
use App\Models\AboutUs;
use App\Models\Whychoose;
use App\Models\Testimonial;
use App\Models\HomeBlog;
use App\Models\Howworks;
use Illuminate\Support\Facades\Session;
use App\Models\ServiceMCQ;
use App\Models\Blog;
use App\Models\AllEvent;
use App\Models\MCQ;
use App\Models\RequestedService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\BlogPost;
use App\Models\EventDetail;
use App\Models\Review;
use App\Models\CategoryBox;
use App\Models\FAQ;
use Illuminate\Http\Request;
use Illuminate\Support\Str;


class HomeController extends Controller
{
    public function index()
    {
        $services = Service::latest()->get();
        $banners = Banner::latest()->get();
        $about_us = AboutUs::latest()->get();
        $whychooses = Whychoose::latest()->get();
        $testimonials = Testimonial::latest()->get();
        $homeblogs = HomeBlog::latest()->get();
        $howworks = Howworks::latest()->get();
        $blogPosts = BlogPost::with('blog')->latest()->take(3)->get();
        $mcqs = DB::table('service_m_c_q_s')->get();
        $serviceId = 1; // Change this based on which service you're targeting (dynamic or static)
        $mcqs = ServiceMCQ::where('service_id', $serviceId)->get();
        
        // Fetch admin events (EventDetail with event relationship) - ONLY admin created events that are approved and set to show on homepage
        $adminEvents = EventDetail::with(['event' => function($query) {
                $query->where('status', 'approved')
                      ->where('show_on_homepage', true);
            }])
            ->where('creator_type', 'admin')
            ->whereHas('event', function($query) {
                $query->where('status', 'approved')
                      ->where('show_on_homepage', true);
            })
            ->latest()
            ->take(6)
            ->get();
        
        // Fetch approved professional events (AllEvent) that are also set to show on homepage
        $professionalEvents = AllEvent::with('professional')
            ->where('created_by_type', 'professional')
            ->where('status', 'approved')
            ->where('show_on_homepage', true)
            ->latest()
            ->take(6)
            ->get();
        
        // Combine both admin and professional events, then take only 6 most recent
        $allEvents = collect();
        
        // Add admin events with creator type
        foreach ($adminEvents as $adminEvent) {
            $allEvents->push((object)[
                'id' => $adminEvent->id,
                'event_id' => $adminEvent->event_id,
                'event' => $adminEvent->event,
                'banner_image' => $adminEvent->banner_image,
                'starting_date' => $adminEvent->starting_date,
                'starting_fees' => $adminEvent->starting_fees,
                'city' => $adminEvent->city,
                'event_mode' => $adminEvent->event_mode,
                'created_at' => $adminEvent->created_at,
                'creator_type' => 'admin'
            ]);
        }
        
        // Add professional events with creator type
        foreach ($professionalEvents as $proEvent) {
            $allEvents->push((object)[
                'id' => $proEvent->id,
                'event_id' => $proEvent->id,
                'event' => $proEvent,
                'banner_image' => $proEvent->card_image ? [$proEvent->card_image] : null,
                'starting_date' => $proEvent->date,
                'starting_fees' => $proEvent->starting_fees,
                'city' => null,
                'event_mode' => null,
                'created_at' => $proEvent->created_at,
                'creator_type' => 'professional',
                'professional' => $proEvent->professional
            ]);
        }
        
        // Sort by created_at descending and take only 6
        $eventDetails = $allEvents->sortByDesc('created_at')->take(6)->values();
        
        $categoryBoxes = CategoryBox::with(['subCategories' => function($query) {
            $query->where('status', true)
                  ->select('id', 'category_box_id', 'service_id', 'name', 'image', 'status');
        }])->where('status', true)->get();
        $faqs = FAQ::where('status', true)->orderBy('order')->get();
        return view('frontend.index', compact('services', 'banners', 'about_us', 'whychooses', 'testimonials', 'homeblogs', 'howworks', 'mcqs', 'blogPosts', 'eventDetails', 'categoryBoxes', 'faqs'));
    }

    //     public function getServiceQuestions($serviceId)
    // {
    //     $questions = DB::table('service_m_c_q_s')
    //                    ->where('service_id', $serviceId)
    //                    ->take(5)
    //                    ->get();

    //     return view('frontend.partials.mcq_questions', compact('questions'));
    // }


    public function showServiceQuestions($serviceId)
    {
        $mcqs = ServiceMCQ::where('service_id', $serviceId)->get();
        $service = Service::find($serviceId);

        return view('frontend.index', compact('mcqs', 'service'));
    }

    public function submitQuestionnaire(Request $request)
    {
        if (!Auth::guard('user')->check()) {
            return response()->json([
                'success' => false,
                'message' => 'You have to login for book.',
                'redirect_to' => route('login')
            ], 403);
        }

        // Parse the JSON answers string into an array
        $answers = json_decode($request->input('answers'), true);

        // Validation
        $request->validate([
            'service_id' => 'required|integer|exists:services,id',
            'answers' => 'required|string' // Changed to string since we're sending JSON
        ]);

        // Validate the parsed answers array
        if (!is_array($answers)) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid answers format'
            ], 422);
        }

        foreach ($answers as $answer) {
            if (!isset($answer['question_id']) || !isset($answer['answer'])) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid answer format'
                ], 422);
            }
        }

        // Save answers temporarily without booking_id (will be linked when booking is completed)
        foreach ($answers as $answer) {
            McqAnswer::create([
                'user_id' => Auth::guard('user')->id(),
                'service_id' => $request->service_id,
                'question_id' => $answer['question_id'],
                'answer' => $answer['answer']
                // booking_id will be added when booking is completed
            ]);
        }

        $service = Service::find($request->service_id);
        if ($service) {
            session([
                'selected_service_id' => $request->service_id,
                'selected_service_name' => $service->name,
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Redirecting to booking page',
            'logged_in' => true
        ]);
    }


    public function professionals(Request $request)
    {
        $services = Service::with('subServices')->get();

        // Get selected service ID either from request or session
        $selectedServiceId = $request->input('service_id', Session::get('selected_service_id'));

        // If service_id is provided in request, store it in session
        if ($request->has('service_id') && $request->service_id) {
            $service = Service::find($request->service_id);
            if ($service) {
                session([
                    'selected_service_id' => $request->service_id,
                    'selected_service_name' => $service->name,
                ]);
                $selectedServiceId = $request->service_id;
            }
        }

        $professionalsQuery = Professional::with('profile', 'professionalServices.subServices', 'professionalServices.service')
            ->where('status', 'accepted')
            ->where('active', true);

        // Filter by service
        if ($selectedServiceId) {
            $professionalsQuery->whereHas('professionalServices', function ($query) use ($selectedServiceId) {
                $query->where('service_id', $selectedServiceId);
            });
        }

        // Filter by sub-service - try both sub-service ID and tags matching
        if ($request->has('sub_service_id') && !empty($request->sub_service_id)) {
            // Get the sub-service name
            $subService = SubService::find($request->sub_service_id);
            
            if ($subService) {
                $subServiceName = strtolower($subService->name);
                
                // Filter by either sub-service ID relationship OR tags containing the sub-service name
                $professionalsQuery->where(function($query) use ($request, $subServiceName) {
                    // Try sub-service relationship first
                    $query->whereHas('professionalServices.subServices', function ($q) use ($request) {
                        $q->where('sub_services.id', $request->sub_service_id);
                    })
                    // OR filter by tags matching sub-service name
                    ->orWhereHas('professionalServices', function ($q) use ($subServiceName) {
                        $q->whereRaw('LOWER(tags) LIKE ?', ['%' . $subServiceName . '%']);
                    });
                });
            }
        }

        // Filter by experience
        if ($request->has('experience') && !empty($request->experience)) {
            $expRange = $request->experience;

            $professionalsQuery->whereHas('profile', function ($query) use ($expRange) {
                $query->where('experience', $expRange);
            });
        }

        // Filter by price range
        if ($request->has('price_range') && !empty($request->price_range)) {
            $priceRange = $request->price_range;

            if (strpos($priceRange, '+') !== false) {
                // Handle "5000+" type ranges
                $minPrice = (int)str_replace('+', '', $priceRange);
                $professionalsQuery->whereHas('profile', function ($query) use ($minPrice) {
                    $query->where('starting_price', '>=', $minPrice);
                });
            } else {
                // Handle "1000-3000" type ranges
                list($minPrice, $maxPrice) = explode('-', $priceRange);
                $professionalsQuery->whereHas('profile', function ($query) use ($minPrice, $maxPrice) {
                    $query->whereBetween('starting_price', [$minPrice, $maxPrice]);
                });
            }
        }

        // Paginate results instead of getting all at once
        $professionals = $professionalsQuery->latest()->paginate(12);

        // When using filters, we need to append them to pagination links
        if ($request->hasAny(['experience', 'price_range', 'service_id', 'sub_service_id'])) {
            $professionals->appends($request->only(['experience', 'price_range', 'service_id', 'sub_service_id']));
        }

        // Get sub-services for the selected service to populate the filter dropdown
        $subServices = collect();
        if ($selectedServiceId) {
            $selectedService = $services->find($selectedServiceId);
            if ($selectedService) {
                $subServices = $selectedService->subServices;
            }
        }

        return view('frontend.sections.gridlisting', compact('professionals', 'services', 'subServices', 'selectedServiceId'));
    }



    public function professionalsDetails($id, $professional_name = null, $sub_service_slug = null)
    {
        // Handle sub-service slug resolution
        $requestedSubServiceId = null;
        
        if ($sub_service_slug) {
            // Convert slug to sub-service ID
            $subService = SubService::where('name', 'LIKE', '%' . str_replace('-', ' ', $sub_service_slug) . '%')
                                  ->orWhere('name', 'LIKE', '%' . str_replace('-', '%', $sub_service_slug) . '%')
                                  ->first();
            
            if (!$subService) {
                // Try a more flexible approach - match slug pattern
                $searchName = ucwords(str_replace('-', ' ', $sub_service_slug));
                $subService = SubService::where('name', 'LIKE', '%' . $searchName . '%')->first();
            }
            
            if ($subService) {
                $requestedSubServiceId = $subService->id;
            } else {
                // If slug not found, check if old query parameter exists as fallback
                $requestedSubServiceId = request('sub_service_id');
                
                // If no fallback found, redirect to professional page without sub-service
                if (!$requestedSubServiceId) {
                    return redirect()->route('professionals.details', [
                        'id' => $id, 
                        'professional_name' => $professional_name
                    ]);
                }
            }
        } else {
            // Fallback to query parameter for backward compatibility
            $requestedSubServiceId = request('sub_service_id');
        }
        
        $requestedService = ProfessionalOtherInformation::where('professional_id', $id)->first();
        $profile = Profile::with(['professional.reviews' => function ($query) {
            $query->with(['user' => function ($q) {
                $q->with('customerProfile');
            }])->orderBy('created_at', 'desc');
        }])->where('professional_id', $id)->first();

        $services = ProfessionalService::where('professional_id', $id)->with('professional', 'subServices')->first();
        
        // Process requirements to ensure they are properly formatted
        if ($services && $services->requirements) {
            // Check if requirements is a JSON string with escaped quotes
            if (is_string($services->requirements) && strpos($services->requirements, '\"') !== false) {
                $services->requirements = json_decode(str_replace('\"', '"', $services->requirements));
            } 
            // Check if requirements is a normal JSON string
            elseif (is_string($services->requirements) && (strpos($services->requirements, '[') === 0 || strpos($services->requirements, '{') === 0)) {
                $services->requirements = json_decode($services->requirements);
            } 
            // If it's a simple string, convert to array
            elseif (!is_array($services->requirements)) {
                $services->requirements = [$services->requirements];
            }
        }
        
        // Filter both rates and availabilities by sub-service if specified
        $ratesQuery = Rate::where('professional_id', $id)->with('professional', 'subService.service');
        $availabilitiesQuery = Availability::where('professional_id', $id)->with('slots');
        
        if ($requestedSubServiceId) {
            // Show rates and availabilities for the specific sub-service
            $ratesQuery->where('sub_service_id', $requestedSubServiceId);
            $availabilitiesQuery->where('sub_service_id', $requestedSubServiceId);
        } else {
            // Show service-level rates and availabilities (without sub-service assignment)
            $ratesQuery->whereNull('sub_service_id');
            $availabilitiesQuery->whereNull('sub_service_id');
        }
        
        $rates = $ratesQuery->get();
        $availabilities = $availabilitiesQuery->get();
        
        // If no availabilities found with sub-service filter, try to get general availabilities
        if ($availabilities->isEmpty()) {
            $availabilities = Availability::where('professional_id', $id)
                ->with('slots')
                ->whereNull('sub_service_id')
                ->get();
        }

        // Debug: Log what we found
        Log::info('Frontend Professional Details Debug', [
            'professional_id' => $id,
            'requested_sub_service_id' => $requestedSubServiceId,
            'availabilities_count' => $availabilities->count(),
            'availabilities_data' => $availabilities->toArray(),
            'total_availabilities_for_professional' => Availability::where('professional_id', $id)->count()
        ]);

        $enabledDates = [];
        $dayMap = [
            'mon' => 1,
            'tue' => 2,
            'wed' => 3,
            'thu' => 4,
            'fri' => 5,
            'sat' => 6,
            'sun' => 7,
        ];

        foreach ($availabilities as $availability) {
            $availabilityMonth = $availability->month; // e.g., "2026-05"
            
            // Parse the month to get year and month
            try {
                // Check if month is in "YYYY-MM" format (new format)
                if (preg_match('/^\d{4}-\d{2}$/', $availabilityMonth)) {
                    $monthDate = Carbon::createFromFormat('Y-m', $availabilityMonth)->startOfMonth();
                    $monthStart = $monthDate->copy();
                    $monthEnd = $monthDate->copy()->endOfMonth();
                    
                    // Make sure we don't go before today
                    $startDate = Carbon::today()->max($monthStart);
                    $endDate = $monthEnd;
                    
                } else {
                    // Legacy format handling - numeric months or month names
                    if (is_numeric($availability->month)) {
                        $monthNumber = str_pad($availability->month, 2, '0', STR_PAD_LEFT);
                    } else {
                        $monthNumber = Carbon::parse("1 " . $availability->month)->format('m');
                    }

                    $currentYear = Carbon::now()->year;
                    $currentMonth = Carbon::now()->month;
                    
                    // Determine the correct year - if the availability month is before or equal to current month, use next year
                    $year = $currentYear;
                    if ($monthNumber < $currentMonth || ($monthNumber == $currentMonth && Carbon::now()->day > 15)) {
                        $year = $currentYear + 1;
                    }
                    
                    $startDate = Carbon::createFromFormat('Y-m-d', "$year-$monthNumber-01");
                    $endDate = $startDate->copy()->endOfMonth();
                }
                
            } catch (\Exception $e) {
                Log::error('Failed to parse month: ' . $availability->month, ['error' => $e->getMessage()]);
                continue;
            }
            
            // Skip if the entire month is in the past
            if ($endDate->isPast()) {
                continue;
            }
            
            $period = CarbonPeriod::create($startDate, $endDate);
            
            // Get weekdays available for this month from slots (new structure)
            $availableWeekdays = collect();
            
            if ($availability->slots && $availability->slots->count() > 0) {
                foreach ($availability->slots as $slot) {
                    if ($slot->weekday) {
                        $weekday = strtolower($slot->weekday);
                        if (isset($dayMap[$weekday])) {
                            $availableWeekdays->push($dayMap[$weekday]);
                        }
                    }
                }
            } else {
                // Fallback to old weekdays field if no slots
                $decoded = $availability->weekdays;
                if (is_string($decoded)) {
                    $decoded = json_decode($decoded);
                    if (is_string($decoded)) {
                        $decoded = json_decode($decoded);
                    }
                }
                
                if (is_array($decoded)) {
                    foreach ($decoded as $day) {
                        if (isset($dayMap[strtolower($day)])) {
                            $availableWeekdays->push($dayMap[strtolower($day)]);
                        }
                    }
                }
            }
            
            $isoDays = $availableWeekdays->unique()->toArray();

            foreach ($period as $date) {
                if (in_array($date->dayOfWeekIso, $isoDays)) {
                    $enabledDates[] = $date->toDateString();
                }
            }
        }

        // Fetch all existing bookings for this professional using the new method
        $existingBookings = BookingTimedate::getBookedSlots($id);

        return view('frontend.sections.professional-details', compact(
            'profile',
            'availabilities',
            'services',
            'rates',
            'enabledDates',
            'requestedService',
            'existingBookings',
            'requestedSubServiceId'
        ), ['showFooter' => false]);
    }

    /**
     * Get sub-services for a service via AJAX
     */
    public function getSubServices(Request $request)
    {
        $serviceId = $request->input('service_id');
        $subServices = SubService::where('service_id', $serviceId)->get();
        
        return response()->json([
            'success' => true,
            'sub_services' => $subServices
        ]);
    }

    /**
     * Get rates and availability for a professional service/sub-service via AJAX
     */
    public function getProfessionalRatesAvailability(Request $request)
    {
        $professionalId = $request->input('professional_id');
        $professionalServiceId = $request->input('professional_service_id');
        $subServiceId = $request->input('sub_service_id');

        // Get rates - show service-level rates when no sub-service, sub-service rates when specified
        $ratesQuery = Rate::where('professional_id', $professionalId);
        // Only filter by professional_service_id if it's provided and not 0
        if ($professionalServiceId && $professionalServiceId > 0) {
            $ratesQuery->where('professional_service_id', $professionalServiceId);
        }
        if ($subServiceId) {
            // Show rates for the specific sub-service
            $ratesQuery->where('sub_service_id', $subServiceId);
        } else {
            // Show service-level rates (rates without sub-service assignment)
            $ratesQuery->whereNull('sub_service_id');
        }
        $rates = $ratesQuery->get();

        // Get availability - show service-level availability when no sub-service, sub-service availability when specified
        $availabilityQuery = Availability::where('professional_id', $professionalId)
            ->with('slots');
        // Only filter by professional_service_id if it's provided and not 0
        if ($professionalServiceId && $professionalServiceId > 0) {
            $availabilityQuery->where('professional_service_id', $professionalServiceId);
        }
        if ($subServiceId) {
            // Show availability for the specific sub-service
            $availabilityQuery->where('sub_service_id', $subServiceId);
        } else {
            // Show service-level availability (availability without sub-service assignment)
            $availabilityQuery->whereNull('sub_service_id');
        }
        $availabilities = $availabilityQuery->get();
        
        // If no availabilities found with sub-service filter, try to get general availabilities
        if ($availabilities->isEmpty()) {
            $availabilities = Availability::where('professional_id', $professionalId)
                ->with('slots')
                ->whereNull('sub_service_id')
                ->get();
        }

        // AJAX availability request received
        
        // Debug: Log what we found in AJAX
        Log::info('AJAX Professional Availability Debug', [
            'professional_id' => $professionalId,
            'professional_service_id' => $professionalServiceId,
            'sub_service_id' => $subServiceId,
            'availabilities_count' => $availabilities->count(),
            'availabilities_data' => $availabilities->toArray()
        ]);

        // Process availability dates
        $enabledDates = [];
        $dayMap = [
            'mon' => 1, 'tue' => 2, 'wed' => 3, 'thu' => 4,
            'fri' => 5, 'sat' => 6, 'sun' => 7,
        ];

        foreach ($availabilities as $availability) {
            $availabilityMonth = $availability->month; // e.g., "2026-05"
            
            // Parse the month to get year and month
            try {
                // Check if month is in "YYYY-MM" format (new format)
                if (preg_match('/^\d{4}-\d{2}$/', $availabilityMonth)) {
                    $monthDate = \Carbon\Carbon::createFromFormat('Y-m', $availabilityMonth)->startOfMonth();
                    $monthStart = $monthDate->copy();
                    $monthEnd = $monthDate->copy()->endOfMonth();
                    
                    // Make sure we don't go before today
                    $startDate = \Carbon\Carbon::today()->max($monthStart);
                    $endDate = $monthEnd;
                    
                } else {
                    // Legacy format handling - numeric months or month names
                    if (is_numeric($availability->month)) {
                        $monthNumber = str_pad($availability->month, 2, '0', STR_PAD_LEFT);
                    } else {
                        $monthNumber = \Carbon\Carbon::parse("1 " . $availability->month)->format('m');
                    }

                    $currentYear = \Carbon\Carbon::now()->year;
                    $currentMonth = \Carbon\Carbon::now()->month;
                    
                    // Determine the correct year - if the availability month is before or equal to current month, use next year
                    $year = $currentYear;
                    if ($monthNumber < $currentMonth || ($monthNumber == $currentMonth && \Carbon\Carbon::now()->day > 15)) {
                        $year = $currentYear + 1;
                    }
                    
                    $startDate = \Carbon\Carbon::createFromFormat('Y-m-d', "$year-$monthNumber-01");
                    $endDate = $startDate->copy()->endOfMonth();
                }
                
            } catch (\Exception $e) {
                Log::error('AJAX Failed to parse month: ' . $availability->month, ['error' => $e->getMessage()]);
                continue;
            }
            
            // Skip if the entire month is in the past
            if ($endDate->isPast()) {
                continue;
            }
            
            $period = \Carbon\CarbonPeriod::create($startDate, $endDate);
            
            // Get weekdays available for this month from slots (new structure)
            $availableWeekdays = collect();
            
            if ($availability->slots && $availability->slots->count() > 0) {
                foreach ($availability->slots as $slot) {
                    if ($slot->weekday) {
                        $weekday = strtolower($slot->weekday);
                        if (isset($dayMap[$weekday])) {
                            $availableWeekdays->push($dayMap[$weekday]);
                        }
                    }
                }
            } else {
                // Fallback to old weekdays field if no slots
                $decoded = json_decode($availability->weekdays);
                if (is_string($decoded)) {
                    $decoded = json_decode($decoded);
                }
                
                if (is_array($decoded)) {
                    foreach ($decoded as $day) {
                        if (isset($dayMap[strtolower($day)])) {
                            $availableWeekdays->push($dayMap[strtolower($day)]);
                        }
                    }
                }
            }
            
            $isoDays = $availableWeekdays->unique()->toArray();

            // AJAX weekdays processed

            foreach ($period as $date) {
                if (in_array($date->dayOfWeekIso, $isoDays)) {
                    $enabledDates[] = $date->toDateString();
                    // AJAX added enabled date
                }
            }
        }

        // Return final enabled dates

        // Get sub-service name if sub-service ID is provided
        $subServiceName = null;
        if ($subServiceId) {
            $subService = \App\Models\SubService::find($subServiceId);
            $subServiceName = $subService ? $subService->name : null;
        }

        return response()->json([
            'success' => true,
            'rates' => $rates,
            'availabilities' => $availabilities,
            'enabled_dates' => $enabledDates,
            'sub_service_name' => $subServiceName
        ]);
    }





    // public function getAvailabilitySlots(Request $request)
    // {
    //     $date = $request->input('date');
    //     $professionalId = $request->input('professional_id');

    //     $dayName = strtolower(date('D', strtotime($date)));
    //     $monthAbbr = strtolower(date('M', strtotime($date)));

    //     $availability = Availability::where('professional_id', $professionalId)
    //         ->where('month', $monthAbbr)
    //         ->with('slots')
    //         ->first();

    //     if (!$availability || !in_array($dayName, json_decode($availability->weekdays))) {
    //         return response()->json(['slots' => []]);
    //     }

    //     return response()->json(['slots' => $availability->slots]);
    // }

    public function storeInSession(Request $request)
    {
        try {
            $request->validate([
                'professional_id' => 'required|exists:professionals,id',
                'plan_type' => 'required|string',
                'bookings' => 'required|array',
                'total_amount' => 'required|numeric',
            ]);

            $bookingData = [];
            $professionalId = $request->professional_id;
            $conflictingSlots = [];

            foreach ($request->bookings as $date => $slots) {
                if (!empty($slots)) {
                    $timeSlot = BookingTimedate::normalizeTimeSlot($slots[0]); // Take the first slot for each date and normalize
                    
                    // Check for existing bookings for this professional at this date/time
                    if (BookingTimedate::isSlotBooked($professionalId, $date, $timeSlot)) {
                        $conflictingSlots[] = $date . ' at ' . $timeSlot;
                    } else {
                        $bookingData[] = [
                            'date' => $date,
                            'time_slot' => $timeSlot,
                        ];
                    }
                }
            }

            // If there are conflicts, return error
            if (!empty($conflictingSlots)) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'The following time slots are already booked: ' . implode(', ', $conflictingSlots) . '. Please refresh the page and select different time slots.'
                ], 422);
            }

            if (empty($bookingData)) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'No valid booking slots provided'
                ], 422);
            }

            session(['booking_data' => [
                'professional_id' => $request->professional_id,
                'plan_type' => $request->plan_type,
                'bookings' => $bookingData,
                'total_amount' => $request->total_amount,
                'service_id' => session('selected_service_id'),
                'service_name' => session('selected_service_name'),
                'professional_name' => $request->professional_name ?? null,
                'professional_address' => $request->professional_address ?? null,
            ]]);

            return response()->json([
                'status' => 'success',
                'message' => 'Booking saved successfully!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'An error occurred: ' . $e->getMessage()
            ], 500);
        }
    }




    public function store(Request $request)
    {
        $validated = $request->validate([
            'phone' => 'required|string',
        ]);

        try {
            $bookingData = session('booking_data');

            if (!$bookingData || !isset($bookingData['bookings']) || !count($bookingData['bookings'])) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'No bookings data found in the session.'
                ], 400);
            }

            // Check for existing bookings conflicts before creating new booking
            $professionalId = $bookingData['professional_id'];
            $conflictingSlots = [];
            
            foreach ($bookingData['bookings'] as $entry) {
                $date = Carbon::parse($entry['date'])->format('Y-m-d');
                $timeSlot = $entry['time_slot'];
                
                // Check if this time slot is already booked for this professional
                if (BookingTimedate::isSlotBooked($professionalId, $date, $timeSlot)) {
                    $conflictingSlots[] = $date . ' at ' . $timeSlot;
                }
            }
            
            // If there are conflicts, return error
            if (!empty($conflictingSlots)) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'The following time slots are already booked: ' . implode(', ', $conflictingSlots) . '. Please select different time slots.'
                ], 422);
            }

            // Start database transaction to ensure atomicity
            DB::beginTransaction();

            // Get professional and service name with fallbacks
            $professional = Professional::find($bookingData['professional_id']);
            $serviceName = session('selected_service_name');
            if (!$serviceName || $serviceName === 'N/A') {
                if ($professional) {
                    $professionalService = ProfessionalService::with('service')
                        ->where('professional_id', $professional->id)
                        ->first();
                    
                    if ($professionalService) {
                        if ($professionalService->service && $professionalService->service->name) {
                            $serviceName = $professionalService->service->name;
                        } elseif ($professionalService->service_name) {
                            $serviceName = $professionalService->service_name;
                        }
                    }
                }
            }

            // Create a new booking record
            $booking = new Booking();
            $booking->user_id = Auth::guard('user')->user()->id;
            $booking->professional_id = $bookingData['professional_id'];
            $booking->plan_type = $bookingData['plan_type'];
            $booking->customer_phone = $request->phone;
            $booking->service_name = $serviceName ?? 'N/A';
            
            // Add sub-service data if available
            if ($request->has('sub_service_id') && $request->sub_service_id) {
                $booking->sub_service_id = $request->sub_service_id;
            }
            if ($request->has('sub_service_name') && $request->sub_service_name) {
                $booking->sub_service_name = $request->sub_service_name;
            }
            
            $booking->session_type = 'online';
            $booking->customer_name = Auth::guard('user')->user()->name;
            $booking->customer_email = Auth::guard('user')->user()->email;
            $booking->month = Carbon::parse($bookingData['bookings'][0]['date'])->format('M');
            $booking->booking_date = Carbon::parse($bookingData['bookings'][0]['date'])->format('Y-m-d');
            $booking->days = json_encode(array_map(function ($b) {
                return Carbon::parse($b['date'])->day;
            }, $bookingData['bookings']));
            $booking->time_slot = json_encode(array_column($bookingData['bookings'], 'time_slot'));
            $booking->save();

            // Insert into booking_timedates table with double-check
            foreach ($bookingData['bookings'] as $entry) {
                $date = Carbon::parse($entry['date'])->format('Y-m-d');
                $timeSlot = BookingTimedate::normalizeTimeSlot($entry['time_slot']);
                
                // Final check before inserting (in case of race conditions)
                if (BookingTimedate::isSlotBooked($professionalId, $date, $timeSlot)) {
                    DB::rollBack();
                    return response()->json([
                        'status' => 'error',
                        'message' => 'Time slot conflict detected. The slot ' . $date . ' at ' . $timeSlot . ' has been booked by another user. Please refresh and select different time slots.'
                    ], 422);
                }
                
                BookingTimedate::create([
                    'booking_id' => $booking->id,
                    'date' => $date,
                    'time_slot' => $timeSlot,
                    'status' => 'pending',
                ]);
            }

            // Commit the transaction
            DB::commit();

            // Associate any pending MCQ answers with this booking
            $serviceId = session('selected_service_id');
            if ($serviceId) {
                McqAnswer::where('user_id', Auth::guard('user')->id())
                    ->where('service_id', $serviceId)
                    ->whereNull('booking_id')
                    ->update(['booking_id' => $booking->id]);
            }

            return response()->json([
                'status' => 'success',
                'message' => 'Your booking has been successfully placed.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'There was an error processing your booking. Please try again later.',
                'data' => $e->getMessage()
            ], 500);
        }
    }




    public function success()
    {
        return view('customer.booking.success', ['showFooter' => false]);
    }

    public function booking()
    {
        $services = Service::latest()->get();
        
        // Always show the booking page - let the view handle missing data gracefully
        return view('customer.booking.booking', compact('services'));
    }

    public function getServiceQuestions($slug)
    {
        $service = Service::where('slug', $slug)->first();
        
        if (!$service) {
            return response()->json([
                'status' => 'error',
                'message' => 'Service not found'
            ], 404);
        }
        
        $questions = ServiceMCQ::where('service_id', $service->id)->get();

        return response()->json([
            'status' => 'success',
            'questions' => $questions
        ]);
    }
    public function setServiceSession(Request $request)
    {
        $request->validate([
            'service_id' => 'required|integer',
            'service_name' => 'required|string'
        ]);

        session([
            'selected_service_id' => $request->service_id,
            'selected_service_name' => $request->service_name
        ]);

        return response()->json(['status' => 'success', 'message' => 'Service saved in session']);
    }
    public function searchservice() {}

    /**
     * Search for services based on name
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function searchServices(Request $request)
    {
        $query = $request->input('query');

        if (!$query || strlen($query) < 1) {
            return response()->json([
                'services' => []
            ]);
        }

        $services = Service::where('name', 'LIKE', "%{$query}%")
            ->select('id', 'name', 'slug')
            ->limit(10)
            ->get();

        return response()->json([
            'services' => $services
        ]);
    }
}
