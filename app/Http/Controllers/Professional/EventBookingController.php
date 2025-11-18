<?php

namespace App\Http\Controllers\Professional;

use App\Http\Controllers\Controller;
use App\Models\EventBooking;
use App\Models\AllEvent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EventBookingController extends Controller
{
    /**
     * Display a listing of event bookings for the authenticated professional.
     */
    public function index(Request $request)
    {
        $professionalId = Auth::guard('professional')->id();

        // Get all events created by this professional
        $professionalEvents = AllEvent::where('created_by_type', 'professional')
            ->where('professional_id', $professionalId)
            ->pluck('id');

        // Get bookings for those events
        $query = EventBooking::with(['user', 'event'])
            ->whereIn('event_id', $professionalEvents);

        // Apply filters
        if ($request->filled('search_name')) {
            $search = $request->search_name;
            $query->where(function ($q) use ($search) {
                $q->where('event_name', 'like', "%{$search}%")
                  ->orWhereHas('user', function($userQuery) use ($search) {
                      $userQuery->where('name', 'like', "%{$search}%")
                               ->orWhere('email', 'like', "%{$search}%");
                  });
            });
        }

        if ($request->filled('search_date_from') && $request->filled('search_date_to')) {
            $query->whereBetween('event_date', [$request->search_date_from, $request->search_date_to]);
        } elseif ($request->filled('search_date_from')) {
            $query->where('event_date', '>=', $request->search_date_from);
        } elseif ($request->filled('search_date_to')) {
            $query->where('event_date', '<=', $request->search_date_to);
        }

        if ($request->filled('payment_status')) {
            $query->where('payment_status', $request->payment_status);
        }

        if ($request->filled('event_type')) {
            $query->where('type', $request->event_type);
        }

        $bookings = $query->latest('created_at')->paginate(15)->appends($request->all());

        // Get filter options for dropdowns
        $paymentStatuses = EventBooking::whereIn('event_id', $professionalEvents)
            ->distinct()
            ->pluck('payment_status')
            ->filter();

        $eventTypes = EventBooking::whereIn('event_id', $professionalEvents)
            ->distinct()
            ->pluck('type')
            ->filter();

        return view('professional.event-bookings.index', compact('bookings', 'paymentStatuses', 'eventTypes'));
    }

    /**
     * Display the specified event booking.
     */
    public function show($id)
    {
        $professionalId = Auth::guard('professional')->id();

        // Get all events created by this professional
        $professionalEvents = AllEvent::where('created_by_type', 'professional')
            ->where('professional_id', $professionalId)
            ->pluck('id');

        $booking = EventBooking::with(['user', 'event'])
            ->whereIn('event_id', $professionalEvents)
            ->findOrFail($id);

        return view('professional.event-bookings.show', compact('booking'));
    }

    /**
     * Update the booking status.
     */
    public function updateStatus(Request $request, $id)
    {
        $professionalId = Auth::guard('professional')->id();

        // Get all events created by this professional
        $professionalEvents = AllEvent::where('created_by_type', 'professional')
            ->where('professional_id', $professionalId)
            ->pluck('id');

        $booking = EventBooking::whereIn('event_id', $professionalEvents)
            ->findOrFail($id);

        // Validate both status and payment_status
        $request->validate([
            'status' => 'sometimes|in:pending,confirmed,cancelled,completed',
            'payment_status' => 'sometimes|in:pending,paid,failed,refunded'
        ]);

        $updateData = [];
        
        if ($request->has('status')) {
            $updateData['status'] = $request->status;
        }
        
        if ($request->has('payment_status')) {
            $updateData['payment_status'] = $request->payment_status;
        }

        $booking->update($updateData);

        $statusMessage = $request->has('status') ? 'Booking status' : 'Payment status';
        return redirect()->back()->with('success', $statusMessage . ' updated successfully.');
    }
}