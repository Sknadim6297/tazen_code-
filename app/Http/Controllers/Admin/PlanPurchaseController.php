<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProfessionalPlanPurchase;
use App\Models\Admin;
use App\Notifications\PlanPurchaseNotification;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PlanPurchaseController extends Controller
{
    /**
     * Display all plan purchases
     */
    public function index(Request $request)
    {
        $query = ProfessionalPlanPurchase::with(['professional', 'plan'])
            ->orderBy('created_at', 'desc');

        // Filter by payment status
        if ($request->has('status') && $request->status !== 'all') {
            $query->where('payment_status', $request->status);
        }

        // Filter by payment method
        if ($request->has('method') && $request->method !== 'all') {
            $query->where('payment_method', $request->method);
        }

        $purchases = $query->paginate(20);

        return view('admin.plans.purchases.index', compact('purchases'));
    }

    /**
     * Show single purchase details
     */
    public function show($id)
    {
        $purchase = ProfessionalPlanPurchase::with(['professional', 'plan'])->findOrFail($id);
        
        return view('admin.plans.purchases.show', compact('purchase'));
    }

    /**
     * Approve manual payment
     */
    public function approve($id)
    {
        $purchase = ProfessionalPlanPurchase::findOrFail($id);

        if ($purchase->payment_method !== 'manual') {
            return redirect()->back()->with('error', 'Only manual payments can be approved.');
        }

        if ($purchase->payment_status === 'success') {
            return redirect()->back()->with('info', 'This purchase is already approved.');
        }

        $purchase->update([
            'payment_status' => 'success',
            'admin_notes' => 'Approved by admin on ' . Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        return redirect()->back()->with('success', 'Plan purchase approved successfully!');
    }

    /**
     * Reject manual payment
     */
    public function reject(Request $request, $id)
    {
        $purchase = ProfessionalPlanPurchase::findOrFail($id);

        if ($purchase->payment_method !== 'manual') {
            return redirect()->back()->with('error', 'Only manual payments can be rejected.');
        }

        $purchase->update([
            'payment_status' => 'failed',
            'admin_notes' => $request->input('reason', 'Rejected by admin on ' . Carbon::now()->format('Y-m-d H:i:s')),
        ]);

        return redirect()->back()->with('success', 'Plan purchase rejected.');
    }

    /**
     * Update purchase status
     */
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'payment_status' => 'required|in:pending,success,failed',
            'admin_notes' => 'nullable|string',
        ]);

        $purchase = ProfessionalPlanPurchase::findOrFail($id);

        $purchase->update([
            'payment_status' => $request->payment_status,
            'admin_notes' => $request->admin_notes,
        ]);

        return redirect()->back()->with('success', 'Purchase status updated successfully!');
    }
}
