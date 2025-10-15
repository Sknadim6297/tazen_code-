@extends('layouts.layout')
@section('styles')
   {{-- <link rel="stylesheet" href="{{ asset('admin/css/styles.css') }}" /> --}}
   <link rel="stylesheet" href="{{ asset('frontend/assets/css/responsive2.css') }}" media="screen and (max-width: 992px)">
   <style>
    /* Improved Banner Slider Styles */
    .hero_single.event-slide {
        position: relative;
        width: 100%;
        height: 70vh; /* Default height for desktop */
        overflow: hidden;
    }
    
    /* Mobile height */
    @media (max-width: 768px) {
        .hero_single.event-slide {
            height: 50vh; /* Adjust height for mobile */
        }
    }
    
    /* Tablet height */
    @media (min-width: 769px) and (max-width: 992px) {
        .hero_single.event-slide {
            height: 60vh;
        }
    }
    
    .hero_single .owl-carousel, 
    .hero_single .owl-stage-outer, 
    .hero_single .owl-stage, 
    .hero_single .owl-item {
        height: 100%;
    }
    
    .hero_single .owl-carousel .item {
        height: 100%;
    }
    
    .hero_single .owl-carousel .item img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        object-position: center;
    }
    
    .hero_single .owl-dots {
        position: absolute;
        bottom: 20px;
        width: 100%;
        text-align: center;
    }
    
    .hero_single .owl-dot span {
        width: 12px;
        height: 12px;
        margin: 0 5px;
        background: rgba(255,255,255,0.5);
        display: block;
        border-radius: 50%;
        transition: all 0.3s ease;
    }
    
    .hero_single .owl-dot.active span {
        background: #fff;
        width: 20px;
        border-radius: 10px;
    }

    /* Modern Modal Styles */
    .bg-gradient-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }

    .modal-content {
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 20px 60px rgba(0,0,0,0.15);
    }

    .modal-header {
        padding: 1.5rem;
        position: relative;
    }

    .modal-header::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        height: 1px;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
    }

    .event-summary-card {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        border: 1px solid #dee2e6;
        transition: all 0.3s ease;
    }

    .event-summary-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(0,0,0,0.1);
    }

    .price-breakdown {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        border: 1px solid #dee2e6;
    }

    .form-control, .input-group-text {
        border-radius: 12px;
        border: 2px solid #e9ecef;
        transition: all 0.3s ease;
    }

    .form-control:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
    }

    .input-group .form-control {
        border-left: none;
        border-top-left-radius: 0;
        border-bottom-left-radius: 0;
    }

    .input-group .input-group-text {
        border-right: none;
        border-top-right-radius: 0;
        border-bottom-right-radius: 0;
    }

    .btn {
        border-radius: 12px;
        font-weight: 600;
        transition: all 0.3s ease;
        text-transform: none;
    }

    .btn-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: none;
        box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(102, 126, 234, 0.5);
    }

    .btn-outline-secondary {
        border: 2px solid #6c757d;
        color: #6c757d;
    }

    .btn-outline-secondary:hover {
        background: #6c757d;
        border-color: #6c757d;
        transform: translateY(-1px);
    }

    .form-label {
        font-weight: 600;
        color: #495057;
        margin-bottom: 0.5rem;
    }

    .form-text {
        font-size: 0.875rem;
        color: #6c757d;
        margin-top: 0.25rem;
    }

    /* Animation for modal */
    .modal.fade .modal-dialog {
        transform: scale(0.8);
        transition: transform 0.3s ease-out;
    }

    .modal.show .modal-dialog {
        transform: scale(1);
    }

    /* Responsive adjustments */
    @media (max-width: 576px) {
        .modal-dialog {
            margin: 1rem;
        }
        
        .modal-header {
            padding: 1rem;
        }
        
        .modal-body {
            padding: 1rem;
        }
        
        .modal-footer {
            padding: 1rem;
        }
    }

    /* Custom scrollbar for textarea */
    textarea::-webkit-scrollbar {
        width: 6px;
    }

    textarea::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 3px;
    }

    textarea::-webkit-scrollbar-thumb {
        background: #c1c1c1;
        border-radius: 3px;
    }

    textarea::-webkit-scrollbar-thumb:hover {
        background: #a8a8a8;
    }
        /* Login Popup Custom Styling */
    .login-popup-title {
        font-size: 1.5rem !important;
        color: white !important;
    }

    .login-popup-title .wave-icon {
        font-size: 1.8rem !important;
    }

    .login-popup-custom {
        background: linear-gradient(135deg, #152a70, #c51010, #f39c12) !important;
        color: white !important;
        border-radius: 15px !important;
        padding: 25px 20px !important;
    }

    .login-popup-btn {
        background-color: #1e0d60 !important;
        color: white !important;
        font-size: 1.2rem !important;
        font-weight: 600 !important;
        padding: 12px 30px !important;
        border-radius: 50px !important;
        border: none !important;
        box-shadow: 0 4px 15px rgba(0,0,0,0.2) !important;
    }

    .login-popup-btn:hover {
        transform: translateY(-3px) !important;
        box-shadow: 0 6px 20px rgba(0,0,0,0.3) !important;
    }
    
    .login-popup-close {
        color: white !important;
        opacity: 0.8 !important;
        font-size: 1.5rem !important;
    }
    
    .login-popup-close:hover {
        opacity: 1 !important;
    }
   </style>
@endsection
@section('content')

<main>
  <!-- Improved Banner Section -->
  <div class="hero_single event-slide">
    <div class="owl-carousel owl-theme">
        @if(isset($allEvent))
            {{-- Professional Event - use card_image as banner --}}
            <div class="item">
                <img src="{{ asset('storage/' . $allEvent->card_image) }}" alt="{{ $allEvent->heading }}" />
            </div>
        @else
            {{-- Admin Event - use banner_image array --}}
            @php
                $banners = $event->banner_image;
                if (is_string($banners)) {
                    $banners = json_decode($banners, true);
                    if (is_string($banners)) {
                        $banners = json_decode($banners, true);
                    }
                }
                if (!is_array($banners)) {
                    $banners = [];
                }
            @endphp
            @if (is_array($banners) && count($banners))
                @foreach ($banners as $banner)
                    <div class="item">
                        <img src="{{ asset('storage/' . str_replace('\\/', '/', $banner)) }}" alt="{{ $event->eventDetails->heading }}" />
                    </div>
                @endforeach
            @else
                <div class="item">
                    <p>No banner images available.</p>
                </div>
            @endif
        @endif
    </div>
 </div>

<div class="event-information my-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <div class="details-event">
                    <h3>{{ isset($allEvent) ? $allEvent->heading : $event->eventDetails->heading }}</h3>
                    <p>{{ isset($allEvent) ? $allEvent->mini_heading : ($event->event_type ?? 'Event') }}</p>
                </div>
            </div>
            <div class="col-lg-4 text-end">
                <button class="btn unique-btn" id="bookNowBtn"
                    data-event-id="{{ isset($allEvent) ? $allEvent->id : ($event->event_id ?? $event->id) }}"
                    data-event-name="{{ isset($allEvent) ? $allEvent->heading : ($event->eventDetails->heading ?? $event->name ?? 'Event') }}"
                    data-location="{{ isset($allEvent) ? 'Online/Offline' : ($event->city ?? 'Kolkata') }}"
                    data-type="{{ isset($allEvent) ? 'TBD' : ($event->event_mode ?? 'offline') }}"
                    data-event-date="{{ isset($allEvent) ? \Carbon\Carbon::parse($allEvent->date)->format('d-m-Y') : \Carbon\Carbon::parse($event->starting_date)->format('d-m-Y') }}"
                    data-amount="{{ isset($allEvent) ? $allEvent->starting_fees : $event->starting_fees }}">
                    Book Now
                </button>
            </div>
        </div>
    </div>
</div>
<hr>
<div class="col-lg-12">
    <div class="event-date" style="text-align: center; display: flex; align-items: center; justify-content: center; gap: 30px;">
        <p>{{ isset($allEvent) ? \Carbon\Carbon::parse($allEvent->date)->format('d-m-Y') : \Carbon\Carbon::parse($event->starting_date)->format('d-m-Y') }} onwards</p>
        <p><i class="fa-solid fa-location-check" style="margin-right: 10px;"></i>{{ isset($allEvent) ? 'To be announced' : $event->event_mode }}</p>
        <p><span>₹{{ isset($allEvent) ? $allEvent->starting_fees : $event->starting_fees }}</span> onwards</p>
    </div>
</div>

<div class="share-description-map my-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-3">
                <div class="share-content">
                    <h2>Share this Event</h2>
                    <div class="share-button text-center">
                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(Request::url()) }}" 
                           target="_blank" 
                           class="share-link facebook">
                            <i class="fa-brands fa-square-facebook"></i>
                        </a>
                        <a href="https://twitter.com/intent/tweet?text={{ urlencode(isset($allEvent) ? $allEvent->heading : $event->eventDetails->heading) }}&url={{ urlencode(Request::url()) }}" 
                           target="_blank" 
                           class="share-link twitter">
                            <i class="fa-brands fa-square-x-twitter"></i>
                        </a>
                        <a href="https://api.whatsapp.com/send?text={{ urlencode((isset($allEvent) ? $allEvent->heading : $event->eventDetails->heading) . ' - ' . Request::url()) }}" 
                           target="_blank" 
                           class="share-link whatsapp">
                            <i class="fa-brands fa-square-whatsapp"></i>
                        </a>
                        <button onclick="copyToClipboard()" class="share-link instagram">
                            <i class="fa-brands fa-square-instagram"></i>
                        </button>
                    </div>
                    <div id="copyMessage" class="copy-message" style="display: none;">
                        Event details copied! You can now paste this into your Instagram story or post.
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
               <div class="first-portion">
                    <h2>Click on interested to stay update about this event</h2>
                    <div class="interest">
                        <div class="like-text d-flex">
                            <div class="likes d-flex gap-3 align-items-center">
                                <a href="#"><i class="fa-regular fa-thumbs-up"></i> <span class="text-dark">230</span></a>
                            </div>
                            <a href="#"><button class="btn unique-btn" style="width: 100%;">Interested</button></a>
                        </div>
                        <p>People have shown interest recently</p>
                    </div>
               </div>
               <div class="second-portion my-3">
                   <div class="note-content">
                    <h2>Note</h2>
                    <p>Reach the venue 30minute prior</p>
                   </div>
               </div>
               <div class="third-portion my-3">
                <div class="about-content">
                    <h3>About Event Details</h3>
                    <p>{{ isset($allEvent) ? $allEvent->short_description : $event->event_details }}</p>
                </div>
            </div>
            
            @if(!isset($allEvent))
            {{-- Gallery section only for admin events --}}
            <div class="forth-portion my-3">
                <div class="gallery-sliding">
                    <h2>Gallery</h2>
                    <div class="owl-carousel gallery-carousal">
                        @php
                            $decoded = json_decode($event->event_gallery, true);
                            $galleryImages = is_string($decoded) ? json_decode($decoded, true) : $decoded;
                        @endphp
            
                        @if (is_array($galleryImages) && count($galleryImages))
                            @foreach ($galleryImages as $galleryImage)
                                <div class="item">
                                    <img src="{{ asset('storage/' . str_replace('\\/', '/', $galleryImage)) }}" alt="Gallery Image">
                                </div>
                            @endforeach
                        @else
                            <div class="item">
                                <p>No gallery images available.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            @endif

            <div class="fifth-portion">
                <div class="col-lg-12 col-md-12 mt-md-0 mt-sm-4 mt-4">
                    <div class="accordion d-flex flex-column gap-4" id="accordionExample" data-aos="fade-down">
                        @foreach($eventfaqs as $faq)
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingOne">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                          {{$faq->question1}}
                          </button>
                            </h2>
                            <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    <p>{{$faq->answer1}}</p>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingTwo">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                    {{$faq->question2}}
                          </button>
                            </h2>
                            <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    <p>{{$faq->answer2}}</p>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingThree">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                    {{$faq->question3}}
                          </button>
                            </h2>
                            <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    <p>{{$faq->answer3}}</p>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingfour">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapsefour" aria-expanded="false" aria-controls="collapsefour">
                                    {{$faq->question4}}
                          </button>
                            </h2>
                            <div id="collapsefour" class="accordion-collapse collapse" aria-labelledby="headingfour" data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    <p>{{$faq->answer4}}</p>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            </div>
            <div class="col-lg-3 pl-0">
                <div class="share-option">
                    <h6>{{ isset($allEvent) ? 'Location TBD' : ($event->city ?? 'Location TBD') }}</h6>
                    <p>Venue to be announced {{ isset($allEvent) ? '' : ($event->city ?? '') }}</p>
                    <div style="position: relative; width: 100%; max-width: 600px; height: 300px; overflow: hidden; border-radius: 10px; box-shadow: 0 4px 8px rgba(0,0,0,0.2);">
                        @php
                            $mapLink = isset($allEvent) ? ($allEvent->map_link ?? null) : ($event->map_link ?? null);
                        @endphp

                        @if($mapLink)
                        <iframe 
                            src="{{ $mapLink }}" 
                            width="100%" 
                            height="100%" 
                            style="border:0; pointer-events: none;" 
                            allowfullscreen="" 
                            loading="lazy" 
                            referrerpolicy="no-referrer-when-downgrade">
                        </iframe>

                        <a href="{{ $mapLink }}" 
                        target="_blank" 
                        style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; text-indent: -9999px;">
                        Open Map
                        </a>
                        @else
                            <div style="display:flex;align-items:center;justify-content:center;height:100%;">
                                <p style="color:#666;">Map not available for this event.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Booking Modal -->
