<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EventBooking;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;
use Illuminate\Http\Request;
use Carbon\Carbon;
use PDF;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $statusList = EventBooking::select('payment_status')->distinct()->pluck('payment_status');

        $query = EventBooking::with(['user', 'event']);

        if ($request->filled('search')) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%');
            })->orWhereHas('event', function ($q) use ($request) {
                $q->where('heading', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->filled('status')) {
            $query->where('payment_status', $request->status);
        }
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('event_date', [$request->start_date, $request->end_date]);
        }
        $bookings = $query->latest()->get();

        return view('admin.event.index', compact('bookings', 'statusList'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Export event bookings to PDF
     * 
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function exportEventBookingsToPdf(Request $request)
    {
        // Build query with filters
        $query = EventBooking::with(['user', 'event']);

        if ($request->filled('search')) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%');
            })->orWhereHas('event', function ($q) use ($request) {
                $q->where('heading', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->filled('status')) {
            $query->where('payment_status', $request->status);
        }
        
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('event_date', [$request->start_date, $request->end_date]);
        }
        
        // Get all records without pagination for PDF
        $bookings = $query->latest()->get();
        
        // Calculate summary statistics
        $totalBookings = $bookings->count();
        $totalAmount = $bookings->sum('amount');
        $statusCounts = $bookings->groupBy('payment_status')
            ->map(function($group) {
                return $group->count();
            });
        
        // Add filter information to pass to the view
        $filterInfo = [
            'start_date' => $request->filled('start_date') ? Carbon::parse($request->start_date)->format('d M Y') : 'All time',
            'end_date' => $request->filled('end_date') ? Carbon::parse($request->end_date)->format('d M Y') : 'Present',
            'status' => $request->filled('status') ? ucfirst($request->status) : 'All statuses',
            'search' => $request->filled('search') ? $request->search : 'None',
            'generated_at' => Carbon::now()->format('d M Y H:i:s'),
        ];
        
        // Generate PDF
        $pdf = FacadePdf::loadView('admin.event.event-bookings-pdf', compact(
            'bookings', 
            'totalBookings', 
            'totalAmount',
            'statusCounts',
            'filterInfo'
        ));
        
        // Set PDF options
        $pdf->setPaper('a4', 'landscape');
        
        // Generate filename with date
        $filename = 'event_bookings_' . Carbon::now()->format('Y_m_d_His') . '.pdf';
        
        // Return download response
        return $pdf->download($filename);
    }

    public function updateGmeetLink(Request $request, $id)
    {
        $request->validate([
            'gmeet_link' => 'nullable|string|max:255',
        ]);

        $booking = EventBooking::findOrFail($id);
        $booking->gmeet_link = $request->gmeet_link;
        $booking->save();

        return redirect()->back()->with('success', 'Google Meet link updated successfully.');
    }
}
