@extends('professional.layout.layout')

@section('title', 'Additional Services')

@section('styles')
<style>
    /* Additional Services Page Specific Styles */
    #additional-services-page .page-header {
        margin-bottom: 1.5rem;
    }
    
    #additional-services-page .page-header .page-title h3 {
        font-size: 1.5rem;
        font-weight: 600;
        margin-bottom: 0.5rem;
        color: #333;
    }

    /* Card styling */
    #additional-services-page .card {
        background-color: #fff;
        border-radius: 0.5rem;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        margin-bottom: 1.5rem;
        border: 1px solid #e9ecef;
    }
    
    #additional-services-page .card-body {
        padding: 1.25rem;
    }

    #additional-services-page .card-header {
        background: #f8f9fa;
        border-bottom: 1px solid #e9ecef;
        padding: 1rem;
        border-radius: 0.5rem 0.5rem 0 0;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    #additional-services-page .card-header h4 {
        font-size: 1.1rem;
        font-weight: 600;
        color: #495057;
        margin: 0;
    }

    /* Table styling */
    #additional-services-page .table-wrapper {
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
        margin-top: 1rem;
    }
    
    #additional-services-page .data-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 0.875rem;
    }
    
    #additional-services-page .data-table th,
    #additional-services-page .data-table td,
    #additional-services-page table.dataTable thead th,
    #additional-services-page table.dataTable tbody td,
    #additional-services-page table.dataTable.no-footer th,
    #additional-services-page table.dataTable.no-footer td {
        padding: 0.875rem 0.75rem !important;
        border: 1px solid #e9ecef !important;
        vertical-align: middle !important;
        text-align: center !important;
    }
    
    #additional-services-page .data-table th,
    #additional-services-page table.dataTable thead th,
    #additional-services-page table.dataTable.no-footer th {
        background-color: #f5f7fa !important;
        font-weight: 600 !important;
        color: #495057 !important;
        white-space: nowrap !important;
        text-align: center !important;
        border-bottom: 2px solid #dee2e6 !important;
    }
    
    #additional-services-page .data-table td,
    #additional-services-page table.dataTable tbody td,
    #additional-services-page table.dataTable.no-footer td {
        color: #495057 !important;
        text-align: center !important;
    }

    /* DataTables specific overrides */
    #additional-services-page table.dataTable.no-footer {
        border-bottom: 1px solid #e9ecef !important;
    }

    #additional-services-page .dataTables_wrapper {
        padding: 0 !important;
    }

    #additional-services-page table.dataTable thead .sorting,
    #additional-services-page table.dataTable thead .sorting_asc,
    #additional-services-page table.dataTable thead .sorting_desc {
        text-align: center !important;
    }

    /* Column widths - Apply to both custom and DataTables classes */
    #additional-services-page .data-table th:nth-child(1),
    #additional-services-page .data-table td:nth-child(1),
    #additional-services-page table.dataTable th:nth-child(1),
    #additional-services-page table.dataTable td:nth-child(1) {
        width: 70px !important;
    }

    #additional-services-page .data-table th:nth-child(2),
    #additional-services-page .data-table td:nth-child(2),
    #additional-services-page table.dataTable th:nth-child(2),
    #additional-services-page table.dataTable td:nth-child(2) {
        min-width: 180px !important;
    }

    #additional-services-page .data-table th:nth-child(3),
    #additional-services-page .data-table td:nth-child(3),
    #additional-services-page table.dataTable th:nth-child(3),
    #additional-services-page table.dataTable td:nth-child(3) {
        min-width: 150px !important;
    }

    #additional-services-page .data-table th:nth-child(4),
    #additional-services-page .data-table td:nth-child(4),
    #additional-services-page table.dataTable th:nth-child(4),
    #additional-services-page table.dataTable td:nth-child(4) {
        width: 110px !important;
    }

    #additional-services-page .data-table th:nth-child(5),
    #additional-services-page .data-table td:nth-child(5),
    #additional-services-page table.dataTable th:nth-child(5),
    #additional-services-page table.dataTable td:nth-child(5) {
        width: 130px !important;
    }

    #additional-services-page .data-table th:nth-child(6),
    #additional-services-page .data-table td:nth-child(6),
    #additional-services-page table.dataTable th:nth-child(6),
    #additional-services-page table.dataTable td:nth-child(6) {
        min-width: 160px !important;
    }

    #additional-services-page .data-table th:nth-child(7),
    #additional-services-page .data-table td:nth-child(7),
    #additional-services-page table.dataTable th:nth-child(7),
    #additional-services-page table.dataTable td:nth-child(7) {
        width: 130px !important;
    }

    #additional-services-page .data-table th:nth-child(8),
    #additional-services-page .data-table td:nth-child(8),
    #additional-services-page table.dataTable th:nth-child(8),
    #additional-services-page table.dataTable td:nth-child(8) {
        width: 120px !important;
    }

    #additional-services-page .data-table th:nth-child(9),
    #additional-services-page .data-table td:nth-child(9),
    #additional-services-page table.dataTable th:nth-child(9),
    #additional-services-page table.dataTable td:nth-child(9) {
        width: 130px !important;
    }

    #additional-services-page .data-table tbody tr,
    #additional-services-page table.dataTable tbody tr {
        transition: background-color 0.2s ease;
    }

    #additional-services-page .data-table tbody tr:hover,
    #additional-services-page table.dataTable tbody tr:hover {
        background-color: #f8f9fa !important;
    }

    /* Additional DataTables Overrides */
    #additional-services-page table.dataTable thead th,
    #additional-services-page table.dataTable thead td {
        border-top: none !important;
    }

    #additional-services-page .dataTables_length,
    #additional-services-page .dataTables_filter,
    #additional-services-page .dataTables_info,
    #additional-services-page .dataTables_paginate {
        font-size: 0.875rem;
    }

    #additional-services-page .dataTables_wrapper .dataTables_paginate .paginate_button {
        padding: 0.375rem 0.75rem !important;
        margin: 0 0.125rem !important;
        border-radius: 0.25rem !important;
    }

    /* Badge/Label styling */
    .badge {
        display: inline-block;
        padding: 0.25rem 0.625rem;
        font-size: 0.75rem;
        font-weight: 600;
        border-radius: 1rem;
        text-transform: uppercase;
    }

    .badge-warning {
        background-color: #ffc107;
        color: #212529;
    }

    .badge-success {
        background-color: #28a745;
        color: white;
    }

    .badge-danger {
        background-color: #dc3545;
        color: white;
    }

    .badge-info {
        background-color: #17a2b8;
        color: white;
    }

    /* Status workflow info box */
    .status-workflow-info {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 1rem;
        border-radius: 0.5rem;
        margin-bottom: 1.5rem;
    }

    .status-workflow-info h5 {
        font-size: 0.95rem;
        font-weight: 600;
        margin-bottom: 0.75rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .status-workflow-info .workflow-steps {
        display: flex;
        flex-wrap: wrap;
        gap: 0.5rem;
        font-size: 0.8rem;
    }

    .status-workflow-info .workflow-step {
        background: rgba(255, 255, 255, 0.2);
        padding: 0.375rem 0.75rem;
        border-radius: 0.25rem;
        white-space: nowrap;
    }

    /* Buttons */
    .btn {
        padding: 0.5rem 1rem;
        border-radius: 0.25rem;
        font-size: 0.875rem;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.2s;
        border: none;
        display: inline-flex;
        align-items: center;
        gap: 0.375rem;
        text-decoration: none;
    }

    .btn-primary {
        background-color: #0d67c7;
        color: white;
    }

    .btn-primary:hover {
        background-color: #0b5bb5;
    }

    .btn-sm {
        padding: 0.375rem 0.75rem;
        font-size: 0.8125rem;
    }

    .btn-outline-primary {
        background: transparent;
        color: #0d67c7;
        border: 1px solid #0d67c7;
    }

    .btn-outline-primary:hover {
        background: #0d67c7;
        color: white;
    }

    /* Dropdown */
    #additional-services-page .dropdown {
        position: relative;
        display: inline-block;
    }

    #additional-services-page .dropdown-toggle {
        white-space: nowrap;
    }

    #additional-services-page .dropdown-menu {
        position: absolute;
        top: 100%;
        right: 0;
        z-index: 1000;
        display: none;
        min-width: 180px;
        padding: 0.5rem 0;
        margin: 0.25rem 0 0;
        background-color: #fff;
        border: 1px solid #e9ecef;
        border-radius: 0.375rem;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    }

    #additional-services-page .dropdown-menu.show {
        display: block;
    }

    #additional-services-page .dropdown-item {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.5rem 1rem;
        color: #495057;
        text-decoration: none;
        cursor: pointer;
        transition: all 0.2s;
    }

    #additional-services-page .dropdown-item:hover {
        background-color: #f8f9fa;
        color: #0d67c7;
    }

    #additional-services-page .dropdown-item i {
        font-size: 0.875rem;
        width: 1rem;
    }

    /* Empty state */
    #additional-services-page .empty-state {
        text-align: center;
        padding: 3rem 1rem;
        background: white;
        border-radius: 0.5rem;
    }

    #additional-services-page .empty-state i {
        font-size: 4rem;
        color: #dee2e6;
        margin-bottom: 1rem;
    }

    #additional-services-page .empty-state h4 {
        color: #495057;
        margin-bottom: 0.5rem;
    }

    #additional-services-page .empty-state p {
        color: #6c757d;
        margin-bottom: 1.5rem;
    }

    /* Breadcrumb */
    #additional-services-page .breadcrumb {
        list-style: none;
        padding: 0;
        margin: 0;
        font-size: 14px;
    }

    #additional-services-page .breadcrumb li {
        display: inline;
        color: #6c757d;
    }

    #additional-services-page .breadcrumb li:not(:last-child):after {
        content: '/';
        margin: 0 8px;
        color: #adb5bd;
    }

    #additional-services-page .breadcrumb li.active {
        color: #495057;
        font-weight: 500;
    }

    #additional-services-page .breadcrumb a {
        color: #0d67c7;
        text-decoration: none;
    }

    /* Modal styling */
    .modal {
        display: none;
        position: fixed;
        z-index: 1050;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgba(0, 0, 0, 0.5);
    }

    .modal.show {
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .modal-dialog {
        max-width: 500px;
        margin: 1rem;
    }

    .modal-content {
        background-color: #fff;
        border-radius: 0.5rem;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
    }

    .modal-header {
        padding: 1rem 1.25rem;
        background: #f8f9fa;
        border-bottom: 1px solid #e9ecef;
        border-radius: 0.5rem 0.5rem 0 0;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .modal-title {
        font-size: 1.125rem;
        font-weight: 600;
        color: #333;
        margin: 0;
    }

    .btn-close {
        background: transparent;
        border: none;
        font-size: 1.5rem;
        line-height: 1;
        color: #6c757d;
        cursor: pointer;
        padding: 0;
    }

    .modal-body {
        padding: 1.25rem;
    }

    .modal-footer {
        padding: 1rem 1.25rem;
        border-top: 1px solid #e9ecef;
        display: flex;
        gap: 0.5rem;
        justify-content: flex-end;
    }

    .btn-secondary {
        background-color: #6c757d;
        color: white;
    }

    .btn-secondary:hover {
        background-color: #5a6268;
    }

    .btn-success {
        background-color: #28a745;
        color: white;
    }

    .btn-success:hover {
        background-color: #218838;
    }

    .form-label {
        font-weight: 600;
        color: #495057;
        margin-bottom: 0.5rem;
        font-size: 0.875rem;
        display: block;
    }

    .form-control {
        width: 100%;
        padding: 0.5rem 0.75rem;
        border: 1px solid #ced4da;
        border-radius: 0.375rem;
        font-size: 0.875rem;
    }

    .form-control:focus {
        border-color: #0d67c7;
        outline: none;
        box-shadow: 0 0 0 3px rgba(13, 103, 199, 0.1);
    }

    /* Text utilities */
    .text-primary {
        color: #0d67c7 !important;
    }

    .text-warning {
        color: #ffc107 !important;
    }

    .text-success {
        color: #28a745 !important;
    }

    .text-muted {
        color: #6c757d !important;
    }

    .text-right {
        text-align: right;
    }

    .text-center {
        text-align: center;
    }

    /* Spacing utilities */
    .mb-3 {
        margin-bottom: 1rem;
    }

    .py-5 {
        padding-top: 3rem;
        padding-bottom: 3rem;
    }

    /* Responsive */
    @media screen and (max-width: 767px) {
        #additional-services-page .table-wrapper {
            overflow-x: auto;
        }

        #additional-services-page .data-table {
            min-width: 1000px;
        }

        #additional-services-page .card-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 0.75rem;
        }

        #additional-services-page .text-right {
            text-align: center;
        }
    }

    @media screen and (min-width: 768px) and (max-width: 1024px) {
        #additional-services-page .table-wrapper {
            overflow-x: auto;
        }
    }
