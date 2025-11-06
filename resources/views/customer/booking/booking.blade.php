@extends('layouts.layout')

@section('styles')
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/booking-sign_up.css') }}" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <style>
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
<main class="bg_gray pattern">
    <!-- Loading overlay -->
    <div class="loading-overlay" id="loadingOverlay">
        <div class="loading-spinner"></div>
    </div>
    
    <div class="container margin_60_40">
        <div class="row justify-content-center">
            <div class="col-lg-4">
                <div class="box_booking_2">
                    @if(session()->has('booking_data'))
                        @php
                            $bookingData = session('booking_data');
                            $professionalId = $bookingData['professional_id'] ?? null;
                            $professional = \App\Models\Professional::with('profile')->where('id', $professionalId)->first();
                            
                            // Get the professional's service information
                            $professionalService = null;
                            $serviceName = 'N/A';
                            $subServiceName = null;
                            
                            if ($professional) {
                                // Try to get professional service with relationship
                                $professionalService = \App\Models\ProfessionalService::with('service')
                                    ->where('professional_id', $professional->id)
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
                            
                            // Final fallback to session if nothing found
                            if ($serviceName === 'N/A') {
                                $serviceName = session('selected_service_name') ?? 'N/A';
                            }
                            
                            // Get sub-service name from booking_data session
                            if (!empty($bookingData['sub_service_name'])) {
                                $subServiceName = $bookingData['sub_service_name'];
                            } elseif (!empty($bookingData['sub_service_id'])) {
                                // If sub_service_id exists but not name, fetch from database
                                $subService = \App\Models\SubService::find($bookingData['sub_service_id']);
                                if ($subService) {
                                    $subServiceName = $subService->name;
                                }
                            } else {
                                // Fallback to session
                                $subServiceName = session('selected_sub_service_name');
                            }
                        @endphp

                        <div class="head">
                            <div class="title">
                                <h3>{{ Auth::guard('user')->user()->name ?? 'N/A' }}</h3>
                                {{ Auth::guard('user')->user()->email ?? 'N/A' }}</a>
                            </div>
                        </div>

                        <div class="main">
                            <h6 style="text-align: center">Booking Summary</h6>
                            <ul>
                                @if(!empty($bookingData['bookings']))
                                    <li><strong>Date & Time:</strong>
                                        <ul>
                                            @foreach($bookingData['bookings'] as $booking)
                                                <li>{{ \Carbon\Carbon::parse($booking['date'])->format('d/m/y') }} - {{ $booking['time_slot'] ?? 'N/A' }}</li>
                                            @endforeach
                                        </ul>
                                    </li>
                                @else
                                    <li>No bookings found.</li>
                                @endif
                                <hr>
                                <li>Service name: <span>{{ $serviceName }}</span></li>
                                @if(isset($subServiceName) && !empty($subServiceName))
                                    <li>Sub-service: <span>{{ $subServiceName }}</span></li>
                                @endif
                                <li>Plan type: <span>{{ isset($bookingData['plan_type']) ? ucwords(str_replace('_', ' ', $bookingData['plan_type'])) : 'N/A' }}</span></li>
                                <li>Type: <span>Appointment</span></li>
                                @php
                                    $baseAmount = $bookingData['total_amount'] ?? 0;
                                    $cgst = $baseAmount * 0.09; // 9% CGST
                                    $sgst = $baseAmount * 0.09; // 9% SGST  
                                    $igst = 0; // 0% IGST (since CGST+SGST are applied)
                                    $totalWithGst = $baseAmount + $cgst + $sgst + $igst;
                                @endphp
                                <li>Base Amount: <span>₹{{ number_format($baseAmount, 2) }}</span></li>
                                <li>CGST (9%): <span>₹{{ number_format($cgst, 2) }}</span></li>
                                <li>SGST (9%): <span>₹{{ number_format($sgst, 2) }}</span></li>
                                <li>IGST (0%): <span>₹{{ number_format($igst, 2) }}</span></li>
                                <hr>
                                <li><strong>Total Amount (including GST): <span>₹{{ number_format($totalWithGst, 2) }}</span></strong></li>
                                <li>Professional name: <span>{{ $professional['name'] ?? 'Booking Details' }}</span></li>
                                <li>Professional Address: <span>{{ $professional->profile->address ?? 'Booking Address is not available' }}</span></li>
                            </ul>
                            <hr>
                            <h6>Enter contact number for the booking</h6>
                            <div class="form-group add_bottom_15">
                                <input type="tel" class="form-control" id="phone" name="phone" placeholder="Phone" maxlength="10" pattern="\d{10}" autocomplete="tel" oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 10)">
                                <i class="icon_phone"></i>
                            </div>

                            <a href="javascript:void(0);" class="btn_1 full-width mb_5 booking">Book Now</a>
                            <a href="{{ route('user.reset-booking') }}" class="btn_1 full-width outline mb_25">Change Booking</a>
                        </div>
                    @else
                        <div class="main text-center">
                            <h6>No booking data available</h6>
                            <p class="text-muted mb-4">You need to select a service and professional before you can proceed with booking.</p>
                            <div class="d-flex flex-column gap-2">
                                <a href="{{ route('home') }}" class="btn btn-primary">
                                    <i class="fa fa-search"></i> Browse Services
                                </a>
                                <a href="{{ route('professionals') }}" class="btn btn-outline-primary">
                                    <i class="fa fa-users"></i> View Professionals
                                </a>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</main>
@endsection

