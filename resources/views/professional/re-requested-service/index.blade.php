@extends('professional.layout.layout')

@section('title', 'Re-booking Services')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Re-booking Services</h5>
                    <a href="{{ route('professional.re-requested-service.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> New Request
                    </a>
                </div>
                <div class="card-body">
                    <!-- Enhanced Filters -->
                    <form method="GET" class="mb-4">
                        <div class="row g-3">
                            <div class="col-md-2">
                                <select name="status" class="form-select form-select-sm">
                                    <option value="">All Status</option>
                                    <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="admin_approved" {{ request('status') === 'admin_approved' ? 'selected' : '' }}>Approved</option>
                                    <option value="customer_paid" {{ request('status') === 'customer_paid' ? 'selected' : '' }}>Paid</option>
                                    <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>Rejected</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <select name="payment_status" class="form-select form-select-sm">
                                    <option value="">Payment Status</option>
                                    <option value="unpaid" {{ request('payment_status') === 'unpaid' ? 'selected' : '' }}>Unpaid</option>
                                    <option value="paid" {{ request('payment_status') === 'paid' ? 'selected' : '' }}>Paid</option>
                                    <option value="failed" {{ request('payment_status') === 'failed' ? 'selected' : '' }}>Failed</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <select name="priority" class="form-select form-select-sm">
                                    <option value="">Priority</option>
                                    <option value="low" {{ request('priority') === 'low' ? 'selected' : '' }}>Low</option>
                                    <option value="normal" {{ request('priority') === 'normal' ? 'selected' : '' }}>Normal</option>
                                    <option value="high" {{ request('priority') === 'high' ? 'selected' : '' }}>High</option>
                                    <option value="urgent" {{ request('priority') === 'urgent' ? 'selected' : '' }}>Urgent</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <input type="date" name="date_from" class="form-control form-control-sm" value="{{ request('date_from') }}" placeholder="From Date">
                            </div>
                            <div class="col-md-2">
                                <input type="date" name="date_to" class="form-control form-control-sm" value="{{ request('date_to') }}" placeholder="To Date">
                            </div>
                            <div class="col-md-2">
                                <div class="d-flex gap-1">
                                    <button type="submit" class="btn btn-primary btn-sm flex-fill">
                                        <i class="fas fa-filter"></i> Filter
                                    </button>
                                    <a href="{{ route('professional.re-requested-service.index') }}" class="btn btn-secondary btn-sm">
                                        <i class="fas fa-times"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-md-10">
                                <input type="text" name="search" class="form-control form-control-sm" placeholder="Search by customer name, email, or service name..." value="{{ request('search') }}">
                            </div>
                        </div>
                    </form>

                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if($reRequestedServices->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead class="table-dark">
                                    <tr>
                                        <th>ID</th>
                                        <th>Customer</th>
                                        <th>Service Name</th>
                                        <th>Original Price</th>
                                        <th>Final Price</th>
                                        <th>CGST/SGST</th>
                                        <th>Total Amount</th>
                                        <th>Status</th>
                                        <th>Priority</th>
                                        <th>Payment Status</th>
                                        <th>Requested Date</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($reRequestedServices as $service)
                                        <tr>
                                            <td>#{{ $service->id }}</td>
                                            <td>
                                                <strong>{{ $service->customer->name }}</strong><br>
                                                <small class="text-muted">{{ $service->customer->email }}</small>
                                            </td>
                                            <td>{{ $service->service_name }}</td>
                                            <td>₹{{ number_format($service->original_price, 2) }}</td>
                                            <td>
                                                ₹{{ number_format($service->final_price, 2) }}
                                                @if($service->admin_modified_price)
                                                    <br><small class="text-info">(Modified by Admin)</small>
                                                @endif
                                            </td>
                                            <td>
                                                <small>CGST: ₹{{ number_format($service->cgst_amount, 2) }}</small><br>
                                                <small>SGST: ₹{{ number_format($service->sgst_amount, 2) }}</small>
                                            </td>
                                            <td>₹{{ number_format($service->total_amount, 2) }}</td>
                                            <td>{!! $service->status_badge !!}</td>
                                            <td>{!! $service->priority_badge !!}</td>
                                            <td>{!! $service->payment_status_badge !!}</td>
                                            <td>{{ $service->requested_at->format('d M Y, h:i A') }}</td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <a href="{{ route('professional.re-requested-service.show', $service->id) }}" 
                                                       class="btn btn-sm btn-info" title="View Details">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    @if($service->status === 'pending')
                                                        <a href="{{ route('professional.re-requested-service.edit', $service->id) }}" 
                                                           class="btn btn-sm btn-warning" title="Edit">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                        <form action="{{ route('professional.re-requested-service.destroy', $service->id) }}" 
                                                              method="POST" class="d-inline" 
                                                              onsubmit="return confirm('Are you sure you want to cancel this request?')">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-sm btn-danger" title="Cancel">
                                                                <i class="fas fa-times"></i>
                                                            </button>
                                                        </form>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="d-flex justify-content-center">
                            {{ $reRequestedServices->appends(request()->query())->links() }}
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">No re-booking services found</h5>
                            <p class="text-muted">You haven't made any service requests yet.</p>
                            <a href="{{ route('professional.re-requested-service.create') }}" class="btn btn-primary">
                                Create Your First Request
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Auto dismiss alerts after 5 seconds
    setTimeout(function() {
        $('.alert').fadeOut();
    }, 5000);
</script>
@endpush
