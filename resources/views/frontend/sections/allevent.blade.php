@extends('layouts.layout')
@section('styles')
   {{-- <link rel="stylesheet" href="{{ asset('admin/css/styles.css') }}" /> --}}
   <link rel="stylesheet" href="{{ asset('frontend/assets/css/responsive2.css') }}" media="screen and (max-width: 992px)">
   <style>
    /* Banner Slider Styles */
    .hero_single.event-slide {
        position: relative;
        overflow: hidden;
    }
    .hero_single .owl-carousel .item img {
        width: 100%;
        height: auto;
        object-fit: cover;
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
   </style>
@endsection
@section('content')

<main>
  <div class="hero_single event-slide">
    <div class="owl-carousel owl-theme">
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
    </div>
 </div>

<div class="event-information my-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <div class="details-event">
                    <h3>{{ $event->eventDetails->heading }}</h3>
                    <p>{{ $event->event_type }}</p>
                </div>
            </div>
            <div class="col-lg-4 text-end">
                <button class="btn unique-btn" id="bookNowBtn"
                    data-event-id="{{ $event->event_id ?? $event->id }}"
                    data-event-name="{{ $event->eventDetails->heading ?? $event->name ?? 'Event' }}"
                    data-location="{{ $event->city ?? 'Kolkata' }}"
                    data-type="{{ $event->event_mode ?? 'offline' }}"
                    data-event-date="{{ $event->starting_date }}"
                    data-amount="{{ $event->starting_fees }}">
                    Book Now
                </button>
            </div>
        </div>
    </div>
</div>
<hr>
<div class="col-lg-12">
    <div class="event-date" style="text-align: center; display: flex; align-items: center; justify-content: center; gap: 30px;">
        <p>{{ $event->starting_date }} onwards</p>
        <p><i class="fa-solid fa-location-check" style="margin-right: 10px;"></i>{{ $event->event_mode }}</p>
        <p><span>Rs.{{ $event->starting_fees }}</span> onwards</p>
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
                        <a href="https://twitter.com/intent/tweet?text={{ urlencode($event->eventDetails->heading) }}&url={{ urlencode(Request::url()) }}" 
                           target="_blank" 
                           class="share-link twitter">
                            <i class="fa-brands fa-square-x-twitter"></i>
                        </a>
                        <a href="https://api.whatsapp.com/send?text={{ urlencode($event->eventDetails->heading . ' - ' . Request::url()) }}" 
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
                    <p>{{ $event->event_details }}</p>
                </div>
            </div>
            
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
                    <h6>{{ $event->city }}</h6>
                    <p>Venue to be announced {{ $event->city }}</p>
                    <div style="position: relative; width: 100%; max-width: 600px; height: 300px; overflow: hidden; border-radius: 10px; box-shadow: 0 4px 8px rgba(0,0,0,0.2);">
                        <iframe 
                            src="{{ $event->map_link }}" 
                            width="100%" 
                            height="100%" 
                            style="border:0; pointer-events: none;" 
                            allowfullscreen="" 
                            loading="lazy" 
                            referrerpolicy="no-referrer-when-downgrade">
                        </iframe>

                        <a href="{{ $event->map_link }}" 
                        target="_blank" 
                        style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; text-indent: -9999px;">
                        Open Map
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Booking Modal -->
<div class="modal fade" id="bookingModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="bookingForm">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Booking Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="event_id" name="event_id">
                    <div class="mb-3">
                        <label class="form-label">Phone Number</label>
                        <input type="text" class="form-control" id="phone" name="phone" maxlength="10" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Number of Persons</label>
                        <input type="number" class="form-control" id="persons" name="persons" min="1" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Total Price</label>
                        <p id="totalPrice" class="fw-bold">₹0</p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Continue</button>
                </div>
            </form>
        </div>
    </div>
</div>

</main>

@endsection
@section('script')
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

    let eventDetails = {}; 
    bookNowBtn.addEventListener('click', function () {
        eventDetails = {
            event_id: this.getAttribute('data-event-id'),
            event_name: this.getAttribute('data-event-name') || 'Event',
            location: this.getAttribute('data-location'),
            type: this.getAttribute('data-type'),
            event_date: this.getAttribute('data-event-date'),
            amount: parseFloat(this.getAttribute('data-amount')) || 0
        };

        bookingForm.reset();
        eventIdInput.value = eventDetails.event_id;
        totalPrice.textContent = '₹0';
        bookingModal.show();
    });

    personsInput.addEventListener('input', function () {
        const persons = parseInt(this.value) || 0;
        const amount = parseFloat(eventDetails.amount) || 0;
        const total = persons * amount;
        totalPrice.textContent = `₹${total.toFixed(2)}`;
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
            total_price: persons * eventDetails.amount
        };

        fetch("{{ route('user.check.login') }}", {
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
                toastr.error('Please login to continue.');
                const redirectUrl = encodeURIComponent(window.location.href);
                window.location.href = "{{ route('login') }}" + '?redirect=' + redirectUrl;
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
                toastr.success(data.message || 'Booking saved successfully!');
                bookingModal.hide();
                setTimeout(() => {
                    window.location.href = "{{ route('user.booking.summary') }}";
                }, 1500);
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
    const eventDetails = `Check out this event: {{ $event->eventDetails->heading }}\n\n` +
                        `Date: {{ $event->starting_date }}\n` +
                        `Location: {{ $event->event_mode }}\n` +
                        `Price: ₹{{ $event->starting_fees }}\n\n` +
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