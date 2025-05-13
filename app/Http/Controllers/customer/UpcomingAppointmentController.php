<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UpcomingAppointmentController extends Controller
{

    public function index()
    {
        $bookings = Booking::with([
            'timedates' => function ($q) {
                $q->where('date', '>=', \Carbon\Carbon::today())
                    ->orderBy('date', 'asc');
            },
            'professional' => function ($q) {
                $q->select('id', 'name');
            }
        ])
            ->where('user_id', Auth::guard('user')->id())
            ->get();

        return view('customer.upcoming-appointment.index', compact('bookings'));
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
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