@section('script')
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    // Check if booking elements exist before initializing
    const bookingBtn = document.querySelector('.booking');
    const csrfToken = document.querySelector('meta[name="csrf-token"]');
    
    if (!bookingBtn || !csrfToken) {
        console.log('Booking elements not found - user may not have booking data');
        return;
    }
    
    const csrfTokenValue = csrfToken.getAttribute('content');

    if (bookingBtn) {
        bookingBtn.addEventListener('click', function (e) {
            e.preventDefault();

            const phoneElement = document.getElementById('phone');
            if (!phoneElement) {
                console.error('Phone input element not found');
                return;
            }
            
            const phone = phoneElement.value;

            if (!phone || phone.length !== 10) {
                if (typeof toastr !== 'undefined') {
                    toastr.warning('Please enter a valid 10-digit phone number.');
                } else {
                    alert('Please enter a valid 10-digit phone number.');
                }
                return;
            }

            // Show loading state on button
            const originalText = bookingBtn.innerHTML;
            bookingBtn.innerHTML = '<i class="fa fa-spinner fa-spin"></i> Processing...';
            bookingBtn.disabled = true;

            // First, initiate payment
            fetch("{{ route('user.booking.initiate-payment') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfTokenValue,
                    'Accept': 'application/json',
                },
                body: JSON.stringify({ phone: phone })
            })
            .then(res => res.json())
            .then(data => {
                if (data.status === 'success') {
                    // Reset button before showing Razorpay
                    bookingBtn.innerHTML = originalText;
                    bookingBtn.disabled = false;
                    
                    // Initialize Razorpay
                    const options = {
                        key: data.key,
                        amount: data.amount,
                        currency: "INR",
                        name: "Tazen",
                        description: "Booking Payment",
                        order_id: data.order_id,
                        handler: function (response) {
                            console.debug('PAYMENT: Razorpay payment handler called', response);
                            
                            // Show immediate loader when payment succeeds
                            Swal.fire({
                                title: 'Payment Successful!',
                                text: 'Processing your booking...',
                                icon: 'success',
                                allowOutsideClick: false,
                                allowEscapeKey: false,
                                showConfirmButton: false,
                                showClass: {
                                    popup: 'animate__animated animate__fadeInDown animate__faster'
                                },
                                didOpen: () => {
                                    Swal.showLoading();
                                }
                            });
                            
                            console.debug('PAYMENT: Starting payment verification...');
                            
                            // Verify payment
                            fetch("{{ route('user.booking.verify-payment') }}", {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': csrfTokenValue,
                                    'Accept': 'application/json',
                                },
                                body: JSON.stringify({
                                    razorpay_payment_id: response.razorpay_payment_id,
                                    razorpay_order_id: response.razorpay_order_id,
                                    razorpay_signature: response.razorpay_signature
                                })
                            })
                            .then(res => {
                                console.debug('PAYMENT: Raw verification response:', res);
                                return res.json();
                            })
                            .then(data => {
                                console.debug('PAYMENT: Payment verification response:', data);
                                if (data.status === 'success') {
                                    console.debug('PAYMENT: Verification successful, checking MCQ questions...');
                                    console.debug('PAYMENT: Response data:', JSON.stringify(data));
                                    
                                    // Important: Close the payment processing loader first
                                    Swal.close();
                                    
                                    // Wait a brief moment before starting MCQ flow to ensure clean state
                                    setTimeout(() => {
                                        try {
                                            // Check for MCQ questions after successful payment
                                            checkAndShowMCQQuestions(data);
                                        } catch (mcqError) {
                                            console.error('PAYMENT: MCQ check failed, using emergency fallback:', mcqError);
                                            // Emergency fallback - show success modal then redirect
                                            Swal.fire({
                                                title: 'Booking Confirmed!',
                                                text: 'Your payment was successful and booking is confirmed.',
                                                icon: 'success',
                                                timer: 3000,
                                                timerProgressBar: true,
                                                allowOutsideClick: false,
                                                showConfirmButton: false
                                            }).then(() => {
                                                console.debug('PAYMENT: Emergency redirect to:', data.redirect_url);
                                                window.location.href = data.redirect_url || "{{ route('user.booking.success') }}";
                                            });
                                        }
                                    }, 300); // Small delay for clean state transition
                                } else {
                                    console.error('PAYMENT: Verification failed:', data);
                                    // Close the loader before showing error
                                    Swal.close();
                                    
                                    // Handle authentication errors in payment verification
                                    if (data.redirect) {
                                        Swal.fire({
                                            title: 'Session Expired',
                                            text: data.message,
                                            icon: 'warning',
                                            confirmButtonText: 'Login Again',
                                            confirmButtonColor: '#3399cc'
                                        }).then(() => {
                                            window.location.href = data.redirect;
                                        });
                                    } else {
                                        if (typeof toastr !== 'undefined') {
                                            toastr.error(data.message);
                                        } else {
                                            alert(data.message);
                                        }
                                    }
                                }
                            })
                            .catch(error => {
                                console.error('PAYMENT: Payment verification error:', error);
                                console.error('PAYMENT: Error details:', error.message, error.stack);
                                
                                // Close the loader before showing error
                                Swal.close();
                                
                                if (error.response) {
                                    error.response.json().then(errorData => {
                                        console.error('PAYMENT: Server error response:', errorData);
                                        if (errorData.redirect) {
                                            Swal.fire({
                                                title: '👋 Hey! You forgot to login',
                                                text: '',
                                                showCloseButton: true,
                                                showCancelButton: false,
                                                confirmButtonText: 'Login',
                                                confirmButtonColor: '#3085d6'
                                            }).then(() => {
                                                window.location.href = errorData.redirect;
                                            });
                                        } else {
                                            if (typeof toastr !== 'undefined') {
                                                toastr.error(errorData.message || 'Payment verification failed');
                                            } else {
                                                alert(errorData.message || 'Payment verification failed');
                                            }
                                        }
                                    }).catch(() => {
                                        if (typeof toastr !== 'undefined') {
                                            toastr.error('Payment verification failed');
                                        } else {
                                            alert('Payment verification failed');
                                        }
                                    });
                                } else {
                                    if (typeof toastr !== 'undefined') {
                                        toastr.error('Payment verification failed');
                                    } else {
                                        alert('Payment verification failed');
                                    }
                                }
                            });
                        },
                        prefill: {
                            name: data.name,
                            email: data.email,
                            contact: data.phone
                        },
                        theme: {
                            color: "#3399cc"
                        }
                    };
                    const rzp = new Razorpay(options);
                    
                    // Show loading state when opening Razorpay
                    rzp.on('payment.created', function(response) {
                        console.log('Payment created:', response);
                    });
                    
                    // Show brief loading when opening payment modal
                    setTimeout(() => {
                        rzp.open();
                    }, 300); // Small delay to show button feedback
                    
                    // Enhanced payment failure handling
                    rzp.on('payment.failed', function (response) {
                        // Log failure and send notifications
                        fetch("{{ route('user.booking.payment.failed') }}", {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': csrfTokenValue,
                                'Accept': 'application/json',
                            },
                            body: JSON.stringify({
                                razorpay_payment_id: response.error.metadata?.payment_id || null,
                                razorpay_order_id: response.error.metadata?.order_id || null,
                                error_code: response.error.code,
                                error_description: response.error.description,
                                error_source: response.error.source,
                                error_step: response.error.step,
                                error_reason: response.error.reason,
                                send_notifications: true
                            })
                        })
                        .then(res => res.json())
                        .then(data => {
                            showAppointmentPaymentFailureDialog(response.error, data);
                        })
                        .catch((error) => {
                            console.error('Error logging payment failure:', error);
                            showAppointmentPaymentFailureDialog(response.error, null);
                        });
                    });
                } else {
                    // Reset button before showing error
                    bookingBtn.innerHTML = originalText;
                    bookingBtn.disabled = false;
                    
                    // Handle authentication errors specifically
                    if (data.redirect) {
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
                                window.location.href = data.redirect;
                            }
                        });
                    } else {
                        toastr.error(data.message);
                    }
                }
            })
            .catch(error => {
                console.error('Payment initiation error:', error);
                
                // Reset button before showing error
                bookingBtn.innerHTML = originalText;
                bookingBtn.disabled = false;
                
                // Handle different types of errors
                if (error.response) {
                    // Server responded with error status
                    error.response.json().then(errorData => {
                        if (errorData.redirect) {
                            Swal.fire({
                                title: '👋 Hey! You forgot to login',
                                text: '',
                                showCloseButton: true,
                                showCancelButton: false,
                                confirmButtonText: 'Login',
                                confirmButtonColor: '#3085d6'
                            }).then(() => {
                                window.location.href = errorData.redirect;
                            });
                        } else {
                            toastr.error(errorData.message || 'Payment initiation failed');
                        }
                    }).catch(() => {
                        toastr.error('Payment initiation failed. Please try again.');
                    });
                } else {
                    // Network or other errors
                    Swal.fire({
                        title: 'Connection Error',
                        text: 'Unable to connect to payment server. Please check your internet connection and try again.',
                        icon: 'error',
                        confirmButtonText: 'Try Again',
                        confirmButtonColor: '#dc3545'
                    });
                }
            });
        });
    }

    // Enhanced appointment payment failure handling functions
    function showAppointmentPaymentFailureDialog(error, logData) {
        const errorMessage = getAppointmentErrorMessage(error.code, error.description);
        const isRetryable = isAppointmentRetryableError(error.code);
        
        Swal.fire({
            title: 'Appointment Payment Failed',
            html: `
                <div style="text-align: left; margin: 20px 0;">
                    <p style="margin-bottom: 15px;"><strong>Reason:</strong> ${errorMessage}</p>
                    ${logData?.reference_id ? `<p style="margin-bottom: 15px;"><strong>Reference ID:</strong> ${logData.reference_id}</p>` : ''}
                    <p style="margin-bottom: 15px; color: #666; font-size: 14px;">
                        <i class="fa fa-shield"></i> No amount has been deducted from your account.
                    </p>
                    ${logData?.notifications_sent ? 
                        '<p style="margin-bottom: 15px; color: #28a745; font-size: 14px;"><i class="fa fa-check"></i> Your assigned professional and our support team have been notified.</p>' : 
                        ''
                    }
                </div>
            `,
            icon: 'error',
            showCancelButton: true,
            confirmButtonText: isRetryable ? '<i class="fa fa-refresh"></i> Retry Payment' : '<i class="fa fa-phone"></i> Contact Support',
            cancelButtonText: '<i class="fa fa-arrow-left"></i> Modify Booking',
            confirmButtonColor: isRetryable ? '#dc3545' : '#17a2b8',
            cancelButtonColor: '#6c757d',
            allowOutsideClick: false
        }).then((result) => {
            if (result.isConfirmed) {
                if (isRetryable) {
                    // Show loading and retry payment
                    Swal.fire({
                        title: 'Retrying Payment...',
                        text: 'Please wait while we process your payment.',
                        icon: 'info',
                        allowOutsideClick: false,
                        didOpen: () => { Swal.showLoading(); }
                    });
                    
                    setTimeout(() => {
                        Swal.close();
                        bookingBtn.click();
                    }, 1500);
                } else {
                    showAppointmentContactSupportDialog();
                }
            } else {
                // Go back to modify booking
                window.location.href = "{{ route('user.reset-booking') }}";
            }
        });
    }

    function showAppointmentContactSupportDialog() {
        Swal.fire({
            title: 'Get Help with Your Appointment',
            html: `
                <div style="text-align: left; margin: 20px 0;">
                    <p style="margin-bottom: 15px;">Our team will help you complete your appointment booking.</p>
                    <div style="background: #f8f9fa; padding: 15px; border-radius: 8px; margin: 15px 0;">
                        <p style="margin: 5px 0;"><strong><i class="fa fa-phone"></i> Call:</strong> +91-XXXX-XXXX-XX</p>
                        <p style="margin: 5px 0;"><strong><i class="fa fa-envelope"></i> Email:</strong> support@yourwebsite.com</p>
                        <p style="margin: 5px 0;"><strong><i class="fa fa-clock"></i> Hours:</strong> 9 AM - 9 PM (Mon-Sun)</p>
                    </div>
                    <p style="margin-bottom: 15px; color: #28a745; font-size: 14px;">
                        <i class="fa fa-user-md"></i> Your assigned professional has been notified about the payment issue.
                    </p>
                </div>
            `,
            icon: 'info',
            showCancelButton: true,
            confirmButtonText: '<i class="fa fa-refresh"></i> Try Again',
            cancelButtonText: '<i class="fa fa-home"></i> Go to Dashboard',
            confirmButtonColor: '#28a745',
            cancelButtonColor: '#6c757d'
        }).then((result) => {
            if (result.isConfirmed) {
                bookingBtn.click();
            } else {
                window.location.href = "{{ route('user.dashboard') }}";
            }
        });
    }

    function getAppointmentErrorMessage(errorCode, errorDescription) {
        const errorMessages = {
            'BAD_REQUEST_ERROR': 'Invalid payment details. Please verify your information.',
            'GATEWAY_ERROR': 'Payment gateway temporarily unavailable. Please try again.',
            'NETWORK_ERROR': 'Network connection issue. Please check your internet.',
            'SERVER_ERROR': 'Server error. Please try again after some time.',
            'PAYMENT_DECLINED': 'Payment declined by bank. Contact your bank or try another method.',
            'INSUFFICIENT_FUNDS': 'Insufficient funds. Please check your account balance.',
            'INVALID_CARD': 'Invalid card details. Please check your card information.',
            'CARD_EXPIRED': 'Card has expired. Please use a different card.',
            'CVV_MISMATCH': 'CVV mismatch. Please check your security code.',
            'OTP_VERIFICATION_FAILED': 'OTP verification failed. Please try again.',
            'PAYMENT_CANCELLED': 'Payment was cancelled.',
            'PAYMENT_TIMEOUT': 'Payment session timed out. Please try again.'
        };

        return errorMessages[errorCode] || errorDescription || 'An unexpected error occurred.';
    }

    function isAppointmentRetryableError(errorCode) {
        const retryableErrors = [
            'NETWORK_ERROR',
            'SERVER_ERROR', 
            'GATEWAY_ERROR',
            'PAYMENT_TIMEOUT',
            'OTP_VERIFICATION_FAILED'
        ];
        
        return retryableErrors.includes(errorCode);
    }

    // MCQ Functions
    function checkAndShowMCQQuestions(bookingData) {
        console.debug('MCQ: checkAndShowMCQQuestions called', bookingData);
        console.debug('MCQ: bookingData keys:', Object.keys(bookingData));
        console.debug('MCQ: professional_id:', bookingData.professional_id);
        console.debug('MCQ: redirect_url:', bookingData.redirect_url);
        
        // Use professional_id from the payment response instead of session
        if (!bookingData.professional_id) {
            console.debug('MCQ: No professional_id in response, proceeding to success page');
            // No professional_id in response, proceed to success page
            proceedToSuccessPage(bookingData);
            return;
        }

        console.debug('MCQ: Fetching MCQ questions for professional_id:', bookingData.professional_id);
        // Fetch MCQ questions for the service
        fetch("{{ route('get.mcq.questions') }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfTokenValue,
                'Accept': 'application/json',
            },
            body: JSON.stringify({
                professional_id: bookingData.professional_id
            })
        })
        .then(res => {
            console.debug('MCQ: MCQ fetch response status:', res.status);
            if (!res.ok) {
                throw new Error(`HTTP ${res.status}: ${res.statusText}`);
            }
            return res.json();
        })
        .then(data => {
            console.debug('MCQ: MCQ fetch response data:', data);
            if (data.status === 'success' && data.mcq_questions && data.mcq_questions.length > 0) {
                console.debug('MCQ: Found', data.mcq_questions.length, 'MCQ questions, showing modal');
                // Show MCQ modal
                showMCQModal(data.mcq_questions, data.service_id, bookingData);
            } else {
                console.debug('MCQ: No MCQ questions found, proceeding to success page');
                // No MCQ questions, show success modal and proceed
                showSuccessModal('Booking confirmed successfully!');
                setTimeout(() => {
                    proceedToSuccessPage(bookingData);
                }, 2000);
            }
        })
        .catch(error => {
            console.error('MCQ: Error fetching MCQ questions:', error);
            console.error('MCQ: Full error details:', error.message, error.stack);
            // Show default success modal and proceed to success page
            showSuccessModal('Booking confirmed successfully!');
            setTimeout(() => {
                console.debug('MCQ: Error fallback - proceeding to success page');
                proceedToSuccessPage(bookingData);
            }, 2000);
        });
    }

    function showSuccessModal(message) {
        console.debug('MCQ: showSuccessModal called with message:', message);
        Swal.fire({
            title: 'Success!',
            text: message,
            icon: 'success',
            timer: 3000,
            timerProgressBar: true,
            allowOutsideClick: false,
            showConfirmButton: false,
            showClass: {
                popup: 'animate__animated animate__bounceIn animate__faster'
            },
            hideClass: {
                popup: 'animate__animated animate__fadeOutUp animate__faster'
            }
        });
    }

    function proceedToSuccessPage(bookingData) {
        console.debug('MCQ: proceedToSuccessPage called', bookingData);
        console.debug('MCQ: redirect_url:', bookingData.redirect_url);
        
        // Ensure we have a redirect URL
        const redirectUrl = bookingData.redirect_url || "{{ route('user.booking.success') }}";
        console.debug('MCQ: Final redirect URL:', redirectUrl);
        
        // Show final success message before redirect
        Swal.fire({
            title: 'Booking Confirmed!',
            text: 'Redirecting to success page...',
            icon: 'success',
            timer: 2000,
            timerProgressBar: true,
            allowOutsideClick: false,
            showConfirmButton: false,
            showClass: {
                popup: 'animate__animated animate__bounceIn animate__faster'
            },
            hideClass: {
                popup: 'animate__animated animate__fadeOutUp animate__faster'
            }
        }).then(() => {
            console.debug('MCQ: Executing redirect to:', redirectUrl);
            // Force redirect
            window.location.href = redirectUrl;
        });
    }

    let currentQuestionIndex = 0;
    let mcqQuestions = [];
    let mcqAnswers = [];
    let mcqServiceId = null;
    let mcqBookingData = null;

    function showMCQModal(questions, serviceId, bookingData) {
        console.debug('MCQ: showMCQModal called', { questionsCount: (questions || []).length, serviceId, bookingData });
        mcqQuestions = questions;
        mcqServiceId = serviceId;
        mcqBookingData = bookingData;
        currentQuestionIndex = 0;
        mcqAnswers = [];

        // Create modal HTML
        const modalHtml = `
            <div class="modal fade" id="mcqModal" tabindex="-1" role="dialog" aria-labelledby="mcqModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
                <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="mcqModalLabel">
                                <i class="fa fa-clipboard-list"></i> Service Feedback Questions
                            </h5>
                        </div>
                        <div class="modal-body">
                            <div class="progress mb-4">
                                <div class="progress-bar progress-bar-striped progress-bar-animated" 
                                     role="progressbar" style="width: 0%" id="mcqProgress">
                                </div>
                            </div>
                            <div id="mcqQuestionContainer">
                                <!-- Question content will be dynamically inserted here -->
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-secondary" id="mcqSkipBtn">
                                <i class="fa fa-skip-forward"></i> Skip Questions
                            </button>
                            <div class="navigation-buttons">
                                <button type="button" class="btn btn-secondary" id="mcqPrevBtn" style="display: none;">
                                    <i class="fa fa-arrow-left"></i> Previous
                                </button>
                                <button type="button" class="btn btn-primary" id="mcqNextBtn">
                                    Next <i class="fa fa-arrow-right"></i>
                                </button>
                                <button type="button" class="btn btn-success" id="mcqSubmitBtn" style="display: none;">
                                    <i class="fa fa-check"></i> Submit Answers
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        `;

        // Remove existing modal if any
        const existingModal = document.getElementById('mcqModal');
        if (existingModal) {
            existingModal.remove();
        }

        // Add modal to body
        document.body.insertAdjacentHTML('beforeend', modalHtml);

        // Show first question
        showCurrentQuestion();

        // Add event listeners for buttons
        document.getElementById('mcqPrevBtn').addEventListener('click', previousQuestion);
        document.getElementById('mcqNextBtn').addEventListener('click', nextQuestion);
        document.getElementById('mcqSubmitBtn').addEventListener('click', submitMCQAnswers);
        document.getElementById('mcqSkipBtn').addEventListener('click', skipMCQQuestions);

        // Show modal - try different modal initialization methods
        const modalElement = document.getElementById('mcqModal');
        let modal;
        
        if (typeof bootstrap !== 'undefined' && bootstrap.Modal) {
            // Bootstrap 5
            modal = new bootstrap.Modal(modalElement);
        } else if (typeof $ !== 'undefined' && $.fn.modal) {
            // Bootstrap 4 with jQuery
            $(modalElement).modal('show');
            console.debug('MCQ: jQuery modal shown');
            return;
        } else {
            // Fallback - manual show
            modalElement.style.display = 'block';
            modalElement.classList.add('show');
            document.body.classList.add('modal-open');
            console.debug('MCQ: fallback modal shown');
            return;
        }
        
        modal.show();
        console.debug('MCQ: bootstrap modal shown');
    }

    function showCurrentQuestion() {
        if (currentQuestionIndex >= mcqQuestions.length) return;

        const question = mcqQuestions[currentQuestionIndex];
        const progress = ((currentQuestionIndex + 1) / mcqQuestions.length) * 100;
        
        // Update progress bar
        document.getElementById('mcqProgress').style.width = progress + '%';
        document.getElementById('mcqProgress').textContent = `${currentQuestionIndex + 1} of ${mcqQuestions.length}`;

        let questionHtml = `
            <div class="question-card">
                <h6 class="mb-3">
                    <span class="badge bg-primary me-2">${currentQuestionIndex + 1}</span>
                    ${question.question}
                </h6>
        `;

        if (question.question_type === 'mcq') {
            questionHtml += '<div class="options-container">';
            
            if (question.formatted_options && Array.isArray(question.formatted_options)) {
                question.formatted_options.forEach((option, index) => {
                    questionHtml += `
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="radio" name="mcq_answer_${question.id}" 
                                   id="option_${question.id}_${index}" value="${option}">
                            <label class="form-check-label" for="option_${question.id}_${index}">
                                ${option}
                            </label>
                        </div>
                    `;
                });
            }

            if (question.has_other_option) {
                questionHtml += `
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="radio" name="mcq_answer_${question.id}" 
                               id="option_${question.id}_other" value="Other">
                        <label class="form-check-label" for="option_${question.id}_other">
                            Other
                        </label>
                    </div>
                    <div class="mt-2" id="other_text_${question.id}" style="display: none;">
                        <input type="text" class="form-control" placeholder="Please specify..." 
                               id="other_input_${question.id}">
                    </div>
                `;
            }

            questionHtml += '</div>';
        } else {
            // Text question
            questionHtml += `
                <div class="form-group">
                    <textarea class="form-control" rows="4" id="text_answer_${question.id}" 
                              placeholder="Please enter your answer..."></textarea>
                </div>
            `;
        }

        questionHtml += '</div>';

        document.getElementById('mcqQuestionContainer').innerHTML = questionHtml;

        // Add event listener for "Other" option if it exists
        if (question.has_other_option) {
            const otherRadio = document.getElementById(`option_${question.id}_other`);
            const otherTextDiv = document.getElementById(`other_text_${question.id}`);
            const allRadios = document.querySelectorAll(`input[name="mcq_answer_${question.id}"]`);

            allRadios.forEach(radio => {
                radio.addEventListener('change', function() {
                    if (this.value === 'Other') {
                        otherTextDiv.style.display = 'block';
                    } else {
                        otherTextDiv.style.display = 'none';
                    }
                });
            });
        }

        // Update button visibility
        updateMCQButtons();

        // Restore previous answer if exists
        if (mcqAnswers[currentQuestionIndex]) {
            const savedAnswer = mcqAnswers[currentQuestionIndex];
            if (question.question_type === 'mcq') {
                const radio = document.querySelector(`input[name="mcq_answer_${question.id}"][value="${savedAnswer.answer}"]`);
                if (radio) {
                    radio.checked = true;
                    if (savedAnswer.answer === 'Other' && savedAnswer.other_answer) {
                        document.getElementById(`other_text_${question.id}`).style.display = 'block';
                        document.getElementById(`other_input_${question.id}`).value = savedAnswer.other_answer;
                    }
                }
            } else {
                document.getElementById(`text_answer_${question.id}`).value = savedAnswer.answer;
            }
        }
    }

    function updateMCQButtons() {
        const prevBtn = document.getElementById('mcqPrevBtn');
        const nextBtn = document.getElementById('mcqNextBtn');
        const submitBtn = document.getElementById('mcqSubmitBtn');

        // Show/hide previous button
        prevBtn.style.display = currentQuestionIndex > 0 ? 'inline-block' : 'none';

        // Show/hide next and submit buttons
        if (currentQuestionIndex === mcqQuestions.length - 1) {
            nextBtn.style.display = 'none';
            submitBtn.style.display = 'inline-block';
        } else {
            nextBtn.style.display = 'inline-block';
            submitBtn.style.display = 'none';
        }
    }

    function previousQuestion() {
        console.log('Previous button clicked, current index:', currentQuestionIndex);
        if (currentQuestionIndex > 0) {
            saveCurrentAnswer();
            currentQuestionIndex--;
            showCurrentQuestion();
        }
    }

    function nextQuestion() {
        console.log('Next button clicked, current index:', currentQuestionIndex);
        if (currentQuestionIndex < mcqQuestions.length - 1) {
            if (saveCurrentAnswer()) {
                currentQuestionIndex++;
                showCurrentQuestion();
            }
        }
    }

    function saveCurrentAnswer() {
        const question = mcqQuestions[currentQuestionIndex];
        console.log('Saving answer for question:', question);
        let answer = '';
        let otherAnswer = '';

        if (question.question_type === 'mcq') {
            const selectedRadio = document.querySelector(`input[name="mcq_answer_${question.id}"]:checked`);
            console.log('Selected radio:', selectedRadio);
            if (!selectedRadio) {
                if (typeof toastr !== 'undefined') {
                    toastr.warning('Please select an answer before proceeding.');
                } else {
                    alert('Please select an answer before proceeding.');
                }
                return false;
            }
            
            answer = selectedRadio.value;
            
            if (answer === 'Other') {
                const otherInput = document.getElementById(`other_input_${question.id}`);
                if (!otherInput || !otherInput.value.trim()) {
                    if (typeof toastr !== 'undefined') {
                        toastr.warning('Please specify your other answer.');
                    } else {
                        alert('Please specify your other answer.');
                    }
                    return false;
                }
                otherAnswer = otherInput.value.trim();
            }
        } else {
            const textArea = document.getElementById(`text_answer_${question.id}`);
            if (!textArea || !textArea.value.trim()) {
                if (typeof toastr !== 'undefined') {
                    toastr.warning('Please enter your answer before proceeding.');
                } else {
                    alert('Please enter your answer before proceeding.');
                }
                return false;
            }
            answer = textArea.value.trim();
        }

        // Save or update answer
        mcqAnswers[currentQuestionIndex] = {
            mcq_id: question.id,
            question: question.question,
            answer: answer,
            other_answer: otherAnswer
        };

        console.log('Answer saved:', mcqAnswers[currentQuestionIndex]);
        return true;
    }

    function submitMCQAnswers() {
        // Save the last answer
        if (!saveCurrentAnswer()) {
            return;
        }

        // Show loading
        const submitBtn = document.getElementById('mcqSubmitBtn');
        const originalText = submitBtn.innerHTML;
        submitBtn.innerHTML = '<i class="fa fa-spinner fa-spin"></i> Submitting...';
        submitBtn.disabled = true;

        // Submit answers
        fetch("{{ route('user.mcq.submit') }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfTokenValue,
                'Accept': 'application/json',
            },
            body: JSON.stringify({
                service_id: mcqServiceId,
                answers: mcqAnswers
            })
        })
        .then(res => res.json())
        .then(data => {
            console.debug('MCQ: Submit MCQ response:', data);
            if (data.status === 'success') {
                console.debug('MCQ: submitMCQAnswers successful response', data);
                // Close MCQ modal
                const modalElement = document.getElementById('mcqModal');
                if (typeof bootstrap !== 'undefined' && bootstrap.Modal) {
                    const modal = bootstrap.Modal.getInstance(modalElement);
                    if (modal) modal.hide();
                } else if (typeof $ !== 'undefined' && $.fn.modal) {
                    $(modalElement).modal('hide');
                } else {
                    modalElement.style.display = 'none';
                    modalElement.classList.remove('show');
                    document.body.classList.remove('modal-open');
                    // Remove modal backdrop if exists
                    const backdrop = document.querySelector('.modal-backdrop');
                    if (backdrop) backdrop.remove();
                }
                
                // Show thank you message and proceed to success page
                Swal.fire({
                    title: 'Thank You!',
                    text: 'Your feedback has been submitted successfully.',
                    icon: 'success',
                    timer: 2000,
                    timerProgressBar: true,
                    allowOutsideClick: false,
                    showConfirmButton: false
                }).then(() => {
                    console.debug('MCQ: proceeding to success page with mcqBookingData', mcqBookingData);
                    proceedToSuccessPage(mcqBookingData);
                });
            } else {
                console.error('MCQ: Failed to submit answers:', data.message);
                // Reset button and show error
                submitBtn.innerHTML = originalText;
                submitBtn.disabled = false;
                if (typeof toastr !== 'undefined') {
                    toastr.error(data.message || 'Failed to submit answers. Please try again.');
                } else {
                    alert(data.message || 'Failed to submit answers. Please try again.');
                }
            }
        })
        .catch(error => {
            console.error('MCQ: Error submitting MCQ answers:', error);
            console.error('MCQ: Full submission error details:', error.message, error.stack);
            // Reset button and show error
            submitBtn.innerHTML = originalText;
            submitBtn.disabled = false;
            if (typeof toastr !== 'undefined') {
                toastr.error('Failed to submit answers. Please try again.');
            } else {
                alert('Failed to submit answers. Please try again.');
            }
            // Alternatively, proceed to success page anyway after showing error
            // setTimeout(() => proceedToSuccessPage(mcqBookingData), 3000);
        });
    }

    function skipMCQQuestions() {
        console.debug('MCQ: Skip button clicked');
        
        // Show confirmation modal
        Swal.fire({
            title: 'Skip Questions?',
            text: 'You can always provide feedback later. Your booking will be confirmed.',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: '<i class="fa fa-check"></i> Yes, Skip',
            cancelButtonText: '<i class="fa fa-times"></i> Continue Questions',
            confirmButtonColor: '#6c757d',
            cancelButtonColor: '#667eea',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                console.debug('MCQ: User confirmed skip, closing modal and proceeding to success');
                
                // Close MCQ modal
                const modalElement = document.getElementById('mcqModal');
                if (typeof bootstrap !== 'undefined' && bootstrap.Modal) {
                    const modal = bootstrap.Modal.getInstance(modalElement);
                    if (modal) modal.hide();
                } else if (typeof $ !== 'undefined' && $.fn.modal) {
                    $(modalElement).modal('hide');
                } else {
                    modalElement.style.display = 'none';
                    modalElement.classList.remove('show');
                    document.body.classList.remove('modal-open');
                    // Remove modal backdrop if exists
                    const backdrop = document.querySelector('.modal-backdrop');
                    if (backdrop) backdrop.remove();
                }
                
                // Show brief message and proceed to success page
                Swal.fire({
                    title: 'Booking Confirmed!',
                    text: 'Your payment was successful and booking is confirmed.',
                    icon: 'success',
                    timer: 2000,
                    timerProgressBar: true,
                    allowOutsideClick: false,
                    showConfirmButton: false
                }).then(() => {
                    console.debug('MCQ: Skip - proceeding to success page with mcqBookingData', mcqBookingData);
                    proceedToSuccessPage(mcqBookingData);
                });
            }
        });
    }
});
</script>

