<!-- /header -->
@extends('layouts.layout')
@section('styles')
   {{-- <link rel="stylesheet" href="{{ asset('admin/css/styles.css') }}" /> --}}
   <link rel="stylesheet" href="{{ asset('frontend/assets/css/newslidertwo.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/newsliders.css') }}">
	<link rel="stylesheet" href="{{ asset('frontend/assets/css/responsive2.css') }}" media="screen and (max-width: 992px)">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
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

		@media only screen and (min-width: 768px) and (max-width: 1024px) {

			.fun-facts-cards .container .card-two {
    			margin-top: 20px;
    
		}

		.fun-facts-cards .container .right .row .third-card .card-three{
			margin-top: 14px;
		}

		.fun-facts-cards .container .card {
			margin-right: 12px
		}

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

	.btn-custom{
		    background: linear-gradient(135deg, #152a70, #c51010, #f39c12);
			border: none;
			color: white;
	}
	.text{
		color: white;
	}
	/* Updated Search Results Styling */
#searchResults {
    max-height: 250px;
    overflow-y: auto;
    border-radius: 0.25rem;
    left: 0; /* Align to the left */
    right: auto; /* Override any right alignment */
    width: 100%; /* Full width of parent */
}

.search-container {
    position: relative; /* Ensure proper positioning context */
    width: 100%;
}

#searchResults .list-group-item {
    border-left: none;
    border-right: none;
    text-align: left; /* Left-align text */
    padding-left: 15px;
}

#searchResults .list-group-item:first-child {
    border-top-left-radius: 0.25rem;
    border-top-right-radius: 0.25rem;
}

#searchResults .list-group-item:last-child {
    border-bottom-left-radius: 0.25rem;
    border-bottom-right-radius: 0.25rem;
}

#searchResults .list-group-item:hover {
    background-color: #f8f9fa;
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
												<div class="form-group position-relative search-container">
        <input class="form-control" type="text" id="serviceSearch" placeholder="Find a professional..." autocomplete="off">
        <div id="searchResults" class="position-absolute w-100 mt-1 d-none" style="z-index: 1050;">
            <!-- Search results will appear here -->
        </div>
    </div>
											</div>
											<div class="col-md-3">
												<input type="submit" id="searchButton" value="Find">
											</div>
										</div>
										<!-- /row -->
									</div>
								<div class="search_trends new-search_trends">
    <h5>Trending:</h5>
    <ul class="new-ul-list-header">
        @foreach($services->take(4) as $service)
            <li><a href="{{ url('/service/' . $service->id) }}">{{ strtolower($service->name) }}</a></li>
        @endforeach
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
														<button class="btn btn-custom book-now" data-service-id="{{ $service->id }}" data-bs-toggle="modal" data-bs-target="#mcqModal">Book Now</button>
											
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

		<section class=" home-about-section py-5" style="background-color:#f4cf2d73;">
			<div class="container">
				@foreach($about_us as $aboutus)
				<div class="row">
					<div class="col-lg-6">
						<div class="about-inside-content">
							
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
									<button class=" btn_1 medium" style="    background: linear-gradient(135deg, #152a70, #c51010, #f39c12);
