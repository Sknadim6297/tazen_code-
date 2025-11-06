@extends('layouts.layout')

@section('styles')
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/booking-sign_up.css') }}">
    <style>
        .success-box {
            background: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            text-align: center;
            margin-top: 50px;
        }
        .success-icon {
            color: #28a745;
            font-size: 50px;
            margin-bottom: 20px;
        }
        .booking-details {
            margin-top: 30px;
            text-align: left;
            padding: 20px;
            background: #f8f9fa;
            border-radius: 8px;
        }
        .booking-details h5 {
            color: #333;
            margin-bottom: 15px;
            border-bottom: 2px solid #28a745;
            padding-bottom: 10px;
        }
        .booking-details ul {
            list-style: none;
            padding: 0;
        }
        .booking-details ul li {
            margin-bottom: 10px;
            padding: 8px 0;
            border-bottom: 1px solid #eee;
        }
        .booking-details ul li strong {
            color: #666;
            min-width: 150px;
            display: inline-block;
        }
        .btn-dashboard {
            margin-top: 20px;
            background: #3399cc;
            color: white;
            padding: 10px 30px;
            border-radius: 5px;
            text-decoration: none;
            transition: all 0.3s;
        }
        .btn-dashboard:hover {
            background: #2980b9;
            text-decoration: none;
            color: white;
        }
    </style>
@endsection

@section('content')
@php
    // Get service name with multiple fallbacks
    $serviceName = 'N/A';
    $subServiceName = null;
    
    // First try from session
    if (session('booking_success.service_name')) {
        $serviceName = session('booking_success.service_name');
    }
    // Then try to get from professional ID if available
    elseif (session('booking_success.professional_id')) {
        $professionalId = session('booking_success.professional_id');
        $professionalService = \App\Models\ProfessionalService::with('service')
            ->where('professional_id', $professionalId)
            ->first();
        
        if ($professionalService) {
            // First try to get from the related Service model
            if ($professionalService->service && $professionalService->service->name) {
                $serviceName = $professionalService->service->name;
            }
            // Fallback to professional service's own service_name
            elseif ($professionalService->service_name) {
                $serviceName = $professionalService->service_name;
            }
        }
    }
    // Final fallback to session
    elseif (session('selected_service_name')) {
        $serviceName = session('selected_service_name');
    }
    
    // Get sub-service name from session if available
    if (session('booking_success.sub_service_name')) {
        $subServiceName = session('booking_success.sub_service_name');
    } elseif (session('booking_success.sub_service_id')) {
        // If sub_service_id exists but not name, fetch from database
        $subService = \App\Models\SubService::find(session('booking_success.sub_service_id'));
        if ($subService) {
            $subServiceName = $subService->name;
        }
    }
@endphp

<main class="bg_gray pattern">
    <div class="container margin_60_40">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="success-box">
                    <div class="success-icon">
                        <i class="icon_check_alt2"></i>
                    </div>
                    <h2>Booking Confirmed!</h2>
                    <p>Your appointment has been successfully booked.</p>

                    <div class="booking-details">
                        <h5>Professional Details</h5>
                        <ul>
                            <li>
                                <strong>Professional Name:</strong>
                                <span>{{ session('booking_success.professional_name') }}</span>
                            </li>
                            <li>
                                <strong>Address:</strong>
                                <span>{{ session('booking_success.professional_address') }}</span>
                            </li>
                            <li>
                                <strong>Service:</strong>
                                <span>{{ $serviceName }}</span>
                            </li>
                            @if($subServiceName)
                            <li>
                                <strong>Sub-Service:</strong>
                                <span>{{ $subServiceName }}</span>
                            </li>
                            @endif
                        </ul>

                        <h5>Booking Information</h5>
                        <ul>
                            <li>
                                <strong>Plan Type:</strong>
                                <span>{{ ucwords(str_replace('_', ' ', session('booking_success.plan_type'))) }}</span>
                            </li>
                            @if(session('booking_success.base_amount') && session('booking_success.cgst'))
                            <li>
                                <strong>Base Amount:</strong>
                                <span>₹{{ number_format(session('booking_success.base_amount'), 2) }}</span>
                            </li>
                            <li>
                                <strong>CGST (9%):</strong>
                                <span>₹{{ number_format(session('booking_success.cgst'), 2) }}</span>
                            </li>
                            <li>
                                <strong>SGST (9%):</strong>
                                <span>₹{{ number_format(session('booking_success.sgst'), 2) }}</span>
                            </li>
                            <li>
                                <strong>IGST (0%):</strong>
                                <span>₹{{ number_format(session('booking_success.igst'), 2) }}</span>
                            </li>
                            @endif
                            <li>
                                <strong>Total Amount Paid (including GST):</strong>