<!-- Enhanced Payment Failure Styles -->
<style>
.payment-failure-popup {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}

.payment-failure-confirm,
.payment-failure-cancel {
    padding: 10px 20px !important;
    font-weight: 600 !important;
    border-radius: 6px !important;
    transition: all 0.3s ease !important;
}

.payment-failure-confirm:hover {
    transform: translateY(-1px) !important;
    box-shadow: 0 4px 8px rgba(0,0,0,0.2) !important;
}

.payment-failure-cancel:hover {
    transform: translateY(-1px) !important;
    box-shadow: 0 4px 8px rgba(0,0,0,0.1) !important;
}

.swal2-icon.swal2-error {
    border-color: #dc3545 !important;
    color: #dc3545 !important;
}

.swal2-icon.swal2-warning {
    border-color: #ffc107 !important;
    color: #ffc107 !important;
}

.swal2-icon.swal2-info {
    border-color: #17a2b8 !important;
    color: #17a2b8 !important;
}

/* Button loading animation */
.btn_1[disabled] {
    opacity: 0.7;
    cursor: not-allowed;
    position: relative;
}

.btn_1 .fa-spinner {
    animation: spin 1s linear infinite;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

/* Smooth transitions for buttons */
.btn_1 {
    transition: all 0.3s ease;
}

.btn_1:not([disabled]):hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.15);
}

