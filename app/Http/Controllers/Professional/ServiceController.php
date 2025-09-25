<?php

namespace App\Http\Controllers\Professional;

use App\Http\Controllers\Controller;
use App\Models\ProfessionalService;
use App\Models\Service;
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
        $services = ProfessionalService::with('service')
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
        $services = Service::all();
        
        // Get professional's profile and specialization
        $professional = Auth::guard('professional')->user();
        $profile = $professional->profile;
        $specialization = $profile ? $profile->specialization : null;
        
        // Find the matching service ID for this specialization
        $matchingServiceId = null;
        if ($specialization) {
            // Try to find an exact match first
            $matchingService = $services->first(function($service) use ($specialization) {
                return strtolower($service->name) === strtolower($specialization);
            });
            
            // If no exact match, try to find partial match
            if (!$matchingService) {
                $matchingService = $services->first(function($service) use ($specialization) {
                    return stripos($service->name, $specialization) !== false || 
                           stripos($specialization, $service->name) !== false;
                });
            }
            
            if ($matchingService) {
                $matchingServiceId = $matchingService->id;
            }
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
        ]);
        
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
        
        $service->duration = $request->serviceDuration;
        $service->description = 'Online session service'; // Add default description
        $service->features = $request->features ? json_encode($request->features) : json_encode(['online']);
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

        return response()->json([
            'success' => true,
            'message' => 'Service has been added successfully.'
        ]);
    }



    public function show(string $id) {}

    public function edit(string $id)
    {
        $service = ProfessionalService::where('id', $id)
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
        }

        $service->duration = $request->serviceDuration;
        $service->description = 'Online session service'; // Add default description
        $service->features = $request->features ? json_encode($request->features) : json_encode(['online']);
        $service->tags = $request->serviceTags;
        $service->requirements = $request->serviceRequirements;

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