<div class="modal fade" id="bookingModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">
            <form id="bookingForm">
                @csrf
                <div class="modal-header bg-gradient-primary text-white border-0">
                    <div class="d-flex align-items-center">
                        <div class="me-3">
                            <i class="fas fa-calendar-check fa-2x"></i>
                        </div>
                        <div>
                            <h5 class="modal-title mb-0 fw-bold">Book Your Event</h5>
                            <small class="opacity-75">Complete your booking details</small>
                        </div>
                    </div>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                
                <div class="modal-body p-4">
                    <input type="hidden" id="event_id" name="event_id">
                    
                    <!-- Event Summary Card -->
                    <div class="event-summary-card mb-4 p-3 bg-light rounded-3 border">
                        <div class="d-flex align-items-center mb-2">
                            <i class="fas fa-star text-warning me-2"></i>
                            <h6 class="mb-0 fw-bold text-primary">Event Details</h6>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <small class="text-muted d-block">Event Name</small>
                                <span class="fw-semibold" id="modalEventName">-</span>
                            </div>
                            <div class="col-6">
                                <small class="text-muted d-block">Date</small>
                                <span class="fw-semibold" id="modalEventDate">-</span>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-6">
                                <small class="text-muted d-block">Location</small>
                                <span class="fw-semibold" id="modalEventLocation">-</span>
                            </div>
                            <div class="col-6">
                                <small class="text-muted d-block">Price per Person</small>
                                <span class="fw-semibold text-success" id="modalEventPrice">-</span>
                            </div>
                        </div>
                    </div>

                    <!-- Contact Information -->
                    <div class="form-group mb-4">
                        <label class="form-label fw-semibold text-dark">
                            <i class="fas fa-phone text-primary me-2"></i>Phone Number
                        </label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0">
                                <i class="fas fa-mobile-alt text-muted"></i>
                            </span>
                            <input type="text" class="form-control border-start-0" id="phone" name="phone" 
                                   maxlength="10" placeholder="Enter 10-digit mobile number" required>
                        </div>
                        <div class="form-text">
                            <i class="fas fa-info-circle text-info me-1"></i>
                            We'll send booking confirmation to this number
                        </div>
                    </div>

                    <!-- Number of Persons -->
                    <div class="form-group mb-4">
                        <label class="form-label fw-semibold text-dark">
                            <i class="fas fa-users text-primary me-2"></i>Number of Persons
                        </label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0">
                                <i class="fas fa-user-friends text-muted"></i>
                            </span>
                            <input type="number" class="form-control border-start-0" id="persons" name="persons" 
                                   min="1" placeholder="How many people?" required>
                            <button type="button" class="btn btn-outline-secondary" id="decreasePersons">
                                <i class="fas fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-outline-secondary" id="increasePersons">
                                <i class="fas fa-plus"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Price Breakdown -->
                    <div class="price-breakdown bg-light rounded-3 p-3 mb-4">
                        <h6 class="fw-semibold text-dark mb-3">
                            <i class="fas fa-receipt text-primary me-2"></i>Price Breakdown
                        </h6>
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="text-muted">Price per person:</span>
                            <span id="pricePerPerson">₹0</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="text-muted">Number of persons:</span>
                            <span id="personsCount">0</span>
                        </div>
                        <hr class="my-2">
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="fw-bold text-dark">Total Amount:</span>
                            <span class="fw-bold text-success fs-5" id="totalPrice">₹0</span>
                        </div>
                    </div>

                    <!-- Additional Info -->
                    <div class="form-group mb-4">
                        <label class="form-label fw-semibold text-dark">
                            <i class="fas fa-comment text-primary me-2"></i>Additional Information (Optional)
                        </label>
                        <textarea class="form-control" id="additional_info" name="additional_info" 
                                  rows="3" placeholder="Any special requirements or notes..."></textarea>
                    </div>
                </div>
                
                <div class="modal-footer bg-light border-0 p-4">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-2"></i>Cancel
                    </button>
                    <button type="submit" class="btn btn-primary btn-lg px-4">
                        <i class="fas fa-credit-card me-2"></i>Proceed to Payment
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

