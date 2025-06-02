<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Review;
use App\Models\Professional;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    /**
     * Store a newly created review in storage.
     */
    public function store(Request $request)
    {
        // Validate the request data
        $validated = $request->validate([
            'professional_id' => 'required|exists:professionals,id',
            'rating' => 'required|integer|min:1|max:5',
            'review_text' => 'required|string|max:1000',
        ]);

        // Check if user is logged in
        if (!Auth::guard('user')->check()) {
            return response()->json([
                'success' => false, 
                'message' => 'You must be logged in to leave a review'
            ], 401);
        }

        $user = Auth::guard('user')->user();
        
        // Check if the user has already reviewed this professional
        $existingReview = Review::where('user_id', $user->id)
            ->where('professional_id', $request->professional_id)
            ->first();
            
        if ($existingReview) {
            return response()->json([
                'success' => false,
                'message' => 'You have already reviewed this professional'
            ], 422);
        }

        // Create the review
        try {
            $review = Review::create([
                'user_id' => $user->id,
                'professional_id' => $request->professional_id,
                'rating' => $request->rating,
                'review_text' => $request->review_text,
            ]);
            
            return response()->json([
                'success' => true,
                'message' => 'Thank you! Your review has been submitted successfully.',
                'review' => $review
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while saving your review: ' . $e->getMessage()
            ], 500);
        }
    }
}
