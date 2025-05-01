<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;


class BookingController extends Controller
{
    public function oneTimeBooking()
    {
        $bookings = Booking::where('plan_type', 'one-time')->with('professional')->get();
        return view('admin.booking.onetime', compact('bookings'));
    }
    public function freeHandBooking()
    {
        $bookings = Booking::where('plan_type', 'free_hand')->with('professional')->get();
        return view('admin.booking.freehand', compact('bookings'));
    }
    public function monthlyBooking()
    {
        $bookings = Booking::where('plan_type', 'monthly')->with('professional')->get();
        return view('admin.booking.monthly', compact('bookings'));
    }
    public function quaterlyBooking()
    {
        $bookings = Booking::where('plan_type', 'quaterly')->with('professional')->get();
        return view('admin.booking.quaterly', compact('bookings'));
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
