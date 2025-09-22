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
                                    <label class="form-label">Current Banner Video/GIF</label><br>
                                    @if($banner->banner_video)
                                        @php
                                            $fileExtension = pathinfo($banner->banner_video, PATHINFO_EXTENSION);
                                            $isGif = strtolower($fileExtension) === 'gif';
                                        @endphp
                                        
                                        @if($isGif)
                                            <img src="{{ asset('storage/' . $banner->banner_video) }}" alt="Banner GIF" style="max-width: 320px; max-height: 240px;">
                                        @else
                                            <video width="320" height="240" controls>
                                                <source src="{{ asset('storage/' . $banner->banner_video) }}" type="video/mp4">
                                                Your browser does not support the video tag.
                                            </video>
                                        @endif
                                    @else
                                        <p>No video/GIF available</p>
                                    @endif
                                </div>

                                <!-- Upload New Video -->
                                <div class="col-xl-12">
                                    <label for="banner_video" class="form-label">Change Banner Video/GIF (optional)</label>
                                    <input type="file" class="form-control" name="banner_video" id="banner_video" accept="video/*,image/gif" onchange="validateFileSize(this, 104857600)">
                                    <small class="text-muted">Supports MP4, AVI, MOV, WMV videos and GIF files (Max: 100MB). Leave blank to keep existing video.</small>
                                    <div id="upload_progress_edit" class="mt-2" style="display: none;">
                                        <div class="progress">
                                            <div class="progress-bar" role="progressbar" style="width: 0%"></div>
                                        </div>
                                        <small class="text-muted">Uploading large file, please wait...</small>
                                    </div>
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

<script>
function validateFileSize(input, maxSize) {
    if (input.files && input.files[0]) {
        const file = input.files[0];
        const fileSize = file.size;
        
        // Show file size to user
        const fileSizeMB = (fileSize / (1024 * 1024)).toFixed(2);
        console.log('Selected file size: ' + fileSizeMB + ' MB');
        
        if (fileSize > maxSize) {
            alert('File size (' + fileSizeMB + ' MB) exceeds the maximum allowed size of 100 MB. Please choose a smaller file.');
            input.value = ''; // Clear the input
            return false;
        }
        
        // Show progress indicator for large files (>10MB)
        if (fileSize > 10485760) { // 10MB
            const progressDiv = input.closest('.col-xl-12').querySelector('[id*="upload_progress"]');
            if (progressDiv) {
                progressDiv.style.display = 'block';
            }
        }
        
        return true;
    }
}

// Show progress on form submission for large files
document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('form[enctype="multipart/form-data"]');
    if (form) {
        form.addEventListener('submit', function(e) {
            const fileInput = form.querySelector('input[type="file"]');
            if (fileInput && fileInput.files && fileInput.files[0]) {
                const fileSize = fileInput.files[0].size;
                if (fileSize > 10485760) { // 10MB
                    const submitBtn = form.querySelector('button[type="submit"]');
                    if (submitBtn) {
                        submitBtn.disabled = true;
                        submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Updating...';
                    }
                }
            }
        });
    }
});
</script>

@endsection
