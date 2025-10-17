<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Availability;
use App\Models\AvailabilitySlot;
use App\Models\Booking;
use App\Models\Professional;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class ProfessionalAvailabilityController extends Controller
{
    /**
     * Get professional's availability for a specific month
     */
    public function getAvailability(Request $request, $professionalId): JsonResponse
    {
        $request->validate([
            'month' => 'required|string|regex:/^\d{4}-\d{2}$/',
        ]);

        $professional = Professional::findOrFail($professionalId);
        $month = $request->month;

        $availability = Availability::with('availabilitySlots')
                                  ->where('professional_id', $professionalId)
                                  ->where('month', $month)
                                  ->first();

        if (!$availability) {
            return response()->json([
                'success' => false,
                'message' => 'No availability found for this month',
                'data' => null
            ]);
        }

        // Group slots by weekday
        $weeklySlots = [];
        foreach ($availability->availabilitySlots as $slot) {
            $weekday = $slot->weekday;
            if (!isset($weeklySlots[$weekday])) {
                $weeklySlots[$weekday] = [];
            }
            
            $weeklySlots[$weekday][] = [
                'start_time' => Carbon::parse($slot->start_time)->format('H:i'),
                'end_time' => Carbon::parse($slot->end_time)->format('H:i'),
            ];
        }

        return response()->json([
            'success' => true,
            'data' => [
                'professional' => [
                    'id' => $professional->id,
                    'name' => $professional->first_name . ' ' . $professional->last_name,
                ],
                'availability' => [
                    'id' => $availability->id,
                    'month' => $availability->month,
                    'session_duration' => $availability->session_duration,
                    'weekly_slots' => $weeklySlots,
                ]
            ]
        ]);
    }

    /**
     * Get available dates for a professional in a given month
     */
    public function getAvailableDates(Request $request, $professionalId): JsonResponse
    {
        $request->validate([
            'month' => 'required|string|regex:/^\d{4}-\d{2}$/',
        ]);

        $professionalId = (int) $professionalId;
        $month = $request->month;

        // Get professional's availability for the month
        $availability = Availability::with('availabilitySlots')
                                  ->where('professional_id', $professionalId)
                                  ->where('month', $month)
                                  ->first();

        if (!$availability) {
            return response()->json([
                'success' => true,
                'data' => []
            ]);
        }

        // Get weekdays that have slots
        $availableWeekdays = $availability->availabilitySlots
                           ->pluck('weekday')
                           ->unique()
                           ->toArray();

        if (empty($availableWeekdays)) {
            return response()->json([
                'success' => true,
                'data' => []
            ]);
        }

        // Generate dates for the month
        $year = (int) substr($month, 0, 4);
        $monthNum = (int) substr($month, 5, 2);
        
        $startDate = Carbon::create($year, $monthNum, 1);
        $endDate = $startDate->copy()->endOfMonth();
        
        $availableDates = [];
        $current = $startDate->copy();
        
        // Map weekday names to Carbon day numbers
        $weekdayMap = [
            'mon' => Carbon::MONDAY,
            'tue' => Carbon::TUESDAY,
            'wed' => Carbon::WEDNESDAY,
            'thu' => Carbon::THURSDAY,
            'fri' => Carbon::FRIDAY,
            'sat' => Carbon::SATURDAY,
            'sun' => Carbon::SUNDAY,
        ];

        while ($current->lte($endDate)) {
            // Skip past dates
            if ($current->lt(Carbon::today())) {
                $current->addDay();
                continue;
            }
            
            $dayOfWeek = $current->dayOfWeek;
            
            // Check if this day has availability
            foreach ($availableWeekdays as $weekday) {
                if (isset($weekdayMap[$weekday]) && $weekdayMap[$weekday] === $dayOfWeek) {
                    $availableDates[] = $current->format('Y-m-d');
                    break;
                }
            }
            
            $current->addDay();
        }

        return response()->json([
            'success' => true,
            'data' => $availableDates
        ]);
    }

    /**
     * Get available time slots for a specific date
     */
    public function getAvailableSlots(Request $request, $professionalId): JsonResponse
    {
        $request->validate([
            'date' => 'required|date|after_or_equal:today',
        ]);

        $professionalId = (int) $professionalId;
        $date = Carbon::parse($request->date);
        $month = $date->format('Y-m');
        
        // Map Carbon day numbers to weekday names
        $weekdayMap = [
            Carbon::MONDAY => 'mon',
            Carbon::TUESDAY => 'tue',
            Carbon::WEDNESDAY => 'wed',
            Carbon::THURSDAY => 'thu',
            Carbon::FRIDAY => 'fri',
            Carbon::SATURDAY => 'sat',
            Carbon::SUNDAY => 'sun',
        ];
        
        $weekday = $weekdayMap[$date->dayOfWeek] ?? null;
        
        if (!$weekday) {
            return response()->json([
                'success' => true,
                'data' => []
            ]);
        }

        // Get professional's availability for the month
        $availability = Availability::with(['availabilitySlots' => function($query) use ($weekday) {
                                      $query->where('weekday', $weekday);
                                  }])
                                  ->where('professional_id', $professionalId)
                                  ->where('month', $month)
                                  ->first();

        if (!$availability || $availability->availabilitySlots->isEmpty()) {
            return response()->json([
                'success' => true,
                'data' => []
            ]);
        }

        $sessionDuration = $availability->session_duration;
        $availableSlots = [];

        // Get existing bookings for this date
        $existingBookings = Booking::where('professional_id', $professionalId)
                                  ->where('booking_date', $date->format('Y-m-d'))
                                  ->where('status', '!=', 'cancelled')
                                  ->get(['booking_time', 'session_duration']);

        foreach ($availability->availabilitySlots as $slot) {
            $startTime = Carbon::parse($slot->start_time);
            $endTime = Carbon::parse($slot->end_time);
            
            // Generate time slots based on session duration
            $currentSlot = $startTime->copy();
            
            while ($currentSlot->copy()->addMinutes($sessionDuration)->lte($endTime)) {
                $slotStart = $currentSlot->format('H:i');
                $slotEnd = $currentSlot->copy()->addMinutes($sessionDuration)->format('H:i');
                
                // Check if this slot is already booked
                $isBooked = false;
                foreach ($existingBookings as $booking) {
                    $bookingStart = Carbon::parse($booking->booking_time);
                    $bookingEnd = $bookingStart->copy()->addMinutes($booking->session_duration ?? $sessionDuration);
                    
                    // Check for overlap
                    if ($currentSlot->lt($bookingEnd) && $currentSlot->copy()->addMinutes($sessionDuration)->gt($bookingStart)) {
                        $isBooked = true;
                        break;
                    }
                }
                
                // Only add if not booked and not in the past for today
                $slotDateTime = $date->copy()->setTimeFromTimeString($slotStart);
                $isInPast = $date->isToday() && $slotDateTime->lt(Carbon::now());
                
                if (!$isBooked && !$isInPast) {
                    $availableSlots[] = [
                        'start_time' => $slotStart,
                        'end_time' => $slotEnd,
                        'duration' => $sessionDuration,
                    ];
                }
                
                $currentSlot->addMinutes($sessionDuration);
            }
        }

        return response()->json([
            'success' => true,
            'data' => [
                'date' => $date->format('Y-m-d'),
                'weekday' => $weekday,
                'session_duration' => $sessionDuration,
                'slots' => $availableSlots
            ]
        ]);
    }
}