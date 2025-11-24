@extends('admin.layouts.layout')
@section('content')
<div class="main-content app-content">
    <div class="container-fluid">

            
        <!-- Page Header -->
        <div class="my-4 page-header-breadcrumb d-flex align-items-center justify-content-between flex-wrap gap-2">
            <div>
                <h1 class="page-title fw-medium fs-18 mb-2">Category Management</h1>
                <div class="">
                    <nav>
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="javascript:void(0);">Admin</a></li>
                            <li class="breadcrumb-item"><a href="javascript:void(0);">Category</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Category Management</li>
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
                            Category Management
                        </div>
                        <div class="d-flex">
                            <button class="btn btn-sm btn-primary btn-wave waves-light" data-bs-toggle="modal" data-bs-target="#create-category"><i class="ri-add-line fw-medium align-middle me-1"></i> Add Category</button>
                            <!-- Start::add category modal -->
                            <div class="modal fade" id="create-category" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-lg modal-dialog-centered">
                                    <form action="{{ route('admin.categorybox.store') }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h6 class="modal-title">Add Main Category with Subcategories</h6>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body px-4">
                                                <div class="row gy-3">
                                    
                                                    {{-- Main Category Name --}}
                                                    <div class="col-xl-6">
                                                        <label for="name" class="form-label">Main Tagline Name</label>
                                                        <input type="text" class="form-control" id="name" name="name" placeholder="Enter Main Category Name" required>
                                                    </div>
                                    
                                                    {{-- Main Category Icon --}}
                                                    <div class="col-xl-6">
                                                        <label for="icon_name" class="form-label">Icon Name</label>
                                                        <input type="text" class="form-control" id="icon_name" name="icon_name" placeholder="Enter Icon Name">
                                                    </div>
                                    
                                                    {{-- Status --}}
                                                    <div class="col-xl-12">
                                                        <label for="status" class="form-label">Status</label>
                                                        <select class="form-control" name="status" id="status" required>
                                                            <option value="1">Active</option>
                                                            <option value="0">Inactive</option>
                                                        </select>
                                                    </div>

                                                    {{-- Service Selection --}}
                                                    <div class="col-xl-12">
                                                        <label for="main_service" class="form-label">Select Main Service <span class="text-danger">*</span></label>
                                                        <select class="form-control" id="main_service" name="main_service_id" required>
                                                            <option value="">Select Service</option>
                                                            @foreach($services as $service)
                                                                <option value="{{ $service->id }}">{{ $service->name }}</option>
                                                            @endforeach
                                                        </select>
                                                        <small class="text-muted">Select the main service for this category</small>
                                                    </div>

                                                    {{-- Main Service Image --}}
                                                    <div class="col-xl-12">
                                                        <label for="service_image" class="form-label">Main Service Image</label>
                                                        <input type="file" class="form-control" id="service_image" name="service_image" accept="image/*" onchange="previewMainImage(this)">
                                                        <small class="text-muted d-block mt-1">Upload an image for the main service (optional). This will be used if no sub-services are added.</small>
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
                                                            <h6 class="mb-0">Sub-Services (Optional)</h6>
                                                            <button type="button" class="btn btn-sm btn-success" id="add-subcategory" disabled>
                                                                <i class="ri-add-line"></i> Add Sub-Service
                                                            </button>
                                                        </div>
                                                        <div class="alert alert-info">
                                                            <i class="ri-information-line me-2"></i>
                                                            <strong>Note:</strong> You can add:
                                                            <ul class="mb-0 mt-2">
                                                                <li>Main service with image only (no sub-services)</li>
                                                                <li>Sub-services with images (each sub-service can have its own image)</li>
                                                                <li>Both main service image and sub-services</li>
                                                            </ul>
                                                        </div>
                                                        <div id="subcategories-container">
                                                            <!-- Sub-services will be loaded here dynamically -->
                                                        </div>
                                                    </div>
                                    
                                                </div>
                                            </div>
                                    
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                                                <button type="submit" class="btn btn-primary">Add Category</button>
                                            </div>
                                        </div>
                                    </form>
                                                                      
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table text-nowrap">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Main Category</th>
                                        <th>Icon</th>
                                        <th>Subcategories</th>
                                        <th>Status</th>
                                        <th>Created At</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                
                                <tbody>
                                    @if(isset($categoryBoxes) && $categoryBoxes->count() > 0)
                                        @foreach ($categoryBoxes as $key => $categoryBox)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>{{ $categoryBox->name }}</td>
                                                <td>
                                                    @if($categoryBox->icon_name)
                                                        <i class="{{ $categoryBox->icon_name }}"></i> {{ $categoryBox->icon_name }}
                                                    @else
                                                        N/A
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($categoryBox->subCategories->count() > 0)
                                                        <span class="badge bg-info">{{ $categoryBox->subCategories->count() }} subcategories</span>
                                                    @else
                                                        <span class="badge bg-secondary">No subcategories</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($categoryBox->status)
                                                        <span class="badge bg-success">Active</span>
                                                    @else
                                                        <span class="badge bg-danger">Inactive</span>
                                                    @endif
                                                </td>
                                                <td>{{ $categoryBox->created_at->format('d-m-Y') }}</td>
                                                <td>
                                                    <a href="{{ route('admin.categorybox.edit', $categoryBox->id) }}" class="btn btn-sm btn-primary">Edit</a>
                                                    <form action="{{ route('admin.categorybox.destroy', $categoryBox->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Are you sure?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="7" class="text-center">No categories found</td>
                                        </tr>
                                    @endif
                                </tbody>
                                
                                
                            </table>
                        </div>
                    </div>
                    <div class="card-footer border-top-0">
                        <nav aria-label="Page navigation">
                            <ul class="pagination mb-0 float-end">
                                <li class="page-item disabled">
                                    <a class="page-link">Previous</a>
                                </li>
                                <li class="page-item"><a class="page-link" href="javascript:void(0);">1</a></li>
                                <li class="page-item active" aria-current="page">
                                    <a class="page-link" href="javascript:void(0);">2</a>
                                </li>
                                <li class="page-item"><a class="page-link" href="javascript:void(0);">3</a></li>
                                <li class="page-item">
                                    <a class="page-link" href="javascript:void(0);">Next</a>
                                </li>
                            </ul>
                        </nav>
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
    
    // Handle main service selection
    document.getElementById('main_service').addEventListener('change', function() {
        const serviceId = this.value;
        const addButton = document.getElementById('add-subcategory');
        const container = document.getElementById('subcategories-container');
        
        if (serviceId) {
            // Show loading message
            container.innerHTML = '<div class="alert alert-info">Loading sub-services...</div>';
            
            // Fetch sub-services for the selected service
            const url = `/admin/get-sub-services/${serviceId}`;
            console.log('Fetching from URL:', url);
            
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
                    console.log('Response status:', response.status);
                    if (!response.ok) {
                        return response.text().then(text => {
                            console.error('Response text:', text);
                            throw new Error(`HTTP error! status: ${response.status}`);
                        });
                    }
                    return response.json();
                })
                .then(data => {
                    console.log('Sub-services loaded:', data);
                    availableSubServices = data.subServices || [];
                    container.innerHTML = ''; // Clear container
                    subcategoryIndex = 0; // Reset index
                    
                    if (availableSubServices.length > 0) {
                        // Service has sub-services
                        addButton.disabled = false;
                        addButton.innerHTML = '<i class="ri-add-line"></i> Add Sub-Service';
                        addButton.style.display = 'inline-block';
                        
                        // Add first sub-service automatically
                        addSubServiceRow();
                    } else {
                        // Service has no sub-services - hide add button and show info
                        addButton.style.display = 'none';
                        container.innerHTML = `
                            <div class="alert alert-success">
                                <i class="ri-check-line me-2"></i>
                                <strong>Great!</strong> This service doesn't have sub-services. You can upload an image using the "Category Image" field above, or leave it empty to create a text-only category.
                            </div>
                        `;
                    }
                })
                .catch(error => {
                    console.error('Error loading sub-services:', error);
                    container.innerHTML = '<div class="alert alert-danger">Error loading sub-services: ' + error.message + '. Please check the console for more details.</div>';
                    addButton.disabled = true;
                });
        } else {
            container.innerHTML = '';
            addButton.disabled = true;
            availableSubServices = [];
        }
    });
    
    // Function to add sub-service row
    function addSubServiceRow() {
        const container = document.getElementById('subcategories-container');
        const newSubcategory = document.createElement('div');
        newSubcategory.className = 'subcategory-item border p-3 mb-3 rounded';
        
        let subServicesOptions = '<option value="">Select Sub-Service</option>';
        availableSubServices.forEach(subService => {
            subServicesOptions += `<option value="${subService.id}">${subService.name}</option>`;
        });
        
        newSubcategory.innerHTML = `
            <div class="row">
                <div class="col-md-5">
                    <label class="form-label">Select Sub-Service <span class="text-danger">*</span></label>
                    <select class="form-control sub-service-select" name="subcategories[${subcategoryIndex}][sub_service_id]" required>
                        ${subServicesOptions}
                    </select>
                </div>
                <div class="col-md-5">
                    <label class="form-label">Sub-Service Image</label>
                    <input type="file" class="form-control sub-service-image-input" name="subcategories[${subcategoryIndex}][image]" accept="image/*" onchange="previewSubServiceImage(this, ${subcategoryIndex})">
                    <div class="sub-image-preview-${subcategoryIndex} mt-2" style="display: none;">
                        <img class="sub-image-preview-img" src="" alt="Preview" style="max-width: 150px; max-height: 150px; border-radius: 8px; border: 1px solid #ddd;">
                    </div>
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <button type="button" class="btn btn-sm btn-danger remove-subcategory">
                        <i class="ri-delete-bin-line"></i>
                    </button>
                </div>
            </div>
        `;
        container.appendChild(newSubcategory);
        subcategoryIndex++;
    }
    
    // Add subcategory button click
    document.getElementById('add-subcategory').addEventListener('click', function() {
        addSubServiceRow();
    });
    
    // Remove subcategory functionality
    document.addEventListener('click', function(e) {
        if (e.target.closest('.remove-subcategory')) {
            const container = document.getElementById('subcategories-container');
            e.target.closest('.subcategory-item').remove();
            
            // If no sub-services left, show info message
            if (container.children.length === 0 && availableSubServices.length > 0) {
                container.innerHTML = `
                    <div class="alert alert-info">
                        <i class="ri-information-line me-2"></i>
                        <strong>No sub-services selected.</strong> You can add sub-services using the "Add Sub-Service" button, or upload a main service image using the "Category Image" field above.
                    </div>
                `;
            }
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
        const input = document.getElementById('service_image');
        preview.style.display = 'none';
        previewImg.src = '';
        if (input) {
            input.value = '';
        }
    };
    
    // Preview sub-service image
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
    
    // Form validation before submit
    document.querySelector('form[action="{{ route('admin.categorybox.store') }}"]').addEventListener('submit', function(e) {
        const mainService = document.getElementById('main_service').value;
        const mainImage = document.getElementById('service_image').files.length;
        const subCategories = document.querySelectorAll('.subcategory-item').length;
        
        if (!mainService) {
            e.preventDefault();
            alert('Please select a main service.');
            return false;
        }
        
        // Check if at least one sub-service is selected when subcategories exist
        if (subCategories > 0) {
            let hasValidSubService = false;
            document.querySelectorAll('.sub-service-select').forEach(select => {
                if (select.value) {
                    hasValidSubService = true;
                }
            });
            
            if (!hasValidSubService) {
                e.preventDefault();
                alert('Please select at least one sub-service or remove all sub-service rows.');
                return false;
            }
        }
        
        // If no sub-services and no main image, show warning but allow (controller will create basic entry)
        if (subCategories === 0 && mainImage === 0) {
            if (!confirm('No image or sub-services selected. A basic category entry will be created. Continue?')) {
                e.preventDefault();
                return false;
            }
        }
    });
});
</script>
@endsection