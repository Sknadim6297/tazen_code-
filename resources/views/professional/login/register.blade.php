<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Professional Registration Portal">
    <meta name="author" content="Ansonika">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Tazen-Professional register</title>

   <!-- BASE CSS -->
   <link href="{{ asset('frontend/assets/css/bootstrap.min.css') }}" rel="stylesheet">
   <link href="{{ asset('frontend/assets/css/style.css') }}" rel="stylesheet">

   <!-- SPECIFIC CSS -->
   <link href="{{ asset('frontend/assets/css/account.css') }}" rel="stylesheet">

   <!-- YOUR CUSTOM CSS -->
   <link href="{{ asset('frontend/assets/css/custom.css') }}" rel="stylesheet">
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" />
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <style>
		@import url('https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap');

		body {
			font-family: "Poppins";
			background-image: url("https://images.pexels.com/photos/1595385/pexels-photo-1595385.jpeg?cs=srgb&dl=pexels-hillaryfox-1595385.jpg&fm=jpg");
            background-repeat: no-repeat;
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
		}
       .form-step {
        display: none;
     }
    .form-step.active {
        display: block;
    }
	.toast-top-center {
    top: 40px !important;
    left: 50% !important;
    transform: translateX(-50%) !important;
    z-index: 9999 !important;
}
 .heading-style {
        font-size: 20px;
        font-weight: bold;
        color: #333;
        border-bottom: 2px solid #007BFF;
        padding-bottom: 5px;
        display: inline-block;
        margin-bottom: 15px;
		display: flex;
        align-items: center;
        justify-content: center;
    }	
.step-header {
    margin-bottom: 20px;
}
.step-number {
    background-color: #3498db;
    color: white;
    border-radius: 50%;
    height: 32px;
    width: 32px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: bold;
    margin-right: 10px;
}
.step-title {
    font-size: 20px;
    font-weight: 600;
    color: #2c3e50;
	text-align: center;
}
.spinner {
        width: 50px;
        height: 50px;
        position: relative;
    }
    .double-bounce1, .double-bounce2 {
        width: 100%;
        height: 100%;
        border-radius: 50%;
        background-color: #3498db;
        opacity: 0.6;
        position: absolute;
        top: 0;
        left: 0;
        animation: sk-bounce 2.0s infinite ease-in-out;
    }
    .double-bounce2 {
        animation-delay: -1.0s;
        background-color: #2ecc71;
    }
    @keyframes sk-bounce {
        0%, 100% { transform: scale(0.0); }
        50% { transform: scale(1.0); }
    }
    .progress-bar-animated {
        animation: progress-bar-stripes 1s linear infinite;
        background-image: linear-gradient(45deg, rgba(255,255,255,.15) 25%, transparent 25%, transparent 50%, rgba(255,255,255,.15) 50%, rgba(255,255,255,.15) 75%, transparent 75%, transparent);
        background-size: 1rem 1rem;
    }
    @keyframes progress-bar-stripes {
        from { background-position: 1rem 0 }
        to { background-position: 0 0 }
    }
    .form-group {
        position: relative;
        margin-bottom: 15px;
    }
    .form-group input.form-control, .form-group select.form-control, .form-group textarea.form-control {
        padding-left: 40px;
    }
    .form-group textarea.form-control {
        min-height: 80px;
        padding-top: 12px;
        padding-bottom: 12px;
    }
    .form-group i.input-icon {
        position: absolute;
        left: 15px;
        top: 50%;
        transform: translateY(-50%);
        color: #aaa;
        font-size: 18px;
        z-index: 2;
        pointer-events: none;
    }
    .form-group textarea + i.input-icon {
        top: 22px; /* Adjust for textarea vertical alignment if needed */
    }
    .form-group .invalid-feedback {
        display: none;
        color: #dc3545;
        font-size: 14px;
        margin-top: 5px;
    }
    .form-group input.is-invalid, .form-group select.is-invalid, .form-group textarea.is-invalid {
        border-color: #dc3545;
    }

    /* Enhanced File Upload Styles - Mobile Optimized */
    .file-upload-wrapper {
        position: relative;
        display: block;
        margin-bottom: 10px;
    }
    
    .file-upload-input {
        width: 100%;
        height: 80px;
        opacity: 0;
        position: absolute;
        top: 0;
        left: 0;
        cursor: pointer;
        z-index: 10;
        font-size: 16px; /* iOS fix */
        -webkit-appearance: none;
        -moz-appearance: none;
        appearance: none;
    }
    
    .file-upload-label {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding: 20px;
        border: 2px dashed #dee2e6;
        border-radius: 8px;
        cursor: pointer;
        transition: all 0.3s ease;
        background: #f8f9fa;
        min-height: 80px;
        position: relative;
        z-index: 1;
        pointer-events: none; /* Let clicks pass through to input */
    }
    
    .file-upload-wrapper:hover .file-upload-label {
        border-color: #007bff;
        background: #e3f2fd;
    }
    
    .file-upload-label.has-file {
        border-color: #28a745;
        background: #d4edda;
        border-style: solid;
    }
    
    .file-upload-label.error {
        border-color: #dc3545;
        background: #f8d7da;
    }
    
    /* Mobile specific fixes */
    @media (max-width: 768px) {
        .file-upload-input {
            height: 100px;
            font-size: 18px;
        }
        
        .file-upload-label {
            min-height: 100px;
            padding: 25px 15px;
        }
        
        .file-upload-text {
            font-size: 16px !important;
        }
        
        .file-upload-hint {
            font-size: 14px !important;
        }
    }
    
    /* iOS specific fixes */
    @supports (-webkit-overflow-scrolling: touch) {
        .file-upload-input {
            -webkit-appearance: none;
            -webkit-transform: translate3d(0,0,0);
        }
    }
    
    .file-upload-icon {
        font-size: 24px;
        color: #6c757d;
        margin-bottom: 8px;
    }
    
    .file-upload-text {
        font-weight: 500;
        color: #495057;
        margin-bottom: 4px;
    }
    
    .file-upload-hint {
        font-size: 12px;
        color: #6c757d;
    }
    
    .file-preview {
        margin-top: 10px;
    }
    
    .file-preview-item {
        background: #f8f9fa;
        border: 1px solid #dee2e6;
        border-radius: 8px;
        padding: 12px;
        margin: 8px 0;
        display: flex;
        align-items: center;
        gap: 12px;
    }
    
    .file-preview-icon {
        font-size: 24px;
        color: #6c757d;
    }
    
    .file-preview-info {
        flex: 1;
        min-width: 0;
    }
    
    .file-preview-name {
        font-weight: 500;
        color: #212529;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    
    .file-preview-size {
        font-size: 12px;
        color: #6c757d;
    }
    
    .file-preview-remove {
        background: #dc3545;
        color: white;
        border: none;
        border-radius: 4px;
        padding: 4px 8px;
        font-size: 12px;
        cursor: pointer;
    }
    
    .file-preview-remove:hover {
        background: #c82333;
    }
    
    /* Form validation improvements */
    .form-control.is-invalid {
        border-color: #dc3545;
        box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);
    }
    
    .invalid-feedback {
        display: none;
        width: 100%;
        margin-top: 0.25rem;
        font-size: 0.875rem;
        color: #dc3545;
    }
    
    .invalid-feedback.show {
        display: block;
    }
    
    /* Radio button and form styling improvements */
    .form-check-input {
        margin-top: 0.1rem !important;
        margin-right: 0.5rem !important;
        width: 1.25rem !important;
        height: 1.25rem !important;
        vertical-align: middle !important;
        cursor: pointer !important;
    }
    
    .form-check-label {
        cursor: pointer !important;
        padding-left: 0.25rem !important;
        margin-bottom: 0 !important;
        font-weight: 500 !important;
        color: #495057 !important;
    }
    
    .form-check {
        padding-left: 0 !important;
        margin-bottom: 0.5rem !important;
        display: flex !important;
        align-items: center !important;
    }
    
    .form-check-inline {
        display: inline-flex !important;
        align-items: center !important;
        margin-right: 1rem !important;
        margin-bottom: 0.5rem !important;
    }
    
    .id-proof-selection {
        padding: 15px;
        background: #f8f9fa;
        border-radius: 8px;
        border: 1px solid #dee2e6;
        margin-bottom: 15px;
    }
    
    .id-proof-section {
        margin-top: 15px;
        padding: 15px;
        background: #ffffff;
        border: 1px solid #e9ecef;
        border-radius: 8px;
    }

    /* Preview box */
