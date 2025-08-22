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

    .badge-monthly {
        background-color: #e8f5e9;
        color: #2e7d32;
        border: 1px solid #c8e6c9;
    }

    .badge-quarterly {
        background-color: #e1f5fe;
        color: #0277bd;
        border: 1px solid #b3e5fc;
    }

    .badge-one_time {
        background-color: #f3e5f5;
        color: #7b1fa2;
        border: 1px solid #e1bee7;
    }

    .badge-free_hand {
        background-color: #fff3e0;
        color: #e65100;
        border: 1px solid #ffe0b2;
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

    /* Button Styling */
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

    .btn-primary {
        background: #007bff;
        color: #fff;
    }

    .btn-primary:hover {
        background: #0056b3;
        color: #fff;
    }

    .btn-secondary {
        background: #6c757d;
        color: #fff;
    }

    .btn-secondary:hover {
        background: #5a6268;
        color: #fff;
    }

    .btn-mm {
        padding: 0.5rem 1rem;
        font-size: 0.85rem;
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
</style>
@endsection

@section('content')
<div class="content-wrapper">
    <!-- Page Header -->
    <div class="page-header">
        <div class="page-title">
            <h3>Billing History</h3>
        </div>
        <ul class="breadcrumb">
            <li>Home</li>
            <li class="active">Billing History</li>
        </ul>
    </div>

    <div class="search-container">
        <form action="{{ route('user.billing.index') }}" method="GET" class="search-form" id="filter-form">
            <div class="form-group">
                <label for="start_date">Start Date</label>
                <input type="date" id="start_date" name="start_date" class="form-control" value="{{ request('start_date') }}">
            </div>
            <div class="form-group">
                <label for="end_date">End Date</label>
                <input type="date" id="end_date" name="end_date" class="form-control" value="{{ request('end_date') }}">
            </div>
            <div class="form-group">
                <label for="service">Service</label>
                <select id="service" name="service" class="form-control">
                    <option value="">All Services</option>
                    @foreach($services as $service)
                        <option value="{{ $service }}" {{ request('service') == $service ? 'selected' : '' }}>
                            {{ $service }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="plan_type">Plan Type</label>
                <select id="plan_type" name="plan_type" class="form-control">
                    <option value="">All Plans</option>
                    <option value="monthly" {{ request('plan_type') == 'monthly' ? 'selected' : '' }}>Monthly</option>
                    <option value="quarterly" {{ request('plan_type') == 'quarterly' ? 'selected' : '' }}>Quarterly</option>
                    <option value="one_time" {{ request('plan_type') == 'one_time' ? 'selected' : '' }}>One Time</option>
                    <option value="free_hand" {{ request('plan_type') == 'free_hand' ? 'selected' : '' }}>Free Hand</option>
                </select>
            </div>
            <div class="search-buttons">
                <button type="submit" class="btn btn-success">Apply Filters</button>
                <a href="{{ route('user.billing.index') }}" class="btn btn-secondary">Reset</a>
            </div>
        </form>
    </div>

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4>All Transactions</h4>
            <a href="{{ route('user.billing.export-all', request()->all()) }}" class="btn btn-primary">
                <i class="fas fa-file-export"></i> Export as PDF
            </a>
        </div>
        <div class="card-body">
            @if($bookings->count() > 0)
            <div class="table-responsive">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>S.No</th>
                            <th>Date</th>
                            <th>Service Taken</th>
                            <th>Professional Name</th>
                            <th>Type of Plan</th>
                            <th>Amount</th>
                            <th>Download PDF</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($bookings as $index => $booking)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $booking->created_at->format('d M Y') }}</td>
                            <td>{{ $booking->service_name }}</td>
                            <td>{{ $booking->professional->name ?? 'N/A' }}</td>
                            <td>
                                <span class="badge badge-{{ str_replace('_', '-', $booking->plan_type) }}">
                                    {{ ucwords(str_replace('_', ' ', $booking->plan_type)) }}
                                </span>
                            </td>
                            <td>₹{{ number_format($booking->amount, 2) }}</td>
                            <td>
                                <a href="{{ route('user.billing.download', $booking->id) }}" class="btn btn-mm btn-primary">
                                    <i class="fas fa-download"></i> Invoice
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
            <div class="alert alert-info">
                No transactions found matching your filters. <a href="{{ route('user.billing.index') }}">Clear filters</a> to see all transactions.
            </div>
            @endif
        </div>
    </div>
</div>
@endsection