<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\EventBooking;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Razorpay\Api\Api;

class BookingController extends Controller
{

    public function checkLogin(Request $request)
    {
        if (!Auth::guard('user')->check()) {
            return response()->json([
                'message' => 'Please login to continue.'
            ], 401);
        }

        session([
            'event_booking_data' => [
                'event_id' => $request->event_id,
                'location' => $request->location,
                'type' => $request->type,
                'event_date' => $request->event_date,
                'price' => $request->amount,
                'total_price' => $request->total_price,
                'phone' => $request->phone,
                'persons' => $request->persons
            ]
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Booking data saved successfully.'
        ]);
    }



    public function bookingSummary()
    {
        $services=Service::all();
        $bookingData = session('event_booking_data');

        if (!$bookingData) {
            return redirect()->back()->with('error', 'No booking data found.');
        }

        return view('customer.booking.summary', compact('bookingData', 'services'));
    }
    public function initPayment()
    {
        $booking = session('event_booking_data');
        $user = Auth::guard('user')->user();

        $api = new Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));
        $amount = ($booking['total_price'] ?? 500) * 100;

        $order = $api->order->create([
            'receipt' => uniqid(),
            'amount' => $amount,
            'currency' => 'INR',
        ]);

        return response()->json([
            'key' => env('RAZORPAY_KEY'),
            'order_id' => $order->id,
            'amount' => $amount,
        ]);
    }

    public function paymentSuccess(Request $request)
    {
        $request->validate([
            'razorpay_payment_id' => 'required|string',
            'razorpay_order_id' => 'required|string',
            'razorpay_signature' => 'required|string',
        ]);

        $user = Auth::guard('user')->user();
        $bookingData = session('event_booking_data');

        if (!$user || !$bookingData) {
            return response()->json(['status' => 'error', 'message' => 'Unauthorized or no booking data found'], 403);
        }
        $totalPrice = $bookingData['total_price'] ?? 0;

        $booking = new EventBooking();
        $booking->user_id = $user->id;
        $booking->event_id = $bookingData['event_id'];
        $booking->event_name = $bookingData['event_name'] ?? '';
        $booking->event_date = $bookingData['event_date'];
        $booking->location = $bookingData['location'] ?? null;
        $booking->type = $bookingData['type'] ?? null;
        $booking->persons = $bookingData['persons'] ?? null;
        $booking->phone = $bookingData['phone'] ?? null;
        $booking->price = $bookingData['price'] ?? null;
        $booking->total_price = $totalPrice;
        $booking->payment_status = 'success';
        $booking->order_id = $request->razorpay_order_id;
        $booking->razorpay_payment_id = $request->razorpay_payment_id;
        $booking->razorpay_signature = $request->razorpay_signature;
        $booking->save();


        session()->forget('event_booking_data');

        return response()->json(['status' => 'success']);
    }
    public function paymentFailed(Request $request)
    {
        $request->validate([
            'razorpay_payment_id' => 'nullable|string',
            'razorpay_order_id' => 'nullable|string',
            'error_code' => 'nullable|string',
            'error_description' => 'nullable|string',
            'error_source' => 'nullable|string',
            'error_step' => 'nullable|string',
            'error_reason' => 'nullable|string',
        ]);

        $user = Auth::guard('user')->user();
        $bookingData = session('event_booking_data');

        if (!$user || !$bookingData) {
            return response()->json(['status' => 'error', 'message' => 'Unauthorized or no booking data found'], 403);
        }

        $booking = new EventBooking();
        $booking->user_id = $user->id;
        $booking->event_id = $bookingData['event_id'];
        $booking->event_name = $bookingData['event_name'] ?? '';
        $booking->event_date = $bookingData['event_date'];
        $booking->location = $bookingData['location'] ?? null;
        $booking->type = $bookingData['type'] ?? null;
        $booking->persons = $bookingData['persons'] ?? null;
        $booking->phone = $bookingData['phone'] ?? null;
        $booking->price = $bookingData['price'] ?? null;
        $booking->total_price = $bookingData['total_price'] ?? 0;
        $booking->payment_status = 'failed';

        $booking->order_id = $request->razorpay_order_id ?? null;
        $booking->razorpay_payment_id = $request->razorpay_payment_id ?? null;
        $booking->payment_failure_reason = $request->error_description ?? 'Unknown error';

        $booking->save();

        session()->forget('event_booking_data');

        return response()->json(['status' => 'failed']);
    }

    public function successPage()
    {
        return view('customer.booking.event_success');
    }
}
