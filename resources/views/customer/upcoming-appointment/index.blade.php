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
    
    .reschedule-btn {
        padding: 6px 8px !important;
        font-size: 10px !important;
    }
    
    .reschedule-btn i {
        margin-right: 3px !important;
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
    
    .reschedule-btn {
        padding: 4px 6px !important;
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
        
        .reschedule-btn {
            padding: 6px 8px;
            font-size: 12px;
        }
        
        .reschedule-btn i {
            margin-right: 3px;
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
        
        .reschedule-btn {
            padding: 6px 10px;
            font-size: 11px;
        }
        
        /* Ensure modal content is properly sized on tablet */
        .custom-modal-content {
            width: 90%;
            max-width: 700px;
        }
        
        .calendar-container,
        .time-slots-container {
            max-height: 300px;
        }
        
        .calendar th, .calendar td {
            padding: 6px 3px;
            font-size: 11px;
        }
        
        .time-slot {
            padding: 6px 12px;
            font-size: 12px;
            min-width: 75px;
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
    
    .calendar-container,
    .time-slots-container {
        max-height: 250px;
        padding: 10px;
    }
    
    .calendar th, .calendar td {
        padding: 3px 1px;
        font-size: 12px;
    }
    
    .time-slot {
        padding: 4px 8px;
        font-size: 12px;
        min-width: 60px;
        margin: 2px;
    }
    
    /* Stack calendar and time slots vertically on mobile */
    .reschedule-modal .row {
        flex-direction: column;
    }
    
    .row .col-md-5,
    .row .col-md-7 {
        width: 100%;
        margin-bottom: 10px;
        padding: 0 5px;
    }
    
    /* Calendar navigation mobile fix */
    .calendar-navigation {
        padding: 5px;
        margin-bottom: 10px;
    }
    
    .calendar-navigation h5 {
        font-size: 14px;
    }
    
    .calendar-navigation button {
        width: 30px;
        height: 30px;
    }
    
    /* Alert mobile fix */
    .alert {
        padding: 8px;
        font-size: 12px;
        margin-bottom: 10px;
    }
    
    /* Form elements mobile fix */
    .form-control {
        font-size: 14px;
        padding: 8px;
    }
    
    .form-label {
        font-size: 13px;
        margin-bottom: 4px;
    }
    
    .form-text {
        font-size: 11px;
    }
}

/* Reschedule Modal Specific Improvements */
.reschedule-modal .custom-modal-content {
    max-width: 950px;
    width: 95%;
}

.reschedule-modal .custom-modal-body {
    max-height: calc(100vh - 160px);
    overflow-y: auto;
}

.reschedule-modal .row {
    margin: 0;
}

.reschedule-modal .col-md-5,
.reschedule-modal .col-md-7 {
    padding: 0 15px;
}

@media (max-width: 768px) {
    .reschedule-modal .col-md-5,
    .reschedule-modal .col-md-7 {
        padding: 0 5px;
        margin-bottom: 15px;
    }
}

/* Reschedule Modal Specific Styles */
.calendar-container {
    background: #f8f9fa;
    border-radius: 8px;
    padding: 15px;
    max-height: 350px;
    overflow-y: auto;
    border: 1px solid #dee2e6;
}

.calendar {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 0;
}

.calendar th, .calendar td {
    text-align: center;
    padding: 8px 4px;
    border: 1px solid #e9ecef;
    vertical-align: middle;
}

.calendar th {
    background-color: #007bff;
    color: white;
    font-weight: 600;
    font-size: 12px;
}

.calendar td {
    cursor: pointer;
    transition: all 0.2s ease;
    position: relative;
    height: 35px;
    font-size: 13px;
}

.calendar td:hover:not(.disabled):not(.other-month) {
    background-color: #e3f2fd;
    transform: scale(1.05);
}

.calendar td.disabled {
    background-color: #f8f9fa;
    color: #6c757d;
    cursor: not-allowed;
}

.calendar td.other-month {
    color: #ccc;
    background-color: #fafafa;
}

.calendar td.selected {
    background-color: #007bff;
    color: white;
    font-weight: bold;
}

.calendar td.today {
    background-color: #28a745;
    color: white;
    font-weight: bold;
}

.calendar td.available {
    background-color: #d4edda;
    border-color: #c3e6cb;
}

.calendar td.booked {
    background-color: #f8d7da;
    border-color: #f5c6cb;
    color: #721c24;
}

.time-slots-container {
    background: #f8f9fa;
    border-radius: 8px;
    padding: 15px;
    max-height: 350px;
    overflow-y: auto;
    border: 1px solid #dee2e6;
}

.time-slots-grid {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
    justify-content: flex-start;
}

.time-slot {
    display: inline-block;
    margin: 0;
    padding: 8px 16px;
    border: 2px solid #007bff;
    border-radius: 25px;
    background-color: white;
    color: #007bff;
    cursor: pointer;
    transition: all 0.3s ease;
    font-size: 14px;
    font-weight: 500;
    min-width: 80px;
    text-align: center;
}

.time-slot:hover {
    background-color: #007bff;
    color: white;
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0, 123, 255, 0.3);
}

.time-slot.selected {
    background-color: #007bff;
    color: white;
    box-shadow: 0 4px 8px rgba(0, 123, 255, 0.3);
}

.time-slot.booked {
    background-color: #6c757d;
    border-color: #6c757d;
    color: white;
    cursor: not-allowed;
    opacity: 0.6;
}

.time-slot.booked:hover {
    transform: none;
    box-shadow: none;
}

.calendar-navigation {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 15px;
    padding: 10px;
    background: white;
    border-radius: 8px;
    border: 1px solid #dee2e6;
}

.calendar-navigation button {
    background: #007bff;
    color: white;
    border: none;
    border-radius: 50%;
    width: 35px;
    height: 35px;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.2s ease;
}

.calendar-navigation button:hover {
    background: #0056b3;
    transform: scale(1.1);
}

.calendar-navigation h5 {
    margin: 0;
    color: #495057;
    font-weight: 600;
}

.alert {
    padding: 12px;
    border-radius: 8px;
    border: 1px solid;
    margin-bottom: 15px;
}

.alert-info {
    background-color: #d1ecf1;
    border-color: #bee5eb;
    color: #0c5460;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .calendar th, .calendar td {
        padding: 6px 2px;
        font-size: 11px;
    }
    
    .time-slot {
        padding: 6px 12px;
        font-size: 12px;
        margin: 3px;
    }
    
    .calendar-navigation {
        padding: 8px;
    }
    
    .calendar-navigation h5 {
        font-size: 16px;
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
                        <th>Plan Type</th>
                        <th>Sessions Taken</th>
                        <th>Sessions Remaining</th>
                        <th>Meet Link</th>
                        <th>Upload document</th>
                        <th>Professional document</th>
                        <th>Action</th>
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
                                <td>{{ \Carbon\Carbon::parse($upcomingTimedate->date)->format('d-m-Y') }}</td>
                                <td>{{ \Carbon\Carbon::parse($upcomingTimedate->date)->format('F') }}</td>
                                <td>{{ \Carbon\Carbon::parse($upcomingTimedate->date)->format('D') }}</td>
                                <td>{{ $upcomingTimedate->time_slot }}</td>
                                <td>{{ $booking->professional->name ?? 'Not Assigned' }}</td>
                                <td>
                                    @if($isFilteredService)
                                        <strong>{{ $booking->service_name }}</strong>
                                    @else
                                        {{ $booking->service_name }}
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
                                    <button type="button" 
                                            class="btn btn-sm btn-warning reschedule-btn" 
                                            data-booking-id="{{ $booking->id }}"
                                            data-timedate-id="{{ $upcomingTimedate->id }}"
                                            data-professional-id="{{ $booking->professional_id }}"
                                            data-professional-name="{{ $booking->professional->name ?? 'Not Assigned' }}"
                                            data-current-date="{{ $upcomingTimedate->date }}"
                                            data-current-time="{{ $upcomingTimedate->time_slot }}"
                                            title="Reschedule Appointment">
                                        <i class="fas fa-calendar-alt"></i> Reschedule
                                    </button>
                                </td>
                            </tr>
                        @endif
                    @empty
                        <tr>
                            <td colspan="14" class="text-center">No upcoming appointments found</td>
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

<!-- Reschedule Modal -->
<div id="rescheduleModal" class="custom-modal reschedule-modal">
    <div class="custom-modal-content">
        <div class="custom-modal-header">
            <h5 class="custom-modal-title">Reschedule Appointment</h5>
            <button type="button" class="custom-modal-close" onclick="closeModal('rescheduleModal')">&times;</button>
        </div>
        <div class="custom-modal-body">
            <div id="rescheduleInfo" class="mb-3">
                <div class="alert alert-info">
                    <strong>Current Appointment:</strong><br>
                    <span id="currentAppointmentDetails"></span>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-5 col-12 mb-3">
                    <h6>Select New Date</h6>
                    <div id="rescheduleCalendar" class="calendar-container">
                        <!-- Calendar will be dynamically generated here -->
                    </div>
                </div>
                <div class="col-md-7 col-12">
                    <h6>Available Time Slots</h6>
                    <div id="rescheduleTimeSlots" class="time-slots-container">
                        <p class="text-muted">Please select a date to view available time slots.</p>
                    </div>
                </div>
            </div>
            
            <form id="rescheduleForm">
                @csrf
                <input type="hidden" name="booking_id" id="rescheduleBookingId">
                <input type="hidden" name="timedate_id" id="rescheduleTimedateId">
                <input type="hidden" name="professional_id" id="rescheduleProfessionalId">
                <input type="hidden" name="new_date" id="rescheduleNewDate">
                <input type="hidden" name="new_time_slot" id="rescheduleNewTimeSlot">
            </form>
        </div>
        <div class="custom-modal-footer">
            <button type="button" class="btn btn-secondary" onclick="closeModal('rescheduleModal')">Cancel</button>
            <button type="button" class="btn btn-primary" id="confirmRescheduleBtn" disabled>Confirm Reschedule</button>
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
    let currentSelectedDate = null;
    let currentSelectedTimeSlot = null;
    let availabilityData = {};
    let bookedSlotsData = {};

    // Handle reschedule button click
    document.querySelectorAll('.reschedule-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const bookingId = this.dataset.bookingId;
            const timedateId = this.dataset.timedateId;
            const professionalId = this.dataset.professionalId;
            const professionalName = this.dataset.professionalName;
            const currentDate = this.dataset.currentDate;
            const currentTime = this.dataset.currentTime;

            // Reset selection
            currentSelectedDate = null;
            currentSelectedTimeSlot = null;
            
            // Store current appointment details for validation
            window.currentAppointment = {
                date: currentDate,
                time: currentTime
            };
            
            // Set form data
            document.getElementById('rescheduleBookingId').value = bookingId;
            document.getElementById('rescheduleTimedateId').value = timedateId;
            document.getElementById('rescheduleProfessionalId').value = professionalId;
            
            // Update current appointment details
            const formattedDate = new Date(currentDate).toLocaleDateString('en-GB', {
                weekday: 'long',
                year: 'numeric',
                month: 'long',
                day: 'numeric'
            });
            document.getElementById('currentAppointmentDetails').innerHTML = 
                `<strong>Professional:</strong> ${professionalName}<br>
                 <strong>Date:</strong> ${formattedDate}<br>
                 <strong>Time:</strong> ${currentTime}`;
            
            // Load availability data
            loadProfessionalAvailability(professionalId);
            
            // Reset confirm button
            document.getElementById('confirmRescheduleBtn').disabled = true;
            
            openModal('rescheduleModal');
        });
    });

    // Load professional availability
    function loadProfessionalAvailability(professionalId) {
        console.log('Loading availability for professional ID:', professionalId);
        
        // Validate professional ID
        if (!professionalId || professionalId === 'undefined' || professionalId === 'null') {
            console.error('Invalid professional ID:', professionalId);
            document.getElementById('rescheduleCalendar').innerHTML = `
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-triangle"></i>
                    Invalid professional ID. Please try again.
                </div>
            `;
            toastr.error('Invalid professional ID');
            return;
        }
        
        // Show loading state
        document.getElementById('rescheduleCalendar').innerHTML = `
            <div class="text-center p-4">
                <div class="spinner-border text-primary" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
                <p class="mt-2 text-muted">Loading availability...</p>
            </div>
        `;
        
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') 
                         || document.querySelector('input[name="_token"]')?.value 
                         || '{{ csrf_token() }}';
        
        console.log('Professional ID:', professionalId);
        console.log('CSRF Token available:', !!csrfToken);
        
        fetch(`/user/get-professional-availability/${professionalId}`, {
            method: 'GET',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': csrfToken,
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            }
        })
            .then(response => {
                console.log('Response status:', response.status);
                console.log('Response headers:', response.headers);
                
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                console.log('Availability API response:', data);
                console.log('Availability data type:', typeof data.availability);
                console.log('Availability data length:', data.availability ? data.availability.length : 'undefined');
                console.log('Booked slots data:', data.bookedSlots);
                
                if (data.success) {
                    availabilityData = data.availability;
                    bookedSlotsData = data.bookedSlots;
                    
                    console.log('Set availabilityData:', availabilityData);
                    console.log('Set bookedSlotsData:', bookedSlotsData);
                    
                    try {
                        generateCalendar(new Date());
                        console.log('Calendar generated successfully');
                    } catch (calendarError) {
                        console.error('Error generating calendar:', calendarError);
                        document.getElementById('rescheduleCalendar').innerHTML = `
                            <div class="alert alert-danger">
                                <i class="fas fa-exclamation-triangle"></i>
                                Error generating calendar: ${calendarError.message}
                            </div>
                        `;
                    }
                } else {
                    console.error('API returned error:', data.message);
                    document.getElementById('rescheduleCalendar').innerHTML = `
                        <div class="alert alert-danger">
                            <i class="fas fa-exclamation-triangle"></i>
                            ${data.message || 'Failed to load availability data'}
                        </div>
                    `;
                    toastr.error(data.message || 'Failed to load availability data');
                }
            })
            .catch(error => {
                console.error('Fetch error:', error);
                console.error('Error details:', {
                    message: error.message,
                    stack: error.stack
                });
                
                let errorMessage = 'Error loading availability data';
                if (error.message.includes('403')) {
                    errorMessage = 'Access denied. Please make sure you are logged in.';
                } else if (error.message.includes('404')) {
                    errorMessage = 'Professional availability data not found.';
                } else if (error.message.includes('500')) {
                    errorMessage = 'Server error occurred while loading availability.';
                }
                
                document.getElementById('rescheduleCalendar').innerHTML = `
                    <div class="alert alert-danger">
                        <i class="fas fa-exclamation-triangle"></i>
                        ${errorMessage}
                        <br><small class="text-muted">${error.message}</small>
                    </div>
                `;
                toastr.error(errorMessage);
            });
    }

    // Generate calendar
    function generateCalendar(date) {
        try {
            const year = date.getFullYear();
            const month = date.getMonth();
            const today = new Date();
            
            const calendarContainer = document.getElementById('rescheduleCalendar');
            
            // Create navigation
            const navigation = document.createElement('div');
            navigation.className = 'calendar-navigation';
            navigation.innerHTML = `
                <button type="button" onclick="changeMonth(-1)">
                    <i class="fas fa-chevron-left"></i>
                </button>
                <h5>${date.toLocaleDateString('en-US', { month: 'long', year: 'numeric' })}</h5>
                <button type="button" onclick="changeMonth(1)">
                    <i class="fas fa-chevron-right"></i>
                </button>
            `;
            
            // Create calendar table
            const table = document.createElement('table');
            table.className = 'calendar';
            
            // Create header
            const header = table.createTHead();
            const headerRow = header.insertRow();
            ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'].forEach(dayName => {
                const th = document.createElement('th');
                th.textContent = dayName;
                headerRow.appendChild(th);
            });
            
            // Create body
            const tbody = table.createTBody();
            
            const firstDay = new Date(year, month, 1);
            const lastDay = new Date(year, month + 1, 0);
            const startDate = new Date(firstDay);
            startDate.setDate(startDate.getDate() - firstDay.getDay());
            
            for (let week = 0; week < 6; week++) {
                const row = tbody.insertRow();
                
                for (let dayIndex = 0; dayIndex < 7; dayIndex++) {
                    const cellDate = new Date(startDate);
                    cellDate.setDate(startDate.getDate() + (week * 7) + dayIndex);
                    
                    const cell = row.insertCell();
                    cell.textContent = cellDate.getDate();
                    // Use local date string to avoid timezone issues
                    const cellYear = cellDate.getFullYear();
                    const cellMonth = String(cellDate.getMonth() + 1).padStart(2, '0');
                    const cellDay = String(cellDate.getDate()).padStart(2, '0');
                    cell.dataset.date = `${cellYear}-${cellMonth}-${cellDay}`;
                    
                    // Add classes based on date properties
                    if (cellDate.getMonth() !== month) {
                        cell.classList.add('other-month');
                    } else if (cellDate.toDateString() === today.toDateString()) {
                        cell.classList.add('today');
                    } else if (cellDate < today) {
                        cell.classList.add('disabled');
                    } else if (isDateAvailable(cellDate)) {
                        cell.classList.add('available');
                    } else {
                        cell.classList.add('disabled');
                    }
                    
                    // Add click event for available dates
                    if (!cell.classList.contains('disabled') && !cell.classList.contains('other-month')) {
                        cell.style.cursor = 'pointer';
                        cell.addEventListener('click', function() {
                            selectDate(cellDate, this);
                        });
                    }
                }
            }
            
            // Clear and add to container
            calendarContainer.innerHTML = '';
            calendarContainer.appendChild(navigation);
            calendarContainer.appendChild(table);
            
            // Store current date for navigation
            window.currentCalendarDate = date;
            
        } catch (error) {
            console.error('Error generating calendar:', error);
            document.getElementById('rescheduleCalendar').innerHTML = `
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-triangle"></i>
                    Error generating calendar: ${error.message}
                </div>
            `;
        }
    }

    // Check if date is available
    function isDateAvailable(date) {
        try {
            // Use local date string to avoid timezone issues
            const year = date.getFullYear();
            const month = String(date.getMonth() + 1).padStart(2, '0');
            const day = String(date.getDate()).padStart(2, '0');
            const dateStr = `${year}-${month}-${day}`;
            // Get day name in 3-letter format to match database storage
            const dayNames = ['sun', 'mon', 'tue', 'wed', 'thu', 'fri', 'sat'];
            const dayName = dayNames[date.getDay()]; // 0 = Sunday, 1 = Monday, etc.
            const monthNumber = date.getMonth() + 1; // 1-12
            
            console.log('Checking availability for date:', {
                date: date,
                dateStr: dateStr,
                dayName: dayName,
                monthNumber: monthNumber,
                availabilityDataLength: availabilityData.length
            });
            
            if (!availabilityData || availabilityData.length === 0) {
                console.log('No availability data available');
                return false;
            }
            
            // Check if professional has availability for this day and month
            const isAvailable = availabilityData.some(availability => {
                const availableMonth = availability.month_number;
                const availableDays = availability.weekdays || [];
                
                const monthMatch = availableMonth === monthNumber;
                const dayMatch = availableDays.includes(dayName);
                const hasSlots = availability.slots && availability.slots.length > 0;
                
                console.log('Checking availability record:', {
                    availableMonth: availableMonth,
                    availableDays: availableDays,
                    monthMatch: monthMatch,
                    dayMatch: dayMatch,
                    hasSlots: hasSlots
                });
                
                return monthMatch && dayMatch && hasSlots;
            });
            
            console.log('Date availability result:', isAvailable);
            return isAvailable;
        } catch (error) {
            console.error('Error in isDateAvailable:', error);
            return false;
        }
    }

    // Select date
    function selectDate(date, cell) {
        // Remove previous selection
        document.querySelectorAll('.calendar td.selected').forEach(td => {
            td.classList.remove('selected');
        });
        
        // Add selection to clicked cell
        cell.classList.add('selected');
        
        // Format date safely without timezone issues
        const year = date.getFullYear();
        const month = String(date.getMonth() + 1).padStart(2, '0');
        const day = String(date.getDate()).padStart(2, '0');
        currentSelectedDate = `${year}-${month}-${day}`;
        
        console.log('Selected date:', {
            originalDate: date,
            formattedDate: currentSelectedDate,
            dateDisplay: date.toDateString()
        });
        
        // Load time slots for selected date
        loadTimeSlots(date);
        
        // Update form
        document.getElementById('rescheduleNewDate').value = currentSelectedDate;
        
        // Reset time slot selection
        currentSelectedTimeSlot = null;
        document.getElementById('rescheduleNewTimeSlot').value = '';
        document.getElementById('confirmRescheduleBtn').disabled = true;
    }

    // Load time slots for selected date
    function loadTimeSlots(date) {
        const container = document.getElementById('rescheduleTimeSlots');
        // Use same day name format as isDateAvailable function
        const dayNames = ['sun', 'mon', 'tue', 'wed', 'thu', 'fri', 'sat'];
        const dayName = dayNames[date.getDay()];
        const monthNumber = date.getMonth() + 1; // 1-12
        // Use local date string to avoid timezone issues
        const year = date.getFullYear();
        const month = String(date.getMonth() + 1).padStart(2, '0');
        const day = String(date.getDate()).padStart(2, '0');
        const dateStr = `${year}-${month}-${day}`;
        
        console.log('Loading time slots for:', {
            selectedDate: date,
            dayName: dayName,
            monthNumber: monthNumber,
            dateStr: dateStr
        });
        
        // Find availability for this day and month
        const relevantAvailability = availabilityData.find(availability => {
            const availableMonth = availability.month_number;
            const availableDays = availability.weekdays || [];
            
            return availableMonth === monthNumber && availableDays.includes(dayName);
        });
        
        console.log('Found availability:', relevantAvailability);
        
        if (!relevantAvailability || !relevantAvailability.slots || relevantAvailability.slots.length === 0) {
            container.innerHTML = '<p class="text-muted">No time slots available for this date.</p>';
            return;
        }
        
        const bookedSlots = bookedSlotsData[dateStr] || [];
        
        let slotsHtml = '<div class="time-slots-grid">';
        relevantAvailability.slots.forEach(slot => {
            const isBooked = bookedSlots.includes(slot.time);
            const slotClass = isBooked ? 'time-slot booked' : 'time-slot';
            const disabled = isBooked ? 'disabled' : '';
            
            slotsHtml += `
                <button type="button" 
                        class="${slotClass}" 
                        data-time="${slot.time}"
                        ${disabled}
                        onclick="selectTimeSlot('${slot.time}', this)">
                    ${slot.time}
                </button>
            `;
        });
        slotsHtml += '</div>';
        
        container.innerHTML = slotsHtml;
    }

    // Select time slot
    window.selectTimeSlot = function(timeSlot, button) {
        if (button.classList.contains('booked')) {
            return;
        }
        
        // Remove previous selection
        document.querySelectorAll('.time-slot.selected').forEach(slot => {
            slot.classList.remove('selected');
        });
        
        // Add selection to clicked slot
        button.classList.add('selected');
        currentSelectedTimeSlot = timeSlot;
        
        // Update form
        document.getElementById('rescheduleNewTimeSlot').value = timeSlot;
        
        // Enable confirm button
        document.getElementById('confirmRescheduleBtn').disabled = false;
    };

    // Change month navigation
    window.changeMonth = function(direction) {
        const currentDate = window.currentCalendarDate || new Date();
        const newDate = new Date(currentDate.getFullYear(), currentDate.getMonth() + direction, 1);
        generateCalendar(newDate);
    };

    // Handle confirm reschedule
    document.getElementById('confirmRescheduleBtn').addEventListener('click', function() {
        if (!currentSelectedDate || !currentSelectedTimeSlot) {
            toastr.error('Please select both date and time slot');
            return;
        }
        
        // Check if user is trying to reschedule to the same date and time
        if (window.currentAppointment && 
            currentSelectedDate === window.currentAppointment.date && 
            currentSelectedTimeSlot === window.currentAppointment.time) {
            toastr.warning('Please select a different date or time for rescheduling');
            return;
        }
        
        const formData = new FormData(document.getElementById('rescheduleForm'));
        
        // Debug: Log what's being sent
        console.log('Reschedule data being sent:', {
            booking_id: formData.get('booking_id'),
            timedate_id: formData.get('timedate_id'),
            professional_id: formData.get('professional_id'),
            new_date: formData.get('new_date'),
            new_time_slot: formData.get('new_time_slot'),
            current_appointment: window.currentAppointment
        });
        
        // Disable button and show loading state
        this.disabled = true;
        this.innerHTML = '<span class="spinner-border spinner-border-sm" role="status"></span> Rescheduling...';
        
        fetch('{{ route("user.upcoming-appointment.reschedule") }}', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            console.log('Reschedule response:', data);
            if (data.success) {
                toastr.success(data.message);
                if (data.data) {
                    console.log('Update details:', data.data);
                }
                setTimeout(() => {
                    window.location.reload();
                }, 1500);
            } else {
                toastr.error(data.message || 'Failed to reschedule appointment');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            toastr.error('Error rescheduling appointment');
        })
        .finally(() => {
            this.disabled = false;
            this.innerHTML = 'Confirm Reschedule';
        });
    });

    // Close reschedule modal when clicking outside
    document.getElementById('rescheduleModal').addEventListener('click', function(event) {
        if (event.target === this) {
            closeModal('rescheduleModal');
        }
    });
});
</script>
@endsection
