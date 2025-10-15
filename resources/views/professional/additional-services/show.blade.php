@extends('professional.layout.layout')

@section('title', 'Additional Service Details')

@section('styles')
<style>
    /* Modern Page Styles */
    .page-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: #fff;
        padding: 2rem 0;
        border-radius: 0 0 20px 20px;
        margin-bottom: 2rem;
        box-shadow: 0 8px 32px rgba(102, 126, 234, 0.3);
    }

    .page-title h3 {
        margin: 0;
        font-weight: 700;
        font-size: 2.2rem;
    }

    .breadcrumb {
        margin: 0;
        background: transparent;
        padding: 0.5rem 0 0 0;
    }

    .breadcrumb li {
        color: rgba(255, 255, 255, 0.8);
    }

    .breadcrumb li a {
        color: rgba(255, 255, 255, 0.9);
        text-decoration: none;
    }

    .breadcrumb li.active {
        color: #fff;
    }

    /* Card Enhancements */
    .card-box {
        border: none;
        border-radius: 20px;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
        margin-bottom: 2rem;
        overflow: hidden;
        transition: all 0.3s ease;
        animation: slideInUp 0.6s ease-out;
    }

    .card-box:hover {
        transform: translateY(-5px);
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
    }

    .card-block {
        padding: 2rem;
    }

    .card-title {
        font-size: 1.4rem;
        font-weight: 700;
        color: #2c3e50;
        margin-bottom: 1.5rem;
        padding-bottom: 0.5rem;
        border-bottom: 3px solid #667eea;
        display: inline-block;
    }

    /* Custom Modal System */
    .custom-modal {
        display: none;
        position: fixed;
        z-index: 1050;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.8);
        backdrop-filter: blur(5px);
        transition: all 0.3s ease;
    }

    .custom-modal.show {
        display: flex;
        align-items: center;
        justify-content: center;
        animation: fadeIn 0.3s ease;
    }

    .modal-content {
        background: #fff;
        border-radius: 20px;
        box-shadow: 0 20px 80px rgba(0, 0, 0, 0.3);
        max-width: 600px;
        width: 90%;
        max-height: 90vh;
        overflow: auto;
        animation: slideInUp 0.3s ease;
        position: relative;
    }

    .modal-header {
        padding: 2rem 2rem 1rem 2rem;
        border-bottom: none;
        position: relative;
    }

    .modal-title {
        font-size: 1.5rem;
        font-weight: 700;
        color: #2c3e50;
        margin: 0;
    }

    .modal-close {
        position: absolute;
        top: 1.5rem;
        right: 2rem;
        background: none;
        border: none;
        font-size: 1.5rem;
        color: #666;
        cursor: pointer;
        transition: all 0.3s ease;
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .modal-close:hover {
        background: #f8f9fa;
        color: #333;
        transform: rotate(90deg);
    }

    .modal-body {
        padding: 1rem 2rem 2rem 2rem;
    }

    .modal-footer {
        padding: 1.5rem 2rem 2rem 2rem;
        border-top: 1px solid #e9ecef;
        display: flex;
        gap: 1rem;
        justify-content: flex-end;
        flex-wrap: wrap;
    }

    /* Form Styling */
    .form-label {
        font-weight: 600;
        color: #2c3e50;
        margin-bottom: 0.5rem;
        display: block;
    }

    .form-control {
        border: 2px solid #e9ecef;
        border-radius: 12px;
        padding: 0.8rem 1rem;
        transition: all 0.3s ease;
        font-size: 0.95rem;
        width: 100%;
        background: #fff;
    }

    .form-control:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
        outline: none;
        background: #fff;
    }

    /* Price Cards */
    .price-card {
        background: linear-gradient(135deg, #00cec9, #00b894);
        color: #fff;
        border-radius: 20px;
        padding: 2rem;
        margin-bottom: 1.5rem;
        box-shadow: 0 10px 30px rgba(0, 206, 201, 0.3);
        animation: fadeIn 0.8s ease;
    }

    .price-card h6 {
        margin: 0 0 1.5rem 0;
        font-weight: 700;
        font-size: 1.2rem;
        opacity: 0.95;
    }

    .price-card label {
        color: rgba(255, 255, 255, 0.9);
        font-weight: 500;
    }

    .price-card p {
        color: #fff;
        font-weight: 600;
        margin-bottom: 0.5rem;
    }

    /* Info Cards */
    .info-card {
        background: linear-gradient(135deg, #74b9ff, #0984e3);
        color: #fff;
        border-radius: 20px;
        padding: 2rem;
        margin-bottom: 1.5rem;
        box-shadow: 0 10px 30px rgba(116, 185, 255, 0.3);
        animation: fadeIn 1s ease;
    }

    .info-card h6 {
        margin: 0 0 1.5rem 0;
        font-weight: 700;
        font-size: 1.2rem;
        opacity: 0.95;
    }

    .info-card label {
        color: rgba(255, 255, 255, 0.9);
        font-weight: 500;
    }

    .info-card p {
        color: #fff;
        font-weight: 600;
        margin-bottom: 0.5rem;
    }

    /* Button Enhancements */
    .btn {
        border-radius: 12px;
        padding: 0.8rem 1.5rem;
        font-weight: 600;
        font-size: 0.95rem;
        transition: all 0.3s ease;
        border: none;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        text-decoration: none;
    }

    .btn-success {
        background: linear-gradient(135deg, #00b894, #00cec9);
        color: #fff;
        box-shadow: 0 5px 15px rgba(0, 184, 148, 0.4);
    }

    .btn-success:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(0, 184, 148, 0.6);
        background: linear-gradient(135deg, #00a085, #00b7b3);
    }

    .btn-primary {
        background: linear-gradient(135deg, #0984e3, #74b9ff);
        color: #fff;
        box-shadow: 0 5px 15px rgba(9, 132, 227, 0.4);
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(9, 132, 227, 0.6);
        background: linear-gradient(135deg, #0875d1, #5faef9);
    }

    .btn-warning {
        background: linear-gradient(135deg, #fdcb6e, #e17055);
        color: #fff;
        box-shadow: 0 5px 15px rgba(253, 203, 110, 0.4);
    }

    .btn-warning:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(253, 203, 110, 0.6);
        background: linear-gradient(135deg, #fcbb5a, #df6348);
    }

    .btn-outline-secondary {
        background: transparent;
        color: #6c757d;
        border: 2px solid #e9ecef;
    }

    .btn-outline-secondary:hover {
        background: #6c757d;
        color: #fff;
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(108, 117, 125, 0.3);
    }

    /* Badge Styling */
    .badge {
        padding: 0.5rem 1rem;
        border-radius: 50px;
        font-weight: 600;
        font-size: 0.8rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .badge-pending {
        background: linear-gradient(135deg, #fdcb6e, #e17055);
        color: #fff;
    }

    .badge-approved {
        background: linear-gradient(135deg, #00b894, #00cec9);
        color: #fff;
    }

    .badge-rejected {
        background: linear-gradient(135deg, #e17055, #d63031);
        color: #fff;
    }

    .badge-paid {
        background: linear-gradient(135deg, #00b894, #00cec9);
        color: #fff;
    }

    /* Alert Styling */
    .alert {
        border: none;
        border-radius: 15px;
        padding: 1.5rem;
        margin-bottom: 1.5rem;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
    }

    .alert-info {
        background: linear-gradient(135deg, rgba(116, 185, 255, 0.1), rgba(9, 132, 227, 0.1));
        border-left: 4px solid #74b9ff;
        color: #0984e3;
    }

    .alert-success {
        background: linear-gradient(135deg, rgba(0, 184, 148, 0.1), rgba(0, 206, 201, 0.1));
        border-left: 4px solid #00b894;
        color: #00b894;
    }

    .alert-danger {
        background: linear-gradient(135deg, rgba(225, 112, 85, 0.1), rgba(214, 48, 49, 0.1));
        border-left: 4px solid #e17055;
        color: #e17055;
    }

    /* Grid Enhancements */
    .d-grid {
        display: grid !important;
    }

    .gap-2 {
        gap: 1rem !important;
    }

    /* Text Utilities */
    .text-success {
        color: #00b894 !important;
    }

    .text-muted {
        color: #74869b !important;
    }

    /* Animations */
    @keyframes fadeIn {
        from { 
            opacity: 0; 
            transform: translateY(20px);
        }
        to { 
            opacity: 1; 
            transform: translateY(0);
        }
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

    /* Responsive Design */
    @media (max-width: 768px) {
        .page-title h3 {
            font-size: 1.8rem;
        }
        
        .card-block {
            padding: 1.5rem;
        }
        
        .modal-content {
            margin: 1rem;
            width: calc(100% - 2rem);
            border-radius: 15px;
        }
        
        .modal-header, .modal-body, .modal-footer {
            padding-left: 1.5rem;
            padding-right: 1.5rem;
        }
        
        .btn {
            padding: 0.7rem 1.2rem;
            font-size: 0.9rem;
        }
        
        .modal-footer {
            flex-direction: column;
        }
        
        .modal-footer .btn {
            width: 100%;
            margin-bottom: 0.5rem;
        }

        .price-card, .info-card {
            padding: 1.5rem;
        }
    }

    /* Price Validation Styles */
    .price-error {
        font-size: 0.875rem;
        font-weight: 500;
        animation: fadeIn 0.3s ease;
    }

    .form-control.is-invalid {
        border-color: #dc3545;
        box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);
    }

    .bg-warning-light {
        background-color: #fff3cd !important;
        border: 1px solid #ffeaa7;
    }

    .alert {
        border-radius: 12px;
        border: none;
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.1);
    }

    .alert-info {
        background: linear-gradient(135deg, #e3f2fd 0%, #bbdefb 100%);
        color: #1565c0;
    }

    .form-group label {
        font-weight: 600;
        color: #2c3e50;
        margin-bottom: 0.5rem;
    }

    .btn-success {
        background: linear-gradient(135deg, #4caf50 0%, #45a049 100%);
        border: none;
        border-radius: 8px;
        padding: 0.75rem 1.5rem;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .btn-success:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(76, 175, 80, 0.4);
    }

    .btn-primary {
        background: linear-gradient(135deg, #2196f3 0%, #1976d2 100%);
        border: none;
        border-radius: 8px;
        padding: 0.75rem 1.5rem;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(33, 150, 243, 0.4);
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(-10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    @media (max-width: 576px) {
        .page-header {
            padding: 1.5rem 0;
            margin-bottom: 1.5rem;
        }
        
        .page-title h3 {
            font-size: 1.6rem;
        }
        
        .card-box {
            margin-bottom: 1.5rem;
        }
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
            <li><a href="{{ route('professional.dashboard') }}">Dashboard</a></li>
            <li><a href="{{ route('professional.additional-services.index') }}">Additional Services</a></li>
            <li class="active">Details</li>
        </ul>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card-box">
                <div class="card-block">
                    <h4 class="card-title">📋 Service Information</h4>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label><strong>Service Name:</strong></label>
                                <p>{{ $additionalService->service_name }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label><strong>Status:</strong></label>
                                <p>
                                    @if($additionalService->admin_status === 'pending')
                                        <span class="badge badge-pending">Pending Review</span>
                                    @elseif($additionalService->admin_status === 'approved')
                                        <span class="badge badge-approved">Approved</span>
                                    @elseif($additionalService->admin_status === 'rejected')
                                        <span class="badge badge-rejected">Rejected</span>
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label><strong>Reason:</strong></label>
                        <p>{{ $additionalService->reason }}</p>
                    </div>

                    <div class="price-card">
                        <h6>💰 Price Breakdown</h6>
                        <div class="row">
                            <div class="col-md-4">
                                <label><strong>Base Price:</strong></label>
                                <p>₹{{ number_format($additionalService->base_price, 2) }}</p>
                                @if($additionalService->negotiation_status === 'admin_responded')
                                    <small class="text-muted">Original price</small>
                                @endif
                            </div>
                            <div class="col-md-4">
                                <label><strong>GST (18%):</strong></label>
                                @php
                                    // Use final price for GST calculation if price was negotiated
                                    $priceForGst = $additionalService->final_price / 1.18; // Remove GST to get base
                                    $gst = $priceForGst * 0.18;
                                @endphp
                                <p>₹{{ number_format($gst, 2) }}</p>
                            </div>
                            <div class="col-md-4">
                                <label><strong>Final Price:</strong></label>
                                <p>
                                    <strong class="text-success">₹{{ number_format($additionalService->final_price, 2) }}</strong>
                                    @if($additionalService->negotiation_status === 'admin_responded')
                                        <br><small class="text-info">✅ Updated after negotiation</small>
                                    @endif
                                </p>
                            </div>
                        </div>
                        
                        @if($additionalService->negotiation_status === 'admin_responded')
                        <div class="alert alert-success mt-3">
                            <h6><i class="fas fa-check-circle"></i> Price Update Notice</h6>
                            <p class="mb-1">
                                <strong>Original Price:</strong> ₹{{ number_format($additionalService->total_price, 2) }} 
                                → 
                                <strong>New Price:</strong> ₹{{ number_format($additionalService->final_price, 2) }}
                            </p>
                            <p class="mb-0">
                                <strong>Savings:</strong> ₹{{ number_format($additionalService->total_price - $additionalService->final_price, 2) }}
                            </p>
                        </div>
                        @endif
                    </div>

                    @if($additionalService->delivery_date)
                    <div class="form-group">
                        <label><strong>Delivery Date:</strong></label>
                        <p>
                            <i class="fas fa-calendar"></i> 
                            {{ \Carbon\Carbon::parse($additionalService->delivery_date)->format('M d, Y') }}
                        </p>
                    </div>
                    @endif

                    @if($additionalService->negotiation_status !== 'none')
                    <div class="alert {{ $additionalService->negotiation_status === 'user_negotiated' ? 'alert-warning' : 'alert-success' }}">
                        <h5>
                            <i class="fas fa-handshake"></i> 
                            @if($additionalService->negotiation_status === 'user_negotiated')
                                Customer Price Negotiation (Pending Your Response)
                            @elseif($additionalService->negotiation_status === 'admin_responded')
                                ✅ Negotiation Completed - Price Updated
                            @endif
                        </h5>
                        
                        @if($additionalService->user_negotiated_price)
                            <p><strong>Customer's Proposed Price:</strong> ₹{{ number_format($additionalService->user_negotiated_price, 2) }}</p>
                            <p><strong>Customer's Reason:</strong> {{ $additionalService->user_negotiation_reason }}</p>
                        @endif
                        
                        @if($additionalService->negotiation_status === 'admin_responded' && $additionalService->admin_final_negotiated_price)
                            @php
                                // Decide label: if modification reason was from professional, show Professional label
                                $modifierLabel = 'Admin';
                                if(stripos($additionalService->price_modification_reason ?? '', 'professional') !== false || stripos($additionalService->price_modification_reason ?? '', 'Professional') !== false) {
                                    $modifierLabel = 'Professional';
                                }
                            @endphp
                            <div class="mt-3 p-3 bg-light rounded">
                                <h6 class="text-success">{{ $modifierLabel }}'s Final Decision:</h6>
                                <p><strong>Approved Price:</strong> <span class="text-success">₹{{ number_format($additionalService->admin_final_negotiated_price, 2) }}</span></p>
                                <p><strong>{{ $modifierLabel }}'s Response:</strong> {{ $additionalService->admin_negotiation_response }}</p>
                                <small class="text-muted">
                                    <i class="fas fa-info-circle"></i> 
                                    The service price has been updated and customer can now proceed with payment.
                                </small>
                            </div>
                        @elseif($additionalService->negotiation_status === 'user_negotiated')
                            <div class="mt-3 p-3 bg-warning-light rounded">
                                <p class="mb-3 text-warning">
                                    <i class="fas fa-clock"></i> 
                                    <strong>Status:</strong> Customer has requested price negotiation - Please respond below.
                                </p>
                                
                                <!-- Professional Negotiation Response Form -->
                                <form id="negotiationResponseForm" class="border-top pt-3">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="professional_final_price"><strong>Your Final Price (₹):</strong></label>
                                                <input type="number" 
                                                       id="professional_final_price" 
                                                       name="professional_final_price" 
                                                       class="form-control" 
                                                       step="0.01" 
                                                       min="{{ $additionalService->base_price * 0.5 }}"
                                                       value="{{ $additionalService->user_negotiated_price }}"
                                                       required>
                                                <small class="text-muted">Minimum enforced</small>
                                                <div class="price-error text-danger mt-1" style="display: none;"></div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="professional_response"><strong>Your Response:</strong></label>
                                                <textarea id="professional_response" 
                                                         name="professional_response" 
                                                         class="form-control" 
                                                         rows="3" 
                                                         maxlength="1000" 
                                                         placeholder="Explain your final price decision..."
                                                         required></textarea>
                                                <small class="text-muted">Max 1000 characters</small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="text-center">
                                        <button type="submit" class="btn btn-success btn-sm">
                                            <i class="fas fa-handshake"></i> Send Response to Customer
                                        </button>
                                    </div>
                                </form>
                            </div>
                        @endif
                    </div>
                    @endif

                    <!-- Professional Price Update Section -->
                    @if($additionalService->admin_status === 'approved' && $additionalService->negotiation_status !== 'user_negotiated')
                    <div class="alert alert-info">
                        <h5><i class="fas fa-edit"></i> Update Service Price</h5>
                        <p class="mb-3">You can update the service price if needed.</p>
                        
                        <form id="priceUpdateForm">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="new_price"><strong>New Price (₹):</strong></label>
                                        <input type="number" 
                                               id="new_price" 
                                               name="new_price" 
                                               class="form-control" 
                                               step="0.01" 
                                               min="{{ $additionalService->base_price * 0.5 }}"
                                               value="{{ $additionalService->final_price }}"
                                               required>
                                        <small class="text-muted">Minimum enforced</small>
                                        <div class="price-error text-danger mt-1" style="display: none;"></div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="price_reason"><strong>Reason for Update:</strong></label>
                                        <textarea id="price_reason" 
                                                 name="reason" 
                                                 class="form-control" 
                                                 rows="3" 
                                                 maxlength="1000" 
                                                 placeholder="Explain why you're updating the price..."
                                                 required></textarea>
                                        <small class="text-muted">Max 1000 characters</small>
                                    </div>
                                </div>
                            </div>
                            <div class="text-center">
                                <button type="submit" class="btn btn-primary btn-sm">
                                    <i class="fas fa-save"></i> Update Price
                                </button>
                            </div>
                        </form>
                    </div>
                    @endif

                    @if($additionalService->admin_status === 'rejected' && $additionalService->admin_reason)
                    <div class="alert alert-danger">
                        <h5><i class="fas fa-times-circle"></i> Rejection Reason</h5>
                        <p>{{ $additionalService->admin_reason }}</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card-box">
                <div class="card-block">
                    <h4 class="card-title">👤 Customer Information</h4>
                    
                    <div class="info-card">
                        <div class="form-group">
                            <label><strong>Customer Name:</strong></label>
                            <p>{{ $additionalService->user->name }}</p>
                        </div>
                        
                        <div class="form-group">
                            <label><strong>Email:</strong></label>
                            <p>{{ $additionalService->user->email }}</p>
                        </div>
                        
                        <div class="form-group">
                            <label><strong>Phone:</strong></label>
                            <p>{{ $additionalService->user->phone }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-box">
                <div class="card-block">
                    <h4 class="card-title">📊 Payment & Commission Details</h4>
                    
                    <div class="form-group">
                        <label><strong>Payment Status:</strong></label>
                        <p>
                            @if($additionalService->payment_status === 'pending')
                                <span class="badge badge-pending">Payment Pending</span>
                            @elseif($additionalService->payment_status === 'paid')
                                <span class="badge badge-paid">Paid</span>
                            @elseif($additionalService->payment_status === 'failed')
                                <span class="badge badge-rejected">Payment Failed</span>
                            @endif
                        </p>
                    </div>

                    @php
                        $professional = $additionalService->professional;
                        $finalPrice = $additionalService->final_price;
                        $serviceRequestMargin = $professional->service_request_margin ?? 0;
                        $serviceRequestOffset = $professional->service_request_offset ?? 0;
                        $platformCommission = ($finalPrice * $serviceRequestMargin) / 100;
                        $professionalEarning = $finalPrice - $platformCommission;
                    @endphp

                    <!-- Commission Breakdown -->
                    <div style="background: linear-gradient(135deg, #f8f9fa, #e9ecef); border-radius: 15px; padding: 1.5rem; margin: 1rem 0;">
                        <h6 style="margin-bottom: 1rem; color: #495057; font-weight: 600;">
                            <i class="fas fa-calculator" style="color: #667eea;"></i>
                            Commission Breakdown
                        </h6>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div style="background: rgba(102, 126, 234, 0.1); border-radius: 10px; padding: 1rem; margin-bottom: 0.5rem; border-left: 4px solid #667eea;">
                                    <div style="font-size: 0.875rem; color: #667eea; font-weight: 600; margin-bottom: 0.25rem;">Service Request Margin</div>
                                    <div style="font-size: 1.25rem; font-weight: 700; color: #495057;">{{ number_format($serviceRequestMargin, 2) }}%</div>
                                    <div style="font-size: 0.75rem; color: #6c757d;">Platform commission rate</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div style="background: rgba(40, 167, 69, 0.1); border-radius: 10px; padding: 1rem; margin-bottom: 0.5rem; border-left: 4px solid #28a745;">
                                    <div style="font-size: 0.875rem; color: #28a745; font-weight: 600; margin-bottom: 0.25rem;">Negotiation Status</div>
                                    <div style="font-size: 1.25rem; font-weight: 700; color: #495057;">
                                        @if($additionalService->negotiation_status === 'none')
                                            Available
                                        @elseif($additionalService->negotiation_status === 'user_negotiated')
                                            Pending
                                        @else
                                            Completed
                                        @endif
                                    </div>
                                    <div style="font-size: 0.75rem; color: #6c757d;">Customer negotiation allowed</div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div style="background: rgba(220, 53, 69, 0.1); border-radius: 10px; padding: 1rem; border-left: 4px solid #dc3545;">
                                    <div style="font-size: 0.875rem; color: #dc3545; font-weight: 600; margin-bottom: 0.25rem;">Platform Commission</div>
                                    <div style="font-size: 1.25rem; font-weight: 700; color: #495057;">₹{{ number_format($platformCommission, 2) }}</div>
                                    <div style="font-size: 0.75rem; color: #6c757d;">Deducted from service price</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div style="background: rgba(40, 167, 69, 0.1); border-radius: 10px; padding: 1rem; border-left: 4px solid #28a745;">
                                    <div style="font-size: 0.875rem; color: #28a745; font-weight: 600; margin-bottom: 0.25rem;">Your Earnings</div>
                                    <div style="font-size: 1.25rem; font-weight: 700; color: #495057;">₹{{ number_format($professionalEarning, 2) }}</div>
                                    <div style="font-size: 0.75rem; color: #6c757d;">After platform commission</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    @if($additionalService->payment_status === 'paid')
                    <div class="alert alert-success" style="border-radius: 12px; border: none; background: linear-gradient(135deg, rgba(40, 167, 69, 0.1), rgba(25, 135, 84, 0.1)); border-left: 4px solid #28a745;">
                        <div style="display: flex; align-items: center;">
                            <i class="fas fa-check-circle" style="color: #28a745; margin-right: 0.5rem; font-size: 1.25rem;"></i>
                            <div>
                                <strong style="color: #155724;">Payment Received</strong>
                                <div style="font-size: 0.875rem; color: #155724; margin-top: 0.25rem;">
                                    You'll receive ₹{{ number_format($professionalEarning, 2) }} ({{ number_format(100 - $serviceRequestMargin, 2) }}% of ₹{{ number_format($finalPrice, 2) }})
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif

                    <div class="form-group">
                        <label><strong>Created Date:</strong></label>
                        <p>{{ $additionalService->created_at->format('M d, Y h:i A') }}</p>
                    </div>
                </div>
            </div>

            <div class="card-box">
                <div class="card-block">
                    <h4 class="card-title">⚡ Quick Actions</h4>
                    
                    <div class="d-grid gap-2">
                        @if($additionalService->canStartConsultation())
                        <button class="btn btn-success start-consultation" data-id="{{ $additionalService->id }}">
                            <i class="fas fa-play"></i> Start Consultation
                        </button>
                        @endif

                        @if($additionalService->canMarkAsCompleted())
                        <button class="btn btn-primary mark-completed" data-id="{{ $additionalService->id }}">
                            <i class="fas fa-check-circle"></i> Mark as Completed
                        </button>
                        @endif

                        @if($additionalService->canSetDeliveryDate())
                        <button class="btn btn-info set-delivery-date" data-id="{{ $additionalService->id }}">
                            <i class="fas fa-calendar-plus"></i> Set Delivery Date
                        </button>
                        @endif

                        @if($additionalService->canCompleteConsultation())
                        <button class="btn btn-success complete-consultation" data-id="{{ $additionalService->id }}">
                            <i class="fas fa-flag-checkered"></i> Complete Consultation
                        </button>
                        @endif

                        @if($additionalService->consulting_status === 'done' && !$additionalService->customer_confirmed_at)
                        <div class="alert alert-info">
                            <small><i class="fas fa-clock"></i> Waiting for customer confirmation</small>
                        </div>
                        @endif

                        @if($additionalService->canUpdateDeliveryDate())
                        <button class="btn btn-warning update-delivery" data-id="{{ $additionalService->id }}">
                            <i class="fas fa-calendar"></i> Update Delivery Date
                        </button>
                        @endif

                        <a href="{{ route('professional.additional-services.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left"></i> Back to List
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Custom Start Consultation Modal -->
<div class="custom-modal" id="startConsultationModal">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">🚀 Start Consultation</h5>
            <button type="button" class="modal-close" onclick="closeModal('startConsultationModal')">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <form id="startConsultationForm">
            <div class="modal-body">
                <div class="alert alert-info">
                    <i class="fas fa-info-circle"></i>
                    <strong>Note:</strong> This will mark the consultation as "In Progress" and notify the customer.
                </div>
                <div class="mb-3">
                    <label for="consultation_notes" class="form-label">
                        <i class="fas fa-clipboard"></i> Consultation Notes (Optional)
                    </label>
                    <textarea class="form-control" id="consultation_notes" name="consultation_notes" 
                              rows="4" placeholder="Add any initial notes or instructions for the consultation..."></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" onclick="closeModal('startConsultationModal')">
                    <i class="fas fa-times"></i> Cancel
                </button>
                <button type="submit" class="btn btn-success">
                    <i class="fas fa-play"></i> Start Consultation
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Custom Mark Completed Modal -->
<div class="custom-modal" id="markCompletedModal">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">✅ Mark Consultation as Completed</h5>
            <button type="button" class="modal-close" onclick="closeModal('markCompletedModal')">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <form id="markCompletedForm">
            <div class="modal-body">
                <div class="text-center mb-4">
                    <div class="bg-success bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                        <i class="fas fa-check-circle text-success" style="font-size: 2.5rem;"></i>
                    </div>
                </div>
                <h6 class="text-center mb-3">Consultation Completion</h6>
                <div class="alert alert-success">
                    <i class="fas fa-check-circle"></i>
                    <strong>Important:</strong> This will mark the consultation as completed and notify the customer for confirmation.
                </div>
                <div class="mb-3">
                    <label for="completion_notes" class="form-label">
                        <i class="fas fa-clipboard-check"></i> Completion Summary *
                    </label>
                    <textarea class="form-control" id="completion_notes" name="completion_notes" 
                              rows="4" required placeholder="Provide a summary of the work completed..."></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" onclick="closeModal('markCompletedModal')">
                    <i class="fas fa-times"></i> Cancel
                </button>
                <button type="submit" class="btn btn-success">
                    <i class="fas fa-check-circle"></i> Mark as Completed
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Custom Update Delivery Modal -->
<div class="custom-modal" id="updateDeliveryModal">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">📅 Update Delivery Date</h5>
            <button type="button" class="modal-close" onclick="closeModal('updateDeliveryModal')">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <form id="updateDeliveryForm">
            <div class="modal-body">
                @if($additionalService->delivery_date)
                <div class="alert alert-info">
                    <strong>Current Delivery Date:</strong> {{ \Carbon\Carbon::parse($additionalService->delivery_date)->format('M d, Y') }}
                </div>
                @endif
                <div class="mb-3">
                    <label for="new_delivery_date" class="form-label">
                        <i class="fas fa-calendar"></i> New Delivery Date *
                    </label>
                    <input type="date" class="form-control" id="new_delivery_date" name="delivery_date" required
                           min="{{ date('Y-m-d') }}" value="{{ $additionalService->delivery_date }}">
                </div>
                <div class="mb-3">
                    <label for="delivery_notes" class="form-label">
                        <i class="fas fa-comment"></i> Reason for Date Change *
                    </label>
                    <textarea class="form-control" id="delivery_notes" name="delivery_notes" 
                              rows="3" required placeholder="Please explain why the delivery date is being changed..."></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" onclick="closeModal('updateDeliveryModal')">
                    <i class="fas fa-times"></i> Cancel
                </button>
                <button type="submit" class="btn btn-warning">
                    <i class="fas fa-calendar"></i> Update Date
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Set Delivery Date Modal -->
<div class="custom-modal" id="setDeliveryDateModal">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">📅 Set Delivery Date</h5>
            <button type="button" class="modal-close" onclick="closeModal('setDeliveryDateModal')">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <form id="setDeliveryDateForm">
            <div class="modal-body">
                <div class="alert alert-info">
                    <strong>Important:</strong> Setting a delivery date will notify the customer and admin about when the consultation will be available for completion.
                </div>
                <div class="mb-3">
                    <label for="delivery_date" class="form-label">
                        <i class="fas fa-calendar"></i> Delivery Date *
                    </label>
                    <input type="date" class="form-control" id="delivery_date" name="delivery_date" required
                           min="{{ date('Y-m-d', strtotime('+1 day')) }}">
                </div>
                <div class="mb-3">
                    <label for="delivery_reason" class="form-label">
                        <i class="fas fa-comment"></i> Reason/Notes *
                    </label>
                    <textarea class="form-control" id="delivery_reason" name="delivery_reason" 
                              rows="3" required placeholder="Please explain why this delivery date is needed..."></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" onclick="closeModal('setDeliveryDateModal')">
                    <i class="fas fa-times"></i> Cancel
                </button>
                <button type="submit" class="btn btn-info">
                    <i class="fas fa-calendar-plus"></i> Set Date
                </button>
            </div>
        </form>
    </div>
</div>
</div>
@endsection
@section('scripts')
<script>
$(document).ready(function() {
    const currentServiceId = {{ $additionalService->id }};

    // Custom Modal Functions
    function openModal(modalId) {
        $('#' + modalId).addClass('show');
        $('body').css('overflow', 'hidden');
        
        // Add entrance animation
        $('#' + modalId + ' .modal-content').css({
            'transform': 'scale(0.8) translateY(50px)',
            'opacity': '0'
        });
        
        setTimeout(function() {
            $('#' + modalId + ' .modal-content').css({
                'transform': 'scale(1) translateY(0)',
                'opacity': '1',
                'transition': 'all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1)'
            });
        }, 50);
    }

    function closeModal(modalId) {
        $('#' + modalId + ' .modal-content').css({
            'transform': 'scale(0.8) translateY(30px)',
            'opacity': '0',
            'transition': 'all 0.25s ease-out'
        });
        
        setTimeout(function() {
            $('#' + modalId).removeClass('show');
            $('body').css('overflow', 'auto');
        }, 250);
    }

    // Make closeModal available globally
    window.closeModal = closeModal;

    // Close modal when clicking outside
    $('.custom-modal').on('click', function(e) {
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

    // Show loading state for buttons
    function showButtonLoading($btn, loadingText) {
        const originalText = $btn.html();
        $btn.data('original-text', originalText);
        $btn.prop('disabled', true).html(`<i class="fas fa-spinner fa-spin"></i> ${loadingText}`);
        return originalText;
    }

    function hideButtonLoading($btn) {
        const originalText = $btn.data('original-text');
        $btn.prop('disabled', false).html(originalText);
    }

    // Start Consultation
    $(document).on('click', '.start-consultation', function(e) {
        e.preventDefault();
        openModal('startConsultationModal');
    });

    $('#startConsultationForm').submit(function(e) {
        e.preventDefault();
        const $submitBtn = $(this).find('button[type="submit"]');
        showButtonLoading($submitBtn, 'Starting...');

        $.ajax({
            url: `/professional/additional-services/${currentServiceId}/start-consultation`,
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                consultation_notes: $('#consultation_notes').val()
            },
            success: function(response) {
                if (response.success) {
                    closeModal('startConsultationModal');
                    
                    // Show success notification
                    if (typeof toastr !== 'undefined') {
                        toastr.success(response.message || 'Consultation started successfully!');
                    } else {
                        alert(response.message || 'Consultation started successfully!');
                    }
                    
                    setTimeout(() => location.reload(), 1500);
                } else {
                    if (typeof toastr !== 'undefined') {
                        toastr.error(response.message || 'Failed to start consultation');
                    } else {
                        alert(response.message || 'Failed to start consultation');
                    }
                }
            },
            error: function(xhr) {
                console.error('Start consultation error:', xhr);
                const message = xhr.responseJSON?.message || 'An error occurred. Please try again.';
                if (typeof toastr !== 'undefined') {
                    toastr.error(message);
                } else {
                    alert(message);
                }
            },
            complete: function() {
                hideButtonLoading($submitBtn);
            }
        });
    });

    // Mark Completed
    $(document).on('click', '.mark-completed', function(e) {
        e.preventDefault();
        openModal('markCompletedModal');
    });

    $('#markCompletedForm').submit(function(e) {
        e.preventDefault();
        const $submitBtn = $(this).find('button[type="submit"]');
        showButtonLoading($submitBtn, 'Completing...');

        $.ajax({
            url: `/professional/additional-services/${currentServiceId}/mark-completed`,
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                completion_notes: $('#completion_notes').val()
            },
            success: function(response) {
                if (response.success) {
                    closeModal('markCompletedModal');
                    
                    if (typeof toastr !== 'undefined') {
                        toastr.success(response.message || 'Consultation marked as completed!');
                    } else {
                        alert(response.message || 'Consultation marked as completed!');
                    }
                    
                    setTimeout(() => location.reload(), 1500);
                } else {
                    if (typeof toastr !== 'undefined') {
                        toastr.error(response.message || 'Failed to mark consultation as completed');
                    } else {
                        alert(response.message || 'Failed to mark consultation as completed');
                    }
                }
            },
            error: function(xhr) {
                console.error('Mark completed error:', xhr);
                
                // Handle validation errors
                const errors = xhr.responseJSON?.errors;
                if (errors) {
                    Object.values(errors).forEach(function(error) {
                        const message = Array.isArray(error) ? error[0] : error;
                        if (typeof toastr !== 'undefined') {
                            toastr.error(message);
                        } else {
                            alert(message);
                        }
                    });
                } else {
                    const message = xhr.responseJSON?.message || 'An error occurred. Please try again.';
                    if (typeof toastr !== 'undefined') {
                        toastr.error(message);
                    } else {
                        alert(message);
                    }
                }
            },
            complete: function() {
                hideButtonLoading($submitBtn);
            }
        });
    });

    // Set Delivery Date (initial setting)
    $(document).on('click', '.set-delivery-date', function(e) {
        e.preventDefault();
        openModal('setDeliveryDateModal');
    });

    $('#setDeliveryDateForm').submit(function(e) {
        e.preventDefault();
        const $submitBtn = $(this).find('button[type="submit"]');
        showButtonLoading($submitBtn, 'Setting...');

        const formData = {
            _token: '{{ csrf_token() }}',
            delivery_date: $('#delivery_date').val(),
            delivery_reason: $('#delivery_reason').val()
        };

        $.ajax({
            url: `/professional/additional-services/${currentServiceId}/set-delivery-date`,
            type: 'POST',
            data: formData,
            success: function(response) {
                if (response.success) {
                    closeModal('setDeliveryDateModal');
                    
                    if (typeof toastr !== 'undefined') {
                        toastr.success(response.message || 'Delivery date set successfully!');
                    } else {
                        alert(response.message || 'Delivery date set successfully!');
                    }
                    
                    setTimeout(() => location.reload(), 1500);
                } else {
                    if (typeof toastr !== 'undefined') {
                        toastr.error(response.message || 'Failed to set delivery date');
                    } else {
                        alert(response.message || 'Failed to set delivery date');
                    }
                }
            },
            error: function(xhr) {
                console.error('Set delivery date error:', xhr);
                
                // Handle validation errors
                const errors = xhr.responseJSON?.errors;
                if (errors) {
                    Object.values(errors).forEach(function(error) {
                        const message = Array.isArray(error) ? error[0] : error;
                        if (typeof toastr !== 'undefined') {
                            toastr.error(message);
                        } else {
                            alert(message);
                        }
                    });
                } else {
                    const message = xhr.responseJSON?.message || 'An error occurred. Please try again.';
                    if (typeof toastr !== 'undefined') {
                        toastr.error(message);
                    } else {
                        alert(message);
                    }
                }
            },
            complete: function() {
                hideButtonLoading($submitBtn);
            }
        });
    });

    // Update Delivery Date
    $(document).on('click', '.update-delivery', function(e) {
        e.preventDefault();
        openModal('updateDeliveryModal');
    });

    // Complete Consultation (after delivery date passes)
    $(document).on('click', '.complete-consultation', function(e) {
        e.preventDefault();
        const $btn = $(this);
        
        if (confirm('Are you sure you want to mark this consultation as completed? This will notify the customer for final confirmation.')) {
            showButtonLoading($btn, 'Completing...');

            $.ajax({
                url: `/professional/additional-services/${currentServiceId}/complete-consultation`,
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.success) {
                        if (typeof toastr !== 'undefined') {
                            toastr.success(response.message || 'Consultation completed successfully!');
                        } else {
                            alert(response.message || 'Consultation completed successfully!');
                        }
                        
                        setTimeout(() => location.reload(), 1500);
                    } else {
                        if (typeof toastr !== 'undefined') {
                            toastr.error(response.message || 'Failed to complete consultation');
                        } else {
                            alert(response.message || 'Failed to complete consultation');
                        }
                    }
                },
                error: function(xhr) {
                    console.error('Complete consultation error:', xhr);
                    const message = xhr.responseJSON?.message || 'An error occurred. Please try again.';
                    if (typeof toastr !== 'undefined') {
                        toastr.error(message);
                    } else {
                        alert(message);
                    }
                },
                complete: function() {
                    hideButtonLoading($btn);
                }
            });
        }
    });

    // Update Delivery Date
    $(document).on('click', '.update-delivery', function(e) {
        e.preventDefault();
        openModal('updateDeliveryModal');
    });

    // Update Delivery Date form submission
    $('#updateDeliveryForm').submit(function(e) {
        e.preventDefault();
        const $submitBtn = $(this).find('button[type="submit"]');
        showButtonLoading($submitBtn, 'Updating...');

        const formData = {
            _token: '{{ csrf_token() }}',
            delivery_date: $('#new_delivery_date').val(),
            delivery_notes: $('#delivery_notes').val()
        };

        $.ajax({
            url: `/professional/additional-services/${currentServiceId}/update-delivery-date`,
            type: 'POST',
            data: formData,
            success: function(response) {
                if (response.success) {
                    closeModal('updateDeliveryModal');
                    
                    if (typeof toastr !== 'undefined') {
                        toastr.success(response.message || 'Delivery date updated successfully!');
                    } else {
                        alert(response.message || 'Delivery date updated successfully!');
                    }
                    
                    setTimeout(() => location.reload(), 1500);
                } else {
                    if (typeof toastr !== 'undefined') {
                        toastr.error(response.message || 'Failed to update delivery date');
                    } else {
                        alert(response.message || 'Failed to update delivery date');
                    }
                }
            },
            error: function(xhr) {
                console.error('Update delivery date error:', xhr);
                
                // Handle validation errors
                const errors = xhr.responseJSON?.errors;
                if (errors) {
                    Object.values(errors).forEach(function(error) {
                        const message = Array.isArray(error) ? error[0] : error;
                        if (typeof toastr !== 'undefined') {
                            toastr.error(message);
                        } else {
                            alert(message);
                        }
                    });
                } else {
                    const message = xhr.responseJSON?.message || 'An error occurred. Please try again.';
                    if (typeof toastr !== 'undefined') {
                        toastr.error(message);
                    } else {
                        alert(message);
                    }
                }
            },
            complete: function() {
                hideButtonLoading($submitBtn);
            }
        });
    });

    // Add smooth entrance animations to cards
    $('.card-box').each(function(index) {
        $(this).css({
            'animation-delay': (index * 0.1) + 's',
            'animation-fill-mode': 'both'
        });
    });

    // Add hover effects to action buttons
    $('.btn').hover(
        function() {
            $(this).css('transform', 'translateY(-2px)');
        },
        function() {
            $(this).css('transform', 'translateY(0)');
        }
    );

    // Initialize tooltips if available
    if (typeof $().tooltip === 'function') {
        $('[data-toggle="tooltip"]').tooltip();
    }

    // Auto-focus first input in modals when opened
    $('.custom-modal').on('transitionend', function() {
        if ($(this).hasClass('show')) {
            $(this).find('input, textarea').first().focus();
        }
    });

    // Form validation styling
    $('form').on('submit', function() {
        $(this).find('.form-control').each(function() {
            if ($(this).prop('required') && !$(this).val()) {
                $(this).addClass('is-invalid');
            } else {
                $(this).removeClass('is-invalid');
            }
        });
    });

    // Remove validation styling on input
    $('.form-control').on('input change', function() {
        $(this).removeClass('is-invalid');
    });

    // Price validation for professional negotiation and price update
    function validatePrice(priceInput, minPrice) {
        const price = parseFloat(priceInput.val());
        const minPriceFloat = parseFloat(minPrice);
        const errorDiv = priceInput.siblings('.price-error');
        
        if (price < minPriceFloat) {
            errorDiv.text('Price cannot be below the allowed minimum').show();
            priceInput.addClass('is-invalid');
            return false;
        } else {
            errorDiv.hide();
            priceInput.removeClass('is-invalid');
            return true;
        }
    }

    // Real-time price validation
    $('#professional_final_price, #new_price').on('input change', function() {
        const minPrice = $(this).attr('min');
        validatePrice($(this), minPrice);
    });

    // Professional Negotiation Response Form
    $('#negotiationResponseForm').submit(function(e) {
        e.preventDefault();
        
        const priceInput = $('#professional_final_price');
        const minPrice = priceInput.attr('min');
        
        // Validate price before submission
        if (!validatePrice(priceInput, minPrice)) {
            return false;
        }
        
        const $submitBtn = $(this).find('button[type="submit"]');
        showButtonLoading($submitBtn, 'Sending Response...');

        const formData = {
            _token: '{{ csrf_token() }}',
            professional_final_price: priceInput.val(),
            professional_response: $('#professional_response').val(),
            min_price: minPrice
        };

        $.ajax({
            url: `/professional/additional-services/${currentServiceId}/respond-negotiation`,
            type: 'POST',
            data: formData,
            success: function(response) {
                if (response.success) {
                    if (typeof toastr !== 'undefined') {
                        toastr.success(response.message || 'Negotiation response sent successfully!');
                    } else {
                        alert(response.message || 'Negotiation response sent successfully!');
                    }
                    
                    setTimeout(() => location.reload(), 1500);
                } else {
                    if (typeof toastr !== 'undefined') {
                        toastr.error(response.message || 'Failed to send negotiation response');
                    } else {
                        alert(response.message || 'Failed to send negotiation response');
                    }
                }
            },
            error: function(xhr) {
                console.error('Negotiation response error:', xhr);
                
                // Handle validation errors
                const errors = xhr.responseJSON?.errors;
                if (errors) {
                    Object.values(errors).forEach(function(error) {
                        const message = Array.isArray(error) ? error[0] : error;
                        if (typeof toastr !== 'undefined') {
                            toastr.error(message);
                        } else {
                            alert(message);
                        }
                    });
                } else {
                    const message = xhr.responseJSON?.message || 'An error occurred. Please try again.';
                    if (typeof toastr !== 'undefined') {
                        toastr.error(message);
                    } else {
                        alert(message);
                    }
                }
            },
            complete: function() {
                hideButtonLoading($submitBtn);
            }
        });
    });

    // Professional Price Update Form
    $('#priceUpdateForm').submit(function(e) {
        e.preventDefault();
        
        const priceInput = $('#new_price');
        const minPrice = priceInput.attr('min');
        
        // Validate price before submission
        if (!validatePrice(priceInput, minPrice)) {
            return false;
        }
        
        const $submitBtn = $(this).find('button[type="submit"]');
        showButtonLoading($submitBtn, 'Updating Price...');

        const formData = {
            _token: '{{ csrf_token() }}',
            new_price: priceInput.val(),
            reason: $('#price_reason').val(),
            min_price: minPrice
        };

        $.ajax({
            url: `/professional/additional-services/${currentServiceId}/update-price`,
            type: 'POST',
            data: formData,
            success: function(response) {
                if (response.success) {
                    if (typeof toastr !== 'undefined') {
                        toastr.success(response.message || 'Service price updated successfully!');
                    } else {
                        alert(response.message || 'Service price updated successfully!');
                    }
                    
                    setTimeout(() => location.reload(), 1500);
                } else {
                    if (typeof toastr !== 'undefined') {
                        toastr.error(response.message || 'Failed to update service price');
                    } else {
                        alert(response.message || 'Failed to update service price');
                    }
                }
            },
            error: function(xhr) {
                console.error('Price update error:', xhr);
                
                // Handle validation errors
                const errors = xhr.responseJSON?.errors;
                if (errors) {
                    Object.values(errors).forEach(function(error) {
                        const message = Array.isArray(error) ? error[0] : error;
                        if (typeof toastr !== 'undefined') {
                            toastr.error(message);
                        } else {
                            alert(message);
                        }
                    });
                } else {
                    const message = xhr.responseJSON?.message || 'An error occurred. Please try again.';
                    if (typeof toastr !== 'undefined') {
                        toastr.error(message);
                    } else {
                        alert(message);
                    }
                }
            },
            complete: function() {
                hideButtonLoading($submitBtn);
            }
        });
    });

    console.log('Professional additional services show page initialized successfully');
});
</script>
@endsection