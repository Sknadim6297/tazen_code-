<?php

namespace App\Http\Controllers\Professional;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    /**
     * Display a listing of reviews for the authenticated professional.
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $professionalId = Auth::guard('professional')->id();
        $query = Review::with('user')
            ->where('professional_id', $professionalId);
        if ($request->filled('rating')) {
            $query->where('rating', $request->rating);
        }
        if ($request->filled('start_date')) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }
        
        if ($request->filled('end_date')) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }
        $query->orderBy('created_at', 'desc');
        $reviews = $query->paginate(10)->appends($request->all());
        $averageRating = Review::where('professional_id', $professionalId)->avg('rating') ?? 0;
        $totalReviews = Review::where('professional_id', $professionalId)->count();
        $ratingCounts = [];
        for ($i = 5; $i >= 1; $i--) {
            $ratingCounts[$i] = Review::where('professional_id', $professionalId)
                ->where('rating', $i)
                ->count();
        }
        
        return view('professional.reviews.index', compact(
            'reviews',
            'averageRating',
            'totalReviews',
            'ratingCounts'
        ));
    }
}
