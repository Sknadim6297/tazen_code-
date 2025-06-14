<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use PDF;

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

        // Paginate the results
        $reviews = $query->paginate(10)->appends($request->all());

        return view('admin.reviews.index', compact('reviews'));
    }

    /**
     * Export reviews data to PDF
     * 
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function exportReviewsToPdf(Request $request)
    {
        // Build query with the same filters as the main view
        $query = Review::with(['user', 'professional']);

        // Apply filters from request
        if ($request->filled('rating')) {
            $query->where('rating', '=', (int)$request->rating);
        }

        if ($request->filled('professional')) {
            $professionalName = $request->professional;
            $query->whereHas('professional', function ($q) use ($professionalName) {
                $q->where(DB::raw('LOWER(name)'), 'like', '%' . strtolower($professionalName) . '%');
            });
        }

        if ($request->filled('start_date')) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }

        if ($request->filled('end_date')) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }

        $query->orderBy('created_at', 'desc');

        // Get all records without pagination for PDF
        $reviews = $query->get();

        // Calculate summary statistics
        $totalReviews = $reviews->count();
        $averageRating = $reviews->avg('rating');
        $ratingDistribution = [
            5 => $reviews->where('rating', 5)->count(),
            4 => $reviews->where('rating', 4)->count(),
            3 => $reviews->where('rating', 3)->count(),
            2 => $reviews->where('rating', 2)->count(),
            1 => $reviews->where('rating', 1)->count(),
        ];

        // Add filter information to pass to the view
        $filterInfo = [
            'start_date' => $request->filled('start_date') ? Carbon::parse($request->start_date)->format('d M Y') : 'All time',
            'end_date' => $request->filled('end_date') ? Carbon::parse($request->end_date)->format('d M Y') : 'Present',
            'rating' => $request->filled('rating') ? $request->rating . ' Star' . ($request->rating > 1 ? 's' : '') : 'All ratings',
            'professional' => $request->filled('professional') ? $request->professional : 'All professionals',
            'generated_at' => Carbon::now()->format('d M Y H:i:s'),
        ];

        // Generate PDF
        $pdf = FacadePdf::loadView('admin.reviews.reviews-pdf', compact(
            'reviews',
            'totalReviews',
            'averageRating',
            'ratingDistribution',
            'filterInfo'
        ));

        // Set PDF options
        $pdf->setPaper('a4', 'landscape');

        // Generate filename with date
        $filename = 'reviews_report_' . Carbon::now()->format('Y_m_d_His') . '.pdf';

        // Return download response
        return $pdf->download($filename);
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