</main>

@endsection
@section('script')
<!-- Add SweetAlert CDN -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    // Initialize Owl Carousel for banner with autoplay
    $('.event-slide .owl-carousel').owlCarousel({
        items: 1,
        loop: true,
        autoplay: true,
        autoplayTimeout: 5000,
        autoplayHoverPause: true,
        smartSpeed: 1000,
        dots: true,
        nav: false,
        animateOut: 'fadeOut',
        animateIn: 'fadeIn'
    });

    // Initialize Owl Carousel for gallery
    $('.gallery-carousal').owlCarousel({
        items: 1,
        loop: true,
        autoplay: true,
        autoplayTimeout: 3000,
        autoplaySpeed: 1000,
        autoplayHoverPause: false,
        smartSpeed: 1000,
        dots: true,
        animateOut: 'fadeOut',
        animateIn: 'fadeIn'
    });

    const bookNowBtn = document.getElementById('bookNowBtn');
    const bookingModal = new bootstrap.Modal(document.getElementById('bookingModal'));
    const eventIdInput = document.getElementById('event_id');
    const personsInput = document.getElementById('persons');
    const phoneInput = document.getElementById('phone');
    const totalPrice = document.getElementById('totalPrice');
    const bookingForm = document.getElementById('bookingForm');
    
    // New modal elements
    const modalEventName = document.getElementById('modalEventName');
    const modalEventDate = document.getElementById('modalEventDate');
    const modalEventLocation = document.getElementById('modalEventLocation');
    const modalEventPrice = document.getElementById('modalEventPrice');
    const pricePerPerson = document.getElementById('pricePerPerson');
    const personsCount = document.getElementById('personsCount');
    const decreasePersons = document.getElementById('decreasePersons');
    const increasePersons = document.getElementById('increasePersons');

    let eventDetails = {}; 

    // Function to save form data to localStorage
    function saveFormData(data) {
        localStorage.setItem('bookingFormData', JSON.stringify(data));
    }

    // Function to load form data from localStorage
    function loadFormData() {
        const savedData = localStorage.getItem('bookingFormData');
        if (savedData) {
            const data = JSON.parse(savedData);
            
            // Restore form fields
            eventIdInput.value = data.event_id || '';
            phoneInput.value = data.phone || '';
            personsInput.value = data.persons || '';
            
            // Update eventDetails
            eventDetails = {
                event_id: data.event_id,
                event_name: data.event_name,
                location: data.location,
                type: data.type,
                event_date: data.event_date,
                amount: parseFloat(data.amount) || 0
            };
            
            // Populate modal details
            populateModalDetails();
            
            // Update price breakdown
            updatePriceBreakdown();
            
            return true;
        }
        return false;
    }

    // Function to clear form data from localStorage
    function clearFormData() {
        localStorage.removeItem('bookingFormData');
    }

    // Check for saved form data on page load
    document.addEventListener('DOMContentLoaded', function() {
        // Check if user just returned from login
        const urlParams = new URLSearchParams(window.location.search);
        if (urlParams.has('redirect') && loadFormData()) {
            // Show the modal with pre-filled data
            setTimeout(() => {
                bookingModal.show();
            }, 500); // Small delay to ensure everything is loaded
        }
    });

    bookNowBtn.addEventListener('click', function () {
        eventDetails = {
            event_id: this.getAttribute('data-event-id'),
            event_name: this.getAttribute('data-event-name') || 'Event',
            location: this.getAttribute('data-location'),
            type: this.getAttribute('data-type'),
            event_date: this.getAttribute('data-event-date'),
            amount: parseFloat(this.getAttribute('data-amount')) || 0
        };

        // First check if user is logged in
        fetch("{{ route('check.login') }}", {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            },
            body: JSON.stringify({ check: true })
        })
        .then(res => {
            if (res.status === 401) {
                // User is not logged in, show SweetAlert
                Swal.fire({
                    title: '<span class="login-popup-title"><span class="wave-icon">👋</span> Hey! You forgot to login</span>',
                    text: '',
                    showCloseButton: true,
                    showCancelButton: false,
                    confirmButtonText: 'Login',
                    customClass: {
                        popup: 'login-popup-custom',
                        confirmButton: 'login-popup-btn',
                        closeButton: 'login-popup-close'
                    },
                    confirmButtonColor: '#1e0d60'
                }).then((result) => {
                    if (result.isConfirmed) {
                        const redirectUrl = encodeURIComponent(window.location.href);
                        window.location.href = "{{ route('login') }}" + '?redirect=' + redirectUrl;
                    } else {
                        // Clear saved data if user cancels
                        clearFormData();
                    }
                });
                throw new Error('Unauthorized');
            }
            if (!res.ok) {
                return res.json().then(errData => {
                    throw new Error(errData.message || `HTTP error! status: ${res.status}`);
                });
            }
            return res.json();
        })
        .then(data => {
            if (data.logged_in) {
                // User is logged in, show the modal
                bookingForm.reset();
                eventIdInput.value = eventDetails.event_id;
                
                // Populate modal with event details
                populateModalDetails();
                
                // Reset price breakdown
                updatePriceBreakdown();
                
                bookingModal.show();
            }
        })
        .catch(error => {
            if (error.message !== 'Unauthorized') {
                console.error('Fetch error:', error);
                toastr.error(error.message || 'Request failed.');
            }
        });
    });

    // Function to update price breakdown
    function updatePriceBreakdown() {
        const persons = parseInt(personsInput.value) || 0;
        const amount = parseFloat(eventDetails.amount) || 0;
        const total = persons * amount;
        
        totalPrice.textContent = `₹${total.toFixed(2)}`;
        pricePerPerson.textContent = `₹${amount.toFixed(2)}`;
        personsCount.textContent = persons;
    }

    // Function to populate modal with event details
    function populateModalDetails() {
        modalEventName.textContent = eventDetails.event_name || 'Event';
        modalEventDate.textContent = eventDetails.event_date || 'TBD';
        modalEventLocation.textContent = eventDetails.location || 'Location TBD';
        modalEventPrice.textContent = `₹${(eventDetails.amount || 0).toFixed(2)}`;
        pricePerPerson.textContent = `₹${(eventDetails.amount || 0).toFixed(2)}`;
    }

    // Plus/Minus button functionality
    decreasePersons.addEventListener('click', function() {
        const currentValue = parseInt(personsInput.value) || 1;
        if (currentValue > 1) {
            personsInput.value = currentValue - 1;
            updatePriceBreakdown();
        }
    });

    increasePersons.addEventListener('click', function() {
        const currentValue = parseInt(personsInput.value) || 0;
        personsInput.value = currentValue + 1;
        updatePriceBreakdown();
    });

    // Update price when persons input changes
    personsInput.addEventListener('input', function () {
        updatePriceBreakdown();
    });

    bookingForm.addEventListener('submit', function (e) {
        e.preventDefault();

        const phone = phoneInput.value.trim();
        const persons = parseInt(personsInput.value);

        if (!phone || phone.length !== 10) {
            toastr.error('Please enter a valid 10-digit phone number');
            return;
        }

        if (isNaN(persons) || persons < 1) {
            toastr.error('Please enter a valid number of persons');
            return;
        }

        const finalData = {
            ...eventDetails,
            phone: phone,
            persons: persons,
            total_price: persons * eventDetails.amount,
            additional_info: document.getElementById('additional_info').value.trim()
        };

        // Save form data to localStorage before making the request
        saveFormData(finalData);

        fetch("{{ route('check.login') }}", {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            },
            body: JSON.stringify(finalData)
        })
        .then(res => {
            if (res.status === 401) {
                // Show SweetAlert for login prompt
                Swal.fire({
                    title: '<span class="login-popup-title"><span class="wave-icon">👋</span> Hey! You forgot to login</span>',
                    text: '',
                    showCloseButton: true,
                    showCancelButton: false,
                    confirmButtonText: 'Login',
                    customClass: {
                        popup: 'login-popup-custom',
                        confirmButton: 'login-popup-btn',
                        closeButton: 'login-popup-close'
                    },
                    confirmButtonColor: '#1e0d60'
                }).then((result) => {
                    if (result.isConfirmed) {
                        const redirectUrl = encodeURIComponent(window.location.href);
                        window.location.href = "{{ route('login') }}" + '?redirect=' + redirectUrl;
                    } else {
                        // Clear saved data if user cancels
                        clearFormData();
                    }
                });
                throw new Error('Unauthorized');
            }
            if (!res.ok) {
                return res.json().then(errData => {
                    throw new Error(errData.message || `HTTP error! status: ${res.status}`);
                });
            }
            return res.json();
        })
        .then(data => {
            if (data.status === 'success') {
                // Clear saved form data on successful booking
                clearFormData();
                toastr.success(data.message || 'Booking saved successfully!');
                bookingModal.hide();
                setTimeout(() => {
                    window.location.href = "{{ route('user.booking.summary') }}";
                }, 1500);
            } else if (data.status === 'failed') {
                // Handle payment failure with retry option
                Swal.fire({
                    title: 'Payment Failed',
                    text: data.message || 'Your payment was not successful. Would you like to retry?',
                    icon: 'error',
                    showCancelButton: true,
                    confirmButtonText: 'Retry Payment',
                    cancelButtonText: 'Cancel',
                    confirmButtonColor: '#dc3545',
                    cancelButtonColor: '#6c757d'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Redirect to retry booking
                        if (data.retry_url) {
                            window.location.href = data.retry_url;
                        } else {
                            // Fallback to booking summary page
                            window.location.href = "{{ route('user.booking.summary') }}";
                        }
                    } else {
                        // User cancelled, show option to go back to event
                        Swal.fire({
                            title: 'Booking Cancelled',
                            text: 'You can try booking again anytime.',
                            icon: 'info',
                            confirmButtonText: 'OK',
                            confirmButtonColor: '#6c757d'
                        });
                    }
                });
            } else {
                toastr.error(data.message || 'Something went wrong.');
            }
        })
        .catch(error => {
            if (error.message !== 'Unauthorized') {
                console.error('Fetch error:', error);
                toastr.error(error.message || 'Request failed.');
            }
        });
    });
});

