@extends('customer.layout.layout')

@section('styles')
<link rel="stylesheet" href="{{ asset('customer-css/assets/css/appointment.css') }}" />
<style>
    /* Modern Page Header */
    .page-header {
        background: #f5f7fa;
        color: #333;
        padding: 2rem;
        border-radius: 10px;
        margin-bottom: 2rem;
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
    }
    .page-title h3 {
        font-size: 2rem;
        font-weight: 600;
        margin: 0;
        color: #333;
    }
    .breadcrumb {
        background: none;
        padding: 0;
        margin: 0.5rem 0 0 0;
        list-style: none;
        display: flex;
        gap: 0.5rem;
        font-size: 0.9rem;
        opacity: 0.9;
        color: #6c757d;
    }
    .breadcrumb li.active {
        font-weight: 600;
        color: #333;
    }

    /* Search/Filter Container */
    .search-container {
        background: #f5f7fa;
        padding: 20px;
        border-radius: 10px;
        margin-bottom: 20px;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
    }

    .search-form {
        display: flex;
        flex-wrap: wrap;
        gap: 15px;
        align-items: flex-end;
    }

    .search-form .form-group {
        flex: 1 1 0;
        min-width: 180px;
        display: flex;
        flex-direction: column;
        margin-bottom: 0;
    }

    .search-form label {
        margin-bottom: 5px;
        font-weight: 600;
        color: #333;
    }

    .search-form input[type="date"],
    .search-form select {
        padding: 10px;
        border-radius: 6px;
        border: 1px solid #ced4da;
        font-size: 14px;
        background: #fff;
    }

    .search-buttons {
        display: flex;
        gap: 10px;
    }

    .search-buttons button,
    .search-buttons a {
        padding: 10px 20px;
        font-size: 14px;
        border-radius: 6px;
        cursor: pointer;
        text-decoration: none;
        border: none;
    }

    .btn-success {
        background-color: #28a745;
        color: white;
    }

    .btn-secondary {
        background-color: #6c757d;
        color: white;
    }

    .btn-success:hover {
        background-color: #218838;
    }

    .btn-secondary:hover {
        background-color: #5a6268;
    }

    /* Card Styling */
    .card {
        border: none;
        border-radius: 15px;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
        overflow: hidden;
        margin-bottom: 2rem;
        background: #fff;
    }

    .card-header {
        background: #f8f9fa;
        border-bottom: 1px solid #e9ecef;
        padding: 1.5rem 2rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .card-header h4 {
        margin: 0;
        font-size: 1.25rem;
        font-weight: 600;
        color: #333;
    }

    .card-body {
        padding: 2rem;
        background: #fff;
    }

    /* Table Styling */
    .table-responsive {
        width: 100%;
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
        background: #f8f9fa;
        border-radius: 12px;
        margin-bottom: 0;
    }

    .data-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
        background: #fff;
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
        min-width: 900px;
    }

    .data-table thead {
        background: #f8f9fa;
    }

    .data-table th {
        padding: 1.25rem 1rem;
        font-weight: 600;
        text-align: left;
        font-size: 0.95rem;
        border: none;
        color: #495057;
        background: #f8f9fa;
    }

    .data-table td {
        padding: 1.25rem 1rem;
        border-bottom: 1px solid #e9ecef;
        vertical-align: middle;
        color: #495057;
    }

    .data-table tbody tr {
        transition: all 0.3s ease;
    }

    .data-table tbody tr:hover {
        background: #f8f9fa;
    }

    .data-table tbody tr:last-child td {
        border-bottom: none;
    }

    /* Badge Styling */
    .badge {
        padding: 0.5rem 1rem;
        border-radius: 20px;
        font-weight: 600;
        font-size: 0.8rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .badge-pending {
        background-color: #fff3cd;
        color: #856404;
        border: 1px solid #ffeaa7;
    }

    .badge-paid {
        background-color: #d1ecf1;
        color: #0c5460;
        border: 1px solid #bee5eb;
    }

    .badge-in-progress {
        background-color: #e2e3e5;
        color: #383d41;
        border: 1px solid #d6d8db;
    }

    .badge-completed {
        background-color: #d4edda;
        color: #155724;
        border: 1px solid #c3e6cb;
    }

    .badge-approved {
        background-color: #d4edda;
        color: #155724;
        border: 1px solid #c3e6cb;
    }

    /* Alert Styling */
    .alert {
        border: none;
        border-radius: 15px;
        padding: 1.5rem;
        font-weight: 500;
    }

    .alert-info {
        background: #e3f2fd;
        color: #0d47a1;
        border-left: 4px solid #2196f3;
    }

    .alert-info a {
        color: #1976d2;
        font-weight: 600;
        text-decoration: none;
    }

    .alert-info a:hover {
        text-decoration: underline;
    }

    /* Enhanced Button Styling */
    .btn {
        padding: 0.5rem 1rem;
        border-radius: 6px;
        font-weight: 500;
        transition: all 0.3s ease;
        border: none;
        cursor: pointer;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }

    /* Pay Now Button - Special Styling */
    .pay-now-btn {
        background: linear-gradient(135deg, #28a745, #20c997);
        color: #fff;
        font-weight: 600;
        box-shadow: 0 4px 15px rgba(40, 167, 69, 0.3);
        position: relative;
        overflow: hidden;
    }

    .pay-now-btn:hover {
        background: linear-gradient(135deg, #218838, #1ea082);
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(40, 167, 69, 0.4);
        color: #fff;
    }

    .pay-now-btn:focus {
        box-shadow: 0 0 0 0.2rem rgba(40, 167, 69, 0.5);
        color: #fff;
    }

    /* Pulse animation for Pay Now button */
    .pulse-animation {
        animation: pulse 2s infinite;
    }

    @keyframes pulse {
        0% {
            box-shadow: 0 4px 15px rgba(40, 167, 69, 0.3);
        }
        50% {
            box-shadow: 0 6px 25px rgba(40, 167, 69, 0.6);
            transform: scale(1.02);
        }
        100% {
            box-shadow: 0 4px 15px rgba(40, 167, 69, 0.3);
        }
    }

    .btn-primary {
        background: #007bff;
        color: #fff;
    }

    .btn-primary:hover {
        background: #0056b3;
        color: #fff;
    }

    .btn-info {
        background: #17a2b8;
        color: #fff;
    }

    .btn-info:hover {
        background: #138496;
        color: #fff;
    }

    .btn-warning {
        background: #ffc107;
        color: #212529;
    }

    .btn-warning:hover {
        background: #e0a800;
        color: #212529;
    }

    .btn-success {
        background: #28a745;
        color: #fff;
    }

    .btn-success:hover {
        background: #218838;
        color: #fff;
    }

    .btn-sm {
        padding: 0.375rem 0.75rem;
        font-size: 0.875rem;
    }

    /* Responsive Design */
    @media (max-width: 900px) {
        .card-body {
            padding: 1rem;
        }
        .data-table th, .data-table td {
            padding: 0.75rem 0.5rem;
        }
        .table-responsive {
            border-radius: 10px;
            overflow: hidden;
        }
        .search-form {
            flex-direction: column;
            gap: 10px;
        }
        .search-form .form-group {
            min-width: 100%;
        }
    }

    @media (max-width: 600px) {
        .breadcrumb {
            flex-wrap: wrap;
        }
        .data-table {
            font-size: 0.8rem;
        }
        .badge {
            padding: 0.4rem 0.8rem;
            font-size: 0.75rem;
        }
        .search-container {
            padding: 1rem;
        }
        .search-form .form-group {
            min-width: 100%;
        }
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
        margin: 1rem;
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
        flex-wrap: wrap;
    }

    /* Form Styling */
    .form-label {
        font-weight: 600;
        color: #2c3e50;
        margin-bottom: 0.5rem;
        display: block;
    }

    .form-control:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
        outline: none;
    }

    /* Enhanced Mobile Compatibility */
    @media (max-width: 576px) {
        .page-header {
            padding: 1.5rem;
            margin-bottom: 1.5rem;
        }
        
        .page-title h3 {
            font-size: 1.5rem;
        }
        
        .breadcrumb {
            font-size: 0.8rem;
            flex-wrap: wrap;
        }
        
        .search-container {
            padding: 1rem;
            margin-bottom: 1rem;
        }
        
        .search-form {
            flex-direction: column;
            gap: 1rem;
        }
        
        .search-form .form-group {
            min-width: 100%;
        }
        
        .search-buttons {
            flex-direction: column;
            gap: 0.5rem;
        }
        
        .search-buttons button,
        .search-buttons a {
            width: 100%;
            text-align: center;
        }
        
        .card-body {
            padding: 1rem;
        }
        
        .data-table {
            font-size: 0.75rem;
            min-width: 800px;
        }
        
        .data-table th,
        .data-table td {
            padding: 0.5rem 0.25rem;
        }
        
        .btn-group-vertical .btn {
            font-size: 0.75rem;
            padding: 0.25rem 0.5rem;
            margin-bottom: 0.25rem;
        }
        
        .badge {
            padding: 0.3rem 0.6rem;
            font-size: 0.7rem;
        }
        
        .modal-content {
            width: 95%;
            margin: 0.5rem;
            max-height: 95vh;
        }
        
        .modal-body {
            padding: 1.5rem;
        }
        
        .modal-footer {
            padding: 1rem 1.5rem;
            flex-direction: column;
        }
        
        .modal-footer .btn {
            width: 100%;
            margin-bottom: 0.5rem;
        }
        
        .modal-footer .btn:last-child {
            margin-bottom: 0;
        }
    }
    
    @media (max-width: 480px) {
        .data-table {
            font-size: 0.7rem;
        }
        
        .btn {
            font-size: 0.7rem;
            padding: 0.4rem 0.8rem;
        }
        
        .page-title h3 {
            font-size: 1.3rem;
        }
        
        .pay-now-btn {
            font-size: 0.75rem;
            padding: 0.5rem 1rem;
        }
    }

    /* Status Indicator Styling */
    .btn-outline-warning[disabled],
    .btn-outline-primary[disabled],
    .btn-outline-info[disabled] {
        opacity: 0.8;
        cursor: default;
        border-width: 1px;
        font-weight: 500;
    }

    .btn-outline-warning[disabled] {
        background: rgba(255, 193, 7, 0.1);
        border-color: #ffc107;
        color: #856404;
    }

    .btn-outline-primary[disabled] {
        background: rgba(0, 123, 255, 0.1);
        border-color: #007bff;
        color: #004085;
    }

    .btn-outline-info[disabled] {
        background: rgba(23, 162, 184, 0.1);
        border-color: #17a2b8;
        color: #0c5460;
    }

    /* Enhanced Table Responsiveness */
    @media (max-width: 768px) {
        .btn-group-vertical .btn {
            width: 100%;
            margin-bottom: 0.25rem;
            font-size: 0.75rem;
            padding: 0.4rem 0.8rem;
        }
        
        .pay-now-btn {
            font-weight: 700;
            background: linear-gradient(135deg, #28a745, #20c997) !important;
        }
    }

    /* Animation */
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

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
</style>
@endsection

@section('content')
<div class="content-wrapper">
    <!-- Page Header -->
    <div class="page-header">
        <div class="page-title">
            <h3>Additional Services</h3>
        </div>
        <ul class="breadcrumb">
            <li><a href="{{ route('user.dashboard') }}">Dashboard</a></li>
            <li class="active">Additional Services</li>
        </ul>
    </div>

    <div class="search-container">
        <form action="{{ route('user.additional-services.index') }}" method="GET" class="search-form" id="filter-form">
            <div class="form-group">
                <label for="start_date">Start Date</label>
                <input type="date" id="start_date" name="start_date" class="form-control" value="{{ request('start_date') }}">
            </div>
            <div class="form-group">
                <label for="end_date">End Date</label>
                <input type="date" id="end_date" name="end_date" class="form-control" value="{{ request('end_date') }}">
            </div>
            <div class="form-group">
                <label for="status">Status</label>
                <select id="status" name="status" class="form-control">
                    <option value="">All Status</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Payment Pending</option>
                    <option value="paid" {{ request('status') == 'paid' ? 'selected' : '' }}>Paid</option>
                    <option value="in_progress" {{ request('status') == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                    <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                </select>
            </div>
            <div class="form-group">
                <label for="professional">Professional</label>
                <select id="professional" name="professional" class="form-control">
                    <option value="">All Professionals</option>
                    @foreach($professionals ?? [] as $professional)
                        <option value="{{ $professional->id }}" {{ request('professional') == $professional->id ? 'selected' : '' }}>
                            {{ $professional->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="search-buttons">
                <button type="submit" class="btn btn-success">Apply Filters</button>
                <a href="{{ route('user.additional-services.index') }}" class="btn btn-secondary">Reset</a>
            </div>
        </form>
    </div>

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4>My Additional Services</h4>
        </div>
        <div class="card-body">
            @if($additionalServices->count() > 0)
            <div class="table-responsive">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Service Name</th>
                            <th>Professional</th>
                            <th>Booking Ref</th>
                            <th>Total Price</th>
                            <th>Status</th>
                            <th>Payment Status</th>
                            <th>Created Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($additionalServices as $service)
                        <tr>
                            <td>
                                <strong>{{ $service->service_name }}</strong>
                                @if($service->delivery_date)
                                    <br><small class="text-info">
                                        <i class="fas fa-calendar"></i> 
                                        Delivery: {{ \Carbon\Carbon::parse($service->delivery_date)->format('M d, Y') }}
                                    </small>
                                @endif
                            </td>
                            <td>{{ $service->professional->name }}</td>
                            <td>
                                <a href="#" class="text-primary">
                                    #{{ $service->booking_id }}
                                </a>
                            </td>
                            <td>
                                <span class="text-success font-weight-bold">
                                    ₹{{ number_format($service->final_price, 2) }}
                                </span>
                                @if($service->negotiation_status !== 'none')
                                    <br><small class="text-warning">
                                        <i class="fas fa-handshake"></i> Negotiated
                                    </small>
                                @endif
                            </td>
                            <td>
                                @if($service->consulting_status === 'in_progress')
                                    <span class="badge badge-in-progress">In Progress</span>
                                @elseif($service->consulting_status === 'done' && !$service->customer_confirmed_at)
                                    <span class="badge badge-pending">Awaiting Confirmation</span>
                                @elseif($service->isConsultationCompleted())
                                    <span class="badge badge-completed">Completed</span>
                                @else
                                    <span class="badge badge-approved">Active</span>
                                @endif
                            </td>
                            <td>
                                @if($service->payment_status === 'pending')
                                    <span class="badge badge-pending">Pending</span>
                                @elseif($service->payment_status === 'paid')
                                    <span class="badge badge-paid">Paid</span>
                                @elseif($service->payment_status === 'failed')
                                    <span class="badge badge-rejected">Failed</span>
                                @endif
                            </td>
                            <td>{{ $service->created_at->format('d M Y') }}</td>
                            <td>
                                <div class="btn-group-vertical">
                                    <!-- Pay Now Button - Highest Priority -->
                                    @if($service->payment_status === 'pending')
                                        <button class="btn btn-sm btn-success pay-now-btn mb-2" 
                                                data-id="{{ $service->id }}" 
                                                data-amount="{{ $service->final_price }}"
                                                title="Pay ₹{{ number_format($service->final_price, 2) }}">
                                            <i class="fas fa-credit-card"></i> Pay ₹{{ number_format($service->final_price, 2) }}
                                        </button>
                                    @endif
                                    
                                    <!-- View Details Button -->
                                    <a href="{{ route('user.additional-services.show', $service->id) }}" 
                                       class="btn btn-sm btn-info mb-1" title="View Details">
                                        <i class="fas fa-eye"></i> View Details
                                    </a>
                                    
                                    <!-- Professional Consulting Status -->
                                    @if($service->payment_status === 'paid')
                                        @if($service->consulting_status === 'not_started')
                                            <span class="btn btn-sm btn-outline-warning mb-1" disabled>
                                                <i class="fas fa-clock"></i> Awaiting Professional
                                            </span>
                                        @elseif($service->consulting_status === 'in_progress')
                                            <span class="btn btn-sm btn-outline-primary mb-1" disabled>
                                                <i class="fas fa-user-md"></i> Consulting in Progress
                                            </span>
                                        @elseif($service->consulting_status === 'done' && !$service->customer_confirmed_at)
                                            <button class="btn btn-sm btn-primary confirm-completion-btn mb-1" 
                                                    data-id="{{ $service->id }}" title="Confirm Completion">
                                                <i class="fas fa-check-circle"></i> Confirm Completion
                                            </button>
                                        @elseif($service->customer_confirmed_at)
                                            <span class="btn btn-sm btn-success mb-1" disabled>
                                                <i class="fas fa-check-double"></i> Completed
                                            </span>
                                        @endif
                                    @endif
                                    
                                    <!-- Negotiation Status (View Only) -->
                                    @if($service->negotiation_status !== 'none')
                                        @if($service->negotiation_status === 'user_negotiated')
                                            <span class="btn btn-sm btn-outline-warning mb-1" disabled>
                                                <i class="fas fa-handshake"></i> Negotiation Pending
                                            </span>
                                        @elseif($service->negotiation_status === 'admin_responded')
                                            <span class="btn btn-sm btn-outline-info mb-1" disabled>
                                                <i class="fas fa-reply"></i> Professional Responded
                                            </span>
                                        @endif
                                    @endif
                                    
                                    <!-- Invoice Download - For Completed & Paid Services -->
                                    @if($service->consulting_status === 'done' && $service->payment_status === 'paid')
                                        <div class="mt-2 pt-2 border-top">
                                            <a href="{{ route('user.additional-services.invoice', $service->id) }}" 
                                               class="btn btn-sm btn-success mb-1" title="View Invoice">
                                                <i class="fas fa-file-text"></i> View Invoice
                                            </a>
                                            <a href="{{ route('user.additional-services.invoice.pdf', $service->id) }}" 
                                               class="btn btn-sm btn-outline-success mb-1" target="_blank" title="Download PDF Invoice">
                                                <i class="fas fa-download"></i> Download PDF
                                            </a>
                                        </div>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
            <div class="alert alert-info">
                <i class="fas fa-info-circle"></i> No additional services found. Professionals may add additional services based on your bookings.
            </div>
            @endif
        </div>
    </div>
</div>

<!-- Enhanced Negotiation Modal -->
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
                <!-- Price Information Card -->
                <div class="alert alert-info mb-4">
                    <div class="row text-center">
                        <div class="col-md-4 mb-2">
                            <div class="d-flex flex-column">
                                <strong class="text-primary">Current Price</strong>
                                <span class="h5 text-success mb-0">₹<span id="current-price">0</span></span>
                            </div>
                        </div>
                        <div class="col-md-4 mb-2">
                            <div class="d-flex flex-column">
                                <strong class="text-warning">Max Discount</strong>
                                <span class="h5 text-warning mb-0"><span id="max-discount">0</span>%</span>
                            </div>
                        </div>
                        <div class="col-md-4 mb-2">
                            <div class="d-flex flex-column">
                                <strong class="text-danger">Min Price</strong>
                                <span class="h5 text-danger mb-0">₹<span id="min-price">0</span></span>
                            </div>
                        </div>
                    </div>
                    <div class="mt-3 text-center">
                        <small class="text-muted">
                            <i class="fas fa-info-circle me-1"></i>
                            You can negotiate up to <strong><span id="discount-info">0</span>%</strong> off the original price
                        </small>
                    </div>
                </div>
                
                <!-- Proposed Price Input -->
                <div class="mb-4">
                    <label for="negotiated_price" class="form-label">
                        <i class="fas fa-tag me-2 text-primary"></i>Your Proposed Price (₹) *
                    </label>
                    <div class="input-group">
                        <span class="input-group-text">₹</span>
                        <input type="number" class="form-control" id="negotiated_price" name="negotiated_price" 
                               min="0" step="0.01" required 
                               placeholder="Enter your price...">
                    </div>
                    <div class="form-text">
                        <i class="fas fa-exclamation-triangle me-1 text-warning"></i>
                        Price must be between ₹<span id="min-price-text">0</span> and ₹<span id="max-price-text">0</span>
                    </div>
                </div>
                
                <!-- Negotiation Reason -->
                <div class="mb-3">
                    <label for="negotiation_reason" class="form-label">
                        <i class="fas fa-comment me-2 text-primary"></i>Reason for Negotiation *
                    </label>
                    <textarea class="form-control" id="negotiation_reason" name="negotiation_reason" 
                              rows="5" maxlength="1000" required 
                              placeholder="Please provide a detailed explanation for why you're requesting a price reduction. This will help the admin review your request."></textarea>
                    <div class="form-text d-flex justify-content-between">
                        <small class="text-muted">Be specific and professional in your reasoning</small>
                        <small><span id="char-count">0</span>/1000 characters</small>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" onclick="closeModal('negotiationModal')">
                    <i class="fas fa-times me-2"></i>Cancel
                </button>
                <button type="submit" class="btn btn-warning">
                    <i class="fas fa-paper-plane me-2"></i>Submit Negotiation Request
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
    let currentServiceId = null;

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

    // Remove negotiate button functionality from index page
    // Negotiation should only be available on the detail page
    
    // Enhanced Pay Now button with amount display
    $('.pay-now-btn').click(function() {
        const serviceId = $(this).data('id');
        const amount = $(this).data('amount');
        const $btn = $(this);
        const originalText = $btn.html();
        
        // Show loading state
        $btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Processing...');
        
        // Add visual feedback
        toastr.info('Preparing payment for ₹' + parseFloat(amount).toFixed(2) + '...');
        
        $.ajax({
            url: `/user/additional-services/${serviceId}/create-payment-order`,
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                if (response.success) {
                    // Controller returns: { success, order_id, amount, currency, key, service_name }
                    const rkey = response.key || response.razorpay_key || '{{ config('services.razorpay.key') }}';
                    const ramount = response.amount || response.order_amount || 0; // amount in paise
                    const rcurrency = response.currency || 'INR';
                    const rorderId = response.order_id || response.orderId || null;

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
                            color: '#28a745'
                        },
                        modal: {
                            ondismiss: function() {
                                toastr.warning('Payment cancelled by user');
                                $btn.prop('disabled', false).html(originalText);
                            }
                        }
                    };

                    const rzp = new Razorpay(options);
                    rzp.open();
                    
                    rzp.on('payment.failed', function (response) {
                        toastr.error('Payment failed: ' + response.error.description);
                        $btn.prop('disabled', false).html(originalText);
                    });
                } else {
                    toastr.error(response.message);
                    $btn.prop('disabled', false).html(originalText);
                }
            },
            error: function(xhr) {
                let errorMessage = 'Unable to initiate payment. Please try again.';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMessage = xhr.responseJSON.message;
                }
                toastr.error(errorMessage);
                $btn.prop('disabled', false).html(originalText);
            }
    });

    // Confirm completion button with enhanced feedback
    $('.confirm-completion-btn').click(function() {
        currentServiceId = $(this).data('id');
        console.log('Opening confirm modal for service (index):', currentServiceId);
        openModal('confirmCompletionModal');
    });

    // Handle payment success with enhanced feedback and consultation enabling
    function handlePaymentSuccess(serviceId, paymentResponse) {
        toastr.success('Payment successful! Verifying and enabling consultation...');
        
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
                    toastr.success('✅ ' + response.message + ' Professional can now start consulting!');
                    
                    // Show success animation and reload
                    setTimeout(() => {
                        toastr.info('🔄 Refreshing page to show updated status...');
                        location.reload();
                    }, 2000);
                } else {
                    toastr.error(response.message);
                }
            },
            error: function(xhr) {
                toastr.error('Payment verification failed. Please contact support.');
            }
        });
    }
    // Confirm completion with enhanced feedback
    $('#confirmCompletionBtn').click(function() {
        if (!currentServiceId) return;
        
        const $btn = $(this);
        const originalText = $btn.html();
        
        $btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Confirming...');
        
        $.ajax({
            url: `/user/additional-services/${currentServiceId}/confirm-consultation`,
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                if (response.success) {
                    closeModal('confirmCompletionModal');
                    toastr.success('✅ ' + response.message);
                    setTimeout(() => location.reload(), 2000);
                } else {
                    toastr.error(response.message);
                }
            },
            error: function(xhr) {
                toastr.error('An error occurred. Please try again.');
            },
            complete: function() {
                $btn.prop('disabled', false).html(originalText);
            }
        });
    });

    // Enhanced mobile interactions
    if (window.innerWidth <= 768) {
        // Improve touch interactions on mobile
        $('.btn').on('touchstart', function() {
            $(this).addClass('active');
        }).on('touchend', function() {
            $(this).removeClass('active');
        });
    }

    // Add smooth animations to cards and enhance Pay Now button visibility
    $('.card').each(function(index) {
        $(this).css({
            'animation-delay': (index * 0.1) + 's'
        });
    });
    
    // Highlight Pay Now buttons for better visibility
    $('.pay-now-btn').addClass('pulse-animation');
});
});
</script>
@endsection
