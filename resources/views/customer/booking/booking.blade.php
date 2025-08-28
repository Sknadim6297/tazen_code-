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
                            .then(res => res.json())
                            .then(data => {
                                if (data.status === 'success') {
                                    // Update loader to show success message
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
                                        window.location.href = data.redirect_url;
                                    });
                                } else {
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
                                        toastr.error(data.message);
                                    }
                                }
                            })
                            .catch(error => {
                                console.error('Payment verification error:', error);
                                
                                // Close the loader before showing error
                                Swal.close();
                                
                                if (error.response) {
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
                                            toastr.error(errorData.message || 'Payment verification failed');
                                        }
                                    }).catch(() => {
                                        toastr.error('Payment verification failed');
                                    });
                                } else {
                                    toastr.error('Payment verification failed');
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
</style>

@endsection
