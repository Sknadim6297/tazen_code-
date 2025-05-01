@extends('layouts.layout')
@section('styles')
   {{-- <link rel="stylesheet" href="{{ asset('admin/css/styles.css') }}" /> --}}
@endsection
@section('content')

<main>
    <div class="hero_single event-slide  ">
        {{-- @foreach($event as $item) --}}
        <div class="owl-carousel owl-theme ">
            <div class="item">
                <img src="{{ asset('storage/' . $event->banner_image) }}" alt="" />
            </div>
            <div class="item">
                <img src="{{ asset('storage/' . $event->banner_image) }}" alt="" />
            </div>
            <div class="item">
                <img src="{{ asset('storage/' . $event->banner_image) }}" alt="" />
            </div>
            <div class="item">
                <img src="{{ asset('storage/' . $event->banner_image) }}" alt="" />
            </div> 
        </div>
        {{-- @endforeach --}}
    </div>
    <!-- /error -->
     <div class="event-information my-5">
       
            <div class="container">
                {{-- @foreach($event as $item) --}}
                <div class="row">
                    <div class="col-lg-8">
                        <div class="details-event">
                            <h3>{{ $event->event_name }}</h3>
                            <p>{{ $event->event_type }}</p>
                        </div>
                    </div>
                    <div class="col-lg-4 text-end">
                       <a href="">
                        <button class="btn unique-btn">
                          Book Now
                        </button>
                       </a>
                    </div>
                    <hr>
                    <div class="col-lg-12">
                        <div class="event-date">
                            <p>{{ $event->starting_date }} onwards</p>
                            <p><i class="fa-solid fa-location-check"></i> Multiple Venues</p>
                            <p><span>Rs.{{ $event->starting_fees }}</span> onwards</p>
                        </div>
                    </div>
                </div>
               {{-- @endforeach --}}
             </div>
       
     </div>

     <div class="share-description-map my-5">
        <div class="container">
            <div class="row">
                {{-- @foreach($event as $item) --}}
                <div class="col-lg-3">
                    <div class="share-content">
                        <h2>Share this Event</h2>
                        <div class="share-button text-center">
                            <i class="fa-brands fa-square-facebook"></i>
                            <i class="fa-brands fa-square-x-twitter"></i>
                            <i class="fa-brands fa-square-instagram"></i>
                            <i class="fa-brands fa-square-whatsapp"></i>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                   <div class="first-portion">
                        <h2>Click on interested to stay update about this event</h2>
                        <div class="interest">
                            <div class="like-text d-flex">
                                <div class=" likes d-flex gap-3 align-items-center">
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
                        <p>
                            <!-- Display first 80 words here -->
                            {{-- <span id="short-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Numquam dolorum, soluta quibusdam consequuntur sunt ratione architecto deserunt...</span> --}}
                            <!-- Rest of the text here -->
                            <span id="full-text" style="display: none;">
                                {{ $event->event_details }}
                            </span>
                            <a href="javascript:void(0);" id="read-more">Read More</a>
                        </p>

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
                                        <p>{{$faq->answer1}}
                                        </p>
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
                                        <p>{{$faq->answer2}}
                                        </p>
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
                                        <p>{{$faq->answer3}}
                                        </p>
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
                                        <p>{{$faq->answer4}}
                                        </p>
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
                        <h6>Kolkata</h6>
                        <p>Venue to be announced Kolkata</p>
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
    
</main>

@endsection