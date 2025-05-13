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
    $query = Booking::with([
        'timedates' => function ($q) {
            $q->orderBy('date', 'desc');
        },
        'professional' => function ($q) {
            $q->select('id', 'name');
        }
    ])
    ->where('user_id', Auth::guard('user')->id());
    if ($request->filled('search_name')) {
        $search = $request->search_name;
        $query->where(function ($q) use ($search) {
            $q->where('service_name', 'like', "%{$search}%")
              ->orWhere('remarks', 'like', "%{$search}%")
              ->orWhereHas('professional', function ($q2) use ($search) {
                  $q2->where('name', 'like', "%{$search}%");
              });
        });
    }

    // 📅 Search by Date Range
    if ($request->filled('search_date_from') && $request->filled('search_date_to')) {
        $query->whereHas('timedates', function ($q) use ($request) {
            $q->whereBetween('booking_date', [$request->search_date_from, $request->search_date_to]);
        });
    } elseif ($request->filled('search_date_from')) {
        $query->whereHas('timedates', function ($q) use ($request) {
            $q->where('booking_date', '>=', $request->search_date_from);
        });
    } elseif ($request->filled('search_date_to')) {
        $query->whereHas('timedates', function ($q) use ($request) {
            $q->where('booking_date', '<=', $request->search_date_to);
        });
    }

    $bookings = $query->get();

    return view('customer.appointment.index', compact('bookings'));
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
