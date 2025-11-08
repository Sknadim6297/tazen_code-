<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\ReRequestedService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Razorpay\Api\Api;

class ReRequestedServiceController extends Controller
{
    public function index(Request $request)
    {
        $customerId = Auth::id();
        
        $query = ReRequestedService::with(['professional', 'originalBooking'])
            ->where('customer_id', $customerId);

        // Apply filters
        $query->byStatus($request->status)
              ->byPaymentStatus($request->payment_status)
              ->byPriority($request->priority);

        // Search by service name or professional name
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('service_name', 'like', "%{$search}%")
                  ->orWhereHas('professional', function($subQ) use ($search) {
                      $subQ->where('name', 'like', "%{$search}%");
                  });
            });
        }

        // Apply date range filter
        if ($request->filled('date_from')) {
            $query->whereDate('requested_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('requested_at', '<=', $request->date_to);
        }

        $reRequestedServices = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('customer.re-requested-service.index', compact('reRequestedServices'));
    }

    public function show($id)
    {
        $reRequestedService = ReRequestedService::with(['professional', 'originalBooking'])
            ->where('customer_id', Auth::id())
            ->findOrFail($id);

        // Mark as viewed by customer
        if (!$reRequestedService->customer_viewed_at) {
            $reRequestedService->update(['customer_viewed_at' => now()]);
        }

        return view('customer.re-requested-service.show', compact('reRequestedService'));
    }

    public function createPayment($id)
    {
        $reRequestedService = ReRequestedService::where('customer_id', Auth::id())
            ->where('status', 'admin_approved')
            ->where('payment_status', 'unpaid')
            ->findOrFail($id);

        try {
            $api = new Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));
            
            $orderData = [
                'receipt' => 'rrs_' . $reRequestedService->id . '_' . time(),
                'amount' => $reRequestedService->total_amount * 100, // Amount in paise
                'currency' => 'INR',
                'notes' => [
                    'type' => 'Re-requested Service',
                    'service_id' => $reRequestedService->id,
                    'professional_id' => $reRequestedService->professional_id,
                    'customer_id' => $reRequestedService->customer_id
                ]
            ];

            $order = $api->order->create($orderData);
            
            // Store payment link
            $reRequestedService->update([
                'payment_id' => $order['id'],
                'payment_link' => route('user.customer.re-requested-service.payment', $reRequestedService->id)
            ]);

            return view('customer.re-requested-service.payment', compact('reRequestedService', 'order'));

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Unable to create payment. Please try again.');
        }
    }

    public function processPayment(Request $request, $id)
    {
        $reRequestedService = ReRequestedService::where('customer_id', Auth::id())
            ->where('status', 'admin_approved')
            ->where('payment_status', 'unpaid')
            ->findOrFail($id);

        try {
            $api = new Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));
            
            $attributes = [
                'razorpay_order_id' => $request->razorpay_order_id,
                'razorpay_payment_id' => $request->razorpay_payment_id,
                'razorpay_signature' => $request->razorpay_signature
            ];

            $api->utility->verifyPaymentSignature($attributes);

            // Payment successful
            $reRequestedService->update([
                'status' => 'customer_paid',
                'payment_status' => 'paid',
                'payment_completed_at' => now()
            ]);

            // Send email notifications to professional and admin
            // Add email notification logic here

            return redirect()->route('user.customer.re-requested-service.success', $reRequestedService->id);

        } catch (\Exception $e) {
            $reRequestedService->update([
                'payment_status' => 'failed'
            ]);

            return redirect()->route('user.customer.re-requested-service.index')
                ->with('error', 'Payment verification failed. Please try again.');
        }
    }

    public function paymentSuccess($id)
    {
        $reRequestedService = ReRequestedService::with(['professional'])
            ->where('customer_id', Auth::id())
            ->where('status', 'customer_paid')
            ->findOrFail($id);

        return view('customer.re-requested-service.success', compact('reRequestedService'));
    }

    public function doLater($id)
    {
        $reRequestedService = ReRequestedService::where('customer_id', Auth::id())
            ->where('status', 'admin_approved')
            ->findOrFail($id);

        $reRequestedService->update([
            'customer_notes' => 'Customer chose to pay later'
        ]);

        return redirect()->route('user.customer.re-requested-service.index')
            ->with('info', 'Payment marked for later. You can pay anytime from your dashboard.');
    }

    public function invoice($id)
    {
        $reRequestedService = ReRequestedService::with(['professional', 'customer'])
            ->where('customer_id', Auth::id())
            ->where('payment_status', 'paid')
            ->findOrFail($id);

        return view('customer.re-requested-service.invoice', compact('reRequestedService'));
    }
}
