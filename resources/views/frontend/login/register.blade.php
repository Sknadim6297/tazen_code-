<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Register with Tazen.in - Join thousands who trust our verified professionals for career counselling, health, finance, and more.">
    <meta name="author" content="Tazen">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Register - Tazen.in | Find Verified Experts for Career, Health & Finance</title>

    <!-- Favicons-->
    <link rel="shortcut icon" href="img/favicon.jpg" type="image/x-icon">

    <link rel="apple-touch-icon" type="image/x-icon" href="img/apple-touch-icon-57x57-precomposed.png">
    <link rel="apple-touch-icon" type="image/x-icon" sizes="72x72" href="img/apple-touch-icon-72x72-precomposed.png">
    <link rel="apple-touch-icon" type="image/x-icon" sizes="114x114" href="img/apple-touch-icon-114x114-precomposed.png">
    <link rel="apple-touch-icon" type="image/x-icon" sizes="144x144" href="img/apple-touch-icon-144x144-precomposed.png">

   <!-- BASE CSS -->
   <link href="{{ asset('frontend/assets/css/bootstrap.min.css') }}" rel="stylesheet">
   <link href="{{ asset('frontend/assets/css/style.css') }}" rel="stylesheet">

   <!-- SPECIFIC CSS -->
   <link href="{{ asset('frontend/assets/css/account.css') }}" rel="stylesheet">

   <!-- YOUR CUSTOM CSS -->
   <link href="{{ asset('frontend/assets/css/custom.css') }}" rel="stylesheet">
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" />
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap');

        body {
            font-family: "Poppins";
        } 
        .toast-top-center {
            top: 40px !important;
            left: 50% !important;
            transform: translateX(-50%) !important;
            z-index: 9999 !important;
        }

        /* Smaller Send Code Button */
        .send-otp-btn {
            background-color: #3498db;
            color: white;
            border: none;
            border-radius: 20px;
            padding: 4px 10px;
            font-size: 12px;
            cursor: pointer;
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            transition: all 0.3s;
        }
        
        .send-otp-btn:hover {
            background-color: #2980b9;
        }
        
        .send-otp-wrapper {
            position: relative;
        }
        
        /* OTP Modal Styles */
        .modal-otp {
            max-width: 400px;
        }
        
        .modal-otp .modal-header {
            border-bottom: none;
            padding-bottom: 0;
        }
        
        .modal-otp .modal-title {
            font-weight: 600;
            color: #333;
        }
        
        .modal-otp .modal-body {
            padding-top: 0;
        }
        
        .otp-input {
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 20px auto;
        }
        
        .otp-digit {
            width: 40px;
            height: 50px;
            margin: 0 5px;
            text-align: center;
            font-size: 18px;
            font-weight: bold;
            border: 2px solid #ccc;
            border-radius: 5px;
            transition: all 0.2s;
        }
        
        .otp-digit:focus {
            border-color: #3498db;
            box-shadow: 0 0 5px rgba(52, 152, 219, 0.5);
        }
        
        .otp-timer {
            font-size: 14px;
            text-align: center;
            margin: 10px 0;
            color: #555;
        }
        
        .verify-otp-btn {
            background-color: #3498db;
            color: white;
            border: none;
            border-radius: 25px;
            padding: 8px 24px;
            font-size: 14px;
            display: block;
            margin: 10px auto;
            transition: all 0.3s;
        }
        
        .verify-otp-btn:hover {
            background-color: #2980b9;
        }
        
        .otp-instructions {
            text-align: center;
            font-size: 13px;
            margin-top: 10px;
            color: #666;
        }
        
        .email-verification-status {
            text-align: center;
            margin: 10px 0;
        }
        
        .otp-verified {
            color: #27ae60;
            font-weight: 500;
        }
        
        /* Animation for verification success */
        @keyframes checkmark {
            0% {
                transform: scale(0);
                opacity: 0;
            }
            50% {
                transform: scale(1.2);
            }
            100% {
                transform: scale(1);
                opacity: 1;
            }
        }
        
        .checkmark-circle {
            width: 80px;
            height: 80px;
            margin: 10px auto;
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .checkmark-circle-bg {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background-color: #27ae60;
            opacity: 0.1;
        }
        
        .checkmark {
            position: absolute;
            color: #27ae60;
            font-size: 36px;
            animation: checkmark 0.5s ease-in-out;
        }
        
        /* Password form section */
        #passwordSection {
            display: none;
        }
        
        .email-badge {
            background-color: #e1f5fe;
            color: #0288d1;
            border-radius: 20px;
            padding: 4px 12px;
            font-size: 13px;
            display: inline-block;
            margin-bottom: 15px;
        }
        
        .email-badge i {
            margin-right: 4px;
        }
        
        /* Progress Steps */
        .form-progress {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
            position: relative;
        }
        
        .form-progress::before {
            content: "";
            position: absolute;
            top: 15px;
            left: 20px;
            right: 20px;
            height: 2px;
            background: #ddd;
            z-index: 0;
        }
        
        .progress-step {
            position: relative;
            z-index: 1;
            text-align: center;
            width: 33.333%;
        }
        
        .step-number {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            background: #eee;
            color: #999;
            font-size: 14px;
            font-weight: bold;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 8px;
            border: 2px solid #ddd;
        }
        
        .step-active .step-number {
            background: #3498db;
            color: white;
            border-color: #3498db;
        }
        
        .step-completed .step-number {
            background: #27ae60;
            color: white;
            border-color: #27ae60;
        }
        
        .step-title {
            font-size: 12px;
            color: #777;
            display: block;
        }
        
        .step-active .step-title {
            color: #3498db;
            font-weight: 500;
        }
        
        .step-completed .step-title {
            color: #27ae60;
            font-weight: 500;
        }
    </style>
