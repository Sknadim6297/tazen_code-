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
            });

        $billings = $query->latest()->paginate(10);

        return view('admin.billing.customer-billing', compact('billings'));
    }
} 