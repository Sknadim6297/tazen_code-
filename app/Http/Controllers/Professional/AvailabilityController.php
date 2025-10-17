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

    public function create()
    {
        return view('professional.availability.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'months' => 'required|array|min:1',
            'months.*' => 'string|regex:/^\d{4}-\d{2}$/',
            'session_duration' => 'required|integer|min:15|max:240',
            'weekly_slots' => 'required|string', // JSON string from frontend
        ]);

        $professionalId = Auth::guard('professional')->id();
        
        // Parse weekly slots JSON
        $weeklySlots = json_decode($request->weekly_slots, true);
        if (!$weeklySlots || !is_array($weeklySlots)) {
            return response()->json([
                'success' => false,
                'errors' => ['Invalid weekly slots data']
            ], 422);
        }

        $errors = [];
        $successfulMonths = [];
        $skippedMonths = [];

        // Validate time slots
        foreach ($weeklySlots as $index => $slot) {
            if (!isset($slot['weekday']) || !isset($slot['start_time']) || !isset($slot['end_time'])) {
                $errors[] = "Invalid slot data at position " . ($index + 1);
                continue;
            }
            
            try {
                $startTime = Carbon::createFromFormat('H:i', $slot['start_time']);
                $endTime = Carbon::createFromFormat('H:i', $slot['end_time']);
                
                if ($startTime->gte($endTime)) {
                    $errors[] = "Start time must be before end time for slot #" . ($index + 1);
                }
            } catch (\Exception $e) {
                $errors[] = "Invalid time format for slot #" . ($index + 1);
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
                    'weekdays' => json_encode([]), // Keep for backward compatibility
                ]);

                // Create weekday-specific time slots
                foreach ($weeklySlots as $slot) {
                    AvailabilitySlot::create([
                        'availability_id' => $availability->id,
                        'weekday' => $slot['weekday'],
                        'start_time' => $slot['start_time'] . ':00',
                        'end_time' => $slot['end_time'] . ':00',
                    ]);
                }
                
                $successfulMonths[] = $month;
            } catch (\Exception $e) {
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

        return response()->json([
            'success' => true,
            'message' => $message,
            'redirect' => route('professional.availability.index')
        ]);
    }

    public function show(Availability $availability)
    {
        if ($availability->professional_id != Auth::guard('professional')->id()) {
            abort(403);
        }
        
        return view('professional.availability.show', compact('availability'));
    }

    public function edit($id)
    {
        $availability = Availability::with('availabilitySlots')
                                  ->where('professional_id', Auth::guard('professional')->id())
                                  ->findOrFail($id);

        // Group slots by weekday
        $weeklySlots = [];
        foreach ($availability->availabilitySlots as $slot) {
            $weeklySlots[] = [
                'weekday' => $slot->weekday,
                'start_time' => Carbon::parse($slot->start_time)->format('H:i'),
                'end_time' => Carbon::parse($slot->end_time)->format('H:i'),
            ];
        }

        return view('professional.availability.edit', compact('availability', 'weeklySlots'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'months' => 'required|array|min:1',
            'months.*' => 'string|regex:/^\d{4}-\d{2}$/',
            'session_duration' => 'required|integer|min:15|max:240',
            'weekly_slots' => 'required|string', // JSON string from frontend
        ]);

        $availability = Availability::findOrFail($id);
        if ($availability->professional_id != Auth::guard('professional')->id()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized access'
            ], 403);
        }

        // Parse weekly slots JSON
        $weeklySlots = json_decode($request->weekly_slots, true);
        if (!$weeklySlots || !is_array($weeklySlots)) {
            return response()->json([
                'success' => false,
                'errors' => ['Invalid weekly slots data']
            ], 422);
        }

        $selectedMonths = $request->months;
        $firstMonth = array_shift($selectedMonths);
        
        $successfulMonths = [];
        $skippedMonths = [];

        // Validate time slots
        $errors = [];
        foreach ($weeklySlots as $index => $slot) {
            if (!isset($slot['weekday']) || !isset($slot['start_time']) || !isset($slot['end_time'])) {
                $errors[] = "Invalid slot data at position " . ($index + 1);
                continue;
            }
            
            try {
                $startTime = Carbon::createFromFormat('H:i', $slot['start_time']);
                $endTime = Carbon::createFromFormat('H:i', $slot['end_time']);
                
                if ($startTime->gte($endTime)) {
                    $errors[] = "Start time must be before end time for slot #" . ($index + 1);
                }
            } catch (\Exception $e) {
                $errors[] = "Invalid time format for slot #" . ($index + 1);
            }
        }
        
        if (count($errors) > 0) {
            return response()->json([
                'success' => false,
                'errors' => $errors
            ], 422);
        }

        try {
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
                    'weekdays' => json_encode([]), // Keep for backward compatibility
                ]);

                // Clear existing slots and create new ones
                $availability->availabilitySlots()->delete();

                foreach ($weeklySlots as $slot) {
                    AvailabilitySlot::create([
                        'availability_id' => $availability->id,
                        'weekday' => $slot['weekday'],
                        'start_time' => $slot['start_time'] . ':00',
                        'end_time' => $slot['end_time'] . ':00',
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
                        'weekdays' => json_encode([]), // Keep for backward compatibility
                    ]);

                    foreach ($weeklySlots as $slot) {
                        AvailabilitySlot::create([
                            'availability_id' => $newAvailability->id,
                            'weekday' => $slot['weekday'],
                            'start_time' => $slot['start_time'] . ':00',
                            'end_time' => $slot['end_time'] . ':00',
                        ]);
                    }
                    
                    $successfulMonths[] = $month;
                } catch (\Exception $e) {
                    Log::error("Failed to create availability for month {$month}: " . $e->getMessage());
                }
            }

        } catch (\Exception $e) {
            Log::error("Failed to update availability: " . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to update availability: ' . $e->getMessage()
            ], 500);
        }

        // Prepare response message
        $message = '';
        if (count($successfulMonths) > 0) {
            $message .= 'Availability updated for ' . count($successfulMonths) . ' month(s). ';
        }
        if (count($skippedMonths) > 0) {
            $message .= count($skippedMonths) . ' month(s) already had availability and were skipped. ';
        }

        return response()->json([
            'success' => true,
            'message' => $message,
            'redirect' => route('professional.availability.index')
        ]);
    }

    public function destroy($id)
    {
        $availability = Availability::findOrFail($id);
        
        if ($availability->professional_id != Auth::guard('professional')->id()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized access'
            ], 403);
        }

        try {
            // Delete associated slots first
            $availability->availabilitySlots()->delete();
            
            // Delete the availability
            $availability->delete();

            return response()->json([
                'success' => true,
                'message' => 'Availability deleted successfully'
            ]);
        } catch (\Exception $e) {
            Log::error("Failed to delete availability: " . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete availability'
            ], 500);
        }
    }
}