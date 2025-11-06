<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\AdditionalService;
use App\Models\Professional;
use App\Models\Admin;
use App\Notifications\AdditionalServiceNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use Razorpay\Api\Api;

class AdditionalServiceController extends Controller
{
    /**
     * Display a listing of additional services for the user
     */
    public function index()
    {
        $additionalServices = AdditionalService::with(['professional', 'booking'])
            ->forUser(Auth::guard('user')->id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('customer.additional-services.index', compact('additionalServices'));
    }

    /**
     * Show details of a specific additional service
     */
    public function show($id)
    {
        $additionalService = AdditionalService::with(['professional', 'booking'])
            ->where('id', $id)
            ->where('user_id', Auth::guard('user')->id())
            ->firstOrFail();

        // Calculate minimum allowed price for negotiation using professional's service_request_offset
        $professional = $additionalService->professional;
        $maxNegotiationPercentage = $professional->service_request_offset ?? 10; // Default 10% if not set
        $basePriceForNegotiation = $additionalService->getEffectiveBasePrice();
        $minPrice = round($basePriceForNegotiation * (1 - ($maxNegotiationPercentage / 100)), 2);

        return view('customer.additional-services.show', compact('additionalService', 'minPrice'));
    }

    /**
     * Start negotiation for price reduction
     */
    public function negotiate(Request $request, $id)
    {
        $request->validate([
            'negotiated_price' => 'required|numeric|min:0',
            'negotiation_reason' => 'required|string|max:1000',
        ]);

        $additionalService = AdditionalService::where('id', $id)
            ->where('user_id', Auth::guard('user')->id())
            ->firstOrFail();

        if (!$additionalService->canBeNegotiated()) {
            return response()->json([
                'success' => false,
                'message' => 'This service cannot be negotiated at this time.'
            ], 400);
        }

        // Check negotiation margin from professional  
        $professional = $additionalService->professional;
        $maxNegotiationPercentage = $professional->service_request_offset ?? 10; // Default 10% if not set
        
        // Calculate minimum allowed price based on BASE PRICE (not total with GST)
        $basePriceForNegotiation = $additionalService->getEffectiveBasePrice(); // Uses base_price, modified_base_price, etc.
        $minAllowedPrice = round($basePriceForNegotiation * (1 - ($maxNegotiationPercentage / 100)), 2);

        if ($request->negotiated_price < $minAllowedPrice) {
            return response()->json([
                'success' => false,
                'message' => "Minimum allowed price is ₹" . number_format($minAllowedPrice, 2) . " (maximum " . $maxNegotiationPercentage . "% discount)",
                'min_allowed_price' => $minAllowedPrice
            ], 400);
        }

        try {
            DB::beginTransaction();

            // Update the negotiated base price and calculate GST automatically
            $additionalService->updatePricingWithGST($request->negotiated_price, 'user_negotiated');
            
            $additionalService->update([
                'user_negotiated_price' => $request->negotiated_price,
                'user_negotiation_reason' => $request->negotiation_reason,
                'negotiation_status' => 'user_negotiated',
                'user_responded_at' => now()
            ]);

            // Notify professional and admin
            $professional = $additionalService->professional;
            $admins = Admin::all();

            $professional->notify(new AdditionalServiceNotification(
                $additionalService, 
                'negotiation_started'
            ));

            foreach ($admins as $admin) {
                $admin->notify(new AdditionalServiceNotification(
                    $additionalService, 
                    'negotiation_started'
                ));
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Negotiation request submitted successfully. Professional has been notified.'
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            
            return response()->json([
                'success' => false,
                'message' => 'An error occurred: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Confirm consultation completion
     */
    public function confirmConsultation($id)
    {
        $additionalService = AdditionalService::where('id', $id)
            ->where('user_id', Auth::guard('user')->id())
            ->firstOrFail();

        if ($additionalService->consulting_status !== 'done' || $additionalService->customer_confirmed_at) {
            return response()->json([
                'success' => false,
                'message' => 'Consultation cannot be confirmed at this time.'
            ], 400);
        }

        try {
            DB::beginTransaction();

            $additionalService->update([
                'customer_confirmed_at' => now(),
                'user_completion_date' => now()
            ]);

            // Notify admin
            $admins = Admin::all();
            foreach ($admins as $admin) {
                $admin->notify(new AdditionalServiceNotification(
                    $additionalService, 
                    'consultation_confirmed'
                ));
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Consultation confirmed successfully. Admin has been notified.'
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            
            return response()->json([
                'success' => false,
                'message' => 'An error occurred: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Create Razorpay order for payment
     */
    public function createPaymentOrder($id)
    {
        $additionalService = AdditionalService::where('id', $id)
            ->where('user_id', Auth::guard('user')->id())
            ->firstOrFail();

        if ($additionalService->payment_status === 'paid') {
            return response()->json([
                'success' => false,
                'message' => 'This service has already been paid for.'
            ], 400);
        }

        try {
            $api = new Api(config('services.razorpay.key'), config('services.razorpay.secret'));
            
            $finalPrice = $additionalService->final_price;
            $amountInPaise = $finalPrice * 100; // Convert to paise
            
            $order = $api->order->create([
                'receipt' => 'add_service_' . $additionalService->id . '_' . time(),
                'amount' => $amountInPaise,
                'currency' => 'INR',
                'notes' => [
                    'additional_service_id' => $additionalService->id,
                    'user_id' => Auth::guard('user')->id(),
                    'service_name' => $additionalService->service_name,
                ]
            ]);

            return response()->json([
                'success' => true,
                'order_id' => $order['id'],
                'amount' => $amountInPaise,
                'currency' => 'INR',
                'key' => config('services.razorpay.key'),
                'service_name' => $additionalService->service_name,
                'professional_name' => $additionalService->professional->name,
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create payment order: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Handle payment success
     */
    public function handlePaymentSuccess(Request $request, $id)
    {
        $request->validate([
            'razorpay_payment_id' => 'required|string',
            'razorpay_order_id' => 'required|string',
            'razorpay_signature' => 'required|string',
        ]);

        $additionalService = AdditionalService::where('id', $id)
            ->where('user_id', Auth::guard('user')->id())
            ->firstOrFail();

        try {
            $api = new Api(config('services.razorpay.key'), config('services.razorpay.secret'));
            
            // Verify payment signature
            $attributes = [
                'razorpay_order_id' => $request->razorpay_order_id,
                'razorpay_payment_id' => $request->razorpay_payment_id,
                'razorpay_signature' => $request->razorpay_signature
            ];
            
            $api->utility->verifyPaymentSignature($attributes);

            DB::beginTransaction();

            // Update service with payment details
            $additionalService->update([
                'payment_status' => 'paid',
                'payment_id' => $request->razorpay_payment_id,
                'user_status' => 'paid',
            ]);

            // Calculate professional earnings (if not already calculated)
            if (!$additionalService->earnings_calculated_at) {
                $this->calculateProfessionalEarnings($additionalService);
            }

            // Notify professional and admin
            $professional = $additionalService->professional;
            $admins = Admin::all();

            $professional->notify(new AdditionalServiceNotification(
                $additionalService, 
                'payment_successful'
            ));

            foreach ($admins as $admin) {
                $admin->notify(new AdditionalServiceNotification(
                    $additionalService, 
                    'payment_successful'
                ));
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Payment successful! Professional and Admin have been notified.',
                'redirect' => route('user.additional-services.show', $id)
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            
            return response()->json([
                'success' => false,
                'message' => 'Payment verification failed: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Calculate professional earnings
     */
    private function calculateProfessionalEarnings(AdditionalService $additionalService)
    {
        // You can customize this based on your business logic
        $platformCommissionRate = 0.10; // 10% platform commission
        $finalPrice = $additionalService->final_price;
        
        $platformCommission = $finalPrice * $platformCommissionRate;
        $professionalAmount = $finalPrice - $platformCommission;
        
        $additionalService->update([
            'platform_commission' => $platformCommission,
            'professional_percentage_amount' => $professionalAmount,
            'professional_final_amount' => $professionalAmount,
            'earnings_calculated_at' => now()
        ]);
    }

    /**
     * Generate invoice for a completed additional service
     */
    public function generateInvoice($id)
    {
        $service = AdditionalService::with(['professional', 'booking'])
            ->where('id', $id)
            ->where('user_id', Auth::guard('user')->id())
            ->where('consulting_status', 'done')
            ->where('payment_status', 'paid')
            ->first();

        if (!$service) {
            return redirect()->back()->with('error', 'Service not found or not eligible for invoice generation.');
        }

        // Prepare invoice data
        $invoiceNumber = 'INV-AS-' . str_pad($service->id, 6, '0', STR_PAD_LEFT) . '-' . date('Y');
        $invoiceDate = now()->format('d M, Y');
        
        // Get pricing details
        $pricing = [
            'base_price' => $service->getEffectiveBasePrice(),
            'cgst' => $service->cgst ?? 0,
            'sgst' => $service->sgst ?? 0,
            'igst' => $service->igst ?? 0,
            'total_price' => $service->getEffectiveTotalPrice()
        ];

        // Negotiation details
        $negotiationDetails = null;
        if ($service->negotiation_status !== 'none') {
            $negotiationDetails = [
                'negotiation_status' => $service->negotiation_status,
                'original_price' => $service->base_price,
                'user_negotiated_price' => $service->user_negotiated_price,
                'admin_final_price' => $service->admin_final_negotiated_price
            ];
        }

        return view('customer.additional-services.invoice', [
            'service' => $service,
            'customer' => Auth::guard('user')->user(),
            'professional' => $service->professional,
            'invoice_number' => $invoiceNumber,
            'invoice_date' => $invoiceDate,
            'pricing' => $pricing,
            'negotiation_details' => $negotiationDetails
        ]);
    }

    /**
     * Generate PDF invoice for a completed additional service
     */
    public function generatePdfInvoice($id)
    {
        $service = AdditionalService::with(['professional', 'booking'])
            ->where('id', $id)
            ->where('user_id', Auth::guard('user')->id())
            ->where('consulting_status', 'done')
            ->where('payment_status', 'paid')
            ->first();

        if (!$service) {
            return redirect()->back()->with('error', 'Service not found or not eligible for invoice generation.');
        }

        // Prepare invoice data
        $invoiceNumber = 'INV-AS-' . str_pad($service->id, 6, '0', STR_PAD_LEFT) . '-' . date('Y');
        $invoiceDate = now()->format('d M, Y');
        
        // Get pricing details
        $pricing = [
            'base_price' => $service->getEffectiveBasePrice(),
            'cgst' => $service->cgst ?? 0,
            'sgst' => $service->sgst ?? 0,
            'igst' => $service->igst ?? 0,
            'total_price' => $service->getEffectiveTotalPrice()
        ];

        // Negotiation details
        $negotiationDetails = null;
        if ($service->negotiation_status !== 'none') {
            $negotiationDetails = [
                'negotiation_status' => $service->negotiation_status,
                'original_price' => $service->base_price,
                'user_negotiated_price' => $service->user_negotiated_price,
                'admin_final_price' => $service->admin_final_negotiated_price
            ];
        }

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('customer.additional-services.invoice-pdf', [
            'service' => $service,
            'customer' => Auth::guard('user')->user(),
            'professional' => $service->professional,
            'invoice_number' => $invoiceNumber,
            'invoice_date' => $invoiceDate,
            'pricing' => $pricing,
            'negotiation_details' => $negotiationDetails
        ]);

        return $pdf->download('invoice-' . $invoiceNumber . '.pdf');
    }
}