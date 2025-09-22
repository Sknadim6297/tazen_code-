@extends('customer.layout.layout')

@section('title', 'Payment - Re-requested Service')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Payment for Re-requested Service</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h6>Service Details</h6>
                            <table class="table table-borderless">
                                <tr>
                                    <td><strong>Service:</strong></td>
                                    <td>{{ $reRequestedService->service_name }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Professional:</strong></td>
                                    <td>{{ $reRequestedService->professional->name }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Reason:</strong></td>
                                    <td>{{ $reRequestedService->reason }}</td>
                                </tr>
                                @if($reRequestedService->admin_notes)
                                <tr>
                                    <td><strong>Admin Notes:</strong></td>
                                    <td>{{ $reRequestedService->admin_notes }}</td>
                                </tr>
                                @endif
                            </table>
                        </div>
                        
                        <div class="col-md-6">
                            <h6>Payment Breakdown</h6>
                            <table class="table table-borderless">
                                <tr>
                                    <td>Service Amount:</td>
                                    <td class="text-end">₹{{ number_format($reRequestedService->final_price, 2) }}</td>
                                </tr>
                                <tr>
                                    <td>GST (18%):</td>
                                    <td class="text-end">₹{{ number_format($reRequestedService->gst_amount, 2) }}</td>
                                </tr>
                                <tr class="border-top">
                                    <td><strong>Total Amount:</strong></td>
                                    <td class="text-end"><strong>₹{{ number_format($reRequestedService->total_amount, 2) }}</strong></td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <hr>

                    <div class="text-center">
                        <h5 class="mb-4">Choose Payment Method</h5>
                        
                        <button id="razorpay-btn" class="btn btn-success btn-lg me-3">
                            <i class="fas fa-credit-card"></i> Pay Now
                        </button>
                        
                        <a href="{{ route('user.customer.re-requested-service.do-later', $reRequestedService->id) }}" 
                           class="btn btn-warning btn-lg"
                           onclick="return confirm('You can pay later from your dashboard. Continue?')">
                            <i class="fas fa-clock"></i> Do Later
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<form id="payment-form" action="{{ route('user.customer.re-requested-service.process-payment', $reRequestedService->id) }}" method="POST" style="display: none;">
    @csrf
    <input type="hidden" name="razorpay_order_id" id="razorpay_order_id">
    <input type="hidden" name="razorpay_payment_id" id="razorpay_payment_id">
    <input type="hidden" name="razorpay_signature" id="razorpay_signature">
</form>
@endsection

@push('scripts')
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script>
document.getElementById('razorpay-btn').onclick = function(e) {
    e.preventDefault();
    
    var options = {
        "key": "{{ env('RAZORPAY_KEY') }}",
        "amount": "{{ $reRequestedService->total_amount * 100 }}",
        "currency": "INR",
        "name": "{{ config('app.name') }}",
        "description": "{{ $reRequestedService->service_name }}",
        "order_id": "{{ $order['id'] }}",
        "handler": function (response){
            document.getElementById('razorpay_order_id').value = response.razorpay_order_id;
            document.getElementById('razorpay_payment_id').value = response.razorpay_payment_id;
            document.getElementById('razorpay_signature').value = response.razorpay_signature;
            document.getElementById('payment-form').submit();
        },
        "prefill": {
            "name": "{{ auth()->user()->name }}",
            "email": "{{ auth()->user()->email }}",
            "contact": "{{ auth()->user()->phone ?? '' }}"
        },
        "notes": {
            "type": "Re-requested Service",
            "service_id": "{{ $reRequestedService->id }}"
        },
        "theme": {
            "color": "#3399cc"
        }
    };
    
    var rzp1 = new Razorpay(options);
    rzp1.on('payment.failed', function (response){
        alert('Payment failed. Please try again.');
    });
    
    rzp1.open();
}
</script>
@endpush
