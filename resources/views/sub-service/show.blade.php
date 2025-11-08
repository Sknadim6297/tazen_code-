@extends('admin.layouts.layout')
@section('content')
<div class="main-content app-content">
    <div class="container-fluid">

        <!-- Page Header -->
        <div class="my-4 page-header-breadcrumb d-flex align-items-center flex-wrap gap-2">
            <div>
                <h1 class="page-title fw-medium fs-18 mb-2">Sub-Service Details</h1>
                <div class="">
                    <nav>
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="{{ route('admin.sub-service.index') }}">Sub-Services</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ $subService->name }}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <!-- Page Header Close -->

        <!-- Start::row -->
        <div class="row">
            <div class="col-xl-8">
                <div class="card custom-card">
                    <div class="card-header justify-content-between">
                        <div class="card-title">
                            Sub-Service Information
                        </div>
                        <div class="d-flex">
                            <a href="{{ route('admin.sub-service.edit', $subService->id) }}" class="btn btn-sm btn-primary btn-wave waves-light me-2">
                                <i class="ri-edit-line fw-medium align-middle me-1"></i> Edit
                            </a>
                            <a href="{{ route('admin.sub-service.index') }}" class="btn btn-sm btn-light btn-wave waves-light">
                                <i class="ri-arrow-left-line fw-medium align-middle me-1"></i> Back to List
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row gy-4">
                            <div class="col-xl-6">
                                <div class="mb-3">
                                    <label class="form-label fw-semibold text-muted">Parent Service</label>
                                    <div class="mt-1">
                                        <span class="badge bg-primary-transparent fs-12">{{ $subService->service->name }}</span>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-xl-6">
                                <div class="mb-3">
                                    <label class="form-label fw-semibold text-muted">Sub-Service Name</label>
                                    <div class="mt-1">
                                        <h6 class="mb-0">{{ $subService->name }}</h6>
                                    </div>
                                </div>
                            </div>
                            
                            @if($subService->description)
                            <div class="col-xl-12">
                                <div class="mb-3">
                                    <label class="form-label fw-semibold text-muted">Description</label>
                                    <div class="mt-1">
                                        <p class="text-muted mb-0">{{ $subService->description }}</p>
                                    </div>
                                </div>
                            </div>
                            @endif
                            
                            <div class="col-xl-6">
                                <div class="mb-3">
                                    <label class="form-label fw-semibold text-muted">Price</label>
                                    <div class="mt-1">
                                        @if(!is_null($subService->price))
                                            <h5 class="text-success mb-0">${{ number_format($subService->price, 2) }}</h5>
                                        @else
                                            <span class="text-muted">Not specified</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-xl-6">
                                <div class="mb-3">
                                    <label class="form-label fw-semibold text-muted">Status</label>
                                    <div class="mt-1">
                                        <span class="badge 
                                            @if($subService->status == 'active') 
                                                bg-success-transparent text-success
                                            @else 
                                                bg-secondary-transparent text-secondary
                                            @endif
                                        ">
                                            {{ ucfirst($subService->status) }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-xl-6">
                                <div class="mb-3">
                                    <label class="form-label fw-semibold text-muted">Created Date</label>
                                    <div class="mt-1">
                                        <span class="text-muted">{{ $subService->created_at->format('F d, Y h:i A') }}</span>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-xl-6">
                                <div class="mb-3">
                                    <label class="form-label fw-semibold text-muted">Last Updated</label>
                                    <div class="mt-1">
                                        <span class="text-muted">{{ $subService->updated_at->format('F d, Y h:i A') }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            @if($subService->image)
            <div class="col-xl-4">
                <div class="card custom-card">
                    <div class="card-header">
                        <div class="card-title">
                            Sub-Service Image
                        </div>
                    </div>
                    <div class="card-body text-center">
                        <img src="{{ asset('storage/' . $subService->image) }}" 
                             alt="{{ $subService->name }}" 
                             class="img-fluid rounded border"
                             style="max-height: 300px; width: 100%; object-fit: cover;">
                    </div>
                </div>
            </div>
            @endif
            
            <!-- Actions Card -->
            <div class="col-xl-12">
                <div class="card custom-card">
                    <div class="card-header">
                        <div class="card-title">
                            Quick Actions
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="d-flex flex-wrap gap-2">
                            <a href="{{ route('admin.sub-service.edit', $subService->id) }}" class="btn btn-primary">
                                <i class="ri-edit-line me-1"></i> Edit Sub-Service
                            </a>
                            
                            @if($subService->status == 'active')
                                <form action="{{ route('admin.sub-service.update', $subService->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="service_id" value="{{ $subService->service_id }}">
                                    <input type="hidden" name="name" value="{{ $subService->name }}">
                                    <input type="hidden" name="description" value="{{ $subService->description }}">
                                    <!-- price removed -->
                                    <input type="hidden" name="status" value="inactive">
                                    <button type="submit" class="btn btn-warning" 
                                            onclick="return confirm('Are you sure you want to deactivate this sub-service?')">
                                        <i class="ri-pause-circle-line me-1"></i> Deactivate
                                    </button>
                                </form>
                            @else
                                <form action="{{ route('admin.sub-service.update', $subService->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="service_id" value="{{ $subService->service_id }}">
                                    <input type="hidden" name="name" value="{{ $subService->name }}">
                                    <input type="hidden" name="description" value="{{ $subService->description }}">
                                    <!-- price removed -->
                                    <input type="hidden" name="status" value="active">
                                    <button type="submit" class="btn btn-success">
                                        <i class="ri-play-circle-line me-1"></i> Activate
                                    </button>
                                </form>
                            @endif
                            
                            <form action="{{ route('admin.sub-service.destroy', $subService->id) }}" method="POST" 
                                  style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this sub-service? This action cannot be undone.');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">
                                    <i class="ri-delete-bin-line me-1"></i> Delete
                                </button>
                            </form>
                            
                            <a href="{{ route('admin.sub-service.index') }}" class="btn btn-light">
                                <i class="ri-arrow-left-line me-1"></i> Back to List
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--End::row -->

    </div>
</div>
@endsection
