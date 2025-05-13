<?php

namespace App\Http\Controllers\Professional;

use App\Http\Controllers\Controller;
use App\Models\Rate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        $request->validate([
            'rateData' => 'required|array',
            'rateData.*.session_type' => 'required|string|max:255',
            'rateData.*.num_sessions' => 'required|integer|min:1',
            'rateData.*.rate_per_session' => 'required|numeric|min:0',
            'rateData.*.final_rate' => 'required|numeric|min:0',
            'rateData.*.duration' => 'required|string|max:255',
        ]);
        $professionalId = Auth::guard('professional')->id();

        foreach ($request->input('rateData') as $rate) {
            Rate::create([
                'professional_id' => $professionalId,
                'session_type' => $rate['session_type'],
                'num_sessions' => $rate['num_sessions'],
                'rate_per_session' => $rate['rate_per_session'],
                'final_rate' => $rate['final_rate'],
                'duration' => $rate['duration'],
            ]);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Rates added successfully.',
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
            'duration' => 'required|string',
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
