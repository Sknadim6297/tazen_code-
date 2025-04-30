@extends('admin.layouts.layout')

@section('content')
<div class="main-content app-content">
    <div class="container-fluid">
        <!-- Page Header Close -->

                    <h1 class="mb-4">Edit Contact Banner</h1>
                        <form action="{{ route('admin.banners.update', $banner->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="row gy-3">
                                <!-- Banner Heading -->
                                <div class="col-xl-6">
                                    <label for="heading" class="form-label">Banner Heading</label>
                                    <input type="text" class="form-control" id="heading" name="heading" value="{{ old('heading', $banner->heading) }}" required>
                                </div>

                                <!-- Banner Sub Heading -->
                                <div class="col-xl-6">
                                    <label for="sub_heading" class="form-label">Sub Heading</label>
                                    <input type="text" class="form-control" id="sub_heading" name="sub_heading" value="{{ old('sub_heading', $banner->sub_heading) }}">
                                </div>

                                <!-- Existing Video Preview -->
                                <div class="col-xl-12">
                                    <label class="form-label">Current Banner Video</label><br>
                                    @if($banner->banner_video)
                                        <video width="320" height="240" controls>
                                            <source src="{{ asset($banner->banner_video) }}" type="video/mp4">
                                            Your browser does not support the video tag.
                                        </video>
                                    @else
                                        <p>No video available</p>
                                    @endif
                                </div>

                                <!-- Upload New Video -->
                                <div class="col-xl-12">
                                    <label for="banner_video" class="form-label">Change Banner Video (optional)</label>
                                    <input type="file" class="form-control" name="banner_video" id="banner_video" accept="video/*">
                                    <small class="text-muted">Leave blank to keep existing video.</small>
                                </div>

                                <!-- Status -->
                                <div class="col-xl-12">
                                    <label for="status" class="form-label">Status</label>
                                    <select class="form-control" name="status" id="status" required>
                                        <option value="active" {{ old('status', $banner->status) == 'active' ? 'selected' : '' }}>Active</option>
                                        <option value="inactive" {{ old('status', $banner->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                    </select>
                                </div>
                            </div>

                            <div class="mt-4">
                                <a href="{{ route('admin.banners.index') }}" class="btn btn-light">Cancel</a>
                                <button type="submit" class="btn btn-primary">Update Banner</button>
                            </div>

                        </form>
                    

    </div>
</div>
@endsection
