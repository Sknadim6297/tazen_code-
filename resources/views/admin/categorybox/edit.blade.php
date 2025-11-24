@extends('admin.layouts.layout')
@section('content')
<div class="main-content app-content">
    <div class="container-fluid">

        <!-- Page Header -->
        <div class="my-4 page-header-breadcrumb d-flex align-items-center justify-content-between flex-wrap gap-2">
            <div>
                <h1 class="page-title fw-medium fs-18 mb-2">Edit Category</h1>
                <div class="">
                    <nav>
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="javascript:void(0);">Admin</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('admin.categorybox.index') }}">Category Management</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Edit Category</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <!-- Page Header Close -->

        <!-- Start::row-2 -->
        <div class="row">
            <div class="col-xxl-12 col-xl-12">
                <div class="card custom-card">
                    <div class="card-header justify-content-between">
                        <div class="card-title">
                            Edit Category: {{ $categoryBox->name }}
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.categorybox.update', $categoryBox->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="row gy-3">
                                
                                {{-- Main Category Name --}}
                                <div class="col-xl-6">
                                    <label for="name" class="form-label">Main Tagline Name</label>
                                    <input type="text" class="form-control" id="name" name="name" 
                                           value="{{ old('name', $categoryBox->name) }}" 
                                           placeholder="Enter Main Category Name" required>
                                    @error('name')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                {{-- Main Category Icon --}}
                                <div class="col-xl-6">
                                    <label for="icon_name" class="form-label">Icon Name</label>
                                    <input type="text" class="form-control" id="icon_name" name="icon_name" 
                                           value="{{ old('icon_name', $categoryBox->icon_name) }}" 
                                           placeholder="Enter Icon Name">
                                    @error('icon_name')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                {{-- Status --}}
                                <div class="col-xl-12">
                                    <label for="status" class="form-label">Status</label>
                                    <select class="form-control" name="status" id="status" required>
                                        <option value="1" {{ old('status', $categoryBox->status) == 1 ? 'selected' : '' }}>Active</option>
                                        <option value="0" {{ old('status', $categoryBox->status) == 0 ? 'selected' : '' }}>Inactive</option>
                                    </select>
                                    @error('status')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Service Selection --}}
                                <div class="col-xl-12">
                                    <label for="main_service" class="form-label">Select Main Service <span class="text-danger">*</span></label>
                                    <select class="form-control" id="main_service" name="main_service_id" required>
                                        <option value="">Select Service</option>
                                        @foreach($services as $service)
                                            <option value="{{ $service->id }}" {{ old('main_service_id', $categoryBox->subCategories->first()->service_id ?? '') == $service->id ? 'selected' : '' }}>{{ $service->name }}</option>
                                        @endforeach
                                    </select>
                                    <small class="text-muted">Select the main service for this category</small>
                                </div>

                                {{-- Main Service Image --}}
                                <div class="col-xl-12">
                                    <label for="new_service_image" class="form-label">Main Service Image</label>
                                    <input type="file" class="form-control" id="new_service_image" name="new_service_image" accept="image/*" onchange="previewMainImage(this)">
                                    <small class="text-muted d-block mt-1">Upload or update the main service image (optional). This will be used if no sub-services are added.</small>
                                    @php
                                        // Find main service subcategory (one that matches the service name exactly)
                                        $firstSubCategory = $categoryBox->subCategories->first();
                                        $mainServiceSubCategory = null;
                                        if ($firstSubCategory) {
                                            $service = \App\Models\Service::find($firstSubCategory->service_id);
                                            if ($service && $service->name === $firstSubCategory->name) {
                                                $mainServiceSubCategory = $firstSubCategory;
                                            }
                                        }
                                    @endphp
                                    @if($mainServiceSubCategory && $mainServiceSubCategory->image)
                                        <div class="mt-2">
                                            <small class="text-muted">Current Main Service Image:</small>
                                            <img src="{{ asset('storage/' . $mainServiceSubCategory->image) }}" 
                                                 alt="Current Image" style="max-width: 200px; max-height: 200px; border-radius: 8px; border: 1px solid #ddd; margin-left: 10px;">
                                        </div>
                                    @endif
                                    <div id="main-image-preview" class="mt-2" style="display: none;">
                                        <img id="main-image-preview-img" src="" alt="Preview" style="max-width: 200px; max-height: 200px; border-radius: 8px; border: 1px solid #ddd;">
                                        <button type="button" class="btn btn-sm btn-danger mt-2" onclick="removeMainImagePreview()">
                                            <i class="ri-delete-bin-line"></i> Remove
                                        </button>
                                    </div>
                                </div>

                                {{-- Subcategories Section --}}
                                <div class="col-xl-12">
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <h6 class="mb-0">Current Subcategories / Images</h6>
                                        <button type="button" class="btn btn-sm btn-success" id="add-subcategory" disabled>
                                            <i class="ri-add-line"></i> Add Sub-Service
                                        </button>
                                    </div>
                                    <div class="alert alert-info">
                                        <i class="ri-information-line me-2"></i>
                                        <strong>Note:</strong> You can update:
                                        <ul class="mb-0 mt-2">
                                            <li>Main service image</li>
                                            <li>Existing sub-service images</li>
                                            <li>Add new sub-services with images</li>
                                        </ul>
                                    </div>
                                    <div id="subcategories-container">
                                        @if($categoryBox->subCategories->count() > 0)
                                            @php
                                                // Filter out main service subcategory (one that matches service name)
                                                $firstSubCategory = $categoryBox->subCategories->first();
                                                $serviceName = null;
                                                if ($firstSubCategory) {
                                                    $service = \App\Models\Service::find($firstSubCategory->service_id);
                                                    $serviceName = $service ? $service->name : null;
                                                }
                                                $subServiceCategories = $categoryBox->subCategories->filter(function($sub) use ($serviceName) {
                                                    return $sub->name !== $serviceName;
                                                });
                                            @endphp
                                            @if($subServiceCategories->count() > 0)
                                                @foreach($subServiceCategories as $index => $subcategory)
                                                <div class="subcategory-item border p-3 mb-3 rounded">
                                                    <div class="row">
                                                        <div class="col-md-5">
                                                            <label class="form-label">Subcategory Name</label>
                                                            <input type="text" class="form-control" 
                                                                   value="{{ $subcategory->name }}" 
                                                                   disabled>
                                                            <input type="hidden" name="existing_subcategories[{{ $index }}][id]" value="{{ $subcategory->id }}">
                                                        </div>
                                                        <div class="col-md-5">
                                                            <label class="form-label">Update Image</label>
                                                            <input type="file" class="form-control existing-image-input" 
                                                                   name="existing_subcategories[{{ $index }}][image]" 
                                                                   accept="image/*"
                                                                   onchange="previewExistingImage(this, {{ $index }})">
                                                            @if($subcategory->image)
                                                                <div class="mt-2 existing-image-preview-{{ $index }}">
                                                                    <small class="text-muted">Current Image:</small>
                                                                    <img src="{{ asset('storage/' . $subcategory->image) }}" 
                                                                         alt="Current Image" 
                                                                         class="current-image-{{ $index }}"
                                                                         style="max-width: 150px; max-height: 150px; border-radius: 8px; border: 1px solid #ddd; margin-left: 10px;">
                                                                </div>
                                                            @endif
                                                        </div>
                                                        <div class="col-md-2 d-flex align-items-end">
                                                            <button type="button" class="btn btn-sm btn-danger delete-existing" data-id="{{ $subcategory->id }}">
                                                                <i class="ri-delete-bin-line"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                                @endforeach
                                            @else
                                                <div class="alert alert-info">No sub-service categories found. You can add new sub-services using the "Add Sub-Service" button above.</div>
                                            @endif
                                        @else
                                            <div class="alert alert-info">No subcategories found. Select a service above to add new ones.</div>
                                        @endif
                                    </div>
                                    <div id="new-subcategories-container"></div>
                                    <input type="hidden" id="deleted_subcategories" name="deleted_subcategories" value="">
                                </div>
                                
                            </div>
                            
                            <div class="row mt-4">
                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary">Update Category</button>
                                    <a href="{{ route('admin.categorybox.index') }}" class="btn btn-light ms-2">Cancel</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!--End::row-2 -->

    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    let subcategoryIndex = 0;
    let availableSubServices = [];
    let deletedIds = [];
    const servicesData = @json($services);
    
    // Handle service selection change for adding new items
    document.getElementById('main_service').addEventListener('change', function() {
        const serviceId = this.value;
        const addButton = document.getElementById('add-subcategory');
        const container = document.getElementById('new-subcategories-container');
        
        if (serviceId) {
            // Show loading message
            container.innerHTML = '<div class="alert alert-info">Loading sub-services...</div>';
            
            // Fetch sub-services for the selected service
            const url = `/admin/get-sub-services/${serviceId}`;
            
            fetch(url, {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                },
                credentials: 'same-origin'
            })
                .then(response => {
                    if (!response.ok) {
                        throw new Error(`HTTP error! status: ${response.status}`);
                    }
                    return response.json();
                })
                .then(data => {
                    availableSubServices = data.subServices || [];
                    container.innerHTML = ''; // Clear container
                    subcategoryIndex = 0; // Reset index
                    
                    if (availableSubServices.length > 0) {
                        addButton.disabled = false;
                        addButton.style.display = 'inline-block';
                        addButton.innerHTML = '<i class="ri-add-line"></i> Add Sub-Service';
                    } else {
                        addButton.style.display = 'none';
                        container.innerHTML = `
                            <div class="alert alert-success">
                                <i class="ri-check-line me-2"></i>
                                <strong>Note:</strong> This service doesn't have sub-services. You can upload a main service image using the "Main Service Image" field above.
                            </div>
                        `;
                    }
                })
                .catch(error => {
                    console.error('Error loading sub-services:', error);
                    container.innerHTML = '<div class="alert alert-danger">Error loading sub-services. Please try again.</div>';
                    addButton.disabled = true;
                });
        } else {
            container.innerHTML = '';
            addButton.disabled = true;
            availableSubServices = [];
        }
    });
    
    // Add new subcategory row
    document.getElementById('add-subcategory').addEventListener('click', function() {
        const container = document.getElementById('new-subcategories-container');
        const newSubcategory = document.createElement('div');
        newSubcategory.className = 'subcategory-item border p-3 mb-3 rounded bg-light';
        
        if (availableSubServices.length > 0) {
            // Service has sub-services
            let subServicesOptions = '<option value="">Select Sub-Service</option>';
            availableSubServices.forEach(subService => {
                subServicesOptions += `<option value="${subService.id}">${subService.name}</option>`;
            });
            
            newSubcategory.innerHTML = `
                <div class="row">
                    <div class="col-md-5">
                        <label class="form-label">Select Sub-Service <span class="text-danger">*</span></label>
                        <select class="form-control" name="new_subcategories[${subcategoryIndex}][sub_service_id]" required>
                            ${subServicesOptions}
                        </select>
                    </div>
                    <div class="col-md-5">
                        <label class="form-label">Sub-Service Image</label>
                        <input type="file" class="form-control sub-service-image-input" name="new_subcategories[${subcategoryIndex}][image]" accept="image/*" onchange="previewSubServiceImage(this, ${subcategoryIndex})">
                        <div class="sub-image-preview-${subcategoryIndex} mt-2" style="display: none;">
                            <img class="sub-image-preview-img" src="" alt="Preview" style="max-width: 150px; max-height: 150px; border-radius: 8px; border: 1px solid #ddd;">
                        </div>
                    </div>
                    <div class="col-md-2 d-flex align-items-end">
                        <button type="button" class="btn btn-sm btn-danger remove-new">
                            <i class="ri-delete-bin-line"></i>
                        </button>
                    </div>
                </div>
            `;
        } else {
            // Service has no sub-services
            newSubcategory.innerHTML = `
                <div class="row">
                    <div class="col-md-10">
                        <label class="form-label">Service Image</label>
                        <input type="file" class="form-control" name="new_service_image" accept="image/*" required>
                        <small class="text-muted">This service doesn't have sub-services.</small>
                    </div>
                    <div class="col-md-2 d-flex align-items-end">
                        <button type="button" class="btn btn-sm btn-danger remove-new">
                            <i class="ri-delete-bin-line"></i>
                        </button>
                    </div>
                </div>
            `;
        }
        
        container.appendChild(newSubcategory);
        subcategoryIndex++;
    });
    
    // Remove new subcategory
    document.addEventListener('click', function(e) {
        if (e.target.closest('.remove-new')) {
            e.target.closest('.subcategory-item').remove();
        }
        
            // Mark existing subcategory for deletion
        if (e.target.closest('.delete-existing')) {
            const id = e.target.closest('.delete-existing').getAttribute('data-id');
            deletedIds.push(id);
            document.getElementById('deleted_subcategories').value = deletedIds.join(',');
            e.target.closest('.subcategory-item').remove();
        }
    });
    
    // Preview main service image
    window.previewMainImage = function(input) {
        const preview = document.getElementById('main-image-preview');
        const previewImg = document.getElementById('main-image-preview-img');
        
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                previewImg.src = e.target.result;
                preview.style.display = 'block';
            };
            reader.readAsDataURL(input.files[0]);
        }
    };
    
    // Remove main image preview
    window.removeMainImagePreview = function() {
        const preview = document.getElementById('main-image-preview');
        const input = document.getElementById('new_service_image');
        preview.style.display = 'none';
        const previewImg = document.getElementById('main-image-preview-img');
        previewImg.src = '';
        if (input) {
            input.value = '';
        }
    };
    
    // Preview existing sub-service image
    window.previewExistingImage = function(input, index) {
        const previewContainer = document.querySelector(`.existing-image-preview-${index}`);
        const currentImg = previewContainer.querySelector(`.current-image-${index}`);
        
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                // Hide current image and show preview
                if (currentImg) {
                    currentImg.style.display = 'none';
                }
                // Create or update preview image
                let previewImg = previewContainer.querySelector('.new-preview-img');
                if (!previewImg) {
                    previewImg = document.createElement('img');
                    previewImg.className = 'new-preview-img';
                    previewImg.style.cssText = 'max-width: 150px; max-height: 150px; border-radius: 8px; border: 1px solid #ddd; margin-left: 10px;';
                    previewContainer.appendChild(previewImg);
                }
                previewImg.src = e.target.result;
                previewImg.alt = 'New Preview';
            };
            reader.readAsDataURL(input.files[0]);
        }
    };
    
    // Preview new sub-service image
    window.previewSubServiceImage = function(input, index) {
        const preview = document.querySelector(`.sub-image-preview-${index}`);
        const previewImg = preview.querySelector('.sub-image-preview-img');
        
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                previewImg.src = e.target.result;
                preview.style.display = 'block';
            };
            reader.readAsDataURL(input.files[0]);
        }
    };
});
</script>
@endsection
