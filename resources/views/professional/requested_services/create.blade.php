@extends('professional.layout.layout')

@section('styles')
<link rel="stylesheet" href="{{ asset('professional/assets/css/other.css') }}" />
@endsection


@section('content')
<div class="content-wrapper">
    <div class="page-header">
        <div class="page-title">
            <h3>Add Other Information</h3>
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
                        <textarea type="text" name="sub_heading" id="sub_heading" class="form-control" required placeholder="Enter services details..."></textarea>
                    </div>
                </div>
            </div>

            <!-- Requested Services -->
            <div id="requestedServicesContainer">
                <div class="form-row requested-service">
                    <div class="form-col">
                        <div class="form-group">
                            <label>Requested Service *</label>
                            <input type="text" name="requested_service[]" class="form-control" required placeholder="Add field related to your service which you can offer">
                        </div>
                    </div>
                    <div class="form-col">
                        <div class="form-group">
                            <label>Price *</label>
                            <input type="number" name="price[]" class="form-control" step="0.01" required placeholder="Enter price">
                        </div>
                    </div>
                </div>
            </div>
            <button type="button" id="addService" class="btn btn-sm btn-secondary mt-2"> <i class="fas fa-plus me-2" style="font-size: 18px;"></i>Add More Requested Service</button>

            <!-- Education -->
            <div class="form-row mt-4">
                <div class="form-col">
                    <div class="form-group">
                        <label for="education_statement">Education Statement</label>
                        <textarea name="education_statement" id="education_statement" class="form-control" rows="4" placeholder="Write about your education..."></textarea>
                    </div>
                </div>
            </div>

         <div id="educationContainer" class="mt-4">
    <div class="form-row education-entry">
        <div class="form-col">
            <div class="form-group">
                <label>College Name</label>
                <input type="text" name="college_name[]" class="form-control" placeholder="Enter college name">
            </div>
        </div>
        <div class="form-col">
            <div class="form-group">
                <label>Degree</label>
                <input type="text" name="degree[]" class="form-control" placeholder="Enter degree">
            </div>
        </div>
    </div>
    </div>
    <button type="button" id="addEducation" class="btn btn-sm btn-secondary mt-2">
        <i class="fas fa-plus me-2" style="font-size: 18px;"></i> Add More Education
    </button>
            <!-- Submit -->
            <div class="form-actions" style="display: flex; justify-content: flex-end; gap:10px; margin-top: 20px;">
                <a href="{{ route('professional.requested_services.index') }}" class="btn btn-outline">Cancel</a>
                <button type="submit" class="btn btn-primary">Save</button>
            </div>
        </form>
    </div>
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



    // AJAX Submit
    $('#serviceForm').submit(function(e) {
        e.preventDefault();
        let form = this;
        let formData = new FormData(form);

        $.ajax({
            url: "{{ route('professional.requested_services.store') }}",
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                console.log(response.data);
                if (response.status=='success') {
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
