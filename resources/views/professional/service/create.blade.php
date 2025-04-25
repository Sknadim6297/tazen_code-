@extends('professional.layout.layout')

@section('style')

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
    
            <div class="form-row">
                <div class="form-col">
                    <div class="form-group">
                        <label for="serviceName">Service Name *</label>
                        <input type="text" name="serviceName" id="serviceName" class="form-control" placeholder="Enter service name" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="serviceCategory">Category *</label>
                        <select name="serviceCategory" id="serviceCategory" class="form-control" required>
                            <option value="">Select Category</option>
                            <option value="consulting">Consulting</option>
                            <option value="coaching">Coaching</option>
                            <option value="training">Training</option>
                            <option value="therapy">Therapy</option>
                            <option value="other">Other</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="serviceDuration">Duration *</label>
                        <select name="serviceDuration" id="serviceDuration" class="form-control" required>
                            <option value="30">30 minutes</option>
                            <option value="45">45 minutes</option>
                            <option value="60">60 minutes</option>
                            <option value="90">90 minutes</option>
                            <option value="120">120 minutes</option>
                        </select>
                    </div>
                </div>
    
                <div class="form-col">
                    <div class="form-group">
                        <label>Service Image</label>
                        <div class="image-upload">
                            <div class="image-preview" id="imagePreview">
                                <i class="fas fa-camera" style="font-size: 24px; color: var(--text-gray);"></i>
                            </div>
                            <div class="upload-btn">
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
                <textarea name="serviceDescription" id="serviceDescription" class="form-control" placeholder="Describe your service in detail" rows="5" required></textarea>
            </div>
    
            <div class="form-row">
                <div class="form-col">
                    <div class="form-group">
                        <label>Service Features</label>
                        <div class="checkbox-group">
                            <label class="checkbox-item">
                                <input type="checkbox" name="features[]" value="online"> Online Sessions
                            </label>
                            <label class="checkbox-item">
                                <input type="checkbox" name="features[]" value="in-person"> In-Person
                            </label>
                            <label class="checkbox-item">
                                <input type="checkbox" name="features[]" value="group"> Group Sessions
                            </label>
                            <label class="checkbox-item">
                                <input type="checkbox" name="features[]" value="recorded"> Recorded Sessions
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
                    window.location.href = "{{ route('professional.dashboard') }}";
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
