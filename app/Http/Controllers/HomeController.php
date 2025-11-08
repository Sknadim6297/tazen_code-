<?php

namespace App\Http\Controllers;

use App\Models\McqAnswer;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function submitQuestionnaire(Request $request)
    {
        if (!Auth::guard('user')->check()) {
            return response()->json([
                'success' => false,
                'message' => 'You have to login for book.',
                'redirect_to' => route('login')
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
} 
