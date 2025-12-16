@extends('professional.layout.layout')

@section('styles')
<style>
    :root {
        --primary: #4f46e5;
        --accent: #22c55e;
        --danger: #ef4444;
        --warning: #f59e0b;
        --page-bg: #f4f6fb;
        --card-bg: #ffffff;
        --text-dark: #0f172a;
        --text-muted: #64748b;
    }

    body,
    .app-content {
        background: var(--page-bg);
    }

    .myplan-page {
        width: 100%;
        padding: 2.6rem 1.35rem 3.5rem;
    }

    .myplan-shell {
        max-width: 900px;
        margin: 0 auto;
        display: flex;
        flex-direction: column;
        gap: 2rem;
    }

    .myplan-header {
        padding: 2rem 2.4rem;
        border-radius: 28px;
        border: 1px solid rgba(79, 70, 229, 0.18);
        background: linear-gradient(135deg, rgba(79, 70, 229, 0.12), rgba(14, 165, 233, 0.16));
        box-shadow: 0 24px 54px rgba(79, 70, 229, 0.16);
    }

    .myplan-header h1 {
        font-size: 2rem;
        font-weight: 700;
        color: var(--text-dark);
        margin: 0;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .plan-card-main {
        background: var(--card-bg);
        border: 1px solid rgba(148, 163, 184, 0.22);
        border-radius: 20px;
        padding: 2rem;
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.06);
    }

    .plan-status-alert {
        padding: 1rem 1.5rem;
        border-radius: 12px;
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
        font-weight: 500;
    }

    .plan-status-alert.expired {
        background: rgba(239, 68, 68, 0.1);
        border: 1px solid rgba(239, 68, 68, 0.2);
        color: #dc2626;
    }

    .plan-status-alert.pending {
        background: rgba(245, 158, 11, 0.1);
        border: 1px solid rgba(245, 158, 11, 0.2);
        color: #d97706;
    }

    .plan-overview {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
    }

    .plan-overview-card {
        background: linear-gradient(135deg, rgba(79, 70, 229, 0.08), rgba(14, 165, 233, 0.08));
        border: 1px solid rgba(79, 70, 229, 0.15);
        border-radius: 16px;
        padding: 1.5rem;
        text-align: center;
    }

    .plan-overview-card h3 {
        font-size: 2rem;
        font-weight: 800;
        color: var(--primary);
        margin: 0.5rem 0;
    }

    .plan-overview-card h4 {
        font-size: 1.75rem;
        font-weight: 700;
        color: var(--text-dark);
        margin: 0.5rem 0;
    }

    .plan-overview-card .badge {
        padding: 0.4rem 1rem;
        border-radius: 999px;
        font-size: 0.85rem;
        font-weight: 600;
    }

    .progress-wrapper {
        background: rgba(148, 163, 184, 0.1);
        border-radius: 12px;
        height: 40px;
        overflow: hidden;
        position: relative;
    }

    .progress-bar-custom {
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: 700;
        transition: width 0.5s ease;
    }

    .info-table {
        width: 100%;
        border-collapse: collapse;
        margin: 1.5rem 0;
    }

    .info-table tr {
        border-bottom: 1px solid rgba(148, 163, 184, 0.15);
    }

    .info-table tr:last-child {
        border-bottom: none;
    }

    .info-table th,
    .info-table td {
        padding: 1rem;
        text-align: left;
    }

    .info-table th {
        font-weight: 600;
        color: var(--text-dark);
        width: 35%;
    }

    .info-table td {
        color: var(--text-muted);
    }

    .features-card {
        background: rgba(34, 197, 94, 0.05);
        border: 1px solid rgba(34, 197, 94, 0.15);
        border-radius: 16px;
        padding: 1.5rem;
    }

    .features-card h5 {
        font-size: 1.2rem;
        font-weight: 700;
        color: var(--text-dark);
        margin-bottom: 1rem;
    }

    .features-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .features-list li {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        padding: 0.75rem 0;
        color: var(--text-dark);
    }

    .features-list i {
        color: var(--accent);
        font-size: 1.1rem;
    }

    .action-buttons {
        display: flex;
        gap: 1rem;
        flex-wrap: wrap;
    }

    .btn-action {
        padding: 0.75rem 1.5rem;
        border-radius: 12px;
        font-weight: 600;
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

    .btn-action.secondary {
        background: #e2e8f0;
        color: var(--text-dark);
    }

    .btn-action:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.15);
    }

    @media (max-width: 768px) {
        .myplan-page {
            padding: 1.5rem 1rem;
        }

        .myplan-header h1 {
            font-size: 1.5rem;
        }

        .plan-overview {
            grid-template-columns: 1fr;
        }
    }
</style>
@endsection

