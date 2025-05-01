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
use App\Models\MCQ;

use Illuminate\Support\Facades\Auth;
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
        $mcqs = MCQ::latest()->get();
        return view('frontend.index', compact('services','banners','about_us','whychooses','testimonials','homeblogs','howworks','mcqs'));
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
        $services = ProfessionalService::where('professional_id', $id)->with('professional')->get();
        $rates = Rate::where('professional_id', $id)->with('professional')->get();

        // dd($profiles, $availabilities, $services, $rates);
        return view('frontend.sections.professional-details', compact('profile', 'availabilities', 'services', 'rates'));
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
            'booking_date' => 'required|date',
            'time_slot' => 'required|string',
        ]);
        session([
            'booking_data' => $request->only('professional_id', 'plan_type', 'booking_date', 'time_slot')
        ]);

        return response()->json([
            'status' => 'success'
        ]);
    }

    public function store(Request $request)
    {
        // Validate the incoming request data
        $validated = $request->validate([
            'professional_id' => 'required|exists:professionals,id',
            'plan_type' => 'required|string',
            'booking_date' => 'required|date_format:d/m/Y', // Assuming date comes in `d/m/Y` format from frontend
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
}