/* Loading overlay for better UX */
.loading-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(255, 255, 255, 0.95);
    display: none;
    z-index: 9999;
    justify-content: center;
    align-items: center;
    backdrop-filter: blur(2px);
}

.loading-overlay.show {
    display: flex;
}

.loading-spinner {
    width: 50px;
    height: 50px;
    border: 4px solid #f3f3f3;
    border-top: 4px solid #3399cc;
    border-radius: 50%;
    animation: spin 1s linear infinite;
}

/* MCQ Modal Styles - Premium Design */
#mcqModal .modal-content {
    border-radius: 25px;
    box-shadow: 0 25px 60px rgba(0, 0, 0, 0.3), 0 0 0 1px rgba(255, 255, 255, 0.1);
    border: none;
    overflow: hidden;
    background: linear-gradient(145deg, #ffffff 0%, #f8fafc 100%);
}

#mcqModal .modal-backdrop {
    background: rgba(0, 0, 0, 0.7);
    backdrop-filter: blur(10px);
}

#mcqModal .modal-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 50%, #f093fb 100%);
    color: white;
    border-radius: 25px 25px 0 0;
    border-bottom: none;
    padding: 30px;
    position: relative;
    overflow: hidden;
}

#mcqModal .modal-header::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(45deg, rgba(255,255,255,0.1) 25%, transparent 25%, transparent 75%, rgba(255,255,255,0.1) 75%), 
                linear-gradient(45deg, rgba(255,255,255,0.1) 25%, transparent 25%, transparent 75%, rgba(255,255,255,0.1) 75%);
    background-size: 20px 20px;
    background-position: 0 0, 10px 10px;
    animation: slidePattern 20s linear infinite;
}

