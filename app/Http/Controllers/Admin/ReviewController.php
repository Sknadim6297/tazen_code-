<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReviewController extends Controller
{
    /**
     * Display a listing of all reviews with pagination and filtering.
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {

        $query = Review::with(['user', 'professional']);
        
        // Filter by rating if provided - Make sure this works with string comparison
        if ($request->filled('rating')) {
            $query->where('rating', '=', (int)$request->rating);
        }
        
        // Filter by professional name if provided
        if ($request->filled('professional')) {
            $professionalName = $request->professional;
            $query->whereHas('professional', function ($q) use ($professionalName) {
                $q->where(DB::raw('LOWER(name)'), 'like', '%' . strtolower($professionalName) . '%');
            });
        }
        
        // Filter by date range if provided
        if ($request->filled('start_date')) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }

        if ($request->filled('end_date')) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }

        // Order by created_at descending
        $query->orderBy('created_at', 'desc');
        
        // Get the raw SQL for debugging
        $sql = $query->toSql();
        $bindings = $query->getBindings();
        
        // Paginate the results
        $reviews = $query->paginate(10)->appends($request->all());
        
        return view('admin.reviews.index', compact('reviews'));
    }
    
    /**
     * Remove the specified review from storage.
     *
     * @param Review $review
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Review $review)
    {
        $review->delete();
        
        return redirect()->route('admin.reviews.index')
            ->with('success', 'Review deleted successfully.');
    }
}
