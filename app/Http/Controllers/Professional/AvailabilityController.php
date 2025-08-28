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


   public function index(Request $request)
{
    $query = Availability::with(['slots', 'professionalService'])
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
        $professionalServices = \App\Models\ProfessionalService::with('subServices')
            ->where('professional_id', Auth::guard('professional')->id())
            ->get();

        return view('professional.availability.create', compact('professionalServices'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'professional_service_id' => 'required|exists:professional_services,id',
            'sub_service_id' => 'nullable|exists:sub_services,id',
            'month' => 'required|string',
            'session_duration' => 'required|integer|min:15|max:240',
            'weekdays' => 'required|array|min:1',
            'start_time' => 'required|array|min:1',
            'end_time' => 'required|array|min:1',
        ]);

        $professionalId = Auth::guard('professional')->id();
        $professionalServiceId = $request->professional_service_id;
        
        // Verify that the professional service belongs to the authenticated professional
        $professionalService = \App\Models\ProfessionalService::where('id', $professionalServiceId)
            ->where('professional_id', $professionalId)
            ->first();
            
        if (!$professionalService) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid service selection.',
            ], 422);
        }
        
            // If this professional service has sub-services, allow either
            // service-level availability (no sub_service_id) or sub-service-level availability.
            // If a sub_service_id is provided, validate it belongs to the selected service.
            if ($professionalService->subServices()->exists() && $request->filled('sub_service_id')) {
                $exists = $professionalService->subServices()->where('sub_services.id', $request->sub_service_id)->exists();
                if (!$exists) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Invalid sub-service selection for the chosen service.'
                    ], 422);
                }
            }

        // Check if availability already exists for this service/sub-service and month
        $existingAvailabilityQuery = Availability::where('professional_id', $professionalId)
            ->where('professional_service_id', $professionalServiceId)
            ->where('month', $request->month);

        // Scope duplicate check to the same level: sub-service if provided, otherwise service-level (sub_service_id IS NULL)
        if ($request->filled('sub_service_id')) {
            $existingAvailabilityQuery->where('sub_service_id', $request->sub_service_id);
        } else {
            $existingAvailabilityQuery->whereNull('sub_service_id');
        }

        $existingAvailability = $existingAvailabilityQuery->first();
            
        if ($existingAvailability) {
            return response()->json([
                'success' => false,
                'message' => 'Availability already exists for this service in ' . ucfirst($request->month) . '. Please edit the existing one or choose a different month.',
            ], 422);
        }
        
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
            'professional_service_id' => $professionalServiceId,
            'sub_service_id' => $request->sub_service_id ?? null,
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
            'message' => 'Availability saved successfully for ' . $professionalService->service_name . '.'
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
        $availability = Availability::with(['slots', 'professionalService'])->findOrFail($id);
        if ($availability->professional_id != Auth::guard('professional')->id()) {
            return redirect()->route('professional.availability.index')->with('error', 'Unauthorized access');
        }

        $professionalServices = \App\Models\ProfessionalService::where('professional_id', Auth::guard('professional')->id())->get();

        return view('professional.availability.edit', compact('availability', 'professionalServices'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'professional_service_id' => 'required|exists:professional_services,id',
            'sub_service_id' => 'nullable|exists:sub_services,id',
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

        $professionalId = Auth::guard('professional')->id();
        $professionalServiceId = $request->professional_service_id;
        
        // Verify that the professional service belongs to the authenticated professional
        $professionalService = \App\Models\ProfessionalService::where('id', $professionalServiceId)
            ->where('professional_id', $professionalId)
            ->first();
            
        if (!$professionalService) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid service selection.',
            ], 422);
        }

        // Validate sub-service belongs to the selected professional service (if provided)
        if ($request->filled('sub_service_id')) {
            $subService = \App\Models\SubService::where('id', $request->sub_service_id)
                ->where('professional_service_id', $professionalServiceId)
                ->first();

            if (!$subService) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid sub-service selection for the chosen service.'
                ], 422);
            }
        }

        // Check if availability already exists for this service/sub-service and month (excluding current)
        $existingAvailabilityQuery = Availability::where('professional_id', $professionalId)
            ->where('professional_service_id', $professionalServiceId)
            ->where('month', $request->month)
            ->where('id', '!=', $id);

        if ($request->filled('sub_service_id')) {
            $existingAvailabilityQuery->where('sub_service_id', $request->sub_service_id);
        } else {
            $existingAvailabilityQuery->whereNull('sub_service_id');
        }

        $existingAvailability = $existingAvailabilityQuery->first();
            
        if ($existingAvailability) {
            return response()->json([
                'success' => false,
                'message' => 'Availability already exists for this service in ' . ucfirst($request->month) . '. Please choose a different month.',
            ], 422);
        }

        $availability->update([
            'professional_service_id' => $professionalServiceId,
            'sub_service_id' => $request->sub_service_id ?? null,
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
            'message' => 'Availability updated successfully for ' . $professionalService->service_name . '.'
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