.file-preview {
  border: 1px solid #e9ecef;
  padding: 10px;
  border-radius: 8px;
  background: #fff;
}

/* A single preview item */
.file-preview-item {
  display:flex;
  align-items:center;
  gap:12px;
  padding:8px;
  border-radius:6px;
  border:1px solid #f1f1f1;
  background: linear-gradient(180deg,#fff,#fafafa);
  margin-bottom:8px;
}

/* Thumbnail */
.file-preview-thumb {
  width:64px;
  height:64px;
  object-fit:cover;
  border-radius:6px;
  border:1px solid #e6e6e6;
}

/* File info */
.file-preview-meta {
  flex:1;
  min-width:0;
}

/* Remove button */
.file-preview-remove {
  background:#dc3545;
  color:#fff;
  border:0;
  padding:6px 8px;
  border-radius:6px;
  cursor:pointer;
}
.file-preview-remove:hover { opacity:.9; }

/* Small responsive spacing */
@media (max-width:576px) {
  .file-preview-thumb { width:48px; height:48px; }
}
    </style>
</head>

<body>
	<nav id="menu" class="fake_menu"></nav>
	<div id="register">
        <figure>
            <a href="{{ route('home') }}"><img src="{{ asset('customer-css/assets/images/tazen_logo.png') }}" width="auto" height="100" alt="" class="logo_sticky"></a>
        </figure>
		<div>
			<h2 class="heading-style">Professional Register</h2>
		</div>
        <form id="registerForm" enctype="multipart/form-data" novalidate>
            @csrf
            {{-- Step 1 - Basic Info --}}
            <div class="form-step step-1 active">
                <div class="step-header">
                    <h4 class="step-title">Email Verification</h4>
                </div>
                <div class="form-group">
                    <i class="fa fa-envelope input-icon"></i>
                    <input class="form-control" type="email" id="verify-email" placeholder="Email">
                    <div class="invalid-feedback">Valid email is required.</div>
                </div>
                <div class="form-group text-center">
                    <button type="button" class="btn_1" id="send-otp-btn">Send Verification Code</button>
                </div>
                
                <!-- OTP Verification Section (initially hidden) -->
                <div id="otp-section" style="display: none;">
                    <div class="form-group">
                        <i class="fa fa-key input-icon"></i>
                        <input class="form-control" type="text" name="otp" id="otp" placeholder="Enter 6-digit verification code" maxlength="6">
                        <div class="invalid-feedback">Please enter a valid verification code.</div>
                    </div>
                    <small class="text-muted mb-3 d-block">A verification code has been sent to your email. It will expire in 10 minutes.</small>
                    <div class="form-group text-center">
                        <button type="button" class="btn_1" id="verify-otp-btn">Verify Code</button>
                        <button type="button" class="btn_1 outline" id="resend-otp-btn">Resend Code</button>
                    </div>
                </div>
                
                <!-- Personal Information Section (initially hidden) -->
                <div id="personal-info-section" style="display: none;">
                    <div class="alert alert-success">
                        <i class="fa fa-check-circle"></i> Email verified successfully!
                    </div>
                    
                    <div class="step-header mt-4">
                        <h4 class="step-title">Basic Information</h4>
                    </div>
                    
                    <div class="form-group">
                        <i class="fa fa-user input-icon"></i>
                        <input class="form-control" type="text" name="first_name" placeholder="First Name">
                        <div class="invalid-feedback">First name is required.</div>
                    </div>
                    <div class="form-group">
                        <i class="fa fa-user input-icon"></i>
                        <input class="form-control" type="text" name="last_name" placeholder="Last Name">
                        <div class="invalid-feedback">Last name is required.</div>
                    </div>
                    <div class="form-group">
                        <i class="fa fa-phone input-icon"></i>
                        <input class="form-control" type="text" name="phone" placeholder="Phone Number">
                        <div class="invalid-feedback">Phone number is required.</div>
                    </div>
                    <div class="form-group">
                        <i class="fa fa-lock input-icon"></i>
                        <input class="form-control" type="password" name="password" id="password" placeholder="Password">
                        <div class="invalid-feedback" id="password-error">Password is required.</div>
                    </div>
                    <div class="form-group">
                        <i class="fa fa-lock input-icon"></i>
                        <input class="form-control" type="password" name="password_confirmation" id="password_confirmation" placeholder="Confirm Password">
                        <div class="invalid-feedback" id="confirm-password-error">Passwords do not match.</div>
                    </div>
                </div>
                
                <button type="button" class="btn_1 full-width next-btn" id="step1-next" disabled>Next Step</button>
            </div>
        
            {{-- Step 2 - Professional Info --}}
            <div class="form-step step-2">
                <div class="step-header">
                    <h4 class="step-title">Professional Info</h4>
                </div>

                <!-- Specialization Input -->
                <div class="form-group">
                    <i class="fa fa-briefcase input-icon"></i>
                    <select class="form-control" name="specialization">
                        <option value="">Select Service (What you offer)</option>
                        @foreach($services as $service)
                            <option value="{{ $service->name }}">{{ $service->name }}</option>
                        @endforeach
                    </select>
                    <div class="invalid-feedback">Specialization is required.</div>
                </div>
            
                <!-- Experience Input -->
                <div class="form-group">
                    <i class="fa fa-briefcase input-icon"></i>
                    <select class="form-control" name="experience">
                        <option value="" disabled selected>Select Experience</option>
                        <option value="0-2">0-2 years</option>
                        <option value="2-4">2-4 years</option>
                        <option value="4-6">4-6 years</option>
                        <option value="6-8">6-8 years</option>
                        <option value="8-10">8-10 years</option>
                        <option value="10+">10+ years</option>
                    </select>
                    <div class="invalid-feedback">Experience is required.</div>
                </div>

                <!-- Starting Price Input -->
                <div class="form-group">
                    <i class="fa fa-rupee-sign input-icon"></i>
                    <input class="form-control" type="text" name="starting_price" placeholder="Price per session (e.g., 1000, 1000-2000, 1500)">
                    <div class="invalid-feedback">Starting price is required.</div>
                    <small class="text-muted">You can enter a fixed price (e.g., 1500) or a range (e.g., 1000-2000)</small>
                </div>
                
                <!-- Location Dropdown -->
                <div class="form-group">
                    <i class="fa fa-map-marker-alt input-icon"></i>
                    <select class="form-control" name="address">
                        <option value="">Select Location</option>
                        <option value="Mumbai">Mumbai</option>
                        <option value="Kolkata">Kolkata</option>
                        <option value="Delhi">Delhi</option>
                        <option value="Bangalore">Bangalore</option>
                        <option value="Chennai">Chennai</option>
                        <option value="Hyderabad">Hyderabad</option>
                        <option value="Pune">Pune</option>
                        <option value="Ahmedabad">Ahmedabad</option>
                        <option value="Surat">Surat</option>
                        <option value="Jaipur">Jaipur</option>
                    </select>
                    <div class="invalid-feedback">Location is required.</div>
                </div>
            
                <!-- Education 1 Input -->
                <div class="form-group">
                    <i class="fa fa-graduation-cap input-icon"></i>
                    <input class="form-control" type="text" name="education" placeholder="Education">
                    <div class="invalid-feedback">Education is required.</div>
                </div>
            
                <!-- Education 2 Input (Optional) -->
                <div class="form-group">
                    <i class="fa fa-graduation-cap input-icon"></i>
                    <input class="form-control" type="text" name="education2" placeholder="Additional Education (Optional)">
                </div>
            
                <!-- Bio removed - will be managed in profile section after registration -->

                <!-- Navigation Buttons -->
                <div style="display: flex; gap: 10px;">
                    <button type="button" class="btn_1 full-width prev-btn">Previous</button>
                    <button type="button" class="btn_1 full-width next-btn">Next Step</button>
                </div>
            </div>
            
            {{-- Step 3 - Document Uploads --}}
            <div class="form-step step-3">
                <div class="step-header">
                    <h4 class="step-title">Document Uploads</h4>
                </div>
                <div class="form-group">
                    <label>Qualification Document</label>
                    <div class="file-upload-wrapper">
                        <input class="file-upload-input" type="file" name="qualification_document" id="qualification_document" accept=".jpeg,.jpg,.png,.pdf,.doc,.docx,.txt,.bmp,.gif,.tiff,.webp">
                        <label for="qualification_document" class="file-upload-label">
                            <i class="fas fa-graduation-cap file-upload-icon"></i>
                            <div class="file-upload-text">Upload Qualification Document</div>
                            <div class="file-upload-hint">All formats accepted (Max: 10MB)</div>
                        </label>
                        <div class="file-preview" id="qualification_document_preview" style="display: none;"></div>
                    </div>
                    <div class="invalid-feedback">Qualification document is required.</div>
                </div>
                
                {{-- Single ID Proof Upload Field --}}
                <div class="form-group">
                    <label style="font-weight: 600; color: #333;">ID Proof Document</label>
                    <small class="form-text text-muted mb-3">Upload either Aadhaar Card or PAN Card</small>
                    
                    <div class="file-upload-wrapper">
                        <input class="file-upload-input" type="file" name="id_proof_document" id="id_proof_document" accept=".jpeg,.jpg,.png,.pdf,.doc,.docx,.txt,.bmp,.gif,.tiff,.webp">
                        <label for="id_proof_document" class="file-upload-label">
                            <i class="fas fa-id-card file-upload-icon"></i>
                            <div class="file-upload-text">Upload Aadhaar Card / PAN Card</div>
                            <div class="file-upload-hint">All formats accepted (Max: 10MB)</div>
                        </label>
                        <div class="file-preview" id="id_proof_document_preview" style="display: none;"></div>
                    </div>
                    <div class="invalid-feedback">ID proof document is required.</div>
                </div>
                
                {{-- GST Registration Section --}}
                <div class="form-group">
                    <div class="form-check" style="margin-bottom: 15px;">
                        <input type="checkbox" class="form-check-input" id="has_gst" name="has_gst" style="margin-right: 8px;padding: 0;">
                        <label class="form-check-label" for="has_gst" style="font-weight: 500;">
                            I have GST Registration (Optional)
                        </label>
                    </div>
                    <small class="text-muted">Check this box if you have GST registration and want to provide GST details</small>
                </div>
                
                {{-- GST Fields Container (Initially Hidden) --}}
                <div id="gst-fields-container" style="display: none;">
                    <div class="form-group">
                        <label>GST Number <span style="color: red;">*</span></label>
                        <input class="form-control" type="text" name="gst_number" id="gst_number">
                        <small class="text-muted">Enter your 15-digit GST number (e.g., 27AAAAA0000A1Z5)</small>
                        <div class="invalid-feedback">GST number is required when providing GST details.</div>
                    </div>
                    
                    <div class="form-group">
                        <label>GST State <span style="color: red;">*</span></label>
                        <select class="form-control" name="state_code" id="state_code">
                            <option value="">Select State</option>
                            <option value="01" data-state="Jammu and Kashmir">01 - Jammu and Kashmir</option>
                            <option value="02" data-state="Himachal Pradesh">02 - Himachal Pradesh</option>
                            <option value="03" data-state="Punjab">03 - Punjab</option>
                            <option value="04" data-state="Chandigarh">04 - Chandigarh</option>
                            <option value="05" data-state="Uttarakhand">05 - Uttarakhand</option>
                            <option value="06" data-state="Haryana">06 - Haryana</option>
                            <option value="07" data-state="Delhi">07 - Delhi</option>
                            <option value="08" data-state="Rajasthan">08 - Rajasthan</option>
                            <option value="09" data-state="Uttar Pradesh">09 - Uttar Pradesh</option>
                            <option value="10" data-state="Bihar">10 - Bihar</option>
                            <option value="11" data-state="Sikkim">11 - Sikkim</option>
                            <option value="12" data-state="Arunachal Pradesh">12 - Arunachal Pradesh</option>
                            <option value="13" data-state="Nagaland">13 - Nagaland</option>
                            <option value="14" data-state="Manipur">14 - Manipur</option>
                            <option value="15" data-state="Mizoram">15 - Mizoram</option>
                            <option value="16" data-state="Tripura">16 - Tripura</option>
                            <option value="17" data-state="Meghalaya">17 - Meghalaya</option>
                            <option value="18" data-state="Assam">18 - Assam</option>
                            <option value="19" data-state="West Bengal">19 - West Bengal</option>
                            <option value="20" data-state="Jharkhand">20 - Jharkhand</option>
                            <option value="21" data-state="Odisha">21 - Odisha</option>
                            <option value="22" data-state="Chhattisgarh">22 - Chhattisgarh</option>
                            <option value="23" data-state="Madhya Pradesh">23 - Madhya Pradesh</option>
                            <option value="24" data-state="Gujarat">24 - Gujarat</option>
                            <option value="25" data-state="Daman and Diu">25 - Daman and Diu</option>
                            <option value="26" data-state="Dadra and Nagar Haveli">26 - Dadra and Nagar Haveli</option>
                            <option value="27" data-state="Maharashtra">27 - Maharashtra</option>
                            <option value="28" data-state="Andhra Pradesh">28 - Andhra Pradesh</option>
                            <option value="29" data-state="Karnataka">29 - Karnataka</option>
                            <option value="30" data-state="Goa">30 - Goa</option>
                            <option value="31" data-state="Lakshadweep">31 - Lakshadweep</option>
                            <option value="32" data-state="Kerala">32 - Kerala</option>
                            <option value="33" data-state="Tamil Nadu">33 - Tamil Nadu</option>
                            <option value="34" data-state="Puducherry">34 - Puducherry</option>
                            <option value="35" data-state="Andaman and Nicobar Islands">35 - Andaman and Nicobar Islands</option>
                            <option value="36" data-state="Telangana">36 - Telangana</option>
                            <option value="37" data-state="Andhra Pradesh (New)">37 - Andhra Pradesh (New)</option>
                            <option value="38" data-state="Ladakh">38 - Ladakh</option>
                        </select>
                        <div class="invalid-feedback">GST state is required when providing GST details.</div>
                    </div>
                    
                    <div class="form-group">
                        <label>GST Address <span style="color: red;">*</span></label>
                        <i class="fa fa-map-marker-alt input-icon"></i>
                        <textarea class="form-control" name="gst_address" placeholder="Enter your GST registered address" rows="3"></textarea>
                        <div class="invalid-feedback">GST address is required when providing GST details.</div>
                    </div>
                    
                    <div class="form-group">
                        <label>GST Certificate <span style="color: red;">*</span></label>
                        <div class="file-upload-wrapper">
                            <input class="file-upload-input" type="file" name="gst_certificate" id="gst_certificate" accept=".jpeg,.jpg,.png,.pdf,.doc,.docx,.txt,.bmp,.gif,.tiff,.webp">
                            <label for="gst_certificate" class="file-upload-label">
                                <i class="fas fa-file-invoice file-upload-icon"></i>
                                <div class="file-upload-text">Upload GST Certificate</div>
                                <div class="file-upload-hint">All formats accepted (Max: 10MB)</div>
                            </label>
                            <div class="file-preview" id="gst_certificate_preview" style="display: none;"></div>
                        </div>
                        <div class="invalid-feedback">GST certificate is required when providing GST details.</div>
                    </div>
                </div>
                
                {{-- Profile Photo (Optional) --}}
                <div class="form-group">
                    <label>Profile Photo (Optional)</label>
                    <div class="file-upload-wrapper">
                        <input class="file-upload-input" type="file" name="profile_photo" id="profile_photo" accept=".jpeg,.jpg,.png,.bmp,.gif,.tiff,.webp">
                        <label for="profile_photo" class="file-upload-label">
                            <i class="fas fa-user-circle file-upload-icon"></i>
                            <div class="file-upload-text">Upload Profile Photo</div>
                            <div class="file-upload-hint">Image formats only (Max: 5MB)</div>
                        </label>
                        <div class="file-preview" id="profile_photo_preview" style="display: none;"></div>
                    </div>
                    <small class="text-muted">You can upload your profile photo now or add it later from your profile settings.</small>
                </div>
                
                {{-- Note about Gallery Management --}}
                <div class="alert alert-info" style="margin-top: 20px; background: #e3f2fd; border: 1px solid #90caf9; color: #1565c0; padding: 15px; border-radius: 8px;">
                    <i class="fas fa-info-circle"></i>
                    <strong>Note:</strong> Gallery images will be managed through your professional profile after registration approval.
                </div>

                <div style="display: flex; gap: 10px; margin-top: 10px;">
                    <button type="button" class="btn_1 full-width prev-btn">Previous</button>
                    <button type="submit" class="btn_1 full-width">Submit</button>
                </div>
            </div>
        </form>
        
        <div id="loading-overlay" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.7); z-index: 9999; backdrop-filter: blur(5px);">
            <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); text-align: center; color: white; background-color: rgba(0,0,0,0.6); padding: 30px; border-radius: 12px; box-shadow: 0 10px 30px rgba(0,0,0,0.2); width: 300px;">
                <div class="spinner" style="margin: 0 auto 20px;">
                    <div class="double-bounce1"></div>
                    <div class="double-bounce2"></div>
                </div>
                <h4 style="margin: 0 0 10px; font-size: 18px; font-weight: 500;">Processing Your Registration</h4>
                <p style="margin: 0; opacity: 0.8; font-size: 14px; line-height: 1.4;">Please wait while we upload your documents. This might take a moment.</p>
                <div style="width: 100%; height: 4px; background: rgba(255,255,255,0.2); border-radius: 4px; margin-top: 20px; overflow: hidden;">
                    <div class="progress-bar-animated" style="height: 100%; width: 100%; background: linear-gradient(90deg, #3498db, #2ecc71);"></div>
                </div>
            </div>
        </div>
        
        <div class="copy">© Tazen</div>
	</div>
	<!-- /login -->
	
	<!-- COMMON SCRIPTS -->
    <script src="{{ asset('frontend/assets/js/common_scripts.min.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/common_func.js') }}"></script>
    <script src="{{ asset('frontend/assets/validate.js') }}"></script>
	
	<!-- SPECIFIC SCRIPTS -->
	<script src="{{ asset('frontend/assets/js/pw_strenght.js') }}"></script>	
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script>
        // Enhanced CSRF Token Management and Global Setup
        function refreshCSRFToken() {
            return new Promise((resolve, reject) => {
                $.ajax({
                    url: '/csrf-token',
                    type: 'GET',
                    timeout: 5000,
                    success: function(data) {
                        if (data && data.csrf_token) {
                            $('meta[name="csrf-token"]').attr('content', data.csrf_token);
                            $('input[name="_token"]').val(data.csrf_token);
                            resolve(data.csrf_token);
                        } else {
                            reject('Invalid CSRF token response');
                        }
                    },
                    error: function() {
                        reject('Failed to refresh CSRF token');
                    }
                });
            });
        }

        // Auto-refresh CSRF token every 30 minutes
        setInterval(function() {
            refreshCSRFToken().catch(function(error) {
                console.warn('CSRF token auto-refresh failed:', error);
            });
        }, 30 * 60 * 1000);

        // Global AJAX setup for CSRF
        $.ajaxSetup({
            beforeSend: function(xhr, settings) {
                if (!settings.crossDomain && settings.type !== 'GET') {
                    xhr.setRequestHeader('X-CSRF-TOKEN', $('meta[name="csrf-token"]').attr('content'));
                }
            }
        });
        
        // Enhanced validation functions with better error handling
        function showFieldError(fieldName, message) {
            console.log('Showing field error for:', fieldName, 'Message:', message);
            const $field = $(`[name="${fieldName}"]`);
            
            // Clear any existing error first
            clearFieldError(fieldName);
            
            // Add error styling
            $field.addClass('is-invalid');
            
            // Find or create error message element
            let $feedback = $field.siblings('.invalid-feedback');
            if ($feedback.length === 0) {
                $feedback = $('<div class="invalid-feedback"></div>');
                $field.after($feedback);
            }
            
            $feedback.text(message).addClass('show').show();
            
            // Show user-friendly toast message
            toastr.error(message, 'Validation Error', {
                timeOut: 5000,
                closeButton: true
            });
        }

        function clearFieldError(fieldName) {
            console.log('Clearing field error for:', fieldName);
            const $field = $(`[name="${fieldName}"]`);
            $field.removeClass('is-invalid');
            $field.siblings('.invalid-feedback').removeClass('show').hide();
        }

        function showFileUploadError(fieldName, message) {
            console.log('Showing file upload error for:', fieldName, 'Message:', message);
            const $fileInput = $(`#${fieldName}`);
            const $wrapper = $fileInput.closest('.file-upload-wrapper');
            const $label = $fileInput.siblings('.file-upload-label');
            let $feedback = $fileInput.closest('.form-group').find('.invalid-feedback');
            
            // Clear existing errors
            clearFileUploadError(fieldName);
            
            // Add error styling
            $fileInput.addClass('is-invalid');
            $label.addClass('error');
            
            // Find or create error message element
            if ($feedback.length === 0) {
                $feedback = $('<div class="invalid-feedback"></div>');
                $fileInput.closest('.form-group').append($feedback);
            }
            
            $feedback.text(message).addClass('show').show();
            
            // Show user-friendly toast message
            toastr.error(message, 'File Upload Error', {
                timeOut: 5000,
                closeButton: true
            });
        }

        function clearFileUploadError(fieldName) {
            console.log('Clearing file upload error for:', fieldName);
            const $fileInput = $(`#${fieldName}`);
            const $label = $fileInput.siblings('.file-upload-label');
            const $feedback = $fileInput.closest('.form-group').find('.invalid-feedback');
            
            $fileInput.removeClass('is-invalid');
            $label.removeClass('error');
            $feedback.removeClass('show').hide();
        }

        function getFieldLabel(fieldName) {
            const labels = {
                'qualification_document': 'Qualification Document',
                'id_proof_document': 'ID Proof Document',
                'gst_certificate': 'GST Certificate',
                'profile_photo': 'Profile Photo',
                'gst_number': 'GST Number',
                'state_code': 'GST State',
                'state_name': 'GST State Name',
                'gst_address': 'GST Address',
                'first_name': 'First Name',
                'last_name': 'Last Name',
                'phone': 'Phone Number',
                'password': 'Password',
                'password_confirmation': 'Confirm Password',
                'specialization': 'Specialization',
                'experience': 'Experience',
                'education': 'Education',
                'starting_price': 'Starting Price',
                'address': 'Location'
            };
            return labels[fieldName] || fieldName.replace('_', ' ').replace(/\b\w/g, l => l.toUpperCase());
        }

        // Configure toastr options
        toastr.options = {
            "positionClass": "toast-top-center",
            "timeOut": "3000",
            "closeButton": true,
            "progressBar": true
        };
        
        // Add debugging when page loads
        $(document).ready(function() {
            console.log('Document ready - checking form elements');
            console.log('Form found:', $('#registerForm').length);
            console.log('File inputs found:', $('.file-upload-input').length);
            console.log('File upload labels found:', $('.file-upload-label').length);
            console.log('State code select found:', $('#state_code').length);
            
            // Add mobile device detection
            const isMobile = /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent);
            const isIOS = /iPad|iPhone|iPod/.test(navigator.userAgent);
            const isAndroid = /Android/.test(navigator.userAgent);
            
            console.log('Device detection:', {
                isMobile: isMobile,
                isIOS: isIOS,
                isAndroid: isAndroid,
                userAgent: navigator.userAgent,
                platform: navigator.platform,
                touchSupport: 'ontouchstart' in window
            });
            
            // Test file input functionality
            $('.file-upload-input').each(function(index) {
                const input = this;
                console.log(`File input ${index}: name="${input.name}", id="${input.id}"`, {
                    visible: $(input).is(':visible'),
                    disabled: input.disabled,
                    readonly: input.readOnly,
                    accept: input.accept,
                    position: $(input).css('position'),
                    zIndex: $(input).css('z-index'),
                    opacity: $(input).css('opacity'),
                    dimensions: {
                        width: input.offsetWidth,
                        height: input.offsetHeight,
                        computed: {
                            width: $(input).width(),
                            height: $(input).height()
                        }
                    }
                });
                
                // Check if the input has files attribute
                if (input.files) {
                    console.log(`File input ${input.id} files length:`, input.files.length);
                } else {
                    console.log(`File input ${input.id} does not have files attribute`);
                }
                
                // Test click functionality
                $(input).on('click', function(e) {
                    console.log(`File input ${input.id} clicked`, {
                        event: e.type,
                        target: e.target.id,
                        isTrusted: e.isTrusted
                    });
                });
            });
            
            // Test file upload labels
            $('.file-upload-label').each(function(index) {
                const $input = $(this).siblings('.file-upload-input');
                console.log(`File label ${index} has input:`, $input.length > 0);
                if ($input.length > 0) {
                    console.log(`File label ${index} input id:`, $input.attr('id'));
                }
            });
            
            // Check if state code already has a value and populate state name
            const initialStateCode = $('#state_code').val();
            if (initialStateCode) {
                const selectedOption = $('#state_code').find('option:selected');
                const stateName = selectedOption.data('state');
                if (stateName) {
                    if (!$('#state_name').length) {
                        $('<input>').attr({
                            type: 'hidden',
                            id: 'state_name',
                            name: 'state_name',
                            value: stateName
                        }).appendTo('#registerForm');
                        console.log('Initial state_name hidden field created with value:', stateName);
                    }
                }
            }
        });

        // Form submission handler
        $('#registerForm').submit(function(e) {
            e.preventDefault();
            
            console.log('Form submission started');
            
            // Check if email was verified
            if (!$('#hidden-verified-email').length || !$('#hidden-verified-email').val()) {
                toastr.error('Please verify your email before submitting the form.');
                $('.form-step').removeClass('active');
                $('.step-1').addClass('active');
                return;
            }
            
            console.log('Email verification check passed');
            
            // Validate all steps
            let isFormValid = true;
            
            // Clear all previous errors first
            $('.form-control, .file-upload-input').removeClass('is-invalid');
            $('.invalid-feedback').hide();
            $('.file-upload-label').removeClass('error');
            
            // Validate Step 1 fields
            const step1Fields = ['first_name', 'last_name', 'phone', 'password', 'password_confirmation'];
            step1Fields.forEach(function(fieldName) {
                const $field = $(`[name="${fieldName}"]`);
                const value = $field.length ? String($field.val() || '') : '';

                if (!value || value.trim() === '') {
                    showFieldError(fieldName, `${getFieldLabel(fieldName)} is required.`);
                    isFormValid = false;
                    console.log(`Validation failed for: ${fieldName}`);
                }
            });
            
            // Password confirmation check
            const password = $('[name="password"]').val();
            const confirmPassword = $('[name="password_confirmation"]').val();
            if (password !== confirmPassword) {
                showFieldError('password_confirmation', 'Passwords do not match.');
                isFormValid = false;
                console.log('Password confirmation failed');
            }
            
            // Validate Step 2 fields (education2 and bio are now optional/removed)
            const step2Fields = ['specialization', 'experience', 'starting_price', 'address', 'education'];
            step2Fields.forEach(function(fieldName) {
                const $field = $(`[name="${fieldName}"]`);
                const value = $field.length ? String($field.val() || '') : '';

                if (!value || value.trim() === '') {
                    const fieldLabel = getFieldLabel(fieldName);
                    showFieldError(fieldName, `${fieldLabel} is required.`);
                    isFormValid = false;
                    console.log(`Validation failed for: ${fieldName}`);
                }
            });
            
            // Step 3 validation is now handled conditionally based on GST checkbox
            
            // Validate required file uploads
            const baseRequiredFiles = ['qualification_document', 'id_proof_document'];
            let requiredFiles = [...baseRequiredFiles];
            
            // Add GST certificate to required files only if GST checkbox is checked
            if ($('#has_gst').is(':checked')) {
                requiredFiles.push('gst_certificate');
                console.log('GST fields enabled - GST certificate is required');
            } else {
                console.log('GST fields disabled - GST certificate is optional');
            }
            
            console.log('Validating required files:', requiredFiles);
            
            requiredFiles.forEach(function(fieldName) {
                const fileInput = $(`[name="${fieldName}"]`)[0];
                console.log(`Checking file input for ${fieldName}:`, {
                    inputFound: !!fileInput,
                    inputId: fileInput ? fileInput.id : 'none',
                    inputName: fileInput ? fileInput.name : 'none',
                    filesExists: !!(fileInput && fileInput.files),
                    filesLength: fileInput && fileInput.files ? fileInput.files.length : 0,
                    inputValue: fileInput ? fileInput.value : 'none',
                    inputVisible: fileInput ? $(fileInput).is(':visible') : false,
                    inputDisabled: fileInput ? fileInput.disabled : 'unknown'
                });
                
                if (fileInput && fileInput.files && fileInput.files.length > 0) {
                    const file = fileInput.files[0];
                    console.log(`File details for ${fieldName}:`, {
                        fileName: file.name,
                        fileSize: file.size,
                        fileType: file.type,
                        lastModified: file.lastModified
                    });
                }
                
                if (!fileInput || !fileInput.files || !fileInput.files.length) {
                    const fieldLabel = getFieldLabel(fieldName);
                    showFileUploadError(fieldName, `${fieldLabel} is required.`);
                    isFormValid = false;
                    console.log(`File validation failed for: ${fieldName}`);
                } else {
                    console.log(`File validation passed for: ${fieldName} - ${fileInput.files[0].name}`);
                    clearFileUploadError(fieldName);
                }
            });
            
            // Validate GST fields only if GST checkbox is checked
            if ($('#has_gst').is(':checked')) {
                const gstFields = ['gst_number', 'state_code', 'state_name', 'gst_address'];
                console.log('Validating GST fields:', gstFields);
                
                // Ensure state_name is populated from selected state_code option (if possible)
                try {
                    const $stateSelect = $('#state_code');
                    if ($stateSelect.length) {
                        const selectedState = $stateSelect.find('option:selected').data('state') || '';
                        if (selectedState) {
                            if ($('#state_name').length === 0) {
                                $('<input>').attr({ type: 'hidden', id: 'state_name', name: 'state_name', value: selectedState }).appendTo('#registerForm');
                                console.log('Created state_name hidden field with value:', selectedState);
                            } else {
                                $('#state_name').val(selectedState);
                                console.log('Updated state_name hidden field with value:', selectedState);
                            }
                        }
                    }
                } catch (err) {
                    console.warn('Could not populate state_name from state_code:', err);
                }

                gstFields.forEach(function(fieldName) {
                    const $field = $(`[name="${fieldName}"]`);
                    const value = $field.length ? String($field.val() || '') : '';

                    if (!value || value.trim() === '') {
                        showFieldError(fieldName, `${getFieldLabel(fieldName)} is required when providing GST details.`);
                        isFormValid = false;
                        console.log(`GST validation failed for: ${fieldName}`);
                    } else {
                        clearFieldError(fieldName);
                    }
                });
            } else {
                // Clear any GST validation errors if GST is not selected
                const gstFields = ['gst_number', 'state_code', 'state_name', 'gst_address'];
                gstFields.forEach(function(fieldName) {
                    clearFieldError(fieldName);
                });
                clearFileUploadError('gst_certificate');
            }
            
            if (!isFormValid) {
                // Show user-friendly error message
                toastr.error('Please complete all required fields before submitting.', 'Form Incomplete', {
                    timeOut: 5000,
                    closeButton: true
                });
                
                console.log('Form validation failed');
                
                // Scroll to first error field for better UX
                const $firstError = $('.is-invalid').first();
                if ($firstError.length) {
                    const fieldName = $firstError.attr('name') || $firstError.attr('id');
                    console.log('Scrolling to first error field:', fieldName);
                    
                    // Determine which step the error is in and navigate there
                    let errorStep = 1;
                    if ($firstError.closest('.step-2').length) errorStep = 2;
                    else if ($firstError.closest('.step-3').length) errorStep = 3;
                    
                    // Show the correct step
                    $('.form-step').removeClass('active');
                    $(`.step-${errorStep}`).addClass('active');
                    
                    // Scroll to the error field
                    setTimeout(() => {
                        $('html, body').animate({
                            scrollTop: $firstError.offset().top - 100
                        }, 500);
                    }, 300);
                }
                return;
            }
            
            console.log('All validations passed, submitting form');
            
            // Show loading overlay
            $('#loading-overlay').show();
            
            const formData = new FormData(this);
            
            // Log form data for debugging
            for (let [key, value] of formData.entries()) {
                console.log(key + ': ' + value);
            }

            $.ajax({
                url: "{{ route('professional.register.submit') }}",
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
                },
                success: function(response) {
                    // Hide loading overlay
                    $('#loading-overlay').hide();
                    
                    if (response.status === 'success') {
                        toastr.success(response.message, 'Registration Successful!', {
                            timeOut: 3000,
                            closeButton: true
                        });
                        
                        // Clear all form data
                        $('#registerForm')[0].reset();
                        $('.file-upload-label').removeClass('has-file');
                        $('.file-preview').hide().empty();
                        
                        // Redirect after showing success message
                        setTimeout(function() {
                            if (response.redirect_url) {
                                window.location.href = response.redirect_url;
                            } else {
                                window.location.href = "{{ route('professional.login') }}";
                            }
                        }, 2000);
                    } else {
                        toastr.error(response.message || "Registration failed. Please try again.");
                    }
                },
                error: function(xhr) {
                    // Hide loading overlay
                    $('#loading-overlay').hide();
                    
                    if (xhr.status === 419) {
                        // CSRF token mismatch - refresh and retry
                        refreshCSRFToken().then(function() {
                            toastr.info('Session refreshed. Please try submitting again.');
                        }).catch(function() {
                            toastr.error('Session expired. Please refresh the page and try again.');
                        });
                        return;
                    }
                    
                    if (xhr.responseJSON && xhr.responseJSON.errors) {
                        // Show inline validation errors
                        var errors = xhr.responseJSON.errors;
                        var hasErrors = false;
                        
                        // Clear all previous errors
                        $('.form-control, .file-upload-input').removeClass('is-invalid');
                        $('.invalid-feedback').hide();
                        $('.file-upload-label').removeClass('error');
                        
                        // Show specific field errors with better UX
                        let firstErrorStep = 1;
                        for (var field in errors) {
                            hasErrors = true;
                            var errorMessage = errors[field][0];
                            
                            // Handle file upload fields
                            if (['qualification_document', 'id_proof_document', 'gst_certificate'].includes(field)) {
                                showFileUploadError(field, errorMessage);
                            } else {
                                showFieldError(field, errorMessage);
                            }
                            
                            // Determine which step has the error
                            const $field = $(`[name="${field}"], #${field}`);
                            if ($field.closest('.step-2').length && firstErrorStep === 1) {
                                firstErrorStep = 2;
                            } else if ($field.closest('.step-3').length && firstErrorStep < 3) {
                                firstErrorStep = 3;
                            }
                        }
                        
                        if (hasErrors) {
                            // Navigate to the step with errors
                            $('.form-step').removeClass('active');
                            $(`.step-${firstErrorStep}`).addClass('active');
                            
                            toastr.error('Please fix the validation errors and try again.', 'Validation Failed', {
                                timeOut: 5000,
                                closeButton: true
                            });
                            
                            // Scroll to first error after navigation
                            setTimeout(() => {
                                const $firstError = $('.is-invalid').first();
                                if ($firstError.length) {
                                    $('html, body').animate({
                                        scrollTop: $firstError.offset().top - 100
                                    }, 500);
                                }
                            }, 300);
                        }
                    } else if (xhr.status === 419) {
                        // CSRF token mismatch - more user-friendly message
                        toastr.error('Your session has expired. Please refresh the page and try again.', 'Session Expired', {
                            timeOut: 7000,
                            closeButton: true
                        });
                    } else if (xhr.responseJSON && xhr.responseJSON.message) {
                        toastr.error(xhr.responseJSON.message, 'Registration Error', {
                            timeOut: 5000,
                            closeButton: true
                        });
                    } else {
                        toastr.error('Something went wrong. Please check your internet connection and try again.', 'Error', {
                            timeOut: 5000,
                            closeButton: true
                        });
                    }
                    
                    console.error("Registration error:", xhr);
                }
            });
        });

        // Show toasts for any flash messages
        @if (session('success'))
            toastr.success("{{ session('success') }}");
        @endif

        @if (session('error'))
            toastr.error("{{ session('error') }}");
        @endif

        @if (session('warning'))
            toastr.warning("{{ session('warning') }}");
        @endif

        @if (session('info'))
            toastr.info("{{ session('info') }}");
        @endif
    </script>
    <script>
        $(document).ready(function () {
            let currentStep = 1;

            $('.next-btn').click(function () {
                if (currentStep === 1) {
                    // Check if email is verified first
                    if (!$('#personal-info-section').is(':visible')) {
                        toastr.error('Please verify your email address before proceeding.');
                        return;
                    }
                    
                    // Validate step 1 fields with JavaScript
                    var stepValid = true;
                    var $step = $('.form-step.step-1');
                    
                    // Clear previous errors
                    $step.find('.form-control').removeClass('is-invalid');
                    $step.find('.invalid-feedback').hide();
                    
                    // Validate first name
                    var firstName = $('input[name="first_name"]').val();
                    if (!firstName || firstName.trim() === '') {
                        showFieldError('first_name', 'First name is required.');
                        stepValid = false;
                    }
                    
                    // Validate last name
                    var lastName = $('input[name="last_name"]').val();
                    if (!lastName || lastName.trim() === '') {
                        showFieldError('last_name', 'Last name is required.');
                        stepValid = false;
                    }
                    
                    // Validate phone
                    var phone = $('input[name="phone"]').val();
                    if (!phone || phone.trim() === '') {
                        showFieldError('phone', 'Phone number is required.');
                        stepValid = false;
                    }
                    
                    // Password validation
                    var password = $('#password').val();
                    var confirmPassword = $('#password_confirmation').val();
                    
                    if (!password || password.length < 6) {
                        $('#password').addClass('is-invalid');
                        $('#password-error').text('Password must be at least 6 characters.').show();
                        stepValid = false;
                    }
                    
                    if (!confirmPassword || password !== confirmPassword) {
                        $('#password_confirmation').addClass('is-invalid');
                        $('#confirm-password-error').text('Passwords do not match.').show();
                        stepValid = false;
                    }
                    
                    if (!stepValid) {
                        toastr.error('Please fix the errors before proceeding.');
                        return;
                    }
                }
                
                if (currentStep === 2) {
                    // Validate step 2 fields with JavaScript
                    var stepValid = true;
                    var $step = $('.form-step.step-2');
                    
                    // Clear previous errors
                    $step.find('.form-control').removeClass('is-invalid');
                    $step.find('.invalid-feedback').hide();
                    
                    // Required fields for step 2 (education2 and bio are now optional/removed)
                    var requiredFields = ['specialization', 'experience', 'starting_price', 'address', 'education'];
                    
                    requiredFields.forEach(function(fieldName) {
                        var $field = $(`[name="${fieldName}"]`);
                        var value = $field.val();
                        
                        if (!value || value.trim() === '') {
                            showFieldError(fieldName, `${getFieldLabel(fieldName)} is required.`);
                            stepValid = false;
                        }
                    });
                    
                    if (!stepValid) {
                        toastr.error('Please fill all required fields.');
                        return;
                    }
                }
                
                if (currentStep < 3) {
                    $('.form-step').removeClass('active');
                    currentStep++;
                    $('.step-' + currentStep).addClass('active');
                }
            });

            $('.prev-btn').click(function () {
                if (currentStep > 1) {
                    $('.form-step').removeClass('active');
                    currentStep--;
                    $('.step-' + currentStep).addClass('active');
                }
            });

            // Remove error on input
            $('input, select, textarea').on('input change', function() {
                if ($(this).val()) {
                    clearFieldError($(this).attr('name'));
                }
            });
            
            // Remove error on file selection
            $('.file-upload-input').on('change', function() {
                if (this.files.length > 0) {
                    clearFileUploadError($(this).attr('id'));
                }
            });
        });
    </script>
    <script>
        // OTP Verification Functionality
        $(document).ready(function () {
            var emailVerified = false;
            
            // Handle OTP sending
            $('#send-otp-btn').click(function() {
                var email = $('#verify-email').val();
                
                if (!email || !isValidEmail(email)) {
                    $('#verify-email').addClass('is-invalid');
                    toastr.error('Please enter a valid email address.');
                    return;
                }
                
                // Show loading animation
                $('#send-otp-btn').prop('disabled', true).text('Sending...');
                
                $.ajax({
                    url: "{{ route('professional.send.otp') }}",
                    type: "POST",
                    data: {
                        email: email,
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        if (response.status === 'success') {
                            toastr.success(response.message);
                            $('#otp-section').show();
                            $('#send-otp-btn').text('Code Sent');
                        } else {
                            toastr.error(response.message || 'Failed to send verification code');
                            $('#send-otp-btn').prop('disabled', false).text('Send Verification Code');
                        }
                    },
                    error: function(xhr) {
                        $('#send-otp-btn').prop('disabled', false).text('Send Verification Code');
                        
                        if (xhr.status === 419) {
                            // CSRF token mismatch
                            refreshCSRFToken().then(function() {
                                toastr.info('Session refreshed. Please try sending the code again.');
                            }).catch(function() {
                                toastr.error('Session expired. Please refresh the page and try again.');
                            });
                        } else if (xhr.responseJSON && xhr.responseJSON.errors && xhr.responseJSON.errors.email) {
                            toastr.error(xhr.responseJSON.errors.email[0]);
                        } else if (xhr.responseJSON && xhr.responseJSON.message) {
                            toastr.error(xhr.responseJSON.message);
                        } else {
                            toastr.error('Something went wrong. Please try again.');
                        }
                    }
                });
            });
            
            // Handle OTP verification
            $('#verify-otp-btn').click(function() {
                var otp = $('#otp').val();
                
                if (!otp || otp.length !== 6 || !/^\d+$/.test(otp)) {
                    $('#otp').addClass('is-invalid');
                    toastr.error('Please enter a valid 6-digit verification code.');
                    return;
                }
                
                // Show loading animation
                $('#verify-otp-btn').prop('disabled', true).text('Verifying...');
                
                $.ajax({
                    url: "{{ route('professional.verify.otp') }}",
                    type: "POST",
                    data: {
                        otp: otp,
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        if (response.status === 'success') {
                            toastr.success(response.message);
                            
                            // Mark email as verified and show personal info section
                            emailVerified = true;
                            $('#personal-info-section').show();
                            $('#otp-section').hide();
                            
                            var verifiedEmail = $('#verify-email').val();
                            
                            // Add a hidden input to store the verified email for submission
                            if ($('#hidden-verified-email').length === 0) {
                                $('<input>').attr({
                                    type: 'hidden',
                                    id: 'hidden-verified-email',
                                    name: 'email',
                                    value: verifiedEmail
                                }).appendTo('#registerForm');
                            } else {
                                $('#hidden-verified-email').val(verifiedEmail);
                            }
                            
                            // Lock the email field
                            $('#verify-email').prop('disabled', true);
                            $('#send-otp-btn').prop('disabled', true);
                            
                            // Enable next step button
                            $('#step1-next').prop('disabled', false);
                        } else {
                            toastr.error(response.message || 'Failed to verify code');
                            $('#verify-otp-btn').prop('disabled', false).text('Verify Code');
                        }
                    },
                    error: function(xhr) {
                        $('#verify-otp-btn').prop('disabled', false).text('Verify Code');
                        
                        if (xhr.status === 419) {
                            // CSRF token mismatch
                            refreshCSRFToken().then(function() {
                                toastr.info('Session refreshed. Please try verifying the code again.');
                            }).catch(function() {
                                toastr.error('Session expired. Please refresh the page and try again.');
                            });
                        } else if (xhr.responseJSON && xhr.responseJSON.message) {
                            toastr.error(xhr.responseJSON.message);
                        } else {
                            toastr.error('Something went wrong. Please try again.');
                        }
                    }
                });
            });
            
            // Handle OTP resend
            $('#resend-otp-btn').click(function() {
                $('#send-otp-btn').click();
            });
            
            // Modify the next button to check for email verification
            $('#step1-next').click(function() {
                if (!emailVerified) {
                    toastr.error('Please verify your email address before proceeding.');
                    return false;
                }
                return true;
            });
            
            // Validate email format
            function isValidEmail(email) {
                var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
                return re.test(String(email).toLowerCase());
            }
        });
    </script>
    
    <script>
        /**
         * Enhanced File Upload Handler with Mobile Support
         */
        $(document).ready(function() {
            console.log('Initializing file upload handlers...');
            
            // File upload handler for all file inputs - improved mobile support
            $('.file-upload-input').off('change').on('change', function(e) {
                console.log('File input change detected for:', this.name);
                const input = this;
                const $input = $(input);
                const $label = $input.siblings('.file-upload-label');
                const $preview = $input.siblings('.file-preview');
                const fieldName = input.name.replace('[]', '');
                
                // Clear any previous errors
                clearFileUploadError(fieldName);
                
                // Prevent event bubbling
                e.stopPropagation();
                
                handleFileUpload(input, $label, $preview, fieldName);
            });
            
            // Remove the problematic label click handler that was interfering with file selection
            // The input is now properly positioned over the label to handle clicks natively
            
            // Add touch support for mobile devices
            $('.file-upload-wrapper').on('touchstart', function(e) {
                console.log('Touch detected on file upload wrapper');
                const $input = $(this).find('.file-upload-input');
                if ($input.length) {
                    // Add focus to help mobile browsers recognize the input
                    $input.focus();
                }
            });
            
            // State code selection handler
            $('#state_code').on('change', function() {
                const selectedOption = $(this).find('option:selected');
                const stateName = selectedOption.data('state');
                
                console.log('State code changed:', this.value, 'State name:', stateName);
                
                // Store state name in a hidden field
                if (stateName) {
                    if (!$('#state_name').length) {
                        $('<input>').attr({
                            type: 'hidden',
                            id: 'state_name',
                            name: 'state_name',
                            value: stateName
                        }).appendTo('#registerForm');
                        console.log('Created state_name hidden field with value:', stateName);
                    } else {
                        $('#state_name').val(stateName);
                        console.log('Updated state_name hidden field with value:', stateName);
                    }
                } else {
                    // Clear state name if no state selected
                    if ($('#state_name').length) {
                        $('#state_name').val('');
                        console.log('Cleared state_name hidden field');
                    }
                }
            });
            
            // GST checkbox handler - show/hide GST fields and toggle required attributes
            $('#has_gst').on('change', function() {
                const isChecked = $(this).is(':checked');
                const $gstContainer = $('#gst-fields-container');

                if (isChecked) {
                    $gstContainer.slideDown(300);
                    // Make GST fields required when enabled
                    $('#gst_number').attr('required', true);
                    $('#state_code').attr('required', true);
                    $('#gst_address').attr('required', true);
                    $('#gst_certificate').attr('required', true);

                    console.log('GST fields enabled - all GST fields are now required');
                } else {
                    $gstContainer.slideUp(300);
                    // Clear GST field values when hidden
                    $('#gst_number').val('');
                    $('#state_code').val('');
                    $('#gst_address').val('');
                    $('#gst_certificate').val('');
                    $('#state_name').val('');

                    // Remove required attributes and any validation errors for GST fields
                    $('#gst_number, #state_code, #gst_address, #gst_certificate').removeAttr('required').removeClass('is-invalid');
                    $('#gst-fields-container .invalid-feedback').hide();

                    console.log('GST fields disabled - GST details are optional');
                }
            });

            // Run once on page load to set initial GST fields state based on checkbox
            if ($('#has_gst').length) {
                // Trigger change to ensure visibility/required state is correct for any pre-checked value
                $('#has_gst').trigger('change');
            }
        });
        
        function handleFileUpload(input, $label, $preview, fieldName) {
            console.log('handleFileUpload called for:', fieldName);
            console.log('Input element:', input);
            console.log('Files property:', input.files);
            
            const files = input.files;
            
            if (!files || files.length === 0) {
                console.log('No files selected or files property is null');
                $label.removeClass('has-file');
                $preview.hide().empty();
                
                // Clear any validation errors when file is removed
                clearFileUploadError(fieldName);
                return;
            }
            
            console.log('Files selected:', files.length);
            console.log('File details:', Array.from(files).map(f => ({ name: f.name, size: f.size, type: f.type })));
            
            // Show visual feedback that file is selected
            $label.addClass('has-file');
            $preview.show().empty();
            
            // Clear any previous validation errors
            clearFileUploadError(fieldName);
            
            // Show success toast for mobile users
            toastr.success(`File(s) selected successfully!`, 'Upload Ready');
            
            // Handle multiple files (for gallery)
            if (input.multiple) {
                // Validate total number of files for gallery
                if (files.length > 10) {
                    toastr.error('You can upload maximum 10 gallery images.');
                    input.value = '';
                    $label.removeClass('has-file');
                    $preview.hide().empty();
                    return;
                }
                
                for (let i = 0; i < files.length; i++) {
                    createFilePreview(files[i], $preview, fieldName, i);
                }
            } else {
                createFilePreview(files[0], $preview, fieldName);
            }
            
            // Update label text to show file count
            const $labelText = $label.find('.file-upload-text');
            if (files.length === 1) {
                $labelText.text(`✓ File selected: ${files[0].name}`);
            } else if (files.length > 1) {
                $labelText.text(`✓ ${files.length} files selected`);
            }
            
            console.log('File upload handling completed successfully');
        }
                $labelText.text(`1 file selected: ${files[0].name}`);
            } else if (files.length > 1) {
                $labelText.text(`${files.length} files selected`);
            }
        }
        
        function createFilePreview(file, $preview, fieldName, index = null) {
            console.log('Creating preview for file:', file.name, 'field:', fieldName);
            const fileSize = formatFileSize(file.size);
            const fileName = file.name;
            const fileExt = fileName.split('.').pop().toLowerCase();
            
            // Validate file size - increased limits for all documents
            let maxSize;
            if (fieldName === 'gallery' || fieldName === 'profile_photo') {
                maxSize = 5 * 1024 * 1024; // 5MB for images
            } else {
                maxSize = 10 * 1024 * 1024; // 10MB for documents
            }
            
            if (file.size > maxSize) {
                toastr.error(`File "${fileName}" is too large. Maximum size is ${formatFileSize(maxSize)}.`);
                console.log('File too large:', fileName, file.size);
                return;
            }
            
            // Determine file icon - support for more file types
            let iconClass = 'fas fa-file';
            let iconType = 'file';
            
            if (['jpg', 'jpeg', 'png', 'gif', 'bmp', 'tiff', 'webp'].includes(fileExt)) {
                iconClass = 'fas fa-image';
                iconType = 'image';
            } else if (fileExt === 'pdf') {
                iconClass = 'fas fa-file-pdf';
                iconType = 'pdf';
            } else if (['doc', 'docx'].includes(fileExt)) {
                iconClass = 'fas fa-file-word';
                iconType = 'document';
            } else if (fileExt === 'txt') {
                iconClass = 'fas fa-file-alt';
                iconType = 'text';
            }
            
            const previewId = `preview_${fieldName}_${index || 0}_${Date.now()}`;
            console.log('Generated preview ID:', previewId);
            
            const $previewItem = $(`
                <div class="file-preview-item" id="${previewId}" style="background: #f8f9fa; border: 1px solid #dee2e6; border-radius: 8px; padding: 12px; margin: 8px 0; display: flex; align-items: center; gap: 12px;">
                    <div class="file-preview-icon ${iconType}" style="font-size: 24px; color: #6c757d;">
                        <i class="${iconClass}"></i>
                    </div>
                    <div class="file-preview-info" style="flex: 1; min-width: 0;">
                        <div class="file-preview-name" style="font-weight: 500; color: #212529; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">${fileName}</div>
                        <div class="file-preview-size" style="font-size: 12px; color: #6c757d;">${fileSize}</div>
                    </div>
                    <button type="button" class="file-preview-remove" onclick="removeFilePreview('${previewId}', '${fieldName}')" style="background: #dc3545; color: white; border: none; border-radius: 4px; padding: 4px 8px; font-size: 12px; cursor: pointer;">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            `);
            
            $preview.append($previewItem);
            console.log('Preview item added to preview container');
            
            // Create image preview for image files - support for more image formats
            if (iconType === 'image') {
                const reader = new FileReader();
                reader.onload = function(e) {
                    $previewItem.find('.file-preview-icon').html(`<img src="${e.target.result}" style="width: 32px; height: 32px; object-fit: cover; border-radius: 4px;">`);
                };
                reader.readAsDataURL(file);
            }
        }
        
        function removeFilePreview(previewId, fieldName) {
            console.log('Removing file preview:', previewId, 'for field:', fieldName);
            $(`#${previewId}`).remove();
            
            // Clear the input if no more previews
            const $preview = $(`#${fieldName}_preview`);
            const $fileInput = $(`#${fieldName}`);
            const $label = $fileInput.siblings('.file-upload-label');
            
            if ($preview.children().length === 0) {
                $fileInput.val('');
                $label.removeClass('has-file');
                $preview.hide();
                
                // Reset label text to original
                const originalTexts = {
                    'qualification_document': 'Upload Qualification Document',
                    'id_proof_document': 'Upload Aadhaar Card / PAN Card',
                    'gst_certificate': 'Upload GST Certificate',
                    'profile_photo': 'Upload Profile Photo',
                    'gallery': 'Upload Gallery Images'
                };
                
                const $labelText = $label.find('.file-upload-text');
                if (originalTexts[fieldName]) {
                    $labelText.text(originalTexts[fieldName]);
                }
                
                console.log('File input cleared and label updated');
            }
        }
        
        function formatFileSize(bytes) {
            if (bytes === 0) return '0 Bytes';
            const k = 1024;
            const sizes = ['Bytes', 'KB', 'MB', 'GB'];
            const i = Math.floor(Math.log(bytes) / Math.log(k));
            return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
        }
    </script>
    
    <script>
        /**
         * GST Fields are now optional for professional registrations
         * All GST-related fields (number, address, certificate, state) are required
         */
        $(document).ready(function() {
            // GST fields are now optional - controlled by checkbox
            // If checkbox is checked, all GST fields become mandatory
            console.log('GST fields are optional - checkbox controls visibility and validation');
        });
    </script>
    <script>
        /* Minimal, safe fixes inserted here:
           - Provide a global email validator so other blocks can call isValidEmail without ReferenceError
           - Attach delegated handlers for file inputs and GST checkbox so bindings are reliable even
             if elements are rendered/manipulated later or other scripts rebind events
        */
        (function () {
            // Global email validator
            window.isValidEmail = function(email) {
                if (!email) return false;
                var re = /^(([^<>()\[\]\\.,;:\s@\"]+(\.[^<>()\[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
                return re.test(String(email).toLowerCase());
            };

            // Delegated file input change handler
            $(document).off('change.delegateFileUpload', '.file-upload-input').on('change.delegateFileUpload', '.file-upload-input', function (e) {
                try {
                    var input = this;
                    var $input = $(input);
                    var $label = $input.siblings('.file-upload-label');
                    var $preview = $input.siblings('.file-preview');
                    var fieldName = (input.name || '').replace(/\[\]$/, '');

                    if (!fieldName) fieldName = input.id || 'file';

                    if (typeof clearFileUploadError === 'function') {
                        clearFileUploadError(fieldName);
                    }
                    if (typeof handleFileUpload === 'function') {
                        handleFileUpload(input, $label, $preview, fieldName);
                    } else {
                        console.warn('handleFileUpload not defined yet for', fieldName);
                    }
                } catch (err) {
                    console.error('delegated file upload handler error:', err);
                }
            });

            // Delegated GST toggle handler
            $(document).off('change.delegateGST', '#has_gst').on('change.delegateGST', '#has_gst', function () {
                try {
                    var $chk = $(this);
                    var $gstContainer = $('#gst-fields-container');
                    if ($gstContainer.length === 0) return;

                    if ($chk.is(':checked')) {
                        $gstContainer.slideDown(180);
                        $gstContainer.find('input, select, textarea').attr('required', 'required');
                        $('#gst_certificate').attr('required', 'required');
                    } else {
                        $gstContainer.slideUp(180);
                        $gstContainer.find('input, select, textarea').removeAttr('required');
                        $('#gst_certificate').removeAttr('required');
                        if (typeof clearFileUploadError === 'function') clearFileUploadError('gst_certificate');
                    }
                } catch (err) {
                    console.error('Error toggling GST fields:', err);
                }
            });

            // Apply initial state
            $(function () {
                if ($('#has_gst').length) $('#has_gst').trigger('change');
            });
        })();
    </script>
</body>
</html>