@keyframes slidePattern {
    0% { transform: translateX(0); }
    100% { transform: translateX(40px); }
}

#mcqModal .modal-title {
    font-weight: 700;
    font-size: 1.5rem;
    text-shadow: 0 2px 4px rgba(0,0,0,0.3);
    z-index: 2;
    position: relative;
    display: flex;
    align-items: center;
}

#mcqModal .modal-title i {
    background: linear-gradient(45deg, #ffd700, #ffed4e);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    margin-right: 12px;
    font-size: 1.8rem;
    filter: drop-shadow(0 2px 4px rgba(255,215,0,0.5));
    animation: pulseGlow 2s ease-in-out infinite alternate;
}

@keyframes pulseGlow {
    0% { filter: drop-shadow(0 2px 4px rgba(255,215,0,0.5)); }
    100% { filter: drop-shadow(0 4px 8px rgba(255,215,0,0.8)); }
}

.question-card {
    background: linear-gradient(145deg, #ffffff 0%, #f1f5f9 100%);
    padding: 35px;
    border-radius: 20px;
    border: 1px solid rgba(226, 232, 240, 0.8);
    margin-bottom: 25px;
    box-shadow: 0 10px 25px rgba(0,0,0,0.08), 0 0 0 1px rgba(255,255,255,0.9);
    position: relative;
    overflow: hidden;
    transition: all 0.4s cubic-bezier(0.25, 0.8, 0.25, 1);
}

.question-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 5px;
    height: 100%;
    background: linear-gradient(180deg, #667eea 0%, #764ba2 50%, #f093fb 100%);
    border-radius: 0 5px 5px 0;
}

.question-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 20px 40px rgba(0,0,0,0.12), 0 0 0 1px rgba(255,255,255,0.9);
}

