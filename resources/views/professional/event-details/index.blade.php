@extends('professional.layout.layout')

@section('styles')
<style>
    :root {
        --primary: #4f46e5;
        --primary-dark: #4338ca;
        --info: #0ea5e9;
        --danger: #ef4444;
        --muted: #64748b;
        --page-bg: #f4f6fb;
        --card-bg: #ffffff;
        --border: rgba(148, 163, 184, 0.22);
        --text-dark: #0f172a;
    }

    .event-details-page {
        width: 100%;
        min-height: 100%;
        background: var(--page-bg);
        padding: 2.4rem 1.5rem 3.2rem;
    }

    .event-details-shell {
        max-width: 1180px;
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
        padding: 2rem 2.4rem;
        border-radius: 28px;
        border: 1px solid rgba(79, 70, 229, 0.18);
        background: linear-gradient(135deg, rgba(79, 70, 229, 0.12), rgba(14, 165, 233, 0.16));
        position: relative;
        overflow: hidden;
        box-shadow: 0 24px 54px rgba(79, 70, 229, 0.16);
    }

    .services-hero::before,
    .services-hero::after {
        content: "";
        position: absolute;
        border-radius: 50%;
        pointer-events: none;
    }

    .services-hero::before {
        width: 340px;
        height: 340px;
        top: -46%;
        right: -12%;
        background: rgba(79, 70, 229, 0.2);
    }

    .services-hero::after {
        width: 220px;
        height: 220px;
        bottom: -42%;
        left: -10%;
        background: rgba(14, 165, 233, 0.18);
    }

    .services-hero > * { position: relative; z-index: 1; }

    .hero-meta {
        display: flex;
        flex-direction: column;
        gap: 0.75rem;
        color: var(--muted);
    }

    .hero-eyebrow {
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        padding: 0.35rem 1rem;
        border-radius: 999px;
        font-size: 0.72rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.12em;
        background: rgba(255, 255, 255, 0.35);
        border: 1px solid rgba(255, 255, 255, 0.45);
        color: #0f172a;
    }

    .hero-meta h1 {
        margin: 0;
        font-size: 2rem;
        font-weight: 700;
        color: #0f172a;
    }

    .hero-meta p {
        margin: 0;
        font-size: 0.94rem;
        color: var(--muted);
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

    .hero-breadcrumb li {
        display: inline-flex;
        align-items: center;
        gap: 0.6rem;
    }

    .hero-breadcrumb li + li:before {
        content: '/';
        color: rgba(79, 70, 229, 0.5);
    }

    .hero-breadcrumb li a {
        color: var(--primary);
        text-decoration: none;
        font-weight: 600;
    }

    .hero-actions {
        display: flex;
        align-items: center;
        gap: 0.9rem;
        flex-wrap: wrap;
    }

    .btn-primary-pill,
    .btn-outline-pill {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.9rem 1.8rem;
        border-radius: 999px;
        font-weight: 600;
        font-size: 0.95rem;
        text-decoration: none;
        transition: transform 0.2s ease, box-shadow 0.2s ease, background 0.2s ease, color 0.2s ease;
    }

    .btn-primary-pill {
        color: #ffffff;
        background: linear-gradient(135deg, var(--primary), var(--primary-dark));
        box-shadow: 0 20px 44px rgba(79, 70, 229, 0.22);
        border: none;
    }

    .btn-primary-pill:hover {
        transform: translateY(-2px);
        box-shadow: 0 24px 60px rgba(79, 70, 229, 0.26);
    }

    .btn-outline-pill {
        color: var(--primary);
        background: rgba(79, 70, 229, 0.08);
        border: 1px solid rgba(79, 70, 229, 0.32);
    }

    .btn-outline-pill:hover {
        background: rgba(79, 70, 229, 0.14);
        transform: translateY(-1px);
    }

    .services-card {
        background: var(--card-bg);
        border-radius: 24px;
        border: 1px solid var(--border);
        box-shadow: 0 24px 52px rgba(15, 23, 42, 0.12);
        overflow: hidden;
    }

    .services-card--warning {
        border: 1px solid rgba(250, 204, 21, 0.32);
        background: rgba(253, 230, 138, 0.12);
        box-shadow: 0 24px 48px rgba(250, 204, 21, 0.18);
    }

    .services-card__head {
        padding: 1.7rem 2.1rem 1.2rem;
        border-bottom: 1px solid rgba(148, 163, 184, 0.18);
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        justify-content: space-between;
        gap: 1rem;
    }

    .services-card__head h2,
    .services-card__head h4 {
        margin: 0;
        font-size: 1.18rem;
        font-weight: 700;
        color: var(--text-dark);
        display: inline-flex;
        align-items: center;
        gap: 0.6rem;
    }

    .services-card__head p,
    .services-card__head small {
        margin: 0;
        color: var(--muted);
        font-size: 0.9rem;
    }

    .services-card__body {
        padding: 2.1rem 2.1rem;
        display: flex;
        flex-direction: column;
        gap: 1.6rem;
    }

    .alert {
        border-radius: 16px;
        border: none;
        padding: 1rem 1.4rem;
        font-weight: 500;
        box-shadow: 0 18px 38px rgba(15, 23, 42, 0.1);
    }

    .alert-success { background: rgba(34, 197, 94, 0.1); color: #15803d; }
    .alert-danger { background: rgba(239, 68, 68, 0.1); color: #b91c1c; }

    .alert .btn-close {
        border-radius: 50%;
        background: rgba(148, 163, 184, 0.2);
        width: 2rem;
        height: 2rem;
        opacity: 1;
        color: var(--muted);
        transition: background 0.18s ease, color 0.18s ease;
    }

    .alert .btn-close:hover {
        background: rgba(148, 163, 184, 0.34);
        color: var(--text-dark);
    }

    .events-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
        gap: 1.2rem;
    }

    .event-card {
        border-radius: 20px;
        border: 1px solid rgba(250, 204, 21, 0.34);
        background: rgba(253, 230, 138, 0.15);
        padding: 1.4rem 1.6rem;
        display: flex;
        flex-direction: column;
        gap: 0.75rem;
        box-shadow: 0 16px 36px rgba(250, 204, 21, 0.18);
    }

    .event-card h6 {
        margin: 0;
        font-size: 1rem;
        font-weight: 700;
        color: #92400e;
    }

    .event-card p {
        margin: 0;
        color: #b45309;
        font-size: 0.88rem;
        line-height: 1.4;
    }

    .event-card .event-meta {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 0.8rem;
        margin-top: auto;
    }

    .event-card small {
        color: rgba(124, 58, 18, 0.9);
        font-weight: 600;
    }

    .event-card .btn-warning {
        padding: 0.5rem 1.1rem;
        font-size: 0.78rem;
    }

    .event-details-page .btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.4rem;
        border-radius: 999px;
        font-weight: 600;
        letter-spacing: 0.01em;
        padding: 0.55rem 1.2rem;
        border: none;
        transition: transform 0.18s ease, box-shadow 0.18s ease, background 0.18s ease;
    }

    .event-details-page .btn-sm {
        padding: 0.45rem 0.95rem;
        font-size: 0.82rem;
    }

    .event-details-page .btn i {
        font-size: 0.85rem;
    }

    .event-details-page .btn-primary {
        background: linear-gradient(135deg, var(--primary), var(--primary-dark));
        color: #fff;
        box-shadow: 0 12px 28px rgba(79, 70, 229, 0.24);
    }

    .event-details-page .btn-info {
        background: linear-gradient(135deg, var(--info), #0284c7);
        color: #fff;
        box-shadow: 0 12px 24px rgba(14, 165, 233, 0.2);
    }

    .event-details-page .btn-danger {
        background: linear-gradient(135deg, var(--danger), #dc2626);
        color: #fff;
        box-shadow: 0 12px 24px rgba(239, 68, 68, 0.24);
    }

    .event-details-page .btn-warning {
        background: linear-gradient(135deg, #fbbf24, #f97316);
        color: #fff;
        box-shadow: 0 12px 24px rgba(249, 115, 22, 0.22);
    }

    .event-details-page .btn-outline-primary {
        background: transparent;
        color: var(--primary);
        border: 1px solid rgba(79, 70, 229, 0.4);
    }

    .event-details-page .btn:hover {
        transform: translateY(-1px);
        box-shadow: 0 16px 32px rgba(15, 23, 42, 0.18);
    }

    .event-details-page .btn-outline-primary:hover {
        background: rgba(79, 70, 229, 0.08);
    }

    .event-details-page .btn-group {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }

    .event-details-page .btn-group form {
        margin: 0;
    }

    .event-details-page .btn-close {
        border-radius: 50%;
        background: rgba(148, 163, 184, 0.15);
        width: 1.9rem;
        height: 1.9rem;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        color: var(--text-dark);
        transition: background 0.18s ease;
    }

    .event-details-page .btn-close:hover {
        background: rgba(148, 163, 184, 0.28);
    }

    .status-badge,
    .table .badge {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 0.4rem 0.85rem;
        border-radius: 999px;
        font-size: 0.76rem;
        font-weight: 600;
        letter-spacing: 0.04em;
        text-transform: uppercase;
    }

    .badge-primary-transparent { background: rgba(79, 70, 229, 0.12); color: var(--primary); }
    .badge-warning-transparent { background: rgba(251, 191, 36, 0.18); color: #b45309; }
    .badge-info-transparent { background: rgba(14, 165, 233, 0.18); color: #0c4a6e; }

    .table-wrapper {
        border-radius: 20px;
        border: 1px solid rgba(226, 232, 240, 0.75);
        overflow: hidden;
        box-shadow: inset 0 0 0 1px rgba(248, 250, 255, 0.6);
    }

    .table-controls {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        justify-content: space-between;
        gap: 0.75rem;
        padding: 0.2rem 0.35rem;
    }

    .table-controls--top {
        margin-bottom: 0.75rem;
    }

    .table-controls--bottom {
        margin-top: 1rem;
        padding-top: 0.85rem;
        border-top: 1px solid rgba(148, 163, 184, 0.18);
    }

    .table-control {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        gap: 0.65rem;
    }

    .table-control--length,
    .table-control--info {
        justify-content: flex-start;
    }

    .table-control--search,
    .table-control--pagination {
        margin-left: auto;
        justify-content: flex-end;
    }

    .table-controls--top .dataTables_length,
    .table-controls--top .dataTables_filter {
        display: flex;
        align-items: center;
        gap: 0.65rem;
    }

    .table-controls--top .dataTables_length label,
    .table-controls--top .dataTables_filter label {
        font-weight: 600;
        color: var(--text-dark);
        display: flex;
        align-items: center;
        gap: 0.45rem;
    }

    .table-controls--top .dataTables_length select,
    .table-controls--top .dataTables_filter input {
        border-radius: 12px;
        border: 1px solid rgba(148, 163, 184, 0.35);
        padding: 0.45rem 0.75rem;
        font-size: 0.85rem;
        color: var(--text-dark);
    }

    .table-controls--top .dataTables_filter input {
        width: 240px;
        max-width: 100%;
    }

    .table-controls--top .dataTables_filter input:focus,
    .table-controls--top .dataTables_length select:focus {
        outline: none;
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.12);
    }

    .table-controls--bottom .dataTables_paginate {
        display: flex;
        align-items: center;
        gap: 0.35rem;
    }

    .table-controls--bottom .dataTables_paginate .paginate_button {
        border-radius: 10px !important;
        padding: 0.45rem 0.85rem !important;
        border: none !important;
        background: rgba(148, 163, 184, 0.18) !important;
        color: #0f172a !important;
        margin: 0 0.15rem !important;
    }

    .table-controls--bottom .dataTables_paginate .paginate_button.current {
        background: linear-gradient(135deg, var(--primary), var(--primary-dark)) !important;
        color: #fff !important;
    }

    .table-controls--bottom .dataTables_info {
        color: var(--muted);
        font-size: 0.85rem;
    }

    .data-table {
        margin: 0;
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
        font-size: 0.9rem;
    }

    .data-table thead th {
        background: rgba(79, 70, 229, 0.09);
        color: var(--text-dark);
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        padding: 0.95rem 1rem;
        border-bottom: 1px solid rgba(148, 163, 184, 0.26);
        text-align: center;
    }

    .data-table tbody td {
        padding: 0.9rem 1rem;
        border-bottom: 1px solid rgba(226, 232, 240, 0.8);
        color: var(--text-dark);
        vertical-align: middle;
    }

    .data-table tbody tr:last-child td {
        border-bottom: none;
    }

    .data-table tbody tr:hover {
        background: rgba(248, 250, 255, 0.85);
    }

    .data-table tbody td:first-child {
        text-align: left;
    }

    .event-meta-info {
        display: flex;
        align-items: center;
        gap: 0.9rem;
    }

    .event-meta-info img {
        width: 72px;
        height: 72px;
        border-radius: 16px;
        object-fit: cover;
        box-shadow: 0 14px 28px rgba(15, 23, 42, 0.18);
        border: 2px solid rgba(255, 255, 255, 0.9);
    }

    .event-meta-info .title {
        font-weight: 600;
        font-size: 0.98rem;
        color: var(--text-dark);
    }

    .event-meta-info .subtitle {
        font-size: 0.84rem;
        color: var(--muted);
    }

    .empty-state {
        text-align: center;
        padding: 3rem 1.6rem;
        border-radius: 20px;
        border: 1px dashed rgba(79, 70, 229, 0.28);
        background: rgba(79, 70, 229, 0.08);
        color: var(--muted);
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 1rem;
    }

    .empty-state i {
        font-size: 3.2rem;
        color: var(--primary);
    }

    .empty-state h5 {
        margin: 0;
        color: var(--text-dark);
        font-weight: 700;
    }

    .empty-state p {
        margin: 0;
        color: var(--muted);
        font-size: 0.95rem;
    }

    @media (max-width: 1024px) {
        .event-details-page {
            padding: 2.2rem 1.2rem 3rem;
        }

        .services-card__body {
            padding: 1.8rem 1.9rem;
        }

        .services-card__head {
            padding: 1.4rem 1.8rem;
        }
    }

    @media (max-width: 768px) {
        .event-details-page {
            padding: 2rem 1rem 2.4rem;
        }

        .event-details-shell {
            gap: 1.5rem;
        }

        .services-hero {
            padding: 1.4rem 1.6rem;
        }

        .hero-meta h1 {
            font-size: 1.6rem;
        }

        .services-card {
            border-radius: 20px;
        }

        .services-card__body {
            padding: 1.6rem;
        }

        .services-card__head {
            padding: 1.4rem 1.6rem;
            flex-direction: column;
            align-items: flex-start;
            gap: 0.8rem;
        }

        .events-grid {
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        }

        .event-meta-info {
            flex-direction: column;
            align-items: flex-start;
        }

        .event-meta-info img {
            width: 100%;
            max-width: 240px;
        }

        .event-details-page .btn-group {
            flex-wrap: wrap;
            justify-content: flex-start;
        }

        .table-controls {
            flex-direction: column;
            align-items: stretch;
            gap: 0.85rem;
        }

        .table-control {
            justify-content: stretch;
        }

        .table-control--search,
        .table-control--pagination {
            margin-left: 0;
            justify-content: flex-start;
        }

        .table-controls--top .dataTables_filter input {
            width: 100%;
        }

        .table-controls--bottom {
            align-items: center;
        }

        .data-table thead th,
        .data-table tbody td {
            white-space: nowrap;
        }

        .table-wrapper {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }
    }
</style>
@endsection

@section('content')
<div class="content-wrapper event-details-page">
    <div class="event-details-shell">
        <section class="services-hero">
            <div class="hero-meta">
                <span class="hero-eyebrow"><i class="fas fa-calendar-alt"></i>Event Management</span>
                <h1>Event Details</h1>
                <p>Manage descriptions, schedules, and pricing for your published events.</p>
                <ul class="hero-breadcrumb">
                    <li><a href="{{ route('professional.dashboard') }}">Home</a></li>
                    <li class="active" aria-current="page">Event Details</li>
                </ul>
            </div>
            <div class="hero-actions">
                <a href="{{ route('professional.event-details.create') }}" class="btn-primary-pill">
                    <i class="fas fa-plus-circle"></i>
                    Add Event Detail
                </a>
                <a href="{{ route('professional.events.create') }}" class="btn-outline-pill">
                    <i class="fas fa-calendar-plus"></i>
                    Create Event
                </a>
            </div>
        </section>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Events Without Details Card -->
    @if($eventsWithoutDetails->count() > 0)
    <section class="services-card services-card--warning">
        <header class="services-card__head">
            <div>
                <h4 class="text-warning mb-0">
                    <i class="fas fa-exclamation-triangle"></i>
                    Events Without Details
                </h4>
                <small>Complete the missing information below to help customers discover your events.</small>
            </div>
            <span class="status-badge badge-warning-transparent">{{ $eventsWithoutDetails->count() }} Pending</span>
        </header>
        <div class="services-card__body">
            <div class="events-grid">
                @foreach($eventsWithoutDetails as $event)
                <div class="event-card">
                    <h6>{{ $event->heading }}</h6>
                    <p>{{ Str::limit($event->short_description, 90) }}</p>
                    <div class="event-meta">
                        <small>{{ $event->date ? \Carbon\Carbon::parse($event->date)->format('M d, Y') : 'No date set' }}</small>
                        <a href="{{ route('professional.event-details.create', ['event_id' => $event->id]) }}" class="btn btn-warning btn-sm">
                            <i class="fas fa-plus"></i>
                            Add Details
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    <!-- Event Details List -->
    <section class="services-card">
        <header class="services-card__head">
            <div>
                <h2><i class="fas fa-calendar-check"></i>Event Details</h2>
                <p>Manage detailed information for your events ({{ $eventdetails->count() }})</p>
            </div>
        </header>
        <div class="services-card__body">
            @if($eventdetails->count() > 0)
                <div class="table-controls table-controls--top">
                    <div class="table-control table-control--length"></div>
                    <div class="table-control table-control--search"></div>
                </div>
                <div class="table-wrapper">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Event</th>
                                <th>Type</th>
                                <th>Starting Date</th>
                                <th>Starting Fees</th>
                                <th>Mode</th>
                                <th>City</th>
                                <th>Created</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($eventdetails as $detail)
                            <tr>
                                <td>
                                    <div class="event-meta-info">
                                        @if($detail->banner_image)
                                            @php
                                                $bannerImages = json_decode($detail->banner_image);
                                                $firstImage = is_array($bannerImages) && count($bannerImages) > 0 ? $bannerImages[0] : null;
                                            @endphp
                                            @if($firstImage)
                                                <img src="{{ asset('storage/' . $firstImage) }}" alt="Event banner">
                                            @endif
                                        @endif
                                        <div>
                                            <div class="title">{{ $detail->event->heading ?? 'N/A' }}</div>
                                            <div class="subtitle">{{ Str::limit($detail->event->mini_heading ?? '', 40) }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="status-badge badge-primary-transparent">{{ $detail->event_type }}</span>
                                </td>
                                <td>{{ $detail->starting_date ? $detail->starting_date->format('M d, Y') : 'N/A' }}</td>
                                <td>
                                    <span class="fw-semibold text-success">₹{{ number_format($detail->starting_fees, 2) }}</span>
                                </td>
                                <td>
                                    @if($detail->event_mode)
                                        <span class="status-badge {{ $detail->event_mode === 'online' ? 'badge-info-transparent' : 'badge-warning-transparent' }}">
                                            {{ ucfirst($detail->event_mode) }}
                                        </span>
                                    @else
                                        <span class="text-muted">N/A</span>
                                    @endif
                                </td>
                                <td>{{ $detail->city ?? 'N/A' }}</td>
                                <td>{{ $detail->created_at->format('M d, Y') }}</td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('professional.event-details.show', $detail) }}" class="btn btn-sm btn-info" title="View">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('professional.event-details.edit', $detail) }}" class="btn btn-sm btn-primary" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('professional.event-details.destroy', $detail) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this event detail?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" title="Delete">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="table-controls table-controls--bottom">
                    <div class="table-control table-control--info"></div>
                    <div class="table-control table-control--pagination"></div>
                </div>
            @else
                <div class="empty-state">
                    <i class="fas fa-calendar-alt"></i>
                    <h5>No Event Details Found</h5>
                    <p>You haven't added details to any of your events yet.</p>
                    @if($eventsWithoutDetails->count() > 0)
                        <a href="{{ route('professional.event-details.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus"></i>
                            Add Your First Event Detail
                        </a>
                    @else
                        <p>Create an event first, then come back to add details.</p>
                        <a href="{{ route('professional.events.create') }}" class="btn btn-outline-primary">
                            <i class="fas fa-plus"></i>
                            Create Event
                        </a>
                    @endif
                </div>
            @endif
        </div>
    </section>
</div>
</div>
@endsection

@section('scripts')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script>
$(document).ready(function() {
    var $table = $('.data-table');
    if (!$table.length || typeof $.fn.DataTable === 'undefined') {
        return;
    }

    var table = $table.DataTable({
        order: [[6, 'desc']],
        pageLength: 10,
        responsive: true,
        language: {
            search: 'Search events:',
            lengthMenu: 'Show _MENU_ events per page',
            info: 'Showing _START_ to _END_ of _TOTAL_ events',
            infoEmpty: 'No events found',
            infoFiltered: '(filtered from _MAX_ total events)',
            zeroRecords: 'No matching events found'
        }
    });

    var $wrapper = $table.closest('.dataTables_wrapper');
    if ($wrapper.length) {
        $wrapper.find('.dataTables_length').appendTo('.table-control--length');
        $wrapper.find('.dataTables_filter').appendTo('.table-control--search');
        $wrapper.find('.dataTables_info').appendTo('.table-control--info');
        $wrapper.find('.dataTables_paginate').appendTo('.table-control--pagination');
    }
});
</script>
@endsection