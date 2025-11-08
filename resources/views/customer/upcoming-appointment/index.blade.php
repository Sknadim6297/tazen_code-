@extends('customer.layout.layout')

@section('styles')
<link rel="stylesheet" href="{{ asset('customer-css/assets/css/upcoming-appointment.css') }}" />
<style>
/* Layout fixes to prevent header shifting */
.main-content {
    margin-left: var(--sidebar-width, 250px) !important;
    width: calc(100% - var(--sidebar-width, 250px)) !important;
    max-width: none !important;
    overflow-x: hidden;
}

/* Additional layout fixes */
.content-section {
    width: 100% !important;
    max-width: 100% !important;
    overflow-x: hidden;
    box-sizing: border-box;
}

.table-wrapper {
    width: 100% !important;
    max-width: 100% !important;
    overflow-x: auto;
    box-sizing: border-box;
}

.page-header {
    position: sticky;
    top: 0;
    z-index: 10;
    background-color: #f8f9fa;
    padding-top: 10px;
    padding-bottom: 10px;
    width: 100%;
    max-width: 100%;
    overflow-x: hidden;
    margin: 0;
    box-sizing: border-box;
}

/* Mobile-specific fixes */
@media (max-width: 768px) {
    /* Override sidebar layout for mobile */
    .main-content {
        margin-left: 0 !important;
        width: 100% !important;
        padding: 0 !important;
    }
    
    .content-wrapper {
        padding: 10px 5px !important;
        width: 100% !important;
        max-width: 100% !important;
        overflow-x: hidden;
    }
    
    .page-header {
        padding: 8px 10px !important;
        margin: 0 !important;
    }
    
    .page-title h3 {
        font-size: 20px !important;
        margin: 0 !important;
    }
    
    .breadcrumb {
        font-size: 14px !important;
        margin: 5px 0 0 0 !important;
    }
    
    .search-container {
        padding: 10px !important;
        margin-bottom: 10px !important;
    }
    
    .search-form {
        flex-direction: column !important;
        gap: 10px !important;
    }
    
    .search-form .form-group {
        min-width: 100% !important;
        margin-bottom: 10px !important;
    }
    
    .search-buttons {
        flex-direction: column !important;
        gap: 8px !important;
    }
    
    .search-buttons button,
    .search-buttons a {
        width: 100% !important;
        text-align: center !important;
    }
    
    /* Table responsive improvements */
    .table-wrapper {
        overflow-x: auto !important;
        -webkit-overflow-scrolling: touch;
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }
    
    .data-table {
        min-width: 800px !important;
        font-size: 12px !important;
    }
    
    .data-table th,
    .data-table td {
        padding: 6px 4px !important;
        white-space: nowrap;
        vertical-align: middle;
    }
    
    .data-table th {
        background-color: #f8f9fa !important;
        font-weight: 600 !important;
        font-size: 11px !important;
    }
    
    /* Button improvements for mobile */
    .btn-sm {
        padding: 4px 6px !important;
        font-size: 10px !important;
    }
    
    /* Section header mobile fix */
    .section-header h4 {
        font-size: 14px !important;
        line-height: 1.3 !important;
    }
    
    .section-header small {
        font-size: 11px !important;
    }
}

@media (max-width: 480px) {
    .content-wrapper {
        padding: 5px 2px !important;
    }
    
    .page-header {
        padding: 5px 8px !important;
    }
    
    .page-title h3 {
        font-size: 14px !important;
    }
    
    .search-container {
        padding: 8px !important;
        margin-bottom: 8px !important;
    }
    
    .data-table {
        min-width: 900px !important;
        font-size: 11px !important;
    }
    
    .data-table th,
    .data-table td {
        padding: 4px 3px !important;
    }
    
    .btn-sm {
        padding: 3px 5px !important;
        font-size: 12px !important;
    }
}
        
/* Make table container scrollable horizontally */
.table-wrapper {
    overflow-x: auto;
    max-width: 100%;
    -webkit-overflow-scrolling: touch; /* Better scrolling on iOS */
}

/* Ensure the table takes full width of container */
.data-table {
    width: 100%;
    table-layout: auto;
}

/* Fix the search container from overflowing */
.search-container {
    width: 100%;
    max-width: 100%;
    overflow-x: hidden;
}

/* Ensure content wrapper doesn't cause horizontal scroll */
.content-wrapper {
    overflow-x: hidden;
    width: 100%;
    max-width: 100vw;
    padding: 20px 10px;
}

/* Fix card width */
.card {
    width: 100%;
    overflow-x: hidden;
}

/* Ensure the card body doesn't cause overflow */
.card-body {
    padding: 10px 5px;
}

/* Optional: Make some table columns width-responsive */
.data-table th,
.data-table td {
    white-space: nowrap;
}

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
    flex: 1;
    min-width: 200px;
    display: flex;
    flex-direction: column;
}

.search-form label {
    margin-bottom: 5px;
    font-weight: 600;
    color: #333;
}

