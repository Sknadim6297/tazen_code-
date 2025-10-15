@extends('customer.layout.layout')

@section('title', 'Additional Service Details')

@section('styles')
<link rel="stylesheet" href="{{ asset('customer-css/assets/css/appointment.css') }}" />
<style>
    /* Modern Page Header */
    .page-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: #fff;
        padding: 2rem;
        border-radius: 15px;
        margin-bottom: 2rem;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
        position: relative;
        overflow: hidden;
    }
    
    .page-header::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -20%;
        width: 100%;
        height: 200%;
        background: rgba(255, 255, 255, 0.1);
        transform: rotate(45deg);
        border-radius: 50px;
    }
    
    .page-title h3 {
        font-size: 2.2rem;
        font-weight: 700;
        margin: 0;
        color: #fff;
        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
        position: relative;
        z-index: 2;
    }
    
    .breadcrumb {
        background: none;
        padding: 0;
        margin: 0.5rem 0 0 0;
        list-style: none;
        display: flex;
        gap: 0.5rem;
        font-size: 0.95rem;
        position: relative;
        z-index: 2;
    }
    
    .breadcrumb li a {
        color: rgba(255, 255, 255, 0.9);
        text-decoration: none;
        transition: color 0.3s ease;
    }
    
    .breadcrumb li a:hover {
        color: #fff;
    }
    
    .breadcrumb li.active {
        font-weight: 600;
        color: #fff;
    }

    /* Content Wrapper */
    .content-wrapper {
        padding: 20px;
        min-height: 100vh;
        background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
    }

    /* Enhanced Card Styling */
    .card {
        border: none;
        border-radius: 20px;
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.12);
        overflow: hidden;
        margin-bottom: 2rem;
        background: #fff;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        position: relative;
    }

    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 40px rgba(0, 0, 0, 0.18);
    }

    .card-header {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        border-bottom: 1px solid #dee2e6;
        padding: 1.5rem 2rem;
        position: relative;
    }

    .card-header::before {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 100%;
        height: 3px;
        background: linear-gradient(90deg, #007bff, #6610f2, #6f42c1);
    }

    .card-header h4, .card-header h5 {
        margin: 0;
        font-size: 1.3rem;
        font-weight: 600;
        color: #2c3e50;
    }

    .card-body {
        padding: 2rem;

    }

    /* Badge Styling */
    .badge {
        padding: 0.6rem 1.2rem;
        border-radius: 25px;
        font-weight: 600;
        font-size: 0.85rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
    }

    .badge-pending {
        background: linear-gradient(135deg, #ffeaa7, #fdcb6e);
        color: #856404;
    }

    .badge-approved {
        background: linear-gradient(135deg, #55a3ff, #667eea);
        color: #fff;
    }

    .badge-paid {
        background: linear-gradient(135deg, #00b894, #00cec9);
        color: #fff;
    }

    .badge-in-progress {
        background: linear-gradient(135deg, #a29bfe, #6c5ce7);
        color: #fff;
    }

    .badge-completed {
        background: linear-gradient(135deg, #00b894, #55a3ff);
        color: #fff;
    }

    /* Enhanced Button Styling */
    .btn {
        padding: 0.8rem 1.5rem;
        border-radius: 12px;
        font-weight: 600;
        transition: all 0.3s ease;
        border: none;
        cursor: pointer;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        position: relative;
        overflow: hidden;
    }

    .btn::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
        transition: left 0.5s;
    }

    .btn:hover::before {
        left: 100%;
    }

    .btn-success {
        background: linear-gradient(135deg, #00b894, #55a3ff);
        color: #fff;
        box-shadow: 0 4px 15px rgba(0, 184, 148, 0.4);
    }

    /* Pay Now Button - Special Styling */
    .pay-now-btn {
        background: linear-gradient(135deg, #00b894, #55a3ff) !important;
        color: white !important;
        border: none !important;
        padding: 12px 24px !important;
        font-size: 1.1rem !important;
        font-weight: 600 !important;
        border-radius: 12px !important;
        box-shadow: 0 6px 20px rgba(0, 184, 148, 0.4) !important;
        transition: all 0.3s ease !important;
        text-transform: uppercase !important;
        letter-spacing: 1px !important;
        position: relative !important;
        overflow: hidden !important;
        animation: pulse-pay 2s infinite !important;
    }

    .pay-now-btn:hover {
        transform: translateY(-2px) !important;
        box-shadow: 0 8px 25px rgba(0, 184, 148, 0.6) !important;
        background: linear-gradient(135deg, #55a3ff, #00b894) !important;
    }

    .pay-now-btn:focus {
        outline: none !important;
        box-shadow: 0 0 0 3px rgba(0, 184, 148, 0.3) !important;
    }

    /* Pulse animation for Pay Now button */
    @keyframes pulse-pay {
        0% {
            box-shadow: 0 6px 20px rgba(0, 184, 148, 0.4);
        }
        50% {
            box-shadow: 0 6px 20px rgba(0, 184, 148, 0.8);
        }
        100% {
            box-shadow: 0 6px 20px rgba(0, 184, 148, 0.4);
        }
    }

    .btn-success:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(0, 184, 148, 0.6);
        color: #fff;
    }

    .btn-warning {
        background: linear-gradient(135deg, #fdcb6e, #e17055);
        color: #fff;
        box-shadow: 0 4px 15px rgba(253, 203, 110, 0.4);
    }

    .btn-warning:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(253, 203, 110, 0.6);
        color: #fff;
    }

    .btn-primary {
        background: linear-gradient(135deg, #667eea, #764ba2);
        color: #fff;
        box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(102, 126, 234, 0.6);
        color: #fff;
    }

    .btn-outline-secondary {
        background: transparent;
        color: #6c757d;
        border: 2px solid #6c757d;
        box-shadow: none;
    }

    .btn-outline-secondary:hover {
        background: #6c757d;
        color: #fff;
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(108, 117, 125, 0.4);
    }

    /* Alert Styling */
    .alert {
        border: none;
        border-radius: 15px;
        padding: 1.5rem;
        font-weight: 500;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        position: relative;
        overflow: hidden;
    }

    .alert::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 5px;
        height: 100%;
    }

    .alert-warning {
        background: linear-gradient(135deg, #fff3cd, #ffeaa7);
        color: #856404;
    }

    .alert-warning::before {
        background: #ffc107;
    }

    .alert-danger {
        background: linear-gradient(135deg, #f8d7da, #fd79a8);
        color: #721c24;
    }

    .alert-danger::before {
        background: #dc3545;
    }

    .alert-info {
        background: linear-gradient(135deg, #d1ecf1, #74b9ff);
        color: #0c5460;
    }

    .alert-info::before {
        background: #17a2b8;
    }

    /* Custom Modal Styling */
    .custom-modal {
        display: none;
        position: fixed;
        z-index: 1050;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.6);
        backdrop-filter: blur(5px);
        animation: fadeIn 0.3s ease;
    }

    .custom-modal.show {
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .modal-content {
        background: #fff;
        border-radius: 20px;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
        max-width: 500px;
        width: 90%;
        max-height: 90vh;
        overflow-y: auto;
        position: relative;
        animation: slideInUp 0.4s ease;
    }

    .modal-header {
        background: linear-gradient(135deg, #667eea, #764ba2);
        color: #fff;
        padding: 1.5rem 2rem;
        border-radius: 20px 20px 0 0;
        position: relative;
    }

    .modal-title {
        margin: 0;
        font-size: 1.3rem;
        font-weight: 600;
    }

    .modal-close {
        position: absolute;
        top: 1rem;
        right: 1.5rem;
        background: rgba(255, 255, 255, 0.2);
        border: none;
        color: #fff;
        width: 35px;
        height: 35px;
        border-radius: 50%;
        cursor: pointer;
        font-size: 1.2rem;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
    }

    .modal-close:hover {
        background: rgba(255, 255, 255, 0.3);
        transform: rotate(90deg);
    }

    .modal-body {
        padding: 2rem;
    }

    .modal-footer {
        padding: 1.5rem 2rem;
        border-top: 1px solid #e9ecef;
        display: flex;
        gap: 1rem;
        justify-content: flex-end;
    }

    /* Form Styling */
    .form-label {
        font-weight: 600;
        color: #2c3e50;
        margin-bottom: 0.5rem;
    }

    .form-control {
        border: 2px solid #e9ecef;
        border-radius: 10px;
        padding: 0.8rem 1rem;
        transition: all 0.3s ease;
        font-size: 0.95rem;
    }

    .form-control:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
        outline: none;
    }

    /* Animations */
    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }

    @keyframes slideInUp {
        from {
            transform: translateY(50px);
            opacity: 0;
        }
        to {
            transform: translateY(0);
            opacity: 1;
        }
    }

    @keyframes pulse {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.05); }
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .page-title h3 {
            font-size: 1.8rem;
        }
        
        .card-body {
            padding: 1.5rem;
        }
        
        .modal-content {
            margin: 1rem;
            width: calc(100% - 2rem);
        }
        
        .btn {
            padding: 0.6rem 1.2rem;
            font-size: 0.9rem;
        }
    }

    /* Info Cards */
    .info-card {
        background: linear-gradient(135deg, #74b9ff, #0984e3);
        color: #fff;
        border-radius: 15px;
        padding: 1.5rem;
        margin-bottom: 1rem;
        box-shadow: 0 6px 20px rgba(116, 185, 255, 0.3);
    }

    .info-card h6 {
        margin: 0 0 1rem 0;
        font-weight: 600;
        opacity: 0.9;
    }

    /* Price Breakdown Card */
    .price-breakdown {
        background: linear-gradient(135deg, #00cec9, #00b894);
        color: #fff;
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 6px 20px rgba(0, 206, 201, 0.3);
    }

    .price-breakdown .card-header {
        background: rgba(255, 255, 255, 0.1);
        border-bottom: 1px solid rgba(255, 255, 255, 0.2);
    }

    .price-breakdown .card-header::before {
        display: none;
    }

    .price-breakdown h6 {
        color: #fff;
    }
</style>
@endsection

@section('content')
<div class="content-wrapper">
    <div class="page-header">
        <div class="page-title">
            <h3>Additional Service Details</h3>
        </div>
        <ul class="breadcrumb">
            <li><a href="{{ route('user.dashboard') }}">Dashboard</a></li>
            <li><a href="{{ route('user.additional-services.index') }}">Additional Services</a></li>
            <li class="active">Details</li>
        </ul>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0">Service Information</h4>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="d-block"><strong>Service Name:</strong></label>
                            <p class="mb-0">{{ $additionalService->service_name }}</p>
                        </div>
                        <div class="col-md-6">
                            <label class="d-block"><strong>Status:</strong></label>
                            <p class="mb-0">{{ $additionalService->status_text }}</p>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="d-block"><strong>Reason:</strong></label>
                        <p class="mb-0">{{ $additionalService->reason }}</p>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="d-block"><strong>Base Price:</strong></label>
                            <p class="mb-0">₹{{ number_format($additionalService->base_price, 2) }}</p>
                        </div>
                        <div class="col-md-6">
                            <label class="d-block"><strong>Total Price (inc. GST):</strong></label>
                            <p class="text-success mb-0"><strong>₹{{ number_format($additionalService->final_price, 2) }}</strong></p>
                        </div>
                    </div>

                    <div class="card mb-3 price-breakdown">
                        <div class="card-header">
                            <h6 class="mb-0">💰 Price Breakdown</h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-6">
                                    <div class="mb-2">
                                        <small class="d-block opacity-75">Base Price</small>
                                        <strong>₹{{ number_format($additionalService->base_price, 2) }}</strong>
                                    </div>
                                    <div>
                                        <small class="d-block opacity-75">CGST (9%)</small>
                                        <strong>₹{{ number_format($additionalService->cgst ?? 0, 2) }}</strong>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="mb-2">
                                        <small class="d-block opacity-75">SGST (9%)</small>
                                        <strong>₹{{ number_format($additionalService->sgst ?? 0, 2) }}</strong>
                                    </div>
                                    <div class="p-3 bg-white bg-opacity-20 rounded">
                                        <small class="d-block opacity-75">Total Amount</small>
                                        <h5 class="mb-0">₹{{ number_format($additionalService->final_price, 2) }}</h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    @if($additionalService->delivery_date)
                    <div class="mb-3">
                        <label class="d-block"><strong>Delivery Date:</strong></label>
                        <p class="mb-0">{{ \Carbon\Carbon::parse($additionalService->delivery_date)->format('M d, Y') }}</p>
                    </div>
                    @endif

                    @if($additionalService->negotiation_status !== 'none')
                    <div class="alert {{ $additionalService->negotiation_status === 'user_negotiated' ? 'alert-warning' : 'alert-info' }}">
                        <h5 class="mb-2">
                            @if($additionalService->negotiation_status === 'user_negotiated')
                                ⏳ Negotiation Pending Admin Review
                            @else
                                Negotiation Status
                            @endif
                        </h5>
                        @if($additionalService->negotiation_status === 'user_negotiated')
                            @php
                                // Determine who handles the negotiation based on who created the service
                                $negotiationHandler = $additionalService->professional_id ? 'professional' : 'admin';
                                $handlerLabel = $negotiationHandler === 'professional' ? 'Professional' : 'Admin';
                            @endphp
                            <p class="mb-1"><strong>Your Negotiated Price:</strong> ₹{{ number_format($additionalService->user_negotiated_price, 2) }}</p>
                            <p class="mb-1"><strong>Your Reason:</strong> {{ $additionalService->user_negotiation_reason }}</p>
                            <p class="text-info mb-0">
                                <i class="fas fa-clock"></i> 
                                <strong>Status:</strong> Waiting for {{ strtolower($handlerLabel) }} response... We'll notify you once {{ strtolower($handlerLabel) }} reviews your negotiation.
                            </p>
                        @elseif($additionalService->negotiation_status === 'admin_responded')
                            @php
                                // Determine who handled the negotiation based on who created the service
                                $modifierLabel = $additionalService->professional_id ? 'Professional' : 'Admin';
                            @endphp
                            <p class="mb-1"><strong>Your Negotiated Price:</strong> ₹{{ number_format($additionalService->user_negotiated_price, 2) }}</p>
                            <p class="mb-1"><strong>{{ $modifierLabel }}'s Final Price:</strong> <span class="text-success">₹{{ number_format($additionalService->admin_final_negotiated_price, 2) }}</span></p>
                            <p class="mb-0"><strong>{{ $modifierLabel }}'s Response:</strong> {{ $additionalService->admin_negotiation_response }}</p>
                            <div class="mt-2">
                                <small class="text-success">✅ <strong>Good news!</strong> {{ $modifierLabel }} has responded to your negotiation. You can now proceed with payment at the updated price.</small>
                            </div>
                        @endif
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card mb-3">
                <div class="card-header">
                    <h5 class="mb-0">👨‍💼 Professional Information</h5>
                </div>
                <div class="card-body">
                    <div class="info-card">
                        <div class="row">
                            <div class="col-12 mb-3">
                                <h6>👤 {{ $additionalService->professional->name }}</h6>
                                <p class="mb-1"><i class="fas fa-envelope me-2"></i>{{ $additionalService->professional->email }}</p>
                                <p class="mb-1"><i class="fas fa-phone me-2"></i>{{ $additionalService->professional->phone }}</p>
                                <p class="mb-0"><i class="fas fa-bookmark me-2"></i>Booking: #{{ $additionalService->booking_id }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mb-3">
                <div class="card-header">
                    <h5 class="mb-0">⚡ Quick Actions</h5>
                </div>
                <div class="card-body d-grid gap-3">
                    @if($additionalService->payment_status === 'pending')
                        @if($additionalService->negotiation_status === 'user_negotiated')
                            <button class="btn btn-secondary" disabled>
                                <i class="fas fa-clock"></i> 
                                Payment Pending Admin Review
                            </button>
                            <small class="text-muted text-center">
                                <i class="fas fa-info-circle"></i> 
                                Payment will be enabled once admin responds to your negotiation
                            </small>
                        @else
                            <button class="btn btn-success pay-now-btn" data-id="{{ $additionalService->id }}">
                                <i class="fas fa-credit-card"></i> 
                                Pay Now - ₹{{ number_format($additionalService->final_price, 2) }}
                            </button>
                        @endif
                    @endif
                    
                    @if($additionalService->canBeNegotiated())
                    <button class="btn btn-warning negotiate-btn" data-id="{{ $additionalService->id }}">
                        <i class="fas fa-handshake"></i> 
                        Negotiate Price
                    </button>
                    @endif
                    
                    @if($additionalService->consulting_status === 'done' && !$additionalService->customer_confirmed_at)
                    <button class="btn btn-primary confirm-completion-btn" data-id="{{ $additionalService->id }}">
                        <i class="fas fa-check-circle"></i> 
                        Confirm Completion
                    </button>
                    @endif

                    <a href="{{ route('user.additional-services.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left"></i> 
                        Back to List
                    </a>
                </div>
            </div>

            @if($additionalService->isPaid())
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">💳 Payment Information</h5>
                </div>
                <div class="card-body">
                    <div class="info-card" style="background: linear-gradient(135deg, #00b894, #00cec9);">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <span class="badge badge-paid">✅ Payment Completed</span>
                            <h4 class="mb-0">₹{{ number_format($additionalService->final_price, 2) }}</h4>
                        </div>
                        @if($additionalService->payment_id)
                        <p class="mb-0">
                            <small class="opacity-75">Transaction ID</small><br>
                            <code>{{ $additionalService->payment_id }}</code>
                        </p>
                        @endif
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

<!-- Custom Negotiation Modal -->
<div class="custom-modal" id="negotiationModal">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">💰 Negotiate Service Price</h5>
            <button type="button" class="modal-close" onclick="closeModal('negotiationModal')">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <form id="negotiationForm">
            <div class="modal-body">
                <div class="alert alert-info">
                    <div class="row">
                        <div class="col-6">
                            <small class="d-block opacity-75">Current Price</small>
                            <strong>₹{{ number_format($additionalService->final_price, 2) }}</strong>
                        </div>
                        <div class="col-6">
                            @php
                                $professional = $additionalService->professional;
                                $maxDiscountPercent = $professional->service_request_offset ?? 10;
                                $minPrice = $additionalService->final_price - (($additionalService->final_price * $maxDiscountPercent) / 100);
                            @endphp
                            <small class="d-block opacity-75">You can negotiate this service</small>
                            <strong class="text-success">💬 Make an offer</strong>
                        </div>
                    </div>
                </div>
                
                <div class="mb-3">
                    <label for="negotiated_price" class="form-label">
                        <i class="fas fa-tag me-2"></i>Your Proposed Price (₹) *
                    </label>
                    <input type="number" class="form-control" id="negotiated_price" name="negotiated_price" 
                           data-min-price="{{ $minPrice }}" max="{{ $additionalService->final_price }}" step="0.01" required
                           placeholder="Enter your proposed price...">
                    <div class="form-text text-muted">
                        <i class="fas fa-info-circle me-1"></i>
                        Enter your best offer for this service
                    </div>
                    <div class="invalid-feedback" id="price-error" style="display: none;">
                        You can't negotiate below this price
                    </div>
                </div>
                
                <div class="mb-3">
                    <label for="negotiation_reason" class="form-label">
                        <i class="fas fa-comment me-2"></i>Reason for Negotiation *
                    </label>
                    <textarea class="form-control" id="negotiation_reason" name="negotiation_reason" 
                              rows="4" maxlength="1000" required 
                              placeholder="Please explain why you're requesting a price reduction..."></textarea>
                    <div class="form-text">
                        <span id="char-count">0</span>/1000 characters
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" onclick="closeModal('negotiationModal')">
                    <i class="fas fa-times me-2"></i>Cancel
                </button>
                <button type="submit" class="btn btn-warning">
                    <i class="fas fa-paper-plane me-2"></i>Submit Negotiation
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Custom Confirm Completion Modal -->
<div class="custom-modal" id="confirmCompletionModal">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">✅ Confirm Service Completion</h5>
            <button type="button" class="modal-close" onclick="closeModal('confirmCompletionModal')">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="modal-body">
            <div class="text-center mb-4">
                <div class="bg-primary bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                    <i class="fas fa-check-circle text-primary" style="font-size: 2.5rem;"></i>
                </div>
            </div>
            <h6 class="text-center mb-3">Service Completion Confirmation</h6>
            <p class="text-center">The professional has marked this consultation as completed. Do you confirm that the service has been delivered satisfactorily?</p>
            <div class="alert alert-warning">
                <i class="fas fa-exclamation-triangle me-2"></i>
                <strong>Important:</strong> Once confirmed, this action cannot be undone and the service will be marked as fully completed.
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-outline-secondary" onclick="closeModal('confirmCompletionModal')">
                <i class="fas fa-clock me-2"></i>Not Yet
            </button>
            <button type="button" class="btn btn-success" id="confirmCompletionBtn">
                <i class="fas fa-check-circle me-2"></i>Yes, Confirm Completion
            </button>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script>
$(document).ready(function() {
    let currentServiceId = {{ $additionalService->id }};

    // Custom Modal Functions
    function openModal(modalId) {
        document.getElementById(modalId).classList.add('show');
        document.body.style.overflow = 'hidden';
    }

    function closeModal(modalId) {
        document.getElementById(modalId).classList.remove('show');
        document.body.style.overflow = 'auto';
    }

    // Make closeModal available globally
    window.closeModal = closeModal;

    // Close modal when clicking outside
    $('.custom-modal').click(function(e) {
        if (e.target === this) {
            closeModal(this.id);
        }
    });

    // Close modal with Escape key
    $(document).keydown(function(e) {
        if (e.keyCode === 27) {
            $('.custom-modal.show').each(function() {
                closeModal(this.id);
            });
        }
    });

    // Character count for negotiation reason
    $('#negotiation_reason').on('input', function() {
        const length = $(this).val().length;
        $('#char-count').text(length);
        
        if (length > 1000) {
            $(this).addClass('is-invalid');
        } else {
            $(this).removeClass('is-invalid');
        }
    });

    // Pay Now functionality with enhanced UI feedback
    $('.pay-now-btn').click(function() {
        const serviceId = $(this).data('id');
        const $btn = $(this);
        const originalText = $btn.html();
        
        $btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Processing...');
        
        $.ajax({
            url: `/user/additional-services/${serviceId}/create-payment-order`,
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                if (response.success) {
                    const rkey = response.key || response.razorpay_key || '{{ config('services.razorpay.key') }}';
                    const ramount = response.amount || response.order_amount || 0; // amount in paise
                    const rcurrency = response.currency || 'INR';
                    const rorderId = response.order_id || response.orderId || response.order?.id || null;

                    if (!rorderId || !ramount) {
                        toastr.error('Invalid payment order returned from server. Please try again.');
                        $btn.prop('disabled', false).html(originalText);
                        return;
                    }

                    const options = {
                        key: rkey,
                        amount: ramount,
                        currency: rcurrency,
                        name: '{{ config('app.name') }}',
                        description: response.service_name || response.description || 'Additional Service Payment',
                        order_id: rorderId,
                        handler: function (razorpayResponse) {
                            handlePaymentSuccess(serviceId, razorpayResponse);
                        },
                        prefill: {
                            name: '{{ Auth::guard('user')->user()->name }}',
                            email: '{{ Auth::guard('user')->user()->email }}',
                            contact: '{{ Auth::guard('user')->user()->phone }}'
                        },
                        theme: {
                            color: '#667eea'
                        },
                        modal: {
                            ondismiss: function() {
                                toastr.info('Payment cancelled by user');
                                $btn.prop('disabled', false).html(originalText);
                            }
                        }
                    };
                    
                    const rzp = new Razorpay(options);
                    rzp.open();
                    
                    rzp.on('payment.failed', function (response) {
                        toastr.error('Payment failed: ' + response.error.description);
                    });
                } else {
                    toastr.error(response.message);
                }
            },
            error: function(xhr) {
                toastr.error('Failed to initiate payment. Please try again.');
            },
            complete: function() {
                $btn.prop('disabled', false).html(originalText);
            }
        });
    });

    function handlePaymentSuccess(serviceId, paymentResponse) {
        // Show success animation
        toastr.success('Payment initiated successfully! Verifying...');
        
        $.ajax({
            url: `/user/additional-services/${serviceId}/payment-success`,
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                razorpay_payment_id: paymentResponse.razorpay_payment_id,
                razorpay_order_id: paymentResponse.razorpay_order_id,
                razorpay_signature: paymentResponse.razorpay_signature
            },
            success: function(response) {
                if (response.success) {
                    toastr.success(response.message);
                    setTimeout(() => location.reload(), 2000);
                } else {
                    toastr.error(response.message);
                }
            },
            error: function(xhr) {
                toastr.error('Payment verification failed. Please contact support.');
            }
        });
    }

    // Negotiate functionality with custom modal
    $('.negotiate-btn').click(function() {
        openModal('negotiationModal');
        // Reset form
        $('#negotiationForm')[0].reset();
        $('#char-count').text('0');
    });

    // Submit negotiation with enhanced feedback
    $('#negotiationForm').submit(function(e) {
        e.preventDefault();
        
        const $submitBtn = $(this).find('button[type="submit"]');
        const originalText = $submitBtn.html();
        
        $submitBtn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Submitting...');
        
        $.ajax({
            url: `/user/additional-services/${currentServiceId}/negotiate`,
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                negotiated_price: $('#negotiated_price').val(),
                negotiation_reason: $('#negotiation_reason').val()
            },
            success: function(response) {
                if (response.success) {
                    closeModal('negotiationModal');
                    toastr.success(response.message);
                    setTimeout(() => location.reload(), 2000);
                } else {
                    toastr.error(response.message);
                }
            },
            error: function(xhr) {
                // Handle validation errors with generic messages
                const serverMessage = xhr.responseJSON?.message;
                const errors = xhr.responseJSON?.errors;
                
                if (errors && errors.negotiated_price) {
                    // Don't show specific amounts in error messages
                    toastr.error("You can't negotiate below this price");
                } else if (serverMessage) {
                    // Filter out any messages that contain price amounts
                    if (serverMessage.includes('₹') || serverMessage.includes('minimum') || serverMessage.includes('below')) {
                        toastr.error("You can't negotiate below this price");
                    } else {
                        toastr.error(serverMessage);
                    }
                } else if (errors) {
                    Object.values(errors).forEach(function(error) {
                        // Filter price-related errors
                        const errorMsg = error[0];
                        if (errorMsg.includes('₹') || errorMsg.includes('minimum') || errorMsg.includes('below')) {
                            toastr.error("You can't negotiate below this price");
                        } else {
                            toastr.error(errorMsg);
                        }
                    });
                } else {
                    toastr.error('An error occurred. Please try again.');
                }
            },
            complete: function() {
                $submitBtn.prop('disabled', false).html(originalText);
            }
        });
    });

    // Confirm completion with custom modal
    $('.confirm-completion-btn').click(function() {
        // ensure currentServiceId is set (show page has it prefilled, but set from button for consistency)
        currentServiceId = $(this).data('id') || currentServiceId;
        console.log('Opening confirm modal for service:', currentServiceId);
        openModal('confirmCompletionModal');
    });

    $('#confirmCompletionBtn').click(function() {
        const $btn = $(this);
        const originalText = $btn.html();
        
        // Debug log
        console.log('Confirm completion clicked for serviceId:', currentServiceId);

        $btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Confirming...');
        
        $.ajax({
            url: `/user/additional-services/${currentServiceId}/confirm-consultation`,
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                console.log('confirm-consultation success response:', response);
                if (response.success) {
                    closeModal('confirmCompletionModal');
                    toastr.success(response.message);
                    setTimeout(() => location.reload(), 2000);
                } else {
                    toastr.error(response.message);
                }
            },
            error: function(xhr) {
                console.error('confirm-consultation error:', xhr);
                const serverMessage = xhr.responseJSON?.message;
                if (serverMessage) {
                    toastr.error(serverMessage);
                } else {
                    toastr.error('An error occurred. Please try again.');
                }
            },
            complete: function() {
                $btn.prop('disabled', false).html(originalText);
            }
        });
    });

    // Add smooth animations to cards
    $('.card').each(function(index) {
        $(this).css({
            'animation-delay': (index * 0.1) + 's'
        });
    });

    // Price input validation with real-time feedback
    $('#negotiated_price').on('input', function() {
        const value = parseFloat($(this).val());
        const minPrice = parseFloat($(this).data('min-price'));
        const max = parseFloat($(this).attr('max'));
        const $errorDiv = $('#price-error');
        
        if (value && value < minPrice) {
            $(this).addClass('is-invalid');
            $errorDiv.show();
        } else if (value > max) {
            $(this).addClass('is-invalid');
            $errorDiv.text('Price cannot exceed current price').show();
        } else {
            $(this).removeClass('is-invalid');
            $errorDiv.hide();
        }
    });
});
</script>
@endsection