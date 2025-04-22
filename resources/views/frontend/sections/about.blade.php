@extends('layouts.layout')
@section('styles')
   {{-- <link rel="stylesheet" href="{{ asset('admin/css/styles.css') }}" /> --}}
@endsection
@section('content')

<main>
    <div class="hero_single inner_pages contact-page">
        <div class="opacity-mask" data-opacity-mask="rgba(0, 0, 0, 0)">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-xl-9 col-lg-10 col-md-8">
                        <h1>About Tazen</h1>
                        <p>Know More  About Our Company</p>

                    </div>
                </div>
                <!-- /row -->
            </div>
        </div>
    </div>
    <!-- /hero_single -->
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
                                    <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry’s standard dummy text ever.</p>
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
                                  <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry’s standard dummy text ever.</p>
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
                                  <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry’s standard dummy text ever.</p>
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
                                  <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry’s standard dummy text ever.</p>
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
                                <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry’s standard dummy text ever.</p>
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
                              <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry’s standard dummy text ever.</p>
                            </div>
                          </div>
                    </div>
                     </div>
                </div>
            </div>
        </div>
    </section>
    <section class="home-about-section py-5" style="background-color: #FFF2E1;">
        <div class="container">
         <div class="row">
             <div class="col-lg-6">
                 <div class="about-inside-content">
                     <small>--- About Us ---</small>
                     <div class="main-about-content">
                         <h1>Explore Our Services And Boost Your Online Presence</h1>
                         <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry’s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.</p>

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
                             <button  class=" btn_1 medium">Get Started</button>
                         <a href="about-us.html"><button  class="btn new-custom-btn">Discover More</button></a>	
                         </div>
                     </div>
                 </div>
             </div>
             <div class="col-lg-6 position-relative d-flex align-item-center justify-content-center">
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
    <!-- /bg_gray -->
     <!-- fun-fact-section  -->
    


    <section class="bg_gray counter-section-info about-page-counter py-5">
        <div class="container my-5">
            <div class="row heading">
                <div class="col ">
                    <div class="main_title center ">
                        <span><em></em></span>
                        <h2>Experience Make Tazen Different</h2>
                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit.</p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6 hero-info">
                    <div class="counter-hero-info">
                        <h1>Grow Your Online Presence.</h1>
                        <p>Hundreds of thousands of small businesses have found new customers on Tazen</p>
                        <button  class=" btn_1 medium">Get Started</button>

                        
                    </div>

                </div>
                <div class="col-lg-6 col-md-6 d-flex flex-column gap-lg-4 gap-md-3 gap-sm-4 gap-4 mt-md-0 mt-sm-5 mt-5">
                    <div class="d-flex align-items-center gap-4 ex-card" data-aos="fade-up">
                        <div class="d-flex align-items-center justify-content-center">
                            <h3 class="count">90</h3>
                            <h3>%</h3>
                        </div>
                        <div>
                            <h4>Creative Approach</h4>
                            <p>Lorem Ipsum Dolor Sit Amet, Consectetur Adipiscing Elit, Sed Do Eiusmod Tempor Incididunt.
                            </p>
                        </div>
                    </div>
                    <div class="d-flex align-items-center gap-4 ex-card" data-aos="fade-up" data-aos-delay="300">
                        <div class="d-flex align-items-center justify-content-center">
                            <h3 class="count">99</h3>
                            <h3>%</h3>
                        </div>
                        <div>
                            <h4>Guaranteed Success</h4>
                            <p>Lorem Ipsum Dolor Sit Amet, Consectetur Adipiscing Elit, Sed Do Eiusmod Tempor Incididunt.
                            </p>
                        </div>
                    </div>
                    <div class="d-flex align-items-center gap-4 ex-card" data-aos="fade-up" data-aos-delay="400">
                        <div class="d-flex align-items-center justify-content-center">
                            <h3 class="count">85</h3>
                            <h3>%</h3>
                        </div>
                        <div>
                            <h4>Brand Strategy</h4>
                            <p>Lorem Ipsum Dolor Sit Amet, Consectetur Adipiscing Elit, Sed Do Eiusmod Tempor Incididunt.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section> 


    <section class="services-counter-section-info py-5" style="background-image: url('img/professionals_photos/about-work-section.jpeg');">
        <div class="container my-5">
            <div class="row heading">
                <div class="col ">
                    <div class="main_title center ">
                        <span><em></em></span>
                        <h2 class="text-white">How We work?</h2>
                        <h2 class="text-white">Our Process For Delivering Results</h2>
                        
                        <p class="text-white">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry’s standard dummy text ever.</p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6 hero-info">
                    <div class="counter-hero-info">
                        <h1 class="text-white">Join a buzzing marketplace</h1>
                        <p class="text-white">Lorem ipsum dolor sit amet consectetur adipiscing elit torquent nu nascetu cubilia tempor lacus natoque quis auctor mattis luctus varius pretium aptent urna iaculis suspendisse eros egestas mollis dis nisl commodo.</p>
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
                                        <h3>Make An Appointment</h3>
                                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 counter-box">
                                <div class="card widget">
                                    <div class="icon">
                                        <i class="fa-solid fa-circle-2"></i>

                                    </div>
                                    <div class="text-info">
                                        <h3>Meet Our Professional Team</h3>
                                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit.s.</p>
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
                                        <h3> Get Consultation</h3>
                                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit.video call!</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 counter-box">
                                <div class="card widget">
                                    <div class="icon">
                                        <i class="fa-solid fa-circle-4"></i>

                                    </div>
                                    <div class="text-info">
                                        <h3>Start Project</h3>
                                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit.video call!</p>
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>




    <section class="ttm-row padding_top_zero-section ttm-bgcolor-white clearfix testimonial-new" >
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
            <div class="row slick_slider " data-slick='{"slidesToShow":4, "slidesToScroll": 1, "arrows":false, "autoplay":true, "dots":false, "infinite":true, "responsive":[{"breakpoint":1199,"settings": {"slidesToShow": 3}},{"breakpoint":992,"settings":{"slidesToShow": 2}},{"breakpoint":767,"settings":{"slidesToShow": 2}}, {"breakpoint":600,"settings":{"slidesToShow": 1}}]}'>
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

    

    <section class="faq position-relative">
        <span> </span>
        <div class="container">
            <div class="row d-flex align-items-center">
                <div class="col-lg-6 col-md-6 text-md-start text-sm-center text-center" data-aos="fade-up">
                    <div class="d-flex gap-3 justify-content-md-start justify-content-sm-center justify-content-center align-items-center">
                        <hr class="faq-hr1">
                        <h5>FAQ</h5>
                    </div>
                    <h2 class="h2_margin">Frequently Asked Questions</h2>
                    <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry’s standard dummy text ever.
                    </p>
                </div>
                <div class="col-lg-6 col-md-6 mt-md-0 mt-sm-4 mt-4">
                    <div class="accordion d-flex flex-column gap-4" id="accordionExample" data-aos="fade-down">
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingOne">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                          WHAT KIND OF DIGITAL SERVICES DO YOU
                          PROVIDE?
                          </button>
                            </h2>
                            <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation.
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingTwo">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                          WHAT IS YOUR PROCESS FOR WORKING
                          WITH CLIENTS?
                          </button>
                            </h2>
                            <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation.
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingThree">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                          WHAT IS YOUR TIMELINE FOR COMPLETING
                          A PROJECT?
                          </button>
                            </h2>
                            <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation.
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingfour">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapsefour" aria-expanded="false" aria-controls="collapsefour">
                          WHAT IF I'M NOT SATISFIED WITH THE
                          WORK?
                          </button>
                            </h2>
                            <div id="collapsefour" class="accordion-collapse collapse" aria-labelledby="headingfour" data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <!-- /container -->

</main>

@endsection