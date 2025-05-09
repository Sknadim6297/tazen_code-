@extends('professional.layout.layout')
@section('styles')
<link rel="stylesheet" href="{{ asset('professional/assets/css/service.css') }}" />
@endsection

@section('content')
<div class="content-wrapper">
    <!-- Page Header -->
    <div class="page-header">
        <div class="page-title">
            <h3>Add Service</h3>
        </div>
        <ul class="breadcrumb">
            <li>Home</li>
            <li class="active">Add Service</li>
        </ul>
    </div>
    <form id="serviceForm" enctype="multipart/form-data">
        @csrf
        <div class="form-container">
            <div class="form-row">
                <div class="form-col">
                    <div class="form-group">
                        <label for="serviceName">Service Name *</label>
                        <input type="text" name="serviceName" id="serviceName" class="form-control" 
                            value="{{ old('serviceName', $service->service_name ?? '') }}" 
                            placeholder="Enter service name" required>
                    </div>
        
                    <div class="form-group">
                        <label for="serviceCategory">Service Category *</label>
                        <select name="serviceId" id="serviceCategory" class="form-control" required>
                            <option value="">Select Category</option>
                            @foreach($services as $cat)
                                <option value="{{ $cat->id }}" 
                                    {{ (old('serviceId', $service->service_id ?? '') == $cat->id) ? 'selected' : '' }}>
                                    {{ ucfirst($cat->name) }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    
        
                    <div class="form-group">
                        <label for="serviceDuration">Duration *</label>
                        <select name="serviceDuration" id="serviceDuration" class="form-control" required>
                            @foreach([30, 45, 60, 90, 120] as $duration)
                                <option value="{{ $duration }}" {{ (old('serviceDuration', $service->duration ?? '') == $duration) ? 'selected' : '' }}>
                                    {{ $duration }} minutes
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
        
                <div class="form-col">
                    <div class="form-group">
                        <label>Service Image</label>
                        <div class="image-upload">
                            <div class="image-preview" id="imagePreview">
                                @if(!empty($service->image_path))
                                    <img src="{{ asset($service->image_path) }}" alt="Service Image" style="max-width: 150px; height: auto;">
                                @else
                                    <i class="fas fa-camera" style="font-size: 24px; color: var(--text-gray);"></i>
                                @endif
                            </div>
                            <div class="upload-btn mt-2">
                                <button type="button" class="btn btn-outline" onclick="document.getElementById('serviceImage').click();">
                                    <i class="fas fa-upload"></i> Upload Image
                                </button>
                                <input type="file" name="serviceImage" id="serviceImage" accept="image/*" style="display: none;">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        
            <div class="form-group">
                <label for="serviceDescription">Description *</label>
                <textarea name="serviceDescription" id="serviceDescription" class="form-control" 
                    placeholder="Describe your service in detail" rows="5" required>{{ old('serviceDescription', $service->description ?? '') }}</textarea>
            </div>
        
            <div class="form-row">
                <div class="form-col">
                    <div class="form-group">
                        <label>Service Features</label>
                        <div class="checkbox-group">
                            @php
                            // If features are not null and is not already an array, decode it
                            $selectedFeatures = is_array($service->features) ? $service->features : json_decode($service->features ?? '[]', true);
                            $allFeatures = ['online' => 'Online Sessions', 'in-person' => 'In-Person', 'group' => 'Group Sessions', 'recorded' => 'Recorded Sessions'];
                        @endphp
                        
                            @foreach($allFeatures as $key => $label)
                                <label class="checkbox-item">
                                    <input type="checkbox" name="features[]" value="{{ $key }}" 
                                        {{ in_array($key, old('features', $selectedFeatures)) ? 'checked' : '' }}> {{ $label }}
                                </label>
                            @endforeach
                        </div>
                    </div>
                </div>
        
                <div class="form-col">
                    <div class="form-group">
                        <label for="serviceTags">Tags</label>
                        <input type="text" name="serviceTags" id="serviceTags" class="form-control" 
                            value="{{ old('serviceTags', $service->tags ?? '') }}" 
                            placeholder="Add tags separated by commas">
                        <small class="text-muted">Example: coaching, business, career</small>
                    </div>
                </div>
            </div>
        
            <div class="form-group">
                <label for="serviceRequirements">Client Requirements</label>
                <textarea name="serviceRequirements" id="serviceRequirements" class="form-control" 
                    placeholder="List any requirements clients should know before booking" rows="3">{{ old('serviceRequirements', $service->requirements ?? '') }}</textarea>
            </div>
        
            <div class="form-actions">
                <a href="{{ route('professional.service.index') }}" class="btn btn-outline">Cancel</a>
                <button type="submit" class="btn btn-primary">Save Service</button>
            </div>
        </div>
    </form>     
    
</div>
@endsection
@section('scripts')
<script>
    $(document).ready(function() {
        $('#serviceForm').submit(function(e) {
            e.preventDefault();
    
            let form = this;
            let formData = new FormData(form);

            formData.append('_method', 'PUT');

            for (let pair of formData.entries()) {
                console.log(pair[0] + ': ' + pair[1]);
            }
    
            $.ajax({
                url: "{{ route('professional.service.update', $service->id) }}",
                type: "POST", 
                data: formData,
                contentType: false,
                processData: false,
                cache: false,
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                success: function(response) {
                    if (response.success) {
                        toastr.success(response.message);
                        form.reset();
                        setTimeout(() => {
                            window.location.href = "{{ route('professional.service.index') }}";
                        }, 1500);
                    } else {
                        toastr.error(response.message || "Something went wrong");
                    }
                },
                error: function(xhr) {
                    console.log(xhr);
                    if (xhr.status === 422) {
                        let errors = xhr.responseJSON.errors;
                        $.each(errors, function(key, value) {
                            toastr.error(value[0]);
                        });
                    } else {
                        toastr.error(xhr.responseJSON.message || "An unexpected error occurred");
                    }
                }
            });
        });
    });
    </script>
    
@endsection