.search-form input[type="text"],
.search-form input[type="date"],
.search-form select {
    padding: 10px;
    border-radius: 6px;
    border: 1px solid #ccc;
    font-size: 14px;
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

/* Highlight row for filtered service */
.service-highlight {
    background-color: #e7f3ff;
}

/* Highlight row for filtered plan type */
.plan-highlight {
    background-color: #f0fff0;
}

/* Plan Type Badge Styles */
.plan-type-badge {
    display: inline-block;
    padding: 4px 10px;
    border-radius: 15px;
    font-size: 12px;
    font-weight: 600;
    background-color: #e3f2fd;
    color: #0d47a1;
    border: 1px solid #bbdefb;
}

.plan-type-premium {
    background-color: #fce4ec;
    color: #c2185b;
    border-color: #f8bbd0;
}

.plan-type-standard {
    background-color: #e8f5e9;
    color: #2e7d32;
    border-color: #c8e6c9;
}

.plan-type-basic {
    background-color: #ede7f6;
    color: #4527a0;
    border-color: #d1c4e9;
}

.plan-type-corporate {
    background-color: #fff3e0;
    color: #e65100;
    border-color: #ffe0b2;
}

.plan-type-one-time {
    background-color: #e1f5fe;
    color: #0277bd;
    border-color: #b3e5fc;
}

@media screen and (max-width: 767px) {
    /* Mobile responsive fixes - enhanced */
    .main-content {
        margin-left: 0 !important;
        width: 100% !important;
    }
    
    .page-header {
        padding: 8px 10px;
        margin: 0;
    }
    
    .page-title h3 {
        font-size: 22px;
        margin: 0;
    }
    
    .breadcrumb {
        font-size: 16px;
        margin: 5px 0 0 0;
    }
    
    .content-wrapper {
        padding: 10px 5px;
        width: 100%;
        max-width: 100%;
        overflow-x: hidden;
    }
    
    .search-container {
        padding: 10px;
        margin-bottom: 10px;
    }
    
    .search-form {
        flex-direction: column;
        gap: 10px;
    }
    
    .search-form .form-group {
        min-width: 100%;
        margin-bottom: 10px;
    }
    
    .search-buttons {
        flex-direction: column;
        gap: 8px;
    }
    
    .search-buttons button,
    .search-buttons a {
        width: 100%;
        text-align: center;
    }
    
    /* Enhanced table responsive */
    .table-wrapper {
        overflow-x: auto;
        max-width: 100%;
        -webkit-overflow-scrolling: touch;
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }
    
    .data-table {
        min-width: 800px;
        font-size: 12px;
    }
    
    .data-table th,
    .data-table td {
        padding: 6px 4px;
        white-space: nowrap;
        vertical-align: middle;
        font-size: 12px;
    }
    
    .data-table th {
        background-color: #f8f9fa;
        font-weight: 600;
        font-size: 13px;
    }
    
    /* Button improvements */
    .btn-sm {
        padding: 4px 6px;
        font-size: 12px;
    }
    
    /* Section header fix */
    .section-header h4 {
        font-size: 14px;
        line-height: 1.3;
    }
    
    .section-header small {
        font-size: 11px;
    }
}

/* Modal Styles */
.custom-modal {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
    z-index: 1050;
    opacity: 0;
    transition: opacity 0.3s ease-in-out;
    overflow-y: auto;
    overflow-x: hidden;
    padding: 20px 0;
}

.custom-modal.show {
    opacity: 1;
}

.custom-modal-content {
    position: relative;
    background-color: #fff;
    margin: 20px auto;
    padding: 0;
    width: 90%;
    max-width: 500px;
    border-radius: 8px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
    transform: translateY(-30px) scale(0.95);
    transition: transform 0.3s ease-in-out;
    max-height: calc(100vh - 40px);
    display: flex;
    flex-direction: column;
}

.custom-modal.show .custom-modal-content {
    transform: translateY(0) scale(1);
}

.custom-modal-header {
    padding: 1rem;
    border-bottom: 1px solid #dee2e6;
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-shrink: 0;
}

.custom-modal-title {
    margin: 0;
    font-size: 1.25rem;
    font-weight: 500;
    color: #333;
}

.custom-modal-close {
    background: none;
    border: none;
    font-size: 1.5rem;
    font-weight: 700;
    color: #666;
    cursor: pointer;
    padding: 0;
    line-height: 1;
}

.custom-modal-close:hover {
    color: #333;
}

.custom-modal-body {
    padding: 1.5rem;
    flex: 1;
    overflow-y: auto;
    min-height: 0;
}

.custom-modal-footer {
    padding: 1rem;
    border-top: 1px solid #dee2e6;
    display: flex;
    justify-content: flex-end;
    gap: 0.5rem;
    flex-shrink: 0;
    background: white;
}

.file-preview {
    margin-top: 1rem;
    padding: 0.75rem;
    background-color: #f8f9fa;
    border-radius: 4px;
}

.file-preview h6 {
    margin-bottom: 0.5rem;
    color: #495057;
}

/* Form Styles */
.form-label {
    font-weight: 500;
    color: #495057;
    margin-bottom: 0.5rem;
}

.form-control {
    border: 1px solid #ced4da;
    border-radius: 4px;
    padding: 0.5rem;
    width: 100%;
}

.form-text {
    font-size: 0.875rem;
    color: #6c757d;
    margin-top: 0.25rem;
}

/* Button Styles */
.btn {
    padding: 0.5rem 1rem;
    border-radius: 4px;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.2s ease-in-out;
}

.btn-primary {
    background-color: #007bff;
    border: 1px solid #007bff;
    color: #fff;
}

.btn-primary:hover {
    background-color: #0056b3;
    border-color: #0056b3;
}

.btn-secondary {
    background-color: #6c757d;
    border: 1px solid #6c757d;
    color: #fff;
}

.btn-secondary:hover {
    background-color: #5a6268;
    border-color: #545b62;
}

/* Animation Classes */
.modal-fade-in {
    animation: fadeIn 0.3s ease-in-out;
}

.modal-fade-out {
    animation: fadeOut 0.3s ease-in-out;
}

@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(-30px) scale(0.95);
    }
    to {
        opacity: 1;
        transform: translateY(0) scale(1);
    }
}

@keyframes fadeOut {
    from {
        opacity: 1;
        transform: translateY(0) scale(1);
    }
    to {
        opacity: 0;
        transform: translateY(-30px) scale(0.95);
    }
}

@media only screen and (min-width: 768px) and (max-width: 1024px) {
    /* Tablet responsive fixes */
    .main-content {
        margin-left: var(--sidebar-width, 250px) !important;
        width: calc(100% - var(--sidebar-width, 250px)) !important;
    }
    
    .page-header {
        padding: 8px 15px;
    }
    
    .content-wrapper {
        padding: 15px 10px;
    }
    
    .search-container {
        padding: 15px;
        margin-bottom: 15px;
    }
    
    .search-form {
        gap: 12px;
    }
    
    .search-form .form-group {
        min-width: 180px;
    }
    
    /* Make table container scrollable horizontally */
    .table-wrapper {
        overflow-x: auto;
        max-width: 100%;
        -webkit-overflow-scrolling: touch;
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }
    
    /* Ensure the table takes full width of container */
    .data-table {
        min-width: 800px;
        font-size: 13px;
    }
    
    /* Make table columns width-responsive */
    .data-table th,
    .data-table td {
        padding: 8px 6px;
        white-space: nowrap;
    }
    
    /* Adjust button sizes for tablet */
    .btn-sm {
        padding: 5px 8px;
        font-size: 11px;
    }
    
    /* Ensure modal content is properly sized on tablet */
    .custom-modal-content {
        width: 90%;
        max-width: 700px;
    }
}