</head>

<body id="register_bg">
    
    <nav id="menu" class="fake_menu"></nav>
    
    <div id="login">
        <aside>
            <figure>
                <a href="{{ route('home') }}"><img src="{{ asset('customer-css/assets/images/tazen_logo.png') }}" width="100" height="100" alt="" class="logo_sticky"></a>
            </figure>
            
            <!-- Progress Steps -->
            <div class="form-progress">
                <div class="progress-step step-active" id="stepInfo">
                    <div class="step-number">1</div>
                    <span class="step-title">Personal Info</span>
                </div>
                <div class="progress-step" id="stepVerify">
                    <div class="step-number">2</div>
                    <span class="step-title">Verify Email</span>
                </div>
                <div class="progress-step" id="stepPassword">
                    <div class="step-number">3</div>
                    <span class="step-title">Set Password</span>
                </div>
            </div>
            
            <form id="registerForm">
                @csrf
                
                <!-- Step 1: Personal Information -->
                <div id="personalInfoSection">
                    <div class="form-group">
                        <input class="form-control" type="text" name="first_name" placeholder="First Name" required>
                        <i class="icon_pencil-edit"></i>
                    </div>
                    <div class="form-group">
                        <input class="form-control" type="text" name="last_name" placeholder="Last Name" required>
                        <i class="icon_pencil-edit"></i>
                    </div>
                    <div class="form-group send-otp-wrapper">
                        <input class="form-control" type="email" name="email" id="email" placeholder="Email" required>
                        <i class="icon_mail_alt"></i>
                        <button type="button" class="send-otp-btn" id="sendOtpBtn">Send Code</button>
                    </div>
                    <button type="button" class="btn_1 rounded full-width" id="continueBtn">Continue</button>
                </div>
                
                <!-- Step 3: Password Section (will be shown after OTP verification) -->
                <div id="passwordSection">
                    <div class="email-badge">
                        <i class="icon-ok-circled"></i> <span id="verifiedEmail">email@example.com</span>
                    </div>
                    <div class="form-group">
                        <input class="form-control" type="password" name="password" id="password1" placeholder="Create Password" required>
                        <i class="icon_lock_alt"></i>
                    </div>
                    <div class="form-group">
                        <input class="form-control" type="password" name="password_confirmation" id="password2" placeholder="Confirm Password" required>
                        <i class="icon_lock_alt"></i>
                    </div>
                    <div id="pass-info" class="clearfix"></div>
                    <button type="submit" class="btn_1 rounded full-width" id="registerButton">Complete Registration</button>
                </div>
                
                <div class="text-center add_top_10">
                    Already have an account? <strong><a href="{{ route('login') }}">Sign In</a></strong>
                </div>
                
                <!-- Hidden OTP field to be submitted with form -->
                <input type="hidden" name="otp" id="fullOtp">
            </form>
            
            <div class="copy">© Tazen</div>
        </aside>
    </div>
    
    <!-- OTP Verification Modal -->
    <div class="modal fade" id="otpModal" tabindex="-1" role="dialog" aria-labelledby="otpModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-otp" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="otpModalLabel">Email Verification</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>We've sent a verification code to <strong id="emailDisplay"></strong></p>
                    
                    <!-- OTP Input -->
                    <div class="otp-input">
                        <input type="text" class="otp-digit" maxlength="1" data-index="1" inputmode="numeric" pattern="[0-9]">
                        <input type="text" class="otp-digit" maxlength="1" data-index="2" inputmode="numeric" pattern="[0-9]">
                        <input type="text" class="otp-digit" maxlength="1" data-index="3" inputmode="numeric" pattern="[0-9]">
                        <input type="text" class="otp-digit" maxlength="1" data-index="4" inputmode="numeric" pattern="[0-9]">
                        <input type="text" class="otp-digit" maxlength="1" data-index="5" inputmode="numeric" pattern="[0-9]">
                        <input type="text" class="otp-digit" maxlength="1" data-index="6" inputmode="numeric" pattern="[0-9]">
                    </div>
                    
                    <div class="otp-timer" id="otpTimer">Expires in: 10:00</div>
                    
                    <button type="button" class="verify-otp-btn" id="verifyOtpBtn">Verify Code</button>
                    
                    <div class="email-verification-status" id="emailVerificationStatus"></div>
                    
                    <p class="otp-instructions">
                        Didn't receive the code? <a href="#" id="resendOtp">Resend</a>
                    </p>
                </div>
                
                <!-- Success state (initially hidden) -->
                <div class="modal-body verification-success" style="display: none;">
                    <div class="checkmark-circle">
                        <div class="checkmark-circle-bg"></div>
                        <i class="icon-ok-circled checkmark"></i>
                    </div>
                    <h4 class="text-center">Email Verified Successfully</h4>
                    <p class="text-center">Your email has been verified. Please create a password to complete registration.</p>
                    <button type="button" class="btn_1 rounded full-width" id="proceedToPassword" data-dismiss="modal">Continue</button>
                </div>
            </div>
        </div>
    </div>
    
    <!-- COMMON SCRIPTS -->
    <script src="{{ asset('frontend/assets/js/common_scripts.min.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/common_func.js') }}"></script>
    <script src="{{ asset('frontend/assets/validate.js') }}"></script>
    
    <!-- SPECIFIC SCRIPTS -->
    <script src="{{ asset('frontend/assets/js/pw_strenght.js') }}"></script>	
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
    $(document).ready(function() {
        // Initialize variables
        let otpVerified = false;
        let otpTimer = null;
        let otpCountdown = 600; // 10 minutes in seconds

        // Configure toastr
        toastr.options = {
            "positionClass": "toast-top-center",
            "timeOut": "3000",
            "closeButton": true,
            "progressBar": true
        };

        // Continue button handler
        $('#continueBtn').on('click', function() {
            const firstName = $('input[name="first_name"]').val();
            const lastName = $('input[name="last_name"]').val();
            const email = $('#email').val();
            
            // Validate fields
            if (!firstName) {
                toastr.error('Please enter your first name.');
                return;
            }
            
            if (!lastName) {
                toastr.error('Please enter your last name.');
                return;
            }
            
            if (!email) {
                toastr.error('Please enter your email address.');
                return;
            }
            
            if (!validateEmail(email)) {
                toastr.error('Please enter a valid email address.');
                return;
            }
            
            // Trigger send OTP
            $('#sendOtpBtn').click();
        });

        // OTP digit input handling
        $('.otp-digit').on('input', function() {
            const index = parseInt($(this).data('index'));
            const value = $(this).val();

            // Allow only numbers
            if (/[^0-9]/.test(value)) {
                $(this).val('');
                return;
            }

            // Move to next input if value is entered
            if (value && index < 6) {
                $(`.otp-digit[data-index="${index + 1}"]`).focus();
            }

            // Combine all digits to form the complete OTP
            updateFullOtp();
        });

        // Handle backspace to move to previous input
        $('.otp-digit').on('keydown', function(e) {
            const index = parseInt($(this).data('index'));
            
            if (e.key === 'Backspace' && !$(this).val() && index > 1) {
                $(`.otp-digit[data-index="${index - 1}"]`).focus();
            }
        });

        // Function to update the hidden full OTP input
        function updateFullOtp() {
            let otp = '';
            $('.otp-digit').each(function() {
                otp += $(this).val() || '';
            });
            $('#fullOtp').val(otp);
        }

        // Send OTP button click handler
        $('#sendOtpBtn, #resendOtp').on('click', function() {
            const email = $('#email').val();
            
            if (!email) {
                toastr.error('Please enter your email address.');
                return;
            }
            
            if (!validateEmail(email)) {
                toastr.error('Please enter a valid email address.');
                return;
            }

            // Send OTP via AJAX
            $.ajax({
                url: "{{ route('register.send-otp') }}",
                type: "POST",
                data: {
                    email: email,
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                beforeSend: function() {
                    $('#sendOtpBtn').prop('disabled', true).text('Sending...');
                    $('#resendOtp').addClass('disabled');
                },
                success: function(response) {
                    if (response.status === 'success') {
                        // Show OTP modal
                        $('#otpModal').modal('show');
                        $('#emailDisplay').text(email);
                        
                        // Update the progress steps
                        $('#stepInfo').removeClass('step-active').addClass('step-completed');
                        $('#stepVerify').addClass('step-active');
                        
                        // Reset OTP input fields
                        $('.otp-digit').val('');
                        updateFullOtp();
                        $('.otp-digit[data-index="1"]').focus();
                        
                        // Make sure we show the verification form, not the success message
                        $('.modal-body:not(.verification-success)').show();
                        $('.verification-success').hide();
                        
                        // Start countdown timer
                        startOtpTimer();
                        
                        toastr.success(response.message);
                    } else {
                        toastr.error(response.message);
                    }
                },
                error: function(xhr) {
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        toastr.error(xhr.responseJSON.message);
                    } else {
                        toastr.error('Something went wrong. Please try again.');
                    }
                },
                complete: function() {
                    $('#sendOtpBtn').prop('disabled', false).text('Send Code');
                    $('#resendOtp').removeClass('disabled');
                }
            });
        });

        // Start OTP countdown timer
        function startOtpTimer() {
            clearInterval(otpTimer);
            otpCountdown = 600; // Reset to 10 minutes
            
            updateTimerDisplay();
            
            otpTimer = setInterval(function() {
                otpCountdown--;
                updateTimerDisplay();
                
                if (otpCountdown <= 0) {
                    clearInterval(otpTimer);
                    $('#otpTimer').text('OTP expired. Please request a new one.');
                }
            }, 1000);
        }

        // Update timer display
        function updateTimerDisplay() {
            const minutes = Math.floor(otpCountdown / 60);
            const seconds = otpCountdown % 60;
            $('#otpTimer').text(`Expires in: ${minutes}:${seconds < 10 ? '0' : ''}${seconds}`);
        }

        // Verify OTP button click handler
        $('#verifyOtpBtn').on('click', function() {
            const otp = $('#fullOtp').val();
            const email = $('#email').val();
            
            if (otp.length !== 6) {
                toastr.error('Please enter the complete 6-digit code.');
                return;
            }
            
            // Verify OTP via AJAX
            $.ajax({
                url: "{{ route('register.verify-otp') }}",
                type: "POST",
                data: {
                    email: email,
                    otp: otp,
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                beforeSend: function() {
                    $('#verifyOtpBtn').prop('disabled', true).text('Verifying...');
                },
                success: function(response) {
                    if (response.status === 'success') {
                        otpVerified = true;
                        clearInterval(otpTimer);
                        
                        // Show success state in modal
                        $('.modal-body:not(.verification-success)').hide();
                        $('.verification-success').show();
                        
                        // Update progress steps
                        $('#stepVerify').removeClass('step-active').addClass('step-completed');
                        $('#stepPassword').addClass('step-active');
                        
                        // Disable editing the email
                        $('#email').prop('readonly', true);
                        $('#sendOtpBtn').prop('disabled', true).hide();
                        
                        // Display verified email
                        $('#verifiedEmail').text(email);
                        
                        toastr.success(response.message);
                        
                        // Automatically close modal after 1.5 seconds
                        setTimeout(function() {
                            $('#otpModal').modal('hide');
                            $('#personalInfoSection').hide();
                            $('#passwordSection').show();
                            $('#password1').focus();
                        }, 1500);
                    } else {
                        toastr.error(response.message);
                    }
                },
                error: function(xhr) {
                    console.log("OTP verification error:", xhr.responseJSON);
                    
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        toastr.error(xhr.responseJSON.message);
                        
                        // Handle specific error cases
                        if (xhr.responseJSON.error_type === 'already_verified') {
                            // Clear OTP fields
                            $('.otp-digit').val('');
                            updateFullOtp();
                            
                            // Force request a new OTP
                            setTimeout(function() {
                                $('#resendOtp').trigger('click');
                            }, 1000);
                        } 
                        else if (xhr.responseJSON.error_type === 'expired') {
                            // Clear OTP fields and highlight the resend button
                            $('.otp-digit').val('');
                            updateFullOtp();
                            $('#resendOtp').addClass('highlight');
                        }
                    } else {
                        toastr.error('Invalid or expired code. Please try again.');
                    }
                },
                complete: function() {
                    $('#verifyOtpBtn').prop('disabled', false).text('Verify Code');
                }
            });
        });
        
        // Procced to password button handler (in case modal doesn't auto-close)
        $('#proceedToPassword').on('click', function() {
            $('#otpModal').modal('hide');
            $('#personalInfoSection').hide();
            $('#passwordSection').show();
            $('#password1').focus();
        });

        // Registration form submission
        $('#registerForm').submit(function(e) {
            e.preventDefault();

            if (!otpVerified) {
                toastr.error('Please verify your email address with OTP first.');
                return;
            }

            $.ajax({
                url: "{{ route('register') }}",
                type: "POST",
                data: $(this).serialize(),
                headers: {
                    "X-CSRF-TOKEN": $("meta[name='csrf-token']").attr("content")
                },
                success: function(response) {
                    if (response.status === 'success') {
                        // Store the email in localStorage for autofill
                        if (response.registered_email) {
                            localStorage.setItem('registered_email', response.registered_email);
                        }
                        
                        // Show success message
                        Swal.fire({
                            icon: 'success',
                            title: 'Registration Successful!',
                            text: response.message,
                            confirmButtonColor: '#152a70',
                            confirmButtonText: 'Login Now'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.href = response.redirect_url;
                            } else {
                                window.location.href = response.redirect_url;
                            }
                        });
                    } else {
                        toastr.error(response.message);
                    }
                },
                error: function(xhr) {
                    if (xhr.responseJSON && xhr.responseJSON.errors) {
                        var errors = xhr.responseJSON.errors;
                        for (var key in errors) {
                            toastr.error(errors[key][0]);
                        }
                    } else {
                        toastr.error("Something went wrong. Please try again.");
                    }
                }
            });
        });

        // Helper function to validate email
        function validateEmail(email) {
            const re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
            return re.test(email);
        }

        // Email input change handler - reset OTP verification if email changes
        $('#email').on('input', function() {
            if (otpVerified) {
                otpVerified = false;
                $('#emailVerificationStatus').html('');
                $('#registerButton').prop('disabled', true);
                $('#sendOtpBtn').prop('disabled', false).text('Send Code').show();
            }
        });
        
        // If modal is closed, reset verification unless successfully verified
        $('#otpModal').on('hidden.bs.modal', function () {
            if (!otpVerified) {
                clearInterval(otpTimer);
                $('.otp-digit').val('');
                updateFullOtp();
                $('#emailVerificationStatus').html('');
                $('.modal-body:not(.verification-success)').show();
                $('.verification-success').hide();
            }
        });
    });
    </script>
    <script>
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
</body>
</html>