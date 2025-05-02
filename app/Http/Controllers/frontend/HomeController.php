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
use App\Models\MCQ;
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
        return view('frontend.index', compact('services','banners','about_us','whychooses','testimonials','homeblogs','howworks','mcqs','blogs'));
        $mcqs = MCQ::latest()->get();
        return view('frontend.index', compact('services', 'banners', 'about_us', 'whychooses', 'testimonials', 'homeblogs', 'howworks', 'mcqs'));
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
    // Fetch the MCQs specific to the selected service
    $mcqs = ServiceMCQ::where('service_id', $serviceId)->get();

    // Fetch other data related to the service, such as service details
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

        return response()->json([
            'success' => true,
            'message' => 'Submitted successfully',
            'logged_in' => true
        ]);
    }
    public function professionals()
    {
        $professionals = Professional::with('profile')->where('status', 'accepted')->latest()->get();
        return view('frontend.sections.gridlisting', compact('professionals'));
    }


    public function professionalsDetails($id)
    {
        $profile = Profile::with('professional')->where('professional_id', $id)->first();
        $availabilities = Availability::where('professional_id', $id)->with('slots')->get();
        $services = ProfessionalService::where('professional_id', $id)->with('professional')->first();
        $rates = Rate::where('professional_id', $id)->with('professional')->get();

        $enabledDates = [];

        // Map weekday string to ISO (1 = Monday, ..., 7 = Sunday)
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

            // Convert to ISO weekdays
            $isoDays = array_map(fn($day) => $dayMap[strtolower($day)] ?? null, $decoded);
            $isoDays = array_filter($isoDays);

            foreach ($period as $date) {
                if (in_array($date->dayOfWeekIso, $isoDays)) {
                    $enabledDates[] = $date->toDateString();
                }
            }
        }
        // dd($enabledDates);

        return view('frontend.sections.professional-details', compact('profile', 'availabilities', 'services', 'rates', 'enabledDates'));
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
            'booking_date' => 'required|string',
            'time_slot' => 'required|string',
        ]);

        $dates = explode(',', $request->booking_date);
        foreach ($dates as $date) {
            if (!strtotime(trim($date))) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Invalid booking date format.'
                ], 422);
            }
        }

        session([
            'booking_data' => $request->only('professional_id', 'plan_type', 'booking_date', 'time_slot')
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Booking saved successfully!'
        ]);
    }


    public function store(Request $request)
    {
        // Validate the incoming request data
        $validated = $request->validate([
            'professional_id' => 'required|exists:professionals,id',
            'plan_type' => 'required|string',
            'booking_date' => 'required|date_format:d/m/Y',
            'time_slot' => 'required|string',
            'name' => 'required|string',
            'email' => 'required|email',
            'phone' => 'required|string',
        ]);

        try {
            // Convert booking_date to MySQL date format (Y-m-d)
            $bookingDate = Carbon::createFromFormat('d/m/Y', $validated['booking_date'])->format('Y-m-d');

            // Create and save the booking data
            $booking = new Booking();
            $booking->user_id = Auth::guard('user')->id();
            $booking->professional_id = $validated['professional_id'];
            $booking->plan_type = $validated['plan_type'];
            $booking->booking_date = $bookingDate;
            $booking->time_slot = $validated['time_slot'];
            $booking->customer_name = $validated['name'];
            $booking->customer_email = $validated['email'];
            $booking->customer_phone = $validated['phone'];
            $booking->month = Carbon::parse($bookingDate)->format('M');
            $booking->days = Carbon::parse($bookingDate)->format('d');
            $booking->save();

            // Return a success response
            return response()->json([
                'status' => 'success',
                'message' => 'Your booking has been successfully placed.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'There was an error placing your booking. Please try again later.'
            ], 500);
        }
    }
    public function success()
    {
        return view('customer.booking.success');
    }

    public function getServiceQuestions($id)
    {
        return response()->json([
            'status' => 'success',
            'questions' => ServiceMCQ::where('service_id', $id)->take(5)->get()
        ]);
    }
    

}
