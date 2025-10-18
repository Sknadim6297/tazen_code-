<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;
use Carbon\Carbon;

class CustomerBillingController extends Controller
{
    public function index(Request $request)
    {
        $serviceOptions = Booking::select('service_name')
            ->distinct()
            ->whereNotNull('service_name')
            ->where('service_name', '!=', '')
            ->orderBy('service_name')
            ->pluck('service_name');

        $query = Booking::with(['professional', 'user'])
            ->when($request->filled('search'), function ($query) use ($request) {
                $search = $request->search;
                $query->where(function ($q) use ($search) {
                    $q->where('customer_name', 'like', "%{$search}%")
                        ->orWhere('service_name', 'like', "%{$search}%");
                });
            })
            ->when($request->filled('start_date') && $request->filled('end_date'), function ($query) use ($request) {
                $query->whereBetween('created_at', [
                    Carbon::parse($request->start_date)->startOfDay(),
                    Carbon::parse($request->end_date)->endOfDay()
                ]);
            })
            ->when($request->filled('plan_type'), function ($query) use ($request) {
                $query->where('plan_type', $request->plan_type);
            })
            ->when($request->filled('sms_status'), function ($query) use ($request) {
                $query->where('sms_status', $request->sms_status);
            })
            ->when($request->filled('service'), function ($query) use ($request) {
                $query->where('service_name', $request->service);
            });

        try {
            $billings = $query->latest()->paginate(10);
        } catch (\Exception $e) {
            $billings = collect(); 

            return view('admin.billing.customer-billing', compact('billings', 'serviceOptions'))
                ->with('error', 'An error occurred while loading the billing data.');
        }

        return view('admin.billing.customer-billing', compact('billings', 'serviceOptions'));
    }
}
