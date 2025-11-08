 @extends('admin.layouts.layout')

@section('styles')
<style>
    .content-card {
        background: white;
        border-radius: 15px;
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.1);
        padding: 30px;
        margin-bottom: 25px;
        border: 1px solid #e3f2fd;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .content-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 12px 40px rgba(0, 0, 0, 0.15);
    }

    .card-header {
        background: linear-gradient(135deg, #007bff 0%, #6c5ce7 100%);
        color: white;
        border-radius: 10px;
        padding: 20px;
        margin: -30px -30px 25px -30px;
        border: none;
    }

    .card-title {
        margin: 0;
        font-size: 1.25rem;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .status-badge {
        padding: 8px 16px;
        border-radius: 25px;
        font-size: 0.875rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        display: inline-flex;
        align-items: center;
        gap: 5px;
    }

    .status-pending {
        background: linear-gradient(135deg, #fff3cd 0%, #ffeaa7 100%);
        color: #856404;
        border: 1px solid #ffeaa7;
    }

    .status-approved {
        background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%);
        color: #155724;
        border: 1px solid #c3e6cb;
    }

    .status-rejected {
        background: linear-gradient(135deg, #f8d7da 0%, #f5c6cb 100%);
        color: #721c24;
        border: 1px solid #f5c6cb;
    }

    .status-paid {
        background: linear-gradient(135deg, #d1ecf1 0%, #bee5eb 100%);
        color: #0c5460;
        border: 1px solid #bee5eb;
    }

    .status-later {
        background: linear-gradient(135deg, #e2e3e5 0%, #d6d8db 100%);
        color: #383d41;
        border: 1px solid #d6d8db;
    }

    .info-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 20px;
        margin-bottom: 20px;
    }

    .info-item {
        padding: 15px;
        background: #f8f9fa;
        border-radius: 10px;
        border-left: 4px solid #007bff;
    }

    .info-label {
        font-weight: 600;
        color: #495057;
        margin-bottom: 8px;
        font-size: 0.9rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .info-value {
        color: #212529;
        font-size: 1rem;
        line-height: 1.5;
    }

    .price-section {
        background: linear-gradient(135deg, #e8f5e8 0%, #d4edda 100%);
        border-left: 5px solid #28a745;
        border-radius: 15px;
        padding: 25px;
        position: relative;
        overflow: hidden;
    }

    .price-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }

    .price-breakdown {
        background: rgba(255, 255, 255, 0.9);
        padding: 20px;
        border-radius: 10px;
        margin-bottom: 15px;
        backdrop-filter: blur(10px);
    }

    .price-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 10px;
        padding: 8px 0;
    }

    .price-row.total {
        border-top: 2px solid #28a745;
        padding-top: 15px;
        margin-top: 15px;
        font-weight: bold;
        font-size: 1.2rem;
        color: #28a745;
    }

    .timeline {
        position: relative;
        padding-left: 30px;
    }

    .timeline::before {
        content: '';
        position: absolute;
        left: 15px;
        top: 0;
        bottom: 0;
        width: 2px;
        background: linear-gradient(to bottom, #007bff, #28a745);
    }

    .timeline-item {
        position: relative;
        margin-bottom: 25px;
        background: #f8f9fa;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }

    .timeline-item::before {
        content: '';
        position: absolute;
        left: -23px;
        top: 20px;
        width: 12px;
        height: 12px;
        border-radius: 50%;
        background: #007bff;
        border: 3px solid white;
        box-shadow: 0 0 0 2px #007bff;
    }

    .action-buttons {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
        margin-bottom: 20px;
    }

    .btn {
        padding: 12px 24px;
        border-radius: 10px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        transition: all 0.3s ease;
        border: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
    }

    .btn-primary {
        background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
        color: white;
    }

    .btn-success {
        background: linear-gradient(135deg, #28a745 0%, #1e7e34 100%);
        color: white;
    }

    .btn-warning {
        background: linear-gradient(135deg, #ffc107 0%, #e0a800 100%);
        color: #212529;
    }

    .btn-danger {
        background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
        color: white;
    }

    .btn-secondary {
        background: linear-gradient(135deg, #6c757d 0%, #545b62 100%);
        color: white;
    }

    .btn-info {
        background: linear-gradient(135deg, #17a2b8 0%, #138496 100%);
        color: white;
    }

    .price-edit-btn {
        background: linear-gradient(135deg, #ffc107 0%, #ff8c00 100%);
        color: white !important;
        font-weight: 700;
        box-shadow: 0 4px 15px rgba(255, 193, 7, 0.4);
        position: relative;
        overflow: hidden;
    }

    .price-edit-btn::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
        transition: left 0.5s;
    }

    .price-edit-btn:hover::before {
        left: 100%;
    }

    .alert {
        border: none;
        border-radius: 12px;
        padding: 20px;
        margin-bottom: 20px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        border-left: 5px solid;
    }

    .alert-info {
        background: linear-gradient(135deg, #d1ecf1 0%, #bee5eb 100%);
        color: #0c5460;
        border-left-color: #17a2b8;
    }

    .alert-warning {
        background: linear-gradient(135deg, #fff3cd 0%, #ffeaa7 100%);
        color: #856404;
        border-left-color: #ffc107;
    }

    .alert-success {
        background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%);
        color: #155724;
        border-left-color: #28a745;
    }

    .sessions-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
        gap: 10px;
        margin-top: 15px;
    }

    .session-badge {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        border: 2px solid #dee2e6;
        padding: 12px;
        border-radius: 10px;
        text-align: center;
        font-size: 0.85rem;
        transition: all 0.2s ease;
    }

    .session-badge:hover {
        background: linear-gradient(135deg, #e9ecef 0%, #dee2e6 100%);
        transform: scale(1.05);
    }

    .breadcrumb {
        background: transparent;
        padding: 0;
        margin-bottom: 20px;
    }

    .breadcrumb-item a {
        color: #007bff;
        text-decoration: none;
    }

    .breadcrumb-item.active {
        color: #6c757d;
    }

    .earnings-breakdown {
        background: rgba(255, 255, 255, 0.8);
        border-radius: 8px;
        padding: 15px;
    }

    .earnings-breakdown .d-flex {
        align-items: center;
        border-bottom: 1px solid #e9ecef;
        padding: 5px 0;
    }

    .earnings-breakdown .d-flex:last-child {
        border-bottom: none;
    }

    @media (max-width: 768px) {
        .info-grid {
            grid-template-columns: 1fr;
        }
        
        .action-buttons {
            flex-direction: column;
        }
        
        .btn {
            width: 100%;
            justify-content: center;
        }
    }
</style>
@endsection

@section('content')
<div class="main-content app-content">
    <div class="container-fluid">

        <!-- Page Header -->
        <div class="my-4 page-header-breadcrumb d-flex align-items-center flex-wrap gap-2">
            <div>
                <h1 class="page-title fw-medium fs-18 mb-2">Re-requested Service Details</h1>
                <div class="">
                    <nav>
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('admin.re-requested-services.index') }}">Re-requested Services</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Review #{{ $reRequestedService->id }}</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <div class="ms-auto">
                <span class="status-badge status-{{ $reRequestedService->admin_status }}">
                    <i class="fas fa-{{ $reRequestedService->admin_status === 'approved' ? 'check' : ($reRequestedService->admin_status === 'rejected' ? 'times' : 'clock') }}"></i>
                    {{ ucfirst($reRequestedService->admin_status) }}
                </span>
            </div>
        </div>
        <!-- Page Header Close -->

        <div class="row">
            <!-- Main Content -->
            <div class="col-lg-8">
                <!-- Admin Actions (for pending requests) -->
                @if($reRequestedService->admin_status === 'pending')
                <div class="content-card">
                    <div class="alert alert-warning">
                        <h5><i class="fas fa-exclamation-triangle"></i> Action Required</h5>
                        <p class="mb-0">This request is pending your review. Please take appropriate action.</p>
                    </div>
                    
                    <div class="action-buttons">
                        <a href="{{ route('admin.re-requested-services.edit', $reRequestedService) }}" class="btn btn-primary">
                            <i class="fas fa-edit"></i> Review & Edit
                        </a>
                        <button type="button" class="btn btn-success" onclick="quickAction('approve')">
                            <i class="fas fa-check"></i> Quick Approve
                        </button>
                        <button type="button" class="btn btn-danger" onclick="quickAction('reject')">
                            <i class="fas fa-times"></i> Quick Reject
                        </button>
                        <button type="button" class="btn price-edit-btn" onclick="showPriceEditModal()">
                            <i class="fas fa-dollar-sign"></i> Edit Price
                        </button>
                    </div>
                </div>
                @endif

                <!-- Service Information -->
                <div class="content-card">
                    <div class="card-header">
                        <h5 class="card-title">
                            <i class="fas fa-info-circle"></i>
                            Service Information
                        </h5>
                    </div>

                    <div class="info-grid">
                        <div class="info-item">
                            <div class="info-label">Service Name</div>
                            <div class="info-value">{{ $reRequestedService->service_name }}</div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">Request ID</div>
                            <div class="info-value">#{{ $reRequestedService->id }}</div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">Professional</div>
                            <div class="info-value">
                                <strong>{{ $reRequestedService->professional->name }}</strong><br>
                                <small class="text-muted">
                                    <i class="fas fa-envelope"></i> {{ $reRequestedService->professional->email }}<br>
                                    <i class="fas fa-phone"></i> {{ $reRequestedService->professional->mobile }}
                                </small>
                            </div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">Customer</div>
                            <div class="info-value">
                                <strong>{{ $reRequestedService->user->name }}</strong><br>
                                <small class="text-muted">
                                    <i class="fas fa-envelope"></i> {{ $reRequestedService->user->email }}<br>
                                    <i class="fas fa-phone"></i> {{ $reRequestedService->user->mobile ?? 'N/A' }}
                                </small>
                            </div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">Admin Status</div>
                            <div class="info-value">
                                <span class="status-badge status-{{ $reRequestedService->admin_status }}">
                                    <i class="fas fa-{{ $reRequestedService->admin_status === 'approved' ? 'check' : ($reRequestedService->admin_status === 'rejected' ? 'times' : 'clock') }}"></i>
                                    {{ ucfirst($reRequestedService->admin_status) }}
                                </span>
                                @if($reRequestedService->admin_reviewed_at)
                                    <br><small class="text-muted">
                                        Reviewed: {{ $reRequestedService->admin_reviewed_at->format('M d, Y h:i A') }}
                                    </small>
                                @endif
                            </div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">User Status</div>
                            <div class="info-value">
                                <span class="status-badge status-{{ $reRequestedService->user_status }}">
                                    <i class="fas fa-{{ $reRequestedService->user_status === 'paid' ? 'credit-card' : ($reRequestedService->user_status === 'later' ? 'clock' : 'hourglass-half') }}"></i>
                                    {{ $reRequestedService->user_status == 'later' ? 'Do Later' : ucfirst($reRequestedService->user_status) }}
                                </span>
                                @if($reRequestedService->user_responded_at)
                                    <br><small class="text-muted">
                                        Responded: {{ $reRequestedService->user_responded_at->format('M d, Y h:i A') }}
                                    </small>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="info-item">
                        <div class="info-label">Reason for Additional Service</div>
                        <div class="info-value">
                            <div class="alert alert-info">
                                <i class="fas fa-quote-left"></i>
                                {{ $reRequestedService->reason }}
                            </div>
                        </div>
                    </div>

                    @if($reRequestedService->admin_reason)
                    <div class="info-item">
                        <div class="info-label">Admin Comments</div>
                        <div class="info-value">
                            <div class="alert alert-{{ $reRequestedService->admin_status == 'approved' ? 'success' : 'warning' }}">
                                <i class="fas fa-{{ $reRequestedService->admin_status == 'approved' ? 'check-circle' : 'exclamation-triangle' }}"></i>
                                {{ $reRequestedService->admin_reason }}
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- User Negotiation Section -->
                    @if($reRequestedService->user_negotiated_price || $reRequestedService->user_negotiation_reason)
                    <div class="info-item">
                        <div class="info-label">User Price Negotiation</div>
                        <div class="info-value">
                            <div class="alert alert-light border" style="border-left: 4px solid #17a2b8 !important;">
                                <div class="row">
                                    @if($reRequestedService->user_negotiated_price)
                                        <div class="col-md-6">
                                            <strong class="text-info">
                                                <i class="fas fa-money-bill-wave"></i> Negotiated Price:
                                            </strong>
                                            <div class="h5 text-primary mb-0">
                                                ₹{{ number_format($reRequestedService->user_negotiated_price, 2) }}
                                            </div>
                                            @php
                                                $originalPrice = $reRequestedService->getFinalPriceAttribute();
                                                $discount = $originalPrice - $reRequestedService->user_negotiated_price;
                                                $discountPercentage = $originalPrice > 0 ? ($discount / $originalPrice) * 100 : 0;
                                            @endphp
                                            <small class="text-muted">
                                                (₹{{ number_format($discount, 2) }} discount - {{ number_format($discountPercentage, 1) }}%)
                                            </small>
                                        </div>
                                    @endif
                                    
                                    @if($reRequestedService->user_negotiation_reason)
                                        <div class="col-md-6">
                                            <strong class="text-info">
                                                <i class="fas fa-comment-alt"></i> Reason:
                                            </strong>
                                            <p class="mb-0 mt-1">{{ $reRequestedService->user_negotiation_reason }}</p>
                                        </div>
                                    @endif
                                </div>
                                
                                @if($reRequestedService->negotiation_status)
                                    <hr class="my-2">
                                    <div class="d-flex align-items-center">
                                        <strong class="text-muted me-2">Status:</strong>
                                        <span class="badge-{{ $reRequestedService->negotiation_status === 'admin_responded' ? 'success' : ($reRequestedService->negotiation_status === 'rejected' ? 'danger' : 'warning') }}">
                                            <i class="fas fa-{{ $reRequestedService->negotiation_status === 'admin_responded' ? 'check-circle' : ($reRequestedService->negotiation_status === 'rejected' ? 'times-circle' : 'clock') }}"></i>
                                            {{ ucwords(str_replace('_', ' ', $reRequestedService->negotiation_status)) }}
                                        </span>
                                        
                                        @if($reRequestedService->negotiation_status === 'admin_responded' && $reRequestedService->admin_final_negotiated_price)
                                            <span class="ml-3 text-success font-weight-bold">
                                                Final Price: ₹{{ number_format($reRequestedService->admin_final_negotiated_price, 2) }}
                                            </span>
                                        @endif
                                    </div>
                                    
                                    @if($reRequestedService->admin_negotiation_response)
                                        <div class="mt-2">
                                            <strong class="text-muted">Admin Response:</strong>
                                            <p class="mb-0 mt-1 small">{{ $reRequestedService->admin_negotiation_response }}</p>
                                        </div>
                                    @endif
                                    
                                    <!-- Admin Negotiation Response Form -->
                                    @if($reRequestedService->negotiation_status === 'user_negotiated')
                                        <div class="mt-3">
                                            <button type="button" class="btn btn-primary btn-sm" onclick="showNegotiationResponseModal()">
                                                <i class="fas fa-reply"></i> Respond to Negotiation
                                            </button>
                                        </div>
                                    @endif
                                @endif
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- Delivery Date Section -->
                    @if($reRequestedService->delivery_date_set && $reRequestedService->delivery_date)
                    <div class="info-item">
                        <div class="info-label">Delivery Information</div>
                        <div class="info-value">
                            <div class="alert alert-success border" style="border-left: 4px solid #28a745 !important;">
                                <div class="row">
                                    <div class="col-md-6">
                                        <strong class="text-success">
                                            <i class="fas fa-calendar-check"></i> Expected Delivery Date:
                                        </strong>
                                        <div class="h5 text-dark mb-0">
                                            {{ $reRequestedService->delivery_date->format('M d, Y') }}
                                        </div>
                                        <small class="text-muted">
                                            <i class="fas fa-clock"></i> 
                                            @if($reRequestedService->delivery_date->isPast())
                                                <span class="text-danger">Overdue by {{ $reRequestedService->delivery_date->diffForHumans() }}</span>
                                            @elseif($reRequestedService->delivery_date->isToday())
                                                <span class="text-warning">Due today</span>
                                            @elseif($reRequestedService->delivery_date->isTomorrow())
                                                <span class="text-info">Due tomorrow</span>
                                            @else
                                                Due {{ $reRequestedService->delivery_date->diffForHumans() }}
                                            @endif
                                        </small>
                                    </div>
                                    <div class="col-md-6">
                                        <strong class="text-success">
                                            <i class="fas fa-user-cog"></i> Set by Professional:
                                        </strong>
                                        <p class="mb-0 mt-1">{{ $reRequestedService->professional->name }}</p>
                                        <small class="text-muted">
                                            Professional committed to deliver the additional service by this date
                                        </small>
                                    </div>
                                </div>
                                
                                <hr class="my-2">
                                <div class="d-flex align-items-center">
                                    <strong class="text-muted me-2">Status:</strong>
                                    @if($reRequestedService->professional_completed_at)
                                        <span class="badge-success">
                                            <i class="fas fa-check-circle"></i> Completed
                                        </span>
                                        <span class="ml-3 text-success">
                                            Completed on {{ $reRequestedService->professional_completed_at->format('M d, Y') }}
                                        </span>
                                    @elseif($reRequestedService->delivery_date->isPast())
                                        <span class="badge badge-danger">
                                            <i class="fas fa-exclamation-triangle"></i> Overdue
                                        </span>
                                    @elseif($reRequestedService->delivery_date->isToday())
                                        <span class="badge badge-warning">
                                            <i class="fas fa-clock"></i> Due Today
                                        </span>
                                    @else
                                        <span class="badge badge-info">
                                            <i class="fas fa-calendar-alt"></i> Scheduled
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    @elseif($reRequestedService->user_status === 'paid' && !$reRequestedService->delivery_date_set)
                    <div class="info-item">
                        <div class="info-label">Delivery Information</div>
                        <div class="info-value">
                            <div class="alert alert-warning">
                                <i class="fas fa-clock"></i> Waiting for professional to set delivery date
                            </div>
                        </div>
                    </div>
                    @endif
                </div>

                <!-- Original Booking Details -->
                <div class="content-card">
                    <div class="card-header">
                        <h5 class="card-title">
                            <i class="fas fa-calendar-alt"></i>
                            Original Booking Details
                        </h5>
                    </div>

                    <div class="info-grid">
                        <div class="info-item">
                            <div class="info-label">Booking ID</div>
                            <div class="info-value">
                                <span class="badge badge-info">#{{ $reRequestedService->booking->id }}</span>
                            </div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">Service</div>
                            <div class="info-value">{{ $reRequestedService->booking->service_name }}</div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">Plan Type</div>
                            <div class="info-value">
                                <span class="badge badge-secondary">{{ ucfirst(str_replace('_', ' ', $reRequestedService->booking->plan_type)) }}</span>
                            </div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">Booking Date</div>
                            <div class="info-value">{{ \Carbon\Carbon::parse($reRequestedService->booking->booking_date)->format('M d, Y') }}</div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">Status</div>
                            <div class="info-value">
                                <span class="badge badge-{{ $reRequestedService->booking->status == 'active' ? 'success' : 'secondary' }}">
                                    {{ ucfirst($reRequestedService->booking->status) }}
                                </span>
                            </div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">Original Amount</div>
                            <div class="info-value">₹{{ number_format($reRequestedService->booking->amount, 2) }}</div>
                        </div>
                    </div>

                    @if($reRequestedService->booking->timedates->count() > 0)
                    <div style="margin-top: 20px;">
                        <div class="info-label">
                            <i class="fas fa-clock"></i> Scheduled Sessions ({{ $reRequestedService->booking->timedates->count() }} total)
                        </div>
                        <div class="sessions-grid">
                            @foreach($reRequestedService->booking->timedates->take(12) as $timedate)
                                <div class="session-badge">
                                    <i class="fas fa-calendar-day"></i>
                                    {{ \Carbon\Carbon::parse($timedate->date)->format('M d') }}<br>
                                    <small>{{ $timedate->time_slot }}</small>
                                </div>
                            @endforeach
                        </div>
                        @if($reRequestedService->booking->timedates->count() > 12)
                            <div class="text-center mt-3">
                                <small class="text-muted">
                                    <i class="fas fa-ellipsis-h"></i> 
                                    ... and {{ $reRequestedService->booking->timedates->count() - 12 }} more sessions
                                </small>
                            </div>
                        @endif
                    </div>
                    @endif
                </div>
            </div>

            <!-- Sidebar -->
            <div class="col-lg-4">
                <!-- Price Details -->
                <div class="content-card">
                    <div class="price-section">
                        <div class="price-header">
                            <h5 class="mb-0">
                                <i class="fas fa-calculator"></i> Price Details
                            </h5>
                            @if($reRequestedService->admin_status === 'pending')
                                <button class="btn btn-sm btn-warning" onclick="showPriceEditModal()">
                                    <i class="fas fa-edit"></i> Edit
                                </button>
                            @endif
                        </div>

                        <div class="price-breakdown">
                            @if($reRequestedService->price_modified_by_admin)
                                <div class="text-center mb-3">
                                    <span class="badge badge-warning">
                                        <i class="fas fa-edit"></i> Modified by Admin
                                    </span>
                                </div>

                                <div class="mb-3">
                                    <strong>Original Price:</strong>
                                    <div style="text-decoration: line-through; color: #6c757d;">
                                        Base: ₹{{ number_format($reRequestedService->base_price, 2) }}<br>
                                        Total: ₹{{ number_format($reRequestedService->total_price, 2) }}
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <strong>Modified Price:</strong>
                                    <div style="color: #28a745; font-weight: bold;">
                                        Base: ₹{{ number_format($reRequestedService->modified_base_price, 2) }}<br>
                                        Total: ₹{{ number_format($reRequestedService->modified_total_price, 2) }}
                                    </div>
                                </div>

                                @if($reRequestedService->price_modification_reason)
                                    <div class="alert alert-info" style="font-size: 0.9rem;">
                                        <strong>Reason:</strong><br>
                                        {{ $reRequestedService->price_modification_reason }}
                                    </div>
                                @endif
                            @else
                                <div class="price-row">
                                    <span><i class="fas fa-tag"></i> Base Price:</span>
                                    <span><strong>₹{{ number_format($reRequestedService->base_price, 2) }}</strong></span>
                                </div>
                                <div class="price-row">
                                    <span><i class="fas fa-percentage"></i> CGST (9%):</span>
                                    <span>₹{{ number_format($reRequestedService->cgst, 2) }}</span>
                                </div>
                                <div class="price-row">
                                    <span><i class="fas fa-percentage"></i> SGST (9%):</span>
                                    <span>₹{{ number_format($reRequestedService->sgst, 2) }}</span>
                                </div>
                                <div class="price-row">
                                    <span><i class="fas fa-percentage"></i> IGST (0%):</span>
                                    <span>₹{{ number_format($reRequestedService->igst, 2) }}</span>
                                </div>
                                <div class="price-row total">
                                    <strong><i class="fas fa-calculator"></i> Total Price:</strong>
                                    <strong>₹{{ number_format($reRequestedService->total_price, 2) }}</strong>
                                </div>
                            @endif
                        </div>

                        @if($reRequestedService->admin_status === 'pending')
                            <button class="btn price-edit-btn btn-block" onclick="showPriceEditModal()">
                                <i class="fas fa-dollar-sign"></i> EDIT PRICE
                            </button>
                        @endif

                        @if($reRequestedService->payment_id)
                            <div class="mt-3 p-3" style="background: #d4edda; border-radius: 8px;">
                                <h6 class="text-success mb-2">
                                    <i class="fas fa-credit-card"></i> Payment Information
                                </h6>
                                <p class="small mb-1">
                                    <strong>Payment ID:</strong> {{ $reRequestedService->payment_id }}
                                </p>
                                <p class="small mb-0">
                                    <strong>Status:</strong> 
                                    <span class="badge badge-success">{{ ucfirst($reRequestedService->payment_status) }}</span>
                                </p>
                            </div>
                        @endif

                        <!-- Professional Earnings Section -->
                        @php
                            $earningsDetails = $reRequestedService->getProfessionalEarningsDetailsAttribute();
                        @endphp
                        <div class="mt-3 p-3" style="background: #e3f2fd; border-radius: 8px; border-left: 4px solid #2196f3;">
                            <h6 class="text-primary mb-3">
                                <i class="fas fa-calculator"></i> Professional Earnings
                            </h6>
                            
                            @if($earningsDetails['calculation_ready'] && $earningsDetails['platform_percentage'] > 0)
                                <div class="earnings-breakdown">
                                    <div class="d-flex justify-content-between mb-2">
                                        <span class="small text-muted">Final Price:</span>
                                        <span class="small font-weight-bold">₹{{ number_format($earningsDetails['final_price'], 2) }}</span>
                                    </div>
                                    <div class="d-flex justify-content-between mb-2">
                                        <span class="small text-muted">Professional Earning ({{ $earningsDetails['professional_percentage'] }}%):</span>
                                        <span class="small font-weight-bold text-success">₹{{ number_format($earningsDetails['professional_amount'], 2) }}</span>
                                    </div>
                                    <div class="d-flex justify-content-between mb-0">
                                        <span class="small text-muted">Platform Commission ({{ $earningsDetails['platform_percentage'] }}%):</span>
                                        <span class="small font-weight-bold text-info">₹{{ number_format($earningsDetails['platform_commission'], 2) }}</span>
                                    </div>
                                    
                                    <hr class="my-2">
                                    @if($earningsDetails['is_calculated'] && $reRequestedService->earnings_calculated_at)
                                        <p class="small mb-0 text-success">
                                            <i class="fas fa-check-circle"></i> Officially Calculated: {{ $reRequestedService->earnings_calculated_at->format('M d, Y h:i A') }}
                                        </p>
                                    @else
                                        <p class="small mb-0 text-info">
                                            <i class="fas fa-calculator"></i> Calculation Preview (Platform fee: {{ $earningsDetails['platform_percentage'] }}%)
                                        </p>
                                    @endif
                                </div>
                            @else
                                <div class="text-center py-2">
                                    <span class="badge badge-warning">
                                        <i class="fas fa-exclamation-triangle"></i> Not Calculated
                                    </span>
                                    <p class="small text-muted mb-0 mt-1">
                                        Platform commission percentage not set
                                    </p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="content-card">
                    <div class="card-header">
                        <h5 class="card-title">
                            <i class="fas fa-cogs"></i>
                            Quick Actions
                        </h5>
                    </div>

                    <div class="d-grid gap-2">
                        @if($reRequestedService->admin_status === 'pending')
                            <a href="{{ route('admin.re-requested-services.edit', $reRequestedService) }}" class="btn btn-primary">
                                <i class="fas fa-edit"></i> Review Request
                            </a>
                        @endif
                        
                        <a href="{{ route('admin.re-requested-services.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Back to List
                        </a>
                        
                        @if($reRequestedService->user->email)
                            <a href="mailto:{{ $reRequestedService->user->email }}" class="btn btn-info">
                                <i class="fas fa-envelope"></i> Email Customer
                            </a>
                        @endif
                        
                        @if($reRequestedService->professional->email)
                            <a href="mailto:{{ $reRequestedService->professional->email }}" class="btn btn-info">
                                <i class="fas fa-envelope"></i> Email Professional
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Quick Action Modal -->
<div class="modal fade" id="quickActionModal" tabindex="-1" role="dialog" aria-labelledby="quickActionModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content" style="border-radius: 15px;">
            <div class="modal-header" style="background: linear-gradient(135deg, #007bff 0%, #6c5ce7 100%); color: white; border-radius: 15px 15px 0 0;">
                <h5 class="modal-title" id="quickActionModalLabel">Quick Action</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: white;">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="quickActionForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body" style="padding: 30px;">
                    <input type="hidden" name="admin_status" id="quickActionStatus">
                    
                    <div class="form-group">
                        <label for="quick_reason" class="font-weight-bold">Comments (Optional)</label>
                        <textarea class="form-control" id="quick_reason" name="admin_reason" rows="4" 
                                  placeholder="Enter comments for your decision..." 
                                  style="border-radius: 10px; border: 2px solid #e9ecef;"></textarea>
                    </div>
                    
                    <div id="quickActionMessage" class="alert" style="display: none;"></div>
                </div>
                <div class="modal-footer" style="padding: 20px 30px; border-top: 1px solid #e9ecef;">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        <i class="fas fa-times"></i> Cancel
                    </button>
                    <button type="submit" class="btn btn-primary" id="confirmQuickAction">
                        <i class="fas fa-check"></i> Confirm
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Price Edit Modal -->
<div class="modal fade" id="priceEditModal" tabindex="-1" role="dialog" aria-labelledby="priceEditModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content" style="border-radius: 15px;">
            <div class="modal-header" style="background: linear-gradient(135deg, #ffc107 0%, #ff8c00 100%); color: white; border-radius: 15px 15px 0 0;">
                <h5 class="modal-title" id="priceEditModalLabel">
                    <i class="fas fa-dollar-sign"></i> Edit Service Price
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: white;">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="priceEditForm" method="POST" action="{{ route('admin.re-requested-services.update-price', $reRequestedService) }}">
                @csrf
                <div class="modal-body" style="padding: 30px;">
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle"></i>
                        <strong>Price Modification:</strong> This will update the service price and notify the customer of the new amount.
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="modified_base_price" class="font-weight-bold">
                                    Base Price (₹) *
                                </label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">₹</span>
                                    </div>
                                    <input type="number" 
                                           class="form-control" 
                                           id="modified_base_price" 
                                           name="modified_base_price" 
                                           value="{{ $reRequestedService->modified_base_price ?? $reRequestedService->base_price }}" 
                                           step="0.01" 
                                           min="1" 
                                           required 
                                           style="border-radius: 0 10px 10px 0;">
                                </div>
                                <small class="form-text text-muted">
                                    Original: ₹{{ number_format($reRequestedService->base_price, 2) }}
                                </small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="modified_total_price" class="font-weight-bold">
                                    Total Price (with GST)
                                </label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">₹</span>
                                    </div>
                                    <input type="number" 
                                           class="form-control" 
                                           id="modified_total_price" 
                                           name="modified_total_price" 
                                           readonly 
                                           style="background-color: #f8f9fa; border-radius: 0 10px 10px 0;">
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="price_modification_reason" class="font-weight-bold">
                            Reason for Price Modification *
                        </label>
                        <textarea class="form-control" 
                                  id="price_modification_reason" 
                                  name="price_modification_reason" 
                                  rows="3" 
                                  required 
                                  placeholder="Enter reason for price modification..."
                                  style="border-radius: 10px;">{{ $reRequestedService->price_modification_reason }}</textarea>
                        <small class="form-text text-muted">This reason will be visible to the customer</small>
                    </div>
                    
                    <div class="alert alert-warning">
                        <i class="fas fa-calculator"></i>
                        <strong>GST Calculation:</strong> 18% total (9% CGST + 9% SGST)
                    </div>
                    
                    <div style="background: #f8f9fa; padding: 20px; border-radius: 10px; margin-top: 15px;">
                        <h6 class="mb-3"><i class="fas fa-receipt"></i> Price Breakdown</h6>
                        <div class="row">
                            <div class="col-6">
                                <div class="d-flex justify-content-between mb-2">
                                    <span>Base Price:</span>
                                    <span id="calc_base" class="font-weight-bold"></span>
                                </div>
                                <div class="d-flex justify-content-between mb-2">
                                    <span>CGST (9%):</span>
                                    <span id="calc_cgst"></span>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="d-flex justify-content-between mb-2">
                                    <span>SGST (9%):</span>
                                    <span id="calc_sgst"></span>
                                </div>
                                <div class="d-flex justify-content-between mb-2">
                                    <span>IGST (0%):</span>
                                    <span>₹0.00</span>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between">
                            <strong>Total Amount:</strong>
                            <strong id="calc_total" class="text-success"></strong>
                        </div>
                    </div>
                    
                    <input type="hidden" name="price_modified_by_admin" value="1">
                </div>
                <div class="modal-footer" style="padding: 20px 30px; border-top: 1px solid #e9ecef;">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        <i class="fas fa-times"></i> Cancel
                    </button>
                    <button type="submit" class="btn price-edit-btn">
                        <i class="fas fa-save"></i> Update Price
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Negotiation Response Modal -->
<div class="modal fade" id="negotiationResponseModal" tabindex="-1" role="dialog" aria-labelledby="negotiationResponseModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content" style="border-radius: 15px; border: none; box-shadow: 0 10px 30px rgba(0,0,0,0.3);">
            <form id="negotiationResponseForm" method="POST" action="{{ route('admin.re-requested-services.handle-negotiation', $reRequestedService) }}">
                @csrf
                <div class="modal-header" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border-radius: 15px 15px 0 0; padding: 25px 30px;">
                    <h4 class="modal-title" id="negotiationResponseModalLabel" style="font-weight: 600;">
                        <i class="fas fa-handshake"></i> Respond to Price Negotiation
                    </h4>
                    <button type="button" class="btn-close btn-close-white" data-dismiss="modal" aria-label="Close" style="opacity: 0.8;"></button>
                </div>
                <div class="modal-body" style="padding: 30px;">
                    @if($reRequestedService->user_negotiated_price && $reRequestedService->user_negotiation_reason)
                    <div class="alert alert-info">
                        <h6><i class="fas fa-user"></i> Customer's Negotiation Request</h6>
                        <p><strong>Requested Price:</strong> ₹{{ number_format($reRequestedService->user_negotiated_price, 2) }}</p>
                        <p><strong>Customer's Reason:</strong> {{ $reRequestedService->user_negotiation_reason }}</p>
                        <p><strong>Original Price:</strong> ₹{{ number_format($reRequestedService->getFinalPriceAttribute(), 2) }}</p>
                    </div>
                    @endif
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="admin_final_negotiated_price" class="font-weight-bold">
                                    Final Negotiated Price (₹) *
                                </label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">₹</span>
                                    </div>
                                    <input type="number" 
                                           class="form-control" 
                                           id="admin_final_negotiated_price" 
                                           name="admin_final_negotiated_price" 
                                           value="{{ $reRequestedService->user_negotiated_price ?? '' }}" 
                                           step="0.01" 
                                           min="1" 
                                           required 
                                           style="border-radius: 0 10px 10px 0;">
                                </div>
                                <small class="form-text text-muted">
                                    Customer requested: ₹{{ number_format($reRequestedService->user_negotiated_price ?? 0, 2) }}
                                </small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="font-weight-bold">Price Comparison</label>
                                <div style="background: #f8f9fa; padding: 15px; border-radius: 8px;">
                                    <div class="d-flex justify-content-between mb-2">
                                        <span>Original Price:</span>
                                        <span class="font-weight-bold">₹{{ number_format($reRequestedService->getFinalPriceAttribute(), 2) }}</span>
                                    </div>
                                    <div class="d-flex justify-content-between mb-2">
                                        <span>Customer Request:</span>
                                        <span class="text-info font-weight-bold">₹{{ number_format($reRequestedService->user_negotiated_price ?? 0, 2) }}</span>
                                    </div>
                                    <hr class="my-2">
                                    <div class="d-flex justify-content-between">
                                        <span>Your Final Price:</span>
                                        <span id="finalPriceDisplay" class="text-success font-weight-bold">₹0.00</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="admin_negotiation_response" class="font-weight-bold">
                            Response Message *
                        </label>
                        <textarea class="form-control" 
                                  id="admin_negotiation_response" 
                                  name="admin_negotiation_response" 
                                  rows="4" 
                                  required 
                                  placeholder="Enter your response to the customer's negotiation request..."
                                  style="border-radius: 10px;"></textarea>
                        <small class="form-text text-muted">This message will be visible to the customer</small>
                    </div>
                    
                    <div class="alert alert-warning">
                        <i class="fas fa-info-circle"></i>
                        <strong>Note:</strong> Once you respond, the customer will be notified and can either accept or reject your final price.
                    </div>
                </div>
                <div class="modal-footer" style="padding: 20px 30px; border-top: 1px solid #e9ecef;">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        <i class="fas fa-times"></i> Cancel
                    </button>
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-paper-plane"></i> Send Response
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

    </div>
</div>
@endsection

@section('scripts')
<script>
// Quick Action Handler
function quickAction(action) {
    $('#quickActionStatus').val(action);
    
    const actionText = action === 'approve' ? 'approve' : 'reject';
    const alertClass = action === 'approve' ? 'alert-success' : 'alert-danger';
    const btnClass = action === 'approve' ? 'btn-success' : 'btn-danger';
    
    $('#quickActionMessage')
        .removeClass('alert-success alert-danger')
        .addClass(alertClass)
        .html(`<strong>Confirm ${actionText}:</strong> This will ${actionText} the request and send email notifications.`)
        .show();
    
    $('#confirmQuickAction')
        .removeClass('btn-primary btn-success btn-danger')
        .addClass(btnClass)
        .text(action === 'approve' ? 'Approve Request' : 'Reject Request');
    
    $('#quickActionForm').attr('action', "{{ route('admin.re-requested-services.update', $reRequestedService) }}");
    $('#quickActionModal').modal('show');
}

// Price Edit Modal Handler
function showPriceEditModal() {
    // Reset form
    $('#priceEditForm')[0].reset();
    $('#modified_base_price').val({{ $reRequestedService->modified_base_price ?? $reRequestedService->base_price }});
    $('#price_modification_reason').val('{{ $reRequestedService->price_modification_reason ?? '' }}');
    
    // Calculate initial total
    calculateTotal();
    
    $('#priceEditModal').modal('show');
}

// Price Calculation Function
function calculateTotal() {
    const basePrice = parseFloat($('#modified_base_price').val()) || 0;
    const cgst = basePrice * 0.09;
    const sgst = basePrice * 0.09;
    const total = basePrice + cgst + sgst;
    
    // Update form field
    $('#modified_total_price').val(total.toFixed(2));
    
    // Update display
    $('#calc_base').text('₹' + basePrice.toLocaleString('en-IN', {minimumFractionDigits: 2}));
    $('#calc_cgst').text('₹' + cgst.toLocaleString('en-IN', {minimumFractionDigits: 2}));
    $('#calc_sgst').text('₹' + sgst.toLocaleString('en-IN', {minimumFractionDigits: 2}));
    $('#calc_total').text('₹' + total.toLocaleString('en-IN', {minimumFractionDigits: 2}));
}

// Document Ready
$(document).ready(function() {
    // Quick action form handler
    $('#quickActionForm').on('submit', function(e) {
        e.preventDefault();
        
        const submitBtn = $('#confirmQuickAction');
        const originalText = submitBtn.text();
        
        submitBtn.prop('disabled', true).text('Processing...');
        
        $.ajax({
            url: $(this).attr('action'),
            method: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                alert('Action completed successfully!');
                location.reload();
            },
            error: function(xhr) {
                submitBtn.prop('disabled', false).text(originalText);
                alert('Error: ' + (xhr.responseJSON?.message || 'Something went wrong'));
            }
        });
    });
    
    // Price edit form handler
    $('#priceEditForm').on('submit', function(e) {
        e.preventDefault();
        
        const submitBtn = $(this).find('button[type="submit"]');
        const originalText = submitBtn.html();
        
        submitBtn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Updating...');
        
        $.ajax({
            url: $(this).attr('action'),
            method: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                alert('Price updated successfully!');
                $('#priceEditModal').modal('hide');
                location.reload();
            },
            error: function(xhr) {
                submitBtn.prop('disabled', false).html(originalText);
                alert('Error: ' + (xhr.responseJSON?.message || 'Failed to update price'));
            }
        });
    });
    
    // Base price input handler
    $('#modified_base_price').on('input', calculateTotal);
    
    // Modal cleanup
    // Negotiation Response Modal Handler
    function showNegotiationResponseModal() {
        $('#negotiationResponseModal').modal('show');
        updateFinalPriceDisplay();
    }

    // Update final price display
    function updateFinalPriceDisplay() {
        const finalPrice = parseFloat($('#admin_final_negotiated_price').val()) || 0;
        $('#finalPriceDisplay').text('₹' + finalPrice.toLocaleString('en-IN', {minimumFractionDigits: 2, maximumFractionDigits: 2}));
    }

    // Admin final negotiated price input handler
    $('#admin_final_negotiated_price').on('input', updateFinalPriceDisplay);

    // Negotiation response form handler
    $('#negotiationResponseForm').on('submit', function(e) {
        e.preventDefault();
        
        const submitBtn = $(this).find('button[type="submit"]');
        const originalText = submitBtn.html();
        
        submitBtn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Sending...');
        
        $.ajax({
            url: $(this).attr('action'),
            method: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                alert('Negotiation response sent successfully!');
                $('#negotiationResponseModal').modal('hide');
                location.reload();
            },
            error: function(xhr) {
                submitBtn.prop('disabled', false).html(originalText);
                alert('Error: ' + (xhr.responseJSON?.message || 'Failed to send response'));
            }
        });
    });

    $('.modal').on('hidden.bs.modal', function() {
        $(this).find('form')[0].reset();
        $(this).find('.alert').hide();
        $(this).find('button[type="submit"]').prop('disabled', false);
    });
});
</script>
@endsection