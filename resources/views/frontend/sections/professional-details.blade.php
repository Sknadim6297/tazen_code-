@extends('layouts.layout')
@section('styles')
   <link rel="preload" href="{{ asset('frontend/assets/css/detail-page.css') }}" as="style">
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/detail-page.css') }}">
    <style>
        	/* Appointment Types Container */
		.appointment_types {
			background: #fff;
			border-radius: 10px;
			box-shadow: 0 2px 15px rgba(0, 0, 0, 0.08);
			margin-bottom: 25px;
			overflow: hidden;
		}
		
		/* Tab Navigation */
		.appointment_types .nav-tabs {
			border-bottom: 2px solid #f0f0f0;
			padding: 0 15px;
			padding-bottom: 10px;
		}
		
		.appointment_types .nav-link {
			border: none;
			color: #6c757d;
			font-weight: 600;
			padding: 12px 15px;
			position: relative;
			transition: all 0.3s ease;
			font-size: 14px;
		}
		
		.appointment_types .nav-link:hover {
			color: #00a6eb;
			background: transparent;
		}
		
		.appointment_types .nav-link.active {
			color: #00a6eb;
			background: transparent;
		}
		
		.appointment_types .nav-link.active:after {
			content: '';
			position: absolute;
			bottom: -2px;
			left: 0;
			width: 100%;
			height: 2px;
			background: #00a6eb;
		}
		
		/* Tab Content */
		.appointment_types .tab-content {
			padding: 20px;
		}
		
		.appointment-details {
			text-align: center;
		}
		
		.appointment-details h4 {
			color: #2a2a2a;
			font-weight: 700;
			margin-bottom: 15px;
			font-size: 18px;
		}
		
		.appointment-details p {
			color: #6c757d;
			margin-bottom: 20px;
			font-size: 14px;
		}
		
		.appointment-features {
			text-align: left;
			margin: 0 auto 20px;
			padding: 0;
			max-width: 280px;
		}
		
		.appointment-features li {
			list-style: none;
			padding: 8px 0;
			color: #555;
			font-size: 14px;
			position: relative;
			padding-left: 25px;
		}
		
		.appointment-features i {
			color: #00a6eb;
			position: absolute;
			left: 0;
			top: 10px;
		}
		
		.price {
			background: #f8f9fa;
			padding: 15px;
			border-radius: 8px;
			margin: 20px 0;
		}
		
		.price strong {
			color: #00a6eb;
			font-size: 22px;
			font-weight: 700;
			display: block;
		}
		
		.price small, .price-range small {
			color: #6c757d;
			font-size: 13px;
		}
		
		.select-plan {
			background: #00a6eb;
			border: none;
			transition: all 0.3s ease;
			padding: 12px 15px;
			font-weight: 600;
		}
		
		.select-plan:hover {
			background: #0088c6;
			transform: translateY(-2px);
			box-shadow: 0 5px 15px rgba(0, 166, 235, 0.3);
		}
		
		/* Selected Plan Display */
		#selected-plan-display {
			background: #f0f9ff;
			border-left: 4px solid #00a6eb;
			color: #2a2a2a;
			animation: fadeIn 0.5s ease;
		}
		
		@keyframes fadeIn {
			from { opacity: 0; transform: translateY(10px); }
			to { opacity: 1; transform: translateY(0); }
		}
		
		/* Responsive Adjustments */
		@media (max-width: 768px) {
			.appointment_types .nav-link {
				padding: 10px 8px;
				font-size: 13px;
			}
			
			.appointment-details h4 {
				font-size: 16px;
			}
			
			.price strong {
				font-size: 20px;
			}
		}
    </style>
