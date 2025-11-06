<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Availability;
use App\Models\AvailabilitySlot;
use App\Models\Professional;
use App\Models\ProfessionalService;
use App\Models\Service;
use App\Models\Profile;
use App\Models\Rate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ProfessionalDeactivated;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;

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
        $professional = Professional::findOrFail($id);
        $profiles = Profile::where('professional_id', $id)->with('professional')->get();
        $availabilities = Availability::where('professional_id', $id)->with('slots')->get();
        $services = ProfessionalService::where('professional_id', $id)->with(['professional', 'service'])->get();
        $rates = Rate::where('professional_id', $id)->with('professional')->get();

        return view('admin.manage-professional.show', compact('professional', 'profiles', 'availabilities', 'services', 'rates'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $professional = Professional::with('profile')->findOrFail($id);
        return view('admin.manage-professional.edit', compact('professional'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:professionals,email,' . $id,
            'phone' => 'nullable|string|max:20',
            'specialization' => 'nullable|string|max:255',
            'experience' => 'nullable|integer|min:0',
            'starting_price' => 'nullable|numeric|min:0',
            'address' => 'nullable|string',
            'gst_number' => 'nullable|string|max:15',
            'state_code' => 'nullable|string|max:10',
            'state_name' => 'nullable|string|max:255',
            'gst_address' => 'nullable|string',
            'account_holder_name' => 'nullable|string|max:255',
            'bank_name' => 'nullable|string|max:255',
            'account_number' => 'nullable|string|max:50',
            'ifsc_code' => 'nullable|string|max:15',
            'account_type' => 'nullable|in:savings,current',
            'bank_branch' => 'nullable|string|max:255',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'qualification_document' => 'nullable|file|mimes:pdf,jpeg,png,jpg|max:5120',
            'id_proof_document' => 'nullable|file|mimes:pdf,jpeg,png,jpg|max:5120',
            'gst_certificate' => 'nullable|file|mimes:pdf,jpeg,png,jpg|max:5120',
            'bank_document' => 'nullable|file|mimes:pdf,jpeg,png,jpg|max:5120',
        ]);

        try {
            DB::beginTransaction();

            // Find the professional
            $professional = Professional::findOrFail($id);
            
            // Update professional basic info
            $professional->update([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
            ]);

            // Get or create profile
            $profile = $professional->profile ?? new Profile();
            $profile->professional_id = $professional->id;

            // Handle file uploads
            $fileFields = ['photo', 'qualification_document', 'id_proof_document', 'gst_certificate', 'bank_document'];
            foreach ($fileFields as $field) {
                if ($request->hasFile($field)) {
                    // Delete old file if exists
                    if ($profile->$field && Storage::exists('public/' . $profile->$field)) {
                        Storage::delete('public/' . $profile->$field);
                    }
                    
                    // Store new file
                    $profile->$field = $request->file($field)->store('professional_documents', 'public');
                }
            }

            // Update profile data
            $profile->fill([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'specialization' => $request->specialization,
                'experience' => $request->experience,
                'starting_price' => $request->starting_price,
                'address' => $request->address,
                'gst_number' => $request->gst_number,
                'state_code' => $request->state_code,
                'state_name' => $request->state_name,
                'gst_address' => $request->gst_address,
                'account_holder_name' => $request->account_holder_name,
                'bank_name' => $request->bank_name,
                'account_number' => $request->account_number,
                'ifsc_code' => $request->ifsc_code,
                'account_type' => $request->account_type,
                'bank_branch' => $request->bank_branch,
            ]);

            $profile->save();

            DB::commit();

            return redirect()->route('admin.manage-professional.show', $id)
                           ->with('success', 'Professional details updated successfully!');

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()
                           ->withInput()
                           ->with('error', 'Failed to update professional details: ' . $e->getMessage());
        }
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
            // Validate both old format (margin_percentage) and new format (margin, service_request_margin, service_request_offset)
            $rules = [];
            
            // Check if it's the old format (single margin field)
            if ($request->has('margin_percentage')) {
                $rules['margin_percentage'] = 'required|numeric|min:0|max:100';
            } else {
                // New format with all commission fields
                $rules = [
                    'margin' => 'required|numeric|min:0|max:100',
                    'service_request_margin' => 'required|numeric|min:0|max:100',
                    'service_request_offset' => 'required|numeric|min:0|max:100',
                ];
            }
            
            $request->validate($rules);

            $professional = \App\Models\Professional::findOrFail($id);
            
            // Update based on the format received
            if ($request->has('margin_percentage')) {
                // Old format - only update margin
                $professional->margin = $request->margin_percentage;
            } else {
                // New format - update all commission settings
                $professional->update([
                    'margin' => $request->margin,
                    'service_request_margin' => $request->service_request_margin,
                    'service_request_offset' => $request->service_request_offset,
                ]);
            }
            
            $professional->save();

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Commission settings updated successfully',
                    'data' => [
                        'margin' => $professional->margin,
                        'service_request_margin' => $professional->service_request_margin,
                        'service_request_offset' => $professional->service_request_offset,
                    ]
                ]);
            }

            return redirect()->back()->with('success', 'Commission settings updated successfully');
        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error updating commission settings: ' . $e->getMessage()
                ], 422);
            }

            return redirect()->back()->with('error', 'Error updating commission settings: ' . $e->getMessage());
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

    /**
     * Export bank details to Excel
     */
    public function exportBankDetails(Request $request)
    {
        try {
            // Get all profiles with bank details
            $profiles = Profile::with('professional')
                ->whereNotNull('account_holder_name')
                ->whereNotNull('bank_name')
                ->whereNotNull('account_number')
                ->whereNotNull('ifsc_code')
                ->get();

            // Filter by professional ID if provided
            if ($request->has('professional_id') && $request->professional_id) {
                $profiles = $profiles->where('professional_id', $request->professional_id);
            }

            $export = new \App\Exports\BankDetailsExport($profiles);
            
            return \Maatwebsite\Excel\Facades\Excel::download(
                $export, 
                'professional_bank_details_' . date('Y_m_d_His') . '.xlsx'
            );
            
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to export bank details: ' . $e->getMessage());
        }
    }

    /**
     * Manage professional services
     */
    public function manageServices($professionalId)
    {
        $professional = Professional::findOrFail($professionalId);
        $services = ProfessionalService::where('professional_id', $professionalId)->with(['service', 'subServices'])->get();
        
        return view('admin.manage-professional.services', compact('professional', 'services'));
    }

    /**
     * Manage professional rates
     */
    public function manageRates($professionalId)
    {
        $professional = Professional::findOrFail($professionalId);
        $rates = Rate::where('professional_id', $professionalId)->with('subService')->get();
        
        // Get professional's services and their sub-services
        $professionalServices = \App\Models\ProfessionalService::where('professional_id', $professionalId)
            ->with(['service', 'subServices'])
            ->get();
        
        return view('admin.manage-professional.rates', compact('professional', 'rates', 'professionalServices'));
    }

    /**
     * Manage professional availability
     */
    public function manageAvailability($professionalId)
    {
        $professional = Professional::findOrFail($professionalId);
        $availabilities = Availability::where('professional_id', $professionalId)->with('slots')->get();
        
        return view('admin.manage-professional.availability', compact('professional', 'availabilities'));
    }

    // ================ ADMIN SERVICES CRUD ================

    /**
     * Store a new service for professional (Admin)
     */
    public function storeService(Request $request, $professionalId)
    {
        $request->validate([
            'service_id' => 'required|exists:services,id',
            'features' => 'nullable|array',
            'features.*' => 'string',
            'tags' => 'nullable|string',
            'requirements' => 'nullable|string',
            'subServices' => 'nullable|array',
            'subServices.*' => 'exists:sub_services,id'
        ]);

        $professional = Professional::findOrFail($professionalId);

        // Check if service already exists for this professional
        $existingService = ProfessionalService::where('professional_id', $professionalId)
                                               ->where('service_id', $request->service_id)
                                               ->first();

        if ($existingService) {
            return back()->with('error', 'This service is already added for this professional.');
        }

        // Enforce only one service per professional (server-side)
        $totalServices = ProfessionalService::where('professional_id', $professionalId)->count();
        if ($totalServices >= 1) {
            return back()->with('error', 'A professional may have only one service.');
        }

        // Get service details
        $service = Service::findOrFail($request->service_id);

        $professionalService = ProfessionalService::create([
            'professional_id' => $professionalId,
            'service_id' => $request->service_id,
            'service_name' => $service->name,
            'category' => $service->category ?? $service->name ?? null,
            'duration' => $service->duration ?? 60,
            'features' => $request->features ?? [],
            // description column is non-nullable in DB; ensure we provide a string
            'description' => $request->description ?? $service->description ?? '',
            'tags' => $request->tags,
            'requirements' => $request->requirements
        ]);

        // Attach sub-services
        if ($request->has('subServices')) {
            $professionalService->subServices()->attach($request->subServices);
        }

        return back()->with('success', 'Service added successfully!');
    }

    /**
     * Update service for professional (Admin)
     */
    public function updateService(Request $request, $professionalId, $serviceId)
    {
        $request->validate([
            'service_id' => 'required|exists:services,id',
            'features' => 'nullable|array',
            'features.*' => 'string',
            'tags' => 'nullable|string',
            'requirements' => 'nullable|string',
            'subServices' => 'nullable|array',
            'subServices.*' => 'exists:sub_services,id'
        ]);

        $professionalService = ProfessionalService::where('professional_id', $professionalId)
                                                   ->where('id', $serviceId)
                                                   ->firstOrFail();

        // Get updated service details
        $service = Service::findOrFail($request->service_id);

        $professionalService->update([
            'service_id' => $request->service_id,
            'service_name' => $service->name,
            'category' => $service->category ?? $service->name ?? null,
            'duration' => $service->duration ?? 60,
            'description' => $request->description ?? $service->description ?? $professionalService->description ?? '',
            'features' => $request->features ?? [],
            'tags' => $request->tags,
            'requirements' => $request->requirements
        ]);

        // Sync sub-services
        if ($request->has('subServices')) {
            $professionalService->subServices()->sync($request->subServices);
        } else {
            $professionalService->subServices()->sync([]);
        }

        return back()->with('success', 'Service updated successfully!');
    }

    /**
     * Delete service for professional (Admin)
     */
    public function deleteService($professionalId, $serviceId)
    {
        $professionalService = ProfessionalService::where('professional_id', $professionalId)
                                                   ->where('id', $serviceId)
                                                   ->firstOrFail();

        $professionalService->delete();

        return back()->with('success', 'Service deleted successfully!');
    }

    // ================ ADMIN RATES CRUD ================

    /**
     * Store a new rate for professional (Admin)
     */
    public function storeRate(Request $request, $professionalId)
    {
        $request->validate([
            'session_type' => 'required|in:One Time,Monthly,Quarterly,Free Hand',
            'num_sessions' => 'required|integer|min:1',
            'rate_per_session' => 'required|numeric|min:0',
            'final_rate' => 'required|numeric|min:0',
            'sub_service_id' => 'nullable|exists:sub_services,id',
            'features' => 'nullable|array',
            'features.*' => 'nullable|string'
        ]);

        $professional = Professional::findOrFail($professionalId);

        // Determine service_id
        $serviceId = null;
        if ($request->sub_service_id) {
            // If sub-service is selected, get its parent service_id
            $subService = \App\Models\SubService::find($request->sub_service_id);
            $serviceId = $subService ? $subService->service_id : null;
        }
        
        // If no service_id from sub-service, get from professional's primary service
        if (!$serviceId) {
            $professionalService = \App\Models\ProfessionalService::where('professional_id', $professionalId)->first();
            $serviceId = $professionalService ? $professionalService->service_id : null;
        }

        // Check for duplicate session type for this professional and sub-service combination
        $existingRate = Rate::where('professional_id', $professionalId)
            ->where('session_type', $request->session_type)
            ->where('sub_service_id', $request->sub_service_id)
            ->exists();

        if ($existingRate) {
            return back()->with('error', 'A rate with this session type already exists for this professional' . 
                ($request->sub_service_id ? ' and sub-service' : '') . '. Please choose a different session type.');
        }

        // Filter out empty features
        $features = array_filter($request->features ?? [], function($feature) {
            return !empty(trim($feature));
        });

        Rate::create([
            'professional_id' => $professionalId,
            'service_id' => $serviceId,
            'session_type' => $request->session_type,
            'num_sessions' => $request->num_sessions,
            'rate_per_session' => $request->rate_per_session,
            'final_rate' => $request->final_rate,
            'sub_service_id' => $request->sub_service_id,
            'features' => $features
        ]);

        return back()->with('success', 'Rate added successfully!');
    }

    /**
     * Update rate for professional (Admin)
     */
    public function updateRate(Request $request, $professionalId, $rateId)
    {
        $request->validate([
            'session_type' => 'required|in:One Time,Monthly,Quarterly,Free Hand',
            'num_sessions' => 'required|integer|min:1',
            'rate_per_session' => 'required|numeric|min:0',
            'final_rate' => 'required|numeric|min:0',
            'sub_service_id' => 'nullable|exists:sub_services,id',
            'features' => 'nullable|array',
            'features.*' => 'nullable|string'
        ]);

        $rate = Rate::where('professional_id', $professionalId)
                    ->where('id', $rateId)
                    ->firstOrFail();

        // Determine service_id
        $serviceId = null;
        if ($request->sub_service_id) {
            // If sub-service is selected, get its parent service_id
            $subService = \App\Models\SubService::find($request->sub_service_id);
            $serviceId = $subService ? $subService->service_id : null;
        }
        
        // If no service_id from sub-service, get from professional's primary service
        if (!$serviceId) {
            $professionalService = \App\Models\ProfessionalService::where('professional_id', $professionalId)->first();
            $serviceId = $professionalService ? $professionalService->service_id : null;
        }

        // Check for duplicate session type (excluding current rate)
        $existingRate = Rate::where('professional_id', $professionalId)
            ->where('session_type', $request->session_type)
            ->where('sub_service_id', $request->sub_service_id)
            ->where('id', '!=', $rateId)
            ->exists();

        if ($existingRate) {
            return back()->with('error', 'A rate with this session type already exists for this professional' . 
                ($request->sub_service_id ? ' and sub-service' : '') . '. Please choose a different session type.');
        }

        // Filter out empty features
        $features = array_filter($request->features ?? [], function($feature) {
            return !empty(trim($feature));
        });

        $rate->update([
            'service_id' => $serviceId,
            'session_type' => $request->session_type,
            'num_sessions' => $request->num_sessions,
            'rate_per_session' => $request->rate_per_session,
            'final_rate' => $request->final_rate,
            'sub_service_id' => $request->sub_service_id,
            'features' => $features
        ]);

        return back()->with('success', 'Rate updated successfully!');
    }

    /**
     * Delete rate for professional (Admin)
     */
    public function deleteRate($professionalId, $rateId)
    {
        $rate = Rate::where('professional_id', $professionalId)
                    ->where('id', $rateId)
                    ->firstOrFail();

        $rate->delete();

        return back()->with('success', 'Rate deleted successfully!');
    }

    // ================ ADMIN AVAILABILITY CRUD ================

    /**
     * Store new availability for professional (Admin)
     */
    public function storeAvailability(Request $request, $professionalId)
    {
        $request->validate([
            'months' => 'required|array|min:1',
            'months.*' => 'string|regex:/^\d{4}-\d{2}$/',
            'session_duration' => 'required|integer|min:15',
            'weekdays' => 'required|array|min:1',
            'weekdays.*' => 'in:mon,tue,wed,thu,fri,sat,sun',
            'slots' => 'required|array',
            'slots.*.start_time' => 'required|date_format:H:i',
            'slots.*.end_time' => 'required|date_format:H:i|after:slots.*.start_time',
            'slots.*.weekday' => 'required|in:mon,tue,wed,thu,fri,sat,sun'
        ]);

        $professional = Professional::findOrFail($professionalId);
        
        $successfulMonths = [];
        $skippedMonths = [];
        $errorMonths = [];

        DB::beginTransaction();
        try {
            foreach ($request->months as $month) {
                // Check if availability for this month already exists
                $existingAvailability = Availability::where('professional_id', $professionalId)
                                                    ->where('month', $month)
                                                    ->first();

                if ($existingAvailability) {
                    $skippedMonths[] = $month;
                    continue;
                }

                try {
                    $availability = Availability::create([
                        'professional_id' => $professionalId,
                        'month' => $month,
                        'session_duration' => $request->session_duration,
                        'weekdays' => json_encode($request->weekdays)
                    ]);

                    // Create slots
                    foreach ($request->slots as $slot) {
                        $availability->slots()->create([
                            'start_time' => $slot['start_time'],
                            'end_time' => $slot['end_time'],
                            'weekday' => $slot['weekday']
                        ]);
                    }
                    
                    $successfulMonths[] = $month;
                } catch (\Exception $e) {
                    $errorMonths[] = $month;
                    \Log::error("Failed to create availability for month {$month}: " . $e->getMessage());
                }
            }

            DB::commit();
            
            // Prepare response message
            $message = '';
            if (count($successfulMonths) > 0) {
                $message .= 'Availability created for ' . count($successfulMonths) . ' month(s). ';
            }
            if (count($skippedMonths) > 0) {
                $message .= count($skippedMonths) . ' month(s) already had availability and were skipped. ';
            }
            if (count($errorMonths) > 0) {
                $message .= count($errorMonths) . ' month(s) failed to save due to errors. ';
            }
            
            $isSuccess = count($successfulMonths) > 0;
            
            // Return JSON response for AJAX requests
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => $isSuccess,
                    'message' => $message ?: 'No availability was created.',
                    'details' => [
                        'successful' => $successfulMonths,
                        'skipped' => $skippedMonths,
                        'errors' => $errorMonths
                    ]
                ]);
            }
            
            if ($isSuccess) {
                return back()->with('success', $message);
            } else {
                return back()->with('error', $message ?: 'Failed to create any availability.');
            }
            
        } catch (\Exception $e) {
            DB::rollback();
            
            // Return JSON response for AJAX requests
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to add availability.',
                    'error' => $e->getMessage()
                ], 500);
            }
            
            return back()->with('error', 'Failed to add availability.');
        }
    }

    /**
     * Update availability for professional (Admin)
     */
    public function updateAvailability(Request $request, $professionalId, $availabilityId)
    {
        $request->validate([
            'months' => 'required|array|min:1',
            'months.*' => 'string|regex:/^\d{4}-\d{2}$/',
            'session_duration' => 'required|integer|min:15',
            'weekdays' => 'required|array|min:1',
            'weekdays.*' => 'in:mon,tue,wed,thu,fri,sat,sun',
            'slots' => 'required|array',
            'slots.*.start_time' => 'required|date_format:H:i',
            'slots.*.end_time' => 'required|date_format:H:i|after:slots.*.start_time',
            'slots.*.weekday' => 'nullable|in:mon,tue,wed,thu,fri,sat,sun'
        ]);

        $availability = Availability::where('professional_id', $professionalId)
                                    ->where('id', $availabilityId)
                                    ->firstOrFail();

        DB::beginTransaction();
        try {
            // If user selected multiple months, we need to handle this carefully
            // For edit mode, we'll update the current availability to the first selected month
            // and create new ones for additional months
            
            $selectedMonths = $request->months;
            $firstMonth = array_shift($selectedMonths); // Get and remove first month
            
            $successfulMonths = [];
            $skippedMonths = [];
            $errorMonths = [];
            
            // Update the existing availability with the first selected month
            // Check if another availability already exists for this month (excluding current one)
            $conflictingAvailability = Availability::where('professional_id', $professionalId)
                                                    ->where('month', $firstMonth)
                                                    ->where('id', '!=', $availabilityId)
                                                    ->first();
            
            if ($conflictingAvailability) {
                $skippedMonths[] = $firstMonth;
            } else {
                // Update availability
                $availability->update([
                    'month' => $firstMonth,
                    'session_duration' => $request->session_duration,
                    'weekdays' => json_encode($request->weekdays)
                ]);

                // Delete existing slots and create new ones
                $availability->slots()->delete();
                foreach ($request->slots as $slot) {
                    $availability->slots()->create([
                        'start_time' => $slot['start_time'],
                        'end_time' => $slot['end_time'],
                        'weekday' => $slot['weekday'] ?? null
                    ]);
                }
                
                $successfulMonths[] = $firstMonth;
            }
            
            // Create new availabilities for additional months
            foreach ($selectedMonths as $month) {
                $existingAvailability = Availability::where('professional_id', $professionalId)
                                                    ->where('month', $month)
                                                    ->first();

                if ($existingAvailability) {
                    $skippedMonths[] = $month;
                    continue;
                }

                try {
                    $newAvailability = Availability::create([
                        'professional_id' => $professionalId,
                        'month' => $month,
                        'session_duration' => $request->session_duration,
                        'weekdays' => json_encode($request->weekdays)
                    ]);

                    // Create slots
                    foreach ($request->slots as $slot) {
                        $newAvailability->slots()->create([
                            'start_time' => $slot['start_time'],
                            'end_time' => $slot['end_time'],
                            'weekday' => $slot['weekday'] ?? null
                        ]);
                    }
                    
                    $successfulMonths[] = $month;
                } catch (\Exception $e) {
                    $errorMonths[] = $month;
                    \Log::error("Failed to create availability for month {$month}: " . $e->getMessage());
                }
            }

            DB::commit();
            
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
            
            // Return JSON response for AJAX requests
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => $isSuccess,
                    'message' => $message ?: 'No availability was updated.',
                    'details' => [
                        'successful' => $successfulMonths,
                        'skipped' => $skippedMonths,
                        'errors' => $errorMonths
                    ]
                ]);
            }
            
            if ($isSuccess) {
                return back()->with('success', $message);
            } else {
                return back()->with('error', $message ?: 'Failed to update any availability.');
            }
            
        } catch (\Exception $e) {
            DB::rollback();
            
            // Return JSON response for AJAX requests
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to update availability.',
                    'error' => $e->getMessage()
                ], 500);
            }
            
            return back()->with('error', 'Failed to update availability.');
        }
    }

    /**
     * Delete availability for professional (Admin)
     */
    public function deleteAvailability(Request $request, $professionalId, $availabilityId)
    {
        $availability = Availability::where('professional_id', $professionalId)
                                    ->where('id', $availabilityId)
                                    ->firstOrFail();

        DB::beginTransaction();
        try {
            // Delete slots first
            $availability->slots()->delete();
            $availability->delete();

            DB::commit();
            
            // Return JSON response for AJAX requests
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Availability deleted successfully!'
                ]);
            }
            
            return back()->with('success', 'Availability deleted successfully!');
        } catch (\Exception $e) {
            DB::rollback();
            
            // Return JSON response for AJAX requests
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to delete availability.',
                    'error' => $e->getMessage()
                ], 500);
            }
            
            return back()->with('error', 'Failed to delete availability.');
        }
    }

    /**
     * Update commission settings for a professional
     */
    public function updateCommission(Request $request, $id)
    {
        $request->validate([
            'margin' => 'required|numeric|min:0|max:100',
            'service_request_margin' => 'required|numeric|min:0|max:100',
            'service_request_offset' => 'required|numeric|min:0|max:100',
        ]);

        try {
            $professional = Professional::findOrFail($id);
            
            $professional->update([
                'margin' => $request->margin,
                'service_request_margin' => $request->service_request_margin,
                'service_request_offset' => $request->service_request_offset,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Commission settings updated successfully.',
                'data' => [
                    'margin' => $professional->margin,
                    'service_request_margin' => $professional->service_request_margin,
                    'service_request_offset' => $professional->service_request_offset,
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update commission settings.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Send email to customer or professional
     */
    public function sendEmail(Request $request)
    {
        try {
            $request->validate([
                'recipient_email' => 'required|email',
                'recipient_type' => 'required|in:customer,professional',
                'subject' => 'required|string|max:255',
                'message' => 'required|string',
            ]);

            $recipientEmail = $request->recipient_email;
            $subject = $request->subject;
            $messageContent = $request->message;
            $recipientType = $request->recipient_type;

            // Send email using Laravel's Mail facade
            Mail::send([], [], function ($message) use ($recipientEmail, $subject, $messageContent) {
                $message->to($recipientEmail)
                    ->subject($subject)
                    ->html($messageContent);
            });

            return response()->json([
                'success' => true,
                'message' => 'Email sent successfully to ' . ucfirst($recipientType) . '!'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to send email. Please check your email configuration.'
            ], 500);
        }
    }
}
