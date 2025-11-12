@extends('customer.layout.layout')

@section('styles')
<link rel="stylesheet" href="{{ asset('customer-css/assets/css/appointment.css') }}" />
<style>
    :root {
        --primary: #f7a86c;
        --primary-dark: #eb8640;
        --primary-soft: #fde5cd;
        --accent: #7dd3fc;
        --accent-dark: #0f4a6e;
        --success: #16a34a;
        --warning: #f59e0b;
        --neutral-900: #2c1b0f;
        --neutral-700: #6b4c33;
        --neutral-500: #a08873;
        --neutral-300: #e6cec0;
        --surface: #ffffff;
        --surface-soft: rgba(255, 255, 255, 0.92);
        --border-soft: rgba(247, 168, 108, 0.28);
        --shadow-lg: 0 24px 48px rgba(122, 63, 20, 0.14);
        --shadow-md: 0 16px 32px rgba(122, 63, 20, 0.12);
        --shadow-sm: 0 10px 20px rgba(15, 23, 42, 0.08);
        --radius-lg: 28px;
        --radius-md: 20px;
        --radius-sm: 14px;
    }

    html,
    body {
        overflow-x: hidden;
    }

    body,
    .app-content {
        background: linear-gradient(180deg, #fff9f3 0%, #fff4e8 100%);
        font-family: 'Inter', sans-serif;
        color: var(--neutral-900);
    }

    .content-wrapper {
        max-width: 1180px;
        margin: 0 auto;
        padding: 2.8rem 1.6rem 3.2rem;
    }

    .billing-hero {
        background: linear-gradient(135deg, rgba(251, 209, 173, 0.95), rgba(255, 244, 232, 0.95));
        border-radius: var(--radius-lg);
        padding: 2.6rem 2.4rem;
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
        gap: 1.8rem 2.2rem;
        position: relative;
        box-shadow: var(--shadow-lg);
        overflow: hidden;
    }

    .billing-hero::before,
    .billing-hero::after {
        content: '';
        position: absolute;
        border-radius: 999px;
        pointer-events: none;
    }

    .billing-hero::before {
        width: 320px;
        height: 320px;
        top: -200px;
        right: -140px;
        background: rgba(247, 168, 108, 0.26);
    }

    .billing-hero::after {
        width: 260px;
        height: 260px;
        bottom: -160px;
        left: -120px;
        background: rgba(255, 236, 214, 0.36);
    }

    .hero-meta {
        display: flex;
        flex-direction: column;
        gap: 0.9rem;
        position: relative;
        z-index: 1;
    }

    .hero-eyebrow {
        display: inline-flex;
        align-items: center;
        gap: 0.45rem;
        padding: 0.45rem 1rem;
        border-radius: 999px;
        background: rgba(255, 255, 255, 0.68);
        color: var(--neutral-700);
        font-weight: 600;
        font-size: 0.82rem;
        text-transform: uppercase;
        letter-spacing: 0.08em;
    }

    .hero-meta h3 {
        margin: 0;
        font-size: 2.15rem;
        font-weight: 700;
        letter-spacing: -0.02em;
    }

    .hero-meta p {
        margin: 0;
        max-width: 540px;
        line-height: 1.6;
        color: rgba(47, 47, 47, 0.72);
    }

    .hero-breadcrumb {
        display: flex;
        gap: 0.6rem;
        padding: 0;
        margin: 0;
        list-style: none;
        flex-wrap: wrap;
        position: relative;
        z-index: 1;
    }

    .hero-breadcrumb li {
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        font-size: 0.88rem;
        color: var(--neutral-500);
    }

    .hero-breadcrumb li a {
        text-decoration: none;
        color: var(--neutral-500);
        padding: 0.35rem 0.75rem;
        border-radius: 999px;
        background: rgba(255, 255, 255, 0.65);
        border: 1px solid rgba(247, 168, 108, 0.2);
        transition: background 0.18s ease, color 0.18s ease;
    }

    .hero-breadcrumb li a:hover {
        background: rgba(247, 168, 108, 0.18);
        color: var(--neutral-900);
    }

    .hero-breadcrumb li.active {
        padding: 0.35rem 0.95rem;
        border-radius: 999px;
        background: rgba(247, 168, 108, 0.26);
        color: var(--neutral-900);
        font-weight: 600;
    }

    .stats-pill {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.45rem 1.1rem;
        border-radius: 999px;
        background: rgba(247, 168, 108, 0.18);
        color: var(--primary-dark);
        font-weight: 600;
        font-size: 0.9rem;
    }

    .summary-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1rem;
        position: relative;
        z-index: 1;
    }

    .summary-card {
        background: rgba(255, 255, 255, 0.85);
        border-radius: var(--radius-sm);
        padding: 1rem 1.2rem;
        border: 1px solid rgba(255, 255, 255, 0.6);
        box-shadow: var(--shadow-sm);
        display: flex;
        flex-direction: column;
        gap: 0.4rem;
    }

    .summary-card span {
        font-size: 0.78rem;
        text-transform: uppercase;
        letter-spacing: 0.08em;
        color: var(--neutral-500);
        font-weight: 600;
    }

    .summary-card strong {
        font-size: 1.1rem;
        color: var(--neutral-900);
    }

    .btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.45rem;
        font-weight: 600;
        border-radius: 999px;
        cursor: pointer;
        text-decoration: none;
        border: none;
        transition: transform 0.18s ease, box-shadow 0.18s ease;
    }

    .btn-primary {
        background: linear-gradient(135deg, var(--primary), var(--primary-dark));
        color: var(--surface);
        padding: 0.85rem 1.6rem;
        box-shadow: 0 18px 36px rgba(247, 168, 108, 0.3);
    }

    .btn-outline {
        background: rgba(255, 255, 255, 0.95);
        color: var(--neutral-700);
        border: 1px solid rgba(148, 163, 184, 0.25);
        padding: 0.85rem 1.5rem;
    }

    .btn:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-sm);
    }

    .filter-card {
        margin-top: 2.4rem;
        background: var(--surface);
        border-radius: var(--radius-md);
        box-shadow: var(--shadow-md);
        border: 1px solid var(--border-soft);
        padding: 2rem 2.2rem;
        display: flex;
        flex-direction: column;
        gap: 1.6rem;
    }

    .filter-card header h4 {
        margin: 0;
        font-size: 1.28rem;
        font-weight: 700;
        color: var(--neutral-900);
    }

    .search-form {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1.2rem 1.4rem;
    }

    .search-form .form-group {
        display: flex;
        flex-direction: column;
        gap: 0.45rem;
    }

    .search-form label {
        font-weight: 600;
        font-size: 0.9rem;
        color: var(--neutral-700);
    }

    .search-form input,
    .search-form select {
        padding: 0.85rem 1rem;
        border-radius: 14px;
        border: 1px solid rgba(226, 232, 240, 0.9);
        background: rgba(247, 249, 252, 0.92);
        transition: border 0.18s ease, box-shadow 0.18s ease;
    }

    .search-form input:focus,
    .search-form select:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(247, 168, 108, 0.18);
        outline: none;
        background: var(--surface);
    }

    .search-buttons {
        display: flex;
        gap: 0.8rem;
        align-items: center;
    }

    .billing-card {
        margin-top: 2.4rem;
        background: var(--surface);
        border-radius: var(--radius-md);
        border: 1px solid var(--border-soft);
        box-shadow: var(--shadow-md);
        overflow: hidden;
    }

    .billing-card__head {
        padding: 1.9rem 2.1rem;
        border-bottom: 1px solid rgba(226, 232, 240, 0.7);
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 1.2rem;
        flex-wrap: wrap;
        background: rgba(255, 255, 255, 0.88);
    }

    .billing-card__head h4 {
        margin: 0;
        font-size: 1.25rem;
        font-weight: 700;
        color: var(--neutral-900);
    }

    .billing-card__body {
        padding: 2rem 2.1rem 2.2rem;
    }

    .table-responsive {
        border-radius: var(--radius-sm);
        border: 1px solid rgba(226, 232, 240, 0.7);
        overflow-x: auto;
        box-shadow: var(--shadow-sm);
    }

    .data-table {
        width: 100%;
        min-width: 960px;
        border-collapse: separate;
        border-spacing: 0;
        background: var(--surface);
    }

    .data-table thead th {
        background: rgba(255, 244, 232, 0.7);
        color: var(--neutral-700);
        font-weight: 600;
        font-size: 0.78rem;
        letter-spacing: 0.08em;
        text-transform: uppercase;
        padding: 1rem 0.95rem;
        border-bottom: 1px solid rgba(247, 168, 108, 0.18);
        white-space: nowrap;
        text-align: left;
    }

    .data-table tbody td {
        padding: 1rem 0.95rem;
        border-bottom: 1px solid rgba(226, 232, 240, 0.7);
        color: var(--neutral-700);
        font-weight: 500;
    }

    .data-table tbody tr:hover td {
        background: rgba(251, 209, 173, 0.12);
    }

    .badge {
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
        padding: 0.45rem 0.9rem;
        border-radius: 999px;
        font-size: 0.82rem;
        font-weight: 600;
        letter-spacing: 0.02em;
        text-transform: capitalize;
        border: 1px solid transparent;
    }

    .badge-monthly { background: rgba(187, 247, 208, 0.32); color: #166534; border-color: rgba(187, 247, 208, 0.5); }
    .badge-quarterly { background: rgba(125, 211, 252, 0.24); color: var(--accent-dark); border-color: rgba(125, 211, 252, 0.45); }
    .badge-one-time { background: rgba(221, 214, 254, 0.28); color: #4338ca; border-color: rgba(221, 214, 254, 0.48); }
    .badge-free-hand { background: rgba(254, 215, 170, 0.28); color: #9a3412; border-color: rgba(254, 215, 170, 0.48); }

    .alert-info {
        border-radius: var(--radius-sm);
        border: 1px dashed rgba(247, 168, 108, 0.45);
        background: rgba(255, 244, 232, 0.7);
        color: var(--neutral-700);
        padding: 1.4rem 1.6rem;
        box-shadow: var(--shadow-sm);
    }

    .alert-info a {
        color: var(--primary-dark);
        font-weight: 600;
        text-decoration: none;
    }

    .alert-info a:hover {
        text-decoration: underline;
    }

    @media (max-width: 992px) {
        .content-wrapper {
            padding: 2.4rem 1.2rem 2.8rem;
        }

        .billing-hero {
            padding: 2.2rem 1.9rem;
        }

        .filter-card {
            padding: 1.8rem 1.6rem;
        }

        .billing-card__body {
            padding: 1.8rem 1.6rem 2rem;
        }

        .data-table {
            min-width: 900px;
        }
    }

    @media (max-width: 768px) {
        .content-wrapper {
            padding: 2rem 1rem 2.4rem;
        }

        .billing-hero {
            padding: 2rem 1.6rem;
        }

        .hero-meta h3 {
            font-size: 1.85rem;
        }

        .search-buttons {
            flex-direction: column;
            align-items: stretch;
        }

        .search-buttons .btn {
            width: 100%;
            text-align: center;
        }

        .billing-card__head {
            flex-direction: column;
            align-items: flex-start;
        }

        .data-table {
            min-width: 840px;
        }
    }

    @media (max-width: 600px) {
        .content-wrapper {
            padding: 1.8rem 0.9rem 2.2rem;
        }

        .billing-hero {
            padding: 1.8rem 1.4rem;
        }

        .filter-card {
            padding: 1.6rem 1.3rem;
        }

        .search-form {
            grid-template-columns: 1fr;
        }

        .billing-card__body {
            padding: 1.6rem 1.3rem 1.9rem;
        }

        .table-responsive {
            border: none;
            box-shadow: none;
            overflow: visible;
        }

        .data-table {
            min-width: 100%;
            border-spacing: 0;
        }

        .data-table thead {
            display: none;
        }

        .data-table tbody {
            display: flex;
            flex-direction: column;
            gap: 1.1rem;
        }

        .data-table tbody tr {
            display: block;
            border: 1px solid var(--border-soft);
            border-radius: var(--radius-sm);
            box-shadow: var(--shadow-sm);
            background: var(--surface);
            overflow: hidden;
        }

        .data-table tbody td {
            display: block;
            padding: 0.85rem 1rem;
            border-bottom: 1px solid rgba(226, 232, 240, 0.7);
        }

        .data-table tbody td:last-child {
            border-bottom: none;
            padding-bottom: 1rem;
        }

        .data-table tbody td::before {
            content: attr(data-label);
            display: block;
            font-size: 0.75rem;
            font-weight: 700;
            letter-spacing: 0.06em;
            text-transform: uppercase;
            color: var(--neutral-500);
            margin-bottom: 0.35rem;
        }

        .data-table tbody td[data-label="Download PDF"] .btn {
            width: 100%;
            justify-content: center;
        }
    }
</style>
@endsection

@section('content')
<div class="content-wrapper">
    <section class="billing-hero">
        <div class="hero-meta">
            <span class="hero-eyebrow"><i class="fas fa-file-invoice-dollar"></i> Billing History</span>
            <h3>Your Billing & Invoices</h3>
            <p>Track every transaction, download invoices, and filter your payment history with just a few clicks.</p>
            <span class="stats-pill">
                <i class="fas fa-receipt"></i>
                {{ $bookings->count() }} {{ Str::plural('transaction', $bookings->count()) }} found
            </span>
        </div>
        <ul class="hero-breadcrumb">
            <li><a href="{{ route('user.dashboard') }}">Home</a></li>
            <li class="active">Billing History</li>
        </ul>
        <div class="summary-grid">
            <div class="summary-card">
                <span>Total Paid</span>
                <strong>₹{{ number_format($bookings->sum('amount'), 2) }}</strong>
            </div>
            <div class="summary-card">
                <span>Unique Services</span>
                <strong>{{ $bookings->pluck('service_name')->unique()->count() }}</strong>
            </div>
            <div class="summary-card">
                <span>Professionals</span>
                <strong>{{ $bookings->pluck('professional_id')->filter()->unique()->count() }}</strong>
            </div>
        </div>
    </section>

    <section class="filter-card">
        <header>
            <h4>Filter Transactions</h4>
        </header>
        <form action="{{ route('user.billing.index') }}" method="GET" class="search-form" id="filter-form">
            <div class="form-group">
                <label for="start_date">Start Date</label>
                <input type="date" id="start_date" name="start_date" class="form-control" value="{{ request('start_date') }}">
            </div>
            <div class="form-group">
                <label for="end_date">End Date</label>
                <input type="date" id="end_date" name="end_date" class="form-control" value="{{ request('end_date') }}">
            </div>
            <div class="form-group">
                <label for="service">Service</label>
                <select id="service" name="service" class="form-control">
                    <option value="">All Services</option>
                    @foreach($services as $service)
                        <option value="{{ $service }}" {{ request('service') == $service ? 'selected' : '' }}>
                            {{ $service }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="plan_type">Plan Type</label>
                <select id="plan_type" name="plan_type" class="form-control">
                    <option value="">All Plans</option>
                    <option value="monthly" {{ request('plan_type') == 'monthly' ? 'selected' : '' }}>Monthly</option>
                    <option value="quarterly" {{ request('plan_type') == 'quarterly' ? 'selected' : '' }}>Quarterly</option>
                    <option value="one_time" {{ request('plan_type') == 'one_time' ? 'selected' : '' }}>One Time</option>
                    <option value="free_hand" {{ request('plan_type') == 'free_hand' ? 'selected' : '' }}>Free Hand</option>
                </select>
            </div>
            <div class="search-buttons">
                <button type="submit" class="btn btn-primary">Apply Filters</button>
                <a href="{{ route('user.billing.index') }}" class="btn btn-outline">Reset</a>
            </div>
        </form>
    </section>

    <section class="billing-card">
        <header class="billing-card__head">
            <h4>All Transactions</h4>
            <a href="{{ route('user.billing.export-all', request()->all()) }}" class="btn btn-primary">
                <i class="fas fa-file-export"></i> Export as PDF
            </a>
        </header>
        <div class="billing-card__body">
            @if($bookings->count() > 0)
                <div class="table-responsive">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>S.No</th>
                                <th>Date</th>
                                <th>Service Taken</th>
                                <th>Professional Name</th>
                                <th>Type of Plan</th>
                                <th>Amount</th>
                                <th>Download PDF</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($bookings as $index => $booking)
                                <tr>
                                    <td data-label="S.No">{{ $index + 1 }}</td>
                                    <td data-label="Date">{{ $booking->created_at->format('d M Y') }}</td>
                                    <td data-label="Service Taken">{{ $booking->service_name }}</td>
                                    <td data-label="Professional Name">{{ $booking->professional->name ?? 'N/A' }}</td>
                                    <td data-label="Type of Plan">
                                        @php
                                            $planKey = str_replace('_', '-', $booking->plan_type);
                                        @endphp
                                        <span class="badge badge-{{ $planKey }}">
                                            {{ ucwords(str_replace('_', ' ', $booking->plan_type)) }}
                                        </span>
                                    </td>
                                    <td data-label="Amount">₹{{ number_format($booking->amount, 2) }}</td>
                                    <td data-label="Download PDF">
                                        <a href="{{ route('user.billing.download', $booking->id) }}" class="btn btn-outline" style="padding: 0.65rem 1.2rem;">
                                            <i class="fas fa-download"></i> Invoice
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="alert alert-info">
                    No transactions found matching your filters. <a href="{{ route('user.billing.index') }}">Clear filters</a> to see all transactions.
                </div>
            @endif
        </div>
    </section>
</div>
@endsection