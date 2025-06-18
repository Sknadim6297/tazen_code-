<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Availability;
use App\Models\Professional;
use App\Models\ProfessionalService;
use App\Models\Service;
use App\Models\Profile;
use App\Models\Rate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ProfessionalDeactivated;
use Illuminate\Support\Facades\DB;

class ManageProfessionalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Get services for filtering dropdown
        $services = Service::orderBy('name')->get();
        $specializations = DB::table('profiles')
            ->select('specialization')
            ->whereNotNull('specialization')
            ->distinct()
            ->orderBy('specialization')
            ->get()
            ->pluck('specialization');

        // If the request is AJAX
        if ($request->ajax()) {
            $searchTerm = $request->input('search');
            $startDate = $request->input('start_date');
            $endDate = $request->input('end_date');
            $serviceId = $request->input('service_id');
            $specializationFilter = $request->input('specialization');

            // Build the query based on filters
            $professionals = Professional::with(['professionalServices.service', 'profile']);

            if ($searchTerm) {
                $professionals = $professionals->where(function ($query) use ($searchTerm) {
                    $query->where('name', 'like', '%' . $searchTerm . '%')
                        ->orWhere('email', 'like', '%' . $searchTerm . '%');
                });
            }

            // Apply date filter if both dates are provided
            if ($startDate && $endDate) {
                // Ensure proper date format for database query
                $professionals = $professionals->whereDate('created_at', '>=', date('Y-m-d', strtotime($startDate)))
                    ->whereDate('created_at', '<=', date('Y-m-d', strtotime($endDate)));
            }

            // Filter by service if selected
            if ($serviceId) {
                $professionals = $professionals->whereHas('professionalServices', function ($query) use ($serviceId) {
                    $query->where('service_id', $serviceId);
                });
            }
            
            // Filter by specialization if selected
            if ($specializationFilter) {
                $professionals = $professionals->whereHas('profile', function($query) use ($specializationFilter) {
                    $query->where('specialization', $specializationFilter);
                });
            }

            // Fetch filtered professionals
            $professionals = $professionals->latest()->paginate(10);

            return response()->json([
                'professionals' => $professionals->toArray(),
            ]);
        }

        // Return the view for initial page load
        $professionals = Professional::with(['professionalServices.service', 'profile'])->latest()->paginate(10);
        return view('admin.manage-professional.index', compact('professionals', 'services', 'specializations'));
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
        $services = ProfessionalService::where('professional_id', $id)->with(['professional', 'service'])->get();
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

    public function updateMargin(Request $request, $id)
    {
        try {
            $request->validate([
                'margin_percentage' => 'required|numeric|min:0|max:100',
            ]);

            $professional = \App\Models\Professional::findOrFail($id);
            $professional->margin = $request->margin_percentage;
            $professional->save();

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Margin updated successfully',
                    'margin' => $professional->margin
                ]);
            }

            return redirect()->back()->with('success', 'Margin updated successfully');
        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error updating margin: ' . $e->getMessage()
                ], 422);
            }

            return redirect()->back()->with('error', 'Error updating margin: ' . $e->getMessage());
        }
    }

    /**
     * Toggle active status of a professional
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function toggleStatus(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'professional_id' => 'required|exists:professionals,id',
                'active_status' => 'required|in:0,1',
            ]);

            $professional = Professional::findOrFail($request->professional_id);
            $wasActive = $professional->active;
            $professional->active = (bool)$request->active_status;
            $professional->save();

            $statusText = $request->active_status ? 'activated' : 'deactivated';
            $message = "Professional {$professional->name} has been {$statusText} successfully.";

            // Send email notification for deactivation
            if ($wasActive && !$professional->active) {
                try {
                    Mail::to($professional->email)->send(new ProfessionalDeactivated($professional));
                    $message .= " Deactivation notification has been sent.";
                } catch (\Exception $e) {
                    $message .= " But failed to send notification email.";
                }
            }

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => $message
                ]);
            }

            return redirect()->back()->with('success', $message);
        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => "Failed to update status: " . $e->getMessage()
                ], 500);
            }

            return redirect()->back()->with('error', "Failed to update status: " . $e->getMessage());
        }
    }
}
