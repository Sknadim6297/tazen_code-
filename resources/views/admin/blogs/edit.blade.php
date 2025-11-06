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
@endsection