m                                <span>₹{{ number_format(session('booking_success.amount'), 2) }}</span>
                            </li>
                            <li>
                                <strong>Booking Dates:</strong>
                                <ul style="margin-left: 150px;">
                                    @foreach(session('booking_success.bookings') as $booking)
                                        <li style="border: none;">
                                            {{ \Carbon\Carbon::parse($booking['date'])->format('d M Y') }} - 
                                            {{ $booking['time_slot'] }}
                                        </li>
                                    @endforeach
                                </ul>
                            </li>
                        </ul>
                    </div>

                    <div style="margin-top: 30px;">
                        <a href="{{ route('user.upcoming-appointment.index') }}" class="btn-dashboard">
                            View My Appointments
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<!-- MCQ Modal -->
@if(isset($mcqQuestions) && $mcqQuestions->count() > 0)
<div class="modal fade" id="mcqModal" tabindex="-1" aria-labelledby="mcqModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="mcqModalLabel">
                    <i class="fas fa-clipboard-list me-2"></i>Service Questionnaire
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" style="max-height: 500px; overflow-y: auto;">
                <div class="alert alert-info">
                    <i class="fas fa-info-circle me-2"></i>
                    Please complete this questionnaire to help us provide better service tailored to your needs.
                </div>

                <form id="mcqForm">
                    @csrf
                    <input type="hidden" id="service_id" name="service_id" value="{{ $serviceId }}">
                    <input type="hidden" id="booking_id" name="booking_id" value="{{ $bookingId }}">

                    @foreach($mcqQuestions as $index => $question)
                        <div class="mb-4">
                            <h6 class="fw-bold text-primary">Question {{ $index + 1 }}:</h6>
                            <p class="question-text">{{ $question->question }}</p>
                            
                            <div class="options-container">
                                @php
                                    $options = $question->formatted_options;
                                @endphp
                                
                                @foreach($options as $optionKey => $optionValue)
                                    @if(!empty($optionValue))
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="radio" 
                                                   name="answers[{{ $index }}][selected_answer]" 
                                                   id="question_{{ $question->id }}_option_{{ $optionKey }}" 
                                                   value="{{ $optionValue }}" required>
                                            <label class="form-check-label" for="question_{{ $question->id }}_option_{{ $optionKey }}">
                                                <strong>{{ $optionKey }}:</strong> {{ $optionValue }}
                                            </label>
                                        </div>
                                    @endif
                                @endforeach

                                @if($question->has_other_option)
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="radio" 
                                               name="answers[{{ $index }}][selected_answer]" 
                                               id="question_{{ $question->id }}_option_other" 
                                               value="Other" required>
                                        <label class="form-check-label" for="question_{{ $question->id }}_option_other">
                                            <strong>Other:</strong>
                                        </label>
                                        <input type="text" class="form-control mt-2 other-input" 
                                               name="answers[{{ $index }}][other_answer]" 
                                               placeholder="Please specify..." 
                                               style="display: none;">
                                    </div>
                                @endif
                            </div>

                            <!-- Hidden inputs for form submission -->
                            <input type="hidden" name="answers[{{ $index }}][mcq_id]" value="{{ $question->id }}">
                            <input type="hidden" name="answers[{{ $index }}][question]" value="{{ $question->question }}">
                        </div>

                        @if(!$loop->last)
                            <hr>
                        @endif
                    @endforeach
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times me-1"></i>Skip for Now
                </button>
                <button type="button" class="btn btn-primary" id="submitMCQ">
                    <i class="fas fa-paper-plane me-1"></i>Submit Answers
                </button>
            </div>
        </div>
    </div>
