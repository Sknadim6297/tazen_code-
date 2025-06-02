<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Booking;
use Razorpay\Api\Api;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Models\McqAnswer;
use App\Models\BookingTimedate;
use Barryvdh\DomPDF\Facade\Pdf;

class CustomerBookingController extends Controller
{
    public function initiatePayment(Request $request)
    {
        try {
            $request->validate([
                'phone' => 'required|string|min:10|max:10',
            ]);

            $bookingData = session('booking_data');
            if (!$bookingData) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'No booking data found'
                ], 400);
            }

            $amount = $bookingData['total_amount'] * 100;
            $api = new Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));

            $order = $api->order->create([
                'amount' => $amount,
                'currency' => 'INR',
                'payment_capture' => 1
            ]);

            // Store order details in session
            session(['razorpay_order_id' => $order->id]);
            session(['customer_phone' => $request->phone]);

            return response()->json([
                'status' => 'success',
                'order_id' => $order->id,
                'amount' => $amount,
                'key' => env('RAZORPAY_KEY'),
                'name' => Auth::guard('user')->user()->name,
                'email' => Auth::guard('user')->user()->email,
                'phone' => $request->phone
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function verifyPayment(Request $request)
    {
        try {
            $api = new Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));
            $attributes = [
                'razorpay_order_id' => $request->razorpay_order_id,
                'razorpay_payment_id' => $request->razorpay_payment_id,
                'razorpay_signature' => $request->razorpay_signature
            ];

            $api->utility->verifyPaymentSignature($attributes);

            // Get booking data from session
            $bookingData = session('booking_data');
            $phone = session('customer_phone');

            // Get professional details
            $professional = \App\Models\Professional::with('profile')->find($bookingData['professional_id']);
            if (!$professional) {
                throw new \Exception('Professional not found');
            }
            $booking = new Booking();
            $booking->user_id = Auth::guard('user')->id();
            $booking->professional_id = $bookingData['professional_id'];
            $booking->plan_type = $bookingData['plan_type'];
            $booking->customer_phone = $phone;
            $booking->service_name = session('selected_service_name');
            $booking->session_type = 'online';
            $booking->customer_name = Auth::guard('user')->user()->name;
            $booking->customer_email = Auth::guard('user')->user()->email;
            $booking->amount = $bookingData['total_amount'];
            $booking->payment_id = $request->razorpay_payment_id;
            $booking->payment_status = 'paid';

            $firstBookingDate = Carbon::parse($bookingData['bookings'][0]['date']);
            $booking->month = $firstBookingDate->format('M');
            $booking->booking_date = $firstBookingDate->format('Y-m-d');
            $booking->days = json_encode(array_map(function ($b) {
                return Carbon::parse($b['date'])->day;
            }, $bookingData['bookings']));
            $booking->time_slot = json_encode(array_column($bookingData['bookings'], 'time_slot'));
            $booking->save();

            // Create booking time dates
            foreach ($bookingData['bookings'] as $entry) {
                BookingTimedate::create([
                    'booking_id' => $booking->id,
                    'date' => Carbon::parse($entry['date'])->format('Y-m-d'),
                    'time_slot' => $entry['time_slot'],
                    'status' => 'pending'
                ]);
            }

            // Link MCQ answers if any
            $serviceId = session('selected_service_id');
            if ($serviceId) {
                McqAnswer::where('user_id', Auth::guard('user')->id())
                    ->where('service_id', $serviceId)
                    ->whereNull('booking_id')
                    ->update(['booking_id' => $booking->id]);
            }
            session([
                'booking_success' => [
                    'professional_name' => $professional->name,
                    'professional_address' => $professional->profile->address ?? 'Address not available',
                    'service_name' => session('selected_service_name'),
                    'plan_type' => $bookingData['plan_type'],
                    'amount' => $bookingData['total_amount'],
                    'bookings' => $bookingData['bookings']
                ]
            ]);

            // Clear booking session data
            session()->forget(['booking_data', 'razorpay_order_id', 'customer_phone']);

            return response()->json([
                'status' => 'success',
                'message' => 'Payment successful and booking confirmed',
                'redirect_url' => route('user.booking.success')
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Payment verification failed: ' . $e->getMessage()
            ], 500);
        }
    }

    public function success()
    {
        if (!session()->has('booking_success')) {
            return redirect()->route('professionals')->with('error', 'No booking information found');
        }

        return view('customer.booking.success');
    }

    public function billing()
    {
        $bookings = Booking::where('user_id', Auth::guard('user')->id())
            ->with('professional')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('customer.billing.index', compact('bookings'));
    }

    public function downloadInvoice($id)
    {
        $booking = Booking::with('professional')->findOrFail($id);

        if ($booking->user_id !== Auth::guard('user')->id()) {
            abort(403, 'Unauthorized');
        }

        $pdf = PDF::loadView('customer.billing.invoice', [
            'booking' => $booking,
            'invoice_no' => 'INV-' . str_pad($booking->id, 6, '0', STR_PAD_LEFT),
            'invoice_date' => $booking->created_at->format('d M Y'),
        ]);

        return $pdf->download('invoice-' . $booking->id . '.pdf');
    }
    public function eventSuccess()
    {
        return view('customer.booking.event_success');
    }
}