</style>
@endsection

@section('content')
<div id="additional-services-page">
    <div class="page-header">
        <div class="page-title">
            <h3>Additional Services</h3>
        </div>
        <ul class="breadcrumb">
            <li><a href="{{ route('professional.dashboard') }}">Home</a></li>
            <li class="active">Additional Services</li>
        </ul>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="card-header">
                <h4>Additional Services List</h4>
                <a href="{{ route('professional.additional-services.create') }}" style="background-color: #0d67c7; color: white; padding: 7px 15px; border-radius: 5px; text-decoration: none; display: inline-flex; align-items: center; gap: 0.375rem;">
                    <i class="fas fa-plus"></i> Add New Service
                </a>
            </div>

            <!-- Filters Section -->
            <div class="filters-section" style="background: #f8f9fa; padding: 1rem; border-radius: 0.375rem; margin: 1rem 0;">
                <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 0.75rem;">
                    <h6 style="margin: 0; font-weight: 600; color: #495057; display: flex; align-items: center; gap: 0.5rem;">
                        <i class="fas fa-filter"></i> Filter Services
                    </h6>
                    <button type="button" id="toggleFiltersBtn" class="btn btn-sm btn-outline-primary" style="padding: 0.25rem 0.75rem;">
                        <i class="fas fa-chevron-down" id="filterIcon"></i> Toggle
                    </button>
                </div>
                
                <div id="filtersContent" style="display: none;">
                    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem; margin-top: 1rem;">
                        <!-- Customer Filter -->
                        <div>
                            <label style="font-size: 0.875rem; font-weight: 600; color: #495057; margin-bottom: 0.375rem; display: block;">
                                <i class="fas fa-user"></i> Customer
                            </label>
                            <select id="filterCustomer" class="form-control" style="font-size: 0.875rem;">
                                <option value="">All Customers</option>
                                @php
                                    $customers = $additionalServices->unique('user_id')->pluck('user')->sortBy('name');
                                @endphp
                                @foreach($customers as $customer)
                                    @if($customer)
                                        <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>

                        <!-- Payment Status Filter -->
                        <div>
                            <label style="font-size: 0.875rem; font-weight: 600; color: #495057; margin-bottom: 0.375rem; display: block;">
                                <i class="fas fa-credit-card"></i> Payment Status
                            </label>
                            <select id="filterPaymentStatus" class="form-control" style="font-size: 0.875rem;">
                                <option value="">All Payment Status</option>
                                <option value="pending">Pending</option>
                                <option value="paid">Paid</option>
                                <option value="failed">Failed</option>
                            </select>
                        </div>

                        <!-- Service Status Filter -->
                        <div>
                            <label style="font-size: 0.875rem; font-weight: 600; color: #495057; margin-bottom: 0.375rem; display: block;">
                                <i class="fas fa-tasks"></i> Service Status
                            </label>
                            <select id="filterServiceStatus" class="form-control" style="font-size: 0.875rem;">
                                <option value="">All Status</option>
                                <option value="completed">Completed</option>
                                <option value="in_progress">In Progress</option>
                                <option value="ready_to_start">Ready to Start</option>
                                <option value="awaiting_delivery_date">Awaiting Delivery Date</option>
                                <option value="awaiting_payment">Awaiting Payment</option>
                                <option value="rejected">Rejected</option>
                                <option value="under_negotiation">Under Negotiation</option>
                                <option value="price_updated">Price Updated</option>
                                <option value="pending_review">Pending Review</option>
                                <option value="awaiting_admin">Awaiting Admin</option>
                                <option value="pending">Pending</option>
                            </select>
                        </div>

                        <!-- Date Range Filter -->
                        <div>
                            <label style="font-size: 0.875rem; font-weight: 600; color: #495057; margin-bottom: 0.375rem; display: block;">
                                <i class="fas fa-calendar"></i> Date Range
                            </label>
                            <select id="filterDateRange" class="form-control" style="font-size: 0.875rem;">
                                <option value="">All Time</option>
                                <option value="today">Today</option>
                                <option value="week">This Week</option>
                                <option value="month">This Month</option>
                                <option value="custom">Custom Range</option>
                            </select>
                        </div>
                    </div>

                    <!-- Custom Date Range -->
                    <div id="customDateRange" style="display: none; grid-template-columns: 1fr 1fr; gap: 1rem; margin-top: 1rem;">
                        <div>
                            <label style="font-size: 0.875rem; font-weight: 600; color: #495057; margin-bottom: 0.375rem; display: block;">
                                From Date
                            </label>
                            <input type="date" id="filterDateFrom" class="form-control" style="font-size: 0.875rem;">
                        </div>
                        <div>
                            <label style="font-size: 0.875rem; font-weight: 600; color: #495057; margin-bottom: 0.375rem; display: block;">
                                To Date
                            </label>
                            <input type="date" id="filterDateTo" class="form-control" style="font-size: 0.875rem;">
                        </div>
                    </div>

                    <!-- Filter Actions -->
                    <div style="display: flex; gap: 0.5rem; margin-top: 1rem; align-items: center;">
                        <button type="button" id="applyFilters" class="btn btn-primary btn-sm">
                            <i class="fas fa-check"></i> Apply Filters
                        </button>
                        <button type="button" id="clearFilters" class="btn btn-secondary btn-sm">
                            <i class="fas fa-times"></i> Clear All
                        </button>
                        <span id="filterResultsCount" style="font-size: 0.875rem; color: #6c757d; margin-left: 1rem;"></span>
                    </div>
                </div>
            </div>
                
                @if($additionalServices->count() > 0)
                <div class="table-wrapper">
                    <table class="data-table" id="additional-services-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Service Name</th>
                                <th>Customer</th>
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
                                <td>#{{ $service->id }}</td>
                                <td><strong>{{ $service->service_name }}</strong></td>
                                <td>{{ $service->user->name }}</td>
                                <td>
                                    <a href="#" class="text-primary" style="font-weight: 600;">
                                        #{{ $service->booking_id }}
                                    </a>
                                </td>
                                <td style="font-weight: 600;">₹{{ number_format($service->final_price, 2) }}</td>
                                <td>
                                    @php
                                        // Determine the current status in the workflow
                                        $statusBadge = '';
                                        $statusText = '';
                                        $subStatusText = '';
                                        
                                        // Check consulting status first (highest priority)
                                        if ($service->consulting_status === 'done' && $service->customer_confirmed_at) {
                                            $statusBadge = 'badge-success';
                                            $statusText = 'Completed';
                                        } elseif ($service->consulting_status === 'in_progress') {
                                            $statusBadge = 'badge-success';
                                            $statusText = 'In Progress';
                                        } elseif ($service->admin_status === 'approved') {
                                            // Service approved by admin
                                            if ($service->payment_status === 'paid') {
                                                if ($service->delivery_date_set) {
                                                    $statusBadge = 'badge-success';
                                                    $statusText = 'Ready to Start';
                                                    $subStatusText = '📅 Delivery Date Set';
                                                } else {
                                                    $statusBadge = 'badge-warning';
                                                    $statusText = 'Awaiting Delivery Date';
                                                    $subStatusText = '⏰ Set delivery date to proceed';
                                                }
                                            } else {
                                                $statusBadge = 'badge-warning';
                                                $statusText = 'Awaiting Payment';
                                                $subStatusText = '💳 Customer needs to pay';
                                            }
                                        } elseif ($service->admin_status === 'rejected') {
                                            $statusBadge = 'badge-danger';
                                            $statusText = 'Rejected';
                                            if ($service->admin_reason) {
                                                $subStatusText = '❌ ' . $service->admin_reason;
                                            }
                                        } elseif ($service->admin_status === 'pending') {
                                            // Check negotiation status
                                            if ($service->negotiation_status === 'user_negotiated') {
                                                $statusBadge = 'badge-warning';
                                                $statusText = 'Under Negotiation';
                                                $subStatusText = '💬 Awaiting admin review';
                                            } elseif ($service->negotiation_status === 'admin_responded') {
                                                $statusBadge = 'badge-warning';
                                                $statusText = 'Price Updated';
                                                $subStatusText = '✅ Awaiting customer response';
                                            } else {
                                                // Check professional status
                                                if ($service->professional_status === 'pending') {
                                                    $statusBadge = 'badge-warning';
                                                    $statusText = 'Pending Review';
                                                    $subStatusText = '⏳ Awaiting admin approval';
                                                } elseif ($service->professional_status === 'accepted') {
                                                    $statusBadge = 'badge-warning';
                                                    $statusText = 'Awaiting Admin';
                                                    $subStatusText = '👨‍💼 Under admin review';
                                                } else {
                                                    $statusBadge = 'badge-warning';
                                                    $statusText = 'Pending';
                                                }
                                            }
                                        } else {
                                            $statusBadge = 'badge-warning';
                                            $statusText = 'Pending';
                                        }
                                    @endphp
                                    
                                    <span class="badge {{ $statusBadge }}">{{ $statusText }}</span>
                                    
                                    @if($subStatusText)
                                        <br><small class="text-muted" style="font-size: 0.70rem; display: block; margin-top: 4px;">{{ $subStatusText }}</small>
                                    @endif
                                </td>
                                <td>
                                    @if($service->payment_status === 'pending')
                                        <span class="badge badge-warning">Pending</span>
                                    @elseif($service->payment_status === 'paid')
                                        <span class="badge badge-success">Paid</span>
                                    @elseif($service->payment_status === 'failed')
                                        <span class="badge badge-danger">Failed</span>
                                    @endif
                                </td>
                                <td>{{ $service->created_at->format('M d, Y') }}</td>
                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-outline-primary dropdown-toggle" type="button" onclick="toggleDropdown(this)">
                                            <i class="fas fa-cog"></i> Actions
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li>
                                                <a href="{{ route('professional.additional-services.show', $service->id) }}" class="dropdown-item">
                                                    <i class="fas fa-eye"></i> View Details
                                                </a>
                                            </li>
                                            @if($service->canBeCompletedByProfessional())
                                            <li>
                                                <a href="javascript:void(0)" class="dropdown-item mark-completed" data-id="{{ $service->id }}">
                                                    <i class="fas fa-check"></i> Mark Completed
                                                </a>
                                            </li>
                                            @endif
                                            @if(!$service->delivery_date_set)
                                            <li>
                                                <a href="javascript:void(0)" class="dropdown-item set-delivery-date" data-id="{{ $service->id }}">
                                                    <i class="fas fa-calendar"></i> Set Delivery Date
                                                </a>
                                            </li>
                                            @endif
                                            
                                            @if($service->consulting_status === 'done' && $service->payment_status === 'paid')
                                            <li><hr class="dropdown-divider"></li>
                                            <li>
                                                <a href="{{ route('professional.additional-services.invoice', $service->id) }}" class="dropdown-item">
                                                    <i class="fas fa-file-text"></i> View Invoice
                                                </a>
                                            </li>
                                            <li>
                                                <a href="{{ route('professional.additional-services.invoice.pdf', $service->id) }}" class="dropdown-item" target="_blank">
                                                    <i class="fas fa-download"></i> Download PDF Invoice
                                                </a>
                                            </li>
                                            @endif
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                        <!-- Pagination -->
                <div style="margin-top: 1.5rem; text-align: center;">
                            {{ $additionalServices->links() }}
                        </div>
                @else
                <div class="empty-state">
                    <i class="fas fa-plus-circle"></i>
                    <h4>No Additional Services Found</h4>
                    <p>You haven't created any additional services yet.</p>
                    <a href="{{ route('professional.additional-services.create') }}" style="background-color: #0d67c7; color: white; padding: 12px 24px; border-radius: 5px; text-decoration: none; display: inline-flex; align-items: center; gap: 0.5rem; font-size: 1rem; font-weight: 600;">
                                <i class="fas fa-plus"></i> Create Your First Additional Service
                            </a>
                        </div>
            @endif
        </div>
    </div>
