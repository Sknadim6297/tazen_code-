<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class BillingController extends Controller
{
    public function professionalBilling(Request $request)
    {
        $serviceOptions = Booking::select('service_name')
            ->distinct()
            ->whereNotNull('service_name')
            ->orderBy('service_name')
            ->pluck('service_name');

        $billings = Booking::with(['professional', 'user'])
            ->when($request->filled('search'), function ($query) use ($request) {
                $query->where(function ($q) use ($request) {
                    $q->where('customer_name', 'like', "%{$request->search}%")
                        ->orWhere('customer_email', 'like', "%{$request->search}%")
                        ->orWhere('customer_phone', 'like', "%{$request->search}%")
                        ->orWhereHas('professional', function ($q) use ($request) {
                            $q->where('name', 'like', "%{$request->search}%");
                        });
                });
            })
            ->when($request->filled(['start_date', 'end_date']), function ($query) use ($request) {
                $query->whereBetween('created_at', [
                    Carbon::parse($request->start_date)->startOfDay(),
                    Carbon::parse($request->end_date)->endOfDay()
                ]);
            })
            ->when($request->filled('plan_type'), fn($q) => $q->where('plan_type', $request->plan_type))
            ->when($request->filled('payment_status'), fn($q) => $q->where('payment_status', $request->payment_status))
            ->when($request->filled('service'), fn($q) => $q->where('service_name', $request->service))
            ->latest()
            ->paginate(10);

        return view('admin.billing.professional-billing', compact('billings', 'serviceOptions'));
    }

    /**
     * Export professional billing data to PDF
     * 
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function exportBillingToPdf(Request $request)
    {
        $query = Booking::with(['professional', 'user'])
            ->when($request->filled('search'), function ($query) use ($request) {
                $query->where(function ($q) use ($request) {
                    $q->where('customer_name', 'like', "%{$request->search}%")
                        ->orWhere('customer_email', 'like', "%{$request->search}%")
                        ->orWhere('customer_phone', 'like', "%{$request->search}%")
                        ->orWhereHas('professional', function ($q) use ($request) {
                            $q->where('name', 'like', "%{$request->search}%");
                        });
                });
            })
            ->when($request->filled(['start_date', 'end_date']), function ($query) use ($request) {
                $query->whereBetween('created_at', [
                    Carbon::parse($request->start_date)->startOfDay(),
                    Carbon::parse($request->end_date)->endOfDay()
                ]);
            })
            ->when($request->filled('plan_type'), fn($q) => $q->where('plan_type', $request->plan_type))
            ->when($request->filled('payment_status'), fn($q) => $q->where('payment_status', $request->payment_status))
            ->when($request->filled('service'), fn($q) => $q->where('service_name', $request->service))
            ->latest();
        $billings = $query->get();
        $totalAmount = 0;
        $totalCommission = 0;
        $totalProfessionalPay = 0;

        foreach ($billings as $billing) {
            $commissionRate = $billing->professional->margin ?? 0;
            $professionalPay = $billing->amount * ((100 - $commissionRate) / 100);
            $amountEarned = $billing->amount * ($commissionRate / 100);

            $totalAmount += $billing->amount;
            $totalCommission += $amountEarned;
            $totalProfessionalPay += $professionalPay;
        }
        $filterInfo = [
            'start_date' => $request->filled('start_date') ? Carbon::parse($request->start_date)->format('d M Y') : 'All time',
            'end_date' => $request->filled('end_date') ? Carbon::parse($request->end_date)->format('d M Y') : 'Present',
            'plan_type' => $request->filled('plan_type') ? ucfirst(str_replace('_', ' ', $request->plan_type)) : 'All plans',
            'payment_status' => $request->filled('payment_status') ? ucfirst($request->payment_status) : 'All statuses',
            'service' => $request->filled('service') ? $request->service : 'All services', // Add service to filter info
            'generated_at' => Carbon::now()->format('d M Y H:i:s'),
        ];
        $pdf = Pdf::loadView('admin.billing.professional-billing-pdf', compact(
            'billings',
            'totalAmount',
            'totalCommission',
            'totalProfessionalPay',
            'filterInfo'
        ));
        $pdf->setPaper('a4', 'landscape');
        $filename = 'professional_billing_' . Carbon::now()->format('Y_m_d_His') . '.pdf';
        return $pdf->download($filename);
    }

    /**
     * Show customer billing records.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function customerBilling(Request $request)
    {
        $serviceOptions = \App\Models\Booking::select('service_name')
            ->distinct()
            ->whereNotNull('service_name')
            ->where('service_name', '!=', '')
            ->orderBy('service_name')
            ->pluck('service_name');

        $query = \App\Models\Booking::with(['professional', 'user']);
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('customer_name', 'like', "%{$search}%")
                    ->orWhere('customer_email', 'like', "%{$search}%")
                    ->orWhere('customer_phone', 'like', "%{$search}%");
            });
        }
        if ($request->filled(['start_date', 'end_date'])) {
            $startDate = \Carbon\Carbon::parse($request->start_date)->startOfDay();
            $endDate = \Carbon\Carbon::parse($request->end_date)->endOfDay();
            $query->whereBetween('created_at', [$startDate, $endDate]);
        }
        if ($request->filled('plan_type')) {
            $query->where('plan_type', $request->plan_type);
        }
        if ($request->filled('sms_status')) {
            $query->where('sms_status', $request->sms_status);
        }
        if ($request->filled('service')) {
            $query->where('service_name', $request->service);
        }
        $billings = $query->latest()->paginate(10);

        return view('admin.billing.customer-billing', compact('billings', 'serviceOptions'));
    }

    /**
     * Export customer billing records to PDF.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function exportCustomerBillingToPdf(Request $request)
    {
        $query = \App\Models\Booking::with(['professional', 'user']);
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('customer_name', 'like', "%{$search}%")
                    ->orWhere('customer_email', 'like', "%{$search}%")
                    ->orWhere('customer_phone', 'like', "%{$search}%");
            });
        }

        if ($request->filled(['start_date', 'end_date'])) {
            $startDate = \Carbon\Carbon::parse($request->start_date)->startOfDay();
            $endDate = \Carbon\Carbon::parse($request->end_date)->endOfDay();
            $query->whereBetween('created_at', [$startDate, $endDate]);
        }

        if ($request->filled('plan_type')) {
            $query->where('plan_type', $request->plan_type);
        }

        if ($request->filled('sms_status')) {
            $query->where('sms_status', $request->sms_status);
        }
        if ($request->filled('service')) {
            $query->where('service_name', $request->service);
        }
        $billings = $query->latest()->get();
        $totalAmount = $billings->sum('amount');
        $planCounts = [
            'one_time' => $billings->where('plan_type', 'one_time')->count(),
            'monthly' => $billings->where('plan_type', 'monthly')->count(),
            'quarterly' => $billings->where('plan_type', 'quarterly')->count(),
            'free_hand' => $billings->where('plan_type', 'free_hand')->count(),
        ];
        $filterInfo = [
            'start_date' => $request->filled('start_date') ? \Carbon\Carbon::parse($request->start_date)->format('d M Y') : 'All time',
            'end_date' => $request->filled('end_date') ? \Carbon\Carbon::parse($request->end_date)->format('d M Y') : 'Present',
            'plan_type' => $request->filled('plan_type') ? ucfirst(str_replace('_', ' ', $request->plan_type)) : 'All plans',
            'sms_status' => $request->filled('sms_status') ? ucfirst($request->sms_status) : 'All statuses',
            'service' => $request->filled('service') ? $request->service : 'All services',
            'generated_at' => \Carbon\Carbon::now()->format('d M Y H:i:s'),
            'total_amount' => $totalAmount
        ];
        $pdf = Pdf::loadView('admin.billing.customer-billing-pdf', compact(
            'billings', 
            'filterInfo', 
            'totalAmount', 
            'planCounts' // Add this variable
        ));
        $pdf->setPaper('a4', 'landscape');
        $filename = 'customer_billing_' . \Carbon\Carbon::now()->format('Y_m_d_His') . '.pdf';
        return $pdf->download($filename);
    }

    public function savePayment(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'billing_id' => 'required|exists:bookings,id',
            'transaction_number' => 'required|string|max:255',
            'paid_date' => 'required|date',
            'status' => 'required|in:paid,unpaid',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            DB::beginTransaction();

            $booking = Booking::findOrFail($request->billing_id);
            $isPaid = $request->status === 'paid';

            $booking->transaction_number = $isPaid ? $request->transaction_number : null;
            $booking->paid_date = $isPaid ? $request->paid_date : null;
            $booking->paid_status = $request->status;
            $booking->payment_status = $isPaid ? 'paid' : 'pending';
            $booking->save();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Payment ' . ($isPaid ? 'marked as paid' : 'marked as unpaid'),
                'booking' => $booking
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update payment status via AJAX toggle
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updatePaymentStatus(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'billing_id' => 'required|exists:bookings,id',
            'status' => 'required|in:paid,unpaid',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }
        if ($request->status === 'paid') {
            return response()->json([
                'success' => false,
                'message' => 'Payment status cannot be changed to paid via toggle. Please use the payment form.'
            ], 422);
        }

        try {
            DB::beginTransaction();
            $booking = Booking::findOrFail($request->billing_id);

            $booking->paid_status = 'unpaid';
            $booking->payment_status = 'pending';
            $booking->transaction_number = null;
            $booking->paid_date = null;
            $booking->save();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Payment status updated successfully',
                'booking' => [
                    'id' => $booking->id,
                    'paid_status' => $booking->paid_status,
                    'payment_status' => $booking->payment_status,
                    'transaction_number' => null,
                    'paid_date' => null
                ]
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Export professional billing data to Excel
     * 
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function exportBillingToExcel(Request $request)
    {
        try {
            $filename = 'professional_billing_' . date('Y_m_d_His') . '.csv';
            $headers = [
                'Content-Type' => 'text/csv',
                'Content-Disposition' => 'attachment; filename="' . $filename . '"',
                'Pragma' => 'no-cache',
                'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
                'Expires' => '0',
            ];
            $query = Booking::with(['professional', 'user'])
                ->when($request->filled('search'), function ($query) use ($request) {
                    $query->where(function ($q) use ($request) {
                        $q->where('customer_name', 'like', "%{$request->search}%")
                            ->orWhere('customer_email', 'like', "%{$request->search}%")
                            ->orWhere('customer_phone', 'like', "%{$request->search}%")
                            ->orWhereHas('professional', function ($q) use ($request) {
                                $q->where('name', 'like', "%{$request->search}%");
                            });
                    });
                })
                ->when($request->filled(['start_date', 'end_date']), function ($query) use ($request) {
                    $query->whereBetween('created_at', [
                        Carbon::parse($request->start_date)->startOfDay(),
                        Carbon::parse($request->end_date)->endOfDay()
                    ]);
                })
                ->when($request->filled('plan_type'), fn($q) => $q->where('plan_type', $request->plan_type))
                ->when($request->filled('payment_status'), fn($q) => $q->where('payment_status', $request->payment_status))
                ->when($request->filled('service'), fn($q) => $q->where('service_name', $request->service))
                ->latest();
            $billings = $query->get();
            $callback = function() use ($billings, $request) {
                $file = fopen('php://output', 'w');
                fputs($file, "\xEF\xBB\xBF");
                fputcsv($file, [
                    'Sl. No',
                    'Date',
                    'Customer Name',
                    'Customer Email',
                    'Customer Phone',
                    'Service',
                    'Professional Name',
                    'Plan Type',
                    'Received Amount (₹)',
                    'Commission Rate (%)',
                    'Professional Pay (₹)',
                    'Payment Status',
                    'Amount Earned (₹)',
                    'Transaction Number',
                    'Paid Date',
                    'Month'
                ]);
                $totalAmount = 0;
                $totalCommission = 0;
                $totalProfessionalPay = 0;
                
                foreach ($billings as $key => $billing) {
                    $commissionRate = $billing->professional ? ($billing->professional->margin ?? 0) : 0;
                    $professionalPay = $billing->amount * ((100 - $commissionRate) / 100);
                    $amountEarned = $billing->amount * ($commissionRate / 100);
                    
                    $totalAmount += $billing->amount;
                    $totalCommission += $amountEarned;
                    $totalProfessionalPay += $professionalPay;
                    
                    fputcsv($file, [
                        $key + 1,
                        $billing->created_at ? $billing->created_at->format('d M Y') : 'N/A',
                        $billing->customer_name ?? 'N/A',
                        $billing->customer_email ?? 'N/A',
                        $billing->customer_phone ?? 'N/A',
                        $billing->service_name ?? 'N/A',
                        $billing->professional ? ($billing->professional->name ?? 'N/A') : 'N/A',
                        $billing->plan_type ? ucfirst(str_replace('_', ' ', $billing->plan_type)) : 'N/A',
                        number_format($billing->amount ?? 0, 2),
                        $commissionRate,
                        number_format($professionalPay, 2),
                        $billing->payment_status ? ucfirst($billing->payment_status) : 'N/A',
                        number_format($amountEarned, 2),
                        $billing->transaction_number ?? 'N/A',
                        $billing->paid_date ? Carbon::parse($billing->paid_date)->format('d M Y') : 'N/A',
                        $billing->created_at ? $billing->created_at->format('M Y') : 'N/A'
                    ]);
                }
                fputcsv($file, ['']);
                
                fputcsv($file, ['Summary', '', '', '', '', '', '', '', 
                    number_format($totalAmount, 2), 
                    '', 
                    number_format($totalProfessionalPay, 2), 
                    '', 
                    number_format($totalCommission, 2)
                ]);
                fputcsv($file, ['']);
                fputcsv($file, ['Filter Information']);
                
                if ($request->filled('start_date') || $request->filled('end_date')) {
                    fputcsv($file, ['Date Range', 
                        $request->filled('start_date') ? Carbon::parse($request->start_date)->format('d M Y') : 'All time',
                        'to',
                        $request->filled('end_date') ? Carbon::parse($request->end_date)->format('d M Y') : 'Present'
                    ]);
                }
                
                if ($request->filled('plan_type')) {
                    fputcsv($file, ['Plan Type', 
                        ucfirst(str_replace('_', ' ', $request->plan_type))
                    ]);
                }
                
                if ($request->filled('payment_status')) {
                    fputcsv($file, ['Payment Status', 
                        ucfirst($request->payment_status)
                    ]);
                }
                
                if ($request->filled('service')) {
                    fputcsv($file, ['Service', 
                        $request->service
                    ]);
                }
                
                fputcsv($file, ['Generated At', now()->format('d M Y H:i:s')]);
                
                fclose($file);
            };
            
            return response()->stream($callback, 200, $headers);
} catch (\Exception $e) {
            if (config('app.debug')) {
                return response()->json([
                    'error' => $e->getMessage(),
                    'file' => $e->getFile(),
                    'line' => $e->getLine(),
                    'trace' => explode("\n", $e->getTraceAsString())
                ], 500);
            }
            return back()->with('error', 'Failed to generate Excel file. Please try again or contact support.');
        }
    }
    /**
     * Export customer billing data to Excel
     * 
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function exportCustomerBillingToExcel(Request $request)
    {
        try {
            $filename = 'customer_billing_' . date('Y_m_d_His') . '.csv';
            $headers = [
                'Content-Type' => 'text/csv',
                'Content-Disposition' => 'attachment; filename="' . $filename . '"',
                'Pragma' => 'no-cache',
                'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
                'Expires' => '0',
            ];
            $query = \App\Models\Booking::with(['professional', 'user']);
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('customer_name', 'like', "%{$search}%")
                    ->orWhere('customer_email', 'like', "%{$search}%")
                    ->orWhere('customer_phone', 'like', "%{$search}%");
            });
        }

        if ($request->filled(['start_date', 'end_date'])) {
            $startDate = \Carbon\Carbon::parse($request->start_date)->startOfDay();
            $endDate = \Carbon\Carbon::parse($request->end_date)->endOfDay();
            $query->whereBetween('created_at', [$startDate, $endDate]);
        }

        if ($request->filled('plan_type')) {
            $query->where('plan_type', $request->plan_type);
        }

        if ($request->filled('sms_status')) {
            $query->where('sms_status', $request->sms_status);
        }
        if ($request->filled('service')) {
            $query->where('service_name', $request->service);
        }
        $billings = $query->latest()->get();
        $callback = function() use ($billings, $request) {
            $file = fopen('php://output', 'w');
            fputs($file, "\xEF\xBB\xBF");
            fputcsv($file, [
                'Sl. No',
                'Date',
                'Customer Name',
                'Customer Email',
                'Customer Phone',
                'Service Taking',
                'Professional',
                'Type of Plan',
                'Amount (₹)',
                'SMS Status',
                'Month'
            ]);
            $totalAmount = 0;
            
            foreach ($billings as $key => $billing) {
                $totalAmount += $billing->amount;
                
                fputcsv($file, [
                    $key + 1,
                    $billing->created_at ? $billing->created_at->format('d M Y') : 'N/A',
                    $billing->customer_name ?? 'N/A',
                    $billing->customer_email ?? 'N/A',
                    $billing->customer_phone ?? 'N/A',
                    $billing->service_name ?? 'N/A',
                    $billing->professional ? ($billing->professional->name ?? 'N/A') : 'N/A',
                    $billing->plan_type ? ucfirst(str_replace('_', ' ', $billing->plan_type)) : 'N/A',
                    number_format($billing->amount ?? 0, 2),
                    $billing->sms_status ? ucfirst($billing->sms_status) : 'N/A',
                    $billing->created_at ? $billing->created_at->format('M Y') : 'N/A'
                ]);
            }
            fputcsv($file, ['']);
            fputcsv($file, ['Summary', '', '', '', '', '', '', '', number_format($totalAmount, 2)]);
            fputcsv($file, ['']);
            fputcsv($file, ['Filter Information']);
            
            if ($request->filled('start_date') || $request->filled('end_date')) {
                fputcsv($file, ['Date Range', 
                    $request->filled('start_date') ? Carbon::parse($request->start_date)->format('d M Y') : 'All time',
                    'to',
                    $request->filled('end_date') ? Carbon::parse($request->end_date)->format('d M Y') : 'Present'
                ]);
            }
            
            if ($request->filled('plan_type')) {
                fputcsv($file, ['Plan Type', 
                    ucfirst(str_replace('_', ' ', $request->plan_type))
                ]);
            }
            
            if ($request->filled('sms_status')) {
                fputcsv($file, ['SMS Status', 
                    ucfirst($request->sms_status)
                ]);
            }
            
            if ($request->filled('service')) {
                fputcsv($file, ['Service', 
                    $request->service
                ]);
            }
            
            if ($request->filled('search')) {
                fputcsv($file, ['Search Query', $request->search]);
            }
            
            fputcsv($file, ['Generated At', now()->format('d M Y H:i:s')]);
            
            fclose($file);
        };
        
        return response()->stream($callback, 200, $headers);
} catch (\Exception $e) {        
        if (config('app.debug')) {
            return response()->json([
                'error' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => explode("\n", $e->getTraceAsString())
            ], 500);
        }
        return back()->with('error', 'Failed to generate Excel file. Please try again or contact support.');
    }
    }
    
    /**
     * View customer invoice for admin
     */
    public function viewCustomerInvoice($id)
    {
        $booking = Booking::with(['professional.profile', 'customer.customerProfile', 'timedates'])
            ->findOrFail($id);
        $invoice_no = 'TZCUS-' . str_pad($booking->id, 6, '0', STR_PAD_LEFT);
        $invoice_date = $booking->created_at->format('d M Y');
        
        return view('customer.billing.invoice', compact(
            'booking',
            'invoice_no', 
            'invoice_date'
        ));
    }
    
    /**
     * Download customer invoice for admin
     */
    public function downloadCustomerInvoice($id)
    {
        $booking = Booking::with(['professional.profile', 'customer.customerProfile', 'timedates'])
            ->findOrFail($id);
        $invoice_no = 'TZCUS-' . str_pad($booking->id, 6, '0', STR_PAD_LEFT);
        $invoice_date = $booking->created_at->format('d M Y');
        
        $pdf = Pdf::loadView('customer.billing.invoice', compact(
            'booking',
            'invoice_no', 
            'invoice_date'
        ));
        $filename = 'customer_invoice_' . $booking->id . '_' . $booking->created_at->format('Y_m_d') . '.pdf';
        
        return $pdf->download($filename);
    }
    
    /**
     * View professional invoice for admin
     */
    public function viewProfessionalInvoice($id)
    {
        $booking = Booking::with(['customer', 'timedates', 'professional.profile'])
            ->findOrFail($id);
            
        $professional = $booking->professional;
        $marginPercentage = $professional->margin ?? 10; // Default to 10% if no margin set
        $baseAmount = $booking->base_amount ?? ($booking->amount / 1.18);
        $customerGST = $booking->amount - $baseAmount;
        $platformFee = ($baseAmount * $marginPercentage) / 100;
        $platformFeeCGST = $platformFee * 0.09;
        $platformFeeSGST = $platformFee * 0.09;
        $totalPlatformCut = $platformFee + $platformFeeCGST + $platformFeeSGST;
        $professionalEarning = $booking->amount - $totalPlatformCut;
        $invoice_no = 'TZPRO-' . str_pad($booking->id, 6, '0', STR_PAD_LEFT);
        $invoice_date = $booking->created_at->format('d M Y');
        
        return view('professional.billing.invoice', [
            'booking' => $booking,
            'professional' => $professional,
            'invoice_no' => $invoice_no,
            'invoice_date' => $invoice_date,
            'marginPercentage' => $marginPercentage,
            'baseAmount' => $baseAmount,
            'customerAmount' => $booking->amount,
            'customerGST' => $customerGST,
            'platformFee' => $platformFee,
            'platformFeeCGST' => $platformFeeCGST,
            'platformFeeSGST' => $platformFeeSGST,
            'totalPlatformCut' => $totalPlatformCut,
            'professionalEarning' => $professionalEarning
        ]);
    }
    
    /**
     * Download professional invoice for admin
     */
    public function downloadProfessionalInvoice($id)
    {
        $booking = Booking::with(['customer', 'timedates', 'professional.profile'])
            ->findOrFail($id);
            
        $professional = $booking->professional;
        $marginPercentage = $professional->margin ?? 10; // Default to 10% if no margin set
        $baseAmount = $booking->base_amount ?? ($booking->amount / 1.18);
        $customerGST = $booking->amount - $baseAmount;
        $platformFee = ($baseAmount * $marginPercentage) / 100;
        $platformFeeCGST = $platformFee * 0.09;
        $platformFeeSGST = $platformFee * 0.09;
        $totalPlatformCut = $platformFee + $platformFeeCGST + $platformFeeSGST;
        $professionalEarning = $booking->amount - $totalPlatformCut;
        $invoice_no = 'TZPRO-' . str_pad($booking->id, 6, '0', STR_PAD_LEFT);
        $invoice_date = $booking->created_at->format('d M Y');
        
        $pdf = Pdf::loadView('professional.billing.invoice', [
            'booking' => $booking,
            'professional' => $professional,
            'invoice_no' => $invoice_no,
            'invoice_date' => $invoice_date,
            'marginPercentage' => $marginPercentage,
            'baseAmount' => $baseAmount,
            'customerAmount' => $booking->amount,
            'customerGST' => $customerGST,
            'platformFee' => $platformFee,
            'platformFeeCGST' => $platformFeeCGST,
            'platformFeeSGST' => $platformFeeSGST,
            'totalPlatformCut' => $totalPlatformCut,
            'professionalEarning' => $professionalEarning
        ]);
        $filename = 'professional_invoice_' . $booking->id . '_' . $booking->created_at->format('Y_m_d') . '.pdf';
        
        return $pdf->download($filename);
    }
    
    /**
     * Download individual customer invoice as Excel
     */
    public function downloadCustomerInvoiceExcel($id)
    {
        $booking = Booking::with(['professional.profile', 'customer.customerProfile', 'timedates'])
            ->findOrFail($id);
        $invoice_no = 'TZCUS-' . str_pad($booking->id, 6, '0', STR_PAD_LEFT);
        $invoice_date = $booking->created_at->format('d M Y');
        $baseAmount = $booking->base_amount ?? ($booking->amount / 1.18);
        $cgstAmount = $booking->cgst_amount ?? ($baseAmount * 0.09);
        $sgstAmount = $booking->sgst_amount ?? ($baseAmount * 0.09);
        $igstAmount = $booking->igst_amount ?? 0;
        $totalTax = $cgstAmount + $sgstAmount + $igstAmount;
        
        try {
            $filename = 'customer_invoice_' . $booking->id . '_' . $booking->created_at->format('Y_m_d') . '.csv';
            $headers = [
                'Content-Type' => 'text/csv',
                'Content-Disposition' => 'attachment; filename="' . $filename . '"',
                'Pragma' => 'no-cache',
                'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
                'Expires' => '0',
            ];
            $callback = function() use ($booking, $invoice_no, $invoice_date, $baseAmount, $cgstAmount, $sgstAmount, $totalTax) {
                $file = fopen('php://output', 'w');
                fputs($file, "\xEF\xBB\xBF");
                fputcsv($file, ['TAZEN TECHNOLOGIES PRIVATE LIMITED']);
                fputcsv($file, ['TAX INVOICE']);
                fputcsv($file, ['']);
                fputcsv($file, ['Invoice Number', $invoice_no]);
                fputcsv($file, ['Invoice Date', $invoice_date]);
                fputcsv($file, ['Order Number', 'TZ-' . str_pad($booking->id, 8, '0', STR_PAD_LEFT)]);
                fputcsv($file, ['Order Date', $booking->created_at->format('d.m.Y')]);
                fputcsv($file, ['Service Date', \Carbon\Carbon::parse($booking->service_datetime)->format('d/m/Y H:i')]);
                fputcsv($file, ['']);
                fputcsv($file, ['BILLING ADDRESS']);
                fputcsv($file, ['Customer Name', $booking->customer_name]);
                fputcsv($file, ['Email', $booking->customer_email]);
                fputcsv($file, ['Phone', $booking->customer_phone]);
                
                if ($booking->customer && $booking->customer->customerProfile) {
                    $customerProfile = $booking->customer->customerProfile;
                    if ($customerProfile->address) {
                        fputcsv($file, ['Address', $customerProfile->address]);
                    }
                    if ($customerProfile->city) {
                        $cityState = $customerProfile->city;
                        if ($customerProfile->state) $cityState .= ', ' . $customerProfile->state;
                        if ($customerProfile->zip_code) $cityState .= ' - ' . $customerProfile->zip_code;
                        fputcsv($file, ['City/State/PIN', $cityState]);
                    }
                }
                fputcsv($file, ['Country', 'INDIA']);
                fputcsv($file, ['']);
                fputcsv($file, ['SOLD BY']);
                fputcsv($file, ['Professional Name', $booking->professional->name ?? 'Professional Name']);
                if ($booking->professional && $booking->professional->profile) {
                    $profile = $booking->professional->profile;
                    if ($profile->gst_address) {
                        fputcsv($file, ['Address', $profile->gst_address]);
                    } elseif ($profile->address) {
                        fputcsv($file, ['Address', $profile->address]);
                    } elseif ($profile->full_address) {
                        fputcsv($file, ['Address', $profile->full_address]);
                    }
                    if ($profile->state_name) {
                        fputcsv($file, ['State', strtoupper($profile->state_name) . ', INDIA']);
                    }
                    if ($profile->gst_number) {
                        fputcsv($file, ['GST Registration No', strtoupper($profile->gst_number)]);
                    }
                    if ($profile->state_code) {
                        fputcsv($file, ['State/UT Code', $profile->state_code]);
                    }
                }
                fputcsv($file, ['']);
                fputcsv($file, ['SERVICE DETAILS']);
                fputcsv($file, [
                    'Sl. No',
                    'Description',
                    'Unit Price (₹)',
                    'Qty',
                    'Net Amount (₹)',
                    'Tax Rate',
                    'Tax Type',
                    'Total Amount (₹)'
                ]);
                fputcsv($file, [
                    '1',
                    $booking->service_name ?? 'Professional Service',
                    number_format($baseAmount, 2),
                    '1',
                    number_format($baseAmount, 2),
                    '18%',
                    'GST',
                    number_format($booking->amount, 2)
                ]);
                
                fputcsv($file, ['']);
                fputcsv($file, ['TAX BREAKDOWN']);
                fputcsv($file, ['Base Amount', '₹' . number_format($baseAmount, 2)]);
                fputcsv($file, ['CGST (9%)', '₹' . number_format($cgstAmount, 2)]);
                fputcsv($file, ['SGST (9%)', '₹' . number_format($sgstAmount, 2)]);
                fputcsv($file, ['Total Tax', '₹' . number_format($totalTax, 2)]);
                fputcsv($file, ['TOTAL AMOUNT', '₹' . number_format($booking->amount, 2)]);
                fputcsv($file, ['']);
                fputcsv($file, ['PAYMENT INFORMATION']);
                fputcsv($file, ['Transaction ID', $booking->payment_id ?? 'CASH_PAYMENT_' . $booking->id]);
                fputcsv($file, ['Payment Method', $booking->payment_method ?? 'Online Payment']);
                fputcsv($file, ['Payment Date', $booking->created_at->format('d/m/Y, H:i:s')]);
                fputcsv($file, ['Invoice Value', '₹' . number_format($booking->amount, 2)]);
                fputcsv($file, ['']);
                fputcsv($file, ['Amount in Words', ucwords(\App\Helpers\NumberToWords::convert($booking->amount)) . ' Only']);
                fputcsv($file, ['']);
                fputcsv($file, ['Whether tax is payable under reverse charge: NO']);
                fputcsv($file, ['']);
                fputcsv($file, ['This is a computer generated invoice and does not require physical signature.']);
                fputcsv($file, ['For any queries regarding this invoice, please contact us at support@tazen.com']);
                fputcsv($file, ['Thank you for choosing our services!']);
                
                fclose($file);
            };
            
            return response()->stream($callback, 200, $headers);
} catch (\Exception $e) {
            return back()->with('error', 'Failed to generate Excel invoice: ' . $e->getMessage());
        }
    }
    
    /**
     * Download individual professional invoice as Excel
     */
    public function downloadProfessionalInvoiceExcel($id)
    {
        $booking = Booking::with(['customer', 'timedates', 'professional.profile'])
            ->findOrFail($id);
            
        $professional = $booking->professional;
        $marginPercentage = $professional->margin ?? 10;
        $platformFee = $booking->amount * ($marginPercentage / 100);
        $professionalShare = $booking->amount - $platformFee;
        $invoice_no = 'TZPRO-' . str_pad($booking->id, 6, '0', STR_PAD_LEFT);
        $invoice_date = $booking->created_at->format('d M Y');
        $baseCommission = $platformFee / 1.18;
        $cgstAmount = $baseCommission * 0.09;
        $sgstAmount = $baseCommission * 0.09;
        
        try {
            $filename = 'professional_invoice_' . $booking->id . '_' . $booking->created_at->format('Y_m_d') . '.csv';
            $headers = [
                'Content-Type' => 'text/csv',
                'Content-Disposition' => 'attachment; filename="' . $filename . '"',
                'Pragma' => 'no-cache',
                'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
                'Expires' => '0',
            ];
            $callback = function() use ($booking, $professional, $invoice_no, $invoice_date, $platformFee, $marginPercentage, $baseCommission, $cgstAmount, $sgstAmount) {
                $file = fopen('php://output', 'w');
                fputs($file, "\xEF\xBB\xBF");
                fputcsv($file, ['TAZEN TECHNOLOGIES PRIVATE LIMITED']);
                fputcsv($file, ['TAX INVOICE - PLATFORM COMMISSION']);
                fputcsv($file, ['']);
                fputcsv($file, ['Invoice Number', $invoice_no]);
                fputcsv($file, ['Invoice Date', $invoice_date]);
                fputcsv($file, ['Order Number', 'TZ-' . str_pad($booking->id, 8, '0', STR_PAD_LEFT)]);
                fputcsv($file, ['Order Date', $booking->created_at->format('d.m.Y')]);
                fputcsv($file, ['Service Date', \Carbon\Carbon::parse($booking->service_datetime)->format('d/m/Y H:i')]);
                fputcsv($file, ['']);
                fputcsv($file, ['SOLD BY']);
                fputcsv($file, ['Company', 'TAZEN TECHNOLOGIES PRIVATE LIMITED']);
                fputcsv($file, ['Address', '110, Acharya Sisir Kumar Ghosh Street']);
                fputcsv($file, ['City', 'Entally, Kolkata - 700014']);
                fputcsv($file, ['State', 'WEST BENGAL, INDIA']);
                fputcsv($file, ['PAN No', 'AAFCT8462R']);
                fputcsv($file, ['GST Registration No', '19AAFCT8462R1Z5']);
                fputcsv($file, ['State/UT Code', '19']);
                fputcsv($file, ['']);
                fputcsv($file, ['BILLING ADDRESS']);
                fputcsv($file, ['Professional Name', strtoupper($professional->name)]);
                
                if ($professional->profile) {
                    $profile = $professional->profile;
                    if ($profile->gst_address) {
                        fputcsv($file, ['Address', $profile->gst_address]);
                    } elseif ($profile->address) {
                        fputcsv($file, ['Address', $profile->address]);
                    } elseif ($profile->full_address) {
                        fputcsv($file, ['Address', $profile->full_address]);
                    } else {
                        fputcsv($file, ['Email', $professional->email]);
                    }
                    if ($profile->state_name) {
                        fputcsv($file, ['State', strtoupper($profile->state_name) . ', INDIA']);
                    } else {
                        fputcsv($file, ['State', 'INDIA']);
                    }
                    if ($profile->state_code) {
                        fputcsv($file, ['State/UT Code', $profile->state_code]);
                    }
                } else {
                    fputcsv($file, ['Email', $professional->email]);
                    fputcsv($file, ['State', 'INDIA']);
                }
                fputcsv($file, ['']);
                fputcsv($file, ['SERVICE DETAILS']);
                fputcsv($file, [
                    'Sl. No',
                    'Description',
                    'Unit Price (₹)',
                    'Qty',
                    'Net Amount (₹)',
                    'Tax Rate',
                    'Tax Type',
                    'Total Amount (₹)'
                ]);
                fputcsv($file, [
                    '1',
                    'Platform Commission - Service Facilitation Fee (' . $marginPercentage . '%)',
                    number_format($baseCommission, 2),
                    '1',
                    number_format($baseCommission, 2),
                    '18%',
                    'GST',
                    number_format($platformFee, 2)
                ]);
                
                fputcsv($file, ['']);
                fputcsv($file, ['TAX BREAKDOWN']);
                fputcsv($file, ['Base Commission', '₹' . number_format($baseCommission, 2)]);
                fputcsv($file, ['CGST (9%)', '₹' . number_format($cgstAmount, 2)]);
                fputcsv($file, ['SGST (9%)', '₹' . number_format($sgstAmount, 2)]);
                fputcsv($file, ['Total Tax', '₹' . number_format($cgstAmount + $sgstAmount, 2)]);
                fputcsv($file, ['TOTAL COMMISSION', '₹' . number_format($platformFee, 2)]);
                fputcsv($file, ['']);
                fputcsv($file, ['PAYMENT INFORMATION']);
                fputcsv($file, ['Transaction ID', $booking->payment_id ?? 'CASH_PAYMENT_' . $booking->id]);
                fputcsv($file, ['Payment Method', $booking->payment_method ?? 'Online Payment']);
                fputcsv($file, ['Payment Date', $booking->created_at->format('d/m/Y, H:i:s')]);
                fputcsv($file, ['Commission Value', '₹' . number_format($platformFee, 2)]);
                fputcsv($file, ['']);
                fputcsv($file, ['Amount in Words', ucwords(\App\Helpers\NumberToWords::convert($platformFee)) . ' Only']);
                fputcsv($file, ['']);
                fputcsv($file, ['Whether tax is payable under reverse charge: NO']);
                fputcsv($file, ['']);
                fputcsv($file, ['This is a computer generated invoice and does not require physical signature.']);
                fputcsv($file, ['For any queries regarding this invoice, please contact us at support@tazen.com']);
                fputcsv($file, ['Thank you for choosing our services!']);
                
                fclose($file);
            };
            
            return response()->stream($callback, 200, $headers);
} catch (\Exception $e) {
            return back()->with('error', 'Failed to generate Excel invoice: ' . $e->getMessage());
        }
    }
}