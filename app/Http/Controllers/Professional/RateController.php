<?php

namespace App\Http\Controllers\Professional;

use App\Http\Controllers\Controller;
use App\Models\Rate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RateController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $rates = Rate::with('professionalService')
            ->where('professional_id', Auth::guard('professional')->id())
            ->get();
        $rateCount = Rate::where('professional_id', auth()->guard('professional')->id())->count();

        return view('professional.rate.index', compact('rates', 'rateCount'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $professionalServices = \App\Models\ProfessionalService::with('subServices')
            ->where('professional_id', Auth::guard('professional')->id())
            ->get();

        return view('professional.rate.create', compact('professionalServices'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the incoming request data
        $validated = $request->validate([
            'professional_service_id' => 'required|exists:professional_services,id',
            'sub_service_id' => 'nullable|exists:sub_services,id',
            'rateData' => 'required|array',
            'rateData.*.session_type' => 'required|string|max:255',
            'rateData.*.num_sessions' => 'required|integer|min:1',
            'rateData.*.rate_per_session' => 'required|numeric|min:0',
            'rateData.*.final_rate' => 'required|numeric|min:0',
            'rateData.*.sub_service_id' => 'nullable|exists:sub_services,id',
        ]);
        
        $professionalId = Auth::guard('professional')->id();
        $professionalServiceId = $request->professional_service_id;
        
        // Verify that the professional service belongs to the authenticated professional
        $professionalService = \App\Models\ProfessionalService::where('id', $professionalServiceId)
            ->where('professional_id', $professionalId)
            ->first();
            
        if (!$professionalService) {
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid service selection.',
            ], 422);
        }
            if ($professionalService->subServices()->exists() && $request->filled('sub_service_id')) {
                $exists = $professionalService->subServices()->where('sub_services.id', $request->sub_service_id)->exists();
                if (!$exists) {
                    return response()->json([
                        'status' => 'error',
                        'message' => 'Invalid sub-service selection for the chosen service.'
                    ], 422);
                }
            }
        
        // Build keys to detect duplicates within submission and prepare DB checks
        $submittedKeys = [];
        $duplicateKeys = [];
        $toCheckAgainstDb = [];

        foreach ($request->input('rateData') as $item) {
            $sessionType = $item['session_type'];
            // prefer per-rate sub_service_id, fall back to top-level sub_service_id
            $subServiceId = $item['sub_service_id'] ?? ($request->sub_service_id ?? null);
            $key = $sessionType . '|' . ($subServiceId === null ? 'null' : $subServiceId);

            if (isset($submittedKeys[$key])) {
                $duplicateKeys[] = $sessionType . ($subServiceId ? ' (sub-service ' . $subServiceId . ')' : ' (service level)');
            }
            $submittedKeys[$key] = true;

            $toCheckAgainstDb[] = ['session_type' => $sessionType, 'sub_service_id' => $subServiceId];
        }

        if (!empty($duplicateKeys)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Duplicate session types for the same scope are not allowed in the same submission: ' . implode(', ', $duplicateKeys),
            ], 422);
        }

        // Check against existing session types in DB for each (session_type, sub_service_id)
        $existingSessionTypes = [];
        foreach ($toCheckAgainstDb as $check) {
            $query = Rate::where('professional_id', $professionalId)
                ->where('professional_service_id', $professionalServiceId)
                ->where('session_type', $check['session_type']);

            if ($check['sub_service_id']) {
                $query->where('sub_service_id', $check['sub_service_id']);
            } else {
                $query->whereNull('sub_service_id');
            }

            if ($query->exists()) {
                $existingSessionTypes[] = $check['session_type'] . ($check['sub_service_id'] ? ' (sub-service ' . $check['sub_service_id'] . ')' : ' (service level)');
            }
        }

        if (!empty($existingSessionTypes)) {
            return response()->json([
                'status' => 'error',
                'message' => 'You already have rates for the following session types for this service: ' . implode(', ', array_unique($existingSessionTypes)),
            ], 422);
        }

        DB::beginTransaction();

        try {
            foreach ($request->input('rateData') as $rate) {
                // determine per-rate sub_service_id (may be null)
                $rowSubServiceId = $rate['sub_service_id'] ?? ($request->sub_service_id ?? null);

                // If a sub_service_id is provided per-row, validate it belongs to this professional service
                if ($rowSubServiceId !== null && $professionalService->subServices()->exists()) {
                    $exists = $professionalService->subServices()->where('sub_services.id', $rowSubServiceId)->exists();
                    if (!$exists) {
                        throw new \Exception('Invalid sub-service selection for one of the rates.');
                    }
                } elseif (!$professionalService->subServices()->exists()) {
                    // service has no sub-services; ensure we store null
                    $rowSubServiceId = null;
                }

                Rate::create([
                    'professional_id' => $professionalId,
                    'professional_service_id' => $professionalServiceId,
                    'sub_service_id' => $rowSubServiceId,
                    'session_type' => $rate['session_type'],
                    'num_sessions' => $rate['num_sessions'],
                    'rate_per_session' => $rate['rate_per_session'],
                    'final_rate' => $rate['final_rate'],
                ]);
            }
            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'Rates added successfully for ' . $professionalService->service_name . '.',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'status' => 'error',
                'message' => 'An error occurred while adding the rates. Please try again.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }    /**
     * Get already used session types for the logged in professional and specific service
     */
    public function getSessionTypes(Request $request)
    {
        $professionalId = Auth::guard('professional')->id();
            $professionalServiceId = $request->get('professional_service_id');
    $subServiceId = $request->get('sub_service_id');
        $query = Rate::where('professional_id', $professionalId);

        if ($professionalServiceId) {
            $query->where('professional_service_id', $professionalServiceId);

            // Load the professional service so we can validate sub-service membership
            $professionalService = \App\Models\ProfessionalService::where('id', $professionalServiceId)
                ->where('professional_id', $professionalId)
                ->first();

            if (!$professionalService) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Invalid service selection.'
                ], 422);
            }

            // When this professional service exposes sub-services, allow both service-level 
            // and sub-service-level rates
            if ($professionalService->subServices()->exists()) {
                if ($request->filled('sub_service_id')) {
                    // Validate that the sub-service belongs to this service
                    $exists = $professionalService->subServices()->where('sub_services.id', $request->sub_service_id)->exists();
                    if (!$exists) {
                        return response()->json([
                            'status' => 'error',
                            'message' => 'Invalid sub-service selection for the chosen service.'
                        ], 422);
                    }

                    $query->where('sub_service_id', $request->sub_service_id);
                } else {
                    // No sub-service selected: get service-level rates (sub_service_id is null)
                    $query->whereNull('sub_service_id');
                }
            } elseif ($request->filled('sub_service_id')) {
                // If service has no sub-services but sub_service_id was passed, ensure it's null
                $query->whereNull('sub_service_id');
            }
        }
        if ($subServiceId) {
            $query->where('sub_service_id', $subServiceId);
        }
        
        $sessionTypes = $query->pluck('session_type')->toArray();
        
        return response()->json([
            'status' => 'success',
            'session_types' => $sessionTypes
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
        $rates = Rate::with('professionalService')->findOrFail($id);
        if ($rates->professional_id != Auth::guard('professional')->id()) {
            return redirect()->route('professional.rate.index')->with('error', 'Unauthorized access');
        }

        $professionalServices = \App\Models\ProfessionalService::where('professional_id', Auth::guard('professional')->id())->get();

        return view('professional.rate.edit', compact('rates', 'professionalServices'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'professional_service_id' => 'required|exists:professional_services,id',
            'sub_service_id' => 'nullable|exists:sub_services,id',
            'num_sessions' => 'required|integer|min:1',
            'rate_per_session' => 'required|numeric|min:0',
            'final_rate' => 'required|numeric|min:0',
        ]);

        $rate = Rate::findOrFail($id);
        if ($rate->professional_id != Auth::guard('professional')->id()) {
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

        // Check if rate already exists for this service/sub-service and session combination (excluding current)
        $existingRateQuery = Rate::where('professional_id', $professionalId)
            ->where('professional_service_id', $professionalServiceId)
            ->where('session_type', $request->session_type ?? $rate->session_type)
            ->where('id', '!=', $id);
        if ($request->filled('sub_service_id')) {
            $existingRateQuery->where('sub_service_id', $request->sub_service_id);
        }
        $existingRate = $existingRateQuery->first();
            
        if ($existingRate) {
            return response()->json([
                'success' => false,
                'message' => 'Rate already exists for this service and session type. Please edit the existing one.',
            ], 422);
        }

        $rate->update($validated);

        return response()->json(['success' => true, 'message' => 'Rate updated successfully for ' . $professionalService->service_name . '.']);
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $rate = Rate::findOrFail($id);
        $rate->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Rate has been deleted successfully.'
        ]);
    }
}
