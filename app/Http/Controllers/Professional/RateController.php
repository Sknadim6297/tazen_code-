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
        $rates = Rate::where('professional_id', Auth::guard('professional')->id())->get();
        $rateCount = Rate::where('professional_id', auth()->guard('professional')->id())->count();

        return view('professional.rate.index', compact('rates', 'rateCount'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        return view('professional.rate.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the incoming request data
        $validated = $request->validate([
            'rateData' => 'required|array',
            'rateData.*.session_type' => 'required|string|max:255',
            'rateData.*.num_sessions' => 'required|integer|min:1',
            'rateData.*.rate_per_session' => 'required|numeric|min:0',
            'rateData.*.final_rate' => 'required|numeric|min:0',
        ]);
        $professionalId = Auth::guard('professional')->id();

        DB::beginTransaction();

        try {

            foreach ($request->input('rateData') as $rate) {
                Rate::create([
                    'professional_id' => $professionalId,
                    'session_type' => $rate['session_type'],
                    'num_sessions' => $rate['num_sessions'],
                    'rate_per_session' => $rate['rate_per_session'],
                    'final_rate' => $rate['final_rate'],

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
