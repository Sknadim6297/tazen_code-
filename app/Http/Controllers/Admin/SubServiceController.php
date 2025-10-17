<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SubService;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SubServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = SubService::with('service');

        // Filter by service
        if ($request->filled('service_id')) {
            $query->where('service_id', $request->service_id);
        }

        // Filter by status
        if ($request->filled('status')) {
            $statusValue = $request->status === 'active' ? 1 : 0;
            $query->where('status', $statusValue);
        }

        // Search by name
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $subServices = $query->latest()->paginate(10);
        $services = Service::where('status', 'active')->get();

        return view('admin.sub-service.index', compact('subServices', 'services'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $services = Service::where('status', 'active')->get();
        return view('admin.sub-service.create', compact('services'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'service_id' => 'required|exists:services,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'status' => 'required|in:active,inactive',
        ]);

        // Prevent adding duplicate sub-service names for the same service (case-insensitive)
        $duplicate = SubService::where('service_id', $request->service_id)
            ->whereRaw('LOWER(name) = ?', [strtolower($request->name)])
            ->exists();

        if ($duplicate) {
            return redirect()->back()->withInput()->with('error', 'You have already added this sub-service for the selected service.');
        }

        $data = $request->only(['service_id', 'name', 'description']);
        $data['status'] = $request->status === 'active' ? 1 : 0;

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('uploads/sub-services', 'public');
            $data['image'] = $imagePath;
        }

        SubService::create($data);

        return redirect()->route('admin.sub-service.index')
            ->with('success', 'Sub-service created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(SubService $subService)
    {
        $subService->load('service');
        return view('admin.sub-service.show', compact('subService'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SubService $subService)
    {
        $services = Service::where('status', 'active')->get();
        return view('admin.sub-service.edit', compact('subService', 'services'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SubService $subService)
    {
        $request->validate([
            'service_id' => 'required|exists:services,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'status' => 'required|in:active,inactive',
        ]);

        // Prevent updating to a name that would duplicate another sub-service under the same service
        $duplicate = SubService::where('service_id', $request->service_id)
            ->whereRaw('LOWER(name) = ?', [strtolower($request->name)])
            ->where('id', '!=', $subService->id)
            ->exists();

        if ($duplicate) {
            return redirect()->back()->withInput()->with('error', 'Another sub-service with this name already exists for the selected service.');
        }

        $data = $request->only(['service_id', 'name', 'description']);
        $data['status'] = $request->status === 'active' ? 1 : 0;

        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($subService->image) {
                Storage::disk('public')->delete($subService->image);
            }
            
            $imagePath = $request->file('image')->store('uploads/sub-services', 'public');
            $data['image'] = $imagePath;
        }

        $subService->update($data);

        return redirect()->route('admin.sub-service.index')
            ->with('success', 'Sub-service updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SubService $subService)
    {
        // Delete image if exists
        if ($subService->image) {
            Storage::disk('public')->delete($subService->image);
        }

        $subService->delete();

        return redirect()->route('admin.sub-service.index')
            ->with('success', 'Sub-service deleted successfully.');
    }
}
