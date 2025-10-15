@extends('admin.layouts.layout')

@section('styles')
<meta name=\"csrf-token\" content=\"{{ csrf_token() }}\">
<style>
    .confirmation-card {
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.08);
        margin-bottom: 1.5rem;
    }

    .info-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 12px 0;
        border-bottom: 1px solid #f0f0f0;
    }

    .info-row:last-child {
        border-bottom: none;
    }

    .info-label {
        font-weight: 600;
        color: #555;
    }

    .info-value {
        color: #333;
    }

    .booking-summary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border-radius: 12px;
        padding: 2rem;
        margin-bottom: 2rem;
    }

    .total-amount {
        font-size: 2rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
    }

    .datetime-item {
        background: #f8f9fa;
        border-radius: 8px;
        padding: 15px;
        margin-bottom: 10px;
        border-left: 4px solid #667eea;
    }

    .datetime-item strong {
        color: #333;
    }

    .confirm-btn {
        background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
        border: none;
        padding: 15px 30px;
        font-size: 1.1rem;
        font-weight: 600;
        border-radius: 8px;
        color: white;
        transition: all 0.3s ease;
    }

    .confirm-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(40, 167, 69, 0.3);
        color: white;
    }
</style>
@endsection

@section('content')
<div class="main-content app-content">
    <div class="container-fluid">
        <!-- Page Header -->
        <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
            <div>
                <h1 class="page-title fw-medium fs-18 mb-2">Confirm Booking</h1>
                <div>
                    <nav>
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('admin.admin-booking.index') }}">Admin Bookings</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Confirm Booking</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <!-- Progress Steps -->
        <div class="card custom-card mb-4">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center">
                        <span class="badge bg-success rounded-pill me-2">1</span>
                        <span class="text-success fw-semibold">Customer Selected</span>
                    </div>
                    <div class="d-flex align-items-center">
                        <span class="badge bg-success rounded-pill me-2">2</span>
                        <span class="text-success fw-semibold">Service Selected</span>
                    </div>
                    <div class="d-flex align-items-center">
                        <span class="badge bg-success rounded-pill me-2">3</span>
                        <span class="text-success fw-semibold">Professional Selected</span>
                    </div>
                    <div class="d-flex align-items-center">
                        <span class="badge bg-success rounded-pill me-2">4</span>
                        <span class="text-success fw-semibold">Session Selected</span>
                    </div>
                    <div class="d-flex align-items-center">
                        <span class="badge bg-success rounded-pill me-2">5</span>
                        <span class="text-success fw-semibold">Date & Time Selected</span>
                    </div>
                    <div class="d-flex align-items-center">
                        <span class="badge bg-primary rounded-pill me-2">6</span>
                        <span class="text-primary fw-semibold">Confirm Booking</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Booking Summary -->
        <div class="booking-summary">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h3 class="mb-2">Booking Summary</h3>
                    <p class="mb-0 opacity-90">Please review the booking details before confirming</p>
                </div>
                <div class="col-md-4 text-end">
                    <div class="total-amount">Rs. {{ number_format($selectedRate->final_rate ?? 0, 2) }}</div>
                    <p class="mb-0 opacity-90">Total Amount</p>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Customer Information -->
            <div class="col-md-6">
                <div class="card custom-card">
                    <div class="card-header">
                        <div class="card-title">
                            <i class="ri-user-line me-2"></i>Customer Information
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="info-row">
                            <span class="info-label">Name:</span>
                            <span class="info-value">{{ $customer->name }}</span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">Email:</span>
                            <span class="info-value">{{ $customer->email }}</span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">Phone:</span>
                            <span class="info-value">{{ $customer->phone ?? 'Not provided' }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Professional Information -->
            <div class="col-md-6">
                <div class="card custom-card">
                    <div class="card-header">
                        <div class="card-title">
                            <i class="ri-user-star-line me-2"></i>Professional Information
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="info-row">
                            <span class="info-label">Name:</span>
                            <span class="info-value">{{ $professional->name }}</span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">Email:</span>
                            <span class="info-value">{{ $professional->email }}</span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">Specialization:</span>
                            <span class="info-value">{{ $professional->specialization ?? 'Not specified' }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Service & Session Details -->
            <div class="col-md-6">
                <div class="card custom-card">
                    <div class="card-header">
                        <div class="card-title">
                            <i class="ri-service-line me-2"></i>Service & Session Details
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="info-row">
                            <span class="info-label">Service:</span>
                            <span class="info-value">{{ $service->name ?? 'Service' }}</span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">Session Type:</span>
                            <span class="info-value">{{ $selectedRate->session_type }}</span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">Number of Sessions:</span>
                            <span class="info-value">{{ $selectedRate->num_sessions ?? 1 }}</span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">Duration:</span>
                            <span class="info-value">{{ $selectedRate->duration ?? '60 mins' }}</span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">Rate:</span>
                            <span class="info-value">Rs. {{ number_format($selectedRate->final_rate ?? 0, 2) }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Selected Date & Time -->
            <div class="col-md-6">
                <div class="card custom-card">
                    <div class="card-header">
                        <div class="card-title">
                            <i class="ri-calendar-check-line me-2"></i>Selected Date & Time
                        </div>
                    </div>
                    <div class="card-body">
                        @if(!empty($datetimeSelections))
                            @foreach($datetimeSelections as $datetime)
                                <div class="datetime-item">
                                    <strong>{{ Carbon\Carbon::parse($datetime['date'])->format('l, F j, Y') }}</strong><br>
                                    <span class="text-muted">{{ $datetime['time_slot'] }}</span>
                                </div>
                            @endforeach
                        @else
                            <p class="text-muted">No date and time selected</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Confirmation Actions -->
        <div class="card custom-card">
            <div class="card-body">
                @if($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <form method="POST" action="{{ route('admin.admin-booking.process-booking') }}" id="confirm-form">
                    @csrf
                    
                    <!-- Payment Status Selection -->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label for="payment_status" class="form-label">Payment Status</label>
                            <select name="payment_status" id="payment_status" class="form-select" required>
                                <option value="">-- Select payment status --</option>
                                <option value="paid">Paid (Payment Completed)</option>
                                <option value="pending">Pending (Payment Required)</option>
                            </select>
                            <small class="text-muted">Select payment status for this booking</small>
                        </div>
                    </div>
                    
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="mb-1">Ready to Confirm?</h5>
                            <p class="text-muted mb-0">This will create the booking and send confirmation to the customer.</p>
                        </div>
                        <div>
                            <a href="{{ route('admin.admin-booking.select-datetime') }}" class="btn btn-secondary me-2">
                                <i class="ri-arrow-left-line me-1"></i>Back
                            </a>
                            <button type="submit" class="btn confirm-btn" id="confirm-btn">
                                <i class="ri-check-line me-1"></i>Confirm Booking
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const confirmForm = document.getElementById('confirm-form');
    const confirmBtn = document.getElementById('confirm-btn');
    const paymentStatusSelect = document.getElementById('payment_status');
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || 
                     document.querySelector('input[name="_token"]')?.value;

    confirmForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const paymentStatus = paymentStatusSelect.value;
        // Client-side validation: ensure payment status is selected
        if (!paymentStatus) {
            Swal.fire({
                title: 'Select Payment Status',
                text: 'Please select a payment status before confirming the booking.',
                icon: 'warning',
                confirmButtonText: 'OK'
            });
            return;
        }

        if (paymentStatus === 'paid') {
            // Direct booking confirmation for paid status
            processDirectBooking();
        } else {
            // Process payment for pending status
            processPayment();
        }
    });
    
    function processDirectBooking() {
        // Show loading state
        confirmBtn.disabled = true;
        confirmBtn.innerHTML = '<i class="ri-loader-line me-1"></i>Processing...';
        
        // Submit the form directly
        const formData = new FormData(confirmForm);
        
        fetch(confirmForm.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
            }
        })
        .then(response => {
            if (response.ok) {
                return response.json();
            }
            throw new Error('Network response was not ok');
        })
        .then(data => {
            console.log('Direct booking response:', data);
            if (data.status === 'success') {
                // Show success message and redirect to success page
                Swal.fire({
                    title: 'Booking Confirmed!',
                    text: 'Booking has been created successfully.',
                    icon: 'success',
                    timer: 2000,
                    showConfirmButton: false
                }).then(() => {
                    // Use the redirect URL from backend or go to index
                    if (data.redirect) {
                        window.location.href = data.redirect;
                    } else {
                        window.location.href = '{{ route("admin.admin-booking.index") }}?booking_created=' + (data.booking_id || '');
                    }
                });
            } else {
                alert('Error: ' + (data.message || 'Failed to create booking'));
                confirmBtn.disabled = false;
                confirmBtn.innerHTML = '<i class="ri-check-line me-1"></i>Confirm Booking';
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error processing booking. Please try again.');
            // Reset button
            confirmBtn.disabled = false;
            confirmBtn.innerHTML = '<i class="ri-check-line me-1"></i>Confirm Booking';
        });
    }
    
    function processPayment() {
        // Show loading state
        confirmBtn.disabled = true;
        confirmBtn.innerHTML = '<i class="ri-loader-line me-1"></i>Initiating Payment...';
        
        // First, initiate payment
        fetch('{{ route("admin.admin-booking.initiate-payment") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json',
            },
            body: JSON.stringify({})
        })
        .then(res => res.json())
        .then(data => {
            if (data.status === 'success') {
                // Reset button before showing Razorpay
                confirmBtn.innerHTML = '<i class="ri-check-line me-1"></i>Confirm Booking';
                confirmBtn.disabled = false;
                
                // Initialize Razorpay
                const options = {
                    key: data.key,
                    amount: data.amount,
                    currency: "INR",
                    name: "Tazen Admin",
                    description: "Admin Booking Payment",
                    order_id: data.order_id,
                    handler: function (response) {
                        // Show payment success loading
                        confirmBtn.disabled = true;
                        confirmBtn.innerHTML = '<i class="ri-loader-line me-1"></i>Verifying Payment...';
                        
                        // Verify payment
                        fetch('{{ route("admin.admin-booking.verify-payment") }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': csrfToken,
                                'Accept': 'application/json',
                            },
                            body: JSON.stringify({
                                razorpay_payment_id: response.razorpay_payment_id,
                                razorpay_order_id: response.razorpay_order_id,
                                razorpay_signature: response.razorpay_signature
                            })
                        })
                        .then(res => {
                            if (!res.ok) {
                                throw new Error(`HTTP ${res.status}: ${res.statusText}`);
                            }
                            return res.json();
                        })
                        .then(data => {
                            if (data.status === 'success') {
                                // Show success message
                                Swal.fire({
                                    title: 'Success!',
                                    text: data.message || 'Payment verified and booking confirmed!',
                                    icon: 'success',
                                    timer: 2000,
                                    showConfirmButton: false
                                }).then(() => {
                                    if (data.redirect) {
                                        window.location.href = data.redirect;
                                    } else {
                                        window.location.href = '/admin/admin-booking?booking_created=' + data.booking_id;
                                    }
                                });
                            } else {
                                throw new Error(data.message || 'Payment verification failed');
                            }
                        })
                        .catch(error => {
                            Swal.fire({
                                title: 'Payment Verification Error',
                                text: 'Payment verification failed. Please contact support with your payment details.',
                                icon: 'error',
                                confirmButtonText: 'OK'
                            });
                            confirmBtn.disabled = false;
                            confirmBtn.innerHTML = '<i class="ri-check-line me-1"></i>Confirm Booking';
                        });
                    },
                    prefill: {
                        name: data.name,
                        email: data.email,
                        contact: data.phone
                    },
                    theme: {
                        color: "#667eea"
                    }
                };
                
                const rzp = new Razorpay(options);
                rzp.open();
                
                // Handle payment failure
                rzp.on('payment.failed', function (response) {
                    console.error('Payment failed:', response.error);
                    alert('Payment failed: ' + response.error.description);
                    confirmBtn.disabled = false;
                    confirmBtn.innerHTML = '<i class="ri-check-line me-1"></i>Confirm Booking';
                });
            } else {
                alert('Payment initiation failed: ' + (data.message || 'Unknown error'));
                confirmBtn.disabled = false;
                confirmBtn.innerHTML = '<i class="ri-check-line me-1"></i>Confirm Booking';
            }
        })
        .catch(error => {
            console.error('Payment initiation error:', error);
            alert('Payment initiation failed. Please try again.');
            confirmBtn.disabled = false;
            confirmBtn.innerHTML = '<i class="ri-check-line me-1"></i>Confirm Booking';
        });
    }
});
</script>
@endsection