<?php

namespace App\Http\Controllers\Professional;

use App\Http\Controllers\Controller;
use App\Models\Availability;
use App\Models\AvailabilitySlot;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AvailabilityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $availability = Availability::with('slots')
            ->where('professional_id', Auth::guard('professional')->id())
            ->get();
        return view('professional.availability.index', compact('availability'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('professional.availability.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'month' => 'required|string',
            'session_duration' => 'required|integer',
            'weekdays' => 'required|array',
            'start_time' => 'required|array',
            'start_period' => 'required|array',
            'end_time' => 'required|array',
            'end_period' => 'required|array',
        ]);

        // Create availability record
        $availability = Availability::create([
            'professional_id' => Auth::guard('professional')->id(),
            'month' => $request->month,
            'session_duration' => $request->session_duration,
            'weekdays' => json_encode($request->weekdays),
        ]);

        // Create time slots
        for ($i = 0; $i < count($request->start_time); $i++) {
            AvailabilitySlot::create([
                'availability_id' => $availability->id,
                'start_time' => $request->start_time[$i],
                'start_period' => $request->start_period[$i],
                'end_time' => $request->end_time[$i],
                'end_period' => $request->end_period[$i],
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Availability saved successfully.',
        ]);
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
