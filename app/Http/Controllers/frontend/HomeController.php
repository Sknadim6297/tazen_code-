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

    public function getServiceQuestions($id)
    {
        $questions = ServiceMCQ::where('service_id', $id)->get();
        
        return response()->json([
            'status' => 'success',
            'questions' => $questions
        ]);
    }

    public function getQuestion($previousAnswer = null)
{
    if ($previousAnswer) {
        $question = Question::where('slug', $previousAnswer->next)->first();
    } else {
        $question = Question::where('is_first', true)->first();
    }

    return response()->json($question->toArray());
}

    

}
