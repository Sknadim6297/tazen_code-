@extends('professional.layout.layout')

@section('styles')
<style>
    :root {
        --primary: #4f46e5;
        --primary-dark: #4338ca;
        --secondary: #0ea5e9;
        --accent: #22c55e;
        --muted: #64748b;
        --page-bg: #f4f6fb;
        --card-bg: #ffffff;
        --border: rgba(148, 163, 184, 0.22);
    }

    body,
    .app-content {
        background: var(--page-bg);
    }

    .billing-index-page {
        width: 100%;
        padding: 2.6rem 1.45rem 3.6rem;
    }

    .billing-shell {
        max-width: 1240px;
        margin: 0 auto;
        display: flex;
        flex-direction: column;
        gap: 2rem;
    }

    .billing-hero {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        justify-content: space-between;
        gap: 1.4rem;
        padding: 2rem 2.4rem;
        border-radius: 28px;
        border: 1px solid rgba(79, 70, 229, 0.18);
        background: linear-gradient(135deg, rgba(79, 70, 229, 0.12), rgba(14, 165, 233, 0.14));
        position: relative;
        overflow: hidden;
        box-shadow: 0 24px 54px rgba(79, 70, 229, 0.16);
    }

    .billing-hero::before,
    .billing-hero::after {
        content: "";
        position: absolute;
        border-radius: 50%;
        pointer-events: none;
    }

    .billing-hero::before {
        width: 360px;
        height: 360px;
        top: -48%;
        right: -14%;
        background: rgba(79, 70, 229, 0.2);
    }

    .billing-hero::after {
        width: 240px;
        height: 240px;
        bottom: -45%;
        left: -12%;
        background: rgba(14, 165, 233, 0.18);
    }

    .billing-hero > * {
        position: relative;
        z-index: 1;
    }

    .hero-meta {
        display: flex;
        flex-direction: column;
        gap: 0.8rem;
        color: var(--muted);
    }

    .hero-eyebrow {
        display: inline-flex;
        align-items: center;
        gap: 0.45rem;
        padding: 0.38rem 1.05rem;
        border-radius: 999px;
        background: rgba(255, 255, 255, 0.42);
        border: 1px solid rgba(255, 255, 255, 0.6);
        font-size: 0.72rem;
        font-weight: 600;
        letter-spacing: 0.12em;
        text-transform: uppercase;
        color: #0f172a;
    }

    .hero-meta h1 {
        margin: 0;
        font-size: 2rem;
        font-weight: 700;
        color: #0f172a;
    }

    .hero-breadcrumb {
        margin: 0;
        padding: 0;
        list-style: none;
        display: flex;
        flex-wrap: wrap;
        gap: 0.6rem;
        font-size: 0.86rem;
        color: var(--muted);
    }

    .hero-breadcrumb li a {
        color: var(--primary);
        text-decoration: none;
    }

    .filters-card {
        background: var(--card-bg);
        border-radius: 24px;
        border: 1px solid var(--border);
        box-shadow: 0 20px 48px rgba(15, 23, 42, 0.14);
        padding: 1.9rem 2rem;
        display: flex;
        flex-direction: column;
        gap: 1.25rem;
    }

    .filters-card__head {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 1rem;
    }

    .filters-card__head h2 {
        margin: 0;
        font-size: 1.1rem;
        font-weight: 700;
        color: #0f172a;
        display: flex;
        align-items: center;
        gap: 0.6rem;
    }

    .filter-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 1.2rem;
    }

    .filter-group {
        display: flex;
        flex-direction: column;
        gap: 0.55rem;
    }

    .filter-group label {
        font-weight: 600;
        color: #0f172a;
        font-size: 0.9rem;
    }

    .filter-group input,
    .filter-group select {
        border-radius: 14px;
        border: 1px solid rgba(148, 163, 184, 0.35);
        padding: 0.65rem 0.85rem;
        font-size: 0.9rem;
        transition: border 0.2s ease, box-shadow 0.2s ease;
    }

    .filter-group input:focus,
    .filter-group select:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.12);
        outline: none;
    }

    .filters-actions {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        gap: 0.8rem;
    }

    .btn-primary,
    .btn-neutral {
        border-radius: 999px;
        border: none;
        padding: 0.8rem 1.5rem;
        font-weight: 600;
        font-size: 0.9rem;
        display: inline-flex;
        align-items: center;
        gap: 0.45rem;
        cursor: pointer;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
        text-decoration: none;
    }

    .btn-primary {
        background: linear-gradient(135deg, var(--primary), var(--primary-dark));
        color: #ffffff;
        box-shadow: 0 18px 40px rgba(79, 70, 229, 0.22);
    }

    .btn-neutral {
        background: rgba(148, 163, 184, 0.18);
        color: #0f172a;
        border: 1px solid rgba(148, 163, 184, 0.35);
    }

    .btn-primary:hover,
    .btn-neutral:hover {
        transform: translateY(-1px);
    }

    .table-card {
        background: var(--card-bg);
        border-radius: 24px;
        border: 1px solid var(--border);
        box-shadow: 0 20px 56px rgba(15, 23, 42, 0.14);
        overflow: hidden;
    }

    .table-card__head {
        padding: 1.7rem 2.1rem 1.2rem;
        border-bottom: 1px solid rgba(148, 163, 184, 0.22);
        display: flex;
        flex-direction: column;
        gap: 0.35rem;
    }

    .table-card__head h3 {
        margin: 0;
        font-size: 1.1rem;
        font-weight: 700;
        color: #0f172a;
    }

    .table-card__head p {
        margin: 0;
        color: var(--muted);
        font-size: 0.9rem;
    }

    .table-card__body {
        padding: 2.1rem 2.1rem;
        display: flex;
        flex-direction: column;
        gap: 1.6rem;
    }

    .table-wrapper {
        border-radius: 18px;
        border: 1px solid rgba(226, 232, 240, 0.85);
        overflow-x: auto;
        overflow-y: hidden;
        -webkit-overflow-scrolling: touch;
    }

    .data-table {
        width: 100%;
        min-width: 1100px;
        border-collapse: separate;
        border-spacing: 0;
        font-size: 0.92rem;
    }

    .data-table thead th {
        background: rgba(79, 70, 229, 0.08);
        padding: 0.95rem 1rem;
        text-align: center;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        color: #0f172a;
    }

    .data-table tbody td {
        padding: 0.85rem 1rem;
        border-bottom: 1px solid rgba(226, 232, 240, 0.8);
        color: #0f172a;
        text-align: center;
        background: #ffffff;
    }

    .data-table tbody tr:hover {
        background: rgba(226, 232, 240, 0.35);
    }

    .data-table tbody td:first-child,
    .data-table thead th:first-child {
        text-align: left;
    }

    .amount { font-weight: 700; color: #0f172a; }
    .amount.net { color: #15803d; }
    .amount.deduction { color: #b91c1c; }

    .badge {
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        padding: 0.35rem 0.75rem;
        border-radius: 999px;
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }

    .badge.paid { background: rgba(34, 197, 94, 0.18); color: #166534; }
    .badge.unpaid { background: rgba(248, 113, 113, 0.18); color: #b91c1c; }

    .badge-plan {
        display: inline-flex;
        align-items: center;
        padding: 0.35rem 0.75rem;
        border-radius: 10px;
        font-size: 0.76rem;
        font-weight: 600;
        color: #0f172a;
        background: rgba(79, 70, 229, 0.12);
    }

    .invoice-actions {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        justify-content: center;
    }

    .invoice-btn {
        width: 38px;
        height: 38px;
        border-radius: 12px;
        border: none;
        background: rgba(79, 70, 229, 0.12);
        color: #4338ca;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: transform 0.18s ease, box-shadow 0.18s ease;
        text-decoration: none;
    }

    .invoice-btn:hover {
        transform: translateY(-1px);
        box-shadow: 0 12px 24px rgba(79, 70, 229, 0.18);
    }

    .invoice-btn.customer {
        background: rgba(34, 197, 94, 0.14);
        color: #15803d;
    }

    .summary-card {
        display: flex;
        flex-direction: column;
        gap: 0.9rem;
        background: linear-gradient(135deg, rgba(14, 165, 233, 0.12), rgba(79, 70, 229, 0.12));
        border-radius: 16px;
        padding: 1.25rem 1.4rem;
        border: 1px solid rgba(148, 163, 184, 0.18);
    }

    .summary-card span { font-size: 0.82rem; color: var(--muted); font-weight: 600; }
    .summary-card strong { font-size: 1rem; color: #0f172a; }

    .empty-state {
        text-align: center;
        padding: 3.4rem 1.6rem;
        border-radius: 22px;
        border: 1px dashed rgba(79, 70, 229, 0.22);
        background: rgba(79, 70, 229, 0.08);
        color: var(--muted);
    }

    .mobile-totals { display: none; }

    @media (max-width: 1024px) {
        .billing-index-page { padding: 2.2rem 1rem 3.2rem; }
        .filters-card { padding: 1.7rem 1.6rem; }
        .table-card__body { padding: 1.7rem 1.6rem; }
    }

    @media (max-width: 768px) {
        .billing-hero { padding: 1.75rem 1.6rem; }
        .filters-actions { flex-direction: column; align-items: stretch; }
        .btn-primary,
        .btn-neutral { width: 100%; justify-content: center; }
        .table-wrapper { overflow: visible; }
        .data-table { display: block; min-width: auto; }
        .data-table thead { display: none; }
        .data-table tbody { display: grid; gap: 1rem; }
        .data-table tbody tr {
            display: grid;
            gap: 0.65rem;
            border: 1px solid rgba(148, 163, 184, 0.22);
            border-radius: 16px;
            padding: 1.2rem 1rem;
            background: #ffffff;
            box-shadow: 0 12px 28px rgba(15, 23, 42, 0.12);
        }
        .data-table tbody td {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border: none;
            padding: 0.35rem 0;
        }
        .data-table tbody td::before {
            content: attr(data-label);
            font-weight: 600;
            color: var(--muted);
        }
        .invoice-actions { justify-content: flex-start; }
        .mobile-totals { display: block; }
    }
</style>
@endsection

@section('content')
<div class="billing-index-page">
    <div class="billing-shell">
        <section class="billing-hero">
            <div class="hero-meta">
                <span class="hero-eyebrow"><i class="fas fa-file-invoice-dollar"></i>Billing</span>
                <h1>Billing Summary</h1>
                <ul class="hero-breadcrumb">
                    <li><a href="{{ route('professional.dashboard') }}">Home</a></li>
                    <li class="active" aria-current="page">Billing</li>
                </ul>
            </div>
            <div class="summary-card">
                <span>Total Professional Earnings</span>
                <strong>₹{{ number_format($bookings->sum('professional_earning'), 2) }}</strong>
                <span style="font-size:0.78rem; color:var(--muted);">After platform fees and GST</span>
            </div>
        </section>

        <section class="filters-card">
            <header class="filters-card__head">
                <h2><i class="fas fa-filter"></i>Filter Billing</h2>
            </header>
            <form action="{{ route('professional.billing.index') }}" method="GET" class="filter-form">
                <div class="filter-grid">
                    <div class="filter-group">
                        <label for="search_date_from">From Date</label>
                        <input type="date" id="search_date_from" name="search_date_from" value="{{ request('search_date_from') }}">
                    </div>
                    <div class="filter-group">
                        <label for="search_date_to">To Date</label>
                        <input type="date" id="search_date_to" name="search_date_to" value="{{ request('search_date_to') }}">
                    </div>
                    <div class="filter-group">
                        <label for="plan_type">Plan Type</label>
                        <select id="plan_type" name="plan_type">
                            <option value="">All Plans</option>
                            <option value="monthly" {{ request('plan_type') == 'monthly' ? 'selected' : '' }}>Monthly</option>
                            <option value="quarterly" {{ request('plan_type') == 'quarterly' ? 'selected' : '' }}>Quarterly</option>
                            <option value="free_hand" {{ request('plan_type') == 'free_hand' ? 'selected' : '' }}>Free Hand</option>
                            <option value="one_time" {{ request('plan_type') == 'one_time' ? 'selected' : '' }}>One Time</option>
                        </select>
                    </div>
                    <div class="filter-group">
                        <label for="payment_status">Payment Status</label>
                        <select id="payment_status" name="payment_status">
                            <option value="">All Status</option>
                            <option value="paid" {{ request('payment_status') == 'paid' ? 'selected' : '' }}>Paid</option>
                            <option value="unpaid" {{ request('payment_status') == 'unpaid' ? 'selected' : '' }}>Unpaid</option>
                        </select>
                    </div>
                </div>
                <div class="filters-actions">
                    <button type="submit" class="btn-primary">
                        <i class="fas fa-search"></i>
                        Apply Filters
                    </button>
                    <a href="{{ route('professional.billing.index') }}" class="btn-neutral">
                        <i class="fas fa-undo"></i>
                        Reset
                    </a>
                </div>
            </form>
        </section>

        <section class="table-card">
            <header class="table-card__head">
                <h3>Billing Overview</h3>
                <p>Track customer payments, platform deductions, and your net earnings in real time.</p>
            </header>
            <div class="table-card__body">
                <div class="table-wrapper">
                    @if($bookings->isEmpty())
                        <div class="empty-state">
                            <i class="fas fa-receipt" style="font-size:2.4rem; color:var(--primary);"></i>
                            <p>No billing records available yet.</p>
                        </div>
                    @else
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>Customer Name</th>
                                    <th>Session Type</th>
                                    <th>Month</th>
                                    <th>Customer Amount</th>
                                    <th>Platform Fee</th>
                                    <th>GST (18%)</th>
                                    <th>Total Deduction</th>
                                    <th>Professional Earning</th>
                                    <th>Status</th>
                                    <th>Professional Invoice</th>
                                    <th>Customer Invoice</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($bookings as $booking)
                                    <tr>
                                        <td data-label="Customer Name">{{ $booking->customer_name }}</td>
                                        <td data-label="Session Type">
                                            <span class="badge-plan">{{ ucwords(str_replace('_', ' ', $booking->plan_type)) }}</span>
                                        </td>
                                        <td data-label="Month">{{ $booking->month }}</td>
                                        <td data-label="Customer Amount" class="amount">₹{{ number_format($booking->customer_amount, 2) }}</td>
                                        <td data-label="Platform Fee" class="amount">₹{{ number_format($booking->platform_fee, 2) }}</td>
                                        <td data-label="GST (18%)" class="amount">₹{{ number_format($booking->platform_cgst + $booking->platform_sgst, 2) }}</td>
                                        <td data-label="Total Deduction" class="amount deduction">₹{{ number_format($booking->total_platform_cut, 2) }}</td>
                                        <td data-label="Professional Earning" class="amount net">₹{{ number_format($booking->professional_earning, 2) }}</td>
                                        <td data-label="Status">
                                            <span class="badge {{ $booking->paid_status == 'paid' ? 'paid' : 'unpaid' }}">
                                                {{ ucfirst($booking->paid_status ?? 'unpaid') }}
                                            </span>
                                        </td>
                                        <td data-label="Prof. Invoice" class="invoice-cell">
                                            <a href="{{ route('professional.billing.download-invoice', ['booking' => $booking->id]) }}" class="invoice-btn" title="Download Invoice">
                                                <i class="fas fa-file-download"></i>
                                            </a>
                                        </td>
                                        <td data-label="Customer Invoice" class="invoice-cell">
                                            <div class="invoice-actions">
                                                <a href="{{ route('professional.billing.customer-invoice.view', ['booking' => $booking->id]) }}" class="invoice-btn customer" target="_blank" title="View Customer Invoice">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('professional.billing.customer-invoice.download', ['booking' => $booking->id]) }}" class="invoice-btn customer" title="Download Customer Invoice">
                                                    <i class="fas fa-file-download"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                                <tr class="total-row">
                                    <td colspan="3" style="text-align:left; font-weight:700;">Total Billing</td>
                                    <td class="amount">₹{{ number_format($totalGrossAmount, 2) }}</td>
                                    <td class="amount">₹{{ number_format($bookings->sum('platform_fee'), 2) }}</td>
                                    <td class="amount">₹{{ number_format($bookings->sum('platform_cgst') + $bookings->sum('platform_sgst'), 2) }}</td>
                                    <td class="amount deduction">₹{{ number_format($bookings->sum('total_platform_cut'), 2) }}</td>
                                    <td class="amount net">₹{{ number_format($bookings->sum('professional_earning'), 2) }}</td>
                                    <td colspan="3"></td>
                                </tr>
                            </tbody>
                        </table>
                    @endif
                </div>

                <div class="mobile-totals" style="border-radius:16px; border:1px solid rgba(148,163,184,0.2); padding:1.3rem 1.4rem; background:#ffffff; display:none;">
                    <h4 style="margin:0 0 1rem; font-size:1.05rem; font-weight:700; color:#0f172a; text-align:center;">Billing Summary</h4>
                    <div style="display:flex; justify-content:space-between; padding:0.45rem 0; border-bottom:1px solid rgba(148,163,184,0.18);">
                        <span>Total Customer Amount</span>
                        <span class="amount">₹{{ number_format($totalGrossAmount, 2) }}</span>
                    </div>
                    <div style="display:flex; justify-content:space-between; padding:0.45rem 0; border-bottom:1px solid rgba(148,163,184,0.18);">
                        <span>Total Platform Fee</span>
                        <span class="amount">₹{{ number_format($bookings->sum('platform_fee'), 2) }}</span>
                    </div>
                    <div style="display:flex; justify-content:space-between; padding:0.45rem 0; border-bottom:1px solid rgba(148,163,184,0.18);">
                        <span>Total GST (18%)</span>
                        <span class="amount">₹{{ number_format($bookings->sum('platform_cgst') + $bookings->sum('platform_sgst'), 2) }}</span>
                    </div>
                    <div style="display:flex; justify-content:space-between; padding:0.45rem 0; border-bottom:1px solid rgba(248,113,113,0.24); color:#b91c1c; font-weight:600;">
                        <span>Total Deduction</span>
                        <span class="amount">₹{{ number_format($bookings->sum('total_platform_cut'), 2) }}</span>
                    </div>
                    <div style="display:flex; justify-content:space-between; padding:0.6rem 0; margin-top:0.6rem; background:rgba(34,197,94,0.12); border-radius:12px; font-weight:700; color:#15803d;">
                        <span>Your Total Earning</span>
                        <span class="amount">₹{{ number_format($bookings->sum('professional_earning'), 2) }}</span>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Additional JS hooks can be placed here if needed in future.
</script>
@endsection