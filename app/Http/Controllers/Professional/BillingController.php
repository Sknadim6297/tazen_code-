<?php

namespace App\Http\Controllers\Professional;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Booking;
use Illuminate\Support\Facades\Auth;
use PDF;

class BillingController extends Controller
{
    public function index()
    {
        $professional = auth()->user(); 
        $marginPercentage = $professional->margin; 
        // Get bookings
        $bookings = Booking::where('professional_id', Auth::guard('professional')->id())
            ->select('id', 'customer_name', 'plan_type', 'month', 'amount')
            ->orderBy('created_at', 'desc')
            ->get();

        // Calculate margin deductions for each booking
        foreach ($bookings as $booking) {
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

        $pdf = PDF::loadView('professional.billing.invoice', [
            'booking' => $booking,
            'invoice_no' => 'INV-' . str_pad($booking->id, 6, '0', STR_PAD_LEFT),
            'invoice_date' => $booking->created_at->format('d M Y'),
            'marginPercentage' => $marginPercentage,
            'marginAmount' => $marginAmount,
            'netAmount' => $netAmount,
        ]);

        return $pdf->download('invoice-' . $booking->id . '.pdf');
    }
}
