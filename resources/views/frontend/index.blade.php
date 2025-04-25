<!-- /header -->
@extends('layouts.layout')
@section('styles')
   {{-- <link rel="stylesheet" href="{{ asset('admin/css/styles.css') }}" /> --}}
@endsection
@section('content')
	<main>
		<div class="header-video">
			<div id="hero_video">
				<div class="opacity-mask d-flex align-items-center" data-opacity-mask="rgba(0, 0, 0, 0.2)">
					<div class="container">
						<div class="row justify-content-md-start">
							<div class="col-xl-8 col-lg-10 col-md-8">
								<h1 class="text-start">Find a Professional</h1>
								<p class="text-start">Book a Consultation by Appointment, Chat or Video call</p>
								<form>
									<div class="d-flex justify-content-md-start">
										<div class="row g-0 custom-search-input">
											<div class="col-md-9">
												<div class="form-group">
													<input class="form-control" type="text"
														placeholder="Find a professional...">
												</div>
											</div>
											<div class="col-md-3">
												<input type="submit" value="Find">
											</div>
										</div>
										<!-- /row -->
									</div>
									<div class="search_trends new-search_trends">
										<h5>Trending:</h5>
										<ul class="new-ul-list-header">
											<li><a href="#0">doctor</a></li>
											<li><a href="#0">lawyer</a></li>
											<li><a href="#0">teacher</a></li>
											<li><a href="#0">psychologist</a></li>
										</ul>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>

			<!-- Video Tag to Add the Video -->
			<video class="header-video--media" autoplay loop muted>
				<source src="{{ asset('frontend/assets/video/hero-video.mp4') }}" type="video/mp4">
				Your browser does not support the video tag.
			</video>
		</div>
		<!-- /header-video -->
		<!-- fun facts sections  -->
		<section class="bg-light">
			<div class="container service-container py-5 ">
				<div class="row heading">
					<div class="col ">
						<div class="main_title center ">
							<span><em></em></span>
							<h2>Our Services</h2>
							<p>Lorem ipsum dolor sit amet consectetur adipisicing elit.</p>
						</div>
					</div>
				</div>

				<div class="container py-5">
					<div class="row">
						<div class="owl-carousel services-carousal">
							<div class="card">
								<div class="card-body one"></div>
								<div class="info mt-3 p-2">
									<div class="content-discover p-3">
										<div class="l">
											<p class="text-dark">job , career and business</p>
										</div>
										<div class="r">
											<button class="btn_1 book-now-btn">Book Now</button>
										</div>
									</div>
								</div>
							</div>
				
							<div class="card">
								<div class="card-body two"></div>
								<div class="info mt-3 p-2">
									<div class="content-discover p-3">
										<div class="l">
											<p class="text-dark">interior designer</p>
										</div>
										<div class="r">
											<button class="btn_1 book-now-btn">Book Now</button>
										</div>
									</div>
								</div>
							</div>
				
							<div class="card">
								<div class="card-body three"></div>
								<div class="info mt-3 p-2">
									<div class="content-discover p-3">
										<div class="l">
											<p class="text-dark">astrologer / priest</p>
										</div>
										<div class="r">
											<button class="btn_1 book-now-btn">Book Now</button>
										</div>
									</div>
								</div>
							</div>
				
							<div class="card">
								<div class="card-body four"></div>
								<div class="info mt-3 p-2">
									<div class="content-discover p-3">
										<div class="l">
											<p class="text-dark">fitness yoga zumba weight training</p>
										</div>
										<div class="r">
											<button class="btn_1 book-now-btn">Book Now</button>
										</div>
									</div>
								</div>
							</div>
				
							<div class="card">
								<div class="card-body five"></div>
								<div class="info mt-3 p-2">
									<div class="content-discover p-3">
										<div class="l">
											<p class="text-dark">style image consultant</p>
										</div>
										<div class="r">
											<button class="btn_1 book-now-btn">Book Now</button>
										</div>
									</div>
								</div>
							</div>
				
							<div class="card">
								<div class="card-body six"></div>
								<div class="info mt-3 p-2">
									<div class="content-discover p-3">
										<div class="l">
											<p class="text-dark">influencer for business</p>
										</div>
										<div class="r">
											<button class="btn_1 book-now-btn">Book Now</button>
										</div>
									</div>
								</div>
							</div>
				
							<div class="card">
								<div class="card-body seven"></div>
								<div class="info mt-3 p-2">
									<div class="content-discover p-3">
										<div class="l">
											<p class="text-dark">psychologist</p>
										</div>
										<div class="r">
											<button class="btn_1 book-now-btn">Book Now</button>
										</div>
									</div>
								</div>
							</div>
				
							<div class="card">
								<div class="card-body eight"></div>
								<div class="info mt-3 p-2">
									<div class="content-discover p-3">
										<div class="l">
											<p class="text-dark">Dieticians</p>
										</div>
										<div class="r">
											<button class="btn_1 book-now-btn">Book Now</button>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				
				<!-- Modal Structure -->
				<div id="mcqModal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
					<div class="modal-dialog modal-dialog-centered" role="document">
						<div class="modal-content">
							<div class="modal-header">
								<h5 class="modal-title">Service Questionnaire</h5>
								<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
							</div>
							<div class="modal-body">
								<form id="mcqForm">
									<!-- Question 1 -->
									<div class="question active" id="question1">
										<h6>Question 1: What is your primary reason for booking this service?</h6>
										<div class="form-check">
											<input class="form-check-input" type="radio" name="q1" id="q1a" value="Personal development">
											<label class="form-check-label" for="q1a">Personal development</label>
										</div>
										<div class="form-check">
											<input class="form-check-input" type="radio" name="q1" id="q1b" value="Professional growth">
											<label class="form-check-label" for="q1b">Professional growth</label>
										</div>
										<div class="form-check">
											<input class="form-check-input" type="radio" name="q1" id="q1c" value="Health reasons">
											<label class="form-check-label" for="q1c">Health reasons</label>
										</div>
										<div class="form-check">
											<input class="form-check-input" type="radio" name="q1" id="q1d" value="Other">
											<label class="form-check-label" for="q1d">Other</label>
										</div>
									</div>
									
									<!-- Question 2 -->
									<div class="question" id="question2">
										<h6>Question 2: How did you hear about our services?</h6>
										<div class="form-check">
											<input class="form-check-input" type="radio" name="q2" id="q2a" value="Social media">
											<label class="form-check-label" for="q2a">Social media</label>
										</div>
										<div class="form-check">
											<input class="form-check-input" type="radio" name="q2" id="q2b" value="Friend/Family">
											<label class="form-check-label" for="q2b">Friend/Family</label>
										</div>
										<div class="form-check">
											<input class="form-check-input" type="radio" name="q2" id="q2c" value="Online search">
											<label class="form-check-label" for="q2c">Online search</label>
										</div>
										<div class="form-check">
											<input class="form-check-input" type="radio" name="q2" id="q2d" value="Other">
											<label class="form-check-label" for="q2d">Other</label>
										</div>
									</div>
									
									<!-- Question 3 -->
									<div class="question" id="question3">
										<h6>Question 3: What is your preferred method of consultation?</h6>
										<div class="form-check">
											<input class="form-check-input" type="radio" name="q3" id="q3a" value="In-person">
											<label class="form-check-label" for="q3a">In-person</label>
										</div>
										<div class="form-check">
											<input class="form-check-input" type="radio" name="q3" id="q3b" value="Video call">
											<label class="form-check-label" for="q3b">Video call</label>
										</div>
										<div class="form-check">
											<input class="form-check-input" type="radio" name="q3" id="q3c" value="Phone call">
											<label class="form-check-label" for="q3c">Phone call</label>
										</div>
										<div class="form-check">
											<input class="form-check-input" type="radio" name="q3" id="q3d" value="No preference">
											<label class="form-check-label" for="q3d">No preference</label>
										</div>
									</div>
									
									<!-- Question 4 -->
									<div class="question" id="question4">
										<h6>Question 4: How soon would you like to schedule the service?</h6>
										<div class="form-check">
											<input class="form-check-input" type="radio" name="q4" id="q4a" value="Within a week">
											<label class="form-check-label" for="q4a">Within a week</label>
										</div>
										<div class="form-check">
											<input class="form-check-input" type="radio" name="q4" id="q4b" value="Within a month">
											<label class="form-check-label" for="q4b">Within a month</label>
										</div>
										<div class="form-check">
											<input class="form-check-input" type="radio" name="q4" id="q4c" value="Not sure yet">
											<label class="form-check-label" for="q4c">Not sure yet</label>
										</div>
										<div class="form-check">
											<input class="form-check-input" type="radio" name="q4" id="q4d" value="Just exploring options">
											<label class="form-check-label" for="q4d">Just exploring options</label>
										</div>
									</div>
								</form>
							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
								<button type="button" class="btn btn-primary" id="prevBtn" style="display:none;">Previous</button>
								<button type="button" class="btn btn-primary" id="nextBtn">Next</button>
								<button type="button" class="btn btn-success" id="submitBtn" style="display:none;">Submit</button>
							</div>
						</div>
					</div>
				</div>
				

				<!-- Modal Structure -->
				{{-- <div id="mcqModal" class="modal fade" tabindex="-1" role="dialog">
					<div class="modal-dialog" role="document">
						<div class="modal-content">
							<div class="modal-header">
								<h5 class="modal-title">Questionnaire</h5>
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									<span aria-hidden="true">&times;</span>
								</button>
							</div>
							<div class="modal-body">
								<form id="mcqForm">
									<!-- Question 1 -->
									<div class="question active" id="question1">
										<h6>Question 1: What is your primary reason for booking this service?</h6>
										<div class="form-check">
											<input class="form-check-input" type="radio" name="q1" id="q1a" value="a">
											<label class="form-check-label" for="q1a">Personal development</label>
										</div>
										<div class="form-check">
											<input class="form-check-input" type="radio" name="q1" id="q1b" value="b">
											<label class="form-check-label" for="q1b">Professional growth</label>
										</div>
										<div class="form-check">
											<input class="form-check-input" type="radio" name="q1" id="q1c" value="c">
											<label class="form-check-label" for="q1c">Health reasons</label>
										</div>
										<div class="form-check">
											<input class="form-check-input" type="radio" name="q1" id="q1d" value="d">
											<label class="form-check-label" for="q1d">Other</label>
										</div>
									</div>

									<!-- Question 2 -->
									<div class="question" id="question2">
										<h6>Question 2: How did you hear about our services?</h6>
										<div class="form-check">
											<input class="form-check-input" type="radio" name="q2" id="q2a" value="a">
											<label class="form-check-label" for="q2a">Social media</label>
										</div>
										<div class="form-check">
											<input class="form-check-input" type="radio" name="q2" id="q2b" value="b">
											<label class="form-check-label" for="q2b">Friend/Family</label>
										</div>
										<div class="form-check">
											<input class="form-check-input" type="radio" name="q2" id="q2c" value="c">
											<label class="form-check-label" for="q2c">Online search</label>
										</div>
										<div class="form-check">
											<input class="form-check-input" type="radio" name="q2" id="q2d" value="d">
											<label class="form-check-label" for="q2d">Other</label>
										</div>
									</div>

									<!-- Question 3 -->
									<div class="question" id="question3">
										<h6>Question 3: What is your preferred method of consultation?</h6>
										<div class="form-check">
											<input class="form-check-input" type="radio" name="q3" id="q3a" value="a">
											<label class="form-check-label" for="q3a">In-person</label>
										</div>
										<div class="form-check">
											<input class="form-check-input" type="radio" name="q3" id="q3b" value="b">
											<label class="form-check-label" for="q3b">Video call</label>
										</div>
										<div class="form-check">
											<input class="form-check-input" type="radio" name="q3" id="q3c" value="c">
											<label class="form-check-label" for="q3c">Phone call</label>
										</div>
										<div class="form-check">
											<input class="form-check-input" type="radio" name="q3" id="q3d" value="d">
											<label class="form-check-label" for="q3d">No preference</label>
										</div>
									</div>

									<!-- Question 4 -->
									<div class="question" id="question4">
										<h6>Question 4: How soon would you like to schedule the service?</h6>
										<div class="form-check">
											<input class="form-check-input" type="radio" name="q4" id="q4a" value="a">
											<label class="form-check-label" for="q4a">Within a week</label>
										</div>
										<div class="form-check">
											<input class="form-check-input" type="radio" name="q4" id="q4b" value="b">
											<label class="form-check-label" for="q4b">Within a month</label>
										</div>
										<div class="form-check">
											<input class="form-check-input" type="radio" name="q4" id="q4c" value="c">
											<label class="form-check-label" for="q4c">Not sure yet</label>
										</div>
										<div class="form-check">
											<input class="form-check-input" type="radio" name="q4" id="q4d" value="d">
											<label class="form-check-label" for="q4d">Just exploring options</label>
										</div>
									</div>
								</form>
							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
								<button type="button" class="btn btn-primary" id="prevBtn"
									style="display:none;">Previous</button>
								<button type="button" class="btn btn-primary" id="nextBtn">Next</button>
								<button type="button" class="btn btn-success" id="submitBtn"
									style="display:none;">Submit</button>
							</div>
						</div>
					</div>
				</div> --}}
                </main>

			</div>
		</section>
		<!-- first popups  -->
		<div id="progressModel" class="model">

			<div class="model-content mx-auto">
				<span class="close" id="closeModel">&times;</span>
				<div class="img">

				</div>

				<div class="inside-question-model">
					<div class="progress-container">
						<div class="progress-bars" id="progressBar"></div>
					</div>
					<h1 class="headline headline-one text-center active" style="font-size: 30px;">You need counselling
						for which field ?
					</h1>
					<h1 class="headline headline-two text-center" style="font-size: 30px;">Which stage of education do
						you need counselling for?</h1>
					<h1 class="headline headline-three text-center" style="font-size: 30px;">What type of counselling do
						you need?</h1>
					<h1 class="headline headline-four text-center" style="font-size: 30px;">Please enter your field of
						specialization and degree (only applicable)</h1>
					<form action="" id="progressForm">


						<div class="step selection-step">

							<div class="question question-1">
								<label>
									<input type="checkbox" name="option" id="edu-check" value="option-1"><span
										class="text-span">
										Education
									</span>
								</label>
							</div>

							<div class="question question-2">
								<label>
									<input type="checkbox" name="option" value="option-2"><span class="text-span">
										Job
									</span>
								</label>
							</div>

							<div class="question question-3">
								<label>
									<input type="checkbox" name="option" value="option-3"><span class="text-span">
										Business
									</span>
								</label>
							</div>

						</div>
						<div class="step education-step-one">

							<div class="question">
								<label><input type="radio" name="option" value="elementary">Elementary (class
									1-8)</label>
							</div>
							<div class="question">
								<label><input type="radio" name="option" value="secondary">Secondary school (Class 9-12)
									//need parent consent</label>
							</div>
							<div class="question">
								<label><input type="radio" name="option" value="bachelors">Bachelor’s Degree</label>
							</div>
							<div class="question">
								<label><input type="radio" name="option" value="masters">Master Degree</label>
							</div>
							<div class="question">
								<label><input type="radio" name="option" value="doctoral">Doctoral Degree</label>
							</div>
							<div class="question">
								<label><input type="radio" name="option" value="professional">Parallel Professional
									courses</label>
							</div>
							<div class="question">
								<label><input type="radio" name="option" value="diploma">Diploma Courses</label>
							</div>
							<div class="question">
								<label>
									<input type="radio" name="option" value="others" id="othersOption">Others (Please
									Specify)
								</label>
								<input type="text" id="othersInput" placeholder="Please specify..."
									style="display: none;">
							</div>
							<!-- Input box for 'Others' -->

						</div>




						<div class="step education-step-two">
							<h2>step 4</h2>
							<label>
								<input type="radio" name="option" value="option-1" required>option 5
							</label><br>
							<label>
								<input type="radio" name="option" value="option-1" required>option 6
							</label><br>
							<label>
								<input type="radio" name="option" value="option-1" required>option 7
							</label><br>
						</div>
						<div class="step education-step-three">
							<h2>step 4</h2>
							<label>
								<input type="radio" name="option" value="option-1" required>option 6
							</label><br>
							<label>
								<input type="radio" name="option" value="option-1" required>option 7
							</label><br>
							<label>
								<input type="radio" name="option" value="option-1" required>option 8
							</label><br>
						</div>
						<div class="button-area d-flex">
							<div class="col-lg-6 text-start one-btn">
								<button class=" btn new-style-form-btn" id="back-control">Back</button>
							</div>
							<div class="col-lg-6 text-end two-btn">
								<button class=" btn new-style-form-btn" id="progress-control">Continue</button>
							</div>


						</div>
					</form>
				</div>
			</div>
		</div>
		<!-- second popups  -->

		<section class=" home-about-section py-5" style="background-color: #FFF2E1;">
			<div class="container">
				<div class="row">
					<div class="col-lg-6">
						<div class="about-inside-content">
							<small>--- About Us ---</small>
							<div class="main-about-content">
								<h1>Explore Our Services And Boost Your Online Presence</h1>
								<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem
									Ipsum has been the industry’s standard dummy text ever since the 1500s, when an
									unknown printer took a galley of type and scrambled it to make a type specimen book.
									It has survived not only five centuries, but also the leap into electronic
									typesetting, remaining essentially unchanged.</p>

								<div class="list-data-div">
									<ul>
										<li>
											<i class="fa fa-check"></i>
											<span>Lorem Ipsum is simply dummy text of the printing.</span>
										</li>
										<li>
											<i class="fa fa-check"></i>
											<span>Lorem Ipsum is simply dummy text of the printing.</span>
										</li>
									</ul>

								</div>
								<div class="button-div">
									<button class=" btn_1 medium">Get Started</button>
									<a href="about-us.html"><button class="btn new-custom-btn">Discover
											More</button></a>
								</div>
							</div>
						</div>
					</div>
					<div class="col-lg-6 position-relative d-flex align-item-center  justify-content-md-center">
						<div class="right-img">
							<img src="img/new-icons/about-home-picture.png" alt="">
						</div>
						<div class="ab-count d-flex justify-content-center align-items-center flex-column text-center">
							<div class="d-flex align-items-center justify-content-center">
								<h2 class="count">12</h2>
								<h2>+</h2>
							</div>
							<p>years of experience</p>
						</div>
					</div>
				</div>
			</div>
		</section>


		<section class="bg-light fun-facts-cards py-5">
			<div class="container">
				<div class="main_title center">
					<span><em></em></span>
					<h2>Why Choose Us</h2>
					<p>Cum doctus civibus efficiantur in imperdiet deterruisset.</p>
				</div>
			</div>
			<div class="container my-5">
				<div class="row">
					<div class="col-lg-6 left">
						<div class="row">
							<div class="col-lg-6 first-card">
								<div class="card card-one funfact-card">

									<div class="icon-content">
										<div class="text col-lg-6">
											<p>Lorem, ipsum.</p>
										</div>
										<div class="icon col-lg-6">
											<i class="fa-solid fa-brain-circuit"></i>
										</div>
									</div>
									<div class="text-content">
										<h3>CUSTOMIZED SOLUTIONS</h3>
										<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry.
											Lorem Ipsum has been the industry’s standard dummy text ever.</p>
									</div>

								</div>
							</div>
							<div class="col-lg-6 second-card">
								<div class="card card-two funfact-card">
									<div class="icon-content">
										<div class="text col-lg-6">
											<p>Lorem, ipsum.</p>
										</div>
										<div class="icon col-lg-6">
											<i class="fa-solid fa-lightbulb-on"></i>
										</div>
									</div>
									<div class="text-content">
										<h3>ROI-DRIVEN APPROACH</h3>
										<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry.
											Lorem Ipsum has been the industry’s standard dummy text ever.</p>
									</div>
								</div>
							</div>
							<div class="col-lg-12 third-card">
								<div class="card card-three funfact-card">
									<div class="icon-content">
										<div class="text col-lg-6">
											<p>Lorem, ipsum.</p>
										</div>
										<div class="icon col-lg-6">
											<i class="fa-solid fa-swatchbook"></i>
										</div>
									</div>
									<div class="text-content">
										<h3>CREATIVE SOLUTION</h3>
										<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry.
											Lorem Ipsum has been the industry’s standard dummy text ever.</p>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-lg-6 right">
						<div class="row">
							<div class="col-lg-12 third-card">
								<div class="card card-three funfact-card">
									<div class="icon-content">
										<div class="text col-lg-6">
											<p>Lorem, ipsum.</p>
										</div>
										<div class="icon col-lg-6">
											<i class="fa-solid fa-people-group"></i>
										</div>
									</div>
									<div class="text-content">
										<h3>EXPERT TEAM</h3>
										<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry.
											Lorem Ipsum has been the industry’s standard dummy text ever.</p>
									</div>
								</div>
							</div>
							<div class="col-lg-6 first-card">
								<div class="card card-one funfact-card">
									<div class="icon-content">
										<div class="text col-lg-6">
											<p>Lorem, ipsum.</p>
										</div>
										<div class="icon col-lg-6">
											<i class="fa-solid fa-brain-circuit"></i>
										</div>
									</div>
									<div class="text-content">
										<h3>CUSTOMIZED SOLUTIONS</h3>
										<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry.
											Lorem Ipsum has been the industry’s standard dummy text ever.</p>
									</div>
								</div>
							</div>
							<div class="col-lg-6 second-card">
								<div class="card card-two funfact-card">
									<div class="icon-content">
										<div class="text col-lg-6">
											<p>Lorem, ipsum.</p>
										</div>
										<div class="icon col-lg-6">
											<i class="fa-solid fa-brain-circuit"></i>
										</div>
									</div>
									<div class="text-content">
										<h3>ROI-DRIVEN APPROACH</h3>
										<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry.
											Lorem Ipsum has been the industry’s standard dummy text ever.</p>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>


		<!-- /bg_gray -->

		<section style="background-color: #FFF2E1;">
			<div class="container margin_60_40">
				<div class="main_title center">
					<span><em></em></span>
					<h2>Events</h2>
					<p>Cum doctus civibus efficiantur in imperdiet deterruisset.</p>
				</div>
				<div class="row add_bottom_15">
					<div class="col-xl-4 col-lg-6 col-md-6 col-sm-6">
						<div class="strip">
							<figure>
								<a href="" class="wish_bt"><i class="icon_heart"></i></a>
								<img src="img/event/astrologer event.jpg" data-src="img/event/astrologer event.jpg"
									class="img-fluid lazy" alt="">
								<a href="all-event.html" class="strip_info">
									<div class="item_title">
										<h3>Dr. Maria Cornfield</h3>
										<small>Pediatrician, Psychologist ...</small>
									</div>
								</a>
							</figure>
							<ul>
								<li><a href="#0" class="tooltip-1" data-bs-toggle="tooltip" data-bs-placement="bottom"
										title="Available Appointment"><i class="icon-users"></i></a></li>
								<li><a href="#0" class="tooltip-1" data-bs-toggle="tooltip" data-bs-placement="bottom"
										title="Available Chat"><i class="icon-chat"></i></a></li>
								<li><a href="#0" class="tooltip-1" data-bs-toggle="tooltip" data-bs-placement="bottom"
										title="Available Video Call"><i class="icon-videocam"></i></a></li>
								<li>
									<div class="score"><span>Superb<em>350 Reviews</em></span><strong>8.9</strong></div>
								</li>
							</ul>
						</div>
					</div>
					<!-- /strip grid -->
					<div class="col-xl-4 col-lg-6 col-md-6 col-sm-6">
						<div class="strip">
							<figure>
								<a href="" class="wish_bt"><i class="icon_heart"></i></a>
								<img src="img/event/fitness yoga event.jpg" data-src="img/event/fitness yoga event.jpg"
									class="img-fluid lazy" alt="">
								<a href="all-event.html" class="strip_info">
									<div class="item_title">
										<h3>Lucy Shoemaker</h3>
										<small>Lawyer</small>
									</div>
								</a>
							</figure>
							<ul>
								<li><a href="#0" class="tooltip-1" data-bs-toggle="tooltip" data-bs-placement="bottom"
										title="Available Appointment"><i class="icon-users"></i></a></li>
								<li><a href="#0" class="tooltip-1" data-bs-toggle="tooltip" data-bs-placement="bottom"
										title="Available Chat"><i class="icon-chat"></i></a></li>
								<li>
									<div class="score"><span>Superb<em>350 Reviews</em></span><strong>8.9</strong></div>
								</li>
							</ul>
						</div>
					</div>
					<!-- /strip grid -->
					<div class="col-xl-4 col-lg-6 col-md-6 col-sm-6">
						<div class="strip">
							<figure>
								<a href="" class="wish_bt"><i class="icon_heart"></i></a>
								<img src="img/event/influencer event.jpg" data-src="img/event/influencer event.jpg"
									class="img-fluid lazy" alt="">
								<a href="all-event.html" class="strip_info">
									<div class="item_title">
										<h3>Prof. Luke Lachinet</h3>
										<small>Math Teacher</small>
									</div>
								</a>
							</figure>
							<ul>
								<li><a href="#0" class="tooltip-1" data-bs-toggle="tooltip" data-bs-placement="bottom"
										title="Available Appointment"><i class="icon-users"></i></a></li>
								<li><a href="#0" class="tooltip-1" data-bs-toggle="tooltip" data-bs-placement="bottom"
										title="Available Video Call"><i class="icon-videocam"></i></a></li>
								<li>
									<div class="score"><span>Superb<em>350 Reviews</em></span><strong>8.9</strong></div>
								</li>
							</ul>
						</div>
					</div>
					<!-- /strip grid -->
					<div class="col-xl-4 col-lg-6 col-md-6 col-sm-6">
						<div class="strip">
							<figure>
								<a href="" class="wish_bt"><i class="icon_heart"></i></a>
								<img src="img/event/interior designer event.jpg"
									data-src="img/event/interior designer event.jpg" class="img-fluid lazy" alt="">
								<a href="all-event.html" class="strip_info">
									<div class="item_title">
										<h3>Dr. Marta Rainwater</h3>
										<small>Psychologist</small>
									</div>
								</a>
							</figure>
							<ul>
								<li><a href="#0" class="tooltip-1" data-bs-toggle="tooltip" data-bs-placement="bottom"
										title="Available Chat"><i class="icon-chat"></i></a></li>
								<li><a href="#0" class="tooltip-1" data-bs-toggle="tooltip" data-bs-placement="bottom"
										title="Available Video Call"><i class="icon-videocam"></i></a></li>
								<li>
									<div class="score"><span>Superb<em>350 Reviews</em></span><strong>8.9</strong></div>
								</li>
							</ul>
						</div>
					</div>
					<!-- /strip grid -->
					<div class="col-xl-4 col-lg-6 col-md-6 col-sm-6">
						<div class="strip">
							<figure>
								<a href="" class="wish_bt"><i class="icon_heart"></i></a>
								<img src="img/event/job career business event.jpg"
									data-src="img/event/job career business event.jpg" class="img-fluid lazy" alt="">
								<a href="all-event.html" class="strip_info">
									<div class="item_title">
										<h3>Tom Manzone</h3>
										<small>Lawyer</small>
									</div>
								</a>
							</figure>
							<ul>
								<li><a href="#0" class="tooltip-1" data-bs-toggle="tooltip" data-bs-placement="bottom"
										title="Available Chat"><i class="icon-chat"></i></a></li>
								<li><a href="#0" class="tooltip-1" data-bs-toggle="tooltip" data-bs-placement="bottom"
										title="Available Video Call"><i class="icon-videocam"></i></a></li>
								<li>
									<div class="score"><span>Superb<em>350 Reviews</em></span><strong>8.9</strong></div>
								</li>
							</ul>
						</div>
					</div>
					<!-- /strip grid -->
					<div class="col-xl-4 col-lg-6 col-md-6 col-sm-6">
						<div class="strip">
							<figure>
								<a href="" class="wish_bt"><i class="icon_heart"></i></a>
								<img src="img/event/psychologist event.jpg" data-src="img/event/psychologist event.jpg"
									class="img-fluid lazy" alt="">
								<a href="all-event.html" class="strip_info">
									<div class="item_title">
										<h3>Carl Cornfield</h3>
										<small>Accountant</small>
									</div>
								</a>
							</figure>
							<ul>
								<li><a href="#0" class="tooltip-1" data-bs-toggle="tooltip" data-bs-placement="bottom"
										title="Available Appointment"><i class="icon-users"></i></a></li>
								<li><a href="#0" class="tooltip-1" data-bs-toggle="tooltip" data-bs-placement="bottom"
										title="Available Chat"><i class="icon-chat"></i></a></li>
								<li>
									<div class="score"><span>Superb<em>350 Reviews</em></span><strong>8.9</strong></div>
								</li>
							</ul>
						</div>
					</div>
					<!-- /strip grid -->
				</div>
				<!-- /row -->

				<p class="text-center"><a href="event-list.html" class="btn_1 medium">Start Searching</a></p>
			</div>
		</section>
		<!-- /container -->

		<div class="bg_gray">
			<div class="container margin_60_40 how">
				<div class="main_title center">
					<span><em></em></span>
					<h2>How does it work?</h2>
					<p>Cum doctus civibus efficiantur in imperdiet deterruisset.</p>
				</div>
				<div class="row justify-content-center align-items-center add_bottom_45">
					<div class="col-lg-5">
						<div class="box_about">
							<strong>1</strong>
							<h3>Search for a Professional</h3>
							<p>Search over 12.000 verifyed professionals that match your criteria.</p>
							<img src="data:image/gif;base64,R0lGODlhAQABAIAAAP///wAAACH5BAEAAAAALAAAAAABAAEAAAICRAEAOw=="
								data-src="img/services-pic/arrow_about.png" alt="" class="arrow_1 lazy">
						</div>
					</div>
					<div class="col-lg-5 pl-lg-5 text-center d-none d-lg-block">
						<figure><img
								src="data:image/gif;base64,R0lGODlhAQABAIAAAP///wAAACH5BAEAAAAALAAAAAABAAEAAAICRAEAOw=="
								data-src="img/services-pic/about_1.png" alt="" class="img-fluid lazy" width="180"
								height="180"></figure>
					</div>
				</div>
				<!-- /row -->
				<div class="row justify-content-center align-items-center add_bottom_45">
					<div class="col-lg-5 pr-lg-5 text-center d-none d-lg-block">
						<figure><img
								src="data:image/gif;base64,R0lGODlhAQABAIAAAP///wAAACH5BAEAAAAALAAAAAABAAEAAAICRAEAOw=="
								data-src="img/services-pic/about_2.png" alt="" class="img-fluid lazy" width="180"
								height="180"></figure>
					</div>
					<div class="col-lg-5">
						<div class="box_about">
							<strong>2</strong>
							<h3>View Professional Profile</h3>
							<p>View professional introduction and read reviews from other customers.</p>
							<img src="data:image/gif;base64,R0lGODlhAQABAIAAAP///wAAACH5BAEAAAAALAAAAAABAAEAAAICRAEAOw=="
								data-src="img/services-pic/arrow_about.png" alt="" class="arrow_2 lazy">
						</div>
					</div>
				</div>
				<!-- /row -->
				<div class="row justify-content-center align-items-center add_bottom_25">
					<div class="col-lg-5">
						<div class="box_about">
							<strong>3</strong>
							<h3>Enjoy the Consultation</h3>
							<p>Connect with your professional booking an appointment, via chat or video call!</p>
						</div>
					</div>
					<div class="col-lg-5 pl-lg-5 text-center d-none d-lg-block">
						<figure><img
								src="data:image/gif;base64,R0lGODlhAQABAIAAAP///wAAACH5BAEAAAAALAAAAAABAAEAAAICRAEAOw=="
								data-src="img/services-pic/group.png" alt="" class="img-fluid lazy" width="180"
								height="180"></figure>
					</div>
				</div>
				<!-- /row -->
			</div>
			<!-- /container -->
		</div>
		<!-- /bg_gray -->


		<!-- testimonials start  -->
		<!-- TESTIMONIALS -->



		<!-- <section id="slider " class="py-5">
			<div class="container">
				<div class="row heading">
					<div class="col ">
						<div class="main_title center ">
							<span><em></em></span>
							<h2>Our Testimonials</h2>
							<p>Great People Colaborate with us</p>
						</div>
					</div>
				</div>
				<div class="slider">
					<div class="owl-carousel testimonial-carousal">
						<div class="slider-card container" id="openPopups">
							<div class="d-flex main-content align-item-center mb-4">
								<img src="img/slides/testimonials/img-1.jpg" alt="">
								<div
									class="information ms-4 d-flex flex-column justify-content-center align-item-center ">
									<h5>Elem santiago</h5>
									<small>abc pvt. ltd.</small>
								</div>
							</div>
							<hr>

							<p class="mb-5">Lorem ipsum dolor sit amet consectetur adipisicing elit. Odit placeat
								accusamus doloribus, ipsam non repellendus maxime nesciunt repudiandae voluptatem
								provident.
							</p>
							<div class="rating">
								<i class="fa-solid fa-star"></i>
								<i class="fa-solid fa-star"></i>
								<i class="fa-solid fa-star"></i>
								<i class="fa-regular fa-star"></i>
								<i class="fa-regular fa-star"></i>
							</div>
						</div>

						<div class="slider-card container" id="openPopups">
							<div class="d-flex main-content align-item-center mb-4">
								<img src="img/slides/testimonials/img-2.jpg" alt="">
								<div
									class="information ms-4 d-flex flex-column justify-content-center align-item-center ">
									<h5>Elem santiago</h5>
									<small>abc pvt. ltd.</small>
								</div>
							</div>
							<hr>

							<p class="mb-5">Lorem ipsum dolor sit amet consectetur adipisicing elit. Odit placeat
								accusamus doloribus, ipsam non repellendus maxime nesciunt repudiandae voluptatem
								provident.
							</p>
							<div class="rating">
								<i class="fa-solid fa-star"></i>
								<i class="fa-solid fa-star"></i>
								<i class="fa-solid fa-star"></i>
								<i class="fa-regular fa-star"></i>
								<i class="fa-regular fa-star"></i>
							</div>
						</div>

						<div class="slider-card container" id="openPopups">
							<div class="d-flex main-content align-item-center mb-4">
								<img src="img/slides/testimonials/img-3.jpg" alt="">
								<div
									class="information ms-4 d-flex flex-column justify-content-center align-item-center ">
									<h5>Elem santiago</h5>
									<small>abc pvt. ltd.</small>
								</div>
							</div>
							<hr>

							<p class="mb-5">Lorem ipsum dolor sit amet consectetur adipisicing elit. Odit placeat
								accusamus doloribus, ipsam non repellendus maxime nesciunt repudiandae voluptatem
								provident.
							</p>
							<div class="rating">
								<i class="fa-solid fa-star"></i>
								<i class="fa-solid fa-star"></i>
								<i class="fa-solid fa-star"></i>
								<i class="fa-regular fa-star"></i>
								<i class="fa-regular fa-star"></i>
							</div>
						</div>

						<div class="slider-card container" id="openPopups">
							<div class="d-flex main-content align-item-center mb-4">
								<img src="img/slides/testimonials/img-4.jpg" alt="">
								<div
									class="information ms-4 d-flex flex-column justify-content-center align-item-center ">
									<h5>Elem santiago</h5>
									<small>abc pvt. ltd.</small>
								</div>
							</div>
							<hr>

							<p class="mb-5">Lorem ipsum dolor sit amet consectetur adipisicing elit. Odit placeat
								accusamus doloribus, ipsam non repellendus maxime nesciunt repudiandae voluptatem
								provident.
							</p>
							<div class="rating">
								<i class="fa-solid fa-star"></i>
								<i class="fa-solid fa-star"></i>
								<i class="fa-solid fa-star"></i>
								<i class="fa-regular fa-star"></i>
								<i class="fa-regular fa-star"></i>
							</div>
						</div>

						<div class="slider-card container" id="openPopups">
							<div class="d-flex main-content align-item-center mb-4">
								<img src="img/slides/testimonials/img-5.jpg" alt="">
								<div
									class="information ms-4 d-flex flex-column justify-content-center align-item-center ">
									<h5>Elem santiago</h5>
									<small>abc pvt. ltd.</small>
								</div>
							</div>
							<hr>

							<p class="mb-5">Lorem ipsum dolor sit amet consectetur adipisicing elit. Odit placeat
								accusamus doloribus, ipsam non repellendus maxime nesciunt repudiandae voluptatem
								provident.
							</p>
							<div class="rating">
								<i class="fa-solid fa-star"></i>
								<i class="fa-solid fa-star"></i>
								<i class="fa-solid fa-star"></i>
								<i class="fa-regular fa-star"></i>
								<i class="fa-regular fa-star"></i>
							</div>
						</div>

						<div class="slider-card container" id="openPopups">
							<div class="d-flex main-content align-item-center mb-4">
								<img src="img/slides/testimonials/img-6.jpg" alt="">
								<div
									class="information ms-4 d-flex flex-column justify-content-center align-item-center ">
									<h5>Elem santiago</h5>
									<small>abc pvt. ltd.</small>
								</div>
							</div>
							<hr>

							<p class="mb-5">Lorem ipsum dolor sit amet consectetur adipisicing elit. Odit placeat
								accusamus doloribus, ipsam non repellendus maxime nesciunt repudiandae voluptatem
								provident.
							</p>
							<div class="rating">
								<i class="fa-solid fa-star"></i>
								<i class="fa-solid fa-star"></i>
								<i class="fa-solid fa-star"></i>
								<i class="fa-regular fa-star"></i>
								<i class="fa-regular fa-star"></i>
							</div>
						</div>



					</div>
				</div>
			</div>
		</section> -->
		<!-- ====== 1.10. Testimonials section ====== -->
		<section class="ttm-row padding_top_zero-section ttm-bgcolor-white clearfix testimonial-new">
			<div class="container-fluid">
				<!-- row -->
				<div class="row">
					<div class="col-lg-12 col-md-12 col-sm-12 ttm-box-col-wrapper m-auto">
						<div class="main_title center">
							<span><em></em></span>
							<h2>TESTIMONIALS</h2>
							<p>More than 10k 5-star reviews</p>
						</div>
					</div>
				</div>
				<div class="row slick_slider "
					data-slick='{"slidesToShow":4, "slidesToScroll": 1, "arrows":false, "autoplay":true, "dots":false, "infinite":true, "responsive":[{"breakpoint":1199,"settings": {"slidesToShow": 3}},{"breakpoint":992,"settings":{"slidesToShow": 2}},{"breakpoint":767,"settings":{"slidesToShow": 2}}, {"breakpoint":600,"settings":{"slidesToShow": 1}}]}'>
					<div class="col-md-4 col-sm-12 ttm-box-col-wrapper">
						<div class="testimonial-box">
							<div class="testimonial-content bg-lavender mb-15">
								Excepteur sint occaecat cupidatat non
								proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
							</div>
							<div class="testimonial-img bg-blue">
								<img src="assets/images/testimonial/1.png">
							</div>
						</div>
					</div>
					<div class="col-md-4 col-sm-12 ttm-box-col-wrapper">
						<div class="testimonial-box ">
							<div class="testimonial-img bg-pink mb-15">
								<img src="assets/images/testimonial/2.png">
							</div>
							<div class="testimonial-content bg-green">
								Excepteur sint occaecat cupidatat non
								proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
							</div>
						</div>
					</div>
					<div class="col-md-4 col-sm-12 ttm-box-col-wrapper">
						<div class="testimonial-box">
							<div class="testimonial-content mb-15">
								Excepteur sint occaecat cupidatat non
								proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
							</div>
							<div class="testimonial-img">
								<img src="assets/images/testimonial/3.png">
							</div>
						</div>
					</div>
					<div class="col-md-4 col-sm-12 ttm-box-col-wrapper">
						<div class="testimonial-box ">
							<div class="testimonial-img bg-green mb-15">
								<img src="assets/images/testimonial/4.png">
							</div>
							<div class="testimonial-content bg-pink">
								Excepteur sint occaecat cupidatat non
								proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
							</div>
						</div>
					</div>
					<div class="col-md-4 col-sm-12 ttm-box-col-wrapper">
						<div class="testimonial-box">
							<div class="testimonial-content bg-lavender mb-15">
								Excepteur sint occaecat cupidatat non
								proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
							</div>
							<div class="testimonial-img bg-blue">
								<img src="assets/images/testimonial/5.png">
							</div>
						</div>
					</div>
					<div class="col-md-4 col-sm-12 ttm-box-col-wrapper">
						<div class="testimonial-box">
							<div class="testimonial-img mb-15 bg-green">
								<img src="assets/images/testimonial/3.png">
							</div>
							<div class="testimonial-content bg-pink">
								Excepteur sint occaecat cupidatat non
								proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>
		<!-- ====== End of 1.10. Testimonials section ====== -->
		<!-- END OF TESTIMONIALS -->
		<!-- testimonials end  -->
		<!-- blog -->
		<div class="full-row bg-light py-5 home-blog-section">
			<div class="container">
				<div class="row heading">
					<div class="col ">
						<div class="main_title center ">
							<span><em></em></span>
							<h2>Our Recent Blogs</h2>
							<p>Cum doctus civibus efficiantur in imperdiet deterruisset</p>
						</div>
					</div>
				</div>
				<div class="row row-cols-lg-3 row-cols-md-2 row-cols-1">
					<div class="col-sm-12">
						<div class="thumb-blog-overlay bg-white hover-text-PushUpBottom mb-4">
							<a href="blog-post.html">
								<div class="post-image position-relative overlay-secondary">
									<img src="img/slides/slide_home_1.jpg" alt="Image not found!">
									<!-- <div class="position-absolute xy-center">
										<div class="overflow-hidden text-center">
											<a class="text-white first-push-up transation font-large" href="#">+</a>
										</div>
									</div> -->
								</div>
							</a>
							<div class="post-content p-35">
								<h5 class="d-block font-400 mb-3"><a href="blog-post.html"
										class="transation text-dark hover-text-primary">Our latest development projects
										by more efficie.</a></h5>
								<p>Nostra maecenas malesuada vel lobortis sociis mus aliquam tempor etiam ipsum pretium
									cursus.</p>
								<div class="post-meta text-uppercase">
									<a href="blog-post.html"><span>By Robert Haven</span></a>
									<a href="blog-post.html"><span>Dec 25, 2019</span></a>
								</div>
							</div>
						</div>
					</div>
					<div class="col-sm-12">
						<div class="thumb-blog-overlay bg-white hover-text-PushUpBottom mb-4">
							<a href="blog-post.html">
								<div class="post-image position-relative overlay-secondary">
									<img src="img/slides/slide_home_2.jpg" alt="Image not found!">
									<!-- <div class="position-absolute xy-center">
										<div class="overflow-hidden text-center">
											<a class="text-white first-push-up transation font-large" href="#">+</a>
										</div>
									</div> -->
								</div>
							</a>
							<div class="post-content p-35">
								<h5 class="d-block font-400 mb-3"><a href="blog-post.html"
										class="transation text-dark hover-text-primary">Cultivating market leadership
										from the inside.</a></h5>
								<p>Nostra maecenas malesuada vel lobortis sociis mus aliquam tempor etiam ipsum pretium
									cursus.</p>
								<div class="post-meta text-uppercase">
									<a href="blog-post.html"><span>By Robert Haven</span></a>
									<a href="blog-post.html"><span>Dec 25, 2019</span></a>
								</div>
							</div>
						</div>
					</div>
					<div class="col-sm-12">
						<div class="thumb-blog-overlay bg-white hover-text-PushUpBottom mb-4">
							<a href="blog-post.html">
								<div class="post-image position-relative overlay-secondary">
									<img src="img/slides/slide_home_3.jpg" alt="Image not found!">
									<!-- <div class="position-absolute xy-center">
										<div class="overflow-hidden text-center">
											<a class="text-white first-push-up transation font-large" href="#">+</a>
										</div>
									</div> -->
								</div>
							</a>
							<div class="post-content p-35">
								<h5 class="d-block font-400 mb-3"><a href="blog-post.html"
										class="transation text-dark hover-text-primary">We are the next generation of
										the advertising.</a></h5>
								<p>Nostra maecenas malesuada vel lobortis sociis mus aliquam tempor etiam ipsum pretium
									cursus.</p>
								<div class="post-meta text-uppercase">
									<a href="blog-post.html"><span>By Robert Haven</span></a>
									<a href="blog-post.html"><span>Dec 25, 2019</span></a>
								</div>
							</div>
						</div>
					</div>
				</div>

				<div class="button-div">
					<a href="blog.html" class="btn_1 medium">Discover More</a>
				</div>


			</div>
		</div>
		<!-- end blog  -->
		<section style="background-color: #FFF2E1;">
			<div class="call_section version_2 lazy">
				<div class="container clearfix">
					<div class="row">
						<div class=" col-md-6  wow">
							<img src="img/are-you-pro.png" alt="">
						</div>
						<div class=" col-md-6  wow">
							<div class="box_1">
								<div class="ribbon_promo"><span>Free</span></div>
								<h3>Are you a Professional?</h3>
								<p>Join Us to increase your online visibility. You'll have access to even more customers
									who are looking to professional service or consultation.</p>
								<a href="submit-professional.html" class="new-unique-btn">Read more</a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>
		<!--/call_section-->

	</main>
	<!-- /main -->
    @endsection