/* Mobile Responsive Styles */
@media (max-width: 576px) {
    .custom-modal {
        padding: 5px 0;
    }
    
    .custom-modal-content {
        width: 98%;
        margin: 5px auto;
        max-height: calc(100vh - 10px);
    }

    .custom-modal-header {
        padding: 0.5rem;
    }
    
    .custom-modal-title {
        font-size: 1rem;
    }

    .custom-modal-body {
        padding: 0.75rem;
    }

    .custom-modal-footer {
        padding: 0.5rem;
        flex-direction: column;
        gap: 8px;
    }
    
    .custom-modal-footer .btn {
        width: 100%;
        margin: 0;
    }
}

/* Reschedule Specific Styles */
.action-buttons {
    display: flex;
    gap: 5px;
    align-items: center;
}

.time-slots-container {
    max-height: 200px;
    overflow-y: auto;
    border: 1px solid #dee2e6;
    border-radius: 4px;
    padding: 10px;
}

.time-slot-option {
    display: inline-block;
    margin: 5px;
    padding: 8px 12px;
    background-color: #e9ecef;
    border: 1px solid #ced4da;
    border-radius: 4px;
    cursor: pointer;
    transition: all 0.2s ease;
    font-size: 14px;
}

.time-slot-option:hover {
    background-color: #007bff;
    color: white;
    border-color: #007bff;
}

.time-slot-option.selected {
    background-color: #28a745;
    color: white;
    border-color: #28a745;
}

.time-slot-option.disabled {
    background-color: #f8f9fa;
    color: #6c757d;
    cursor: not-allowed;
    opacity: 0.6;
}

.loading-slots {
    text-align: center;
    padding: 20px;
    color: #6c757d;
}

.no-slots-available {
    text-align: center;
    padding: 20px;
    color: #dc3545;
}

@media (max-width: 576px) {
    .time-slot-option {
        width: 100%;
        margin: 3px 0;
        text-align: center;
    }
}

/* Calendar Styles */
.reschedule-calendar {
    border: 1px solid #dee2e6;
    border-radius: 8px;
    padding: 20px;
    background: white;
    max-width: 100%;
    margin: 0 auto;
}

.calendar-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
    padding: 0 10px;
}

.calendar-nav {
    background: none;
    border: none;
    font-size: 20px;
    color: #007bff;
    cursor: pointer;
    padding: 5px 10px;
    border-radius: 4px;
    transition: background-color 0.2s;
}

.calendar-nav:hover {
    background-color: #f8f9fa;
}

.calendar-nav:disabled {
    color: #6c757d;
    cursor: not-allowed;
}

.calendar-month-year {
    font-size: 18px;
    font-weight: 600;
    color: #333;
}

.calendar-grid {
    display: grid;
    grid-template-columns: repeat(7, 1fr);
    gap: 2px;
    background-color: #e9ecef;
    border-radius: 4px;
    padding: 2px;
}

.calendar-day-header {
    background-color: #f8f9fa;
    padding: 8px 4px;
    text-align: center;
    font-weight: 600;
    font-size: 12px;
    color: #495057;
}

.calendar-day {
    background-color: white;
    padding: 8px 4px;
    text-align: center;
    cursor: pointer;
    transition: all 0.2s;
    font-size: 14px;
    min-height: 35px;
    display: flex;
    align-items: center;
    justify-content: center;
    position: relative;
}

.calendar-day:hover {
    background-color: #e3f2fd;
}

.calendar-day.other-month {
    color: #adb5bd;
    background-color: #f8f9fa;
}

.calendar-day.past-date {
    color: #adb5bd;
    background-color: #f8f9fa;
    cursor: not-allowed;
}

.calendar-day.available {
    background-color: #d4edda;
    color: #155724;
    font-weight: 600;
}

.calendar-day.available:hover {
    background-color: #c3e6cb;
}

.calendar-day.selected {
    background-color: #007bff;
    color: white;
    font-weight: 600;
}

.calendar-day.unavailable {
    background-color: #f8f9fa;
    color: #6c757d;
    cursor: not-allowed;
}

.calendar-loading {
    text-align: center;
    padding: 40px;
    color: #6c757d;
}

@media (max-width: 576px) {
    .reschedule-calendar {
        padding: 10px;
    }
    
    .calendar-day {
        min-height: 30px;
        font-size: 12px;
    }
    
    .calendar-day-header {
        font-size: 10px;
        padding: 6px 2px;
    }
}
</style>
@endsection

