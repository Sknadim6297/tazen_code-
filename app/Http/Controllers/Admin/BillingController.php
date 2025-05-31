<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class BillingController extends Controller
{
    public function professionalBilling(Request $request)
    {
        $billings = Booking::with(['professional', 'user'])
            ->when($request->filled('search'), function ($query) use ($request) {
                $query->where(function ($q) use ($request) {
                    $q->where('customer_name', 'like', "%{$request->search}%")
                        ->orWhere('customer_email', 'like', "%{$request->search}%")
                        ->orWhere('customer_phone', 'like', "%{$request->search}%")
                        ->orWhereHas('professional', function ($q) use ($request) {
                            $q->where('name', 'like', "%{$request->search}%");
                        });
                });
            })
            ->when($request->filled(['start_date', 'end_date']), function ($query) use ($request) {
                $query->whereBetween('created_at', [
                    Carbon::parse($request->start_date)->startOfDay(),
                    Carbon::parse($request->end_date)->endOfDay()
                ]);
            })
            ->when($request->filled('plan_type'), fn($q) => $q->where('plan_type', $request->plan_type))
            ->when($request->filled('payment_status'), fn($q) => $q->where('payment_status', $request->payment_status))
            ->latest()
            ->paginate(10);

        return view('admin.billing.professional-billing', compact('billings'));
    }

    public function savePayment(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'billing_id' => 'required|exists:bookings,id',
            'transaction_number' => 'required|string|max:255',
            'paid_date' => 'required|date',
            'status' => 'required|in:paid,unpaid',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            DB::beginTransaction();

            $booking = Booking::findOrFail($request->billing_id);
            $isPaid = $request->status === 'paid';

            $booking->transaction_number = $isPaid ? $request->transaction_number : null;
            $booking->paid_date = $isPaid ? $request->paid_date : null;
            $booking->paid_status = $request->status;
            $booking->payment_status = $isPaid ? 'paid' : 'pending';
            $booking->save();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Payment ' . ($isPaid ? 'marked as paid' : 'marked as unpaid'),
                'booking' => $booking
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update payment status via AJAX toggle
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updatePaymentStatus(Request $request)
    {
        // Validate the request
        $validator = Validator::make($request->all(), [
            'billing_id' => 'required|exists:bookings,id',
            'status' => 'required|in:paid,unpaid',
        ]);
        
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }
        if ($request->status === 'paid') {
            return response()->json([
                'success' => false,
                'message' => 'Payment status cannot be changed to paid via toggle. Please use the payment form.'
            ], 422);
        }
        
        try {
            DB::beginTransaction();
            $booking = Booking::findOrFail($request->billing_id);

            $booking->paid_status = 'unpaid';
            $booking->payment_status = 'pending';
            $booking->transaction_number = null;
            $booking->paid_date = null;
            $booking->save();
            
            DB::commit();
            
            return response()->json([
                'success' => true,
                'message' => 'Payment status updated successfully',
                'booking' => [
                    'id' => $booking->id,
                    'paid_status' => $booking->paid_status,
                    'payment_status' => $booking->payment_status,
                    'transaction_number' => null,
                    'paid_date' => null
                ]
            ]);
            
        } catch (\Exception $e) {
            DB::rollBack();
            
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }
}
