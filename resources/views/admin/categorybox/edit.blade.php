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
                                    <label for="main_service" class="form-label">Select Main Service</label>
                                    <select class="form-control" id="main_service" name="main_service_id" required>
                                        <option value="">Select Service</option>
                                        @foreach($services as $service)
                                            <option value="{{ $service->id }}">{{ $service->name }}</option>
                                        @endforeach
                                    </select>
                                    <small class="text-muted">Note: Changing the service will reset sub-services</small>
                                </div>

                                {{-- Subcategories Section --}}
                                <div class="col-xl-12">
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <h6 class="mb-0">Current Subcategories / Images</h6>
                                        <button type="button" class="btn btn-sm btn-success" id="add-subcategory">
                                            <i class="ri-add-line"></i> Add More
                                        </button>
                                    </div>
                                    <div id="subcategories-container">
                                        @if($categoryBox->subCategories->count() > 0)
                                            @foreach($categoryBox->subCategories as $index => $subcategory)
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
                                                            <input type="file" class="form-control" 
                                                                   name="existing_subcategories[{{ $index }}][image]" 
                                                                   accept="image/*">
                                                            @if($subcategory->image)
                                                                <div class="mt-2">
                                                                    <small class="text-muted">Current Image:</small>
                                                                    <img src="{{ asset('storage/' . $subcategory->image) }}" 
                                                                         alt="Current Image" width="50" height="50" class="ms-2">
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
        
        if (serviceId) {
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
                .then(response => response.json())
                .then(data => {
                    availableSubServices = data.subServices || [];
                    
                    if (availableSubServices.length > 0) {
                        addButton.disabled = false;
                        addButton.style.display = 'inline-block';
                    } else {
                        addButton.style.display = 'inline-block';
                        addButton.disabled = false;
                    }
                })
                .catch(error => {
                    console.error('Error loading sub-services:', error);
                });
        } else {
            addButton.disabled = true;
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
                        <label class="form-label">Select Sub-Service</label>
                        <select class="form-control" name="new_subcategories[${subcategoryIndex}][sub_service_id]" required>
                            ${subServicesOptions}
                        </select>
                    </div>
                    <div class="col-md-5">
                        <label class="form-label">Sub-Service Image</label>
                        <input type="file" class="form-control" name="new_subcategories[${subcategoryIndex}][image]" accept="image/*">
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
});
</script>
@endsection
