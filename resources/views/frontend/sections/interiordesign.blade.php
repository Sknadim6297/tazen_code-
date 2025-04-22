@extends('layouts.layout')
@section('styles')
   {{-- <link rel="stylesheet" href="{{ asset('admin/css/styles.css') }}" /> --}}
@endsection
@section('content')

<main>
    <div class="hero_single interior-designer">
        <div class="opacity-mask" data-opacity-mask="rgba(0, 0, 0, 0.4)">
            <div class="container">
                <div class="row">
                    <div class="col-xl-9 col-lg-10">
                        <h1>Find Interior Designer Experts near you</h1>
                        <p>Book a Consultation by Appointment, Chat or Video call</p>
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
            <div class="img">

            </div>

            <div class="inside-question-model">
                <div class="progress-container">
                    <div class="progress-bars" id="progressBar"></div>
                </div>
                <h1 class="text-center" style="font-size: 30px;">what are you looking for ?</h1>

                <form action="" id="progressForm">
                

                    <div class="step step-3">

                        <div class="question question-1">
                            <label>
                                <input type="checkbox" name="option" value="option-1" required><span
                                    class="text-span">
                                    option one
                                </span>
                            </label>
                        </div>

                        <div class="question question-2">
                            <label>
                                <input type="checkbox" name="option" value="option-1" required><span
                                    class="text-span">
                                    option two
                                </span>
                            </label>
                        </div>

                        <div class="question question-3">
                            <label>
                                <input type="checkbox" name="option" value="option-1" required><span
                                    class="text-span">
                                    option three
                                </span>
                            </label>
                        </div>

                        <div class="question question-3">
                            <label>
                                <input type="checkbox" name="option" value="option-1" required><span
                                    class="text-span">
                                    option three
                                </span>
                            </label>
                        </div>

                        <div class="question question-3">
                            <label>
                                <input type="checkbox" name="option" value="option-1" required><span
                                    class="text-span">
                                    option three
                                </span>
                            </label>
                        </div>

                        <div class="question question-3">
                            <label>
                                <input type="checkbox" name="option" value="option-1" required><span
                                    class="text-span">
                                    option three
                                </span>
                            </label>
                        </div>

                        <div class="question question-3">
                            <label>
                                <input type="checkbox" name="option" value="option-1" required><span
                                    class="text-span">
                                    option three
                                </span>
                            </label>
                        </div>

                        <div class="question question-3">
                            <label>
                                <input type="checkbox" name="option" value="option-1" required><span
                                    class="text-span">
                                    option three
                                </span>
                            </label>
                        </div>

                        <div class="question question-3">
                            <label>
                                <input type="checkbox" name="option" value="option-1" required><span
                                    class="text-span">
                                    option three
                                </span>
                            </label>
                        </div>

                        <div class="question question-3">
                            <label>
                                <input type="checkbox" name="option" value="option-1" required><span
                                    class="text-span">
                                    option three
                                </span>
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
                            <button class=" btn new-style-form-btn" id="back-control">Back</button>
                        </div>
                        <div class="col-lg-6 text-end two-btn">
                            <button class=" btn new-style-form-btn" id="progress-control">Continue</button>
                        </div>
                        
                        
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- /hero_single -->
    
    <div class="bg_gray need-help-service">
        <div class="container margin_60_40">
            <!-- <div class="main_title center add_bottom_10">
                <span><em></em></span>
                <h2>How does it works?</h2>
                <p>Cum doctus civibus efficiantur in imperdiet deterruisset.</p>
            </div> -->
            <div class="row justify-content-md-center how_2">
                <div class="col-lg-5">
                    <h1>Need help finding a Interior Designer Expert?</h1>
                    <p>You can find the best Tax Resolution Experts on Bark. Start your search and get free quotes now!  </p>
                    <p>First time looking for a Tax Resolution Expert and not sure where to start? Tell us about your project and we’ll send you a list of Tax Resolution Experts to review. There’s no pressure to hire, so you can compare profiles, read previous reviews and ask for more information before you make your decision. </p>

                    <p>Best of all - it’s completely free!</p>

                     <p class="add_top_30"><a href="#0" class="btn_1">Start Searching</a></p>
                 </div>
                <div class="col-lg-5 text-center">
                    <figure>
                        <img src="img/professionals_photos/Interior Designer consultant 360.jpg" data-src="img/professionals_photos/Interior Designer consultant 360.jpg" alt="" class="img-fluid lazy" width="360" height="380">
                    </figure>
                </div>
                
                <!-- /row -->
            </div>
        </div>
        <!-- /container -->
    </div>


    <!-- timeline  -->
    <!-- <div class="bg_gray">
        <div class="container margin_60_40">
            <div class="main_title center add_bottom_10">
                <span><em></em></span>
                <h2>How does it works?</h2>
                <p>Cum doctus civibus efficiantur in imperdiet deterruisset.</p>
            </div>
            <div class="row justify-content-md-center how_2">
                <div class="col-lg-5 text-center">
                    <figure>
                        <img src="img/services-pic/timeline-pic-two.png" data-src="img/services-pic/timeline-pic-two.png" alt="" class="img-fluid lazy" width="360" height="380">
                    </figure>
                </div>
                <div class="col-lg-5">
                   <ul>
                        <li>
                            <h3><span>#01.</span> Search for a Professional</h3>
                            <p>Search over 12.000 verifyed professionals that match your criteria.</p>
                        </li>
                        <li>
                            <h3><span>#02.</span> View Professional Profile</h3>
                            <p>View professional introduction and read reviews from other customers.</p>
                        </li>
                        <li>
                            <h3><span>#03.</span> Enjoy the Consultation</h3>
                            <p>Connect with your professional booking an appointment, via chat or video call!</p>
                        </li>
                    </ul>
                    <p class="add_top_30"><a href="#0" class="btn_1">Start Searching</a></p>
                </div>
              
            </div>
        </div>
       
    </div> -->
    <section class="services-counter-section-info py-5" style="background-image: url('img/professionals_photos/interior-designer.jpg');">
        <div class="container my-5">
            <div class="row heading">
                <div class="col ">
                    <div class="main_title center ">
                        <span><em></em></span>
                        <h2 class="text-white">How does it works?</h2>
                        <p class="text-white">Lorem ipsum dolor sit amet consectetur adipisicing elit.</p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6 hero-info">
                    <div class="counter-hero-info">
                        <h1 class="text-white">Building dreams one
                            room at a time</h1>
                        <p class="text-white">Lorem ipsum dolor sit amet consectetur adipiscing elit torquent nu nascetu cubilia tempor lacus natoque quis auctor mattis luctus varius pretium aptent urna iaculis suspendisse eros egestas mollis dis nisl commodo.</p>
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
                                        <h3>Search for a Professional</h3>
                                        <p>Search over 12.000 verifyed professionals that match your criteria.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 counter-box">
                                <div class="card widget">
                                    <div class="icon">
                                        <i class="fa-solid fa-circle-2"></i>

                                    </div>
                                    <div class="text-info">
                                        <h3>View Professional Profile</h3>
                                        <p>View professional introduction and read reviews from other customers.</p>
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
                                        <h3>Enjoy the Consultation</h3>
                                        <p>Connect with your professional booking an appointment, via chat or video call!</p>
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
        <div class="container margin_60_40">
            <div class="main_title center">
                <span><em></em></span>
                <h2>Events</h2>
                <p>Cum doctus civibus efficiantur in imperdiet deterruisset.</p>
            </div>
            <div class="row add_bottom_15">
                <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6">
                    <div class="strip">
                        <figure>
                            <a href="" class="wish_bt"><i class="icon_heart"></i></a>
                            <img src="img/event/astrologer event.jpg"
                                data-src="img/event/astrologer event.jpg" class="img-fluid lazy" alt="">
                            <a href="all-event.html" class="strip_info">
                                <div class="item_title">
                                    <h3>Dr. Maria Cornfield</h3>
                                    <small>Pediatrician, Psychologist ...</small>
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
                                <div class="score"><span>Superb<em>350 Reviews</em></span><strong>8.9</strong></div>
                            </li>
                        </ul>
                    </div>
                </div>
                <!-- /strip grid -->
                <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6">
                    <div class="strip">
                        <figure>
                            <a href="" class="wish_bt"><i class="icon_heart"></i></a>
                            <img src="img/event/fitness yoga event.jpg" data-src="img/event/fitness yoga event.jpg"
                                class="img-fluid lazy" alt="">
                            <a href="all-event.html" class="strip_info">
                                <div class="item_title">
                                    <h3>Lucy Shoemaker</h3>
                                    <small>Lawyer</small>
                                </div>
                            </a>
                        </figure>
                        <ul>
                            <li><a href="#0" class="tooltip-1" data-bs-toggle="tooltip" data-bs-placement="bottom"
                                    title="Available Appointment"><i class="icon-users"></i></a></li>
                            <li><a href="#0" class="tooltip-1" data-bs-toggle="tooltip" data-bs-placement="bottom"
                                    title="Available Chat"><i class="icon-chat"></i></a></li>
                            <li>
                                <div class="score"><span>Superb<em>350 Reviews</em></span><strong>8.9</strong></div>
                            </li>
                        </ul>
                    </div>
                </div>
                <!-- /strip grid -->
                <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6">
                    <div class="strip">
                        <figure>
                            <a href="" class="wish_bt"><i class="icon_heart"></i></a>
                         <img src="img/event/influencer event.jpg" data-src="img/event/influencer event.jpg"
                                class="img-fluid lazy" alt="">
                            <a href="all-event.html" class="strip_info">
                                <div class="item_title">
                                    <h3>Prof. Luke Lachinet</h3>
                                    <small>Math Teacher</small>
                                </div>
                            </a>
                        </figure>
                        <ul>
                            <li><a href="#0" class="tooltip-1" data-bs-toggle="tooltip" data-bs-placement="bottom"
                                    title="Available Appointment"><i class="icon-users"></i></a></li>
                            <li><a href="#0" class="tooltip-1" data-bs-toggle="tooltip" data-bs-placement="bottom"
                                    title="Available Video Call"><i class="icon-videocam"></i></a></li>
                            <li>
                                <div class="score"><span>Superb<em>350 Reviews</em></span><strong>8.9</strong></div>
                            </li>
                        </ul>
                    </div>
                </div>
                <!-- /strip grid -->
                <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6">
                    <div class="strip">
                        <figure>
                            <a href="" class="wish_bt"><i class="icon_heart"></i></a>
                            <img src="img/event/interior designer event.jpg" data-src="img/event/interior designer event.jpg"
                                class="img-fluid lazy" alt="">
                            <a href="all-event.html" class="strip_info">
                                <div class="item_title">
                                    <h3>Dr. Marta Rainwater</h3>
                                    <small>Psychologist</small>
                                </div>
                            </a>
                        </figure>
                        <ul>
                            <li><a href="#0" class="tooltip-1" data-bs-toggle="tooltip" data-bs-placement="bottom"
                                    title="Available Chat"><i class="icon-chat"></i></a></li>
                            <li><a href="#0" class="tooltip-1" data-bs-toggle="tooltip" data-bs-placement="bottom"
                                    title="Available Video Call"><i class="icon-videocam"></i></a></li>
                            <li>
                                <div class="score"><span>Superb<em>350 Reviews</em></span><strong>8.9</strong></div>
                            </li>
                        </ul>
                    </div>
                </div>
                <!-- /strip grid -->
                <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6">
                    <div class="strip">
                        <figure>
                            <a href="" class="wish_bt"><i class="icon_heart"></i></a>
                            <img src="img/event/job career business event.jpg" data-src="img/event/job career business event.jpg"
                                class="img-fluid lazy" alt="">
                            <a href="all-event.html" class="strip_info">
                                <div class="item_title">
                                    <h3>Tom Manzone</h3>
                                    <small>Lawyer</small>
                                </div>
                            </a>
                        </figure>
                        <ul>
                            <li><a href="#0" class="tooltip-1" data-bs-toggle="tooltip" data-bs-placement="bottom"
                                    title="Available Chat"><i class="icon-chat"></i></a></li>
                            <li><a href="#0" class="tooltip-1" data-bs-toggle="tooltip" data-bs-placement="bottom"
                                    title="Available Video Call"><i class="icon-videocam"></i></a></li>
                            <li>
                                <div class="score"><span>Superb<em>350 Reviews</em></span><strong>8.9</strong></div>
                            </li>
                        </ul>
                    </div>
                </div>
                <!-- /strip grid -->
                <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6">
                    <div class="strip">
                        <figure>
                            <a href="" class="wish_bt"><i class="icon_heart"></i></a>
                            <img src="img/event/psychologist event.jpg" data-src="img/event/psychologist event.jpg"
                                class="img-fluid lazy" alt="">
                            <a href="all-event.html" class="strip_info">
                                <div class="item_title">
                                    <h3>Carl Cornfield</h3>
                                    <small>Accountant</small>
                                </div>
                            </a>
                        </figure>
                        <ul>
                            <li><a href="#0" class="tooltip-1" data-bs-toggle="tooltip" data-bs-placement="bottom"
                                    title="Available Appointment"><i class="icon-users"></i></a></li>
                            <li><a href="#0" class="tooltip-1" data-bs-toggle="tooltip" data-bs-placement="bottom"
                                    title="Available Chat"><i class="icon-chat"></i></a></li>
                            <li>
                                <div class="score"><span>Superb<em>350 Reviews</em></span><strong>8.9</strong></div>
                            </li>
                        </ul>
                    </div>
                </div>
                <!-- /strip grid -->
            </div>
            <!-- /row -->

            <p class="text-center"><a href="event-list.html" class="btn_1 medium">Start Searching</a></p>
        </div>
    </section>
    <!-- /bg_gray -->
    
    <!-- /container -->

    

    <!-- related serivce carousal  -->
    <section class="bg-light">
        <div class="container service-container py-5 ">
            <div class="row heading">
                <div class="col ">
                    <div class="main_title center ">
                        <span><em></em></span>
                        <h2>Related Services</h2>
                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit.</p>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="owl-carousel services-carousal">
                    <div class="card" id="open">
                        <div class="card-body one">

                            
                        </div>
                        <div class="info mt-3 p-2">
                            <div class="content-discover p-3">
                                <div class="l">
                                    <p class="text-dark">job , career and business</p>
                                </div>
                                <div class="r">
                                    <a href="job-career.html" class="btn_1">Read more</a>
                                </div>
                            </div>
                            
                        </div>
                    </div>

                    <div class="card" id="open-2">
                        <div class="card-body two">

                            
                        </div>
                        <div class="info mt-3 p-2 ">
                            
                            <div class="content-discover p-3">
                                <div class="l">
                                    <p class="text-dark">interior designer</p>
                                </div>
                                <div class="r">
                                    <a href="interiorDesign.html" class="btn_1">Read more</a>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="card" id="open-3">
                        <div class="card-body three">

                            
                        </div>
                        <div class="info mt-3 p-2 ">
                        
                            <div class="content-discover p-3">
                                <div class="l">
                                    <p class="text-dark">astrologer / priest</p>
                                </div>
                                <div class="r">
                                    <a href="astro-page.html" class="btn_1">Read more</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card" id="open-4">
                        <div class="card-body four">

                            
                        </div>
                        <div class="info mt-3 p-2 ">
                        
                            <div class="content-discover p-3">
                                <div class="l">
                                    <p class="text-dark">fitness yoga zumba weight training</p>
                                </div>
                                <div class="r">
                                    <a href="fitness-yoga.html" class="btn_1">Read more</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card" id="open-5">
                        <div class="card-body five">

                            
                        </div>
                        <div class="info mt-3 p-2 ">
                        
                            <div class="content-discover p-3">
                                <div class="l">
                                    <p class="text-dark">style image consultant</p>
                                </div>
                                <div class="r">
                                    <a href="stylist.html" class="btn_1">Read more</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card" id="open-6">
                        <div class="card-body six">

                        
                        </div>
                        <div class="info mt-3 p-2 ">
                            
                            <div class="content-discover p-3">
                                <div class="l">
                                    <p class="text-dark">influencer for business</p>
                                </div>
                                <div class="r">
                                    <a href="influencer.html" class="btn_1">Read more</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card" id="open-7">
                        <div class="card-body seven">

                            
                        </div>
                        <div class="info mt-3 p-2 ">
                            
                            <div class="content-discover p-3">
                                <div class="l">
                                    <p class="text-dark">psychologist</p>
                                </div>
                                <div class="r">
                                    <a href="psychology.html" class="btn_1">Read more</a>
                                </div>
                            </div>
                        </div>
                    </div>
                      

                    <div class="card">
                        <div class="card-body eight" >

                            
                        </div>
                        <div class="info mt-3 p-2 ">
                            
                            <div class="content-discover p-3">
                                <div class="l">
                                    <p class="text-dark">Dieticians</p>
                                </div>
                                <div class="r">
                                    <a href="Dieticians.html" class="btn_1">Read more</a>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </section>
    <!-- /bg_gray -->

    <!-- testimonials slider  -->
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
    
    <section class="cta-bg-color-new">
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