">Get Started</button>
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

		<section style="background-color:  #99b1f699;">
			<div class="container margin_60_40">
				<div class="main_title center">
					<span><em></em></span>
					<h2>Events</h2>
					<p>Cum doctus civibus efficiantur in imperdiet deterruisset.</p>
				</div>
				<div class="row add_bottom_15">
					@foreach($eventDetails as $eventDetail)
					<div class="col-xl-4 col-lg-6 col-md-6 col-sm-6">
						<div class="strip">
							<figure>
								<a href="" class="wish_bt"><i class="icon_heart"></i></a>
								<img src="{{ asset('storage/' . $eventDetail->event->card_image) }}" 
									 data-src="{{ asset('storage/' . $eventDetail->event->card_image) }}"
									 class="img-fluid lazy" alt="{{ $eventDetail->event->heading }}">
								<a href="{{ url('/allevent/' . $eventDetail->id) }}" class="strip_info">
									<div class="item_title">
										<h3>{{ $eventDetail->event->heading }}</h3>
										<small>{{ $eventDetail->event->mini_heading }}</small>
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
										<span>Starting from<em>{{ $eventDetail->event->date }}</em></span>
										<strong>₹{{ number_format($eventDetail->event->starting_fees, 2) }}</strong>
									</div>
								</li>
							</ul>
						</div>
					</div>
					@endforeach
				</div>

				<p class="text-center"><a href="{{ route('event.list') }}" class="btn_1 medium" style="    background: linear-gradient(135deg, #152a70, #c51010, #f39c12);">View All Events</a></p>
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
		 <section class="ttm-row padding_top_zero-section ttm-bgcolor-white clearfix testimonial-new">
        <div class="container-fluid">
            <!-- Static heading and subheading -->
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 ttm-box-col-wrapper m-auto">
                    <div class="main_title center">
                        <span><em></em></span>
                        <h2>TESTIMONIALS</h2>
                        <p>What our clients say about us</p>
                    </div>
                </div>
            </div>
    
            <div class="row">
                <div class="owl-carousel services-carousal" id="testimonial-carousel">
                    @php
                        $totalSlides = 6; // Total slides to display
                        $testimonialCount = count($testimonials);
                    @endphp
    
                    @for($i = 0; $i < $totalSlides; $i++)
                        <div class="item">
                            <div class="testimonial-box">
                                @php
                                    $isEven = $i % 2 === 0;
                                @endphp
    
                                @if($i < $testimonialCount)
                                    {{-- Real testimonial --}}
                                    @php $t = $testimonials[$i]; @endphp
                                    @if($isEven)
                                        <div class="testimonial-content bg-lavender mb-15">
                                            <p class="text">{{ $t->description }}</p>
                                        </div>
                                        <div class="testimonial-img bg-blue">
                                            <img src="{{ asset('storage/'.$t->image) }}" alt="Testimonial Image" style="width: auto; height: 250px;">
                                        </div>
                                    @else
                                        <div class="testimonial-img bg-pink mb-15">
                                            <img src="{{ asset('storage/'.$t->image) }}" alt="Testimonial Image" style="width: auto; height: 250px;">
                                        </div>
                                        <div class="testimonial-content bg-green">
                                            <p class="text">{{ $t->description }}</p>
                                        </div>
                                    @endif
                                @else
                                    {{-- Dummy testimonial --}}
                                    @if($isEven)
                                        <div class="testimonial-content bg-lavender mb-15">
                                            This is a sample testimonial. Excellent service and support!
                                        </div>
                                        <div class="testimonial-img bg-blue">
                                            <img src="{{ asset('images/dummy'.($i+1).'.jpg') }}" alt="Dummy Image" style="width: auto; height: 250px;">
                                        </div>
                                    @else
                                        <div class="testimonial-img bg-pink mb-15">
                                            <img src="{{ asset('images/dummy'.($i+1).'.jpg') }}" alt="Dummy Image" style="width: auto; height: 250px;">
                                        </div>
                                        <div class="testimonial-content bg-green">
                                            <p class="text">This is a sample testimonial. Highly recommended!</p>
                                        </div>
                                    @endif
                                @endif
                            </div>
                        </div>
                    @endfor
                </div>
            </div>
        </div>
    </section>


		<script>
			$(document).ready(function(){
				$("#testimonial-carousel").owlCarousel({
					loop: true,
					margin: 20,
					nav: true,
					dots: true,
					autoplay: true,
					autoplayTimeout: 3000,
					autoplayHoverPause: true,
					items: 4,
					responsive: {
						0: {
							items: 1
						},
						576: {
							items: 2
						},
						992: {
							items: 3
						},
						1200: {
							items: 4
						}
					}
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
					@foreach ($blogPosts as $blogPost)
						<div class="col-sm-12">
							<div class="thumb-blog-overlay bg-white hover-text-PushUpBottom mb-4">
								<a href="{{ route('blog.show', $blogPost->id) }}">
									<div class="post-image position-relative overlay-secondary" style="height: 200px; overflow: hidden;">
										<img src="{{ asset('storage/' . $blogPost->image) }}" alt="Blog Image" class="img-fluid" style="width: 100%; height: 100%; object-fit: cover;">
									</div>
								</a>
								<div class="post-content p-35">
									<h5 class="d-block font-400 mb-3">
										<a href="{{ route('blog.show', $blogPost->id) }}" class="transation text-dark hover-text-primary">
											{{ $blogPost->blog->title }}
										</a>
									</h5>
									<p>{{ $blogPost->blog->description_short }}</p>
									<div class="post-meta text-uppercase">
										<a href="#"><span>{{ $blogPost->blog->created_by }}</span></a>
									</div>
								</div>
							</div>
						</div>
					@endforeach
				</div>
				

				<div class="button-div">
					<a href="{{ route('blog.index') }}" class="btn_1 medium" style="background: linear-gradient(135deg, #152a70, #c51010, #f39c12);">Discover More</a>
				</div>

			</div>
		</div>
		<!-- end blog  -->
		<section style="background-color: #ffd41473;">
			<div class="call_section version_2 lazy">
				<div class="container clearfix">
					<div class="row">
						<div class=" col-md-6  wow">
							<img src="{{ asset('frontend/assets/img/are-you-pro.png')}}" alt="">
						</div>
						<div class=" col-md-6  wow">
							<div class="box_1">
								<div class="ribbon_promo"></div>
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
    const modalCloseBtn = document.querySelector("#mcqModal .btn-close");
    const cancelBtn = document.querySelector("#mcqModal .btn-secondary");

    let currentQuestion = 0;
    let questions = [];
    
    // Enhance modal design
    styleModalForModernLook();

    // Handle Book Now button clicks
    document.querySelectorAll('.book-now').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const serviceId = this.dataset.serviceId;
            serviceIdInput.value = serviceId;
            
            // Check if user is logged in
            checkLoginStatus(serviceId);
        });
    });
    
    // Check if user is logged in before showing modal
    function checkLoginStatus(serviceId) {
        fetch('/check-auth-status')
            .then(response => response.json())
            .then(data => {
                if (data.authenticated) {
                    // User is logged in, proceed with loading questions
                    $('#mcqModal').modal('show');
                    loadQuestions(serviceId);
                } else {
                    // User is not logged in, show message and redirect
                    Swal.fire({
                        title: 'Authentication Required',
                        text: 'Please login to book this service',
                        icon: 'info',
                        showCancelButton: true,
                        confirmButtonText: 'Login Now',
                        cancelButtonText: 'Cancel',
                        customClass: {
                            confirmButton: 'btn btn-primary',
                            cancelButton: 'btn btn-secondary'
                        }
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Redirect to login page with return URL to come back to this page
                            window.location.href = `/login?redirect=${encodeURIComponent(window.location.pathname)}`;
                        }
                    });
                }
            })
            .catch(error => {
                console.error('Error checking authentication status:', error);
                Swal.fire('Error', 'An error occurred. Please try again.', 'error');
            });
    }

    // Handle confirmation when closing the modal
    function handleModalClose(e) {
        e.preventDefault();
        
        if (questions.length > 0) {
            // Show confirmation dialog with standard confirm
            if (confirm('Your progress will be lost if you cancel now. Are you sure?')) {
                // Reset and close modal
                resetModal();
                $('#mcqModal').modal('hide');
            }
        } else {
            // No questions loaded yet, just close
            $('#mcqModal').modal('hide');
        }
    }
    
    // Reset modal state
    function resetModal() {
        questions = [];
        currentQuestion = 0;
        questionsContainer.innerHTML = '';
        prevBtn.style.display = 'none';
        nextBtn.style.display = 'inline-block';
        submitBtn.style.display = 'none';
    }
    
    // Apply modern styling to modal
    function styleModalForModernLook() {
        const modal = document.getElementById('mcqModal');
        if (!modal) return;
        
        const modalDialog = modal.querySelector('.modal-dialog');
        const modalContent = modal.querySelector('.modal-content');
        const modalHeader = modal.querySelector('.modal-header');
        const modalTitle = modal.querySelector('.modal-title');
        const modalBody = modal.querySelector('.modal-body');
        const modalFooter = modal.querySelector('.modal-footer');
        
        // Add modern styling classes
        if (modalDialog) modalDialog.classList.add('modal-dialog-centered');
        if (modalContent) {
            modalContent.style.borderRadius = '12px';
            modalContent.style.boxShadow = '0 15px 35px rgba(50, 50, 93, 0.1), 0 5px 15px rgba(0, 0, 0, 0.07)';
            modalContent.style.border = 'none';
        }
        
        if (modalHeader) {
            modalHeader.style.borderBottom = '1px solid rgba(0,0,0,0.05)';
            modalHeader.style.background = 'linear-gradient(135deg, #f8f9fa, #ffffff)';
            modalHeader.style.borderTopLeftRadius = '12px';
            modalHeader.style.borderTopRightRadius = '12px';
            modalHeader.style.padding = '20px 24px';
        }
        
        if (modalTitle) {
            modalTitle.style.fontSize = '1.25rem';
            modalTitle.style.fontWeight = '600';
        }
        
        if (modalBody) {
            modalBody.style.padding = '24px';
        }
        
        if (modalFooter) {
            modalFooter.style.borderTop = '1px solid rgba(0,0,0,0.05)';
            modalFooter.style.padding = '16px 24px';
        }
        
        // Style the buttons
        const buttons = modal.querySelectorAll('.modal-footer .btn');
        buttons.forEach(button => {
            button.style.borderRadius = '6px';
            button.style.padding = '8px 16px';
            button.style.fontWeight = '500';
            button.style.transition = 'all 0.2s ease';
        });
        
        // Style primary buttons
        const primaryButtons = modal.querySelectorAll('.btn-primary');
        primaryButtons.forEach(button => {
            button.style.background = 'linear-gradient(135deg, #152a70, #c51010, #f39c12)';
            button.style.borderColor = 'transparent';
        });
        
        // Style success button
        const successButton = modal.querySelector('.btn-success');
        if (successButton) {
            successButton.style.background = 'linear-gradient(135deg, #28a745, #20c997)';
            successButton.style.borderColor = 'transparent';
        }
    }

    function loadQuestions(serviceId) {
        // Show loading state
        questionsContainer.innerHTML = '<div class="text-center py-4"><div class="spinner-border text-primary" role="status"></div><p class="mt-3">Loading questions...</p></div>';
        
        fetch(`/service/${serviceId}/questions`)
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success' && Array.isArray(data.questions) && data.questions.length > 0) {
                    questions = data.questions;
                    currentQuestion = 0;
                    renderQuestions();
                    showQuestion(0);
                } else {
                    questionsContainer.innerHTML = '<div class="alert alert-warning my-3"><i class="fas fa-exclamation-circle me-2"></i>No questions available for this service. Please try another service or contact support.</div>';
                    console.error("No questions found in response:", data);
                }
            })
            .catch(error => {
                questionsContainer.innerHTML = '<div class="alert alert-danger my-3"><i class="fas fa-exclamation-circle me-2"></i>Failed to load questions. Please try again.</div>';
                console.error('Error loading questions:', error);
                alert('Failed to load questions. Please try again.');
            });
    }

    function renderQuestions() {
        questionsContainer.innerHTML = '';
        
        questions.forEach((question, index) => {
            const questionDiv = document.createElement('div');
            questionDiv.className = 'question';
            questionDiv.id = `question${index}`; // Changed from question.id to index
            questionDiv.style.display = 'none';
            
            // Question number indicator
            const questionProgress = document.createElement('div');
            questionProgress.className = 'question-progress mb-3';
            questionProgress.innerHTML = `<span class="badge bg-primary">Question ${index + 1} of ${questions.length}</span>`;
            questionDiv.appendChild(questionProgress);
            
            // Question heading
            const heading = document.createElement('h6');
            heading.className = 'mb-3 fw-bold';
            heading.textContent = question.question || 'Question not available';
            questionDiv.appendChild(heading);
            
            // Create input based on question type
            if (question.question_type === 'text') {
                // Text input
                const formGroup = document.createElement('div');
                formGroup.className = 'form-group mt-4';
                
                const input = document.createElement('input');
                input.type = 'text';
                input.className = 'form-control form-control-lg';
                input.name = `q${index}`; // Changed from question.id to index
                input.required = true;
                input.placeholder = 'Type your answer here...';
                input.style.borderRadius = '8px';
                input.style.padding = '12px';
                input.style.boxShadow = '0 1px 3px rgba(0,0,0,0.1)';
                
                formGroup.appendChild(input);
                questionDiv.appendChild(formGroup);
            } else if (Array.isArray(question.options)) {
                // Radio options
                const optionsContainer = document.createElement('div');
                optionsContainer.className = 'options-container mt-4';
                
                question.options.forEach((option, optIndex) => {
                    if (!option) return; // Skip empty options
                    
                    const formCheck = document.createElement('div');
                    formCheck.className = 'form-check mb-3';
                    formCheck.style.backgroundColor = '#f8f9fa';
                    formCheck.style.borderRadius = '8px';
                    formCheck.style.padding = '10px 41px';
                    formCheck.style.border = '1px solid #e9ecef';
                    formCheck.style.transition = 'all 0.2s ease';
                    formCheck.style.cursor = 'pointer';
                    
                    const radio = document.createElement('input');
                    radio.className = 'form-check-input me-2';
                    radio.type = 'radio';
                    radio.name = `q${index}`; // Changed from question.id to index
                    radio.id = `q${index}opt${optIndex}`;
                    radio.value = option;
                    radio.required = true;
                    
                    const label = document.createElement('label');
                    label.className = 'form-check-label';
                    label.htmlFor = `q${index}opt${optIndex}`;
                    label.textContent = option;
                    
                    // Highlight selected option
                    radio.addEventListener('change', function() {
                        // Reset all options
                        optionsContainer.querySelectorAll('.form-check').forEach(el => {
                            el.style.backgroundColor = '#f8f9fa';
                            el.style.borderColor = '#e9ecef';
                        });
                        
                        // Highlight selected
                        if (this.checked) {
                            formCheck.style.backgroundColor = '#e8f4ff';
                            formCheck.style.borderColor = '#2196f3';
                        }
                    });
                    
                    formCheck.appendChild(radio);
                    formCheck.appendChild(label);
                    
                    // Add "Other" text field if this option is "Other"
                    if (option === 'Other') {
                        radio.addEventListener('change', function() {
                            const otherInputContainer = document.getElementById(`otherContainer${index}`);
                            if (this.checked && otherInputContainer) {
                                otherInputContainer.style.display = 'block';
                                otherInputContainer.querySelector('input').required = true;
                                otherInputContainer.querySelector('input').focus();
                            } else if (otherInputContainer) {
                                otherInputContainer.style.display = 'none';
                                otherInputContainer.querySelector('input').required = false;
                            }
                        });
                        
                        const otherContainer = document.createElement('div');
                        otherContainer.id = `otherContainer${index}`;
                        otherContainer.className = 'mt-2 ps-4';
                        otherContainer.style.display = 'none';
                        
                        const otherInput = document.createElement('input');
                        otherInput.type = 'text';
                        otherInput.className = 'form-control';
                        otherInput.name = `q${index}_other`;
                        otherInput.placeholder = 'Please specify...';
                        otherInput.style.borderRadius = '6px';
                        
                        otherContainer.appendChild(otherInput);
                        formCheck.appendChild(otherContainer);
                    }
                    
                    // Make entire option div clickable
                    formCheck.addEventListener('click', function(e) {
                        if (e.target !== radio) {
                            radio.checked = true;
                            radio.dispatchEvent(new Event('change'));
                        }
                    });
                    
                    optionsContainer.appendChild(formCheck);
                });
                
                questionDiv.appendChild(optionsContainer);
            } else {
                // Fallback for missing options
                const alert = document.createElement('div');
                alert.className = 'alert alert-warning';
                alert.textContent = 'No options available for this question.';
                questionDiv.appendChild(alert);
            }
            
            questionDiv.appendChild(document.createElement('hr'));
            
            questionsContainer.appendChild(questionDiv);
        });
        
        // If no questions were rendered, show a message
        if (questionsContainer.children.length === 0) {
            questionsContainer.innerHTML = '<div class="alert alert-warning my-3">No questions found for this service.</div>';
        }
    }

    function showQuestion(index) {
        // Validate index
        if (index < 0 || index >= questions.length || !questions[index]) {
            console.error('Invalid question index:', index, 'Questions:', questions);
            return;
        }
        
        // Hide all questions
        document.querySelectorAll('.question').forEach(question => {
            question.style.display = 'none';
        });
        
        // Show the current question
        const currentQuestionElement = document.getElementById(`question${index}`);
        if (currentQuestionElement) {
            currentQuestionElement.style.display = 'block';
        } else {
            console.error(`Question element with id question${index} not found`);
            return;
        }
        
        // Update navigation buttons
        prevBtn.style.display = index > 0 ? "inline-block" : "none";
        nextBtn.style.display = index < questions.length - 1 ? "inline-block" : "none";
        submitBtn.style.display = index === questions.length - 1 ? "inline-block" : "none";
    }

    // Navigation buttons event listeners
    nextBtn.addEventListener("click", function () {
        // Validate current question
        const currentQuestionElement = document.getElementById(`question${currentQuestion}`);
        if (!currentQuestionElement) return;
        
        const inputs = currentQuestionElement.querySelectorAll('input[required]');
        let isValid = true;
        
        inputs.forEach(input => {
            if ((input.type === 'radio' && !document.querySelector(`input[name="${input.name}"]:checked`)) ||
                (input.type === 'text' && !input.value.trim())) {
                isValid = false;
            }
        });
        
        if (!isValid) {
            alert('Please answer the question before proceeding.');
            return;
        }
        
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

    // Submit button event listener
    submitBtn.addEventListener("click", function() {
        // Validate last question
        const lastQuestionElement = document.getElementById(`question${currentQuestion}`);
        if (!lastQuestionElement) return;
        
        const inputs = lastQuestionElement.querySelectorAll('input[required]');
        let isValid = true;
        
        inputs.forEach(input => {
            if ((input.type === 'radio' && !document.querySelector(`input[name="${input.name}"]:checked`)) ||
                (input.type === 'text' && !input.value.trim())) {
                isValid = false;
            }
        });
        
        if (!isValid) {
            Swal.fire({
                icon: 'warning',
                title: 'Please Answer',
                text: 'Please answer the question before submitting.'
            });
            return;
        }
        
        // Create FormData and collect answers
        const formData = new FormData(form);
        const answers = [];
        
        // Collect all answers
        questions.forEach((question, index) => {
            if (question.question_type === 'text') {
                const textInput = document.querySelector(`input[name="q${index}"]`);
                if (textInput && textInput.value.trim()) {
                    answers.push({
                        question_id: question.id,
                        question: question.question,
                        answer: textInput.value.trim()
                    });
                }
            } else {
                const selectedOption = document.querySelector(`input[name="q${index}"]:checked`);
                if (selectedOption) {
                    let answer = selectedOption.value;
                    
                    // If "Other" is selected, get the other input value
                    if (answer === 'Other') {
                        const otherInput = document.querySelector(`input[name="q${index}_other"]`);
                        if (otherInput && otherInput.value.trim()) {
                            answer = otherInput.value.trim();
                        }
                    }
                    
                    answers.push({
                        question_id: question.id,
                        question: question.question,
                        answer: answer
                    });
                }
            }
        });
        
        // Add answers to FormData
        formData.append('answers', JSON.stringify(answers));
        
        // Set the submit button to loading state
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Submitting...';
        
        // Submit using fetch API
        fetch(form.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json'
            }
        })
        .then(response => {
            if (!response.ok) {
                return response.json().then(data => Promise.reject(data));
            }
            return response.json();
        })
        .then(data => {
            // Show success message
            Swal.fire({
                icon: 'success',
                title: 'Thank You!',
                text: 'Your questionnaire has been submitted successfully.',
                confirmButtonText: 'Find Professionals'
            }).then(() => {
                // Explicitly redirect to professionals page
                window.location.href = "/professionals";
            });
            
            // Reset modal
            resetModal();
            $('#mcqModal').modal('hide');
        })
        .catch(error => {
            console.error('Submission error:', error);
            submitBtn.disabled = false;
            submitBtn.innerHTML = 'Submit';
            
            Swal.fire({
                icon: 'error',
                title: 'Submission Failed',
                text: error.message || 'Something went wrong. Please try again.'
            });
        });
    });
});
	</script>
		
	<script>
		// Combined Live Search and Find Button functionality
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('serviceSearch');
    const searchResults = document.getElementById('searchResults');
    const searchButton = document.getElementById('searchButton');
    const searchForm = searchInput.closest('form');
    let searchTimeout;
    let currentResults = [];

    // Prevent form submission
    if (searchForm) {
        searchForm.addEventListener('submit', function(e) {
            e.preventDefault();
            handleSearchButtonClick();
        });
    }

    // Find button click event
    searchButton.addEventListener('click', function(e) {
        e.preventDefault();
        handleSearchButtonClick();
    });

    // Function to handle Find button click
    function handleSearchButtonClick() {
        const query = searchInput.value.trim();
        
        // Changed from query.length < 2 to query.length < 1
        if (query.length < 1) {
            toastr.warning('Please enter at least 1 character to search');
            return;
        }
        
        // If we already have results from typing, use the first result
        if (currentResults.length > 0) {
            window.location.href = `/service/${currentResults[0].id}`;
            return;
        }
        
        // Otherwise, perform a search and navigate to first result
        searchButton.disabled = true;
        searchButton.value = 'Searching...';
        
        fetch(`/search-services?query=${encodeURIComponent(query)}`)
            .then(response => response.json())
            .then(data => {
                searchButton.disabled = false;
                searchButton.value = 'Find';
                
                if (data.services && data.services.length > 0) {
                    // If there's an exact match, go to that
                    const exactMatch = data.services.find(service => 
                        service.name.toLowerCase() === query.toLowerCase());
                    
                    if (exactMatch) {
                        window.location.href = `/service/${exactMatch.id}`;
                    } else {
                        // Otherwise go to first result
                        window.location.href = `/service/${data.services[0].id}`;
                    }
                } else {
                    toastr.error('No matching services found. Please try a different search term.');
                }
            })
            .catch(error => {
                console.error('Error searching:', error);
                searchButton.disabled = false;
                searchButton.value = 'Find';
                toastr.error('An error occurred while searching. Please try again.');
            });
    }

    // Function to fetch search results for the dropdown
    function fetchSearchResults(query) {
        // Changed from query.length < 2 to query.length < 1
        if (query.length < 1) {
            searchResults.classList.add('d-none');
            searchResults.innerHTML = '';
            currentResults = [];
            return;
        }

        fetch(`/search-services?query=${encodeURIComponent(query)}`)
            .then(response => response.json())
            .then(data => {
                // Store results for later use by the Find button
                currentResults = data.services || [];
                
                if (currentResults.length > 0) {
                    // Display search results
                    searchResults.classList.remove('d-none');
                    searchResults.innerHTML = `
                        <div class="list-group shadow">
                            ${currentResults.map(service => `
                                <a href="/service/${service.id}" class="list-group-item list-group-item-action">
                                    ${service.name}
                                </a>
                            `).join('')}
                        </div>
                    `;
                } else {
                    // No results found
                    searchResults.classList.remove('d-none');
                    searchResults.innerHTML = `
                        <div class="list-group shadow">
                            <div class="list-group-item text-muted">No result found</div>
                        </div>
                    `;
                }
                
                // Ensure proper positioning
                searchResults.style.left = '0';
                searchResults.style.right = 'auto';
            })
            .catch(error => {
                console.error('Error fetching search results:', error);
                currentResults = [];
                searchResults.classList.add('d-none');
            });
    }

    // Search input event for live results
    searchInput.addEventListener('input', function() {
        const query = this.value.trim();
        
        // Clear previous timeout
        clearTimeout(searchTimeout);

        // Set new timeout for debounce
        searchTimeout = setTimeout(() => {
            fetchSearchResults(query);
        }, 300);
    });

    // Handle keyboard navigation in search results
    searchInput.addEventListener('keydown', function(e) {
        if (e.key === 'Enter' && !searchResults.classList.contains('d-none')) {
            e.preventDefault();
            
            // Find the first result link and navigate to it
            const firstResult = searchResults.querySelector('.list-group-item');
            if (firstResult && firstResult.href) {
                window.location.href = firstResult.href;
            } else {
                // If no results are visible, trigger the Find button
                handleSearchButtonClick();
            }
        }
    });

    // Hide results when clicking outside
    document.addEventListener('click', function(event) {
        if (!searchInput.contains(event.target) && !searchResults.contains(event.target)) {
            searchResults.classList.add('d-none');
        }
    });

    // Show results when input is focused
    searchInput.addEventListener('focus', function() {
        // Changed from this.value.trim().length >= 2 to this.value.trim().length >= 1
        if (this.value.trim().length >= 1) {
            fetchSearchResults(this.value.trim());
        }
    });
});

	</script>

	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
 @endsection