@section('content')
<div class="content-wrapper">
    <!-- Page Header -->
    <div class="page-header">
        <div class="page-title">
            <h3>Upcoming Details of Your Appointments</h3>
        </div>
        <ul class="breadcrumb">
            <li>Home</li>
            <li class="active">upcoming-appointment</li>
        </ul>
    </div>
    <div class="search-container">
        <form action="{{ route('user.upcoming-appointment.index') }}" method="GET" class="search-form">
            <div class="form-group">
                <label for="search_name">Search</label>
                <input type="text" name="search_name" id="search_name" value="{{ request('search_name') }}" placeholder="Search appointment">
            </div>

            <!-- Service Filter -->
            <div class="form-group">
                <label for="service">Service</label>
                <select name="service" id="service" class="form-control">
                    <option value="all">All Services</option>
                    @foreach($serviceOptions as $service)
                        <option value="{{ $service }}" {{ request('service') == $service ? 'selected' : '' }}>
                            {{ $service }}
                        </option>
                    @endforeach
                </select>
            </div>
            
            <!-- Plan Type Filter -->
            <div class="form-group">
                <label for="plan_type">Plan Type</label>
                <select name="plan_type" id="plan_type" class="form-control">
                    <option value="all">All Plans</option>
                    @foreach($planTypeOptions as $planType)
                        <option value="{{ $planType }}" {{ request('plan_type') == $planType ? 'selected' : '' }}>
                            {{ $formattedPlanTypes[$planType] ?? $planType }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="search_date_from">From Date</label>
                <input type="date" name="search_date_from" value="{{ request('search_date_from') }}">
            </div>

            <div class="form-group">
                <label for="search_date_to">To Date</label>
                <input type="date" name="search_date_to" value="{{ request('search_date_to') }}">
            </div>

            <div class="search-buttons">
                <button type="submit" class="btn-success">Search</button>
                <a href="{{ route('user.upcoming-appointment.index') }}" class="btn-secondary">Reset</a>
            </div>
        </form>
    </div>

    <div class="content-section">
        <div class="section-header mb-3 d-flex justify-content-between align-items-center">
            <h4>
                Results: {{ $bookings->count() }} {{ Str::plural('appointment', $bookings->count()) }}
                @if(request('service') && request('service') != 'all')
                    for <strong>{{ request('service') }}</strong>
                @endif
                @if(request('plan_type') && request('plan_type') != 'all')
                    with plan <strong>{{ $formattedPlanTypes[request('plan_type')] ?? request('plan_type') }}</strong>
                @endif
                <small class="d-block text-muted mt-1">Showing all pending and confirmed future appointments</small>
            </h4>   
        </div>
        <div class="table-wrapper">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>S.No</th>
                        <th>Date</th>
                        <th>Month</th>
                        <th>Day</th>
                        <th>Time</th>
                        <th>Professional Name</th>
                        <th>Service Category</th>
                        <th>Sub-Service</th>
                        <th>Plan Type</th>
                        <th>Sessions Taken</th>
                        <th>Sessions Remaining</th>
                        <th>Meet Link</th>
                        <th>Upload document</th>
                        <th>Professional document</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($bookings as $index => $booking)
                        @php
                            // The timedate is already filtered to be the next upcoming one
                            $upcomingTimedate = $booking->timedates->first();
                            
                            // Check if this service is being filtered
                            $isFilteredService = request('service') == $booking->service_name;
                            
                            // Check if this plan type is being filtered
                            $isFilteredPlan = request('plan_type') == $booking->plan_type;
                            
                            // Determine plan type class
                            $planTypeClass = 'plan-type-badge';
                            $planTypeLower = strtolower($booking->plan_type ?? '');
                            
                            if ($planTypeLower == 'premium') {
                                $planTypeClass .= ' plan-type-premium';
                            } elseif ($planTypeLower == 'standard') {
                                $planTypeClass .= ' plan-type-standard';
                            } elseif ($planTypeLower == 'basic') {
                                $planTypeClass .= ' plan-type-basic';
                            } elseif ($planTypeLower == 'corporate') {
                                $planTypeClass .= ' plan-type-corporate';
                            } elseif ($planTypeLower == 'one_time') {
                                $planTypeClass .= ' plan-type-one-time';
                            }
                        @endphp
                        
                        @if($upcomingTimedate)
                            <tr class="{{ $isFilteredService ? 'service-highlight' : '' }} {{ $isFilteredPlan ? 'plan-highlight' : '' }}">
                                <td>{{ $index + 1 }}</td>
                                <td>
                                    <div>
                                        <p class="mb-0 fw-semibold">{{ \Carbon\Carbon::parse($upcomingTimedate->date)->format('M d, Y') }}</p>
                                        <p class="mb-0 text-muted fs-12">{{ \Carbon\Carbon::parse($upcomingTimedate->date)->format('l') }}</p>
                                    </div>
                                </td>
                                <td>{{ \Carbon\Carbon::parse($upcomingTimedate->date)->format('F') }}</td>
                                <td>{{ \Carbon\Carbon::parse($upcomingTimedate->date)->format('D') }}</td>
                                <td>
                                    <p class="mb-0 fw-semibold">{{ $upcomingTimedate->time_slot }}</p>
                                </td>
                                <td>{{ $booking->professional->name ?? 'Not Assigned' }}</td>
                                <td>
                                    @if($isFilteredService)
                                        <strong>{{ $booking->service_name }}</strong>
                                    @else
                                        {{ $booking->service_name }}
                                    @endif
                                </td>
                                <td>
                                    @if($booking->sub_service_name)
                                        <span class="badge bg-info">{{ $booking->sub_service_name }}</span>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>
                                    @if($booking->plan_type)
                                        <span class="{{ $planTypeClass }}">{{ $booking->formatted_plan_type }}</span>
                                    @else
                                        <span class="text-muted">No Plan</span>
                                    @endif
                                </td>
                                <td>{{ $booking->sessions_taken ?? 0 }}</td>
                                <td>{{ $booking->sessions_remaining ?? 0 }}</td>
                                <td>
                                    @if($upcomingTimedate->meeting_link)
                                        <a href="{{ $upcomingTimedate->meeting_link }}" target="_blank" class="btn btn-primary" style="padding: 4px 8px;">Join</a>
                                    @else
                                        <span class="text-muted">No link</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="document-actions">
                                        @if($booking->customer_document)
                                            <a href="{{ asset('storage/' . $booking->customer_document) }}" 
                                               class="btn btn-sm btn-info" 
                                               target="_blank" 
                                               title="View Document">
                                                <i class="fas fa-file"></i>
                                            </a>
                                        @endif
                                        <button type="button" 
                                                class="btn btn-sm {{ $booking->customer_document ? 'btn-warning' : 'btn-primary' }} upload-btn" 
                                                data-booking-id="{{ $booking->id }}"
                                                title="{{ $booking->customer_document ? 'Update Document' : 'Upload Document' }}">
                                            <i class="fas {{ $booking->customer_document ? 'fa-edit' : 'fa-upload' }}"></i>
                                        </button>
                                    </div>
                                </td>
                                <td>
                                    @if($booking->professional_documents)
                                        @foreach(explode(',', $booking->professional_documents) as $document)
                                            <a href="{{ asset('storage/' . $document) }}" 
                                               class="btn btn-sm btn-info mb-1" 
                                               target="_blank" 
                                               title="View Professional Document">
                                                <i class="fas fa-file"></i>
                                            </a>
                                        @endforeach
                                    @else
                                        <span class="text-muted">No documents</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="action-buttons">
                                        @php
                                            $rescheduleEnabled = $booking->reschedule_count < $booking->max_reschedules_allowed;
                                            $remainingReschedules = $booking->max_reschedules_allowed - $booking->reschedule_count;
                                        @endphp
                                        
                                        @if($rescheduleEnabled)
                                            <button type="button" 
                                                    class="btn btn-sm btn-warning reschedule-btn" 
                                                    data-booking-id="{{ $booking->id }}"
                                                    title="Reschedule Appointment ({{ $remainingReschedules }} remaining)">
                                                <i class="fas fa-calendar-alt"></i>
                                            </button>
                                        @else
                                            <span class="text-muted small" title="Maximum reschedules reached">
                                                <i class="fas fa-ban"></i>
                                            </span>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endif
                    @empty
                        <tr>
                            <td colspan="15" class="text-center">No upcoming appointments found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Custom Upload Modal -->
<div id="uploadModal" class="custom-modal">
    <div class="custom-modal-content">
        <div class="custom-modal-header">
            <h5 class="custom-modal-title">Upload Document</h5>
            <button type="button" class="custom-modal-close" onclick="closeModal('uploadModal')">&times;</button>
        </div>
        <div class="custom-modal-body">
            <form id="uploadForm" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="booking_id" id="bookingId">
                <div class="mb-3">
                    <label for="document" class="form-label">Select Document</label>
                    <input type="file" class="form-control" id="document" name="document" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png" required>
                    <div class="form-text">Supported formats: PDF, DOC, DOCX, JPG, JPEG, PNG (Max: 2MB)</div>
                </div>
                <div id="filePreview" class="file-preview" style="display: none;">
                    <h6>Selected File:</h6>
                    <p class="mb-0" id="selectedFileName"></p>
                </div>
            </form>
        </div>
        <div class="custom-modal-footer">
            <button type="button" class="btn btn-secondary" onclick="closeModal('uploadModal')">Cancel</button>
            <button type="button" class="btn btn-primary" id="uploadBtn">Upload</button>
        </div>
    </div>
</div>

<!-- Custom Reschedule Modal -->
<div id="rescheduleModal" class="custom-modal">
    <div class="custom-modal-content" style="max-width: 600px;">
        <div class="custom-modal-header">
            <h5 class="custom-modal-title">Reschedule Appointment</h5>
            <button type="button" class="custom-modal-close" onclick="closeModal('rescheduleModal')">&times;</button>
        </div>
        <div class="custom-modal-body">
            <form id="rescheduleForm">
                @csrf
                <input type="hidden" name="booking_id" id="rescheduleBookingId">
                
                <div class="mb-3">
                    <label class="form-label">Current Appointment</label>
                    <div class="alert alert-info">
                        <div id="currentAppointmentInfo"></div>
                    </div>
                </div>
                
                <div class="mb-3">
                    <label for="rescheduleCalendar" class="form-label">Select New Date</label>
                    <div id="rescheduleCalendar" class="reschedule-calendar"></div>
                    <input type="hidden" id="selectedDate" name="new_date" required>
                    <div class="form-text">
                        <span class="text-success">● Available dates</span> | 
                        <span class="text-muted">● Unavailable dates</span>
                    </div>
                </div>
                
                <div class="mb-3">
                    <label class="form-label">Available Time Slots</label>
                    <div id="rescheduleTimeSlots" class="time-slots-container">
                        <div class="text-muted text-center p-3">Please select a date first</div>
                    </div>
                </div>
                
                <div class="mb-3">
                    <label for="rescheduleReason" class="form-label">Reason for Reschedule <span class="text-danger">*</span></label>
                    <textarea class="form-control" id="rescheduleReason" name="reschedule_reason" rows="3" required placeholder="Please provide a reason for rescheduling..."></textarea>
                </div>
                
                <div id="rescheduleInfo" class="alert alert-warning small" style="display: none;">
                    <i class="fas fa-info-circle"></i> <span id="rescheduleInfoText"></span>
                </div>
            </form>
        </div>
        <div class="custom-modal-footer">
            <button type="button" class="btn btn-secondary" onclick="closeModal('rescheduleModal')">Cancel</button>
            <button type="button" class="btn btn-warning" id="rescheduleBtn" disabled>
                <i class="fas fa-calendar-alt"></i> Reschedule Appointment
            </button>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const uploadForm = document.getElementById('uploadForm');
    const uploadBtn = document.getElementById('uploadBtn');
    const fileInput = document.getElementById('document');
    const filePreview = document.getElementById('filePreview');
    const selectedFileName = document.getElementById('selectedFileName');
    const modal = document.getElementById('uploadModal');

    // Modal functions
    window.openModal = function(modalId) {
        const modal = document.getElementById(modalId);
        modal.style.display = 'block';
        setTimeout(() => {
            modal.classList.add('show');
        }, 10);
        document.body.style.overflow = 'hidden';
    };

    window.closeModal = function(modalId) {
        const modal = document.getElementById(modalId);
        modal.classList.remove('show');
        setTimeout(() => {
            modal.style.display = 'none';
        }, 300);
        document.body.style.overflow = '';
    };

    // Close modal when clicking outside for all modals
    document.querySelectorAll('.custom-modal').forEach(modal => {
        modal.addEventListener('click', function(event) {
            if (event.target === modal) {
                closeModal(modal.id);
            }
        });
    });

    // Prevent modal from closing when clicking inside the modal content for all modals
    document.querySelectorAll('.custom-modal-content').forEach(content => {
        content.addEventListener('click', function(event) {
            event.stopPropagation();
        });
    });

    // Handle ESC key to close modals
    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') {
            document.querySelectorAll('.custom-modal.show').forEach(modal => {
                closeModal(modal.id);
            });
        }
    });

    // Handle file input change
    fileInput.addEventListener('change', function() {
        if (this.files && this.files[0]) {
            const file = this.files[0];
            const allowedTypes = [
                'application/pdf',
                'application/msword',
                'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                'image/jpeg',
                'image/png',
                'image/jpg'
            ];
            if (!allowedTypes.includes(file.type)) {
                toastr.error('Invalid file type. Allowed: PDF, DOC, DOCX, JPG, JPEG, PNG.');
                this.value = '';
                filePreview.style.display = 'none';
                return;
            }
            if (file.size > 2 * 1024 * 1024) {
                toastr.error('File size exceeds 2MB.');
                this.value = '';
                filePreview.style.display = 'none';
                return;
            }
            selectedFileName.textContent = file.name;
            filePreview.style.display = 'block';
        } else {
            filePreview.style.display = 'none';
        }
    });

    // Handle upload button click
    document.querySelectorAll('.upload-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            document.getElementById('bookingId').value = this.dataset.bookingId;
            filePreview.style.display = 'none';
            uploadForm.reset();
            openModal('uploadModal');
        });
    });

    // Handle file upload
    uploadBtn.addEventListener('click', function() {
        const formData = new FormData(uploadForm);

        // Disable the upload button and show loading state
        uploadBtn.disabled = true;
        uploadBtn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Uploading...';

        fetch('{{ route("user.upload.document") }}', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                toastr.success(data.message);
                setTimeout(() => {
                    window.location.reload();
                }, 1500);
            } else {
                if (data.errors) {
                    // Show all validation errors
                    Object.values(data.errors).forEach(msgArr => {
                        if (Array.isArray(msgArr)) {
                            msgArr.forEach(msg => toastr.error(msg));
                        } else {
                            toastr.error(msgArr);
                        }
                    });
                } else {
                    toastr.error(data.message);
                }
            }
        })
        .catch(error => {
            console.error('Error:', error);
            toastr.error('Error uploading document');
        })
        .finally(() => {
            // Re-enable the upload button and restore original text
            uploadBtn.disabled = false;
            uploadBtn.innerHTML = 'Upload';
        });
    });

    // Reschedule functionality
    let selectedTimeSlot = null;
    let currentBookingData = null;
    let availableDates = [];
    let currentCalendarDate = new Date();
    let professionalAvailabilityData = [];
    let existingBookings = {};

    // Handle reschedule button click
    document.querySelectorAll('.reschedule-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const bookingId = this.dataset.bookingId;
            openRescheduleModal(bookingId);
        });
    });

    // Open reschedule modal
    function openRescheduleModal(bookingId) {
        // Find booking data from the current page
        const row = document.querySelector(`[data-booking-id="${bookingId}"]`).closest('tr');
        const cells = row.querySelectorAll('td');
        
        // Extract current appointment info
        const currentDate = cells[1].textContent.trim();
        const currentTime = cells[4].textContent.trim();
        const professionalName = cells[5].textContent.trim();
        const serviceName = cells[6].textContent.trim();
        
        currentBookingData = {
            id: bookingId,
            currentDate: currentDate,
            currentTime: currentTime,
            professionalName: professionalName,
            serviceName: serviceName
        };

        // Set booking ID in form
        document.getElementById('rescheduleBookingId').value = bookingId;

        // Set current appointment info
        document.getElementById('currentAppointmentInfo').innerHTML = `
            <strong>Service:</strong> ${serviceName}<br>
            <strong>Professional:</strong> ${professionalName}<br>
            <strong>Current Date:</strong> ${currentDate}<br>
            <strong>Current Time:</strong> ${currentTime}
        `;

        // Reset form
        document.getElementById('rescheduleForm').reset();
        document.getElementById('rescheduleBookingId').value = bookingId; // Set again after reset
        document.getElementById('rescheduleTimeSlots').innerHTML = '<div class="text-muted text-center p-3">Please select a date first</div>';
        document.getElementById('rescheduleBtn').disabled = true;
        selectedTimeSlot = null;
        currentCalendarDate = new Date();

        // Load professional availability and render calendar
        loadProfessionalAvailability(bookingId);

        openModal('rescheduleModal');
    }

    // Load professional availability data
    function loadProfessionalAvailability(bookingId) {
        const calendarContainer = document.getElementById('rescheduleCalendar');
        calendarContainer.innerHTML = '<div class="calendar-loading"><i class="fas fa-spinner fa-spin"></i> Loading calendar...</div>';

        console.log('Loading availability for booking ID:', bookingId);

        fetch(`{{ url('/user/upcoming-appointment') }}/${bookingId}/professional-availability`)
            .then(response => {
                console.log('Response status:', response.status);
                return response.json();
            })
            .then(data => {
                console.log('Received availability data:', data);
                if (data.success) {
                    professionalAvailabilityData = data.data;
                    existingBookings = data.existing_bookings || {};
                    console.log('Professional availability data:', professionalAvailabilityData);
                    console.log('Existing bookings:', existingBookings);
                    generateAvailableDates();
                    renderCalendar();
                } else {
                    console.error('API returned error:', data.message);
                    calendarContainer.innerHTML = `<div class="text-danger text-center p-3">${data.message}</div>`;
                }
            })
            .catch(error => {
                console.error('Error loading professional availability:', error);
                calendarContainer.innerHTML = '<div class="text-danger text-center p-3">Error loading calendar. Please try again.</div>';
            });
    }

    // Generate available dates from professional availability
    function generateAvailableDates() {
        availableDates = [];
        const today = new Date();
        today.setHours(0, 0, 0, 0);

        professionalAvailabilityData.forEach(availability => {
            const monthYear = availability.month; // Format: "2025-11"
            const [year, month] = monthYear.split('-').map(Number);
            const weeklySlots = availability.weekly_slots;

            // Generate dates for the entire month
            const daysInMonth = new Date(year, month, 0).getDate();
            
            for (let day = 1; day <= daysInMonth; day++) {
                const date = new Date(year, month - 1, day);
                
                // Skip past dates (only allow future dates)
                if (date < today) continue;

                // Get weekday name
                const weekdayMap = ['sun', 'mon', 'tue', 'wed', 'thu', 'fri', 'sat'];
                const weekday = weekdayMap[date.getDay()];

                // Check if professional has slots for this weekday
                if (weeklySlots && weeklySlots[weekday] && weeklySlots[weekday].length > 0) {
                    availableDates.push(date.toISOString().split('T')[0]);
                }
            }
        });
        
        console.log('Generated available dates:', availableDates);
    }

    // Render calendar
    function renderCalendar() {
        const calendarContainer = document.getElementById('rescheduleCalendar');
        const year = currentCalendarDate.getFullYear();
        const month = currentCalendarDate.getMonth();

        const monthNames = [
            'January', 'February', 'March', 'April', 'May', 'June',
            'July', 'August', 'September', 'October', 'November', 'December'
        ];

        const dayNames = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];

        // Calculate first day of month and number of days
        const firstDay = new Date(year, month, 1).getDay();
        const daysInMonth = new Date(year, month + 1, 0).getDate();
        const daysInPrevMonth = new Date(year, month, 0).getDate();

        let calendarHtml = `
            <div class="calendar-header">
                <button type="button" class="calendar-nav" onclick="navigateMonth(-1)">
                    <i class="fas fa-chevron-left"></i>
                </button>
                <div class="calendar-month-year">
                    ${monthNames[month]} ${year}
                </div>
                <button type="button" class="calendar-nav" onclick="navigateMonth(1)">
                    <i class="fas fa-chevron-right"></i>
                </button>
            </div>
            <div class="calendar-grid">
        `;

        // Add day headers
        dayNames.forEach(day => {
            calendarHtml += `<div class="calendar-day-header">${day}</div>`;
        });

        // Add empty cells for days before month starts
        for (let i = firstDay - 1; i >= 0; i--) {
            const day = daysInPrevMonth - i;
            calendarHtml += `<div class="calendar-day other-month">${day}</div>`;
        }

        // Add days of current month
        const today = new Date();
        today.setHours(0, 0, 0, 0);

        for (let day = 1; day <= daysInMonth; day++) {
            const date = new Date(year, month, day);
            const dateString = date.toISOString().split('T')[0];
            
            let dayClass = 'calendar-day';
            let clickHandler = '';

            if (date < today) {
                dayClass += ' past-date';
            } else if (availableDates.includes(dateString)) {
                dayClass += ' available';
                clickHandler = `onclick="selectCalendarDate('${dateString}')"`;
            } else {
                dayClass += ' unavailable';
            }

            calendarHtml += `<div class="${dayClass}" ${clickHandler}>${day}</div>`;
        }

        // Add empty cells for days after month ends
        const totalCells = Math.ceil((firstDay + daysInMonth) / 7) * 7;
        const remainingCells = totalCells - (firstDay + daysInMonth);
        for (let day = 1; day <= remainingCells; day++) {
            calendarHtml += `<div class="calendar-day other-month">${day}</div>`;
        }

        calendarHtml += '</div>';
        calendarContainer.innerHTML = calendarHtml;
    }

    // Navigate calendar months
    window.navigateMonth = function(direction) {
        const today = new Date();
        const newDate = new Date(currentCalendarDate);
        newDate.setMonth(newDate.getMonth() + direction);
        
        // Allow navigation from current month to 6 months ahead
        const maxDate = new Date(today);
        maxDate.setMonth(maxDate.getMonth() + 6);
        
        // Don't allow navigation to past months or more than 6 months ahead
        if (newDate < new Date(today.getFullYear(), today.getMonth(), 1) || newDate > maxDate) {
            return;
        }
        
        currentCalendarDate = newDate;
        renderCalendar();
    };

    // Select calendar date
    window.selectCalendarDate = function(dateString) {
        // Remove previous selection
        document.querySelectorAll('.calendar-day').forEach(day => {
            day.classList.remove('selected');
        });

        // Select current date
        event.target.classList.add('selected');
        document.getElementById('selectedDate').value = dateString;

        // Load time slots for selected date
        loadAvailableTimeSlots(currentBookingData.id, dateString);
    };

    // Load available time slots for selected date
    function loadAvailableTimeSlots(bookingId, date) {
        const slotsContainer = document.getElementById('rescheduleTimeSlots');
        slotsContainer.innerHTML = '<div class="loading-slots"><i class="fas fa-spinner fa-spin"></i> Loading available time slots...</div>';

        displayTimeSlots(professionalAvailabilityData, date);
    }

    // Display time slots
    function displayTimeSlots(availabilityData, selectedDate) {
        const slotsContainer = document.getElementById('rescheduleTimeSlots');
        const dateObj = new Date(selectedDate);
        
        // Get day name (convert to lowercase 3-letter format expected by backend)
        const dayNames = ['sun', 'mon', 'tue', 'wed', 'thu', 'fri', 'sat'];
        const dayName = dayNames[dateObj.getDay()];
        
        let availableSlots = [];
        let bookedSlots = existingBookings[selectedDate] || [];
        
        console.log('=== TIME SLOT GENERATION DEBUG ===');
        console.log('Selected date:', selectedDate);
        console.log('Date object:', dateObj);
        console.log('Day name:', dayName);
        console.log('Availability data:', availabilityData);
        console.log('Booked slots for this date:', bookedSlots);
        
        // Find slots for the selected day
        availabilityData.forEach((availability, index) => {
            console.log(`Processing availability ${index}:`, availability);
            
            if (availability.weekly_slots && availability.weekly_slots[dayName]) {
                console.log(`Found slots for ${dayName}:`, availability.weekly_slots[dayName]);
                
                availability.weekly_slots[dayName].forEach((slot, slotIndex) => {
                    console.log(`Processing slot ${slotIndex}:`, slot);
                    
                    // Generate time slots based on session duration
                    const sessionDuration = availability.session_duration || 60;
                    const startTime = slot.start_time;
                    const endTime = slot.end_time;
                    
                    console.log(`Slot details - Start: ${startTime}, End: ${endTime}, Duration: ${sessionDuration} mins`);
                    
                    const start = new Date(`2023-01-01 ${startTime}`);
                    const end = new Date(`2023-01-01 ${endTime}`);
                    
                    console.log('Start date object:', start);
                    console.log('End date object:', end);
                    
                    let slotCounter = 0;
                    while (start < end && slotCounter < 20) { // Safety limit
                        const slotStart = start.toTimeString().substr(0, 5);
                        const slotEnd = new Date(start.getTime() + sessionDuration * 60000).toTimeString().substr(0, 5);
                        
                        console.log(`Generated slot ${slotCounter}: ${slotStart} - ${slotEnd}`);
                        
                        // Skip if end time exceeds availability end time
                        if (new Date(`2023-01-01 ${slotEnd}`) > end) {
                            console.log('Slot end time exceeds availability, breaking');
                            break;
                        }
                        
                        // Convert to 12-hour format
                        const slotStart12 = formatTo12Hour(slotStart);
                        const slotEnd12 = formatTo12Hour(slotEnd);
                        const timeSlot = `${slotStart12} - ${slotEnd12}`;
                        
                        console.log(`Formatted slot: ${timeSlot}`);
                        
                        availableSlots.push(timeSlot);
                        start.setMinutes(start.getMinutes() + sessionDuration);
                        slotCounter++;
                    }
                });
            } else {
                console.log(`No slots found for ${dayName} in availability:`, availability.weekly_slots);
            }
        });

        console.log('Final generated available slots:', availableSlots);

        if (availableSlots.length === 0) {
            console.log('No available slots found, showing message');
            slotsContainer.innerHTML = '<div class="no-slots-available">No available time slots for this date</div>';
            return;
        }

        // Remove duplicates and sort
        availableSlots = [...new Set(availableSlots)];
        console.log('After removing duplicates:', availableSlots);
        
        availableSlots.sort((a, b) => {
            const timeA = a.split(' - ')[0];
            const timeB = b.split(' - ')[0];
            return convertTo24Hour(timeA).localeCompare(convertTo24Hour(timeB));
        });

        console.log('After sorting:', availableSlots);

        // Display slots
        let slotsHtml = '';
        availableSlots.forEach(slot => {
            const isBooked = bookedSlots.includes(slot);
            const slotClass = isBooked ? 'time-slot-option disabled' : 'time-slot-option';
            const clickHandler = isBooked ? '' : `onclick="selectTimeSlot('${slot}')"`;
            const statusText = isBooked ? '<small class="d-block text-danger">Booked</small>' : '';
            
            slotsHtml += `
                <div class="${slotClass}" ${clickHandler}>
                    ${slot}
                    ${statusText}
                </div>
            `;
        });

        console.log('Generated HTML:', slotsHtml);
        slotsContainer.innerHTML = slotsHtml;
        console.log('=== END TIME SLOT DEBUG ===');
    }
                </div>
            `;
        });

        slotsContainer.innerHTML = slotsHtml;
    }

    // Convert 12-hour to 24-hour format for sorting
    function convertTo24Hour(time12) {
        const [time, modifier] = time12.split(' ');
        let [hours, minutes] = time.split(':');
        if (hours === '12') {
            hours = '00';
        }
        if (modifier === 'PM') {
            hours = parseInt(hours, 10) + 12;
        }
        return `${hours}:${minutes}`;
    }

    // Convert 24-hour to 12-hour format
    function formatTo12Hour(time24) {
        const [hours, minutes] = time24.split(':');
        const hour12 = hours % 12 || 12;
        const ampm = hours >= 12 ? 'PM' : 'AM';
        return `${hour12}:${minutes} ${ampm}`;
    }

    // Select time slot
    window.selectTimeSlot = function(timeSlot) {
        // Don't select if slot is disabled
        if (event.target.classList.contains('disabled')) {
            return;
        }

        // Remove previous selection
        document.querySelectorAll('.time-slot-option').forEach(option => {
            option.classList.remove('selected');
        });

        // Select current option
        event.target.classList.add('selected');
        selectedTimeSlot = timeSlot;

        // Enable reschedule button if all required fields are filled
        checkRescheduleFormValidity();
    };

    // Check if reschedule form is valid
    function checkRescheduleFormValidity() {
        const date = document.getElementById('selectedDate').value;
        const reason = document.getElementById('rescheduleReason').value.trim();
        const rescheduleBtn = document.getElementById('rescheduleBtn');

        rescheduleBtn.disabled = !(date && selectedTimeSlot && reason);
    }

    // Handle reason textarea change
    document.getElementById('rescheduleReason').addEventListener('input', checkRescheduleFormValidity);

    // Handle reschedule submission
    document.getElementById('rescheduleBtn').addEventListener('click', function() {
        if (!selectedTimeSlot || !currentBookingData) {
            toastr.error('Please select a time slot');
            return;
        }

        const formData = new FormData();
        formData.append('_token', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
        formData.append('new_date', document.getElementById('selectedDate').value);
        formData.append('new_time_slot', selectedTimeSlot);
        formData.append('reschedule_reason', document.getElementById('rescheduleReason').value);

        // Disable button and show loading
        this.disabled = true;
        this.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Rescheduling...';

        fetch(`{{ url('/user/upcoming-appointment') }}/${currentBookingData.id}/reschedule`, {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                toastr.success(data.message);
                closeModal('rescheduleModal');
                // Reload page after short delay
                setTimeout(() => {
                    window.location.reload();
                }, 2000);
            } else {
                if (data.errors) {
                    Object.values(data.errors).forEach(msgArr => {
                        if (Array.isArray(msgArr)) {
                            msgArr.forEach(msg => toastr.error(msg));
                        } else {
                            toastr.error(msgArr);
                        }
                    });
                } else {
                    toastr.error(data.message);
                }
            }
        })
        .catch(error => {
            console.error('Error:', error);
            toastr.error('Error rescheduling appointment');
        })
        .finally(() => {
            // Re-enable button
            this.disabled = false;
            this.innerHTML = '<i class="fas fa-calendar-alt"></i> Reschedule Appointment';
        });
    });
});
</script>
@endsection