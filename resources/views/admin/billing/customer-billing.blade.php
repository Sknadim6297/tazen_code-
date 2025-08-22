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

    .btn-outline-secondary {
        border: 2px solid #6c757d;
        color: #6c757d;
        border-radius: 8px;
        padding: 0.75rem 1.5rem;
        font-weight: 500;
        transition: all 0.3s ease;
    }

    .btn-outline-secondary:hover {
        background: #6c757d;
        border-color: #6c757d;
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(108, 117, 125, 0.3);
    }

    /* Custom Pagination Styling */
    .pagination {
        margin-bottom: 0;
    }
    .page-item.active .page-link {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-color: #667eea;
    }
    .page-link {
        color: #667eea;
        padding: 0.5rem 0.75rem;
        margin: 0 3px;
        border-radius: 6px;
        transition: all 0.2s ease;
    }
    .page-link:hover {
        background-color: #f0f2ff;
        color: #5a6fd8;
        transform: translateY(-2px);
        box-shadow: 0 2px 8px rgba(102, 126, 234, 0.15);
    }
    .page-link:focus {
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
        
        .export-buttons {
            margin-left: 0;
            margin-top: 10px;
            display: flex;
            width: 100%;
            gap: 10px;
        }
        
        .export-buttons .export-btn {
            flex: 1;
        }
        
        .pagination .page-link {
            padding: 0.4rem 0.6rem;
            font-size: 0.9rem;
        }
    }
    
    /* Invoice Button Styles */
    .btn-sm {
        padding: 0.4rem 0.8rem;
        font-size: 0.75rem;
        font-weight: 500;
        border-radius: 6px;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.3rem;
        border: none;
        cursor: pointer;
    }

    .btn-info {
        background: linear-gradient(135deg, #4299e1 0%, #3182ce 100%);
        color: white;
    }

    .btn-info:hover {
        background: linear-gradient(135deg, #3182ce 0%, #2c5282 100%);
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(66, 153, 225, 0.3);
        color: white;
        text-decoration: none;
    }

    .btn-primary.btn-sm {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }

    .btn-primary.btn-sm:hover {
        background: linear-gradient(135deg, #5a67d8 0%, #6b46a3 100%);
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
        color: white;
        text-decoration: none;
    }

    .btn-success {
        background: linear-gradient(135deg, #48bb78 0%, #38a169 100%);
        color: white;
    }

    .btn-success:hover {
        background: linear-gradient(135deg, #38a169 0%, #2f855a 100%);
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(72, 187, 120, 0.3);
        color: white;
        text-decoration: none;
    }
</style>
@endsection

@section('content')
<div class="main-content app-content">
    <div class="container-fluid">
        <!-- Page Header -->
        <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
            <div>
                <h1 class="page-title fw-medium fs-18 mb-2">Customer Billing</h1>
                <div>
                    <nav>
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="javascript:void(0);">Customer</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Customer Billing</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <!-- Filter Section - Modern Design -->
        <div class="card custom-card filter-card mb-4">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="ri-filter-3-line me-2 text-primary"></i>
                    Filter Customer Billing Records
                </h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.customer.billing') }}" method="GET" id="searchForm">
                    <div class="row g-3">
                        <!-- Date Range -->
                        <div class="col-lg-3 col-md-6">
                            <label class="form-label fw-medium text-muted mb-2">
                                <i class="ri-calendar-line me-1"></i>Date Range
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0">
                                    <i class="ri-calendar-event-line text-muted"></i>
                                </span>
                                <input type="date" class="form-control border-start-0 border-end-0" 
                                       placeholder="Start Date" name="start_date" value="{{ request('start_date') }}">
                                <span class="input-group-text bg-light border-start-0 border-end-0 text-muted">to</span>
                                <input type="date" class="form-control border-start-0" 
                                       placeholder="End Date" name="end_date" value="{{ request('end_date') }}">
                            </div>
                        </div>
                        
                        <!-- Plan Type -->
                        <div class="col-lg-3 col-md-6">
                            <label for="planTypeFilter" class="form-label fw-medium text-muted mb-2">
                                <i class="ri-briefcase-line me-1"></i>Plan Type
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0">
                                    <i class="ri-settings-line text-muted"></i>
                                </span>
                                <select class="form-select border-start-0" name="plan_type" id="planTypeFilter">
                                    <option value="">All Plans</option>
                                    <option value="one_time" {{ request('plan_type') == 'one_time' ? 'selected' : '' }}>One Time</option>
                                    <option value="monthly" {{ request('plan_type') == 'monthly' ? 'selected' : '' }}>Monthly</option>
                                    <option value="quarterly" {{ request('plan_type') == 'quarterly' ? 'selected' : '' }}>Quarterly</option>
                                    <option value="free_hand" {{ request('plan_type') == 'free_hand' ? 'selected' : '' }}>Free Hand</option>
                                </select>
                            </div>
                        </div>
                        
                        <!-- SMS Status -->
                        <div class="col-lg-3 col-md-6">
                            <label for="smsStatusFilter" class="form-label fw-medium text-muted mb-2">
                                <i class="ri-message-2-line me-1"></i>SMS Status
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0">
                                    <i class="ri-notification-line text-muted"></i>
                                </span>
                                <select class="form-select border-start-0" name="sms_status" id="smsStatusFilter">
                                    <option value="">All Status</option>
                                    <option value="sent" {{ request('sms_status') == 'sent' ? 'selected' : '' }}>Sent</option>
                                    <option value="pending" {{ request('sms_status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                </select>
                            </div>
                        </div>
                        
                        <!-- Service Filter -->
                        <div class="col-lg-3 col-md-6">
                            <label for="serviceFilter" class="form-label fw-medium text-muted mb-2">
                                <i class="ri-service-line me-1"></i>Service
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0">
                                    <i class="ri-tools-line text-muted"></i>
                                </span>
                                <select class="form-select border-start-0" name="service" id="serviceFilter">
                                    <option value="">All Services</option>
                                    @foreach($serviceOptions as $serviceName)
                                    <option value="{{ $serviceName }}" {{ request('service') == $serviceName ? 'selected' : '' }}>
                                        {{ $serviceName }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        
                        <!-- Search Input -->
                        <div class="col-lg-9 col-md-6">
                            <label for="searchInput" class="form-label fw-medium text-muted mb-2">
                                <i class="ri-search-line me-1"></i>Search
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0">
                                    <i class="ri-user-line text-muted"></i>
                                </span>
                                <input type="text" class="form-control border-start-0" name="search" 
                                       id="searchInput" placeholder="Search by name, email or phone" value="{{ request('search') }}">
                            </div>
                        </div>
                        
                        <!-- Action Buttons -->
                        <div class="col-12">
                            <div class="d-flex gap-2 justify-content-end pt-2">
                                <button type="submit" class="btn btn-primary px-4" id="search-button">
                                    <i class="ri-search-line me-1"></i>Search
                                </button>
                                <a href="{{ route('admin.customer.billing') }}" class="btn btn-outline-secondary px-4">
                                    <i class="ri-refresh-line me-1"></i>Reset
                                </a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Add Export buttons outside the filter form -->
        <div class="d-flex justify-content-end mb-3">
            <div class="export-buttons">
                <button type="button" class="export-btn export-btn-excel" onclick="exportData('excel')">
                    <i class="ri-file-excel-line me-1"></i> Export Excel
                </button>
                <button type="button" class="export-btn export-btn-pdf" onclick="exportData('pdf')">
                    <i class="ri-file-pdf-line me-1"></i> Export PDF
                </button>
            </div>
        </div>

        <!-- Add this hidden form for export -->
        <form id="export-form" method="GET" action="{{ route('admin.customer.billing.export') }}">
            <!-- Hidden inputs to carry over current filters -->
            <input type="hidden" name="search" id="export-search">
            <input type="hidden" name="service" id="export-service">
            <input type="hidden" name="plan_type" id="export-plan-type">
            <input type="hidden" name="sms_status" id="export-sms-status">
            <input type="hidden" name="start_date" id="export-start-date">
            <input type="hidden" name="end_date" id="export-end-date">
        </form>

        <!-- Billing Table -->
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered text-nowrap">
                        <thead>
                            <tr>
                                <th>S.No</th>
                                <th>Customer Name</th>
                                <th>Service Taking</th>
                                <th>Professional</th>
                                <th>Type of Plan</th>
                                <th>Amount</th>
                                <th>Date</th>
                                <th>Customer Invoice</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($billings as $key => $billing)
                            <tr>
                                <td>{{ ($billings->currentPage() - 1) * $billings->perPage() + $key + 1 }}</td>
                                <td>{{ $billing->customer_name }}</td>
                                <td>
                                    <!-- Highlight the service if it's filtered -->
                                    @if(request('service') == $billing->service_name)
                                        <span class="badge bg-info">{{ $billing->service_name }}</span>
                                    @else
                                        {{ $billing->service_name }}
                                    @endif
                                </td>
                                <td>{{ $billing->professional->name ?? 'N/A' }}</td>
                                <td>{{ ucfirst(str_replace('_', ' ', $billing->plan_type)) }}</td>
                                <td>₹{{ number_format($billing->amount, 2) }}</td>
                                <td>{{ $billing->created_at->format('d M Y') }}</td>
                                <td>
                                    <div class="d-flex gap-2">
                                        <a href="{{ route('admin.customer.invoice.view', ['id' => $billing->id]) }}" 
                                           class="btn btn-sm btn-info" target="_blank" title="View Customer Invoice">
                                            <i class="ri-eye-line"></i> View
                                        </a>
                                        <a href="{{ route('admin.customer.invoice.download', ['id' => $billing->id]) }}" 
                                           class="btn btn-sm btn-primary" title="Download Customer Invoice PDF">
                                            <i class="ri-download-line"></i> PDF
                                        </a>
                                        <a href="{{ route('admin.customer.invoice.excel', ['id' => $billing->id]) }}" 
                                           class="btn btn-sm btn-success" title="Download Customer Invoice Excel">
                                            <i class="ri-file-excel-line"></i> Excel
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="8" class="text-center">No billing records found</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="mt-4">
                    <!-- Pagination with filter parameters preserved -->
                    <div class="d-flex justify-content-center">
                        {{ $billings->appends(request()->query())->links('pagination::bootstrap-4') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        // Add Select2 for better service selection (if Select2 is available)
        if ($.fn.select2) {
            $('select[name="service"]').select2({
                placeholder: "Select a service",
                allowClear: true,
                width: '100%'
            });
        }
    });

    // Export data function
    window.exportData = function(type) {
        // Show loading overlay first
        showLoadingOverlay();
        
        // Set the values of the hidden inputs to current filter values
        document.getElementById('export-search').value = document.getElementById('searchInput').value;
        document.getElementById('export-service').value = document.getElementById('serviceFilter').value;
        document.getElementById('export-plan-type').value = document.getElementById('planTypeFilter').value;
        document.getElementById('export-sms-status').value = document.getElementById('smsStatusFilter').value;
        document.getElementById('export-start-date').value = document.querySelector('input[name="start_date"]').value;
        document.getElementById('export-end-date').value = document.querySelector('input[name="end_date"]').value;

        // Set the correct action for the export
        let form = document.getElementById('export-form');
        if (type === 'excel') {
            form.action = "{{ route('admin.customer.billing.export.excel') }}";
        } else if (type === 'pdf') {
            form.action = "{{ route('admin.customer.billing.export') }}";
        }

        // Submit the form
        form.submit();
    }
    
    // Create loading overlay function
    function showLoadingOverlay() {
        $('<div class="position-fixed w-100 h-100 d-flex align-items-center justify-content-center" style="top:0;left:0;background:rgba(255,255,255,0.7);z-index:9999;">' +
          '<div class="spinner-border text-primary" style="width:3rem;height:3rem;" role="status">' +
          '<span class="visually-hidden">Loading...</span>' +
          '</div><div style="margin-top:1rem;font-weight:500;color:#333;font-size:1.2rem;">Processing...</div></div>').appendTo('body');
    }
    
    // Add a loading state when clicking pagination links or submitting form
    $(document).ready(function() {
        // For pagination links
        $('.pagination .page-link').on('click', function() {
            showLoadingOverlay();
        });
        
        // For search form submission
        $('#searchForm').on('submit', function() {
            showLoadingOverlay();
        });
        
        // For reset button
        $('.btn-outline-secondary').on('click', function() {
            showLoadingOverlay();
        });
    });
</script>
@endsection