@section('content')
<div class="content-wrapper myplan-page">
    <div class="myplan-shell">
        <!-- Page Header -->
        <div class="myplan-header">
            <h1>
                <i class="fas fa-crown"></i>
                My Current Plan
            </h1>
        </div>

        <div class="plan-card-main">
            <!-- Status Alert -->
            @if($purchase->isExpired())
                <div class="plan-status-alert expired">
                    <i class="fas fa-exclamation-triangle"></i>
                    Your plan has expired on {{ $purchase->end_date->format('d M, Y') }}
                </div>
            @elseif($purchase->payment_status !== 'success')
                <div class="plan-status-alert pending">
                    <i class="fas fa-clock"></i>
                    Your payment is pending approval.
                </div>
            @endif

            <!-- Plan Overview Cards -->
            <div class="plan-overview">
                <div class="plan-overview-card">
                    <h3>{{ $purchase->plan_name }}</h3>
                    <h4>{{ $purchase->formatted_price }}</h4>
                    <span class="badge" style="background: {{ $purchase->payment_status === 'success' ? '#22c55e' : '#f59e0b' }}; color: white;">
                        {{ ucfirst($purchase->payment_status) }}
                    </span>
                </div>
                
                <div class="plan-overview-card">
                    <h5 style="color: var(--text-muted); margin: 0; font-size: 0.9rem;">Lead Usage</h5>
                    <div class="progress-wrapper mt-3">
                        @php
                            $percentage = ($purchase->leads_used / $purchase->lead_limit) * 100;
                            $barColor = $percentage > 80 ? '#ef4444' : ($percentage > 50 ? '#f59e0b' : '#22c55e');
                        @endphp
                        <div class="progress-bar-custom" style="width: {{ $percentage }}%; background: {{ $barColor }};">
                            {{ number_format($percentage, 1) }}%
                        </div>
                    </div>
                    <h4 style="margin-top: 1rem;">{{ $purchase->remaining_leads }} / {{ $purchase->lead_limit }}</h4>
                    <small style="color: var(--text-muted);">Leads Remaining</small>
                </div>
            </div>

            <!-- Plan Information Table -->
            <table class="info-table">
                <tr>
                    <th>Purchase Date:</th>
                    <td>{{ $purchase->created_at->format('d M, Y h:i A') }}</td>
                </tr>
                <tr>
                    <th>Start Date:</th>
                    <td>{{ $purchase->start_date ? $purchase->start_date->format('d M, Y') : 'N/A' }}</td>
                </tr>
                @if($purchase->end_date)
                    <tr>
                        <th>Expiry Date:</th>
                        <td>
                            {{ $purchase->end_date->format('d M, Y') }}
                            @if(!$purchase->isExpired())
                                <span class="badge" style="background: #3b82f6; color: white; margin-left: 0.5rem;">
                                    {{ now()->diffInDays($purchase->end_date) }} days remaining
                                </span>
                            @endif
                        </td>
                    </tr>
                @else
                    <tr>
                        <th>Validity:</th>
                        <td><span class="badge" style="background: #22c55e; color: white;">Unlimited</span></td>
                    </tr>
                @endif
                @if($purchase->payment_id)
                    <tr>
                        <th>Payment ID:</th>
                        <td><code style="background: #f1f5f9; padding: 0.25rem 0.5rem; border-radius: 4px;">{{ $purchase->payment_id }}</code></td>
                    </tr>
                @endif
                <tr>
                    <th>Payment Method:</th>
                    <td>{{ ucfirst($purchase->payment_method ?? 'N/A') }}</td>
                </tr>
            </table>

            <!-- Plan Features -->
            @if($purchase->features && is_array($purchase->features))
                <div class="features-card">
                    <h5>✨ Your Plan Features</h5>
                    <ul class="features-list">
                        @foreach($purchase->features as $feature)
                            <li>
                                <i class="fas fa-check-circle"></i>
                                {{ $feature }}
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Admin Notes -->
            @if($purchase->admin_notes)
                <div style="background: rgba(59, 130, 246, 0.1); border: 1px solid rgba(59, 130, 246, 0.2); border-radius: 12px; padding: 1rem; margin-top: 1.5rem;">
                    <strong style="color: #2563eb;">Admin Notes:</strong><br>
                    <span style="color: var(--text-muted);">{{ $purchase->admin_notes }}</span>
                </div>
            @endif

            <!-- Action Buttons -->
            <div class="action-buttons mt-4">
                <a href="{{ route('professional.plans.index') }}" class="btn-action primary">
                    <i class="fas fa-shopping-cart"></i>
                    Upgrade Plan
                </a>
                <a href="{{ route('professional.dashboard') }}" class="btn-action secondary">
                    <i class="fas fa-home"></i>
                    Dashboard
                </a>
            </div>

            <!-- Help Info -->
            <div style="background: rgba(245, 158, 11, 0.1); border: 1px solid rgba(245, 158, 11, 0.2); border-radius: 12px; padding: 1rem; margin-top: 1.5rem; color: #d97706;">
                <i class="fas fa-info-circle"></i>
                <strong>Need Help?</strong> If you have any issues with your plan, please contact our support team.
            </div>
        </div>
    </div>
</div>
@endsection
