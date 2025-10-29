<!-- /header -->
@extends('layouts.layout')

@php
use App\Helpers\ImageHelper;
@endphp

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
.login-popup-title {
        font-size: 1.5rem !important;
        color: white !important;
    }

    .login-popup-title .wave-icon {
        font-size: 1.8rem !important;
    }

    .login-popup-custom {
        background: linear-gradient(135deg, #152a70, #c51010, #f39c12) !important;
        color: white !important;
        border-radius: 15px !important;
        padding: 25px 20px !important;
    }

    .login-popup-btn {
        background-color: #1e0d60 !important;
        color: white !important;
        font-size: 1.2rem !important;
        font-weight: 600 !important;
        padding: 12px 30px !important;
        border-radius: 50px !important;
        border: none !important;
        box-shadow: 0 4px 15px rgba(0,0,0,0.2) !important;
    }

    .login-popup-btn:hover {
        transform: translateY(-3px) !important;
        box-shadow: 0 6px 20px rgba(0,0,0,0.3) !important;
    }
    
    .login-popup-close {
        color: white !important;
        opacity: 0.8 !important;
        font-size: 1.5rem !important;
    }
    
    .login-popup-close:hover {
        opacity: 1 !important;
    }
</style>
@endsection
@section('content')
	<main>
		<!-- Notification Section -->
		@if(session('warning'))
			<div class="alert alert-warning alert-dismissible fade show" role="alert" style="margin: 0; border-radius: 0;">
				<div class="container">
					<strong>Notice:</strong> {{ session('warning') }}
					<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
				</div>
			</div>
		@endif
		
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
            <li><a href="{{ url('/service/' . $service->slug) }}">{{ strtolower($service->name) }}</a></li>
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
							<p>Explore a Wide Range of Expert Services Tailored to Your Personal and Professional Needs</p>
						</div>
					</div>
				</div>
				<div class="container py-5 position-relative">
					<button class="carousel-arrow left-arrow" style="position:absolute;left:-40px;top:50%;transform:translateY(-50%);z-index:2;background:#fff;border:none;border-radius:50%;width:40px;height:40px;box-shadow:0 2px 8px rgba(0,0,0,0.1);display:flex;align-items:center;justify-content:center;"><i class="fa fa-chevron-left"></i></button>
					<button class="carousel-arrow right-arrow" style="position:absolute;right:-40px;top:50%;transform:translateY(-50%);z-index:2;background:#fff;border:none;border-radius:50%;width:40px;height:40px;box-shadow:0 2px 8px rgba(0,0,0,0.1);display:flex;align-items:center;justify-content:center;"><i class="fa fa-chevron-right"></i></button>
					<div class="row">
						<div class="owl-carousel services-carousal">
							@foreach($services as $service)
								<div class="card">
									<div 
										class="card-body" 
							        style="background-image: url('{{ Storage::url($service->image) }}'); background-size: cover; background-position: center; border-radius: .375rem;"
									></div>
									
									<div class="info mt-3 p-2">
										<div class="content-discover p-3 d-flex justify-content-between align-items-center">
											<div class="l">
												<p class="text-dark mb-0">{{ $service->name }}</p>
											</div>
											<div class="r">
														<button class="btn btn-custom book-now" data-service-id="{{ $service->id }}" onclick="selectServiceAndRedirect({{ $service->id }}, '{{ $service->name }}')">Book Now</button>
											
											</div>
										</div>
									</div>
								</div>
							@endforeach
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
								<h3>{{ $aboutus->heading }}</h3>
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
									<a href="{{ url('/login') }}"><button class=" btn_1 medium" style="    background: linear-gradient(135deg, #152a70, #c51010, #f39c12);
">Get Started</button></a>
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
					<p>Stay Updated with the Latest Workshops, Webinars, and Expert-Led Sessions</p>
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
                                            <img src="{{ asset('storage/'.$t->image) }}" alt="Testimonial Image" style="width: 70%; height: 100%;">
                                        </div>
                                    @else
                                        <div class="testimonial-img bg-pink mb-15">
                                            <img src="{{ asset('storage/'.$t->image) }}" alt="Testimonial Image" style="width: 70%; height: 100%;">
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
                                            <img src="{{ asset('images/dummy'.($i+1).'.jpg') }}" alt="Dummy Image" style="width: 100%; height: auto;">
                                        </div>
                                    @else
                                        <div class="testimonial-img bg-pink mb-15">
                                            <img src="{{ asset('images/dummy'.($i+1).'.jpg') }}" alt="Dummy Image" style="width: 100%; height: auto;">
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
								<a href="{{ route('blog.show', \Illuminate\Support\Str::slug($blogPost->blog->title)) }}">
									<div class="post-image position-relative overlay-secondary" style="height: 200px; overflow: hidden;">
										<img src="{{ ImageHelper::getStorageImageUrl($blogPost->image, 'img/lazy-placeholder.png') }}" alt="{{ $blogPost->blog->title }}" class="img-fluid" style="width: 100%; height: 100%; object-fit: cover;">
									</div>
								</a>
								<div class="post-content p-35">
									<h5 class="d-block font-400 mb-3">
											<a href="{{ route('blog.show', \Illuminate\Support\Str::slug($blogPost->blog->title)) }}" class="transation text-dark hover-text-primary">
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
								<h4>Are you a Professional?</h4>
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
// Simple service selection function for index page
function selectServiceAndRedirect(serviceId, serviceName) {
    // Save service ID and name in session for later use
    fetch('/set-service-session', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({
            service_id: serviceId,
            service_name: serviceName
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'success') {
            // Redirect to professionals listing page
            window.location.href = '/professionals';
        } else {
            console.error('Failed to save service session');
            // Even if session save fails, still redirect
            window.location.href = '/professionals';
        }
    })
    .catch(error => {
        console.error('Error:', error);
        // Even if session save fails, still redirect
        window.location.href = '/professionals';
    });
}
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
            window.location.href = `/service/${currentResults[0].slug}`;
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
                        window.location.href = `/service/${exactMatch.slug}`;
                    } else {
                        // Otherwise go to first result
                       window.location.href = `/service/${data.services[0].slug}`;
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
                                <a href="/service/${service.slug}" class="list-group-item list-group-item-action">
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


<style>
.carousel-arrow {
    transition: background 0.2s;
}
.carousel-arrow:hover {
    background: #f0f0f0;
}
@media (max-width: 991px) {
    .carousel-arrow.left-arrow { left: 0; }
    .carousel-arrow.right-arrow { right: 0; }
}
</style>
<script>
document.addEventListener('DOMContentLoaded', function() {
    var $carousel = $('.services-carousal');
    $('.left-arrow').on('click', function() {
        $carousel.trigger('prev.owl.carousel');
    });
    $('.right-arrow').on('click', function() {
        $carousel.trigger('next.owl.carousel');
    });
    
    // Handle blog image loading errors with fallbacks
    const blogImages = document.querySelectorAll('.thumb-blog-overlay img, .post-image img');
    
    blogImages.forEach(img => {
        img.addEventListener('error', function() {
            if (this.src.includes('storage/')) {
                // Blog image fallback
                this.src = '{{ asset("img/lazy-placeholder.png") }}';
                this.style.opacity = '0.7';
            }
        });
        
        img.addEventListener('load', function() {
            this.classList.add('loaded');
            this.style.opacity = '1';
        });
    });
});
</script>
