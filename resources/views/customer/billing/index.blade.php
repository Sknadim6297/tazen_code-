@extends('customer.layout.layout')
<link rel="stylesheet" href="{{ asset('customer-css/assets/css/appointment.css') }}" />

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

    <div class="card mb-4">
        <div class="card-header">
            <h4>Filter Transactions</h4>
        </div>
        <div class="card-body">
            <form action="{{ route('user.billing.index') }}" method="GET" id="filter-form">
                <div class="row">
                    <div class="col-md-3 mb-3">
                        <label for="start_date">Start Date</label>
                        <input type="date" id="start_date" name="start_date" class="form-control" value="{{ request('start_date') }}">
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="end_date">End Date</label>
                        <input type="date" id="end_date" name="end_date" class="form-control" value="{{ request('end_date') }}">
                    </div>
                    <div class="col-md-3 mb-3">
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
                    <div class="col-md-3 mb-3">
                        <label for="plan_type">Plan Type</label>
                        <select id="plan_type" name="plan_type" class="form-control">
                            <option value="">All Plans</option>
                            <option value="monthly" {{ request('plan_type') == 'monthly' ? 'selected' : '' }}>Monthly</option>
                            <option value="quarterly" {{ request('plan_type') == 'quarterly' ? 'selected' : '' }}>Quarterly</option>
                            <option value="one_time" {{ request('plan_type') == 'one_time' ? 'selected' : '' }}>One Time</option>
                            <option value="free_hand" {{ request('plan_type') == 'free_hand' ? 'selected' : '' }}>Free Hand</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary">Apply Filters</button>
                        <a href="{{ route('user.billing.index') }}" class="btn btn-secondary">Reset</a>
                    </div>
                </div>
            </form>
        </div>
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
                            <td><span class="badge badge-{{ strtolower($booking->plan_type) }}">{{ ucwords(str_replace('_', ' ', $booking->plan_type)) }}</span></td>
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

<style>
    /* Modern Page Header */
    .page-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 2rem;
        border-radius: 15px;
        margin-bottom: 2rem;
        box-shadow: 0 8px 25px rgba(102, 126, 234, 0.15);
    }

    .page-title h3 {
        font-size: 2rem;
        font-weight: 600;
        margin: 0;
        text-shadow: 0 2px 4px rgba(0,0,0,0.1);
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

    /* Card Styling */
    .card {
        border: none;
        border-radius: 15px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.08);
        overflow: hidden;
        margin-bottom: 2rem;
        background: white;
    }

    .card-header {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
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
        color: #2d3748;
    }

    .card-body {
        padding: 2rem;
    }

    /* Form Controls */
    .form-control {
        border: 2px solid #e2e8f0;
        border-radius: 10px;
        padding: 0.75rem 1rem;
        font-size: 0.95rem;
        transition: all 0.3s ease;
        background: #f8f9fa;
    }

    .form-control:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        background: white;
    }

    .form-control:focus {
        outline: none;
    }

    label {
        font-weight: 600;
        color: #4a5568;
        margin-bottom: 0.5rem;
        display: block;
    }

    /* Buttons */
    .btn {
        border-radius: 10px;
        padding: 0.75rem 1.5rem;
        font-weight: 600;
        transition: all 0.3s ease;
        border: none;
        cursor: pointer;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }

    .btn-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(102, 126, 234, 0.3);
        color: white;
    }

    .btn-secondary {
        background: #6c757d;
        color: white;
    }

    .btn-secondary:hover {
        background: #5a6268;
        transform: translateY(-2px);
        color: white;
    }

    .btn-mm {
        padding: 0.5rem 1rem;
        font-size: 0.85rem;
    }

    /* Table Styling */
    .data-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
        background: white;
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 4px 15px rgba(0,0,0,0.05);
    }

    .data-table thead {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
    }

    .data-table th {
        padding: 1.25rem 1rem;
        font-weight: 600;
        text-align: left;
        font-size: 0.95rem;
        border: none;
    }

    .data-table td {
        padding: 1.25rem 1rem;
        border-bottom: 1px solid #f1f5f9;
        vertical-align: middle;
        color: #4a5568;
    }

    .data-table tbody tr {
        transition: all 0.3s ease;
    }

    .data-table tbody tr:hover {
        background: #f8f9fa;
        transform: scale(1.01);
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
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
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
    }

    .badge-quarterly {
        background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        color: white;
    }

    .badge-one_time {
        background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        color: white;
    }

    .badge-free_hand {
        background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
        color: white;
    }

    /* Alert Styling */
    .alert {
        border: none;
        border-radius: 15px;
        padding: 1.5rem;
        font-weight: 500;
    }

    .alert-info {
        background: linear-gradient(135deg, #e3f2fd 0%, #bbdefb 100%);
        color: #1565c0;
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

    /* Responsive Design */
    @media (max-width: 768px) {
        .page-header {
            padding: 1.5rem;
        }

        .page-title h3 {
            font-size: 1.5rem;
        }

        .card-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 1rem;
            padding: 1rem 1.5rem;
        }

        .card-body {
            padding: 1rem;
        }

        .data-table {
            font-size: 0.85rem;
        }

        .data-table th,
        .data-table td {
            padding: 0.75rem 0.5rem;
        }

        .btn {
            padding: 0.6rem 1rem;
            font-size: 0.85rem;
        }

        .table-responsive {
            border-radius: 10px;
            overflow: hidden;
        }
    }

    @media (max-width: 576px) {
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
</style>
@endsection