@extends('admin.layouts.layout')

@section('content')
<div class="main-content app-content">
    <div class="container-fluid">
        <!-- Page Header -->
        <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
        <div>
                <h1 class="page-title fw-medium fs-18 mb-2">Professional Billing</h1>
                <div>
                    <nav>
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="javascript:void(0);">Professional</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Professional Billing</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <!-- End Page Header -->

        <!-- Search Container -->
        <div class="card mb-4">
            <div class="card-body">
                <form action="{{ route('admin.professional.billing') }}" method="GET">
                    <div class="row g-3">
                        <div class="col-md-3">
                            <label class="form-label">Date Range</label>
                            <input type="date" class="form-control" name="start_date" value="{{ request('start_date') }}">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">To</label>
                            <input type="date" class="form-control" name="end_date" value="{{ request('end_date') }}">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Plan Type</label>
                            <select class="form-select" name="plan_type">
                                <option value="">All Plans</option>
                                <option value="one_time" {{ request('plan_type') == 'one_time' ? 'selected' : '' }}>One Time</option>
                                <option value="monthly" {{ request('plan_type') == 'monthly' ? 'selected' : '' }}>Monthly</option>
                                <option value="quarterly" {{ request('plan_type') == 'quarterly' ? 'selected' : '' }}>Quarterly</option>
                                <option value="free_hand" {{ request('plan_type') == 'free_hand' ? 'selected' : '' }}>Free Hand</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Payment Status</label>
                            <select class="form-select" name="payment_status">
                                <option value="">All Status</option>
                                <option value="paid" {{ request('payment_status') == 'paid' ? 'selected' : '' }}>Paid</option>
                                <option value="pending" {{ request('payment_status') == 'pending' ? 'selected' : '' }}>Pending</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary">Search</button>
                            <a href="{{ route('admin.professional.billing') }}" class="btn btn-secondary">Reset</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Billing Table -->
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered text-nowrap">
                        <thead>
                            <tr>
                                <th>Sl. No</th>
                                <th>Date</th>
                                <th>Customer Name</th>
                                <th>Service</th>
                                <th>Professional Name</th>
                                <th>Plan Type</th>
                                <th>Received Amount</th>
                                <th>Commission Rate</th>
                                <th>Professional Pay</th>
                                <th>Status</th>
                                <th>Amount Earned</th>
                                <th>Month</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($billings as $key => $billing)
                            @php
                                $commissionRate = 20; // Set your commission rate here
                                $professionalPay = $billing->amount * ((100 - $commissionRate) / 100);
                                $amountEarned = $billing->amount * ($commissionRate / 100);
                            @endphp
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $billing->created_at->format('d M Y') }}</td>
                                <td>{{ $billing->customer_name }}</td>
                                <td>{{ $billing->service_name }}</td>
                                <td>{{ $billing->professional->name ?? 'N/A' }}</td>
                                <td>{{ ucfirst(str_replace('_', ' ', $billing->plan_type)) }}</td>
                                <td>₹{{ number_format($billing->amount, 2) }}</td>
                                <td>{{ $commissionRate }}%</td>
                                <td>₹{{ number_format($professionalPay, 2) }}</td>
                                <td>
                                    <span class="badge bg-{{ $billing->payment_status == 'paid' ? 'success' : 'warning' }}">
                                        {{ ucfirst($billing->payment_status) }}
                                    </span>
                                </td>
                                <td>₹{{ number_format($amountEarned, 2) }}</td>
                                <td>{{ $billing->created_at->format('M Y') }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="12" class="text-center">No billing records found</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="mt-4">
                    {{ $billings->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 