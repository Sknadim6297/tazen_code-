<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Professional;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use Exception;
use Illuminate\Support\Facades\Log;

class ReportController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    /**
     * Display the booking summary report page
     */
    public function bookingSummaryReport()
    {
        return view('admin.reports.booking-summary');
    }

    /**
     * Generate booking summary report in CSV format (Excel alternative)
     */
    public function exportBookingSummaryExcel(Request $request)
    {
        $request->validate([
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'professional_id' => 'nullable|exists:professionals,id',
            'plan_type' => 'nullable|in:one_time,monthly,quarterly,free_hand'
        ]);

        try {
            $query = $this->getBookingQuery($request);
            $bookings = $query->get();

            $filename = 'booking_summary_report_' . now()->format('Y_m_d_His') . '.csv';
            $csvData = $this->generateBookingSummaryCSV($bookings);
            $headers = [
                'Content-Type' => 'text/csv',
                'Content-Disposition' => 'attachment; filename="' . $filename . '"',
                'Cache-Control' => 'max-age=0',
            ];
            
            return response($csvData, 200, $headers);
} catch (Exception $e) {
            Log::error('CSV export failed: ' . $e->getMessage());
            return back()->with('error', 'Failed to generate CSV file. Please try again.');
        }
    }

    /**
     * Generate booking summary report in PDF format
     */
    public function exportBookingSummaryPdf(Request $request)
    {
        $request->validate([
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'professional_id' => 'nullable|exists:professionals,id',
            'plan_type' => 'nullable|in:one_time,monthly,quarterly,free_hand'
        ]);

        $query = $this->getBookingQuery($request);
        $bookings = $query->get();
        $filterInfo = [
            'start_date' => $request->start_date ? Carbon::parse($request->start_date)->format('d M Y') : 'All time',
            'end_date' => $request->end_date ? Carbon::parse($request->end_date)->format('d M Y') : 'Present',
            'professional_name' => $request->professional_id ? 
                Professional::find($request->professional_id)->name : 'All Professionals',
            'plan_type' => $request->plan_type ? 
                ucwords(str_replace('_', ' ', $request->plan_type)) : 'All Plans'
        ];

        $pdf = PDF::loadView('admin.reports.booking-summary-pdf', [
            'bookings' => $bookings,
            'filterInfo' => $filterInfo,
            'generatedDate' => now()->format('d M Y H:i:s')
        ]);

        $pdf->setPaper('a4', 'landscape');

        $filename = 'booking_summary_report_' . now()->format('Y_m_d_His') . '.pdf';
        
        return $pdf->download($filename);
    }

    /**
     * Get filtered booking query
     */
    private function getBookingQuery(Request $request)
    {
        $query = Booking::with(['professional'])
            ->where('payment_status', 'paid')
            ->orderBy('created_at', 'desc');
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('created_at', [
                Carbon::parse($request->start_date)->startOfDay(),
                Carbon::parse($request->end_date)->endOfDay()
            ]);
        } elseif ($request->filled('start_date')) {
            $query->where('created_at', '>=', Carbon::parse($request->start_date)->startOfDay());
        } elseif ($request->filled('end_date')) {
            $query->where('created_at', '<=', Carbon::parse($request->end_date)->endOfDay());
        }
        if ($request->filled('professional_id')) {
            $query->where('professional_id', $request->professional_id);
        }
        if ($request->filled('plan_type')) {
            $query->where('plan_type', $request->plan_type);
        }

        return $query;
    }

    /**
     * Get professionals for filter dropdown
     */
    public function getProfessionals()
    {
        $professionals = Professional::select('id', 'name')
            ->where('status', 'approved')
            ->orderBy('name')
            ->get();

        return response()->json($professionals);
    }

    /**
     * Generate CSV content for booking summary
     */
    private function generateBookingSummaryCSV($bookings)
    {
        $csvData = [];
        $csvData[] = [
            'Professional Name',
            'Customer Invoice No',
            'Customer Invoice Date', 
            'Customer Basic Amount',
            'Customer GST Total',
            'Platform Invoice No',
            'Platform Invoice Date',
            'Platform Basic Amount', 
            'Platform GST Total',
            'TCS Basic Amount',
            'TCS CGST',
            'TCS SGST', 
            'TCS Total',
            'Professional Basic Amount',
            'Professional CGST',
            'Professional SGST',
            'Professional Total Amount'
        ];
        foreach ($bookings as $booking) {
            $customerBasicAmount = floatval($booking->base_amount ?? 0);
            $customerCGST = floatval($booking->cgst_amount ?? 0);
            $customerSGST = floatval($booking->sgst_amount ?? 0);
            $customerIGST = floatval($booking->igst_amount ?? 0);
            $customerGSTTotal = $customerCGST + $customerSGST + $customerIGST;
            $platformCommissionRate = 0.20;
            $platformBasicAmount = $customerBasicAmount * $platformCommissionRate;
            $platformCGST = $platformBasicAmount * 0.09; // 9% CGST
            $platformSGST = $platformBasicAmount * 0.09; // 9% SGST
            $platformGSTTotal = $platformCGST + $platformSGST;
            $netSupply = $customerBasicAmount - $platformBasicAmount;
            $tcsBasicAmount = $netSupply * 0.01;
            $tcsCGST = $tcsBasicAmount * 0.09;
            $tcsSGST = $tcsBasicAmount * 0.09;
            $tcsTotal = $tcsBasicAmount + $tcsCGST + $tcsSGST;
            $professionalBasicAmount = $customerBasicAmount - $platformBasicAmount - $tcsBasicAmount;
            $professionalCGST = $customerCGST - $platformCGST - $tcsCGST;
            $professionalSGST = $customerSGST - $platformSGST - $tcsSGST;
            $professionalTotal = $professionalBasicAmount + $professionalCGST + $professionalSGST;
            
            $csvData[] = [
                $booking->professional->name ?? 'N/A',
                'INV-' . str_pad($booking->id, 6, '0', STR_PAD_LEFT), // Invoice No
                $booking->created_at ? $booking->created_at->format('d/m/Y') : '', // Date
                number_format($customerBasicAmount, 2), // Basic Amount
                number_format($customerGSTTotal, 2), // GST Total
                'PLT-' . str_pad($booking->id, 6, '0', STR_PAD_LEFT), // Invoice No
                $booking->created_at ? $booking->created_at->format('d/m/Y') : '', // Date
                number_format($platformBasicAmount, 2), // Basic Amount
                number_format($platformGSTTotal, 2), // GST Total
                number_format($tcsBasicAmount, 2), // Basic Amount
                number_format($tcsCGST, 2), // CGST
                number_format($tcsSGST, 2), // SGST
                number_format($tcsTotal, 2), // Total TCS
                number_format($professionalBasicAmount, 2), // Basic Amount
                number_format($professionalCGST, 2), // CGST
                number_format($professionalSGST, 2), // SGST
                number_format($professionalTotal, 2), // Total Amount
            ];
        }
        $output = fopen('php://temp', 'r+');
        foreach ($csvData as $row) {
            fputcsv($output, $row);
        }
        rewind($output);
        $csvContent = stream_get_contents($output);
        fclose($output);
        
        return $csvContent;
    }
}