.question-card h6 {
    font-weight: 700;
    color: #1e293b;
    margin-bottom: 25px;
    font-size: 1.2rem;
    line-height: 1.6;
    display: flex;
    align-items: center;
    gap: 15px;
}

.question-card .badge {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    font-size: 0.85rem;
    padding: 10px 16px;
    border-radius: 50px;
    font-weight: 600;
    box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
    border: 2px solid rgba(255,255,255,0.2);
    min-width: 45px;
    text-align: center;
    animation: badgePulse 3s ease-in-out infinite;
}

@keyframes badgePulse {
    0%, 100% { transform: scale(1); }
    50% { transform: scale(1.05); }
}

.options-container {
    display: grid;
    gap: 15px;
}

.options-container .form-check {
    background: linear-gradient(145deg, #ffffff 0%, #f8fafc 100%);
    padding: 20px 25px;
    border-radius: 15px;
    border: 2px solid #e2e8f0;
    transition: all 0.4s cubic-bezier(0.25, 0.8, 0.25, 1);
    cursor: pointer;
    position: relative;
    overflow: hidden;
    margin-bottom: 0;
}

.options-container .form-check::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(102, 126, 234, 0.1), transparent);
    transition: left 0.6s ease;
}

.options-container .form-check:hover::before {
    left: 100%;
}

