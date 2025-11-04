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

    /* Payment Popup Styles */
    .payment-popup-overlay {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.7);
        z-index: 9999;
        justify-content: center;
        align-items: center;
    }

    .payment-popup-overlay.show {
        display: flex;
    }

    .payment-popup-content {
        background: white;
        border-radius: 12px;
        padding: 2rem;
        max-width: 500px;
        width: 90%;
        max-height: 90vh;
        overflow-y: auto;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.3);
    }

    .payment-popup-header {
        border-bottom: 2px solid #f0f0f0;
        padding-bottom: 1rem;
        margin-bottom: 1.5rem;
    }

    .payment-popup-header h4 {
        margin: 0;
        color: #333;
        font-weight: 600;
    }

    .popup-close-btn {
        position: absolute;
        top: 1rem;
        right: 1rem;
        background: none;
        border: none;
        font-size: 1.5rem;
        cursor: pointer;
        color: #666;
        transition: color 0.3s;
    }

    .popup-close-btn:hover {
        color: #333;
    }

    .payment-form-group {
        margin-bottom: 1.5rem;
    }

    .payment-form-group label {
        font-weight: 600;
        color: #555;
        margin-bottom: 0.5rem;
        display: block;
    }

    .payment-form-group input,
    .payment-form-group select {
        width: 100%;
        padding: 0.75rem;
        border: 1px solid #ddd;
        border-radius: 8px;
        transition: border-color 0.3s;
    }

    .payment-form-group input:focus,
    .payment-form-group select:focus {
        outline: none;
        border-color: #667eea;
    }

    .payment-form-group small {
        display: block;
        margin-top: 0.25rem;
        color: #6c757d;
    }

    .popup-actions {
        display: flex;
        gap: 1rem;
        margin-top: 2rem;
    }

    .popup-actions button {
        flex: 1;
        padding: 0.75rem;
        border-radius: 8px;
        font-weight: 600;
        border: none;
        cursor: pointer;
        transition: all 0.3s;
    }

    .popup-submit-btn {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
    }

    .popup-submit-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(102, 126, 234, 0.3);
    }

    .popup-cancel-btn {
        background: #f0f0f0;
        color: #333;
    }

    .popup-cancel-btn:hover {
        background: #e0e0e0;
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
            <div class="row">
                <div class="col-md-7">
                    <h3 class="mb-2">Booking Summary</h3>
                    <p class="mb-0 opacity-90">Please review the booking details before confirming</p>
                </div>
                <div class="col-md-5 text-end">
                    @php
                        $baseAmount = $selectedRate->final_rate ?? 0;
                        $cgst = $baseAmount * 0.09; // 9% CGST
                        $sgst = $baseAmount * 0.09; // 9% SGST
                        $totalAmount = $baseAmount + $cgst + $sgst;
                    @endphp
                    
                    <div class="mb-2">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <span class="opacity-90">Base Amount:</span>
                            <span class="fw-semibold">Rs. {{ number_format($baseAmount, 2) }}</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <span class="opacity-90">CGST (9%):</span>
                            <span class="fw-semibold">Rs. {{ number_format($cgst, 2) }}</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="opacity-90">SGST (9%):</span>
                            <span class="fw-semibold">Rs. {{ number_format($sgst, 2) }}</span>
                        </div>
                        <hr class="my-2 opacity-50">
                    </div>
                    
                    <div class="total-amount">Rs. {{ number_format($totalAmount, 2) }}</div>
                    <p class="mb-0 opacity-90">Total Amount (incl. taxes)</p>
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
                        @if(isset($subService) && $subService)
                        <div class="info-row">
                            <span class="info-label">Sub-Service:</span>
                            <span class="info-value">{{ $subService->name }}</span>
                        </div>
                        @endif
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
                                <option value="paid">Paid (Offline Payment - Enter Details Manually)</option>
                                <option value="pending" selected>Pending (Online Payment - Razorpay Gateway)</option>
                            </select>
                            <small class="text-muted">
                                <strong>Paid:</strong> For cash/bank transfer payments already received<br>
                                <strong>Pending:</strong> For online payment via Razorpay
                            </small>
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

        <!-- Payment Popup Form -->
        <div class="payment-popup-overlay" id="paymentPopup">
            <div class="payment-popup-content">
                <div class="payment-popup-header" style="position: relative;">
                    <h4><i class="ri-secure-payment-line me-2"></i>Payment Details</h4>
                    <button type="button" class="popup-close-btn" id="closePopupBtn">
                        <i class="ri-close-line"></i>
                    </button>
                </div>
                <form id="paymentDetailsForm">
                    <div class="payment-form-group">
                        <label for="transaction_id">Transaction ID <span class="text-danger">*</span></label>
                        <input type="text" id="transaction_id" name="transaction_id" class="form-control" placeholder="Enter transaction ID" required>
                        <small>Enter the unique transaction reference number</small>
                    </div>

                    <div class="payment-form-group">
                        <label for="payment_screenshot">Payment Screenshot</label>
                        <input type="file" id="payment_screenshot" name="payment_screenshot" class="form-control" accept="image/*,application/pdf">
                        <small>Upload proof of payment (JPG, PNG, PDF) - Optional</small>
                    </div>

                    <div class="payment-form-group">
                        <label for="payment_method">Payment Method</label>
                        <select id="payment_method" name="payment_method" class="form-control">
                            <option value="">-- Select payment method --</option>
                            <option value="bank_transfer">Bank Transfer</option>
                            <option value="upi">UPI</option>
                            <option value="cash">Cash</option>
                            <option value="cheque">Cheque</option>
                            <option value="credit_card">Credit Card</option>
                            <option value="debit_card">Debit Card</option>
                            <option value="other">Other</option>
                        </select>
                    </div>

                    <div class="payment-form-group">
                        <label for="payment_notes">Additional Notes</label>
                        <textarea id="payment_notes" name="payment_notes" class="form-control" rows="3" placeholder="Any additional information about the payment..."></textarea>
                    </div>

                    <div class="popup-actions">
                        <button type="button" class="popup-cancel-btn" id="cancelPopupBtn">Cancel</button>
                        <button type="submit" class="popup-submit-btn" id="submitPaymentBtn">
                            <i class="ri-check-line me-1"></i>Submit Payment
                        </button>
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

    // Payment popup elements
    const paymentPopup = document.getElementById('paymentPopup');
    const paymentDetailsForm = document.getElementById('paymentDetailsForm');
    const closePopupBtn = document.getElementById('closePopupBtn');
    const cancelPopupBtn = document.getElementById('cancelPopupBtn');
    const submitPaymentBtn = document.getElementById('submitPaymentBtn');

    // Store payment details
    let paymentDetails = {
        transaction_id: '',
        payment_screenshot: null,
        payment_method: '',
        payment_notes: ''
    };

    // Close popup handlers
    closePopupBtn.addEventListener('click', closePaymentPopup);
    cancelPopupBtn.addEventListener('click', closePaymentPopup);
    
    paymentPopup.addEventListener('click', function(e) {
        if (e.target === paymentPopup) {
            closePaymentPopup();
        }
    });

    function closePaymentPopup() {
        paymentPopup.classList.remove('show');
        paymentDetailsForm.reset();
    }

    function openPaymentPopup() {
        paymentPopup.classList.add('show');
    }

    // Payment details form submission
    paymentDetailsForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        // Validate required fields
        const transactionId = document.getElementById('transaction_id').value.trim();
        
        if (!transactionId) {
            Swal.fire({
                title: 'Missing Information',
                text: 'Please enter the transaction ID.',
                icon: 'warning',
                confirmButtonText: 'OK'
            });
            return;
        }
        
        // Store payment details
        paymentDetails.transaction_id = transactionId;
        paymentDetails.payment_screenshot = document.getElementById('payment_screenshot').files[0] || null;
        paymentDetails.payment_method = document.getElementById('payment_method').value;
        paymentDetails.payment_notes = document.getElementById('payment_notes').value;

        // Close popup
        closePaymentPopup();

        // Process direct booking with payment details
        processDirectBookingWithPayment();
    });

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
            // Show payment details popup for offline/manual payment
            openPaymentPopup();
        } else if (paymentStatus === 'pending') {
            // Process Razorpay payment for pending status
            processPayment();
        } else {
            // Process payment for other statuses
            processPayment();
        }
    });
    
    function processDirectBookingWithPayment() {
        // Show loading state
        confirmBtn.disabled = true;
        confirmBtn.innerHTML = '<i class="ri-loader-line me-1"></i>Processing...';
        
        // Create FormData and append payment details
        const formData = new FormData(confirmForm);
        
        // Append payment details
        if (paymentDetails.transaction_id) {
            formData.append('transaction_id', paymentDetails.transaction_id);
        }
        if (paymentDetails.payment_screenshot && paymentDetails.payment_screenshot instanceof File) {
            formData.append('payment_screenshot', paymentDetails.payment_screenshot);
        }
        if (paymentDetails.payment_method) {
            formData.append('payment_method', paymentDetails.payment_method);
        }
        if (paymentDetails.payment_notes) {
            formData.append('payment_notes', paymentDetails.payment_notes);
        }
        
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
                    text: 'Booking has been created successfully with payment details.',
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
                Swal.fire({
                    title: 'Error',
                    text: data.message || 'Failed to create booking',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
                confirmBtn.disabled = false;
                confirmBtn.innerHTML = '<i class="ri-check-line me-1"></i>Confirm Booking';
            }
        })
        .catch(error => {
            console.error('Error:', error);
            Swal.fire({
                title: 'Error',
                text: 'Error processing booking. Please try again.',
                icon: 'error',
                confirmButtonText: 'OK'
            });
            // Reset button
            confirmBtn.disabled = false;
            confirmBtn.innerHTML = '<i class="ri-check-line me-1"></i>Confirm Booking';
        });
    }

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
            console.log('Response status:', response.status);
            if (!response.ok) {
                return response.json().then(err => {
                    throw new Error(err.message || 'Failed to create booking');
                });
            }
            return response.json();
        })
        .then(data => {
            console.log('Direct booking response:', data);
            if (data.status === 'success') {
                // Show success message and redirect to index page
                Swal.fire({
                    title: 'Booking Confirmed!',
                    text: data.message || 'Booking has been created successfully.',
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
                Swal.fire({
                    title: 'Error',
                    text: data.message || 'Failed to create booking',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
                confirmBtn.disabled = false;
                confirmBtn.innerHTML = '<i class="ri-check-line me-1"></i>Confirm Booking';
            }
        })
        .catch(error => {
            console.error('Error:', error);
            Swal.fire({
                title: 'Error',
                text: error.message || 'Error processing booking. Please try again.',
                icon: 'error',
                confirmButtonText: 'OK'
            });
            // Reset button
            confirmBtn.disabled = false;
            confirmBtn.innerHTML = '<i class="ri-check-line me-1"></i>Confirm Booking';
        });
    }
    
    function processPayment() {
        // Show loading state
        confirmBtn.disabled = true;
        confirmBtn.innerHTML = '<i class="ri-loader-line me-1"></i>Initiating Payment...';
        
        console.log('Starting payment initiation...');
        
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
        .then(res => {
            console.log('Initiate payment response status:', res.status);
            return res.json();
        })
        .then(data => {
            console.log('Initiate payment response data:', data);
            if (data.status === 'success') {
                // Reset button before showing Razorpay
                confirmBtn.innerHTML = '<i class="ri-check-line me-1"></i>Confirm Booking';
                confirmBtn.disabled = false;
                
                console.log('Opening Razorpay with order_id:', data.order_id);
                
                // Initialize Razorpay
                const options = {
                    key: data.key,
                    amount: data.amount,
                    currency: "INR",
                    name: "Tazen Admin",
                    description: "Admin Booking Payment",
                    order_id: data.order_id,
                    modal: {
                        ondismiss: function() {
                            console.log('Razorpay modal dismissed by user');
                            Swal.fire({
                                title: 'Payment Cancelled',
                                text: 'You have cancelled the payment. Please try again.',
                                icon: 'warning',
                                confirmButtonText: 'OK'
                            });
                            confirmBtn.disabled = false;
                            confirmBtn.innerHTML = '<i class="ri-check-line me-1"></i>Confirm Booking';
                        },
                        escape: false, // Prevent closing on ESC
                        backdropclose: false // Prevent closing on backdrop click
                    },
                    handler: function (response) {
                        console.log('=== RAZORPAY HANDLER TRIGGERED ===');
                        console.log('Razorpay payment successful, response:', response);
                        
                        // Prevent any default behavior
                        if (event && event.preventDefault) {
                            event.preventDefault();
                        }
                        
                        // Show payment success loading
                        confirmBtn.disabled = true;
                        confirmBtn.innerHTML = '<i class="ri-loader-line me-1"></i>Verifying Payment...';
                        
                        // Verify payment
                        console.log('Sending verification request...');
                        
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
                            console.log('Verify payment response status:', res.status);
                            if (!res.ok) {
                                return res.text().then(text => {
                                    console.error('Verify payment error response:', text);
                                    throw new Error(`HTTP ${res.status}: ${text}`);
                                });
                            }
                            return res.json();
                        })
                        .then(data => {
                            console.log('Verify payment response data:', data);
                            
                            // IMPORTANT: Remove beforeunload warning FIRST before any action
                            window.onbeforeunload = null;
                            
                            if (data.status === 'success') {
                                // Show success message
                                Swal.fire({
                                    title: 'Success!',
                                    text: data.message || 'Payment verified and booking confirmed!',
                                    icon: 'success',
                                    timer: 2000,
                                    showConfirmButton: false,
                                    allowOutsideClick: false,
                                    allowEscapeKey: false
                                }).then(() => {
                                    console.log('Redirecting to:', data.redirect);
                                    // Final check: ensure onbeforeunload is removed
                                    window.onbeforeunload = null;
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
                            window.onbeforeunload = null; // Remove the warning
                            console.error('Payment verification error:', error);
                            Swal.fire({
                                title: 'Payment Verification Error',
                                text: error.message || 'Payment verification failed. Please contact support with your payment details.',
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
                    },
                    notes: {
                        booking_type: 'admin_booking',
                        customer_id: '{{ session("admin_booking_customer_id") }}',
                        professional_id: '{{ session("admin_booking_professional_id") }}'
                    },
                    redirect: false // Prevent automatic redirect
                };
                
                console.log('Creating Razorpay instance with options:', options);
                const rzp = new Razorpay(options);
                
                // Open Razorpay
                console.log('Opening Razorpay modal...');
                rzp.open();
                
                // Prevent any form submission or page navigation
                window.onbeforeunload = function() {
                    return "Payment is in progress. Are you sure you want to leave?";
                };
                
                // Handle payment failure
                rzp.on('payment.failed', function (response) {
                    console.error('=== RAZORPAY PAYMENT FAILED ===');
                    console.error('Razorpay payment failed:', response.error);
                    window.onbeforeunload = null; // Remove the warning
                    Swal.fire({
                        title: 'Payment Failed',
                        text: response.error.description || 'Payment failed. Please try again.',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                    confirmBtn.disabled = false;
                    confirmBtn.innerHTML = '<i class="ri-check-line me-1"></i>Confirm Booking';
                });
            } else {
                console.error('Payment initiation failed:', data);
                Swal.fire({
                    title: 'Payment Initiation Failed',
                    text: data.message || 'Unknown error occurred',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
                confirmBtn.disabled = false;
                confirmBtn.innerHTML = '<i class="ri-check-line me-1"></i>Confirm Booking';
            }
        })
        .catch(error => {
            console.error('Payment initiation error:', error);
            Swal.fire({
                title: 'Payment Initiation Failed',
                text: error.message || 'Payment initiation failed. Please try again.',
                icon: 'error',
                confirmButtonText: 'OK'
            });
            confirmBtn.disabled = false;
            confirmBtn.innerHTML = '<i class="ri-check-line me-1"></i>Confirm Booking';
        });
    }
});
</script>
@endsection