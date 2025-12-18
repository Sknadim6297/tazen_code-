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

        // Filter by active/inactive status
        if ($request->has('active_only') && $request->active_only !== '') {
            if ($request->active_only == '1') {
                // Show only active plans (successful and not expired)
                $query->where('payment_status', 'success')
                    ->where(function($q) {
                        $q->whereNull('end_date')
                          ->orWhere('end_date', '>', \Carbon\Carbon::now());
                    });
            } elseif ($request->active_only == '0') {
                // Show only inactive plans (expired or failed/pending)
                $query->where(function($q) {
                    $q->where('payment_status', '!=', 'success')
                      ->orWhere(function($subQ) {
                          $subQ->where('payment_status', 'success')
                               ->whereNotNull('end_date')
                               ->where('end_date', '<=', \Carbon\Carbon::now());
                      });
                });
            }
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

        // Validation
        $request->validate([
            'payment_status' => 'required|in:pending,success,failed',
            'lead_limit' => 'required|integer|min:0',
            'leads_used' => 'required|integer|min:0',
            'end_date' => 'nullable|date',
            'admin_notes' => 'nullable|string',
        ]);

        // Validate leads_used cannot exceed lead_limit
        if ($request->leads_used > $request->lead_limit) {
            return redirect()->back()
                ->withErrors(['leads_used' => 'Leads used cannot exceed lead limit.'])
                ->withInput();
        }

        // Check if this is the active plan
        $activePlan = ProfessionalPlanPurchase::getActivePlanForProfessional($purchase->professional_id);
        $isActivePlan = $activePlan && $activePlan->id === $purchase->id;

        // Get upgrade history count for this professional
        $upgradeHistory = ProfessionalPlanPurchase::where('professional_id', $purchase->professional_id)
            ->where('payment_status', 'success')
            ->orderBy('created_at', 'desc')
            ->get();

        // Prepare update data - preserve plan_name and plan_id to prevent downgrades
        $updateData = [
            'payment_status' => $request->payment_status,
            'lead_limit' => $request->lead_limit,
            'leads_used' => $request->leads_used,
            'admin_notes' => $request->admin_notes,
            // Explicitly preserve plan_name and plan_id
            'plan_name' => $purchase->plan_name,
            'plan_id' => $purchase->plan_id,
        ];
        
        // Only update end_date if it's actually provided (not null/empty)
        // This prevents accidentally clearing end_date when admin only updates leads
        if ($request->has('end_date') && $request->end_date !== null && $request->end_date !== '') {
            $updateData['end_date'] = $request->end_date;
        }
        
        $purchase->update($updateData);
        
        // Refresh the model to get the updated values
        $purchase->refresh();

        // Build detailed success message
        $message = 'Purchased plan updated successfully!';
        $remainingLeads = $purchase->lead_limit - $purchase->leads_used;
        
        // Check if plan is NOW active based on actual stored values after update
        $willBeActive = $purchase->payment_status === 'success' && 
                        (!$purchase->end_date || \Carbon\Carbon::parse($purchase->end_date)->isFuture());
        
        if (!$isActivePlan) {
            $message .= ' ⚠️ Note: This is NOT the currently active plan for this professional.';
            if ($upgradeHistory->count() > 1) {
                $currentIndex = $upgradeHistory->search(function($item) use ($purchase) {
                    return $item->id === $purchase->id;
                });
                $message .= " This professional has upgraded {$upgradeHistory->count()} times. This is purchase #{" . ($currentIndex + 1) . "}";
            }
        } else {
            if ($willBeActive) {
                $message .= " ✓ This is the ACTIVE plan. Remaining leads: {$remainingLeads}";
                if ($purchase->end_date) {
                    $expiryDate = \Carbon\Carbon::parse($purchase->end_date);
                    $daysUntilExpiry = now()->diffInDays($expiryDate, false);
                    if ($daysUntilExpiry > 0) {
                        $message .= " | Expires in {$daysUntilExpiry} days (on " . $expiryDate->format('d M, Y') . ")";
                    } else {
                        $message .= " | Expires today";
                    }
                } else {
                    $message .= " | No expiry date (unlimited)";
                }
            } else {
                $message .= " ⚠️ Plan is INACTIVE";
                if ($purchase->payment_status !== 'success') {
                    $message .= " (Payment status: " . ucfirst($purchase->payment_status) . ")";
                }
                if ($purchase->end_date && \Carbon\Carbon::parse($purchase->end_date)->isPast()) {
                    $message .= " (Expired on " . \Carbon\Carbon::parse($purchase->end_date)->format('d M, Y') . ")";
                }
            }
            if ($upgradeHistory->count() > 1) {
                $message .= " | Professional has upgraded {$upgradeHistory->count()} times";
            }
        }

        return redirect()->route('admin.purchased-plans.index')
            ->with('success', $message);
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
