<?php

namespace App\Http\Controllers\Professional;

use App\Http\Controllers\Controller;
use App\Models\Availability;
use App\Models\AvailabilitySlot;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AvailabilityController extends Controller
{


   public function index(Request $request)
{
    $query = Availability::with('slots')
        ->where('professional_id', Auth::guard('professional')->id());

    if ($request->filled('search_month')) {
        $searchMonth = strtolower($request->search_month);
        $query->where('month', $searchMonth); 
    }

    $availability = $query->get();
    $availableMonths = Availability::where('professional_id', Auth::guard('professional')->id())
        ->pluck('month')
        ->unique()
        ->sort()
        ->values();

    return view('professional.availability.index', compact('availability', 'availableMonths'));
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
            'months' => 'required|array|min:1',
            'months.*' => 'string|regex:/^\d{4}-\d{2}$/',
            'session_duration' => 'required|integer|min:15|max:240',
            'weekdays' => 'required|array|min:1',
            'start_time' => 'required|array|min:1',
            'end_time' => 'required|array|min:1',
        ]);

        $professionalId = Auth::guard('professional')->id();
        $errors = [];
        $successfulMonths = [];
        $skippedMonths = [];
        $errorMonths = [];

        // Validate time slots first
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

        // Process each month
        foreach ($request->months as $month) {
            // Check if availability for this month already exists
            $existingAvailability = Availability::where('professional_id', $professionalId)
                                                ->where('month', $month)
                                                ->first();

            if ($existingAvailability) {
                $skippedMonths[] = $month;
                continue;
            }

            try {
                $availability = Availability::create([
                    'professional_id' => $professionalId,
                    'month' => $month,
                    'session_duration' => $request->session_duration,
                    'weekdays' => json_encode($request->weekdays),
                ]);

                // Create time slots for this availability
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
                
                $successfulMonths[] = $month;
            } catch (\Exception $e) {
                $errorMonths[] = $month;
                Log::error("Failed to create availability for month {$month}: " . $e->getMessage());
            }
        }

        // Prepare response message
        $message = '';
        if (count($successfulMonths) > 0) {
            $message .= 'Availability created for ' . count($successfulMonths) . ' month(s). ';
        }
        if (count($skippedMonths) > 0) {
            $message .= count($skippedMonths) . ' month(s) already had availability and were skipped. ';
        }
        if (count($errorMonths) > 0) {
            $message .= count($errorMonths) . ' month(s) failed to save due to errors. ';
        }
        
        $isSuccess = count($successfulMonths) > 0;

        return response()->json([
            'success' => $isSuccess,
            'message' => $message ?: 'No availability was created.',
            'details' => [
                'successful' => $successfulMonths,
                'skipped' => $skippedMonths,
                'errors' => $errorMonths
            ]
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
            'months' => 'required|array|min:1',
            'months.*' => 'string|regex:/^\d{4}-\d{2}$/',
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

        $selectedMonths = $request->months;
        $firstMonth = array_shift($selectedMonths); // Get and remove first month
        
        $successfulMonths = [];
        $skippedMonths = [];
        $errorMonths = [];

        // Validate time slots first
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

        try {
            // Update the existing availability with the first selected month
            // Check if another availability already exists for this month (excluding current one)
            $conflictingAvailability = Availability::where('professional_id', Auth::guard('professional')->id())
                                                    ->where('month', $firstMonth)
                                                    ->where('id', '!=', $id)
                                                    ->first();
            
            if ($conflictingAvailability) {
                $skippedMonths[] = $firstMonth;
            } else {
                // Update availability
                $availability->update([
                    'month' => $firstMonth,
                    'session_duration' => $request->session_duration,
                    'weekdays' => json_encode($request->weekdays),
                ]);

                // Clear existing slots and create new ones
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
                
                $successfulMonths[] = $firstMonth;
            }
            
            // Create new availabilities for additional months
            foreach ($selectedMonths as $month) {
                $existingAvailability = Availability::where('professional_id', Auth::guard('professional')->id())
                                                    ->where('month', $month)
                                                    ->first();

                if ($existingAvailability) {
                    $skippedMonths[] = $month;
                    continue;
                }

                try {
                    $newAvailability = Availability::create([
                        'professional_id' => Auth::guard('professional')->id(),
                        'month' => $month,
                        'session_duration' => $request->session_duration,
                        'weekdays' => json_encode($request->weekdays),
                    ]);

                    // Create slots
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
                            'availability_id' => $newAvailability->id,
                            'start_time' => $startTime,
                            'end_time' => $endTime,
                        ]);
                    }
                    
                    $successfulMonths[] = $month;
                } catch (\Exception $e) {
                    $errorMonths[] = $month;
                    Log::error("Failed to create availability for month {$month}: " . $e->getMessage());
                }
            }

            // Prepare response message
            $message = '';
            if (count($successfulMonths) > 0) {
                $message .= 'Availability updated/created for ' . count($successfulMonths) . ' month(s). ';
            }
            if (count($skippedMonths) > 0) {
                $message .= count($skippedMonths) . ' month(s) already had availability and were skipped. ';
            }
            if (count($errorMonths) > 0) {
                $message .= count($errorMonths) . ' month(s) failed to save due to errors. ';
            }
            
            $isSuccess = count($successfulMonths) > 0;

            return response()->json([
                'success' => $isSuccess,
                'message' => $message ?: 'No availability was updated.',
                'details' => [
                    'successful' => $successfulMonths,
                    'skipped' => $skippedMonths,
                    'errors' => $errorMonths
                ]
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update availability.',
                'error' => $e->getMessage()
            ], 500);
        }
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
