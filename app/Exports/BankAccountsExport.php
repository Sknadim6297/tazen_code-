<?php

namespace App\Exports;

use App\Models\Profile;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class BankAccountsExport implements FromCollection, WithHeadings, WithMapping, WithStyles, ShouldAutoSize
{
    protected $filters;

    public function __construct($filters = [])
    {
        $this->filters = $filters;
    }

    public function collection()
    {
        $query = Profile::with('professional')
            ->whereNotNull('bank_name')
            ->whereNotNull('account_number')
            ->whereNotNull('ifsc_code');

        // Apply filters
        if (isset($this->filters['professional_status']) && $this->filters['professional_status']) {
            $query->whereHas('professional', function ($q) {
                $q->where('status', $this->filters['professional_status']);
            });
        }

        if (isset($this->filters['account_type']) && $this->filters['account_type']) {
            $query->where('account_type', $this->filters['account_type']);
        }

        if (isset($this->filters['verification_status']) && $this->filters['verification_status']) {
            if ($this->filters['verification_status'] === 'verified') {
                $query->whereNotNull('bank_document');
            } elseif ($this->filters['verification_status'] === 'pending') {
                $query->whereNull('bank_document');
            }
        }

        if (isset($this->filters['search']) && $this->filters['search']) {
            $search = $this->filters['search'];
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

        return $query->orderBy('created_at', 'desc')->get();
    }

    public function headings(): array
    {
        return [
            'Professional Name',
            'Professional Email',
            'Professional Phone',
            'Professional Status',
            'Account Holder Name',
            'Bank Name',
            'Branch Name',
            'Account Number',
            'IFSC Code',
            'Account Type',
            'Verification Status',
            'Bank Document',
            'Created Date',
            'Updated Date'
        ];
    }

    public function map($profile): array
    {
        return [
            $profile->professional->name ?? 'N/A',
            $profile->professional->email ?? 'N/A',
            $profile->professional->phone ?? 'N/A',
            ucfirst($profile->professional->status ?? 'pending'),
            $profile->account_holder_name ?? 'N/A',
            $profile->bank_name ?? 'N/A',
            $profile->bank_branch ?? 'N/A',
            $profile->account_number ?? 'N/A',
            $profile->ifsc_code ?? 'N/A',
            ucfirst($profile->account_type ?? 'savings'),
            $profile->bank_document ? 'Verified' : 'Pending',
            $profile->bank_document ? 'Available' : 'Not Available',
            $profile->created_at ? $profile->created_at->format('Y-m-d H:i:s') : 'N/A',
            $profile->updated_at ? $profile->updated_at->format('Y-m-d H:i:s') : 'N/A'
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Style the first row as bold text
            1 => ['font' => ['bold' => true]],
            
            // Style the header row with background color
            'A1:N1' => [
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => [
                        'argb' => 'FF4472C4',
                    ],
                ],
                'font' => [
                    'color' => ['argb' => 'FFFFFFFF'],
                    'bold' => true,
                ],
            ],
        ];
    }
}