.options-container .form-check:hover {
    border-color: #667eea;
    background: linear-gradient(145deg, #f8fafc 0%, #ffffff 100%);
    transform: translateY(-3px) scale(1.02);
    box-shadow: 0 10px 25px rgba(102, 126, 234, 0.15);
}

.options-container .form-check-label {
    font-weight: 500;
    color: #475569;
    font-size: 15px;
    line-height: 1.5;
    cursor: pointer;
    transition: all 0.3s ease;
    margin-left: 10px;
}

.options-container .form-check-input {
    width: 20px;
    height: 20px;
    border: 2px solid #cbd5e1;
    transition: all 0.3s ease;
    margin-top: 2px;
}

.options-container .form-check-input:checked {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-color: #667eea;
    box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.2);
}

.options-container .form-check-input:checked + .form-check-label {
    color: #1e293b;
    font-weight: 600;
}

.options-container .form-check:has(.form-check-input:checked) {
    border-color: #667eea;
    background: linear-gradient(145deg, #eef2ff 0%, #f8fafc 100%);
    box-shadow: 0 8px 25px rgba(102, 126, 234, 0.2);
    transform: translateY(-2px);
}

.options-container .form-check:has(.form-check-input:checked)::after {
    content: '✓';
    position: absolute;
    top: 15px;
    right: 20px;
    color: #667eea;
    font-weight: bold;
    font-size: 18px;
    animation: checkMark 0.5s ease-in-out;
}

@keyframes checkMark {
    0% { transform: scale(0) rotate(180deg); opacity: 0; }
    100% { transform: scale(1) rotate(0deg); opacity: 1; }
}

.progress {
    height: 12px;
    border-radius: 20px;
    background: linear-gradient(145deg, #e2e8f0 0%, #cbd5e1 100%);
    overflow: hidden;
    box-shadow: inset 0 2px 4px rgba(0,0,0,0.1);
}

.progress-bar {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 50%, #f093fb 100%);
    border-radius: 20px;
    transition: width 0.8s cubic-bezier(0.25, 0.8, 0.25, 1);
    font-size: 11px;
    font-weight: 700;
    color: white;
    text-align: center;
    line-height: 12px;
    text-shadow: 0 1px 2px rgba(0,0,0,0.3);
    position: relative;
    overflow: hidden;
}

.progress-bar::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.4), transparent);
    animation: progressShine 2s ease-in-out infinite;
}

