@extends('customer.layout.layout')

@section('title', 'Re-requested Services')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Re-requested Services</h5>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if(session('info'))
                        <div class="alert alert-info alert-dismissible fade show" role="alert">
                            {{ session('info') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if($reRequestedServices->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead class="table-dark">
                                    <tr>
                                        <th>ID</th>
                                        <th>Professional</th>
                                        <th>Service Name</th>
                                        <th>Reason</th>
                                        <th>Amount</th>
                                        <th>Status</th>
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
                                                <strong>{{ $service->professional->name }}</strong><br>
                                                <small class="text-muted">{{ $service->professional->email }}</small>
                                            </td>
                                            <td>{{ $service->service_name }}</td>
                                            <td>
                                                <div class="text-truncate" style="max-width: 200px;" title="{{ $service->reason }}">
                                                    {{ Str::limit($service->reason, 50) }}
                                                </div>
                                            </td>
                                            <td>
                                                <strong>₹{{ number_format($service->total_amount, 2) }}</strong><br>
                                                <small class="text-muted">
                                                    (₹{{ number_format($service->final_price, 2) }} + ₹{{ number_format($service->gst_amount, 2) }} GST)
                                                </small>
                                            </td>
                                            <td>{!! $service->status_badge !!}</td>
                                            <td>{!! $service->payment_status_badge !!}</td>
                                            <td>{{ $service->requested_at->format('d M Y, h:i A') }}</td>
                                            <td>
                                                <a href="{{ route('user.customer.re-requested-service.show', $service->id) }}" 
                                                   class="btn btn-sm btn-info" title="View Details">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                
                                                @if($service->status === 'admin_approved' && $service->payment_status === 'unpaid')
                                                    <a href="{{ route('user.customer.re-requested-service.payment', $service->id) }}" 
                                                       class="btn btn-sm btn-success" title="Pay Now">
                                                        <i class="fas fa-credit-card"></i> Pay
                                                    </a>
                                                    
                                                    <form action="{{ route('user.customer.re-requested-service.do-later', $service->id) }}" 
                                                          method="POST" class="d-inline">
                                                        @csrf
                                                        <button type="submit" class="btn btn-sm btn-warning" title="Do Later">
                                                            <i class="fas fa-clock"></i> Later
                                                        </button>
                                                    </form>
                                                @endif
                                                
                                                @if($service->payment_status === 'paid')
                                                    <a href="{{ route('user.customer.re-requested-service.invoice', $service->id) }}" 
                                                       class="btn btn-sm btn-primary" title="Download Invoice">
                                                        <i class="fas fa-download"></i> Invoice
                                                    </a>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="d-flex justify-content-center">
                            {{ $reRequestedServices->links() }}
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">No re-requested services found</h5>
                            <p class="text-muted">No professionals have requested additional services from you yet.</p>
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
