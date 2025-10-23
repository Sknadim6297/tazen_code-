@extends('admin.layouts.layout')

@section('styles')
<style>
    /* Export buttons styling */
    .export-buttons {
        display: flex;
        gap: 10px;
        margin-left: 10px;
    }

    .export-btn {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 0.375rem 0.75rem;
        font-size: 0.875rem;
        border-radius: 0.25rem;
        cursor: pointer;
        transition: all 0.2s;
    }

    .export-btn-excel {
        background-color: #1f7244;
        color: white;
        border: none;
    }

    .export-btn-excel:hover {
        background-color: #155a33;
    }

    .export-btn-pdf {
        background-color: #c93a3a;
        color: white;
        border: none;
    }

    .export-btn-pdf:hover {
        background-color: #a52929;
    }

    /* Filter Section Styling */
    .filter-card {
        border: none;
        box-shadow: 0 2px 10px rgba(0,0,0,0.08);
        border-radius: 12px;
        transition: all 0.3s ease;
    }

    .filter-card:hover {
        box-shadow: 0 4px 20px rgba(0,0,0,0.12);
    }

    .filter-card .card-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border-radius: 12px 12px 0 0;
        border: none;
        padding: 1rem 1.5rem;
    }

    .filter-card .card-title {
        color: white;
        font-weight: 600;
        font-size: 1.1rem;
    }

    .filter-card .card-body {
        padding: 1.5rem;
        background: #fafbfc;
    }

    .form-label {
        font-size: 0.875rem;
        font-weight: 500;
        color: #6c757d;
        margin-bottom: 0.5rem;
    }

    .input-group {
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 2px 4px rgba(0,0,0,0.04);
        transition: all 0.3s ease;
    }

    .input-group:focus-within {
        box-shadow: 0 4px 12px rgba(102, 126, 234, 0.15);
        transform: translateY(-1px);
    }

    .input-group-text {
        background: #f8f9fa;
        border: 1px solid #e9ecef;
        color: #6c757d;
        font-size: 0.875rem;
        padding: 0.75rem 1rem;
    }

    .form-control, .form-select {
        border: 1px solid #e9ecef;
        padding: 0.75rem 1rem;
        font-size: 0.875rem;
        transition: all 0.3s ease;
    }

    .form-control:focus, .form-select:focus {
        border-color: #667eea;
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

    /* Custom Pagination Styling */
    .pagination-nav {
        display: flex;
        justify-content: center;
        margin-top: 1rem;
    }

    .pagination-modern {
        margin-bottom: 0;
        gap: 0.25rem;
    }

    .pagination-modern .page-item {
        margin: 0;
    }

    .pagination-modern .page-link {
        color: #667eea;
        background-color: #fff;
        border: 1px solid #e9ecef;
        padding: 0.5rem 0.75rem;
        margin: 0;
        border-radius: 8px;
        transition: all 0.3s ease;
        font-weight: 500;
        min-width: 40px;
        text-align: center;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
    }

    .pagination-modern .page-link:hover {
        background: linear-gradient(135deg, #f0f2ff 0%, #e8ebff 100%);
        color: #5a6fd8;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(102, 126, 234, 0.15);
        border-color: #c7d2fe;
    }

    .pagination-modern .page-item.active .page-link {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-color: #667eea;
        color: #fff;
        box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
        transform: translateY(-1px);
    }

    .pagination-modern .page-item.disabled .page-link {
        color: #adb5bd;
        background-color: #f8f9fa;
        border-color: #e9ecef;
        cursor: not-allowed;
        opacity: 0.6;
    }

    .pagination-wrapper {
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    /* Enhanced Filter Styles */
    .filter-card {
        border: none;
        box-shadow: 0 4px 20px rgba(0,0,0,0.08);
        border-radius: 16px;
        transition: all 0.3s ease;
        overflow: hidden;
    }

    .filter-card:hover {
        box-shadow: 0 8px 30px rgba(0,0,0,0.12);
        transform: translateY(-2px);
    }

    .filter-card .card-header {
        background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
        border-bottom: 1px solid #e2e8f0;
        padding: 1.25rem 1.5rem;
    }

    .filter-card .card-title {
        font-weight: 600;
        color: #374151;
        font-size: 1.1rem;
    }

    .filter-card .card-body {
        padding: 1.5rem;
        background: #fff;
    }

    .form-control, .form-select {
        border: 2px solid #e5e7eb;
        padding: 0.75rem 1rem;
        font-size: 0.875rem;
        transition: all 0.3s ease;
        border-radius: 10px;
        background-color: #fff;
    }

    .form-control:focus, .form-select:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.15);
        background-color: #fff;
    }

    .input-group-text {
        background: #f8fafc;
        border: 2px solid #e5e7eb;
        border-right: none;
        color: #6b7280;
        border-radius: 10px 0 0 10px;
    }

    .input-group .form-control {
        border-left: none;
        border-radius: 0 10px 10px 0;
    }

    .input-group:focus-within .input-group-text {
        border-color: #667eea;
        background: #f0f4ff;
    }

    .btn-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: none;
        border-radius: 10px;
        padding: 0.75rem 1.5rem;
        font-weight: 600;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
    }

    .btn-primary:hover {
        background: linear-gradient(135deg, #5a6fd8 0%, #6a4190 100%);
        transform: translateY(-2px);
        box-shadow: 0 6px 25px rgba(102, 126, 234, 0.4);
    }

    .btn-outline-secondary {
        border: 2px solid #e5e7eb;
        color: #6b7280;
        border-radius: 10px;
        padding: 0.75rem 1.5rem;
        font-weight: 500;
        transition: all 0.3s ease;
    }

    .btn-outline-secondary:hover {
        background: #f3f4f6;
        border-color: #d1d5db;
        color: #374151;
        transform: translateY(-1px);
    }

    .btn-outline-primary {
        border: 2px solid #667eea;
        color: #667eea;
        border-radius: 10px;
        font-weight: 500;
        transition: all 0.3s ease;
    }

    .btn-outline-primary:hover {
        background: #667eea;
        border-color: #667eea;
        color: #fff;
        transform: translateY(-1px);
        box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
    }

    /* Results Summary Card */
    .bg-primary-transparent {
        background: rgba(102, 126, 234, 0.1) !important;
    }

    /* Export Buttons Enhancement */
    .export-buttons {
        display: flex;
        gap: 0.75rem;
    }

    .export-btn {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.75rem 1.25rem;
        font-size: 0.875rem;
        border-radius: 10px;
        cursor: pointer;
        transition: all 0.3s ease;
        font-weight: 500;
        text-decoration: none;
        border: none;
    }

    .export-btn-excel {
        background: linear-gradient(135deg, #059669 0%, #047857 100%);
        color: white;
        box-shadow: 0 4px 15px rgba(5, 150, 105, 0.3);
    }

    .export-btn-excel:hover {
        background: linear-gradient(135deg, #047857 0%, #065f46 100%);
        transform: translateY(-2px);
        box-shadow: 0 6px 25px rgba(5, 150, 105, 0.4);
        color: white;
    }

    .export-btn-pdf {
        background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%);
        color: white;
        box-shadow: 0 4px 15px rgba(220, 38, 38, 0.3);
    }

    .export-btn-pdf:hover {
        background: linear-gradient(135deg, #b91c1c 0%, #991b1b 100%);
        transform: translateY(-2px);
        box-shadow: 0 6px 25px rgba(220, 38, 38, 0.4);
        color: white;
    }

    /* Form Select Enhancements */
    .form-select-sm {
        padding: 0.5rem 2rem 0.5rem 0.75rem;
        font-size: 0.875rem;
        border-radius: 8px;
        border: 1px solid #d1d5db;
    }

    /* Animation for filter toggle */
    #filterSection {
        transition: all 0.3s ease;
        overflow: hidden;
    }

    .rotating {
        transition: transform 0.3s ease;
    }

    .rotating.rotated {
        transform: rotate(180deg);
    }
        box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
        .filter-card .card-body {
            padding: 1rem;
        }
        
        .input-group {
            margin-bottom: 1rem;
        }
        
        .btn {
            width: 100%;
            margin-bottom: 0.5rem;
        }
    }
</style>
@endsection

@section('content')
<div class="main-content app-content">
    <div class="container-fluid">
        <!-- Page Header -->
        <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
            <div>
                <h1 class="page-title fw-medium fs-18 mb-2">Admin Bookings</h1>
                <div>
                    <nav>
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Admin Bookings</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <div class="d-flex align-items-center gap-2">
                <a href="{{ route('admin.admin-booking.create') }}" class="btn btn-primary">
                    <i class="ri-add-line me-1"></i>Create New Booking
                </a>
            </div>
        </div>

        @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

        <!-- Advanced Filters Section -->
        <div class="card filter-card mb-4">
            <div class="card-header">
                <div class="d-flex align-items-center justify-content-between">
                    <h5 class="card-title mb-0">
                        <i class="ri-filter-3-line me-2 text-primary"></i>
                        Advanced Filters
                    </h5>
                    <button type="button" class="btn btn-sm btn-outline-primary" id="toggleFilters">
                        <i class="ri-arrow-down-s-line" id="filterIcon"></i>
                        <span id="filterText">Show Filters</span>
                    </button>
                </div>
            </div>
            <div class="card-body" id="filterSection" style="display: none;">
                <form method="GET" action="{{ route('admin.admin-booking.index') }}" id="filterForm">
                    <div class="row g-3">
                        <!-- Search -->
                        <div class="col-md-3">
                            <label class="form-label">Search</label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="ri-search-line"></i>
                                </span>
                                <input type="text" class="form-control" name="search" 
                                       value="{{ request('search') }}" 
                                       placeholder="Booking ID, Customer, Professional...">
                            </div>
                        </div>

                        <!-- Status Filter -->
                        <div class="col-md-3">
                            <label class="form-label">Status</label>
                            <select class="form-select" name="status">
                                <option value="">All Statuses</option>
                                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="confirmed" {{ request('status') == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                                <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                                <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                <option value="rescheduled" {{ request('status') == 'rescheduled' ? 'selected' : '' }}>Rescheduled</option>
                            </select>
                        </div>

                        <!-- Professional Filter -->
                        <div class="col-md-3">
                            <label class="form-label">Professional</label>
                            <select class="form-select" name="professional_id">
                                <option value="">All Professionals</option>
                                @foreach(\App\Models\Professional::orderBy('name')->get() as $professional)
                                    <option value="{{ $professional->id }}" 
                                            {{ request('professional_id') == $professional->id ? 'selected' : '' }}>
                                        {{ $professional->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Service Filter -->
                        <div class="col-md-3">
                            <label class="form-label">Service</label>
                            <select class="form-select" name="service_id">
                                <option value="">All Services</option>
                                @foreach(\App\Models\Service::orderBy('name')->get() as $service)
                                    <option value="{{ $service->id }}" 
                                            {{ request('service_id') == $service->id ? 'selected' : '' }}>
                                        {{ $service->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Date Range -->
                        <div class="col-md-3">
                            <label class="form-label">From Date</label>
                            <input type="date" class="form-control" name="from_date" 
                                   value="{{ request('from_date') }}">
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">To Date</label>
                            <input type="date" class="form-control" name="to_date" 
                                   value="{{ request('to_date') }}">
                        </div>

                        <!-- Amount Range -->
                        <div class="col-md-3">
                            <label class="form-label">Min Amount</label>
                            <div class="input-group">
                                <span class="input-group-text">₹</span>
                                <input type="number" class="form-control" name="min_amount" 
                                       value="{{ request('min_amount') }}" 
                                       placeholder="0" min="0" step="0.01">
                            </div>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Max Amount</label>
                            <div class="input-group">
                                <span class="input-group-text">₹</span>
                                <input type="number" class="form-control" name="max_amount" 
                                       value="{{ request('max_amount') }}" 
                                       placeholder="∞" min="0" step="0.01">
                            </div>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-12">
                            <div class="d-flex gap-2 justify-content-end">
                                <button type="button" class="btn btn-outline-secondary" id="clearFilters">
                                    <i class="ri-refresh-line me-1"></i>Clear Filters
                                </button>
                                <button type="submit" class="btn btn-primary">
                                    <i class="ri-search-line me-1"></i>Apply Filters
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Results Summary -->
        <div class="card mb-4">
            <div class="card-body py-3">
                <div class="d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center gap-3">
                        <div class="bg-primary-transparent p-2 rounded">
                            <i class="ri-file-list-line text-primary fs-16"></i>
                        </div>
                        <div>
                            <h6 class="mb-0">Total Results: <span class="text-primary">{{ $bookings->total() }}</span></h6>
                            <small class="text-muted">
                                Showing {{ $bookings->firstItem() ?? 0 }} to {{ $bookings->lastItem() ?? 0 }} of {{ $bookings->total() }} bookings
                            </small>
                        </div>
                    </div>
                    <div class="export-buttons">
                        <button class="export-btn export-btn-excel" onclick="exportToExcel()">
                            <i class="ri-file-excel-line"></i>
                            Export Excel
                        </button>
                        <button class="export-btn export-btn-pdf" onclick="exportToPDF()">
                            <i class="ri-file-pdf-line"></i>
                            Export PDF
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bookings Table -->
        <div class="card custom-card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="ri-calendar-check-line me-2 text-primary"></i>
                    All Admin Bookings
                </h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table text-nowrap table-striped table-hover table-bordered">
                        <thead class="table-primary">
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Customer</th>
                                <th scope="col">Professional</th>
                                <th scope="col">Service</th>
                                <th scope="col">Session Type</th>
                                <th scope="col">Booking Date</th>
                                <th scope="col">Amount</th>
                                <th scope="col">Payment Info</th>
                                <th scope="col">Status</th>
                                <th scope="col">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($bookings as $booking)
                                <tr>
                                    <td class="fw-medium">#{{ $booking->id }}</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar avatar-sm avatar-rounded me-2 bg-primary-transparent">
                                                <i class="ri-user-line"></i>
                                            </div>
                                            <div>
                                                <p class="mb-0 fw-semibold">{{ optional($booking->user)->name }}</p>
                                                <p class="mb-0 text-muted fs-12">{{ optional($booking->user)->email }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar avatar-sm avatar-rounded me-2 bg-success-transparent">
                                                <i class="ri-user-star-line"></i>
                                            </div>
                                            <div>
                                                <p class="mb-0 fw-semibold">{{ optional($booking->professional)->name }}</p>
                                                <p class="mb-0 text-muted fs-12">{{ optional($booking->professional)->email }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div>
                                            <p class="mb-0 fw-semibold">{{ $booking->service->name ?? $booking->service_name ?? 'N/A' }}</p>
                                            @if($booking->subService || $booking->sub_service_name)
                                                <small class="text-muted">{{ $booking->subService->name ?? $booking->sub_service_name }}</small>
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge bg-info-transparent">{{ ucfirst($booking->session_type ?? 'online') }}</span>
                                        @if($booking->session_duration)
                                            <br><small class="text-muted">{{ $booking->session_duration }} mins</small>
                                        @endif
                                    </td>
                                    <td>
                                        @if($booking->timedates && $booking->timedates->first())
                                            <div>
                                                <p class="mb-0 fw-semibold">{{ \Carbon\Carbon::parse($booking->timedates->first()->date ?? $booking->booking_date)->format('M d, Y') }}</p>
                                                @if($booking->timedates->first()->time_slot)
                                                    <p class="mb-0 text-muted fs-12">{{ $booking->timedates->first()->time_slot }}</p>
                                                @elseif($booking->booking_time)
                                                    <p class="mb-0 text-muted fs-12">{{ $booking->booking_time }}</p>
                                                @endif
                                            </div>
                                        @elseif($booking->booking_date)
                                            <div>
                                                <p class="mb-0 fw-semibold">{{ \Carbon\Carbon::parse($booking->booking_date)->format('M d, Y') }}</p>
                                                @if($booking->booking_time)
                                                    <p class="mb-0 text-muted fs-12">{{ $booking->booking_time }}</p>
                                                @endif
                                            </div>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="fw-semibold text-success">₹{{ number_format($booking->amount ?? $booking->base_amount ?? 0, 2) }}</span>
                                    </td>
                                    <td>
                                        @if($booking->payment_status === 'paid')
                                            <div class="payment-info">
                                                <span class="badge bg-success mb-1">Paid</span>
                                                @if($booking->payment_method)
                                                    <br><small class="text-muted">
                                                        <i class="ri-bank-card-line"></i> {{ ucfirst(str_replace('_', ' ', $booking->payment_method)) }}
                                                    </small>
                                                @endif
                                                @if($booking->transaction_id)
                                                    <br><small class="text-muted">
                                                        <i class="ri-number-1"></i> {{ $booking->transaction_id }}
                                                    </small>
                                                @endif
                                                @if($booking->payment_screenshot)
                                                    <br>
                                                    <button type="button" class="btn btn-sm btn-outline-primary mt-1" 
                                                            onclick="viewPaymentScreenshot('{{ asset('storage/' . $booking->payment_screenshot) }}')">
                                                        <i class="ri-image-line"></i> View Receipt
                                                    </button>
                                                @endif
                                            </div>
                                        @else
                                            <span class="badge bg-warning">{{ ucfirst($booking->payment_status ?? 'Pending') }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        @php
                                            $status = $booking->booking_status ?? $booking->payment_status ?? 'pending';
                                            $statusClass = match($status) {
                                                'confirmed', 'paid' => 'bg-success-transparent text-success',
                                                'pending' => 'bg-warning-transparent text-warning',
                                                'cancelled' => 'bg-danger-transparent text-danger',
                                                'completed' => 'bg-primary-transparent text-primary',
                                                default => 'bg-secondary-transparent text-secondary',
                                            };
                                        @endphp
                                        <span class="badge {{ $statusClass }}">{{ ucfirst($status) }}</span>
                                        @if($booking->created_by_admin || $booking->created_by === 'admin')
                                            <br><small class="text-primary"><i class="ri-admin-line"></i> Admin Created</small>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group btn-group-sm" role="group">
                                            <button type="button" class="btn btn-outline-primary" 
                                                    onclick="viewBookingDetails({{ $booking->id }})"
                                                    title="View Details">
                                                <i class="ri-eye-line"></i>
                                            </button>
                                            @if($booking->payment_status !== 'paid')
                                                <button type="button" class="btn btn-outline-success" 
                                                        onclick="markAsPaid({{ $booking->id }})"
                                                        title="Mark as Paid">
                                                    <i class="ri-check-line"></i>
                                                </button>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="10" class="text-center py-5">
                                        <div class="d-flex flex-column align-items-center">
                                            <div class="avatar avatar-xxl avatar-rounded bg-primary-transparent mb-3">
                                                <i class="ri-calendar-line fs-1 text-primary"></i>
                                            </div>
                                            <h6 class="fw-semibold text-muted mb-2">No admin bookings found</h6>
                                            <p class="text-muted mb-3">Start by creating your first admin booking</p>
                                            <a href="{{ route('admin.admin-booking.create') }}" class="btn btn-primary">
                                                <i class="ri-add-line me-1"></i>Create Booking
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Enhanced Pagination Section -->
                @if($bookings->hasPages())
                    <div class="card-footer border-top-0 bg-light">
                        <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
                            <!-- Per Page Selector -->
                            <div class="d-flex align-items-center gap-2">
                                <label class="form-label mb-0 text-muted">Show:</label>
                                <select class="form-select form-select-sm w-auto" onchange="changePerPage(this.value)">
                                    <option value="10" {{ request('per_page', 15) == 10 ? 'selected' : '' }}>10</option>
                                    <option value="15" {{ request('per_page', 15) == 15 ? 'selected' : '' }}>15</option>
                                    <option value="25" {{ request('per_page', 15) == 25 ? 'selected' : '' }}>25</option>
                                    <option value="50" {{ request('per_page', 15) == 50 ? 'selected' : '' }}>50</option>
                                    <option value="100" {{ request('per_page', 15) == 100 ? 'selected' : '' }}>100</option>
                                </select>
                                <span class="text-muted">entries per page</span>
                            </div>

                            <!-- Pagination Info -->
                            <div class="text-muted">
                                <small>
                                    Page {{ $bookings->currentPage() }} of {{ $bookings->lastPage() }}
                                    ({{ $bookings->total() }} total entries)
                                </small>
                            </div>

                            <!-- Pagination Links -->
                            <div class="pagination-wrapper">
                                {{ $bookings->appends(request()->query())->links('admin.partials.pagination') }}
                            </div>
                        </div>
                    </div>
                @else
                    <div class="card-footer border-top-0 bg-light">
                        <div class="text-center py-3">
                            <div class="mb-3">
                                <i class="ri-file-list-line fs-48 text-muted"></i>
                            </div>
                            <h6 class="text-muted">No bookings found</h6>
                            <p class="text-muted mb-0">Try adjusting your filter criteria or create a new booking.</p>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Check if booking was just created
    const urlParams = new URLSearchParams(window.location.search);
    const bookingCreated = urlParams.get('booking_created');
    
    if (bookingCreated) {
        // Show success notification
        Swal.fire({
            title: 'Booking Created Successfully!',
            text: 'The booking has been confirmed and saved.',
            icon: 'success',
            timer: 3000,
            showConfirmButton: true,
            confirmButtonText: 'Great!',
            confirmButtonColor: '#667eea'
        });
        
        // Clean URL by removing the parameter
        const url = new URL(window.location);
        url.searchParams.delete('booking_created');
        window.history.replaceState({}, document.title, url);
    }

    // Filter toggle functionality
    const toggleFilters = document.getElementById('toggleFilters');
    const filterSection = document.getElementById('filterSection');
    const filterIcon = document.getElementById('filterIcon');
    const filterText = document.getElementById('filterText');

    // Check if filters are active
    const hasActiveFilters = urlParams.toString() !== '';
    if (hasActiveFilters) {
        filterSection.style.display = 'block';
        filterIcon.classList.add('rotated');
        filterText.textContent = 'Hide Filters';
    }

    toggleFilters.addEventListener('click', function() {
        if (filterSection.style.display === 'none' || filterSection.style.display === '') {
            filterSection.style.display = 'block';
            filterIcon.classList.add('rotated');
            filterText.textContent = 'Hide Filters';
        } else {
            filterSection.style.display = 'none';
            filterIcon.classList.remove('rotated');
            filterText.textContent = 'Show Filters';
        }
    });

    // Clear filters functionality
    document.getElementById('clearFilters').addEventListener('click', function() {
        // Reset form
        document.getElementById('filterForm').reset();
        
        // Redirect to base URL without parameters
        window.location.href = '{{ route("admin.admin-booking.index") }}';
    });

    // Auto-submit form on filter change (optional)
    const filterInputs = document.querySelectorAll('#filterForm input, #filterForm select');
    filterInputs.forEach(input => {
        input.addEventListener('change', function() {
            // Optional: Auto-submit on change
            // document.getElementById('filterForm').submit();
        });
    });
});

// Change per page function
function changePerPage(perPage) {
    const url = new URL(window.location);
    url.searchParams.set('per_page', perPage);
    url.searchParams.delete('page'); // Reset to first page
    window.location.href = url.toString();
}

// Export functions
function exportToExcel() {
    const url = new URL('{{ route("admin.admin-booking.index") }}');
    
    // Add current filters to export
    const currentParams = new URLSearchParams(window.location.search);
    currentParams.forEach((value, key) => {
        url.searchParams.set(key, value);
    });
    
    url.searchParams.set('export', 'excel');
    
    // Create temporary link and trigger download
    const link = document.createElement('a');
    link.href = url.toString();
    link.download = 'admin-bookings.xlsx';
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
    
    // Show success message
    Swal.fire({
        title: 'Export Started',
        text: 'Your Excel file will download shortly.',
        icon: 'info',
        timer: 2000,
        showConfirmButton: false
    });
}

function exportToPDF() {
    const url = new URL('{{ route("admin.admin-booking.index") }}');
    
    // Add current filters to export
    const currentParams = new URLSearchParams(window.location.search);
    currentParams.forEach((value, key) => {
        url.searchParams.set(key, value);
    });
    
    url.searchParams.set('export', 'pdf');
    
    // Open in new tab for PDF
    window.open(url.toString(), '_blank');
    
    // Show success message
    Swal.fire({
        title: 'Export Started',
        text: 'Your PDF file will open in a new tab.',
        icon: 'info',
        timer: 2000,
        showConfirmButton: false
    });
}

// Add smooth animations to table rows
document.querySelectorAll('tbody tr').forEach((row, index) => {
    row.style.opacity = '0';
    row.style.transform = 'translateY(20px)';
    
    setTimeout(() => {
        row.style.transition = 'all 0.5s ease';
        row.style.opacity = '1';
        row.style.transform = 'translateY(0)';
    }, index * 50);
});

// Enhanced filter form validation
document.getElementById('filterForm').addEventListener('submit', function(e) {
    const fromDate = document.querySelector('input[name="from_date"]').value;
    const toDate = document.querySelector('input[name="to_date"]').value;
    const minAmount = document.querySelector('input[name="min_amount"]').value;
    const maxAmount = document.querySelector('input[name="max_amount"]').value;

    // Validate date range
    if (fromDate && toDate && fromDate > toDate) {
        e.preventDefault();
        Swal.fire({
            title: 'Invalid Date Range',
            text: 'From date cannot be later than To date.',
            icon: 'error',
            confirmButtonColor: '#667eea'
        });
        return;
    }

    // Validate amount range
    if (minAmount && maxAmount && parseFloat(minAmount) > parseFloat(maxAmount)) {
        e.preventDefault();
        Swal.fire({
            title: 'Invalid Amount Range',
            text: 'Minimum amount cannot be greater than maximum amount.',
            icon: 'error',
            confirmButtonColor: '#667eea'
        });
        return;
    }
});
</script>
@endsection

<!-- Payment Screenshot Modal -->
<div class="modal fade" id="paymentScreenshotModal" tabindex="-1" aria-labelledby="paymentScreenshotModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="paymentScreenshotModalLabel">
                    <i class="ri-image-line me-2"></i>Payment Receipt
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <img id="paymentScreenshotImage" src="" alt="Payment Screenshot" class="img-fluid" style="max-height: 70vh;">
            </div>
            <div class="modal-footer">
                <a id="downloadScreenshot" href="" download class="btn btn-primary">
                    <i class="ri-download-line me-1"></i>Download
                </a>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Booking Details Modal -->
<div class="modal fade" id="bookingDetailsModal" tabindex="-1" aria-labelledby="bookingDetailsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="bookingDetailsModalLabel">
                    <i class="ri-information-line me-2"></i>Booking Details
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="bookingDetailsContent">
                <div class="text-center py-5">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// View Payment Screenshot
function viewPaymentScreenshot(imageUrl) {
    const modal = new bootstrap.Modal(document.getElementById('paymentScreenshotModal'));
    document.getElementById('paymentScreenshotImage').src = imageUrl;
    document.getElementById('downloadScreenshot').href = imageUrl;
    modal.show();
}

// View Booking Details
function viewBookingDetails(bookingId) {
    const modal = new bootstrap.Modal(document.getElementById('bookingDetailsModal'));
    modal.show();
    
    fetch(`/admin/admin-booking/${bookingId}/details`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                document.getElementById('bookingDetailsContent').innerHTML = data.html;
            } else {
                document.getElementById('bookingDetailsContent').innerHTML = `
                    <div class="alert alert-danger">
                        <i class="ri-error-warning-line me-2"></i>
                        ${data.message || 'Failed to load booking details'}
                    </div>
                `;
            }
        })
        .catch(error => {
            console.error('Error:', error);
            document.getElementById('bookingDetailsContent').innerHTML = `
                <div class="alert alert-danger">
                    <i class="ri-error-warning-line me-2"></i>
                    An error occurred while loading the booking details.
                </div>
            `;
        });
}

// Mark as Paid
function markAsPaid(bookingId) {
    Swal.fire({
        title: 'Mark as Paid',
        html: `
            <div class="text-start">
                <div class="mb-3">
                    <label class="form-label">Payment Method</label>
                    <select id="payment_method" class="form-select">
                        <option value="">Select method</option>
                        <option value="bank_transfer">Bank Transfer</option>
                        <option value="upi">UPI</option>
                        <option value="cash">Cash</option>
                        <option value="cheque">Cheque</option>
                        <option value="credit_card">Credit Card</option>
                        <option value="debit_card">Debit Card</option>
                        <option value="other">Other</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Transaction ID</label>
                    <input type="text" id="transaction_id" class="form-control" placeholder="Enter transaction ID">
                </div>
            </div>
        `,
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Mark as Paid',
        cancelButtonText: 'Cancel',
        confirmButtonColor: '#28a745',
        preConfirm: () => {
            return {
                payment_method: document.getElementById('payment_method').value,
                transaction_id: document.getElementById('transaction_id').value
            }
        }
    }).then((result) => {
        if (result.isConfirmed) {
            // Send AJAX request to mark as paid
            fetch(`/admin/admin-booking/${bookingId}/mark-paid`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify(result.value)
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire({
                        title: 'Success!',
                        text: 'Booking marked as paid successfully.',
                        icon: 'success',
                        confirmButtonColor: '#667eea'
                    }).then(() => {
                        location.reload();
                    });
                } else {
                    Swal.fire({
                        title: 'Error!',
                        text: data.message || 'Failed to update payment status.',
                        icon: 'error',
                        confirmButtonColor: '#667eea'
                    });
                }
            })
            .catch(error => {
                Swal.fire({
                    title: 'Error!',
                    text: 'An error occurred. Please try again.',
                    icon: 'error',
                    confirmButtonColor: '#667eea'
                });
            });
        }
    });
}
</script>
@endsection