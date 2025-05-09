<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Tazen - Professional Register</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" />
    <link href="{{ asset('frontend/assets/css/rejectpro.css') }}" rel="stylesheet">

    <style>
        .custom-modal {
            display: none;
            position: fixed;
            z-index: 10000;
            left: 0;
            top: 0;
            width: 100vw;
            height: 100vh;
            background-color: rgba(0, 0, 0, 0.6);
            backdrop-filter: blur(3px);
            justify-content: center;
            align-items: center;
        }

        .custom-modal-content {
            background-color: #fff;
            padding: 30px;
            border-radius: 12px;
            width: 90%;
            max-width: 500px;
            text-align: center;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.3);
            animation: popup-zoom 0.4s ease;
        }

        @keyframes popup-zoom {
            0% { transform: scale(0.5); opacity: 0; }
            100% { transform: scale(1); opacity: 1; }
        }

        .close-btn {
            position: absolute;
            top: 15px;
            right: 20px;
            color: #888;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
        }

        .close-btn:hover {
            color: #000;
        }
        .resubmit-hint {
    display: block;
    margin-top: 15px;
    font-size: 13px;
    color: #ff4d4d;
    font-weight: bold;
    animation: blink 1.5s infinite;
}

@keyframes blink {
    0%, 100% { opacity: 1; }
    50% { opacity: 0.4; }
}

    </style>
</head>

<body>
    <nav id="menu" class="fake_menu"></nav>

    <div id="login">
        <aside>
            <h2 style="text-align: center">Please Check For Approval</h2>

            <form id="registerForm" enctype="multipart/form-data">
                @csrf

                {{-- Step 1 - Basic Info --}}
                <div class="form-step step-1 active">
                    <h4>Step 1 – Basic Info</h4>

                    <div class="form-group">
                        <label for="name">Name</label>
                        <input class="form-control" type="text" id="name" name="name" placeholder="Enter your name"
                            value="{{ $RejectedUser->professional->name ?? '' }}" required>
                    </div>

                    <div class="form-group">
                        <label for="email">Email</label>
                        <input class="form-control" type="email" id="email" name="email" placeholder="Enter your email"
                            value="{{ $RejectedUser->professional->email ?? '' }}" required>
                    </div>

                    <div class="form-group">
                        <label for="phone">Phone Number</label>
                        <input class="form-control" type="text" id="phone" name="phone"
                            placeholder="Enter your phone number"
                            value="{{ $RejectedUser->professional->phone ?? '' }}" required>
                    </div>

                    <button type="button" class="btn_1 full-width next-btn">Next Step</button>
                </div>

                {{-- Step 2 - Professional Info --}}
                <div class="form-step step-2">
                    <h4>Step 2 – Professional Info</h4>

                    <div class="form-group">
                        <input class="form-control" type="text" name="specialization" placeholder="Specialization"
                            required value="{{ old('specialization', $RejectedUser->profile->specialization) }}">
                    </div>

                    <div class="form-group">
                        <input class="form-control" type="text" name="experience" placeholder="Experience" required
                            value="{{ old('experience', $RejectedUser->profile->experience) }}">
                    </div>

                    <div class="form-group">
                        <input class="form-control" type="text" name="starting_price" placeholder="Starting Price"
                            required value="{{ old('starting_price', $RejectedUser->profile->starting_price) }}">
                    </div>

                    <div class="form-group">
                        <label for="address">Select Location</label>
                        <select class="form-control" name="address" id="address" required>
                            <option value="">Select Location</option>
                            @php
                                $selectedAddress = old('address', $RejectedUser->profile->address ?? '');
                                $cities = ['Mumbai', 'Kolkata', 'Delhi', 'Bangalore', 'Chennai', 'Hyderabad', 'Pune', 'Ahmedabad', 'Surat', 'Jaipur'];
                            @endphp
                            @foreach($cities as $city)
                                <option value="{{ $city }}" {{ $selectedAddress == $city ? 'selected' : '' }}>{{ $city }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <input class="form-control" type="text" name="education" placeholder="Education" required
                            value="{{ old('education', $RejectedUser->profile->education) }}">
                    </div>

                    <div class="form-group">
                        <input class="form-control" type="text" name="education2" placeholder="Additional Education" required
                            value="{{ old('education2', $RejectedUser->profile->education2) }}">
                    </div>

                    <div class="form-group">
                        <textarea class="form-control" name="bio" placeholder="Short Bio" required>{{ old('bio', $RejectedUser->profile->bio) }}</textarea>
                    </div>

                    <div style="display: flex; gap: 10px;">
                        <button type="button" class="btn_1 full-width prev-btn">Previous</button>
                        <button type="button" class="btn_1 full-width next-btn">Next Step</button>
                    </div>
                </div>

                {{-- Step 3 - Document Uploads --}}
                <div class="form-step step-3">
                    <h4>Step 3 – Document Uploads</h4>

                    @php
                        $doc = $RejectedUser->profile;
                    @endphp

                    @foreach ([
                        'qualification_document' => 'Qualification Document',
                        'aadhaar_card' => 'Aadhaar Card',
                        'pan_card' => 'PAN Card'
                    ] as $field => $label)
                        <div class="form-group">
                            <label>{{ $label }}</label><br>
                            @if($doc->$field)
                                <a href="{{ asset($doc->$field) }}" target="_blank">View {{ $label }}</a>
                            @endif
                            <input class="form-control mt-2" type="file" name="{{ $field }}">
                        </div>
                    @endforeach

                    {{-- Profile Photo --}}
                    <div class="form-group">
                        <label>Profile Photo</label><br>
                        @if($doc->photo)
                            <img src="{{ asset($doc->photo) }}" alt="Profile Photo" width="100">
                        @endif
                        <input class="form-control mt-2" type="file" name="profile_photo">
                    </div>

                    {{-- Gallery Images --}}
                    <div class="form-group">
                        <label for="gallery">Upload Gallery Images</label><br>
                        @if($doc->gallery && is_array(json_decode($doc->gallery)))
                            @foreach(json_decode($doc->gallery) as $image)
                                <img src="{{ asset($image) }}" alt="Gallery Image" width="80" style="margin: 5px;">
                            @endforeach
                        @endif
                        <input class="form-control mt-2" type="file" name="gallery[]" multiple>
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
                    <h2 style="color: #ff4d4d;">⚠ Reason for Rejection of your profile</h2>
                    <p>{{ $RejectedUser->reason ?? 'No rejection reason provided.' }}</p>
        
                    <small class="resubmit-hint">⚠ Kindly check and resubmit your details</small>
                    <span class="close-btn">Ok</span>
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
        $('#registerForm').submit(function (e) {
            e.preventDefault();

            let formData = new FormData(this);

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
                        toastr.success(response.message);
                        setTimeout(() => {
                            window.location.href = "{{ route('professional.login') }}";
                        }, 1500);
                    } else {
                        toastr.error(response.message);
                    }
                },
                error: function (xhr) {
                    if (xhr.responseJSON?.errors) {
                        Object.values(xhr.responseJSON.errors).forEach(err => {
                            toastr.error(err[0]);
                        });
                    } else {
                        toastr.error("Something went wrong. Please try again.");
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
        </script>
</body>
</html>
