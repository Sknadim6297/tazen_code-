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
        
        // Start with base query
        $query = Booking::where('professional_id', Auth::guard('professional')->id());
        
        // Apply date filters
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }
        
        // Apply plan type filter
        if ($request->filled('plan_type')) {
            $query->where('plan_type', $request->plan_type);
        }
        
        // Apply payment status filter
        if ($request->filled('payment_status')) {
            $query->where('paid_status', $request->payment_status);
        }
        
        // Get bookings
        $bookings = $query->select('id', 'customer_name', 'plan_type', 'month', 'amount', 'transaction_number', 'paid_status', 'created_at')
            ->orderBy('created_at', 'desc')
            ->get();
            
        // Fill in month if not present and calculate margins
        foreach ($bookings as $booking) {
            // Set month if not present
            if (empty($booking->month)) {
                $booking->month = Carbon::parse($booking->created_at)->format('F Y');
            }
            
            // Calculate margin deductions
            $booking->margin_amount = ($booking->amount * $marginPercentage) / 100;
            $booking->net_amount = $booking->amount - $booking->margin_amount;
        }

        // Calculate totals
        $totalGrossAmount = $bookings->sum('amount');
        $totalMarginDeducted = $bookings->sum('margin_amount');
        $totalNetAmount = $bookings->sum('net_amount');

        return view('professional.billing.index', [
            'bookings' => $bookings,
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
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function downloadInvoice($id)
    {
        $booking = Booking::findOrFail($id);
        if ($booking->professional_id !== Auth::guard('professional')->id()) {
            abort(403, 'Unauthorized');
        }

        $professional = Auth::guard('professional')->user();
        $marginPercentage = $professional->margin;

        $marginAmount = ($booking->amount * $marginPercentage) / 100;
        $netAmount = $booking->amount - $marginAmount;

        try {
            $pdf = Pdf::loadView('professional.billing.invoice', [
                'booking' => $booking,
                'invoice_no' => 'INV-' . str_pad($booking->id, 6, '0', STR_PAD_LEFT),
                'invoice_date' => $booking->created_at->format('d M Y'),
                'marginPercentage' => $marginPercentage,
                'marginAmount' => $marginAmount,
                'netAmount' => $netAmount,
                'professional' => $professional,
            ]);

            return $pdf->download('invoice-' . $booking->id . '.pdf');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to generate invoice: ' . $e->getMessage());
        }
    }
}
