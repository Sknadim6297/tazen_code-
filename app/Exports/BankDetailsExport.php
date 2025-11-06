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
use PhpOffice\PhpSpreadsheet\Style\Fill;

class BankDetailsExport implements FromArray, WithHeadings, ShouldAutoSize, WithStyles, WithTitle, WithCustomStartCell
{
    protected $profiles;
    
    public function __construct($profiles)
    {
        $this->profiles = $profiles;
    }

    public function array(): array
    {
        $data = [];
        
        foreach ($this->profiles as $profile) {
            $data[] = [
                'Professional Name' => $profile->professional->name ?? 'N/A',
                'Email' => $profile->email ?? 'N/A',
                'Phone' => $profile->phone ?? 'N/A',
                'Account Holder Name' => $profile->account_holder_name ?? 'Not provided',
                'Bank Name' => $profile->bank_name ?? 'Not provided',
                'Account Number' => $profile->account_number ?? 'Not provided',
                'IFSC Code' => $profile->ifsc_code ?? 'Not provided',
                'Account Type' => ucfirst($profile->account_type ?? 'Not specified'),
                'Branch' => $profile->bank_branch ?? 'Not provided',
                'GST Number' => $profile->gst_number ?? 'N/A',
                'Status' => $profile->professional->status ?? 'N/A',
                'Registration Date' => $profile->created_at ? $profile->created_at->format('Y-m-d') : 'N/A',
                'Last Updated' => $profile->updated_at ? $profile->updated_at->format('Y-m-d H:i:s') : 'N/A',
            ];
        }
        
        return $data;
    }

    public function headings(): array
    {
        return [
            'Professional Name',
            'Email',
            'Phone',
            'Account Holder Name',
            'Bank Name',
            'Account Number',
            'IFSC Code',
            'Account Type',
            'Branch',
            'GST Number',
            'Status',
            'Registration Date',
            'Last Updated'
        ];
    }

    public function startCell(): string
    {
        return 'A3';
    }

    public function title(): string
    {
        return 'Professional Bank Details';
    }

    public function styles(Worksheet $sheet)
    {
        // Title styling
        $sheet->setCellValue('A1', 'PROFESSIONAL BANK ACCOUNT DETAILS REPORT');
        $sheet->setCellValue('A2', 'Generated on: ' . now()->format('Y-m-d H:i:s'));
        
        $sheet->mergeCells('A1:M1');
        $sheet->mergeCells('A2:M2');
        
        return [
            // Title row styling
            'A1' => [
                'font' => [
                    'bold' => true,
                    'size' => 16,
                    'color' => ['rgb' => 'FFFFFF']
                ],
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'startColor' => ['rgb' => '4F46E5']
                ],
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                    'vertical' => Alignment::VERTICAL_CENTER,
                ]
            ],
            
            // Subtitle row styling
            'A2' => [
                'font' => [
                    'bold' => true,
                    'size' => 12,
                    'color' => ['rgb' => 'FFFFFF']
                ],
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'startColor' => ['rgb' => '6366F1']
                ],
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                    'vertical' => Alignment::VERTICAL_CENTER,
                ]
            ],
            
            // Headers styling
            3 => [
                'font' => [
                    'bold' => true,
                    'color' => ['rgb' => 'FFFFFF']
                ],
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'startColor' => ['rgb' => '374151']
                ],
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                    'vertical' => Alignment::VERTICAL_CENTER,
                ]
            ],
            
            // All cells border
            'A1:M' . (count($this->profiles) + 3) => [
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => Border::BORDER_THIN,
                        'color' => ['rgb' => 'D1D5DB']
                    ]
                ]
            ],
            
            // Data rows alignment
            'A4:M' . (count($this->profiles) + 3) => [
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_LEFT,
                    'vertical' => Alignment::VERTICAL_CENTER,
                    'wrapText' => true
                ]
            ]
        ];
    }
}