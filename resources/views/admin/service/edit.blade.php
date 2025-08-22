@extends('admin.layouts.layout')
@section('content')
<div class="main-content app-content">
    <div class="container mt-5">
        <h4>Edit Service</h4>
    
        <form action="{{ route('admin.service.update', $service->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
    
            <div class="card mt-4">
                <div class="card-body">
                    <!-- Service Name -->
                    <div class="mb-3">
                        <label for="service-name" class="form-label">Service Name</label>
                        <input type="text" class="form-control" name="name" id="service-name"
                               value="{{ old('name', $service->name) }}" required>
                    </div>
    
                    <!-- Existing Image -->
                    @if($service->image)
                        <div class="mb-3">
                            <label class="form-label">Current Image</label><br>
                            <img src="{{ asset('storage/' . $service->image) }}" width="100">
                        </div>
                    @endif
    
                    <!-- Upload New Image -->
                    <div class="mb-3">
                        <label for="service-image" class="form-label">Change Image</label>
                        <input type="file" class="form-control" name="image" id="service-image" accept="image/*">
                    </div>
    
                    <!-- Status -->
                    <div class="mb-3">
                        <label for="service-status" class="form-label">Status</label>
                        <select class="form-control" name="status" id="service-status" required>
                            <option value="active" {{ $service->status === 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ $service->status === 'inactive' ? 'selected' : '' }}>Inactive</option>
                        </select>
                    </div>
                </div>
    
                <div class="card-footer d-flex justify-content-between">
                    <a href="{{ route('admin.service.index') }}" class="btn btn-secondary">Back</a>
                    <button type="submit" class="btn btn-primary">Update Service</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection