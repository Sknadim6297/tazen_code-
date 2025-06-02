<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="l">
    <meta name="author" content="Ansonika">
    <title>Tazen-Professional register</title>

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
</style>
</head>

<body>
	<nav id="menu" class="fake_menu"></nav>
	
	<div id="login"><figure>
				<a href="{{ route('home') }}"><img src="{{ asset('customer-css/assets/images/tazen_logo.png') }}" width="100" height="100" alt="" class="logo_sticky"></a>
			</figure>
		<div>
			<h2 class="heading-style">Professional Register</h2>
		</div>
			<form id="registerForm" enctype="multipart/form-data">
				@csrf
				{{-- Step 1 - Basic Info --}}
				<div class="form-step step-1 active">
		<div class="step-header">
  <h4 class="step-title">Basic Information</h4>
</div>
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
						<input class="form-control" type="text" name="phone" placeholder="Phone Number" required>
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
					<div class="step-header">
						<h4 class="step-title">Professional Info</h4>
					</div>

					<!-- Specialization Input -->
				<div class="form-group">
						<select class="form-control" style="padding-left: 39px;" name="specialization" required >
							<option value="">Select Specialization</option>
							<option value="Job Counselor & Career Counsellor">Job Counselor & Career Counsellor</option>
							<option value="Psychologists ">Psychologists </option>
							<option value="Dietician ">Dietician </option>
							<option value="Fitness Trainer">Fitness Trainer</option>
							<option value="Financial Experts">Financial Experts</option>
							<option value="Life Coach">Life Coach</option>
							<option value="Style Consultant">Style Consultant</option>
							<option value="Astrologer">Astrologer</option>
						</select>
					</div>
				
				<!-- Experience Input -->
<div class="form-group">
    <select class="form-control" style="padding-left: 39px;" name="experience" required>
        <option value="" disabled selected>Select Experience</option>
        <option value="0-2">0-2 years</option>
        <option value="2-4">2-4 years</option>
        <option value="4-6">4-6 years</option>
        <option value="6-8">6-8 years</option>
        <option value="8-10">8-10 years</option>
        <option value="10+">10+ years</option>
    </select>
</div>

	<!-- Starting Price Input -->
					<div class="form-group">
						<input class="form-control" type="text" name="starting_price" placeholder="Price per session (Rs.)" required>
					</div>
					<!-- Location Dropdown -->
					<div class="form-group">
						<select class="form-control" style="padding-left: 39px;" name="address" required >
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
					</div>
				
					<!-- Education 1 Input -->
					<div class="form-group">
						<input class="form-control" type="text" name="education" placeholder="Education" required>
					</div>
				
					<!-- Education 2 Input -->
					<div class="form-group">
						<input class="form-control" type="text" name="education2" placeholder="Additional Education" required>
					</div>
				
					<!-- Bio Textarea -->
					<div class="form-group">
						<textarea class="form-control" name="bio" style="padding-left: 39px;" placeholder="Short Bio" required></textarea>
					</div>
				
					<!-- Navigation Buttons -->
					<div style="display: flex; gap: 10px;">
						<button type="button" class="btn_1 full-width prev-btn">Previous</button>
						<button type="button" class="btn_1 full-width next-btn">Next Step</button>
					</div>
				</div>
				{{-- Step 3 - Document Uploads --}}
				<div class="form-step step-3">
					 <div class="step-header">
					<h4 class="step-title"> Document Uploads</h4>
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
    
    // Show loading overlay
    $('#loading-overlay').show();
    
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
            // Hide loading overlay
            $('#loading-overlay').hide();
            
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
            // Hide loading overlay
            $('#loading-overlay').hide();
            
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