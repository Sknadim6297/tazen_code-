@extends('admin.layouts.layout')

@section('styles')
<meta name="csrf-token" content="{{ csrf_token() }}">
<style>
    /* Form styling consistent with admin panel */
    .form-label {
        font-size: 0.875rem;
        font-weight: 500;
        color: #6c757d;
        margin-bottom: 0.5rem;
    }

    .form-control, .form-select {
        border: 1px solid #e9ecef;
        padding: 0.75rem 1rem;
        font-size: 0.875rem;
        transition: all 0.3s ease;
    }

    .form-control:focus, .form-select:focus {
        border-color: #66                        if (customersArray.length > 0) {
                            html = '<div class="list-group mt-2">';
                            customersArray.forEach(customer => {a;
        box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
    }

    .btn-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: none;
        border-radius: 8px;
        padding: 0.75rem 1.5rem;
        font-weight: 500;
        transition: all 0.3s ease;
        box-shadow: 0 2px 8px rgba(102, 126, 234, 0.3);
    }

    .btn-primary:hover {
        background: linear-gradient(135deg, #5a6fd8 0%, #6a4190 100%);
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
    }

    .customer-type-card {
        border: 2px solid #e9ecef;
        border-radius: 12px;
        padding: 1.5rem;
        text-align: center;
        cursor: pointer;
        transition: all 0.3s ease;
        background: #fafbfc;
    }

    .customer-type-card:hover {
        border-color: #667eea;
        background: #f0f2ff;
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(102, 126, 234, 0.15);
    }

    .customer-type-card.selected {
        border-color: #667eea;
        background: rgba(102, 126, 234, 0.1);
    }

    .customer-type-card .icon {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1rem;
        font-size: 1.5rem;
    }

    .existing-customer .icon {
        background: rgba(25, 135, 84, 0.1);
        color: #198754;
    }

    .new-customer .icon {
        background: rgba(13, 110, 253, 0.1);
        color: #0d6efd;
    }

    .new-customer-form {
        display: none;
        margin-top: 2rem;
        padding: 2rem;
        background: #f8f9fa;
        border-radius: 12px;
        border: 1px solid #e9ecef;
    }

    .existing-customer-form {
        display: none;
        margin-top: 2rem;
        padding: 2rem;
        background: #f8f9fa;
        border-radius: 12px;
        border: 1px solid #e9ecef;
    }
</style>
@endsection

@section('content')
<div class="main-content app-content">
    <div class="container-fluid">
        <!-- Page Header -->
        <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
            <div>
                <h1 class="page-title fw-medium fs-18 mb-2">Create Admin Booking</h1>
                <div>
                    <nav>
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('admin.admin-booking.index') }}">Admin Bookings</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Create Booking</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <!-- Create Booking Form -->
        <div class="card custom-card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="ri-user-add-line me-2 text-primary"></i>
                    Step 1: Select or Create Customer
                </h5>
            </div>
            <div class="card-body">
                @if($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <form action="{{ route('admin.admin-booking.select-customer') }}" method="POST" id="customerForm">
                    @csrf
                    
                    <!-- Customer Type Selection -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <h6 class="fw-semibold mb-3">Choose Customer Type</h6>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="customer-type-card existing-customer" data-type="existing">
                                <div class="icon">
                                    <i class="ri-user-search-line"></i>
                                </div>
                                <h6 class="fw-semibold">Existing Customer</h6>
                                <p class="text-muted mb-0">Select from registered customers</p>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="customer-type-card new-customer" data-type="new">
                                <div class="icon">
                                    <i class="ri-user-add-line"></i>
                                </div>
                                <h6 class="fw-semibold">New Customer</h6>
                                <p class="text-muted mb-0">Create a new customer account</p>
                            </div>
                        </div>
                    </div>

                    <input type="hidden" name="customer_type" id="customerType" required>

                    <!-- Existing Customer Section -->
                    <div id="existing_customer_section" class="d-none">
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <label for="customer_search" class="form-label">Search Customer</label>
                                <input type="text" id="customer_search" class="form-control" placeholder="Search by name, email, or phone...">
                                <input type="hidden" name="customer_id" id="customer_id" value="{{ old('customer_id') }}">
                                <div id="customer_results" class="position-relative">
                                    <!-- Search results will appear here -->
                                </div>
                            </div>
                        </div>
                        
                        <div id="selected_customer" class="d-none">
                            <div class="alert alert-success">
                                <h6 class="mb-1">Selected Customer:</h6>
                                <div id="customer_details"></div>
                            </div>
                        </div>
                    </div>

                    <!-- New Customer Section -->
                    <div id="new_customer_section" class="d-none">
                        <!-- Step 1: Customer Details -->
                        <div id="customer_details_step">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="first_name" class="form-label">First Name <span class="text-danger">*</span></label>
                                    <input type="text" name="first_name" id="first_name" class="form-control" value="{{ old('first_name') }}" placeholder="Enter first name">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="last_name" class="form-label">Last Name <span class="text-danger">*</span></label>
                                    <input type="text" name="last_name" id="last_name" class="form-control" value="{{ old('last_name') }}" placeholder="Enter last name">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                                    <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}" placeholder="Enter email address">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="phone" class="form-label">Phone <span class="text-danger">*</span></label>
                                    <input type="tel" name="phone" id="phone" class="form-control" value="{{ old('phone') }}" placeholder="Enter phone number">
                                </div>
                            </div>
                            
                            <div class="alert alert-info">
                                <h6 class="mb-1"><i class="ri-information-line me-1"></i>Next Step:</h6>
                                <p class="mb-0">After filling the details, an OTP will be sent to the email for verification.</p>
                            </div>

                            <button type="button" id="send_otp_btn" class="btn btn-primary">
                                <i class="ri-mail-send-line me-1"></i>Send OTP
                            </button>
                        </div>

                        <!-- Step 2: OTP Verification -->
                        <div id="otp_verification_step" class="d-none">
                            <div class="alert alert-success">
                                <h6 class="mb-1"><i class="ri-check-line me-1"></i>OTP Sent!</h6>
                                <p class="mb-0">Please check the email and enter the 6-digit OTP code below.</p>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="otp_code" class="form-label">Enter OTP <span class="text-danger">*</span></label>
                                    <input type="text" name="otp_code" id="otp_code" class="form-control" placeholder="Enter 6-digit OTP" maxlength="6">
                                </div>
                            </div>

                            <button type="button" id="verify_otp_btn" class="btn btn-success">
                                <i class="ri-shield-check-line me-1"></i>Verify OTP
                            </button>
                            <button type="button" id="resend_otp_btn" class="btn btn-outline-secondary ms-2">
                                <i class="ri-refresh-line me-1"></i>Resend OTP
                            </button>
                        </div>

                        <!-- Step 3: Set Password -->
                        <div id="password_step" class="d-none">
                            <div class="alert alert-success">
                                <h6 class="mb-1"><i class="ri-check-line me-1"></i>OTP Verified!</h6>
                                <p class="mb-0">Now set a password for the customer account.</p>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="password" class="form-label">Password <span class="text-danger">*</span></label>
                                    <input type="password" name="password" id="password" class="form-control" placeholder="Enter password" minlength="8">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="password_confirmation" class="form-label">Confirm Password <span class="text-danger">*</span></label>
                                    <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" placeholder="Confirm password">
                                </div>
                            </div>

                            <div class="alert alert-info">
                                <h6 class="mb-1"><i class="ri-information-line me-1"></i>Password Requirements:</h6>
                                <p class="mb-0">Password must be at least 8 characters long.</p>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <button type="submit" id="main_submit_btn" class="btn btn-primary" style="display: none;">
                                <i class="ri-arrow-right-line me-1"></i>Next: Select Service
                            </button>
                            <a href="{{ route('admin.admin-booking.index') }}" class="btn btn-secondary ms-2">
                                <i class="ri-arrow-left-line me-1"></i>Cancel
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Get all elements
    const customerTypeCards = document.querySelectorAll('.customer-type-card');
    const customerTypeInput = document.getElementById('customerType');
    const existingSection = document.getElementById('existing_customer_section');
    const newSection = document.getElementById('new_customer_section');
    const customerSearch = document.getElementById('customer_search');
    const customerResults = document.getElementById('customer_results');
    const customerIdInput = document.getElementById('customer_id');
    const selectedCustomerDiv = document.getElementById('selected_customer');
    const customerDetailsDiv = document.getElementById('customer_details');
    const mainSubmitBtn = document.getElementById('main_submit_btn');

    // New customer flow elements
    const customerDetailsStep = document.getElementById('customer_details_step');
    const otpVerificationStep = document.getElementById('otp_verification_step');
    const passwordStep = document.getElementById('password_step');
    const sendOtpBtn = document.getElementById('send_otp_btn');
    const verifyOtpBtn = document.getElementById('verify_otp_btn');
    const resendOtpBtn = document.getElementById('resend_otp_btn');

    let currentCustomerId = null;
    let otpToken = null;

    // Customer type card selection
    customerTypeCards.forEach(card => {
        card.addEventListener('click', function() {
            // Remove selected class from all cards
            customerTypeCards.forEach(c => c.classList.remove('selected'));
            // Add selected class to clicked card
            this.classList.add('selected');
            
            const type = this.dataset.type;
            customerTypeInput.value = type;
            
            // Show/hide sections
            if (type === 'existing') {
                existingSection.classList.remove('d-none');
                newSection.classList.add('d-none');
                mainSubmitBtn.style.display = 'none';
            } else if (type === 'new') {
                newSection.classList.remove('d-none');
                existingSection.classList.add('d-none');
                // Reset to first step
                resetNewCustomerFlow();
                mainSubmitBtn.style.display = 'none';
            }
        });
    });

    // Reset new customer flow to first step
    function resetNewCustomerFlow() {
        customerDetailsStep.classList.remove('d-none');
        otpVerificationStep.classList.add('d-none');
        passwordStep.classList.add('d-none');
        currentCustomerId = null;
        otpToken = null;
    }

    // Send OTP
    sendOtpBtn.addEventListener('click', function() {
        const firstName = document.getElementById('first_name').value.trim();
        const lastName = document.getElementById('last_name').value.trim();
        const email = document.getElementById('email').value.trim();
        const phone = document.getElementById('phone').value.trim();

        // Basic validation
        if (!firstName || !lastName || !email || !phone) {
            alert('Please fill all customer details first.');
            return;
        }

        if (!isValidEmail(email)) {
            alert('Please enter a valid email address.');
            return;
        }

        // Disable button and show loading
        sendOtpBtn.disabled = true;
        sendOtpBtn.innerHTML = '<i class="ri-loader-line me-1 fa-spin"></i>Sending...';

        // Send OTP request
        fetch('{{ route("admin.send-otp") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                first_name: firstName,
                last_name: lastName,
                email: email,
                phone: phone
            })
        })
        .then(response => {
            console.log('Send OTP response status:', response.status); // Debug log
            
            // Handle 422 validation errors differently from other errors
            if (response.status === 422) {
                return response.json().then(data => {
                    // Extract validation errors
                    const errors = data.errors || {};
                    let errorMessage = data.message || 'Validation failed';
                    
                    // Format validation errors
                    if (Object.keys(errors).length > 0) {
                        const errorList = Object.values(errors).flat();
                        errorMessage = errorList.join('\n');
                    }
                    
                    alert(errorMessage);
                    // Don't throw error, just return a rejected promise
                    return Promise.reject({ isValidationError: true, message: errorMessage });
                });
            }
            
            // Check if response is ok before parsing JSON
            if (!response.ok) {
                // Try to get error text for better debugging
                return response.text().then(text => {
                    console.error('Send OTP error response:', text);
                    throw new Error(`HTTP error! status: ${response.status}, response: ${text.substring(0, 200)}`);
                });
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                otpToken = data.token;
                // Move to OTP verification step
                customerDetailsStep.classList.add('d-none');
                otpVerificationStep.classList.remove('d-none');
            } else {
                alert(data.message || 'Error sending OTP. Please try again.');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            // Don't show generic error message for validation errors since we already showed specific message
            if (!error.isValidationError) {
                alert('Error sending OTP. Please try again.');
            }
        })
        .finally(() => {
            sendOtpBtn.disabled = false;
            sendOtpBtn.innerHTML = '<i class="ri-mail-send-line me-1"></i>Send OTP';
        });
    });

    // Verify OTP
    verifyOtpBtn.addEventListener('click', function() {
        const otpCode = document.getElementById('otp_code').value.trim();

        if (!otpCode || otpCode.length !== 6) {
            alert('Please enter a valid 6-digit OTP.');
            return;
        }

        verifyOtpBtn.disabled = true;
        verifyOtpBtn.innerHTML = '<i class="ri-loader-line me-1 fa-spin"></i>Verifying...';

        fetch('{{ route("admin.verify-otp") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                token: otpToken,
                otp: otpCode
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                currentCustomerId = data.customer_id;
                // Move to password step
                otpVerificationStep.classList.add('d-none');
                passwordStep.classList.remove('d-none');
            } else {
                alert(data.message || 'Invalid OTP. Please try again.');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error verifying OTP. Please try again.');
        })
        .finally(() => {
            verifyOtpBtn.disabled = false;
            verifyOtpBtn.innerHTML = '<i class="ri-shield-check-line me-1"></i>Verify OTP';
        });
    });

    // Resend OTP
    resendOtpBtn.addEventListener('click', function() {
        sendOtpBtn.click();
    });

    // Password validation and completion
    document.getElementById('password_confirmation').addEventListener('input', function() {
        const password = document.getElementById('password').value;
        const confirmation = this.value;

        if (password && confirmation && password === confirmation && password.length >= 8) {
            mainSubmitBtn.style.display = 'inline-block';
        } else {
            mainSubmitBtn.style.display = 'none';
        }
    });

    document.getElementById('password').addEventListener('input', function() {
        const password = this.value;
        const confirmation = document.getElementById('password_confirmation').value;

        if (password && confirmation && password === confirmation && password.length >= 8) {
            mainSubmitBtn.style.display = 'inline-block';
        } else {
            mainSubmitBtn.style.display = 'none';
        }
    });

    // Form submission handler
    document.getElementById('customerForm').addEventListener('submit', function(e) {
        if (customerTypeInput.value === 'new' && currentCustomerId) {
            // Set the customer ID for new customer
            const hiddenInput = document.createElement('input');
            hiddenInput.type = 'hidden';
            hiddenInput.name = 'customer_id';
            hiddenInput.value = currentCustomerId;
            this.appendChild(hiddenInput);

            // Set password
            const password = document.getElementById('password').value;
            fetch('{{ route("admin.set-password") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    customer_id: currentCustomerId,
                    password: password
                })
            });
        }
    });

    // Customer search functionality (existing customers)
    let searchTimeout;
    if (customerSearch) {
        customerSearch.addEventListener('input', function() {
            const query = this.value.trim();
            
            clearTimeout(searchTimeout);
            
            if (query.length < 2) {
                customerResults.innerHTML = '';
                selectedCustomerDiv.classList.add('d-none');
                customerIdInput.value = '';
                mainSubmitBtn.style.display = 'none';
                return;
            }

            // Show loading indicator
            customerResults.innerHTML = '<div class="alert alert-info mt-2"><i class="fas fa-spinner fa-spin"></i> Searching customers...</div>';

            searchTimeout = setTimeout(() => {
                console.log('Starting search for:', query); // Debug log
                fetch(`{{ route('admin.search-customers') }}?query=${encodeURIComponent(query)}`, {
                    method: 'GET',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error(`HTTP error! status: ${response.status}`);
                        }
                        return response.json();
                    })
                    .then(data => {
                        console.log('Search response:', data); // Debug log
                        
                        // Handle both old format (just customers array) and new format (with success flag)
                        const customers = data.customers || data || [];
                        const customersArray = Array.isArray(customers) ? customers : [];
                        
                        let html = '';
                        if (customersArray.length > 0) {
                            html = '<div class="list-group mt-2">';
                            customers.forEach(customer => {
                                const displayName = customer.name || `${customer.first_name || ''} ${customer.last_name || ''}`.trim();
                                const customerProfile = customer.customer_profile || {};
                                html += `
                                    <a href="#" class="list-group-item list-group-item-action customer-item" 
                                       data-id="${customer.id}" 
                                       data-name="${displayName}"
                                       data-email="${customer.email || ''}"
                                       data-phone="${customer.phone || ''}">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                <h6 class="mb-1">${displayName}</h6>
                                                <small class="text-muted">${customer.email || ''}</small>
                                                ${customer.phone && customer.phone.trim() !== '' ? `<br><small class="text-muted">${customer.phone}</small>` : ''}
                                            </div>
                                            <span class="badge bg-primary">Select</span>
                                        </div>
                                    </a>
                                `;
                            });
                            html += '</div>';
                        } else {
                            html = '<div class="alert alert-warning mt-2"><i class="fas fa-info-circle"></i> No customers found matching your search. Try searching by name, email, or phone number.</div>';
                        }
                        customerResults.innerHTML = html;

                        // Add click handlers to customer items
                        document.querySelectorAll('.customer-item').forEach(item => {
                            item.addEventListener('click', function(e) {
                                e.preventDefault();
                                const id = this.dataset.id;
                                const name = this.dataset.name;
                                const email = this.dataset.email;
                                const phone = this.dataset.phone;

                                customerIdInput.value = id;
                                customerSearch.value = name;
                                customerResults.innerHTML = '';
                                
                                customerDetailsDiv.innerHTML = `
                                    <strong>${name}</strong><br>
                                    <small class="text-muted">${email}</small>
                                    ${phone && phone.trim() !== '' ? `<br><small class="text-muted">${phone}</small>` : ''}
                                `;
                                selectedCustomerDiv.classList.remove('d-none');
                                mainSubmitBtn.style.display = 'inline-block';
                            });
                        });
                    })
                    .catch(error => {
                        console.error('Error searching customers:', error);
                        customerResults.innerHTML = '<div class="alert alert-danger mt-2"><i class="fas fa-exclamation-triangle"></i> Error searching customers. Please try again. (Debug: ' + error.message + ')</div>';
                    });
            }, 300);
        });
    }

    // Email validation helper
    function isValidEmail(email) {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return emailRegex.test(email);
    }
});
</script>
@endsection