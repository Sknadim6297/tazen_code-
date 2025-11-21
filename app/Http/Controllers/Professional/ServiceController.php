<?php

namespace App\Http\Controllers\Professional;

use App\Http\Controllers\Controller;
use App\Models\ProfessionalService;
use App\Models\Service;
use App\Models\SubService;
use App\Traits\ImageUploadTraits;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ServiceController extends Controller
{
    use ImageUploadTraits;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $services = ProfessionalService::with(['service', 'subServices'])
            ->where('professional_id', Auth::guard('professional')->id())
            ->get();

        // Pass the services to the view
        return view('professional.service.index', compact('services'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Get professional's profile and specialization
        $professional = Auth::guard('professional')->user();
        $profile = $professional->profile;
        $specialization = $profile ? $profile->specialization : null;
        
        // Only get services that match the professional's specialization
        $services = collect();
        $matchingServiceId = null;
        
        if ($specialization) {
            $allServices = Service::all();
            
            // Try to find an exact match first
            $matchingService = $allServices->first(function($service) use ($specialization) {
                return strtolower($service->name) === strtolower($specialization);
            });
            
            // If no exact match, try to find partial match
            if (!$matchingService) {
                $matchingService = $allServices->first(function($service) use ($specialization) {
                    return stripos($service->name, $specialization) !== false || 
                           stripos($specialization, $service->name) !== false;
                });
            }
            
            if ($matchingService) {
                $matchingServiceId = $matchingService->id;
                // Only provide the matching service(s) - professionals can only create services in their specialization
                $services = collect([$matchingService]);
            }
        }
        
        // Check if professional has no specialization or no matching services
        if (!$specialization) {
            return redirect()->back()->with('error', 'Please complete your profile with a valid specialization before creating services.');
        }
        
        if ($services->isEmpty()) {
            return redirect()->back()->with('error', 'No service categories found matching your specialization: ' . $specialization . '. Please contact support for assistance.');
        }
        
        // Log information for debugging
        \Illuminate\Support\Facades\Log::info('Service creation - Specialization debug', [
            'professional_id' => $professional->id,
            'has_profile' => !is_null($profile),
            'specialization' => $specialization,
            'service_names' => $services->pluck('name')->toArray(),
            'matching_service_id' => $matchingServiceId
        ]);
        
        return view('professional.service.create', compact('services', 'specialization', 'matchingServiceId'));
    }

    /**
     * Get sub-services for a given service category
     */
    public function getSubServices(Request $request)
    {
        $serviceId = $request->get('service_id');
        
        if (!$serviceId) {
            return response()->json([
                'success' => false,
                'message' => 'Service ID is required'
            ], 400);
        }
        
        $subServices = SubService::where('service_id', $serviceId)
            ->where('status', 1)
            ->select('id', 'name', 'description')
            ->get();
        
        return response()->json([
            'success' => true,
            'subServices' => $subServices
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'serviceId' => 'required|integer|exists:services,id',
            'serviceDuration' => 'required|integer',
            'features' => 'nullable|array',
            'serviceTags' => 'nullable|string',
            'serviceRequirements' => 'nullable|string',
            'subServices' => 'nullable|array|',
            'subServices.*' => 'exists:sub_services,id',
        ]);
        
        // Validate that the professional can only create services in their specialization
        $professional = Auth::guard('professional')->user();
        $profile = $professional->profile;
        $specialization = $profile ? $profile->specialization : null;
        
        if ($specialization) {
            $selectedService = Service::find($request->serviceId);
            if ($selectedService) {
                $isValidSpecialization = strtolower($selectedService->name) === strtolower($specialization) ||
                                       stripos($selectedService->name, $specialization) !== false ||
                                       stripos($specialization, $selectedService->name) !== false;
                
                if (!$isValidSpecialization) {
                    return response()->json([
                        'success' => false,
                        'message' => 'You can only create services in your registered specialization: ' . $specialization
                    ], 422);
                }
            }
        }
        
        // If no serviceId is provided, get the professional's specialization 
        // and find matching service
        if (empty($request->serviceId)) {
            $professional = Auth::guard('professional')->user();
            $profile = $professional->profile;
            
            if ($profile && $profile->specialization) {
                $specialization = $profile->specialization;
                $service = Service::where('name', 'LIKE', "%$specialization%")->first();
                
                if (!$service) {
                    return response()->json([
                        'success' => false,
                        'message' => 'No matching service found for your specialization. Please contact support.'
                    ], 422);
                }
                
                $request->merge(['serviceId' => $service->id]);
            }
        }

        $service = new ProfessionalService();
        $service->professional_id = Auth::guard('professional')->id();
        $service->service_id = $request->serviceId;
        
        // Get the service category name to use as service_name
        $serviceCategory = Service::find($request->serviceId);
    $service->service_name = $serviceCategory ? $serviceCategory->name : 'Online Service';
    // Keep legacy 'category' column in sync to satisfy NOT NULL schemas
    $service->category = $service->service_name;
        
        $service->duration = $request->serviceDuration;
        $service->description = 'Online session service'; // Add default description
    // Store features as array; Eloquent will JSON-encode due to casts
    $service->features = $request->features ?? ['online'];
        $service->tags = $request->serviceTags;
        $service->requirements = $request->serviceRequirements;

        if ($request->hasFile('serviceImage')) {
            try {
                $service->image_path = $this->uploadImage($request, 'serviceImage', 'uploads/professional/photo');
                if (!$service->image_path) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Image upload failed.'
                    ], 400);
                }
            } catch (\Exception $e) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error occurred while uploading the image. ' . $e->getMessage()
                ], 500);
            }
        }

        $service->save();
        
        // Attach selected sub-services if any (ensure they belong to the selected service and limit to 2)
        if ($request->has('subServices') && is_array($request->subServices)) {
            // Validate that all sub-services belong to the selected service
            $validSubServices = SubService::where('service_id', $request->serviceId)
                ->whereIn('id', $request->subServices)
                ->pluck('id')
                ->toArray();

            // Enforce maximum 2 selections server-side as well
            $validSubServices = array_slice($validSubServices, 0, 2);

            if (!empty($validSubServices)) {
                $service->subServices()->attach($validSubServices);
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Service has been added successfully.'
        ]);
    }



    public function show(string $id) {}

    public function edit(string $id)
    {
        $service = ProfessionalService::with('subServices')->where('id', $id)
            ->where('professional_id', Auth::guard('professional')->id())
            ->firstOrFail();
        $services = Service::all();
        
        // Get professional's profile and specialization
        $professional = Auth::guard('professional')->user();
        $profile = $professional->profile;
        $specialization = $profile ? $profile->specialization : null;
        
        // Find the matching service ID for this specialization
        $matchingServiceId = null;
        if ($specialization && !$service->service_id) {
            // Try to find an exact match first
            $matchingService = $services->first(function($s) use ($specialization) {
                return strtolower($s->name) === strtolower($specialization);
            });
            
            // If no exact match, try to find partial match
            if (!$matchingService) {
                $matchingService = $services->first(function($s) use ($specialization) {
                    return stripos($s->name, $specialization) !== false || 
                           stripos($specialization, $s->name) !== false;
                });
            }
            
            if ($matchingService) {
                $matchingServiceId = $matchingService->id;
            }
        }
        
        return view('professional.service.edit', compact('service', 'services', 'specialization', 'matchingServiceId'));
    }


    public function update(Request $request, string $id)
    {
        $request->validate([
            'serviceId' => 'required|integer|exists:services,id',
            'serviceDuration' => 'required|integer',
            'features' => 'nullable|array',
            'serviceTags' => 'nullable|string',
            'serviceRequirements' => 'nullable|string',
            'subServices' => 'nullable|array',
            'subServices.*' => 'exists:sub_services,id',
        ]);

        $service = ProfessionalService::where('id', $id)
            ->where('professional_id', Auth::guard('professional')->id())
            ->firstOrFail();

        // Update service_id and service_name if changed
        if ($request->serviceId != $service->service_id) {
            $service->service_id = $request->serviceId;
            
            // Get the service category name to use as service_name
            $serviceCategory = Service::find($request->serviceId);
            $service->service_name = $serviceCategory ? $serviceCategory->name : 'Online Service';
            // Keep legacy 'category' column in sync when service changes
            $service->category = $service->service_name;
        }

        $service->duration = $request->serviceDuration;
        $service->description = 'Online session service'; // Add default description
        // Store features as array; Eloquent will JSON-encode due to casts
        $service->features = $request->features ?? ['online'];
        $service->tags = $request->serviceTags;
        $service->requirements = $request->serviceRequirements;

        // Ensure category is set even if serviceId didn’t change (for older rows)
        if (empty($service->category)) {
            $service->category = $service->service_name;
        }

        if ($request->hasFile('serviceImage')) {
            if ($service->image_path && file_exists(public_path($service->image_path))) {
                @unlink(public_path($service->image_path));
            }
            try {
                $service->image_path = $this->uploadImage($request, 'serviceImage', 'uploads/professional/photo');
                if (!$service->image_path) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Image upload failed.'
                    ], 400);
                }
            } catch (\Exception $e) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error occurred while uploading the image. ' . $e->getMessage()
                ], 500);
            }
        }

        $service->save();
        
        // Update sub-services
        if ($request->has('subServices') && is_array($request->subServices)) {
            // Validate that all sub-services belong to the selected service
            $validSubServices = SubService::where('service_id', $request->serviceId)
                ->whereIn('id', $request->subServices)
                ->pluck('id')
                ->toArray();
            
            // Sync sub-services (this will replace existing ones)
            $service->subServices()->sync($validSubServices);
        } else {
            // If no sub-services are selected, remove all existing ones
            $service->subServices()->detach();
        }

        return response()->json([
            'success' => true,
            'message' => 'Service has been updated successfully.'
        ]);
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $service = ProfessionalService::where('id', $id)
            ->where('professional_id', Auth::guard('professional')->id())
            ->firstOrFail();

        // Delete the image file if it exists
        if ($service->image_path && file_exists(public_path($service->image_path))) {
            @unlink(public_path($service->image_path));
        }

        $service->delete();

        return response()->json([
            'success' => true,
            'message' => 'Service has been deleted successfully.'
        ]);
    }
}
