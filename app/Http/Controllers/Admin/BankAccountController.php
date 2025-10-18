<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Profile;
use App\Models\Professional;
use App\Exports\BankAccountsExport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

class BankAccountController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin.auth');
    }

    public function index(Request $request)
    {
        $query = Profile::with('professional')
            ->whereNotNull('bank_name')
            ->whereNotNull('account_number')
            ->whereNotNull('ifsc_code');
        if ($request->filled('professional_status')) {
            $query->whereHas('professional', function ($q) use ($request) {
                $q->where('status', $request->professional_status);
            });
        }

        if ($request->filled('account_type')) {
            $query->where('account_type', $request->account_type);
        }

        if ($request->filled('verification_status')) {
            if ($request->verification_status === 'verified') {
                $query->whereNotNull('bank_document');
            } elseif ($request->verification_status === 'pending') {
                $query->whereNull('bank_document');
            }
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('account_holder_name', 'like', "%{$search}%")
                  ->orWhere('bank_name', 'like', "%{$search}%")
                  ->orWhere('account_number', 'like', "%{$search}%")
                  ->orWhere('ifsc_code', 'like', "%{$search}%")
                  ->orWhere('bank_branch', 'like', "%{$search}%")
                  ->orWhereHas('professional', function ($q) use ($search) {
                      $q->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                  });
            });
        }

        $bankAccounts = $query->orderBy('created_at', 'desc')->paginate(25);
        $bankAccounts->getCollection()->transform(function ($profile) {
            if (!$profile->account_type) {
                $profile->account_type = 'savings';
            }
            $profile->verification_status = $profile->bank_document ? 'verified' : 'pending';
            
            return $profile;
        });

        return view('admin.bank-accounts.index', compact('bankAccounts'));
    }

    public function show($id)
    {
        $account = Profile::with('professional')
            ->where('id', $id)
            ->whereNotNull('bank_name')
            ->whereNotNull('account_number')
            ->whereNotNull('ifsc_code')
            ->first();

        if (!$account) {
            return response()->json(['error' => 'Bank account not found'], 404);
        }
        if (!$account->account_type) {
            $account->account_type = 'savings';
        }
        
        $account->verification_status = $account->bank_document ? 'verified' : 'pending';
        
        return view('admin.bank-accounts.show', compact('account'));
    }

    public function verify(Request $request, $id)
    {
        try {
            $account = Profile::with('professional')
                ->where('id', $id)
                ->whereNotNull('bank_name')
                ->whereNotNull('account_number')
                ->whereNotNull('ifsc_code')
                ->first();

            if (!$account) {
                return response()->json(['success' => false, 'message' => 'Bank account not found'], 404);
            }
            if (!$account->bank_document) {
                return response()->json([
                    'success' => false, 
                    'message' => 'Cannot verify account without bank document'
                ], 400);
            }
            return response()->json([
                'success' => true,
                'message' => 'Bank account verified successfully'
            ]);
} catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to verify account: ' . $e->getMessage()
            ], 500);
        }
    }

    public function exportPdf(Request $request)
    {
        try {
            $query = Profile::with('professional')
                ->whereNotNull('bank_name')
                ->whereNotNull('account_number')
                ->whereNotNull('ifsc_code');
            if ($request->filled('professional_status')) {
                $query->whereHas('professional', function ($q) use ($request) {
                    $q->where('status', $request->professional_status);
                });
            }

            if ($request->filled('account_type')) {
                $query->where('account_type', $request->account_type);
            }

            if ($request->filled('verification_status')) {
                if ($request->verification_status === 'verified') {
                    $query->whereNotNull('bank_document');
                } elseif ($request->verification_status === 'pending') {
                    $query->whereNull('bank_document');
                }
            }

            if ($request->filled('search')) {
                $search = $request->search;
                $query->where(function ($q) use ($search) {
                    $q->where('account_holder_name', 'like', "%{$search}%")
                      ->orWhere('bank_name', 'like', "%{$search}%")
                      ->orWhere('account_number', 'like', "%{$search}%")
                      ->orWhere('ifsc_code', 'like', "%{$search}%")
                      ->orWhere('bank_branch', 'like', "%{$search}%")
                      ->orWhereHas('professional', function ($q) use ($search) {
                          $q->where('name', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%");
                      });
                });
            }

            $bankAccounts = $query->orderBy('created_at', 'desc')->get();
            $bankAccounts = $bankAccounts->map(function ($profile) {
                if (!$profile->account_type) {
                    $profile->account_type = 'savings';
                }
                $profile->verification_status = $profile->bank_document ? 'verified' : 'pending';
                return $profile;
            });

            $pdf = Pdf::loadView('admin.bank-accounts.pdf', compact('bankAccounts'));
            $pdf->setPaper('A4', 'landscape');
            
            return $pdf->download('professional-bank-accounts-' . now()->format('Y-m-d') . '.pdf');
} catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to generate PDF: ' . $e->getMessage());
        }
    }

    public function exportExcel(Request $request)
    {
        try {
            $filters = $request->only(['professional_status', 'account_type', 'verification_status', 'search']);
            
            return Excel::download(
                new BankAccountsExport($filters), 
                'professional-bank-accounts-' . now()->format('Y-m-d') . '.xlsx'
            );
} catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to generate Excel: ' . $e->getMessage());
        }
    }
}