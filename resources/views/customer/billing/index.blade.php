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

    <div class="card">
        <div class="card-header">
            <h4>All Transactions</h4>
        </div>
        <div class="card-body">
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
                                <a href="{{ route('user.billing.download', $booking->id) }}" class="btn btn-sm btn-primary">
                                    <i class="fas fa-download"></i> Invoice
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<style>
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

.data-table {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0;
    border: 1px solid #e2e8f0;
    border-radius: 8px;
}

.data-table th,
.data-table td {
    padding: 12px 16px;
    text-align: left;
    border-bottom: 1px solid #e2e8f0;
}

.data-table th {
    background-color: #f7fafc;
    font-weight: 600;
    color: #4a5568;
}

.data-table tr:last-child td {
    border-bottom: none;
}

.data-table tr:hover {
    background-color: #f8fafc;
}

.btn-sm {
    padding: 0.4rem 0.75rem;
    font-size: 0.875rem;
    border-radius: 0.375rem;
}
</style>
@endsection 