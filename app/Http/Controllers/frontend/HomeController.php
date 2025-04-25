<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Models\McqAnswer;
use App\Models\Profile;
use App\Models\Service;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;


class HomeController extends Controller
{
    public function index()
    {
        $services = Service::latest()->get();
        return view('frontend.index', compact('services'));
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
        $profiles = Profile::latest()->get();
        return view('frontend.sections.gridlisting', compact('profiles'));
    }
}
