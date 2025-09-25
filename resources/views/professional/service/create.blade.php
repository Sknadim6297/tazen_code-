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
                        <label for="serviceCategory">Service Category * <span class="badge bg-secondary" style="font-size: 11px; padding: 3px 6px;">Fixed</span></label>
                        <select name="serviceId" id="serviceCategory" class="form-control" required disabled style="background-color: #f8f9fa;">
                            <option value="">Select Category</option>
                            @foreach($services as $service)
                                <option value="{{ $service->id }}" {{ 
                                    (isset($matchingServiceId) && $matchingServiceId == $service->id) ? 'selected' : '' 
                                }}>{{ $service->name }}</option>
                            @endforeach
                        </select>
                        <!-- Add a hidden input to ensure the value is submitted even when disabled -->
                        <input type="hidden" name="serviceId" value="{{ $matchingServiceId ?? '' }}">
                        <small class="text-muted">
                            <strong>Note:</strong> This is based on your registration information and cannot be changed now.
                            <br>You can change your service category later when editing this service.
                        </small>
                    </div>
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
