<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;


class BookingController extends Controller
{
    public function oneTimeBooking(Request $request)
    {
        $query = Booking::where('plan_type', 'one-time');
        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('customer_name', 'like', '%' . $searchTerm . '%')
                    ->orWhere('service_name', 'like', '%' . $searchTerm . '%');
            })
                ->orWhereHas('professional', function ($q) use ($searchTerm) {
                    $q->where('name', 'like', '%' . $searchTerm . '%');
                });
        }
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('created_at', [$request->start_date, $request->end_date]);
        }

        // Fetch the bookings
        $bookings = $query->latest()->get();

        return view('admin.booking.onetime', compact('bookings'));
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

    public function quarterlyBooking(Request $request)
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
        return view('admin.booking.quarterly', compact('bookings'));
    }

    public function updateLink(Request $request, $id)
    {
        $request->validate([
            'meeting_link' => 'required|url'
        ]);

        $booking = Booking::findOrFail($id);
        $booking->meeting_link = $request->meeting_link;
        $booking->save();

        return redirect()->back()->with('success', 'Meeting link updated successfully!');
    }
}