@keyframes progressShine {
    0% { left: -100%; }
    100% { left: 100%; }
}

#mcqModal .btn {
    border-radius: 50px;
    padding: 15px 35px;
    font-weight: 700;
    transition: all 0.4s cubic-bezier(0.25, 0.8, 0.25, 1);
    border: none;
    text-transform: uppercase;
    letter-spacing: 1px;
    font-size: 0.85rem;
    position: relative;
    overflow: hidden;
    box-shadow: 0 4px 15px rgba(0,0,0,0.2);
}

#mcqModal .btn::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
    transition: left 0.6s ease;
}

#mcqModal .btn:hover::before {
    left: 100%;
}

#mcqModal .btn-primary {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    box-shadow: 0 8px 25px rgba(102, 126, 234, 0.4);
}

#mcqModal .btn-primary:hover {
    background: linear-gradient(135deg, #5a67d8 0%, #6b46c1 100%);
    transform: translateY(-3px);
    box-shadow: 0 12px 35px rgba(102, 126, 234, 0.5);
}

#mcqModal .btn-secondary {
    background: linear-gradient(135deg, #64748b 0%, #475569 100%);
    color: white;
    box-shadow: 0 8px 25px rgba(100, 116, 139, 0.4);
}

#mcqModal .btn-secondary:hover {
    background: linear-gradient(135deg, #475569 0%, #334155 100%);
    transform: translateY(-3px);
    box-shadow: 0 12px 35px rgba(100, 116, 139, 0.5);
}

#mcqModal .btn-success {
    background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    color: white;
    box-shadow: 0 8px 25px rgba(16, 185, 129, 0.4);
}

#mcqModal .btn-success:hover {
    background: linear-gradient(135deg, #059669 0%, #047857 100%);
    transform: translateY(-3px);
    box-shadow: 0 12px 35px rgba(16, 185, 129, 0.5);
}

#mcqModal .modal-footer {
    border-top: none;
    padding: 30px;
    background: linear-gradient(145deg, #f8fafc 0%, #f1f5f9 100%);
    border-radius: 0 0 25px 25px;
    gap: 15px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

#mcqModal .modal-footer .navigation-buttons {
    display: flex;
    gap: 15px;
    align-items: center;
}

#mcqModal .btn-outline-secondary {
    background: transparent;
    border: 2px solid #6c757d;
    color: #6c757d;
    box-shadow: 0 4px 15px rgba(108, 117, 125, 0.2);
}

#mcqModal .btn-outline-secondary:hover {
    background: linear-gradient(135deg, #6c757d 0%, #495057 100%);
    color: white;
    transform: translateY(-3px);
    box-shadow: 0 8px 25px rgba(108, 117, 125, 0.4);
}

#mcqModal .modal-body {
    padding: 30px;
    background: linear-gradient(145deg, #ffffff 0%, #f8fafc 100%);
}

/* Text area styling */
#mcqModal textarea.form-control {
    border: 2px solid #e2e8f0;
    border-radius: 15px;
    padding: 20px;
    transition: all 0.4s cubic-bezier(0.25, 0.8, 0.25, 1);
    font-size: 15px;
    resize: vertical;
    min-height: 120px;
    background: linear-gradient(145deg, #ffffff 0%, #f8fafc 100%);
    box-shadow: inset 0 2px 4px rgba(0,0,0,0.05);
    font-family: inherit;
    line-height: 1.6;
}

#mcqModal textarea.form-control:focus {
    border-color: #667eea;
    box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1), inset 0 2px 4px rgba(0,0,0,0.05);
    transform: translateY(-2px);
    background: #ffffff;
}

#mcqModal textarea.form-control::placeholder {
    color: #94a3b8;
    font-style: italic;
}

/* Other input styling */
#mcqModal input[type="text"].form-control {
    border: 2px solid #e2e8f0;
    border-radius: 12px;
    padding: 15px 20px;
    transition: all 0.4s cubic-bezier(0.25, 0.8, 0.25, 1);
    background: linear-gradient(145deg, #ffffff 0%, #f8fafc 100%);
    box-shadow: inset 0 2px 4px rgba(0,0,0,0.05);
    font-size: 15px;
}

#mcqModal input[type="text"].form-control:focus {
    border-color: #667eea;
    box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1), inset 0 2px 4px rgba(0,0,0,0.05);
    transform: translateY(-2px);
    background: #ffffff;
}

#mcqModal input[type="text"].form-control::placeholder {
    color: #94a3b8;
    font-style: italic;
}

/* Animation for modal entrance */
#mcqModal.fade .modal-dialog {
    transition: all 0.5s cubic-bezier(0.25, 0.8, 0.25, 1);
    transform: scale(0.8) translateY(50px);
    opacity: 0;
}

#mcqModal.show .modal-dialog {
    transform: scale(1) translateY(0);
    opacity: 1;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    #mcqModal .modal-content {
        border-radius: 20px;
        margin: 15px;
    }
    
    #mcqModal .modal-header,
    #mcqModal .modal-body,
    #mcqModal .modal-footer {
        padding: 20px;
    }
    
    .question-card {
        padding: 25px;
    }
    
    #mcqModal .btn {
        padding: 12px 25px;
        font-size: 0.8rem;
    }
}
</style>

@endsection
