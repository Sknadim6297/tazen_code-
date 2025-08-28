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

                    <!-- Slug -->
                    <div class="mb-3">
                        <label for="service-slug" class="form-label">Slug (URL friendly)</label>
                        <input type="text" class="form-control" name="slug" id="service-slug"
                               value="{{ old('slug', $service->slug) }}" placeholder="Auto-generated from name">
                        <small class="form-text text-muted">Leave empty to auto-generate from service name</small>
                    </div>

                    <!-- Meta Title -->
                    <div class="mb-3">
                        <label for="meta-title" class="form-label">Meta Title (SEO)</label>
                        <input type="text" class="form-control" name="meta_title" id="meta-title"
                               value="{{ old('meta_title', $service->meta_title) }}" placeholder="Enter meta title for SEO" maxlength="255">
                        <small class="form-text text-muted">Recommended: 50-60 characters</small>
                    </div>

                    <!-- Meta Description -->
                    <div class="mb-3">
                        <label for="meta-description" class="form-label">Meta Description (SEO)</label>
                        <textarea class="form-control" name="meta_description" id="meta-description" rows="3" 
                                  placeholder="Enter meta description for SEO" maxlength="500">{{ old('meta_description', $service->meta_description) }}</textarea>
                        <small class="form-text text-muted">Recommended: 150-160 characters</small>
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

<script>
// Auto-generate slug from service name
document.addEventListener('DOMContentLoaded', function() {
    const serviceNameInput = document.getElementById('service-name');
    const serviceSlugInput = document.getElementById('service-slug');
    
    if (serviceNameInput && serviceSlugInput) {
        serviceNameInput.addEventListener('input', function() {
            if (!serviceSlugInput.value || serviceSlugInput.dataset.userEdited !== 'true') {
                const slug = this.value
                    .toLowerCase()
                    .replace(/[^a-z0-9\s-]/g, '') // Remove special characters
                    .replace(/\s+/g, '-') // Replace spaces with hyphens
                    .replace(/-+/g, '-') // Replace multiple hyphens with single hyphen
                    .trim();
                serviceSlugInput.value = slug;
            }
        });
        
        // Mark slug as user-edited if manually changed
        serviceSlugInput.addEventListener('input', function() {
            this.dataset.userEdited = 'true';
        });
    }
});
</script>
@endsection