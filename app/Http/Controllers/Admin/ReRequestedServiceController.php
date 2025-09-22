<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ReRequestedService;
use App\Mail\ReRequestedServiceApproved;
use App\Mail\ReRequestedServiceRejected;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;

class ReRequestedServiceController extends Controller
{
    public function index(Request $request)
    {
        $query = ReRequestedService::with(['professional', 'customer', 'originalBooking']);

        // Apply filters using scope methods
        $query->byStatus($request->status)
              ->byPaymentStatus($request->payment_status)
              ->byPriority($request->priority)
              ->searchByName($request->search);

        // Apply date range filter
        if ($request->filled('date_from')) {
            $query->whereDate('requested_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('requested_at', '<=', $request->date_to);
        }

        // Apply price range filter
        if ($request->filled('price_from')) {
            $query->where('final_price', '>=', $request->price_from);
        }
        if ($request->filled('price_to')) {
            $query->where('final_price', '<=', $request->price_to);
        }

        $reRequestedServices = $query->orderBy('created_at', 'desc')->paginate(15);

        // Get counts for dashboard
        $counts = [
            'total' => ReRequestedService::count(),
            'pending' => ReRequestedService::where('status', 'pending')->count(),
            'approved' => ReRequestedService::where('status', 'admin_approved')->count(),
            'paid' => ReRequestedService::where('payment_status', 'paid')->count(),
            'rejected' => ReRequestedService::where('status', 'rejected')->count(),
        ];

        return view('admin.re-requested-service.index', compact('reRequestedServices', 'counts'));
    }

    public function show($id)
    {
        $reRequestedService = ReRequestedService::with(['professional', 'customer', 'originalBooking'])
            ->findOrFail($id);

        return view('admin.re-requested-service.show', compact('reRequestedService'));
    }

    public function edit($id)
    {
        $reRequestedService = ReRequestedService::with(['professional', 'customer'])
            ->findOrFail($id);

        return view('admin.re-requested-service.edit', compact('reRequestedService'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'admin_modified_price' => 'required|numeric|min:0|max:999999',
            'admin_notes' => 'nullable|string|max:1000',
            'priority' => 'nullable|in:low,normal,high,urgent'
        ], [
            'admin_modified_price.max' => 'Price cannot exceed ₹999,999.'
        ]);

        $reRequestedService = ReRequestedService::findOrFail($id);
        
        $modifiedPrice = $request->admin_modified_price;
        
        // Calculate CGST and SGST (8% each)
        $cgstAmount = ($modifiedPrice * 8) / 100;
        $sgstAmount = ($modifiedPrice * 8) / 100;
        $totalGstAmount = $cgstAmount + $sgstAmount;
        $totalAmount = $modifiedPrice + $totalGstAmount;

        $updateData = [
            'admin_modified_price' => $modifiedPrice,
            'final_price' => $modifiedPrice,
            'gst_amount' => $totalGstAmount,
            'cgst_amount' => $cgstAmount,
            'sgst_amount' => $sgstAmount,
            'total_amount' => $totalAmount,
            'admin_notes' => $request->admin_notes
        ];

        if ($request->filled('priority')) {
            $updateData['priority'] = $request->priority;
        }

        $reRequestedService->update($updateData);

        return redirect()->route('admin.re-requested-service.index')
            ->with('success', 'Re-booking service price has been updated successfully.');
    }

    public function approve(Request $request, $id)
    {
        $request->validate([
            'admin_notes' => 'nullable|string'
        ]);

        $reRequestedService = ReRequestedService::findOrFail($id);
        
        $reRequestedService->update([
            'status' => 'admin_approved',
            'admin_approved_at' => now(),
            'admin_notes' => $request->admin_notes
        ]);

        // Send email to customer and professional
        try {
            Mail::to($reRequestedService->customer->email)
                ->send(new ReRequestedServiceApproved($reRequestedService, 'customer'));
            
            Mail::to($reRequestedService->professional->email)
                ->send(new ReRequestedServiceApproved($reRequestedService, 'professional'));
        } catch (\Exception $e) {
            // Log email error but don't fail the approval
        }

        return redirect()->route('admin.re-requested-service.index')
            ->with('success', 'Re-requested service has been approved and notifications sent.');
    }

    public function reject(Request $request, $id)
    {
        $request->validate([
            'admin_notes' => 'required|string'
        ]);

        $reRequestedService = ReRequestedService::findOrFail($id);
        
        $reRequestedService->update([
            'status' => 'rejected',
            'admin_notes' => $request->admin_notes
        ]);

        // Send email to customer and professional
        try {
            Mail::to($reRequestedService->customer->email)
                ->send(new ReRequestedServiceRejected($reRequestedService, 'customer'));
            
            Mail::to($reRequestedService->professional->email)
                ->send(new ReRequestedServiceRejected($reRequestedService, 'professional'));
        } catch (\Exception $e) {
            // Log email error but don't fail the rejection
        }

        return redirect()->route('admin.re-requested-service.index')
            ->with('success', 'Re-requested service has been rejected and notifications sent.');
    }

    public function sendEmail(Request $request, $id)
    {
        $request->validate([
            'recipient' => 'required|in:customer,professional,both',
            'subject' => 'required|string|max:255',
            'message' => 'required|string'
        ]);

        $reRequestedService = ReRequestedService::findOrFail($id);
        
        try {
            if ($request->recipient === 'customer' || $request->recipient === 'both') {
                Mail::raw($request->message, function($mail) use ($reRequestedService, $request) {
                    $mail->to($reRequestedService->customer->email)
                         ->subject($request->subject);
                });
            }

            if ($request->recipient === 'professional' || $request->recipient === 'both') {
                Mail::raw($request->message, function($mail) use ($reRequestedService, $request) {
                    $mail->to($reRequestedService->professional->email)
                         ->subject($request->subject);
                });
            }

            return redirect()->back()->with('success', 'Email sent successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to send email. Please try again.');
        }
    }

    public function analytics()
    {
        $totalRequests = ReRequestedService::count();
        $pendingRequests = ReRequestedService::where('status', 'pending')->count();
        $approvedRequests = ReRequestedService::where('status', 'admin_approved')->count();
        $paidRequests = ReRequestedService::where('payment_status', 'paid')->count();
        $totalRevenue = ReRequestedService::where('payment_status', 'paid')->sum('total_amount');

        $monthlyData = ReRequestedService::selectRaw('MONTH(created_at) as month, COUNT(*) as count, SUM(total_amount) as revenue')
            ->whereYear('created_at', date('Y'))
            ->groupBy('month')
            ->get();

        return view('admin.re-requested-service.analytics', compact(
            'totalRequests', 
            'pendingRequests', 
            'approvedRequests', 
            'paidRequests', 
            'totalRevenue', 
            'monthlyData'
        ));
    }

    public function bulkAction(Request $request)
    {
        $request->validate([
            'action' => 'required|in:approve,reject,delete',
            'selected_ids' => 'required|array|min:1',
            'selected_ids.*' => 'exists:re_requested_services,id',
            'bulk_admin_notes' => 'nullable|string|max:1000'
        ]);

        $ids = $request->selected_ids;
        $action = $request->action;
        $notes = $request->bulk_admin_notes;

        try {
            DB::beginTransaction();

            switch ($action) {
                case 'approve':
                    $services = ReRequestedService::whereIn('id', $ids)
                        ->where('status', 'pending')
                        ->get();
                    
                    foreach ($services as $service) {
                        $service->update([
                            'status' => 'admin_approved',
                            'admin_approved_at' => now(),
                            'admin_notes' => $notes ?? 'Bulk approved by admin'
                        ]);
                        
                        // Send email notifications
                        try {
                            Mail::to($service->customer->email)
                                ->send(new ReRequestedServiceApproved($service, 'customer'));
                            
                            Mail::to($service->professional->email)
                                ->send(new ReRequestedServiceApproved($service, 'professional'));
                        } catch (\Exception $e) {
                            // Continue even if email fails
                        }
                    }
                    
                    $message = count($services) . ' request(s) approved successfully.';
                    break;

                case 'reject':
                    if (empty($notes)) {
                        return redirect()->back()->withErrors(['bulk_admin_notes' => 'Notes are required for rejection.']);
                    }
                    
                    $services = ReRequestedService::whereIn('id', $ids)
                        ->where('status', 'pending')
                        ->get();
                    
                    foreach ($services as $service) {
                        $service->update([
                            'status' => 'rejected',
                            'rejection_reason' => $notes,
                            'admin_notes' => $notes
                        ]);
                        
                        // Send email notifications
                        try {
                            Mail::to($service->customer->email)
                                ->send(new ReRequestedServiceRejected($service, 'customer'));
                            
                            Mail::to($service->professional->email)
                                ->send(new ReRequestedServiceRejected($service, 'professional'));
                        } catch (\Exception $e) {
                            // Continue even if email fails
                        }
                    }
                    
                    $message = count($services) . ' request(s) rejected successfully.';
                    break;

                case 'delete':
                    $count = ReRequestedService::whereIn('id', $ids)
                        ->whereIn('status', ['pending', 'rejected', 'cancelled'])
                        ->delete();
                    
                    $message = $count . ' request(s) deleted successfully.';
                    break;
            }

            DB::commit();
            return redirect()->back()->with('success', $message);

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'An error occurred during bulk action: ' . $e->getMessage());
        }
    }

