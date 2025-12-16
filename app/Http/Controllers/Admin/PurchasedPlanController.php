<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProfessionalPlanPurchase;
use Illuminate\Http\Request;

class PurchasedPlanController extends Controller
{
    /**
     * Display a listing of purchased plans
     */
    public function index(Request $request)
    {
        $query = ProfessionalPlanPurchase::with(['professional', 'plan'])
            ->orderBy('created_at', 'desc');

        // Filter by payment status
        if ($request->has('payment_status') && $request->payment_status != '') {
            $query->where('payment_status', $request->payment_status);
        }

        // Search by professional name
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->whereHas('professional', function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $purchases = $query->paginate(20);

        return view('admin.purchased-plans.index', compact('purchases'));
    }

    /**
     * Show the details of a purchased plan
     */
    public function show($id)
    {
        $purchase = ProfessionalPlanPurchase::with(['professional', 'plan'])
            ->findOrFail($id);

        return view('admin.purchased-plans.show', compact('purchase'));
    }

    /**
     * Show the form for editing a purchased plan
     */
    public function edit($id)
    {
        $purchase = ProfessionalPlanPurchase::with(['professional', 'plan'])
            ->findOrFail($id);

        return view('admin.purchased-plans.edit', compact('purchase'));
    }

    /**
     * Update the purchased plan
     */
    public function update(Request $request, $id)
    {
        $purchase = ProfessionalPlanPurchase::findOrFail($id);

        $request->validate([
            'payment_status' => 'required|in:pending,success,failed',
            'lead_limit' => 'required|integer|min:0',
            'leads_used' => 'required|integer|min:0',
            'end_date' => 'nullable|date',
            'admin_notes' => 'nullable|string',
        ]);

        $purchase->update([
            'payment_status' => $request->payment_status,
            'lead_limit' => $request->lead_limit,
            'leads_used' => $request->leads_used,
            'end_date' => $request->end_date,
            'admin_notes' => $request->admin_notes,
        ]);

        return redirect()->route('admin.purchased-plans.index')
            ->with('success', 'Purchased plan updated successfully!');
    }

    /**
     * Extend the plan validity
     */
    public function extend(Request $request, $id)
    {
        $purchase = ProfessionalPlanPurchase::findOrFail($id);

        $request->validate([
            'extend_days' => 'required|integer|min:1',
        ]);

        if ($purchase->end_date) {
            $purchase->end_date = \Carbon\Carbon::parse($purchase->end_date)
                ->addDays($request->extend_days);
        } else {
            $purchase->end_date = \Carbon\Carbon::now()
                ->addDays($request->extend_days);
        }

        $purchase->save();

        return redirect()->back()
            ->with('success', "Plan extended by {$request->extend_days} days successfully!");
    }
}
