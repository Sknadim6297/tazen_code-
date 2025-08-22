<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\BookingTimedate;
use App\Models\Availability;
use App\Models\AvailabilitySlot;
use App\Models\Professional;
use App\Models\Admin;
use App\Notifications\AppointmentRescheduled;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

class UpcomingAppointmentController extends Controller
{
    public function index(Request $request)
    {
        try {
            $serviceOptions = Booking::where('user_id', Auth::guard('user')->id())
                ->select('service_name')
                ->distinct()
                ->whereNotNull('service_name')
                ->where('service_name', '!=', '')
                ->orderBy('service_name')
                ->pluck('service_name');
                
            $planTypeOptions = Booking::where('user_id', Auth::guard('user')->id())
                ->select('plan_type')
                ->distinct()
                ->whereNotNull('plan_type')
                ->where('plan_type', '!=', '')
                ->orderBy('plan_type')
                ->pluck('plan_type');
                
            $query = Booking::with([
                'professional' => function ($q) {
                    $q->select('id', 'name');
                }
            ])->where('user_id', Auth::guard('user')->id());

            // Apply search filters if provided
            if ($request->filled('search_name')) {
                $search = $request->search_name;
                $query->where(function($q) use ($search) {
                    $q->where('service_name', 'like', "%{$search}%")
                      ->orWhere('plan_type', 'like', "%{$search}%")
                      ->orWhereHas('professional', function ($q2) use ($search) {
                          $q2->where('name', 'like', "%{$search}%");
                      });
                });
            }
            
            // Apply service filter if provided
            if ($request->filled('service') && $request->service !== 'all') {
                $query->where('service_name', $request->service);
            }
            
            // Apply plan type filter if provided
            if ($request->filled('plan_type') && $request->plan_type !== 'all') {
                $query->where('plan_type', $request->plan_type);
            }

            // Get the bookings
            $allBookings = $query->get();
            
            // Get current date
            $today = Carbon::today();
            $processedBookings = collect();
            
            foreach ($allBookings as $booking) {
                try {
                    // CHANGED: Get all pending/confirmed future timedates (removed 3-day limit)
                    $upcomingTimedates = BookingTimedate::where('booking_id', $booking->id)
                        ->whereIn('status', ['pending', 'confirmed'])
                        ->where('date', '>=', $today->format('Y-m-d')) // Only future dates
                        ->orderBy('date', 'asc')
                        ->get();
                    
                    // Only add this booking if it has any future timedates
                    if ($upcomingTimedates->isNotEmpty()) {
                        // Get the first upcoming timedate
                        $nextTimedate = $upcomingTimedates->first();
                        
                        // Replace the timedates collection with just this single upcoming timedate
                        $booking->setRelation('timedates', collect([$nextTimedate]));
                        
                        // Get all timedates to calculate sessions
                        $allTimedates = BookingTimedate::where('booking_id', $booking->id)->get();
                        
                        // Add calculated session information
                        $booking->sessions_taken = $allTimedates->where('status', 'completed')->count();
                        $booking->total_sessions = $allTimedates->count();
                        $booking->sessions_remaining = $booking->total_sessions - $booking->sessions_taken;
                        
                        $processedBookings->push($booking);
                    }
                } catch (\Exception $e) {
                    // Continue with next booking even if this one fails
                    Log::error('Error processing booking ID ' . $booking->id . ': ' . $e->getMessage());
                    continue;
                }
            }
            
            // Apply date filtering if requested
            if ($request->filled('search_date_from') || $request->filled('search_date_to')) {
                $processedBookings = $processedBookings->filter(function ($booking) use ($request) {
                    $timedate = $booking->timedates->first();
                    if (!$timedate) return false;
                    
                    $date = Carbon::parse($timedate->date);
                    
                    if ($request->filled('search_date_from') && $request->filled('search_date_to')) {
                        $from = Carbon::parse($request->search_date_from);
                        $to = Carbon::parse($request->search_date_to);
                        return $date->between($from, $to);
                    } elseif ($request->filled('search_date_from')) {
                        return $date->gte(Carbon::parse($request->search_date_from));
                    } elseif ($request->filled('search_date_to')) {
                        return $date->lte(Carbon::parse($request->search_date_to));
                    }
                    
                    return true;
                });
            }
            
            // Sort by the nearest upcoming date
            $sortedBookings = $processedBookings->sortBy(function ($booking) {
                $timedate = $booking->timedates->first();
                return $timedate ? Carbon::parse($timedate->date)->timestamp : PHP_INT_MAX;
            })->values();
            
            // Format plan types for display
            $formattedPlanTypes = [];
            foreach ($planTypeOptions as $planType) {
                $formattedPlanTypes[$planType] = $this->formatPlanType($planType);
            }
            
            // Format bookings with plan type display names
            $formattedBookings = $sortedBookings->map(function ($booking) {
                $booking->formatted_plan_type = $this->formatPlanType($booking->plan_type);
                return $booking;
            });
            
            // Pass to view
            $bookings = $formattedBookings;
            
            return view('customer.upcoming-appointment.index', compact('bookings', 'serviceOptions', 'planTypeOptions', 'formattedPlanTypes'));
        } catch (\Exception $e) {
            // Provide a friendly error message to the user
            Log::error('Error in upcoming appointments: ' . $e->getMessage());
            return redirect()->back()->with('error', 'An error occurred while loading your appointments. Please try again later.');
        }
    }