function copyToClipboard() {
    const eventTitle = `{{ isset($allEvent) ? addslashes($allEvent->heading) : (isset($event) && isset($event->eventDetails) ? addslashes($event->eventDetails->heading) : 'Event') }}`;
    const eventDate = `{{ isset($allEvent) ? ($allEvent->date ?? '') : ($event->starting_date ?? '') }}`;
    const eventLocation = `{{ isset($allEvent) ? ($allEvent->mini_heading ?? '') : ($event->event_mode ?? '') }}`;
    const eventPrice = `{{ isset($allEvent) ? ($allEvent->starting_fees ?? '') : ($event->starting_fees ?? '') }}`;

    const eventDetails = `Check out this event: ${eventTitle}\n\n` +
                        `Date: ${eventDate}\n` +
                        `Location: ${eventLocation}\n` +
                        `Price: ₹${eventPrice}\n\n` +
                        `More details: {{ Request::url() }}`;

    navigator.clipboard.writeText(eventDetails).then(() => {
        const copyMessage = document.getElementById('copyMessage');
        copyMessage.style.display = 'block';
        setTimeout(() => {
            copyMessage.style.display = 'none';
        }, 3000);
    }).catch(err => {
        console.error('Failed to copy text: ', err);
    });
}
</script>

<style>
.share-button {
    display: flex;
    gap: 15px;
    justify-content: center;
    margin-top: 15px;
}

.share-link {
    font-size: 24px;
    color: #666;
    transition: all 0.3s ease;
    text-decoration: none;
    background: none;
    border: none;
    cursor: pointer;
    padding: 0;
}

.share-link:hover {
    transform: translateY(-3px);
}

.share-link.facebook:hover {
    color: #1877f2;
}

.share-link.twitter:hover {
    color: #1da1f2;
}

.share-link.whatsapp:hover {
    color: #25d366;
}

.share-link.instagram:hover {
    color: #e4405f;
}

.share-link.email:hover {
    color: #ea4335;
}

.share-content h2 {
    font-size: 1.5rem;
    color: #333;
    margin-bottom: 15px;
}

.copy-message {
    margin-top: 10px;
    padding: 10px;
    background-color: #f8f9fa;
    border-radius: 5px;
    color: #28a745;
    font-size: 0.9rem;
    text-align: center;
    animation: fadeOut 3s forwards;
}

@keyframes fadeOut {
    0% { opacity: 1; }
    70% { opacity: 1; }
    100% { opacity: 0; }
}
</style>

@endsection