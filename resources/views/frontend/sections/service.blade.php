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
                        <button class="btn_1 service-search-btn" data-service-id="{{ $service->id }}" data-bs-toggle="modal" data-bs-target="#mcqModal" style="background: linear-gradient(135deg, #152a70, #c51010, #f39c12);">Start Searching</button>
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
                            <button class="btn_1 service-search-btn" data-service-id="{{ $service->id }}" data-bs-toggle="modal" data-bs-target="#mcqModal" style="background: linear-gradient(135deg, #152a70, #c51010, #f39c12);">Start Searching</button>
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
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener("DOMContentLoaded", function () {
    // Get modal elements
    const questionsContainer = document.getElementById("questionsContainer");
    const nextBtn = document.getElementById("nextBtn");
    const prevBtn = document.getElementById("prevBtn");
    const submitBtn = document.getElementById("submitBtn");
    const form = document.getElementById("mcqForm");
    const serviceIdInput = document.getElementById("service_id");
    const modalCloseBtn = document.querySelector("#mcqModal .btn-close");
    const cancelBtn = document.querySelector("#mcqModal .btn-secondary");

    let currentQuestion = 0;
    let questions = [];
    
    // Enhance modal design
    styleModalForModernLook();

    // Handle all service-search-btn and Book Now buttons
    document.querySelectorAll('.service-search-btn, .btn-custom[data-bs-toggle="modal"]').forEach(button => {
        button.addEventListener('click', function(e) {
            // Get service ID from button data attribute or fallback to hidden input
            const serviceId = this.getAttribute('data-service-id') || document.getElementById('service_id').value;
            document.getElementById('service_id').value = serviceId;
            
            // Check if user is logged in
            checkLoginStatus(serviceId);
        });
    });
    
    // Check if user is logged in before showing modal
    function checkLoginStatus(serviceId) {
        fetch('/check-auth-status')
            .then(response => response.json())
            .then(data => {
                if (data.authenticated) {
                    // User is logged in, proceed with loading questions
                    $('#mcqModal').modal('show');
                    loadQuestions(serviceId);
                } else {
                    // User is not logged in, show message and redirect
                    Swal.fire({
                        title: 'Authentication Required',
                        text: 'Please login to book this service',
                        icon: 'info',
                        showCancelButton: true,
                        confirmButtonText: 'Login Now',
                        cancelButtonText: 'Cancel',
                        customClass: {
                            confirmButton: 'btn btn-primary',
                            cancelButton: 'btn btn-secondary'
                        }
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Redirect to login page with return URL to come back to this page
                            window.location.href = `/login?redirect=${encodeURIComponent(window.location.pathname)}`;
                        }
                    });
                }
            })
            .catch(error => {
                console.error('Error checking authentication status:', error);
                Swal.fire('Error', 'An error occurred. Please try again.', 'error');
            });
    }

    // Handle confirmation when closing the modal
    function handleModalClose(e) {
        e.preventDefault();
        
        if (questions.length > 0) {
            // Show confirmation dialog with standard confirm
            if (confirm('Your progress will be lost if you cancel now. Are you sure?')) {
                // Reset and close modal
                resetModal();
                $('#mcqModal').modal('hide');
            }
        } else {
            // No questions loaded yet, just close
            $('#mcqModal').modal('hide');
        }
    }
    
    // Reset modal state
    function resetModal() {
        questions = [];
        currentQuestion = 0;
        questionsContainer.innerHTML = '';
        prevBtn.style.display = 'none';
        nextBtn.style.display = 'inline-block';
        submitBtn.style.display = 'none';
    }
    
    // Apply modern styling to modal
    function styleModalForModernLook() {
        const modal = document.getElementById('mcqModal');
        if (!modal) return;
        
        const modalDialog = modal.querySelector('.modal-dialog');
        const modalContent = modal.querySelector('.modal-content');
        const modalHeader = modal.querySelector('.modal-header');
        const modalTitle = modal.querySelector('.modal-title');
        const modalBody = modal.querySelector('.modal-body');
        const modalFooter = modal.querySelector('.modal-footer');
        
        // Add modern styling classes
        if (modalDialog) modalDialog.classList.add('modal-dialog-centered');
        if (modalContent) {
            modalContent.style.borderRadius = '12px';
            modalContent.style.boxShadow = '0 15px 35px rgba(50, 50, 93, 0.1), 0 5px 15px rgba(0, 0, 0, 0.07)';
            modalContent.style.border = 'none';
        }
        
        if (modalHeader) {
            modalHeader.style.borderBottom = '1px solid rgba(0,0,0,0.05)';
            modalHeader.style.background = 'linear-gradient(135deg, #f8f9fa, #ffffff)';
            modalHeader.style.borderTopLeftRadius = '12px';
            modalHeader.style.borderTopRightRadius = '12px';
            modalHeader.style.padding = '20px 24px';
        }
        
        if (modalTitle) {
            modalTitle.style.fontSize = '1.25rem';
            modalTitle.style.fontWeight = '600';
        }
        
        if (modalBody) {
            modalBody.style.padding = '24px';
        }
        
        if (modalFooter) {
            modalFooter.style.borderTop = '1px solid rgba(0,0,0,0.05)';
            modalFooter.style.padding = '16px 24px';
        }
        
        // Style the buttons
        const buttons = modal.querySelectorAll('.modal-footer .btn');
        buttons.forEach(button => {
            button.style.borderRadius = '6px';
            button.style.padding = '8px 16px';
            button.style.fontWeight = '500';
            button.style.transition = 'all 0.2s ease';
        });
        
        // Style primary buttons
        const primaryButtons = modal.querySelectorAll('.btn-primary');
        primaryButtons.forEach(button => {
            button.style.background = 'linear-gradient(135deg, #152a70, #c51010, #f39c12)';
            button.style.borderColor = 'transparent';
        });
        
        // Style success button
        const successButton = modal.querySelector('.btn-success');
        if (successButton) {
            successButton.style.background = 'linear-gradient(135deg, #28a745, #20c997)';
            successButton.style.borderColor = 'transparent';
        }
    }

    function loadQuestions(serviceId) {
        // Show loading state
        questionsContainer.innerHTML = '<div class="text-center py-4"><div class="spinner-border text-primary" role="status"></div><p class="mt-3">Loading questions...</p></div>';
        
        fetch(`/service/${serviceId}/questions`)
            .then(response => response.json())
            .then(data => {
                console.log("Questions data:", data);
                if (data.status === 'success' && Array.isArray(data.questions) && data.questions.length > 0) {
                    questions = data.questions;
                    currentQuestion = 0;
                    renderQuestions();
                    showQuestion(0);
                } else {
                    questionsContainer.innerHTML = '<div class="alert alert-warning my-3"><i class="fas fa-exclamation-circle me-2"></i>No questions available for this service. Please try another service or contact support.</div>';
                    console.error("No questions found in response:", data);
                }
            })
            .catch(error => {
                questionsContainer.innerHTML = '<div class="alert alert-danger my-3"><i class="fas fa-exclamation-circle me-2"></i>Failed to load questions. Please try again.</div>';
                console.error('Error loading questions:', error);
                alert('Failed to load questions. Please try again.');
            });
    }

    function renderQuestions() {
        questionsContainer.innerHTML = '';
        
        questions.forEach((question, index) => {
            const questionDiv = document.createElement('div');
            questionDiv.className = 'question';
            questionDiv.id = `question${index}`; // Changed from question.id to index
            questionDiv.style.display = 'none';
            
            // Question number indicator
            const questionProgress = document.createElement('div');
            questionProgress.className = 'question-progress mb-3';
            questionProgress.innerHTML = `<span class="badge bg-primary">Question ${index + 1} of ${questions.length}</span>`;
            questionDiv.appendChild(questionProgress);
            
            // Question heading
            const heading = document.createElement('h6');
            heading.className = 'mb-3 fw-bold';
            heading.textContent = question.question || 'Question not available';
            questionDiv.appendChild(heading);
            
            // Create input based on question type
            if (question.question_type === 'text') {
                // Text input
                const formGroup = document.createElement('div');
                formGroup.className = 'form-group mt-4';
                
                const input = document.createElement('input');
                input.type = 'text';
                input.className = 'form-control form-control-lg';
                input.name = `q${index}`; // Changed from question.id to index
                input.required = true;
                input.placeholder = 'Type your answer here...';
                input.style.borderRadius = '8px';
                input.style.padding = '12px';
                input.style.boxShadow = '0 1px 3px rgba(0,0,0,0.1)';
                
                formGroup.appendChild(input);
                questionDiv.appendChild(formGroup);
            } else {
                // Radio options
                const optionsContainer = document.createElement('div');
                optionsContainer.className = 'options-container mt-4';
                
                // Handle various option data structures
                let options = [];
                
                // Check if options is an array directly
                if (Array.isArray(question.options)) {
                    options = question.options;
                } 
                // Check for legacy format with answer1, answer2, etc.
                else {
                    for (let i = 1; i <= 6; i++) {
                        const answerKey = `answer${i}`;
                        if (question[answerKey] && question[answerKey].trim() !== '') {
                            options.push(question[answerKey]);
                        }
                    }
                }
                
                // If no options were found, add a message
                if (options.length === 0) {
                    const noOptionsMsg = document.createElement('div');
                    noOptionsMsg.className = 'alert alert-warning';
                    noOptionsMsg.textContent = 'No options available for this question.';
                    optionsContainer.appendChild(noOptionsMsg);
                }
                
                // Create option elements
                options.forEach((option, optIndex) => {
                    if (!option) return; // Skip empty options
                    
                    const formCheck = document.createElement('div');
                    formCheck.className = 'form-check mb-3';
                    formCheck.style.backgroundColor = '#f8f9fa';
                    formCheck.style.borderRadius = '8px';
                    formCheck.style.padding = '10px 15px 10px 41px';
                    formCheck.style.border = '1px solid #e9ecef';
                    formCheck.style.transition = 'all 0.2s ease';
                    formCheck.style.cursor = 'pointer';
                    formCheck.style.position = 'relative';
                    
                    const radio = document.createElement('input');
                    radio.className = 'form-check-input me-2';
                    radio.type = 'radio';
                    radio.name = `q${index}`; // Changed from question.id to index
                    radio.id = `q${index}opt${optIndex}`;
                    radio.value = option;
                    radio.required = true;
                    radio.style.position = 'absolute';
                    radio.style.left = '15px';
                    radio.style.top = '50%';
                    radio.style.transform = 'translateY(-50%)';
                    
                    const label = document.createElement('label');
                    label.className = 'form-check-label';
                    label.htmlFor = `q${index}opt${optIndex}`;
                    label.textContent = option;
                    label.style.display = 'block';
                    label.style.marginLeft = '10px';
                    label.style.cursor = 'pointer';
                    
                    // Highlight selected option
                    radio.addEventListener('change', function() {
                        // Reset all options
                        optionsContainer.querySelectorAll('.form-check').forEach(el => {
                            el.style.backgroundColor = '#f8f9fa';
                            el.style.borderColor = '#e9ecef';
                        });
                        
                        // Highlight selected
                        if (this.checked) {
                            formCheck.style.backgroundColor = '#e8f4ff';
                            formCheck.style.borderColor = '#2196f3';
                        }
                    });
                    
                    formCheck.appendChild(radio);
                    formCheck.appendChild(label);
                    
                    // Add "Other" text field if this option is "Other"
                    if (option === 'Other') {
                        radio.addEventListener('change', function() {
                            const otherInputContainer = document.getElementById(`otherContainer${index}`);
                            if (this.checked && otherInputContainer) {
                                otherInputContainer.style.display = 'block';
                                otherInputContainer.querySelector('input').required = true;
                                otherInputContainer.querySelector('input').focus();
                            } else if (otherInputContainer) {
                                otherInputContainer.style.display = 'none';
                                otherInputContainer.querySelector('input').required = false;
                            }
                        });
                        
                        const otherContainer = document.createElement('div');
                        otherContainer.id = `otherContainer${index}`;
                        otherContainer.className = 'mt-2 ps-4';
                        otherContainer.style.display = 'none';
                        
                        const otherInput = document.createElement('input');
                        otherInput.type = 'text';
                        otherInput.className = 'form-control';
                        otherInput.name = `q${index}_other`;
                        otherInput.placeholder = 'Please specify...';
                        otherInput.style.borderRadius = '6px';
                        
                        otherContainer.appendChild(otherInput);
                        formCheck.appendChild(otherContainer);
                    }
                    
                    // Make entire option div clickable
                    formCheck.addEventListener('click', function(e) {
                        if (e.target !== radio) {
                            radio.checked = true;
                            radio.dispatchEvent(new Event('change'));
                        }
                    });
                    
                    optionsContainer.appendChild(formCheck);
                });
                
                questionDiv.appendChild(optionsContainer);
            }
            
            questionDiv.appendChild(document.createElement('hr'));
            
            questionsContainer.appendChild(questionDiv);
        });
        
        // If no questions were rendered, show a message
        if (questionsContainer.children.length === 0) {
            questionsContainer.innerHTML = '<div class="alert alert-warning my-3">No questions found for this service.</div>';
        }
    }

    function showQuestion(index) {
        // Validate index
        if (index < 0 || index >= questions.length || !questions[index]) {
            console.error('Invalid question index:', index, 'Questions:', questions);
            return;
        }
        
        // Hide all questions
        document.querySelectorAll('.question').forEach(question => {
            question.style.display = 'none';
        });
        
        // Show the current question
        const currentQuestionElement = document.getElementById(`question${index}`);
        if (currentQuestionElement) {
            currentQuestionElement.style.display = 'block';
        } else {
            console.error(`Question element with id question${index} not found`);
            return;
        }
        
        // Update navigation buttons
        prevBtn.style.display = index > 0 ? "inline-block" : "none";
        nextBtn.style.display = index < questions.length - 1 ? "inline-block" : "none";
        submitBtn.style.display = index === questions.length - 1 ? "inline-block" : "none";
    }

    // Navigation buttons event listeners
    nextBtn.addEventListener("click", function () {
        // Validate current question
        const currentQuestionElement = document.getElementById(`question${currentQuestion}`);
        if (!currentQuestionElement) return;
        
        const inputs = currentQuestionElement.querySelectorAll('input[required]');
        let isValid = true;
        
        inputs.forEach(input => {
            if ((input.type === 'radio' && !document.querySelector(`input[name="${input.name}"]:checked`)) ||
                (input.type === 'text' && !input.value.trim())) {
                isValid = false;
            }
        });
        
        if (!isValid) {
            alert('Please answer the question before proceeding.');
            return;
        }
        
        if (currentQuestion < questions.length - 1) {
            currentQuestion++;
            showQuestion(currentQuestion);
        }
    });

    prevBtn.addEventListener("click", function () {
        if (currentQuestion > 0) {
            currentQuestion--;
            showQuestion(currentQuestion);
        }
    });

    // Submit button event listener
    submitBtn.addEventListener("click", function() {
        // Validate last question
        const lastQuestionElement = document.getElementById(`question${currentQuestion}`);
        if (!lastQuestionElement) return;
        
        const inputs = lastQuestionElement.querySelectorAll('input[required]');
        let isValid = true;
        
        inputs.forEach(input => {
            if ((input.type === 'radio' && !document.querySelector(`input[name="${input.name}"]:checked`)) ||
                (input.type === 'text' && !input.value.trim())) {
                isValid = false;
            }
        });
        
        if (!isValid) {
            Swal.fire({
                icon: 'warning',
                title: 'Please Answer',
                text: 'Please answer the question before submitting.'
            });
            return;
        }
        
        // Create FormData and collect answers
        const formData = new FormData(form);
        const answers = [];
        
        // Collect all answers
        questions.forEach((question, index) => {
            if (question.question_type === 'text') {
                const textInput = document.querySelector(`input[name="q${index}"]`);
                if (textInput && textInput.value.trim()) {
                    answers.push({
                        question_id: question.id,
                        question: question.question,
                        answer: textInput.value.trim()
                    });
                }
            } else {
                const selectedOption = document.querySelector(`input[name="q${index}"]:checked`);
                if (selectedOption) {
                    let answer = selectedOption.value;
                    
                    // If "Other" is selected, get the other input value
                    if (answer === 'Other') {
                        const otherInput = document.querySelector(`input[name="q${index}_other"]`);
                        if (otherInput && otherInput.value.trim()) {
                            answer = otherInput.value.trim();
                        }
                    }
                    
                    answers.push({
                        question_id: question.id,
                        question: question.question,
                        answer: answer
                    });
                }
            }
        });
        
        // Add answers to FormData
        formData.append('answers', JSON.stringify(answers));
        
        // Set the submit button to loading state
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Submitting...';
        
        // Submit using fetch API
        fetch('/submit-questionnaire', {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json'
            }
        })
        .then(response => {
            if (!response.ok) {
                return response.json().then(data => Promise.reject(data));
            }
            return response.json();
        })
        .then(data => {
            // Show success message
            Swal.fire({
                icon: 'success',
                title: 'Thank You!',
                text: 'Your questionnaire has been submitted successfully.',
                confirmButtonText: 'Find Professionals'
            }).then(() => {
                // Redirect to professionals page with service ID
                window.location.href = `/professionals?service_id=${serviceIdInput.value}`;
            });
            
            // Reset modal
            resetModal();
            $('#mcqModal').modal('hide');
        })
        .catch(error => {
            console.error('Submission error:', error);
            submitBtn.disabled = false;
            submitBtn.innerHTML = 'Submit';
            
            Swal.fire({
                icon: 'error',
                title: 'Submission Failed',
                text: error.message || 'Something went wrong. Please try again.'
            });
        });
    });
    
    // Add event listeners to close buttons
    if (modalCloseBtn) {
        modalCloseBtn.addEventListener('click', handleModalClose);
    }
    
    if (cancelBtn) {
        cancelBtn.addEventListener('click', handleModalClose);
    }
});
</script>

<!-- Add search scripts here if needed -->
@endsection