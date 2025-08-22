<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="Discover trusted professionals in career counselling, business, health, finance, and more. Book verified experts easily with Tazen.in.">
	<meta name="keywords" content="career counselling, health experts, finance professionals, business consultants, verified experts, professional consultation, appointment booking, Tazen">
	<meta name="author" content="Tazen">
	<meta name="csrf-token" content="{{ csrf_token() }}">
	
	<!-- SEO Meta Tags -->
	<meta name="robots" content="index, follow">
	<meta name="googlebot" content="index, follow">
	<link rel="canonical" href="{{ url()->current() }}">
	
	<!-- Open Graph Meta Tags for Social Media -->
	<meta property="og:title" content="Tazen.in | Find Verified Experts for Career, Health & Finance">
	<meta property="og:description" content="Discover trusted professionals in career counselling, business, health, finance, and more. Book verified experts easily with Tazen.in.">
	<meta property="og:type" content="website">
	<meta property="og:url" content="{{ url()->current() }}">
	<meta property="og:site_name" content="Tazen.in">
	<meta property="og:image" content="{{ asset('frontend/assets/img/tazen-logo.png') }}">
	
	<!-- Twitter Card Meta Tags -->
	<meta name="twitter:card" content="summary_large_image">
	<meta name="twitter:title" content="Tazen.in | Find Verified Experts for Career, Health & Finance">
	<meta name="twitter:description" content="Discover trusted professionals in career counselling, business, health, finance, and more. Book verified experts easily with Tazen.in.">
	<meta name="twitter:image" content="{{ asset('frontend/assets/img/tazen-logo.png') }}">
	
	<title>Tazen.in | Find Verified Experts for Career, Health & Finance</title>

	<!-- Font Awesome -->
	<link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.6.0/css/all.css">

<!-- SPECIFIC CSS -->
<link href="{{ asset('frontend/assets/css/home.css') }}" rel="stylesheet">

<!-- YOUR CUSTOM CSS -->
<link href="{{ asset('frontend/assets/css/custom.css') }}" rel="stylesheet">
{{-- <link rel="stylesheet" href="{{ asset('frontend/assets/css/new-style.css') }}"> --}}
{{-- <link rel="stylesheet" href="{{ asset('frontend/assets/css/testi.css') }}">
<link rel="stylesheet" href="{{ asset('frontend/assets/css/listing.css') }}">
<link rel="stylesheet" href="{{ asset('frontend/assets/css/details.css') }}">
<link rel="stylesheet" href="{{ asset('frontend/assets/css/detail-page.css') }}">
<link rel="stylesheet" href="{{ asset('frontend/assets/css/event-list.css') }}"> --}}
{{-- <link rel="stylesheet" href="{{ asset('frontend/assets/css/blog.css') }}">
<link rel="stylesheet" href="{{ asset('frontend/assets/css/owl2.css') }}">
<link rel="stylesheet" href="{{ asset('frontend/assets/css/aos.css') }}">
<link rel="stylesheet" href="{{ asset('frontend/assets/css/astro.css') }}">
<link rel="stylesheet" href="{{ asset('frontend/assets/css/campaign.css') }}"> --}}
{{-- <link rel="stylesheet" href="{{ asset('frontend/assets/style.css') }}">
<link rel="stylesheet" href="{{ asset('frontend/assets/css/responsive.css') }}">
<link rel="stylesheet" href="{{ asset('frontend/assets/css/slick.min.css') }}">
<link rel="stylesheet" href="{{ asset('frontend/assets/css/campaign-detail.css') }}">
<link rel="stylesheet" href="{{ asset('frontend/assets/css/swiper-bundle.min.css') }}"> --}}
{{-- <link rel="stylesheet" href="{{ asset('frontend/assets/css/newsliders.css') }}">
<link rel="stylesheet" href="{{ asset('frontend/assets/css/newslidertwo.css') }}">
<link rel="stylesheet" href="{{ asset('frontend/assets/css/account.css') }}">
<link rel="stylesheet" href="{{ asset('frontend/assets/css/contacts.css') }}"> --}}
{{-- <link rel="stylesheet" href="{{ asset('frontend/assets/css/blog.css') }}"> --}}
@yield('styles')
 

	<!-- slick slider css  -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.css" />
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick-theme.min.css" />
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" />
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css" />
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" />

	<!-- Project CSS -->
	<link href="{{ asset('frontend/assets/css/bootstrap.min.css') }}" rel="stylesheet">
	<link href="{{ asset('frontend/assets/css/style.css') }}" rel="stylesheet">
	<link href="{{ asset('frontend/assets/css/form.css') }}" rel="stylesheet">
	<link href="{{ asset('frontend/assets/css/home.css') }}" rel="stylesheet">
	<link href="{{ asset('frontend/assets/css/custom.css') }}" rel="stylesheet">
	<link href="{{ asset('frontend/assets/css/new-style.css') }}" rel="stylesheet">
	<link href="{{ asset('frontend/assets/css/layout.css') }}" rel="stylesheet">
	<link rel="stylesheet" href="{{ asset('frontend/assets/css/responsive2.css') }}" media="screen and (max-width: 992px)">

	@yield('styles')

	<!-- Bootstrap Bundle -->
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
	<style>
		.item  {
		  display: block;
		
		  height: 400px;
		  
		}
		/* Success toast */
