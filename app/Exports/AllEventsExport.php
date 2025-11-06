<?php

namespace App\Exports;

use App\Models\AllEvent;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class AllEventsExport implements FromCollection, WithHeadings, WithMapping, WithStyles, ShouldAutoSize
{
    protected $filters;

    public function __construct($filters = [])
    {
        $this->filters = $filters;
    }

    public function collection()
    {
        $query = AllEvent::with(['professional.professionalServices.service', 'approvedBy']);

        // Apply filters
        if (isset($this->filters['filter']) && $this->filters['filter']) {
            switch ($this->filters['filter']) {
                case 'admin':
                    $query->where('created_by_type', 'admin');
                    break;
                case 'professional':
                    $query->where('created_by_type', 'professional');
                    break;
            }
        }

        if (isset($this->filters['status']) && $this->filters['status']) {
            $query->where('status', $this->filters['status']);
        }

        if (isset($this->filters['from_date']) && $this->filters['from_date']) {
            $query->whereDate('date', '>=', $this->filters['from_date']);
        }

        if (isset($this->filters['to_date']) && $this->filters['to_date']) {
            $query->whereDate('date', '<=', $this->filters['to_date']);
        }

        if (isset($this->filters['search']) && $this->filters['search']) {
            $search = $this->filters['search'];
            $query->where(function($q) use ($search) {
                $q->where('heading', 'like', "%{$search}%")
                  ->orWhere('mini_heading', 'like', "%{$search}%")
                  ->orWhere('short_description', 'like', "%{$search}%")
                  ->orWhereHas('professional', function($q) use ($search) {
                      $q->where('name', 'like', "%{$search}%");
                  });
            });
        }

        return $query->orderBy('created_at', 'desc')->get();
    }

    public function headings(): array
    {
        return [
            'Event ID',
            'Event Name',
            'Type',
            'Event Date',
            'Description',
            'Starting Fees',
            'Created By',
            'Professional Name',
            'Professional Email',
            'Service Offered',
            'Service Category',
            'Status',
            'Meet Link',
            'Approved By',
            'Approved At',
            'Admin Notes',
            'Created At',
            'Updated At'
        ];
    }

    public function map($event): array
    {
        // Get professional service if exists
        $professionalService = null;
        $serviceName = 'N/A';
        $serviceCategory = 'N/A';
        
        if ($event->isProfessionalEvent() && $event->professional) {
            $professionalService = $event->professional->professionalServices->first();
            if ($professionalService) {
                $serviceName = $professionalService->service_name ?? $professionalService->service->name ?? 'N/A';
                $serviceCategory = $professionalService->category ?? 'N/A';
            }
        }
        
        return [
            $event->id,
            $event->heading ?? 'N/A',
            $event->mini_heading ?? 'N/A',
            $event->date ? date('M d, Y', strtotime($event->date)) : 'N/A',
            $event->short_description ?? 'N/A',
            $event->starting_fees ? '₹' . number_format($event->starting_fees, 2) : 'N/A',
            ucfirst($event->created_by_type),
            $event->professional ? $event->professional->name : 'Admin',
            $event->professional ? $event->professional->email : 'N/A',
            $serviceName,
            $serviceCategory,
            ucfirst($event->status),
            $event->meet_link ?? 'N/A',
            $event->approvedBy ? $event->approvedBy->name : 'N/A',
            $event->approved_at ? date('M d, Y h:i A', strtotime($event->approved_at)) : 'N/A',
            $event->admin_notes ?? 'N/A',
            date('M d, Y h:i A', strtotime($event->created_at)),
            date('M d, Y h:i A', strtotime($event->updated_at))
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Style the first row (header row)
            1 => [
                'font' => [
                    'bold' => true,
                    'color' => ['rgb' => 'FFFFFF'],
                    'size' => 12,
                ],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['rgb' => '667eea'],
                ],
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                ],
            ],
        ];
    }
}
