@extends('layouts.layout')
@section('styles')
   {{-- <link rel="stylesheet" href="{{ asset('admin/css/styles.css') }}" /> --}}
@endsection
@section('content')

<main class="bg_color">
    <div class="container margin_detail">
        <div class="row">
            <div class="col-xl-8 col-lg-7">
                <div class="box_general">
                     <div>
                        <img src="img/detail_2.jpg" alt="" class="img-fluid" width="990" height="450">
                    </div>
                    <div class="main_info_wrapper">
                        <div class="main_info clearfix">
                            <div class="user_desc">
                                <h3>Dr. Maria Cornfield</h3>
                                <p>27 Old Gloucester St, 4530 - <a href="https://www.google.com/maps/dir//Assistance+–+Hôpitaux+De+Paris,+3+Avenue+Victoria,+75004+Paris,+Francia/@48.8606548,2.3348734,14z/data=!4m15!1m6!3m5!1s0x47e66e1de36f4147:0xb6615b4092e0351f!2sAssistance+Publique+-+Hôpitaux+de+Paris+(AP-HP)+-+Siège!8m2!3d48.8568376!4d2.3504305!4m7!1m0!1m5!1m1!1s0x47e67031f8c20147:0xa6a9af76b1e2d899!2m2!1d2.3504327!2d48.8568361" target="blank">Get directions</a></p>
                                <ul class="tags no_margin">
                                    <li><a href="#0">Pediatrician</a></li>
                                    <li><a href="#0">Piscologist</a></li>
                                    <li><a href="#0">Researcher</a></li>
                                </ul>
                            </div>
                            <div class="score_in">
                                <div class="rating">
                                    <div class="score"><span>Superb<em>350 Reviews</em></span><strong>8.9</strong></div>
                                </div>
                                <a href="#0" class="wish_bt" aria-label="Add to wish list"><i class="icon_heart_alt"></i></a>
                            </div>
                        </div>
                        <!-- /main_info_wrapper -->
                        <hr>
                        <h4>About me</h4>
                        <p>Tincidunt intellegam mel ne, an eam menandri invenire euripidis. Ea quo utroque forensibus eloquentiam. Nam ad option iisque verterem, sed nemore menandri ex. Pri ei solet eripuit, et nam decore tacimates persequeris. Te nec duis corpora persequeris, vix ubique graece intellegat ea. In pro <strong>euismod molestie</strong>, eam sonet doming offendit ut.</p>
                        <div class="content_more">
                            <p>Lorem ipsum dolor sit amet, an sea eius elitr persius. Voluptaria inciderint qui in. No tollit aliquid reformidans mei, nec illum sensibus id, at has esse admodum adipisci. Et has maiestatis scriptorem. Et aeque iudico oblique ius.</p>
                        </div>
                        <!-- /content_more -->
                        <a href="#0" class="show_hide" data-content="toggle-text">Read More</a>
                    </div>
                    <!-- /main_info -->
                </div>
                <!-- /box_general -->
                <div class="box_general">
                    <div class="tabs_detail">
                        <ul class="nav nav-tabs" role="tablist">
                            <li class="nav-item">
                                <a id="tab-A" href="#pane-A" class="nav-link active" data-bs-toggle="tab" role="tab">Other info</a>
                            </li>
                            <li class="nav-item">
                                <a id="tab-B" href="#pane-B" class="nav-link" data-bs-toggle="tab" role="tab">Reviews</a>
                            </li>
                            <li class="nav-item">
                                <a id="tab-C" href="#pane-C" class="nav-link" data-bs-toggle="tab" role="tab">Gallery</a>
                            </li>
                        </ul>
                        <div class="tab-content" role="tablist">
                            <div id="pane-A" class="card tab-pane fade show active" role="tabpanel" aria-labelledby="tab-A">
                                <div class="card-header" role="tab" id="heading-A">
                                    <h5>
                                        <a class="collapsed" data-bs-toggle="collapse" href="#collapse-A" aria-expanded="true" aria-controls="collapse-A">
                                            Other info
                                        </a>
                                    </h5>
                                </div>
                                <div id="collapse-A" class="collapse" role="tabpanel" aria-labelledby="heading-A">
                                    <div class="card-body info_content">
                                        <div class="indent_title_in">
                                            <i class="icon_document_alt"></i>
                                            <h3>Services</h3>
                                            <p>Mussum ipsum cacilds, vidis litro abertis.</p>
                                        </div>
                                        <div class="wrapper_indent">
                                            <p>Sed pretium, ligula sollicitudin laoreet viverra, tortor libero sodales leo, eget blandit nunc tortor eu nibh. Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Phasellus hendrerit. Pellentesque aliquet nibh nec urna. In nisi neque, aliquet vel, dapibus id, mattis vel, nisi. Nullam mollis. Phasellus hendrerit.</p>
                                            <h6>Most requested services</h6>
                                            <div class="services_list clearfix">
                                                <ul>
                                                    <li>Cardiological examination with ECG <strong><small>from</small> $80</strong></li>
                                                    <li>Echocardiogram <strong><small>from</small> 110$</strong></li>
                                                    <li>Electrocardiogram or ECG <strong><small>from</small> $95</strong></li>
                                                </ul>
                                            </div>
                                        </div>
                                        <!--  End wrapper indent -->
                                        <hr>
                                        <div class="indent_title_in">
                                            <i class="icon_document_alt"></i>
                                            <h3>Professional statement</h3>
                                            <p>Mussum ipsum cacilds, vidis litro abertis.</p>
                                        </div>
                                        <div class="wrapper_indent">
                                            <p>Sed pretium, ligula sollicitudin laoreet viverra, tortor libero sodales leo, eget blandit nunc tortor eu nibh. Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Phasellus hendrerit. Pellentesque aliquet nibh nec urna. In nisi neque, aliquet vel, dapibus id, mattis vel, nisi. Nullam mollis. Phasellus hendrerit. Pellentesque aliquet nibh nec urna. In nisi neque, aliquet vel, dapi.</p>
                                            <h6>Specializations</h6>
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <ul class="bullets">
                                                        <li>Abdominal Radiology</li>
                                                        <li>Addiction Psychiatry</li>
                                                        <li>Adolescent Medicine</li>
                                                        <li>Cardiothoracic Radiology </li>
                                                    </ul>
                                                </div>
                                                <div class="col-lg-6">
                                                    <ul class="bullets">
                                                        <li>Abdominal Radiology</li>
                                                        <li>Addiction Psychiatry</li>
                                                        <li>Adolescent Medicine</li>
                                                        <li>Cardiothoracic Radiology </li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <!-- /row-->
                                        </div>
                                        <!--  End wrapper indent -->
                                        <hr>
                                        <div class="indent_title_in">
                                            <i class="icon_document_alt"></i>
                                            <h3>Education</h3>
                                            <p>Mussum ipsum cacilds, vidis litro abertis.</p>
                                        </div>
                                        <div class="wrapper_indent add_bottom_25">
                                            <p>Phasellus hendrerit. Pellentesque aliquet nibh nec urna. In nisi neque, aliquet vel, dapibus id, mattis vel, nisi. Nullam mollis. Phasellus hendrerit. Pellentesque aliquet nibh nec urna. In nisi neque, aliquet vel, dapi.</p>
                                            <h6>Curriculum</h6>
                                            <ul class="bullets">
                                                <li><strong>New York Medical College</strong> - Doctor of Medicine</li>
                                                <li><strong>Montefiore Medical Center</strong> - Residency in Internal Medicine</li>
                                                <li><strong>New York Medical College</strong> - Master Internal Medicine</li>
                                            </ul>
                                        </div>
                                        <!--  End wrapper indent -->
                                    </div>
                                </div>
                            </div>
                            <!-- /tab -->
                            <div id="pane-B" class="card tab-pane fade" role="tabpanel" aria-labelledby="tab-B">
                                <div class="card-header" role="tab" id="heading-B">
                                    <h5>
                                        <a class="collapsed" data-bs-toggle="collapse" href="#collapse-B" aria-expanded="false" aria-controls="collapse-B">
                                            Reviews
                                        </a>
                                    </h5>
                                </div>
                                <div id="collapse-B" class="collapse" role="tabpanel" aria-labelledby="heading-B">
                                    <div class="card-body reviews">
                                        <div class="row add_bottom_45 d-flex align-items-center">
                                            <div class="col-md-3">
                                                <div id="review_summary">
                                                    <strong>8.5</strong>
                                                    <em>Superb</em>
                                                    <small>Based on 4 reviews</small>
                                                </div>
                                            </div>
                                            <div class="col-md-9 reviews_sum_details">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <h6>Response time</h6>
                                                        <div class="row">
                                                            <div class="col-xl-10 col-lg-9 col-9">
                                                                <div class="progress">
                                                                    <div class="progress-bar" role="progressbar" style="width: 90%" aria-valuenow="90" aria-valuemin="0" aria-valuemax="100"></div>
                                                                </div>
                                                            </div>
                                                            <div class="col-xl-2 col-lg-3 col-3"><strong>9.0</strong></div>
                                                        </div>
                                                        <!-- /row -->
                                                        <h6>Service</h6>
                                                        <div class="row">
                                                            <div class="col-xl-10 col-lg-9 col-9">
                                                                <div class="progress">
                                                                    <div class="progress-bar" role="progressbar" style="width: 95%" aria-valuenow="95" aria-valuemin="0" aria-valuemax="100"></div>
                                                                </div>
                                                            </div>
                                                            <div class="col-xl-2 col-lg-3 col-3"><strong>9.5</strong></div>
                                                        </div>
                                                        <!-- /row -->
                                                    </div>
                                                    <div class="col-md-6">
                                                        <h6>Communication</h6>
                                                        <div class="row">
                                                            <div class="col-xl-10 col-lg-9 col-9">
                                                                <div class="progress">
                                                                    <div class="progress-bar" role="progressbar" style="width: 60%" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100"></div>
                                                                </div>
                                                            </div>
                                                            <div class="col-xl-2 col-lg-3 col-3"><strong>6.0</strong></div>
                                                        </div>
                                                        <!-- /row -->
                                                        <h6>Price</h6>
                                                        <div class="row">
                                                            <div class="col-xl-10 col-lg-9 col-9">
                                                                <div class="progress">
                                                                    <div class="progress-bar" role="progressbar" style="width: 60%" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100"></div>
                                                                </div>
                                                            </div>
                                                            <div class="col-xl-2 col-lg-3 col-3"><strong>6.0</strong></div>
                                                        </div>
                                                        <!-- /row -->
                                                    </div>
                                                </div>
                                                <!-- /row -->
                                            </div>
                                        </div>
                                        <div id="reviews">
                                            <div class="review_card">
                                                <div class="row">
                                                    <div class="col-md-2 user_info">
                                                        <figure><img src="img/avatar4.jpg" alt=""></figure>
                                                        <h5>Lukas</h5>
                                                    </div>
                                                    <div class="col-md-10 review_content">
                                                        <div class="clearfix add_bottom_15">
                                                            <span class="rating">8.5<small>/10</small> <strong>Rating average</strong></span>
                                                            <em>Published 54 minutes ago</em>
                                                        </div>
                                                        <h4>"Great!!"</h4>
                                                        <p>Eos tollit ancillae ea, lorem consulatu qui ne, eu eros eirmod scaevola sea. Et nec tantas accusamus salutatus, sit commodo veritus te, erat legere fabulas has ut. Rebum laudem cum ea, ius essent fuisset ut. Viderer petentium cu his. Tollit molestie suscipiantur his et.</p>
                                                        <ul>
                                                            <li><a href="#0"><i class="icon_like"></i><span>Useful</span></a></li>
                                                            <li><a href="#0"><i class="icon_dislike"></i><span>Not useful</span></a></li>
                                                            <li><a href="#0"><i class="arrow_back"></i> <span>Reply</span></a></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <!-- /row -->
                                            </div>
                                            <!-- /review_card -->
                                            <div class="review_card">
                                                <div class="row">
                                                    <div class="col-md-2 user_info">
                                                        <figure><img src="img/avatar6.jpg" alt=""></figure>
                                                        <h5>Lukas</h5>
                                                    </div>
                                                    <div class="col-md-10 review_content">
                                                        <div class="clearfix add_bottom_15">
                                                            <span class="rating">8.5<small>/10</small> <strong>Rating average</strong></span>
                                                            <em>Published 10 Oct. 2019</em>
                                                        </div>
                                                        <h4>"Awesome Experience"</h4>
                                                        <p>Eos tollit ancillae ea, lorem consulatu qui ne, eu eros eirmod scaevola sea. Et nec tantas accusamus salutatus, sit commodo veritus te, erat legere fabulas has ut. Rebum laudem cum ea, ius essent fuisset ut. Viderer petentium cu his. Tollit molestie suscipiantur his et.</p>
                                                        <ul>
                                                            <li><a href="#0"><i class="icon_like"></i><span>Useful</span></a></li>
                                                            <li><a href="#0"><i class="icon_dislike"></i><span>Not useful</span></a></li>
                                                            <li><a href="#0"><i class="arrow_back"></i> <span>Reply</span></a></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <!-- /row -->
                                            </div>
                                            <!-- /review_card -->
                                            <div class="review_card">
                                                <div class="row">
                                                    <div class="col-md-2 user_info">
                                                        <figure><img src="img/avatar1.jpg" alt=""></figure>
                                                        <h5>Marika</h5>
                                                    </div>
                                                    <div class="col-md-10 review_content">
                                                        <div class="clearfix add_bottom_15">
                                                            <span class="rating">9.0<small>/10</small> <strong>Rating average</strong></span>
                                                            <em>Published 11 Oct. 2019</em>
                                                        </div>
                                                        <h4>"Really great!!"</h4>
                                                        <p>Eos tollit ancillae ea, lorem consulatu qui ne, eu eros eirmod scaevola sea. Et nec tantas accusamus salutatus, sit commodo veritus te, erat legere fabulas has ut. Rebum laudem cum ea, ius essent fuisset ut. Viderer petentium cu his. Tollit molestie suscipiantur his et.</p>
                                                        <ul>
                                                            <li><a href="#0"><i class="icon_like"></i><span>Useful</span></a></li>
                                                            <li><a href="#0"><i class="icon_dislike"></i><span>Not useful</span></a></li>
                                                            <li><a href="#0"><i class="arrow_back"></i> <span>Reply</span></a></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <!-- /row -->
                                                <div class="row reply">
                                                    <div class="col-md-2 user_info">
                                                        <figure><img src="img/avatar.jpg" alt=""></figure>
                                                    </div>
                                                    <div class="col-md-10">
                                                        <div class="review_content">
                                                            <strong>Reply from Prozim</strong>
                                                            <em>Published 3 minutes ago</em>
                                                            <p><br>Hi Monika,<br><br>Eos tollit ancillae ea, lorem consulatu qui ne, eu eros eirmod scaevola sea. Et nec tantas accusamus salutatus, sit commodo veritus te, erat legere fabulas has ut. Rebum laudem cum ea, ius essent fuisset ut. Viderer petentium cu his. Tollit molestie suscipiantur his et.<br><br>Thanks</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- /reply -->
                                            </div>
                                            <!-- /review_card -->
                                        </div>
                                        <!-- /reviews -->
                                        <p class="text-end"><a href="leave-review.html" class="btn_1">Leave a review</a></p>
                                    </div>
                                </div>
                            </div>
                            <!-- /tab -->
                            
                            <!-- New Gallery Tab -->
                            <div id="pane-C" class="card tab-pane fade" role="tabpanel" aria-labelledby="tab-C">
                                <div class="card-header" role="tab" id="heading-C">
                                    <h5>
                                        <a class="collapsed" data-bs-toggle="collapse" href="#collapse-C" aria-expanded="false" aria-controls="collapse-C">
                                            Gallery
                                        </a>
                                    </h5>
                                </div>
                                <div id="collapse-C" class="collapse" role="tabpanel" aria-labelledby="heading-C">
                                    <div class="card-body">
                                        <div class="gallery-container">
                                            <div class="row">
                                                <div class="col-md-4 col-sm-6 mb-4">
                                                    <a href="img/gallery/1.jpg" class="gallery-item" data-fancybox="gallery">
                                                        <img src="img/gallery/1.jpg" class="img-fluid rounded" alt="Clinic Photo 1">
                                                    </a>
                                                </div>
                                                <div class="col-md-4 col-sm-6 mb-4">
                                                    <a href="img/gallery/2.jpg" class="gallery-item" data-fancybox="gallery">
                                                        <img src="img/gallery/2.jpg" class="img-fluid rounded" alt="Clinic Photo 2">
                                                    </a>
                                                </div>
                                                <div class="col-md-4 col-sm-6 mb-4">
                                                    <a href="img/gallery/3.jpg" class="gallery-item" data-fancybox="gallery">
                                                        <img src="img/gallery/3.jpg" class="img-fluid rounded" alt="Clinic Photo 3">
                                                    </a>
                                                </div>
                                                <div class="col-md-4 col-sm-6 mb-4">
                                                    <a href="img/gallery/4.jpg" class="gallery-item" data-fancybox="gallery">
                                                        <img src="img/gallery/4.jpg" class="img-fluid rounded" alt="Clinic Photo 4">
                                                    </a>
                                                </div>
                                                <div class="col-md-4 col-sm-6 mb-4">
                                                    <a href="img/gallery/5.jpg" class="gallery-item" data-fancybox="gallery">
                                                        <img src="img/gallery/5.jpg" class="img-fluid rounded" alt="Clinic Photo 5">
                                                    </a>
                                                </div>
                                                <div class="col-md-4 col-sm-6 mb-4">
                                                    <a href="img/gallery/6.jpg" class="gallery-item" data-fancybox="gallery">
                                                        <img src="img/gallery/6.jpg" class="img-fluid rounded" alt="Clinic Photo 6">
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="text-center mt-3">
                                                <p>Our state-of-the-art facilities and comfortable environment</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /Gallery tab -->
                            
                        </div>
                        <!-- /tab-content -->
                    </div>
                    <!-- /tabs_detail -->
                </div>
            </div>
            <!-- /col -->
            <div class="col-xl-4 col-lg-5" id="sidebar_fixed">
                <!-- Appointment Type Tabs -->
                <div class="box_booking appointment_types">
                    <div class="tabs">
                        <ul class="nav nav-tabs" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="one-time-tab" data-bs-toggle="tab" href="#one-time" role="tab">One-time</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="monthly-tab" data-bs-toggle="tab" href="#monthly" role="tab">Monthly</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="quarterly-tab" data-bs-toggle="tab" href="#quarterly" role="tab">Quarterly</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="freehand-tab" data-bs-toggle="tab" href="#freehand" role="tab">Free-hand</a>
                            </li>
                        </ul>
                        
                        <div class="tab-content">
                            <!-- One-time Tab -->
                            <div class="tab-pane fade show active" id="one-time" role="tabpanel" aria-labelledby="one-time-tab">
                                <div class="appointment-details">
                                    <h4>One-time Consultation</h4>
                                    <p>Single consultation session with the doctor for immediate concerns.</p>
                                    <ul class="appointment-features">
                                        <li><i class="icon_check_alt2"></i> 30-45 minute session</li>
                                        <li><i class="icon_check_alt2"></i> Personalized treatment plan</li>
                                        <li><i class="icon_check_alt2"></i> Follow-up recommendations</li>
                                    </ul>
                                    <div class="price">
                                        <strong>Rs. 2,500</strong>
                                        <small>per session</small>
                                    </div>
                                    <button class="btn_1 full-width select-plan" data-plan="one-time">Select One-time</button>
                                </div>
                            </div>
                            
                            <!-- Monthly Tab -->
                            <div class="tab-pane fade" id="monthly" role="tabpanel" aria-labelledby="monthly-tab">
                                <div class="appointment-details">
                                    <h4>Monthly Package</h4>
                                    <p>Regular monthly checkups for ongoing treatment and monitoring.</p>
                                    <ul class="appointment-features">
                                        <li><i class="icon_check_alt2"></i> 4 sessions per month</li>
                                        <li><i class="icon_check_alt2"></i> 24/7 priority support</li>
                                        <li><i class="icon_check_alt2"></i> Medication management</li>
                                        <li><i class="icon_check_alt2"></i> Progress tracking</li>
                                    </ul>
                                    <div class="price">
                                        <strong>Rs. 8,000</strong>
                                        <small>per month (20% savings)</small>
                                    </div>
                                    <button class="btn_1 full-width select-plan" data-plan="monthly">Select Monthly</button>
                                </div>
                            </div>
                            
                            <!-- Quarterly Tab -->
                            <div class="tab-pane fade" id="quarterly" role="tabpanel" aria-labelledby="quarterly-tab">
                                <div class="appointment-details">
                                    <h4>Quarterly Package</h4>
                                    <p>Comprehensive 3-month treatment plan for chronic conditions.</p>
                                    <ul class="appointment-features">
                                        <li><i class="icon_check_alt2"></i> 12 sessions over 3 months</li>
                                        <li><i class="icon_check_alt2"></i> Complete health assessment</li>
                                        <li><i class="icon_check_alt2"></i> Diet & lifestyle planning</li>
                                        <li><i class="icon_check_alt2"></i> Emergency consultations</li>
                                        <li><i class="icon_check_alt2"></i> Lab test discounts</li>
                                    </ul>
                                    <div class="price">
                                        <strong>Rs. 21,000</strong>
                                        <small>per quarter (30% savings)</small>
                                    </div>
                                    <button class="btn_1 full-width select-plan" data-plan="quarterly">Select Quarterly</button>
                                </div>
                            </div>
                            
                            <!-- Free-hand Tab -->
                            <div class="tab-pane fade" id="freehand" role="tabpanel" aria-labelledby="freehand-tab">
                                <div class="appointment-details">
                                    <h4>Free-hand Consultation</h4>
                                    <p>Customizable consultation package tailored to your needs.</p>
                                    <ul class="appointment-features">
                                        <li><i class="icon_check_alt2"></i> Choose number of sessions</li>
                                        <li><i class="icon_check_alt2"></i> Flexible scheduling</li>
                                        <li><i class="icon_check_alt2"></i> Mix of in-person and virtual</li>
                                        <li><i class="icon_check_alt2"></i> Personalized package</li>
                                    </ul>
                                    <div class="price-range">
                                        <strong>Starting from Rs. 2,000</strong>
                                        <small>per session (bulk discounts available)</small>
                                    </div>
                                    <button class="btn_1 full-width select-plan" data-plan="freehand">Select Free-hand</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /Appointment Type Tabs -->
            
                <div class="box_booking mobile_fixed">
                    <div class="head">
                        <h3>Booking</h3>
                        <a href="#0" class="close_panel_mobile"><i class="icon_close"></i></a>
                    </div>
                    <!-- /head -->
                    <div class="main">
                        <div id="selected-plan-display" style="display:none; margin-bottom:15px; padding:10px; background:#f8f9fa; border-radius:5px;">
                            <strong>Selected Plan: </strong><span id="selected-plan-text">None</span>
                            <input type="hidden" id="selected_plan" name="selected_plan" value="">
                        </div>
                        
                        <div class="radio_select type">
                            <ul>
                                <li>
                                    <input type="radio" id="appointment" name="type" value="12.00pm">
                                    <label for="appointment"><i class="icon-users"></i> Appointment</label>
                                </li>
                            </ul>
                        </div>
                        <!-- /type -->
                        <input type="text" id="datepicker_field">
                        <div id="DatePicker"></div>
                        <div class="dropdown time">
                            <a href="#" data-bs-toggle="dropdown">Hour <span id="selected_time"></span></a>
                            <div class="dropdown-menu">
                                <div class="dropdown-menu-content">
                                    <div class="radio_select">
                                        <ul>
                                            <li>
                                                <input type="radio" id="time_1" name="time" value="12.00pm to 12.30pm">
                                                <label for="time_1">12.00<small>pm to</small>12.30<small>pm</small></label>
                                            </li>
                                            <li>
                                                <input type="radio" id="time_2" name="time" value="1.00pm to 1.30pm">
                                                <label for="time_2">1.00<small>pm to</small>1.30<small>pm</small></label>
                                            </li>
                                            <li>
                                                <input type="radio" id="time_3" name="time" value="1.30pm to 2.00pm">
                                                <label for="time_3">1.30<small>pm to</small>2.00<small>pm</small></label>
                                            </li>
                                            <li>
                                                <input type="radio" id="time_4" name="time" value="2.00pm to 2.30pm">
                                                <label for="time_4">2.00<small>pm to</small>2.30<small>pm</small></label>
                                            </li>
                                            <li>
                                                <input type="radio" id="time_5" name="time" value="2.30pm to 3.00pm">
                                                <label for="time_5">2.30<small>pm to</small>3.00<small>pm</small></label>
                                            </li>
                                            <li>
                                                <input type="radio" id="time_6" name="time" value="3.00pm to 3.30pm">
                                                <label for="time_6">3.00<small>pm to</small>3.30<small>pm</small></label>
                                            </li>
                                        </ul>
                                    </div>
                                    <!-- /time_select -->
                                </div>
                            </div>
                        </div>
                        <!-- /dropdown -->
                        <a href="booking.html" class="btn_1 full-width booking">Book Now</a>
                    </div>
                </div>
                <!-- /box_booking -->
                <div class="btn_reserve_fixed"><a href="#0" class="btn_1 full-width booking">Book Now</a></div>
                <ul class="share-buttons">
                    <li><a class="fb-share" href="#0"><i class="social_facebook"></i> Share</a></li>
                    <li><a class="twitter-share" href="#0"><i class="social_twitter"></i> Share</a></li>
                    <li><a class="gplus-share" href="#0"><i class="social_googleplus"></i> Share</a></li>
                </ul>
            </div>
            
            <script>
            // JavaScript to handle plan selection
            document.addEventListener('DOMContentLoaded', function() {
                const planButtons = document.querySelectorAll('.select-plan');
                const selectedPlanDisplay = document.getElementById('selected-plan-display');
                const selectedPlanText = document.getElementById('selected-plan-text');
                const selectedPlanInput = document.getElementById('selected_plan');
                
                planButtons.forEach(button => {
                    button.addEventListener('click', function() {
                        const plan = this.getAttribute('data-plan');
                        let planName = '';
                        
                        switch(plan) {
                            case 'one-time':
                                planName = 'One-time Consultation (Rs. 2,500)';
                                break;
                            case 'monthly':
                                planName = 'Monthly Package (Rs. 8,000)';
                                break;
                            case 'quarterly':
                                planName = 'Quarterly Package (Rs. 21,000)';
                                break;
                            case 'freehand':
                                planName = 'Free-hand Consultation (Starting from Rs. 2,000)';
                                break;
                        }
                        
                        selectedPlanText.textContent = planName;
                        selectedPlanInput.value = plan;
                        selectedPlanDisplay.style.display = 'block';
                        
                        // Scroll to booking section
                        document.querySelector('.box_booking.mobile_fixed').scrollIntoView({
                            behavior: 'smooth'
                        });
                    });
                });
            });
            </script>
        </div>
        <!-- /row -->
    </div>
    <!-- /container -->
</main>

@endsection