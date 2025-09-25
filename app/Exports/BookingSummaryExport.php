<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;

class BookingSummaryExport implements FromArray, WithHeadings, ShouldAutoSize, WithStyles, WithTitle, WithCustomStartCell
{
    protected $bookings;
    
    public function __construct($bookings)
    {
        $this->bookings = $bookings;
    }

    public function array(): array
    {
        $data = [];
        
        foreach ($this->bookings as $booking) {
            // Calculate customer bill (what customer pays) - same as PDF
            $customerBasicAmount = floatval($booking->base_amount ?? 0);
            $customerCGST = floatval($booking->cgst_amount ?? 0);
            $customerSGST = floatval($booking->sgst_amount ?? 0);
            $customerIGST = floatval($booking->igst_amount ?? 0);
            $customerGSTTotal = $customerCGST + $customerSGST + $customerIGST;

            // Calculate platform commission (20% of base amount) - same as PDF
            $platformCommissionRate = 0.20;
            $platformBasicAmount = $customerBasicAmount * $platformCommissionRate;
            $platformCGST = $platformBasicAmount * 0.09; // 9% CGST
            $platformSGST = $platformBasicAmount * 0.09; // 9% SGST
            $platformGSTTotal = $platformCGST + $platformSGST;

            // Calculate TCS @1% on net supply - same as PDF
            $netSupply = $customerBasicAmount - $platformBasicAmount;
            $tcsBasicAmount = $netSupply * 0.01;
            $tcsCGST = $tcsBasicAmount * 0.09;
            $tcsSGST = $tcsBasicAmount * 0.09;
            $tcsTotal = $tcsBasicAmount + $tcsCGST + $tcsSGST;

            // Calculate amount to be paid to professional - same as PDF
            $professionalBasicAmount = $customerBasicAmount - $platformBasicAmount - $tcsBasicAmount;
            $professionalCGST = $customerCGST - $platformCGST - $tcsCGST;
            $professionalSGST = $customerSGST - $platformSGST - $tcsSGST;
            $professionalTotal = $professionalBasicAmount + $professionalCGST + $professionalSGST;
            
            $data[] = [
                // Professional Name
                $booking->professional->name ?? 'N/A',
                
                // Bill to the Customers (4 columns)
                'INV-' . str_pad($booking->id, 6, '0', STR_PAD_LEFT), // Invoice No
                $booking->created_at ? $booking->created_at->format('d/m/Y') : '', // Date
                number_format($customerBasicAmount, 2), // Basic Amount
                number_format($customerGSTTotal, 2), // GST Total
                
                // Bill to the Professional by platform (4 columns)
                'PLT-' . str_pad($booking->id, 6, '0', STR_PAD_LEFT), // Invoice No
                $booking->created_at ? $booking->created_at->format('d/m/Y') : '', // Date
                number_format($platformBasicAmount, 2), // Basic Amount
                number_format($platformGSTTotal, 2), // GST Total
                
                // TCS to be collected (4 columns)
                number_format($tcsBasicAmount, 2), // Basic Amount
                number_format($tcsCGST, 2), // CGST
                number_format($tcsSGST, 2), // SGST
                number_format($tcsTotal, 2), // Total TCS
                
                // Amount to be paid to Professional (4 columns)
                number_format($professionalBasicAmount, 2), // Basic Amount
                number_format($professionalCGST, 2), // CGST
                number_format($professionalSGST, 2), // SGST
                number_format($professionalTotal, 2), // Total Amount
            ];
        }
        
        return $data;
    }

    public function headings(): array
    {
        return [
            'Professional Name',
            
            // Bill to the Customers (4 columns)
            'Customer Invoice No',
            'Customer Invoice Date', 
            'Customer Basic Amount',
            'Customer GST Total',
            
            // Bill to the Professional by platform (4 columns)
            'Platform Invoice No',
            'Platform Invoice Date',
            'Platform Basic Amount', 
            'Platform GST Total',
            
            // TCS to be collected (4 columns)
            'TCS Basic Amount',
            'TCS CGST',
            'TCS SGST', 
            'TCS Total',
            
            // Amount to be paid to Professional (4 columns)
            'Professional Basic Amount',
            'Professional CGST',
            'Professional SGST',
            'Professional Total Amount'
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // Add the main group headers in row 1
        $sheet->setCellValue('A1', 'Professional Name');
        $sheet->setCellValue('B1', 'Bill to the Customers');
        $sheet->setCellValue('F1', 'Bill to the Professional by platform for our services');
        $sheet->setCellValue('J1', 'TCS to be collected @1% on the net supply');
        $sheet->setCellValue('N1', 'Amount to be paid to the Professional');
        
        // Merge cells for group headers
        $sheet->mergeCells('A1:A2'); // Professional name spans 2 rows
        $sheet->mergeCells('B1:E1'); // Bill to Customers
        $sheet->mergeCells('F1:I1'); // Bill to Platform
        $sheet->mergeCells('J1:M1'); // TCS
        $sheet->mergeCells('N1:Q1'); // Professional Amount
        
        // Add sub-headers in row 2
        $sheet->setCellValue('B2', 'Invoice No');
        $sheet->setCellValue('C2', 'Date');
        $sheet->setCellValue('D2', 'Basic Amount');
        $sheet->setCellValue('E2', 'GST Total');
        
        $sheet->setCellValue('F2', 'Invoice No');
        $sheet->setCellValue('G2', 'Date');
        $sheet->setCellValue('H2', 'Basic Amount');
        $sheet->setCellValue('I2', 'GST Total');
        
        $sheet->setCellValue('J2', 'Basic Amount');
        $sheet->setCellValue('K2', 'CGST');
        $sheet->setCellValue('L2', 'SGST');
        $sheet->setCellValue('M2', 'Total TCS');
        
        $sheet->setCellValue('N2', 'Basic Amount');
        $sheet->setCellValue('O2', 'CGST');
        $sheet->setCellValue('P2', 'SGST');
        $sheet->setCellValue('Q2', 'Total Amount');

        return [
            // Style the main header row
            1 => [
                'font' => ['bold' => true, 'size' => 11],
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER],
                'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]],
                'fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'color' => ['rgb' => '4CAF50']]
            ],
            // Style the sub-header row
            2 => [
                'font' => ['bold' => true, 'size' => 9],
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER],
                'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]],
                'fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'color' => ['rgb' => 'E3F2FD']]
            ]
        ];
    }

    public function title(): string
    {
        return 'Professional Billing Report';
    }

    public function startCell(): string
    {
        return 'A3'; // Start data from row 3, leaving space for headers
    }
}
