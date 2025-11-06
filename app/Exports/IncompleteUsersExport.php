<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use Illuminate\Http\Request;

class IncompleteUsersExport implements FromCollection, WithHeadings, WithMapping, WithStyles, ShouldAutoSize
{
    protected $request;

    public function __construct(Request $request = null)
    {
        $this->request = $request;
    }

    /**
     * Get the collection of users to export
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
            'Registration Completed',
            'Password Set',
            'Registration Date',
            'Email Verified Date',
            'Password Set Date',
            'Status'
        ];
    }

    /**
     * Map the data for each row
     */
    public function map($user): array
    {
        $status = 'Incomplete';
        if ($user->registration_completed) {
            $status = 'Completed';
        } elseif ($user->email_verified) {
            $status = 'Email Verified - Password Pending';
        } else {
            $status = 'Email Not Verified';
        }

        return [
            $user->id,
            $user->name,
            $user->email,
            $user->phone ?? 'N/A',
            $user->email_verified ? 'Yes' : 'No',
            $user->registration_completed ? 'Yes' : 'No',
            $user->password ? 'Yes' : 'No',
            $user->created_at ? $user->created_at->format('Y-m-d H:i:s') : 'N/A',
            $user->email_verified_at ? $user->email_verified_at->format('Y-m-d H:i:s') : 'N/A',
            $user->password_set_at ? $user->password_set_at->format('Y-m-d H:i:s') : 'N/A',
            $status
        ];
    }

    /**
     * Apply styling to the worksheet
     */
    public function styles(Worksheet $sheet)
    {
        return [
            // Style the header row
            1 => [
                'font' => [
                    'bold' => true,
                    'color' => ['argb' => Color::COLOR_WHITE],
                ],
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'startColor' => ['argb' => '2c3e50'],
                ],
            ],
        ];
    }

    /**
     * Apply filters based on request parameters
     */
    private function applyFilters($query)
    {
        if ($this->request->filled('registration_status')) {
            switch ($this->request->registration_status) {
                case 'completed':
                    $query->where('registration_completed', true);
                    break;
                case 'incomplete':
                    $query->where('registration_completed', false);
                    break;
                case 'email_verified':
                    $query->where('email_verified', true);
                    break;
                case 'email_not_verified':
                    $query->where('email_verified', false);
                    break;
            }
        }

        if ($this->request->filled('search')) {
            $search = $this->request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        if ($this->request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $this->request->date_from);
        }

        if ($this->request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $this->request->date_to);
        }
    }
}