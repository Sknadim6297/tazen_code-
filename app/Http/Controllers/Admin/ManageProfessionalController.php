<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Availability;
use App\Models\Professional;
use App\Models\ProfessionalService;
use App\Models\Profile;
use App\Models\Rate;
use Illuminate\Http\Request;

class ManageProfessionalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
   public function index(Request $request)
{
    // If the request is AJAX
    if ($request->ajax()) {
        $searchTerm = $request->input('search');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        // Build the query based on filters
        $professionals = Professional::query();

        if ($searchTerm) {
            $professionals = $professionals->where(function($query) use ($searchTerm) {
                $query->where('name', 'like', '%' . $searchTerm . '%')
                      ->orWhere('email', 'like', '%' . $searchTerm . '%');
            });
        }

        if ($startDate && $endDate) {
            $professionals = $professionals->whereBetween('created_at', [$startDate, $endDate]);
        }

        // Fetch filtered professionals
        $professionals = $professionals->latest()->paginate(10);

        return response()->json([
            'professionals' => $professionals->toArray(),
        ]);
    }

    // Return the view for initial page load
    $professionals = Professional::latest()->paginate(10);
    return view('admin.manage-professional.index', compact('professionals'));
}



    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.manage-professional.create');
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
        $profiles = Profile::where('professional_id', $id)->with('professional')->get();
        $availabilities = Availability::where('professional_id', $id)->with('slots')->get();
        $services = ProfessionalService::where('professional_id', $id)->with('professional')->get();
        $rates = Rate::where('professional_id', $id)->with('professional')->get();

        return view('admin.manage-professional.show', compact('profiles', 'availabilities', 'services', 'rates'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $professional = Professional::findOrFail($id);
        return view('admin.manage-professional.edit', compact('professional'));
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
}