    /**
     * Format plan type for better display
     */
    private function formatPlanType($planType) 
    {
        if (empty($planType)) return null;
        
        // Handle special case for "one_time"
        if (strtolower($planType) == 'one_time') {
            return 'One Time';
        }
        
        // Replace underscores with spaces and capitalize each word
        return ucwords(str_replace('_', ' ', $planType));
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

    public function uploadDocument(Request $request)
    {
        try {
            // Validate the request
            $request->validate([
                'document' => 'required|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:2048',
                'booking_id' => 'required|exists:bookings,id'
            ]);

            // Log the request data for debugging
            Log::info('Upload document request:', [
                'booking_id' => $request->booking_id,
                'has_file' => $request->hasFile('document'),
                'file_name' => $request->hasFile('document') ? $request->file('document')->getClientOriginalName() : null,
            ]);

            $booking = Booking::findOrFail($request->booking_id);

            if ($request->hasFile('document')) {
                $file = $request->file('document');
                if ($booking->customer_document && Storage::disk('public')->exists($booking->customer_document)) {
                    try {
                        Storage::disk('public')->delete($booking->customer_document);
                    } catch (\Exception $e) {
                        Log::warning('Failed to delete old file: ' . $e->getMessage());
                    }
                }

                $fileName = time() . '_' . str_replace(' ', '_', $file->getClientOriginalName());

                try {
                    $path = $file->storeAs('customer-documents', $fileName, 'public');
                    if (!Storage::disk('public')->exists($path)) {
                        throw new \Exception('File was not stored properly');
                    }

                    $booking->customer_document = $path;
                    $booking->save();

                    return response()->json([
                        'success' => true,
                        'message' => 'Document uploaded successfully',
                        'file' => [
                            'path' => $path,
                            'url' => Storage::disk('public')->url($path),
                            'name' => $fileName,
                            'type' => $file->getClientOriginalExtension(),
                            'size' => $this->formatFileSize($file->getSize())
                        ]
                    ]);
                } catch (\Exception $e) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Error storing file: ' . $e->getMessage()
                    ], 500);
                }
            }

