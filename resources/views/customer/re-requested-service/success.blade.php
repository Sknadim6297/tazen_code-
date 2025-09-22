@extends('customer.layout.layout')

@section('title', 'Payment Successful')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg border-0">
                <div class="card-header bg-success text-white text-center py-4">
                    <div class="mb-3">
                        <i class="fas fa-check-circle fa-5x"></i>
                    </div>
                    <h2 class="mb-0">Payment Successful!</h2>
                </div>
                <div class="card-body p-5">
                    <div class="text-center mb-4">
                        <h4 class="text-success mb-3">Thank you for your payment</h4>
                        <p class="lead text-muted">Your payment for the additional service request has been processed successfully.</p>
                    </div>

                    <!-- Payment Details -->
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card bg-light">
                                <div class="card-header">
                                    <h6 class="mb-0"><i class="fas fa-info-circle"></i> Service Details</h6>
                                </div>
                                <div class="card-body">
                                    <table class="table table-borderless mb-0">
                                        <tr>
                                            <td><strong>Request ID:</strong></td>
                                            <td>#{{ $reRequestedService->id }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Service:</strong></td>
                                            <td>{{ $reRequestedService->service_name }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Professional:</strong></td>
                                            <td>{{ $reRequestedService->professional->name }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Payment Date:</strong></td>
                                            <td>{{ $reRequestedService->payment_completed_at->format('d M Y, h:i A') }}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="card bg-light">
                                <div class="card-header">
                                    <h6 class="mb-0"><i class="fas fa-rupee-sign"></i> Payment Summary</h6>
                                </div>
                                <div class="card-body">
                                    <table class="table table-borderless mb-0">
                                        <tr>
                                            <td><strong>Service Amount:</strong></td>
                                            <td>₹{{ number_format($reRequestedService->final_price, 2) }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>GST (18%):</strong></td>
                                            <td>₹{{ number_format($reRequestedService->gst_amount, 2) }}</td>
                                        </tr>
                                        <tr class="border-top">
                                            <td><strong>Total Paid:</strong></td>
                                            <td><strong class="text-success">₹{{ number_format($reRequestedService->total_amount, 2) }}</strong></td>
                                        </tr>
                                        <tr>
                                            <td><strong>Payment Status:</strong></td>
                                            <td><span class="badge bg-success">Paid</span></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- What's Next Section -->
                    <div class="card mt-4 border-info">
                        <div class="card-header bg-info text-white">
                            <h6 class="mb-0"><i class="fas fa-forward"></i> What's Next?</h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <h6><i class="fas fa-user-tie text-primary"></i> Professional Next Steps:</h6>
                                    <ul class="list-unstyled">
                                        <li><i class="fas fa-check text-success"></i> Professional has been notified of your payment</li>
                                        <li><i class="fas fa-check text-success"></i> They will proceed with the additional service</li>
                                        <li><i class="fas fa-check text-success"></i> You'll receive updates as the work progresses</li>
                                    </ul>
                                </div>
                                <div class="col-md-6">
                                    <h6><i class="fas fa-user text-primary"></i> Your Actions:</h6>
                                    <ul class="list-unstyled">
                                        <li><i class="fas fa-file-pdf text-info"></i> Download your invoice for records</li>
                                        <li><i class="fas fa-eye text-info"></i> Track progress in your dashboard</li>
                                        <li><i class="fas fa-phone text-info"></i> Contact support if you have questions</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="text-center mt-4">
                        <div class="d-flex justify-content-center gap-3 flex-wrap">
                            <a href="{{ route('user.customer.re-requested-service.invoice', $reRequestedService->id) }}" 
                               class="btn btn-primary btn-lg">
                                <i class="fas fa-download"></i> Download Invoice
                            </a>
                            
                            <a href="{{ route('user.customer.re-requested-service.show', $reRequestedService->id) }}" 
                               class="btn btn-outline-primary btn-lg">
                                <i class="fas fa-eye"></i> View Details
                            </a>
                            
                            <a href="{{ route('user.customer.re-requested-service.index') }}" 
                               class="btn btn-outline-secondary btn-lg">
                                <i class="fas fa-list"></i> All Requests
                            </a>
                            
                            <a href="{{ route('user.customer.dashboard') }}" 
                               class="btn btn-outline-dark btn-lg">
                                <i class="fas fa-tachometer-alt"></i> Dashboard
                            </a>
                        </div>
                    </div>

                    <!-- Support Information -->
                    <div class="text-center mt-4 pt-4 border-top">
                        <h6 class="text-muted">Need Help?</h6>
                        <p class="text-muted">
                            If you have any questions about your payment or service, please contact our support team.
                        </p>
                        <div class="d-flex justify-content-center gap-3">
                            <a href="mailto:support@example.com" class="btn btn-sm btn-outline-info">
                                <i class="fas fa-envelope"></i> Email Support
                            </a>
                            <a href="tel:+1234567890" class="btn btn-sm btn-outline-info">
                                <i class="fas fa-phone"></i> Call Support
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.card {
    border-radius: 15px;
}

.card-header {
    border-radius: 15px 15px 0 0 !important;
}

.fa-5x {
    font-size: 5rem;
}

.btn-lg {
    padding: 12px 30px;
    font-weight: 600;
}

.list-unstyled li {
    padding: 5px 0;
}

.border-top {
    border-top: 2px solid #dee2e6 !important;
}

@media (max-width: 768px) {
    .card-body {
        padding: 2rem 1rem;
    }
    
    .btn-lg {
        width: 100%;
        margin-bottom: 10px;
    }
    
    .d-flex.gap-3 {
        flex-direction: column;
        gap: 0.5rem !important;
    }
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Add some celebration animation
    setTimeout(function() {
        const icon = document.querySelector('.fa-check-circle');
        if (icon) {
            icon.style.transform = 'scale(1.1)';
            icon.style.transition = 'transform 0.3s ease';
            setTimeout(() => {
                icon.style.transform = 'scale(1)';
            }, 300);
        }
    }, 500);
    
    // Auto scroll to top on page load
    window.scrollTo(0, 0);
});
</script>
@endpush