@endsection
@section('content')
    <div class="container margin_detail" style="margin-top: 100px;">
        <div class="row">
            <div class="col-xl-8 col-lg-7">
                <div class="box_general">
                     <div>
                        <img src="{{ asset($profile->photo) }}" alt="" class="img-fluid" width="990" height="300">
                    </div>
                    <div class="main_info_wrapper">
                        <div class="main_info clearfix">
                            <div class="user_desc">
                                <h3 id="professional_name">{{ $profile->first_name }} {{ $profile->last_name }}</h3>

                                <p id="professional_address">{{ $profile->address }} - <a href="https://www.google.com/maps/dir//Assistance+–+Hôpitaux+De+Paris,+3+Avenue+Victoria,+75004+Paris,+Francia/@48.8606548,2.3348734,14z/data=!4m15!1m6!3m5!1s0x47e66e1de36f4147:0xb6615b4092e0351f!2sAssistance+Publique+-+Hôpitaux+de+Paris+(AP-HP)+-+Siège!8m2!3d48.8568376!4d2.3504305!4m7!1m0!1m5!1m1!1s0x47e67031f8c20147:0xa6a9af76b1e2d899!2m2!1d2.3504327!2d48.8568361" target="blank">Get dir ections</a></p>
                                <ul class="tags no_margin">
                                    <li><a href="#0">{{ $profile->specialization }}</a></li>
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

                        @php
                            $bioText = strip_tags($profile->bio); 
                            $limit = 250;
                        @endphp
                        
                        @if(strlen($bioText) > $limit)
                            <p id="bio-short">{{ Str::limit($bioText, $limit, '...') }}</p>
                            <div id="bio-full" style="display: none;">
                                {!! $profile->bio !!}
                            </div>
                            <a href="javascript:void(0)" class="show_hide" id="toggle-bio">Read More</a>
                        @else
                            <p>{!! $profile->bio !!}</p>
                        @endif
                        
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
                                @php
                                $galleryImages = json_decode($profile->gallery, true);
                                @endphp
                        @if(!empty($galleryImages))
                            <div id="collapse-C" class="collapse" role="tabpanel" aria-labelledby="heading-C">
                            <div class="card-body">
                                  <div class="gallery-container">
                               <div class="row">
                            @foreach($galleryImages as $image)
                            <div class="col-md-4 col-sm-6 mb-4">
                            <a href="{{ asset($image) }}" class="gallery-item" data-fancybox="gallery">
                                <img src="{{ asset($image) }}" class="img-fluid rounded" alt="Clinic Photo">
                            </a>
                        </div>
                    @endforeach

                </div>
                <div class="text-center mt-3">
                    <p>Our state-of-the-art facilities and comfortable environment</p>
                </div>
            </div>
        </div>
    </div>
