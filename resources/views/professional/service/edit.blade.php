@extends('professional.layout.layout')
@section('styles')
<link rel="stylesheet" href="{{ asset('professional/assets/css/service.css') }}" />

@endsection

@section('content')
<div class="content-wrapper">
    <!-- Page Header -->
    <div class="page-header">
        <div class="page-title">
            <h3>Edit Service</h3>
        </div>
        <ul class="breadcrumb">
            <li>Home</li>
            <li class="active">Edit Service</li>
        </ul>
    </div>
    <form id="serviceForm" enctype="multipart/form-data">
        @csrf
        <!-- Hidden duration field -->
        <input type="hidden" name="serviceDuration" value="{{ old('serviceDuration', $service->duration ?? 60) }}">
        
        <div class="form-container">
        
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
                            $selectedFeatures = is_array($service->features) ? $service->features : json_decode($service->features ?? '[]', true);
                            $allFeatures = ['online' => 'Online Sessions'];
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
<style>
    @media only screen and (min-width: 768px) and (max-width: 1024px) {
    .user-profile-wrapper {
        margin-top: -57px;
    }
}
</style>
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
