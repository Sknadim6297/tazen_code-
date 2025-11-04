<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OnboardingController extends Controller
{
    /**
     * Mark customer onboarding as completed
     */
    public function completeCustomerOnboarding(Request $request)
    {
        $user = Auth::user();
        
        $user->update([
            'customer_onboarding_completed_at' => now(),
            'onboarding_data' => array_merge(
                $user->onboarding_data ?? [],
                ['customer_completed' => true, 'customer_completed_at' => now()]
            )
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Onboarding completed successfully!'
        ]);
    }

    /**
     * Mark professional onboarding as completed
     */
    public function completeProfessionalOnboarding(Request $request)
    {
        $user = Auth::user();
        
        $user->update([
            'professional_onboarding_completed_at' => now(),
            'onboarding_data' => array_merge(
                $user->onboarding_data ?? [],
                ['professional_completed' => true, 'professional_completed_at' => now()]
            )
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Onboarding completed successfully!'
        ]);
    }

    /**
     * Reset onboarding for customer (for testing or replay)
     */
    public function resetCustomerOnboarding(Request $request)
    {
        $user = Auth::user();
        
        $user->update([
            'customer_onboarding_completed_at' => null,
            'onboarding_data' => array_merge(
                $user->onboarding_data ?? [],
                ['customer_completed' => false, 'customer_reset_at' => now()]
            )
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Customer onboarding reset successfully!'
        ]);
    }

    /**
     * Reset onboarding for professional (for testing or replay)
     */
    public function resetProfessionalOnboarding(Request $request)
    {
        $user = Auth::user();
        
        $user->update([
            'professional_onboarding_completed_at' => null,
            'onboarding_data' => array_merge(
                $user->onboarding_data ?? [],
                ['professional_completed' => false, 'professional_reset_at' => now()]
            )
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Professional onboarding reset successfully!'
        ]);
    }

    /**
     * Get onboarding status
     */
    public function getOnboardingStatus(Request $request)
    {
        $user = Auth::user();
        $type = $request->get('type', 'customer'); // customer or professional

        $isCompleted = $type === 'customer' 
            ? !is_null($user->customer_onboarding_completed_at)
            : !is_null($user->professional_onboarding_completed_at);

        return response()->json([
            'completed' => $isCompleted,
            'type' => $type,
            'user_id' => $user->id,
            'onboarding_data' => $user->onboarding_data ?? []
        ]);
    }
}
