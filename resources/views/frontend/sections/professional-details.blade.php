@extends('layouts.layout')
@section('styles')
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/detail-page.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <style>
        /* Global Styles */
        body {
            background-color: #f8f9fa;
            
            line-height: 1.6;
            color: #333;
        }

        .container.margin_detail {
            background-color: #fff;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            margin-top: 100px;
            margin-bottom: 40px;
        }

        /* Header Section */
        .profile-header-flex {
            display: flex;
            align-items: flex-start;
            gap: 36px;
            margin-bottom: 32px;
            padding: 32px;
            background: #fff;
            border-radius: 18px;
            box-shadow: 0 4px 24px rgba(0,0,0,0.07);
            flex-wrap: wrap;
        }

        .profile-main-image {
            width: 320px;
            height: 320px;
            border-radius: 14px;
            object-fit: cover;
            object-position: center;
            box-shadow: 0 2px 16px rgba(0,0,0,0.10);
            background: #f8f8f8;
            border: 4px solid #f0f0f0;
            flex-shrink: 0;
        }

        .profile-header-details {
            flex: 1;
            display: flex;
            flex-direction: column;
            gap: 12px;
            min-width: 300px;
        }

        .profile-header-details h3 {
            margin-bottom: 8px;
            font-size: 2rem;
            font-weight: 700;
            color: #2a2a2a;
        }

        .profile-header-details p {
            margin-bottom: 8px;
            color: #666;
            font-size: 1.1rem;
        }

        .tags.no_margin {
            margin-left: -40px;
        }

        .tag-btn {
            display: inline-block;
            background: #f0f4ff;
            color: #2563eb;
            border-radius: 16px;
            padding: 5px 14px;
            font-size: 0.98rem;
            font-weight: 600;
            margin-right: 8px;
            margin-bottom: 8px;
            border: none;
            cursor: default;
            transition: background 0.2s;
        }

        .score_in {
            margin-top: 15px;
        }

        /* About Section */
        .main_info_wrapper {
            margin-bottom: 30px;
        }

        .user_desc h4 {
            font-size: 1.5rem;
            color: #2a2a2a;
            margin-bottom: 15px;
        }

        .user_desc p {
            color: #555;
            margin-bottom: 15px;
        }

        .show_hide {
            color: #00a6eb;
            font-weight: 600;
            cursor: pointer;
            display: inline-block;
            margin-top: 10px;
        }

        /* Tabs Section */
        .tabs_detail {
            margin-bottom: 30px;
        }

        .nav-tabs {
            border-bottom: 2px solid #f0f0f0;
        }

        .nav-tabs .nav-link {
            color: #6c757d;
            font-weight: 600;
            padding: 12px 20px;
            border: none;
        }

        .nav-tabs .nav-link.active {
            color: #00a6eb;
            background: transparent;
            border-bottom: 2px solid #00a6eb;
        }

        .tab-content {
            padding: 20px 0;
        }

        /* Appointment Types */
        .appointment_types {
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.08);
            margin-bottom: 25px;
        }

        .appointment_types .nav-tabs {
            padding: 0 15px;
        }

        .appointment-details {
            text-align: center;
            padding: 15px;
        }

        .appointment-details h4 {
            color: #2a2a2a;
            font-weight: 700;
            margin-bottom: 15px;
            font-size: 1.25rem;
        }

        .appointment-details p {
            color: #6c757d;
            margin-bottom: 20px;
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

        .price small {
            color: #6c757d;
            font-size: 13px;
        }

        /* Booking Section */
        .box_booking {
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.08);
            padding: 20px;
            margin-bottom: 25px;
        }

        .box_booking .head {
            margin-bottom: 20px;
        }

        .box_booking .head h3 {
            font-size: 1.5rem;
            color: #2a2a2a;
        }

        #selected-plan-display {
            display: none;
            margin-bottom: 20px;
            padding: 15px;
            background: #f0f9ff;
            border-left: 4px solid #00a6eb;
            border-radius: 5px;
            animation: fadeIn 0.5s ease;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* Buttons */
        .select-plan, .btn_1 {
            background: #00a6eb;
            color: white;
            border: none;
            transition: all 0.3s ease;
            padding: 12px 15px;
            font-weight: 600;
            border-radius: 5px;
            width: 100%;
            text-align: center;
            display: block;
            margin-top: 10px;
        }

        .select-plan:hover, .btn_1:hover {
            background: #0088c6;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 166, 235, 0.3);
            color: white;
            text-decoration: none;
        }

        .booking {
            margin-top: 20px;
        }

        /* Calendar */
        #calendarDiv {
            width: 100%;
            max-width: 400px;
            margin: 0 auto;
        }

        .flatpickr-day.selected {
            border: 2px solid black !important;
            box-sizing: border-box;
        }

        .flatpickr-day:hover {
            border: 2px solid #000;
        }

        .flatpickr-day.today {
            border: 1px solid #ccc;
        }

        /* Time Slots */
        .dropdown.time {
            width: 100%;
        }

        .dropdown-menu-content {
            padding: 15px;
        }

        .radio_select.time {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }

        .slot-box {
            flex: 0 0 calc(50% - 5px);
            display: none;
        }

        .slot-box label {
            display: block;
            padding: 8px 12px;
            background: #f8f9fa;
            border-radius: 5px;
            cursor: pointer;
            transition: all 0.2s;
            text-align: center;
        }

        .slot-box input[type="radio"]:checked + label {
            background: #00a6eb;
            color: white;
        }

        /* Reviews */
        .review_card {
            background: #fff;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }

        .rating i {
            color: #ffb700;
        }

        /* Gallery */
        .gallery-container {
            margin-top: 20px;
        }

        .gallery-item img {
            transition: transform 0.3s;
            cursor: pointer;
        }

        .gallery-item img:hover {
            transform: scale(1.02);
        }

        /* Responsive Adjustments */
        @media (max-width: 1200px) {
            .profile-main-image {
                width: 280px;
                height: 280px;
            }
        }

        @media (max-width: 992px) {
            .profile-header-flex {
                gap: 24px;
                padding: 24px;
            }
            
            .profile-main-image {
                width: 240px;
                height: 240px;
            }
            
            .profile-header-details h3 {
                font-size: 1.8rem;
            }

            .container.margin_detail {
                margin-top: 80px;
            }
        }

        @media (max-width: 768px) {
            .profile-header-flex {
                flex-direction: column;
                align-items: center;
                text-align: center;
                gap: 18px;
                padding: 20px;
            }
            
            .profile-main-image {
                width: 200px;
                height: 200px;
                margin: 0 auto;
            }
            
            .profile-header-details {
                text-align: center;
                align-items: center;
            }
            
            .profile-header-details h3 {
                font-size: 1.6rem;
            }
            
            .tags.no_margin {
                margin-left: 0 !important;
                justify-content: center;
            }
            
            .appointment_types .nav-link {
                padding: 10px 8px;
                font-size: 13px;
            }
            
            .appointment-details h4 {
                font-size: 1.1rem;
            }
            
            .price strong {
                font-size: 20px;
            }
            
            .box_booking {
                margin-top: 20px;
            }
            
            .tabs_detail .nav-tabs {
                flex-wrap: nowrap;
                overflow-x: auto;
                white-space: nowrap;
                -webkit-overflow-scrolling: touch;
                padding-bottom: 5px;
            }
            
            .tabs_detail .nav-item {
                display: inline-block;
                float: none;
            }

            .container.margin_detail {
                padding: 15px;
            }
        }

        @media (max-width: 576px) {
            .profile-main-image {
                width: 160px;
                height: 160px;
            }
            
            .profile-header-details h3 {
                font-size: 1.4rem;
            }
            
            .profile-header-details p {
                font-size: 1rem;
            }
            
            .tag-btn {
                font-size: 0.9rem;
                padding: 4px 12px;
                margin-right: 6px;
                margin-bottom: 6px;
            }
            
            .appointment_types .nav-link {
                padding: 8px 6px;
                font-size: 12px;
            }
            
            .appointment-features {
                max-width: 100%;
            }
            
            .select-plan, .btn_1 {
                padding: 10px 12px;
                font-size: 14px;
            }
            
            .slot-box {
                flex: 0 0 100%;
            }

            .container.margin_detail {
                margin-top: 70px;
            }
        }

        @media (max-width: 400px) {
            .profile-main-image {
                width: 140px;
                height: 140px;
            }
            
            .profile-header-details h3 {
                font-size: 1.3rem;
            }
            
            .appointment_types .nav-link {
                padding: 6px 4px;
                font-size: 11px;
            }

            .container.margin_detail {
                margin-top: 60px;
                padding: 10px;
            }
        }

        @media (max-width: 600px) {
            .appointment-tabs {
                flex-direction: column !important;
                gap: 0 !important;
            }
            .appointment-tabs .nav-link {
                border-radius: 8px 8px 0 0 !important;
                margin-bottom: 6px !important;
                padding: 3px 9px !important;
                font-size: 1rem !important;
            }
            .appointment-tab-content {
                padding: 18px 8px 14px 8px !important;
            }
            .appointment-details h4 {
                font-size: 1.1rem !important;
            }
            .appointment-details .price strong {
                font-size: 1.3rem !important;
            }
        }

        .tab-pane-container {
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 2px 15px rgba(0,0,0,0.08);
            margin-top: 0;
            margin-bottom: 24px;
            padding: 0;
            border: none;
        }
        .tab-pane-container .card-body {
            padding: 28px 24px;
        }
        @media (max-width: 768px) {
            .tab-pane-container .card-body {
                padding: 16px 8px;
            }
        }
    </style>
@endsection

@section('content')
    <div class="container margin_detail">
        <div class="row">
            <div class="col-xl-8 col-lg-7">
                <div class="box_general">
                    <div class="profile-header-flex">
                        <img src="{{ asset($profile->photo) }}" alt="" class="profile-main-image">
                        <div class="profile-header-details">
                            <h3 id="professional_name">{{ $profile->name }}</h3>
                            <p id="professional_address">{{ $profile->address }} - <a href="https://www.google.com/maps/dir//Assistance+–+Hôpitaux+De+Paris,+3+Avenue+Victoria,+75004+Paris,+Francia/@48.8606548,2.3348734,14z/data=!4m15!1m6!3m5!1s0x47e66e1de36f4147:0xb6615b4092e0351f!2sAssistance+Publique+-+Hôpitaux+de+Paris+(AP-HP)+-+Siège!8m2!3d48.8568376!4d2.3504305!4m7!1m0!1m5!1m1!1s0x47e67031f8c20147:0xa6a9af76b1e2d899!2m2!1d2.3504327!2d48.8568361" target="blank">Get directions</a></p>
                            <ul class="tags no_margin" style="margin-bottom: 8px;">
                                @if($services && $services->tags)
                                    @foreach(explode(',', $services->tags) as $tag)
                                        <li style="display:inline; list-style:none; padding:0; margin:0;">
                                            <span class="tag-btn">{{ trim($tag) }}</span>
                                        </li>
                                    @endforeach
                                @else
                                    <li><span class="tag-btn" style="background:#eee; color:#888;">No tags available</span></li>
                                @endif
                            </ul>
                            @if(!empty($profile->experience))
                                <div class="profile-experience" style="margin-bottom: 10px; color: #444; font-weight: 500; font-size: 1.08rem;">
                                    <i class="icon_briefcase" style="margin-right: 6px;"></i>{{ $profile->experience }} experience
                                </div>
                            @else
                                <div class="profile-experience" style="margin-bottom: 10px; color: #888; font-size: 1.08rem;">
                                    <i class="icon_briefcase" style="margin-right: 6px;"></i>Experience not specified
                                </div>
                            @endif
                            @if(!empty($profile->starting_price))
                                <div class="profile-price" style="margin-bottom: 10px; color: #1a8917; font-weight: 600; font-size: 1.08rem;">
                                    <i class="fas fa-wallet" style="margin-right: 6px;"></i>From ₹{{ number_format($profile->starting_price, 2) }}
                                </div>
                            @else
                                <div class="profile-price" style="margin-bottom: 10px; color: #888; font-size: 1.08rem;">
                                    <i class="fas fa-wallet" style="margin-right: 6px;"></i>Price not specified
                                </div>
                            @endif
                            <div class="score_in">
                                <div class="rating">
                                    <div class="score"><span>Superb<em>350 Reviews</em></span><strong>8.9</strong></div>
                                </div>
                                <a href="#0" class="wish_bt" aria-label="Add to wish list"><i class="icon_heart_alt"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="main_info_wrapper">
                        <div class="main_info clearfix">
                            <div class="user_desc">
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
                        </div>
                        <hr>
                    </div>
                </div>
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
                        <div id="pane-A" class="card tab-pane fade show active tab-pane-container" role="tabpanel" aria-labelledby="tab-A">
                            <div class="card-header" role="tab" id="heading-A">
                                <h5>
                                    <a class="collapsed" data-bs-toggle="collapse" href="#collapse-A" aria-expanded="true" aria-controls="collapse-A">
                                        Other info
                                    </a>
                                </h5>
                            </div>
                            @php
                            $services = $requestedService && $requestedService->requested_service
                                        ? json_decode($requestedService->requested_service, true)
                                        : [];
                        
                            $prices = $requestedService && $requestedService->price
                                        ? json_decode($requestedService->price, true)
                                        : [];
                        
                            $specializations = $requestedService && $requestedService->specializations
                                        ? json_decode($requestedService->specializations, true)
                                        : [];
                        
                            $education = $requestedService && $requestedService->education
                                        ? json_decode($requestedService->education, true)
                                        : ['college_name' => [], 'degree' => []];
                        @endphp
                        
                        <div id="collapse-A" class="collapse show" role="tabpanel" aria-labelledby="heading-A">
                            <div class="card-body info_content">
                                {{-- Services --}}
                                <div class="indent_title_in">
                                    <i class="icon_document_alt"></i>
                                    <h3>Services</h3>
                                </div>
                                <div class="wrapper_indent">
                                    @if(!empty($services))
                                        <p>{{ $requestedService->sub_heading ?? '' }}</p>
                        
                                        <h6>Most Requested Services</h6>
                                        <div class="services_list clearfix">
                                            <ul>
                                                @foreach($services as $index => $service)
                                                    <li>
                                                        {{ $service }}
                                                        @if(isset($prices[$index]))
                                                        <strong><small>from</small> ₹{{ number_format($prices[$index], 2) }}</strong>
                                                        @endif
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @else
                                        <p>No services available at the moment.</p>
                                    @endif
                                </div>
                                <hr>
                        
                                {{-- Specializations --}}
                                <div class="indent_title_in">
                                    <i class="icon_document_alt"></i>
                                    <h3>Professional statement</h3>
                                    <p>{{ $requestedService->statement ?? 'No statement provided.' }}</p>
                                </div>
                                <div class="wrapper_indent">
                                    <h6>Specializations</h6>
                                    <div class="row">
                                        @php
                                            $chunks = [];
                                            if (!empty($specializations) && count($specializations) > 0) {
                                                $chunks = array_chunk($specializations, ceil(count($specializations) / 2));
                                            }
                                        @endphp

                                        @if(!empty($chunks))
                                            @foreach($chunks as $chunk)
                                                <div class="col-lg-6">
                                                    <ul class="bullets">
                                                        @foreach($chunk as $item)
                                                            <li>{{ $item }}</li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            @endforeach
                                        @else
                                            <div class="col-12">
                                                <p>No specializations available at the moment.</p>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <hr>
                        
                                {{-- Education --}}
                                <div class="indent_title_in">
                                    <i class="icon_document_alt"></i>
                                    <h3>Educational background</h3>
                                    <p>{{ $requestedService->education_statement ?? 'No education statement available.' }}</p>
                                </div>
                                <div class="wrapper_indent add_bottom_25">
                                    <ul class="bullets">
                                        @foreach($education['college_name'] as $i => $college)
                                            @if(!empty($college) || !empty($education['degree'][$i]))
                                                <li><strong>{{ $college }}</strong> - {{ $education['degree'][$i] ?? '' }}</li>
                                            @endif
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                        </div>
                        
                        <div id="pane-B" class="card tab-pane fade tab-pane-container" role="tabpanel" aria-labelledby="tab-B">
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
                                        @php
                                            $reviews = $profile->professional->reviews ?? collect([]);
                                            $reviewCount = $reviews->count();
                                            $avgRating = $reviewCount > 0 ? number_format($reviews->avg('rating'), 1) : 0;
                                            
                                            // Rating text based on average score
                                            $ratingText = 'No ratings yet';
                                            if ($reviewCount > 0) {
                                                if ($avgRating >= 4.5) $ratingText = 'Excellent';
                                                elseif ($avgRating >= 4.0) $ratingText = 'Very Good';
                                                elseif ($avgRating >= 3.5) $ratingText = 'Good';
                                                elseif ($avgRating >= 3.0) $ratingText = 'Average';
                                                else $ratingText = 'Fair';
                                            }
                                        @endphp
                                        
                                        <div class="col-md-3">
                                            <div id="review_summary">
                                                <strong>{{ $avgRating }}</strong>
                                                <em>{{ $ratingText }}</em>
                                                <small>Based on {{ $reviewCount }} {{ $reviewCount == 1 ? 'review' : 'reviews' }}</small>
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-9 reviews_sum_details">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <h6>Rating</h6>
                                                    <div class="row">
                                                        <div class="col-xl-10 col-lg-9 col-9">
                                                            <div class="progress">
                                                                <div class="progress-bar" role="progressbar" style="width: {{ $avgRating * 20 }}%" aria-valuenow="{{ $avgRating * 20 }}" aria-valuemin="0" aria-valuemax="100"></div>
                                                            </div>
                                                        </div>
                                                        <div class="col-xl-2 col-lg-3 col-3"><strong>{{ $avgRating }}</strong></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <p class="text-end">
                                        <button type="button" class="btn_1" data-bs-toggle="modal" data-bs-target="#reviewModal">
                                            <i class="fas fa-star me-1"></i> Leave a review
                                        </button>
                                    </p>
                                    
                                    <div id="reviews">
                                        @forelse($reviews as $review)
                                            <div class="review_card">
                                                <div class="row">
                                                    <div class="col-md-2 user_info">
                                                        @php
                                                            // Try to get profile image from customer_profiles table
                                                            $userPhoto = null;
                                                            if ($review->user && $review->user->customerProfile) {
                                                                $userPhoto = $review->user->customerProfile->photo;
                                                            }
                                                            // Fallback to default avatar
                                                            if (!$userPhoto) {
                                                                $userPhoto = 'img/avatar-placeholder.jpg';
                                                            }
                                                        @endphp
                                                        <figure class="mb-2">
                                                            <img src="{{ asset($userPhoto) }}" alt="{{ $review->user->name ?? 'Anonymous' }}" class="img-fluid rounded-circle" style="width: 70px; height: 70px; object-fit: cover;">
                                                        </figure>
                                                        <h5>{{ $review->user->name ?? 'Anonymous' }}</h5>
                                                    </div>
                                                    <div class="col-md-10 review_content">
                                                        <div class="clearfix add_bottom_15">
                                                            <span class="rating">
                                                                @for ($i = 1; $i <= 5; $i++)
                                                                    @if ($i <= $review->rating)
                                                                        <i class="fas fa-star text-warning"></i>
                                                                    @else
                                                                        <i class="far fa-star text-muted"></i>
                                                                    @endif
                                                                @endfor
                                                                <small class="ms-2">({{ $review->rating }}/5)</small>
                                                            </span>
                                                            <em>Published {{ $review->created_at->diffForHumans() }}</em>
                                                        </div>
                                                        <p>{{ $review->review_text }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        @empty
                                            <div class="alert alert-info">
                                                <p class="mb-0 text-center">This professional doesn't have any reviews yet. Be the first to leave a review!</p>
                                            </div>
                                        @endforelse
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div id="pane-C" class="card tab-pane fade tab-pane-container" role="tabpanel" aria-labelledby="tab-C">
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
                    </div>
                </div>
            </div>
            
            <div class="col-xl-4 col-lg-5">
                <!-- Appointment Type Tabs -->
                <div class="box_booking appointment_types">
                    <div class="tabs">
                        <ul class="nav nav-tabs appointment-tabs" role="tablist" style="border-bottom:none; gap: 8px;">
                            @foreach($rates as $rate)
                                @php
                                    $safeId = strtolower(str_replace(' ', '_', $rate->session_type));
                                @endphp
                                <li class="nav-item" style="margin-bottom:0;">
                                    <a class="nav-link @if($loop->first) active @endif" id="{{ $safeId }}-tab" data-bs-toggle="tab" href="#{{ $safeId }}" role="tab" style="font-weight:600; border-radius: 8px 8px 0 0; padding: 3px 9px; border: 1px solid #e0e7ef; background: @if($loop->first) #2563eb @else #f7f9fc @endif; color: @if($loop->first) #fff @else #222 @endif; transition: background 0.2s, color 0.2s;">
                                        {{ ucfirst($rate->session_type) }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                        <div class="tab-content appointment-tab-content" style="background:#f7f9fc; border-radius:0 0 12px 12px; padding:32px 28px 24px 28px; margin-top:-2px; border:1px solid #e0e7ef;">
                            @foreach($rates as $rate)
                                @php
                                    $safeId = strtolower(str_replace(' ', '_', $rate->session_type));
                                @endphp
                                <div class="tab-pane fade @if($loop->first) show active @endif" id="{{ $safeId }}" role="tabpanel" aria-labelledby="{{ $safeId }}-tab">
                                    <div class="appointment-details" style="max-width:500px; margin:auto;">
                                        <h4 style="font-weight:700; color:#222; margin-bottom:10px;">{{ ucfirst($rate->session_type) }} Consultation</h4>
                                        <p style="color:#555; margin-bottom:18px;">{{ $rate->professional->bio }}</p>
                                        <ul class="appointment-features" style="padding-left:0; list-style:none; margin-bottom:22px;">
                                            <li style="margin-bottom:7px; color:#2563eb;"><i class="icon_check_alt2"></i> <span style="color:#444;">{{ $rate->num_sessions }} sessions</span></li>
                                            <li style="margin-bottom:7px; color:#2563eb;"><i class="icon_check_alt2"></i> <span style="color:#444;">{{ $rate->duration }} min per session</span></li>
                                            <li style="color:#2563eb;"><i class="icon_check_alt2"></i> <span style="color:#444;">Curated solutions for you</span></li>
                                        </ul>
                                        <div class="price" style="margin-bottom:18px;">
                                            @php
                                            $perText = match (strtolower($rate->session_type)) {
                                                'free hand' => 'per session',
                                                'weekly' => 'per week',
                                                'monthly' => 'per month',
                                                'quarterly' => 'per 3 months',
                                                default => 'per session',
                                            };
                                            @endphp
                                            <strong style="font-size:2rem; color:#2563eb; font-weight:700;">Rs. {{ number_format($rate->final_rate, 2) }}</strong><br>
                                            <small style="font-size:1rem; color:#666;">{{ $perText }}</small>
                                        </div>
                                        <button 
                                            class="select-plan" 
                                            data-plan="{{ $safeId }}" 
                                            data-sessions="{{ $rate->num_sessions }}" 
                                            data-rate="{{ $rate->final_rate }}"
                                            style="background:#2563eb; color:#fff; border:none; border-radius:6px; padding:10px 28px; font-weight:600; font-size:1.08rem; transition:background 0.2s; box-shadow:none; outline:none; cursor:pointer;"
                                            onmouseover="this.style.background='#1741a6'" onmouseout="this.style.background='#2563eb'"
                                        >
                                            Select {{ ucfirst($rate->session_type) }}
                                        </button>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                
                <!-- Booking Section -->
                <div class="box_booking">
                    <div class="head">
                        <h3>Booking</h3>
                        <a href="#0" class="close_panel_mobile"><i class="icon_close"></i></a>
                    </div>
                    <div class="main">
                        <div id="selected-plan-display" style="display:none;">
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
                        <div style="display: flex; justify-content: center; margin-top: 20px;">
                            <div style="padding: 10px; background: #fff; border: 1px solid #ccc; box-shadow: 0 0 10px rgba(0,0,0,0.1); border-radius: 8px;">
                                <input type="text" id="rangeInput" placeholder="Select Dates" style="display: none;" />
                                <div id="calendarDiv"></div>
                            </div>
                        </div>
                        <div class="dropdown time mt-4">
                            <a href="#" data-bs-toggle="dropdown">
                                <div>Hour</div>
                                <div id="selected_time"></div>
                            </a>
                            
                            <div class="dropdown-menu">
                                <div class="dropdown-menu-content">
                                    <div class="radio_select d-flex flex-wrap gap-2">
                                        @foreach($availabilities as $availability)
                                            @php $weekdays = json_decode($availability->weekdays, true); @endphp
                                            @if(is_array($weekdays))
                                                @foreach($availability->slots as $slot)
                                                    @foreach($weekdays as $day)
                                                        @php
                                                            $weekday = strtolower($day);
                                                            $startTime = \Carbon\Carbon::createFromFormat('H:i:s', $slot->start_time)->format('h:i A'); 
                                                            $endTime = \Carbon\Carbon::createFromFormat('H:i:s', $slot->end_time)->format('h:i A');
                                                        @endphp

                                                        <div class="slot-box" data-weekday="{{ $weekday }}" style="flex: 0 0 auto; display: none;">
                                                            <input type="radio"
                                                                id="time_{{ $slot->id }}_{{ $weekday }}"
                                                                name="time"
                                                                class="time-slot"
                                                                data-id="{{ $slot->id }}"
                                                                value="{{ $startTime }} to {{ $endTime }}"
                                                                data-start="{{ $startTime }}"
                                                                data-start-period="{{ strtoupper($slot->start_period) }}"
                                                                data-end="{{ $endTime }}"
                                                                data-end-period="{{ strtoupper($slot->end_period) }}">

                                                            <label for="time_{{ $slot->id }}_{{ $weekday }}">
                                                                {{ $startTime }} - {{ $endTime }}
                                                            </label>
                                                        </div>
                                                    @endforeach
                                                @endforeach
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                        <ul id="selected-time-list">
                            <!-- Selected dates and times will be appended here -->
                        </ul>
                        
                        <a href="javascript:void(0);" class="btn_1 full-width booking">Book Now</a>
                    </div>
                </div>
                
                <!-- Social Share Buttons -->
                <ul class="share-buttons">
                    <li><a class="fb-share" href="#0"><i class="social_facebook"></i> Share</a></li>
                    <li><a class="twitter-share" href="#0"><i class="social_twitter"></i> Share</a></li>
                    <li><a class="gplus-share" href="#0"><i class="social_googleplus"></i> Share</a></li>
                </ul>
            </div>
        </div>
    </div>
    
    <!-- Review Modal -->
    <div class="modal fade" id="reviewModal" tabindex="-1" aria-labelledby="reviewModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="reviewModalLabel">
                        <i class="fas fa-star text-warning me-2"></i>Rate Your Experience
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    @if(Auth::guard('user')->check())
                        <form id="reviewForm">
                            @csrf
                            <input type="hidden" name="professional_id" value="{{ $profile->professional->id ?? '' }}">
                            
                            <!-- Rating Stars -->
                            <div class="rating-container text-center mb-4">
                                <p class="rating-title mb-2">How would you rate this professional?</p>
                                <div class="star-rating">
                                    <input type="radio" id="star5" name="rating" value="5" />
                                    <label for="star5" title="5 stars"><i class="fas fa-star"></i></label>
                                    
                                    <input type="radio" id="star4" name="rating" value="4" />
                                    <label for="star4" title="4 stars"><i class="fas fa-star"></i></label>
                                    
                                    <input type="radio" id="star3" name="rating" value="3" />
                                    <label for="star3" title="3 stars"><i class="fas fa-star"></i></label>
                                    
                                    <input type="radio" id="star2" name="rating" value="2" />
                                    <label for="star2" title="2 stars"><i class="fas fa-star"></i></label>
                                    
                                    <input type="radio" id="star1" name="rating" value="1" />
                                    <label for="star1" title="1 star"><i class="fas fa-star"></i></label>
                                </div>
                                <div class="rating-value mt-2">
                                    <span id="selected-rating">Select a rating</span>
                                </div>
                            </div>
                            
                            <!-- Review Text -->
                            <div class="form-group mb-3">
                                <label for="review_text" class="form-label">Your Review</label>
                                <textarea class="form-control" name="review_text" id="review_text" rows="4" 
                                    placeholder="Share your experience with this professional..."></textarea>
                                <small class="form-text text-muted">
                                    Your honest feedback helps others make better decisions.
                                </small>
                            </div>
                        </form>
                    @else
                        <div class="alert alert-info d-flex align-items-center">
                            <i class="fas fa-info-circle me-2"></i>
                            <div>
                                Please <a href="{{ route('login') }}?redirect={{ url()->current() }}" class="alert-link">sign in</a> to leave a review.
                            </div>
                        </div>
                    @endif
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                    @if(Auth::guard('user')->check())
                        <button type="button" class="btn_1" id="submitReview">
                            <i class="fas fa-paper-plane me-1"></i> Submit Review
                        </button>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            let enabledDates = @json($enabledDates);
            console.log(enabledDates);
            
            // Get existing bookings for this professional
            const existingBookings = @json($existingBookings ?? []);
            console.log("Existing bookings:", existingBookings);
            
            let selectedBookings = {};

            // Helper function to format the date to local date string
            function formatLocalDate(date) {
                const offset = date.getTimezoneOffset();
                const localDate = new Date(date.getTime() - offset * 60000);
                return localDate.toISOString().split('T')[0];
            }

            // Initialize Flatpickr
            flatpickr("#calendarDiv", {
                inline: true,
                mode: "multiple",
                dateFormat: "Y-m-d",
                minDate: "today",
                enable: enabledDates, 
                disable: [
                    function (date) {
                        const dateString = formatLocalDate(date);
                        return !enabledDates.includes(dateString) || date.getDay() === 0;
                    }
                ],
                onDayCreate: function (dObj, dStr, fp, dayElem) {
                    const date = dayElem.dateObj;
                    const dateString = formatLocalDate(date);
                    if (enabledDates.includes(dateString) && date.getDay() !== 0) {
                        dayElem.style.backgroundColor = '#28a745';
                        dayElem.style.color = 'white';
                    } else {
                        dayElem.style.backgroundColor = '#ccc'; // Disabled days
                        dayElem.style.color = '#999';
                    }
                },
                onChange: function (selectedDates, dateStr, instance) {
                    const offset = selectedDates.length ? selectedDates[0].getTimezoneOffset() : 0;
                    const selectedDatesLocal = selectedDates.map(d => {
                        return new Date(d.getTime() - offset * 60000).toISOString().split('T')[0];
                    });

                    // Remove unselected dates from selectedBookings
                    Object.keys(selectedBookings).forEach(date => {
                        if (!selectedDatesLocal.includes(date)) {
                            delete selectedBookings[date];
                        }
                    });

                    // Hide all slot boxes first
                    document.querySelectorAll('.slot-box').forEach(box => {
                        box.style.display = 'none';
                        box.removeAttribute('data-current-date');
                    });

                    // Show slots for last selected date only
                    if (selectedDates.length > 0) {
                        const selectedDateUTC = selectedDates[selectedDates.length - 1];
                        const selectedDate = new Date(selectedDateUTC.getTime() - offset * 60000);
                        const weekdayNames = ['sun', 'mon', 'tue', 'wed', 'thu', 'fri', 'sat'];
                        const weekday = weekdayNames[selectedDate.getDay()];
                        const dateString = selectedDate.toISOString().split('T')[0];

                        document.querySelectorAll(`.slot-box[data-weekday="${weekday}"]`).forEach(box => {
                            box.style.display = 'flex';
                            box.setAttribute('data-current-date', dateString);
                            
                            // Check if the slot is already booked
                            const timeInput = box.querySelector('.time-slot');
                            const timeValue = timeInput.value;
                            
                            // Disable slots that are already booked
                            if (isTimeSlotBooked(dateString, timeValue)) {
                                timeInput.disabled = true;
                                timeInput.checked = false;
                                box.classList.add('slot-booked');
                            } else {
                                timeInput.disabled = false;
                                box.classList.remove('slot-booked');
                            }
                        });
                    }

                    updateSelectedTimeList();
                }
            });

            // Function to check if a time slot is already booked
            function isTimeSlotBooked(date, timeSlot) {
                if (!existingBookings[date]) return false;
                
                // Format timeSlot for comparison (both might have different formats)
                const slotStartTime = timeSlot.split(' to ')[0].trim();
                
                return existingBookings[date].some(bookedTime => {
                    // Format bookedTime for comparison
                    const bookedStartTime = bookedTime.split(' to ')[0].trim();
                    
                    // Compare times (ignoring AM/PM for now - would need more robust comparison in production)
                    return bookedStartTime === slotStartTime;
                });
            }

            // Handle slot selection
            document.querySelectorAll('.time-slot').forEach(slot => {
                slot.addEventListener('change', function () {
                    const box = this.closest('.slot-box');
                    const currentDate = box.getAttribute('data-current-date');
                    const selectedTime = this.value;

                    // Don't allow selection of already booked slots
                    if (isTimeSlotBooked(currentDate, selectedTime)) {
                        toastr.error('This time slot is already booked. Please choose another time.');
                        this.checked = false;
                        return;
                    }

                    if (currentDate && selectedTime) {
                        if (!selectedBookings[currentDate]) {
                            selectedBookings[currentDate] = [];
                        }
                        selectedBookings[currentDate] = [selectedTime];
                        document.querySelectorAll(`.slot-box[data-current-date="${currentDate}"] .time-slot`).forEach(input => {
                            input.checked = (input.value === selectedTime);
                        });

                        updateSelectedTimeList();
                    }
                });
            });
            
            // Add CSS for booked slots
            const style = document.createElement('style');
            style.textContent = `
                .slot-booked {
                    opacity: 0.6;
                    position: relative;
                }
                .slot-booked::after {
                    content: "BOOKED";
                    position: absolute;
                    top: 50%;
                    left: 50%;
                    transform: translate(-50%, -50%);
                    background-color: rgba(255, 0, 0, 0.7);
                    color: white;
                    font-size: 10px;
                    padding: 2px 5px;
                    border-radius: 3px;
                    white-space: nowrap;
                    z-index: 2;
                }
            `;
            document.head.appendChild(style);

            function updateSelectedTimeList() {
                const list = document.getElementById('selected-time-list');
                if (list) {
                    list.innerHTML = '';

                    // Sort the dates first
                    const sortedDates = Object.keys(selectedBookings).sort();

                    sortedDates.forEach(date => {
                        // Sort times within each date
                        const sortedTimes = selectedBookings[date].slice().sort((a, b) => {
                            return new Date(`1970-01-01T${a}`) - new Date(`1970-01-01T${b}`);
                        });

                        sortedTimes.forEach(time => {
                            const item = document.createElement('li');
                            item.textContent = `${date} - ${time}`;
                            list.appendChild(item);
                        });
                    });
                    const bookingDataInput = document.getElementById('booking_data_json');
                    if (bookingDataInput) {
                        bookingDataInput.value = JSON.stringify(selectedBookings);
                    }
                } else {
                    console.warn('Selected time list element not found!');
                }
            }

            // Handle plan selection
            const planButtons = document.querySelectorAll('.select-plan');
            const selectedPlanDisplay = document.getElementById('selected-plan-display');
            const selectedPlanText = document.getElementById('selected-plan-text');
            const selectedPlanInput = document.getElementById('selected_plan');
            let sessionCount = 0; 
            let selectedRate = 0;

            planButtons.forEach(button => {
                button.addEventListener('click', function () {
                    const plan = this.getAttribute('data-plan');
                    sessionCount = parseInt(this.getAttribute('data-sessions')); 
                    selectedRate = parseFloat(this.getAttribute('data-rate'));
                    selectedPlanInput.value = plan;
                    
                    // Format the plan name for display
                    const displayPlan = plan.split('_')
                        .map(word => word.charAt(0).toUpperCase() + word.slice(1))
                        .join(' ');
                        
                    selectedPlanText.textContent = `${displayPlan} Consultation (Total ${sessionCount} Sessions)`;
                    selectedPlanDisplay.style.display = 'block';
                    selectedPlanDisplay.scrollIntoView({ behavior: 'smooth' });
                });
            });

            // Handle booking submission
            document.querySelector('.booking').addEventListener('click', function (e) {
                e.preventDefault();

                const planType = selectedPlanInput.value;
                const bookingData = selectedBookings;

                // Get the number of dates selected by the user
                const selectedDatesCount = Object.keys(bookingData).length;

                if (!planType) {
                    toastr.error('Please select a consultation plan.');
                    return;
                }

                if (selectedDatesCount !== sessionCount) {
                    toastr.error(`You need to select ${sessionCount} dates for this booking.`);
                    return;
                }

                const professionalName = document.getElementById('professional_name').textContent.trim();
                const professionalAddress = document.getElementById('professional_address').textContent.trim();
                const professionalId = {{ json_encode($profile->professional->id ?? null) }};

                // Format the bookings data into the expected structure
                const formattedBookings = {};
                Object.keys(bookingData).forEach(date => {
                    formattedBookings[date] = bookingData[date];
                });

                // Send the booking data to the server
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
                        bookings: formattedBookings,
                        total_amount: selectedRate
                    })
                })
                .then(res => {
                    if (!res.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return res.json();
                })
                .then(data => {
                    console.log('Response Data:', data);
                    
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
            });

            // Toggle Bio functionality
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

            // Star rating selection
            const starInputs = document.querySelectorAll('.star-rating input');
            const ratingValue = document.getElementById('selected-rating');
            
            starInputs.forEach(input => {
                input.addEventListener('change', function() {
                    const value = this.value;
                    let text = '';
                    
                    switch(value) {
                        case '5': text = 'Excellent'; break;
                        case '4': text = 'Very Good'; break;
                        case '3': text = 'Good'; break;
                        case '2': text = 'Fair'; break;
                        case '1': text = 'Poor'; break;
                        default: text = 'Select a rating';
                    }
                    
                    ratingValue.textContent = `${text} (${value}/5)`;
                });
            });

            // Submit review
            const submitReviewBtn = document.getElementById('submitReview');
            if (submitReviewBtn) {
                submitReviewBtn.addEventListener('click', function() {
                    const form = document.getElementById('reviewForm');
                    const formData = new FormData(form);
                    const rating = formData.get('rating');
                    const reviewText = formData.get('review_text');
                    
                    // Validate form
                    if (!rating) {
                        toastr.error('Please select a rating');
                        return;
                    }
                    
                    if (!reviewText.trim()) {
                        toastr.error('Please write your review');
                        return;
                    }
                    
                    // Show loading state
                    submitReviewBtn.disabled = true;
                    submitReviewBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i> Submitting...';
                    
                    // Submit the review
                    fetch('{{ route("user.review.store") }}', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Content-Type': 'application/json',
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({
                            professional_id: formData.get('professional_id'),
                            rating: rating,
                            review_text: reviewText
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            toastr.success(data.message || 'Review submitted successfully!');
                            
                            // Close modal and reset form
                            const modal = bootstrap.Modal.getInstance(document.getElementById('reviewModal'));
                            modal.hide();
                            setTimeout(() => {
                                window.location.reload();
                            }, 1500);
                        } else {
                            toastr.error(data.message || 'Something went wrong');
                            submitReviewBtn.disabled = false;
                            submitReviewBtn.innerHTML = '<i class="fas fa-paper-plane me-1"></i> Submit Review';
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        toastr.error('An error occurred. Please try again.');
                        submitReviewBtn.disabled = false;
                        submitReviewBtn.innerHTML = '<i class="fas fa-paper-plane me-1"></i> Submit Review';
                    });
                });
            }
        });
    </script>
@endsection