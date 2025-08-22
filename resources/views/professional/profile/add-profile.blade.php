@extends('professional.layout.layout')
@section('styles')
<style>
    :root {
        --primary-color: #3498db;
        --primary-hover: #2980b9;
        --secondary-color: #2c3e50;
        --text-color: #34495e;
        --light-text: #7f8c8d;
        --border-color: #e0e6ed;
        --bg-color: #f7f9fc;
        --card-bg: #ffffff;
        --success-color: #2ecc71;
        --warning-color: #f39c12;
        --danger-color: #e74c3c;
        --shadow-sm: 0 2px 4px rgba(0,0,0,0.05);
        --shadow-md: 0 5px 15px rgba(0,0,0,0.07);
        --shadow-lg: 0 15px 30px rgba(0,0,0,0.1);
        --transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
        --border-radius: 8px;
    }

    body {
        font-family: 'Inter', 'Segoe UI', Roboto, sans-serif;
        color: var(--text-color);
        background-color: var(--bg-color);
    }
    
    /* Content Wrapper */
    .content-wrapper {
        padding: 2rem;
        background-color: var(--bg-color);
        min-height: calc(100vh - 60px);
        transition: var(--transition);
    }

    /* Page Header */
    .page-header {
        margin-bottom: 2rem;
        position: relative;
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 1rem;
    }

    .page-title h3 {
        font-size: 1.75rem;
        font-weight: 700;
        color: var(--secondary-color);
        margin: 0;
        position: relative;
        display: inline-block;
    }

    .page-title h3::after {
        content: "";
        position: absolute;
        bottom: -6px;
        left: 0;
        width: 40px;
        height: 3px;
        background-color: var(--primary-color);
        border-radius: 2px;
    }

   
    /* Breadcrumb */
    .breadcrumb {
        list-style: none;
        padding: 0;
        display: flex;
        gap: 10px;
        font-size: 0.85rem;
        color: var(--light-text);
        margin: 0;
    }

    .breadcrumb li {
        display: flex;
        align-items: center;
    }
    
    .breadcrumb li:not(:last-child)::after {
        content: "/";
        margin-left: 10px;
        color: #bdc3c7;
    }

    .breadcrumb li.active {
        font-weight: 600;
        color: var(--secondary-color);
    }

    /* Form Card */
    .add-profile-form {
        background: var(--card-bg);
        border-radius: var(--border-radius);
        padding: 2rem;
        box-shadow: var(--shadow-md);
        transition: var(--transition);
        border: 1px solid var(--border-color);
    }

    .add-profile-form:hover {
        box-shadow: var(--shadow-lg);
    }

    /* Form Elements */
    .form-group {
        margin-bottom: 1.5rem;
    }

    .form-group label {
        display: block;
        font-weight: 600;
        margin-bottom: 0.5rem;
        color: var(--secondary-color);
        font-size: 0.9rem;
        transition: var(--transition);
    }

    /* Input Fields */
    input[type="text"],
    input[type="email"],
    input[type="tel"],
    input[type="number"],
    textarea {
        width: 100%;
        padding: 0.75rem 1rem;
        border: 1px solid var(--border-color);
        border-radius: var(--border-radius);
        font-size: 0.95rem;
        transition: var(--transition);
        background-color: var(--card-bg);
        color: var(--text-color);
    }

    input[type="text"]:focus,
    input[type="email"]:focus,
    input[type="tel"]:focus,
    input[type="number"]:focus,
    textarea:focus {
        border-color: var(--primary-color);
        outline: none;
        box-shadow: 0 0 0 3px rgba(52, 152, 219, 0.15);
    }

    input[type="text"]::placeholder,
    input[type="email"]::placeholder,
    input[type="tel"]::placeholder,
    input[type="number"]::placeholder,
    textarea::placeholder {
        color: #aab2bd;
    }

    /* File Upload Styling */
    input[type="file"] {
        width: 100%;
        padding: 0.75rem 1rem;
        border: 1px dashed var(--border-color);
        border-radius: var(--border-radius);
        background-color: rgba(52, 152, 219, 0.03);
        font-size: 0.9rem;
        cursor: pointer;
        transition: var(--transition);
    }

    input[type="file"]:hover {
        border-color: var(--primary-color);
        background-color: rgba(52, 152, 219, 0.05);
    }

    /* Custom file input */
    .file-input-wrapper {
        position: relative;
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        gap: 0.5rem;
        margin-top: 0.5rem;
    }

    /* Image Preview */
    .image-preview {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        margin-top: 10px;
    }

    .image-preview img {
        border-radius: var(--border-radius);
        box-shadow: var(--shadow-sm);
        transition: var(--transition);
        max-width: 100px;
        object-fit: cover;
        border: 2px solid transparent;
    }

    .image-preview img:hover {
        transform: scale(1.05);
        box-shadow: var(--shadow-md);
        border-color: var(--primary-color);
    }

    .image-preview a {
        display: inline-block;
        padding: 5px 10px;
        background-color: rgba(52, 152, 219, 0.1);
        color: var(--primary-color);
        border-radius: var(--border-radius);
        font-size: 0.8rem;
        text-decoration: none;
        transition: var(--transition);
    }

    .image-preview a:hover {
        background-color: rgba(52, 152, 219, 0.2);
    }

    /* Grid Layout */
    .form-group.col-2 {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 1.5rem;
    }

    .form-group.col-full {
        width: 100%;
    }

    /* Button */
    .btn-primary {
        background-color: var(--primary-color);
        border: none;
        padding: 0.85rem 1.5rem;
        color: white;
        border-radius: var(--border-radius);
        font-weight: 600;
        font-size: 0.95rem;
        cursor: pointer;
        transition: var(--transition);
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        position: relative;
        overflow: hidden;
        box-shadow: 0 4px 6px rgba(52, 152, 219, 0.2);
    }

    .btn-primary:hover {
        background-color: var(--primary-hover);
        transform: translateY(-2px);
        box-shadow: 0 6px 10px rgba(52, 152, 219, 0.3);
    }

    .btn-primary:active {
        transform: translateY(0);
    }

    .btn-primary i {
        font-size: 0.9rem;
    }

    /* Button Animation */
    .btn-primary::before {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        width: 0;
        height: 0;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
        transform: translate(-50%, -50%);
        transition: width 0.6s ease-out, height 0.6s ease-out;
    }

    .btn-primary:hover::before {
        width: 300px;
        height: 300px;
    }

    /* Form Sections */
    .form-section {
        border-bottom: 1px solid var(--border-color);
        padding-bottom: 1.5rem;
        margin-bottom: 1.5rem;
    }

    .form-section:last-child {
        border-bottom: none;
        padding-bottom: 0;
        margin-bottom: 0;
    }

    .form-section-title {
        font-size: 1.1rem;
        font-weight: 600;
        color: var(--secondary-color);
        margin-bottom: 1rem;
        padding-bottom: 0.5rem;
        border-bottom: 1px solid var(--border-color);
    }

    /* Loading State */
    .btn-loading {
        position: relative;
        pointer-events: none;
    }

    .btn-loading::after {
        content: '';
        position: absolute;
        width: 16px;
        height: 16px;
        top: calc(50% - 8px);
        left: calc(50% - 8px);
        border: 2px solid rgba(255, 255, 255, 0.3);
        border-top-color: white;
        border-radius: 50%;
        animation: rotate 0.8s linear infinite;
    }

    @keyframes rotate {
        from {
            transform: rotate(0deg);
        }
        to {
            transform: rotate(360deg);
        }
    }

    /* Form Feedback / Validation */
    .form-control-feedback {
        font-size: 0.8rem;
        margin-top: 0.25rem;
        display: none;
    }

    .is-invalid {
        border-color: var(--danger-color) !important;
    }

    .is-invalid + .form-control-feedback {
        display: block;
        color: var(--danger-color);
    }

    .is-valid {
        border-color: var(--success-color) !important;
    }

    .is-valid + .form-control-feedback {
        display: block;
        color: var(--success-color);
    }

    /* Animations */
    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .fade-in {
        animation: fadeIn 0.3s ease forwards;
    }

    /* Form Field Focus Effect */
    .form-group:has(input:focus) label,
    .form-group:has(textarea:focus) label {
        color: var(--primary-color);
    }

    /* Responsive Design */
    @media (max-width: 992px) {
        .content-wrapper {
            padding: 1.5rem;
        }
        
        .add-profile-form {
            padding: 1.5rem;
        }
    }

    @media (max-width: 768px) {
        .form-group.col-2 {
            grid-template-columns: 1fr;
            gap: 1rem;
        }
        
        .page-header {
            flex-direction: column;
            align-items: flex-start;
        }
    }

    @media (max-width: 576px) {
        .content-wrapper {
            padding: 1rem;
        }
        
        .add-profile-form {
            padding: 1.25rem;
        }
        
        .page-title h3 {
            font-size: 1.5rem;
        }
    }

    /* Dark Mode Support (Optional) */
    @media (prefers-color-scheme: dark) {
        :root {
            --bg-color: #121212;
            --card-bg: #1e1e1e;
            --text-color: #e4e6eb;
            --light-text: #b0b3b8;
            --border-color: #2a2a2a;
            --secondary-color: #e4e6eb;
        }
        
        input[type="text"],
        input[type="email"],
        input[type="tel"],
        input[type="number"],
        textarea {
            background-color: #242424;
        }
        
        input[type="file"] {
            background-color: rgba(52, 152, 219, 0.1);
        }
    }



    /* Add these styles for the gallery image deletion feature */
    .gallery-image-container {
        position: relative;
        display: inline-block;
        margin-right: 10px;
        margin-bottom: 10px;
    }

    .delete-image-btn {
        position: absolute;
        top: -8px;
        right: -8px;
        width: 20px;
        height: 20px;
        border-radius: 50%;
        background-color: var(--danger-color);
        color: white;
        border: 1px solid white;
        font-size: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        padding: 0;
        box-shadow: var(--shadow-sm);
        transition: var(--transition);
        opacity: 0.8;
        z-index: 5;
    }

    .delete-image-btn:hover {
        opacity: 1;
        transform: scale(1.1);
        box-shadow: var(--shadow-md);
    }

    /* Animation for image removal */
    @keyframes fadeOut {
        from {
            opacity: 1;
            transform: scale(1);
        }
        to {
            opacity: 0;
            transform: scale(0.8);
        }
    }

    .fade-out {
        animation: fadeOut 0.3s ease forwards;
    }

    /* New image preview styling */
    .new-image-preview {
        position: relative;
        display: inline-block;
        margin-right: 10px;
        margin-bottom: 10px;
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

    <div class="add-profile-form fade-in">
        <form id="profileForm">
            @csrf
            <div class="form-section">
                <h4 class="form-section-title">Profile Information</h4>
                <div class="form-group col-full">
                    <label for="photo">Profile Photo</label>
                    <input type="file" id="photo" name="photo" accept="image/*">
                    <div class="file-input-wrapper">
                        @if($profile->photo)
                            <div class="image-preview">
                                <img src="{{ $profile->photo ? asset('storage/'.$profile->photo) : asset('default.jpg') }}" alt="Current Photo" width="100">
                            </div>
                        @else
                            <div class="image-preview">
                                <img src="{{ asset('default.jpg') }}" alt="Default Photo" width="100">
                            </div>
                        @endif
                    </div>
                </div>
                <div class="form-group col-full">
                    <label for="gallery">Gallery Images (Multiple)</label>
                    <input type="file" id="gallery" name="gallery[]" accept="image/*" multiple>
                    <div class="file-input-wrapper">
                        @if($profile->gallery)
                            <div class="image-preview">
                                @php
                                    $gallery = is_array($profile->gallery) ? $profile->gallery : json_decode($profile->gallery, true);
                                    // Ensure $gallery is an array, fallback to empty array if null or invalid
                                    $gallery = is_array($gallery) ? $gallery : [];
                                @endphp
                                @if(!empty($gallery))
                                    @foreach($gallery as $index => $img)
                                        <div class="gallery-image-container" id="gallery-image-{{ $index }}">
                                            <button type="button" class="delete-image-btn" data-path="{{ $img }}">
                                                <i class="fas fa-times"></i>
                                            </button>
                                            <img src="{{ asset('storage/'.$img) }}" alt="Gallery Image" width="80">
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        @endif
                    </div>
                    <!-- Hidden input to store deleted image paths -->
                    <input type="hidden" name="deleted_images" id="deleted_images" value="">
                </div>
                <div class="form-group col-2">
                    <div>
                        <label for="Name">Name</label>
                        <input type="text" id="name" name="name" value="{{ old('name', $profile->professional->name ?? 'N/A' ) }}" required>
                        <div class="form-control-feedback"></div>
                    </div>
                    <div>
                        <label for="email">Email Address</label>
                        <input type="email" id="email" name="email" value="{{ old('email', $profile->email) }}" required>
                        <div class="form-control-feedback"></div>
                    </div>
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
            </div>
            
            <div class="form-section">
                <h4 class="form-section-title">Professional Details</h4>
                <div class="form-group col-2">
                    <div>
                        <label for="experience">Years of Experience</label>
                        <input type="text" id="experience" name="experience" value="{{ old('experience', $profile->experience) }}">
                    </div>
                    <div>
                        <label for="startingPrice">Starting Price (e.g., 5000 or 5000-8000)</label>
                        <input type="text" id="startingPrice" name="startingPrice" value="{{ old('startingPrice', $profile->starting_price) }}" placeholder="Price per session (e.g., 1000, 1000-2000, 1500)">
                    </div>
                </div>
                <div class="form-group col-full">
                    <label for="address">Address</label>
                    <textarea id="address" name="address" rows="3">{{ old('address', $profile->address) }}</textarea>
                </div>
                <div class="form-group col-full">
                    <label for="education">Education Details</label>
                    <textarea id="education" name="education" rows="3">{{ old('education', $profile->education) }}</textarea>
                </div>
            </div>
            
            <div class="form-section">
                <h4 class="form-section-title">GST Information (Optional)</h4>
                <div class="form-group col-2">
                    <div>
                        <label for="gst_number">GST Number</label>
                        <input type="text" id="gst_number" name="gst_number" value="{{ old('gst_number', $profile->gst_number) }}">
                        <small class="text-muted">Optional: Enter your GST number if applicable</small>
                    </div>
                    <div class="gst-certificate-group" style="{{ $profile->gst_number ? 'display: block;' : 'display: none;' }}">
                        <label for="gst_certificate">GST Certificate</label>
                        <input type="file" id="gst_certificate" name="gst_certificate" accept=".pdf,.jpg,.jpeg,.png">
                        <div class="file-input-wrapper">
                            @if($profile->gst_certificate)
                                <a href="{{ asset('storage/'.$profile->gst_certificate) }}" target="_blank">View GST Certificate</a>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="form-group col-full">
                    <label for="gst_address">GST Address</label>
                    <textarea id="gst_address" name="gst_address" rows="3" placeholder="GST Address (Optional)">{{ old('gst_address', $profile->gst_address) }}</textarea>
                    <small class="text-muted">Optional: Enter your GST registered address</small>
                </div>
                <div class="form-group col-2">
                    <div>
                        <label for="state_code">State Code</label>
                        <select id="state_code" name="state_code">
                            <option value="">Select State (Optional)</option>
                            @php
                                $selectedStateCode = old('state_code', $profile->state_code ?? '');
                            @endphp
                            <option value="01" data-state="Jammu and Kashmir" {{ $selectedStateCode == '01' ? 'selected' : '' }}>01 - Jammu and Kashmir</option>
                            <option value="02" data-state="Himachal Pradesh" {{ $selectedStateCode == '02' ? 'selected' : '' }}>02 - Himachal Pradesh</option>
                            <option value="03" data-state="Punjab" {{ $selectedStateCode == '03' ? 'selected' : '' }}>03 - Punjab</option>
                            <option value="04" data-state="Chandigarh" {{ $selectedStateCode == '04' ? 'selected' : '' }}>04 - Chandigarh</option>
                            <option value="05" data-state="Uttarakhand" {{ $selectedStateCode == '05' ? 'selected' : '' }}>05 - Uttarakhand</option>
                            <option value="06" data-state="Haryana" {{ $selectedStateCode == '06' ? 'selected' : '' }}>06 - Haryana</option>
                            <option value="07" data-state="Delhi" {{ $selectedStateCode == '07' ? 'selected' : '' }}>07 - Delhi</option>
                            <option value="08" data-state="Rajasthan" {{ $selectedStateCode == '08' ? 'selected' : '' }}>08 - Rajasthan</option>
                            <option value="09" data-state="Uttar Pradesh" {{ $selectedStateCode == '09' ? 'selected' : '' }}>09 - Uttar Pradesh</option>
                            <option value="10" data-state="Bihar" {{ $selectedStateCode == '10' ? 'selected' : '' }}>10 - Bihar</option>
                            <option value="11" data-state="Sikkim" {{ $selectedStateCode == '11' ? 'selected' : '' }}>11 - Sikkim</option>
                            <option value="12" data-state="Arunachal Pradesh" {{ $selectedStateCode == '12' ? 'selected' : '' }}>12 - Arunachal Pradesh</option>
                            <option value="13" data-state="Nagaland" {{ $selectedStateCode == '13' ? 'selected' : '' }}>13 - Nagaland</option>
                            <option value="14" data-state="Manipur" {{ $selectedStateCode == '14' ? 'selected' : '' }}>14 - Manipur</option>
                            <option value="15" data-state="Mizoram" {{ $selectedStateCode == '15' ? 'selected' : '' }}>15 - Mizoram</option>
                            <option value="16" data-state="Tripura" {{ $selectedStateCode == '16' ? 'selected' : '' }}>16 - Tripura</option>
                            <option value="17" data-state="Meghalaya" {{ $selectedStateCode == '17' ? 'selected' : '' }}>17 - Meghalaya</option>
                            <option value="18" data-state="Assam" {{ $selectedStateCode == '18' ? 'selected' : '' }}>18 - Assam</option>
                            <option value="19" data-state="West Bengal" {{ $selectedStateCode == '19' ? 'selected' : '' }}>19 - West Bengal</option>
                            <option value="20" data-state="Jharkhand" {{ $selectedStateCode == '20' ? 'selected' : '' }}>20 - Jharkhand</option>
                            <option value="21" data-state="Odisha" {{ $selectedStateCode == '21' ? 'selected' : '' }}>21 - Odisha</option>
                            <option value="22" data-state="Chhattisgarh" {{ $selectedStateCode == '22' ? 'selected' : '' }}>22 - Chhattisgarh</option>
                            <option value="23" data-state="Madhya Pradesh" {{ $selectedStateCode == '23' ? 'selected' : '' }}>23 - Madhya Pradesh</option>
                            <option value="24" data-state="Gujarat" {{ $selectedStateCode == '24' ? 'selected' : '' }}>24 - Gujarat</option>
                            <option value="25" data-state="Daman and Diu" {{ $selectedStateCode == '25' ? 'selected' : '' }}>25 - Daman and Diu</option>
                            <option value="26" data-state="Dadra and Nagar Haveli" {{ $selectedStateCode == '26' ? 'selected' : '' }}>26 - Dadra and Nagar Haveli</option>
                            <option value="27" data-state="Maharashtra" {{ $selectedStateCode == '27' ? 'selected' : '' }}>27 - Maharashtra</option>
                            <option value="28" data-state="Andhra Pradesh" {{ $selectedStateCode == '28' ? 'selected' : '' }}>28 - Andhra Pradesh</option>
                            <option value="29" data-state="Karnataka" {{ $selectedStateCode == '29' ? 'selected' : '' }}>29 - Karnataka</option>
                            <option value="30" data-state="Goa" {{ $selectedStateCode == '30' ? 'selected' : '' }}>30 - Goa</option>
                            <option value="31" data-state="Lakshadweep" {{ $selectedStateCode == '31' ? 'selected' : '' }}>31 - Lakshadweep</option>
                            <option value="32" data-state="Kerala" {{ $selectedStateCode == '32' ? 'selected' : '' }}>32 - Kerala</option>
                            <option value="33" data-state="Tamil Nadu" {{ $selectedStateCode == '33' ? 'selected' : '' }}>33 - Tamil Nadu</option>
                            <option value="34" data-state="Puducherry" {{ $selectedStateCode == '34' ? 'selected' : '' }}>34 - Puducherry</option>
                            <option value="35" data-state="Andaman and Nicobar Islands" {{ $selectedStateCode == '35' ? 'selected' : '' }}>35 - Andaman and Nicobar Islands</option>
                            <option value="36" data-state="Telangana" {{ $selectedStateCode == '36' ? 'selected' : '' }}>36 - Telangana</option>
                            <option value="37" data-state="Andhra Pradesh (New)" {{ $selectedStateCode == '37' ? 'selected' : '' }}>37 - Andhra Pradesh (New)</option>
                            <option value="38" data-state="Ladakh" {{ $selectedStateCode == '38' ? 'selected' : '' }}>38 - Ladakh</option>
                        </select>
                        <small class="text-muted">Select your state for GST registration (if applicable)</small>
                    </div>
                    <div>
                        <label for="state_name">State Name</label>
                        <input type="text" id="state_name" name="state_name" value="{{ old('state_name', $profile->state_name) }}" readonly placeholder="Auto-filled based on state code">
                        <small class="text-muted">This field is auto-filled when you select a state code</small>
                    </div>
                </div>
            </div>
            
            <div class="form-section">
                <h4 class="form-section-title">Documents</h4>
                <div class="form-group col-full">
                    <label for="qualificationDocument">Qualification Document</label>
                    <input type="file" id="qualificationDocument" name="qualificationDocument" accept=".pdf,.doc,.docx,image/*">
                    <div class="file-input-wrapper">
                        @if($profile->qualification_document)
                            <a href="{{ asset('storage/'.$profile->qualification_document) }}" target="_blank">View Document</a>
                        @endif
                    </div>
                </div>
                <div class="form-group col-2">
                    <div>
                        <label for="idProofDocument">ID Proof Document (Aadhaar / PAN Card)</label>
                        <input type="file" id="idProofDocument" name="idProofDocument" accept=".pdf,.jpg,.jpeg,.png">
                        <div class="file-input-wrapper">
                            @if($profile->id_proof_document)
                                <a href="{{ asset('storage/'.$profile->id_proof_document) }}" target="_blank">View ID Proof</a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="form-section">
                <h4 class="form-section-title">Additional Information</h4>
                <div class="form-group col-full">
                    <label for="comments">Additional Comments</label>
                    <textarea id="comments" name="comments" rows="3">{{ old('comments', $profile->comments) }}</textarea>
                </div>
                <div class="form-group col-full">
                    <label for="bio">Bio</label>
                    <textarea id="bio" name="bio" rows="4">{{ old('bio', $profile->bio) }}</textarea>
                </div>
            </div>
            
            <div class="form-group col-full">
                <button type="submit" id="submitBtn" class="btn btn-primary"><i class="fas fa-save"></i> Save Profile</button>
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
// Array to store deleted image paths
const deletedImages = [];

// Handle delete button click
$(document).on('click', '.delete-image-btn', function() {
    const imagePath = $(this).data('path');
    const container = $(this).closest('.gallery-image-container');
    
    // Add confirmation dialog
    if (confirm('Are you sure you want to delete this image?')) {
        // Add fade-out animation
        container.addClass('fade-out');
        
        // Add the image path to the deleted images array
        deletedImages.push(imagePath);
        
        // Update the hidden input with deleted images
        $('#deleted_images').val(JSON.stringify(deletedImages));
        
        // Remove the element after animation
        setTimeout(() => {
            container.remove();
        }, 300);
    }
});

// Handle form submission
$('#profileForm').submit(function(e) {
    e.preventDefault();
    let form = this;
    let formData = new FormData(form);
    formData.append('_method', 'PUT');
    
    // Add the deleted images to formData if any
    if (deletedImages.length > 0) {
        formData.set('deleted_images', JSON.stringify(deletedImages));
    }
    
    // Add loading state
    $('#submitBtn').addClass('btn-loading').html('');
    
    // Reset validation state
    $('.is-invalid').removeClass('is-invalid');
    $('.form-control-feedback').text('');

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
            console.log(response);
            
            if (response.status === 'success') {
                toastr.success(response.message);
                
                // Show success animation
                $('.add-profile-form').addClass('fade-in');
                
                setTimeout(function() {
                    window.location.href = "{{ route('professional.profile.index') }}";
                }, 1500);
            } else {
                toastr.error(response.message || "Something went wrong");
                $('#submitBtn').removeClass('btn-loading').html('<i class="fas fa-save"></i> Save Profile');
            }
        },
        error: function(xhr) {
            $('#submitBtn').removeClass('btn-loading').html('<i class="fas fa-save"></i> Save Profile');
            
            if (xhr.status === 422) {
                let errors = xhr.responseJSON.errors;
                $.each(errors, function(key, value) {
                    toastr.error(value[0]);
                    
                    // Add validation styling
                    $('#' + key).addClass('is-invalid');
                    $('#' + key).next('.form-control-feedback').text(value[0]);
                });
            } else {
                toastr.error(xhr.responseJSON.message || "An unexpected error occurred");
            }
        }
    });
});