</div><!-- End #additional-services-page -->

<!-- Mark Completed Modal -->
<div class="modal" id="markCompletedModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Mark Consultation Completed</h5>
                <button type="button" class="btn-close" onclick="closeModal('markCompletedModal')">&times;</button>
            </div>
            <div class="modal-body">
                <p style="margin: 0; line-height: 1.6;">Are you sure you want to mark this consultation as completed? The customer will be notified to confirm the completion.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="closeModal('markCompletedModal')">
                    <i class="fas fa-times"></i> Cancel
                </button>
                <button type="button" class="btn btn-success" id="confirmComplete">
                    <i class="fas fa-check"></i> Mark Completed
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Set Delivery Date Modal -->
<div class="modal" id="deliveryDateModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Set Delivery Date</h5>
                <button type="button" class="btn-close" onclick="closeModal('deliveryDateModal')">&times;</button>
            </div>
            <form id="deliveryDateForm">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="delivery_date" class="form-label">Delivery Date *</label>
                        <input type="date" class="form-control" id="delivery_date" name="delivery_date" 
                               min="{{ date('Y-m-d', strtotime('+1 day')) }}" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" onclick="closeModal('deliveryDateModal')">
                        <i class="fas fa-times"></i> Cancel
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-calendar-check"></i> Set Date
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<!-- DataTables CSS and JS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>

