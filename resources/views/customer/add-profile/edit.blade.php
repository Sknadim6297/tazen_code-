@extends('customer.layout.layout')
@section('styles')
<link rel="stylesheet" href="{{ asset('customer-css/assets/css/add-profile.css') }}" />
<style>
    .content-wrapper {
        padding: 30px;  
        background-color: #f7f9fc;
    }

    .page-header {
        margin-bottom: 30px;
    }

    .page-title h3 {
        font-size: 24px;
        font-weight: 600;
        color: #2c3e50;
    }

    .breadcrumb {
        list-style: none;
        padding: 0;
        display: flex;
        gap: 10px;
        font-size: 14px;
        color: #7f8c8d;
    }

    .breadcrumb li.active {
        font-weight: bold;
        color: #2c3e50;
    }

    .add-profile-form {
        background: #fff;
        border-radius: 10px;
        padding: 30px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-group label {
        display: block;
        font-weight: 600;
        margin-bottom: 8px;
        color: #34495e;
    }
    
    input[type="text"],
    input[type="email"],
    input[type="tel"],
    input[type="number"],
    input[type="file"],
    textarea {
        width: 100%;
        padding: 12px 14px;
        border: 1px solid #ced4da;
        border-radius: 6px;
        font-size: 14px;
        transition: border-color 0.3s;
    }

    input[type="text"]:focus,
    input[type="email"]:focus,
    input[type="tel"]:focus,
    input[type="number"]:focus,
    textarea:focus {
        border-color: #3498db;
        outline: none;
    }

    .form-group.col-2 {
        display: flex;
        gap: 20px;
        flex-wrap: wrap;
    }

    .form-group.col-2 > div {
        flex: 1;
    }

    .form-group.col-full {
        width: 100%;
    }
    

    img {
        margin-top: 10px;
        border-radius: 6px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }

    .btn-primary {
        background-color: #2980b9;
        border: none;
        padding: 12px 24px;
        color: white;
        border-radius: 6px;
        font-weight: 600;
        transition: background-color 0.3s;
    }

    .btn-primary:hover {
        background-color: #1c6690;
    }

    @media (max-width: 768px) {
        .form-group.col-2 {
            flex-direction: column;
        }
    }
</style>
@endsection
@section('content')
<div class="content-wrapper">
    <div class="page-header">
        <div class="page-title">
            <h3>Edit Profile</h3>
        </div>
        <ul class="breadcrumb">
            <li>Home</li>
            <li class="active">Edit Profile</li>
        </ul>
    </div>

    <div class="add-profile-form">
        <form id="profileForm" enctype="multipart/form-data">
            @csrf
            <div class="form-group col-full">
                <label for="photo">Profile Photo</label>
                <input type="file" id="profile_image" name="profile_image" accept="image/*">
             @if($profile->customerProfile && $profile->customerProfile->profile_image)
    <img src="{{ asset('storage/'.$profile->customerProfile->profile_image) }}" alt="Current Photo" width="100">
@endif

            </div>
            <div class="form-group col-2">
                <div>
                    <label for="Name">Name</label>
                    <input type="text" id="name" name="name" value="{{ old('name', $profile->name ?? 'N/A' ) }}" required>
                </div>
            </div>
            <div class="form-group col-full">
                <label for="email">Email Address</label>
                <input type="email" id="email" name="email" value="{{ old('email', $profile->email) }}" required>
            </div>
         <div class="form-group col-2">
    <div>
        <label for="phone">Phone Number</label>
        <input type="tel" id="phone" name="phone" value="{{ old('phone', $profile->customerProfile ? $profile->customerProfile->phone : '') }}">
    </div>
</div>

            <div class="form-group col-full">
                <label for="address">Address</label>
                <textarea id="address" name="address" rows="3">{{ old('address', $profile->customerProfile ? $profile->customerProfile->address : '') }}</textarea>
            </div>
           <div class="form-group col-2">
    <div>
        <label for="city">City</label>
        <input id="city" name="city" value="{{ old('city', $profile->customerProfile?->city) }}" required>
    </div>
    <div>
        <label for="zip_code">Zip Code</label>
        <input id="zip_code" name="zip_code" value="{{ old('zip_code', $profile->customerProfile?->zip_code) }}" required>
    </div>
    <div>
        <label for="state">State</label>
        <input id="state" name="state" value="{{ old('state', $profile->customerProfile?->state) }}" required>
    </div>
</div>

            <div class="form-group col-full">
                <label for="notes">Notes</label>
                <textarea id="notes" name="notes" rows="3">{{ old('notes', $profile->customerProfile ? $profile->customerProfile->notes : '') }}</textarea>
            </div>
            <div class="form-group col-full">
                <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Save Profile</button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
$('#profileForm').submit(function(e) {
    e.preventDefault();
    let form = this;
    let formData = new FormData(form);
    formData.append('_method', 'PUT'); 

    $.ajax({
        url: "{{ route('user.profile.update', ['profile' => $profile->id]) }}", 
        method: "POST", 
        data: formData,
        contentType: false, 
        processData: false, 
        cache: false, 
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {
            console.log(response);
            
            if (response.status === 'success') {
                toastr.success(response.message);
                form.reset();
                setTimeout(function() {
                    window.location.href = "{{ route('user.profile.index') }}";
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
