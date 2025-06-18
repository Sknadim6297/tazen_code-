<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EventBooking;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;
use Illuminate\Http\Request;
use Carbon\Carbon;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $statusList = EventBooking::select('payment_status')->distinct()->pluck('payment_status');
        // Get event modes (online/offline)
        $eventModes = EventBooking::select('type')->distinct()->pluck('type');

        $query = EventBooking::with(['user', 'event']);

        if ($request->filled('search')) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%');
            })->orWhereHas('event', function ($q) use ($request) {
                $q->where('heading', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->filled('status')) {
            $query->where('payment_status', $request->status);
        }
        
        // Add event mode filter
        if ($request->filled('event_mode')) {
            $query->where('type', $request->event_mode);
        }
        
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('event_date', [$request->start_date, $request->end_date]);
        }
        
        $bookings = $query->latest()->get();

        return view('admin.event.index', compact('bookings', 'statusList', 'eventModes'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Export event bookings to PDF
     * 
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function exportEventBookingsToPdf(Request $request)
    {
        // Build query with filters
        $query = EventBooking::with(['user', 'event']);

        if ($request->filled('search')) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%');
            })->orWhereHas('event', function ($q) use ($request) {
                $q->where('heading', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->filled('status')) {
            $query->where('payment_status', $request->status);
        }
        
        // Add event mode filter for PDF export
        if ($request->filled('event_mode')) {
            $query->where('type', $request->event_mode);
        }
        
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('event_date', [$request->start_date, $request->end_date]);
        }
        
        // Get all records without pagination for PDF
        $bookings = $query->latest()->get();
        
        // Calculate summary statistics
        $totalBookings = $bookings->count();
        $totalAmount = $bookings->sum('total_price');
        $statusCounts = $bookings->groupBy('payment_status')
            ->map(function($group) {
                return $group->count();
            });
        
        // Add filter information to pass to the view
        $filterInfo = [
            'start_date' => $request->filled('start_date') ? Carbon::parse($request->start_date)->format('d M Y') : 'All time',
            'end_date' => $request->filled('end_date') ? Carbon::parse($request->end_date)->format('d M Y') : 'Present',
            'status' => $request->filled('status') ? ucfirst($request->status) : 'All statuses',
            'event_mode' => $request->filled('event_mode') ? ucfirst($request->event_mode) : 'All modes',
            'search' => $request->filled('search') ? $request->search : 'None',
            'generated_at' => Carbon::now()->format('d M Y H:i:s'),
        ];
        
        // Generate PDF
        $pdf = FacadePdf::loadView('admin.event.event-bookings-pdf', compact(
            'bookings', 
            'totalBookings', 
            'totalAmount',
            'statusCounts',
            'filterInfo'
        ));
        
        // Set PDF options
        $pdf->setPaper('a4', 'landscape');
        
        // Generate filename with date
        $filename = 'event_bookings_' . Carbon::now()->format('Y_m_d_His') . '.pdf';
        
        // Return download response
        return $pdf->download($filename);
    }

    /**
     * Export event bookings to Excel using PhpSpreadsheet
     * 
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function exportEventBookingsToExcel(Request $request)
    {
        try {
            // Build query with same filters as PDF export
            $query = EventBooking::with(['user', 'event']);

            if ($request->filled('search')) {
                $query->whereHas('user', function ($q) use ($request) {
                    $q->where('name', 'like', '%' . $request->search . '%');
                })->orWhereHas('event', function ($q) use ($request) {
                    $q->where('heading', 'like', '%' . $request->search . '%');
                });
            }

            if ($request->filled('status')) {
                $query->where('payment_status', $request->status);
            }
            
            // Add event mode filter for Excel export
            if ($request->filled('event_mode')) {
                $query->where('type', $request->event_mode);
            }
            
            if ($request->filled('start_date') && $request->filled('end_date')) {
                $query->whereBetween('event_date', [$request->start_date, $request->end_date]);
            }
            
            $bookings = $query->latest()->get();

            // Create new Spreadsheet object
            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();
            
            // Set document properties
            $spreadsheet->getProperties()
                ->setCreator('Tazen')
                ->setLastModifiedBy('Tazen Admin')
                ->setTitle('Event Bookings Report')
                ->setSubject('Event Bookings')
                ->setDescription('Event bookings export generated on ' . date('Y-m-d H:i:s'));
            
            // Add header row
            $headers = ['Sl.No', 'Customer Name', 'Event Name', 'Event Date', 'Location', 
                       'Type (Online/Offline)', 'Persons', 'Phone', 'Price', 'Total Price', 
                       'Google Meet Link', 'Payment Status', 'Order ID', 'Payment Date'];
            
            $sheet->fromArray($headers, NULL, 'A1');
            
            // Style header row
            $headerStyle = [
                'font' => [
                    'bold' => true,
                    'color' => ['rgb' => '000000'],
                ],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => [
                        'rgb' => 'E4E4E4',
                    ],
                ],
            ];
            $sheet->getStyle('A1:N1')->applyFromArray($headerStyle);
            
            // Add data rows
            $row = 2;
            foreach ($bookings as $index => $booking) {
                $sheet->setCellValue('A' . $row, $index + 1);
                $sheet->setCellValue('B' . $row, $booking->user->name ?? 'N/A');
                $sheet->setCellValue('C' . $row, $booking->event->heading ?? 'N/A');
                $sheet->setCellValue('D' . $row, $booking->event_date);
                $sheet->setCellValue('E' . $row, $booking->location ?? 'N/A');
                $sheet->setCellValue('F' . $row, ucfirst($booking->type ?? 'N/A'));
                $sheet->setCellValue('G' . $row, $booking->persons ?? 'N/A');
                $sheet->setCellValue('H' . $row, $booking->phone ?? 'N/A');
                $sheet->setCellValue('I' . $row, $booking->price);
                $sheet->setCellValue('J' . $row, $booking->total_price);
                $sheet->setCellValue('K' . $row, $booking->gmeet_link ?? 'N/A');
                $sheet->setCellValue('L' . $row, $booking->payment_status);
                $sheet->setCellValue('M' . $row, $booking->order_id ?? 'N/A');
                $sheet->setCellValue('N' . $row, $booking->created_at->format('Y-m-d H:i'));
                $row++;
            }
            
            // Auto size columns
            foreach (range('A', 'N') as $col) {
                $sheet->getColumnDimension($col)->setAutoSize(true);
            }
            
            // Generate filename with date
            $filename = 'event_bookings_' . Carbon::now()->format('Y_m_d_His') . '.xlsx';
            
            // Create a temporary file
            $tempFile = tempnam(sys_get_temp_dir(), 'excel');
            
            // Create Excel writer and save to the temporary file
            $writer = new Xlsx($spreadsheet);
            $writer->save($tempFile);
            
            // Return file as download with proper headers
            return response()->download($tempFile, $filename, [
                'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            ])->deleteFileAfterSend(true);
            
        } catch (\Exception $e) {
            // Return with error message
            return redirect()->back()->with('error', 'Failed to generate Excel file. Error: ' . $e->getMessage());
        }
    }
    
    public function updateGmeetLink(Request $request, $id)
    {
        $request->validate([
            'gmeet_link' => 'nullable|string|max:255',
        ]);

        $booking = EventBooking::findOrFail($id);
        $booking->gmeet_link = $request->gmeet_link;
        $booking->save();

        return redirect()->back()->with('success', 'Google Meet link updated successfully.');
    }
}
