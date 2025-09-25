@extends('professional.layout.layout')

@section('styles')
<link rel="stylesheet" href="{{ asset('professional/assets/css/other.css') }}" />
<style>
    /* Mobile-friendly styling for Other Information page */
@media screen and (max-width: 767px) {
    /* Fix header to prevent horizontal scrolling */
    .page-header {
        position: sticky;
        top: 0;
        z-index: 10;
        background-color: #f8f9fa;
        padding-top: 10px;
        padding-bottom: 10px;
        width: 100%;
        max-width: 100vw;
        overflow-x: hidden;
    }
    
    /* Make table container scrollable horizontally */
    .table-responsive {
        overflow-x: auto;
        max-width: 100%;
        -webkit-overflow-scrolling: touch; /* Better scrolling on iOS */
    }
    
    /* Ensure the table takes full width of container */
    .table {
        width: 100%;
        table-layout: auto;
    }
    
    /* Ensure content wrapper doesn't cause horizontal scroll */
    .content-wrapper {
        overflow-x: hidden;
        width: 100%;
        max-width: 100vw;
        padding: 20px 10px;
    }
    
    /* Fix card width */
    .card {
        width: 100%;
        overflow-x: hidden;
    }
    
    /* Ensure the card body doesn't cause overflow */
    .card-body {
        padding: 10px 5px;
    }
    
    /* Optional: Make some table columns width-responsive */
    .table th,
    .table td {
        white-space: nowrap;
    }
    
    /* Fix the actions column to be more mobile-friendly */
    .table td:last-child {
        min-width: 100px;
    }
    
    /* Fix buttons in small screens */
    .btn-sm {
        padding: 0.25rem 0.5rem;
        font-size: 0.75rem;
    }
    
    /* Fix badges display in mobile view */
    .badge {
        display: inline-block;
        margin-bottom: 3px;
    }
    
    /* Card header adjustments for mobile */
    .card-header {
        flex-direction: column;
        align-items: flex-start !important;
    }
    
    .card-header .btn {
        margin-top: 10px;
    }
}
</style>
@endsection


@section('content')
<div class="content-wrapper">
    <div class="page-header">
        <div class="page-title">
            <h3>Edit Other Information</h3>
        </div>
        <ul class="breadcrumb">
            <li>Home</li>
            <li class="active">Other Information</li>
        </ul>
    </div>

    <div class="form-container">
        <form id="serviceForm">
            @csrf
        
            <!-- Services Details -->
            <div class="form-row">
                <div class="form-col">
                    <div class="form-group">
                        <label for="sub_heading">Services Details*</label>
                        <textarea name="sub_heading" id="sub_heading" class="form-control" required placeholder="Enter services details...">{{ $info->sub_heading }}</textarea>
                    </div>
                </div>
            </div>
        
            <!-- Requested Services -->
            <div id="requestedServicesContainer">
                @foreach(json_decode($info->requested_service) as $key => $service)
                    <div class="form-row requested-service">
                        <div class="form-col">
                            <div class="form-group">
                                <label>Requested Service *</label>
                                <input type="text" name="requested_service[]" class="form-control" required value="{{ $service }}" placeholder="Add field related to your service which you can offer">
                            </div>
                        </div>
                        <div class="form-col">
                            <div class="form-group">
                                <label>Price *</label>
                                <input type="number" name="price[]" class="form-control" step="0.01" required value="{{ json_decode($info->price)[$key] }}" placeholder="Enter price">
                            </div>
                        </div>
                        @if($key > 0)
                        <div class="form-col">
                            <button type="button" class="btn btn-sm btn-danger remove-service">Delete</button>
                        </div>
                        @endif
                    </div>
                @endforeach
            </div>
            <button type="button" id="addService" class="btn btn-sm btn-secondary mt-2"><i class="fas fa-plus me-2"></i>Add More Requested Service</button>
        
            <!-- Education Overview -->
            <div class="form-row mt-4">
                <div class="form-col">
                    <div class="form-group">
                        <label for="education_statement">Education statement</label>
                        <textarea name="education_statement" id="education_statement" class="form-control" rows="4" placeholder="Write about your education...">{{ $info->education_statement ?? '' }}</textarea>
                    </div>
                </div>
            </div>
        
            <!-- Education Detail -->
            <div id="educationContainer" class="mt-4">
                @php
                    $education = json_decode($info->education, true);
                @endphp
                @foreach($education['college_name'] as $key => $college)
                    <div class="form-row education-entry">
                        <div class="form-col">
                            <div class="form-group">
                                <label>College Name</label>
                                <input type="text" name="college_name[]" class="form-control" value="{{ $college }}" placeholder="Enter college name" >
                            </div>
                        </div>
                        <div class="form-col">
                            <div class="form-group">
                                <label>Degree</label>
                                <input type="text" name="degree[]" class="form-control" value="{{ $education['degree'][$key] }}" placeholder="Enter degree" >
                            </div>
                        </div>
                        @if($key > 0)
                        <div class="form-col">
                            <button type="button" class="btn btn-sm btn-danger remove-education">Delete</button>
                        </div>
                        @endif
                    </div>
                @endforeach
            </div>
            <button type="button" id="addEducation" class="btn btn-sm btn-secondary mt-2">
                <i class="fas fa-plus me-2"></i>Add More Education
            </button>
        
            <!-- Submit -->
            <div class="form-actions mt-4" style="display: flex; justify-content: flex-end; gap:10px;">
                <a href="{{ route('professional.requested_services.index') }}" class="btn btn-outline">Cancel</a>
                <button type="submit" class="btn btn-primary">Update</button>
            </div>
        </form>
        
    </div>
