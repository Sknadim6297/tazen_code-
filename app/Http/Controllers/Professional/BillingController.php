<?php

namespace App\Http\Controllers\Professional;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Booking;
use Illuminate\Support\Facades\Auth;
use PDF;

class BillingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $bookings = Booking::where('professional_id', Auth::guard('professional')->id())
            ->select('id', 'customer_name', 'plan_type', 'month', 'amount')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('professional.billing.index', compact('bookings'));
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
        
        // Check if the booking belongs to the authenticated professional
        if ($booking->professional_id !== Auth::guard('professional')->id()) {
            abort(403, 'Unauthorized');
        }

        $pdf = PDF::loadView('professional.billing.invoice', [
            'booking' => $booking,
            'invoice_no' => 'INV-' . str_pad($booking->id, 6, '0', STR_PAD_LEFT),
            'invoice_date' => $booking->created_at->format('d M Y'),
        ]);

        return $pdf->download('invoice-' . $booking->id . '.pdf');
    }
}
