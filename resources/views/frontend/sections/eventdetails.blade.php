@extends('layouts.layout')
@section('styles')
   {{-- <link rel="stylesheet" href="{{ asset('admin/css/styles.css') }}" /> --}}
@endsection
@section('content')

<main class="bg_color">
    <div class="site-main">
        <div class="slider campaign-slider">
            <div class="slide">
                <figure>
                    <img src="assets/images/campaign/01-768x512.jpg" alt="" />
                 </figure>
            </div>
            <div class="slide">
                <figure>
                    <img src="assets/images/campaign/02-768x512.jpg" alt="" />
                 </figure>
                
            </div>
            <div class="slide">
                <figure>
                    <img src="assets/images/campaign/03-768x512.jpg" alt="" />
                 </figure>
                
            </div>
          <div class="slide">
                <figure>
                    <img src="assets/images/campaign/01-768x512.jpg" alt="" />
                 </figure>
            </div>
        </div>

        <div class="campaign-detail-bottom bg-beige">
            <div class="container">
                 <div class="row title-row">
                     <div class="col-md-12">
                         <div class="">
                             <h5>Campaign Name <span><a class="ttm-btn ttm-btn-size-xs ttm-btn-shape-rounded ttm-btn-style-border ttm-btn-color-white pull-right" href="book-appointment.html">Book Now</a></span></h5>
                             <p>Campaign Type</p>
                             
                         </div>
                         
                         <ul>
                             <li>Sat 10 Feb onwards</li>
                             <li><i class="fa fa-map-marker"></i> Multiple Venues</li>
                             <li><b>₹ 400</b> onwards</li>
                         </ul>
                     </div>
                 </div>
                 <div class="row detail-row p-0">
                     <div class="col-lg-3 pl-0">
                         <div class="share-option">
                             <h6>Share this Event</h6>
                             <ul>
                                 <li><a href="">
                                     <i class="fa-brands fa-facebook"></i>
                                 </a></li>
                                 <li><a href="">
                                     <i class="fa-brands fa-twitter"></i>
                                 </a></li>
                             </ul>
                         </div>
                     </div>
                     <div class="col-lg-6">
                         <div class="like-box">
                             <h6>Click on interested to stay update about this event</h6>
                             <div class="like-detail">
                                <h5><i class="fa fa-thumbs-up" aria-hidden="true"></i> 7028 <span class="pull-right"><a href="">Interested</a></span></h5>
                                <p>People have shown interest recently</p>
                             </div>
                         </div>
                         <div class="note-box">
                             <div class="beige-box">
                                  <h5>NOTE</h5>
                                  <p>Reach the venue 30minute prior</p>
                             </div>
                             
                             <div class="about-box">
                                 <h6>About</h6>
                                 <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                                 tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                                 quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
                                 consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
                                 cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
                                 proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
                                 <a href="">Read More</a>
                             </div>
                             <div class="gallery2-box">
                                <h6>Gallery</h6>
                                 <div class="property-container">
                                    <div class="property-wrapper">
                                      <div class="property-slide">
                                        <div class="property-item">
                                          <a href="#">
                                            <div class="property-img">
                                              <img src="https://images.unsplash.com/photo-1519302959554-a75be0afc82a?ixlib=rb-0.3.5&q=85&fm=jpg&crop=entropy&cs=srgb&ixid=eyJhcHBfaWQiOjE0NTg5fQ&s=e21b31e3bddc474a0a13b376d367e2ce" alt="Featured Property" />
                                            </div>
                                          </a>
                                        </div>
                                        <div class="property-item">
                                          <a href="#">
                                            <div class="property-img">
                                              <img src="https://images.unsplash.com/photo-1534479888607-8978e8243743?ixlib=rb-0.3.5&q=85&fm=jpg&crop=entropy&cs=srgb&ixid=eyJhcHBfaWQiOjE0NTg5fQ&s=dcadee71cb7cff203f1497e4ddb97ccb" alt="Featured Property" />
                                            </div>
                                          </a>
                                        </div>
                                        <div class="property-item">
                                          <a href="#">
                                            <div class="property-img">
                                              <img src="https://images.unsplash.com/photo-1525619526717-37cba4c9c8a6?ixlib=rb-0.3.5&q=85&fm=jpg&crop=entropy&cs=srgb&ixid=eyJhcHBfaWQiOjE0NTg5fQ&s=6bf44954af0448e201a664b4b8211c22" alt="Featured Property" />
                                            </div>
                                          </a>
                                        </div>
                                        <div class="property-item">
                                          <a href="#">
                                            <div class="property-img">
                                              <img src="https://images.unsplash.com/photo-1504396463218-15cec8dfd816?ixlib=rb-0.3.5&q=85&fm=jpg&crop=entropy&cs=srgb&ixid=eyJhcHBfaWQiOjE0NTg5fQ&s=8275a6f19d63c736bc4c4cf628137a1b" alt="Featured Property" />
                                            </div>
                                          </a>
                                        </div>
                                        <div class="property-item">
                                          <a href="#">
                                            <div class="property-img">
                                              <img src="https://images.unsplash.com/photo-1519302959554-a75be0afc82a?ixlib=rb-0.3.5&q=85&fm=jpg&crop=entropy&cs=srgb&ixid=eyJhcHBfaWQiOjE0NTg5fQ&s=e21b31e3bddc474a0a13b376d367e2ce" alt="Featured Property" />
                                            </div>
                                          </a>
                                        </div>
                                        <div class="property-item">
                                          <a href="#">
                                            <div class="property-img">
                                              <img src="https://images.unsplash.com/photo-1534479888607-8978e8243743?ixlib=rb-0.3.5&q=85&fm=jpg&crop=entropy&cs=srgb&ixid=eyJhcHBfaWQiOjE0NTg5fQ&s=dcadee71cb7cff203f1497e4ddb97ccb" alt="Featured Property" />
                                            </div>
                                          </a>
                                        </div>
                                        <div class="property-item">
                                          <a href="#">
                                            <div class="property-img">
                                              <img src="https://images.unsplash.com/photo-1525619526717-37cba4c9c8a6?ixlib=rb-0.3.5&q=85&fm=jpg&crop=entropy&cs=srgb&ixid=eyJhcHBfaWQiOjE0NTg5fQ&s=6bf44954af0448e201a664b4b8211c22" alt="Featured Property" />
                                            </div>
                                          </a>
                                        </div>
                                        <div class="property-item">
                                          <a href="#">
                                            <div class="property-img">
                                              <img src="https://images.unsplash.com/photo-1504396463218-15cec8dfd816?ixlib=rb-0.3.5&q=85&fm=jpg&crop=entropy&cs=srgb&ixid=eyJhcHBfaWQiOjE0NTg5fQ&s=8275a6f19d63c736bc4c4cf628137a1b" alt="Featured Property" />
                                            </div>
                                          </a>
                                        </div>
                                      </div>
                                    </div>
                                  </div>

                             </div>
                             <div class="faq-box">
                                 <div class="accordion d-flex flex-column gap-4" id="accordionExample">
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
                     <div class="col-lg-3 pl-0">
                         <div class="share-option">
                             <h6>Kolkata</h6>
                             <p>Venue to be announced Kolkata</p>
                             <div class="map">
                                 <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d235850.81212011125!2d88.18254112599966!3d22.535343439863773!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x39f882db4908f667%3A0x43e330e68f6c2cbc!2sKolkata%2C%20West%20Bengal!5e0!3m2!1sen!2sin!4v1714985138921!5m2!1sen!2sin" width="600" height="250" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                             </div>
                         </div>
                     </div>
                 </div>
            </div>
        </div>
    </div>
</main>

@endsection