@extends('professional.layout.layout')
@section('styles')
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
        <form id="profileForm">
            @csrf
            <div class="form-group col-full">
                <label for="photo">Profile Photo</label>
                <input type="file" id="photo" name="photo" accept="image/*">
                @if($profile->photo)
                    <img src="{{ asset($profile->photo) }}" alt="Current Photo" width="100">
                @endif
            </div>
            <div class="form-group col-full">
                <label for="gallery">Gallery Images (Multiple)</label>
                <input type="file" id="gallery" name="gallery[]" accept="image/*" multiple>
                @if($profile->gallery)
                    @php
                        $gallery = is_array($profile->gallery) ? $profile->gallery : json_decode($profile->gallery, true);
                    @endphp
                    @foreach($gallery as $img)
                        <img src="{{ asset($img) }}" alt="Gallery Image" width="80">
                    @endforeach
                @endif
            </div>
            <div class="form-group col-2">
                <div>
                    <label for="firstName">First Name</label>
                    <input type="text" id="firstName" name="firstName" value="{{ old('firstName', $profile->first_name) }}" required>
                </div>
                <div>
                    <label for="lastName">Last Name</label>
                    <input type="text" id="lastName" name="lastName" value="{{ old('lastName', $profile->last_name) }}" required>
                </div>
            </div>
            <div class="form-group col-full">
                <label for="email">Email Address</label>
                <input type="email" id="email" name="email" value="{{ old('email', $profile->email) }}" required>
            </div>
            <div class="form-group col-2">
                <div>
                    <label for="phone">Phone Number</label>
                    <input type="tel" id="phone" name="phone" value="{{ old('phone', $profile->phone) }}">
                </div>
                <div>
                    <label for="specialization">Specialization</label>
                    <input type="text" id="specialization" name="specialization" value="{{ old('specialization', $profile->specialization) }}">
                </div>
            </div>
            <div class="form-group col-full">
                <label for="experience">Years of Experience</label>
                <input type="text" id="experience" name="experience" value="{{ old('experience', $profile->experience) }}">
            </div>
            <div class="form-group col-full">
                <label for="startingPrice">Starting From Price</label>
                <input type="number" id="startingPrice" name="startingPrice" value="{{ old('startingPrice', $profile->starting_price) }}" min="0">
            </div>
            <div class="form-group col-full">
                <label for="address">Address</label>
                <textarea id="address" name="address" rows="3">{{ old('address', $profile->address) }}</textarea>
            </div>
            <div class="form-group col-full">
                <label for="education">Education Details</label>
                <textarea id="education" name="education" rows="3">{{ old('education', $profile->education) }}</textarea>
            </div>
            <div class="form-group col-full">
                <label for="qualificationDocument">Qualification Document</label>
                <input type="file" id="qualificationDocument" name="qualificationDocument" accept=".pdf,.doc,.docx,image/*">
                @if($profile->qualification_document)
                    <a href="{{ asset($profile->qualification_document) }}" target="_blank">View Document</a>
                @endif
            </div>
            <div class="form-group col-2">
                <div>
                    <label for="aadhaarCard">Aadhaar Card</label>
                    <input type="file" id="aadhaarCard" name="aadhaarCard" accept=".pdf,.jpg,.jpeg,.png">
                    @if($profile->aadhaar_card)
                        <a href="{{ asset($profile->aadhaar_card) }}" target="_blank">View Aadhaar</a>
                    @endif
                </div>
                <div>
                    <label for="panCard">PAN Card</label>
                    <input type="file" id="panCard" name="panCard" accept=".pdf,.jpg,.jpeg,.png">
                    @if($profile->pan_card)
                        <a href="{{ asset($profile->pan_card) }}" target="_blank">View PAN</a>
                    @endif
                </div>
            </div>
            <div class="form-group col-full">
                <label for="comments">Additional Comments</label>
                <textarea id="comments" name="comments" rows="3">{{ old('comments', $profile->comments) }}</textarea>
            </div>
            <div class="form-group col-full">
                <label for="bio">Bio</label>
                <textarea id="bio" name="bio" rows="4">{{ old('bio', $profile->bio) }}</textarea>
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

    $.ajax({
        url: "{{ route('professional.profile.update', ['profile' => $profile->id]) }}", 
        method: "POST",
        data: formData,
        contentType: false, 
        processData: false, 
        cache: false, 
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {
            if (response.success) {
                toastr.success(response.message);
                form.reset();
                setTimeout(function() {
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
