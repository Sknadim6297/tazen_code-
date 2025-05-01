<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Prozim - Find a Professional and Book a Consultation by Appointment, Chat or Video call">
    <meta name="author" content="Ansonika">
    <title>Tazen-Professional register</title>

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
       .form-step {
        display: none;
     }
    .form-step.active {
        display: block;
    }
	</style>
</head>

<body>
	<nav id="menu" class="fake_menu"></nav>
	<div id="login">
		<aside>
			<h2 style="text-align: center">Professional Register</h2>
			<div class="access_social">
					<a href="#0" class="social_bt facebook">Register with Facebook</a>
					<a href="#0" class="social_bt google">Register with Google</a>
				</div>
            <div class="divider"><span>Or</span></div>
			<form id="registerForm" enctype="multipart/form-data">
				@csrf
			
				{{-- Step 1 - Basic Info --}}
				<div class="form-step step-1 active">
					<h4>Step 1 – Basic Info</h4>
					<div class="form-group">
						<input class="form-control" type="text" name="first_name" placeholder="First Name" required>
					</div>
					<div class="form-group">
						<input class="form-control" type="text" name="last_name" placeholder="Last Name" required>
					</div>
					<div class="form-group">
						<input class="form-control" type="email" name="email" placeholder="Email" required>
					</div>
					<div class="form-group">
						<input class="form-control" type="password" name="password" placeholder="Password" required>
					</div>
					<div class="form-group">
						<input class="form-control" type="password" name="password_confirmation" placeholder="Confirm Password" required>
					</div>
					<button type="button" class="btn_1 full-width next-btn">Next Step</button>
				</div>
			
				{{-- Step 2 - Professional Info --}}
				<div class="form-step step-2">
					<h4>Step 2 – Professional Info</h4>
					<div class="form-group">
						<input class="form-control" type="text" name="phone" placeholder="Phone Number" required>
					</div>
					<div class="form-group">
						<input class="form-control" type="text" name="specialization" placeholder="Specialization" required>
					</div>
					<div class="form-group">
						<input class="form-control" type="text" name="experience" placeholder="Experience" required>
					</div>
					<div class="form-group">
						<input class="form-control" type="text" name="starting_price" placeholder="Starting Price" required>
					</div>
					<div class="form-group">
						<input class="form-control" type="text" name="address" placeholder="Address" required>
					</div>
					<div class="form-group">
						<input class="form-control" type="text" name="education" placeholder="Education" required>
					</div>
					<div class="form-group">
						<textarea class="form-control" name="comments" placeholder="Comments"></textarea>
					</div>
					<div class="form-group">
						<textarea class="form-control" name="bio" placeholder="Short Bio" required></textarea>
					</div>
					<div style="display: flex; gap: 10px;">
					<button type="button" class="btn_1 full-width prev-btn">Previous</button>
					<button type="button" class="btn_1 full-width next-btn">Next Step</button>
				</div>
				</div>
			
				{{-- Step 3 - Document Uploads --}}
				<div class="form-step step-3">
					<h4>Step 3 – Document Uploads</h4>
					<div class="form-group">
						<label>Qualification Document</label>
						<input class="form-control" type="file" name="qualification_document" required>
					</div>
					<div class="form-group">
						<label>Aadhaar Card</label>
						<input class="form-control" type="file" name="aadhaar_card" required>
					</div>
					<div class="form-group">
						<label>PAN Card</label>
						<input class="form-control" type="file" name="pan_card" required>
					</div>
					<div class="form-group">
						<label>Profile Photo</label>
						<input class="form-control" type="file" name="profile_photo" required>
					</div>
					<div>
						<label for="gallery">Upload Gallery Images</label>
						<input class="form-control" type="file" name="gallery[]" multiple>
					</div>
					<div style="display: flex; gap: 10px; margin-top: 10px;">
					<button type="button" class="btn_1 full-width prev-btn">Previous</button>
					<button type="submit" class="btn_1 full-width">Submit</button>
				</div>
				</div>
			</form>
			
			
			<div class="copy">© Tazen</div>
		</aside>
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
	
	$('#registerForm').submit(function(e) {
    e.preventDefault();

    var formData = new FormData(this); 

    $.ajax({
        url: "{{ route('professional.register.submit') }}",
        type: "POST",
        data: formData,
        processData: false, 
        contentType: false, 
        headers: {
            "X-CSRF-TOKEN": $("meta[name='csrf-token']").attr("content")
        },
        success: function(response) {
            if (response.status === 'success') {
                toastr.success(response.message);
                setTimeout(function() {
                    window.location.href = "{{ route('professional.login') }}";
                }, 1500);
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