@endif

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
                            @foreach($rates as $rate)
                                @php
                                    $safeId = strtolower(str_replace(' ', '_', $rate->session_type));
                                @endphp
                                <li class="nav-item">
                                    <a class="nav-link @if($loop->first) active @endif" id="{{ $safeId }}-tab" data-bs-toggle="tab" href="#{{ $safeId }}" role="tab">{{ ucfirst($rate->session_type) }}</a>
                                </li>
                            @endforeach
                        </ul>
                        
                        <div class="tab-content">
                            @foreach($rates as $rate)
                                @php
                                    $safeId = strtolower(str_replace(' ', '_', $rate->session_type));
                                @endphp
                                <div class="tab-pane fade @if($loop->first) show active @endif" id="{{ $safeId }}" role="tabpanel" aria-labelledby="{{ $safeId }}-tab">
                                    <div class="appointment-details">
                                        <h4>{{ ucfirst($rate->session_type) }} Consultation</h4>
                                        <p>{{ $rate->professional->bio }}</p>
                                        <ul class="appointment-features">
                                            <li><i class="icon_check_alt2"></i> {{ $rate->num_sessions }} sessions</li>
                                            <li><i class="icon_check_alt2"></i> {{ $rate->duration }} per session</li>
                                            <li><i class="icon_check_alt2"></i> Personalized treatment plan</li>
                                        </ul>
                                        <div class="price">
                                     @php
                                    $perText = match (strtolower($rate->session_type)) {
                                         'free hand' => 'per session',
                                            'weekly' => 'per week',
                                            'monthly' => 'per month',
                                                'quarterly' => 'per 3 months', 
                                                default => 'per session',
                                                          };
                                             @endphp

                                        
                                            <strong>Rs. {{ number_format($rate->final_rate, 2) }}</strong>
                                            <small>{{ $perText }}</small>
                                        </div>
                                        
                                        <button class="btn_1 full-width select-plan" data-plan="{{ $safeId }}">Select {{ ucfirst($rate->session_type) }}</button>
                                    </div>
                                </div>
                            @endforeach
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
                                    <div class="radio_select" style="display: flex; flex-wrap: wrap; gap: 10px;">
                                        @foreach($availabilities as $availability)
                                            @foreach($availability->slots as $slot)
                                                <div style="flex: 0 0 auto;">
                                                    <input type="radio"
                                                           id="time_{{ $slot->id }}"
                                                           data-id="{{ $slot->id }}"
                                                           name="time"
                                                           value="{{ \Carbon\Carbon::createFromFormat('H:i:s', $slot->start_time)->format('h:i') }} {{ $slot->start_period }} to {{ \Carbon\Carbon::createFromFormat('H:i:s', $slot->end_time)->format('h:i') }} {{ $slot->end_period }}"
                                                           class="time-slot"
                                                           data-start="{{ \Carbon\Carbon::createFromFormat('H:i:s', $slot->start_time)->format('h:i') }}"
                                                           data-start-period="{{ $slot->start_period }}"
                                                           data-end="{{ \Carbon\Carbon::createFromFormat('H:i:s', $slot->end_time)->format('h:i') }}"
                                                           data-end-period="{{ $slot->end_period }}">
                                                    <label for="time_{{ $slot->id }}">
                                                        {{ \Carbon\Carbon::createFromFormat('H:i:s', $slot->start_time)->format('h:i') }}
                                                        <small>{{ strtoupper($slot->start_period) }}</small> -
                                                        {{ \Carbon\Carbon::createFromFormat('H:i:s', $slot->end_time)->format('h:i') }}
                                                        <small>{{ strtoupper($slot->end_period) }}</small>
                                                    </label>
                                                </div>
                                            @endforeach
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- /dropdown -->
                        <a href="javascript:void(0);" class="btn_1 full-width booking">Book Now</a>
                    </div>
                </div>
                <ul class="share-buttons">
                    <li><a class="fb-share" href="#0"><i class="social_facebook"></i> Share</a></li>
                    <li><a class="twitter-share" href="#0"><i class="social_twitter"></i> Share</a></li>
                    <li><a class="gplus-share" href="#0"><i class="social_googleplus"></i> Share</a></li>
                </ul>
            </div>
            @endsection
            @section('script')
            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    // const professionalName=document.getElementById('professional_name');
                    // const professionalAddress=document.getElementById('professional_address');
                    const planButtons = document.querySelectorAll('.select-plan');
                    const selectedPlanDisplay = document.getElementById('selected-plan-display');
                    const selectedPlanText = document.getElementById('selected-plan-text');
                    const selectedPlanInput = document.getElementById('selected_plan');
            
                    // Plan selection
                    planButtons.forEach(button => {
                        button.addEventListener('click', function () {
                            const plan = this.getAttribute('data-plan');
                            selectedPlanInput.value = plan;
                            selectedPlanText.textContent = plan + ' Consultation';
                            selectedPlanDisplay.style.display = 'block';
                            selectedPlanDisplay.scrollIntoView({ behavior: 'smooth' });
                        });
                    });
            
                    document.querySelector('.booking').addEventListener('click', function (e) {
    e.preventDefault();

    const selectedTimeRadio = document.querySelector('input[name="time"]:checked');
    const timeSlot = selectedTimeRadio ? selectedTimeRadio.value : null;
    const planType = selectedPlanInput.value;
    const bookingDate = document.getElementById('datepicker_field').value;

    const professionalName = document.getElementById('professional_name').textContent.trim();
    const professionalAddress = document.getElementById('professional_address').textContent.trim();

    const professionalId = {{ json_encode($profile->professional->id ?? null) }};

    console.log( {
        professional_name: professionalName,
        professional_address: professionalAddress,
        professional_id: professionalId,
        plan_type: planType,
        booking_date: bookingDate,
        time_slot: timeSlot,
    });
    

    if (!planType) {
        alert('Please select a consultation plan.');
        return;
    }

    if (!bookingDate) {
        alert('Please select a booking date.');
        return;
    }

    if (!timeSlot) {
        alert('Please select a time slot.');
        return;
    }

    fetch("{{ route('user.booking.session.store') }}", {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({
            professional_name: professionalName,
            professional_address: professionalAddress,
            professional_id: professionalId,
            plan_type: planType,
            booking_date: bookingDate,
            time_slot: timeSlot,
        })
    })
    .then(res => res.json())
    .then(data => {
        if (data.status === 'success') {
            toastr.success(data.message);
            setTimeout(() => {
                window.location.href = "{{ route('user.booking') }}";
            }, 1000);
        } else {
            toastr.error(data.message || 'Something went wrong.');
        }
    })
    .catch(err => {
        console.error(err);
        toastr.error('Server error. Please try again later.');
    });
});});

    document.addEventListener("DOMContentLoaded", function () {
        const bioShort = document.getElementById("bio-short");
        const bioFull = document.getElementById("bio-full");
        const toggleBtn = document.getElementById("toggle-bio");

        if (toggleBtn) {
            toggleBtn.addEventListener("click", function () {
                if (bioFull.style.display === "none") {
                    bioShort.style.display = "none";
                    bioFull.style.display = "block";
                    toggleBtn.textContent = "Read Less";
                } else {
                    bioShort.style.display = "block";
                    bioFull.style.display = "none";
                    toggleBtn.textContent = "Read More";
                }
            });
        }
    });


            </script>
            @endsection
            