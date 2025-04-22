<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Prozim - Find a Professional and Book a Consultation by Appointment, Chat or Video call">
    <meta name="author" content="Ansonika">
    <title>Find a Professional and Book a Consultation by Appointment, Chat or Video call</title>

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
    <style>
		@import url('https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap');

		body {
			font-family: "Poppins";
		}
	</style>
</head>

<body id="register_bg">
	
	<nav id="menu" class="fake_menu"></nav>
	
	<div id="login">
		<aside>
			<figure>
				<a href="index-3.html"><img src="img/tazen logo-01.png" width="150" height="60" alt="" class="logo_sticky"></a>
			</figure>
			<div class="access_social">
					<a href="#0" class="social_bt facebook">Register with Facebook</a>
					<a href="#0" class="social_bt google">Register with Google</a>
				</div>
            <div class="divider"><span>Or</span></div>
			<form autocomplete="off">
				<div class="form-group">
					<input class="form-control" type="text" placeholder="Name">
					<i class="icon_pencil-edit"></i>
				</div>
				<div class="form-group">
					<input class="form-control" type="text" placeholder="Last Name">
					<i class="icon_pencil-edit"></i>
				</div>
				<div class="form-group">
					<input class="form-control" type="email" placeholder="Email">
					<i class="icon_mail_alt"></i>
				</div>
				<div class="form-group">
					<input class="form-control" type="password" id="password1" placeholder="Password">
					<i class="icon_lock_alt"></i>
				</div>
				<div class="form-group">
					<input class="form-control" type="password" id="password2" placeholder="Confirm Password">
					<i class="icon_lock_alt"></i>
				</div>
				<div id="pass-info" class="clearfix"></div>
				<a href="#0" class="btn_1 rounded full-width">Register Now!</a>
				<div class="text-center add_top_10">Already have an acccount? <strong><a href="login.html">Sign In</a></strong></div>
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
  
</body>
</html>