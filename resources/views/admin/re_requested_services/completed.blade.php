@extends('admin.layouts.layout')

@section('styles')
<style>
    .stats-card {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 15px;
        padding: 20px;
        color: white;
        margin-bottom: 20px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease;
    }
    .stats-card:hover {
        transform: translateY(-5px);
    }
    
    .table-card {
        background: white;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
    }
    
    .status-badge {
        padding: 6px 12px;
        border-radius: 15px;
        font-size: 0.8rem;
        font-weight: 500;
    }
    .status-success { background: #d4edda; color: #155724; }
    .status-info { background: #d1ecf9; color: #0c5460; }
    .status-warning { background: #fff3cd; color: #856404; }
    
    .price-display {
        font-weight: 600;
        color: #28a745;
    }
</style>
@endsection

@section('content')
<div class="d-sm-flex d-block align-items-center justify-content-between page-header-breadcrumb">
    <h4 class="fw-medium mb-0">Completed Consultations</h4>
    <div class="ms-sm-1 ms-0">
        <nav>
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Completed Consultations</li>
            </ol>
        </nav>
    </div>
</div>

<div class="main-content app-content">
    <div class="container-fluid">
        <!-- Stats Overview -->
        <div class="row">
            <div class="col-xl-3 col-lg-6 col-md-6 col-xm-12">
                <div class="stats-card">
                    <div class="stats-number">{{ $completedServices->total() }}</div>
                    <div class="stats-label">Total Completed Services</div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-6 col-md-6 col-xm-12">
                <div class="stats-card">
                    <div class="stats-number">₹{{ number_format($completedServices->sum('professional_final_amount'), 2) }}</div>
                    <div class="stats-label">Total Professional Earnings</div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-6 col-md-6 col-xm-12">
                <div class="stats-card">
                    <div class="stats-number">₹{{ number_format($completedServices->sum('final_price'), 2) }}</div>
                    <div class="stats-label">Total Revenue</div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-6 col-md-6 col-xm-12">
                <div class="stats-card">
                    <div class="stats-number">{{ $completedServices->where('professional_payment_status', 'processed')->count() }}</div>
                    <div class="stats-label">Payments Processed</div>
                </div>
            </div>
        </div>

        <!-- Completed Services Table -->
        <div class="row">
            <div class="col-xl-12">
                <div class="table-card">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Service Details</th>
                                    <th>Professional</th>
                                    <th>Customer</th>
                                    <th>Service Price</th>
                                    <th>Professional Earning</th>
                                    <th>Completed Date</th>
                                    <th>Payment Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($completedServices as $service)
                                    <tr>
                                        <td>
                                            <span class="badge badge-primary">#{{ $service->id }}</span>
                                        </td>
                                        <td>
                                            <div>
                                                <strong>{{ Str::limit($service->service_name, 30) }}</strong>
                                                <br><small class="text-muted">{{ Str::limit($service->reason, 50) }}</small>
                                            </div>
                                        </td>
                                        <td>
                                            <div>
                                                <strong>{{ $service->professional->name }}</strong>
                                                <br><small class="text-muted">{{ $service->professional->email }}</small>
                                            </div>
                                        </td>
                                        <td>
                                            <div>
                                                <strong>{{ $service->user->name }}</strong>
                                                <br><small class="text-muted">{{ $service->user->email }}</small>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="price-display">
                                                ₹{{ number_format($service->final_price, 2) }}
                                            </div>
                                        </td>
                                        <td>
                                            <div class="price-display text-success">
                                                @if($service->professional_final_amount)
                                                    ₹{{ number_format($service->professional_final_amount, 2) }}
                                                    <br><small class="text-muted">({{ $service->professional_percentage_amount }}%)</small>
                                                @else
                                                    <span class="text-muted">Not Calculated</span>
                                                @endif
                                            </div>
                                        </td>
                                        <td>
                                            {{ $service->customer_confirmed_at->format('M d, Y') }}
                                            <br><small class="text-muted">{{ $service->customer_confirmed_at->format('h:i A') }}</small>
                                        </td>
                                        <td>
                                            @if($service->professional_payment_status === 'processed')
                                                <span class="status-badge status-success">Paid</span>
                                            @else
                                                <span class="status-badge status-warning">Pending</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($service->professional_payment_status !== 'processed')
                                                <form method="POST" action="{{ route('admin.re-requested-services.process-payment', $service) }}" 
                                                      style="display: inline;" onsubmit="return confirm('Are you sure you want to process payment for this professional?')">
                                                    @csrf
                                                    <button type="submit" class="btn btn-success btn-sm">
                                                        <i class="fas fa-money-bill-wave"></i> Process Payment
                                                    </button>
                                                </form>
                                            @endif
                                            <a href="{{ route('admin.re-requested-services.show', $service) }}" class="btn btn-info btn-sm">
                                                <i class="fas fa-eye"></i> View
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="9" class="text-center py-4">
                                            <div class="text-muted">
                                                <i class="fas fa-inbox fa-3x mb-3"></i>
                                                <p>No completed consultations found.</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    @if($completedServices->hasPages())
                        <div class="card-footer">
                            <div class="d-flex justify-content-center">
                                {{ $completedServices->links() }}
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
$(document).ready(function() {
    // Add any additional JavaScript functionality here
});
</script>
@endsection
