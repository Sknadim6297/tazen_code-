<!-- /header -->
@extends('layouts.layout')
@section('styles')
   {{-- <link rel="stylesheet" href="{{ asset('admin/css/styles.css') }}" /> --}}
   <link rel="stylesheet" href="{{ asset('frontend/assets/css/newslidertwo.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/newsliders.css') }}">
	<link rel="stylesheet" href="{{ asset('frontend/assets/css/responsive2.css') }}" media="screen and (max-width: 992px)">
	 <style>
        /* Hide video and show image on mobile */
        @media (max-width: 992px) {
            .header-video--media {
                display: none !important;
            }
            .mobile-video-fallback {
                display: block !important;
                width: 100%;
                height: auto;
            }
        }
        .mobile-video-fallback {
            display: none;
        }
		
    </style>
	<style>
    .header-video {
        position: relative;
        height: 500px; /* Set your desired height */
        overflow: hidden;
    }
    .header-video--media {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .mobile-video-fallback {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: none;
    }
    @media (max-width: 992px) {
        .header-video--media {
            display: none;
        }
        .mobile-video-fallback {
            display: block;
        }
    }
</style>
@endsection
@section('content')
	<main>
		<div class="header-video">
			<div id="hero_video">
				<div class="opacity-mask d-flex align-items-center" data-opacity-mask="rgba(0, 0, 0, 0.2)">
					<div class="container">
						@foreach($banners as $banner)
						<div class="row justify-content-md-start">
							<div class="col-xl-8 col-lg-10 col-md-8">
								<h1 class="text-start">{{ $banner->heading }}</h1>
								<p class="text-start">{{ $banner->sub_heading }}</p>
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
							@endforeach
						</div>
					</div>
				</div>
			</div>

			<!-- Video Tag to Add the Video -->
				@foreach($banners as $banner)
    <video class="header-video--media" autoplay loop muted>
        <source src="{{ asset('frontend/assets/video/hero-video.mp4') }}" type="video/mp4">
        Your browser does not support the video tag.
    </video>
    <!-- Fallback image for mobile -->
    <img src="{{ asset('frontend/assets/img/slides/slide_home_2.jpg') }}" class="mobile-video-fallback" >
@endforeach
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
							@foreach($services as $service)
								<div class="card">
									<div 
										class="card-body" 
										style="background-image: url('{{ asset($service->image) }}'); background-size: cover; background-position: center; border-radius: .375rem;"
									></div>
									
									<div class="info mt-3 p-2">
										<div class="content-discover p-3 d-flex justify-content-between align-items-center">
											<div class="l">
												<p class="text-dark mb-0">{{ $service->name }}</p>
											</div>
											<div class="r">
														<button class="btn btn-primary book-now" data-service-id="{{ $service->id }}" data-bs-toggle="modal" data-bs-target="#mcqModal">Book Now</button>
											
											</div>
										</div>
									</div>
								</div>
							@endforeach
						</div>
					</div>
				</div>
			
				<div id="mcqModal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
					<div class="modal-dialog modal-dialog-centered" role="document">
						<div class="modal-content">
							<div class="modal-header">
								<h5 class="modal-title">Service Questionnaire</h5>
								<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
							</div>
				
							<div class="modal-body">
								<form id="mcqForm" method="POST" action="{{ route('submitQuestionnaire') }}">
									@csrf
									<input type="hidden" name="service_id" id="service_id">
									<div id="questionsContainer">
										<!-- Questions will be loaded here dynamically -->
									</div>
								</form>
							</div>
				
							<div class="modal-footer">
								<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
								<button type="button" class="btn btn-primary" id="prevBtn" style="display: none;">Previous</button>
								<button type="button" class="btn btn-primary" id="nextBtn">Next</button>
								<button type="button" class="btn btn-success" id="submitBtn" style="display: none;">Submit</button>
							</div>
						</div>
					</div>
				</div>
				


				
                </main>

			</div>
		</section>
		<!-- second popups  -->

		<section class=" home-about-section py-5" style="background-color: #FFF2E1;">
			<div class="container">
				@foreach($about_us as $aboutus)
				<div class="row">
					<div class="col-lg-6">
						<div class="about-inside-content">
							<small>--- About Us ---</small>
							<div class="main-about-content">
								<h1>{{ $aboutus->heading }}</h1>
								<p>{{ $aboutus->description }}</p>

								<div class="list-data-div">
									<ul>
										<li>
											<i class="fa fa-check"></i>
											<span>{{ $aboutus->line1 }}</span>
										</li>
										<li>
											<i class="fa fa-check"></i>
											<span>{{ $aboutus->line2 }}</span>
										</li>
									</ul>

								</div>
								<div class="button-div">
									<button class=" btn_1 medium">Get Started</button>
									<a href="{{ url('/about') }}"><button class="btn new-custom-btn">Discover
											More</button></a>
								</div>
							</div>
						</div>
					</div>
					<div class="col-lg-6 position-relative d-flex align-item-center  justify-content-md-center">
						<div class="right-img">
							<img src="{{ asset('storage/' . $aboutus->image) }}" alt="">
						</div>
						<div class="ab-count d-flex justify-content-center align-items-center flex-column text-center">
							<div class="d-flex align-items-center justify-content-center">
								<h2 class="count">{{ $aboutus->year_of_experience }}</h2>
								<h2>+</h2>
							</div>
							<p>years of experience</p>
						</div>
					</div>
					@endforeach
				</div>
			</div>
		</section>



		<section class="bg-light fun-facts-cards py-5">
			@foreach ($whychooses as $whychoose)
			<div class="container">
				
				<div class="main_title center">
					<span><em></em></span>
					<h2>{{ $whychoose->section_heading }}</h2>
					<p>{{ $whychoose->section_sub_heading }}</p>
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
											<p>{{ $whychoose->card1_mini_heading }}</p>
										</div>
										<div class="icon col-lg-6">
											<i class="{{ $whychoose->card1_icon }}"></i>
										</div>
									</div>
									<div class="text-content">
										<h3>{{ $whychoose->card1_heading }}</h3>
										<p>{{ $whychoose->card1_description }}</p>
									</div>

								</div>
							</div>
							<div class="col-lg-6 second-card">
								<div class="card card-two funfact-card">
									<div class="icon-content">
										<div class="text col-lg-6">
											<p>{{ $whychoose->card2_mini_heading }}</p>
										</div>
										<div class="icon col-lg-6">
											<i class="{{ $whychoose->card2_icon }}"></i>
										</div>
									</div>
									<div class="text-content">
										<h3>{{ $whychoose->card2_heading }}</h3>
										<p>{{ $whychoose->card2_description }}</p>
									</div>
								</div>
							</div>
							<div class="col-lg-12 third-card">
								<div class="card card-three funfact-card">
									<div class="icon-content">
										<div class="text col-lg-6">
											<p>{{ $whychoose->card3_mini_heading }}</p>
										</div>
										<div class="icon col-lg-6">
											<i class="{{ $whychoose->card3_icon }}"></i>
										</div>
									</div>
									<div class="text-content">
										<h3>{{ $whychoose->card3_heading }}</h3>
										<p>{{ $whychoose->card3_description }}</p>
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
											<p>{{ $whychoose->card4_mini_heading }}</p>
										</div>
										<div class="icon col-lg-6">
											<i class="{{ $whychoose->card4_icon }}"></i>
										</div>
									</div>
									<div class="text-content">
										<h3>{{ $whychoose->card4_heading }}</h3>
										<p>{{ $whychoose->card4_description }}</p>
									</div>
								</div>
							</div>
							<div class="col-lg-6 first-card">
								<div class="card card-one funfact-card">
									<div class="icon-content">
										<div class="text col-lg-6">
											<p>{{ $whychoose->card5_mini_heading }}</p>
										</div>
										<div class="icon col-lg-6">
											<i class="{{ $whychoose->card5_icon }}"></i>
										</div>
									</div>
									<div class="text-content">
										<h3>{{ $whychoose->card5_heading }}</h3>
										<p>{{ $whychoose->card5_description }}</p>
									</div>
								</div>
							</div>
							<div class="col-lg-6 second-card">
								<div class="card card-two funfact-card">
									<div class="icon-content">
										<div class="text col-lg-6">
											<p>{{ $whychoose->card6_mini_heading }}</p>
										</div>
										<div class="icon col-lg-6">
											<i class="{{ $whychoose->card6_icon }}"></i>
										</div>
									</div>
									<div class="text-content">
										<h3>{{ $whychoose->card6_heading }}</h3>
										<p>{{ $whychoose->card6_description }}</p>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			@endforeach
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
					@foreach($allevents->take(6) as $event)
					<div class="col-xl-4 col-lg-6 col-md-6 col-sm-6">
						<div class="strip">
							<figure>
								<a href="" class="wish_bt"><i class="icon_heart"></i></a>
								<img src="{{ asset('storage/' . $event->card_image) }}" 
									 data-src="{{ asset('storage/' . $event->card_image) }}"
									 class="img-fluid lazy" alt="{{ $event->heading }}">
								<a href="{{ route('event.details', $event->id) }}" class="strip_info">
									<div class="item_title">
										<h3>{{ $event->heading }}</h3>
										<small>{{ $event->mini_heading }}</small>
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
									<div class="score">
										<span>Starting from<em>{{ $event->date }}</em></span>
										<strong>₹{{ number_format($event->starting_fees, 2) }}</strong>
									</div>
								</li>
							</ul>
						</div>
					</div>
					@endforeach
				</div>

				<p class="text-center"><a href="{{ route('event.list') }}" class="btn_1 medium">View All Events</a></p>
			</div>
		</section>
		<!-- /container -->

		<div class="bg_gray">
			<div class="container margin_60_40 how">
				@foreach($howworks as $howwork)
				<div class="main_title center">
					<span><em></em></span>
					<h2>How does it work?</h2>
					<p>{{ $howwork->section_sub_heading }}</p>
				</div>
				<div class="row justify-content-center align-items-center add_bottom_45">
					<div class="col-lg-5">
						<div class="box_about">
							<strong>1</strong>
							<h3>{{ $howwork->heading1 }}</h3>
							<p>{{ $howwork->description1 }}</p>
							<img src="data:image/gif;base64,R0lGODlhAQABAIAAAP///wAAACH5BAEAAAAALAAAAAABAAEAAAICRAEAOw=="

								data-src="url('{{ asset('frontend/assets/img/services-pic/arrow_about.png') }}')" alt="" class="arrow_1 lazy">
						</div>
					</div>
					<div class="col-lg-5 pl-lg-5 text-center d-none d-lg-block">
						<figure><img
							src="{{ asset('storage/'.$howwork->image1) }}" 
							data-src="{{ asset('storage/'.$howwork->image1) }}"  
							alt="How it works"
							class="img-fluid lazy"
							width="180"
							height="180">
						</figure>
					</div>
				</div>
				<!-- /row -->
				<div class="row justify-content-center align-items-center add_bottom_45">
					<div class="col-lg-5 pr-lg-5 text-center d-none d-lg-block">
						<figure><img
							src="{{ asset('storage/'.$howwork->image2) }}" 
							data-src="{{ asset('storage/'.$howwork->image2) }}"  
							alt="How it works"
							class="img-fluid lazy"
							width="180"
							height="180"></figure>
					</div>
					<div class="col-lg-5">
						<div class="box_about">
							<strong>2</strong>
							<h3>{{ $howwork->heading2 }}</h3>
							<p>{{ $howwork->description2 }}</p>
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
							<h3>{{ $howwork->heading3 }}</h3>
							<p>{{ $howwork->description3 }}</p>
						</div>
					</div>
					<div class="col-lg-5 pl-lg-5 text-center d-none d-lg-block">
						<figure><img
							src="{{ asset('storage/'.$howwork->image3) }}" 
							data-src="{{ asset('storage/'.$howwork->image3) }}"  
							alt="How it works"
							class="img-fluid lazy"
							width="180"
							height="180"></figure>
					</div>
				</div>
				<!-- /row -->
				@endforeach
			</div>
			<!-- /container -->
		</div>
		<!-- /bg_gray -->

		<!-- Testimonial Section -->
		<section class="testimonial-section py-5">
			<div class="container">
				<div class="main_title center mb-5">
					<span><em></em></span>
					<h2>What Our Clients Say</h2>
					<p>Discover why people love our services</p>
				</div>

				<div class="row testimonial-slider">
					@foreach($testimonials as $testimonial)
					<div class="col-lg-4">
						<div class="testimonial-card">
							<div class="testimonial-content">
								<div class="quote-icon">
									<i class="fas fa-quote-left"></i>
								</div>
								<p class="testimonial-text">{{ $testimonial->description }}</p>
								<div class="testimonial-author">
									<div class="author-image">
										<img src="{{ asset('storage/'.$testimonial->image) }}" alt="Client">
									</div>
									<div class="author-info">
										<h5>{{ $testimonial->name ?? 'Happy Client' }}</h5>
										<span>{{ $testimonial->position ?? 'Verified Customer' }}</span>
									</div>
								</div>
							</div>
						</div>
					</div>
					@endforeach
				</div>
			</div>
		</section>

		<style>
			.testimonial-section {
				background-color: #f8f9fa;
				position: relative;
				overflow: hidden;
			}

			.testimonial-card {
				background: #fff;
				border-radius: 15px;
				padding: 30px;
				margin: 15px;
				box-shadow: 0 5px 20px rgba(0,0,0,0.05);
				transition: all 0.3s ease;
			}

			.testimonial-card:hover {
				transform: translateY(-5px);
				box-shadow: 0 8px 25px rgba(0,0,0,0.1);
			}

			.quote-icon {
				color: #007bff;
				font-size: 24px;
				margin-bottom: 15px;
			}

			.testimonial-text {
				font-size: 16px;
				line-height: 1.6;
				color: #555;
				margin-bottom: 20px;
				min-height: 100px;
			}

			.testimonial-author {
				display: flex;
				align-items: center;
				margin-top: 20px;
				border-top: 1px solid #eee;
				padding-top: 20px;
			}

			.author-image {
				width: 60px;
				height: 60px;
				border-radius: 50%;
				overflow: hidden;
				margin-right: 15px;
				border: 3px solid #007bff;
			}

			.author-image img {
				width: 100%;
				height: 100%;
				object-fit: cover;
			}

			.author-info h5 {
				margin: 0;
				font-size: 18px;
				color: #333;
			}

			.author-info span {
				font-size: 14px;
				color: #777;
			}

			/* Slick Slider Customization */
			.testimonial-slider {
				margin: 0 -15px;
			}

			.testimonial-slider .slick-slide {
				padding: 0 15px;
			}

			.testimonial-slider .slick-dots {
				bottom: -40px;
			}

			.testimonial-slider .slick-dots li button:before {
				font-size: 12px;
				color: #007bff;
			}

			.testimonial-slider .slick-prev,
			.testimonial-slider .slick-next {
				width: 40px;
				height: 40px;
				background: #fff;
				border-radius: 50%;
				box-shadow: 0 2px 5px rgba(0,0,0,0.1);
				z-index: 1;
			}

			.testimonial-slider .slick-prev:before,
			.testimonial-slider .slick-next:before {
				color: #007bff;
				font-size: 20px;
			}

			.testimonial-slider .slick-prev {
				left: -20px;
			}

			.testimonial-slider .slick-next {
				right: -20px;
			}

			@media (max-width: 768px) {
				.testimonial-card {
					margin: 10px;
				}

				.testimonial-slider .slick-prev {
					left: 0;
				}

				.testimonial-slider .slick-next {
					right: 0;
				}
			}
		</style>

		<script>
			$(document).ready(function(){
				$('.testimonial-slider').slick({
					dots: true,
					infinite: true,
					speed: 500,
					slidesToShow: 3,
					slidesToScroll: 1,
					autoplay: true,
					autoplaySpeed: 3000,
					responsive: [
						{
							breakpoint: 1024,
							settings: {
								slidesToShow: 2,
								slidesToScroll: 1
							}
						},
						{
							breakpoint: 768,
							settings: {
								slidesToShow: 1,
								slidesToScroll: 1
							}
						}
					]
				});
			});
		</script>

		<!-- blog -->
		<div class="full-row bg-light py-5 home-blog-section">
			<div class="container">
				<div class="row heading">
					<div class="col ">
						<div class="main_title center ">
							<span><em></em></span>
							<h2>Our Recent Blogs</h2>
							<p>Explore our blogs</p>
						</div>
					</div>
				</div>
				<div class="row row-cols-lg-3 row-cols-md-2 row-cols-1">
					@foreach ($blogs->take(3) as $blog)
						<div class="col-sm-12">
							<div class="thumb-blog-overlay bg-white hover-text-PushUpBottom mb-4">
								<a href="{{ route('blog.index') }}">
									<div class="post-image position-relative overlay-secondary" style="height: 200px; overflow: hidden;">
										<img src="{{ asset('storage/' . $blog->image) }}" alt="Blog Image" class="img-fluid" style="width: 100%; height: 100%; object-fit: cover;">
									</div>
								</a>
								<div class="post-content p-35">
									<h5 class="d-block font-400 mb-3">
										<a href="{{ route('blog.index') }}" class="transation text-dark hover-text-primary">
											{{ $blog->title }}
										</a>
									</h5>
									<p>{{ $blog->description_short }}</p>
									<div class="post-meta text-uppercase">
										<a href="#"><span>{{ $blog->created_by }}</span></a>
									</div>
								</div>
							</div>
						</div>
					@endforeach
				</div>
				

				<div class="button-div">
					<a href="{{ route('blog.index') }}" class="btn_1 medium">Discover More</a>
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

	</main>

    @endsection
	@section('script')
	<script src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
	<script>
$(document).ready(function(){
  $('.testimonial_slider').slick({
    slidesToShow: 1,
    slidesToScroll: 1,
    arrows: true,
    dots: true,
    autoplay: true,
    autoplaySpeed: 3000,
  });
});
</script>
	<script>
		document.addEventListener("DOMContentLoaded", function () {
			const questionsContainer = document.getElementById("questionsContainer");
			const nextBtn = document.getElementById("nextBtn");
			const prevBtn = document.getElementById("prevBtn");
			const submitBtn = document.getElementById("submitBtn");
			const form = document.getElementById("mcqForm");
			const serviceIdInput = document.getElementById("service_id");

			let currentQuestion = 0;
			let questions = [];

			// Handle Book Now button clicks
			document.querySelectorAll('.book-now').forEach(button => {
				button.addEventListener('click', function() {
					const serviceId = this.dataset.serviceId;
					serviceIdInput.value = serviceId;
					loadQuestions(serviceId);
				});
			});

			function loadQuestions(serviceId) {
				fetch(`/service/${serviceId}/questions`)
					.then(response => response.json())
					.then(data => {
						if (data.status === 'success') {
							questions = data.questions;
							renderQuestions();
							showQuestion(0);
						}
					})
					.catch(error => {
						console.error('Error loading questions:', error);
						toastr.error('Failed to load questions. Please try again.');
					});
			}

			function renderQuestions() {
				questionsContainer.innerHTML = questions.map((question, index) => `
					<div class="question" id="question${question.id}" style="display: none;">
						<h6>Question ${index + 1}: ${question.question}</h6>
						<div class="form-check">
							<input class="form-check-input" type="radio" name="q${question.id}" id="q${question.id}answer1" value="${question.answer1}" required>
							<label class="form-check-label" for="q${question.id}answer1">${question.answer1}</label>
						</div>
						<div class="form-check">
							<input class="form-check-input" type="radio" name="q${question.id}" id="q${question.id}answer2" value="${question.answer2}" required>
							<label class="form-check-label" for="q${question.id}answer2">${question.answer2}</label>
						</div>
						<div class="form-check">
							<input class="form-check-input" type="radio" name="q${question.id}" id="q${question.id}answer3" value="${question.answer3}" required>
							<label class="form-check-label" for="q${question.id}answer3">${question.answer3}</label>
						</div>
						<div class="form-check">
							<input class="form-check-input" type="radio" name="q${question.id}" id="q${question.id}answer4" value="${question.answer4}" required>
							<label class="form-check-label" for="q${question.id}answer4">${question.answer4}</label>
						</div>
					</div>
				`).join('');
			}

			function showQuestion(index) {
				const questionElements = document.querySelectorAll('.question');
				questionElements.forEach((q, i) => {
					q.style.display = i === index ? "block" : "none";
				});
				
				prevBtn.style.display = index > 0 ? "inline-block" : "none";
				nextBtn.style.display = index < questions.length - 1 ? "inline-block" : "none";
				submitBtn.style.display = index === questions.length - 1 ? "inline-block" : "none";
			}

			nextBtn.addEventListener("click", function () {
				if (currentQuestion < questions.length - 1) {
					currentQuestion++;
					showQuestion(currentQuestion);
				}
			});

			prevBtn.addEventListener("click", function () {
				if (currentQuestion > 0) {
					currentQuestion--;
					showQuestion(currentQuestion);
				}
			});

			// Single submit event listener
			submitBtn.addEventListener("click", function () {
				const formData = new FormData(form);
				const answers = [];
				
				// Get all questions
				const questions = document.querySelectorAll('.question');
				questions.forEach((question) => {
					const questionId = question.id.replace('question', '');
					const selectedAnswer = question.querySelector('input[type="radio"]:checked');
					
					if (selectedAnswer) {
						answers.push({
							question_id: questionId,
							answer: selectedAnswer.value
						});
					}
				});

				// Add answers to formData as a JSON string
				formData.append('answers', JSON.stringify(answers));
				formData.append('service_id', document.getElementById('service_id').value);

				fetch("{{ route('submitQuestionnaire') }}", {
					method: "POST",
					headers: {
						"X-CSRF-TOKEN": "{{ csrf_token() }}",
						"Accept": "application/json",
					},
					body: formData,
				})
				.then(response => {
					if (!response.ok) {
						return response.json().then(err => {
							throw err;
						});
					}
					return response.json();
				})
				.then(data => {
					if (data.success) {
						toastr.success("Thanks for your feedback!");
						setTimeout(() => {
							window.location.href = "{{ route('professionals') }}";
						}, 3000);
					}
				})
				.catch(error => {
					if (error.errors) {
						Object.values(error.errors).forEach(msgArray => {
							msgArray.forEach(msg => {
								toastr.error(msg);
							});
						});
					} else if (error.message) {
						toastr.error(error.message);
					} else {
						toastr.error("Something went wrong. Please try again.");
					}
					console.error("Validation or Server Error:", error);
				});
			});
		});
	</script>
		
	

	
 @endsection