// Update file input preview functionality for gallery images
$('#gallery').change(function(e) {
    const fileInput = $(this);
    let previewContainer = fileInput.next('.file-input-wrapper').find('.image-preview');
    
    if (!previewContainer.length) {
        fileInput.next('.file-input-wrapper').append('<div class="image-preview"></div>');
        previewContainer = fileInput.next('.file-input-wrapper').find('.image-preview');
    }
    
    if (this.files && this.files.length > 0) {
        // For each file, create a preview with delete button
        for (let i = 0; i < this.files.length; i++) {
            const file = this.files[i];
            
            if (file.type.match('image.*')) {
                const reader = new FileReader();
                const uniqueId = 'new-img-' + Date.now() + '-' + i;
                
                reader.onload = function(e) {
                    const newImage = `
                        <div class="new-image-preview" id="${uniqueId}">
                            <button type="button" class="delete-image-btn" data-id="${uniqueId}">
                                <i class="fas fa-times"></i>
                            </button>
                            <img src="${e.target.result}" alt="New image" width="80">
                        </div>
                    `;
                    previewContainer.append(newImage);
                };
                
                reader.readAsDataURL(file);
            }
        }
    }
});

// Handle delete button for newly uploaded images
$(document).on('click', '.new-image-preview .delete-image-btn', function() {
    const containerId = $(this).data('id');
    const $container = $('#' + containerId);
    
    $container.addClass('fade-out');
    setTimeout(() => {
        $container.remove();
    }, 300);
});

