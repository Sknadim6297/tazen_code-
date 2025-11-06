<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\BookingTimedate;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function oneTimeBooking(Request $request)
    {
        $query = Booking::whereIn('plan_type', ['one_time', 'One Time'])->with(['professional', 'timedates']);

        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('customer_name', 'like', '%' . $searchTerm . '%')
                    ->orWhere('customer_phone', 'like', '%' . $searchTerm . '%');
            })->orWhereHas('professional', function ($q) use ($searchTerm) {
                $q->where('name', 'like', '%' . $searchTerm . '%');
            });
        }
        if ($request->filled('service')) {
            $query->where('service_name', $request->service);
        }

        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('created_at', [$request->start_date, $request->end_date]);
        }

        if ($request->filled('status')) {
            $query->whereHas('timedates', function ($q) use ($request) {
                $q->where('status', $request->status);
            });
        }

        $bookings = $query->latest()->paginate(10)->withQueryString();
        $statuses = ['pending', 'completed', 'cancelled'];
        $services = Booking::whereIn('plan_type', ['one_time', 'One Time'])
            ->distinct()
            ->pluck('service_name')
            ->filter()
            ->values();

        return view('admin.booking.onetime', compact('bookings', 'statuses', 'services'));
    }

public function freeHandBooking(Request $request)
    {
        $query = Booking::whereIn('plan_type', ['free_hand', 'Free Hand'])
            ->with(['professional', 'timedates', 'customerProfile']);

        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('customer_name', 'like', '%' . $searchTerm . '%')
                    ->orWhere('customer_phone', 'like', '%' . $searchTerm . '%');
            })->orWhereHas('professional', function ($q) use ($searchTerm) {
                $q->where('name', 'like', '%' . $searchTerm . '%');
            });
        }
        if ($request->filled('service')) {
            $query->where('service_name', $request->service);
        }

        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('created_at', [$request->start_date, $request->end_date]);
        }
        if ($request->filled('status')) {
            $query->whereHas('timedates', function ($q) use ($request) {
                $q->where('status', $request->status);
            });
        }
        $bookings = $query->latest()->paginate(10)->withQueryString();
        $services = Booking::whereIn('plan_type', ['free_hand', 'Free Hand'])
            ->distinct()
            ->pluck('service_name')
            ->filter()
            ->values();

        $today = now()->startOfDay();

        foreach ($bookings as $booking) {
            $nextSession = $booking->timedates()
                ->where('date', '>=', $today->format('Y-m-d'))
                ->orderBy('date', 'asc')
                ->first();
            $lastSessionWithLink = $booking->timedates()
                ->where('date', '<', $today->format('Y-m-d'))
                ->whereNotNull('meeting_link')
                ->orderBy('date', 'desc')
                ->first();
            $booking->next_booking = $nextSession;
            $booking->last_session_with_link = $lastSessionWithLink;
            $completedSessions = 0;
            $pendingSessions = 0;

            if ($booking->timedates && $booking->timedates->count() > 0) {
                foreach ($booking->timedates as $td) {
                    $slots = explode(',', $td->time_slot);
                    if ($td->status === 'completed') {
                        $completedSessions += count($slots);
                    } else {
                        $pendingSessions += count($slots);
                    }
                }
            }

            $booking->completed_sessions = $completedSessions;
            $booking->pending_sessions = $pendingSessions;
        }
        $statuses = ['pending', 'completed'];

        return view('admin.booking.freehand', compact('bookings', 'statuses', 'services'));
    }

    public function monthlyBooking(Request $request)
    {
        $query = Booking::whereIn('plan_type', ['monthly', 'Monthly'])->with(['professional', 'timedates', 'customerProfile']);

        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('customer_name', 'like', '%' . $searchTerm . '%')
                    ->orWhere('customer_phone', 'like', '%' . $searchTerm . '%')
                    ->orWhere('service_name', 'like', '%' . $searchTerm . '%');
            })->orWhereHas('professional', function ($q) use ($searchTerm) {
                $q->where('name', 'like', '%' . $searchTerm . '%');
            });
        }
        if ($request->filled('service')) {
            $query->where('service_name', $request->service);
        }

        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('created_at', [$request->start_date, $request->end_date]);
        }
        if ($request->filled('status')) {
            $query->whereHas('timedates', function ($q) use ($request) {
                $q->where('status', $request->status);
            });
        }
        $bookings = $query->latest()->paginate(10)->withQueryString();
        $services = Booking::whereIn('plan_type', ['monthly', 'Monthly'])
            ->distinct()
            ->pluck('service_name')
            ->filter()
            ->values();
        foreach ($bookings as $booking) {
            $nextBookingDate = $booking->timedates()
                ->where('date', '>', now()->format('Y-m-d'))
                ->where('status', '!=', 'completed')
                ->orderBy('date', 'asc')
                ->first();

            $booking->next_booking_date = $nextBookingDate ?
                \Carbon\Carbon::parse($nextBookingDate->date)->format('d M Y') :
                'No Upcoming Booking';
            if ($nextBookingDate) {
                $booking->next_booking_time = $nextBookingDate->time_slot;
                $booking->next_meeting_link = $nextBookingDate->meeting_link;
            }
            $booking->display_amount = $booking->payment_status === 'paid' ?
                number_format($booking->amount, 2) : 'Not Paid';
            $latestTimedate = $booking->timedates()
                ->whereNotNull('meeting_link')
                ->orderBy('date', 'desc')
                ->first();

            $booking->latest_meeting_link = $latestTimedate ? $latestTimedate->meeting_link : null;
        }
        $statuses = ['pending', 'completed'];

        return view('admin.booking.monthly', compact('bookings', 'statuses', 'services'));
    }

    public function quaterlyBooking(Request $request)
    {
        $query = Booking::whereIn('plan_type', ['quarterly', 'Quarterly'])
            ->with(['professional', 'timedates', 'customerProfile']);

        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('customer_name', 'like', '%' . $searchTerm . '%')
                    ->orWhere('customer_phone', 'like', '%' . $searchTerm . '%')
                    ->orWhere('service_name', 'like', '%' . $searchTerm . '%');
            })->orWhereHas('professional', function ($q) use ($searchTerm) {
                $q->where('name', 'like', '%' . $searchTerm . '%');
            });
        }
        if ($request->filled('service')) {
            $query->where('service_name', $request->service);
        }

        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('created_at', [$request->start_date, $request->end_date]);
        }
        if ($request->filled('status')) {
            $query->whereHas('timedates', function ($q) use ($request) {
                $q->where('status', $request->status);
            });
        }
        $bookings = $query->latest()->paginate(10)->withQueryString();
        $services = Booking::whereIn('plan_type', ['quarterly', 'Quarterly'])
            ->distinct()
            ->pluck('service_name')
            ->filter()
            ->values();
        foreach ($bookings as $booking) {
            $nextBookingDate = $booking->timedates()
                ->where('date', '>', now()->format('Y-m-d'))
                ->where('status', '!=', 'completed')
                ->orderBy('date', 'asc')
                ->first();

            $booking->next_booking_date = $nextBookingDate ?
                \Carbon\Carbon::parse($nextBookingDate->date)->format('d M Y') :
                'No Upcoming Booking';
            if ($nextBookingDate) {
                $booking->next_booking_time = $nextBookingDate->time_slot;
                $booking->next_meeting_link = $nextBookingDate->meeting_link;
            }
            $booking->display_amount = $booking->payment_status === 'paid' ?
                number_format($booking->amount, 2) : 'Not Paid';
            $latestTimedate = $booking->timedates()
                ->whereNotNull('meeting_link')
                ->orderBy('date', 'desc')
                ->first();

            $booking->latest_meeting_link = $latestTimedate ? $latestTimedate->meeting_link : null;
        }
        $statuses = ['pending', 'completed'];

        return view('admin.booking.quaterly', compact('bookings', 'statuses', 'services'));
    }

    public function addMeetingLink(Request $request)
    {
        $request->validate([
            'timedate_id' => 'required_without:id|exists:booking_timedates,id',
            'id' => 'required_without:timedate_id|exists:bookings,id',
            'meeting_link' => 'required|url',
        ]);

        try {
            if ($request->has('timedate_id')) {
                $timedate = BookingTimedate::findOrFail($request->timedate_id);
                $timedate->meeting_link = $request->meeting_link;
                $timedate->save();

                return redirect()->back()->with('success', 'Meeting link added successfully for the selected date.');
            } else if ($request->has('id')) {
                $booking = Booking::findOrFail($request->id);
                $timedate = $booking->timedates->first();

                if ($timedate) {
                    $timedate->meeting_link = $request->meeting_link;
                    $timedate->save();

                    return redirect()->back()->with('success', 'Meeting link added successfully for the booking.');
                } else {
                    return redirect()->back()->with('error', 'No timedate found for this booking.');
                }
            }

            return redirect()->back()->with('error', 'Missing required parameters.');
        } catch (\Exception $e) {

            return redirect()->back()->with('error', 'Failed to save meeting link: ' . $e->getMessage());
        }
    }

    public function show($id)
    {
        $booking = Booking::with('timedates')->find($id);

        if (!$booking) {
            return response()->json(['error' => 'Booking not found'], 404);
        }

        $today = now()->startOfDay();

        return response()->json([
            'dates' => $booking->timedates->map(function ($td) use ($today) {
                $dateObj = \Carbon\Carbon::parse($td->date);
                $isExpired = $dateObj->lt($today);

                return [
                    'id' => $td->id,
                    'date' => $td->date,
                    'time_slot' => $td->time_slot,
                    'status' => $td->status ?? 'pending',
                    'remarks' => $td->remarks ?? '-',
                    'meeting_link' => $td->meeting_link ?? '',
                    'is_expired' => $isExpired,
                    'is_today' => $dateObj->isToday(),
                ];
            })->sortBy('date')->values()->all()
        ]);
    }
    public function addRemarks(Request $request, $id)
    {
        $request->validate([
            'remarks' => 'nullable|string|max:1000',
        ]);
        $booking = Booking::findOrFail($id);
        $booking->remarks = $request->remarks;
        $booking->save();
        return redirect()->back()->with('success', 'Remarks updated successfully!');
    }

    public function addProfessionalRemarks(Request $request, $id)
    {
        $request->validate([
            'remarks_for_professional' => 'nullable|string|max:1000',
        ]);

        $booking = Booking::findOrFail($id);
        $booking->remarks_for_professional = $request->remarks_for_professional;
        $booking->save();

        return back()->with('success', 'Remarks for professional updated successfully.');
    }

    /**
     * Export free hand bookings to PDF
     * 
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function exportFreeHandBookingsToPdf(Request $request)
    {
        $query = Booking::whereIn('plan_type', ['free_hand', 'Free Hand'])
            ->with(['professional', 'timedates', 'customerProfile']);
        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('customer_name', 'like', '%' . $searchTerm . '%')
                    ->orWhere('customer_phone', 'like', '%' . $searchTerm . '%');
            })->orWhereHas('professional', function ($q) use ($searchTerm) {
                $q->where('name', 'like', '%' . $searchTerm . '%');
            });
        }

        if ($request->filled('service')) {
            $query->where('service_name', $request->service);
        }

        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('created_at', [$request->start_date, $request->end_date]);
        }

        if ($request->filled('status')) {
            $query->whereHas('timedates', function ($q) use ($request) {
                $q->where('status', $request->status);
            });
        }
        $bookings = $query->latest()->get();

        $today = now()->startOfDay();
        foreach ($bookings as $booking) {
            $nextSession = $booking->timedates()
                ->where('date', '>=', $today->format('Y-m-d'))
                ->orderBy('date', 'asc')
                ->first();

            $booking->next_booking = $nextSession;
            $completedSessions = 0;
            $pendingSessions = 0;

            if ($booking->timedates && $booking->timedates->count() > 0) {
                foreach ($booking->timedates as $td) {
                    $slots = explode(',', $td->time_slot);
                    if ($td->status === 'completed') {
                        $completedSessions += count($slots);
                    } else {
                        $pendingSessions += count($slots);
                    }
                }
            }

            $booking->completed_sessions = $completedSessions;
            $booking->pending_sessions = $pendingSessions;
        }
        $totalBookings = $bookings->count();
        $totalAmount = $bookings->where('payment_status', 'paid')->sum('amount');
        $completedSessions = $bookings->sum('completed_sessions');
        $pendingSessions = $bookings->sum('pending_sessions');
        $filterInfo = [
            'start_date' => $request->filled('start_date') ? \Carbon\Carbon::parse($request->start_date)->format('d M Y') : 'All time',
            'end_date' => $request->filled('end_date') ? \Carbon\Carbon::parse($request->end_date)->format('d M Y') : 'Present',
            'status' => $request->filled('status') ? ucfirst($request->status) : 'All statuses',
            'service' => $request->filled('service') ? $request->service : 'All services',
            'search' => $request->filled('search') ? $request->search : '',
            'generated_at' => now()->format('d M Y H:i:s'),
        ];
        $pdf = Pdf::loadView('admin.booking.freehand-pdf', compact(
            'bookings',
            'totalBookings',
            'totalAmount',
            'completedSessions',
            'pendingSessions',
            'filterInfo'
        ));
        $pdf->setPaper('a4', 'landscape');
        $filename = 'freehand_bookings_' . now()->format('Y_m_d_His') . '.pdf';
        return $pdf->download($filename);
    }
    /**
     * Export monthly bookings to PDF
     * 
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function exportMonthlyBookingsToPdf(Request $request)
    {
        $query = Booking::whereIn('plan_type', ['monthly', 'Monthly'])
            ->with(['professional', 'timedates', 'customerProfile']);
        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('customer_name', 'like', '%' . $searchTerm . '%')
                    ->orWhere('customer_phone', 'like', '%' . $searchTerm . '%')
                    ->orWhere('service_name', 'like', '%' . $searchTerm . '%');
            })->orWhereHas('professional', function ($q) use ($searchTerm) {
                $q->where('name', 'like', '%' . $searchTerm . '%');
            });
        }

        if ($request->filled('service')) {
            $query->where('service_name', $request->service);
        }

        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('created_at', [$request->start_date, $request->end_date]);
        }

        if ($request->filled('status')) {
            $query->whereHas('timedates', function ($q) use ($request) {
                $q->where('status', $request->status);
            });
        }
        $bookings = $query->latest()->get();

        $today = now()->startOfDay();
        foreach ($bookings as $booking) {
            $nextBooking = $booking->timedates
                ->filter(fn($td) => \Carbon\Carbon::parse($td->date)->startOfDay()->gte($today))
                ->sortBy('date')
                ->first();
            $completedSessions = 0;
            $pendingSessions = 0;

            if ($booking->timedates && $booking->timedates->count() > 0) {
                foreach ($booking->timedates as $td) {
                    $slots = explode(',', $td->time_slot);
                    if ($td->status === 'completed') {
                        $completedSessions += count($slots);
                    } else {
                        $pendingSessions += count($slots);
                    }
                }
            }

            $booking->nextBooking = $nextBooking;
            $booking->completed_sessions = $completedSessions;
            $booking->pending_sessions = $pendingSessions;
        }
        $totalBookings = $bookings->count();
        $totalAmount = $bookings->where('payment_status', 'paid')->sum('amount');
        $completedSessions = $bookings->sum('completed_sessions');
        $pendingSessions = $bookings->sum('pending_sessions');
        $filterInfo = [
            'start_date' => $request->filled('start_date') ? \Carbon\Carbon::parse($request->start_date)->format('d M Y') : 'All time',
            'end_date' => $request->filled('end_date') ? \Carbon\Carbon::parse($request->end_date)->format('d M Y') : 'Present',
            'status' => $request->filled('status') ? ucfirst($request->status) : 'All statuses',
            'service' => $request->filled('service') ? $request->service : 'All services',
            'search' => $request->filled('search') ? $request->search : '',
            'generated_at' => now()->format('d M Y H:i:s'),
        ];
        $pdf = Pdf::loadView('admin.booking.monthly-pdf', compact(
            'bookings',
            'totalBookings',
            'totalAmount',
            'completedSessions',
            'pendingSessions',
            'filterInfo'
        ));
        $pdf->setPaper('a4', 'landscape');
        $filename = 'monthly_bookings_' . now()->format('Y_m_d_His') . '.pdf';
        return $pdf->download($filename);
    }
    /**
     * Export one time bookings to PDF
     * 
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function exportOneTimeBookingsToPdf(Request $request)
    {
        $query = Booking::whereIn('plan_type', ['one_time', 'One Time'])
            ->with(['professional', 'timedates', 'customerProfile']);
        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('customer_name', 'like', '%' . $searchTerm . '%')
                    ->orWhere('customer_phone', 'like', '%' . $searchTerm . '%');
            })->orWhereHas('professional', function ($q) use ($searchTerm) {
                $q->where('name', 'like', '%' . $searchTerm . '%');
            });
        }

        if ($request->filled('service')) {
            $query->where('service_name', $request->service);
        }

        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('created_at', [$request->start_date, $request->end_date]);
        }

        if ($request->filled('status')) {
            $query->whereHas('timedates', function ($q) use ($request) {
                $q->where('status', $request->status);
            });
        }
        $bookings = $query->latest()->get();
        foreach ($bookings as $booking) {
            $earliestTimedate = $booking->timedates && $booking->timedates->count() > 0
                ? $booking->timedates
                ->filter(fn($td) => \Carbon\Carbon::parse($td->date)->isFuture())
                ->sortBy('date')
                ->first()
                : null;

            $booking->earliest_timedate = $earliestTimedate;
        }
        $totalBookings = $bookings->count();
        $totalAmount = $bookings->where('payment_status', 'paid')->sum('amount');
        $statusCounts = [];

        foreach ($bookings as $booking) {
            $timedate = $booking->timedates->first();
            if ($timedate) {
                $status = $timedate->status;
                if (!isset($statusCounts[$status])) {
                    $statusCounts[$status] = 0;
                }
                $statusCounts[$status]++;
            }
        }
        $filterInfo = [
            'start_date' => $request->filled('start_date') ? \Carbon\Carbon::parse($request->start_date)->format('d M Y') : 'All time',
            'end_date' => $request->filled('end_date') ? \Carbon\Carbon::parse($request->end_date)->format('d M Y') : 'Present',
            'status' => $request->filled('status') ? ucfirst($request->status) : 'All statuses',
            'service' => $request->filled('service') ? $request->service : 'All services',
            'search' => $request->filled('search') ? $request->search : '',
            'generated_at' => \Carbon\Carbon::now()->format('d M Y H:i:s'),
        ];
        $pdf = PDF::loadView('admin.booking.onetime-pdf', compact(
            'bookings',
            'totalBookings',
            'totalAmount',
            'statusCounts',
            'filterInfo'
        ));
        $pdf->setPaper('a4', 'landscape');
        $filename = 'onetime_bookings_' . \Carbon\Carbon::now()->format('Y_m_d_His') . '.pdf';
        return $pdf->download($filename);
    }
    /**
     * Export quarterly bookings to PDF
     * 
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function exportQuarterlyBookingsToPdf(Request $request)
    {
        $query = Booking::whereIn('plan_type', ['quarterly', 'Quarterly'])
            ->with(['professional', 'timedates', 'customerProfile']);
        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('customer_name', 'like', '%' . $searchTerm . '%')
                    ->orWhere('customer_phone', 'like', '%' . $searchTerm . '%')
                    ->orWhere('service_name', 'like', '%' . $searchTerm . '%');
            })->orWhereHas('professional', function ($q) use ($searchTerm) {
                $q->where('name', 'like', '%' . $searchTerm . '%');
            });
        }

        if ($request->filled('service')) {
            $query->where('service_name', $request->service);
        }

        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('created_at', [$request->start_date, $request->end_date]);
        }

        if ($request->filled('status')) {
            $query->whereHas('timedates', function ($q) use ($request) {
                $q->where('status', $request->status);
            });
        }
        $bookings = $query->latest()->get();

        $today = now()->startOfDay();
        foreach ($bookings as $booking) {
            $nextBooking = $booking->timedates
                ->filter(fn($td) => \Carbon\Carbon::parse($td->date)->startOfDay()->gte($today))
                ->sortBy('date')
                ->first();

            $booking->next_booking = $nextBooking;
            $completedSessions = 0;
            $pendingSessions = 0;

            if ($booking->timedates && $booking->timedates->count() > 0) {
                foreach ($booking->timedates as $td) {
                    $slots = explode(',', $td->time_slot);
                    if ($td->status === 'completed') {
                        $completedSessions += count($slots);
                    } else {
                        $pendingSessions += count($slots);
                    }
                }
            }

            $booking->completed_sessions = $completedSessions;
            $booking->pending_sessions = $pendingSessions;
            $latestTimedate = $booking->timedates()
                ->whereNotNull('meeting_link')
                ->orderBy('date', 'desc')
                ->first();

            $booking->latest_meeting_link = $latestTimedate ? $latestTimedate->meeting_link : null;
        }
        $totalBookings = $bookings->count();
        $totalAmount = $bookings->where('payment_status', 'paid')->sum('amount');
        $completedSessions = $bookings->sum('completed_sessions');
        $pendingSessions = $bookings->sum('pending_sessions');
        $filterInfo = [
            'start_date' => $request->filled('start_date') ? \Carbon\Carbon::parse($request->start_date)->format('d M Y') : 'All time',
            'end_date' => $request->filled('end_date') ? \Carbon\Carbon::parse($request->end_date)->format('d M Y') : 'Present',
            'status' => $request->filled('status') ? ucfirst($request->status) : 'All statuses',
            'service' => $request->filled('service') ? $request->service : 'All services',
            'search' => $request->filled('search') ? $request->search : '',
            'generated_at' => \Carbon\Carbon::now()->format('d M Y H:i:s'),
        ];
        $pdf = PDF::loadView('admin.booking.quarterly-pdf', compact(
            'bookings',
            'totalBookings',
            'totalAmount',
            'completedSessions',
            'pendingSessions',
            'filterInfo'
        ));
        $pdf->setPaper('a4', 'landscape');
        $filename = 'quarterly_bookings_' . \Carbon\Carbon::now()->format('Y_m_d_His') . '.pdf';
        return $pdf->download($filename);
    }

    /**
     * Export quarterly booking data to Excel
     * 
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function exportQuarterlyToExcel(Request $request)
    {
        try {
            $filename = 'quarterly_bookings_' . date('Y_m_d_His') . '.csv';
            $headers = [
                'Content-Type' => 'text/csv',
                'Content-Disposition' => 'attachment; filename="' . $filename . '"',
                'Pragma' => 'no-cache',
                'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
                'Expires' => '0',
            ];
            $query = Booking::with(['professional', 'user', 'timedates'])
                ->whereIn('plan_type', ['quarterly', 'Quarterly'])
                ->when($request->filled('search'), function ($query) use ($request) {
                    $query->where(function ($q) use ($request) {
                        $q->where('customer_name', 'like', "%{$request->search}%")
                            ->orWhere('customer_phone', 'like', "%{$request->search}%")
                            ->orWhereHas('professional', function ($q) use ($request) {
                                $q->where('name', 'like', "%{$request->search}%")
                                    ->orWhere('phone', 'like', "%{$request->search}%");
                            });
                    });
                })
                ->when($request->filled('status'), fn($q) => $q->whereHas('timedates', function ($query) use ($request) {
                    $query->where('status', $request->status);
                }))
                ->when($request->filled('service'), fn($q) => $q->where('service_name', $request->service))
                ->when($request->filled(['start_date', 'end_date']), function ($query) use ($request) {
                    $query->whereHas('timedates', function ($q) use ($request) {
                        $q->whereBetween('date', [
                            Carbon::parse($request->start_date)->startOfDay(),
                            Carbon::parse($request->end_date)->endOfDay()
                        ]);
                    });
                });
            $bookings = $query->latest()->get();
            $callback = function () use ($bookings, $request) {
                $file = fopen('php://output', 'w');
                fputs($file, "\xEF\xBB\xBF");
                fputcsv($file, [
                    'Sl. No',
                    'Customer Name',
                    'Customer Phone',
                    'Professional Name',
                    'Professional Phone',
                    'Service Required',
                    'Paid Amount',
                    'Number Of Session',
                    'Number Of Session Taken',
                    'Number Of Session Pending',
                    'Validity Till',
                    'Current Service Date',
                    'Current Service Time',
                    'Meeting Link',
                    'Status',
                    'Admin Remarks to Professional',
                    'Telecaller Remarks'
                ]);
                $totalAmount = 0;

                foreach ($bookings as $key => $booking) {
                    $nextBooking = $booking->timedates
                        ->filter(fn($td) => \Carbon\Carbon::parse($td->date)->startOfDay()->gte(now()->startOfDay()))
                        ->sortBy('date')
                        ->first();

                    $completedSessions = 0;
                    $pendingSessions = 0;

                    if ($booking->timedates && $booking->timedates->count() > 0) {
                        foreach ($booking->timedates as $td) {
                            $slots = explode(',', $td->time_slot);
                            if ($td->status === 'completed') {
                                $completedSessions += count($slots);
                            } else {
                                $pendingSessions += count($slots);
                            }
                        }
                    }

                    $totalAmount += $booking->amount;

                    fputcsv($file, [
                        $key + 1,
                        $booking->customer_name ?? 'N/A',
                        $booking->customer_phone ?? 'N/A',
                        $booking->professional->name ?? 'N/A',
                        $booking->professional->phone ?? 'N/A',
                        $booking->service_name ?? 'N/A',
                        $booking->payment_status === 'paid' ? number_format($booking->amount ?? 0, 2) : 'Not Paid',
                        is_array($booking->days) ? count($booking->days) : count(json_decode($booking->days, true) ?? []),
                        $completedSessions,
                        $pendingSessions,
                        $booking->quarter ?? '3 months',
                        $nextBooking ? \Carbon\Carbon::parse($nextBooking->date)->format('d M Y') : 'No upcoming sessions',
                        $nextBooking ? str_replace(',', ' | ', $nextBooking->time_slot) : '-',
                        $booking->latest_meeting_link ?? 'No link available',
                        ucfirst($booking->status ?? 'Pending'),
                        $booking->remarks_for_professional ?? '-',
                        $booking->remarks ?? '-'
                    ]);
                }
                fputcsv($file, ['']);
                fputcsv($file, ['Summary', '', '', '', '', '', number_format($totalAmount, 2), $bookings->count(), '', '', '', '', '', '', '', '']);
                fputcsv($file, ['']);
                fputcsv($file, ['Filter Information']);

                if ($request->filled(['start_date', 'end_date'])) {
                    fputcsv($file, [
                        'Date Range',
                        $request->filled('start_date') ? Carbon::parse($request->start_date)->format('d M Y') : 'All time',
                        'to',
                        $request->filled('end_date') ? Carbon::parse($request->end_date)->format('d M Y') : 'Present'
                    ]);
                }

                if ($request->filled('status')) {
                    fputcsv($file, ['Status', ucfirst($request->status)]);
                }

                if ($request->filled('service')) {
                    fputcsv($file, ['Service', $request->service]);
                }

                if ($request->filled('search')) {
                    fputcsv($file, ['Search Query', $request->search]);
                }

                fputcsv($file, ['Generated At', now()->format('d M Y H:i:s')]);
                fputcsv($file, ['Total Bookings', $bookings->count()]);

                fclose($file);
            };

            return response()->stream($callback, 200, $headers);
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to generate Excel file. Please try again or contact support.');
        }
    }

    /**
     * Export free hand booking data to Excel
     * 
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function exportFreehandToExcel(Request $request)
    {
        try {
            $filename = 'freehand_bookings_' . date('Y_m_d_His') . '.csv';
            $headers = [
                'Content-Type' => 'text/csv',
                'Content-Disposition' => 'attachment; filename="' . $filename . '"',
                'Pragma' => 'no-cache',
                'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
                'Expires' => '0',
            ];
            $query = Booking::with(['professional', 'user', 'timedates'])
                ->whereIn('plan_type', ['free_hand', 'Free Hand'])
                ->when($request->filled('search'), function ($query) use ($request) {
                    $query->where(function ($q) use ($request) {
                        $q->where('customer_name', 'like', "%{$request->search}%")
                            ->orWhere('customer_phone', 'like', "%{$request->search}%")
                            ->orWhereHas('professional', function ($q) use ($request) {
                                $q->where('name', 'like', "%{$request->search}%")
                                    ->orWhere('phone', 'like', "%{$request->search}%");
                            });
                    });
                })
                ->when($request->filled('status'), fn($q) => $q->where('status', $request->status))
                ->when($request->filled('service'), fn($q) => $q->where('service_name', $request->service))
                ->when($request->filled(['start_date', 'end_date']), function ($query) use ($request) {
                    $query->whereHas('timedates', function ($q) use ($request) {
                        $q->whereBetween('date', [
                            Carbon::parse($request->start_date)->startOfDay(),
                            Carbon::parse($request->end_date)->endOfDay()
                        ]);
                    });
                });
            $bookings = $query->latest()->get();
            $callback = function () use ($bookings, $request) {
                $file = fopen('php://output', 'w');
                fputs($file, "\xEF\xBB\xBF");
                fputcsv($file, [
                    'Sl. No',
                    'Customer Name',
                    'Customer Phone',
                    'Professional Name',
                    'Professional Phone',
                    'Service Required',
                    'Paid Amount',
                    'Number Of Service',
                    'Number Of Service Taken',
                    'Number Of Service Pending',
                    'Validity Till',
                    'Current Service Date',
                    'Current Service Time',
                    'Meeting Link',
                    'Status',
                    'Admin Remarks to Professional',
                    'Telecaller Remarks'
                ]);
                $totalAmount = 0;

                foreach ($bookings as $key => $booking) {
                    $nextBooking = $booking->timedates
                        ->filter(fn($td) => \Carbon\Carbon::parse($td->date)->startOfDay()->gte(now()->startOfDay()))
                        ->sortBy('date')
                        ->first();

                    $completedSessions = $booking->completed_sessions ?? 0;
                    $pendingSessions = $booking->pending_sessions ?? 0;

                    $totalAmount += $booking->amount;

                    fputcsv($file, [
                        $key + 1,
                        $booking->customer_name ?? 'N/A',
                        $booking->customer_phone ?? 'N/A',
                        $booking->professional->name ?? 'N/A',
                        $booking->professional->phone ?? 'N/A',
                        $booking->service_name ?? 'N/A',
                        $booking->payment_status === 'paid' ? number_format($booking->amount ?? 0, 2) : 'Not Paid',
                        is_array($booking->days) ? count($booking->days) : count(json_decode($booking->days, true) ?? []),
                        $completedSessions,
                        $pendingSessions,
                        $booking->month ?? 'N/A',
                        $nextBooking ? \Carbon\Carbon::parse($nextBooking->date)->format('d M Y') : 'No upcoming sessions',
                        $nextBooking ? str_replace(',', ' | ', $nextBooking->time_slot) : '-',
                        ($nextBooking && $nextBooking->meeting_link) ? $nextBooking->meeting_link : 'No link available',
                        ucfirst($booking->status ?? 'Pending'),
                        $booking->remarks_for_professional ?? '-',
                        $booking->remarks ?? '-'
                    ]);
                }
                fputcsv($file, ['']);
                fputcsv($file, ['Summary', '', '', '', '', '', number_format($totalAmount, 2), $bookings->count(), '', '', '', '', '', '', '', '']);
                fputcsv($file, ['']);
                fputcsv($file, ['Filter Information']);

                if ($request->filled(['start_date', 'end_date'])) {
                    fputcsv($file, [
                        'Date Range',
                        $request->filled('start_date') ? Carbon::parse($request->start_date)->format('d M Y') : 'All time',
                        'to',
                        $request->filled('end_date') ? Carbon::parse($request->end_date)->format('d M Y') : 'Present'
                    ]);
                }

                if ($request->filled('status')) {
                    fputcsv($file, ['Status', ucfirst($request->status)]);
                }

                if ($request->filled('service')) {
                    fputcsv($file, ['Service', $request->service]);
                }

                if ($request->filled('search')) {
                    fputcsv($file, ['Search Query', $request->search]);
                }

                fputcsv($file, ['Generated At', now()->format('d M Y H:i:s')]);
                fputcsv($file, ['Total Bookings', $bookings->count()]);

                fclose($file);
            };

            return response()->stream($callback, 200, $headers);
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to generate Excel file. Please try again or contact support.');
        }
    }

    /**
     * Export one time booking data to Excel
     * 
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function exportOnetimeToExcel(Request $request)
    {
        try {
            $filename = 'onetime_bookings_' . date('Y_m_d_His') . '.csv';
            $headers = [
                'Content-Type' => 'text/csv',
                'Content-Disposition' => 'attachment; filename="' . $filename . '"',
                'Pragma' => 'no-cache',
                'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
                'Expires' => '0',
            ];
            $query = Booking::with(['professional', 'user', 'timedates'])
                ->whereIn('plan_type', ['one_time', 'One Time'])
                ->when($request->filled('search'), function ($query) use ($request) {
                    $query->where(function ($q) use ($request) {
                        $q->where('customer_name', 'like', "%{$request->search}%")
                            ->orWhere('customer_phone', 'like', "%{$request->search}%")
                            ->orWhereHas('professional', function ($q) use ($request) {
                                $q->where('name', 'like', "%{$request->search}%")
                                    ->orWhere('phone', 'like', "%{$request->search}%");
                            });
                    });
                })
                ->when($request->filled('status'), fn($q) => $q->whereHas('timedates', function ($query) use ($request) {
                    $query->where('status', $request->status);
                }))
                ->when($request->filled('service'), fn($q) => $q->where('service_name', $request->service))
                ->when($request->filled(['start_date', 'end_date']), function ($query) use ($request) {
                    $query->whereHas('timedates', function ($q) use ($request) {
                        $q->whereBetween('date', [
                            Carbon::parse($request->start_date)->startOfDay(),
                            Carbon::parse($request->end_date)->endOfDay()
                        ]);
                    });
                });
            $bookings = $query->latest()->get();
            $callback = function () use ($bookings, $request) {
                $file = fopen('php://output', 'w');
                fputs($file, "\xEF\xBB\xBF");
                fputcsv($file, [
                    'Sl. No',
                    'Customer Name',
                    'Customer Phone',
                    'Professional Name',
                    'Professional Phone',
                    'Service Required',
                    'Status',
                    'Service Date',
                    'Service Time',
                    'Meeting Link',
                    'Paid Amount',
                    'Professional Remarks to Customer',
                    'Admin Remarks to Professional',
                    'Telecaller Remarks'
                ]);
                $totalAmount = 0;

                foreach ($bookings as $key => $booking) {
                    $earliestTimedate = $booking->timedates && $booking->timedates->count() > 0
                        ? $booking->timedates
                        ->filter(fn($td) => \Carbon\Carbon::parse($td->date)->isFuture())
                        ->sortBy('date')
                        ->first()
                        : null;

                    $totalAmount += $booking->amount;

                    fputcsv($file, [
                        $key + 1,
                        $booking->customer_name ?? 'N/A',
                        $booking->customer_phone ?? 'N/A',
                        $booking->professional->name ?? 'N/A',
                        $booking->professional->phone ?? 'N/A',
                        $booking->service_name ?? 'N/A',
                        $booking->timedates->first()?->status ?? '-',
                        $earliestTimedate ? \Carbon\Carbon::parse($earliestTimedate->date)->format('d M Y') : '-',
                        $earliestTimedate ? str_replace(',', ' | ', $earliestTimedate->time_slot) : '-',
                        $booking->timedates->first()?->meeting_link ?? 'No link available',
                        $booking->payment_status === 'paid' ? number_format($booking->amount ?? 0, 2) : 'Not Paid',
                        $booking->timedates->first()?->remarks ?? '-',
                        $booking->remarks_for_professional ?? '-',
                        $booking->remarks ?? '-'
                    ]);
                }
                fputcsv($file, ['']);
                fputcsv($file, ['Summary', '', '', '', '', '', '', '', '', '', number_format($totalAmount, 2), '', '', '']);
                fputcsv($file, ['']);
                fputcsv($file, ['Filter Information']);

                if ($request->filled(['start_date', 'end_date'])) {
                    fputcsv($file, [
                        'Date Range',
                        $request->filled('start_date') ? Carbon::parse($request->start_date)->format('d M Y') : 'All time',
                        'to',
                        $request->filled('end_date') ? Carbon::parse($request->end_date)->format('d M Y') : 'Present'
                    ]);
                }

                if ($request->filled('status')) {
                    fputcsv($file, ['Status', ucfirst($request->status)]);
                }

                if ($request->filled('service')) {
                    fputcsv($file, ['Service', $request->service]);
                }

                if ($request->filled('search')) {
                    fputcsv($file, ['Search Query', $request->search]);
                }

                fputcsv($file, ['Generated At', now()->format('d M Y H:i:s')]);
                fputcsv($file, ['Total Bookings', $bookings->count()]);

                fclose($file);
            };

            return response()->stream($callback, 200, $headers);
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to generate Excel file. Please try again or contact support.');
        }
    }
    public function exportMonthlyToExcel(Request $request)
    {
        try {
            $filename = 'monthly_bookings_' . date('Y_m_d_His') . '.csv';
            $headers = [
                'Content-Type' => 'text/csv',
                'Content-Disposition' => 'attachment; filename="' . $filename . '"',
                'Pragma' => 'no-cache',
                'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
                'Expires' => '0',
            ];
            $query = Booking::with(['professional', 'user', 'timedates'])
                ->whereIn('plan_type', ['monthly', 'Monthly'])
                ->when($request->filled('search'), function ($query) use ($request) {
                    $query->where(function ($q) use ($request) {
                        $q->where('customer_name', 'like', "%{$request->search}%")
                            ->orWhere('customer_phone', 'like', "%{$request->search}%")
                            ->orWhereHas('professional', function ($q) use ($request) {
                                $q->where('name', 'like', "%{$request->search}%")
                                    ->orWhere('phone', 'like', "%{$request->search}%");
                            });
                    });
                })
                ->when($request->filled('status'), fn($q) => $q->whereHas('timedates', function ($query) use ($request) {
                    $query->where('status', $request->status);
                }))
                ->when($request->filled('service'), fn($q) => $q->where('service_name', $request->service))
                ->when($request->filled(['start_date', 'end_date']), function ($query) use ($request) {
                    $query->whereHas('timedates', function ($q) use ($request) {
                        $q->whereBetween('date', [
                            Carbon::parse($request->start_date)->startOfDay(),
                            Carbon::parse($request->end_date)->endOfDay()
                        ]);
                    });
                });
            $bookings = $query->latest()->get();
            $callback = function () use ($bookings, $request) {
                $file = fopen('php://output', 'w');
                fputs($file, "\xEF\xBB\xBF");
                fputcsv($file, [
                    'Sl. No',
                    'Customer Name',
                    'Customer Phone',
                    'Professional Name',
                    'Professional Phone',
                    'Service Required',
                    'Paid Amount',
                    'Number Of Session',
                    'Number Of Session Taken',
                    'Number Of Session Pending',
                    'Validity Till',
                    'Current Service Date',
                    'Current Service Time',
                    'Meeting Link',
                    'Status',
                    'Admin Remarks to Professional',
                    'Telecaller Remarks'
                ]);
                $totalAmount = 0;
                $today = now()->startOfDay();

                foreach ($bookings as $key => $booking) {
                    $nextBooking = $booking->timedates
                        ->filter(fn($td) => \Carbon\Carbon::parse($td->date)->startOfDay()->gte($today))
                        ->sortBy('date')
                        ->first();
                    $completedSessions = 0;
                    $pendingSessions = 0;

                    if ($booking->timedates && $booking->timedates->count() > 0) {
                        foreach ($booking->timedates as $td) {
                            $slots = explode(',', $td->time_slot);
                            if ($td->status === 'completed') {
                                $completedSessions += count($slots);
                            } else {
                                $pendingSessions += count($slots);
                            }
                        }
                    }
                    $latestTimedate = $booking->timedates()
                        ->whereNotNull('meeting_link')
                        ->orderBy('date', 'desc')
                        ->first();

                    $meetingLink = $latestTimedate ? $latestTimedate->meeting_link : 'No link available';

                    if ($booking->payment_status === 'paid') {
                        $totalAmount += $booking->amount;
                    }

                    fputcsv($file, [
                        $key + 1,
                        $booking->customer_name ?? 'N/A',
                        $booking->customer_phone ?? 'N/A',
                        $booking->professional->name ?? 'N/A',
                        $booking->professional->phone ?? 'N/A',
                        $booking->service_name ?? 'N/A',
                        $booking->payment_status === 'paid' ? number_format($booking->amount ?? 0, 2) : 'Not Paid',
                        is_array($booking->days) ? count($booking->days) : count(json_decode($booking->days, true) ?? []),
                        $completedSessions,
                        $pendingSessions,
                        $booking->month ?? 'One Month',
                        $nextBooking ? \Carbon\Carbon::parse($nextBooking->date)->format('d M Y') : 'No upcoming sessions',
                        $nextBooking ? str_replace(',', ' | ', $nextBooking->time_slot) : '-',
                        $meetingLink,
                        'Pending', // Default status for monthly bookings
                        $booking->remarks_for_professional ?? '-',
                        $booking->remarks ?? '-'
                    ]);
                }
                fputcsv($file, ['']);
                fputcsv($file, ['Summary', '', '', '', '', '', number_format($totalAmount, 2), '', '', '', '', '', '', '', '', '', '']);
                fputcsv($file, ['']);
                fputcsv($file, ['Filter Information']);

                if ($request->filled(['start_date', 'end_date'])) {
                    fputcsv($file, [
                        'Date Range',
                        $request->filled('start_date') ? Carbon::parse($request->start_date)->format('d M Y') : 'All time',
                        'to',
                        $request->filled('end_date') ? Carbon::parse($request->end_date)->format('d M Y') : 'Present'
                    ]);
                }

                if ($request->filled('status')) {
                    fputcsv($file, ['Status', ucfirst($request->status)]);
                }

                if ($request->filled('service')) {
                    fputcsv($file, ['Service', $request->service]);
                }

                if ($request->filled('search')) {
                    fputcsv($file, ['Search Query', $request->search]);
                }

                fputcsv($file, ['Generated At', now()->format('d M Y H:i:s')]);
                fputcsv($file, ['Total Bookings', $bookings->count()]);
                fputcsv($file, ['Total Paid Amount', number_format($totalAmount, 2)]);

                fclose($file);
            };

            return response()->stream($callback, 200, $headers);
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to generate Excel file. Please try again or contact support.');
        }
    }
}
