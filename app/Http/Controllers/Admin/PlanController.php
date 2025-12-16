<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PlanController extends Controller
{
    /**
     * Display a listing of plans
     */
    public function index()
    {
        $plans = Plan::orderBy('order')->get();
        return view('admin.plans.index', compact('plans'));
    }

    /**
     * Show the form for creating a new plan
     */
    public function create()
    {
        return view('admin.plans.create');
    }

    /**
     * Store a newly created plan
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'lead_limit' => 'required|integer|min:1',
            'features' => 'nullable|array',
            'features.*' => 'string',
            'validity_days' => 'nullable|integer|min:1',
            'status' => 'required|in:active,inactive',
            'description' => 'nullable|string',
            'order' => 'nullable|integer|min:0',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $data = $request->all();
        
        // Filter out empty features
        if (isset($data['features'])) {
            $data['features'] = array_filter($data['features'], function($feature) {
                return !empty(trim($feature));
            });
            $data['features'] = array_values($data['features']); // Re-index array
        }

        Plan::create($data);

        return redirect()->route('admin.plans.index')
            ->with('success', 'Plan created successfully!');
    }

    /**
     * Show the form for editing the specified plan
     */
    public function edit($id)
    {
        $plan = Plan::findOrFail($id);
        return view('admin.plans.edit', compact('plan'));
    }

    /**
     * Update the specified plan
     */
    public function update(Request $request, $id)
    {
        $plan = Plan::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'lead_limit' => 'required|integer|min:1',
            'features' => 'nullable|array',
            'features.*' => 'string',
            'validity_days' => 'nullable|integer|min:1',
            'status' => 'required|in:active,inactive',
            'description' => 'nullable|string',
            'order' => 'nullable|integer|min:0',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $data = $request->all();
        
        // Filter out empty features
        if (isset($data['features'])) {
            $data['features'] = array_filter($data['features'], function($feature) {
                return !empty(trim($feature));
            });
            $data['features'] = array_values($data['features']); // Re-index array
        }

        $plan->update($data);

        return redirect()->route('admin.plans.index')
            ->with('success', 'Plan updated successfully!');
    }

    /**
     * Remove the specified plan
     */
    public function destroy($id)
    {
        $plan = Plan::findOrFail($id);
        
        // Check if plan has any purchases
        if ($plan->purchases()->count() > 0) {
            return redirect()->back()
                ->with('error', 'Cannot delete plan with existing purchases!');
        }

        $plan->delete();

        return redirect()->route('admin.plans.index')
            ->with('success', 'Plan deleted successfully!');
    }

    /**
     * Toggle plan status
     */
    public function toggleStatus($id)
    {
        $plan = Plan::findOrFail($id);
        $plan->status = $plan->status === 'active' ? 'inactive' : 'active';
        $plan->save();

        return redirect()->back()
            ->with('success', 'Plan status updated successfully!');
    }
}
