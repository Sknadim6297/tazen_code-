@extends('professional.layout.layout')

@section('styles')
<style>
    :root {
        --success: #22c55e;
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

    .success-page {
        width: 100%;
        padding: 2.6rem 1.35rem 3.5rem;
        min-height: 70vh;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .success-shell {
        max-width: 700px;
        width: 100%;
    }

    .success-card {
        background: var(--card-bg);
        border: 2px solid rgba(34, 197, 94, 0.3);
        border-radius: 24px;
        padding: 3rem;
        box-shadow: 0 20px 60px rgba(34, 197, 94, 0.15);
        text-align: center;
    }

    .success-icon {
        width: 100px;
        height: 100px;
        background: linear-gradient(135deg, var(--success), #16a34a);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 2rem;
        animation: scaleIn 0.5s ease;
    }

    .success-icon i {
        font-size: 50px;
        color: white;
    }

    @keyframes scaleIn {
        from {
            transform: scale(0);
        }
        to {
            transform: scale(1);
        }
    }

    .success-title {
        font-size: 2rem;
        font-weight: 700;
        color: var(--success);
        margin-bottom: 1rem;
    }

    .success-subtitle {
        background: linear-gradient(135deg, rgba(34, 197, 94, 0.1), rgba(34, 197, 94, 0.05));
        border: 1px solid rgba(34, 197, 94, 0.2);
        border-radius: 12px;
        padding: 1.25rem;
        margin-bottom: 2rem;
    }

    .success-subtitle h4 {
        font-size: 1.3rem;
        font-weight: 700;
        color: var(--text-dark);
        margin: 0;
    }

    .detail-card {
        background: rgba(79, 70, 229, 0.05);
        border: 1px solid rgba(79, 70, 229, 0.15);
        border-radius: 16px;
        padding: 2rem;
        margin-bottom: 2rem;
        text-align: left;
    }

    .detail-card h5 {
        font-size: 1.2rem;
        font-weight: 700;
        color: var(--text-dark);
        margin-bottom: 1.5rem;
        text-align: center;
    }

    .detail-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1.5rem;
    }

    .detail-item {
        text-align: center;
    }

    .detail-item strong {
        display: block;
        color: var(--text-dark);
        font-weight: 600;
        margin-bottom: 0.5rem;
        font-size: 0.9rem;
    }

    .detail-item span,
    .detail-item code {
        display: block;
        color: var(--text-muted);
        font-size: 1rem;
    }

    .detail-item code {
        background: rgba(79, 70, 229, 0.1);
        padding: 0.5rem 1rem;
        border-radius: 8px;
        font-size: 0.85rem;
        word-break: break-all;
    }

    .detail-item .badge {
        padding: 0.5rem 1rem;
        border-radius: 999px;
        font-weight: 600;
        font-size: 0.9rem;
    }

    .features-section {
        background: rgba(34, 197, 94, 0.05);
        border: 1px solid rgba(34, 197, 94, 0.15);
        border-radius: 12px;
        padding: 1.5rem;
        margin-bottom: 2rem;
    }

    .features-section h6 {
        font-weight: 700;
        color: var(--text-dark);
        margin-bottom: 1rem;
        text-align: center;
    }

    .features-section ul {
        list-style: none;
        padding: 0;
        margin: 0;
        text-align: left;
        columns: 2;
        column-gap: 2rem;
    }

    .features-section li {
        padding: 0.5rem 0;
        color: var(--text-dark);
    }

    .action-buttons {
        display: flex;
        gap: 1rem;
        justify-content: center;
        flex-wrap: wrap;
    }

    .btn-action {
        padding: 1rem 2rem;
        border-radius: 12px;
        font-weight: 600;
        font-size: 1rem;
        border: none;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }

    .btn-action.primary {
        background: linear-gradient(135deg, var(--primary), #4338ca);
        color: white;
    }

    .btn-action.success {
        background: linear-gradient(135deg, var(--success), #16a34a);
        color: white;
    }

    .btn-action:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.15);
        color: white;
    }

    .info-note {
        background: rgba(59, 130, 246, 0.1);
        border: 1px solid rgba(59, 130, 246, 0.2);
        border-radius: 12px;
        padding: 1rem 1.5rem;
        color: #2563eb;
        margin-bottom: 2rem;
        font-size: 0.95rem;
    }

    @media (max-width: 768px) {
        .success-page {
            padding: 1.5rem 1rem;
        }

        .success-card {
            padding: 2rem 1.5rem;
        }

        .success-title {
            font-size: 1.5rem;
        }

        .features-section ul {
            columns: 1;
        }

        .action-buttons {
            flex-direction: column;
        }

        .btn-action {
            width: 100%;
            justify-content: center;
        }
    }
</style>
@endsection

@section('content')
<div class="content-wrapper success-page">
    <div class="success-shell">
        <div class="success-card">
            <div class="success-icon">
                <i class="fas fa-check-circle"></i>
            </div>
            
            <h2 class="success-title">Payment Successful!</h2>
            
            <div class="success-subtitle">
                <h4>Your {{ $purchase->plan_name }} Plan is Now Active</h4>
            </div>

            <div class="detail-card">
                <h5>Plan Details:</h5>
                <div class="detail-grid">
                    <div class="detail-item">
                        <strong>Plan Name:</strong>
                        <span>{{ $purchase->plan_name }}</span>
                    </div>
                    <div class="detail-item">
                        <strong>Price Paid:</strong>
                        <span>{{ $purchase->formatted_price }}</span>
                    </div>
                    <div class="detail-item">
                        <strong>Lead Limit:</strong>
                        <span>{{ $purchase->lead_limit }} leads</span>
                    </div>
                    <div class="detail-item">
                        <strong>Payment Status:</strong>
                        <span class="badge" style="background: #22c55e; color: white;">{{ ucfirst($purchase->payment_status) }}</span>
                    </div>
                    @if($purchase->payment_id)
                        <div class="detail-item" style="grid-column: 1 / -1;">
                            <strong>Payment ID:</strong>
                            <code>{{ $purchase->payment_id }}</code>
                        </div>
                    @endif
                </div>
            </div>

            @if($purchase->features && is_array($purchase->features))
                <div class="features-section">
                    <h6>✨ Your Plan Features</h6>
                    <ul>
                        @foreach($purchase->features as $feature)
                            <li><i class="fas fa-check" style="color: #22c55e; margin-right: 0.5rem;"></i>{{ $feature }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="action-buttons">
                <a href="{{ route('professional.plans.my-plan') }}" class="btn-action primary">
                    <i class="fas fa-eye"></i>
                    View My Plan
                </a>
                <a href="{{ route('professional.dashboard') }}" class="btn-action success">
                    <i class="fas fa-home"></i>
                    Go to Dashboard
                </a>
            </div>

            <div class="info-note mt-4">
                <i class="fas fa-info-circle"></i>
                If you have any issues or questions, please contact support.
            </div>
        </div>
    </div>
</div>
@endsection
