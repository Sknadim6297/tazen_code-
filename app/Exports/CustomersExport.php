<?php

namespace App\Exports;

use App\Models\User;
use App\Models\CustomerProfile;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use Illuminate\Http\Request;

class CustomersExport implements FromCollection, WithHeadings, WithMapping, WithStyles, ShouldAutoSize
{
    protected $request;

    public function __construct(Request $request = null)
    {
        $this->request = $request;
    }

    /**
     * Get the collection of customers to export
     */
    public function collection()
    {
        $query = User::query();
        
        if ($this->request) {
            $this->applyFilters($query);
        }
        
        return $query->orderBy('created_at', 'desc')->get();
    }

    /**
     * Apply filters from request
     */
    protected function applyFilters($query)
    {
        if ($this->request->filled('search')) {
            $search = $this->request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                    ->orWhere('email', 'like', '%' . $search . '%');
            });
        }

        if ($this->request->filled('start_date') && $this->request->filled('end_date')) {
            $startDate = \Carbon\Carbon::parse($this->request->start_date)->startOfDay();
            $endDate = \Carbon\Carbon::parse($this->request->end_date)->endOfDay();
            $query->whereBetween('created_at', [$startDate, $endDate]);
        }
    }

    /**
     * Define the headings for the Excel file
     */
    public function headings(): array
    {
        return [
            'ID',
            'Name',
            'Email',
            'Phone',
            'Email Verified',
            'Email Verified At',
            'Registration Date',
            'Last Login',
            'Status',
            'Gender',
            'Date of Birth',
            'Address',
            'City',
            'State',
            'Country',
            'Profile Completed'
        ];
    }

    /**
     * Map the data for each row
     */
    public function map($user): array
    {
        // Get customer profile if exists
        $customerProfile = CustomerProfile::where('user_id', $user->id)->first();
        
        return [
            $user->id,
            $user->name,
            $user->email,
            $user->phone ?? 'N/A',
            $user->email_verified_at ? 'Yes' : 'No',
            $user->email_verified_at ? $user->email_verified_at->format('Y-m-d H:i:s') : 'Not Verified',
            $user->created_at->format('Y-m-d H:i:s'),
            $user->last_login_at ? $user->last_login_at->format('Y-m-d H:i:s') : 'Never',
            $user->is_active ? 'Active' : 'Inactive',
            $customerProfile ? ($customerProfile->gender ?? 'N/A') : 'N/A',
            $customerProfile ? ($customerProfile->dob ?? 'N/A') : 'N/A',
            $customerProfile ? ($customerProfile->address ?? 'N/A') : 'N/A',
            $customerProfile ? ($customerProfile->city ?? 'N/A') : 'N/A',
            $customerProfile ? ($customerProfile->state ?? 'N/A') : 'N/A',
            $customerProfile ? ($customerProfile->country ?? 'N/A') : 'N/A',
            $customerProfile ? 'Yes' : 'No'
        ];
    }

    /**
     * Apply styles to the worksheet
     */
    public function styles(Worksheet $sheet)
    {
        // Style the header row
        $sheet->getStyle('A1:P1')->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['rgb' => 'FFFFFF'],
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => '4472C4'],
            ],
        ]);

        // Auto-fit columns
        foreach (range('A', 'P') as $column) {
            $sheet->getColumnDimension($column)->setAutoSize(true);
        }

        return [];
    }
}