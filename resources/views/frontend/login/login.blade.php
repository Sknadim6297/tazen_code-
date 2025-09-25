<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Login to Tazen.in - Find verified professionals for career counselling, health, finance, and more. Book consultations easily.">
    <meta name="author" content="Tazen">
    <title>Login - Tazen.in | Find Verified Experts</title>

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

		/* Terms checkbox disabled state */
		input[type="checkbox"]:disabled + .checkmark {
			background-color: #e9ecef;
			opacity: 0.6;
			cursor: not-allowed;
		}
		
		.container_check input:disabled ~ .checkmark {
			background-color: #e9ecef;
			opacity: 0.6;
		}
		
		.invalid-feedback {
			display: none;
			color: #dc3545;
			font-size: 12px;
			margin-top: 5px;
		}
		
		.invalid-feedback.show {
			display: block;
		}
		
		.scroll-indicator {
			position: sticky;
			top: 0;
			background: white;
			padding: 10px;
			border-bottom: 1px solid #dee2e6;
			z-index: 10;
		}
		
		.terms-content {
			padding: 20px 0;
		}
		
		.terms-content h6 {
			color: #333;
			margin-top: 20px;
			margin-bottom: 10px;
		}
		
		.terms-content p, .terms-content li {
			margin-bottom: 10px;
			line-height: 1.6;
		}
	</style>
</head>

<body id="login_bg">
	
	<div id="preloader">
		<div data-loader="circle-side"></div>
	</div>
	<!-- End Preload -->
	
	<div id="login">
		<aside>
			<figure>
				<a href="{{ route('home') }}"><img src="{{ asset('customer-css/assets/images/tazen_logo.png') }}" width="auto" height="100" alt="" class="logo_sticky"></a>
			</figure>
			<form id="loginForm" >
				@csrf
				<div class="form-group">
					<input type="email" class="form-control" name="email" id="email" placeholder="Email" required>
					<i class="icon_mail_alt"></i>
				</div>
				<div class="form-group">
					<input type="password" class="form-control" name="password" id="password" placeholder="Password" required>
					<i class="icon_lock_alt"></i>
				</div>
				<div class="clearfix add_bottom_30">
					<div class="checkboxes float-start">
						<label class="container_check">Remember me
							<input type="checkbox" name="remember">
							<span class="checkmark"></span>
						</label>
					</div>
					<div class="float-end"><a href="{{ route('forgot.form') }}">Forgot Password?</a></div>
				</div>

				<!-- Add Terms and Conditions checkbox -->
				<div class="form-group mb-3">
					<label class="container_check">I accept the <a href="#" onclick="openTermsModal(event)">Terms and Conditions</a>
						<input type="checkbox" name="terms_accepted" id="terms_accepted" disabled>
						<span class="checkmark"></span>
					</label>
					<div class="invalid-feedback" id="terms-error">
						You must read the complete Terms and Conditions to continue.
					</div>
					<small class="text-muted">Please read the complete terms and conditions to enable the checkbox.</small>
				</div>

				<button type="submit" class="btn_1 full-width">login-Customer</button>
				<div class="text-center add_top_10">New to Tazen? <strong><a href="{{ route('register') }}">Sign up!</a></strong></div>
			</form>
			
			<div class="copy">© Tazen</div>
		</aside>
	</div>
	<!-- /login -->

	<!-- Terms and Conditions Modal -->
	<div class="modal fade" id="termsModal" tabindex="-1" aria-labelledby="termsModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg modal-dialog-scrollable">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="termsModalLabel">Terms and Conditions</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body" id="termsModalBody" style="max-height: 400px; overflow-y: auto;">
					@include('frontend.partials.terms_agreement')
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
					<button type="button" class="btn btn-primary" id="agreeButton" disabled onclick="agreeToTerms()">I Agree</button>
				</div>
			</div>
		</div>
	</div>
		
	<!-- COMMON SCRIPTS -->
   	<script src="{{ asset('frontend/assets/js/common_scripts.min.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/common_func.js') }}"></script>
    <script src="{{ asset('frontend/assets/validate.js') }}"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
	<!-- Add SweetAlert CDN before your script -->
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

	<script>
	// Terms Modal Functions
	function openTermsModal(event) {
		event.preventDefault();
		$('#termsModal').modal('show');
	}

	function agreeToTerms() {
		$('#terms_accepted').prop('disabled', false).prop('checked', true);
		$('#terms-error').hide();
		$('#termsModal').modal('hide');
		toastr.success('Thank you for accepting the Terms and Conditions');
	}

	// Scroll detection for terms modal
	$(document).ready(function() {
		$('#termsModal').on('shown.bs.modal', function() {
			const modalBody = document.getElementById('termsModalBody');
			const agreeButton = document.getElementById('agreeButton');
			
			// Reset agree button state
			agreeButton.disabled = true;
			agreeButton.textContent = 'Please scroll to bottom';
			
			modalBody.addEventListener('scroll', function() {
				const scrollTop = modalBody.scrollTop;
				const scrollHeight = modalBody.scrollHeight;
				const clientHeight = modalBody.clientHeight;
				
				// Check if user has scrolled to bottom (with small tolerance)
				if (scrollTop + clientHeight >= scrollHeight - 10) {
					agreeButton.disabled = false;
					agreeButton.textContent = 'I Agree';
					$('.scroll-indicator').html('<small class="text-success">✓ You have read the complete terms</small>');
				}
			});
		});
	});

	$(document).ready(function() {
    $('#loginForm').submit(function(e) {
        e.preventDefault();
        
        // Validate form
        if (!$('#terms_accepted').is(':checked')) {
            $('#terms-error').show();
            toastr.error('You must read and accept the Terms and Conditions to continue.');
            return false;
        }
        
        const urlParams = new URLSearchParams(window.location.search);
        const redirect = urlParams.get('redirect') || "{{ route('home') }}";
        let formData = $(this).serializeArray();
        formData.push({name: 'redirect', value: redirect});
        
        loginUser(formData);
    });

    // Function to handle login with AJAX
    function loginUser(formData, forceLogin = false) {
        // Use the correct URL based on whether it's a force login or regular login
        const url = forceLogin 
            ? "{{ route('force.login') }}" 
            : "{{ route('login.submit') }}";
        
        $.ajax({
            url: url,
            method: "POST",
            data: $.param(formData),
            success: function(response) {
                // Handle confirm_logout status - show SweetAlert
                if (response.status === 'confirm_logout') {
                    Swal.fire({
                        title: 'Already Logged In',
                        text: response.message,
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, log me in',
                        cancelButtonText: 'Cancel'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // User confirmed, resubmit with force_login flag
                            loginUser(formData, true);
                        }
                    });
                    return;
                }
                
                // Normal login success
                if (response.status === 'success') {
                    toastr.success(response.message);
                    setTimeout(function() {
                        window.location.href = response.redirect_url;
                    }, 1500);
                }
            },
            error: function(xhr) {
                if (xhr.status === 422) {
                    let errors = xhr.responseJSON.errors;
                    $.each(errors, function(key, value) {
                        toastr.error(value[0]);
                    });
                } else if (xhr.responseJSON && xhr.responseJSON.message) {
                    toastr.error(xhr.responseJSON.message);
                } else {
                    toastr.error("Something went wrong");
                }
            }
        });
    }
});

	</script>
	
	<script>
toastr.options = {
    "positionClass": "toast-top-center",
    "timeOut": "3000",
    "closeButton": true,
    "progressBar": true
};

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