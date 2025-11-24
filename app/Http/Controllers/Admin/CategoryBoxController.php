<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CategoryBox;
use App\Models\SubCategory;
use App\Models\SubService;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CategoryBoxController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categoryBoxes = CategoryBox::with('subCategories')->get();
        $services = \App\Models\Service::all();
        return view('admin.categorybox.index', compact('categoryBoxes', 'services'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.categorybox.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'status' => 'required|boolean',
            'main_service_id' => 'required|exists:services,id',
            'subcategories' => 'nullable|array',
            'subcategories.*.sub_service_id' => 'required_with:subcategories|exists:sub_services,id',
            'subcategories.*.image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'service_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048'
        ]);

        // Create main category
        $categoryBox = CategoryBox::create([
            'name' => $request->name,
            'status' => $request->status
        ]);

        // Handle main service image (always create if image is provided)
        if ($request->hasFile('service_image')) {
            $imagePath = $request->file('service_image')->store('subcategories', 'public');
            
            // Get service name
            $service = Service::find($request->main_service_id);
            
            SubCategory::create([
                'category_box_id' => $categoryBox->id,
                'service_id' => $request->main_service_id,
                'name' => $service ? $service->name : 'Service',
                'image' => $imagePath,
                'status' => true
            ]);
        }
        
        // Handle sub-services (can be added along with main service image)
        if ($request->has('subcategories') && is_array($request->subcategories) && count($request->subcategories) > 0) {
            // Service WITH sub-services
            foreach ($request->subcategories as $subcategoryData) {
                $imagePath = null;
                
                // Handle image upload for sub-service
                if (isset($subcategoryData['image']) && $subcategoryData['image']) {
                    $imagePath = $subcategoryData['image']->store('subcategories', 'public');
                }

                // Get sub-service name
                $subService = SubService::find($subcategoryData['sub_service_id']);
                
                SubCategory::create([
                    'category_box_id' => $categoryBox->id,
                    'service_id' => $request->main_service_id,
                    'name' => $subService ? $subService->name : 'Unknown',
                    'image' => $imagePath,
                    'status' => true
                ]);
            }
        } elseif (!$request->hasFile('service_image')) {
            // No sub-services and no main image - create a basic entry with service name
            $service = Service::find($request->main_service_id);
            
            SubCategory::create([
                'category_box_id' => $categoryBox->id,
                'service_id' => $request->main_service_id,
                'name' => $service ? $service->name : 'Service',
                'image' => null,
                'status' => true
            ]);
        }

        return redirect()->route('admin.categorybox.index')->with('success', 'Category created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $categoryBox = CategoryBox::with('subCategories')->findOrFail($id);
        return view('admin.categorybox.show', compact('categoryBox'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $categoryBox = CategoryBox::with('subCategories')->findOrFail($id);
        $services = Service::all();
        return view('admin.categorybox.edit', compact('categoryBox', 'services'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'status' => 'required|boolean',
            'main_service_id' => 'nullable|exists:services,id',
            'existing_subcategories' => 'nullable|array',
            'existing_subcategories.*.image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'new_subcategories' => 'nullable|array',
            'new_subcategories.*.sub_service_id' => 'required_with:new_subcategories|exists:sub_services,id',
            'new_subcategories.*.image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'new_service_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'deleted_subcategories' => 'nullable|string'
        ]);

        $categoryBox = CategoryBox::findOrFail($id);
        
        // Update main category
        $categoryBox->update([
            'name' => $request->name,
            'status' => $request->status
        ]);

        // Handle deleted subcategories
        if ($request->filled('deleted_subcategories')) {
            $deletedIds = explode(',', $request->deleted_subcategories);
            foreach ($deletedIds as $deletedId) {
                $subcategory = SubCategory::find($deletedId);
                if ($subcategory && $subcategory->category_box_id == $categoryBox->id) {
                    // Delete image from storage
                    if ($subcategory->image) {
                        Storage::disk('public')->delete($subcategory->image);
                    }
                    $subcategory->delete();
                }
            }
        }

        // Update existing subcategories (images only)
        if ($request->has('existing_subcategories')) {
            foreach ($request->existing_subcategories as $subcategoryData) {
                if (isset($subcategoryData['id'])) {
                    $subcategory = SubCategory::find($subcategoryData['id']);
                    if ($subcategory && isset($subcategoryData['image'])) {
                        // Delete old image
                        if ($subcategory->image) {
                            Storage::disk('public')->delete($subcategory->image);
                        }
                        // Upload new image
                        $imagePath = $subcategoryData['image']->store('subcategories', 'public');
                        $subcategory->update(['image' => $imagePath]);
                    }
                }
            }
        }

        // Handle main service image update (check if main service subcategory exists)
        if ($request->hasFile('new_service_image')) {
            $service = Service::find($request->main_service_id);
            $imagePath = $request->file('new_service_image')->store('subcategories', 'public');
            
            // Check if main service subcategory already exists (name matches service name)
            $service = Service::find($request->main_service_id);
            $mainServiceSubCategory = $categoryBox->subCategories()
                ->where('service_id', $request->main_service_id)
                ->where('name', $service ? $service->name : 'Service')
                ->first();
            
            if ($mainServiceSubCategory) {
                // Update existing main service image
                if ($mainServiceSubCategory->image) {
                    Storage::disk('public')->delete($mainServiceSubCategory->image);
                }
                $mainServiceSubCategory->update(['image' => $imagePath]);
            } else {
                // Create new main service subcategory
                SubCategory::create([
                    'category_box_id' => $categoryBox->id,
                    'service_id' => $request->main_service_id,
                    'name' => $service ? $service->name : 'Service',
                    'image' => $imagePath,
                    'status' => true
                ]);
            }
        }
        
        // Add new subcategories (can be added along with main service image)
        if ($request->has('new_subcategories') && is_array($request->new_subcategories)) {
            foreach ($request->new_subcategories as $newSubData) {
                $imagePath = null;
                
                if (isset($newSubData['image'])) {
                    $imagePath = $newSubData['image']->store('subcategories', 'public');
                }

                $subService = SubService::find($newSubData['sub_service_id']);
                
                SubCategory::create([
                    'category_box_id' => $categoryBox->id,
                    'service_id' => $request->main_service_id,
                    'name' => $subService ? $subService->name : 'Unknown',
                    'image' => $imagePath,
                    'status' => true
                ]);
            }
        }

        return redirect()->route('admin.categorybox.index')->with('success', 'Category updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $categoryBox = CategoryBox::findOrFail($id);
        
        // Delete subcategory images
        foreach ($categoryBox->subCategories as $subcategory) {
            if ($subcategory->image) {
                Storage::disk('public')->delete($subcategory->image);
            }
        }
        
        // Delete the category (subcategories will be deleted due to cascade)
        $categoryBox->delete();

        return redirect()->route('admin.categorybox.index')->with('success', 'Category deleted successfully!');
    }

    /**
     * Get sub-services for a specific service via AJAX
     */
    public function getSubServices($serviceId)
    {
        $subServices = SubService::where('service_id', $serviceId)->get();
        
        return response()->json([
            'success' => true,
            'subServices' => $subServices
        ]);
    }
}
