<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EventBooking;
use Illuminate\Http\Request;
use Carbon\Carbon;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $statusList = EventBooking::select('payment_status')->distinct()->pluck('payment_status');
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
        if ($request->filled('event_mode')) {
            $query->where('type', $request->event_mode);
        }

        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('event_date', [$request->start_date, $request->end_date]);
        }

        $bookings = $query->latest()->paginate(10)->appends($request->all());

        return view('admin.event.index', compact('bookings', 'statusList', 'eventModes'));
    }

/**
     * Show the form for creating a new resource.
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
    }

    /**
     * Export event bookings to PDF
     * 
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function exportEventBookingsToPdf(Request $request)
    {
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
        if ($request->filled('event_mode')) {
            $query->where('type', $request->event_mode);
        }

        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('event_date', [$request->start_date, $request->end_date]);
        }
        $bookings = $query->latest()->get();
        $totalBookings = $bookings->count();
        $totalAmount = $bookings->sum('total_price');
        $statusCounts = $bookings->groupBy('payment_status')
            ->map(function ($group) {
                return $group->count();
            });
        $filterInfo = [
            'start_date' => $request->filled('start_date') ? Carbon::parse($request->start_date)->format('d M Y') : 'All time',
            'end_date' => $request->filled('end_date') ? Carbon::parse($request->end_date)->format('d M Y') : 'Present',
            'status' => $request->filled('status') ? ucfirst($request->status) : 'All statuses',
            'event_mode' => $request->filled('event_mode') ? ucfirst($request->event_mode) : 'All modes',
            'search' => $request->filled('search') ? $request->search : 'None',
            'generated_at' => Carbon::now()->format('d M Y H:i:s'),
        ];
        $pdf = FacadePdf::loadView('admin.event.event-bookings-pdf', compact(
            'bookings',
            'totalBookings',
            'totalAmount',
            'statusCounts',
            'filterInfo'
        ));
        $pdf->setPaper('a4', 'landscape');
        $filename = 'event_bookings_' . Carbon::now()->format('Y_m_d_His') . '.pdf';
        return $pdf->download($filename);
    }

    /**
     * Export event bookings to Excel
     * 
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function exportEventBookingsToExcel(Request $request)
    {
        try {
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
            if ($request->filled('event_mode')) {
                $query->where('type', $request->event_mode);
            }

            if ($request->filled('start_date') && $request->filled('end_date')) {
                $query->whereBetween('event_date', [$request->start_date, $request->end_date]);
            }

            $bookings = $query->latest()->get();
            $filename = 'event_bookings_' . Carbon::now()->format('Y_m_d_His') . '.csv';
            $headers = [
                'Content-Type' => 'text/csv; charset=UTF-8',
                'Content-Disposition' => 'attachment; filename="' . $filename . '"',
                'Pragma' => 'no-cache',
                'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
                'Expires' => '0',
            ];
            $totalBookings = $bookings->count();
            $totalAmount = $bookings->sum('total_price');
            $statusCounts = $bookings->groupBy('payment_status')
                ->map(function ($group) {
                    return $group->count();
                });
            $callback = function () use ($bookings, $totalBookings, $totalAmount, $statusCounts) {
                $file = fopen('php://output', 'w');
                fputs($file, "\xEF\xBB\xBF");
                fputcsv($file, [
                    'Sl.No',
                    'Customer Name',
                    'Event Name',
                    'Event Date',
                    'Location',
                    'Type (Online/Offline)',
                    'Persons',
                    'Phone',
                    'Price',
                    'Total Price',
                    'Payment Status',
                    'Order ID',
                    'Payment Date'
                ]);
                foreach ($bookings as $index => $booking) {
                    fputcsv($file, [
                        $index + 1,
                        $booking->user->name ?? 'N/A',
                        $booking->event->heading ?? 'N/A',
                        \Carbon\Carbon::parse($booking->event_date)->format('d-m-Y'),
                        $booking->location ?? 'N/A',
                        ucfirst($booking->type ?? 'N/A'),
                        $booking->persons ?? 'N/A',
                        $booking->phone ?? 'N/A',
                        $booking->price,
                        $booking->total_price,
                        $booking->payment_status,
                        $booking->order_id ?? 'N/A',
                        $booking->created_at->format('d-m-Y H:i')
                    ]);
                }
                fputcsv($file, []); // Empty row
                fputcsv($file, ['SUMMARY']);
                fputcsv($file, ['Total Bookings', $totalBookings]);
                fputcsv($file, ['Total Amount', '₹' . number_format($totalAmount, 2)]);

                fputcsv($file, []); // Empty row
                fputcsv($file, ['PAYMENT STATUS DISTRIBUTION']);
                foreach ($statusCounts as $status => $count) {
                    $percentage = $totalBookings > 0 ? round(($count / $totalBookings) * 100, 2) : 0;
                    fputcsv($file, [
                        ucfirst($status),
                        $count,
                        $percentage . '%'
                    ]);
                }

                fputcsv($file, []); // Empty row
                fputcsv($file, ['REPORT GENERATED ON', Carbon::now()->format('d M Y H:i:s')]);

                fclose($file);
            };
            return response()->stream($callback, 200, $headers);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to generate Excel file. Error: ' . $e->getMessage());
        }
    }


    /**
     * Handle export based on type (pdf or excel)
     * 
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function export(Request $request)
    {
        $type = $request->get('type', 'pdf'); // Default to PDF if not specified

if ($type === 'excel') {
            return $this->exportEventBookingsToExcel($request);
        } else {
            return $this->exportEventBookingsToPdf($request);
        }
    }
}
