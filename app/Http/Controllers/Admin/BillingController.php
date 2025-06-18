<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;
use Barryvdh\DomPDF\PDF as DomPDFPDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use PDF; // Add this for PDF generation

class BillingController extends Controller
{
    public function professionalBilling(Request $request)
    {
        // Get all unique service names for the dropdown
        $serviceOptions = Booking::select('service_name')
            ->distinct()
            ->whereNotNull('service_name')
            ->orderBy('service_name')
            ->pluck('service_name');

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
            // Add service filter
            ->when($request->filled('service'), fn($q) => $q->where('service_name', $request->service))
            ->latest()
            ->paginate(10);

        return view('admin.billing.professional-billing', compact('billings', 'serviceOptions'));
    }

    /**
     * Export professional billing data to PDF
     * 
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function exportBillingToPdf(Request $request)
    {
        // Build query with the same filters as the main view
        $query = Booking::with(['professional', 'user'])
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
            // Add service filter to PDF export
            ->when($request->filled('service'), fn($q) => $q->where('service_name', $request->service))
            ->latest();

        // Get all records without pagination for PDF
        $billings = $query->get();

        // Calculate summary statistics
        $totalAmount = 0;
        $totalCommission = 0;
        $totalProfessionalPay = 0;

        foreach ($billings as $billing) {
            $commissionRate = $billing->professional->margin ?? 0;
            $professionalPay = $billing->amount * ((100 - $commissionRate) / 100);
            $amountEarned = $billing->amount * ($commissionRate / 100);

            $totalAmount += $billing->amount;
            $totalCommission += $amountEarned;
            $totalProfessionalPay += $professionalPay;
        }

        // Add filter information to pass to the view
        $filterInfo = [
            'start_date' => $request->filled('start_date') ? Carbon::parse($request->start_date)->format('d M Y') : 'All time',
            'end_date' => $request->filled('end_date') ? Carbon::parse($request->end_date)->format('d M Y') : 'Present',
            'plan_type' => $request->filled('plan_type') ? ucfirst(str_replace('_', ' ', $request->plan_type)) : 'All plans',
            'payment_status' => $request->filled('payment_status') ? ucfirst($request->payment_status) : 'All statuses',
            'service' => $request->filled('service') ? $request->service : 'All services', // Add service to filter info
            'generated_at' => Carbon::now()->format('d M Y H:i:s'),
        ];

        // Generate PDF
        $pdf = FacadePdf::loadView('admin.billing.professional-billing-pdf', compact(
            'billings',
            'totalAmount',
            'totalCommission',
            'totalProfessionalPay',
            'filterInfo'
        ));

        // Set PDF options
        $pdf->setPaper('a4', 'landscape');

        // Generate filename with date
        $filename = 'professional_billing_' . Carbon::now()->format('Y_m_d_His') . '.pdf';

        // Return download response
        return $pdf->download($filename);
    }

    /**
     * Show customer billing records.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function customerBilling(Request $request)
    {
        // Get all unique service names for the dropdown
        $serviceOptions = \App\Models\Booking::select('service_name')
            ->distinct()
            ->whereNotNull('service_name')
            ->where('service_name', '!=', '')
            ->orderBy('service_name')
            ->pluck('service_name');

        $query = \App\Models\Booking::with(['professional', 'user']);

        // Search filter
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('customer_name', 'like', "%{$search}%")
                    ->orWhere('customer_email', 'like', "%{$search}%")
                    ->orWhere('customer_phone', 'like', "%{$search}%");
            });
        }

        // Date range filter
        if ($request->filled(['start_date', 'end_date'])) {
            $startDate = \Carbon\Carbon::parse($request->start_date)->startOfDay();
            $endDate = \Carbon\Carbon::parse($request->end_date)->endOfDay();
            $query->whereBetween('created_at', [$startDate, $endDate]);
        }

        // Plan type filter
        if ($request->filled('plan_type')) {
            $query->where('plan_type', $request->plan_type);
        }

        // SMS status filter
        if ($request->filled('sms_status')) {
            $query->where('sms_status', $request->sms_status);
        }

        // Service filter
        if ($request->filled('service')) {
            $query->where('service_name', $request->service);
        }

        // Get results with pagination
        $billings = $query->latest()->paginate(10);

        return view('admin.billing.customer-billing', compact('billings', 'serviceOptions'));
    }

    /**
     * Export customer billing records to PDF.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function exportCustomerBillingToPdf(Request $request)
    {
        // Build query with the same filters
        $query = \App\Models\Booking::with(['professional', 'user']);

        // Apply the same filters as above
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('customer_name', 'like', "%{$search}%")
                    ->orWhere('customer_email', 'like', "%{$search}%")
                    ->orWhere('customer_phone', 'like', "%{$search}%");
            });
        }

        if ($request->filled(['start_date', 'end_date'])) {
            $startDate = \Carbon\Carbon::parse($request->start_date)->startOfDay();
            $endDate = \Carbon\Carbon::parse($request->end_date)->endOfDay();
            $query->whereBetween('created_at', [$startDate, $endDate]);
        }

        if ($request->filled('plan_type')) {
            $query->where('plan_type', $request->plan_type);
        }

        if ($request->filled('sms_status')) {
            $query->where('sms_status', $request->sms_status);
        }

        // Service filter for PDF export
        if ($request->filled('service')) {
            $query->where('service_name', $request->service);
        }

        // Get all records without pagination for PDF
        $billings = $query->latest()->get();

        // Calculate totals
        $totalAmount = $billings->sum('amount');

        // Add filter information
        $filterInfo = [
            'start_date' => $request->filled('start_date') ? \Carbon\Carbon::parse($request->start_date)->format('d M Y') : 'All time',
            'end_date' => $request->filled('end_date') ? \Carbon\Carbon::parse($request->end_date)->format('d M Y') : 'Present',
            'plan_type' => $request->filled('plan_type') ? ucfirst(str_replace('_', ' ', $request->plan_type)) : 'All plans',
            'sms_status' => $request->filled('sms_status') ? ucfirst($request->sms_status) : 'All statuses',
            'service' => $request->filled('service') ? $request->service : 'All services',
            'generated_at' => \Carbon\Carbon::now()->format('d M Y H:i:s'),
            'total_amount' => $totalAmount
        ];

        // Generate PDF
        $pdf = FacadePdf::loadView('admin.billing.customer-billing-pdf', compact('billings', 'filterInfo'));

        // Set PDF options
        $pdf->setPaper('a4', 'landscape');

        // Generate filename with date
        $filename = 'customer_billing_' . \Carbon\Carbon::now()->format('Y_m_d_His') . '.pdf';

        // Return download response
        return $pdf->download($filename);
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
