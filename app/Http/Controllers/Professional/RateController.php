<?php

namespace App\Http\Controllers\Professional;

use App\Http\Controllers\Controller;
use App\Models\Rate;
use App\Models\ProfessionalService;
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
        $professionalId = Auth::guard('professional')->id();
        
        $rates = Rate::where('professional_id', $professionalId)
            ->with(['service', 'subService'])
            ->get();
            
        // Get professional services to show service names
        $professionalServices = ProfessionalService::where('professional_id', $professionalId)
            ->with('service')
            ->get()
            ->keyBy('service_id');
            
        $rateCount = Rate::where('professional_id', $professionalId)->count();

        return view('professional.rate.index', compact('rates', 'rateCount', 'professionalServices'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $professionalId = Auth::guard('professional')->id();
        $professionalServices = ProfessionalService::where('professional_id', $professionalId)
            ->with('service', 'subServices')
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
            'rateData' => 'required|array',
            'rateData.*.session_type' => 'required|string|max:255',
            'rateData.*.sub_service_id' => 'nullable|exists:sub_services,id',
            'rateData.*.num_sessions' => 'required|integer|min:1',
            'rateData.*.rate_per_session' => 'required|numeric|min:0',
            'rateData.*.final_rate' => 'required|numeric|min:0',
            'rateData.*.features' => 'nullable|array',
            'rateData.*.features.*' => 'nullable|string|max:255',
        ]);
        
        $professionalId = Auth::guard('professional')->id();
        $professionalServiceId = $request->input('professional_service_id');
        
        // Get the actual service_id from professional_services table
        $professionalService = ProfessionalService::findOrFail($professionalServiceId);
        $serviceId = $professionalService->service_id;
        
        // Check for duplicate session types with sub-service combinations within the submitted data
        $combinations = [];
        foreach ($request->input('rateData') as $rate) {
            $key = $rate['session_type'] . '|' . ($rate['sub_service_id'] ?? 'null');
            if (in_array($key, $combinations)) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Duplicate session types with the same sub-service are not allowed in the same submission.',
                ], 422);
            }
            $combinations[] = $key;
        }
        
        // Check against existing rates for this professional
        foreach ($request->input('rateData') as $rate) {
            $exists = Rate::where('professional_id', $professionalId)
                ->where('service_id', $serviceId)
                ->where('session_type', $rate['session_type'])
                ->where('sub_service_id', $rate['sub_service_id'] ?? null)
                ->exists();
                
            if ($exists) {
                $subServiceMsg = isset($rate['sub_service_id']) ? ' with this sub-service' : '';
                return response()->json([
                    'status' => 'error',
                    'message' => 'You already have a rate for session type "' . $rate['session_type'] . '"' . $subServiceMsg . '.',
                ], 422);
            }
        }

        DB::beginTransaction();

        try {
            foreach ($request->input('rateData') as $rate) {
                Rate::create([
                    'professional_id' => $professionalId,
                    'service_id' => $serviceId,
                    'session_type' => $rate['session_type'],
                    'sub_service_id' => $rate['sub_service_id'] ?? null,
                    'num_sessions' => $rate['num_sessions'],
                    'rate_per_session' => $rate['rate_per_session'],
                    'final_rate' => $rate['final_rate'],
                    'features' => $rate['features'] ?? [],
                ]);
            }
            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'Rates added successfully.',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'status' => 'error',
                'message' => 'An error occurred while adding the rates. Please try again.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Get already used session types for the logged in professional
     * Returns session types with their sub_service_id to properly check duplicates
     */
    public function getSessionTypes()
    {
        $professionalId = Auth::guard('professional')->id();
        $rates = Rate::where('professional_id', $professionalId)
            ->select('session_type', 'sub_service_id')
            ->get()
            ->map(function($rate) {
                return [
                    'session_type' => $rate->session_type,
                    'sub_service_id' => $rate->sub_service_id
                ];
            })
            ->toArray();
        
        return response()->json([
            'status' => 'success',
            'rates' => $rates
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
        $rates = Rate::findOrFail($id);
        return view('professional.rate.edit', compact('rates'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'num_sessions' => 'required|integer|min:1',
            'rate_per_session' => 'required|numeric|min:0',
            'final_rate' => 'required|numeric|min:0',
            'features' => 'nullable|array',
            'features.*' => 'nullable|string|max:255',
        ]);

        $rate = Rate::findOrFail($id);
        $rate->update($validated);

        return response()->json(['success' => true, 'message' => 'Rate updated successfully.']);
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
