<?php

namespace App\Http\Controllers\Professional;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PDF;

class ProfessionalBillingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:professional');
    }

    public function downloadInvoice(Booking $booking)
    {
        // Ensure the professional can only access their own bookings
        if ($booking->professional_id !== Auth::guard('professional')->id()) {
            abort(403, 'Unauthorized action.');
        }

        $data = [
            'booking' => $booking,
            'invoice_no' => 'INV-' . str_pad($booking->id, 6, '0', STR_PAD_LEFT),
            'date' => $booking->created_at->format('d M, Y'),
            'professional_name' => Auth::guard('professional')->user()->name,
            'customer_name' => $booking->customer_name,
            'plan_type' => ucwords(str_replace('_', ' ', $booking->plan_type)),
            'amount' => $booking->amount,
            'platform_fee' => $booking->amount * 0.20, // 20% platform fee
            'professional_share' => $booking->amount * 0.80, // 80% professional share
        ];

        $pdf = FacadePdf::loadView('professional.billing.invoice', $data);
        
        return $pdf->download('invoice-' . $booking->id . '.pdf');
    }
} 