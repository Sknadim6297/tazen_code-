<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\BookingTimedate;
use App\Models\Professional;
use App\Models\Admin;
use App\Models\Availability;
use App\Models\AvailabilitySlot;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;
use Carbon\Carbon;

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
            if ($request->filled('service') && $request->service !== 'all') {
                $query->where('service_name', $request->service);
            }
            if ($request->filled('plan_type') && $request->plan_type !== 'all') {
                $query->where('plan_type', $request->plan_type);
            }
            $allBookings = $query->get();
            $today = Carbon::today();
            $processedBookings = collect();
            
            foreach ($allBookings as $booking) {
                try {
                    $upcomingTimedates = BookingTimedate::where('booking_id', $booking->id)
                        ->whereIn('status', ['pending', 'confirmed'])
                        ->where('date', '>=', $today->format('Y-m-d')) // Only future dates
                        ->orderBy('date', 'asc')
                        ->get();
                    if ($upcomingTimedates->isNotEmpty()) {
                        $nextTimedate = $upcomingTimedates->first();
                        $booking->setRelation('timedates', collect([$nextTimedate]));
                        $allTimedates = BookingTimedate::where('booking_id', $booking->id)->get();
                        $booking->sessions_taken = $allTimedates->where('status', 'completed')->count();
                        $booking->total_sessions = $allTimedates->count();
                        $booking->sessions_remaining = $booking->total_sessions - $booking->sessions_taken;
                        
                        $processedBookings->push($booking);
                    }
                } catch (\Exception $e) {
                    Log::error('Error processing booking ID ' . $booking->id . ': ' . $e->getMessage());
                    continue;
                }
            }
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
            $sortedBookings = $processedBookings->sortBy(function ($booking) {
                $timedate = $booking->timedates->first();
                return $timedate ? Carbon::parse($timedate->date)->timestamp : PHP_INT_MAX;
            })->values();
            $formattedPlanTypes = [];
            foreach ($planTypeOptions as $planType) {
                $formattedPlanTypes[$planType] = $this->formatPlanType($planType);
            }
            $formattedBookings = $sortedBookings->map(function ($booking) {
                $booking->formatted_plan_type = $this->formatPlanType($booking->plan_type);
                return $booking;
            });
            $bookings = $formattedBookings;
            
            return view('customer.upcoming-appointment.index', compact('bookings', 'serviceOptions', 'planTypeOptions', 'formattedPlanTypes'));
        } catch (\Exception $e) {
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
        if (strtolower($planType) == 'one_time') {
            return 'One Time';
        }
        return ucwords(str_replace('_', ' ', $planType));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
    }

    public function uploadDocument(Request $request)
    {
        try {
            $request->validate([
                'document' => 'required|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:2048',
                'booking_id' => 'required|exists:bookings,id'
            ]);
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

    public function cancelAppointment(Request $request)
    {
        try {
            $request->validate([
                'booking_id' => 'required|exists:bookings,id',
            ]);

            $booking = Booking::findOrFail($request->booking_id);
            $timedate = $booking->timedates()->where('date', '>=', Carbon::today())->first();
            if (!$timedate) {
                return response()->json([
                    'success' => false,
                    'message' => 'No upcoming timedate found for this booking'
                ], 404);
            }
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

    /**
     * Get professional availability for reschedule calendar
     */
    public function getProfessionalAvailability(Booking $booking)
    {
        try {
            // Verify booking belongs to authenticated user
            if ($booking->user_id !== Auth::guard('user')->id()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized access'
                ], 403);
            }

            // Check if reschedule is allowed
            if ($booking->reschedule_count >= $booking->max_reschedules_allowed) {
                return response()->json([
                    'success' => false,
                    'message' => 'Maximum reschedule limit reached'
                ], 400);
            }

            $professionalId = $booking->professional_id;
            
            // Get availability for next 6 months
            $months = [];
            for ($i = 0; $i < 6; $i++) {
                $months[] = Carbon::now()->addMonths($i)->format('Y-m');
            }

            // Get availability for the next 6 months
            $availabilities = Availability::with('availabilitySlots')
                ->where('professional_id', $professionalId)
                ->whereIn('month', $months)
                ->get();

            $availabilityData = [];
            foreach ($availabilities as $availability) {
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

                $availabilityData[] = [
                    'month' => $availability->month,
                    'session_duration' => $availability->session_duration,
                    'weekly_slots' => $weeklySlots
                ];
            }

            // Get existing bookings for this professional (excluding current booking)
            $existingBookings = BookingTimedate::whereHas('booking', function($query) use ($professionalId, $booking) {
                    $query->where('professional_id', $professionalId)
                          ->where('id', '!=', $booking->id)
                          ->whereIn('status', ['pending', 'confirmed']);
                })
                ->where('date', '>=', Carbon::today())
                ->whereIn('status', ['pending', 'confirmed'])
                ->get(['date', 'time_slot'])
                ->groupBy('date')
                ->map(function($timedates) {
                    return $timedates->pluck('time_slot')->toArray();
                })
                ->toArray();

            return response()->json([
                'success' => true,
                'data' => $availabilityData,
                'existing_bookings' => $existingBookings,
                'professional' => [
                    'id' => $booking->professional->id,
                    'name' => $booking->professional->name
                ]
            ]);

        } catch (\Exception $e) {
            Log::error('Error getting professional availability: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error loading availability'
            ], 500);
        }
    }

    /**
     * Process reschedule request
     */
    public function reschedule(Request $request, Booking $booking)
    {
        try {
            // Verify booking belongs to authenticated user
            if ($booking->user_id !== Auth::guard('user')->id()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized access'
                ], 403);
            }

            // Validate request
            $request->validate([
                'new_date' => 'required|date|after:today',
                'new_time_slot' => 'required|string',
                'reschedule_reason' => 'required|string|max:500'
            ]);

            // Check if reschedule is allowed
            if ($booking->reschedule_count >= $booking->max_reschedules_allowed) {
                return response()->json([
                    'success' => false,
                    'message' => 'Maximum reschedule limit reached'
                ], 400);
            }

            $newDate = Carbon::parse($request->new_date);
            $newTimeSlot = $request->new_time_slot;

            // Check if the new slot is available
            $conflictingTimedate = BookingTimedate::where('booking_id', '!=', $booking->id)
                ->whereHas('booking', function($query) use ($booking) {
                    $query->where('professional_id', $booking->professional_id)
                          ->where('status', '!=', 'cancelled');
                })
                ->where('date', $newDate->format('Y-m-d'))
                ->where('time_slot', $newTimeSlot)
                ->whereIn('status', ['pending', 'confirmed'])
                ->exists();

            if ($conflictingTimedate) {
                return response()->json([
                    'success' => false,
                    'message' => 'Selected time slot is no longer available'
                ], 400);
            }

            // Get the upcoming timedate to reschedule
            $upcomingTimedate = BookingTimedate::where('booking_id', $booking->id)
                ->where('date', '>=', Carbon::today()->format('Y-m-d'))
                ->whereIn('status', ['pending', 'confirmed'])
                ->orderBy('date', 'asc')
                ->first();

            if (!$upcomingTimedate) {
                return response()->json([
                    'success' => false,
                    'message' => 'No upcoming appointment found to reschedule'
                ], 404);
            }

            // Store original booking details if this is the first reschedule
            if ($booking->reschedule_count === 0) {
                $booking->original_date = $upcomingTimedate->date;
                $booking->original_time_slot = $upcomingTimedate->time_slot;
            }

            // Update booking reschedule info
            $booking->reschedule_count += 1;
            $booking->reschedule_reason = $request->reschedule_reason;
            $booking->reschedule_requested_at = Carbon::now();
            $booking->reschedule_approved_at = Carbon::now(); // Auto-approve for now
            $booking->save();

            // Update the timedate
            $upcomingTimedate->date = $newDate->format('Y-m-d');
            $upcomingTimedate->time_slot = $newTimeSlot;
            $upcomingTimedate->status = 'confirmed'; // Confirm the new slot
            $upcomingTimedate->save();

            // Log the reschedule action
            Log::info('Appointment rescheduled', [
                'booking_id' => $booking->id,
                'user_id' => Auth::guard('user')->id(),
                'old_date' => $booking->original_date ?? 'unknown',
                'old_time' => $booking->original_time_slot ?? 'unknown',
                'new_date' => $newDate->format('Y-m-d'),
                'new_time' => $newTimeSlot,
                'reason' => $request->reschedule_reason
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Appointment rescheduled successfully',
                'data' => [
                    'new_date' => $newDate->format('M d, Y'),
                    'new_time_slot' => $newTimeSlot,
                    'reschedules_remaining' => $booking->max_reschedules_allowed - $booking->reschedule_count
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
                'message' => 'Error rescheduling appointment'
            ], 500);
        }
    }
}
