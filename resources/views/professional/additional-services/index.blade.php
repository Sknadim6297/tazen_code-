@extends('professional.layout.layout')

@section('title', 'Additional Services')

@section('styles')
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
<style>
    :root {
        --primary: #4f46e5;
        --primary-dark: #4338ca;
        --secondary: #0ea5e9;
        --accent: #22c55e;
        --danger: #ef4444;
        --warning: #f97316;
        --muted: #64748b;
        --page-bg: #f4f6fb;
        --card-bg: #ffffff;
        --border: rgba(148, 163, 184, 0.22);
        --shadow-lg: 0 28px 56px rgba(15, 23, 42, 0.14);
    }

    body,
    .app-content {
        background: var(--page-bg);
    }

    .additional-services-page {
        width: 100%;
        padding: 2.6rem 1.45rem 3.6rem;
    }

    .additional-services-shell {
        max-width: 1240px;
        margin: 0 auto;
        display: flex;
        flex-direction: column;
        gap: 2rem;
    }

    .services-hero {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        justify-content: space-between;
        gap: 1.4rem;
        padding: 2.2rem 2.5rem;
        border-radius: 28px;
        border: 1px solid rgba(79, 70, 229, 0.18);
        background: linear-gradient(135deg, rgba(79, 70, 229, 0.12), rgba(14, 165, 233, 0.14));
        position: relative;
        overflow: hidden;
        box-shadow: 0 26px 54px rgba(79, 70, 229, 0.16);
    }

    .services-hero::before,
    .services-hero::after {
        content: "";
        position: absolute;
        border-radius: 50%;
        pointer-events: none;
    }

    .services-hero::before {
        width: 360px;
        height: 360px;
        top: -48%;
        right: -14%;
        background: rgba(79, 70, 229, 0.22);
    }

    .services-hero::after {
        width: 240px;
        height: 240px;
        bottom: -45%;
        left: -12%;
        background: rgba(14, 165, 233, 0.18);
    }

    .services-hero > * {
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
        gap: 0.55rem;
        padding: 0.45rem 1.1rem;
        border-radius: 999px;
        border: 1px solid rgba(255, 255, 255, 0.6);
        background: rgba(255, 255, 255, 0.35);
        font-size: 0.76rem;
        font-weight: 600;
        letter-spacing: 0.14em;
        text-transform: uppercase;
        color: #0f172a;
    }

    .hero-meta h1 {
        margin: 0;
        font-size: 2.1rem;
        font-weight: 700;
        color: #0f172a;
    }

    .hero-breadcrumb {
        margin: 0;
        padding: 0;
        list-style: none;
        display: flex;
        flex-wrap: wrap;
        gap: 0.65rem;
        font-size: 0.88rem;
        color: var(--muted);
    }

    .hero-breadcrumb li a {
        color: var(--primary);
        text-decoration: none;
    }

    .hero-actions {
        display: flex;
        align-items: center;
        gap: 0.9rem;
        flex-wrap: wrap;
    }

    .btn-primary-pill {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.9rem 1.8rem;
        border-radius: 999px;
        font-weight: 600;
        font-size: 0.95rem;
        color: #ffffff;
        background: linear-gradient(135deg, var(--primary), var(--primary-dark));
        box-shadow: 0 20px 44px rgba(79, 70, 229, 0.22);
        text-decoration: none;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .btn-primary-pill:hover {
        transform: translateY(-2px);
        box-shadow: 0 24px 60px rgba(79, 70, 229, 0.26);
    }

    .filters-card {
        background: var(--card-bg);
        border-radius: 24px;
        border: 1px solid var(--border);
        box-shadow: var(--shadow-lg);
        padding: 1.9rem 2rem;
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }

    .filters-card__head {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 1rem;
    }

    .filters-card__head h3 {
        margin: 0;
        font-size: 1.05rem;
        font-weight: 700;
        color: #0f172a;
        display: flex;
        align-items: center;
        gap: 0.6rem;
    }

    .filters-card__head h3 i {
        color: var(--primary);
    }

    .filters-toggle {
        display: inline-flex;
        align-items: center;
        gap: 0.45rem;
        padding: 0.55rem 1rem;
        border-radius: 999px;
        border: 1px solid rgba(79, 70, 229, 0.28);
        color: var(--primary);
        background: rgba(79, 70, 229, 0.1);
        font-weight: 600;
        font-size: 0.84rem;
        cursor: pointer;
        transition: transform 0.2s ease;
    }

    .filters-toggle:hover {
        transform: translateY(-1px);
    }

    .filters-content {
        display: none;
        border-top: 1px solid rgba(148, 163, 184, 0.18);
        padding-top: 1.4rem;
        display: none;
    }

    .filters-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 1.2rem;
    }

    .filters-grid label {
        font-size: 0.86rem;
        font-weight: 600;
        color: #0f172a;
        display: block;
        margin-bottom: 0.45rem;
    }

    .filters-grid select,
    .filters-grid input[type="date"] {
        width: 100%;
        border-radius: 12px;
        border: 1px solid rgba(148, 163, 184, 0.35);
        padding: 0.65rem 0.85rem;
        font-size: 0.9rem;
        color: #0f172a;
        transition: border 0.2s ease, box-shadow 0.2s ease;
    }

    .filters-grid select:focus,
    .filters-grid input[type="date"]:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.12);
        outline: none;
    }

    .filters-actions {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        gap: 0.7rem;
        margin-top: 1.2rem;
    }

    .btn-filter-primary,
    .btn-filter-secondary {
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        border-radius: 12px;
        padding: 0.65rem 1.2rem;
        font-weight: 600;
        font-size: 0.85rem;
        border: none;
        cursor: pointer;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .btn-filter-primary {
        background: linear-gradient(135deg, var(--primary), var(--primary-dark));
        color: #fff;
        box-shadow: 0 16px 32px rgba(79, 70, 229, 0.18);
    }

    .btn-filter-secondary {
        background: rgba(148, 163, 184, 0.16);
        color: #0f172a;
        border: 1px solid rgba(148, 163, 184, 0.35);
    }

    .btn-filter-primary:hover,
    .btn-filter-secondary:hover {
        transform: translateY(-1px);
    }

    .filters-count {
        font-size: 0.82rem;
        color: var(--muted);
        margin-left: auto;
    }

    .services-card {
        background: var(--card-bg);
        border-radius: 24px;
        border: 1px solid var(--border);
        box-shadow: var(--shadow-lg);
        overflow: hidden;
    }

    .services-card__head {
        padding: 1.8rem 2.2rem 1.1rem;
        border-bottom: 1px solid rgba(148, 163, 184, 0.22);
        display: flex;
        flex-direction: column;
        gap: 0.4rem;
    }

    .services-card__head h2 {
        margin: 0;
        font-size: 1.18rem;
        font-weight: 700;
        color: #0f172a;
    }

    .services-card__head p {
        margin: 0;
        color: var(--muted);
        font-size: 0.92rem;
    }

    .services-card__body {
        padding: 2.1rem 2.2rem;
    }

    .table-wrapper {
        border-radius: 18px;
        border: 1px solid rgba(226, 232, 240, 0.85);
        overflow-x: auto;
        overflow-y: hidden;
        -webkit-overflow-scrolling: touch;
    }

    .table-wrapper::-webkit-scrollbar {
        height: 8px;
    }

    .table-wrapper::-webkit-scrollbar-track {
        background: rgba(226, 232, 240, 0.6);
        border-radius: 10px;
    }

    .table-wrapper::-webkit-scrollbar-thumb {
        background: rgba(79, 70, 229, 0.35);
        border-radius: 10px;
    }

    .table-wrapper::-webkit-scrollbar-thumb:hover {
        background: rgba(79, 70, 229, 0.55);
    }

    .data-table,
    table.dataTable {
        width: 100% !important;
        border-collapse: separate !important;
        border-spacing: 0 !important;
        font-size: 0.9rem !important;
        min-width: 1100px;
    }

    .data-table thead th,
    table.dataTable thead th {
        background: rgba(79, 70, 229, 0.09) !important;
        border-bottom: 1px solid rgba(148, 163, 184, 0.28) !important;
        color: #0f172a !important;
        font-weight: 700 !important;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        padding: 0.95rem 1rem !important;
        white-space: nowrap;
        text-align: center !important;
    }

    .data-table tbody td,
    table.dataTable tbody td {
        padding: 0.85rem 1rem !important;
        border-bottom: 1px solid rgba(226, 232, 240, 0.8) !important;
        color: #0f172a !important;
        text-align: center !important;
    }

    .data-table tbody td:first-child,
    table.dataTable tbody td:first-child,
    .data-table tbody td:nth-child(2),
    table.dataTable tbody td:nth-child(2),
    .data-table tbody td:nth-child(3),
    table.dataTable tbody td:nth-child(3) {
        text-align: left !important;
    }

    .data-table tbody tr,
    table.dataTable tbody tr {
        transition: transform 0.16s ease, box-shadow 0.16s ease;
        background: #ffffff !important;
    }

    .data-table tbody tr:hover,
    table.dataTable tbody tr:hover {
        transform: translateY(-2px);
        box-shadow: 0 12px 28px rgba(15, 23, 42, 0.12);
        background: #f8faff !important;
    }

    #additional-services-table_wrapper .dataTables_length,
    #additional-services-table_wrapper .dataTables_filter {
        display: flex;
        align-items: center;
        gap: 0.65rem;
        margin-bottom: 1.2rem;
    }

    #additional-services-table_wrapper .dataTables_length label,
    #additional-services-table_wrapper .dataTables_filter label {
        font-weight: 600;
        color: #0f172a;
        display: flex;
        align-items: center;
        gap: 0.45rem;
    }

    #additional-services-table_wrapper .dataTables_length select,
    #additional-services-table_wrapper .dataTables_filter input {
        border-radius: 12px;
        border: 1px solid rgba(148, 163, 184, 0.35);
        padding: 0.45rem 0.75rem;
        font-size: 0.85rem;
        color: #0f172a;
    }

    #additional-services-table_wrapper .dataTables_filter input {
        width: 240px;
        max-width: 100%;
    }

    #additional-services-table_wrapper .dataTables_filter input:focus,
    #additional-services-table_wrapper .dataTables_length select:focus {
        outline: none;
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.12);
    }

    #additional-services-table_wrapper .dataTables_length {
        justify-content: flex-start;
    }

    #additional-services-table_wrapper .dataTables_filter {
        justify-content: flex-end;
        flex-wrap: wrap;
    }

    .action-buttons {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        gap: 0.5rem;
        margin-bottom: 0.6rem;
    }

    .btn-action {
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
        border-radius: 999px;
        border: none;
        padding: 0.55rem 1.15rem;
        font-size: 0.8rem;
        font-weight: 600;
        cursor: pointer;
        transition: transform 0.18s ease, box-shadow 0.18s ease;
        text-decoration: none;
    }

    .btn-action.view {
        background: rgba(79, 70, 229, 0.14);
        color: var(--primary-dark);
        box-shadow: 0 12px 24px rgba(79, 70, 229, 0.18);
    }

    .btn-action.delivery {
        background: rgba(14, 165, 233, 0.18);
        color: #0369a1;
        box-shadow: 0 12px 24px rgba(14, 165, 233, 0.18);
    }

    .btn-action.complete {
        background: rgba(34, 197, 94, 0.18);
        color: #15803d;
        box-shadow: 0 12px 24px rgba(34, 197, 94, 0.18);
    }

    .btn-action:hover {
        transform: translateY(-1px);
    }

    .services-card__body .dropdown {
        position: relative;
    }

    .actions-trigger {
        display: inline-flex;
        align-items: center;
        gap: 0.45rem;
        border: none;
        border-radius: 999px;
        padding: 0.58rem 1.35rem;
        font-size: 0.83rem;
        font-weight: 600;
        background: linear-gradient(135deg, var(--primary), var(--primary-dark));
        color: #ffffff;
        box-shadow: 0 18px 34px rgba(79, 70, 229, 0.22);
        cursor: pointer;
        transition: transform 0.18s ease, box-shadow 0.18s ease;
    }

    .actions-trigger:hover {
        transform: translateY(-1px);
        box-shadow: 0 22px 44px rgba(79, 70, 229, 0.28);
    }

    .actions-trigger .caret-icon {
        font-size: 0.68rem;
        opacity: 0.8;
    }

    .services-card__body .dropdown-menu {
        border-radius: 16px;
        border: 1px solid rgba(148, 163, 184, 0.26);
        box-shadow: 0 16px 32px rgba(15, 23, 42, 0.16);
        padding: 0.35rem;
        margin-top: 0.45rem;
    }

    .services-card__body .dropdown-item {
        padding: 0.55rem 0.85rem;
        border-radius: 12px;
        font-size: 0.85rem;
        font-weight: 500;
    }

    .services-card__body .dropdown-item:hover {
        background: rgba(79, 70, 229, 0.12);
        color: var(--primary);
    }

    .status-pill,
    .badge {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.35rem;
        padding: 0.4rem 0.85rem;
        border-radius: 999px;
        font-size: 0.75rem;
        font-weight: 600;
        letter-spacing: 0.05em;
        text-transform: uppercase;
        border: none;
        color: #0f172a;
    }

    .badge-warning { background: rgba(250, 204, 21, 0.28); color: #a16207; }
    .badge-success { background: rgba(34, 197, 94, 0.25); color: #166534; }
    .badge-danger { background: rgba(248, 113, 113, 0.25); color: #b91c1c; }
    .badge-info { background: rgba(14, 165, 233, 0.22); color: #0369a1; }

    .status-subtext {
        display: block;
        margin-top: 0.35rem;
        font-size: 0.72rem;
        color: var(--muted);
    }

    .empty-state {
        text-align: center;
        padding: 3.4rem 1.6rem;
        display: flex;
        flex-direction: column;
        gap: 1rem;
        border-radius: 22px;
        border: 1px dashed rgba(79, 70, 229, 0.28);
        background: rgba(79, 70, 229, 0.08);
        color: var(--muted);
    }

    .empty-state i {
        font-size: 3.5rem;
        color: var(--primary);
    }

    .empty-state h4 {
        margin: 0;
        color: #0f172a;
    }

    .empty-state a {
        align-self: center;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.85rem 1.7rem;
        border-radius: 14px;
        background: linear-gradient(135deg, var(--primary), var(--primary-dark));
        color: #ffffff;
        text-decoration: none;
        font-weight: 600;
        box-shadow: 0 20px 44px rgba(79, 70, 229, 0.22);
        transition: transform 0.2s ease;
    }

    .empty-state a:hover {
        transform: translateY(-2px);
    }

    .modal {
        display: none;
        position: fixed;
        inset: 0;
        z-index: 1050;
        background: rgba(15, 23, 42, 0.52);
        align-items: center;
        justify-content: center;
        padding: 1.5rem;
    }

    .modal.show {
        display: flex;
    }

    .modal-dialog {
        width: 100%;
        max-width: 520px;
    }

    .modal-content {
        background: #ffffff;
        border-radius: 24px;
        border: 1px solid rgba(148, 163, 184, 0.18);
        box-shadow: 0 30px 70px rgba(15, 23, 42, 0.2);
        overflow: hidden;
    }

    .modal-header {
        padding: 1.3rem 1.6rem;
        background: rgba(79, 70, 229, 0.08);
        border-bottom: 1px solid rgba(148, 163, 184, 0.18);
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 1rem;
    }

    .modal-title {
        margin: 0;
        font-size: 1.05rem;
        font-weight: 700;
        color: #0f172a;
    }

    .btn-close {
        border: none;
        background: transparent;
        font-size: 1.6rem;
        color: var(--muted);
        cursor: pointer;
    }

    .modal-body {
        padding: 1.6rem;
        color: #0f172a;
        font-size: 0.96rem;
    }

    .modal-footer {
        padding: 1.2rem 1.6rem;
        border-top: 1px solid rgba(148, 163, 184, 0.18);
        display: flex;
        gap: 0.7rem;
        justify-content: flex-end;
    }

    .modal-footer .btn {
        border-radius: 12px;
        font-weight: 600;
        padding: 0.65rem 1.3rem;
        border: none;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 0.45rem;
    }

    .btn-secondary { background: rgba(148, 163, 184, 0.2); color: #0f172a; }
    .btn-secondary:hover { background: rgba(148, 163, 184, 0.32); }
    .btn-success { background: var(--accent); color: #fff; }
    .btn-success:hover { background: #16a34a; }
    .btn-primary { background: linear-gradient(135deg, var(--primary), var(--primary-dark)); color: #fff; }
    .btn-primary:hover { transform: translateY(-1px); }

    .form-label {
        font-weight: 600;
        color: #0f172a;
        margin-bottom: 0.45rem;
        display: block;
    }

    .modal-body .form-control {
        border-radius: 12px;
        border: 1px solid rgba(148, 163, 184, 0.35);
        padding: 0.65rem 0.85rem;
        font-size: 0.9rem;
        width: 100%;
        resize: vertical;
        min-height: auto;
    }

    .modal-body .form-control:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.12);
        outline: none;
    }

    .modal-body textarea.form-control {
        min-height: 80px;
        font-family: inherit;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button {
        border-radius: 10px !important;
        padding: 0.45rem 0.85rem !important;
        border: none !important;
        background: rgba(148, 163, 184, 0.18) !important;
        color: #0f172a !important;
        margin: 0 0.15rem !important;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button.current {
        background: linear-gradient(135deg, var(--primary), var(--primary-dark)) !important;
        color: #fff !important;
    }

    .dataTables_wrapper .dataTables_filter input,
    .dataTables_wrapper .dataTables_length select {
        border-radius: 10px;
        border: 1px solid rgba(148, 163, 184, 0.35);
        padding: 0.4rem 0.65rem;
    }

    .dataTables_wrapper .dataTables_info {
        color: var(--muted);
        font-size: 0.85rem;
    }

    @media (max-width: 1024px) {
        .additional-services-page {
            padding: 2.3rem 1.1rem 3.2rem;
        }

        .services-card__body {
            padding: 1.8rem 1.75rem;
        }
    }

    @media (max-width: 768px) {
        .services-hero {
            padding: 1.75rem 1.6rem;
        }

        .hero-actions {
            width: 100%;
            justify-content: stretch;
        }

        .btn-primary-pill {
            width: 100%;
            justify-content: center;
        }

        .filters-card {
            padding: 1.6rem 1.5rem;
        }

        .filters-actions {
            flex-direction: column;
            align-items: stretch;
        }

        .btn-filter-primary,
        .btn-filter-secondary {
            width: 100%;
            justify-content: center;
        }

        .filters-count {
            margin-left: 0;
        }

        .services-card__body {
            padding: 1.6rem 1.4rem;
        }
    }
</style>
@endsection

@section('content')
<div id="additional-services-page" class="additional-services-page">
    <div class="additional-services-shell">
        <section class="services-hero">
            <div class="hero-meta">
                <span class="hero-eyebrow"><i class="fas fa-layer-group"></i>Additional Services</span>
                <h1>Manage Additional Services</h1>
                <ul class="hero-breadcrumb">
                    <li><a href="{{ route('professional.dashboard') }}">Home</a></li>
                    <li class="active" aria-current="page">Additional Services</li>
                </ul>
            </div>
            <div class="hero-actions">
                <a href="{{ route('professional.additional-services.create') }}" class="btn-primary-pill">
                    <i class="fas fa-plus"></i>
                    Add New Service
                </a>
            </div>
        </section>

        <section class="filters-card">
            <div class="filters-card__head">
                <h3><i class="fas fa-filter"></i>Filter Services</h3>
                <button type="button" id="toggleFiltersBtn" class="filters-toggle">
                    <i class="fas fa-chevron-down" id="filterIcon"></i>
                    Toggle Filters
                </button>
            </div>

            <div id="filtersContent" class="filters-content">
                <div class="filters-grid">
                    <div>
                        <label for="filterCustomer"><i class="fas fa-user"></i> Customer</label>
                        <select id="filterCustomer">
                            <option value="">All Customers</option>
                            @php
                                $customers = $additionalServices->unique('user_id')->pluck('user')->sortBy('name');
                            @endphp
                            @foreach($customers as $customer)
                                @if($customer)
                                    <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="filterPaymentStatus"><i class="fas fa-credit-card"></i> Payment Status</label>
                        <select id="filterPaymentStatus">
                            <option value="">All Payment Status</option>
                            <option value="pending">Pending</option>
                            <option value="paid">Paid</option>
                            <option value="failed">Failed</option>
                        </select>
                    </div>

                    <div>
                        <label for="filterServiceStatus"><i class="fas fa-tasks"></i> Service Status</label>
                        <select id="filterServiceStatus">
                            <option value="">All Status</option>
                            <option value="completed">Completed</option>
                            <option value="in_progress">In Progress</option>
                            <option value="ready_to_start">Ready to Start</option>
                            <option value="awaiting_delivery_date">Awaiting Delivery Date</option>
                            <option value="awaiting_payment">Awaiting Payment</option>
                            <option value="rejected">Rejected</option>
                            <option value="under_negotiation">Under Negotiation</option>
                            <option value="price_updated">Price Updated</option>
                            <option value="pending_review">Pending Review</option>
                            <option value="awaiting_admin">Awaiting Admin</option>
                            <option value="pending">Pending</option>
                        </select>
                    </div>

                    <div>
                        <label for="filterDateRange"><i class="fas fa-calendar"></i> Date Range</label>
                        <select id="filterDateRange">
                            <option value="">All Time</option>
                            <option value="today">Today</option>
                            <option value="week">This Week</option>
                            <option value="month">This Month</option>
                            <option value="custom">Custom Range</option>
                        </select>
                    </div>
                </div>

                <div id="customDateRange" class="filters-grid" style="display: none; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));">
                    <div>
                        <label for="filterDateFrom">From Date</label>
                        <input type="date" id="filterDateFrom">
                    </div>
                    <div>
                        <label for="filterDateTo">To Date</label>
                        <input type="date" id="filterDateTo">
                    </div>
                </div>

                <div class="filters-actions">
                    <button type="button" id="applyFilters" class="btn-filter-primary">
                        <i class="fas fa-check"></i>
                        Apply Filters
                    </button>
                    <button type="button" id="clearFilters" class="btn-filter-secondary">
                        <i class="fas fa-times"></i>
                        Clear All
                    </button>
                    <span id="filterResultsCount" class="filters-count"></span>
                </div>
            </div>
        </section>

        <section class="services-card">
            <header class="services-card__head">
                <h2>Additional Services List</h2>
                <p>Monitor service requests, update delivery schedules, and manage consultation status without changing any underlying logic.</p>
            </header>
            <div class="services-card__body">
                @if($additionalServices->count() > 0)
                    <div class="table-wrapper">
                        <table class="data-table" id="additional-services-table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Service Name</th>
                                    <th>Customer</th>
                                    <th>Booking Ref</th>
                                    <th>Total Price</th>
                                    <th>Status</th>
                                    <th>Payment Status</th>
                                    <th>Created Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($additionalServices as $service)
                                    <tr>
                                        <td>#{{ $service->id }}</td>
                                        <td><strong>{{ $service->service_name }}</strong></td>
                                        <td>{{ $service->user->name }}</td>
                                        <td>
                                            <a href="#" class="text-primary" style="font-weight: 600;">
                                                #{{ $service->booking_id }}
                                            </a>
                                        </td>
                                        <td style="font-weight: 600;">₹{{ number_format($service->final_price, 2) }}</td>
                                        <td>
                                            @php
                                                $statusBadge = '';
                                                $statusText = '';
                                                $subStatusText = '';

                                                if ($service->consulting_status === 'done' && $service->customer_confirmed_at) {
                                                    $statusBadge = 'badge-success';
                                                    $statusText = 'Completed';
                                                } elseif ($service->consulting_status === 'in_progress') {
                                                    $statusBadge = 'badge-success';
                                                    $statusText = 'In Progress';
                                                } elseif ($service->admin_status === 'approved') {
                                                    if ($service->payment_status === 'paid') {
                                                        if ($service->delivery_date_set) {
                                                            $statusBadge = 'badge-success';
                                                            $statusText = 'Ready to Start';
                                                            $subStatusText = '📅 Delivery Date Set';
                                                        } else {
                                                            $statusBadge = 'badge-warning';
                                                            $statusText = 'Awaiting Delivery Date';
                                                            $subStatusText = '⏰ Set delivery date to proceed';
                                                        }
                                                    } else {
                                                        $statusBadge = 'badge-warning';
                                                        $statusText = 'Awaiting Payment';
                                                        $subStatusText = '💳 Customer needs to pay';
                                                    }
                                                } elseif ($service->admin_status === 'rejected') {
                                                    $statusBadge = 'badge-danger';
                                                    $statusText = 'Rejected';
                                                    if ($service->admin_reason) {
                                                        $subStatusText = '❌ ' . $service->admin_reason;
                                                    }
                                                } elseif ($service->admin_status === 'pending') {
                                                    if ($service->negotiation_status === 'user_negotiated') {
                                                        $statusBadge = 'badge-warning';
                                                        $statusText = 'Under Negotiation';
                                                        $subStatusText = '💬 Awaiting admin review';
                                                    } elseif ($service->negotiation_status === 'admin_responded') {
                                                        $statusBadge = 'badge-warning';
                                                        $statusText = 'Price Updated';
                                                        $subStatusText = '✅ Awaiting customer response';
                                                    } else {
                                                        if ($service->professional_status === 'pending') {
                                                            $statusBadge = 'badge-warning';
                                                            $statusText = 'Pending Review';
                                                            $subStatusText = '⏳ Awaiting admin approval';
                                                        } elseif ($service->professional_status === 'accepted') {
                                                            $statusBadge = 'badge-warning';
                                                            $statusText = 'Awaiting Admin';
                                                            $subStatusText = '👨‍💼 Under admin review';
                                                        } else {
                                                            $statusBadge = 'badge-warning';
                                                            $statusText = 'Pending';
                                                        }
                                                    }
                                                } else {
                                                    $statusBadge = 'badge-warning';
                                                    $statusText = 'Pending';
                                                }
                                            @endphp

                                            <span class="status-pill {{ $statusBadge }}">{{ $statusText }}</span>

                                            @if($subStatusText)
                                                <small class="status-subtext">{{ $subStatusText }}</small>
                                            @endif
                                        </td>
                                        <td>
                                            @if($service->payment_status === 'pending')
                                                <span class="badge badge-warning">Pending</span>
                                            @elseif($service->payment_status === 'paid')
                                                <span class="badge badge-success">Paid</span>
                                            @elseif($service->payment_status === 'failed')
                                                <span class="badge badge-danger">Failed</span>
                                            @endif
                                        </td>
                                        <td>{{ $service->created_at->format('M d, Y') }}</td>
                                        <td>
                                            <div class="action-buttons">
                                                <a href="{{ route('professional.additional-services.show', $service->id) }}" class="btn-action view">
                                                    <i class="fas fa-eye"></i>
                                                    View
                                                </a>
                                                @if(!$service->delivery_date_set)
                                                    <button type="button" class="btn-action delivery set-delivery-date" data-id="{{ $service->id }}">
                                                        <i class="fas fa-calendar-plus"></i>
                                                        Set Delivery
                                                    </button>
                                                @endif
                                                @if($service->canBeCompletedByProfessional())
                                                    <button type="button" class="btn-action complete mark-completed" data-id="{{ $service->id }}">
                                                        <i class="fas fa-check"></i>
                                                        Mark Completed
                                                    </button>
                                                @endif
                                            </div>
                                            @if($service->consulting_status === 'done' && $service->payment_status === 'paid')
                                                <div class="dropdown">
                                                    <button class="actions-trigger" type="button" onclick="toggleDropdown(this)">
                                                        <i class="fas fa-file-invoice"></i>
                                                        Invoice
                                                        <i class="fas fa-chevron-down caret-icon"></i>
                                                    </button>
                                                    <ul class="dropdown-menu">
                                                        <li>
                                                            <a href="{{ route('professional.additional-services.invoice', $service->id) }}" class="dropdown-item">
                                                                <i class="fas fa-file-alt"></i> View Invoice
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a href="{{ route('professional.additional-services.invoice.pdf', $service->id) }}" class="dropdown-item" target="_blank">
                                                                <i class="fas fa-download"></i> Download PDF Invoice
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div style="margin-top: 1.6rem; text-align: center;">
                        {{ $additionalServices->links() }}
                    </div>
                @else
                    <div class="empty-state">
                        <i class="fas fa-plus-circle"></i>
                        <h4>No Additional Services Found</h4>
                        <p>You haven't created any additional services yet.</p>
                        <a href="{{ route('professional.additional-services.create') }}">
                            <i class="fas fa-plus"></i>
                            Create Your First Additional Service
                        </a>
                    </div>
                @endif
            </div>
        </section>
    </div>
</div>

<!-- Mark Completed Modal -->
<div class="modal" id="markCompletedModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Mark Consultation Completed</h5>
                <button type="button" class="btn-close" onclick="closeModal('markCompletedModal')">&times;</button>
            </div>
            <div class="modal-body">
                Are you sure you want to mark this consultation as completed? The customer will be notified to confirm the completion.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="closeModal('markCompletedModal')">
                    <i class="fas fa-times"></i> Cancel
                </button>
                <button type="button" class="btn btn-success" id="confirmComplete">
                    <i class="fas fa-check"></i> Mark Completed
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Set Delivery Date Modal -->
<div class="modal" id="deliveryDateModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Set Delivery Date</h5>
                <button type="button" class="btn-close" onclick="closeModal('deliveryDateModal')">&times;</button>
            </div>
            <form id="deliveryDateForm">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="delivery_date" class="form-label">Delivery Date *</label>
                        <input type="date" class="form-control" id="delivery_date" name="delivery_date" min="{{ date('Y-m-d', strtotime('+1 day')) }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="delivery_reason" class="form-label">Delivery Reason *</label>
                        <textarea class="form-control" id="delivery_reason" name="delivery_reason" rows="3" placeholder="Please provide a reason for the delivery date..." required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" onclick="closeModal('deliveryDateModal')">
                        <i class="fas fa-times"></i> Cancel
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-calendar-check"></i> Set Date
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>

<script>
let currentServiceId = null;

function toggleDropdown(button) {
    const dropdown = button.closest('.dropdown');
    const menu = dropdown.querySelector('.dropdown-menu');

    document.querySelectorAll('.dropdown-menu.show').forEach(otherMenu => {
        if (otherMenu !== menu) {
            otherMenu.classList.remove('show');
        }
    });

    menu.classList.toggle('show');

    if (menu.classList.contains('show')) {
        setTimeout(() => {
            document.addEventListener('click', function closeDropdown(e) {
                if (!dropdown.contains(e.target)) {
                    menu.classList.remove('show');
                    document.removeEventListener('click', closeDropdown);
                }
            });
        }, 0);
    }
}

function showModal(modalId) {
    const modal = document.getElementById(modalId);
    if (modal) {
        modal.classList.add('show');
        document.body.style.overflow = 'hidden';
    }
}

function closeModal(modalId) {
    const modal = document.getElementById(modalId);
    if (modal) {
        modal.classList.remove('show');
        document.body.style.overflow = '';
    }
}

document.querySelectorAll('.modal').forEach(modal => {
    modal.addEventListener('click', function(e) {
        if (e.target === this) {
            closeModal(this.id);
        }
    });
});

$(document).ready(function() {
    if (typeof $.fn.DataTable === 'undefined') {
        console.error('DataTables library not loaded');
        return;
    }

    var table = $('#additional-services-table').DataTable({
        "order": [[ 7, "desc" ]],
        "pageLength": 10,
        "responsive": true,
        "language": {
            "search": "Search services:",
            "lengthMenu": "Show _MENU_ services per page",
            "info": "Showing _START_ to _END_ of _TOTAL_ services",
            "infoEmpty": "No services found",
            "infoFiltered": "(filtered from _MAX_ total services)",
            "zeroRecords": "No matching services found"
        }
    });

    $('#toggle_filters_btn, #toggleFiltersBtn').on('click', function() {
        var content = document.getElementById('filtersContent');
        var icon = document.getElementById('filterIcon');

        if (content.style.display === 'none' || content.style.display === '') {
            content.style.display = 'block';
            icon.classList.remove('fa-chevron-down');
            icon.classList.add('fa-chevron-up');
        } else {
            content.style.display = 'none';
            icon.classList.remove('fa-chevron-up');
            icon.classList.add('fa-chevron-down');
        }
    });

    $('#filterDateRange').on('change', function() {
        var customRange = document.getElementById('customDateRange');
        if ($(this).val() === 'custom') {
            customRange.style.display = 'grid';
        } else {
            customRange.style.display = 'none';
        }
    });

    $('#applyFilters').on('click', function() {
        applyFilters();
    });

    $('#clearFilters').on('click', function() {
        $('#filterCustomer').val('');
        $('#filterPaymentStatus').val('');
        $('#filterServiceStatus').val('');
        $('#filterDateRange').val('');
        $('#filterDateFrom').val('');
        $('#filterDateTo').val('');
        document.getElementById('customDateRange').style.display = 'none';

        $.fn.dataTable.ext.search = [];

        table.columns().search('').draw();

        table.search('').draw();

        updateFilterCount();

        if (typeof toastr !== 'undefined') {
            toastr.success('All filters cleared');
        }
    });

    function applyFilters() {
        var customerId = $('#filterCustomer').val();
        var paymentStatus = $('#filterPaymentStatus').val();
        var serviceStatus = $('#filterServiceStatus').val();
        var dateRange = $('#filterDateRange').val();
        var dateFrom = $('#filterDateFrom').val();
        var dateTo = $('#filterDateTo').val();

        $.fn.dataTable.ext.search = [];
        table.columns().search('');

        if (customerId) {
            var customerName = $('#filterCustomer option:selected').text();
            table.column(2).search(customerName, false, false);
        }

        if (paymentStatus) {
            var paymentText = paymentStatus.charAt(0).toUpperCase() + paymentStatus.slice(1);
            table.column(6).search(paymentText, false, false);
        }

        if (serviceStatus) {
            var statusMapping = {
                'completed': 'Completed',
                'in_progress': 'In Progress',
                'ready_to_start': 'Ready to Start',
                'awaiting_delivery_date': 'Awaiting Delivery Date',
                'awaiting_payment': 'Awaiting Payment',
                'rejected': 'Rejected',
                'under_negotiation': 'Under Negotiation',
                'price_updated': 'Price Updated',
                'pending_review': 'Pending Review',
                'awaiting_admin': 'Awaiting Admin',
                'pending': 'Pending'
            };
            var statusText = statusMapping[serviceStatus] || serviceStatus;
            table.column(5).search(statusText, false, false);
        }

        if (dateRange && dateRange !== 'custom') {
            var today = new Date();
            var filterDate = new Date();

            switch(dateRange) {
                case 'today':
                    filterDate.setHours(0, 0, 0, 0);
                    break;
                case 'week':
                    filterDate.setDate(today.getDate() - 7);
                    break;
                case 'month':
                    filterDate.setMonth(today.getMonth() - 1);
                    break;
            }

            $.fn.dataTable.ext.search.push(
                function(settings, data, dataIndex) {
                    var dateStr = data[7];
                    if (!dateStr) return true;

                    var rowDate = new Date(dateStr);

                    if (dateRange === 'today') {
                        return rowDate.toDateString() === today.toDateString();
                    } else {
                        return rowDate >= filterDate;
                    }
                }
            );
        } else if (dateRange === 'custom' && dateFrom && dateTo) {
            var fromDate = new Date(dateFrom);
            var toDate = new Date(dateTo);
            toDate.setHours(23, 59, 59, 999);

            $.fn.dataTable.ext.search.push(
                function(settings, data, dataIndex) {
                    var dateStr = data[7];
                    if (!dateStr) return true;

                    var rowDate = new Date(dateStr);
                    return rowDate >= fromDate && rowDate <= toDate;
                }
            );
        }

        table.draw();

        updateFilterCount();

        var activeFilters = 0;
        if (customerId) activeFilters++;
        if (paymentStatus) activeFilters++;
        if (serviceStatus) activeFilters++;
        if (dateRange) activeFilters++;

        if (activeFilters > 0 && typeof toastr !== 'undefined') {
            toastr.success(activeFilters + ' filter(s) applied');
        }
    }

    function updateFilterCount() {
        var info = table.page.info();
        var countText = '';

        if (info.recordsDisplay < info.recordsTotal) {
            countText = 'Showing ' + info.recordsDisplay + ' of ' + info.recordsTotal + ' services';
        } else {
            countText = 'Showing all ' + info.recordsTotal + ' services';
        }

        $('#filterResultsCount').text(countText);
    }

    updateFilterCount();

    table.on('draw', function() {
        updateFilterCount();
    });

    $(document).on('click', '.mark-completed', function(e) {
        e.preventDefault();
        e.stopPropagation();
        currentServiceId = $(this).data('id');
        showModal('markCompletedModal');
    });

    $('#confirmComplete').click(function() {
        if (currentServiceId) {
            $.ajax({
                url: `/professional/additional-services/${currentServiceId}/mark-completed`,
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.success) {
                        toastr.success(response.message);
                        location.reload();
                    } else {
                        toastr.error(response.message);
                    }
                },
                error: function() {
                    toastr.error('An error occurred. Please try again.');
                }
            });
        }
        closeModal('markCompletedModal');
    });

    $(document).on('click', '.set-delivery-date', function(e) {
        e.preventDefault();
        e.stopPropagation();
        currentServiceId = $(this).data('id');
        showModal('deliveryDateModal');
    });

    $('#deliveryDateForm').submit(function(e) {
        e.preventDefault();

        if (currentServiceId) {
            $.ajax({
                url: `/professional/additional-services/${currentServiceId}/set-delivery-date`,
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    delivery_date: $('#delivery_date').val(),
                    delivery_reason: $('#delivery_reason').val()
                },
                success: function(response) {
                    if (response.success) {
                        toastr.success(response.message);
                        location.reload();
                    } else {
                        toastr.error(response.message);
                    }
                },
                error: function(xhr) {
                    const errors = xhr.responseJSON?.errors;
                    if (errors) {
                        Object.values(errors).forEach(function(error) {
                            toastr.error(error[0]);
                        });
                    } else {
                        toastr.error('An error occurred. Please try again.');
                    }
                }
            });
        }
        closeModal('deliveryDateModal');
    });
});
</script>
@endsection