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

        $professional = Auth::guard('professional')->user();
        $marginPercentage = $professional->margin ?? 20; // Default to 20% if not set
        $platformFee = ($booking->amount * $marginPercentage) / 100;
        $professionalShare = $booking->amount - $platformFee;

        $data = [
            'booking' => $booking,
            'invoice_no' => 'INV-' . str_pad($booking->id, 6, '0', STR_PAD_LEFT),
            'invoice_date' => $booking->created_at->format('d M Y'),
            'professional' => $professional,
            'professional_name' => $professional->name,
            'customer_name' => $booking->customer_name,
            'plan_type' => ucwords(str_replace('_', ' ', $booking->plan_type)),
            'amount' => $booking->amount,
            'marginPercentage' => $marginPercentage,
            'platformFee' => $platformFee,
            'professionalShare' => $professionalShare,
            // Keep old variable names for backward compatibility
            'date' => $booking->created_at->format('d M Y'),
            'platform_fee' => $platformFee,
            'professional_share' => $professionalShare,
        ];

        $pdf = FacadePdf::loadView('professional.billing.invoice', $data);
        
        return $pdf->download('invoice-' . $booking->id . '.pdf');
    }
} 