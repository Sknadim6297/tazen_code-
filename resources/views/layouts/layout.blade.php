<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description"
		content="Prozim - Find a Professional and Book a Consultation by Appointment, Chat or Video call">
	<meta name="author" content="Ansonika">
	<title>Find a Professional and Book a Consultation by Appointment, Chat or Video call</title>

	<!-- Favicons-->
	<link rel="shortcut icon" href="img/favicon.jpg" type="image/x-icon">
	<link rel="apple-touch-icon" type="image/x-icon" href="img/apple-touch-icon-57x57-precomposed.png">
	<link rel="apple-touch-icon" type="image/x-icon" sizes="72x72" href="img/apple-touch-icon-72x72-precomposed.png">
	<link rel="apple-touch-icon" type="image/x-icon" sizes="114x114"
		href="img/apple-touch-icon-114x114-precomposed.png">
	<link rel="apple-touch-icon" type="image/x-icon" sizes="144x144"
		href="img/apple-touch-icon-144x144-precomposed.png">
	<!-- font awasome  -->
	<link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.6.0/css/all.css">
	<!-- BASE CSS -->
	<link href="{{ asset('frontend/assets/css/bootstrap.min.css') }}" rel="stylesheet">
<link href="{{ asset('frontend/assets/css/style.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('frontend/assets/css/form.css') }}">

<!-- SPECIFIC CSS -->
<link href="{{ asset('frontend/assets/css/home.css') }}" rel="stylesheet">

<!-- YOUR CUSTOM CSS -->
<link href="{{ asset('frontend/assets/css/custom.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('frontend/assets/css/new-style.css') }}">
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


	<!-- slick slider css  -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.css" />
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick-theme.min.css" />
	<!-- Include Owl Carousel CSS and JS -->
	<link rel="stylesheet"
		href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" />
	<link rel="stylesheet"
		href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css" />



	<style>
		@import url('https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap');

		body {
			font-family: "Poppins";
		}
	</style>



	<style>
		.service-container .card {
			position: relative;
			/* cursor: pointer; */
			border-radius: 12px;
		}


		.service-container .card .card-body {
			height: 420px;
			/* position: relative; */
			cursor: pointer;
		}

		.service-container .card .info {
			position: absolute;
			bottom: 0;
			left: 0;
			background: transparent;
			width: 100%;
			/* text-align: right; */
			padding: 6px;

			border-top: 0;
			border-bottom: 0;
			opacity: 1;
			/* transition: 0.3s ease; */
		}

		.service-container .card .info .content-discover {
			display: flex;
			border-radius: 6px;
			background: #ffffff;

		}

		.service-container .card .info .content-discover .l {
			text-align: start;
			width: 60%;
			align-content: center;
		}

		.service-container .card .info .content-discover .r {
			margin-right: 8px;
			text-align: end;
			width: 40%;
		}

		/* .service-container .card:hover .info{

	opacity: 1;
   transition: 0.3s ease;
   bottom: 0px;

  } */

		.service-container .card .info .text-dark {
			text-transform: uppercase;
			font-size: 15px !important;
			font-weight: 550;
			margin-bottom: 0px;
		}

		.service-container .card .one {
			background-image: url(img/professionals_photos/seven-services/career-consultant.jpg);
			background-size: cover;
			background-position: center;
			background-repeat: no-repeat;
			border-radius: 12px;
		}

		.service-container .card .two {
			background-image: url(img/professionals_photos/seven-services/interior-design-service.jpg);
			background-size: cover;
			background-position: center;
			background-repeat: no-repeat;
			border-radius: 12px;
		}

		.service-container .card .three {
			background-image: url(img/services-pic/astro-service.jpg);
			background-size: cover;
			background-position: center;
			background-repeat: no-repeat;
			border-radius: 12px;
		}

		.service-container .card .four {
			background-image: url(img/services-pic/yoga-consult.jpg);
			background-size: cover;
			background-position: center;
			background-repeat: no-repeat;
			border-radius: 12px;
		}

		.service-container .card .five {
			background-image: url(img/services-pic/stylish-consutant.jpg);
			background-size: cover;
			background-position: center;
			background-repeat: no-repeat;
			border-radius: 12px;
		}

		.service-container .card .six {
			background-image: url(img/professionals_photos/seven-services/Influencer-consulating.jpg);
			background-size: cover;
			background-position: center;
			background-repeat: no-repeat;
			border-radius: 12px;
		}

		.service-container .card .seven {
			background-image: url(img/professionals_photos/seven-services/psychology-consulting.jpg);
			background-size: cover;
			background-position: center;
			background-repeat: no-repeat;
			border-radius: 12px;
		}

		.service-container .card .eight {
			background-image: url(img/professionals_photos/seven-services/food-dietician.jpg);
			background-size: cover;
			background-position: center;
			background-repeat: no-repeat;
			border-radius: 12px;
		}
	</style>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

	
	
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
</head>

<body>
	@include('frontend.sections.header')
          @yield('content')
	@include('frontend.sections.footer')

      @yield('script')
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
	<link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet"/>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>


<script src="{{ asset('frontend/assets/js/common_scripts.min.js') }}"></script>
<script src="{{ asset('frontend/assets/js/common_func.js') }}"></script>
<script src="{{ asset('frontend/assets/validate.js') }}"></script>

<!-- SPECIFIC SCRIPTS -->
<script src="{{ asset('frontend/assets/js/modernizr.min.js') }}"></script>
<script src="{{ asset('frontend/assets/js/video_header.min.js') }}"></script>
<script src="{{ asset('frontend/assets/js/job-career-business.js') }}"></script>
<script src="{{ asset('frontend/assets/js/main_map_scripts.js') }}"></script>
<script src="{{ asset('frontend/assets/js/specific_listing.min.js') }}"></script>
<script src="{{ asset('frontend/assets/js/sticky_sidebar.min.js') }}"></script>
<script src="{{ asset('frontend/assets/js/datepicker_func_1.js') }}"></script>
<script src="{{ asset('frontend/assets/js/datepicker.min.js') }}"></script>
<script src="{{ asset('frontend/assets/js/specific_detail.min.js') }}"></script>
<script src="{{ asset('frontend/assets/js/details.js') }}"></script>
<script src="{{ asset('frontend/assets/js/isotope.min.js') }}"></script>
<script src="{{ asset('frontend/assets/js/isotope.pkgd.min.js') }}"></script>
<script src="{{ asset('frontend/assets/js/slick.min.js') }}"></script>
<script src="{{ asset('frontend/assets/js/owl2.js') }}"></script>
<script src="{{ asset('frontend/assets/js/custom2.js') }}"></script>
<script src="{{ asset('frontend/assets/js/aos.js') }}"></script>
<script src="{{ asset('frontend/assets/js/swiper-bundle.min.js') }}"></script>
<script src="{{ asset('frontend/assets/js/swiper.min.js') }}"></script>
<script src="{{ asset('frontend/assets/js/waypoints.min.js') }}"></script>
<script src="{{ asset('frontend/assets/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('frontend/assets/js/slide-two.js') }}"></script>
<script src="{{ asset('frontend/assets/js/jquery.cookiebar.js') }}"></script>


	<script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js"></script>

	<script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
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

