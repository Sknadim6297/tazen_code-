@extends('admin.layouts.layout')

@section('content')
<div class="main-content app-content">
    <div class="container mt-4">
        <h4>Edit About Banner</h4>
    
        <form action="{{ route('admin.about-banner.update', $banner->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
    
            <div class="row mb-3">
                <label for="heading" class="col-form-label col-md-2">Banner Heading</label>
                <div class="col-md-10">
                    <input type="text" class="form-control" id="heading" name="heading" value="{{ old('heading', $banner->heading) }}" required>
                </div>
            </div>
    
            <div class="row mb-3">
                <label for="sub_heading" class="col-form-label col-md-2">Sub Heading</label>
                <div class="col-md-10">
                    <input type="text" class="form-control" id="sub_heading" name="sub_heading" value="{{ old('sub_heading', $banner->sub_heading) }}">
                </div>
            </div>
    
            <div class="row mb-3">
                <label for="banner_image" class="col-form-label col-md-2">Banner Image</label>
                <div class="col-md-10">
                    <input type="file" class="form-control" id="banner_image" name="banner_image" accept="image/*">
                    @if ($banner->banner_image)
                        <img src="{{ asset('uploads/banners/' . $banner->banner_image) }}" alt="Current Banner" width="150" class="mt-2">
                    @endif
                </div>
            </div>
    
            <div class="row mb-3">
                <label for="status" class="col-form-label col-md-2">Status</label>
                <div class="col-md-10">
                    <select name="status" id="status" class="form-control" required>
                        <option value="active" {{ $banner->status === 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ $banner->status === 'inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>
            </div>
    
            <div class="text-end">
                <a href="{{ route('admin.about-banner.index') }}" class="btn btn-secondary">Back</a>
                <button type="submit" class="btn btn-primary">Update Banner</button>
            </div>
        </form>
    </div>

</div>
@endsection