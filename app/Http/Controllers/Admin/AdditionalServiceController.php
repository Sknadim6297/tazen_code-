<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdditionalService;
use App\Models\Professional;
use App\Models\User;
use App\Notifications\AdditionalServiceNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AdditionalServiceController extends Controller
{
    /**
     * Display a listing of all additional services
     */
    public function index(Request $request)
    {
        $query = AdditionalService::with(['professional', 'user', 'booking']);

        // Apply filters
        if ($request->filled('status')) {
            switch ($request->status) {
                case 'pending':
                    $query->where('admin_status', 'pending');
                    break;
                case 'approved':
                    $query->where('admin_status', 'approved');
                    break;
                case 'rejected':
                    $query->where('admin_status', 'rejected');
                    break;
                case 'paid':
                    $query->where('payment_status', 'paid');
                    break;
                case 'negotiation':
                    $query->where('negotiation_status', '!=', 'none');
                    break;
            }
        }

        if ($request->filled('professional')) {
            $query->where('professional_id', $request->professional);
        }

        if ($request->filled('user')) {
            $query->where('user_id', $request->user);
        }

        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $additionalServices = $query->orderBy('created_at', 'desc')->paginate(15);

        // Get filter options
        $professionals = Professional::select('id', 'name')->orderBy('name')->get();
        $users = User::select('id', 'name')->orderBy('name')->get();

        return view('admin.additional-services.index', compact(
            'additionalServices', 
            'professionals', 
            'users'
        ));
    }

    /**
     * Show details of a specific additional service
     */
    public function show($id)
    {
        $additionalService = AdditionalService::with(['professional', 'user', 'booking'])
            ->findOrFail($id);

        return view('admin.additional-services.show', compact('additionalService'));
    }

    /**
     * Approve additional service
     */
    public function approve(Request $request, $id)
    {
        $additionalService = AdditionalService::findOrFail($id);

        if ($additionalService->admin_status === 'approved') {
            return response()->json([
                'success' => false,
                'message' => 'Service is already approved.'
            ], 400);
        }

        try {
            DB::beginTransaction();

            $additionalService->update([
                'admin_status' => 'approved',
                'admin_reviewed_at' => now(),
                'admin_reason' => $request->reason
            ]);

            // Notify user and professional
            $user = $additionalService->user;
            $professional = $additionalService->professional;

            $user->notify(new AdditionalServiceNotification(
                $additionalService, 
                'service_approved'
            ));

            $professional->notify(new AdditionalServiceNotification(
                $additionalService, 
                'service_approved'
            ));

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Additional service approved successfully.'
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
     * Reject additional service
     */
    public function reject(Request $request, $id)
    {
        $request->validate([
            'reason' => 'required|string|max:1000'
        ]);

        $additionalService = AdditionalService::findOrFail($id);

        if ($additionalService->admin_status === 'rejected') {
            return response()->json([
                'success' => false,
                'message' => 'Service is already rejected.'
            ], 400);
        }

        try {
            DB::beginTransaction();

            $additionalService->update([
                'admin_status' => 'rejected',
                'admin_reviewed_at' => now(),
                'admin_reason' => $request->reason
            ]);

            // Notify user and professional
            $user = $additionalService->user;
            $professional = $additionalService->professional;

            $message = "Reason: " . $request->reason;

            $user->notify(new AdditionalServiceNotification(
                $additionalService, 
                'service_rejected',
                $message
            ));

            $professional->notify(new AdditionalServiceNotification(
                $additionalService, 
                'service_rejected',
                $message
            ));

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Additional service rejected successfully.'
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
     * Modify price of additional service
     */
    public function modifyPrice(Request $request, $id)
    {
        $request->validate([
            'modified_base_price' => 'required|numeric|min:0',
            'modification_reason' => 'required|string|max:1000'
        ]);

        $additionalService = AdditionalService::findOrFail($id);

        try {
            DB::beginTransaction();

            // Calculate new GST and total
            $basePrice = $request->modified_base_price;
            $cgst = round($basePrice * 0.09, 2);
            $sgst = round($basePrice * 0.09, 2);
            $modifiedTotal = round($basePrice + $cgst + $sgst, 2);

            $additionalService->update([
                'modified_base_price' => $basePrice,
                'modified_total_price' => $modifiedTotal,
                'price_modified_by_admin' => true,
                'price_modification_reason' => $request->modification_reason,
                'admin_reviewed_at' => now()
            ]);

            // Notify user and professional
            $user = $additionalService->user;
            $professional = $additionalService->professional;

            $message = "Price modified from ₹{$additionalService->total_price} to ₹{$modifiedTotal}. Reason: {$request->modification_reason}";

            $user->notify(new AdditionalServiceNotification(
                $additionalService, 
                'price_modified',
                $message
            ));

            $professional->notify(new AdditionalServiceNotification(
                $additionalService, 
                'price_modified',
                $message
            ));

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Price modified successfully and notifications sent.'
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
     * Respond to negotiation
     */
    public function respondToNegotiation(Request $request, $id)
    {
        $request->validate([
            'admin_final_price' => 'required|numeric|min:0',
            'admin_response' => 'required|string|max:1000'
        ]);

        $additionalService = AdditionalService::findOrFail($id);

        if ($additionalService->negotiation_status !== 'user_negotiated') {
            return response()->json([
                'success' => false,
                'message' => 'No active negotiation found for this service.'
            ], 400);
        }

        try {
            DB::beginTransaction();

            $additionalService->update([
                'admin_final_negotiated_price' => $request->admin_final_price,
                'admin_negotiation_response' => $request->admin_response,
                'negotiation_status' => 'admin_responded',
                'admin_reviewed_at' => now(),
                // Update the total price to reflect the negotiated amount
                'modified_total_price' => $request->admin_final_price,
                'price_modified_by_admin' => true
            ]);

            // Notify user and professional
            $user = $additionalService->user;
            $professional = $additionalService->professional;

            $message = "Your negotiation has been reviewed. Response: {$request->admin_response}";

            $user->notify(new AdditionalServiceNotification(
                $additionalService, 
                'negotiation_responded',
                $message
            ));

            $professional->notify(new AdditionalServiceNotification(
                $additionalService, 
                'negotiation_responded',
                $message
            ));

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Negotiation response sent successfully.'
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
     * Update delivery date
     */
    public function updateDeliveryDate(Request $request, $id)
    {
        $request->validate([
            'delivery_date' => 'required|date',
            'date_change_reason' => 'required|string|max:1000'
        ]);

        $additionalService = AdditionalService::findOrFail($id);

        try {
            DB::beginTransaction();

            $additionalService->update([
                'delivery_date' => $request->delivery_date,
                'delivery_date_set' => true,
                'admin_reviewed_at' => now()
            ]);

            // Notify user and professional
            $user = $additionalService->user;
            $professional = $additionalService->professional;

            $deliveryDate = \Carbon\Carbon::parse($request->delivery_date)->format('M d, Y');
            $message = "Delivery date updated to {$deliveryDate}. Reason: {$request->date_change_reason}";

            $user->notify(new AdditionalServiceNotification(
                $additionalService, 
                'delivery_date_changed',
                $message
            ));

            $professional->notify(new AdditionalServiceNotification(
                $additionalService, 
                'delivery_date_changed',
                $message
            ));

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Delivery date updated successfully.'
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
     * Release payment to professional
     */
    public function releasePayment($id)
    {
        $additionalService = AdditionalService::findOrFail($id);

        if ($additionalService->payment_status !== 'paid') {
            return response()->json([
                'success' => false,
                'message' => 'Payment has not been received yet.'
            ], 400);
        }

        if ($additionalService->professional_payment_status === 'processed') {
            return response()->json([
                'success' => false,
                'message' => 'Payment has already been released to the professional.'
            ], 400);
        }

        try {
            DB::beginTransaction();

            $additionalService->update([
                'professional_payment_status' => 'processed',
                'professional_payment_processed_at' => now()
            ]);

            // Notify professional
            $professional = $additionalService->professional;
            $professional->notify(new AdditionalServiceNotification(
                $additionalService, 
                'payment_released'
            ));

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Payment released to professional successfully.'
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
     * Get statistics for dashboard
     */
    public function getStatistics()
    {
        $stats = [
            'total' => AdditionalService::count(),
            'pending' => AdditionalService::where('admin_status', 'pending')->count(),
            'approved' => AdditionalService::where('admin_status', 'approved')->count(),
            'paid' => AdditionalService::where('payment_status', 'paid')->count(),
            'with_negotiation' => AdditionalService::where('negotiation_status', '!=', 'none')->count(),
            'total_revenue' => AdditionalService::where('payment_status', 'paid')->sum('total_price'),
            'pending_payouts' => AdditionalService::where('payment_status', 'paid')
                ->where('professional_payment_status', 'pending')
                ->sum('professional_final_amount'),
        ];

        return response()->json($stats);
    }

    /**
     * Update service price directly by admin with history tracking
     */
    public function updateServicePrice(Request $request, $id)
    {
        $request->validate([
            'new_price' => 'required|numeric|min:0',
            'reason' => 'required|string|max:1000'
        ]);

        $additionalService = AdditionalService::findOrFail($id);

        try {
            DB::beginTransaction();

            // Store price history
            $priceHistory = [
                'previous_price' => $additionalService->modified_total_price ?? $additionalService->total_price,
                'new_price' => $request->new_price,
                'modified_by' => 'admin',
                'modified_at' => now(),
                'reason' => $request->reason,
                'admin_id' => Auth::guard('admin')->id()
            ];

            $existingHistory = json_decode($additionalService->price_history ?? '[]', true);
            $existingHistory[] = $priceHistory;

            $additionalService->update([
                'modified_total_price' => $request->new_price,
                'price_modified_by_admin' => true,
                'price_modification_reason' => $request->reason,
                'price_history' => json_encode($existingHistory),
                'admin_reviewed_at' => now()
            ]);

            // Notify user and professional
            $user = $additionalService->user;
            $professional = $additionalService->professional;

            $message = "Service price has been updated by admin. New price: ₹{$request->new_price}. Reason: {$request->reason}";

            $user->notify(new AdditionalServiceNotification(
                $additionalService, 
                'price_updated_admin',
                $message
            ));

            $professional->notify(new AdditionalServiceNotification(
                $additionalService, 
                'price_updated_admin',
                $message
            ));

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Service price updated successfully with history tracking.'
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
     * Get price history for a service
     */
    public function getPriceHistory($id)
    {
        $additionalService = AdditionalService::findOrFail($id);
        $priceHistory = json_decode($additionalService->price_history ?? '[]', true);

        return response()->json([
            'success' => true,
            'history' => $priceHistory,
            'current_price' => $additionalService->final_price,
            'original_price' => $additionalService->base_price
        ]);
    }

    /**
     * Mark consultation as completed by admin
     */
    public function markAsCompleted(Request $request, $id)
    {
        $additionalService = AdditionalService::findOrFail($id);

        // Check if service can be marked as completed
        if ($additionalService->consulting_status === 'done') {
            return response()->json([
                'success' => false,
                'message' => 'Service has already been marked as completed.'
            ], 400);
        }

        if ($additionalService->payment_status !== 'paid') {
            return response()->json([
                'success' => false,
                'message' => 'Payment must be completed before marking service as done.'
            ], 400);
        }

        try {
            DB::beginTransaction();

            $additionalService->update([
                'consulting_status' => 'done',
                'professional_completed_at' => now(),
                'customer_confirmed_at' => now() // Auto-confirm when admin marks as completed
            ]);

            // Notify user and professional
            $user = $additionalService->user;
            $professional = $additionalService->professional;

            $user->notify(new AdditionalServiceNotification(
                $additionalService, 
                'consultation_completed'
            ));

            $professional->notify(new AdditionalServiceNotification(
                $additionalService, 
                'consultation_completed'
            ));

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Service marked as completed successfully. User and professional have been notified.'
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            
            return response()->json([
                'success' => false,
                'message' => 'An error occurred: ' . $e->getMessage()
            ], 500);
        }
    }
}