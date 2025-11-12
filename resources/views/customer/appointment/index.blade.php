@extends('customer.layout.layout')

@section('styles')
<link rel="stylesheet" href="{{ asset('customer-css/assets/css/appointment.css') }}" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<style>
    :root {
        --primary: #f7a86c;
        --primary-dark: #eb8640;
        --primary-soft: #fde5cd;
        --accent: #7dd3fc;
        --accent-dark: #0f4a6e;
        --success: #16a34a;
        --warning: #f59e0b;
        --danger: #ef4444;
        --neutral-900: #1f2937;
        --neutral-700: #374151;
        --neutral-500: #6b7280;
        --neutral-300: #d1d5db;
        --surface: #ffffff;
        --surface-muted: rgba(255, 255, 255, 0.92);
        --border-soft: rgba(247, 168, 108, 0.26);
        --shadow-lg: 0 24px 48px rgba(122, 63, 20, 0.14);
        --shadow-md: 0 16px 32px rgba(122, 63, 20, 0.12);
        --shadow-sm: 0 8px 18px rgba(15, 23, 42, 0.08);
        --radius-lg: 28px;
        --radius-md: 20px;
        --radius-sm: 12px;
    }

    body,
    .app-content {
        background: linear-gradient(180deg, #fff8f1 0%, #fdf2e9 100%);
        font-family: 'Inter', sans-serif;
    }

    .appointments-page.content-wrapper {
        max-width: 1180px;
        margin: 0 auto;
        padding: 2.8rem 1.6rem 3.2rem;
    }

    .appointments-page .appointments-hero {
        background: linear-gradient(135deg, rgba(251, 209, 173, 0.95), rgba(255, 244, 232, 0.95));
        border-radius: var(--radius-lg);
        padding: 2.6rem 2.4rem;
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 1.6rem 2rem;
        box-shadow: var(--shadow-lg);
        position: relative;
        overflow: hidden;
    }

    .appointments-page .appointments-hero::before,
    .appointments-page .appointments-hero::after {
        content: '';
        position: absolute;
        border-radius: 999px;
        pointer-events: none;
    }

    .appointments-page .appointments-hero::before {
        width: 320px;
        height: 320px;
        top: -200px;
        right: -120px;
        background: rgba(247, 168, 108, 0.26);
    }

    .appointments-page .appointments-hero::after {
        width: 240px;
        height: 240px;
        bottom: -160px;
        left: -120px;
        background: rgba(255, 236, 214, 0.36);
    }

    .appointments-page .hero-meta {
        display: flex;
        flex-direction: column;
        gap: 0.9rem;
        position: relative;
        z-index: 1;
        color: var(--neutral-900);
    }

    .appointments-page .hero-meta h3 {
        margin: 0;
        font-size: 2.1rem;
        font-weight: 700;
        letter-spacing: -0.02em;
    }

    .appointments-page .hero-meta p {
        margin: 0;
        max-width: 520px;
        line-height: 1.6;
        color: rgba(47, 47, 47, 0.7);
    }

    .appointments-page .hero-breadcrumb {
        display: flex;
        gap: 0.6rem;
        padding: 0;
        margin: 0;
        list-style: none;
        flex-wrap: wrap;
    }

    .appointments-page .hero-breadcrumb li {
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        font-size: 0.88rem;
        color: var(--neutral-500);
    }

    .appointments-page .hero-breadcrumb li a {
        text-decoration: none;
        color: var(--neutral-500);
        padding: 0.35rem 0.75rem;
        border-radius: 999px;
        background: rgba(255, 255, 255, 0.65);
        border: 1px solid rgba(247, 168, 108, 0.2);
        transition: background 0.18s ease, color 0.18s ease;
    }

    .appointments-page .hero-breadcrumb li a:hover {
        background: rgba(247, 168, 108, 0.18);
        color: var(--neutral-900);
    }

    .appointments-page .hero-breadcrumb li.active {
        padding: 0.35rem 0.95rem;
        border-radius: 999px;
        background: rgba(247, 168, 108, 0.26);
        color: var(--neutral-900);
        font-weight: 600;
    }

    .appointments-page .stats-pill {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.45rem 1.1rem;
        border-radius: 999px;
        background: rgba(247, 168, 108, 0.16);
        color: var(--primary-dark);
        font-weight: 600;
        font-size: 0.9rem;
    }

    .appointments-page .filter-card {
        margin-top: 2.2rem;
        background: var(--surface);
        border-radius: var(--radius-md);
        box-shadow: var(--shadow-md);
        border: 1px solid var(--border-soft);
        padding: 2rem 2.2rem;
    }

    .appointments-page .filter-card header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 1rem;
        margin-bottom: 1.6rem;
    }

    .appointments-page .filter-card header h4 {
        margin: 0;
        font-size: 1.28rem;
        font-weight: 700;
        color: var(--neutral-900);
    }

    .appointments-page .search-form {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1.2rem 1.4rem;
    }

    .appointments-page .search-form .form-group {
        display: flex;
        flex-direction: column;
        gap: 0.45rem;
    }

    .appointments-page .search-form label {
        font-weight: 600;
        font-size: 0.9rem;
        color: var(--neutral-700);
    }

    .appointments-page .search-form input[type="text"],
    .appointments-page .search-form input[type="date"],
    .appointments-page .search-form select {
        padding: 0.85rem 1rem;
        border-radius: 14px;
        border: 1px solid rgba(226, 232, 240, 0.9);
        background: rgba(247, 249, 252, 0.92);
        transition: border 0.18s ease, box-shadow 0.18s ease;
    }

    .appointments-page .search-form input:focus,
    .appointments-page .search-form select:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(247, 168, 108, 0.18);
        outline: none;
        background: var(--surface);
    }

    .appointments-page .search-buttons {
        display: flex;
        gap: 0.8rem;
        align-items: center;
    }

    .appointments-page .search-buttons .btn-primary {
        background: linear-gradient(135deg, var(--primary), var(--primary-dark));
        color: var(--surface);
        border: none;
        padding: 0.85rem 1.6rem;
        border-radius: 999px;
        font-weight: 600;
        box-shadow: 0 16px 32px rgba(247, 168, 108, 0.28);
    }

    .appointments-page .search-buttons .btn-secondary {
        background: rgba(255, 255, 255, 0.95);
        color: var(--neutral-700);
        border: 1px solid rgba(148, 163, 184, 0.25);
        padding: 0.85rem 1.5rem;
        border-radius: 999px;
        font-weight: 600;
    }

    .appointments-page .content-section {
        margin-top: 2.4rem;
        background: var(--surface);
        border-radius: var(--radius-md);
        border: 1px solid var(--border-soft);
        box-shadow: var(--shadow-md);
        padding: 1.9rem 1.6rem;
        overflow-x: auto;
    }

    .appointments-page .section-header {
        display: flex;
        flex-wrap: wrap;
        justify-content: space-between;
        align-items: center;
        gap: 0.9rem;
    }

    .appointments-page .section-header h4 {
        margin: 0;
        color: var(--neutral-900);
    }

    .appointments-page .appointments-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
        overflow: hidden;
        border-radius: var(--radius-sm);
        border: 1px solid rgba(226, 232, 240, 0.7);
        box-shadow: var(--shadow-sm);
        background: var(--surface);
        min-width: 960px;
    }

    .appointments-page .appointments-table thead th {
        background: rgba(255, 244, 232, 0.7);
        color: var(--neutral-700);
        font-weight: 600;
        font-size: 0.78rem;
        letter-spacing: 0.08em;
        text-transform: uppercase;
        padding: 0.95rem;
        border-bottom: 1px solid rgba(247, 168, 108, 0.18);
        white-space: nowrap;
    }

    .appointments-page .appointments-table thead th.chat-col,
    .appointments-page .appointments-table tbody td.chat-col {
        min-width: 140px;
        text-align: center;
    }

    .appointments-page .appointments-table tbody td {
        padding: 1rem;
        border-bottom: 1px solid rgba(226, 232, 240, 0.7);
        color: var(--neutral-700);
        vertical-align: middle;
    }

    .appointments-page .appointments-table tbody tr:hover {
        background: rgba(251, 209, 173, 0.12);
    }

    .appointments-page .subservice-pill {
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        padding: 0.4rem 0.75rem;
        border-radius: 999px;
        background: rgba(125, 211, 252, 0.2);
        color: var(--accent-dark);
        font-size: 0.82rem;
        font-weight: 600;
    }

    .appointments-page .plan-type-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        padding: 0.35rem 0.7rem;
        border-radius: 999px;
        font-size: 0.82rem;
        font-weight: 600;
        background: rgba(251, 209, 173, 0.26);
        color: var(--primary-dark);
        border: 1px solid rgba(247, 168, 108, 0.32);
    }

    .plan-type-premium { background: rgba(244, 187, 213, 0.24); color: #9c2f64; border-color: rgba(244, 187, 213, 0.4); }
    .plan-type-standard { background: rgba(187, 247, 208, 0.26); color: #166534; border-color: rgba(187, 247, 208, 0.42); }
    .plan-type-basic { background: rgba(221, 214, 254, 0.24); color: #4338ca; border-color: rgba(221, 214, 254, 0.42); }
    .plan-type-corporate { background: rgba(254, 215, 170, 0.26); color: #9a3412; border-color: rgba(254, 215, 170, 0.42); }
    .plan-type-one-time { background: rgba(200, 250, 230, 0.3); color: #0f766e; border-color: rgba(200, 250, 230, 0.46); }

    .appointments-page .status-badge {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 0.38rem 0.75rem;
        border-radius: 999px;
        font-size: 0.78rem;
        font-weight: 600;
        text-transform: capitalize;
        letter-spacing: 0.04em;
    }

    .appointments-page .status-completed { background: rgba(187, 247, 208, 0.35); color: #166534; border: 1px solid rgba(187, 247, 208, 0.5); }
    .appointments-page .status-pending { background: rgba(254, 215, 170, 0.35); color: #b45309; border: 1px solid rgba(254, 215, 170, 0.48); }
    .appointments-page .status-cancelled { background: rgba(254, 202, 202, 0.32); color: #b91c1c; border: 1px solid rgba(254, 202, 202, 0.48); }

    .appointments-page .btn-sm {
        border-radius: 999px;
        padding: 0.55rem 1rem;
        font-weight: 600;
        font-size: 0.83rem;
        border: none;
        transition: transform 0.18s ease, box-shadow 0.18s ease;
    }

    .appointments-page .btn-sm:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-sm);
    }

    .appointments-page .btn-sm.btn-secondary {
        background: rgba(125, 211, 252, 0.18);
        color: var(--accent-dark);
        border: 1px solid rgba(125, 211, 252, 0.35);
    }

    .appointments-page .btn-sm.btn-success {
        background: rgba(74, 222, 128, 0.22);
        color: #166534;
        border: 1px solid rgba(74, 222, 128, 0.38);
    }

    .appointments-page .chat-btn {
        background: linear-gradient(135deg, rgba(125, 211, 252, 0.35), rgba(14, 165, 233, 0.35));
        border: 1px solid rgba(125, 211, 252, 0.45);
        color: var(--accent-dark);
        padding: 0.6rem 1.1rem;
        border-radius: 999px;
        font-weight: 600;
        gap: 0.45rem;
        transition: transform 0.18s ease, box-shadow 0.18s ease, background 0.18s ease;
    }

    .appointments-page .chat-btn:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-sm);
        background: linear-gradient(135deg, rgba(125, 211, 252, 0.45), rgba(45, 197, 245, 0.45));
        color: var(--accent-dark);
    }

    .appointments-page .btn-sm.btn-primary {
        background: rgba(147, 197, 253, 0.22);
        color: #1d4ed8;
        border: 1px solid rgba(147, 197, 253, 0.38);
    }

    .appointments-page .chat-badge {
        position: absolute;
        top: -6px;
        right: -6px;
        min-width: 18px;
        height: 18px;
        background: var(--danger);
        color: var(--surface);
        border-radius: 999px;
        font-size: 0.72rem;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }

    .appointments-page .empty-state {
        color: var(--neutral-500);
        font-style: italic;
    }

    .appointments-page .custom-modal {
        display: none;
        position: fixed;
        inset: 0;
        z-index: 1050;
        background-color: rgba(17, 24, 39, 0.55);
        backdrop-filter: blur(6px);
        padding: 1.5rem;
    }

    .appointments-page .custom-modal-content {
        background: var(--surface);
        border-radius: var(--radius-lg);
        border: 1px solid var(--border-soft);
        box-shadow: var(--shadow-lg);
        width: min(680px, 100%);
        max-height: 90vh;
        overflow-y: auto;
        animation: fadeIn 0.24s ease;
    }

    .appointments-page .modal-header {
        padding: 1.8rem 2rem;
        border-bottom: 1px solid rgba(247, 168, 108, 0.22);
        background: rgba(255, 255, 255, 0.9);
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .appointments-page .modal-header h4 {
        margin: 0;
        font-size: 1.2rem;
        font-weight: 600;
        color: var(--neutral-900);
    }

    .appointments-page .modal-body {
        padding: 1.9rem 2rem;
    }

    .appointments-page .modal-footer {
        padding: 1.6rem 2rem;
        border-top: 1px solid rgba(247, 168, 108, 0.22);
        background: rgba(255, 255, 255, 0.95);
        display: flex;
        justify-content: flex-end;
        gap: 0.8rem;
    }

    .appointments-page .close-modal,
    .appointments-page .close-modal-btn {
        border-radius: 999px;
        background: rgba(247, 168, 108, 0.18);
        color: var(--primary-dark);
        border: none;
        padding: 0.55rem 1.3rem;
        font-weight: 600;
        cursor: pointer;
    }

    .appointments-page #appointmentDetailsTable {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
        border-radius: var(--radius-sm);
        overflow: hidden;
        border: 1px solid rgba(226, 232, 240, 0.7);
    }

    .appointments-page #appointmentDetailsTable thead th {
        background: rgba(255, 244, 232, 0.7);
        padding: 0.9rem;
        font-size: 0.78rem;
        letter-spacing: 0.08em;
        text-transform: uppercase;
        color: var(--neutral-500);
    }

    .appointments-page #appointmentDetailsTable tbody td {
        padding: 0.85rem 0.95rem;
        border-bottom: 1px solid rgba(226, 232, 240, 0.7);
        color: var(--neutral-700);
    }

    .appointments-page .remarks-cell {
        max-width: 260px;
        word-break: break-word;
    }

    @media (max-width: 992px) {
        .appointments-page.content-wrapper {
            padding: 2.4rem 1.2rem 2.8rem;
        }

        .appointments-page .filter-card {
            padding: 1.8rem 1.6rem;
        }

        .appointments-page .search-form {
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
        }

        .appointments-page .appointments-table {
            min-width: 880px;
        }
    }

    @media (max-width: 768px) {
        .appointments-page.content-wrapper {
            padding: 2rem 1rem 2.4rem;
        }

        .appointments-page .appointments-hero {
            padding: 2rem 1.6rem;
            grid-template-columns: 1fr;
            text-align: left;
        }

        .appointments-page .hero-meta h3 {
            font-size: 1.85rem;
        }

        .appointments-page .hero-breadcrumb {
            justify-content: flex-start;
        }

        .appointments-page .search-buttons {
            flex-direction: column;
            align-items: stretch;
        }

        .appointments-page .search-buttons .btn-primary,
        .appointments-page .search-buttons .btn-secondary {
            width: 100%;
            text-align: center;
        }

        .appointments-page .content-section {
            padding: 1.6rem 1.15rem;
            overflow-x: auto;
        }

        .appointments-page .section-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 0.6rem;
        }

        .appointments-page .appointments-table {
            min-width: 760px;
        }

        .appointments-page .custom-modal-content {
            width: 100%;
        }
    }

    @media (max-width: 540px) {
        .appointments-page .appointments-hero {
            padding: 1.9rem 1.5rem;
            row-gap: 1.2rem;
        }

        .appointments-page .hero-meta p {
            font-size: 0.94rem;
        }

        .appointments-page .stats-pill {
            align-self: flex-start;
        }

        .appointments-page .filter-card {
            padding: 1.6rem 1.4rem;
        }

        .appointments-page .search-form {
            grid-template-columns: 1fr;
        }

        .appointments-page .search-form .form-group,
        .appointments-page .search-buttons .btn-primary,
        .appointments-page .search-buttons .btn-secondary {
            width: 100%;
        }

        .appointments-page .content-section {
            padding: 1.4rem 1.1rem;
        }

        .appointments-page .appointments-table {
            min-width: 700px;
        }

        .appointments-page .subservice-pill,
        .appointments-page .plan-type-badge {
            font-size: 0.78rem;
        }

        .appointments-page .custom-modal-content {
            margin: 8% auto;
            padding: 1rem;
        }

        .appointments-page .modal-body {
            padding: 1.2rem;
        }
    }

    @media (max-width: 480px) {
        .appointments-page .appointments-hero {
            padding: 1.7rem 1.35rem;
        }

        .appointments-page .hero-meta h3 {
            font-size: 1.7rem;
        }

        .appointments-page .hero-meta p {
            font-size: 0.9rem;
        }

        .appointments-page .filter-card {
            padding: 1.5rem 1.25rem;
        }

        .appointments-page .content-section {
            padding: 1.3rem 1rem;
        }

        .appointments-page .appointments-table {
            min-width: 640px;
        }

        .appointments-page .custom-modal-content {
            margin: 8% auto;
            padding: 1rem;
        }
    }

    /* Hard overrides to ensure mobile styles take effect when other styles conflict */
    @media (max-width: 640px) {
        .appointments-page.content-wrapper {
            padding: 1.8rem 0.9rem 2.1rem !important;
        }

        .appointments-page .appointments-hero {
            grid-template-columns: 1fr !important;
            padding: 1.7rem 1.3rem !important;
            text-align: left !important;
            row-gap: 1.1rem !important;
        }

        .appointments-page .hero-meta h3 {
            font-size: 1.65rem !important;
        }

        .appointments-page .hero-breadcrumb {
            justify-content: flex-start !important;
        }

        .appointments-page .search-form {
            grid-template-columns: 1fr !important;
            gap: 1rem !important;
        }

        .appointments-page .search-form .form-group,
        .appointments-page .search-buttons .btn-primary,
        .appointments-page .search-buttons .btn-secondary {
            width: 100% !important;
        }

        .appointments-page .search-buttons {
            flex-direction: column !important;
            align-items: stretch !important;
        }

        .appointments-page .content-section {
            padding: 1.15rem 0.85rem !important;
        }

        .appointments-page .appointments-table {
            border: none !important;
            box-shadow: none !important;
            min-width: 100% !important;
        }

        .appointments-page .appointments-table thead {
            display: none !important;
        }

        .appointments-page .appointments-table tbody {
            display: flex !important;
            flex-direction: column !important;
            gap: 1.2rem !important;
        }

        .appointments-page .appointments-table tr {
            display: flex !important;
            flex-direction: column !important;
            background: rgba(255, 255, 255, 0.95) !important;
            border: 1px solid rgba(247, 168, 108, 0.26) !important;
            border-radius: 18px !important;
            padding: 1rem 1.1rem !important;
            box-shadow: 0 14px 26px rgba(122, 63, 20, 0.12) !important;
        }

        .appointments-page .appointments-table td {
            display: flex !important;
            justify-content: space-between !important;
            align-items: flex-start !important;
            gap: 0.8rem !important;
            padding: 0.5rem 0 !important;
            border-bottom: 1px solid rgba(226, 232, 240, 0.6) !important;
        }

        .appointments-page .appointments-table td:last-child {
            border-bottom: none !important;
            padding-bottom: 0 !important;
        }

        .appointments-page .appointments-table td::before {
            content: attr(data-label) !important;
            font-weight: 600 !important;
            color: var(--neutral-500) !important;
            letter-spacing: 0.05em !important;
            text-transform: uppercase !important;
            font-size: 0.72rem !important;
            flex: 0 0 45% !important;
        }

        .appointments-page .appointments-table td[colspan]::before {
            content: none !important;
        }

        .appointments-page .appointments-table td[data-label="S.No"]::before {
            content: "S.No" !important;
        }

        .appointments-page .appointments-table td[data-label="S.No"] {
            font-weight: 700 !important;
            font-size: 1rem !important;
        }

        .appointments-page .appointments-table td.chat-col {
            justify-content: flex-start !important;
        }

        .appointments-page .chat-btn {
            width: 100% !important;
            justify-content: center !important;
        }

        .appointments-page .btn-sm.btn-primary,
        .appointments-page .btn-sm.btn-secondary {
            width: 100% !important;
            justify-content: center !important;
        }
    }
</style>
@endsection

@section('content')
@php
    if (! function_exists('customerFormatPlanType')) {
        function customerFormatPlanType($planType) {
            if (empty($planType)) {
                return null;
            }

            $value = strtolower($planType);

            return match ($value) {
                'one_time' => 'One Time',
                'no_plan' => 'No Plan',
                'monthly' => 'Monthly',
                'quarterly' => 'Quarterly',
                'free_hand' => 'Free Hand',
                default => ucwords(str_replace('_', ' ', $planType)),
            };
        }
    }
@endphp
<div class="appointments-page content-wrapper">

    <section class="appointments-hero">
        <div class="hero-meta">
            <h3>Summary of Your Appointments</h3>
            <p>Track upcoming sessions, review completed consultations, and jump straight into chat or payment actions when needed.</p>
            <span class="stats-pill">
                <i class="fas fa-calendar-check"></i>
                {{ $bookings->count() }} {{ Str::plural('appointment', $bookings->count()) }} found
            </span>
        </div>
        <ul class="hero-breadcrumb">
            <li><a href="{{ route('user.dashboard') }}">Home</a></li>
            <li class="active">Appointments</li>
        </ul>
    </section>

    <section class="filter-card">
        <header>
            <h4>Filter Appointments</h4>
        </header>
        <form action="{{ route('user.all-appointment.index') }}" method="GET" class="search-form">
            <div class="form-group">
                <label for="search_name">Search</label>
                <input type="text" name="search_name" id="search_name" value="{{ request('search_name') }}" placeholder="Search appointment">
            </div>

            <!-- Service Filter -->
            <div class="form-group">
                <label for="service">Service</label>
                <select name="service" id="service" class="form-control">
                    <option value="all">All Services</option>
                    @foreach($serviceOptions as $service)
                        <option value="{{ $service }}" {{ request('service') == $service ? 'selected' : '' }}>
                            {{ $service }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Plan Type Filter -->
            <!-- Update the plan type filter dropdown -->
<div class="form-group">
    <label for="plan_type">Plan Type</label>
    <select name="plan_type" id="plan_type" class="form-control">
        <option value="all">All Plans</option>
        @foreach($planTypeOptions as $planType)
            @php
                $formattedPlanType = customerFormatPlanType($planType);
                $originalValue = $planType;
            @endphp
            <option value="{{ $originalValue }}" {{ request('plan_type') == $originalValue ? 'selected' : '' }}>
                {{ $formattedPlanType }}
            </option>
        @endforeach
    </select>
</div>

            <div class="form-group">
                <label for="search_date_from">From Date</label>
                <input type="date" name="search_date_from" value="{{ request('search_date_from') }}">
            </div>

            <div class="form-group">
                <label for="search_date_to">To Date</label>
                <input type="date" name="search_date_to" value="{{ request('search_date_to') }}">
            </div>

            <div class="search-buttons">
                <button type="submit" class="btn-primary">Search</button>
                <a href="{{ route('user.all-appointment.index') }}" class="btn-secondary">Reset</a>
            </div>
        </form>
    </section>

    <!-- Appointments Summary -->
    <div class="content-section">
        <div class="section-header mb-3 d-flex justify-content-between align-items-center">
            <h4>
                Results: {{ $bookings->count() }} {{ Str::plural('appointment', $bookings->count()) }}
                @if(request('service') && request('service') != 'all')
                    for <strong>{{ request('service') }}</strong>
                @endif
                @if(request('plan_type') && request('plan_type') != 'all')
                    with plan <strong>{{ request('plan_type') }}</strong>
                @endif
            </h4>
            {{-- <div class="export-buttons">
                <a href="{{ route('user.all-appointment.index', array_merge(request()->all(), ['export' => 'pdf'])) }}" class="btn-export btn-pdf">
                    <i class="fas fa-file-pdf"></i> Export PDF
                </a>
                <a href="{{ route('user.all-appointment.index', array_merge(request()->all(), ['export' => 'excel'])) }}" class="btn-export btn-excel">
                    <i class="fas fa-file-excel"></i> Export Excel
                </a>
            </div> --}}
        </div>

        <table class="table appointments-table">
            <thead>
                <tr>
                    <th>S.No</th>
                    <th>Booking date</th>
                    <th>Professional Name</th>
                    <th>Service Category</th>
                    <th>Sub-Service</th>
                    <th>Plan Type</th>
                    <th>Sessions Taken</th>
                    <th>Sessions Remaining</th>
                    <th>Documents</th>
                    <th class="chat-col">Chat</th>
                    <th>Details</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($bookings as $key => $booking)
                    @php
                        $totalSessions = $booking->timedates->count();
                        $sessionsTaken = $booking->timedates->where('status', '!=', 'pending')->count();

                        // Sessions remaining (count of 'pending' timedates)
                        $sessionsRemaining = $totalSessions - $sessionsTaken;
                        
                        // Check if this service is the one being filtered
                        $isFilteredService = request('service') == $booking->service_name;
                        
                        // Check if this plan type is the one being filtered
                        $isFilteredPlan = request('plan_type') == $booking->plan_type;
                        
                        // Determine plan type class
                        $planTypeClass = 'plan-type-badge';
                        if (strtolower($booking->plan_type) == 'premium') {
                            $planTypeClass .= ' plan-type-premium';
                        } elseif (strtolower($booking->plan_type) == 'standard') {
                            $planTypeClass .= ' plan-type-standard';
                        } elseif (strtolower($booking->plan_type) == 'basic') {
                            $planTypeClass .= ' plan-type-basic';
                        } elseif (strtolower($booking->plan_type) == 'corporate') {
                            $planTypeClass .= ' plan-type-corporate';
                        }
                    @endphp

                    <tr class="{{ $isFilteredService ? 'service-highlight' : '' }} {{ $isFilteredPlan ? 'plan-highlight' : '' }}">
                        <td data-label="S.No">{{ $key + 1 }}</td>
                        <td data-label="Booking Date">{{ $booking->timedates->first() ? \Carbon\Carbon::parse($booking->timedates->first()->date)->format('d-m-Y') : '-' }}</td>
                        <td data-label="Professional Name">{{ $booking->professional->name ?? 'No Professional' }}</td>
                        <td data-label="Service Category">
                            @if($isFilteredService)
                                <strong>{{ $booking->service_name }}</strong>
                            @else
                                {{ $booking->service_name }}
                            @endif
                        </td>
                        <td data-label="Sub-Service">
                            @if($booking->sub_service_name)
                                <span class="subservice-pill">{{ $booking->sub_service_name }}</span>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td data-label="Plan Type">
    @if($booking->plan_type)
        @php
            $formattedPlanType = customerFormatPlanType($booking->plan_type);

            $planTypeClass = 'plan-type-badge';
            $planTypeLower = strtolower($booking->plan_type);

            if ($planTypeLower == 'premium') {
                $planTypeClass .= ' plan-type-premium';
            } elseif ($planTypeLower == 'standard') {
                $planTypeClass .= ' plan-type-standard';
            } elseif ($planTypeLower == 'basic') {
                $planTypeClass .= ' plan-type-basic';
            } elseif ($planTypeLower == 'corporate') {
                $planTypeClass .= ' plan-type-corporate';
            } elseif ($planTypeLower == 'one_time') {
                $planTypeClass .= ' plan-type-one-time';
            }
        @endphp
        <span class="{{ $planTypeClass }}">{{ $formattedPlanType }}</span>
    @else
        <span class="empty-state">No Plan</span>
    @endif
</td>
                        <td data-label="Sessions Taken">{{ $sessionsTaken }}</td> <!-- Sessions taken -->
                        <td data-label="Sessions Remaining">{{ $sessionsRemaining }}</td> <!-- Sessions remaining -->
                        <td data-label="Documents">
                            @if ($booking->professional_documents)
                                <a href="{{ asset('storage/' . $booking->professional_documents) }}" class="btn btn-sm btn-secondary mt-1" target="_blank">
                                    <img src="{{ asset('images/pdf-icon.png') }}" alt="PDF" style="width: 20px;">
                                </a>
                            @else
                                No Documents
                            @endif
                        </td>
                        <td class="chat-col" data-label="Chat">
                            <a href="{{ route('user.chat.open', $booking->id) }}" 
                               class="btn btn-sm chat-btn position-relative chat-btn-{{ $booking->id }}" 
                               target="_blank" 
                               title="Chat with Professional"
                               data-booking-id="{{ $booking->id }}">
                                <i class="fas fa-comments"></i> Chat
                                <span class="chat-badge badge bg-danger position-absolute top-0 start-100 translate-middle rounded-pill d-none" 
                                      id="chat-badge-{{ $booking->id }}">
                                    0
                                </span>
                            </a>
                        </td>
                        <td data-label="Details">
                            <button class="btn btn-sm btn-primary view-details-btn" data-id="{{ $booking->id }}">
                                View Details
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="12" class="text-center">No appointments found</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Enhanced Appointment Details Modal -->
    <div id="customModal" class="custom-modal">
        <div class="custom-modal-content">
            <div class="modal-header">
                <h4>Appointment Details</h4>
                <span class="close-modal">&times;</span>
            </div>
            <div class="modal-body">
                <table class="table" id="appointmentDetailsTable">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Time Slot(s)</th>
                            <th>Status</th>
                            <th>Summary/Remarks</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary close-modal-btn">Close</button>
            </div>
        </div>
    </div>

</div>
@endsection
@section('scripts')
<script>
   $(document).on('click', '.view-details-btn', function () {
    const bookingId = $(this).data('id');

    $.ajax({
        url: `/user/appointments/${bookingId}/details`,  
        type: 'GET',
        success: function (response) {
            const tbody = $('#appointmentDetailsTable tbody');
            tbody.empty();

            response.dates.forEach(item => {
                const timeSlots = item.time_slot.join(', ');
                const status = item.status ?? 'pending';
                
                // Generate status badge with appropriate class
                let statusClass = '';
                switch(status.toLowerCase()) {
                    case 'completed':
                        statusClass = 'status-completed';
                        break;
                    case 'pending':
                        statusClass = 'status-pending';
                        break;
                    case 'cancelled':
                        statusClass = 'status-cancelled';
                        break;
                    default:
                        statusClass = 'status-pending';
                }
                
                const statusBadge = `<span class="status-badge ${statusClass}">${status}</span>`;
                const formattedDate = new Date(item.date).toLocaleDateString('en-GB', {
                    day: '2-digit', 
                    month: 'short', 
                    year: 'numeric'
                });
                
                const remarks = item.remarks ? item.remarks : '<span class="empty-state">No remarks available</span>';

                tbody.append(`
                    <tr>
                        <td>${formattedDate}</td>
                        <td>${timeSlots}</td>
                        <td>${statusBadge}</td>
                        <td class="remarks-cell">${remarks}</td>
                    </tr>
                `);
            });

            $('#customModal').show();  
        },
        error: function () {
            alert('Failed to load appointment details.');
        }
    });
});

// Close modal - both X button and the Close button in footer
$(document).on('click', '.close-modal, .close-modal-btn', function () {
    $('#customModal').hide();
});

// Close modal when clicking outside modal content
$(window).on('click', function (e) {
    if ($(e.target).is('#customModal')) {
        $('#customModal').hide();
    }
});



// Chat Functionality
function openBookingChat(bookingId) {
    // Prevent opening multiple chats
    if(currentBookingChatId === bookingId && $('#bookingChatModal').is(':visible')) {
        return;
    }
    
    // Clear any existing interval
    if(messageCheckInterval) {
        clearInterval(messageCheckInterval);
        messageCheckInterval = null;
    }
    
    currentBookingChatId = bookingId;
    isPolling = false;
    
    // Initialize or get existing chat
    $.ajax({
        url: '/user/booking-chat/initialize',
        type: 'POST',
        data: {
            booking_id: bookingId,
            _token: $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {
            if(response.success) {
                currentChatId = response.chat_id;
                
                // Update modal title with booking context
                const title = `
                    <div>
                        <strong>${response.booking.service_name}</strong><br>
                        <small style="font-weight: normal; opacity: 0.8;">
                            Chat with ${response.participant.name} (${response.participant.type})
                        </small>
                    </div>
                `;
                $('#chatModalTitle').html(title);
                $('#bookingChatModal').fadeIn(300);
                
                // Load messages
                loadChatMessages(bookingId);
                
                // Attach send button click handler directly (not delegated)
                $('#sendMessageBtn').off('click').on('click', function() {
                    console.log('Send button clicked');
                    sendChatMessage();
                });
                
                // Attach Enter key handler directly
                $('#chatMessageInput').off('keypress').on('keypress', function(e) {
                    if(e.which === 13) {
                        console.log('Enter key pressed');
                        sendChatMessage();
                    }
                });
                
                // Start polling only if not already polling
                if(!messageCheckInterval && !isPolling) {
                    isPolling = true;
                    messageCheckInterval = setInterval(() => {
                        if($('#bookingChatModal').is(':visible')) {
                            loadChatMessages(bookingId);
                        }
                    }, 3000);
                }
            }
        },
        error: function(xhr) {
            alert('Error opening chat: ' + (xhr.responseJSON?.error || 'Unknown error'));
        }
    });
}

function loadChatMessages(bookingId) {
    $.ajax({
        url: `/user/booking-chat/${bookingId}/messages`,
        type: 'GET',
        success: function(response) {
            if(response.success) {
                displayChatMessages(response.messages);
            }
        },
        error: function(xhr) {
            console.error('Error loading messages:', xhr);
        }
    });
}

function displayChatMessages(messages) {
    const chatContainer = $('#chatMessages');
    const wasScrolledToBottom = chatContainer[0].scrollHeight - chatContainer.scrollTop() <= chatContainer.outerHeight() + 50;
    
    chatContainer.empty();
    
    if(messages.length === 0) {
        chatContainer.append('<div style="text-align: center; color: #999; padding: 20px;">No messages yet. Start the conversation!</div>');
    } else {
        messages.forEach(msg => {
            const isOwn = msg.sender_type === 'customer';
            const messageClass = isOwn ? 'message-own' : 'message-other';
            
            // Get sender name - fallback to type if name not available
            let senderName = msg.sender_name || 'Unknown';
            if (!msg.sender_name) {
                senderName = isOwn ? 'You' : (msg.sender_type === 'professional' ? 'Professional' : msg.sender_type);
            } else if (isOwn) {
                senderName = 'You';
            }
            
            const time = msg.formatted_time || new Date(msg.created_at).toLocaleTimeString('en-US', {hour: '2-digit', minute: '2-digit'});
            
            let messageContent = '';
            
            // Handle different message types
            if(msg.message_type === 'image' && msg.file_path) {
                messageContent = `
                    <img src="/storage/${msg.file_path}" alt="Image" style="max-width: 200px; border-radius: 8px; cursor: pointer;" onclick="window.open('/storage/${msg.file_path}', '_blank')">
                    ${msg.message ? '<div>' + msg.message + '</div>' : ''}
                `;
            } else if(msg.message_type === 'file' && msg.file_path) {
                const fileName = msg.file_path.split('/').pop();
                messageContent = `
                    <a href="/storage/${msg.file_path}" target="_blank" style="color: inherit; text-decoration: underline;">
                        <i class="fas fa-file"></i> ${fileName}
                    </a>
                    ${msg.message ? '<div>' + msg.message + '</div>' : ''}
                `;
            } else {
                messageContent = msg.message;
            }
            
            chatContainer.append(`
                <div class="chat-message ${messageClass}">
                    <div class="message-sender" style="font-weight: bold; margin-bottom: 5px;">${senderName}</div>
                    <div class="message-content">${messageContent}</div>
                    <div class="message-time" style="font-size: 11px; opacity: 0.7; margin-top: 5px;">${time}</div>
                </div>
            `);
        });
    }
    
    // Auto scroll to bottom
    if(wasScrolledToBottom) {
        chatContainer.scrollTop(chatContainer[0].scrollHeight);
    }
}

function sendChatMessage() {
    const messageInput = $('#chatMessageInput');
    const fileInput = $('#chatFileInput')[0];
    
    console.log('sendChatMessage called');
    console.log('messageInput element:', messageInput);
    console.log('messageInput length:', messageInput.length);
    console.log('messageInput value:', messageInput.val());
    
    const message = messageInput.val()?.trim() || '';
    const file = fileInput?.files[0];
    
    console.log('After processing - message:', message);
    console.log('After processing - message length:', message.length);
    console.log('After processing - file:', file);
    
    console.log('Sending message:', { message: message, hasFile: !!file });
    
    if(!message && !file) {
        console.log('No message or file to send');
        return;
    }
    
    const formData = new FormData();
    if(message) formData.append('message', message);
    if(file) formData.append('file', file);
    formData.append('_token', $('meta[name="csrf-token"]').attr('content'));
    
    console.log('FormData contents:', {
        hasMessage: formData.has('message'),
        hasFile: formData.has('file'),
        hasToken: formData.has('_token')
    });
    
    // Disable send button
    $('#sendMessageBtn').prop('disabled', true);
    
    $.ajax({
        url: `/user/booking-chat/${currentBookingChatId}/send`,
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function(response) {
            console.log('Message sent successfully:', response);
            if(response.success) {
                messageInput.val('');
                if(fileInput) fileInput.value = '';
                $('#selectedFileName').text('');
                loadChatMessages(currentBookingChatId);
            } else {
                console.error('Response success was false:', response);
                alert('Failed to send message: ' + (response.error || 'Unknown error'));
            }
        },
        error: function(xhr) {
            console.error('Error sending message:', xhr);
            const errorMsg = xhr.responseJSON?.error || xhr.responseJSON?.message || 'Unknown error';
            const details = xhr.responseJSON?.details ? JSON.stringify(xhr.responseJSON.details) : '';
            alert('Error sending message: ' + errorMsg + (details ? '\n' + details : ''));
        },
        complete: function() {
            $('#sendMessageBtn').prop('disabled', false);
        }
    });
}

// Show selected file name
$(document).on('change', '#chatFileInput', function() {
    const fileName = this.files[0]?.name || '';
    $('#selectedFileName').text(fileName ? `📎 ${fileName}` : '');
});

// Close modal and stop polling - Use OFF to prevent multiple bindings
$(document).off('click', '#closeChatModal').on('click', '#closeChatModal', function() {
    $('#bookingChatModal').fadeOut(300);
    if(messageCheckInterval) {
        clearInterval(messageCheckInterval);
        messageCheckInterval = null;
        isPolling = false;
    }
    currentBookingChatId = null;
    currentChatId = null;
});

// Close on outside click
$(window).off('click.chatModal').on('click.chatModal', function (e) {
    if ($(e.target).is('#bookingChatModal')) {
        $('#closeChatModal').trigger('click');
    }
});

// Load unread chat counts for all bookings
function loadUnreadChatCounts() {
    $('[data-booking-id]').each(function() {
        const bookingId = $(this).data('booking-id');
        const badgeElement = $(`#chat-badge-${bookingId}`);
        
        $.ajax({
            url: `/user/chat/booking/${bookingId}/unread-count`,
            method: 'GET',
            success: function(response) {
                if(response.success && response.unread_count > 0) {
                    badgeElement.text(response.unread_count);
                    badgeElement.removeClass('d-none');
                } else {
                    badgeElement.addClass('d-none');
                }
            },
            error: function() {
                // Silently fail
            }
        });
    });
}

// Load counts on page load
$(document).ready(function() {
    loadUnreadChatCounts();
    
    // Refresh counts every 30 seconds
    setInterval(loadUnreadChatCounts, 30000);
});

</script>

@endsection
