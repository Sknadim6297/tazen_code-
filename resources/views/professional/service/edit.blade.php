@extends('professional.layout.layout')
@section('styles')
<link rel="stylesheet" href="{{ asset('professional/assets/css/service.css') }}" />

<style>
.sub-service-container {
    border: 1px solid #e9ecef;
    border-radius: 8px;
    padding: 15px;
    background-color: #f8f9fa;
    min-height: 60px;
}

.sub-service-item {
    display: flex;
    align-items: center;
    margin-bottom: 10px;
    padding: 8px;
    background-color: white;
    border-radius: 5px;
    border: 1px solid #dee2e6;
}

.sub-service-item:last-child {
    margin-bottom: 0;
}

.sub-service-item input[type="checkbox"] {
    margin-right: 10px;
    transform: scale(1.2);
}

.sub-service-item label {
    margin: 0;
    cursor: pointer;
    font-weight: 500;
}

.sub-service-loading {
    text-align: center;
    color: #6c757d;
    font-style: italic;
}
</style>

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
            <div class="form-row">
                <div class="form-col">
                    <div class="form-group">
                        <label for="serviceCategory">Service Category * <span class="badge bg-secondary text-white" style="font-size: 11px; padding: 3px 6px;">Not editable</span></label>
                        <!-- Service category is shown but not editable on the edit page. The hidden input ensures the value is submitted. -->
                        <select name="serviceId_disabled" id="serviceCategory" class="form-control" disabled>
                            <option value="">Select Category</option>
                            @foreach($services as $serviceItem)
                                <option value="{{ $serviceItem->id }}" 
                                    {{ $service->service_id == $serviceItem->id ? 'selected' : 
                                       (isset($matchingServiceId) && $matchingServiceId == $serviceItem->id ? 'selected' : '') }}>
                                    {{ $serviceItem->name }}
                                </option>
                            @endforeach
                        </select>
                        <input type="hidden" name="serviceId" value="{{ $service->service_id }}">
                        <small class="text-muted">Service category is read-only on this page and cannot be changed.</small>
                    </div>
                </div>
            </div>
            
            <!-- Sub-Service Selection -->
            <div class="form-row">
                <div class="form-col">
                    <div class="form-group">
                        <label for="subServices">Sub-Services (Optional)</label>
                        <div id="subServiceContainer" class="sub-service-container">
                            <div class="sub-service-loading">Loading sub-services...</div>
                        </div>
                        <small class="text-muted">Select the specific sub-services you offer within your service category.</small>
                    </div>
                </div>
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
                                        {{ in_array($key, old('features', $selectedFeatures)) ? 'checked' : 'checked' }}> {{ $label }}
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
        // Load sub-services when service category changes
        $('#serviceCategory').change(function() {
            loadSubServices($(this).val());
        });
        
        // Load sub-services on page load for current service
        loadSubServices($('#serviceCategory').val(), @json($service->subServices->pluck('id')->toArray()));
        
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
    
    function loadSubServices(serviceId, selectedSubServices = []) {
        const container = $('#subServiceContainer');
        
        console.log('loadSubServices called with serviceId:', serviceId, 'selectedSubServices:', selectedSubServices);
        
        if (!serviceId) {
            container.html('<p class="text-muted">Please select a service category first to see available sub-services.</p>');
            return;
        }
        
        container.html('<div class="sub-service-loading">Loading sub-services...</div>');
        
        $.ajax({
            url: "{{ route('professional.service.getSubServices') }}",
            type: "GET",
            data: { service_id: serviceId },
            success: function(response) {
                console.log('AJAX response:', response);
                if (response.success && response.subServices.length > 0) {
                    let html = '';
                    response.subServices.forEach(function(subService) {
                        const isSelected = selectedSubServices.includes(subService.id);
                        html += `
                            <div class="sub-service-item">
                                <input type="checkbox" name="subServices[]" value="${subService.id}" id="subService${subService.id}" ${isSelected ? 'checked' : ''}>
                                <label for="subService${subService.id}">${subService.name}</label>
                            </div>
                        `;
                    });
                    container.html(html);
                    enforceSubServiceLimit(container);
                } else {
                    container.html('<p class="text-muted">No sub-services available for this category.</p>');
                }
            },
            error: function(xhr) {
                console.error('AJAX error:', xhr);
                container.html('<p class="text-danger">Error loading sub-services. Please try again.</p>');
            }
        });
    }

    // No limit on sub-service selection: allow professionals to choose any number of sub-services
    function enforceSubServiceLimit(container) {
        // Intentionally left blank so checkboxes remain independent and unlimited selection is allowed.
        container.find('input[type="checkbox"]').off('change').on('change', function() {
            // no-op: selection not limited
        });
    }
    </script>
    
@endsection
