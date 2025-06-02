@extends('professional.layout.layout')

@section('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<style>
    :root {
        --primary: #4f46e5;
        --primary-dark: #4338ca;
        --primary-rgb: 79, 70, 229;
        --gray-100: #f3f4f6;
        --gray-200: #e5e7eb;
        --gray-300: #d1d5db;
        --gray-400: #9ca3af;
        --gray-500: #6b7280;
        --gray-600: #4b5563;
        --gray-700: #374151;
        --gray-800: #1f2937;
        --gray-900: #111827;
    }
  
    /* Date Picker and Filter Styling */
    .filter-section {
        background-color: white;
        border-radius: 12px;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03);
        padding: 20px;
        margin-bottom: 30px;
    }

    .filter-group {
        margin-bottom: 15px;
    }

    .filter-label {
        display: block;
        font-size: 0.875rem;
        font-weight: 500;
        color: var(--gray-700);
        margin-bottom: 6px;
    }

    .filter-input {
        width: 100%;
        padding: 10px 12px;
        border: 1px solid var(--gray-300);
        border-radius: 6px;
        font-size: 0.9375rem;
        transition: all 0.2s;
    }

    .filter-input:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(var(--primary-rgb), 0.1);
        outline: none;
    }

    .filter-btn {
        background-color: var(--primary);
        color: white;
        border: none;
        border-radius: 6px;
        padding: 10px 18px;
        font-size: 0.9375rem;
        font-weight: 500;
        cursor: pointer;
        transition: background-color 0.2s ease;
    }

    .filter-btn:hover {
        background-color: var(--primary-dark);
    }

    .filter-btn.reset {
        background-color: var(--gray-200);
        color: var(--gray-700);
    }

    .filter-btn.reset:hover {
        background-color: var(--gray-300);
    }

    /* Date picker customization */
    .flatpickr-calendar {
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05) !important;
        border-radius: 10px !important;
    }

    .flatpickr-day.selected, 
    .flatpickr-day.startRange, 
    .flatpickr-day.endRange, 
    .flatpickr-day.selected.inRange, 
    .flatpickr-day.startRange.inRange, 
    .flatpickr-day.endRange.inRange, 
    .flatpickr-day.selected:focus, 
    .flatpickr-day.startRange:focus, 
    .flatpickr-day.endRange:focus, 
    .flatpickr-day.selected:hover, 
    .flatpickr-day.startRange:hover, 
    .flatpickr-day.endRange:hover {
        background: var(--primary) !important;
        border-color: var(--primary) !important;
    }

    /* Transaction number styling */
    .transaction-number {
        font-family: monospace;
        padding: 4px 8px;
        background: #f7fafc;
        border-radius: 4px;
        border: 1px solid #e2e8f0;
        font-size: 0.85rem;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        max-width: 150px;
        display: inline-block;
        text-align: center;
    }

    /* Status badges */
    .status-badge {
        padding: 6px 12px;
        border-radius: 9999px;
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }

    .status-paid {
        background-color: rgba(72, 187, 120, 0.1);
        color: #48bb78;
    }

    .status-unpaid {
        background-color: rgba(237, 100, 88, 0.1);
        color: #ed645c;
    }

    .content-wrapper {
        background-color: #f8fafc;
        min-height: calc(100vh - 60px);
        padding: 30px;
    }

    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 30px;
        flex-wrap: wrap;
        gap: 15px;
    }

    .page-title h3 {
        font-size: 1.75rem;
        font-weight: 700;
        color: var(--gray-800);
        margin: 0;
        position: relative;
        padding-left: 15px;
    }

    .page-title h3::before {
        content: '';
        position: absolute;
        left: 0;
        top: 5px;
        bottom: 5px;
        width: 4px;
        background: var(--primary);
        border-radius: 4px;
    }

    .breadcrumb {
        display: flex;
        list-style: none;
        padding: 0;
        margin: 0;
        align-items: center;
        font-size: 0.875rem;
    }

    .breadcrumb li {
        color: var(--gray-600);
        display: flex;
        align-items: center;
    }

    .breadcrumb li:not(:last-child)::after {
        content: '/';
        margin: 0 8px;
        color: var(--gray-400);
    }

    .breadcrumb li.active {
        color: var(--primary);
        font-weight: 500;
    }

    .card {
        background: white;
        border-radius: 12px;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03);
        border: none;
        overflow: hidden;
        margin-bottom: 30px;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .card:hover {
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        transform: translateY(-2px);
    }

    .card-header {
        padding: 20px 25px;
        background: white;
        border-bottom: 1px solid var(--gray-200);
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .card-header h4 {
        font-size: 1.25rem;
        font-weight: 600;
        color: var(--gray-800);
        margin: 0;
    }

    .card-body {
        padding: 25px;
    }

    .table-responsive {
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }

    /* Updated table styling for bordered design */
    .data-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
        font-size: 0.9375rem;
        background: white;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
    }

    .data-table thead th {
        background: #f8fafc;
        color: #1a202c;
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.8125rem;
        letter-spacing: 0.5px;
        padding: 16px;
        text-align: center;
        border-bottom: 2px solid #e2e8f0;
        position: relative;
    }

    .data-table thead th:not(:last-child)::after {
        content: '';
        position: absolute;
        right: 0;
        top: 25%;
        height: 50%;
        width: 1px;
        background-color: #e2e8f0;
    }

    .data-table tbody td {
        padding: 16px;
        text-align: center;
        vertical-align: middle;
        border-bottom: 1px solid #e2e8f0;
        color: #4a5568;
        transition: background-color 0.2s;
    }

    .data-table .label {
        display: none;  /* Hide by default */
    }

    .data-table .value {
        display: inline-block;
    }

    /* Desktop specific styles */
    @media (min-width: 769px) {
        .data-table tbody td {
            position: relative;
        }
        
        .data-table .label {
            display: block;
            font-size: 0.75rem;
            color: #718096;
            margin-bottom: 4px;
        }
        
        .data-table .value {
            font-weight: 500;
        }
        
        td[data-label="Amount"] .value {
            color: #2d3748;
            font-weight: 600;
        }
    }

    /* Mobile specific styles */
    @media (max-width: 768px) {
        .data-table tbody td {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 12px 15px;
            text-align: right;
        }

        .data-table tbody td::before {
            content: attr(data-label);
            font-weight: 600;
            margin-right: 1rem;
            text-align: left;
        }
    }

    .data-table tbody tr:hover td {
        background-color: #f7fafc;
    }

    .data-table tbody tr:last-child td {
        border-bottom: none;
    }

    .data-table tbody tr.total-row {
        background-color: #f8fafc;
        font-weight: 600;
    }

    .data-table tbody tr.total-row td {
        border-top: 2px solid #e2e8f0;
        color: #2d3748;
        font-size: 1rem;
    }

    .badge {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 6px 12px;
        border-radius: 9999px;
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }

    .badge-weekly {
        background-color: rgba(56, 178, 172, 0.1);
        color: #38b2ac;
    }

    .badge-monthly {
        background-color: rgba(102, 126, 234, 0.1);
        color: #667eea;
    }

    .badge-quarterly {
        background-color: rgba(237, 137, 54, 0.1);
        color: #ed8936;
    }

    .badge-one-time {
        background-color: rgba(66, 153, 225, 0.1);
        color: #4299e1;
    }

    .badge-yearly {
        background-color: rgba(72, 187, 120, 0.1);
        color: #48bb78;
    }

    /* Export button styling */
    .btn-export {
        display: flex;
        align-items: center;
        gap: 8px;
        background-color: var(--primary);
        color: white;
        border: none;
        border-radius: 6px;
        padding: 8px 16px;
        font-size: 0.875rem;
        font-weight: 500;
        cursor: pointer;
        transition: background-color 0.2s ease;
    }

    .btn-export:hover {
        background-color: var(--primary-dark);
    }

    .btn-sm {
        padding: 0.4rem 0.75rem;
        font-size: 0.875rem;
        border-radius: 0.375rem;
    }

    .btn-primary {
        background-color: var(--primary);
        color: white;
        border: none;
        cursor: pointer;
        transition: background-color 0.2s;
    }

    .btn-primary:hover {
        background-color: var(--primary-dark);
    }

    .btn-download {
        background-color: #4299e1;
        color: white;
        border: none;
        padding: 8px 16px;
        border-radius: 6px;
        font-size: 0.875rem;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.2s;
        text-decoration: none;
        display: inline-block;
    }

    .btn-download:hover {
        background-color: #3182ce;
        transform: translateY(-1px);
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    @media (max-width: 768px) {
        .content-wrapper {
            padding: 15px;
        }

        .card {
            border-radius: 12px;
            margin-bottom: 20px;
        }

        .card-header {
            padding: 15px;
        }

        .card-body {
            padding: 0;
        }

        .data-table {
            border-radius: 0;
            box-shadow: none;
            background: transparent;
        }

        .data-table thead {
            display: none;
        }

        .data-table tbody tr {
            display: block;
            background: white;
            margin-bottom: 15px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .data-table tbody td {
            display: flex;
            padding: 12px 15px;
            border-bottom: 1px solid #e2e8f0;
            align-items: center;
            min-height: 50px;
        }

        .data-table tbody td::before {
            content: attr(data-label);
            font-weight: 600;
            width: 40%;
            min-width: 120px;
            color: #4a5568;
        }

        .data-table tbody td:last-child {
            border-bottom: none;
        }

        .badge {
            margin: 0 auto;
            padding: 6px 12px;
        }

        .btn-download {
            margin: 0 auto;
            padding: 8px 16px;
            width: auto;
            min-width: 140px;
            text-align: center;
        }

        .total-row {
            background: #f8fafc !important;
            border: 2px solid #e2e8f0 !important;
            margin-top: 20px !important;
        }

        .total-row td {
            justify-content: space-between !important;
            font-weight: 600 !important;
            color: #2d3748 !important;
        }

        .total-row td[colspan="3"] {
            display: none !important;
        }

        .total-row td:last-child {
            border-top: none !important;
        }

        /* Adjust the table cell content alignment */
        .data-table tbody td {
            justify-content: space-between;
            text-align: right;
            gap: 10px;
        }

        /* Make the amount more prominent */
        td[data-label="Amount"] {
            font-weight: 600;
            color: #2d3748;
        }

        /* Center the session type badge */
        td[data-label="Session Type"] {
            justify-content: space-between;
        }

        /* Improve spacing for the invoice button */
        td[data-label="Invoice"] {
            justify-content: center;
            padding: 15px;
        }

        .label {
            display: none;
        }
        
        .value {
            flex: 1;
        }

        .total-label {
            text-align: left !important;
            padding-left: 15px !important;
        }

        .total-amount {
            text-align: right !important;
            padding-right: 15px !important;
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

    <!-- New Filter Section -->
    <div class="filter-section">
        <form action="{{ route('professional.billing.index') }}" method="GET" id="filter-form">
            <div class="row">
                   <div class="form-group">
            <label for="search_date_from">From Date</label>
            <input type="date" name="search_date_from" value="{{ request('search_date_from') }}">
        </div>

        <div class="form-group">
            <label for="search_date_to">To Date</label>
            <input type="date" name="search_date_to" value="{{ request('search_date_to') }}">
        </div>
                <div class="col-md-3 filter-group">
                    <label class="filter-label" for="plan_type">Plan Type</label>
                    <select class="filter-input" id="plan_type" name="plan_type">
                        <option value="">All Plans</option>
                        <option value="monthly" {{ request('plan_type') == 'monthly' ? 'selected' : '' }}>Monthly</option>
                        <option value="quarterly" {{ request('plan_type') == 'quarterly' ? 'selected' : '' }}>Quarterly</option>
                        <option value="yearly" {{ request('plan_type') == 'free_hand' ? 'selected' : '' }}>Free Hand</option>
                        <option value="one_time" {{ request('plan_type') == 'one_time' ? 'selected' : '' }}>One Time</option>
                    </select>
                </div>
                <div class="col-md-3 filter-group">
                    <label class="filter-label" for="payment_status">Payment Status</label>
                    <select class="filter-input" id="payment_status" name="payment_status">
                        <option value="">All Statuses</option>
                        <option value="paid" {{ request('payment_status') == 'paid' ? 'selected' : '' }}>Paid</option>
                        <option value="unpaid" {{ request('payment_status') == 'unpaid' ? 'selected' : '' }}>Unpaid</option>
                    </select>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-12 d-flex justify-content-end filter-actions">
                    <button type="submit" class="filter-btn">Apply Filters</button>
                    <a href="{{ route('professional.billing.index') }}" class="filter-btn reset ml-2">Reset</a>
                </div>
            </div>
        </form>
    </div>

    <div class="card">
        <div class="card-header">
            <h4>Billing Details</h4>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Customer Name</th>
                            <th>Session Type</th>
                            <th>Month</th>
                           
                            <th>Gross Amount</th>
                            <th>Platform Margin</th>
                            <th>Net Amount</th>
                    
                            <th>Status</th>
                                     <th>Transaction Number</th>
                            <th>Invoice</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($bookings as $booking)
                        <tr>
                            <td data-label="Customer Name">
                                <div class="label">Customer Name</div>
                                <div class="value">{{ $booking->customer_name }}</div>
                            </td>
                            <td data-label="Session Type">
                                <div class="label">Session Type</div>
                                <div class="value">
                                    <span class="badge badge-{{ str_replace('_', '-', strtolower($booking->plan_type)) }}">
                                        {{ ucwords(str_replace('_', ' ', $booking->plan_type)) }}
                                    </span>
                                </div>
                            </td>
                            <td data-label="Month">
                                <div class="label">Month</div>
                                <div class="value">{{ $booking->month }}</div>
                            </td>
                            
                            <td data-label="Gross Amount">
                                <div class="label">Gross Amount</div>
                                <div class="value">₹{{ number_format($booking->amount, 2) }}</div>
                            </td>
                            <td data-label="Platform Margin">
                                <div class="label">Platform Margin</div>
                                <div class="value margin-value">
                                    <span class="margin-badge">{{ $marginPercentage }}%</span>
                                </div>
                            </td>
                            <td data-label="Net Amount">
                                <div class="label">Net Amount</div>
                                <div class="value net-amount">₹{{ number_format($booking->net_amount, 2) }}</div>
                            </td>
                            
                            <td data-label="Status">
                                <div class="label">Status</div>
                                <div class="value">
                                    <span class="status-badge status-{{ $booking->paid_status ?? 'unpaid' }}">
                                        {{ ucfirst($booking->paid_status ?? 'unpaid') }}
                                    </span>
                                </div>
                            </td>
                            <td data-label="Transaction ID">
                                <div class="label">Transaction ID</div>
                                <div class="value">
                                    <span class="transaction-number">{{ $booking->transaction_number ?? 'N/A' }}</span>
                                </div>
                            </td>
                            <td data-label="Invoice">
                                <div class="label">Invoice</div>
                                <div class="value">
                                    <a href="{{ route('professional.billing.download-invoice', ['booking' => $booking->id]) }}" class="btn-download">
                                        Download Invoice
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                        <tr class="total-row">
                            <td colspan="4" class="total-label">Total Billing:</td>
                            <td class="total-amount">₹{{ number_format($totalGrossAmount, 2) }}</td>
                            <td class="total-deduction">₹{{ number_format($totalMarginDeducted, 2) }}</td>
                            <td class="total-net">₹{{ number_format($totalNetAmount, 2) }}</td>
                            <td colspan="2"></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection



@section('scripts')
<script>
    
</script>
@endsection