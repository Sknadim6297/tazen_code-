@extends('admin.layouts.layout')

@section('content')
<div class="main-content app-content">
    <div class="container-fluid">
        <!-- Page Header -->
        <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
            <div>
                <h1 class="page-title fw-medium fs-18 mb-2">Customer Billing</h1>
                <div>
                    <nav>
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="javascript:void(0);">Customer</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Customer Billing</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <!-- Add Export Button -->
            <div>
                <a href="{{ route('admin.customer.billing.export', request()->all()) }}" class="btn btn-primary">
                    <i class="fas fa-file-pdf me-1"></i> Export to PDF
                </a>
            </div>
        </div>
        <!-- End Page Header -->

        <!-- Search Container -->
        <div class="card mb-4">
            <div class="card-body">
                <form action="{{ route('admin.customer.billing') }}" method="GET" id="searchForm">
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
                            <label class="form-label">SMS Status</label>
                            <select class="form-select" name="sms_status">
                                <option value="">All Status</option>
                                <option value="sent" {{ request('sms_status') == 'sent' ? 'selected' : '' }}>Sent</option>
                                <option value="pending" {{ request('sms_status') == 'pending' ? 'selected' : '' }}>Pending</option>
                            </select>
                        </div>
                        <!-- Add Service Filter -->
                        <div class="col-md-6">
                            <label class="form-label">Service</label>
                            <select class="form-select" name="service">
                                <option value="">All Services</option>
                                @foreach($serviceOptions as $serviceName)
                                <option value="{{ $serviceName }}" {{ request('service') == $serviceName ? 'selected' : '' }}>
                                    {{ $serviceName }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Search</label>
                            <input type="text" class="form-control" name="search" placeholder="Search by name, email or phone" value="{{ request('search') }}">
                        </div>
                        <div class="col-12 d-flex gap-2">
                            <button type="submit" class="btn btn-primary">Search</button>
                            <a href="{{ route('admin.customer.billing') }}" class="btn btn-secondary">Reset</a>
                            <button type="button" class="btn btn-success" id="exportFilteredBtn">
                                <i class="fas fa-file-pdf me-1"></i> Export Filtered Data
                            </button>
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
                                <th>S.No</th>
                                <th>Customer Name</th>
                                <th>Service Taking</th>
                                <th>Professional</th>
                                <th>Type of Plan</th>
                                <th>Amount</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($billings as $key => $billing)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $billing->customer_name }}</td>
                                <td>
                                    <!-- Highlight the service if it's filtered -->
                                    @if(request('service') == $billing->service_name)
                                        <span class="badge bg-info">{{ $billing->service_name }}</span>
                                    @else
                                        {{ $billing->service_name }}
                                    @endif
                                </td>
                                <td>{{ $billing->professional->name ?? 'N/A' }}</td>
                                <td>{{ ucfirst(str_replace('_', ' ', $billing->plan_type)) }}</td>
                                <td>₹{{ number_format($billing->amount, 2) }}</td>
                                <td>{{ $billing->created_at->format('d M Y') }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="8" class="text-center">No billing records found</td>
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

@section('scripts')
<script>
    $(document).ready(function() {
        // Add Select2 for better service selection (if Select2 is available)
        if ($.fn.select2) {
            $('select[name="service"]').select2({
                placeholder: "Select a service",
                allowClear: true,
                width: '100%'
            });
        }
        
        // Export filtered data button
        $('#exportFilteredBtn').click(function() {
            var formData = $('#searchForm').serialize();
            window.location.href = "{{ route('admin.customer.billing.export') }}?" + formData;
        });
    });
</script>
@endsection