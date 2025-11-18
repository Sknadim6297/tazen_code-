@extends('admin.layouts.layout')

@section('content')
<div class="main-content app-content">
   
    <div class="container mt-4">
        <h4>Edit Blog</h4>
    
        @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <form action="{{ route('admin.blogs.update', $blog->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        
        <div class="mb-3">
            <label for="blog-title" class="form-label">Blog Title</label>
            <input type="text" class="form-control" name="title" id="blog-title" value="{{ old('title', $blog->title) }}" required>
        </div>

        <div class="mb-3">
            <label for="meta-title" class="form-label">Meta Title (SEO)</label>
            <input type="text" class="form-control" name="meta_title" id="meta-title" value="{{ old('meta_title', $blog->meta_title) }}" maxlength="60" placeholder="Enter meta title for SEO">
            <small class="text-muted">Recommended: 50-60 characters</small>
        </div>

        <div class="mb-3">
            <label for="meta-description" class="form-label">Meta Description (SEO)</label>
            <textarea class="form-control" name="meta_description" id="meta-description" rows="3" maxlength="160" placeholder="Enter meta description for SEO">{{ old('meta_description', $blog->meta_description) }}</textarea>
            <small class="text-muted">Recommended: 150-160 characters</small>
        </div>

        <div class="mb-3">
            <label for="description_short" class="form-label">Short Description</label>
            <textarea class="form-control" name="description_short" id="description_short" required>{{ old('description_short', $blog->description_short) }}</textarea>
        </div>

        <div class="mb-3">
            <label for="blog-image" class="form-label">Blog Image</label>
            <input type="file" class="form-control" name="image" id="blog-image" accept="image/*">
            @if($blog->image)
                <div class="mt-2">
                    <img src="{{ asset('storage/' . $blog->image) }}" alt="Current Image" style="height: 100px; border-radius: 5px;">
                    <br>
                    <small class="text-muted">Current image: {{ basename($blog->image) }}</small>
                    <br>
                    <small class="text-info">Leave empty to keep current image, or select a new file to replace it.</small>
                </div>
            @else
                <small class="text-muted">No image currently set. Select an image file to add one.</small>
            @endif
        </div>

        <div class="mb-3">
            <label for="created_by" class="form-label">Created By</label>
            <input type="text" class="form-control" name="created_by" id="created_by" value="{{ old('created_by', $blog->created_by) }}" required>
        </div>

        <div class="mb-3">
            <label for="status" class="form-label">Status</label>
            <select class="form-control" name="status" id="status" required>
                <option value="active" {{ $blog->status == 'active' ? 'selected' : '' }}>Active</option>
                <option value="inactive" {{ $blog->status == 'inactive' ? 'selected' : '' }}>Inactive</option>
            </select>
        </div>

        <div class="d-flex justify-content-between">
            <a href="{{ route('admin.blogs.index') }}" class="btn btn-secondary">Back</a>
            <button type="submit" class="btn btn-primary">Update Blog</button>
        </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Meta title character counter
    var metaTitleInput = document.getElementById('meta-title');
    var metaDescriptionInput = document.getElementById('meta-description');
    
    function updateMetaTitleCount() {
        var length = metaTitleInput.value.length;
        var existingCounter = document.getElementById('meta-title-counter');
        if (!existingCounter) {
            existingCounter = document.createElement('small');
            existingCounter.id = 'meta-title-counter';
            existingCounter.className = 'text-muted d-block';
            metaTitleInput.parentNode.appendChild(existingCounter);
        }
        existingCounter.textContent = length + '/60 characters';
        existingCounter.className = length > 60 ? 'text-danger d-block' : 'text-muted d-block';
    }
    
    function updateMetaDescriptionCount() {
        var length = metaDescriptionInput.value.length;
        var existingCounter = document.getElementById('meta-description-counter');
        if (!existingCounter) {
            existingCounter = document.createElement('small');
            existingCounter.id = 'meta-description-counter';
            existingCounter.className = 'text-muted d-block';
            metaDescriptionInput.parentNode.appendChild(existingCounter);
        }
        existingCounter.textContent = length + '/160 characters';
        existingCounter.className = length > 160 ? 'text-danger d-block' : 'text-muted d-block';
    }
    
    if (metaTitleInput) {
        metaTitleInput.addEventListener('input', updateMetaTitleCount);
        updateMetaTitleCount(); // Initialize
    }
    
    if (metaDescriptionInput) {
        metaDescriptionInput.addEventListener('input', updateMetaDescriptionCount);
        updateMetaDescriptionCount(); // Initialize
    }
});
</script>

@endsection
