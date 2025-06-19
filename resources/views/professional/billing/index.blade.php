@extends('professional.layout.layout')

@section('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<style>
    :root {
        --primary: #667eea;
        --primary-dark: #5a67d8;
        --primary-rgb: 102, 126, 234;
        --secondary: #764ba2;
        --success: #48bb78;
        --warning: #ed8936;
        --danger: #f56565;
        --info: #4299e1;
        --gray-100: #f7fafc;
        --gray-200: #edf2f7;
        --gray-300: #e2e8f0;
        --gray-400: #cbd5e0;
        --gray-500: #a0aec0;
        --gray-600: #718096;
        --gray-700: #4a5568;
        --gray-800: #2d3748;
        --gray-900: #1a202c;
    }
  
    /* Modern Page Header */
    .content-wrapper {
        background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
        min-height: calc(100vh - 60px);
        padding: 2rem;
    }

    .page-header {
        background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
        color: white;
        padding: 2rem;
        border-radius: 20px;
        margin-bottom: 2rem;
        box-shadow: 0 10px 30px rgba(102, 126, 234, 0.2);
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 1rem;
    }

    .page-title h3 {
        font-size: 2rem;
        font-weight: 700;
        margin: 0;
        text-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }

    .breadcrumb {
        background: none;
        padding: 0;
        margin: 0;
        list-style: none;
        display: flex;
        gap: 0.5rem;
        font-size: 0.9rem;
        opacity: 0.9;
    }

    .breadcrumb li {
        position: relative;
    }

    .breadcrumb li:not(:last-child)::after {
        content: '>';
        margin-left: 0.5rem;
        opacity: 0.7;
    }

    .breadcrumb li.active {
        font-weight: 600;
    }

    /* Filter Section Styling */
    .filter-section {
        background: white;
        border-radius: 20px;
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
        padding: 2rem;
        margin-bottom: 2rem;
        border: 1px solid var(--gray-200);
    }

    .filter-group {
        margin-bottom: 1.5rem;
    }

    .filter-label {
        display: block;
        font-size: 0.9rem;
        font-weight: 600;
        color: var(--gray-700);
        margin-bottom: 0.5rem;
    }

    .filter-input {
        width: 100%;
        padding: 0.75rem 1rem;
        border: 2px solid var(--gray-300);
        border-radius: 12px;
        font-size: 0.95rem;
        transition: all 0.3s ease;
        background: var(--gray-100);
    }

    .filter-input:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(var(--primary-rgb), 0.1);
        outline: none;
        background: white;
    }

    .filter-btn {
        background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
        color: white;
        border: none;
        border-radius: 12px;
        padding: 0.75rem 1.5rem;
        font-size: 0.95rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }

    .filter-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(102, 126, 234, 0.3);
        color: white;
    }

    .filter-btn.reset {
        background: var(--gray-200);
        color: var(--gray-700);
    }

    .filter-btn.reset:hover {
        background: var(--gray-300);
        transform: translateY(-2px);
    }

    /* Card Styling */
    .card {
        background: white;
        border-radius: 20px;
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
        border: none;
        overflow: hidden;
        margin-bottom: 2rem;
        transition: all 0.3s ease;
    }

    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.12);
    }

    .card-header {
        background: linear-gradient(135deg, var(--gray-100) 0%, var(--gray-200) 100%);
        border-bottom: 1px solid var(--gray-200);
        padding: 1.5rem 2rem;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .card-header h4 {
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--gray-800);
        margin: 0;
    }

    .card-body {
        padding: 2rem;
    }

    /* Table Styling */
    .data-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
        background: white;
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
    }

    .data-table thead th {
        background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
        color: white;
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.85rem;
        letter-spacing: 0.5px;
        padding: 1.25rem 1rem;
        text-align: center;
        border: none;
        position: relative;
    }

    .data-table thead th:not(:last-child)::after {
        content: '';
        position: absolute;
        right: 0;
        top: 25%;
        height: 50%;
        width: 1px;
        background-color: rgba(255, 255, 255, 0.2);
    }

    .data-table tbody td {
        padding: 1.25rem 1rem;
        text-align: center;
        vertical-align: middle;
        border-bottom: 1px solid var(--gray-200);
        color: var(--gray-700);
        transition: all 0.3s ease;
    }

    .data-table tbody tr {
        transition: all 0.3s ease;
    }

    .data-table tbody tr:hover {
        background: var(--gray-100);
        transform: scale(1.01);
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    }

    .data-table tbody tr:last-child td {
        border-bottom: none;
    }

    .data-table tbody tr.total-row {
        background: linear-gradient(135deg, var(--gray-100) 0%, var(--gray-200) 100%);
        font-weight: 700;
    }

    .data-table tbody tr.total-row td {
        border-top: 2px solid var(--primary);
        color: var(--gray-800);
        font-size: 1.1rem;
    }

    /* Badge Styling */
    .badge {
        padding: 0.5rem 1rem;
        border-radius: 20px;
        font-weight: 600;
        font-size: 0.8rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }

    .badge-monthly {
        background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
        color: white;
    }

    .badge-quarterly {
        background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        color: white;
    }

    .badge-yearly {
        background: linear-gradient(135deg, var(--success) 0%, #38a169 100%);
        color: white;
    }

    .badge-one-time {
        background: linear-gradient(135deg, var(--info) 0%, #3182ce 100%);
        color: white;
    }

    /* Status Badge Styling */
    .status-badge {
        padding: 0.5rem 1rem;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .status-paid {
        background: linear-gradient(135deg, var(--success) 0%, #38a169 100%);
        color: white;
    }

    .status-unpaid {
        background: linear-gradient(135deg, var(--danger) 0%, #e53e3e 100%);
        color: white;
    }

    /* Transaction Number Styling */
    .transaction-number {
        font-family: 'Courier New', monospace;
        padding: 0.5rem 1rem;
        background: var(--gray-100);
        border-radius: 8px;
        border: 1px solid var(--gray-300);
        font-size: 0.85rem;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        max-width: 150px;
        display: inline-block;
        text-align: center;
        color: var(--gray-700);
    }

    /* Button Styling */
    .btn-download {
        background: linear-gradient(135deg, var(--info) 0%, #3182ce 100%);
        color: white;
        border: none;
        padding: 0.75rem 1.5rem;
        border-radius: 12px;
        font-size: 0.9rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }

    .btn-download:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(66, 153, 225, 0.3);
        color: white;
    }

    /* Margin Badge Styling */
    .margin-badge {
        background: linear-gradient(135deg, var(--warning) 0%, #dd6b20 100%);
        color: white;
        padding: 0.4rem 0.8rem;
        border-radius: 15px;
        font-size: 0.8rem;
        font-weight: 600;
    }

    /* Net Amount Styling */
    .net-amount {
        font-weight: 700;
        color: var(--success);
        font-size: 1.1rem;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .content-wrapper {
            padding: 1rem;
        }

        .page-header {
            padding: 1.5rem;
            flex-direction: column;
            align-items: flex-start;
        }

        .page-title h3 {
            font-size: 1.5rem;
        }

        .filter-section {
            padding: 1.5rem;
        }

        .card-header {
            padding: 1rem 1.5rem;
            flex-direction: column;
            align-items: flex-start;
            gap: 1rem;
        }

        .card-body {
            padding: 1rem;
        }

        .data-table {
            font-size: 0.85rem;
        }

        .data-table thead {
            display: none;
        }

        .data-table tbody tr {
            display: block;
            background: white;
            margin-bottom: 1rem;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .data-table tbody td {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1rem 1.5rem;
            border-bottom: 1px solid var(--gray-200);
            text-align: left;
        }

        .data-table tbody td::before {
            content: attr(data-label);
            font-weight: 600;
            color: var(--gray-600);
            min-width: 120px;
        }

        .data-table tbody td:last-child {
            border-bottom: none;
        }

        .badge, .status-badge {
            margin: 0 auto;
        }

        .btn-download {
            margin: 0 auto;
            width: auto;
            min-width: 140px;
            justify-content: center;
        }

        .total-row {
            background: var(--gray-100) !important;
            border: 2px solid var(--primary) !important;
            margin-top: 1rem !important;
        }

        .total-row td {
            justify-content: space-between !important;
            font-weight: 700 !important;
            color: var(--gray-800) !important;
        }

        .total-row td[colspan] {
            display: none !important;
        }
    }

    @media (max-width: 576px) {
        .breadcrumb {
            flex-wrap: wrap;
        }

        .data-table tbody td {
            font-size: 0.8rem;
        }

        .badge, .status-badge {
            padding: 0.4rem 0.8rem;
            font-size: 0.75rem;
        }

        .transaction-number {
            max-width: 120px;
            font-size: 0.8rem;
        }
    }

    /* Animation */
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

    .card {
        animation: fadeInUp 0.6s ease-out;
    }

    .data-table tbody tr {
        animation: fadeInUp 0.4s ease-out;
        animation-fill-mode: both;
    }

    .data-table tbody tr:nth-child(1) { animation-delay: 0.1s; }
    .data-table tbody tr:nth-child(2) { animation-delay: 0.2s; }
    .data-table tbody tr:nth-child(3) { animation-delay: 0.3s; }
    .data-table tbody tr:nth-child(4) { animation-delay: 0.4s; }
    .data-table tbody tr:nth-child(5) { animation-delay: 0.5s; }

    /* Form Group Styling */
    .form-group {
        margin-bottom: 1rem;
    }

    .form-group label {
        display: block;
        font-weight: 600;
        color: var(--gray-700);
        margin-bottom: 0.5rem;
    }

    .form-group input[type="date"] {
        width: 100%;
        padding: 0.75rem 1rem;
        border: 2px solid var(--gray-300);
        border-radius: 12px;
        font-size: 0.95rem;
        transition: all 0.3s ease;
        background: var(--gray-100);
    }

    .form-group input[type="date"]:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(var(--primary-rgb), 0.1);
        outline: none;
        background: white;
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
                        <option value="">All Status</option>
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
<style>
    /* Table horizontal scrolling for mobile */
    .table-responsive-container {
        width: 100%;
        overflow-x: auto;
        -webkit-overflow-scrolling: touch; /* Smooth scrolling on iOS */
    }
    
    .table {
        min-width: 600px; /* Minimum width to ensure all columns are visible when scrolling */
        width: 100%;
    }

    @media only screen and (min-width: 768px) and (max-width: 1024px) {
         /* Fix header to prevent horizontal scrolling */
        .page-header {
            position: sticky;
            top: 0;
            z-index: 10;
            background-color: #f8f9fa;
            padding-top: 10px;
            padding-bottom: 10px;
            width: 100%;
            max-width: 100vw;
            overflow-x: hidden;
        }
        
        /* Make table container scrollable horizontally */
        .table-responsive-container {
            display: block;
            width: 100%;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
            margin-bottom: 15px;
        }
        
        /* Ensure the table takes full width of container */
        .table {
            width: 100%;
            table-layout: auto;
            white-space: nowrap;
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
        
        /* Add scrollbar styling */
        .table-responsive-container::-webkit-scrollbar {
            height: 8px;
        }
        
        .table-responsive-container::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }
        
        .table-responsive-container::-webkit-scrollbar-thumb {
            background: #888;
            border-radius: 10px;
        }
        
        .table-responsive-container::-webkit-scrollbar-thumb:hover {
            background: #555;
        }

            .user-profile-wrapper{
                margin-top: -57px;
            }
    }
    
    @media screen and (max-width: 767px) {
        /* Fix header to prevent horizontal scrolling */
        .page-header {
            position: sticky;
            top: 0;
            z-index: 10;
            background-color: #f8f9fa;
            padding-top: 10px;
            padding-bottom: 10px;
            width: 100%;
            max-width: 100vw;
            overflow-x: hidden;
        }
        
        /* Make table container scrollable horizontally */
        .table-responsive-container {
            display: block;
            width: 100%;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
            margin-bottom: 15px;
        }
        
        /* Ensure the table takes full width of container */
        .table {
            width: 100%;
            table-layout: auto;
            white-space: nowrap;
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
        
        /* Add scrollbar styling */
        .table-responsive-container::-webkit-scrollbar {
            height: 8px;
        }
        
        .table-responsive-container::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }
        
        .table-responsive-container::-webkit-scrollbar-thumb {
            background: #888;
            border-radius: 10px;
        }
        
        .table-responsive-container::-webkit-scrollbar-thumb:hover {
            background: #555;
        }
    }
</style>
@endsection



@section('scripts')
<script>
    
</script>
@endsection