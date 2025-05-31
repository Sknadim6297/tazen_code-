<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\BookingTimedate;
use Illuminate\Http\Request;


class BookingController extends Controller
{
    public function oneTimeBooking(Request $request)
    {
        $query = Booking::with('professional', 'timedates')
            ->where('plan_type', 'one_time');

        // 🔍 Search by customer/service/professional name
        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('customer_name', 'like', '%' . $searchTerm . '%')
                    ->orWhere('service_name', 'like', '%' . $searchTerm . '%');
            })->orWhereHas('professional', function ($q) use ($searchTerm) {
                $q->where('name', 'like', '%' . $searchTerm . '%');
            });
        }

        // 📅 Filter by date range
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('created_at', [$request->start_date, $request->end_date]);
        }

        // ✅ Filter by status from BookingTimedate
        if ($request->filled('status')) {
            $query->whereHas('timedates', function ($q) use ($request) {
                $q->where('status', $request->status);
            });
        }

        $bookings = $query->latest()->get();

        $statuses = \App\Models\BookingTimedate::whereHas('booking', function ($q) {
            $q->where('plan_type', 'one_time');
        })->pluck('status')->unique()->filter()->values();

        return view('admin.booking.onetime', compact('bookings', 'statuses'));
    }


    public function freeHandBooking(Request $request)
    {
        $query = Booking::where('plan_type', 'free_hand')
            ->with(['professional', 'timedates', 'customerProfile']);
        
        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('customer_name', 'like', '%' . $searchTerm . '%')
                    ->orWhere('customer_phone', 'like', '%' . $searchTerm . '%')
                    ->orWhere('service_name', 'like', '%' . $searchTerm . '%');
            })->orWhereHas('professional', function ($q) use ($searchTerm) {
                $q->where('name', 'like', '%' . $searchTerm . '%');
            });
        }
        
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('created_at', [$request->start_date, $request->end_date]);
        }

        // Fetch the bookings
        $bookings = $query->latest()->get();

        $today = now()->startOfDay();

        foreach ($bookings as $booking) {
            // Calculate next booking date - only looking at future dates
            $nextSession = $booking->timedates()
                ->where('date', '>=', $today->format('Y-m-d'))
                ->orderBy('date', 'asc')
                ->first();
            
            // Get the most recent past session with a meeting link (for reference)
            $lastSessionWithLink = $booking->timedates()
                ->where('date', '<', $today->format('Y-m-d'))
                ->whereNotNull('meeting_link')
                ->orderBy('date', 'desc')
                ->first();
            
            // Set meeting link priority: 1) Next session link, 2) Most recent past session link
            $booking->next_booking = $nextSession;
            $booking->last_session_with_link = $lastSessionWithLink;
            
            // Calculate completed and pending sessions
            $completedSessions = 0;
            $pendingSessions = 0;
            
            if ($booking->timedates && $booking->timedates->count() > 0) {
                foreach ($booking->timedates as $td) {
                    $slots = explode(',', $td->time_slot);
                    if ($td->status === 'completed') {
                        $completedSessions += count($slots);
                    } else {
                        $pendingSessions += count($slots);
                    }
                }
            }
            
            $booking->completed_sessions = $completedSessions;
            $booking->pending_sessions = $pendingSessions;
        }

        return view('admin.booking.freehand', compact('bookings'));
    }

    public function monthlyBooking(Request $request)
    {
        $query = Booking::where('plan_type', 'monthly')->with(['professional', 'timedates', 'customerProfile']);

        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('customer_name', 'like', '%' . $searchTerm . '%')
                    ->orWhere('customer_phone', 'like', '%' . $searchTerm . '%')
                    ->orWhere('service_name', 'like', '%' . $searchTerm . '%');
            })->orWhereHas('professional', function ($q) use ($searchTerm) {
                $q->where('name', 'like', '%' . $searchTerm . '%');
            });
        }

        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('created_at', [$request->start_date, $request->end_date]);
        }

        // Fetch the bookings
        $bookings = $query->latest()->get();

        // Enhance bookings with next booking date and payment info
        foreach ($bookings as $booking) {
            // Calculate next booking date
            $nextBookingDate = $booking->timedates()
                ->where('date', '>', now()->format('Y-m-d'))
                ->where('status', '!=', 'completed')
                ->orderBy('date', 'asc')
                ->first();

            $booking->next_booking_date = $nextBookingDate ?
                \Carbon\Carbon::parse($nextBookingDate->date)->format('d M Y') :
                'No Upcoming Booking';

            // Format time slots for next booking
            if ($nextBookingDate) {
                $booking->next_booking_time = $nextBookingDate->time_slot;
                $booking->next_meeting_link = $nextBookingDate->meeting_link;
            }

            // Handle payment info - show amount if payment status is paid
            $booking->display_amount = $booking->payment_status === 'paid' ?
                number_format($booking->amount, 2) : 'Not Paid';

            // Get the latest meeting link from the most recent timedate with a link
            $latestTimedate = $booking->timedates()
                ->whereNotNull('meeting_link')
                ->orderBy('date', 'desc')
                ->first();

            $booking->latest_meeting_link = $latestTimedate ? $latestTimedate->meeting_link : null;
        }

        return view('admin.booking.monthly', compact('bookings'));
    }

    public function quaterlyBooking(Request $request)
    {
        $query = Booking::where('plan_type', 'quarterly')
            ->with(['professional', 'timedates', 'customerProfile']);

        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('customer_name', 'like', '%' . $searchTerm . '%')
                    ->orWhere('customer_phone', 'like', '%' . $searchTerm . '%')
                    ->orWhere('service_name', 'like', '%' . $searchTerm . '%');
            })->orWhereHas('professional', function ($q) use ($searchTerm) {
                $q->where('name', 'like', '%' . $searchTerm . '%');
            });
        }

        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('created_at', [$request->start_date, $request->end_date]);
        }

        // Fetch the bookings
        $bookings = $query->latest()->paginate(10);

        // Enhance bookings with next booking date and payment info
        foreach ($bookings as $booking) {
            // Calculate next booking date
            $nextBookingDate = $booking->timedates()
                ->where('date', '>', now()->format('Y-m-d'))
                ->where('status', '!=', 'completed')
                ->orderBy('date', 'asc')
                ->first();

            $booking->next_booking_date = $nextBookingDate ?
                \Carbon\Carbon::parse($nextBookingDate->date)->format('d M Y') :
                'No Upcoming Booking';

            // Format time slots for next booking
            if ($nextBookingDate) {
                $booking->next_booking_time = $nextBookingDate->time_slot;
                $booking->next_meeting_link = $nextBookingDate->meeting_link;
            }

            // Handle payment info - show amount if payment status is paid
            $booking->display_amount = $booking->payment_status === 'paid' ?
                number_format($booking->amount, 2) : 'Not Paid';

            // Get the latest meeting link from the most recent timedate with a link
            $latestTimedate = $booking->timedates()
                ->whereNotNull('meeting_link')
                ->orderBy('date', 'desc')
                ->first();

            $booking->latest_meeting_link = $latestTimedate ? $latestTimedate->meeting_link : null;
        }

        return view('admin.booking.quaterly', compact('bookings'));
    }

    public function addMeetingLink(Request $request)
    {
        $request->validate([
            'timedate_id' => 'required|exists:booking_timedates,id',
            'meeting_link' => 'required|url',
        ]);

        $timedate = BookingTimedate::find($request->timedate_id);
        $timedate->meeting_link = $request->meeting_link;
        $timedate->save();

        return back()->with('success', 'Meeting link added successfully.');
    }

    public function show($id)
    {
        $booking = Booking::with('timedates')->find($id);

        if (!$booking) {
            return response()->json(['error' => 'Booking not found'], 404);
        }

        $today = now()->startOfDay();

        return response()->json([
            'dates' => $booking->timedates->map(function ($td) use ($today) {
                $dateObj = \Carbon\Carbon::parse($td->date);
                $isExpired = $dateObj->lt($today);

                return [
                    'id' => $td->id,
                    'date' => $td->date,
                    'time_slot' => $td->time_slot,
                    'status' => $td->status ?? 'pending',
                    'remarks' => $td->remarks ?? '-',
                    'meeting_link' => $td->meeting_link ?? '',
                    'is_expired' => $isExpired,
                    'is_today' => $dateObj->isToday(),
                ];
            })->sortBy('date')->values()->all()
        ]);
    }
    public function addRemarks(Request $request, $id)
    {
        $request->validate([
            'remarks' => 'nullable|string|max:1000',
        ]);
        $booking = Booking::findOrFail($id);
        $booking->remarks = $request->remarks;
        $booking->save();
        return redirect()->back()->with('success', 'Remarks updated successfully!');
    }

    public function addProfessionalRemarks(Request $request, $id)
    {
        $request->validate([
            'remarks_for_professional' => 'nullable|string|max:1000',
        ]);

        $booking = Booking::findOrFail($id);
        $booking->remarks_for_professional = $request->remarks_for_professional;
        $booking->save();

        return back()->with('success', 'Remarks for professional updated successfully.');
    }
}