// Rest of your existing JS code...

// Add form field validation on blur
$('input, textarea').blur(function() {
    const input = $(this);
    
    if (input.attr('required') && !input.val().trim()) {
        input.addClass('is-invalid');
        input.next('.form-control-feedback').text('This field is required');
    } else {
        input.removeClass('is-invalid');
        
        // Special validation for starting price
        if (input.attr('name') === 'startingPrice' && input.val().trim()) {
            const startingPrice = input.val().trim();
            const pricePattern = /^(\d+(\.\d{1,2})?(-\d+(\.\d{1,2})?)?)$/;
            
            if (!pricePattern.test(startingPrice)) {
                input.addClass('is-invalid');
                input.next('.form-control-feedback').text('Please enter a valid price (e.g., 1000 or 1000-2000)');
                return;
            }
        }
        
        if (input.val().trim()) {
            input.addClass('is-valid');
        } else {
            input.removeClass('is-valid');
        }
    }
});

// Add smooth scroll to sections
$('.form-section-title').click(function() {
    $(this).next().slideToggle(300);
});

// Add entrance animations
$(document).ready(function() {
    $('.form-section').each(function(index) {
        $(this).css({
            'animation-delay': (index * 0.1) + 's',
            'animation': 'fadeIn 0.5s ease forwards'
        });
    });
    
    // GST Number and Certificate Handler
    $('#gst_number').on('input', function() {
        var gstNumber = $(this).val().trim();
        if (gstNumber) {
            $('.gst-certificate-group').slideDown();
            $('#gst_certificate').attr('required', false); // Optional unless GST number is provided
        } else {
            $('.gst-certificate-group').slideUp();
            $('#gst_certificate').attr('required', false);
        }
    });
});
</script>
@endsection