@extends('professional.layout.layout')

@section('styles')
<style>

 .btn-download.customer-invoice {
        background: linear-gradient(135deg, #48bb78 0%, #38a169 100%);
        font-size: 0.75rem;
        padding: 0.5rem 1rem;
        min-width: 120px;
    }

    .btn-download.customer-invoice:hover {
        box-shadow: 0 8px 25px rgba(72, 187, 120, 0.3);
        background: linear-gradient(135deg, #38a169 0%, #2f855a 100%);
    }
    
    .btn-download.view-invoice {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }
    
    .btn-download.view-invoice:hover {
        background: linear-gradient(135deg, #5a6fd8 0%, #6b46c1 100%);
        box-shadow: 0 8px 25px rgba(102, 126, 234, 0.3);
    }

    /* Invoice button styling */
    .btn-download {
        background-color: #17a2b8;
        color: white;
        border: none;
        border-radius: 0.25rem;
        padding: 0.6rem;
        font-size: 0.75rem;
        cursor: pointer;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        margin: 2px;
        transition: all 0.2s;
        white-space: nowrap;
        width: 40px;
        height: 40px;
        text-align: center;
        position: relative;
    }
    
    .btn-download i {
        font-size: 1rem;
        margin: 0;
        flex-shrink: 0;
    }
    
    .btn-download.view-invoice i {
        font-size: 0.95rem;
    }
    
    /* Tooltip for buttons */
    .btn-download::after {
        content: attr(data-tooltip);
        position: absolute;
        bottom: 120%;
        left: 50%;
        transform: translateX(-50%);
        background-color: #333;
        color: white;
        padding: 0.5rem 0.75rem;
        border-radius: 0.25rem;
        font-size: 0.75rem;
        white-space: nowrap;
        opacity: 0;
        visibility: hidden;
        transition: opacity 0.3s;
        z-index: 1000;
        pointer-events: none;
    }
    
    .btn-download::before {
        content: '';
        position: absolute;
        bottom: 110%;
        left: 50%;
        transform: translateX(-50%);
        border: 5px solid transparent;
        border-top-color: #333;
        opacity: 0;
        visibility: hidden;
        transition: opacity 0.3s;
        z-index: 1000;
        pointer-events: none;
    }
    
    .btn-download:hover::after,
    .btn-download:hover::before {
        opacity: 1;
        visibility: visible;
    }

    .btn-download:hover {
        background-color: #138496;
        color: white;
        text-decoration: none;
    }

    /* Invoice cell styling */
    .invoice-cell {
        min-width: 100px;
        padding: 0.5rem !important;
        text-align: center;
    }

    .invoice-cell .btn-download {
        margin: 2px;
        display: inline-flex;
    }

    .invoice-cell .btn-download:last-child {
        margin: 2px;
    }
    /* Core layout */
    .content-wrapper {
        background-color: #f8f9fa;
        padding: 1.5rem;
        min-height: calc(100vh - 60px);
    }
    
    .page-header {
        margin-bottom: 1.5rem;
    }
    
    .page-title h3 {
        font-size: 1.5rem;
        font-weight: 600;
        margin-bottom: 0.5rem;
        color: #333;
    }

    /* Card styling */
    .card {
        background-color: #fff;
        border-radius: 0.5rem;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        margin-bottom: 1.5rem;
    }

    /* Table styling */
    .table-wrapper {
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
        width: 100%;
        max-width: 100%;
    }
    
    .data-table {
        width: 100%;
        min-width: 1200px; /* Forces horizontal scroll on smaller screens */
        border-collapse: collapse;
        font-size: 0.875rem;
    }
    
    .data-table th,
    .data-table td {
        padding: 0.75rem;
        border: 1px solid #e9ecef;
        vertical-align: middle;
    }
    
    .data-table th {
        background-color: #e2e8f0;
        color: black;
        font-weight: 600;
        white-space: nowrap;
    }
    
    .data-table td {
        color: #495057;
    }

    /* Search container */
    .search-container {
        background: #fff;
        padding: 1.25rem;
        border-radius: 0.5rem;
        margin-bottom: 1.5rem;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
    }
    
    .search-form {
        display: flex;
        flex-wrap: wrap;
        gap: 1rem;
    }
    
    .search-form .form-group {
        flex: 1;
        min-width: 200px;
    }
    
    .search-form label {
        display: block;
        font-weight: 500;
        margin-bottom: 0.5rem;
        color: #495057;
        font-size: 0.875rem;
    }
    
    .search-form select,
    .search-form input {
        width: 100%;
        padding: 0.5rem;
        border: 1px solid #ced4da;
        border-radius: 0.25rem;
        background-color: white;
        color: #495057;
        font-size: 0.875rem;
    }
    
    .search-buttons {
        display: flex;
        gap: 0.75rem;
        /* margin-top: 1.5rem; */
        margin-bottom: 23px;
        align-items: flex-end;
    }

    /* Buttons */
    .btn-primary {
        background-color: #2fcc4e;
        color: white;
        border: none;
        border-radius: 0.25rem;
        padding: 0.5rem 1rem;
        font-size: 0.875rem;
        cursor: pointer;
        transition: background-color 0.2s;
    }
    
    .btn-secondary {
        background-color: #6c757d;
        color: white;
        border: none;
        border-radius: 0.25rem;
        padding: 0.5rem 1rem;
        font-size: 0.875rem;
        cursor: pointer;
        text-decoration: none;
        display: inline-block;
        transition: background-color 0.2s;
    }
    
    .btn-info {
        background-color: #17a2b8;
        color: white;
        border: none;
        border-radius: 0.25rem;
        padding: 0.25rem 0.5rem;
        font-size: 0.75rem;
        cursor: pointer;
    }
    
    .btn-link {
        background-color: #5a67d8;
        color: white;
        text-decoration: none;
        border-radius: 0.25rem;
        padding: 0.25rem 0.5rem;
        font-size: 0.75rem;
        display: inline-block;
    }
    
    .btn-primary:hover { background-color: #4c51bf; }
    .btn-secondary:hover { background-color: #5a6268; }
    .btn-info:hover { background-color: #138496; }
    .btn-link:hover { background-color: #434190; }

    /* Status badges */
    .badge {
        display: inline-block;
        padding: 0.25rem 0.5rem;
        font-size: 0.75rem;
        font-weight: 500;
        border-radius: 1rem;
        text-transform: uppercase;
    }
    
    .bg-success { background-color: #48bb78 !important; color: white; }
    .bg-danger { background-color: #f56565 !important; color: white; }
    
    /* Plan type badges */
    .badge-monthly { background-color: #667eea; color: white; }
    .badge-quarterly { background-color: #9f7aea; color: white; }
    .badge-yearly { background-color: #48bb78; color: white; }
    .badge-one-time { background-color: #4299e1; color: white; }
    .badge-free-hand { background-color: #ed8936; color: white; }

    /* Transaction ID styling */
    .transaction-id {
        font-family: 'Courier New', monospace;
        background-color: #f8f9fa;
        padding: 0.25rem 0.5rem;
        border-radius: 0.25rem;
        border: 1px solid #e2e8f0;
        font-size: 0.75rem;
    }

    /* Amount styling */
    .amount {
        font-weight: 600;
    }
    
    .net-amount {
        color: #48bb78;
    }
    
    .deduction {
        color: #e53e3e;
        font-weight: 600;
    }
    
    .margin-badge {
        background-color: #ed8936;
        color: white;
        padding: 0.25rem 0.5rem;
        border-radius: 0.25rem;
        font-size: 0.75rem;
        display: inline-block;
    }

    /* Total row styling */
    .total-row {
        background-color: #f8fafc !important;
        font-weight: 700;
    }
    
    .total-row td {
        border-top: 2px solid #5a67d8 !important;
        color: #2d3748 !important;
    }

    /* Responsive styles */
    @media screen and (max-width: 767px) {
        .content-wrapper {
            padding: 1rem 0.5rem;
        }
        
        .page-title h3 {
            font-size: 1.25rem;
        }
        
        .search-container {
            margin-bottom: 1rem;
            padding: 1rem;
        }
        
        .search-form {
            flex-direction: column;
            gap: 0.75rem;
        }
        
        .search-form .form-group {
            width: 100%;
            min-width: auto;
        }
        
        .search-form label {
            font-size: 0.9rem;
            margin-bottom: 0.25rem;
        }
        
        .search-form select,
        .search-form input {
            padding: 0.75rem;
            font-size: 0.9rem;
            border-radius: 0.375rem;
        }
        
        .search-buttons {
            flex-direction: column;
            width: 100%;
            gap: 0.5rem;
        }
        
        .search-buttons button,
        .search-buttons a {
            width: 100%;
            margin-bottom: 0;
        }
        
        /* Mobile card layout for table */
        .table-wrapper {
            overflow: visible;
        }
        
        .data-table {
            display: block;
            width: 100%;
            min-width: auto;
            border: none;
        }
        
        .data-table thead {
            display: none;
        }
        
        .data-table tbody {
            display: block;
        }
        
        .data-table tbody tr {
            display: block;
            margin-bottom: 1.5rem;
            border: 1px solid #e2e8f0;
            border-radius: 0.5rem;
            padding: 1rem;
            background: white;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        
        .data-table tbody tr:last-of-type:not(.total-row) {
            margin-bottom: 0;
        }
        
        .data-table tbody td {
            display: block;
            padding: 0.5rem 0;
            border: none;
            border-bottom: 1px solid #f1f5f9;
            text-align: left;
        }
        
        .data-table tbody td:last-child {
            border-bottom: none;
        }
        
        .data-table tbody td::before {
            content: attr(data-label) ": ";
            font-weight: 600;
            color: #4a5568;
            display: inline-block;
            width: 100%;
            margin-bottom: 0.25rem;
        }
        
        /* Mobile invoice buttons */
        .invoice-cell {
            min-width: auto;
            padding: 0.5rem 0 !important;
            text-align: center;
        }
        
        .invoice-cell .btn-download {
            width: 45px;
            height: 45px;
            margin: 0.25rem;
            padding: 0.75rem;
            font-size: 0.875rem;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }
        
        .invoice-cell .btn-download:last-child {
            margin: 0.25rem;
        }
        
        .invoice-cell .btn-download i {
            font-size: 1.1rem;
            margin: 0;
        }
        
        /* Mobile badges */
        .badge {
            padding: 0.5rem 0.75rem;
            font-size: 0.75rem;
        }
        
        /* Mobile amounts */
        .amount {
            font-size: 1rem;
            font-weight: 700;
        }
        
        /* Hide total row on mobile or make it simpler */
        .total-row {
            display: none !important;
        }
        
        /* Mobile totals summary */
        .mobile-totals {
            display: block;
            background: #f8fafc;
            padding: 1rem;
            border-radius: 0.5rem;
            margin-top: 1rem;
            border: 1px solid #e2e8f0;
        }
        
        .mobile-totals h4 {
            margin-bottom: 0.75rem;
            color: #2d3748;
            font-size: 1.1rem;
            text-align: center;
        }
        
        .mobile-totals .total-item {
            display: flex;
            justify-content: space-between;
            padding: 0.5rem 0;
            border-bottom: 1px solid #e2e8f0;
        }
        
        .mobile-totals .total-item:last-child {
            border-bottom: none;
            font-weight: 700;
            color: #48bb78;
            background: rgba(72, 187, 120, 0.1);
            padding: 0.75rem;
            border-radius: 0.25rem;
            margin-top: 0.5rem;
        }
        
        .mobile-totals .total-item.deduction {
            color: #e53e3e;
            font-weight: 600;
        }
        
        /* Empty state mobile */
        .text-center {
            padding: 2rem 1rem !important;
            font-size: 1rem;
        }
    }
    
    /* Hide mobile totals on desktop */
    .mobile-totals {
        display: none;
    }

    @media screen and (min-width: 768px) and (max-width: 1024px) {
        .search-form {
            flex-wrap: wrap;
        }
        
        .search-form .form-group {
            min-width: 48%;
            flex: 0 0 48%;
        }
        
        .search-buttons {
            width: 100%;
            justify-content: flex-start;
        }
        
        .table-wrapper {
            overflow-x: auto;
        }
        
    }
</style>
@endsection

@section('content')
<div class="content-wrapper">
    <div class="page-header">
        <div class="page-title">
            <h3>All Billing</h3>
        </div>
        <ul class="breadcrumb">
            <li>Home</li>
            <li class="active">All Billing</li>
        </ul>
    </div>

    <!-- Commission & Service Request Settings -->
    <div class="card-box" style="margin-bottom: 2rem; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border-radius: 15px; padding: 2rem; box-shadow: 0 10px 30px rgba(102, 126, 234, 0.3);">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
            <h4 style="margin: 0; color: white; font-weight: 700; font-size: 1.25rem;">
                <i class="fas fa-percentage" style="margin-right: 0.5rem;"></i>
                Commission & Service Request Settings
            </h4>
            <span style="font-size: 0.875rem; opacity: 0.9;">Your current earning rates</span>
        </div>
        
        <div class="row">
            <div class="col-md-4">
                <div style="background: rgba(255, 255, 255, 0.15); backdrop-filter: blur(10px); border-radius: 12px; padding: 1.5rem; text-align: center; border: 1px solid rgba(255, 255, 255, 0.2);">
                    <div style="font-size: 0.75rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 0.5rem; opacity: 0.9;">
                        <i class="fas fa-handshake" style="margin-right: 0.25rem;"></i>
                        Regular Session Margin
                    </div>
                    <div style="font-size: 2rem; font-weight: 800; margin-bottom: 0.5rem;">
                        {{ number_format($marginPercentage ?? 0, 2) }}%
                    </div>
                    <div style="font-size: 0.75rem; opacity: 0.8;">
                        Platform commission on regular bookings
                    </div>
                </div>
            </div>
            
            <div class="col-md-4">
                <div style="background: rgba(255, 255, 255, 0.15); backdrop-filter: blur(10px); border-radius: 12px; padding: 1.5rem; text-align: center; border: 1px solid rgba(255, 255, 255, 0.2);">
                    <div style="font-size: 0.75rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 0.5rem; opacity: 0.9;">
                        <i class="fas fa-plus-circle" style="margin-right: 0.25rem;"></i>
                        Service Request Margin
                    </div>
                    <div style="font-size: 2rem; font-weight: 800; margin-bottom: 0.5rem;">
                        {{ number_format(auth('professional')->user()->service_request_margin ?? 0, 2) }}%
                    </div>
                    <div style="font-size: 0.75rem; opacity: 0.8;">
                        Platform commission on additional services
                    </div>
                </div>
            </div>
            
            <div class="col-md-4">
                <div style="background: rgba(255, 255, 255, 0.15); backdrop-filter: blur(10px); border-radius: 12px; padding: 1.5rem; text-align: center; border: 1px solid rgba(255, 255, 255, 0.2);">
                    <div style="font-size: 0.75rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 0.5rem; opacity: 0.9;">
                        <i class="fas fa-arrows-alt-v" style="margin-right: 0.25rem;"></i>
                        Negotiation Offset
                    </div>
                    <div style="font-size: 2rem; font-weight: 800; margin-bottom: 0.5rem;">
                        {{ number_format(auth('professional')->user()->service_request_offset ?? 0, 2) }}%
                    </div>
                    <div style="font-size: 0.75rem; opacity: 0.8;">
                        Max discount customers can negotiate
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Earnings Calculator -->
        <div style="margin-top: 2rem; padding: 1.5rem; background: rgba(255, 255, 255, 0.1); border-radius: 12px; border: 1px solid rgba(255, 255, 255, 0.2);">
            <h5 style="margin: 0 0 1rem 0; color: white; font-weight: 600; font-size: 1rem;">
                <i class="fas fa-calculator" style="margin-right: 0.5rem;"></i>
                Earnings Example (₹1000 Service)
            </h5>
            
            <div class="row">
                <div class="col-md-4">
                    <div style="text-align: center;">
                        <div style="font-size: 0.75rem; margin-bottom: 0.5rem; opacity: 0.9;">Regular Session - You Earn</div>
                        <div style="font-size: 1.5rem; font-weight: 700; color: #48bb78;">
                            ₹{{ number_format(1000 - (1000 * ($marginPercentage ?? 0) / 100), 2) }}
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div style="text-align: center;">
                        <div style="font-size: 0.75rem; margin-bottom: 0.5rem; opacity: 0.9;">Service Request - You Earn</div>
                        <div style="font-size: 1.5rem; font-weight: 700; color: #48bb78;">
                            ₹{{ number_format(1000 - (1000 * (auth('professional')->user()->service_request_margin ?? 0) / 100), 2) }}
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div style="text-align: center;">
                        <div style="font-size: 0.75rem; margin-bottom: 0.5rem; opacity: 0.9;">Min Customer Can Pay</div>
                        <div style="font-size: 1.5rem; font-weight: 700; color: #fbb042;">
                            ₹{{ number_format(1000 - (1000 * (auth('professional')->user()->service_request_offset ?? 0) / 100), 2) }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="search-container">
        <form action="{{ route('professional.billing.index') }}" method="GET" class="search-form">
            <div class="form-group">
                <label for="search_date_from">From Date</label>
                <input type="date" name="search_date_from" value="{{ request('search_date_from') }}">
            </div>

            <div class="form-group">
                <label for="search_date_to">To Date</label>
                <input type="date" name="search_date_to" value="{{ request('search_date_to') }}">
            </div>

            <div class="form-group">
                <label for="plan_type">Plan Type</label>
                <select name="plan_type" id="plan_type" class="form-control">
                    <option value="">All Plans</option>
                    <option value="monthly" {{ request('plan_type') == 'monthly' ? 'selected' : '' }}>Monthly</option>
                    <option value="quarterly" {{ request('plan_type') == 'quarterly' ? 'selected' : '' }}>Quarterly</option>
                    <option value="free_hand" {{ request('plan_type') == 'free_hand' ? 'selected' : '' }}>Free Hand</option>
                    <option value="one_time" {{ request('plan_type') == 'one_time' ? 'selected' : '' }}>One Time</option>
                </select>
            </div>

            <div class="form-group">
                <label for="payment_status">Payment Status</label>
                <select name="payment_status" id="payment_status" class="form-control">
                    <option value="">All Status</option>
                    <option value="paid" {{ request('payment_status') == 'paid' ? 'selected' : '' }}>Paid</option>
                    <option value="unpaid" {{ request('payment_status') == 'unpaid' ? 'selected' : '' }}>Unpaid</option>
                </select>
            </div>

            <div class="search-buttons">
                <button type="submit" class="btn-primary">Apply Filters</button>
                <a href="{{ route('professional.billing.index') }}" class="btn-secondary">Reset</a>
            </div>
        </form>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="table-wrapper">
                @if($bookings->isEmpty())
                    <div class="text-center py-5 text-muted">
                        <p>No billing records available.</p>
                    </div>
                @else
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Customer Name</th>
                                <th>Session Type</th>
                                <th>Month</th>
                                <th>Customer Amount</th>
                                <th>Platform Fee</th>
                                <th>GST (18%)</th>
                                <th>Total Deduction</th>
                                <th>Professional Earning</th>
                                <th>Status</th>
                                <th>Professional Invoice</th>
                                <th>Customer Invoice</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($bookings as $booking)
                            <tr>
                                <td data-label="Customer Name">{{ $booking->customer_name }}</td>
                                <td data-label="Session Type">
                                    <span class="badge badge-{{ str_replace('_', '-', strtolower($booking->plan_type)) }}">
                                        {{ ucwords(str_replace('_', ' ', $booking->plan_type)) }}
                                    </span>
                                </td>
                                <td data-label="Month">{{ $booking->month }}</td>
                                <td data-label="Customer Amount" class="amount">₹{{ number_format($booking->customer_amount, 2) }}</td>
                                <td data-label="Platform Fee" class="amount">₹{{ number_format($booking->platform_fee, 2) }}</td>
                                <td data-label="GST (18%)" class="amount">₹{{ number_format($booking->platform_cgst + $booking->platform_sgst, 2) }}</td>
                                <td data-label="Total Deduction" class="amount deduction">₹{{ number_format($booking->total_platform_cut, 2) }}</td>
                                <td data-label="Professional Earning" class="amount net-amount">₹{{ number_format($booking->professional_earning, 2) }}</td>
                                <td data-label="Status">
                                    <span class="badge bg-{{ $booking->paid_status == 'paid' ? 'success' : 'danger' }}">
                                        {{ ucfirst($booking->paid_status ?? 'unpaid') }}
                                    </span>
                                </td>
                                <td data-label="Prof. Invoice" class="invoice-cell">
                                    <a href="{{ route('professional.billing.download-invoice', ['booking' => $booking->id]) }}" class="btn-download">
                                        <i class="fas fa-file-pdf"></i>
                                    </a>
                                </td>
                                <td data-label="Customer Invoice" class="invoice-cell">
                                    <a href="{{ route('professional.billing.customer-invoice.view', ['booking' => $booking->id]) }}" class="btn-download customer-invoice view-invoice" target="_blank">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('professional.billing.customer-invoice.download', ['booking' => $booking->id]) }}" class="btn-download customer-invoice">
                                        <i class="fas fa-file-pdf"></i>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                            <tr class="total-row">
                                <td colspan="3"><strong>Total Billing:</strong></td>
                                <td class="amount"><strong>₹{{ number_format($totalGrossAmount, 2) }}</strong></td>
                                <td class="amount"><strong>₹{{ number_format($bookings->sum('platform_fee'), 2) }}</strong></td>
                                <td class="amount"><strong>₹{{ number_format($bookings->sum('platform_cgst') + $bookings->sum('platform_sgst'), 2) }}</strong></td>
                                <td class="amount deduction"><strong>₹{{ number_format($bookings->sum('total_platform_cut'), 2) }}</strong></td>
                                <td class="amount net-amount"><strong>₹{{ number_format($bookings->sum('professional_earning'), 2) }}</strong></td>
                                <td colspan="3"></td>
                            </tr>
                        </tbody>
                    </table>
                @endif
            </div>
            
            <!-- Mobile Totals Summary -->
            <div class="mobile-totals">
                <h4>Billing Summary</h4>
                <div class="total-item">
                    <span>Total Customer Amount:</span>
                    <span class="amount">₹{{ number_format($totalGrossAmount, 2) }}</span>
                </div>
                <div class="total-item">
                    <span>Total Platform Fee:</span>
                    <span class="amount">₹{{ number_format($bookings->sum('platform_fee'), 2) }}</span>
                </div>
                <div class="total-item">
                    <span>Total GST (18%):</span>
                    <span class="amount">₹{{ number_format($bookings->sum('platform_cgst') + $bookings->sum('platform_sgst'), 2) }}</span>
                </div>
                <div class="total-item deduction">
                    <span>Total Deduction:</span>
                    <span class="amount">₹{{ number_format($bookings->sum('total_platform_cut'), 2) }}</span>
                </div>
                <div class="total-item">
                    <span>Your Total Earning:</span>
                    <span class="amount">₹{{ number_format($bookings->sum('professional_earning'), 2) }}</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Add any necessary JavaScript here
</script>
@endsection