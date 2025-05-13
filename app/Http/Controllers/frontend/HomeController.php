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
        $blogs = Blog::latest()->get();
        $mcqs = DB::table('service_m_c_q_s')->get();
        $serviceId = 1; // Change this based on which service you're targeting (dynamic or static)
        $mcqs = ServiceMCQ::where('service_id', $serviceId)->get();
        $allevents = AllEvent::latest()->get();
        return view('frontend.index', compact('services','banners','about_us','whychooses','testimonials','homeblogs','howworks','mcqs','blogs','allevents'));
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
                'message' => 'You have to login for book.'
            ], 403);
        }

        // Validation
        $request->validate([
            'q1' => 'required|string',
            'q2' => 'required|string',
            'q3' => 'required|string',
            'q4' => 'required|string',
            'q5' => 'nullable|string',
            'service_id' => 'required|integer|exists:services,id',
        ]);

        // Save answers
        $questionnaire = new McqAnswer();
        $questionnaire->user_id = Auth::guard('user')->id();
        $questionnaire->q1 = $request->input('q1');
        $questionnaire->q2 = $request->input('q2');
        $questionnaire->q3 = $request->input('q3');
        $questionnaire->q4 = $request->input('q4');
        $questionnaire->q5 = $request->input('q5', null);
        $questionnaire->save();

        // Save the selected service ID and service name in the session
        $selectedServiceId = $request->input('service_id');
        $service = Service::find($selectedServiceId);

        if ($service) {
            session([
                'selected_service_id' => $selectedServiceId,
                'selected_service_name' => $service->name,
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Redirecting to booking page',
            'logged_in' => true
        ]);
    }

    public function professionals()
    {
        $services = Service::all();
        $professionals = Professional::with('profile')->where('status', 'accepted')->latest()->get();
        return view('frontend.sections.gridlisting', compact('professionals', 'services'));
    }


    public function professionalsDetails($id)
    {
        $requestedService = ProfessionalOtherInformation::where('professional_id', $id)->first();
        $profile = Profile::with('professional')->where('professional_id', $id)->first();
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

        return view('frontend.sections.professional-details', compact(
            'profile',
            'availabilities',
            'services',
            'rates',
            'enabledDates',
            'requestedService'
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
        $request->validate([
            'professional_id' => 'required|exists:professionals,id',
            'plan_type' => 'required|string',
            'bookings' => 'required|array|min:1',
        ]);

        $bookingData = [];

        foreach ($request->bookings as $date => $slots) {
            foreach ($slots as $slot) {
                $bookingData[] = [
                    'date' => $date,
                    'time_slot' => $slot,
                ];
            }
        }

        session(['booking_data' => [
            'professional_id' => $request->professional_id,
            'plan_type' => $request->plan_type,
            'bookings' => $bookingData,
        ]]);

        return response()->json([
            'status' => 'success',
            'message' => 'Booking saved successfully!',
        ]);
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
}
