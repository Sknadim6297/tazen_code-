<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CustomerProfile;
use App\Models\User;
use App\Exports\CustomersExport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

class ManageCustomerController extends Controller
{

    public function index(Request $request)
    {
        $query = User::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                    ->orWhere('email', 'like', '%' . $search . '%');
            });
        }

        if ($request->filled('start_date') && $request->filled('end_date')) {
            $startDate = \Carbon\Carbon::parse($request->start_date)->startOfDay();
            $endDate = \Carbon\Carbon::parse($request->end_date)->endOfDay();
            $query->whereBetween('created_at', [$startDate, $endDate]);
        }
        $users = $query->latest()->get();

        return view('admin.manage-customer.index', compact('users'));
    }

/**
     * Show the form for creating a new resource.
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Get the user first
        $user = User::findOrFail($id);
        
        // Try to get customer profile, create default if doesn't exist
        $customer_profile = CustomerProfile::where('user_id', $id)->first();
        
        // If no customer profile exists, create a temporary one with user data
        if (!$customer_profile) {
            $customer_profile = new CustomerProfile([
                'user_id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'phone' => $user->phone,
            ]);
        }
            
        return view('admin.manage-customer.show', compact('customer_profile', 'user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $customer_profile = CustomerProfile::with('user')
            ->where('user_id', $id)
            ->first();
        return view('admin.manage-customer.edit', compact('customer_profile'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
    }

    /**
     * Export customers to Excel
     */
    public function exportExcel(Request $request)
    {
        $fileName = 'customers_' . date('Y-m-d_H-i-s') . '.xlsx';
        
        return Excel::download(new CustomersExport($request), $fileName);
    }

    /**
     * Export customers to PDF
     */
    public function exportPdf(Request $request)
    {
        $query = User::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                    ->orWhere('email', 'like', '%' . $search . '%');
            });
        }

        if ($request->filled('start_date') && $request->filled('end_date')) {
            $startDate = \Carbon\Carbon::parse($request->start_date)->startOfDay();
            $endDate = \Carbon\Carbon::parse($request->end_date)->endOfDay();
            $query->whereBetween('created_at', [$startDate, $endDate]);
        }

        $users = $query->latest()->get();
        
        // Get customer profiles for all users
        $userIds = $users->pluck('id')->toArray();
        $customerProfiles = CustomerProfile::whereIn('user_id', $userIds)->get()->keyBy('user_id');
        
        $data = [
            'users' => $users,
            'customerProfiles' => $customerProfiles,
            'exportDate' => now()->format('Y-m-d H:i:s'),
            'totalCustomers' => $users->count(),
            'filters' => [
                'search' => $request->search,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
            ]
        ];

        $pdf = Pdf::loadView('admin.exports.customers_pdf', $data);
        $pdf->setPaper('A4', 'landscape');
        
        $fileName = 'customers_' . date('Y-m-d_H-i-s') . '.pdf';
        
        return $pdf->download($fileName);
    }

    /**
     * Reset customer onboarding (Admin function)
     */
    public function resetOnboarding(Request $request, $id)
    {
        $user = User::findOrFail($id);
        
        $user->update([
            'customer_onboarding_completed_at' => null,
            'professional_onboarding_completed_at' => null,
            'onboarding_data' => null
        ]);
        
        return redirect()->back()->with('success', 'Onboarding status has been reset for this user.');
    }
}
