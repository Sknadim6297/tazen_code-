@extends('admin.layouts.layout')
@section('content')
<div class="main-content app-content">
    <div class="container-fluid">

        <!-- Page Header -->
        <div class="my-4 page-header-breadcrumb d-flex align-items-center flex-wrap gap-2">
            <div>
                <h1 class="page-title fw-medium fs-18 mb-2">Sub-Services Management</h1>
                <div class="">
                    <nav>
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="javascript:void(0);">Services</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Sub-Services</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <!-- Page Header Close -->

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Filters -->
        <div class="row mb-4">
            <div class="col-xl-12">
                <div class="card custom-card">
                    <div class="card-header">
                        <div class="card-title">Filter Sub-Services</div>
                    </div>
                    <div class="card-body">
                        <form method="GET" action="{{ route('admin.sub-service.index') }}">
                            <div class="row g-3">
                                <div class="col-md-3">
                                    <label for="service_id" class="form-label">Service</label>
                                    <select class="form-select" name="service_id" id="service_id">
                                        <option value="">All Services</option>
                                        @foreach($services as $service)
                                            <option value="{{ $service->id }}" {{ request('service_id') == $service->id ? 'selected' : '' }}>
                                                {{ $service->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label for="status" class="form-label">Status</label>
                                    <select class="form-select" name="status" id="status">
                                        <option value="">All Status</option>
                                        <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                                        <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label for="search" class="form-label">Search</label>
                                    <input type="text" class="form-control" name="search" id="search" 
                                           placeholder="Search by name..." value="{{ request('search') }}">
                                </div>
                                <div class="col-md-2 d-flex align-items-end">
                                    <button type="submit" class="btn btn-primary me-2">Filter</button>
                                    <a href="{{ route('admin.sub-service.index') }}" class="btn btn-secondary">Clear</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Start::row-2 -->
        <div class="row">
            <div class="col-xxl-12 col-xl-12">
                <div class="card custom-card">
                    <div class="card-header justify-content-between">
                        <div class="card-title">
                            Sub-Services List ({{ $subServices->total() }} total)
                        </div>
                        <div class="d-flex">
                            <button class="btn btn-sm btn-primary btn-wave waves-light" data-bs-toggle="modal" data-bs-target="#create-sub-service">
                                <i class="ri-add-line fw-medium align-middle me-1"></i> Create Sub-Service
                            </button>
                            
                            <!-- Start::add sub-service modal -->
                            <div class="modal fade" id="create-sub-service" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered modal-lg">
                                    <form action="{{ route('admin.sub-service.store') }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h6 class="modal-title">Add Sub-Service</h6>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body px-4">
                                                <div class="row gy-3">
                                                    <!-- Service Selection -->
                                                    <div class="col-xl-12">
                                                        <label for="service_id" class="form-label">Parent Service <span class="text-danger">*</span></label>
                                                        <select class="form-select" name="service_id" id="service_id" required>
                                                            <option value="">Select Service</option>
                                                            @foreach($services as $service)
                                                                <option value="{{ $service->id }}">{{ $service->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    
                                                    <!-- Sub-Service Name -->
                                                    <div class="col-xl-12">
                                                        <label for="sub-service-name" class="form-label">Sub-Service Name <span class="text-danger">*</span></label>
                                                        <input type="text" class="form-control" name="name" id="sub-service-name" 
                                                               placeholder="Enter sub-service name" required>
                                                    </div>
                                                    
                                                    <!-- Description -->
                                                    <div class="col-xl-12">
                                                        <label for="description" class="form-label">Description</label>
                                                        <textarea class="form-control" name="description" id="description" rows="3" 
                                                                  placeholder="Enter description"></textarea>
                                                    </div>
                                                    
                                                    <!-- Price removed -->
                                                    
                                                    <!-- Status -->
                                                    <div class="col-xl-6">
                                                        <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                                                        <select class="form-select" name="status" id="status" required>
                                                            <option value="active">Active</option>
                                                            <option value="inactive">Inactive</option>
                                                        </select>
                                                    </div>
                                                    
                                                    <!-- Image -->
                                                    <div class="col-xl-12">
                                                        <label for="image" class="form-label">Image</label>
                                                        <input type="file" class="form-control" name="image" id="image" accept="image/*">
                                                        <small class="text-muted">Supported formats: JPG, JPEG, PNG, WebP (Max: 2MB)</small>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                <button type="submit" class="btn btn-primary">Create Sub-Service</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <!-- End::add sub-service modal -->
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table text-nowrap">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Service</th>
                                        <th>Name</th>
                                        <th>Image</th>
                                        <th>Status</th>
                                        <th>Created Date</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($subServices as $subService)
                                        <tr>
                                            <td>{{ $subService->id }}</td>
                                            <td>
                                                <span class="badge bg-primary-transparent">{{ $subService->service->name }}</span>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div>
                                                        <span class="fw-medium">{{ $subService->name }}</span>
                                                        @if($subService->description)
                                                            <small class="text-muted d-block">{{ Str::limit($subService->description, 50) }}</small>
                                                        @endif
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                @if($subService->image)
                                                    <img src="{{ asset('storage/' . $subService->image) }}" 
                                                         width="50" height="50" alt="Sub-Service Image" 
                                                         class="rounded" style="object-fit: cover;">
                                                @else
                                                    <span class="text-muted">No Image</span>
                                                @endif
                                            </td>
                                            <td>
                                                <span class="badge 
                                                    @if($subService->status == 1) 
                                                        bg-success-transparent text-success
                                                    @else 
                                                        bg-secondary-transparent text-secondary
                                                    @endif
                                                ">
                                                    {{ ucfirst($subService->status_text) }}
                                                </span>
                                            </td>
                                            <td>
                                                <span class="text-muted">{{ $subService->created_at->format('M d, Y') }}</span>
                                            </td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <button type="button" class="btn btn-info-light btn-icon btn-sm" 
                                                            data-bs-toggle="modal" data-bs-target="#view-sub-service-{{ $subService->id }}"
                                                            data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="View">
                                                        <i class="ri-eye-line"></i>
                                                    </button>
                                                    <button type="button" class="btn btn-primary-light btn-icon btn-sm" 
                                                            data-bs-toggle="modal" data-bs-target="#edit-sub-service-{{ $subService->id }}"
                                                            data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Edit">
                                                        <i class="ri-edit-line"></i>
                                                    </button>
                                                    <form action="{{ route('admin.sub-service.destroy', $subService->id) }}" method="POST" 
                                                          style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this sub-service?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger-light btn-icon btn-sm" 
                                                                data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Delete">
                                                            <i class="ri-delete-bin-5-line"></i>
                                                        </button>
                                                    </form>
                                                </div>

                                                <!-- View Modal -->
                                                <div class="modal fade" id="view-sub-service-{{ $subService->id }}" tabindex="-1" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h6 class="modal-title">Sub-Service Details</h6>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="row g-3">
                                                                    <div class="col-12">
                                                                        <strong>Service:</strong>
                                                                        <p class="mb-0">{{ $subService->service->name }}</p>
                                                                    </div>
                                                                    <div class="col-12">
                                                                        <strong>Name:</strong>
                                                                        <p class="mb-0">{{ $subService->name }}</p>
                                                                    </div>
                                                                    @if($subService->description)
                                                                    <div class="col-12">
                                                                        <strong>Description:</strong>
                                                                        <p class="mb-0">{{ $subService->description }}</p>
                                                                    </div>
                                                                    @endif
                                                                    @if(!is_null($subService->price))
                                                                    <div class="col-12">
                                                                        <strong>Price:</strong>
                                                                        <p class="mb-0">${{ number_format($subService->price, 2) }}</p>
                                                                    </div>
                                                                    @endif
                                                                    <div class="col-12">
                                                                        <strong>Status:</strong>
                                                                        <p class="mb-0">
                                                                            <span class="badge 
                                                                                @if($subService->status == 1) 
                                                                                    bg-success-transparent text-success
                                                                                @else 
                                                                                    bg-secondary-transparent text-secondary
                                                                                @endif
                                                                            ">
                                                                                {{ ucfirst($subService->status_text) }}
                                                                            </span>
                                                                        </p>
                                                                    </div>
                                                                    @if($subService->image)
                                                                    <div class="col-12">
                                                                        <strong>Image:</strong>
                                                                        <div class="mt-2">
                                                                            <img src="{{ asset('storage/' . $subService->image) }}" 
                                                                                 alt="Sub-Service Image" class="img-fluid rounded" style="max-height: 200px;">
                                                                        </div>
                                                                    </div>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Edit Modal -->
                                                <div class="modal fade" id="edit-sub-service-{{ $subService->id }}" tabindex="-1" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered modal-lg">
                                                        <form action="{{ route('admin.sub-service.update', $subService->id) }}" method="POST" enctype="multipart/form-data">
                                                            @csrf
                                                            @method('PUT')
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h6 class="modal-title">Edit Sub-Service</h6>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body px-4">
                                                                    <div class="row gy-3">
                                                                        <!-- Service Selection -->
                                                                        <div class="col-xl-12">
                                                                            <label for="edit_service_id_{{ $subService->id }}" class="form-label">Parent Service <span class="text-danger">*</span></label>
                                                                            <select class="form-select" name="service_id" id="edit_service_id_{{ $subService->id }}" required>
                                                                                @foreach($services as $service)
                                                                                    <option value="{{ $service->id }}" {{ $subService->service_id == $service->id ? 'selected' : '' }}>
                                                                                        {{ $service->name }}
                                                                                    </option>
                                                                                @endforeach
                                                                            </select>
                                                                        </div>
                                                                        
                                                                        <!-- Sub-Service Name -->
                                                                        <div class="col-xl-12">
                                                                            <label for="edit_name_{{ $subService->id }}" class="form-label">Sub-Service Name <span class="text-danger">*</span></label>
                                                                            <input type="text" class="form-control" name="name" id="edit_name_{{ $subService->id }}" 
                                                                                   value="{{ $subService->name }}" required>
                                                                        </div>
                                                                        
                                                                        <!-- Description -->
                                                                        <div class="col-xl-12">
                                                                            <label for="edit_description_{{ $subService->id }}" class="form-label">Description</label>
                                                                            <textarea class="form-control" name="description" id="edit_description_{{ $subService->id }}" rows="3">{{ $subService->description }}</textarea>
                                                                        </div>
                                                                        
                                                                        <!-- Price removed -->
                                                                        
                                                                        <!-- Status -->
                                                                        <div class="col-xl-6">
                                                                            <label for="edit_status_{{ $subService->id }}" class="form-label">Status <span class="text-danger">*</span></label>
                                                                            <select class="form-select" name="status" id="edit_status_{{ $subService->id }}" required>
                                                                                <option value="active" {{ $subService->status == 1 ? 'selected' : '' }}>Active</option>
                                                                                <option value="inactive" {{ $subService->status == 0 ? 'selected' : '' }}>Inactive</option>
                                                                            </select>
                                                                        </div>
                                                                        
                                                                        <!-- Current Image -->
                                                                        @if($subService->image)
                                                                        <div class="col-xl-12">
                                                                            <label class="form-label">Current Image</label>
                                                                            <div>
                                                                                <img src="{{ asset('storage/' . $subService->image) }}" 
                                                                                     alt="Current Image" class="img-fluid rounded" style="max-height: 100px;">
                                                                            </div>
                                                                        </div>
                                                                        @endif
                                                                        
                                                                        <!-- New Image -->
                                                                        <div class="col-xl-12">
                                                                            <label for="edit_image_{{ $subService->id }}" class="form-label">
                                                                                @if($subService->image) Update Image @else Add Image @endif
                                                                            </label>
                                                                            <input type="file" class="form-control" name="image" id="edit_image_{{ $subService->id }}" accept="image/*">
                                                                            <small class="text-muted">Supported formats: JPG, JPEG, PNG, WebP (Max: 2MB)</small>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                                    <button type="submit" class="btn btn-primary">Update Sub-Service</button>
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="8" class="text-center py-4">
                                                <div class="d-flex flex-column align-items-center">
                                                    <i class="ri-file-list-3-line fs-1 text-muted mb-2"></i>
                                                    <h6 class="text-muted">No Sub-Services Found</h6>
                                                    <p class="text-muted mb-0">Create your first sub-service to get started.</p>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                    
                    @if($subServices->hasPages())
                    <div class="card-footer border-top-0">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="text-muted">
                                Showing {{ $subServices->firstItem() }} to {{ $subServices->lastItem() }} of {{ $subServices->total() }} results
                            </div>
                            {{ $subServices->appends(request()->query())->links() }}
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
        <!--End::row-2 -->

    </div>
</div>

@section('scripts')
<script>
    // Initialize tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    })
</script>
@endsection

@endsection