.toast-success {
    background-color: #51A351 !important;
    color: #fff !important;
}

/* Error toast */
.toast-error {
    background-color: #BD362F !important;
    color: #fff !important;
}

/* Info toast */
.toast-info {
    background-color: #2F96B4 !important;
    color: #fff !important;
}

/* Warning toast */
.toast-warning {
    background-color: #F89406 !important;
    color: #fff !important;
}

</style>
	
	<style>
		.question {
			display: none;
		}
		.question.active {
			display: block;
		}
		.form-check {
			margin-bottom: 10px;
		}
		.card-body {
			height: 200px;
			background-size: cover;
			background-position: center;
		}
		.one { background-color: #f8d7da; }
		.two { background-color: #d1e7dd; }
		.three { background-color: #cfe2ff; }
		.four { background-color: #fff3cd; }
		.five { background-color: #e2e3e5; }
		.six { background-color: #d9f2f9; }
		.seven { background-color: #f8d7da; }
		.eight { background-color: #d1e7dd; }
		.btn_1 {
			background: #4e63d7;
			color: #fff;
			padding: 8px 20px;
			border-radius: 30px;
			border: none;
			text-decoration: none;
			display: inline-block;
		}
		.btn_1:hover {
			background: #3a4eb3;
			color: #fff;
		}
		.content-discover {
			display: flex;
			justify-content: space-between;
			align-items: center;
		}
	</style>

	<!-- WhatsApp Floating Button Styles -->
	<style>
		.whatsapp-float {
			position: fixed;
			width: 60px;
			height: 60px;
			bottom: 25px;
			right: 25px;
			background-color: #25d366;
			color: #FFF;
			border-radius: 50px;
			text-align: center;
			font-size: 28px;
			box-shadow: 2px 2px 3px #999;
			z-index: 1000;
			transition: all 0.3s ease;
			display: flex;
			align-items: center;
			justify-content: center;
			text-decoration: none;
		}

		.whatsapp-float:hover {
			background-color: #20ba5a;
			transform: scale(1.1);
			color: #FFF;
			text-decoration: none;
			box-shadow: 0 4px 15px rgba(37, 211, 102, 0.4);
		}

		.whatsapp-float i {
			margin-top: 0;
		}

		/* Pulse animation */
		.whatsapp-float::before {
			content: '';
			position: absolute;
			top: 0;
			left: 0;
			right: 0;
			bottom: 0;
			border-radius: 50%;
			border: 2px solid #25d366;
			animation: pulse 2s infinite;
			opacity: 0.7;
		}

		@keyframes pulse {
			0% {
				transform: scale(1);
				opacity: 0.7;
			}
			50% {
				transform: scale(1.1);
				opacity: 0.4;
			}
			100% {
				transform: scale(1.2);
				opacity: 0;
			}
		}

		/* Responsive adjustments */
		@media (max-width: 768px) {
			.whatsapp-float {
				width: 50px;
				height: 50px;
				bottom: 80px; /* Adjusted for mobile */
				right: 20px;
				font-size: 24px;
			}
		}

		/* Tooltip */
		.whatsapp-float .tooltip-text {
			visibility: hidden;
			width: 140px;
			background-color: #333;
			color: #fff;
			text-align: center;
			border-radius: 6px;
			padding: 8px;
			position: absolute;
			z-index: 1;
			bottom: 70px;
			right: 0;
			font-size: 12px;
			opacity: 0;
			transition: opacity 0.3s;
		}

		.whatsapp-float .tooltip-text::after {
			content: "";
			position: absolute;
			top: 100%;
			right: 20px;
			margin-left: -5px;
			border-width: 5px;
			border-style: solid;
			border-color: #333 transparent transparent transparent;
		}

		.whatsapp-float:hover .tooltip-text {
			visibility: visible;
			opacity: 1;
		}
	</style>
</head>

<body>

	@include('frontend.sections.header')

	@yield('content')
	
	@if (!isset($showFooter) || $showFooter)
	@include('frontend.sections.footer')
	@endif

	<!-- WhatsApp Floating Button -->
	<a href="https://wa.me/+919147421560?text=Hello%20Tazen!%20I%20need%20assistance%20with%20your%20services." target="_blank" class="whatsapp-float">
		<i class="fab fa-whatsapp"></i>
		<span class="tooltip-text">Chat with us on WhatsApp</span>
	</a>

	@yield('script')

	<!-- External JS -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>

	<!-- Project JS -->
	<script src="{{ asset('frontend/assets/js/common_scripts.min.js') }}"></script>
	<script src="{{ asset('frontend/assets/js/common_func.js') }}"></script>
	<script src="{{ asset('frontend/assets/validate.js') }}"></script>
	<script src="{{ asset('frontend/assets/js/sticky_sidebar.min.js') }}"></script>
	<script src="{{ asset('frontend/assets/js/datepicker_func_1.js') }}"></script>
	<script src="{{ asset('frontend/assets/js/datepicker.min.js') }}"></script>
	<script src="{{ asset('frontend/assets/js/specific_detail.min.js') }}"></script>
	<script src="{{ asset('frontend/assets/js/jquery.cookiebar.js') }}"></script>
	<script>
		$(document).ready(function () {
			$('.slick_slider').slick();
		});

		$(window).on("load",function(){
		  var $container = $('.isotope-wrapper');
		  $container.isotope({ itemSelector: '.isotope-item', layoutMode: 'masonry' });
		});
		$('.switch-field').on( 'click', 'input', 'change', function(){
		  var selector = $(this).attr('data-filter');
		  $('.isotope-wrapper').isotope({ filter: selector });
		});
	</script>


	<script>
		$(document).ready(function () {
			$('.services-carousal').owlCarousel({
				loop: true,
				margin: 10,
				responsiveClass: true,

				nav: false,
				dots: false,
				autoplay: true,               // Enable autoplay
				autoplayTimeout: 2000,        // Time between slides (1 second)
				autoplayHoverPause: true,     // Pause on mouse hover
				ltr: true,
				responsive: {
					0: {
						items: 1,

					},
					600: {
						items: 2,

					},
					1000: {
						items: 3,

					}
				}
			})
		});
	</script>


	<script>
		// Video Header
		HeaderVideo.init({
			container: $('.header-video'),
			header: $('.header-video--media'),
			videoTrigger: $("#video-trigger"),
			autoPlayVideo: true,
		});
	</script>
	<script type="text/javascript">
		function openmodal(val) {

			$("#openPopups").modal('show');
			$('#modal_title').val(val);

		}
	</script>
	 <script type="text/javascript">
        $(function(){   
    initSlider();
});


function initSlider() {
        
    var slider = $(".slider");
        
    slider.on("init", function(slick) {
        checkSlides(this, 0);
    });
    
    slider.on("beforeChange", function(event, slick, currentSlide, nextSlide) {
        $(this).addClass("changing");
    });
    
    slider.on("afterChange", function(event, slick, currentSlide) {
        $(this).removeClass("changing");
        checkSlides(this, currentSlide);
    });
    
    
    slider.slick({
        prevArrow: "<button type='button' class='slick-prev' aria-label='Previous picture'></button>",
        nextArrow: "<button type='button' class='slick-next' aria-label='Next Picture'></button>",
        centerMode: true,
        variableWidth: true,
        dots: true,
    autoplay: true,
    slidesToShow: 1,
    });
    
}

function checkSlides(slider, currentSlide) {
    var slides = $(".slide", $(slider));
    slides.removeClass("prev");
    slides.filter(function(index) {
        return $(this).attr("data-slick-index") < currentSlide;
    }).addClass("prev");;
}

    </script>

    <script type="text/javascript">
        jQuery(".property-slide").slick({
          dots: false,
          infinite: true,
          speed: 300,
          slidesToShow: 2,
          slidesToScroll: 2,
          arrows: true,
          autoplay: true,
          autoplaySpeed: 6000,
          prevArrow:
            '<button class="slick-prev fa-solid fa-arrow-left" aria-label="Prev"></button>',
          nextArrow:
            '<button class="slick-next fa-solid fa-arrow-right" aria-label="Next"></button>',
          responsive: [
            {
              breakpoint: 992,
              settings: {
                slidesToShow: 2,
                slidesToScroll: 2
              }
            },
            {
              breakpoint: 600,
              settings: {
                slidesToShow: 1,
                slidesToScroll: 1
              }
            },
            {
              breakpoint: 480,
              settings: {
                slidesToShow: 1,
                slidesToScroll: 1
              }
            }
            // You can unslick at a given breakpoint now by adding:
            // settings: "unslick"
            // instead of a settings object
          ]
        });

    </script>
	<script>
		$(document).ready(function(){
			$('.slick_slider').slick();
		});
	</script>
	

	<script>
		$(document).ready(function () {
			$('.services-carousal').owlCarousel({
				loop: true,
				margin: 10,
				responsiveClass: true,

				nav: false,
				dots: false,
				autoplay: true,               // Enable autoplay
				autoplayTimeout: 2000,        // Time between slides (1 second)
				autoplayHoverPause: true,     // Pause on mouse hover
				ltr: true,
				responsive: {
					0: {
						items: 1,

					},
					600: {
						items: 2,

					},
					1000: {
						items: 3,

					}
				}
			})
		});
	</script>
	<script>
		$(document).ready(function() {
			'use strict';
			$.cookieBar({
				fixed: true
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
		$('.owl-carousel').owlCarousel({
			loop: true,
			margin: 0,
			autoWidth:true,
		   nav: false,
			responsive: {
				0: {
					items: 1
				},
				600: {
					items: 3
				},
				1000: {
					items: 3
				}
			}
		});
	});
</script>
<script>
$(document).ready(function () {
	$('.gallery-carousal').owlCarousel({
		loop: true,
		margin: 10,
	  
		autoplay: true,           // Enables autoplay
		autoplayHoverPause: true, // Pauses autoplay on hover
		nav: false, 
		responsive: {
			0: {
				items: 1
			},
			600: {
				items: 2
			},
			1000: {
				items: 2
			}
		}
	});
});
</script>


<script>
	document.getElementById("read-more").addEventListener("click", function() {
var fullText = document.getElementById("full-text");
var shortText = document.getElementById("short-text");

if (fullText.style.display === "none") {
	fullText.style.display = "inline";
	shortText.style.display = "none";
	this.textContent = "Read Less"; // Change link text to "Read Less"
} else {
	fullText.style.display = "none";
	shortText.style.display = "inline";
	this.textContent = "Read More"; // Change link text back to "Read More"
}
});

</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
<script>
	let currentQuestion = 1;
	const totalQuestions = 5;
	
	function showQuestion(num) {
		$('.question').hide();
		$('#question' + num).show();
	
		$('#prevBtn').toggle(num > 1);
		$('#nextBtn').toggle(num < totalQuestions);
		$('#submitBtn').toggle(num === totalQuestions);
	}
	
	$('.book-now-btn').on('click', function () {
		const serviceId = $(this).data('service-id');
	
		// Reset navigation
		currentQuestion = 1;
	
		$.ajax({
			url: `/get-mcqs/${serviceId}`,
			method: 'GET',
			success: function (mcq) {
				if (mcq) {
					// Fill the questions
					$('#question1 h6').text('Question 1: ' + mcq.question1);
					$('#q1a').next().text(mcq.option1_a);
					$('#q1b').next().text(mcq.option1_b);
					$('#q1c').next().text(mcq.option1_c);
					$('#q1d').next().text(mcq.option1_d);
	
					$('#question2 h6').text('Question 2: ' + mcq.question2);
					$('#q2a').next().text(mcq.option2_a);
					$('#q2b').next().text(mcq.option2_b);
					$('#q2c').next().text(mcq.option2_c);
					$('#q2d').next().text(mcq.option2_d);
	
					$('#question3 h6').text('Question 3: ' + mcq.question3);
					$('#q3a').next().text(mcq.option3_a);
					$('#q3b').next().text(mcq.option3_b);
					$('#q3c').next().text(mcq.option3_c);
					$('#q3d').next().text(mcq.option3_d);
	
					$('#question4 h6').text('Question 4: ' + mcq.question4);
					$('#q4a').next().text(mcq.option4_a);
					$('#q4b').next().text(mcq.option4_b);
					$('#q4c').next().text(mcq.option4_c);
					$('#q4d').next().text(mcq.option4_d);
	
					$('#question5 h6').text('Question 5: ' + mcq.question5);
					$('#mcqForm textarea[name="q5"]').val('');
	
					showQuestion(currentQuestion);
				}
			}
		});
	});
	
	$('#nextBtn').on('click', function () {
		if (currentQuestion < totalQuestions) {
			currentQuestion++;
			showQuestion(currentQuestion);
		}
	});
	
	$('#prevBtn').on('click', function () {
		if (currentQuestion > 1) {
			currentQuestion--;
			showQuestion(currentQuestion);
		}
	});
	$.get('/get-mcq-questions/' + serviceId, function(data) {
    // fill the modal content with MCQ questions
    $('#mcqModal .modal-body').html(data);
    $('#mcqModal').modal('show');
});
	</script>
	
	
</body>
</html>