<script>
let currentServiceId = null;

// Dropdown toggle function
function toggleDropdown(button) {
    const dropdown = button.closest('.dropdown');
    const menu = dropdown.querySelector('.dropdown-menu');
    
    // Close all other dropdowns
    document.querySelectorAll('.dropdown-menu.show').forEach(otherMenu => {
        if (otherMenu !== menu) {
            otherMenu.classList.remove('show');
        }
    });
    
    // Toggle current dropdown
    menu.classList.toggle('show');
    
    // Close dropdown when clicking outside
    if (menu.classList.contains('show')) {
        setTimeout(() => {
            document.addEventListener('click', function closeDropdown(e) {
                if (!dropdown.contains(e.target)) {
                    menu.classList.remove('show');
                    document.removeEventListener('click', closeDropdown);
                }
            });
        }, 0);
    }
}

// Modal functions
function showModal(modalId) {
    const modal = document.getElementById(modalId);
    if (modal) {
        modal.classList.add('show');
        document.body.style.overflow = 'hidden';
    }
}

function closeModal(modalId) {
    const modal = document.getElementById(modalId);
    if (modal) {
        modal.classList.remove('show');
        document.body.style.overflow = '';
    }
}

// Close modal when clicking outside
document.querySelectorAll('.modal').forEach(modal => {
    modal.addEventListener('click', function(e) {
        if (e.target === this) {
            closeModal(this.id);
        }
    });
});

