@extends('customer.layout.layout')

@section('title', 'Re-requested Service Details')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Request #{{ $reRequestedService->id }}</h5>
                </div>
                <div class="card-body">
                    <table class="table table-borderless">
                        <tr>
                            <th>Service</th>
                            <td>{{ $reRequestedService->service_name }}</td>
                        </tr>
                        <tr>
                            <th>Professional</th>
                            <td>
                                <strong>{{ $reRequestedService->professional->name ?? '-' }}</strong><br>
                                <small class="text-muted">{{ $reRequestedService->professional->email ?? '' }}</small>
                            </td>
                        </tr>
                        <tr>
                            <th>Reason</th>
                            <td>{{ $reRequestedService->reason }}</td>
                        </tr>
                        @if(!empty($reRequestedService->admin_notes))
                        <tr>
                            <th>Admin Notes</th>
                            <td>{{ $reRequestedService->admin_notes }}</td>
                        </tr>
                        @endif
                        <tr>
                            <th>Final Price</th>
                            <td>₹{{ number_format($reRequestedService->final_price, 2) }}</td>
                        </tr>
                        <tr>
                            <th>GST</th>
                            <td>₹{{ number_format($reRequestedService->gst_amount ?? 0, 2) }}</td>
                        </tr>
                        <tr>
                            <th>Total Amount</th>
                            <td>₹{{ number_format($reRequestedService->total_amount, 2) }}</td>
                        </tr>
                        <tr>
                            <th>Status</th>
                            <td>{!! $reRequestedService->status_badge ?? ucfirst($reRequestedService->status) !!}</td>
                        </tr>
                        <tr>
                            <th>Payment Status</th>
                            <td>{!! $reRequestedService->payment_status_badge ?? ucfirst($reRequestedService->payment_status) !!}</td>
                        </tr>
                    </table>

                    <div class="mt-3">
                        @if($reRequestedService->status === 'admin_approved' && $reRequestedService->payment_status === 'unpaid')
                            <a href="{{ route('user.customer.re-requested-service.payment', $reRequestedService->id) }}" class="btn btn-success">
                                <i class="fas fa-credit-card"></i> Pay Now
                            </a>

                            <form action="{{ route('user.customer.re-requested-service.do-later', $reRequestedService->id) }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-warning">
                                    <i class="fas fa-clock"></i> Pay Later
                                </button>
                            </form>
                        @endif

                        @if($reRequestedService->payment_status === 'paid')
                            <a href="{{ route('user.customer.re-requested-service.invoice', $reRequestedService->id) }}" class="btn btn-primary">
                                <i class="fas fa-download"></i> Download Invoice
                            </a>
                        @endif

                        <a href="{{ route('user.customer.re-requested-service.index') }}" class="btn btn-secondary">Back</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