</div>

<style>
.question-text {
    background: #f8f9fa;
    padding: 15px;
    border-left: 4px solid #007bff;
    border-radius: 5px;
    margin-bottom: 15px;
}

.options-container {
    padding-left: 20px;
}

.form-check {
    padding: 10px;
    border-radius: 5px;
    transition: background-color 0.2s;
}

.form-check:hover {
    background-color: #f8f9fa;
}

.form-check-input:checked + .form-check-label {
    color: #007bff;
    font-weight: 600;
}

.other-input {
    margin-left: 24px;
    max-width: 300px;
}

.modal-header {
    border-bottom: 3px solid #dee2e6;
}

.modal-footer {
    border-top: 3px solid #dee2e6;
}

#mcqModal .modal-body {
    font-size: 14px;
}

#mcqModal h6 {
    font-size: 16px;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Show MCQ modal automatically after success page loads
    @if(isset($mcqQuestions) && $mcqQuestions->count() > 0)
        setTimeout(function() {
            var mcqModal = new bootstrap.Modal(document.getElementById('mcqModal'));
            mcqModal.show();
        }, 1500); // Show after 1.5 seconds
    @endif

    // Handle "Other" option selection
    document.addEventListener('change', function(e) {
        if (e.target.type === 'radio' && e.target.value === 'Other') {
            const otherInput = e.target.closest('.form-check').querySelector('.other-input');
            if (otherInput) {
                otherInput.style.display = 'block';
                otherInput.required = true;
                otherInput.focus();
            }
        } else if (e.target.type === 'radio' && e.target.value !== 'Other') {
            // Hide other inputs in the same question group
            const questionContainer = e.target.closest('.mb-4');
            const otherInputs = questionContainer.querySelectorAll('.other-input');
            otherInputs.forEach(input => {
                input.style.display = 'none';
                input.required = false;
                input.value = '';
            });
        }
    });

    // Handle MCQ form submission
    document.getElementById('submitMCQ').addEventListener('click', function() {
        const form = document.getElementById('mcqForm');
        const formData = new FormData(form);
        const submitBtn = this;
        
        // Validate form
        const requiredInputs = form.querySelectorAll('input[required]');
        let isValid = true;
        
        requiredInputs.forEach(input => {
            if (!input.value.trim()) {
                isValid = false;
                input.closest('.mb-4').classList.add('border', 'border-danger');
            } else {
                input.closest('.mb-4').classList.remove('border', 'border-danger');
            }
        });

        if (!isValid) {
            alert('Please answer all questions before submitting.');
            return;
        }

        // Show loading state
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i>Submitting...';

        // Convert FormData to JSON
        const answers = [];
        const serviceId = formData.get('service_id');
        const bookingId = formData.get('booking_id');

        @foreach($mcqQuestions as $index => $question)
            const answer{{ $index }} = {
                mcq_id: formData.get('answers[{{ $index }}][mcq_id]'),
                question: formData.get('answers[{{ $index }}][question]'),
                selected_answer: formData.get('answers[{{ $index }}][selected_answer]'),
                other_answer: formData.get('answers[{{ $index }}][other_answer]') || null
            };
            answers.push(answer{{ $index }});
        @endforeach

        // Submit via AJAX
        fetch('{{ route("user.booking.mcq.store") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                service_id: serviceId,
                booking_id: bookingId,
                answers: answers
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                // Show success message and close modal
                alert(data.message);
                bootstrap.Modal.getInstance(document.getElementById('mcqModal')).hide();
            } else {
                throw new Error(data.message || 'Failed to submit answers');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Failed to submit your answers. Please try again.');
        })
        .finally(() => {
            // Reset button state
            submitBtn.disabled = false;
            submitBtn.innerHTML = '<i class="fas fa-paper-plane me-1"></i>Submit Answers';
        });
    });
});
</script>
@endif

@endsection



