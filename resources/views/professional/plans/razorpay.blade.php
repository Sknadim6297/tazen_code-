@extends('professional.layout.layout')

@section('styles')
<style>
    :root {
        --primary: #4f46e5;
        --page-bg: #f4f6fb;
        --card-bg: #ffffff;
        --text-dark: #0f172a;
        --text-muted: #64748b;
    }

    body,
    .app-content {
        background: var(--page-bg);
    }

    .payment-page {
        width: 100%;
        padding: 2.6rem 1.35rem 3.5rem;
        min-height: 70vh;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .payment-shell {
        max-width: 600px;
        width: 100%;
    }

    .payment-card {
        background: var(--card-bg);
        border: 1px solid rgba(148, 163, 184, 0.22);
        border-radius: 20px;
        padding: 2.5rem;
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.06);
        text-align: center;
    }

    .payment-icon {
        width: 80px;
        height: 80px;
        background: linear-gradient(135deg, var(--primary), #6366f1);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1.5rem;
        animation: pulse 2s infinite;
    }

    @keyframes pulse {
        0%, 100% {
            transform: scale(1);
            box-shadow: 0 0 0 0 rgba(79, 70, 229, 0.4);
        }
        50% {
            transform: scale(1.05);
            box-shadow: 0 0 0 15px rgba(79, 70, 229, 0);
        }
    }

    .payment-icon i {
        font-size: 2.5rem;
        color: white;
    }

    .payment-title {
        font-size: 1.75rem;
        font-weight: 700;
        color: var(--text-dark);
        margin-bottom: 0.5rem;
    }

    .payment-subtitle {
        font-size: 0.95rem;
        color: var(--text-muted);
        margin-bottom: 2rem;
    }

    .payment-details {
        background: rgba(79, 70, 229, 0.05);
        border: 1px solid rgba(79, 70, 229, 0.15);
        border-radius: 12px;
        padding: 1.5rem;
        margin-bottom: 2rem;
        text-align: left;
    }

    .payment-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0.75rem 0;
        border-bottom: 1px solid rgba(148, 163, 184, 0.15);
    }

    .payment-row:last-child {
        border-bottom: none;
        font-weight: 700;
        font-size: 1.1rem;
        color: var(--primary);
        padding-top: 1rem;
    }

    .payment-label {
        color: var(--text-muted);
        font-weight: 500;
    }

    .payment-value {
        color: var(--text-dark);
        font-weight: 600;
    }

    .payment-button {
        width: 100%;
        padding: 1rem 2rem;
        background: linear-gradient(135deg, var(--primary), #6366f1);
        color: white;
        border: none;
        border-radius: 12px;
        font-size: 1rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        box-shadow: 0 4px 12px rgba(79, 70, 229, 0.3);
    }

    .payment-button:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(79, 70, 229, 0.4);
    }

    .payment-button:disabled {
        opacity: 0.6;
        cursor: not-allowed;
        transform: none;
    }

    .cancel-link {
        display: inline-block;
        margin-top: 1rem;
        color: var(--text-muted);
        text-decoration: none;
        font-size: 0.9rem;
        transition: color 0.2s;
    }

    .cancel-link:hover {
        color: var(--text-dark);
    }

    .spinner {
        display: inline-block;
        width: 16px;
        height: 16px;
        border: 2px solid rgba(255, 255, 255, 0.3);
        border-radius: 50%;
        border-top-color: white;
        animation: spin 1s linear infinite;
        margin-left: 0.5rem;
    }

    @keyframes spin {
        to { transform: rotate(360deg); }
    }
</style>
@endsection

