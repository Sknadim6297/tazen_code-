<?php

namespace App\Http\Controllers\Professional;

use App\Http\Controllers\Controller;
use App\Models\AdditionalService;
use App\Models\Booking;
use App\Models\Professional;
use App\Models\User;
use App\Models\Admin;
use App\Notifications\AdditionalServiceNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;

class AdditionalServiceController extends Controller
{
    /**
     * Display a listing of additional services for the professional
     */
    public function index()
    {
        $additionalServices = AdditionalService::with(['user', 'booking'])
            ->forProfessional(Auth::guard('professional')->id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('professional.additional-services.index', compact('additionalServices'));
    }

    /**
     * Show the form for creating a new additional service
     */
    public function create(Request $request)
    {
        $bookingId = $request->get('booking_id');
        $booking = null;
        
        if ($bookingId) {
            $booking = Booking::with('user')
                ->where('id', $bookingId)
                ->where('professional_id', Auth::guard('professional')->id())
                ->first();
            
            if (!$booking) {
                return redirect()->route('professional.additional-services.index')
                    ->with('error', 'Booking not found or you do not have permission to access it.');
            }
        }

        // Get all bookings for this professional for dropdown
        $bookings = Booking::with('user')
            ->where('professional_id', Auth::guard('professional')->id())
            ->where('status', '!=', 'cancelled')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('professional.additional-services.create', compact('booking', 'bookings'));
    }

    /**
     * Store a newly created additional service
     */
    public function store(Request $request)
    {
        $request->validate([
            'booking_id' => 'required|exists:bookings,id',
            'service_name' => 'required|string|max:255',
            'reason' => 'required|string',
            'base_price' => 'required|numeric|min:0',
        ]);

        // Verify booking belongs to this professional
        $booking = Booking::where('id', $request->booking_id)
            ->where('professional_id', Auth::guard('professional')->id())
            ->first();

        if (!$booking) {
            return response()->json([
                'success' => false,
                'message' => 'Booking not found or you do not have permission to access it.'
            ], 403);
        }

        try {
            DB::beginTransaction();

            $additionalService = new AdditionalService();
            $additionalService->professional_id = Auth::guard('professional')->id();
            $additionalService->user_id = $booking->user_id;
            $additionalService->booking_id = $request->booking_id;
            $additionalService->service_name = $request->service_name;
            $additionalService->reason = $request->reason;
            $additionalService->base_price = $request->base_price;
            
            // Calculate GST and total price
            $basePrice = $request->base_price;
            $cgst = $basePrice * 0.09; // 9% CGST
            $sgst = $basePrice * 0.09; // 9% SGST
            $totalPrice = $basePrice + $cgst + $sgst; // Base + 18% GST
            
            $additionalService->cgst = $cgst;
            $additionalService->sgst = $sgst;
            $additionalService->igst = 0.00; // Usually 0 for intrastate
            $additionalService->total_price = $totalPrice;
            
            $additionalService->save();

            // Send notifications to User and Admin
            $user = User::find($booking->user_id);
            $admins = Admin::all();

            if ($user) {
                $user->notify(new AdditionalServiceNotification(
                    $additionalService, 
                    'new_service'
                ));
            }

            foreach ($admins as $admin) {
                $admin->notify(new AdditionalServiceNotification(
                    $additionalService, 
                    'new_service'
                ));
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Additional service created successfully and notifications sent.',
                'redirect' => route('professional.additional-services.index')
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while creating the additional service: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Show details of a specific additional service
     */
    public function show($id)
    {
        $additionalService = AdditionalService::with(['user', 'booking'])
            ->where('id', $id)
            ->where('professional_id', Auth::guard('professional')->id())
            ->firstOrFail();

        return view('professional.additional-services.show', compact('additionalService'));
    }

    /**
     * Mark consultation as completed
     */
    public function markConsultationCompleted(Request $request, $id)
    {
        $additionalService = AdditionalService::where('id', $id)
            ->where('professional_id', Auth::guard('professional')->id())
            ->firstOrFail();

        if (!$additionalService->canBeCompletedByProfessional()) {
            return response()->json([
                'success' => false,
                'message' => 'Consultation cannot be marked as completed at this time.'
            ], 400);
        }

        try {
            DB::beginTransaction();

            $additionalService->update([
                'consulting_status' => 'done',
                'professional_completed_at' => now()
            ]);

            // Notify user
            $user = $additionalService->user;
            $user->notify(new AdditionalServiceNotification(
                $additionalService, 
                'consultation_completed'
            ));

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Consultation marked as completed. User has been notified.'
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
     * Set delivery date for the service
     */


    /**
     * Get bookings for AJAX dropdown
     */
    public function getBookings(Request $request)
    {
        $bookings = Booking::with('user')
            ->where('professional_id', Auth::guard('professional')->id())
            ->where('status', '!=', 'cancelled')
            ->when($request->search, function ($query, $search) {
                return $query->where(function ($q) use ($search) {
                    $q->where('customer_name', 'like', "%{$search}%")
                      ->orWhere('service_name', 'like', "%{$search}%")
                      ->orWhere('id', 'like', "%{$search}%");
                });
            })
            ->orderBy('created_at', 'desc')
            ->limit(20)
            ->get()
            ->map(function ($booking) {
                return [
                    'id' => $booking->id,
                    'text' => "#{$booking->id} - {$booking->customer_name} - {$booking->service_name}",
                    'customer_name' => $booking->customer_name,
                    'service_name' => $booking->service_name,
                    'booking_date' => $booking->booking_date,
                ];
            });

        return response()->json($bookings);
    }

    /**
     * Set delivery date for additional service
     */
    public function setDeliveryDate(Request $request, $id)
    {
        $request->validate([
            'delivery_date' => 'required|date|after:today',
            'delivery_reason' => 'required|string|max:1000',
        ]);

        $additionalService = AdditionalService::where('id', $id)
            ->where('professional_id', Auth::guard('professional')->id())
            ->firstOrFail();

        if (!$additionalService->canSetDeliveryDate()) {
            return response()->json([
                'success' => false,
                'message' => 'Delivery date cannot be set at this time.'
            ], 400);
        }

        try {
            DB::beginTransaction();

            $additionalService->update([
                'delivery_date' => $request->delivery_date,
                'delivery_date_reason' => $request->delivery_reason,
                'delivery_date_set_by_professional_at' => now(),
                'can_complete_consultation' => false, // Will be updated when date passes
            ]);

            // Notify admin and user
            $admins = Admin::all();
            $user = $additionalService->user;

            foreach ($admins as $admin) {
                $admin->notify(new AdditionalServiceNotification(
                    $additionalService, 
                    'delivery_date_set'
                ));
            }

            $user->notify(new AdditionalServiceNotification(
                $additionalService, 
                'delivery_date_set'
            ));

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Delivery date set successfully. Admin and customer have been notified.'
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
     * Update existing delivery date
     */
    public function updateDeliveryDate(Request $request, $id)
    {
        $request->validate([
            'delivery_date' => 'required|date|after:today',
            'delivery_notes' => 'required|string|max:1000',
        ]);

        $additionalService = AdditionalService::where('id', $id)
            ->where('professional_id', Auth::guard('professional')->id())
            ->firstOrFail();

        if (!$additionalService->delivery_date) {
            return response()->json([
                'success' => false,
                'message' => 'No delivery date has been set yet. Please set delivery date first.'
            ], 400);
        }

        try {
            DB::beginTransaction();

            $additionalService->update([
                'delivery_date' => $request->delivery_date,
                'delivery_date_reason' => $request->delivery_notes,
                'delivery_date_modified_by_admin_at' => null, // Reset admin modification
                'can_complete_consultation' => false, // Will be updated when date passes
            ]);

            // Notify admin and user
            $admins = Admin::all();
            $user = $additionalService->user;

            foreach ($admins as $admin) {
                $admin->notify(new AdditionalServiceNotification(
                    $additionalService, 
                    'delivery_date_changed'
                ));
            }

            $user->notify(new AdditionalServiceNotification(
                $additionalService, 
                'delivery_date_changed'
            ));

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Delivery date updated successfully. Admin and customer have been notified.'
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
     * Mark consultation as completed
     */
    public function completeConsultation($id)
    {
        $additionalService = AdditionalService::where('id', $id)
            ->where('professional_id', Auth::guard('professional')->id())
            ->firstOrFail();

        if (!$additionalService->canCompleteConsultation()) {
            return response()->json([
                'success' => false,
                'message' => 'Consultation cannot be completed yet. Please wait until the delivery date has passed.'
            ], 400);
        }

        if ($additionalService->consulting_status === 'done') {
            return response()->json([
                'success' => false,
                'message' => 'Consultation has already been marked as completed.'
            ], 400);
        }

        try {
            DB::beginTransaction();

            $additionalService->update([
                'consulting_status' => 'done',
                'professional_completed_at' => now(),
            ]);

            // Notify admin and user
            $admins = Admin::all();
            $user = $additionalService->user;

            foreach ($admins as $admin) {
                $admin->notify(new AdditionalServiceNotification(
                    $additionalService, 
                    'consultation_completed'
                ));
            }

            $user->notify(new AdditionalServiceNotification(
                $additionalService, 
                'consultation_completed'
            ));

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Consultation marked as completed. Customer will be notified to confirm.'
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
     * Respond to customer negotiation
     */
    public function respondToNegotiation(Request $request, $id)
    {
        $request->validate([
            'professional_final_price' => 'required|numeric|min:1',
            'professional_response' => 'required|string|max:1000',
            'min_price' => 'required|numeric|min:0'
        ]);

        $additionalService = AdditionalService::where('id', $id)
            ->where('professional_id', Auth::guard('professional')->id())
            ->firstOrFail();

        if ($additionalService->negotiation_status !== 'user_negotiated') {
            return response()->json([
                'success' => false,
                'message' => 'No active negotiation found for this service.'
            ], 400);
        }

        // Validate minimum price
        if ($request->professional_final_price < $request->min_price) {
            return response()->json([
                'success' => false,
                'message' => "Price cannot be below the allowed minimum"
            ], 422);
        }

        try {
            DB::beginTransaction();

            $additionalService->update([
                'admin_final_negotiated_price' => $request->professional_final_price,
                'admin_negotiation_response' => $request->professional_response,
                'negotiation_status' => 'admin_responded',
                'admin_reviewed_at' => now(),
                // Update the total price to reflect the negotiated amount
                'modified_total_price' => $request->professional_final_price,
                'price_modified_by_admin' => true,
                'price_modification_reason' => 'Professional responded to customer negotiation'
            ]);

            // Notify user
            $user = $additionalService->user;
            $message = "Professional has responded to your negotiation. Response: {$request->professional_response}";

            $user->notify(new AdditionalServiceNotification(
                $additionalService, 
                'negotiation_responded',
                $message
            ));

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Negotiation response sent successfully to customer.'
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
     * Update service price directly (professional initiated)
     */
    public function updatePrice(Request $request, $id)
    {
        $request->validate([
            'new_price' => 'required|numeric|min:1',
            'reason' => 'required|string|max:1000',
            'min_price' => 'required|numeric|min:0'
        ]);

        $additionalService = AdditionalService::where('id', $id)
            ->where('professional_id', Auth::guard('professional')->id())
            ->firstOrFail();

        // Validate minimum price
        if ($request->new_price < $request->min_price) {
            return response()->json([
                'success' => false,
                'message' => "Price cannot be below the allowed minimum"
            ], 422);
        }

        try {
            DB::beginTransaction();

            $additionalService->update([
                'modified_total_price' => $request->new_price,
                'price_modified_by_admin' => true,
                'price_modification_reason' => $request->reason,
                'admin_reviewed_at' => now()
            ]);

            // Notify user
            $user = $additionalService->user;
            $message = "Service price has been updated by professional. New price: ₹{$request->new_price}. Reason: {$request->reason}";

            $user->notify(new AdditionalServiceNotification(
                $additionalService, 
                'price_updated',
                $message
            ));

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Service price updated successfully.'
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
     * Generate invoice for a completed additional service
     */
    public function generateInvoice($id)
    {
        $service = AdditionalService::with(['user', 'professional', 'booking'])
            ->where('id', $id)
            ->where('professional_id', Auth::guard('professional')->id())
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

        return view('professional.additional-services.invoice', [
            'service' => $service,
            'customer' => $service->user,
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
        $service = AdditionalService::with(['user', 'professional', 'booking'])
            ->where('id', $id)
            ->where('professional_id', Auth::guard('professional')->id())
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

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('professional.additional-services.invoice-pdf', [
            'service' => $service,
            'customer' => $service->user,
            'professional' => $service->professional,
            'invoice_number' => $invoiceNumber,
            'invoice_date' => $invoiceDate,
            'pricing' => $pricing,
            'negotiation_details' => $negotiationDetails
        ]);

        return $pdf->download('invoice-' . $invoiceNumber . '.pdf');
    }
}