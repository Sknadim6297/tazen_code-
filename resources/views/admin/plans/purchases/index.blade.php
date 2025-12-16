@extends('admin.layout.layout')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title mb-0">Professional Plan Purchases</h3>
                </div>

                <div class="card-body">
                    <!-- Filters -->
                    <form method="GET" action="{{ route('admin.plans.purchases.index') }}" class="mb-4">
                        <div class="row">
                            <div class="col-md-4">
                                <select name="status" class="form-control" onchange="this.form.submit()">
                                    <option value="all" {{ request('status') == 'all' ? 'selected' : '' }}>All Status</option>
                                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="success" {{ request('status') == 'success' ? 'selected' : '' }}>Success</option>
                                    <option value="failed" {{ request('status') == 'failed' ? 'selected' : '' }}>Failed</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <select name="method" class="form-control" onchange="this.form.submit()">
                                    <option value="all" {{ request('method') == 'all' ? 'selected' : '' }}>All Methods</option>
                                    <option value="manual" {{ request('method') == 'manual' ? 'selected' : '' }}>Manual</option>
                                    <option value="razorpay" {{ request('method') == 'razorpay' ? 'selected' : '' }}>Razorpay</option>
                                    <option value="stripe" {{ request('method') == 'stripe' ? 'selected' : '' }}>Stripe</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <a href="{{ route('admin.plans.purchases.index') }}" class="btn btn-secondary">Reset Filters</a>
                            </div>
                        </div>
                    </form>

                    <!-- Purchases Table -->
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Professional</th>
                                    <th>Plan Name</th>
                                    <th>Price</th>
                                    <th>Leads</th>
                                    <th>Payment Status</th>
                                    <th>Purchase Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($purchases as $purchase)
                                <tr>
                                    <td>{{ $purchase->id }}</td>
                                    <td>
                                        <strong>{{ $purchase->professional->name }}</strong><br>
                                        <small class="text-muted">{{ $purchase->professional->email }}</small>
                                    </td>
                                    <td>{{ $purchase->plan_name }}</td>
                                    <td>₹{{ number_format($purchase->price, 2) }}</td>
                                    <td>
                                        {{ $purchase->leads_used }}/{{ $purchase->lead_limit }}<br>
                                        <small class="text-muted">Remaining: {{ $purchase->remaining_leads }}</small>
                                    </td>
                                    <td>
                                        @if($purchase->payment_status === 'success')
                                            <span class="badge badge-success">Success</span>
                                        @elseif($purchase->payment_status === 'pending')
                                            <span class="badge badge-warning">Pending</span>
                                            @if($purchase->payment_method === 'manual')
                                                <br><small class="text-info">Requires Approval</small>
                                            @endif
                                        @else
                                            <span class="badge badge-danger">Failed</span>
                                        @endif
                                        <br>
                                        <small class="text-muted">{{ ucfirst($purchase->payment_method) }}</small>
                                    </td>
                                    <td>
                                        {{ $purchase->created_at->format('d M, Y') }}<br>
                                        <small class="text-muted">{{ $purchase->created_at->format('h:i A') }}</small>
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.plans.purchases.show', $purchase->id) }}" class="btn btn-sm btn-info">
                                            <i class="fas fa-eye"></i> View
                                        </a>
                                        
                                        @if($purchase->payment_method === 'manual' && $purchase->payment_status === 'pending')
                                        <form action="{{ route('admin.plans.purchases.approve', $purchase->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-success" onclick="return confirm('Approve this purchase?')">
                                                <i class="fas fa-check"></i> Approve
                                            </button>
                                        </form>
                                        <button type="button" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#rejectModal{{ $purchase->id }}">
                                            <i class="fas fa-times"></i> Reject
                                        </button>

                                        <!-- Reject Modal -->
                                        <div class="modal fade" id="rejectModal{{ $purchase->id }}" tabindex="-1">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <form action="{{ route('admin.plans.purchases.reject', $purchase->id) }}" method="POST">
                                                        @csrf
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Reject Purchase</h5>
                                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="form-group">
                                                                <label>Reason for Rejection</label>
                                                                <textarea name="reason" class="form-control" rows="3" required></textarea>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                                            <button type="submit" class="btn btn-danger">Reject</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="8" class="text-center">No purchases found</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="mt-3">
                        {{ $purchases->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
