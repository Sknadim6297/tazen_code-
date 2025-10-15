<?php

namespace App\Http\Controllers\Professional;

use App\Http\Controllers\Controller;
use App\Models\Availability;
use App\Models\AvailabilitySlot;
use App\Models\Service;
use App\Models\SubService;
use App\Services\ProfessionalServiceManager;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AvailabilityController extends Controller
{
    protected $serviceManager;

    public function __construct(ProfessionalServiceManager $serviceManager)
    {
        $this->serviceManager = $serviceManager;
    }


   public function index(Request $request)
{
    $professionalId = Auth::guard('professional')->id();
    $serviceId = $request->input('service_id');
    $subServiceId = $request->input('sub_service_id');
    
    $query = Availability::with(['slots', 'service', 'subService'])
        ->where('professional_id', $professionalId);

    if ($request->filled('search_month')) {
        $searchMonth = strtolower($request->search_month);
        $query->where('month', $searchMonth); 
    }
    
    // Filter by service and sub-service if provided
    if ($serviceId) {
        $query->where('service_id', $serviceId);
    }
    
    if ($subServiceId) {
        $query->where('sub_service_id', $subServiceId);
    }

    $availability = $query->get();
    $availableMonths = Availability::where('professional_id', $professionalId)
        ->pluck('month')
        ->unique()
        ->sort()
        ->values();
    
    // Get professional's services for filtering
    $services = Service::whereHas('professionals', function($q) use ($professionalId) {
        $q->where('professional_id', $professionalId);
    })->with('subServices')->get();

    return view('professional.availability.index', compact('availability', 'availableMonths', 'services'));
}


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $professionalId = Auth::guard('professional')->id();
        
        // Get professional's services for the form
        $services = Service::whereHas('professionals', function($q) use ($professionalId) {
            $q->where('professional_id', $professionalId);
        })->with('subServices')->get();
        
        return view('professional.availability.create', compact('services'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'service_id' => 'nullable|exists:services,id',
            'sub_service_id' => 'nullable|exists:sub_services,id',
            'months' => 'required|array|min:1',
            'months.*' => 'string|regex:/^\d{4}-\d{2}$/',
            'session_duration' => 'required|integer|min:15|max:240',
            'weekdays' => 'required|array|min:1',
            'start_time' => 'required|array|min:1',
            'end_time' => 'required|array|min:1',
        ]);

        $professionalId = Auth::guard('professional')->id();
        $serviceId = $request->service_id;
        $subServiceId = $request->sub_service_id;
        
        // Validate that sub-service belongs to the service if both are provided
        if ($serviceId && $subServiceId) {
            $subService = SubService::where('id', $subServiceId)
                ->where('service_id', $serviceId)
                ->first();
                
            if (!$subService) {
                return response()->json([
                    'success' => false,
                    'errors' => ['Selected sub-service does not belong to the selected service.']
                ], 422);
            }
        }

        // Prepare availability data
        $availabilityData = [
            'months' => $request->months,
            'session_duration' => $request->session_duration,
            'weekdays' => $request->weekdays,
            'time_slots' => []
        ];

        // Prepare time slots
        for ($i = 0; $i < count($request->start_time); $i++) {
            $availabilityData['time_slots'][] = [
                'start_time' => $request->start_time[$i],
                'end_time' => $request->end_time[$i]
            ];
        }

        // Use service manager to store availability
        $result = $this->serviceManager->storeAvailability(
            $professionalId, 
            $availabilityData, 
            $serviceId, 
            $subServiceId
        );

        if ($result['success']) {
            return response()->json([
                'success' => true,
                'message' => $result['message']
            ]);
        } else {
            return response()->json([
                'success' => false,
                'errors' => [$result['message']]
            ], 500);
        }
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
        $availability = Availability::with(['slots', 'service', 'subService'])->findOrFail($id);
        if ($availability->professional_id != Auth::guard('professional')->id()) {
            return redirect()->route('professional.availability.index')->with('error', 'Unauthorized access');
        }
        
        $professionalId = Auth::guard('professional')->id();
        
        // Get professional's services for the form
        $services = Service::whereHas('professionals', function($q) use ($professionalId) {
            $q->where('professional_id', $professionalId);
        })->with('subServices')->get();

        return view('professional.availability.edit', compact('availability', 'services'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'service_id' => 'nullable|exists:services,id',
            'sub_service_id' => 'nullable|exists:sub_services,id',
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
        
        $serviceId = $request->service_id;
        $subServiceId = $request->sub_service_id;
        
        // Validate that sub-service belongs to the service if both are provided
        if ($serviceId && $subServiceId) {
            $subService = SubService::where('id', $subServiceId)
                ->where('service_id', $serviceId)
                ->first();
                
            if (!$subService) {
                return response()->json([
                    'success' => false,
                    'message' => 'Selected sub-service does not belong to the selected service.'
                ], 422);
            }
        }

        try {
            // Update availability details
            $availability->update([
                'service_id' => $serviceId,
                'sub_service_id' => $subServiceId,
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
                } catch (\Exception $e) {
                    Log::error("Failed to create time slot: " . $e->getMessage());
                    continue;
                }
            }

            return response()->json([
                'success' => true,
                'message' => 'Availability updated successfully.'
            ]);

        } catch (\Exception $e) {
            Log::error("Failed to update availability: " . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to update availability. Please try again.'
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
            'success' => true,
            'message' => 'Availability deleted successfully.'
        ]);
    }
    
    /**
     * Get availability by service and optional sub-service
     */
    public function getAvailabilityByService(Request $request)
    {
        $professionalId = Auth::guard('professional')->id();
        $serviceId = $request->input('service_id');
        $subServiceId = $request->input('sub_service_id');
        
        $availability = $this->serviceManager->getAvailabilityByService($professionalId, $serviceId, $subServiceId);
        
        return response()->json([
            'success' => true,
            'data' => $availability
        ]);
    }
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
