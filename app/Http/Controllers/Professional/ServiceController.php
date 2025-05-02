<?php

namespace App\Http\Controllers\Professional;

use App\Http\Controllers\Controller;
use App\Models\ProfessionalService;
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
        $services = ProfessionalService::where('professional_id', Auth::guard('professional')->id())->get();
        return view('professional.service.index', compact('services'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('professional.service.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'serviceName' => 'required|string|max:255',
            'serviceCategory' => 'required|string',
            'serviceDuration' => 'required|integer',
            'serviceImage' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',
            'serviceDescription' => 'required|string',
            'features' => 'nullable|array',
            'serviceTags' => 'nullable|string',
            'serviceRequirements' => 'nullable|string', 
        ]);


        $service = new ProfessionalService();
        $service->professional_id = Auth::guard('professional')->id();
        $service->service_name = $request->serviceName;
        $service->category = $request->serviceCategory;
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
        // dd($service);
        return view('professional.service.edit', compact('service'));
    }


    public function update(Request $request, string $id)
    {
        // Validate the incoming data
        $request->validate([
            'serviceName' => 'required|string|max:255',
            'serviceCategory' => 'required|string',
            'serviceDuration' => 'required|integer',
            'serviceImage' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',
            'serviceDescription' => 'required|string',
            'features' => 'nullable|array',
            'serviceTags' => 'nullable|string',
            'serviceRequirements' => 'nullable|string',
        ]);

        // Find the service by ID
        $service = ProfessionalService::findOrFail($id);
        $service->professional_id = Auth::guard('professional')->id();
        $service->service_name = $request->serviceName;
        $service->category = $request->serviceCategory;
        $service->duration = $request->serviceDuration;
        $service->description = $request->serviceDescription;
        $service->features = $request->features ? json_encode($request->features) : null;
        $service->tags = $request->serviceTags;
        $service->requirements = $request->serviceRequirements;

        // Handle image upload if a new image is uploaded
        if ($request->hasFile('serviceImage')) {
            try {
                // Delete old image if exists
                if ($service->image_path) {
                    unlink(public_path($service->image_path));
                }
                // Upload new image
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

        // Save the updated service
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
