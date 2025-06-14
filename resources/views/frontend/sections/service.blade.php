@extends('layouts.layout')

@section('styles')
    {{-- <link rel="stylesheet" href="{{ asset('admin/css/styles.css') }}" /> --}}
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/newslidertwo.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/newsliders.css') }}">
    <style>
        @media (max-width: 767px) {
    .how_2 figure img {
        width: 327px;
    }
}

    .btn-custom{
        background: linear-gradient(135deg, #152a70, #c51010, #f39c12);
        color: white;
        border: none;
    }

    @media (max-width: 991px) {
    .custom-search-input {
        margin-left: 0;
    }
    }
    @media only screen and (min-width: 768px) and (max-width: 1024px) {
    .need-help-service .container .text-center figure::before {
    position: absolute;
    top: 12%;
    right: 188px;
    }

    .services-counter-section-info .container .row .counter-section .card{
        margin-top: 10px;
    }
}

.text{
		color: white;
	}

    </style>
@endsection

@section('content')
<main>
     <div class="hero_single fitness-yoga" style="background-image: url('{{ asset('storage/' . $service->detail->banner_image) }}'); background-size: cover; background-position: center;">
        <div class="opacity-mask" data-opacity-mask="rgba(0, 0, 0, 0.4)">
            <div class="container">
                <div class="row">
                    <div class="col-xl-9 col-lg-10">
                        <h1>{{ $service->detail->banner_heading }}</h1>
                        <p>{{ $service->detail->banner_sub_heading }}</p>
                        <form >
                            <div class="row g-0 custom-search-input">
                              <div class="col-md-9">
    <div class="form-group position-relative search-container">
        <input class="form-control" type="text" id="serviceSearch" placeholder="Find a professional..." autocomplete="off">
        <div id="searchResults" class="position-absolute w-100 mt-1 d-none" style="z-index: 1050;">
            <!-- Search results will appear here -->
        </div>
    </div>
</div>
<div class="col-md-3">
    <input type="submit" id="searchButton" value="Find">
</div>
                            </div>
                            <!-- /row -->
                            {{-- <div class="search_trends new-search_trends">
    <h5>Trending:</h5>
    <ul class="new-ul-list-header">
        @foreach($services->take(4) as $service)
            <li><a href="{{ url('/service/' . $service->id) }}">{{ strtolower($service->name) }}</a></li>
        @endforeach
    </ul>
</div> --}}
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
            <div class="img"></div>

            <div class="inside-question-model">
                <div class="progress-container">
                    <div class="progress-bars" id="progressBar"></div>
                </div>
                <h1 class="text-center" style="font-size: 30px;">what are you looking for ?</h1>

                <form action="" id="progressForm">
                    <div class="step step-3">
                        <div class="question question-1">
                            <label>
                                <input type="checkbox" name="option" value="option-1" required>
                                <span class="text-span">option one</span>
                            </label>
                        </div>

                        <div class="question question-2">
                            <label>
                                <input type="checkbox" name="option" value="option-1" required>
                                <span class="text-span">option two</span>
                            </label>
                        </div>

                        <div class="question question-3">
                            <label>
                                <input type="checkbox" name="option" value="option-1" required>
                                <span class="text-span">option three</span>
                            </label>
                        </div>

                        <div class="question question-3">
                            <label>
                                <input type="checkbox" name="option" value="option-1" required>
                                <span class="text-span">option three</span>
                            </label>
                        </div>

                        <div class="question question-3">
                            <label>
                                <input type="checkbox" name="option" value="option-1" required>
                                <span class="text-span">option three</span>
                            </label>
                        </div>

                        <div class="question question-3">
                            <label>
                                <input type="checkbox" name="option" value="option-1" required>
                                <span class="text-span">option three</span>
                            </label>
                        </div>

                        <div class="question question-3">
                            <label>
                                <input type="checkbox" name="option" value="option-1" required>
                                <span class="text-span">option three</span>
                            </label>
                        </div>

                        <div class="question question-3">
                            <label>
                                <input type="checkbox" name="option" value="option-1" required>
                                <span class="text-span">option three</span>
                            </label>
                        </div>

                        <div class="question question-3">
                            <label>
                                <input type="checkbox" name="option" value="option-1" required>
                                <span class="text-span">option three</span>
                            </label>
                        </div>

                        <div class="question question-3">
                            <label>
                                <input type="checkbox" name="option" value="option-1" required>
                                <span class="text-span">option three</span>
                            </label>
                        </div>

                        <div class="question question-3">
                            <label>
                                <input type="checkbox" name="option" value="option-1" required>
                                <span class="text-span">option three</span>
                            </label>
                        </div>

                        <div class="question question-3">
                            <label>
                                <input type="checkbox" name="option" value="option-1" required>
                                <span class="text-span">option three</span>
                            </label>
                        </div>

                        <div class="question question-3">
                            <label>
                                <input type="checkbox" name="option" value="option-1" required>
                                <span class="text-span">option three</span>
                            </label>
                        </div>

                        <div class="question question-3">
                            <label>
                                <input type="checkbox" name="option" value="option-1" required>
                                <span class="text-span">option three</span>
                            </label>
                        </div>

                        <div class="question question-3">
                            <label>
                                <input type="checkbox" name="option" value="option-1" required>
                                <span class="text-span">option three</span>
                            </label>
                        </div>

                        <div class="question question-3">
                            <label>
                                <input type="checkbox" name="option" value="option-1" required>
                                <span class="text-span">option three</span>
                            </label>
                        </div>

                        <div class="question question-3">
                            <label>
                                <input type="checkbox" name="option" value="option-1" required>
                                <span class="text-span">option three</span>
                            </label>
                        </div>

                        <div class="question question-3">
                            <label>
                                <input type="checkbox" name="option" value="option-1" required>
                                <span class="text-span">option three</span>
                            </label>
                        </div>

                        <div class="question question-3">
                            <label>
                                <input type="checkbox" name="option" value="option-1" required>
                                <span class="text-span">option three</span>
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
                            <button class="btn new-style-form-btn" id="back-control">Back</button>
                        </div>
                        <div class="col-lg-6 text-end two-btn">
                            <button class="btn new-style-form-btn" id="progress-control">Continue</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- /hero_single -->
    
    <div class="bg_gray need-help-service">
        <div class="container margin_60_40">
            <div class="row justify-content-md-center how_2">
                <div class="col-lg-5">
                    <h1>{{ $service->detail->about_heading }}</h1>
                    <p>{{ $service->detail->about_subheading }}</p>
                    <p>{{ $service->detail->about_description }}</p>
                    <p class="add_top_30">
                        <button class="btn_1 service-search-btn" data-service-id="{{ $service->id }}" data-bs-toggle="modal" data-bs-target="#mcqModal">Start Searching</button>
                    </p>
                </div>
                <div class="col-lg-5 text-center">
                    <figure>
                        <img 
                            src="{{ asset('storage/' . $service->detail->about_image) }}" 
                            data-src="{{ asset('storage/' . $service->detail->about_image) }}" 
                            alt="About Image" 
                            class="img-fluid lazy" 
                            width="360" 
                            height="380">
                    </figure>
                </div>
            </div>
            <!-- /row -->
        </div>
        <!-- /container -->
    </div>

    <section class="services-counter-section-info py-5" style="background: url('{{ asset('storage/' . $service->detail->background_image) }}')center center / cover no-repeat;">
        <div class="container my-5">
            <div class="row heading">
                <div class="col">
                    <div class="main_title center">
                        <span><em></em></span>
                        <h2 class="text-white">How does it works?</h2>
                        <p class="text-white">{{ $service->detail->how_it_works_subheading }}</p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6 hero-info">
                    <div class="counter-hero-info">
                        <h1 class="text-white">{{ $service->detail->content_heading }}</h1>
                        <p class="text-white">{{ $service->detail->content_sub_heading }}</p>
                        <p class="add_top_30">
                            <button class="btn_1 service-search-btn" data-service-id="{{ $service->id }}" data-bs-toggle="modal" data-bs-target="#mcqModal">Start Searching</button>
                        </p>
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
                                        <h3>{{ $service->detail->step1_heading }}</h3>
                                        <p>{{ $service->detail->step1_description }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 counter-box">
                                <div class="card widget">
                                    <div class="icon">
                                        <i class="fa-solid fa-circle-2"></i>
                                    </div>
                                    <div class="text-info">
                                        <h3>{{ $service->detail->step2_heading }}</h3>
                                        <p>{{ $service->detail->step2_description }}</p>
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
                                        <h3>{{ $service->detail->step3_heading }}</h3>
                                        <p>{{ $service->detail->step3_description }}</p>
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
   <section style="background-color: #f8f9fa;">
        <div class="container service-container py-5">
            <div class="row heading">
                <div class="col">
                    <div class="main_title center">
                        <span><em></em></span>
                        <h2>Related Services</h2>
                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit.</p>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="owl-carousel services-carousal">
                    @foreach($services as $relatedService)
                        <div class="card">
                            <div 
                                class="card-body" 
                                style="background-image: url('{{ asset($relatedService->image) }}'); background-size: cover; background-position: center; border-radius: .375rem;"
                            ></div>
                            
                            <div class="info mt-3 p-2">
                                <div class="content-discover p-3 d-flex justify-content-between align-items-center">
                                    <div class="l">
                                        <p class="text-dark mb-0">{{ $relatedService->name }}</p>
                                    </div>
                                    <div class="r">
                                        <button class="btn btn-custom" data-bs-toggle="modal" data-bs-target="#mcqModal">Book Now</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
    <!-- /bg_gray -->

    <!-- testimonials slider  -->
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
    
            <div class="row">
                <div class="owl-carousel services-carousal" id="testimonial-carousel">
                    @php
                        $totalSlides = 6; // Total slides to display
                        $testimonialCount = count($testimonials);
                    @endphp
    
                    @for($i = 0; $i < $totalSlides; $i++)
                        <div class="item">
                            <div class="testimonial-box">
                                @php
                                    $isEven = $i % 2 === 0;
                                @endphp
    
                                @if($i < $testimonialCount)
                                    {{-- Real testimonial --}}
                                    @php $t = $testimonials[$i]; @endphp
                                    @if($isEven)
                                        <div class="testimonial-content bg-lavender mb-15">
                                            <p class="text">{{ $t->description }}</p>
                                        </div>
                                        <div class="testimonial-img bg-blue">
                                            <img src="{{ asset('storage/'.$t->image) }}" alt="Testimonial Image" style="width: auto; height: 250px;">
                                        </div>
                                    @else
                                        <div class="testimonial-img bg-pink mb-15">
                                            <img src="{{ asset('storage/'.$t->image) }}" alt="Testimonial Image" style="width: auto; height: 250px;">
                                        </div>
                                        <div class="testimonial-content bg-green">
                                            <p class="text">{{ $t->description }}</p>
                                        </div>
                                    @endif
                                @else
                                    {{-- Dummy testimonial --}}
                                    @if($isEven)
                                        <div class="testimonial-content bg-lavender mb-15">
                                           <p class="text"> This is a sample testimonial. Excellent service and support!</p>
                                        </div>
                                        <div class="testimonial-img bg-blue">
                                            <img src="{{ asset('images/dummy'.($i+1).'.jpg') }}" alt="Dummy Image" style="width: auto; height: 250px;">
                                        </div>
                                    @else
                                        <div class="testimonial-img bg-pink mb-15">
                                            <img src="{{ asset('images/dummy'.($i+1).'.jpg') }}" alt="Dummy Image" style="width: auto; height: 250px;">
                                        </div>
                                        <div class="testimonial-content bg-green">
                                            <p class="text">This is a sample testimonial. Highly recommended!</p>
                                        </div>
                                    @endif
                                @endif
                            </div>
                        </div>
                    @endfor
                </div>
            </div>
        </div>
    </section>
    
    <section class="cta-bg-color-new">
        <div class="call_section version_2 lazy">
            <div class="container clearfix">
                <div class="row">
                    <div class="col-md-6 wow">
                        <img src="{{ asset('frontend/assets/img/are-you-pro.png')}}" alt="">
                    </div>
                    <div class="col-md-6 wow">
                        <div class="box_1">
                            <div class="ribbon_promo"></div>
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

    <!-- MCQ Modal -->
<div class="modal fade" id="mcqModal" tabindex="-1" aria-labelledby="mcqModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="mcqModalLabel">{{ $service->name }} Questions</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="progress mb-3">
                    <div class="progress-bar" role="progressbar" id="questionProgress" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">0%</div>
                </div>
                <form id="mcqForm">
                    @csrf
                    <input type="hidden" name="service_id" id="service_id" value="{{ $service->id }}">
                    <div id="questionsContainer">
                        <div class="text-center py-4">
                            <div class="spinner-border text-primary" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                            <p class="mt-2">Loading questions...</p>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="prevBtn" style="display: none;">Previous</button>
                <button type="button" class="btn btn-primary" id="nextBtn">Next</button>
                <button type="button" class="btn btn-success" id="submitBtn" style="display: none;">Submit</button>
            </div>
        </div>
    </div>
</div>
</main>

<script>
    $(document).ready(function(){
        $("#testimonial-carousel").owlCarousel({
            loop: true,
            margin: 20,
            nav: true,
            dots: true,
            autoplay: true,
            autoplayTimeout: 3000,
            autoplayHoverPause: true,
            items: 4,
            responsive: {
                0: {
                    items: 1
                },
                576: {
                    items: 2
                },
                992: {
                    items: 3
                },
                1200: {
                    items: 4
                }
            }
        });
    });
</script>
@endsection

@section('script')
<script>
document.addEventListener("DOMContentLoaded", function() {
    // Get modal elements
    const mcqModal = document.getElementById('mcqModal');
    const questionsContainer = document.getElementById('questionsContainer');
    const nextBtn = document.getElementById('nextBtn');
    const prevBtn = document.getElementById('prevBtn');
    const submitBtn = document.getElementById('submitBtn');
    const progressBar = document.getElementById('questionProgress');
    
    let questions = [];
    let currentQuestionIndex = 0;
    
    // Handle all service-search-btn and Book Now buttons
    document.querySelectorAll('.service-search-btn, .btn-custom[data-bs-toggle="modal"]').forEach(button => {
        button.addEventListener('click', function(e) {
            // Get service ID from button data attribute or fallback to hidden input
            const serviceId = this.getAttribute('data-service-id') || document.getElementById('service_id').value;
            document.getElementById('service_id').value = serviceId;
            
            // Load questions for this service
            loadQuestions(serviceId);
        });
    });
    
    // Function to load questions from server
    function loadQuestions(serviceId) {
        console.log("Loading questions for service ID:", serviceId);
        
        // Reset container to loading state
        questionsContainer.innerHTML = `
            <div class="text-center py-4">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
                <p class="mt-2">Loading questions...</p>
            </div>
        `;
        
        // Get CSRF token
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
        
        // Make AJAX request
        fetch(`/service/${serviceId}/questions`, {
            method: 'GET',
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': csrfToken
            }
        })
        .then(response => {
            if (!response.ok) {
                throw new Error(`Network response error: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            console.log("Questions data received:", data);
            
            if (data.questions && data.questions.length > 0) {
                questions = data.questions;
                currentQuestionIndex = 0;
                renderQuestion(0);
                updateProgressBar(0);
            } else {
                questionsContainer.innerHTML = `
                    <div class="alert alert-warning">
                        <h5>No Questions Available</h5>
                        <p>There are currently no questions for this service.</p>
                    </div>
                `;
                updateProgressBar(0);
            }
        })
        .catch(error => {
            console.error("Error loading questions:", error);
            
            questionsContainer.innerHTML = `
                <div class="alert alert-danger">
                    <h5>Error Loading Questions</h5>
                    <p>${error.message || 'Failed to load questions. Please try again later.'}</p>
                </div>
            `;
            updateProgressBar(0);
        });
    }
    
    // Function to render a question
    function renderQuestion(index) {
        if (!questions || index < 0 || index >= questions.length) {
            console.warn("Invalid question index:", index, "Total questions:", questions.length);
            return;
        }
        
        const question = questions[index];
        currentQuestionIndex = index;
        
        console.log(`Rendering question ${index + 1}/${questions.length}:`, question);
        
        // Create the question container with modern styling
        questionsContainer.innerHTML = `
            <div class="question-item">
                <div class="question-number badge bg-secondary mb-3">Question ${index + 1} of ${questions.length}</div>
                <h4 class="mb-4 fw-bold">${question.question}</h4>
                <div class="options">
                    ${createOptionElements(question, index)}
                </div>
            </div>
        `;
        
        // Add event listeners to the newly created options
        document.querySelectorAll('.option-card').forEach(card => {
            card.addEventListener('click', function() {
                // Remove active class from all cards
                document.querySelectorAll('.option-card').forEach(c => {
                    c.classList.remove('active');
                });
                
                // Add active class to the clicked card
                this.classList.add('active');
                
                // Check the radio button
                const radio = this.querySelector('input[type="radio"]');
                if (radio) {
                    radio.checked = true;
                }
                
                // Handle "Other" option display
                const value = radio.value;
                const questionId = radio.name.replace('q', '');
                const otherContainer = document.getElementById(`otherContainer${questionId}`);
                
                if (otherContainer) {
                    otherContainer.style.display = value === 'Other' ? 'block' : 'none';
                    if (value === 'Other') {
                        setTimeout(() => {
                            otherContainer.querySelector('input').focus();
                        }, 100);
                    }
                }
                
                // Store answer in session storage
                sessionStorage.setItem(`q${question.id}_answer`, value);
            });
        });
        
        // Check if there's a previously selected option
        const savedAnswer = sessionStorage.getItem(`q${question.id}_answer`);
        if (savedAnswer) {
            const radio = document.querySelector(`input[name="q${question.id}"][value="${savedAnswer}"]`);
            if (radio) {
                radio.checked = true;
                const card = radio.closest('.option-card');
                if (card) {
                    card.classList.add('active');
                }
                
                // Check if it's an "Other" option
                if (savedAnswer === 'Other') {
                    const otherContainer = document.getElementById(`otherContainer${question.id}`);
                    if (otherContainer) {
                        otherContainer.style.display = 'block';
                        const otherValue = sessionStorage.getItem(`q${question.id}_other`);
                        if (otherValue) {
                            otherContainer.querySelector('input').value = otherValue;
                        }
                    }
                }
            }
        }
        
        // Update button visibility
        prevBtn.style.display = index > 0 ? 'inline-block' : 'none';
        nextBtn.style.display = index < questions.length - 1 ? 'inline-block' : 'none';
        submitBtn.style.display = index === questions.length - 1 ? 'inline-block' : 'none';
        
        // Update progress bar
        updateProgressBar(index);
    }
    
    // Create HTML for question options
    function createOptionElements(question, index) {
        let options = '';
        
        // For answer1, answer2, etc. properties
        for (let i = 1; i <= 4; i++) {
            const answerKey = `answer${i}`;
            if (question[answerKey] && question[answerKey].trim() !== '') {
                options += `
                    <div class="option-card mb-3">
                        <div class="d-flex align-items-center">
                            <input class="form-check-input me-3" type="radio" name="q${question.id}" id="q${question.id}_opt${i}" value="${question[answerKey]}">
                            <label class="form-check-label w-100" for="q${question.id}_opt${i}" style="cursor: pointer;">${question[answerKey]}</label>
                        </div>
                        ${question[answerKey] === 'Other' ? createOtherOptionInput(question.id) : ''}
                    </div>
                `;
            }
        }
        
        return options;
    }
    
    // Create HTML for "Other" option input
    function createOtherOptionInput(questionId) {
        return `
            <div id="otherContainer${questionId}" class="mt-2 ps-4" style="display: none;">
                <input type="text" class="form-control" name="q${questionId}_other" placeholder="Please specify..." style="border-radius: 6px;">
            </div>
        `;
    }
    
    // Update the progress bar
    function updateProgressBar(index) {
        const progress = questions.length > 0 ? Math.round(((index + 1) / questions.length) * 100) : 0;
        progressBar.style.width = `${progress}%`;
        progressBar.setAttribute('aria-valuenow', progress);
        progressBar.textContent = `${progress}%`;
    }
    
    // Navigation: Next button click
    nextBtn.addEventListener('click', function() {
        // Validate current question
        const currentQuestion = questions[currentQuestionIndex];
        const selectedOption = document.querySelector(`input[name="q${currentQuestion.id}"]:checked`);
        
        if (!selectedOption) {
            alert('Please select an answer to continue');
            return;
        }
        
        if (currentQuestionIndex < questions.length - 1) {
            renderQuestion(currentQuestionIndex + 1);
        }
    });
    
    // Navigation: Previous button click
    prevBtn.addEventListener('click', function() {
        if (currentQuestionIndex > 0) {
            renderQuestion(currentQuestionIndex - 1);
        }
    });
    
    // Submit answers
    submitBtn.addEventListener('click', function() {
        // Check if all questions are answered
        const unansweredQuestions = [];
        
        questions.forEach((question, idx) => {
            const selectedOption = document.querySelector(`input[name="q${question.id}"]:checked`);
            if (!selectedOption) {
                unansweredQuestions.push(idx + 1);
            }
        });
        
        if (unansweredQuestions.length > 0) {
            alert(`Please answer all questions. Missing answer for question(s): ${unansweredQuestions.join(', ')}`);
            return;
        }
        
        // Collect answers
        const answers = [];
        questions.forEach(question => {
            const selectedOption = document.querySelector(`input[name="q${question.id}"]:checked`);
            if (selectedOption) {
                let value = selectedOption.value;
                
                // Handle "Other" option
                if (value === 'Other') {
                    const otherInput = document.querySelector(`input[name="q${question.id}_other"]`);
                    if (otherInput && otherInput.value.trim()) {
                        value = otherInput.value.trim();
                    }
                }
                
                answers.push({
                    question_id: question.id,
                    answer: value
                });
            }
        });
        
        // Disable submit button and show loading
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span> Submitting...';
        
        // Get CSRF token
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
        
        // Submit answers
        fetch('/submit-questionnaire', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json', 
                'X-CSRF-TOKEN': csrfToken
            },
            body: JSON.stringify({
                service_id: document.getElementById('service_id').value,
                answers: answers
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Clear session storage for this questionnaire
                questions.forEach(question => {
                    sessionStorage.removeItem(`q${question.id}_answer`);
                    sessionStorage.removeItem(`q${question.id}_other`);
                });
                
                // Show success message
                alert(data.message || 'Thank you! Your answers have been submitted successfully.');
                
                // Close modal
                const modalInstance = bootstrap.Modal.getInstance(mcqModal);
                modalInstance.hide();
                
                // Redirect if needed
                if (data.redirect_url) {
                    window.location.href = data.redirect_url;
                }
            } else {
                alert(data.message || 'There was an error submitting your answers. Please try again.');
                submitBtn.disabled = false;
                submitBtn.innerHTML = 'Submit';
            }
        })
        .catch(error => {
            console.error('Error submitting answers:', error);
            alert('There was a problem submitting your answers. Please try again.');
            submitBtn.disabled = false;
            submitBtn.innerHTML = 'Submit';
        });
    });
    
    // Store "Other" input values
    document.addEventListener('input', function(e) {
        if (e.target.name && e.target.name.includes('_other')) {
            const questionId = e.target.name.replace('q', '').replace('_other', '');
            sessionStorage.setItem(`q${questionId}_other`, e.target.value);
        }
    });
});
</script>
<script>
    // Combined Live Search and Find Button functionality
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('serviceSearch');
    const searchResults = document.getElementById('searchResults');
    const searchButton = document.getElementById('searchButton');
    const searchForm = searchInput.closest('form');
    let searchTimeout;
    let currentResults = [];

    // Prevent form submission
    if (searchForm) {
        searchForm.addEventListener('submit', function(e) {
            e.preventDefault();
            handleSearchButtonClick();
        });
    }

    // Find button click event
    searchButton.addEventListener('click', function(e) {
        e.preventDefault();
        handleSearchButtonClick();
    });

    // Function to handle Find button click
    function handleSearchButtonClick() {
        const query = searchInput.value.trim();
        
        if (query.length < 2) {
            toastr.warning('Please enter at least 2 characters to search');
            return;
        }
        
        // If we already have results from typing, use the first result
        if (currentResults.length > 0) {
            window.location.href = `/service/${currentResults[0].id}`;
            return;
        }
        
        // Otherwise, perform a search and navigate to first result
        searchButton.disabled = true;
        searchButton.value = 'Searching...';
        
        fetch(`/search-services?query=${encodeURIComponent(query)}`)
            .then(response => response.json())
            .then(data => {
                searchButton.disabled = false;
                searchButton.value = 'Find';
                
                if (data.services && data.services.length > 0) {
                    // If there's an exact match, go to that
                    const exactMatch = data.services.find(service => 
                        service.name.toLowerCase() === query.toLowerCase());
                    
                    if (exactMatch) {
                        window.location.href = `/service/${exactMatch.id}`;
                    } else {
                        // Otherwise go to first result
                        window.location.href = `/service/${data.services[0].id}`;
                    }
                } else {
                    toastr.error('No matching services found. Please try a different search term.');
                }
            })
            .catch(error => {
                console.error('Error searching:', error);
                searchButton.disabled = false;
                searchButton.value = 'Find';
                toastr.error('An error occurred while searching. Please try again.');
            });
    }

    // Function to fetch search results for the dropdown
    function fetchSearchResults(query) {
        if (query.length < 2) {
            searchResults.classList.add('d-none');
            searchResults.innerHTML = '';
            currentResults = [];
            return;
        }

        fetch(`/search-services?query=${encodeURIComponent(query)}`)
            .then(response => response.json())
            .then(data => {
                // Store results for later use by the Find button
                currentResults = data.services || [];
                
                if (currentResults.length > 0) {
                    // Display search results
                    searchResults.classList.remove('d-none');
                    searchResults.innerHTML = `
                        <div class="list-group shadow">
                            ${currentResults.map(service => `
                                <a href="/service/${service.id}" class="list-group-item list-group-item-action">
                                    ${service.name}
                                </a>
                            `).join('')}
                        </div>
                    `;
                } else {
                    // No results found
                    searchResults.classList.remove('d-none');
                    searchResults.innerHTML = `
                        <div class="list-group shadow">
                            <div class="list-group-item text-muted">No result found</div>
                        </div>
                    `;
                }
                
                // Ensure proper positioning
                searchResults.style.left = '0';
                searchResults.style.right = 'auto';
            })
            .catch(error => {
                console.error('Error fetching search results:', error);
                currentResults = [];
                searchResults.classList.add('d-none');
            });
    }

    // Search input event for live results
    searchInput.addEventListener('input', function() {
        const query = this.value.trim();
        
        // Clear previous timeout
        clearTimeout(searchTimeout);

        // Set new timeout for debounce
        searchTimeout = setTimeout(() => {
            fetchSearchResults(query);
        }, 300);
    });

    // Handle keyboard navigation in search results
    searchInput.addEventListener('keydown', function(e) {
        if (e.key === 'Enter' && !searchResults.classList.contains('d-none')) {
            e.preventDefault();
            
            // Find the first result link and navigate to it
            const firstResult = searchResults.querySelector('.list-group-item');
            if (firstResult && firstResult.href) {
                window.location.href = firstResult.href;
            } else {
                // If no results are visible, trigger the Find button
                handleSearchButtonClick();
            }
        }
    });

    // Hide results when clicking outside
    document.addEventListener('click', function(event) {
        if (!searchInput.contains(event.target) && !searchResults.contains(event.target)) {
            searchResults.classList.add('d-none');
        }
    });

    // Show results when input is focused
    searchInput.addEventListener('focus', function() {
        if (this.value.trim().length >= 2) {
            fetchSearchResults(this.value.trim());
        }
    });
});
</script>
@endsection