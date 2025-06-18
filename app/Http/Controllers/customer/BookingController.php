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

        try {
            $eventId = $request->input('event_id');
            $eventName = $request->input('event_name', '');
            // Check if the event ID exists in all_events table
            $allEvent = \App\Models\AllEvent::find($eventId);

            // If not found by ID and we have a name, try to find by heading only
            // since 'name' column doesn't exist in all_events table
            if (!$allEvent && !empty($eventName)) {
                $allEvent = \App\Models\AllEvent::where('heading', 'LIKE', "%{$eventName}%")
                    ->first(); // Remove the query for 'name' column

                if ($allEvent) {
                    $eventId = $allEvent->id;
                }
            }

            // If still not found, check if it exists in the events table
            if (!$allEvent && $eventId) {
                $regularEvent = \App\Models\Event::find($eventId);

                if ($regularEvent) {
                    // Create a new entry in all_events table
                    $allEvent = new \App\Models\AllEvent();
                    $allEvent->heading = $regularEvent->name ?? $eventName ?? 'Event'; // Use heading instead of name
                    $allEvent->city = $regularEvent->city ?? $request->input('location') ?? 'Kolkata';
                    $allEvent->status = 'active';
                    $allEvent->save();
                    $eventId = $allEvent->id;
                }
            }

            // Store booking data in session with the correct event_id
            session([
                'event_booking_data' => [
                    'event_id' => $allEvent ? $allEvent->id : null,
                    'event_name' => $allEvent ? $allEvent->heading : $eventName, // Use heading since name doesn't exist
                    'location' => $request->input('location') ?? 'Kolkata',
                    'type' => $request->input('type') ?? 'offline',
                    'event_date' => $request->input('event_date'),
                    'price' => $request->input('amount'),
                    'total_price' => $request->input('total_price'),
                    'phone' => $request->input('phone'),
                    'persons' => $request->input('persons')
                ]
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Booking data saved successfully.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'An error occurred: ' . $e->getMessage()
            ], 500);
        }
    }



    public function bookingSummary()
    {
        $bookingData = session('event_booking_data');

        if (!$bookingData) {
            return redirect()->route('home')->with('error', 'No booking information found.');
        }

        // Try to find the event details
        $event = null;
        if (!empty($bookingData['event_id'])) {
            $event = \App\Models\AllEvent::find($bookingData['event_id']);
        }

        // Get the authenticated user
        $user = Auth::guard('user')->user();

        return view('customer.booking.summary', compact('bookingData', 'event', 'user'));
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

        try {
            // Verify the event exists in all_events table
            $eventId = $bookingData['event_id'] ?? null;
            $event = null;

            if ($eventId) {
                $event = \App\Models\AllEvent::find($eventId);

                // If not found and we have an event name, try to find by heading only
                if (!$event && !empty($bookingData['event_name'])) {
                    $event = \App\Models\AllEvent::where('heading', 'LIKE', "%{$bookingData['event_name']}%")
                        ->first();
                }
            }

            // Create booking record - with null event_id if necessary
            $booking = new \App\Models\EventBooking();
            $booking->user_id = $user->id;
            $booking->event_id = $event ? $event->id : null;
            $booking->event_name = $bookingData['event_name'] ?? '';
            $booking->event_date = $bookingData['event_date'] ?? now()->format('Y-m-d');
            $booking->location = $bookingData['location'] ?? '';
            $booking->type = $bookingData['type'] ?? '';
            $booking->persons = $bookingData['persons'] ?? 1;
            $booking->phone = $bookingData['phone'] ?? '';
            $booking->price = $bookingData['price'] ?? 0;
            $booking->total_price = $bookingData['total_price'] ?? 0;
            $booking->payment_status = 'success';
            $booking->order_id = $request->razorpay_order_id;
            $booking->razorpay_payment_id = $request->razorpay_payment_id;
            $booking->razorpay_signature = $request->razorpay_signature;
            $booking->save();
            // Clear session data
            session()->forget('event_booking_data');

            return response()->json(['status' => 'success']);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'An error occurred: ' . $e->getMessage()
            ], 500);
        }
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
        return view('customer.booking.success');
    }

    public function bookingSuccessPage()
    {
        return view('customer.booking.success');
    }

    public function resetBooking()
    {
        // Store previous URL before clearing session
        $previousUrl = url()->previous();

        // Extract service_id and professional_id from session if they exist
        $serviceId = session()->has('booking_data') ? session('booking_data.service_id') : null;
        $professionalId = session()->has('booking_data') ? session('booking_data.professional_id') : null;

        session()->forget('booking_data');

        session()->flash('success', 'Your booking has been reset. You can start fresh now.');

        // Check if the previous URL was a professional details page
        if (preg_match('/professionals\/details\/(\d+)/', $previousUrl, $matches)) {
            $professionalId = $matches[1];
            // Use the correct route name for professional details
            return redirect()->route('user.professionals.details', ['id' => $professionalId]);
        }

        // If we have a professional ID in the session, redirect to that professional's page
        if ($professionalId) {
            return redirect()->route('professionals.details', ['id' => $professionalId]);
        }
    }
}
