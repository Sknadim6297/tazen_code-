@extends('layouts.layout')

@section('styles')
    {{-- <link rel="stylesheet" href="{{ asset('admin/css/styles.css') }}" /> --}}
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/newslidertwo.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/newsliders.css') }}">
@endsection

@section('content')
<main>
    <div class="hero_single fitness-yoga" style="background-image: url('{{ asset('storage/' . $service->detail->banner_image) }}'); background-size: cover; background-position: center;">
        <div class="opacity-mask" data-opacity-mask="rgba(0, 0, 0, 0.4)">
            <div class="container">
                <div class="row">
                    <div class="col-xl-9 col-lg-10">
                        <h1>{{ $service->detail->banner_heading }}</h1>
                        <p>{{ $service->detail->banner_sub_heading }}</p>
                        <form >
                            <div class="row g-0 custom-search-input">
                                <div class="col-md-9">
                                    <div class="form-group">
                                        <input class="form-control" type="text" placeholder="Chat or Video Call ....">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <input type="submit" id="openPopups" value="Find" onclick="return false;">
                                </div>
                            </div>
                            <!-- /row -->
                            <div class="search_trends">
                                <h5>Trending:</h5>
                                <ul>
                                    <li><a href="#0">doctor</a></li>
                                    <li><a href="#0">lawyer</a></li>
                                    <li><a href="#0">teacher</a></li>
                                    <li><a href="#0">psychologist</a></li>
                                </ul>
                            </div>
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

            <div class="inside-question-model">
                <div class="progress-container">
                    <div class="progress-bars" id="progressBar"></div>
                </div>
                <h1 class="text-center" style="font-size: 30px;">what are you looking for ?</h1>

                <form action="" id="progressForm">
                    <div class="step step-3">
                        <div class="question question-1">
                            <label>
                                <input type="checkbox" name="option" value="option-1" required>
                                <span class="text-span">option one</span>
                            </label>
                        </div>

                        <div class="question question-2">
                            <label>
                                <input type="checkbox" name="option" value="option-1" required>
                                <span class="text-span">option two</span>
                            </label>
                        </div>

                        <div class="question question-3">
                            <label>
                                <input type="checkbox" name="option" value="option-1" required>
                                <span class="text-span">option three</span>
                            </label>
                        </div>

                        <div class="question question-3">
                            <label>
                                <input type="checkbox" name="option" value="option-1" required>
                                <span class="text-span">option three</span>
                            </label>
                        </div>

                        <div class="question question-3">
                            <label>
                                <input type="checkbox" name="option" value="option-1" required>
                                <span class="text-span">option three</span>
                            </label>
                        </div>

                        <div class="question question-3">
                            <label>
                                <input type="checkbox" name="option" value="option-1" required>
                                <span class="text-span">option three</span>
                            </label>
                        </div>

                        <div class="question question-3">
                            <label>
                                <input type="checkbox" name="option" value="option-1" required>
                                <span class="text-span">option three</span>
                            </label>
                        </div>

                        <div class="question question-3">
                            <label>
                                <input type="checkbox" name="option" value="option-1" required>
                                <span class="text-span">option three</span>
                            </label>
                        </div>

                        <div class="question question-3">
                            <label>
                                <input type="checkbox" name="option" value="option-1" required>
                                <span class="text-span">option three</span>
                            </label>
                        </div>

                        <div class="question question-3">
                            <label>
                                <input type="checkbox" name="option" value="option-1" required>
                                <span class="text-span">option three</span>
                            </label>
                        </div>
                    </div>
                    
                    <div class="step step-4">
                        <h2>step 4</h2>
                        <label>
                            <input type="radio" name="option" value="option-1" required>option 1
                        </label><br>
                        <label>
                            <input type="radio" name="option" value="option-1" required>option 1
                        </label><br>
                        <label>
                            <input type="radio" name="option" value="option-1" required>option 1
                        </label><br>
                    </div>
                    
                    <div class="button-area d-flex">
                        <div class="col-lg-6 text-start one-btn">
                            <button class="btn new-style-form-btn" id="back-control">Back</button>
                        </div>
                        <div class="col-lg-6 text-end two-btn">
                            <button class="btn new-style-form-btn" id="progress-control">Continue</button>
                        </div>
                    </div>
                </form>
            </div>
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
                    <p class="add_top_30"><a href="#0" class="btn_1">Start Searching</a></p>
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
                        <p class="add_top_30"><a href="#0" class="btn_1">Start Searching</a></p>
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
    <section style="background-color: #FFF2E1;">
        <div class="container service-container py-5">
            <div class="row heading">
                <div class="col">
                    <div class="main_title center">
                        <span><em></em></span>
                        <h2>Related Services</h2>
                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit.</p>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="owl-carousel services-carousal">
                    @foreach($services as $relatedService)
                        <div class="card">
                            <div 
                                class="card-body" 
                                style="background-image: url('{{ asset($relatedService->image) }}'); background-size: cover; background-position: center; border-radius: .375rem;"
                            ></div>
                            
                            <div class="info mt-3 p-2">
                                <div class="content-discover p-3 d-flex justify-content-between align-items-center">
                                    <div class="l">
                                        <p class="text-dark mb-0">{{ $relatedService->name }}</p>
                                    </div>
                                    <div class="r">
                                        <button class="btn_1 book-now-btn" data-bs-toggle="modal" data-bs-target="#mcqModal">Book Now</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
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
    
    <section class="cta-bg-color-new">
        <div class="call_section version_2 lazy">
            <div class="container clearfix">
                <div class="row">
                    <div class="col-md-6 wow">
                        <img src="img/are-you-pro.png" alt="">
                    </div>
                    <div class="col-md-6 wow">
                        <div class="box_1">
                            <div class="ribbon_promo"><span>Free</span></div>
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
</main>
@endsection