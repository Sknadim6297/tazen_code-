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
    /* Your existing styles */
    .form-control {
        height: auto;
        padding: 0.5rem 0.75rem;
    }
    
    .card-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 15px 20px;
    }
    
    .card-header h4 {
        margin-bottom: 0;
    }
    
    @media (max-width: 767px) {
        .card-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 10px;
        }
    }
    
    /* Existing badge styles */
    .badge {
        padding: 6px 12px;
        border-radius: 15px;
        font-weight: 500;
        font-size: 0.85rem;
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
    
    .badge-one_time, .badge-free_hand {
        background-color: rgba(90, 103, 216, 0.1);
        color: #5a67d8;
    }
</style>
@endsection