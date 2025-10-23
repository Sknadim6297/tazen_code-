<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MyBookingController extends Controller
{
    public function index()
    {
        $userId = Auth::guard('web')->id();
        
        $bookings = Booking::with(['professional', 'service', 'chat.messages'])
            ->where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        
        return view('customer.bookings.index', compact('bookings'));
    }
}
