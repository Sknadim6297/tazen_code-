@extends('layouts.layout')

@section('styles')
<link rel="stylesheet" href="{{ asset('frontend/assets/css/booking-sign_up.css') }}" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
@endsection

@section('content')
<main class="bg_gray pattern">
    <!-- Loading overlay -->
    <div class="loading-overlay" id="loadingOverlay">
        <div class="loading-spinner"></div>
    </div>
    
    <div class="container margin_60_40">
        <div class="row justify-content-center">
            <div class="col-lg-5">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fa fa-check-circle"></i> {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif
                
                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fa fa-exclamation-circle"></i> {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif
                
                <div class="box_booking_2">
                    @if(isset($bookingData))
                        @php
                            $event = \App\Models\AllEvent::find($bookingData['event_id'] ?? null);
                            $user = Auth::guard('user')->user();
                            $amount = ($bookingData['total_price'] ?? 0) * 100;
                        @endphp

                        <div class="head">
                            <div class="title">
                                <h3>{{ $bookingData['event_name'] ?? 'Event Booking' }}</h3>
                                <p>{{ $bookingData['location'] ?? 'Location N/A' }} ({{ ucfirst($bookingData['type'] ?? '') }})</p>
                            </div>
                        </div>

                        <div class="main">
                            <h6>Event Booking Summary</h6>
                            <ul>
                                <li>Event Name: <span>{{ $bookingData['event_name'] ?? ($event->heading ?? 'N/A') }}</span></li>
                                <li>Event Date: <span>{{ isset($bookingData['event_date']) ? \Carbon\Carbon::parse($bookingData['event_date'])->format('d M Y') : 'N/A' }}</span></li>
                                <li>Total Amount: <span>₹{{ number_format($bookingData['total_price'] ?? 0, 2) }}</span></li>
                                <li>Status: <span>{{ ucfirst($event->status ?? 'Pending') }}</span></li>
                                <li>Location: <span>{{ $bookingData['location'] ?? ($event->city ?? 'N/A') }}</span></li>
                                <li>Type: <span>{{ ucfirst($bookingData['type'] ?? 'N/A') }}</span></li>
                                <li>Persons: <span>{{ $bookingData['persons'] ?? 'N/A' }}</span></li>
                                <li>Phone: <span>{{ $bookingData['phone'] ?? 'N/A' }}</span></li>
                                <li>Your Name: <span>{{ $user->name ?? 'N/A' }}</span></li>
                                <li>Your Email: <span>{{ $user->email ?? 'N/A' }}</span></li>
                            </ul>

                            <hr>
                            <button class="btn_1 full-width mb_5" id="payNowBtn">Confirm Booking</button>
                            <a href="{{ route('event.list') }}" class="btn_1 full-width outline mb_25">Change Booking</a>
                            
                            @if(session('failed_booking_data'))
                                <div class="alert alert-warning mt-3">
                                    <h6>Previous Payment Failed</h6>
                                    <p>Your previous payment attempt was unsuccessful. You can retry your booking below.</p>
                                    <a href="{{ route('user.booking.retry', ['booking_id' => session('failed_booking_id')]) }}" 
                                       class="btn btn-warning btn-sm">
                                        <i class="fa fa-refresh"></i> Retry Booking
                                    </a>
                                </div>
                            @endif
                        </div>
                    @else
                        <div class="main">
                            <h6>No booking data available.</h6>
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
<!-- Add SweetAlert CDN -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const payBtn = document.getElementById('payNowBtn');
    if (!payBtn) return;

    payBtn.addEventListener('click', function () {
        // Show loading state on button
        const originalText = payBtn.innerHTML;
        payBtn.innerHTML = '<i class="fa fa-spinner fa-spin"></i> Processing...';
        payBtn.disabled = true;
        
        fetch("{{ route('user.booking.payment.init') }}", {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json'
            },
        })
        .then(res => res.json())
        .then(data => {
            console.log('Payment initialization response:', data);
            
            if (!data || !data.order_id) {
                console.error('Payment initialization failed:', data);
                
                // Reset button before showing error
                payBtn.innerHTML = originalText;
                payBtn.disabled = false;
                
                if (typeof Swal !== 'undefined') {
                    Swal.fire({
                        title: 'Payment Setup Failed',
                        text: 'Unable to initialize payment. Please try again.',
                        icon: 'error',
                        confirmButtonText: 'Try Again'
                    });
                } else {
                    alert('Payment initialization failed. Please try again.');
                }
                return;
            }

            // Reset button before showing Razorpay
            payBtn.innerHTML = originalText;
            payBtn.disabled = false;

            const options = {
                key: data.key,
                amount: data.amount,
                currency: "INR",
                name: "Your Website",
                description: "Event Booking",
                image: "{{ asset('frontend/assets/img/logo.png') }}",
                order_id: data.order_id,
                handler: function (response) {
                    console.log('Payment successful, verifying...', response);
                    
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
                    
                    fetch("{{ route('user.booking.payment.success') }}", {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Content-Type': 'application/json',
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({
                            razorpay_payment_id: response.razorpay_payment_id,
                            razorpay_order_id: response.razorpay_order_id,
                            razorpay_signature: response.razorpay_signature
                        })
                    })
                    .then(res => {
                        console.log('Payment verification response status:', res.status);
                        return res.json();
                    })
                    .then(data => {
                        console.log('Payment verification response:', data);
                        
                        if (data.status === 'success') {
                            // Show success message with auto-redirect
                            Swal.fire({
                                title: 'Booking Confirmed!',
                                text: 'Your event booking has been confirmed successfully.',
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
                            }).then(() => {
                                window.location.href = "{{ route('user.event.booking.success') }}";
                            });
                        } else {
                            console.error('Payment verification failed:', data);
                            
                            // Close the loader before showing error
                            Swal.close();
                            
                            // Show appropriate error message
                            const message = data.message || 'Payment verification failed.';
                            if (typeof Swal !== 'undefined') {
                                Swal.fire({
                                    title: 'Payment Verification Failed',
                                    text: message,
                                    icon: 'error',
                                    showCancelButton: true,
                                    confirmButtonText: 'Contact Support',
                                    cancelButtonText: 'Try Again',
                                    confirmButtonColor: '#dc3545'
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        showContactSupportDialog();
                                    }
                                });
                            } else {
                                alert(message);
                            }
                        }
                    })
                    .catch(error => {
                        console.error('Network error during payment verification:', error);
                        
                        // Close the loader before showing error
                        Swal.close();
                        
                        if (typeof Swal !== 'undefined') {
                            Swal.fire({
                                title: 'Connection Error',
                                text: 'Unable to verify payment. Please check your connection and contact support if the issue persists.',
                                icon: 'error',
                                confirmButtonText: 'Contact Support'
                            }).then(() => {
                                showContactSupportDialog();
                            });
                        } else {
                            alert('Connection error during payment verification. Please contact support.');
                        }
                    });
                },
                prefill: {
                    name: "{{ $user->name ?? '' }}",
                    email: "{{ $user->email ?? '' }}",
                    contact: "{{ $bookingData['phone'] ?? '' }}"
                },
                theme: {
                    color: "#0a58ca"
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
            
            rzp.on('payment.failed', function (response) {
                // First log the failure and send notifications
                fetch("{{ route('user.customer.booking.payment.failed') }}", {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        razorpay_payment_id: response.error.metadata?.payment_id || null,
                        razorpay_order_id: response.error.metadata?.order_id || null,
                        error_code: response.error.code,
                        error_description: response.error.description,
                        error_source: response.error.source,
                        error_step: response.error.step,
                        error_reason: response.error.reason,
                        send_notifications: true // Flag to send notifications to admin/professional
                    })
                })
                .then(res => res.json())
                .then(data => {
                    // Enhanced payment failure handling with better UX
                    showPaymentFailureDialog(response.error, data);
                })
                .catch((error) => {
                    console.error('Error logging payment failure:', error);
                    showPaymentFailureDialog(response.error, null);
                });
            });

            // Note: rzp.open() is called in setTimeout above with 300ms delay
        })
        .catch(err => {
            console.error(err);
            
            // Reset button before showing error
            payBtn.innerHTML = originalText;
            payBtn.disabled = false;
            
            showGenericPaymentError();
        });
    });

    // Enhanced payment failure handling functions
    function showPaymentFailureDialog(error, logData) {
        const errorMessage = getErrorMessage(error.code, error.description);
        const isRetryable = isRetryableError(error.code);
        
        let swalConfig = {
            title: 'Payment Failed',
            html: `
                <div style="text-align: left; margin: 20px 0;">
                    <p style="margin-bottom: 15px;"><strong>Reason:</strong> ${errorMessage}</p>
                    ${logData?.reference_id ? `<p style="margin-bottom: 15px;"><strong>Reference ID:</strong> ${logData.reference_id}</p>` : ''}
                    <p style="margin-bottom: 15px; color: #666; font-size: 14px;">
                        <i class="fa fa-info-circle"></i> Don't worry, no amount has been deducted from your account.
                    </p>
                    ${logData?.notifications_sent ? 
                        '<p style="margin-bottom: 15px; color: #28a745; font-size: 14px;"><i class="fa fa-check"></i> Our support team has been notified and will assist you shortly.</p>' : 
                        ''
                    }
                </div>
            `,
            icon: 'error',
            showCancelButton: true,
            confirmButtonText: isRetryable ? '<i class="fa fa-refresh"></i> Retry Payment' : '<i class="fa fa-phone"></i> Contact Support',
            cancelButtonText: '<i class="fa fa-arrow-left"></i> Go Back',
            confirmButtonColor: isRetryable ? '#dc3545' : '#17a2b8',
            cancelButtonColor: '#6c757d',
            allowOutsideClick: false,
            allowEscapeKey: false,
            customClass: {
                popup: 'payment-failure-popup',
                confirmButton: 'payment-failure-confirm',
                cancelButton: 'payment-failure-cancel'
            },
            buttonsStyling: true
        };

        Swal.fire(swalConfig).then((result) => {
            if (result.isConfirmed) {
                if (isRetryable) {
                    // Show loading and retry payment
                    Swal.fire({
                        title: 'Retrying Payment...',
                        text: 'Please wait while we process your payment.',
                        icon: 'info',
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });
                    
                    // Delay retry to show loading
                    setTimeout(() => {
                        Swal.close();
                        payBtn.click();
                    }, 1500);
                } else {
                    // Contact support
                    showContactSupportDialog();
                }
            } else {
                // Go back to events
                showBookingCancelledDialog();
            }
        });
    }

    function showGenericPaymentError() {
        Swal.fire({
            title: 'Payment Error',
            html: `
                <div style="text-align: left; margin: 20px 0;">
                    <p style="margin-bottom: 15px;">We encountered an issue while processing your payment.</p>
                    <p style="margin-bottom: 15px; color: #666; font-size: 14px;">
                        <i class="fa fa-info-circle"></i> This could be due to network connectivity or server issues.
                    </p>
                    <p style="margin-bottom: 15px; color: #666; font-size: 14px;">
                        <i class="fa fa-shield"></i> No amount has been deducted from your account.
                    </p>
                </div>
            `,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: '<i class="fa fa-refresh"></i> Try Again',
            cancelButtonText: '<i class="fa fa-arrow-left"></i> Go Back',
            confirmButtonColor: '#17a2b8',
            cancelButtonColor: '#6c757d'
        }).then((result) => {
            if (result.isConfirmed) {
                payBtn.click();
            } else {
                showBookingCancelledDialog();
            }
        });
    }

    function showContactSupportDialog() {
        Swal.fire({
            title: 'Contact Support',
            html: `
                <div style="text-align: left; margin: 20px 0;">
                    <p style="margin-bottom: 15px;">Our support team is here to help you complete your booking.</p>
                    <div style="background: #f8f9fa; padding: 15px; border-radius: 8px; margin: 15px 0;">
                        <p style="margin: 5px 0;"><strong><i class="fa fa-phone"></i> Call:</strong> +91-XXXX-XXXX-XX</p>
                        <p style="margin: 5px 0;"><strong><i class="fa fa-envelope"></i> Email:</strong> support@yourwebsite.com</p>
                        <p style="margin: 5px 0;"><strong><i class="fa fa-clock"></i> Hours:</strong> 9 AM - 9 PM (Mon-Sun)</p>
                    </div>
                    <p style="margin-bottom: 15px; color: #666; font-size: 14px;">
                        <i class="fa fa-bookmark"></i> Keep your reference ID handy when contacting support.
                    </p>
                </div>
            `,
            icon: 'info',
            showCancelButton: true,
            confirmButtonText: '<i class="fa fa-refresh"></i> Try Payment Again',
            cancelButtonText: '<i class="fa fa-home"></i> Go to Homepage',
            confirmButtonColor: '#28a745',
            cancelButtonColor: '#6c757d'
        }).then((result) => {
            if (result.isConfirmed) {
                payBtn.click();
            } else {
                window.location.href = "{{ route('user.dashboard') }}";
            }
        });
    }

    function showBookingCancelledDialog() {
        Swal.fire({
            title: 'Booking Saved',
            html: `
                <div style="text-align: left; margin: 20px 0;">
                    <p style="margin-bottom: 15px;">Your booking details have been saved.</p>
                    <p style="margin-bottom: 15px; color: #666; font-size: 14px;">
                        <i class="fa fa-info-circle"></i> You can complete the payment anytime from your dashboard.
                    </p>
                </div>
            `,
            icon: 'info',
            showCancelButton: true,
            confirmButtonText: '<i class="fa fa-list"></i> View My Bookings',
            cancelButtonText: '<i class="fa fa-calendar"></i> Browse Events',
            confirmButtonColor: '#17a2b8',
            cancelButtonColor: '#6c757d'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = "{{ route('user.booking') }}";
            } else {
                window.location.href = "{{ route('event.list') }}";
            }
        });
    }

    function getErrorMessage(errorCode, errorDescription) {
        const errorMessages = {
            'BAD_REQUEST_ERROR': 'Invalid payment details. Please check your information.',
            'GATEWAY_ERROR': 'Payment gateway is temporarily unavailable. Please try again.',
            'NETWORK_ERROR': 'Network connection issue. Please check your internet connection.',
            'SERVER_ERROR': 'Server error occurred. Please try again after some time.',
            'PAYMENT_DECLINED': 'Payment was declined by your bank. Please contact your bank or try another payment method.',
            'INSUFFICIENT_FUNDS': 'Insufficient funds in your account. Please check your balance.',
            'INVALID_CARD': 'Invalid card details. Please check your card information.',
            'CARD_EXPIRED': 'Your card has expired. Please use a different card.',
            'CVV_MISMATCH': 'CVV mismatch. Please check your card security code.',
            'OTP_VERIFICATION_FAILED': 'OTP verification failed. Please try again.',
            'PAYMENT_CANCELLED': 'Payment was cancelled by you.',
            'PAYMENT_TIMEOUT': 'Payment session timed out. Please try again.'
        };

        return errorMessages[errorCode] || errorDescription || 'An unexpected error occurred. Please try again.';
    }

    function isRetryableError(errorCode) {
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
    border-top: 4px solid #0a58ca;
    border-radius: 50%;
    animation: spin 1s linear infinite;
}
</style>

@endsection
