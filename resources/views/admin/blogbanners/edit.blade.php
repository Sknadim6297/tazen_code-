@extends('admin.layouts.layout')
@section('content')
<div class="main-content app-content">
    <div class="container">
        <h4>Edit Blog Banner</h4>
        <form action="{{ route('admin.blogbanners.update', $banner->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
    
            <div class="row gy-3">
                <div class="col-xl-6">
                    <label for="heading" class="form-label">Banner Heading</label>
                    <input type="text" class="form-control" id="heading" name="heading" value="{{ old('heading', $banner->heading) }}" required>
                </div>
    
                <div class="col-xl-6">
                    <label for="sub_heading" class="form-label">Banner Sub Heading</label>
                    <input type="text" class="form-control" id="sub_heading" name="subheading" value="{{ old('subheading', $banner->subheading) }}">
                </div>
    
                <div class="col-xl-12">
                    <label for="banner_image" class="form-label">Banner Image</label><br>
                    @if ($banner->banner_image)
                        <img src="{{ asset('uploads/blog_banners/' . $banner->banner_image) }}" width="150" class="mb-2">
                    @endif
                    <input type="file" class="form-control" name="banner_image" id="banner_image" accept="image/*">
                </div>
    
                <div class="col-xl-12">
                    <label for="status" class="form-label">Status</label>
                    <select class="form-control" name="status" id="status" required>
                        <option value="active" {{ $banner->status == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ $banner->status == 'inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>
            </div>
    
            <button type="submit" class="btn btn-success mt-3">Update Banner</button>
        </form>
    </div>

</div>
@endsection