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
use Barryvdh\DomPDF\Facade\Pdf; // Change the import at the top

class ManageProfessionalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Get specializations for filtering dropdown
        $specializations = DB::table('profiles')
            ->select('specialization')
            ->whereNotNull('specialization')
            ->distinct()
            ->orderBy('specialization')
            ->get()
            ->pluck('specialization');

        // Build base query with filters
        $query = Professional::with(['professionalServices.service', 'profile']);
        
        // Apply search filters
        if ($request->has('search') && $request->search) {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('name', 'like', '%' . $searchTerm . '%')
                  ->orWhere('email', 'like', '%' . $searchTerm . '%');
            });
        }

        // Apply date filter if both dates are provided
        if ($request->has('start_date') && $request->has('end_date') && $request->start_date && $request->end_date) {
            $startDate = \Carbon\Carbon::parse($request->start_date)->startOfDay();
            $endDate = \Carbon\Carbon::parse($request->end_date)->endOfDay();
            $query->whereBetween('created_at', [$startDate, $endDate]);
        }
        
        // Filter by specialization if selected
        if ($request->has('specialization') && $request->specialization) {
            $query->whereHas('profile', function($q) use ($request) {
                $q->where('specialization', $request->specialization);
            });
        }
        
        // Get the professionals with filters
        $professionals = $query->latest();

        // Handle export requests
        if ($request->has('export')) {
            $exportProfessionals = $professionals->get(); // Get all results for export
            
            if ($request->export === 'excel') {
                return $this->exportToExcel($exportProfessionals);
            } elseif ($request->export === 'pdf') {
                return $this->exportToPdf($exportProfessionals);
            }
        }

        // If AJAX request, return JSON
        if ($request->ajax()) {
            $paginated = $professionals->paginate(10);
            return response()->json([
                'professionals' => $paginated->toArray(),
                'pagination' => $paginated->links()->render(),
            ]);
        }

        // Paginate for view rendering
        $professionals = $professionals->paginate(10);
        
        // Return the view for initial page load with pagination
        return view('admin.manage-professional.index', compact(
            'professionals', 
            'specializations'
        ));
    }

    /**
     * Export data to Excel (CSV format)
     */
    private function exportToExcel($professionals)
    {
        try {
            $headers = [
                'Content-Type' => 'text/csv',
                'Content-Disposition' => 'attachment; filename="professionals_' . date('Y_m_d_His') . '.csv"',
                'Pragma' => 'no-cache',
                'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
                'Expires' => '0',
            ];
            
            $callback = function() use ($professionals) {
                $file = fopen('php://output', 'w');
                
                // Add headers - adjusted for active professionals
                fputcsv($file, [
                    'ID', 'Name', 'Email', 'Phone', 'Specialization', 
                    'Experience', 'Address', 'Starting Price', 'Margin',
                    'Status', 'Active', 'Registration Date'
                ]);
                
                // Add data rows
                foreach ($professionals as $professional) {
                    fputcsv($file, [
                        $professional->id,
                        $professional->name,
                        $professional->email,
                        $professional->phone,
                        $professional->profile ? $professional->profile->specialization : 'Not specified',
                        $professional->profile ? $professional->profile->experience : 'Not specified',
                        $professional->profile ? $professional->profile->address : 'Not specified',
                        $professional->profile ? $professional->profile->starting_price : 'Not specified',
                        $professional->margin . '%',
                        ucfirst($professional->status),
                        $professional->active ? 'Yes' : 'No',
                        $professional->created_at->format('d/m/Y')
                    ]);
                }
                
                fclose($file);
            };
            
            return response()->stream($callback, 200, $headers);
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to export data: ' . $e->getMessage());
        }
    }

    /**
     * Export data to PDF
     */
    private function exportToPdf($professionals)
    {
        try {
            $data = [
                'professionals' => $professionals,
                'title' => 'Professionals Report',
            ];
            
            $pdf = Pdf::loadView('admin.manage-professional.professionals', $data);
            return $pdf->download('professionals_' . date('Y_m_d_His') . '.pdf');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to export to PDF: ' . $e->getMessage());
        }
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
