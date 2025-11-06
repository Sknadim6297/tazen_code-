<?php

namespace App\Http\Controllers\Professional;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Booking;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class BillingController extends Controller
{
    public function index(Request $request)
    {
        $professional = Auth::guard('professional')->user();
        $marginPercentage = $professional->margin;
        $query = Booking::with(['customer.customerProfile', 'professional.profile'])
            ->where('professional_id', Auth::guard('professional')->id());
        if ($request->filled('start_date')) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }
        
        if ($request->filled('end_date')) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }
        if ($request->filled('plan_type')) {
            $query->where('plan_type', $request->plan_type);
        }
        if ($request->filled('service')) {
            $query->where('service_name', $request->service);
        }
        if ($request->filled('payment_status')) {
            $query->where('paid_status', $request->payment_status);
        }
        $bookings = $query->select('id', 'customer_name', 'service_name', 'plan_type', 'month', 'amount', 'base_amount', 'cgst_amount', 'sgst_amount', 'igst_amount', 'transaction_number', 'paid_status', 'created_at')
            ->orderBy('created_at', 'desc')
            ->get();
        $services = Booking::where('professional_id', Auth::guard('professional')->id())
            ->select('service_name')
            ->distinct()
            ->whereNotNull('service_name')
            ->pluck('service_name');
        foreach ($bookings as $booking) {
            if (empty($booking->month)) {
                $booking->month = Carbon::parse($booking->created_at)->format('F Y');
            }
            $baseAmount = $booking->base_amount ?? ($booking->amount / 1.18);
            $customerGST = $booking->amount - $baseAmount; // Total GST paid by customer
            $platformFee = ($baseAmount * $marginPercentage) / 100;
            $platformFeeCGST = $platformFee * 0.09;
            $platformFeeSGST = $platformFee * 0.09;
            $totalPlatformCut = $platformFee + $platformFeeCGST + $platformFeeSGST;
            $booking->customer_amount = $booking->amount; // Total paid by customer
            $booking->base_amount_calc = $baseAmount;
            $booking->customer_gst = $customerGST;
            $booking->platform_fee = $platformFee;
            $booking->platform_cgst = $platformFeeCGST;
            $booking->platform_sgst = $platformFeeSGST;
            $booking->total_platform_cut = $totalPlatformCut;
            $booking->professional_earning = $booking->amount - $totalPlatformCut;
            $booking->margin_amount = $totalPlatformCut;
            $booking->net_amount = $booking->professional_earning;
        }
        $totalGrossAmount = $bookings->sum('amount');
        $totalMarginDeducted = $bookings->sum('margin_amount');
        $totalNetAmount = $bookings->sum('net_amount');

        return view('professional.billing.index', [
            'bookings' => $bookings,
            'services' => $services,
            'marginPercentage' => $marginPercentage,
            'totalGrossAmount' => $totalGrossAmount,
            'totalMarginDeducted' => $totalMarginDeducted,
            'totalNetAmount' => $totalNetAmount
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
    }

    public function downloadInvoice($id)
    {
        $booking = Booking::with(['professional.profile', 'customer.customerProfile'])->findOrFail($id);
        if ($booking->professional_id !== Auth::guard('professional')->id()) {
            abort(403, 'Unauthorized');
        }

        $professional = Auth::guard('professional')->user();
        $marginPercentage = $professional->margin;
        $baseAmount = $booking->base_amount ?? ($booking->amount / 1.18);
        $customerGST = $booking->amount - $baseAmount;
        $platformFee = ($baseAmount * $marginPercentage) / 100;
        $platformFeeCGST = $platformFee * 0.09;
        $platformFeeSGST = $platformFee * 0.09;
        $totalPlatformCut = $platformFee + $platformFeeCGST + $platformFeeSGST;
        $professionalEarning = $booking->amount - $totalPlatformCut;

        try {
            $pdf = Pdf::loadView('professional.billing.invoice', [
                'booking' => $booking,
                'invoice_no' => 'TZPRO-' . str_pad($booking->id, 6, '0', STR_PAD_LEFT),
                'invoice_date' => $booking->created_at->format('d M Y'),
                'marginPercentage' => $marginPercentage,
                'baseAmount' => $baseAmount,
                'customerAmount' => $booking->amount,
                'customerGST' => $customerGST,
                'platformFee' => $platformFee,
                'platformFeeCGST' => $platformFeeCGST,
                'platformFeeSGST' => $platformFeeSGST,
                'totalPlatformCut' => $totalPlatformCut,
                'professionalEarning' => $professionalEarning,
                'professional' => $professional,
            ]);

            return $pdf->download('professional_invoice_' . $booking->id . '.pdf');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to generate invoice: ' . $e->getMessage());
        }
    }
    
    /**
     * View customer invoice for professional
     */
    public function viewCustomerInvoice($id)
    {
        $booking = Booking::with(['professional.profile', 'customer.customerProfile', 'timedates'])
            ->where('professional_id', Auth::guard('professional')->id())
            ->findOrFail($id);
        $invoice_no = 'TZCUS-' . str_pad($booking->id, 6, '0', STR_PAD_LEFT);
        $invoice_date = $booking->created_at->format('d M Y');
        
        return view('customer.billing.invoice', compact(
            'booking',
            'invoice_no', 
            'invoice_date'
        ));
    }
    
    /**
     * Download customer invoice for professional
     */
    public function downloadCustomerInvoice($id)
    {
        $booking = Booking::with(['professional.profile', 'customer.customerProfile', 'timedates'])
            ->where('professional_id', Auth::guard('professional')->id())
            ->findOrFail($id);
        $invoice_no = 'TZCUS-' . str_pad($booking->id, 6, '0', STR_PAD_LEFT);
        $invoice_date = $booking->created_at->format('d M Y');
        
        $pdf = Pdf::loadView('customer.billing.invoice', compact(
            'booking',
            'invoice_no', 
            'invoice_date'
        ));
        $filename = 'customer_invoice_' . $booking->id . '_' . $booking->created_at->format('Y_m_d') . '.pdf';
        
        return $pdf->download($filename);
    }
}
