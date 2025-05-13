<?php

namespace App\Http\Controllers\Professional;

use App\Http\Controllers\Controller;
use App\Models\Availability;
use App\Models\AvailabilitySlot;
use Carbon\Carbon;
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
            'session_duration' => 'required|integer|min:15|max:240',
            'weekdays' => 'required|array|min:1',
            'start_time' => 'required|array|min:1',
            'end_time' => 'required|array|min:1',
        ]);

        $professionalId = Auth::guard('professional')->id();
        $errors = [];

        for ($i = 0; $i < count($request->start_time); $i++) {
            $startRaw = $request->start_time[$i];
            $endRaw = $request->end_time[$i];

            try {

                $startTimeObj = Carbon::createFromFormat('h:i A', $startRaw);
                $endTimeObj = Carbon::createFromFormat('h:i A', $endRaw);
            } catch (\Exception $e) {
                $errors[] = "Invalid time format at slot #" . ($i + 1);
                continue;
            }

            if ($startTimeObj->gte($endTimeObj)) {
                $errors[] = "Start time must be before end time at slot #" . ($i + 1);
                continue;
            }
        }
        if (count($errors) > 0) {
            return response()->json([
                'success' => false,
                'errors' => $errors
            ], 422);
        }

        $availability = Availability::create([
            'professional_id' => $professionalId,
            'month' => $request->month,
            'session_duration' => $request->session_duration,
            'weekdays' => json_encode($request->weekdays),
        ]);

        foreach ($request->start_time as $index => $startRaw) {
            $endRaw = $request->end_time[$index];

            try {

                $startTimeObj = Carbon::createFromFormat('h:i A', $startRaw);
                $endTimeObj = Carbon::createFromFormat('h:i A', $endRaw);
            } catch (\Exception $e) {

                continue;
            }

            if ($startTimeObj->gte($endTimeObj)) {
                continue;
            }
            $startTime = $startTimeObj->format('H:i:s');
            $endTime = $endTimeObj->format('H:i:s');

            AvailabilitySlot::create([
                'availability_id' => $availability->id,
                'start_time' => $startTime,
                'end_time' => $endTime,
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Availability saved successfully.'
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
        $availability = Availability::with('slots')->findOrFail($id);
        if ($availability->professional_id != Auth::guard('professional')->id()) {
            return redirect()->route('professional.availability.index')->with('error', 'Unauthorized access');
        }

        return view('professional.availability.edit', compact('availability'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'month' => 'required|string',
            'session_duration' => 'required|integer|min:15|max:240',
            'weekdays' => 'required|array|min:1',
            'start_time' => 'required|array|min:1',
            'end_time' => 'required|array|min:1',
        ]);

        $availability = Availability::findOrFail($id);
        if ($availability->professional_id != Auth::guard('professional')->id()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized access'
            ], 403);
        }

        $availability->update([
            'month' => $request->month,
            'session_duration' => $request->session_duration,
            'weekdays' => json_encode($request->weekdays),
        ]);

        // Clear existing slots
        $availability->slots()->delete();

        foreach ($request->start_time as $index => $startRaw) {
            $endRaw = $request->end_time[$index];

            try {

                $startTimeObj = Carbon::createFromFormat('h:i A', $startRaw);
                $endTimeObj = Carbon::createFromFormat('h:i A', $endRaw);
            } catch (\Exception $e) {

                continue;
            }

            if ($startTimeObj->gte($endTimeObj)) {
                continue;
            }
            $startTime = $startTimeObj->format('H:i:s');
            $endTime = $endTimeObj->format('H:i:s');

            AvailabilitySlot::create([
                'availability_id' => $availability->id,
                'start_time' => $startTime,
                'end_time' => $endTime,
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Availability updated successfully.'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $availability = Availability::findOrFail($id);
        if ($availability->professional_id != Auth::guard('professional')->id()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized access'
            ], 403);
        }

        $availability->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Availability deleted successfully.'
        ]);
    }
}
