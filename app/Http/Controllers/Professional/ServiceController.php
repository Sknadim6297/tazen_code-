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
        // dd($services);
        return view('professional.service.create', compact('services'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'serviceId' => 'required|integer|exists:services,id',
            'serviceName' => 'required|string|max:255',
            'serviceDuration' => 'required|integer',
            'serviceImage' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',
            'serviceDescription' => 'required|string',
            'features' => 'nullable|array',
            'serviceTags' => 'nullable|string',
            'serviceRequirements' => 'nullable|string',
        ]);

        $service = new ProfessionalService();
        $service->professional_id = Auth::guard('professional')->id();
        $service->service_id = $request->serviceId;
        $service->service_name = $request->serviceName;
        $service->duration = $request->serviceDuration;
        $service->description = $request->serviceDescription;
        $service->features = $request->features ? json_encode($request->features) : null;
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
        $service = ProfessionalService::findOrFail($id);
        $services = Service::all();
        return view('professional.service.edit', compact('service', 'services'));
    }


    public function update(Request $request, string $id)
    {
        $request->validate([
            'serviceId' => 'required|integer|exists:services,id',
            'serviceName' => 'required|string|max:255',
            'serviceDuration' => 'required|integer',
            'serviceImage' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',
            'serviceDescription' => 'required|string',
            'features' => 'nullable|array',
            'serviceTags' => 'nullable|string',
            'serviceRequirements' => 'nullable|string',
        ]);
        $service = ProfessionalService::findOrFail($id);
        $service->professional_id = Auth::guard('professional')->id();
        $service->service_id = $request->serviceId;
        $service->service_name = $request->serviceName;
        $service->duration = $request->serviceDuration;
        $service->description = $request->serviceDescription;
        $service->features = $request->features ? json_encode($request->features) : null;
        $service->tags = $request->serviceTags;
        $service->requirements = $request->serviceRequirements;
        if ($request->hasFile('serviceImage')) {
            if ($service->image_path) {
                unlink(public_path($service->image_path));
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
        $service = ProfessionalService::findOrFail($id);
        if ($service->image_path) {
            unlink(public_path($service->image_path));
        }

        $service->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'Service has been deleted successfully.'
        ]);
    }
}
