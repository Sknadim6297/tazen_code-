@extends('admin.layouts.layout')
@section('content')
<div class="main-content app-content">
    <div class="container-fluid">

        <!-- Page Header -->
        <div class="my-4 page-header-breadcrumb d-flex align-items-center flex-wrap gap-2">
            <div>
                <h1 class="page-title fw-medium fs-18 mb-2">Edit Sub-Service</h1>
                <div class="">
                    <nav>
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="{{ route('admin.sub-service.index') }}">Sub-Services</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Edit</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <!-- Page Header Close -->

        <!-- Start::row -->
        <div class="row">
            <div class="col-xl-12">
                <div class="card custom-card">
                    <div class="card-header justify-content-between">
                        <div class="card-title">
                            Edit Sub-Service: {{ $subService->name }}
                        </div>
                        <div class="d-flex">
                            <a href="{{ route('admin.sub-service.index') }}" class="btn btn-sm btn-light btn-wave waves-light">
                                <i class="ri-arrow-left-line fw-medium align-middle me-1"></i> Back to List
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.sub-service.update', $subService->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="row gy-4">
                                <!-- Service Selection -->
                                <div class="col-xl-6">
                                    <label for="service_id" class="form-label">Parent Service <span class="text-danger">*</span></label>
                                    <select class="form-select @error('service_id') is-invalid @enderror" name="service_id" id="service_id" required>
                                        <option value="">Select Service</option>
                                        @foreach($services as $service)
                                            <option value="{{ $service->id }}" 
                                                {{ (old('service_id', $subService->service_id) == $service->id) ? 'selected' : '' }}>
                                                {{ $service->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('service_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <!-- Sub-Service Name -->
                                <div class="col-xl-6">
                                    <label for="name" class="form-label">Sub-Service Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                           name="name" id="name" placeholder="Enter sub-service name" 
                                           value="{{ old('name', $subService->name) }}" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <!-- Description -->
                                <div class="col-xl-12">
                                    <label for="description" class="form-label">Description</label>
                                    <textarea class="form-control @error('description') is-invalid @enderror" 
                                              name="description" id="description" rows="4" 
                                              placeholder="Enter description">{{ old('description', $subService->description) }}</textarea>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <!-- Price removed -->
                                
                                <!-- Status -->
                                <div class="col-xl-6">
                                    <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                                    <select class="form-select @error('status') is-invalid @enderror" name="status" id="status" required>
                                        <option value="active" {{ old('status', $subService->status) == 'active' ? 'selected' : '' }}>Active</option>
                                        <option value="inactive" {{ old('status', $subService->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                    </select>
                                    @error('status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <!-- Current Image -->
                                @if($subService->image)
                                <div class="col-xl-12">
                                    <label class="form-label">Current Image</label>
                                    <div class="mb-3">
                                        <img src="{{ asset('storage/' . $subService->image) }}" 
                                             alt="Current Image" class="img-fluid rounded border" style="max-height: 150px;">
                                    </div>
                                </div>
                                @endif
                                
                                <!-- New Image -->
                                <div class="col-xl-12">
                                    <label for="image" class="form-label">
                                        @if($subService->image) Update Image @else Add Image @endif
                                    </label>
                                    <input type="file" class="form-control @error('image') is-invalid @enderror" 
                                           name="image" id="image" accept="image/*">
                                    @error('image')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="text-muted">Supported formats: JPG, JPEG, PNG, WebP (Max: 2MB)</small>
                                </div>
                                
                                <!-- Image Preview -->
                                <div class="col-xl-12" id="image-preview" style="display: none;">
                                    <label class="form-label">New Image Preview</label>
                                    <div>
                                        <img id="preview-img" src="" alt="Image Preview" 
                                             class="img-fluid rounded border" style="max-height: 200px;">
                                    </div>
                                </div>
                            </div>
                            
                            <div class="mt-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="ri-save-line fw-medium align-middle me-1"></i> Update Sub-Service
                                </button>
                                <a href="{{ route('admin.sub-service.index') }}" class="btn btn-light ms-2">
                                    <i class="ri-close-line fw-medium align-middle me-1"></i> Cancel
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!--End::row -->

    </div>
</div>

@section('scripts')
<script>
    // Image preview functionality
    document.getElementById('image').addEventListener('change', function(e) {
        const file = e.target.files[0];
        const preview = document.getElementById('image-preview');
        const previewImg = document.getElementById('preview-img');
        
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                previewImg.src = e.target.result;
                preview.style.display = 'block';
            }
            reader.readAsDataURL(file);
        } else {
            preview.style.display = 'none';
        }
    });
</script>
@endsection

@endsection
