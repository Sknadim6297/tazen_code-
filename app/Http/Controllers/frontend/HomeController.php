<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Models\Availability;
use App\Models\Booking;
use App\Models\McqAnswer;
use App\Models\Professional;
use App\Models\ProfessionalService;
use App\Models\Profile;
use App\Models\Rate;
use Carbon\Carbon;
use App\Models\Service;
use App\Models\Banner;
use App\Models\AboutUs;
use App\Models\Whychoose;
use App\Models\Testimonial;
use App\Models\HomeBlog;
use App\Models\Howworks;
use App\Models\ServiceMCQ;
use App\Models\Blog;
use App\Models\AllEvent;
use App\Models\BookingTimedate;
use App\Models\MCQ;
use App\Models\ProfessionalOtherInformation;
use App\Models\RequestedService;
use Carbon\CarbonPeriod;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\Models\BlogPost;
use App\Models\EventDetail;
use App\Models\Review;
use Illuminate\Http\Request;


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
        $eventDetails = EventDetail::with('event')->latest()->take(6)->get();
        return view('frontend.index', compact('services', 'banners', 'about_us', 'whychooses', 'testimonials', 'homeblogs', 'howworks', 'mcqs', 'blogPosts', 'eventDetails'));
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
        $services = Service::all();
        
        // Get selected service ID either from request or session
        $selectedServiceId = $request->input('service_id', Session::get('selected_service_id'));

        $professionalsQuery = Professional::with('profile', 'professionalServices')
            ->where('status', 'accepted');

        // Filter by service
        if ($selectedServiceId) {
            $professionalsQuery->whereHas('professionalServices', function ($query) use ($selectedServiceId) {
                $query->where('service_id', $selectedServiceId);
            });
        }

        // Filter by experience
        if ($request->has('experience') && !empty($request->experience)) {
            $expRange = $request->experience;
            
            if ($expRange == '10+') {
                $professionalsQuery->whereHas('profile', function ($query) {
                    $query->where('experience', '>=', 10);
                });
            } else {
                list($minExp, $maxExp) = explode('-', $expRange);
                $professionalsQuery->whereHas('profile', function ($query) use ($minExp, $maxExp) {
                    $query->whereBetween('experience', [$minExp, $maxExp]);
                });
            }
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
        if ($request->hasAny(['experience', 'price_range', 'service_id'])) {
            $professionals->appends($request->only(['experience', 'price_range', 'service_id']));
        }

        return view('frontend.sections.gridlisting', compact('professionals', 'services'));
    }



    public function professionalsDetails($id)
    {
        $requestedService = ProfessionalOtherInformation::where('professional_id', $id)->first();
        $profile = Profile::with(['professional.reviews' => function ($query) {
            $query->with(['user' => function ($q) {
                $q->with('customerProfile');
            }])->orderBy('created_at', 'desc');
        }])->where('professional_id', $id)->first();

        $availabilities = Availability::where('professional_id', $id)->with('slots')->get();
        $services = ProfessionalService::where('professional_id', $id)->with('professional')->first();
        $rates = Rate::where('professional_id', $id)->with('professional')->get();

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
            try {
                $monthNumber = Carbon::parse("1 " . $availability->month)->format('m');
            } catch (\Exception $e) {
                continue;
            }

            $year = Carbon::now()->year;
            $start = Carbon::createFromFormat('Y-m-d', "$year-$monthNumber-01");
            $end = $start->copy()->endOfMonth();
            $period = CarbonPeriod::create($start, $end);
            $decoded = json_decode($availability->weekdays);
            if (is_string($decoded)) {
                $decoded = json_decode($decoded);
            }

            $isoDays = array_map(fn($day) => $dayMap[strtolower($day)] ?? null, $decoded);
            $isoDays = array_filter($isoDays);

            foreach ($period as $date) {
                if (in_array($date->dayOfWeekIso, $isoDays)) {
                    $enabledDates[] = $date->toDateString();
                }
            }
        }

        // Fetch all existing bookings for this professional
        $existingBookings = [];

        // Get booking time dates from database
        $bookedTimeSlots = BookingTimedate::whereHas('booking', function ($query) use ($id) {
            $query->where('professional_id', $id)
                ->where('status', '!=', 'cancelled');
        })->get();

        // Format the booked time slots into a structured array
        foreach ($bookedTimeSlots as $slot) {
            $date = $slot->date;
            if (!isset($existingBookings[$date])) {
                $existingBookings[$date] = [];
            }
            $existingBookings[$date][] = $slot->time_slot;
        }

        return view('frontend.sections.professional-details', compact(
            'profile',
            'availabilities',
            'services',
            'rates',
            'enabledDates',
            'requestedService',
            'existingBookings'
        ), ['showFooter' => false]);
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

            foreach ($request->bookings as $date => $slots) {
                if (!empty($slots)) {
                    $bookingData[] = [
                        'date' => $date,
                        'time_slot' => $slots[0], // Take the first slot for each date
                    ];
                }
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

            // Create a new booking record
            $booking = new Booking();
            $booking->user_id = Auth::guard('user')->user()->id;
            $booking->professional_id = $bookingData['professional_id'];
            $booking->plan_type = $bookingData['plan_type'];
            $booking->customer_phone = $request->phone;
            $booking->service_name = session('selected_service_name');
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

            // Insert into booking_timedates table
            foreach ($bookingData['bookings'] as $entry) {
                BookingTimedate::create([
                    'booking_id' => $booking->id,
                    'date' => Carbon::parse($entry['date'])->format('Y-m-d'),
                    'time_slot' => $entry['time_slot'],
                    'status' => 'pending',
                ]);
            }

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

    public function getServiceQuestions($id)
    {
        $questions = ServiceMCQ::where('service_id', $id)->get();

        return response()->json([
            'status' => 'success',
            'questions' => $questions
        ]);
    }
    public function setServiceSession(Request $request)
    {
        $request->validate([
            'service_id' => 'required|integer'
        ]);

        session(['selected_service_id' => $request->service_id]);

        return response()->json(['status' => 'success', 'message' => 'Service ID saved in session']);
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

        if (!$query || strlen($query) < 2) {
            return response()->json([
                'services' => []
            ]);
        }

        $services = Service::where('name', 'LIKE', "%{$query}%")
            ->select('id', 'name')
            ->limit(10)
            ->get();

        return response()->json([
            'services' => $services
        ]);
    }
}