@section('content')
<div class="payment-page">
    <div class="payment-shell">
        <div class="payment-card">
            <div class="payment-icon">
                <i class="fas fa-credit-card"></i>
            </div>

            <h1 class="payment-title">Complete Your Payment</h1>
            <p class="payment-subtitle">You're just one step away from activating your plan</p>

            <div class="payment-details">
                <div class="payment-row">
                    <span class="payment-label">Plan Name:</span>
                    <span class="payment-value">{{ $purchase->plan_name }}</span>
                </div>
                <div class="payment-row">
                    <span class="payment-label">Lead Limit:</span>
                    <span class="payment-value">{{ $purchase->lead_limit }} leads</span>
                </div>
                @if($purchase->end_date)
                <div class="payment-row">
                    <span class="payment-label">Validity:</span>
                    <span class="payment-value">{{ \Carbon\Carbon::parse($purchase->start_date)->diffInDays($purchase->end_date) }} days</span>
                </div>
                @endif
                <div class="payment-row">
                    <span class="payment-label">Amount:</span>
                    <span class="payment-value">{{ $purchase->formatted_price }}</span>
                </div>
            </div>

            <button type="button" id="razorpay-button" class="payment-button">
                <i class="fas fa-lock"></i> Pay Securely
            </button>

            <a href="{{ route('professional.plans.index') }}" class="cancel-link">
                <i class="fas fa-arrow-left"></i> Cancel Payment
            </a>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const button = document.getElementById('razorpay-button');
    
    const options = {
        key: '{{ $razorpayKey }}',
        amount: {{ $order['amount'] }},
        currency: '{{ $order['currency'] }}',
        name: 'Professional Plan',
        description: '{{ $purchase->plan_name }} Plan Purchase',
        order_id: '{{ $order['id'] }}',
        handler: function (response) {
            // Show loading state
            button.disabled = true;
            button.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Verifying Payment...';
            
            // Send payment details to server for verification
            fetch('{{ route("professional.plans.razorpay-callback") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    razorpay_payment_id: response.razorpay_payment_id,
                    razorpay_order_id: response.razorpay_order_id,
                    razorpay_signature: response.razorpay_signature,
                    purchase_id: {{ $purchase->id }}
                })
            })
            .then(res => res.json())
            .then(data => {
                if (data.success || data.status === 'success') {
                    // Redirect to success page
                    window.location.href = '{{ route("professional.plans.success", $purchase->id) }}';
                } else {
                    alert('Payment verification failed. Please contact support.');
                    button.disabled = false;
                    button.innerHTML = '<i class="fas fa-lock"></i> Pay Securely';
                }
            })
            .catch(error => {
                console.error('Payment verification error:', error);
                alert('An error occurred during payment verification. Please contact support.');
                button.disabled = false;
                button.innerHTML = '<i class="fas fa-lock"></i> Pay Securely';
            });
        },
        prefill: {
            name: '{{ Auth::user()->name }}',
            email: '{{ Auth::user()->email }}',
            contact: '{{ Auth::user()->phone ?? '' }}'
        },
        notes: {
            purchase_id: '{{ $purchase->id }}',
            plan_name: '{{ $purchase->plan_name }}'
        },
        theme: {
            color: '#4f46e5'
        },
        modal: {
            ondismiss: function() {
                button.disabled = false;
                console.log('Payment cancelled by user');
            }
        }
    };
    
    const rzp = new Razorpay(options);
    
    rzp.on('payment.failed', function (response){
        console.error('Payment failed:', response.error);
        alert('Payment failed: ' + response.error.description);
        button.disabled = false;
    });
    
    button.addEventListener('click', function(e) {
        e.preventDefault();
        button.disabled = true;
        button.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Opening Payment Gateway...';
        
        try {
            rzp.open();
        } catch (error) {
            console.error('Razorpay error:', error);
            alert('Failed to open payment gateway. Please try again.');
            button.disabled = false;
            button.innerHTML = '<i class="fas fa-lock"></i> Pay Securely';
        }
    });
    
    // Auto-trigger payment after 1 second
    setTimeout(function() {
        if (!button.disabled) {
            button.click();
        }
    }, 1000);
});
</script>
@endsection