            return response()->json([
                'success' => false,
                'message' => 'No document was uploaded'
            ], 400);
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Validation error: ' . json_encode($e->errors()));
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            Log::error('Document upload error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error uploading document: ' . $e->getMessage()
            ], 500);
        }
    }

    private function formatFileSize($size)
    {
        $units = ['B', 'KB', 'MB', 'GB'];
        $i = 0;
        while ($size >= 1024 && $i < count($units) - 1) {
            $size /= 1024;
            $i++;
        }
        return round($size, 2) . ' ' . $units[$i];
    }

    public function getDocumentInfo($id)
    {
        try {
            $booking = Booking::findOrFail($id);

            if (!$booking->customer_document) {
                return response()->json([
                    'success' => false,
                    'message' => 'No document found'
                ], 404);
            }

            if (!Storage::disk('public')->exists($booking->customer_document)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Document file not found'
                ], 404);
            }

            $path = $booking->customer_document;
            $fileInfo = [
                'path' => $path,
                'url' => Storage::disk('public')->url($path),
                'name' => basename($path),
                'type' => pathinfo($path, PATHINFO_EXTENSION),
                'size' => $this->formatFileSize(Storage::disk('public')->size($path))
            ];

            return response()->json([
                'success' => true,
                'file' => $fileInfo
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error getting document information'
            ], 500);
        }
    }

    /**
     * Get professional availability data for calendar
     */
    public function getProfessionalAvailability($professionalId)
    {
        try {
            Log::info('Getting professional availability', [
                'professional_id' => $professionalId,
                'user_id' => Auth::guard('user')->id()
            ]);
            
            // Get professional availability
            $availabilities = Availability::where('professional_id', $professionalId)
                ->with('slots')
                ->get();

            Log::info('Found availabilities', [
                'count' => $availabilities->count(),
                'data' => $availabilities->toArray()
            ]);

            // Format availability data with improved month handling
            $availabilityData = [];
            $monthMap = [
                'jan' => 1, 'feb' => 2, 'mar' => 3, 'apr' => 4,
                'may' => 5, 'jun' => 6, 'jul' => 7, 'aug' => 8,
                'sep' => 9, 'oct' => 10, 'nov' => 11, 'dec' => 12
            ];
            
            foreach ($availabilities as $availability) {
                $weekdays = $availability->weekdays;
                
                // Handle different weekdays format
                if (is_string($weekdays)) {
                    $weekdays = json_decode($weekdays, true);
                }
                
                // Normalize weekdays to 3-letter format
                $normalizedWeekdays = array_map(function($day) {
                    $dayMap = [
                        'sunday' => 'sun', 'monday' => 'mon', 'tuesday' => 'tue', 
                        'wednesday' => 'wed', 'thursday' => 'thu', 'friday' => 'fri', 'saturday' => 'sat'
                    ];
                    $lowerDay = strtolower($day);
                    return $dayMap[$lowerDay] ?? $lowerDay;
                }, $weekdays ?: []);
                
                // Convert month name to number for easier handling
                $monthNum = $monthMap[strtolower($availability->month)] ?? null;
                
                if ($monthNum && $availability->slots->count() > 0) {
                    $availabilityData[] = [
                        'month' => $availability->month,
                        'month_number' => $monthNum,
                        'weekdays' => $normalizedWeekdays,
                        'original_weekdays' => $weekdays,
                        'slots' => $availability->slots->map(function ($slot) {
                            // Format time to match the booking time_slot format
                            $startTime = \Carbon\Carbon::createFromFormat('H:i:s', $slot->start_time)->format('h:i A');
                            $endTime = \Carbon\Carbon::createFromFormat('H:i:s', $slot->end_time)->format('h:i A');
                            $formattedTimeSlot = $startTime . ' - ' . $endTime;
                            
                            return [
                                'time' => $formattedTimeSlot,
                                'start_time' => $slot->start_time,
                                'end_time' => $slot->end_time,
                                'id' => $slot->id
                            ];
                        })->toArray()
                    ];
                }
            }

            // Get booked time slots for the next 12 months
            $bookedTimeSlots = BookingTimedate::whereHas('booking', function ($query) use ($professionalId) {
                $query->where('professional_id', $professionalId)
                    ->whereIn('status', ['pending', 'confirmed']);
            })->where('date', '>=', Carbon::today()->format('Y-m-d'))
              ->where('date', '<=', Carbon::today()->addMonths(12)->format('Y-m-d'))
              ->get();

            $bookedSlots = [];
            foreach ($bookedTimeSlots as $slot) {
                $date = $slot->date;
                if (!isset($bookedSlots[$date])) {
                    $bookedSlots[$date] = [];
                }
                
                // Normalize time slot format to match availability slots
                $timeSlot = $slot->time_slot;
                // Convert "06:00 PM to 06:30 PM" to "06:00 PM - 06:30 PM"
                $normalizedTimeSlot = str_replace(' to ', ' - ', $timeSlot);
                
                $bookedSlots[$date][] = $normalizedTimeSlot;
            }

            Log::info('Processed booked slots', [
                'original_count' => $bookedTimeSlots->count(),
                'normalized_slots' => $bookedSlots
            ]);

            Log::info('Final availability data', [
                'availability_count' => count($availabilityData),
                'booked_slots_count' => count($bookedSlots),
                'availability_data' => $availabilityData
            ]);

            return response()->json([
                'success' => true,
                'availability' => $availabilityData,
                'bookedSlots' => $bookedSlots
            ]);
        } catch (\Exception $e) {
            Log::error('Error getting professional availability: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            return response()->json([
                'success' => false,
                'message' => 'Error loading availability data: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Reschedule an appointment
     */
    public function reschedule(Request $request)
    {
        try {
            Log::info('Reschedule request received', [
                'all_data' => $request->all(),
                'user_id' => Auth::guard('user')->id()
            ]);
            
            $request->validate([
                'booking_id' => 'required|exists:bookings,id',
                'timedate_id' => 'required|exists:booking_timedates,id',
                'professional_id' => 'required|exists:professionals,id',
                'new_date' => 'required|date|after_or_equal:today',
                'new_time_slot' => 'required|string'
            ]);

            $booking = Booking::findOrFail($request->booking_id);
            
            // Verify the booking belongs to the authenticated user
            if ($booking->user_id !== Auth::guard('user')->id()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized access to this booking'
                ], 403);
            }

            $timedate = BookingTimedate::findOrFail($request->timedate_id);
            
            Log::info('Current timedate before update', [
                'timedate_id' => $timedate->id,
                'current_date' => $timedate->date,
                'current_time_slot' => $timedate->time_slot,
                'requested_date' => $request->new_date,
                'requested_time_slot' => $request->new_time_slot
            ]);
            
            // Verify the timedate belongs to the booking
            if ($timedate->booking_id !== $booking->id) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid timedate for this booking'
                ], 400);
            }
            
            // Check if trying to reschedule to the same date and time
            if ($timedate->date === $request->new_date && $timedate->time_slot === $request->new_time_slot) {
                return response()->json([
                    'success' => false,
                    'message' => 'Please select a different date or time for rescheduling'
                ], 400);
            }
            
            // Check if the new time slot is available using the new method
            $isSlotTaken = BookingTimedate::isSlotBooked($request->professional_id, $request->new_date, $request->new_time_slot);

            if ($isSlotTaken) {
                return response()->json([
                    'success' => false,
                    'message' => 'The selected time slot is no longer available'
                ], 400);
            }

            // Check if professional has availability for the selected date and time
            $newDate = Carbon::parse($request->new_date);
            $dayName = strtolower($newDate->format('D')); // mon, tue, etc.
            $monthName = strtolower($newDate->format('M')); // jan, feb, etc.
            $monthNumber = $newDate->format('n'); // 1-12

            Log::info('Checking availability for', [
                'date' => $request->new_date,
                'day_name' => $dayName,
                'month_name' => $monthName,
                'month_number' => $monthNumber,
                'time_slot' => $request->new_time_slot
            ]);

            $availability = Availability::where('professional_id', $request->professional_id)
                ->where('month', $monthName)
                ->whereHas('slots', function ($query) use ($request) {
                    // Extract start time from the formatted time slot "06:00 PM - 06:45 PM"
                    $timeParts = explode(' - ', $request->new_time_slot);
                    if (count($timeParts) === 2) {
                        $startTime = \Carbon\Carbon::createFromFormat('h:i A', trim($timeParts[0]))->format('H:i:s');
                        $query->where('start_time', $startTime);
                    } else {
                        // Fallback: treat as start time directly
                        $query->where('start_time', $request->new_time_slot);
                    }
                })
                ->first();

            if (!$availability) {
                Log::warning('No availability found for month and time', [
                    'professional_id' => $request->professional_id,
                    'month' => $monthName,
                    'time_slot' => $request->new_time_slot
                ]);
                return response()->json([
                    'success' => false,
                    'message' => 'Professional is not available at the selected time'
                ], 400);
            }

            // Check if the day is available
            $weekdays = $availability->weekdays;
            if (is_string($weekdays)) {
                $weekdays = json_decode($weekdays, true);
            }
            
            // Normalize weekdays for comparison
            $normalizedWeekdays = array_map(function($day) {
                $dayMap = [
                    'sunday' => 'sun', 'monday' => 'mon', 'tuesday' => 'tue', 
                    'wednesday' => 'wed', 'thursday' => 'thu', 'friday' => 'fri', 'saturday' => 'sat'
                ];
                $lowerDay = strtolower($day);
                return $dayMap[$lowerDay] ?? $lowerDay;
            }, $weekdays);
            
            Log::info('Day availability check', [
                'requested_day' => $dayName,
                'available_days' => $weekdays,
                'normalized_days' => $normalizedWeekdays
            ]);
            
            if (!in_array($dayName, $normalizedWeekdays)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Professional is not available on the selected day'
                ], 400);
            }

            // Update the booking timedate
            $oldDate = $timedate->date;
            $oldTimeSlot = $timedate->time_slot;
            
            $timedate->date = $request->new_date;
            $timedate->time_slot = $request->new_time_slot;
            $saved = $timedate->save();

            // Verify the update
            $timedate->refresh();
            
            Log::info('Appointment rescheduled successfully', [
                'booking_id' => $request->booking_id,
                'timedate_id' => $request->timedate_id,
                'old_date' => $oldDate,
                'old_time' => $oldTimeSlot,
                'new_date' => $timedate->date,
                'new_time' => $timedate->time_slot,
                'save_result' => $saved,
                'user_id' => Auth::guard('user')->id()
            ]);

            // Send notifications to professional and admins
            try {
                $customer = Auth::guard('user')->user();
                $professional = Professional::find($request->professional_id);
                $admins = Admin::all();

                // Notify the professional
                if ($professional) {
                    $professional->notify(new AppointmentRescheduled(
                        $booking, 
                        $timedate, 
                        $customer, 
                        $oldDate, 
                        $oldTimeSlot, 
                        $timedate->date, 
                        $timedate->time_slot
                    ));
                    Log::info('Notification sent to professional', ['professional_id' => $professional->id]);
                }

                // Notify all admins
                foreach ($admins as $admin) {
                    $admin->notify(new AppointmentRescheduled(
                        $booking, 
                        $timedate, 
                        $customer, 
                        $oldDate, 
                        $oldTimeSlot, 
                        $timedate->date, 
                        $timedate->time_slot
                    ));
                }
                Log::info('Notifications sent to admins', ['admin_count' => $admins->count()]);

            } catch (\Exception $e) {
                Log::error('Error sending reschedule notifications: ' . $e->getMessage(), [
                    'booking_id' => $booking->id,
                    'professional_id' => $request->professional_id
                ]);
                // Don't fail the reschedule if notifications fail
            }

            return response()->json([
                'success' => true,
                'message' => 'Appointment rescheduled successfully!',
                'data' => [
                    'old_date' => $oldDate,
                    'old_time' => $oldTimeSlot,
                    'new_date' => $timedate->date,
                    'new_time' => $timedate->time_slot
                ]
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            Log::error('Error rescheduling appointment: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error rescheduling appointment. Please try again.'
            ], 500);
        }
    }

    public function cancelAppointment(Request $request)
    {
        try {
            // Validate the request
            $request->validate([
                'booking_id' => 'required|exists:bookings,id',
            ]);

            $booking = Booking::findOrFail($request->booking_id);

            // Find the associated timedate
            $timedate = $booking->timedates()->where('date', '>=', Carbon::today())->first();
            if (!$timedate) {
                return response()->json([
                    'success' => false,
                    'message' => 'No upcoming timedate found for this booking'
                ], 404);
            }

            // Update the timedate status to 'canceled'
            $timedate->status = 'canceled';
            $timedate->save();

            return response()->json([
                'success' => true,
                'message' => 'Appointment canceled successfully'
            ]);
        } catch (\Exception $e) {
            Log::error('Error canceling appointment: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error canceling appointment: ' . $e->getMessage()
            ], 500);
        }
    }
}
