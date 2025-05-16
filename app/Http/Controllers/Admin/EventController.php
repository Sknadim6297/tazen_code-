<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EventBooking;
use Illuminate\Http\Request;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $statusList = EventBooking::select('payment_status')->distinct()->pluck('payment_status');

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
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('event_date', [$request->start_date, $request->end_date]);
        }
        $bookings = $query->latest()->get();

        return view('admin.event.index', compact('bookings', 'statusList'));
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
