<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Tazen - Professional Register</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" />
    <link href="{{ asset('frontend/assets/css/rejectpro.css') }}" rel="stylesheet"> 
    <style>
        /* Disable HTML5 validation tooltips and use JavaScript validation only */
        input:invalid,
        select:invalid,
        textarea:invalid {
            box-shadow: none !important;
            border: 1px solid #ced4da !important;
        }
        
        input:focus:invalid,
        select:focus:invalid,
        textarea:focus:invalid {
            box-shadow: none !important;
            border-color: #80bdff !important;
        }

        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap');

    body {
        font-family: 'Poppins', sans-serif;
        background: linear-gradient(135deg, #ff4400b3, #cd952d, #d0be5b, #3776b5);
        background-size: 300% 300%;
        animation: gradientFlow 10s ease infinite;
        margin: 0;
        padding: 0;
    }

    @keyframes gradientFlow {
        0% { background-position: 0% 50%; }
        50% { background-position: 100% 50%; }
        100% { background-position: 0% 50%; }
    }

    .custom-modal {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(15, 15, 15, 0.6);
    backdrop-filter: blur(6px);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 9999;
}

.custom-modal-content {
    background: rgba(255, 255, 255, 0.95);
    border-radius: 16px;
    padding: 40px 30px;
    max-width: 500px;
    width: 90%;
    text-align: center;
    position: relative;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
    animation: slideDownFade 0.4s ease-out;
}

.modal-icon {
    font-size: 50px;
    color: #ff4d4d;
    margin-bottom: 10px;
}

.custom-modal-content h2 {
    font-size: 24px;
    color: #333;
    margin-bottom: 10px;
}

.rejection-reason {
    font-size: 16px;
    color: #555;
    margin-bottom: 20px;
    padding: 0 10px;
}

.resubmit-hint {
    font-size: 14px;
    color: #888;
    margin-bottom: 20px;
}

.resubmit-btn {
    padding: 10px 25px;
    background: #007bff;
    color: white;
    border: none;
    border-radius: 25px;
    font-size: 16px;
    cursor: pointer;
    transition: background 0.3s;
}

.resubmit-btn:hover {
    background: #0056b3;
}

.close-btn {
    position: absolute;
    top: 12px;
    right: 15px;
    font-size: 18px;
    color: #888;
    background: none;
    border: none;
    cursor: pointer;
}

@keyframes slideDownFade {
    from {
        transform: translateY(-30px);
        opacity: 0;
    }
    to {
        transform: translateY(0);
        opacity: 1;
    }
}

.btn{
    background-color: #0056b3;
    padding: 5px;
    border: none;
    border-radius: 5px;
    margin-bottom: 5px;
}
 
.btn a{
    text-decoration: none;
    color: white;
}

    /* Add these new styles */
    .step-logo {
        text-align: center;
        margin-bottom: 20px;
    }

    .step-logo img {
        max-width: 150px;
        height: auto;
    }

    .form-step {
        display: none;
    }

    .form-step.active {
        display: block;
    }

    .step-header {
        text-align: center;
        margin-bottom: 30px;
    }

    .step-header h4 {
        color: #333;
        font-size: 20px;
        margin-top: 15px;
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

    </style>
</head>

<body>
    <nav id="menu" class="fake_menu"></nav>

    <div id="login">
        <aside>
            <div class="step-logo">
                <img src="{{ asset('customer-css/assets/images/tazen_logo.png') }}" alt="Tazen Logo">
            </div>
            <h2 style="text-align: center">Update Your Details</h2>
            <div class="alert alert-info" style="background: #e3f2fd; border: 1px solid #90caf9; color: #1565c0; padding: 15px; border-radius: 8px; margin-bottom: 20px; text-align: center;">
                <i class="fas fa-info-circle"></i>
                <strong>Note:</strong> You only need to update the fields or upload new documents that were mentioned in the rejection reason. All other fields are optional.
            </div>

            <form id="registerForm" enctype="multipart/form-data" novalidate>
                @csrf

                {{-- Step 1 - Basic Info --}}
                <div class="form-step step-1 active">
                    <div class="step-header">
                        {{-- <div class="step-logo">
                            <img src="{{ asset('customer-css/assets/images/tazen_logo.png') }}" alt="Tazen Logo">
                        </div> --}}
                        <h4>Step 1 – Basic Info</h4>
                        <small class="text-muted">Update only the fields that need correction</small>
                    </div>

                    <div class="form-group">
                        <label for="name">Name</label>
                        <input class="form-control" type="text" id="name" name="name" placeholder="Enter your name"
                            value="{{ $RejectedUser->professional->name ?? '' }}">
                    </div>

                    <div class="form-group">
                        <label for="email">Email</label>
                        <input class="form-control" type="email" id="email" name="email" placeholder="Enter your email"
                            value="{{ $RejectedUser->professional->email ?? '' }}" readonly>
                        <small class="text-muted">Email address cannot be changed</small>
                    </div>

                    <div class="form-group">
                        <label for="phone">Phone Number</label>
                        <input class="form-control" type="text" id="phone" name="phone"
                            placeholder="Enter your phone number"
                            value="{{ $RejectedUser->professional->phone ?? '' }}">
                    </div>

                    <button type="button" class="btn_1 full-width next-btn">Next Step</button>
                </div>

                {{-- Step 2 - Professional Info --}}
                <div class="form-step step-2">
                    <div class="step-header">
                        {{-- <div class="step-logo">
                            <img src="{{ asset('customer-css/assets/images/tazen_logo.png') }}" alt="Tazen Logo">
                        </div> --}}
                        <h4>Step 2 – Professional Info</h4>
                        <small class="text-muted">Update only the fields that need correction</small>
                    </div>

                    <!-- Specialization Dropdown -->
                    <div class="form-group">
                        <select class="form-control" name="specialization">
                            <option value="">Select Service (What you offer)</option>
                            @php
                                $selectedSpecialization = old('specialization', $RejectedUser->profile->specialization ?? '');
                            @endphp
                            @foreach($services as $service)
                                <option value="{{ $service->name }}" {{ $selectedSpecialization == $service->name ? 'selected' : '' }}>{{ $service->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Experience Dropdown -->
                    <div class="form-group">
                        <select class="form-control" name="experience">
                            <option value="" disabled>Select Experience</option>
                            @php
                                $experiences = ['0-2', '2-4', '4-6', '6-8', '8-10', '10+'];
                                $selectedExperience = old('experience', $RejectedUser->profile->experience ?? '');
                            @endphp
                            @foreach($experiences as $exp)
                                <option value="{{ $exp }}" {{ $selectedExperience == $exp ? 'selected' : '' }}>{{ $exp }} years</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Starting Price Input -->
                    <div class="form-group">
                        <input class="form-control" type="text" name="starting_price" placeholder="Price per session (Rs.)" value="{{ old('starting_price', $RejectedUser->profile->starting_price ?? '') }}">
                    </div>

                    <!-- Location Dropdown -->
                    <div class="form-group">
                        <select class="form-control" name="address">
                            <option value="">Select Location</option>
                            @php
                                $cities = ['Mumbai', 'Kolkata', 'Delhi', 'Bangalore', 'Chennai', 'Hyderabad', 'Pune', 'Ahmedabad', 'Surat', 'Jaipur'];
                                $selectedAddress = old('address', $RejectedUser->profile->address ?? '');
                            @endphp
                            @foreach($cities as $city)
                                <option value="{{ $city }}" {{ $selectedAddress == $city ? 'selected' : '' }}>{{ $city }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Education 1 Input -->
                    <div class="form-group">
                        <input class="form-control" type="text" name="education" placeholder="Education" value="{{ old('education', $RejectedUser->profile->education ?? '') }}">
                    </div>

                    <!-- Education 2 Input (Optional) -->
                    <div class="form-group">
                        <input class="form-control" type="text" name="education2" placeholder="Additional Education (Optional)" value="{{ old('education2', $RejectedUser->profile->education2 ?? '') }}">
                    </div>

                    <!-- Bio removed - will be managed in profile section -->

                    <div style="display: flex; gap: 10px;">
                        <button type="button" class="btn_1 full-width prev-btn">Previous</button>
                        <button type="button" class="btn_1 full-width next-btn">Next Step</button>
                    </div>
                </div>

                {{-- Step 3 - Document Uploads --}}
                <div class="form-step step-3">
                    <div class="step-header">
                        {{-- <div class="step-logo">
                            <img src="{{ asset('customer-css/assets/images/tazen_logo.png') }}" alt="Tazen Logo">
                        </div> --}}
                        <h4>Step 3 – Document Uploads</h4>
                        <small class="text-muted">Upload new documents only if the existing ones were rejected</small>
                    </div>

                    @php
                        $doc = $RejectedUser->profile ?? null;
                    @endphp

                    {{-- Profile Photo (Optional) --}}
                    <div class="file-upload-wrapper">
                        <div class="form-group">
                            <label>Profile Photo <span style="color: #888; font-size: 12px;">(Optional)</span></label><br>
                            @if($doc && !empty($doc->photo))
                                <div class="current-file-display">
                                    <img src="{{ asset('storage/'.$doc->photo) }}" alt="Current Profile Photo" style="width: 80px; height: 80px; object-fit: cover; border-radius: 50%; border: 2px solid #ddd;">
                                </div>
                            @else
                                <span style="color: #888; font-size: 14px;">No photo uploaded</span>
                            @endif
                            <input class="form-control mt-2" type="file" name="profile_photo" accept=".jpg,.jpeg,.png,.bmp,.gif,.webp">
                            <small class="form-text text-muted">Upload a profile photo (JPG, PNG, GIF, WebP). This is optional.</small>
                        </div>
                    </div>

                    {{-- Qualification Document --}}
                    <div class="form-group">
                        <label>Qualification Document</label><br>
                        @if($doc && !empty($doc->qualification_document))
                            <button class="btn"><a href="{{ asset('storage/'.$doc->qualification_document) }}" target="_blank">View Qualification Document</a></button>
                        @else
                            <span style="color: #888; font-size: 14px;">No document uploaded</span>
                        @endif
                        <input class="form-control mt-2" type="file" name="qualification_document" accept=".pdf,.doc,.docx,.txt,.jpg,.jpeg,.png,.bmp,.gif,.tiff,.webp">
                    </div>

                    {{-- Single ID Proof Upload Field --}}
                    <div class="form-group">
                        <label style="font-weight: 600; color: #333;">ID Proof Document</label>
                        <small class="form-text text-muted mb-3">Upload either Aadhaar Card or PAN Card</small>
                        
                        @php
                            $hasIdProof = $doc && !empty($doc->id_proof_document);
                            $currentIdProof = $doc->id_proof_document ?? null;
                        @endphp
                        
                        @if($hasIdProof && $currentIdProof)
                            <button class="btn btn-sm btn-info mb-2">
                                <a href="{{ asset('storage/'.$currentIdProof) }}" target="_blank" style="color: white; text-decoration: none;">
                                    View Current ID Proof
                                </a>
                            </button>
                        @else
                            <span style="color: #888; font-size: 14px;">No ID proof uploaded</span>
                        @endif
                        
                        <input class="form-control mt-2" type="file" name="id_proof_document" accept=".pdf,.doc,.docx,.txt,.jpg,.jpeg,.png,.bmp,.gif,.tiff,.webp">
                        <small class="form-text text-muted">Upload your Aadhaar Card or PAN Card (PDF, DOC, or Image)</small>
                    </div>
                    
                    {{-- GST Registration Section --}}
                    <div class="form-group">
                        <div class="form-check" style="margin-bottom: 15px;">
                            @php
                                // Prefer profile values, fall back to professional record if present
                                $profile = $RejectedUser->profile ?? null;
                                $professional = $RejectedUser->professional ?? null;

                                // Determine existing gst number considering old input, profile, or professional
                                $existingGstNumber = old('gst_number', $profile->gst_number ?? $professional->gst_number ?? '');

                                // Also consider existing gst certificate file as indication of GST
                                $existingGstCertificate = $profile->gst_certificate ?? $professional->gst_certificate ?? '';

                                $hasGst = !empty($existingGstNumber) || !empty($existingGstCertificate);
                            @endphp
                            <input type="checkbox" class="form-check-input" id="has_gst" name="has_gst" 
                                   style="margin-right: 8px;" {{ $hasGst ? 'checked' : '' }}>
                            <label class="form-check-label" for="has_gst" style="font-weight: 500;">
                                I have GST Registration (Optional)
                            </label>
                        </div>
                        <small class="text-muted">Check this box if you have GST registration and want to provide GST details</small>
                    </div>
                    
                    {{-- GST Fields Container --}}
                    <div id="gst-fields-container" style="{{ $hasGst ? 'display: block;' : 'display: none;' }}">
                        {{-- GST Number --}}
                        <div class="form-group">
                            <label>GST Number</label>
                            <i class="fa fa-receipt input-icon"></i>
                            <input class="form-control" type="text" name="gst_number" id="gst_number" 
                                   value="{{ old('gst_number', $existingGstNumber) }}">
                            <div class="invalid-feedback">GST number is required when providing GST details.</div>
                            <div class="gst-info-box">
                                <i class="fas fa-info-circle"></i>
                                Please enter your GST number (10-15 characters)
                            </div>
                        </div>
                        
                        {{-- GST State --}}
                        <div class="form-group">
                            <label>GST State</label>
                            <i class="fa fa-map-marker-alt input-icon"></i>
                            <select class="form-control" name="state_code" id="state_code">
                                <option value="">Select GST State Code</option>
                                @php
                                    // Select state code from old input, then profile, then professional record
                                    $selectedStateCode = old('state_code', $profile->state_code ?? $professional->state_code ?? '');
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
                            <div class="invalid-feedback">GST state is required when providing GST details.</div>
                        </div>
                        
                        {{-- GST Address --}}
                        <div class="form-group">
                            <label>GST Address</label>
                            <i class="fa fa-map-marker-alt input-icon"></i>
                            <textarea class="form-control" name="gst_address" 
                                      placeholder="Enter your GST registered address" rows="3">{{ old('gst_address', $profile->gst_address ?? $professional->gst_address ?? '') }}</textarea>
                            <div class="invalid-feedback">GST address is required when providing GST details.</div>
                        </div>
                        
                        {{-- GST Certificate --}}
                        <div class="form-group">
                            <label>GST Certificate</label><br>
                            @if(!empty($existingGstCertificate))
                                <button class="btn"><a href="{{ asset('storage/'.$existingGstCertificate) }}" target="_blank">View GST Certificate</a></button>
                            @else
                                <span style="color: #888; font-size: 14px;">No document uploaded</span>
                            @endif
                            <input class="form-control mt-2" type="file" name="gst_certificate" id="gst_certificate" accept=".pdf,.doc,.docx,.txt,.jpg,.jpeg,.png,.bmp,.gif,.tiff,.webp">
                            <div class="invalid-feedback">GST certificate is required when providing GST details.</div>
                        </div>
                    </div>

                    {{-- Note about Profile Management --}}
                    <div class="alert alert-info" style="margin-top: 20px;">
                        <i class="fas fa-info-circle"></i>
                        <strong>Note:</strong> Profile photo and gallery images will be managed through your professional profile after registration approval.
                    </div>

                    <div style="display: flex; gap: 10px; margin-top: 10px;">
                        <button type="button" class="btn_1 full-width prev-btn">Previous</button>
                        <button type="submit" class="btn_1 full-width">Re-Submit</button>
                    </div>
                </div>
            </form>

           {{-- Rejection Modal --}}
<div id="rejectionModal" class="custom-modal">
    <div class="custom-modal-content">
        <div class="step-logo">
            <img src="{{ asset('customer-css/assets/images/tazen_logo.png') }}" alt="Tazen Logo">
        </div>
        <div class="modal-icon">⚠</div>
        <h2>Profile Rejected</h2>
        <p class="rejection-reason">{{ $reason ?? 'No rejection reason provided.' }}</p>
        <p class="resubmit-hint">Please check and update your details before resubmitting.</p>
        <button class="resubmit-btn" onclick="resubmitDetails()">Proceed Again</button>
    </div>
</div>

            

            <div class="copy">© Tazen</div>
        </aside>
    </div>

    <!-- JS Scripts -->
    <script src="{{ asset('frontend/assets/js/common_scripts.min.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/common_func.js') }}"></script>
    <script src="{{ asset('frontend/assets/validate.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <script>
        // Disable HTML5 validation and use custom JavaScript validation
        $(document).ready(function() {
            // Add meta tag for CSRF token if not present
            if (!$('meta[name="csrf-token"]').length) {
                $('head').append('<meta name="csrf-token" content="{{ csrf_token() }}">');
            }
            
            // Setup CSRF for all AJAX requests
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        });

        // Function to refresh CSRF token
        function refreshCSRFToken() {
            $.get('/csrf-token', function(data) {
                $('meta[name="csrf-token"]').attr('content', data.csrf_token);
                $('input[name="_token"]').val(data.csrf_token);
            }).fail(function() {
                console.warn('Failed to refresh CSRF token');
            });
        }

        // Function to show field error with improved UX
        function showFieldError(fieldName, errorMessage) {
            const field = $(`[name="${fieldName}"]`);
            field.addClass('is-invalid');
            
            // Remove existing error message
            field.siblings('.invalid-feedback').remove();
            
            // Add new error message
            field.after(`<div class="invalid-feedback" style="display: block; color: #dc3545; font-size: 14px; margin-top: 5px;">${errorMessage}</div>`);
            
            // Show user-friendly toast
            toastr.error(errorMessage, 'Validation Error', {
                timeOut: 4000,
                closeButton: true
            });
        }

        // Function to clear field errors
        function clearFieldErrors() {
            $('.form-control').removeClass('is-invalid');
            $('.invalid-feedback').remove();
        }

        // Function to validate current step - OPTIONAL validation for rejected users
        function validateStep(step) {
            // For rejected users, validation is optional since they're just updating specific fields
            // We only validate if the field has content and it's invalid format
            let isValid = true;
            console.log(`Validating step ${step}`);
            
            if (step === 1) {
                const name = $('[name="name"]').val().trim();
                const phone = $('[name="phone"]').val().trim();
                
                console.log(`Step 1 - Name: "${name}", Phone: "${phone}"`);
                
                // Only validate if user entered something and it's invalid
                if (name && name.length < 2) {
                    console.log('Name validation failed');
                    showFieldError('name', 'Name must be at least 2 characters');
                    isValid = false;
                }
                
                // More lenient phone validation - just check if it's reasonable
                if (phone && (phone.length < 6 || phone.length > 15 || !/^\d+$/.test(phone))) {
                    console.log('Phone validation failed');
                    showFieldError('phone', 'Please enter a valid phone number (6-15 digits)');
                    isValid = false;
                }
            } else if (step === 2) {
                const startingPrice = $('[name="starting_price"]').val().trim();
                
                console.log(`Step 2 - Starting Price: "${startingPrice}"`);
                
                // Only validate price format if entered - allow price ranges like "1000-2000" or single numbers
                if (startingPrice) {
                    // Check if it's a valid price range (e.g., "1000-2000") or single number
                    const pricePattern = /^(\d+(\.\d{1,2})?(-\d+(\.\d{1,2})?)?)$/;
                    if (!pricePattern.test(startingPrice)) {
                        console.log('Starting price validation failed');
                        showFieldError('starting_price', 'Please enter a valid price (e.g., 1000 or 1000-2000)');
                        isValid = false;
                    }
                }
            } else if (step === 3) {
                // For step 3, only validate GST fields if GST checkbox is checked
                if ($('#has_gst').is(':checked')) {
                    const gstNumber = $('[name="gst_number"]').val().trim();
                    const stateCode = $('[name="state_code"]').val().trim();
                    const gstAddress = $('[name="gst_address"]').val().trim();
                    
                    console.log(`Step 3 - GST validation enabled. GST Number: "${gstNumber}", State: "${stateCode}", Address: "${gstAddress}"`);
                    
                    // Validate GST number format if entered
                    if (gstNumber && (gstNumber.length < 10 || gstNumber.length > 15)) {
                        console.log('GST number validation failed');
                        showFieldError('gst_number', 'Please enter a valid GST number (10-15 characters)');
                        isValid = false;
                    }
                    
                    // Validate required GST fields when GST is enabled
                    if (!gstNumber) {
                        console.log('GST number required validation failed');
                        showFieldError('gst_number', 'GST number is required when providing GST details');
                        isValid = false;
                    }
                    
                    if (!stateCode) {
                        console.log('GST state code required validation failed');
                        showFieldError('state_code', 'GST state is required when providing GST details');
                        isValid = false;
                    }
                    
                    if (!gstAddress) {
                        console.log('GST address required validation failed');
                        showFieldError('gst_address', 'GST address is required when providing GST details');
                        isValid = false;
                    }
                } else {
                    console.log('Step 3 - GST validation skipped (GST not selected)');
                }
            }
            
            console.log(`Step ${step} validation result:`, isValid);
            return isValid;
        }

        $('#registerForm').submit(function (e) {
            e.preventDefault();
            
            console.log('Rejected form submission started');
            
            // Clear previous errors
            clearFieldErrors();
            
            // For rejected users, we don't require all fields to be filled
            // We only validate format/content of fields that have values
            let isFormValid = true;
            for (let step = 1; step <= 3; step++) {
                console.log(`Validating step ${step}`);
                if (!validateStep(step)) {
                    console.log(`Step ${step} validation failed`);
                    isFormValid = false;
                }
            }
            
            if (!isFormValid) {
                console.log('Form validation failed');
                toastr.error('Please fix the validation errors before submitting your updates.', 'Form Incomplete', {
                    timeOut: 5000,
                    closeButton: true
                });
                
                // Navigate to step with errors and scroll to first error
                const $firstError = $('.is-invalid').first();
                if ($firstError.length) {
                    let errorStep = 1;
                    if ($firstError.closest('.step-2').length) errorStep = 2;
                    else if ($firstError.closest('.step-3').length) errorStep = 3;
                    
                    // Show the correct step
                    $('.form-step').removeClass('active');
                    $(`.step-${errorStep}`).addClass('active');
                    
                    // Scroll to error
                    setTimeout(() => {
                        $('html, body').animate({
                            scrollTop: $firstError.offset().top - 100
                        }, 500);
                    }, 300);
                }
                return;
            }

            console.log('All validation passed, submitting form');
            
            // Show loading message
            toastr.info('Updating your profile...', 'Please Wait', {
                timeOut: 10000,
                closeButton: false
            });

            let formData = new FormData(this);
            
            // Log form data for debugging
            console.log('Form data being submitted:');
            for (let [key, value] of formData.entries()) {
                console.log(`${key}: ${value}`);
            }

            // Refresh CSRF token before submission
            refreshCSRFToken();

            $.ajax({
                url: "{{ route('professional.register.re-submit') }}",
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                headers: {
                    "X-CSRF-TOKEN": $("meta[name='csrf-token']").attr("content")
                },
                success: function (response) {
                    if (response.status === 'success') {
                        toastr.success(response.message, 'Update Successful', {
                            timeOut: 3000,
                            closeButton: true
                        });
                        setTimeout(() => {
                            window.location.href = "{{ route('professional.login') }}";
                        }, 2000);
                    } else {
                        toastr.error(response.message, 'Update Failed', {
                            timeOut: 5000,
                            closeButton: true
                        });
                    }
                },
                error: function (xhr) {
                    if (xhr.status === 419) {
                        // CSRF token mismatch
                        refreshCSRFToken();
                        toastr.error('Your session has expired. Please refresh the page and try again.', 'Session Expired', {
                            timeOut: 7000,
                            closeButton: true
                        });
                    } else if (xhr.responseJSON?.errors) {
                        // Show specific validation errors with better UX
                        let errorCount = 0;
                        let firstErrorStep = 1;
                        
                        Object.keys(xhr.responseJSON.errors).forEach(field => {
                            const errorMessages = xhr.responseJSON.errors[field];
                            errorMessages.forEach(errorMessage => {
                                errorCount++;
                                showFieldError(field, errorMessage);
                                
                                // Determine which step has the error
                                const $field = $(`[name="${field}"]`);
                                if ($field.closest('.step-2').length && firstErrorStep === 1) {
                                    firstErrorStep = 2;
                                } else if ($field.closest('.step-3').length && firstErrorStep < 3) {
                                    firstErrorStep = 3;
                                }
                            });
                        });
                        
                        // Navigate to step with errors
                        $('.form-step').removeClass('active');
                        $(`.step-${firstErrorStep}`).addClass('active');
                        
                        // Show summary error message
                        toastr.error(`Please fix ${errorCount} validation error${errorCount > 1 ? 's' : ''} and try again.`, 'Validation Failed', {
                            timeOut: 5000,
                            closeButton: true
                        });
                        
                        // Scroll to first error
                        setTimeout(() => {
                            const $firstError = $('.is-invalid').first();
                            if ($firstError.length) {
                                $('html, body').animate({
                                    scrollTop: $firstError.offset().top - 100
                                }, 500);
                            }
                        }, 300);
                    } else if (xhr.responseJSON?.message) {
                        toastr.error(xhr.responseJSON.message, 'Error', {
                            timeOut: 5000,
                            closeButton: true
                        });
                    } else {
                        toastr.error('Something went wrong. Please check your internet connection and try again.', 'Network Error', {
                            timeOut: 5000,
                            closeButton: true
                        });
                    }
                }
            });
        });

        // Toastr session messages
        @if (session('success'))
            toastr.success("{{ session('success') }}");
        @endif
        @if (session('error'))
            toastr.error("{{ session('error') }}");
        @endif
        @if (session('warning'))
            toastr.warning("{{ session('warning') }}");
        @endif

        // Show rejection modal
        $(document).ready(() => {
            $('#rejectionModal').css('display', 'flex');
            $('.close-btn').click(() => {
                $('#rejectionModal').fadeOut();
            });
        });
    </script>
    	<script>
            $(document).ready(function () {
                let currentStep = 1;
        
                $('.next-btn').click(function () {
                    // Clear previous errors
                    clearFieldErrors();
                    
                    // For rejected users, validation is optional - only validate if there are format errors
                    if (!validateStep(currentStep)) {
                        toastr.error('Please fix the validation errors before proceeding to the next step.', 'Validation Error', {
                            timeOut: 4000,
                            closeButton: true
                        });
                        
                        // Scroll to first error
                        setTimeout(() => {
                            const $firstError = $('.is-invalid').first();
                            if ($firstError.length) {
                                $('html, body').animate({
                                    scrollTop: $firstError.offset().top - 100
                                }, 500);
                            }
                        }, 100);
                        return;
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
            });
            
            function resubmitDetails() {
                document.getElementById('rejectionModal').style.display = 'none';
            }
        </script>
        
        <script>
            /**
             * GST fields are now optional for professional re-submission
             * GST checkbox controls visibility and validation
             */
            $(document).ready(function() {
                // GST checkbox handler - show/hide GST fields
                $('#has_gst').on('change', function() {
                    const isChecked = $(this).is(':checked');
                    const $gstContainer = $('#gst-fields-container');
                    
                    if (isChecked) {
                        $gstContainer.slideDown(300);
                        console.log('GST fields enabled for rejected form');
                    } else {
                        $gstContainer.slideUp(300);
                        // Clear GST field values when hidden
                        $('#gst_number').val('');
                        $('#state_code').val('');
                        $('#gst_address').val('');
                        $('#gst_certificate').val('');
                        $('#state_name').val('');
                        
                        // Clear any validation errors for GST fields
                        $('#gst_number, #state_code, #gst_address, #gst_certificate').removeClass('is-invalid');
                        $('#gst-fields-container .invalid-feedback').hide();
                        
                        console.log('GST fields disabled for rejected form');
                    }
                });
                
                // State code selection handler
                $('#state_code').on('change', function() {
                    const selectedOption = $(this).find('option:selected');
                    const stateName = selectedOption.data('state');
                    
                    // Store state name in a hidden field
                    if (stateName) {
                        if (!$('#state_name').length) {
                            $('<input>').attr({
                                type: 'hidden',
                                id: 'state_name',
                                name: 'state_name',
                                value: stateName
                            }).appendTo('#registerForm');
                        } else {
                            $('#state_name').val(stateName);
                        }
                    }
                });
                
                // Initialize state name on page load if state code is already selected
                const initialStateCode = $('#state_code').val();
                if (initialStateCode) {
                    const selectedOption = $('#state_code option:selected');
                    const stateName = selectedOption.data('state');
                    if (stateName) {
                        $('<input>').attr({
                            type: 'hidden',
                            id: 'state_name',
                            name: 'state_name',
                            value: stateName
                        }).appendTo('#registerForm');
                    }
                }
            });
        </script>
        
</body>
</html>