</div>
@endsection

@section('scripts')
<script>
 // Add Requested Service with a Delete Button
$('#addService').click(function () {
    $('#requestedServicesContainer').append(`
        <div class="form-row requested-service">
            <div class="form-col">
                <div class="form-group">
                    <input type="text" name="requested_service[]" class="form-control" placeholder="Enter service name" required>
                </div>
            </div>
            <div class="form-col">
                <div class="form-group">
                    <input type="number" name="price[]" class="form-control" placeholder="Enter price" step="0.01" required>
                </div>
            </div>
            <div class="form-col">
                <button type="button" class="btn btn-sm btn-danger remove-service">Delete</button>
            </div>
        </div>
    `);
});

// Add Education Entry with a Delete Button
$('#addEducation').click(function () {
    $('#educationContainer').append(`
        <div class="form-row education-entry">
            <div class="form-col">
                <div class="form-group">
                    <input type="text" name="college_name[]" class="form-control" placeholder="Enter college name" required>
                </div>
            </div>
            <div class="form-col">
                <div class="form-group">
                    <input type="text" name="degree[]" class="form-control" placeholder="Enter degree" required>
                </div>
            </div>
            <div class="form-col">
                <button type="button" class="btn btn-sm btn-danger remove-education">Delete</button>
            </div>
        </div>
    `);
});

$(document).on('click', '.remove-service', function () {
    $(this).closest('.requested-service').remove();
});

$(document).on('click', '.remove-education', function () {
    $(this).closest('.education-entry').remove();
});



$('#serviceForm').submit(function(e) {
    e.preventDefault();
    let form = this;
    let formData = new FormData(form);

    // Append _method=PUT to simulate PUT request
    formData.append('_method', 'PUT');

    $.ajax({
        url: "{{ route('professional.requested_services.update', $info->id) }}",
        type: "POST", // still use POST, but with _method override
        data: formData,
        contentType: false,
        processData: false,
        success: function(response) {
            console.log(response.data);
            if (response.status == 'success') {
                toastr.success(response.message);
                form.reset();
                setTimeout(() => {
                    window.location.href = "{{ route('professional.requested_services.index') }}";
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
