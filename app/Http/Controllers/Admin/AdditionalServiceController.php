<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdditionalService;
use App\Models\Professional;
use App\Models\User;
use App\Notifications\AdditionalServiceNotification;
use App\Traits\AdditionalServiceNotificationTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class AdditionalServiceController extends Controller
{
    use AdditionalServiceNotificationTrait;
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

        if ($request->filled('professional_id')) {
            $query->where('professional_id', $request->professional_id);
        }

        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        // Handle export requests
        if ($request->has('export')) {
            $services = $query->orderBy('created_at', 'desc')->get();
            
            if ($request->export === 'excel') {
                return $this->exportToExcel($services);
            } elseif ($request->export === 'pdf') {
                return $this->exportToPDF($services);
            }
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
    public function releasePayment(Request $request, $id)
    {
        $request->validate([
            'payment_transaction_id' => 'required|string|max:255',
            'payment_method' => 'required|in:bank_transfer,upi,cheque,cash,other',
            'payment_notes' => 'nullable|string|max:1000'
        ]);

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
                'professional_payment_processed_at' => now(),
                'payment_transaction_id' => $request->payment_transaction_id,
                'payment_method' => $request->payment_method,
                'payment_notes' => $request->payment_notes
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
                'message' => 'Payment released to professional successfully with transaction ID: ' . $request->payment_transaction_id
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
     * Get statistics for dashboard (with filtering support)
     */
    public function getStatistics(Request $request)
    {
        // Build base query with same filters as index method
        $baseQuery = AdditionalService::query();

        // Apply same filters as index method
        if ($request->filled('status')) {
            switch ($request->status) {
                case 'pending':
                    $baseQuery->where('admin_status', 'pending');
                    break;
                case 'approved':
                    $baseQuery->where('admin_status', 'approved');
                    break;
                case 'rejected':
                    $baseQuery->where('admin_status', 'rejected');
                    break;
                case 'paid':
                    $baseQuery->where('payment_status', 'paid');
                    break;
                case 'negotiation':
                    $baseQuery->where('negotiation_status', '!=', 'none');
                    break;
            }
        }

        if ($request->filled('professional_id')) {
            $baseQuery->where('professional_id', $request->professional_id);
        }

        if ($request->filled('user_id')) {
            $baseQuery->where('user_id', $request->user_id);
        }

        if ($request->filled('date_from')) {
            $baseQuery->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $baseQuery->whereDate('created_at', '<=', $request->date_to);
        }

        // Calculate statistics based on filtered results
        $stats = [
            'total' => (clone $baseQuery)->count(),
            'pending' => (clone $baseQuery)->where('admin_status', 'pending')->count(),
            'approved' => (clone $baseQuery)->where('admin_status', 'approved')->count(),
            'paid' => (clone $baseQuery)->where('payment_status', 'paid')->count(),
            'with_negotiation' => (clone $baseQuery)->where('negotiation_status', '!=', 'none')->count(),
            'total_revenue' => (clone $baseQuery)->where('payment_status', 'paid')->sum('total_price') ?? 0,
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

        // Admin can mark as completed when payment is received (no other restrictions)
        if ($additionalService->payment_status !== 'paid') {
            return response()->json([
                'success' => false,
                'message' => 'Payment must be completed before marking service as done.'
            ], 400);
        }
        
        try {
            DB::beginTransaction();

            $updateData = [
                'consulting_status' => 'done',
                'admin_completed_at' => now(), // Track that admin completed it
                'professional_completed_at' => $additionalService->professional_completed_at ?? now(),
                'customer_confirmed_at' => $additionalService->customer_confirmed_at ?? now()
            ];

            $additionalService->update($updateData);

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

    /**
     * Respond to user's price negotiation
     */
    public function respondNegotiation(Request $request, $id)
    {
        $request->validate([
            'admin_final_negotiated_price' => 'required|numeric|min:0',
            'admin_negotiation_response' => 'required|string|max:1000'
        ]);

        $additionalService = AdditionalService::findOrFail($id);

        if ($additionalService->negotiation_status !== 'user_negotiated') {
            return response()->json([
                'success' => false,
                'message' => 'No active negotiation found.'
            ], 400);
        }

        try {
            DB::beginTransaction();

            // Update pricing with GST calculation
            $newPrice = $request->admin_final_negotiated_price;
            $gstData = $additionalService->updatePricingWithGST($newPrice, 'admin_negotiation');

            $additionalService->update([
                'admin_negotiation_response' => $request->admin_negotiation_response,
                'admin_reviewed_at' => now()
            ]);

            // Notify user about negotiation response
            $user = $additionalService->user;
            $message = "Admin responded to your negotiation. New price: ₹{$gstData['total_price']} (including GST). Response: {$request->admin_negotiation_response}";

            $user->notify(new AdditionalServiceNotification(
                $additionalService, 
                'negotiation_responded',
                $message
            ));

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Negotiation response sent successfully.',
                'data' => [
                    'final_base_price' => $gstData['base_price'],
                    'cgst' => $gstData['cgst'],
                    'sgst' => $gstData['sgst'],
                    'final_total_price' => $gstData['total_price']
                ]
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
     * Generate invoice for completed additional service
     */
    public function generateInvoice($id)
    {
        $additionalService = AdditionalService::with(['professional', 'user', 'booking'])
            ->findOrFail($id);

        // Check if service is completed and paid
        if ($additionalService->payment_status !== 'paid' || 
            $additionalService->consulting_status !== 'done') {
            return response()->json([
                'success' => false,
                'message' => 'Invoice can only be generated for completed and paid services.'
            ], 400);
        }

        // Get effective pricing
        $effectiveBasePrice = $additionalService->getEffectiveBasePrice();
        $gstData = $additionalService->calculateGST($effectiveBasePrice);

        $invoiceData = [
            'invoice_number' => 'INV-AS-' . str_pad($additionalService->id, 6, '0', STR_PAD_LEFT),
            'invoice_date' => now()->format('Y-m-d'),
            'service' => $additionalService,
            'customer' => $additionalService->user,
            'professional' => $additionalService->professional,
            'pricing' => [
                'base_price' => $effectiveBasePrice,
                'cgst' => $gstData['cgst'],
                'sgst' => $gstData['sgst'],
                'igst' => $gstData['igst'],
                'total_price' => $gstData['total_price']
            ],
            'price_history' => json_decode($additionalService->price_history, true) ?? [],
            'negotiation_details' => [
                'original_price' => $additionalService->base_price,
                'user_negotiated_price' => $additionalService->user_negotiated_price,
                'admin_final_price' => $additionalService->admin_final_negotiated_price,
                'negotiation_status' => $additionalService->negotiation_status
            ]
        ];

        return view('admin.additional-services.invoice', $invoiceData);
    }

    /**
     * Generate PDF invoice
     */
    public function generatePdfInvoice($id)
    {
        $additionalService = AdditionalService::with(['professional', 'user', 'booking'])
            ->findOrFail($id);

        if ($additionalService->payment_status !== 'paid' || 
            $additionalService->consulting_status !== 'done') {
            return response()->json([
                'success' => false,
                'message' => 'Invoice can only be generated for completed and paid services.'
            ], 400);
        }

        // Get effective pricing
        $effectiveBasePrice = $additionalService->getEffectiveBasePrice();
        $gstData = $additionalService->calculateGST($effectiveBasePrice);

        $invoiceData = [
            'invoice_number' => 'INV-AS-' . str_pad($additionalService->id, 6, '0', STR_PAD_LEFT),
            'invoice_date' => now()->format('Y-m-d'),
            'service' => $additionalService,
            'customer' => $additionalService->user,
            'professional' => $additionalService->professional,
            'pricing' => [
                'base_price' => $effectiveBasePrice,
                'cgst' => $gstData['cgst'],
                'sgst' => $gstData['sgst'],
                'igst' => $gstData['igst'],
                'total_price' => $gstData['total_price']
            ]
        ];

        $pdf = Pdf::loadView('admin.additional-services.invoice-pdf', $invoiceData);
        
        return $pdf->download('additional-service-invoice-' . $additionalService->id . '.pdf');
    }

    /**
     * Export additional services to Excel
     */
    private function exportToExcel($services)
    {
        $filename = 'additional_services_' . now()->format('Y_m_d_H_i_s') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($services) {
            $file = fopen('php://output', 'w');
            
            // Add CSV headers
            fputcsv($file, [
                'ID',
                'Service Name',
                'Professional',
                'Customer',
                'Final Price',
                'Admin Status',
                'Payment Status',
                'Consulting Status',
                'Delivery Date',
                'Created At',
                'Negotiation Status'
            ]);

            // Add data rows
            foreach ($services as $service) {
                fputcsv($file, [
                    $service->id,
                    $service->service_name,
                    $service->professional->name ?? 'N/A',
                    $service->user->name ?? 'N/A',
                    '₹' . number_format($service->final_price, 2),
                    ucfirst($service->admin_status),
                    ucfirst($service->payment_status),
                    ucfirst(str_replace('_', ' ', $service->consulting_status)),
                    $service->delivery_date ? \Carbon\Carbon::parse($service->delivery_date)->format('Y-m-d') : 'Not Set',
                    $service->created_at->format('Y-m-d H:i:s'),
                    ucfirst(str_replace('_', ' ', $service->negotiation_status))
                ]);
            }
            
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Export additional services to PDF
     */
    private function exportToPDF($services)
    {
        $data = [
            'services' => $services,
            'title' => 'Additional Services Report',
            'generated_at' => now()->format('Y-m-d H:i:s'),
            'total_count' => $services->count()
        ];

        $pdf = PDF::loadView('admin.additional-services.export-pdf', $data);
        $pdf->setPaper('A4', 'landscape');
        
        return $pdf->download('additional_services_report_' . now()->format('Y_m_d_H_i_s') . '.pdf');
    }
}