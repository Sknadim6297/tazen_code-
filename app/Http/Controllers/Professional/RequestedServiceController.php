<?php

namespace App\Http\Controllers\Professional;

use App\Http\Controllers\Controller;
use App\Models\OtherInformation;
use App\Models\ProfessionalOtherInformation;
use App\Models\RequestedService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RequestedServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $requestedServices = ProfessionalOtherInformation::where('professional_id', Auth::guard('professional')->id())->get();
        // dd($requestedServices);
        $serviceCount = ProfessionalOtherInformation::where('professional_id', auth()->id())->count();
        return view('professional.requested_services.index', compact('requestedServices', 'serviceCount'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('professional.requested_services.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the incoming request
        $validated = $request->validate([
            'sub_heading' => 'required|string',
            'requested_service' => 'required|array',
            'price' => 'required|array',
            'statement' => 'nullable|string',
            'specializations' => 'nullable|array',
            'education_statement' => 'nullable|string',
            'college_name' => 'nullable|array',
            'degree' => 'nullable|array',
        ]);

        // Store the data
        $professionalOtherInfo = new ProfessionalOtherInformation();
        $professionalOtherInfo->professional_id = Auth::guard('professional')->id();
        $professionalOtherInfo->sub_heading = $validated['sub_heading'];
        $professionalOtherInfo->requested_service = json_encode($validated['requested_service']);
        $professionalOtherInfo->price = json_encode($validated['price']);
        $professionalOtherInfo->statement = $validated['statement'];
        $professionalOtherInfo->specializations = json_encode($validated['specializations']);
        $professionalOtherInfo->education_statement = $validated['education_statement'];
        $professionalOtherInfo->education = json_encode([
            'college_name' => $validated['college_name'],
            'degree' => $validated['degree']
        ]);
        $professionalOtherInfo->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Other Information added successfully.',
        ]);
    }

    public function show(string $id) {}

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $info = ProfessionalOtherInformation::findOrFail($id);
        // dd($info);
        return view('professional.requested_services.edit', compact('info'));
    }
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'sub_heading' => 'required|string',
            'requested_service' => 'required|array',
            'price' => 'required|array',
            'statement' => 'nullable|string',
            'specializations' => 'nullable|array',
            'education_statement' => 'nullable|string',
            'college_name' => 'nullable|array',
            'degree' => 'nullable|array',
        ]);

        $info = ProfessionalOtherInformation::findOrFail($id);
        $info->sub_heading = $validated['sub_heading'];
        $info->requested_service = json_encode($validated['requested_service']);
        $info->price = json_encode($validated['price']);
        $info->statement = $validated['statement'];
        $info->specializations = json_encode($validated['specializations']);
        $info->education_statement = $validated['education_statement'];
        $info->education = json_encode([
            'college_name' => $validated['college_name'],
            'degree' => $validated['degree']
        ]);
        $info->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Other Information updated successfully.',
        ]);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $requestedService = ProfessionalOtherInformation::findOrFail($id);
        if ($requestedService->professional_id != Auth::guard('professional')->id()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized access'
            ], 403);
        }

        $requestedService->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Other Information deleted successfully.'
        ]);
    }
}