// Initialize DataTable
$(document).ready(function() {
    // Check if DataTable is available
    if (typeof $.fn.DataTable === 'undefined') {
        console.error('DataTables library not loaded');
        return;
    }

    var table = $('#additional-services-table').DataTable({
        "order": [[ 7, "desc" ]],
        "pageLength": 10,
        "responsive": true,
        "language": {
            "search": "Search services:",
            "lengthMenu": "Show _MENU_ services per page",
            "info": "Showing _START_ to _END_ of _TOTAL_ services",
            "infoEmpty": "No services found",
            "infoFiltered": "(filtered from _MAX_ total services)",
            "zeroRecords": "No matching services found"
        }
    });

    // Toggle filters - Using vanilla JavaScript
    $('#toggleFiltersBtn').on('click', function() {
        var content = document.getElementById('filtersContent');
        var icon = document.getElementById('filterIcon');
        
        if (content.style.display === 'none' || content.style.display === '') {
            content.style.display = 'block';
            icon.classList.remove('fa-chevron-down');
            icon.classList.add('fa-chevron-up');
        } else {
            content.style.display = 'none';
            icon.classList.remove('fa-chevron-up');
            icon.classList.add('fa-chevron-down');
        }
    });

    // Show/hide custom date range
    $('#filterDateRange').on('change', function() {
        var customRange = document.getElementById('customDateRange');
        if ($(this).val() === 'custom') {
            customRange.style.display = 'grid';
        } else {
            customRange.style.display = 'none';
        }
    });

    // Apply Filters
    $('#applyFilters').on('click', function() {
        applyFilters();
    });

    // Clear Filters
    $('#clearFilters').on('click', function() {
        $('#filterCustomer').val('');
        $('#filterPaymentStatus').val('');
        $('#filterServiceStatus').val('');
        $('#filterDateRange').val('');
        $('#filterDateFrom').val('');
        $('#filterDateTo').val('');
        document.getElementById('customDateRange').style.display = 'none';
        
        // Clear all DataTables search functions
        $.fn.dataTable.ext.search = [];
        
        // Clear all column filters
        table.columns().search('').draw();
        
        // Reset DataTable search
        table.search('').draw();
        
        updateFilterCount();
        
        if (typeof toastr !== 'undefined') {
            toastr.success('All filters cleared');
        }
    });

    // Function to apply filters
    function applyFilters() {
        var customerId = $('#filterCustomer').val();
        var paymentStatus = $('#filterPaymentStatus').val();
        var serviceStatus = $('#filterServiceStatus').val();
        var dateRange = $('#filterDateRange').val();
        var dateFrom = $('#filterDateFrom').val();
        var dateTo = $('#filterDateTo').val();

        // Clear previous filters
        $.fn.dataTable.ext.search = [];
        table.columns().search('');

        // Apply Customer filter (column 2)
        if (customerId) {
            var customerName = $('#filterCustomer option:selected').text();
            table.column(2).search(customerName, false, false);
        }

        // Apply Payment Status filter (column 6)
        if (paymentStatus) {
            var paymentText = paymentStatus.charAt(0).toUpperCase() + paymentStatus.slice(1);
            table.column(6).search(paymentText, false, false);
        }

        // Apply Service Status filter (column 5)
        if (serviceStatus) {
            var statusMapping = {
                'completed': 'Completed',
                'in_progress': 'In Progress',
                'ready_to_start': 'Ready to Start',
                'awaiting_delivery_date': 'Awaiting Delivery Date',
                'awaiting_payment': 'Awaiting Payment',
                'rejected': 'Rejected',
                'under_negotiation': 'Under Negotiation',
                'price_updated': 'Price Updated',
                'pending_review': 'Pending Review',
                'awaiting_admin': 'Awaiting Admin',
                'pending': 'Pending'
            };
            var statusText = statusMapping[serviceStatus] || serviceStatus;
            table.column(5).search(statusText, false, false);
        }

        // Apply Date Range filter (column 7)
        if (dateRange && dateRange !== 'custom') {
            var today = new Date();
            var filterDate = new Date();
            
            switch(dateRange) {
                case 'today':
                    filterDate.setHours(0, 0, 0, 0);
                    break;
                case 'week':
                    filterDate.setDate(today.getDate() - 7);
                    break;
                case 'month':
                    filterDate.setMonth(today.getMonth() - 1);
                    break;
            }
            
            // Custom search function for date
            $.fn.dataTable.ext.search.push(
                function(settings, data, dataIndex) {
                    var dateStr = data[7]; // Created Date column
                    if (!dateStr) return true;
                    
                    var rowDate = new Date(dateStr);
                    
                    if (dateRange === 'today') {
                        return rowDate.toDateString() === today.toDateString();
                    } else {
                        return rowDate >= filterDate;
                    }
                }
            );
        } else if (dateRange === 'custom' && dateFrom && dateTo) {
            var fromDate = new Date(dateFrom);
            var toDate = new Date(dateTo);
            toDate.setHours(23, 59, 59, 999);
            
            $.fn.dataTable.ext.search.push(
                function(settings, data, dataIndex) {
                    var dateStr = data[7];
                    if (!dateStr) return true;
                    
                    var rowDate = new Date(dateStr);
                    return rowDate >= fromDate && rowDate <= toDate;
                }
            );
        }

        // Redraw table with filters
        table.draw();
        
        updateFilterCount();
        
        var activeFilters = 0;
        if (customerId) activeFilters++;
        if (paymentStatus) activeFilters++;
        if (serviceStatus) activeFilters++;
        if (dateRange) activeFilters++;
        
        if (activeFilters > 0 && typeof toastr !== 'undefined') {
            toastr.success(activeFilters + ' filter(s) applied');
        }
    }

    // Update filter count
    function updateFilterCount() {
        var info = table.page.info();
        var countText = '';
        
        if (info.recordsDisplay < info.recordsTotal) {
            countText = 'Showing ' + info.recordsDisplay + ' of ' + info.recordsTotal + ' services';
        } else {
            countText = 'Showing all ' + info.recordsTotal + ' services';
        }
        
        $('#filterResultsCount').text(countText);
    }

    // Initial count
    updateFilterCount();

    // Update count after each draw
    table.on('draw', function() {
        updateFilterCount();
    });

    // Mark Completed
    $(document).on('click', '.mark-completed', function(e) {
        e.preventDefault();
        e.stopPropagation();
        currentServiceId = $(this).data('id');
        showModal('markCompletedModal');
    });

    $('#confirmComplete').click(function() {
        if (currentServiceId) {
            $.ajax({
                url: `/professional/additional-services/${currentServiceId}/mark-completed`,
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.success) {
                        toastr.success(response.message);
                        location.reload();
                    } else {
                        toastr.error(response.message);
                    }
                },
                error: function(xhr) {
                    toastr.error('An error occurred. Please try again.');
                }
            });
        }
        closeModal('markCompletedModal');
    });

    // Set Delivery Date
    $(document).on('click', '.set-delivery-date', function(e) {
        e.preventDefault();
        e.stopPropagation();
        currentServiceId = $(this).data('id');
        showModal('deliveryDateModal');
    });

    $('#deliveryDateForm').submit(function(e) {
        e.preventDefault();
        
        if (currentServiceId) {
            $.ajax({
                url: `/professional/additional-services/${currentServiceId}/set-delivery-date`,
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    delivery_date: $('#delivery_date').val()
                },
                success: function(response) {
                    if (response.success) {
                        toastr.success(response.message);
                        location.reload();
                    } else {
                        toastr.error(response.message);
                    }
                },
                error: function(xhr) {
                    const errors = xhr.responseJSON?.errors;
                    if (errors) {
                        Object.values(errors).forEach(function(error) {
                            toastr.error(error[0]);
                        });
                    } else {
                        toastr.error('An error occurred. Please try again.');
                    }
                }
            });
        }
        closeModal('deliveryDateModal');
    });
});
</script>
@endsection