    public function export(Request $request)
    {
        $query = ReRequestedService::with(['professional', 'customer', 'originalBooking']);

        // Apply same filters as index
        $query->byStatus($request->status)
              ->byPaymentStatus($request->payment_status)
              ->byPriority($request->priority)
              ->searchByName($request->search);

        if ($request->filled('date_from')) {
            $query->whereDate('requested_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('requested_at', '<=', $request->date_to);
        }

        $services = $query->orderBy('created_at', 'desc')->get();

        $filename = 'rebooking_services_' . date('Y-m-d_H-i-s') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($services) {
            $file = fopen('php://output', 'w');
            
            // CSV headers
            fputcsv($file, [
                'ID', 'Professional Name', 'Customer Name', 'Service Name', 
                'Original Price', 'Final Price', 'CGST', 'SGST', 'Total Amount',
                'Status', 'Priority', 'Payment Status', 'Requested Date', 
                'Admin Notes', 'Reason'
            ]);

            foreach ($services as $service) {
                fputcsv($file, [
                    $service->id,
                    $service->professional->name,
                    $service->customer->name,
                    $service->service_name,
                    $service->original_price,
                    $service->final_price,
                    $service->cgst_amount,
                    $service->sgst_amount,
                    $service->total_amount,
                    $service->status,
                    $service->priority,
                    $service->payment_status,
                    $service->requested_at->format('Y-m-d H:i:s'),
                    $service->admin_notes,
                    $service->reason
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Delete a single re-requested service.
     */
    public function destroy($id)
    {
        try {
            $service = ReRequestedService::findOrFail($id);

            // Allow deletion only for specific statuses
            if (!in_array($service->status, ['pending', 'rejected', 'cancelled'])) {
                return redirect()->back()->with('error', 'Only pending, rejected or cancelled requests can be deleted.');
            }

            $service->delete();

            return redirect()->back()->with('success', 'Re-requested service deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to delete request: ' . $e->getMessage());
        }
    }
}
