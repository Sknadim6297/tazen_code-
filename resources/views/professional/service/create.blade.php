@extends('professional.layout.layout')

@section('styles')
   <link rel="stylesheet" href="{{ asset('professional/assets/css/service.css') }}" />

   <style>
.checkbox-group {
    display: flex;
    flex-wrap: wrap; 
}
.checkbox-item input[type="checkbox"] {
    appearance: none;
    -webkit-appearance: none;
    -moz-appearance: none;
    width: 15px;
    height: 15px;
    border-radius: 50%;
    border: 2px solid #ccc;
    position: relative;
    cursor: pointer;
    transition: background-color 0.3s ease, border-color 0.3s ease;
    margin-right: 10px; 
}

.checkbox-item input[type="checkbox"]:not([disabled]):checked {
    background-color: green;
    border-color: green;
}


.checkbox-item input[type="checkbox"]:disabled {
    background-color: red;
    border-color: red;
    cursor: not-allowed; /* Show that it's not clickable */
}

/* Optional: Add a little fade effect to disabled checkboxes */
.checkbox-item input[type="checkbox"]:disabled {
    opacity: 0.5;
}

/* Label styling */
.checkbox-item {
    display: flex;
    flex-direction: column; /* Added to stack label text below checkbox */
    font-size: 14px;
}

   </style>

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
            <h3>Add Service</h3>
        </div>
        <ul class="breadcrumb">
            <li>Home</li>
            <li class="active">Add Service</li>
        </ul>
    </div>
    
    <!-- Add Service Form -->
    <div class="form-container">
        <form id="serviceForm" enctype="multipart/form-data">
            @csrf   
            
            <!-- Hidden field for service duration with default value -->
            <input type="hidden" name="serviceDuration" value="60">
    
            <div class="form-row">
                <div class="form-col">
                    <div class="form-group">
                        <label for="serviceCategory">Service Category * <span class="badge bg-secondary" style="font-size: 11px; padding: 3px 6px;">Selectable</span></label>
                        <select name="serviceId" id="serviceCategory" class="form-control" required>
                            <option value="">Select Category</option>
                            @foreach($services as $service)
                                <option value="{{ $service->id }}" {{ 
                                    (isset($matchingServiceId) && $matchingServiceId == $service->id) ? 'selected' : '' 
                                }}>{{ $service->name }}</option>
                            @endforeach
                        </select>
                        <!-- Keep the hidden input as backup -->
                        <input type="hidden" name="serviceIdBackup" value="{{ $matchingServiceId ?? '' }}">
                        <small class="text-muted">
                            <strong>Note:</strong> Select the service category you want to offer.
                            <br>You can change this when editing the service later.
                        </small>
                    </div>
                    </div>
                </div>
            </div>
            
            <!-- Sub-Service Selection -->
            <div class="form-row">
                <div class="form-col">
                    <div class="form-group">
                        <label for="subServices">Sub-Services (Optional)</label>
                        <div id="subServiceContainer" class="sub-service-container">
                            <p class="text-muted">Please select a service category first to see available sub-services.</p>
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
                            <label class="checkbox-item">
                                <input type="checkbox" name="features[]" value="online" checked> Online Sessions
                            </label>
                        </div>
                        
                    </div>
                </div>
    
                <div class="form-col">
                    <div class="form-group">
                        <label for="serviceTags">Tags</label>
                        <input type="text" name="serviceTags" id="serviceTags" class="form-control" placeholder="Add tags separated by commas">
                        <small class="text-muted">Example: coaching, business, career</small>
                    </div>
                </div>
            </div>
    
            <div class="form-group">
                <label for="serviceRequirements">Client Requirements</label>
                <textarea name="serviceRequirements" id="serviceRequirements" class="form-control" placeholder="List any requirements clients should know before booking" rows="3"></textarea>
            </div>
    
            <div class="form-actions">
                <button type="button" class="btn btn-outline">Cancel</button>
                <button type="submit" class="btn btn-primary">Save Service</button>
            </div>
        </form>
    </div>
    
</div>
@endsection
@section('scripts')
<script>
$(document).ready(function() {
    // Load sub-services when service category changes
    $('#serviceCategory').change(function() {
        loadSubServices($(this).val());
    });
    
    // Load sub-services on page load if a service is pre-selected
    var serviceId = $('#serviceCategory').val();
    console.log('Initial service ID:', serviceId);
    if (serviceId) {
        loadSubServices(serviceId);
    }
});

function loadSubServices(serviceId) {
    const container = $('#subServiceContainer');
    
    console.log('loadSubServices called with serviceId:', serviceId);
    
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
                    html += `
                        <div class="sub-service-item">
                            <input type="checkbox" name="subServices[]" value="${subService.id}" id="subService${subService.id}">
                            <label for="subService${subService.id}">${subService.name}</label>
                        </div>
                    `;
                });
                container.html(html);
                // Attach limit handler after rendering
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

// Limit selection to maximum of 2 checkboxes
function enforceSubServiceLimit(container) {
    container.find('input[type="checkbox"]').off('change').on('change', function() {
        const checked = container.find('input[type="checkbox"]:checked');
        if (checked.length >= 2) {
            // disable all unchecked checkboxes
            container.find('input[type="checkbox"]:not(:checked)').attr('disabled', true).closest('.sub-service-item').addClass('disabled');
        } else {
            container.find('input[type="checkbox"]').attr('disabled', false).closest('.sub-service-item').removeClass('disabled');
        }
    });
}

$('#serviceForm').submit(function(e) {
    e.preventDefault();
    let form = this;
    let formData = new FormData(form); 

    $.ajax({
        url: "{{ route('professional.service.store') }}",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        cache: false,
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
</script>
@endsection
