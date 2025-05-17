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
        $query = Booking::where('plan_type', 'free_hand')->with('professional', 'timedates');
        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('customer_name', 'like', '%' . $searchTerm . '%')
                    ->orWhere('service_name', 'like', '%' . $searchTerm . '%');
            });
        }
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('created_at', [$request->start_date, $request->end_date]);
        }
        $bookings = $query->latest()->get();
        return view('admin.booking.freehand', compact('bookings'));
    }

    public function monthlyBooking(Request $request)
    {
        $query = Booking::where('plan_type', 'monthly')->with('professional', 'timedates', 'customerProfile');
        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('customer_name', 'like', '%' . $searchTerm . '%')
                    ->orWhere('service_name', 'like', '%' . $searchTerm . '%');
            });
        }
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('created_at', [$request->start_date, $request->end_date]);
        }

        // Fetch the bookings
        $bookings = $query->latest()->get();
        return view('admin.booking.monthly', compact('bookings'));
    }

    public function quaterlyBooking(Request $request)
    {
        $query = Booking::where('plan_type', 'quarterly')->with('professional');
        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('customer_name', 'like', '%' . $searchTerm . '%')
                    ->orWhere('service_name', 'like', '%' . $searchTerm . '%');
            });
        }
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('created_at', [$request->start_date, $request->end_date]);
        }

        // Fetch the bookings
        $bookings = $query->latest()->get();
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

        return response()->json([
            'dates' => $booking->timedates->map(function ($td) {
                return [
                    'date' => $td->date,
                    'time_slot' => explode(',', $td->time_slot),
                    'status' => $td->status ?? 'Pending',
                ];
            })
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
}
