@extends('layouts.layout')
@section('styles')
   {{-- <link rel="stylesheet" href="{{ asset('admin/css/styles.css') }}" /> --}}
   <link rel="stylesheet" href="{{ asset('frontend/assets/css/newslidertwo.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/newsliders.css') }}">
@endsection
@section('content')

<main>
    @foreach($banners as $banner)
    <div class="hero_single inner_pages contact-page" style="background: url('{{ asset('storage/'.$banner->banner_image) }}') center center/cover no-repeat #ededed;">
        <div class="opacity-mask" data-opacity-mask="rgba(0, 0, 0, 0)">
            <div class="container">
                
                <div class="row justify-content-center">
                    <div class="col-xl-9 col-lg-10 col-md-8">
                        <h1>{{ $banner->heading }}</h1>
                        <p>{{ $banner->subheading }}</p>

                    </div>
                </div>
                
                <!-- /row -->
            </div>
        </div>
       
    </div>
    @endforeach
    <!-- /hero_single -->
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
    <section class="home-about-section py-5" style="background-color: #FFF2E1;">
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
                             <button  class=" btn_1 medium">Get Started</button>
                         <a href="about-us.html"><button  class="btn new-custom-btn">Discover More</button></a>	
                         </div>
                     </div>
                 </div>
             </div>
             <div class="col-lg-6 position-relative d-flex align-item-center justify-content-center">
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
         </div>
         @endforeach
        </div>
     </section>
    <!-- /bg_gray -->
     <!-- fun-fact-section  -->
    


    <section class="bg_gray counter-section-info about-page-counter py-5">
        <div class="container my-5">
            @foreach($aboutexperiences as $exp)
            <div class="row heading">
                <div class="col ">
                    <div class="main_title center ">
                        <span><em></em></span>
                        <h2>{{ $exp->section_heading }}</h2>
                        <p>{{ $exp->section_subheading }}</p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6 hero-info">
                    <div class="counter-hero-info">
                        <h1>{{ $exp->content_heading }}</h1>
                        <p>{{ $exp->content_subheading }}</p>
                        <button  class=" btn_1 medium">Get Started</button>

                        
                    </div>

                </div>
                <div class="col-lg-6 col-md-6 d-flex flex-column gap-lg-4 gap-md-3 gap-sm-4 gap-4 mt-md-0 mt-sm-5 mt-5">
                    <div class="d-flex align-items-center gap-4 ex-card" data-aos="fade-up">
                        <div class="d-flex align-items-center justify-content-center">
                            <h3 class="count">{{ $exp->experience_percentage1 }}</h3>
                            <h3>%</h3>
                        </div>
                        <div>
                            <h4>{{ $exp->experience_heading1 }}</h4>
                            <p>{{ $exp->description1 }}
                            </p>
                        </div>
                    </div>
                    <div class="d-flex align-items-center gap-4 ex-card" data-aos="fade-up" data-aos-delay="300">
                        <div class="d-flex align-items-center justify-content-center">
                            <h3 class="count">{{ $exp->experience_percentage2 }}</h3>
                            <h3>%</h3>
                        </div>
                        <div>
                            <h4>{{ $exp->experience_heading2 }}</h4>
                            <p>{{ $exp->description2 }}
                            </p>
                        </div>
                    </div>
                    <div class="d-flex align-items-center gap-4 ex-card" data-aos="fade-up" data-aos-delay="400">
                        <div class="d-flex align-items-center justify-content-center">
                            <h3 class="count">{{ $exp->experience_percentage3 }}</h3>
                            <h3>%</h3>
                        </div>
                        <div>
                            <h4>{{ $exp->experience_heading3 }}</h4>
                            <p>{{ $exp->description3 }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </section> 


    <section class="services-counter-section-info py-5" style="background-image: url('{{ asset('frontend/assets/img/professionals_photos/about-work-section.jpeg') }}');">
        <div class="container my-5">
            @foreach ($abouthowweworks as $how)
            <div class="row heading">
                <div class="col ">
                    <div class="main_title center ">
                        <span><em></em></span>
                        <h2 class="text-white">How We work?</h2>
                        <h2 class="text-white">{{ $how->section_heading }}</h2>
                        
                        <p class="text-white">{{ $how->section_sub_heading }}</p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6 hero-info">
                    <div class="counter-hero-info">
                        <h1 class="text-white">{{ $how->content_heading }}</h1>
                        <p class="text-white">{{ $how->content_sub_heading }}</p>
                        <p class="add_top_30"><a href="#0" class="btn_1">Join Team</a></p>

                        
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
                                        <h3>{{ $how->step1_heading }}</h3>
                                        <p>{{ $how->step1_description }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 counter-box">
                                <div class="card widget">
                                    <div class="icon">
                                        <i class="fa-solid fa-circle-2"></i>

                                    </div>
                                    <div class="text-info">
                                        <h3>{{ $how->step2_heading }}</h3>
                                        <p>{{ $how->step2_description }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row second-row">
                            <div class="col-lg-6 counter-box">
                                <div class="card widget">
                                    <div class="icon">
                                        <i class="fa-solid fa-circle-3"></i>

                                    </div>
                                    <div class="text-info">
                                        <h3> {{ $how->step3_heading }}</h3>
                                        <p>{{ $how->step3_description }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 counter-box">
                                <div class="card widget">
                                    <div class="icon">
                                        <i class="fa-solid fa-circle-4"></i>

                                    </div>
                                    <div class="text-info">
                                        <h3>{{ $how->step4_heading }}</h3>
                                        <p>{{ $how->step4_description }}</p>
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </section>




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

    

    <section class="faq position-relative">
        <span> </span>
        <div class="container">
            @foreach($aboutfaqs as $faq)
            <div class="row d-flex align-items-center">
                <div class="col-lg-6 col-md-6 text-md-start text-sm-center text-center" data-aos="fade-up">
                    <div class="d-flex gap-3 justify-content-md-start justify-content-sm-center justify-content-center align-items-center">
                        <hr class="faq-hr1">
                        <h5>FAQ</h5>
                    </div>
                    <h2 class="h2_margin">Frequently Asked Questions</h2>
                    <p>{{ $faq->faq_description }}
                    </p>
                </div>
                <div class="col-lg-6 col-md-6 mt-md-0 mt-sm-4 mt-4">
                    <div class="accordion d-flex flex-column gap-4" id="accordionExample" data-aos="fade-down">
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingOne">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                    {{ $faq->question1 }}
                          </button>
                            </h2>
                            <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    <p>{{ $faq->answer1 }}
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingTwo">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                    {{ $faq->question2 }}
                          </button>
                            </h2>
                            <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    <p>{{ $faq->answer2 }}
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingThree">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                    {{ $faq->question3 }}
                          </button>
                            </h2>
                            <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    <p>{{ $faq->answer3 }}
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingfour">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapsefour" aria-expanded="false" aria-controls="collapsefour">
                                    {{ $faq->question4 }}
                          </button>
                            </h2>
                            <div id="collapsefour" class="accordion-collapse collapse" aria-labelledby="headingfour" data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    <p>{{ $faq->answer4 }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </section>
    
    <!-- /container -->

</main>

@endsection