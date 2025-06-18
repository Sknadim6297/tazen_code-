<?php

namespace App\Http\Controllers\Customer;
use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\BookingTimedate;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AppointmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Get all distinct services for the filter dropdown
        $serviceOptions = Booking::where('user_id', Auth::guard('user')->id())
            ->select('service_name')
            ->distinct()
            ->whereNotNull('service_name')
            ->orderBy('service_name')
            ->pluck('service_name');
            
        // Get all distinct plan types for the filter dropdown
        $planTypeOptions = Booking::where('user_id', Auth::guard('user')->id())
            ->select('plan_type')
            ->distinct()
            ->whereNotNull('plan_type')
            ->orderBy('plan_type')
            ->pluck('plan_type');
            
        $query = Booking::with([
            'timedates' => function ($q) {
                $q->orderBy('date', 'desc');
            },
            'professional' => function ($q) {
                $q->select('id', 'name');
            }
        ])
        ->where('user_id', Auth::guard('user')->id());

        // Filter by search term
        if ($request->filled('search_name')) {
            $search = $request->search_name;
            $query->where(function ($q) use ($search) {
                $q->where('service_name', 'like', "%{$search}%")
                  ->orWhere('remarks', 'like', "%{$search}%")
                  ->orWhere('plan_type', 'like', "%{$search}%")
                  ->orWhereHas('professional', function ($q2) use ($search) {
                      $q2->where('name', 'like', "%{$search}%");
                  });
            });
        }

        // Filter by service
        if ($request->filled('service') && $request->service !== 'all') {
            $query->where('service_name', $request->service);
        }
        
        // Filter by plan type
        if ($request->filled('plan_type') && $request->plan_type !== 'all') {
            $query->where('plan_type', $request->plan_type);
        }

        // Search by Date Range
        if ($request->filled('search_date_from') && $request->filled('search_date_to')) {
            $query->whereHas('timedates', function ($q) use ($request) {
                $q->whereBetween('date', [$request->search_date_from, $request->search_date_to]);
            });
        } elseif ($request->filled('search_date_from')) {
            $query->whereHas('timedates', function ($q) use ($request) {
                $q->where('date', '>=', $request->search_date_from);
            });
        } elseif ($request->filled('search_date_to')) {
            $query->whereHas('timedates', function ($q) use ($request) {
                $q->where('date', '<=', $request->search_date_to);
            });
        }

        // Generate PDF and Excel Export if requested
        if ($request->has('export') && $request->export == 'pdf') {
            return $this->exportToPdf($query->get());
        } elseif ($request->has('export') && $request->export == 'excel') {
            return $this->exportToExcel($query->get());
        }

        $bookings = $query->get();

        return view('customer.appointment.index', compact('bookings', 'serviceOptions', 'planTypeOptions'));
    }

    /**
     * Export appointments to PDF
     */
    private function exportToPdf($bookings)
    {
        // Implementation for PDF export
        // Implement this or leave as placeholder
    }

    /**
     * Export appointments to Excel
     */
    private function exportToExcel($bookings) 
    {
        // Implementation for Excel export
        // Implement this or leave as placeholder
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
    public function showDetails($id)
    {
        $booking = Booking::with('timedates')->find($id);

        if (!$booking) {
            return response()->json(['error' => 'Booking not found'], 404);
        }

        return response()->json([
            'dates' => $booking->timedates->map(function ($td) {
                return [
                    'date' => $td->date,
                    'time_slot' => explode(',', $td->time_slot),
                    'status' => $td->status ?? 'Pending',
                    'remarks' => $td->remarks ?? 'No remarks',
                ];
            })
        ]);
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
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
