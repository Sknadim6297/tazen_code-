@extends('layouts.layout')

@section('styles')
    {{-- <link rel="stylesheet" href="{{ asset('admin/css/styles.css') }}" /> --}}
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/newslidertwo.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/newsliders.css') }}">
    <style>
        @media (max-width: 767px) {
    .how_2 figure img {
        width: 327px;
    }
}

    .btn-custom{
        background: linear-gradient(135deg, #152a70, #c51010, #f39c12);
        color: white;
        border: none;
        transition: all 0.3s ease;
    }
    .bg_gray {
    background-color: white;
            background-size: 400% 400%;
            animation: gradientBG 18s ease infinite;
            min-height: 100vh;
        }
        /*@keyframes gradientBG {*/
        /*    0% { background-position: 0% 50%; }*/
        /*    50% { background-position: 100% 50%; }*/
        /*    100% { background-position: 0% 50%; }*/
}
    

    .btn-custom:hover {
        background: linear-gradient(135deg, #1a3080, #d91111, #ffa726);
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(0,0,0,0.3) !important;
        color: white;
    }

    .btn-custom:active {
        transform: translateY(0);
    }

    /* Service page specific styling - remove search input background and shadow */
    .service-page .custom-search-input {
        background: none !important;
        box-shadow: none !important;
        border: none !important;
        padding: 0 !important;
    }

    @media (max-width: 991px) {
    .custom-search-input {
        margin-left: 0;
    }
    }
    @media only screen and (min-width: 768px) and (max-width: 1024px) {
    .need-help-service .container .text-center figure::before {
    position: absolute;
    top: 12%;
    right: 188px;
    }

    .services-counter-section-info .container .row .counter-section .card{
        margin-top: 10px;
    }
}

.text{
		color: white;
	}

    </style>
@endsection

@section('content')
<main class="service-page">
     <div class="hero_single fitness-yoga" style="background-image: url('{{ asset('storage/' . $service->detail->banner_image) }}'); background-size: cover; background-position: center;">
        <div class="opacity-mask" data-opacity-mask="rgba(0, 0, 0, 0.4)">
            <div class="container">
                <div class="row">
                    <div class="col-xl-9 col-lg-10">
                        <h1>{{ $service->detail->banner_heading }}</h1>
                        <p>{{ $service->detail->banner_sub_heading }}</p>
                        <form>
                            <div class="row g-0 custom-search-input">
                                <div class="col-12" style="display: flex; justify-content: flex-start;">
                                    <a href="{{ url('/professionals?service_id=' . $service->id) }}" class="btn btn-custom btn-lg px-5 py-3" style="background: linear-gradient(135deg, #152a70, #c51010, #f39c12); font-size: 1rem; font-weight: 600; border-radius: 50px; box-shadow: 0 4px 15px rgba(0,0,0,0.2); transition: all 0.3s ease; text-align: center; margin: 0; text-decoration: none; color: white;">
                                        <i class="fas fa-calendar-check me-2"></i>Book Now
                                    </a>
                                </div>
                            </div>
                            <!-- /row -->
                            {{-- <div class="search_trends new-search_trends">
    <h5>Trending:</h5>
    <ul class="new-ul-list-header">
        @foreach($services->take(4) as $service)
            <li><a href="{{ url('/service/' . $service->id) }}">{{ strtolower($service->name) }}</a></li>
        @endforeach
    </ul>
</div> --}}
                        </form>
                    </div>
                </div>
                <!-- /row -->
            </div>
        </div>
    </div>
    
    <!-- form area  -->
    <div id="progressModel" class="model">
        <div class="model-content mx-auto"> 
            <span class="close" id="closeModel">&times;</span>
            <div class="img"></div>
        </div>
    </div>
    <!-- /hero_single -->
    
    <div class="bg_gray need-help-service">
        <div class="container margin_60_40">
            <div class="row justify-content-md-center how_2">
                <div class="col-lg-5">
                    <h1>{{ $service->detail->about_heading }}</h1>
                    <p>{{ $service->detail->about_subheading }}</p>
                    <p>{{ $service->detail->about_description }}</p>
                    <p class="add_top_30">
                        <a href="{{ url('/professionals?service_id=' . $service->id) }}" class="btn_1" style="background: linear-gradient(135deg, #152a70, #c51010, #f39c12); text-decoration: none; color: white;">Start Searching</a>
                    </p>
                </div>
                <div class="col-lg-5 text-center">
                    <figure>
                        <img 
                            src="{{ asset('storage/' . $service->detail->about_image) }}" 
                            data-src="{{ asset('storage/' . $service->detail->about_image) }}" 
                            alt="About Image" 
                            class="img-fluid lazy" 
                            width="360" 
                            height="380">
                    </figure>
                </div>
            </div>
            <!-- /row -->
        </div>
        <!-- /container -->
    </div>

    <section class="services-counter-section-info py-5" style="background: url('{{ asset('storage/' . $service->detail->background_image) }}')center center / cover no-repeat;">
        <div class="container my-5">
            <div class="row heading">
                <div class="col">
                    <div class="main_title center">
                        <span><em></em></span>
                        <h2 class="text-white">How does it works?</h2>
                        <p class="text-white">{{ $service->detail->how_it_works_subheading }}</p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6 hero-info">
                    <div class="counter-hero-info">
                        <h1 class="text-white">{{ $service->detail->content_heading }}</h1>
                        <p class="text-white">{{ $service->detail->content_sub_heading }}</p>
                        <p class="add_top_30">
                            <a href="{{ url('/professionals?service_id=' . $service->id) }}" class="btn_1" style="background: linear-gradient(135deg, #152a70, #c51010, #f39c12); text-decoration: none; color: white;">Start Searching</a>
                        </p>
                    </div>
                </div>
                <div class="col-lg-6 counter-section">
                    <div class="container counter">
                        <div class="row">
                            <div class="col-lg-6 counter-box">
                                <div class="card widget">
                                    <div class="icon">
                                        <i class="fa-solid fa-circle-1"></i>
                                    </div>
                                    <div class="text-info">
                                        <h3>{{ $service->detail->step1_heading }}</h3>
                                        <p>{{ $service->detail->step1_description }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 counter-box">
                                <div class="card widget">
                                    <div class="icon">
                                        <i class="fa-solid fa-circle-2"></i>
                                    </div>
                                    <div class="text-info">
                                        <h3>{{ $service->detail->step2_heading }}</h3>
                                        <p>{{ $service->detail->step2_description }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row second-row">
                            <div class="col-lg-6 counter-box mx-auto">
                                <div class="card widget">
                                    <div class="icon">
                                        <i class="fa-solid fa-circle-3"></i>
                                    </div>
                                    <div class="text-info">
                                        <h3>{{ $service->detail->step3_heading }}</h3>
                                        <p>{{ $service->detail->step3_description }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <!-- popular category section  -->
   <section style="background-color: #f8f9fa;">
    </section>
    <!-- /bg_gray -->

    <!-- testimonials slider  -->
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
                                           <p class="text"> This is a sample testimonial. Excellent service and support!</p>
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
    
    <section class="cta-bg-color-new">
        <div class="call_section version_2 lazy">
            <div class="container clearfix">
                <div class="row">
                    <div class="col-md-6 wow">
                        <img src="{{ asset('frontend/assets/img/are-you-pro.png')}}" alt="">
                    </div>
                    <div class="col-md-6 wow">
                        <div class="box_1">
                            <div class="ribbon_promo"></div>
                            <h3>Are you a Professional?</h3>
                            <p>Join Us to increase your online visibility. You'll have access to even more customers who are looking to professional service or consultation.</p>
                            <a href="submit-professional.html" class="new-unique-btn">Read more</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--/call_section-->
    
    <!-- Social Share Section -->
    <section class="add_bottom_30">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="social-share-section text-center p-4" style="background: #f8f9fa; border-radius: 15px; box-shadow: 0 4px 20px rgba(0,0,0,0.1);">
                        <h6 class="text-dark mb-3" style="font-weight: 600; font-size: 1.2rem;">
                            <i class="fas fa-share-alt me-2"></i>Share this service:
                        </h6>
                        @php
                            $serviceName = $service->name ?? 'Service';
                            $serviceUrl = url()->current();
                        @endphp
                        <ul class="share-buttons d-flex justify-content-center flex-wrap gap-3" style="list-style: none; padding: 0; margin: 0;">
                            <li><a class="fb-share btn btn-primary btn-sm d-flex align-items-center" href="#0" onclick="shareOnFacebookService('{{ $serviceName }}', '{{ $serviceUrl }}')" style="background: #1877f2; border: none; padding: 10px 15px; border-radius: 8px; text-decoration: none; color: white;"><i class="fab fa-facebook-f me-2"></i> Facebook</a></li>
                            <li><a class="x-share btn btn-dark btn-sm d-flex align-items-center" href="#0" onclick="shareOnXService('{{ $serviceName }}', '{{ $serviceUrl }}')" style="background: #000; border: none; padding: 10px 15px; border-radius: 8px; text-decoration: none; color: white;"><i class="fab fa-x-twitter me-2"></i> X</a></li>
                            <li><a class="whatsapp-share btn btn-success btn-sm d-flex align-items-center" href="#0" onclick="shareOnWhatsAppService('{{ $serviceName }}', '{{ $serviceUrl }}')" style="background: #25d366; border: none; padding: 10px 15px; border-radius: 8px; text-decoration: none; color: white;"><i class="fab fa-whatsapp me-2"></i> WhatsApp</a></li>
                            <li><a class="instagram-share btn btn-sm d-flex align-items-center" href="#0" onclick="shareOnInstagramService('{{ $serviceName }}', '{{ $serviceUrl }}')" style="background: linear-gradient(45deg, #f09433 0%,#e6683c 25%,#dc2743 50%,#cc2366 75%,#bc1888 100%); border: none; padding: 10px 15px; border-radius: 8px; text-decoration: none; color: white;"><i class="fab fa-instagram me-2"></i> Instagram</a></li>
                            <li><a class="copy-link btn btn-secondary btn-sm d-flex align-items-center" href="#0" onclick="copyLinkService('{{ $serviceUrl }}')" style="background: #6c757d; border: none; padding: 10px 15px; border-radius: 8px; text-decoration: none; color: white;"><i class="fas fa-copy me-2"></i> Copy Link</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

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
        
        // Social sharing functions for service pages
        window.shareOnFacebookService = function(serviceName, url) {
            const shareUrl = `https://www.facebook.com/sharer/sharer.php?u=${encodeURIComponent(url)}&quote=${encodeURIComponent(`Check out this service: ${serviceName}`)}`;
            window.open(shareUrl, '_blank', 'width=600,height=400');
        };

        window.shareOnXService = function(serviceName, url) {
            const text = `Check out this service: ${serviceName}`;
            const shareUrl = `https://x.com/intent/tweet?text=${encodeURIComponent(text)}&url=${encodeURIComponent(url)}`;
            window.open(shareUrl, '_blank', 'width=600,height=400');
        };

        window.shareOnWhatsAppService = function(serviceName, url) {
            const text = `Check out this service: ${serviceName} ${url}`;
            const shareUrl = `https://wa.me/?text=${encodeURIComponent(text)}`;
            window.open(shareUrl, '_blank');
        };

        window.shareOnInstagramService = function(serviceName, url) {
            navigator.clipboard.writeText(url).then(function() {
                alert('Link copied to clipboard! Open Instagram and paste it in your story or post.');
            }).catch(function() {
                alert('Please copy this link and share it on Instagram: ' + url);
            });
        };

        window.copyLinkService = function(url) {
            navigator.clipboard.writeText(url).then(function() {
                alert('Service link copied to clipboard!');
            }).catch(function() {
                const textArea = document.createElement('textarea');
                textArea.value = url;
                document.body.appendChild(textArea);
                textArea.select();
                document.execCommand('copy');
                document.body.removeChild(textArea);
                alert('Service link copied to clipboard!');
            });
        };
    });
    });
</script>
@endsection