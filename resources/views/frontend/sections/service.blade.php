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
                                    <div class="form-group">
                                        <input class="form-control" type="text" placeholder="Chat or Video Call ....">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <input type="submit" id="openPopups" value="Find" onclick="return false;">
                                </div>
                            </div>
                            <!-- /row -->
                            <div class="search_trends new-search_trends">
    <h5>Trending:</h5>
    <ul class="new-ul-list-header">
        @foreach($services->take(4) as $service)
            <li><a href="{{ url('/service/' . $service->id) }}">{{ strtolower($service->name) }}</a></li>
        @endforeach
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
    const serviceId = document.getElementById('service_id').value;

    let questions = [];
    let currentQuestionIndex = 0;
    
    document.querySelectorAll('.service-search-btn').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            console.log('Search button clicked, loading questions');
            loadQuestions();
        });
    });
    

    document.getElementById('openPopups')?.addEventListener('click', function(e) {
        e.preventDefault();
        console.log('Find button clicked, loading questions');
        loadQuestions();
    });
    
    // Function to load questions from API
    function loadQuestions() {
        // Show loading state
        questionsContainer.innerHTML = `
            <div class="text-center py-4">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
                <p class="mt-2">Loading questions...</p>
            </div>
        `;
        
        // Open the modal
        const modal = new bootstrap.Modal(mcqModal);
        modal.show();
        
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        console.log(`Fetching questions for service ID: ${serviceId}`);
        console.log(`CSRF Token: ${csrfToken ? 'Found' : 'Not found'}`);
        
        // Fetch questions from API
        fetch(`/service/${serviceId}/questions`, {
            method: 'GET',
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': csrfToken
            }
        })
        .then(response => {
            console.log("Response status:", response.status);
            console.log("Response headers:", response.headers);
            
            if (!response.ok) {
                return response.text().then(text => {
                    console.error("Error response body:", text);
                    throw new Error('Network response was not ok: ' + response.status);
                });
            }
            
            return response.json().catch(err => {
                console.error("JSON parse error:", err);
                throw new Error('Invalid JSON response');
            });
        })
        .then(data => {
            console.log("Questions data received:", data);
            
            if (data.status === 'success' && data.questions && data.questions.length > 0) {
                questions = data.questions;
                console.log(`Loaded ${questions.length} questions:`, questions);
                
                // Reset to first question
                currentQuestionIndex = 0;
                renderQuestion(0);
            } else {
                console.warn("No questions found or error in response:", data);
                questionsContainer.innerHTML = `
                    <div class="alert alert-warning">
                        <h5>No Questions Available</h5>
                        <p>There are currently no questions set up for this service.</p>
                    </div>
                `;
            }
        })
        .catch(error => {
            console.error("Error fetching questions:", error);
            questionsContainer.innerHTML = `
                <div class="alert alert-danger">
                    <h5>Error Loading Questions</h5>
                    <p>${error.message}</p>
                    <p>Please try refreshing the page.</p>
                </div>
            `;
        });
    }
    
    // Function to render a specific question by index
    function renderQuestion(index) {
        if (!questions || index < 0 || index >= questions.length) {
            console.warn("Invalid question index:", index, "Total questions:", questions.length);
            return;
        }
        
        const question = questions[index];
        currentQuestionIndex = index;
        
        console.log(`Rendering question ${index + 1}/${questions.length}:`, question);
        
      
        questionsContainer.innerHTML = `
            <div class="question-item">
                <h4 class="mb-4">${index + 1}. ${question.question}</h4>
                <div class="options">
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="radio" name="q${question.id}" id="q${question.id}_opt1" value="${question.answer1}">
                        <label class="form-check-label" for="q${question.id}_opt1">${question.answer1}</label>
                    </div>
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="radio" name="q${question.id}" id="q${question.id}_opt2" value="${question.answer2}">
                        <label class="form-check-label" for="q${question.id}_opt2">${question.answer2}</label>
                    </div>
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="radio" name="q${question.id}" id="q${question.id}_opt3" value="${question.answer3}">
                        <label class="form-check-label" for="q${question.id}_opt3">${question.answer3}</label>
                    </div>
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="radio" name="q${question.id}" id="q${question.id}_opt4" value="${question.answer4}">
                        <label class="form-check-label" for="q${question.id}_opt4">${question.answer4}</label>
                    </div>
                </div>
            </div>
        `;
        
        // Update button visibility
        prevBtn.style.display = index > 0 ? 'inline-block' : 'none';
        nextBtn.style.display = index < questions.length - 1 ? 'inline-block' : 'none';
        submitBtn.style.display = index === questions.length - 1 ? 'inline-block' : 'none';
        
        // Update progress bar
        updateProgressBar(index);
    }
    
    // Function to update progress bar
    function updateProgressBar(index) {
        const progress = questions.length > 0 ? Math.round(((index + 1) / questions.length) * 100) : 0;
        progressBar.style.width = `${progress}%`;
        progressBar.setAttribute('aria-valuenow', progress);
        progressBar.textContent = `${progress}%`;
    }
    
    // Event listeners for navigation buttons
    nextBtn.addEventListener('click', function() {
        if (currentQuestionIndex < questions.length - 1) {
            renderQuestion(currentQuestionIndex + 1);
        }
    });
    
    prevBtn.addEventListener('click', function() {
        if (currentQuestionIndex > 0) {
            renderQuestion(currentQuestionIndex - 1);
        }
    });
    
    // Submit answers
    submitBtn.addEventListener('click', function() {
        const answers = [];
        const form = document.getElementById('mcqForm');
        
        questions.forEach(question => {
            const selectedOption = form.querySelector(`input[name="q${question.id}"]:checked`);
            if (selectedOption) {
                answers.push({
                    question_id: question.id,
                    answer: selectedOption.value
                });
            }
        });
        
        // Check if all questions are answered
        if (answers.length < questions.length) {
            alert('Please answer all questions before submitting.');
            return;
        }
        
        console.log("Submitting answers:", answers);
        
        // Submit form data
        const formData = new FormData();
        formData.append('service_id', serviceId);
        formData.append('answers', JSON.stringify(answers));
        formData.append('_token', document.querySelector('input[name="_token"]').value);
        
        fetch('{{ route("submitQuestionnaire") }}', {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
            }
        })
        .then(response => response.json())
        .then(data => {
            console.log("Submission response:", data);
            
            if (data.success) {
                questionsContainer.innerHTML = `
                    <div class="alert alert-success">
                        <h4>Thank you for completing the questionnaire!</h4>
                        <p>You will be redirected to professionals page shortly...</p>
                    </div>
                `;
                
                // Hide navigation buttons
                nextBtn.style.display = 'none';
                prevBtn.style.display = 'none';
                submitBtn.style.display = 'none';
                
                // Redirect after a delay
                setTimeout(() => {
                    window.location.href = "{{ route('professionals') }}";
                }, 2000);
            } else if (data.redirect_to) {
                
                toastr.error('Please log in to continue');
                window.location.href = data.redirect_to;
            } else {
                toastr.error('There was an error submitting your answers. Please try again.');
            }
        })
        .catch(error => {
            console.error('Error submitting questionnaire:', error);
            toastr.error('There was an error submitting your answers. Please try again.');
        });
    });
});
</script>
@endsection