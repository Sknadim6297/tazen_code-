<!-- /header -->
@extends('layouts.layout')
@section('styles')
   {{-- <link rel="stylesheet" href="{{ asset('admin/css/styles.css') }}" /> --}}
   <link rel="stylesheet" href="{{ asset('frontend/assets/css/newslidertwo.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/newsliders.css') }}">
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
				<source src="{{ asset('storage/' . $banner->banner_video) }}" type="video/mp4">
				Your browser does not support the video tag.
			</video>
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
														<button class="btn btn-primary book-now" 
														data-service-id="{{ $service->id }}" 
														data-bs-toggle="modal" 
														data-bs-target="#mcqModal">
														Book Now
													</button>
											
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
								<form id="mcqForm" method="POST" action="{{ route('submit.mcq') }}">
									@csrf
									<input type="hidden" name="service_id" id="selected_service_id">
									<!-- Loop through MCQs -->
									@foreach ($mcqs as $index => $mcq)
										<div class="question" id="question{{ $index + 1 }}">
											<h6>Question {{ $index + 1 }}: {{ $mcq->question }}</h6>
				
											@foreach (['answer1', 'answer2', 'answer3', 'answer4'] as $opt)
												<div class="form-check">
													<input class="form-check-input" type="radio" name="q{{ $index + 1 }}" id="q{{ $index + 1 }}{{ $opt }}" value="{{ $mcq->$opt }}" required>
													<label class="form-check-label" for="q{{ $index + 1 }}{{ $opt }}">{{ $mcq->$opt }}</label>
												</div>
											@endforeach
										</div>
									@endforeach
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
								data-src="url('{{ asset('frontend/assets/img/services-pic/arrow_about.png') }}')" alt="" class="arrow_2 lazy">
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


		<!-- ====== 1.10. Testimonials section ====== -->
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
		
				<div class="row slick_slider"
					 data-slick='{"slidesToShow":4,"slidesToScroll":1,"arrows":false,"autoplay":true,"dots":false,"infinite":true,"responsive":[{"breakpoint":1199,"settings":{"slidesToShow":3}},{"breakpoint":992,"settings":{"slidesToShow":2}},{"breakpoint":767,"settings":{"slidesToShow":2}},{"breakpoint":600,"settings":{"slidesToShow":1}}]}'>
					
					@php
						$totalSlides = 6; // Total slides to display
						$testimonialCount = count($testimonials);
					@endphp
		
					@for($i = 0; $i < $totalSlides; $i++)
						<div class="col-md-4 col-sm-12 ttm-box-col-wrapper">
							<div class="testimonial-box">
								@php
									$isEven = $i % 2 === 0;
								@endphp
		
								@if($i < $testimonialCount)
									{{-- Real testimonial --}}
									@php $t = $testimonials[$i]; @endphp
									@if($isEven)
										<div class="testimonial-content bg-lavender mb-15">
											{{ $t->description }}
										</div>
										<div class="testimonial-img bg-blue">
											<img src="{{ asset('storage/'.$t->image) }}" alt="Testimonial Image">
										</div>
									@else
										<div class="testimonial-img bg-pink mb-15">
											<img src="{{ asset('storage/'.$t->image) }}" alt="Testimonial Image">
										</div>
										<div class="testimonial-content bg-green">
											{{ $t->description }}
										</div>
									@endif
								@else
									{{-- Dummy testimonial --}}
									@if($isEven)
										<div class="testimonial-content bg-lavender mb-15">
											This is a sample testimonial. Excellent service and support!
										</div>
										<div class="testimonial-img bg-blue">
											<img src="{{ asset('images/dummy'.($i+1).'.jpg') }}" alt="Dummy Image">
										</div>
									@else
										<div class="testimonial-img bg-pink mb-15">
											<img src="{{ asset('images/dummy'.($i+1).'.jpg') }}" alt="Dummy Image">
										</div>
										<div class="testimonial-content bg-green">
											This is a sample testimonial. Highly recommended!
										</div>
									@endif
								@endif
							</div>
						</div>
					@endfor
		
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
							<p>Explore our blogs</p>
						</div>
					</div>
				</div>
				<div class="row row-cols-lg-3 row-cols-md-2 row-cols-1">
					@foreach ($blogs as $blog)
						<div class="col-sm-12">
							<div class="thumb-blog-overlay bg-white hover-text-PushUpBottom mb-4">
								<a href="{{ url('/blog/' . $blog->id) }}">
									<div class="post-image position-relative overlay-secondary">
										<img src="{{ asset('storage/' . $blog->image) }}" alt="Blog Image" class="img-fluid">
									</div>
								</a>
								<div class="post-content p-35">
									<h5 class="d-block font-400 mb-3">
										<a href="{{ url('/blog/' . $blog->id) }}" class="transation text-dark hover-text-primary">
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
					<div class="question" id="question${index + 1}" style="display: none;">
						<h6>Question ${index + 1}: ${question.question}</h6>
						<div class="form-check">
							<input class="form-check-input" type="radio" name="q${index + 1}" id="q${index + 1}answer1" value="${question.answer1}" required>
							<label class="form-check-label" for="q${index + 1}answer1">${question.answer1}</label>
						</div>
						<div class="form-check">
							<input class="form-check-input" type="radio" name="q${index + 1}" id="q${index + 1}answer2" value="${question.answer2}" required>
							<label class="form-check-label" for="q${index + 1}answer2">${question.answer2}</label>
						</div>
						<div class="form-check">
							<input class="form-check-input" type="radio" name="q${index + 1}" id="q${index + 1}answer3" value="${question.answer3}" required>
							<label class="form-check-label" for="q${index + 1}answer3">${question.answer3}</label>
						</div>
						<div class="form-check">
							<input class="form-check-input" type="radio" name="q${index + 1}" id="q${index + 1}answer4" value="${question.answer4}" required>
							<label class="form-check-label" for="q${index + 1}answer4">${question.answer4}</label>
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

			submitBtn.addEventListener("click", function () {
				const formData = new FormData(form);
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
