@extends('customer.layout.layout')

@section('styles')
<link rel="stylesheet" href="{{ asset('customer-css/assets/css/upcoming-appointment.css') }}" />
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
        --border-soft: rgba(247, 168, 108, 0.28);
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

    .content-wrapper {
        max-width: 1180px;
        margin: 0 auto;
        padding: 2.8rem 1.6rem 3.2rem;
    }

    .upcoming-hero {
        background: linear-gradient(135deg, rgba(251, 209, 173, 0.95), rgba(255, 244, 232, 0.95));
        border-radius: var(--radius-lg);
        padding: 2.6rem 2.4rem;
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
        gap: 1.6rem 2rem;
        box-shadow: var(--shadow-lg);
        position: relative;
        overflow: hidden;
    }

    .upcoming-hero::before,
    .upcoming-hero::after {
        content: '';
        position: absolute;
        border-radius: 999px;
        pointer-events: none;
    }

    .upcoming-hero::before {
        width: 320px;
        height: 320px;
        top: -200px;
        right: -120px;
        background: rgba(247, 168, 108, 0.26);
    }

    .upcoming-hero::after {
        width: 240px;
        height: 240px;
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
        color: var(--neutral-900);
    }

    .hero-meta h3 {
        margin: 0;
        font-size: 2.1rem;
        font-weight: 700;
        letter-spacing: -0.02em;
    }

    .hero-meta p {
        margin: 0;
        max-width: 540px;
        line-height: 1.6;
        color: rgba(47, 47, 47, 0.7);
    }

    .hero-breadcrumb {
        display: flex;
        gap: 0.6rem;
        padding: 0;
        margin: 0;
        list-style: none;
        flex-wrap: wrap;
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
        background: rgba(247, 168, 108, 0.16);
        color: var(--primary-dark);
        font-weight: 600;
        font-size: 0.9rem;
    }

    .filter-card {
        margin-top: 2.2rem;
        background: var(--surface);
        border-radius: var(--radius-md);
        box-shadow: var(--shadow-md);
        border: 1px solid var(--border-soft);
        padding: 2rem 2.2rem;
    }

    .filter-card header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 1rem;
        margin-bottom: 1.6rem;
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

.search-form input[type="text"],
.search-form input[type="date"],
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

    .search-buttons .btn-primary,
    .search-buttons .btn-secondary {
        width: auto;
    }

    .content-section {
        margin-top: 2.4rem;
        background: var(--surface);
        border-radius: var(--radius-md);
        border: 1px solid var(--border-soft);
        box-shadow: var(--shadow-md);
        padding: 1.9rem 1.6rem;
    }

    .section-header h4 {
        margin: 0;
        font-size: 1.2rem;
        font-weight: 600;
        color: var(--neutral-900);
    }

    .section-header small {
        font-size: 0.84rem;
        color: var(--neutral-500);
    }

    .table-wrapper {
        margin-top: 1.2rem;
        overflow-x: auto;
        border-radius: var(--radius-sm);
        box-shadow: var(--shadow-sm);
        border: 1px solid rgba(226, 232, 240, 0.7);
    }

    .data-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
        background: var(--surface);
        min-width: 1024px;
    }

    .data-table thead th {
        background: rgba(255, 244, 232, 0.7);
        color: var(--neutral-700);
    font-weight: 600;
        font-size: 0.78rem;
        letter-spacing: 0.08em;
        text-transform: uppercase;
        padding: 0.9rem 0.95rem;
        border-bottom: 1px solid rgba(247, 168, 108, 0.18);
        white-space: nowrap;
    }

    .data-table tbody td {
        padding: 0.95rem;
        border-bottom: 1px solid rgba(226, 232, 240, 0.7);
        color: var(--neutral-700);
        vertical-align: middle;
        background: var(--surface);
    }

    .data-table tbody tr:hover td {
        background: rgba(251, 209, 173, 0.12);
    }

    .subservice-pill {
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

    .plan-type-badge {
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

    .meet-link-btn {
        display: inline-flex;
        align-items: center;
        gap: 0.45rem;
        padding: 0.55rem 1rem;
        border-radius: 999px;
        background: linear-gradient(135deg, rgba(125, 211, 252, 0.32), rgba(14, 165, 233, 0.32));
        color: var(--accent-dark);
        font-weight: 600;
        border: 1px solid rgba(125, 211, 252, 0.42);
        transition: transform 0.18s ease, box-shadow 0.18s ease;
    }

    .meet-link-btn:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-sm);
        color: var(--accent-dark);
    }

    .document-actions {
        display: flex;
        gap: 0.45rem;
        align-items: center;
        flex-wrap: wrap;
    }

    .action-buttons {
        display: flex;
        gap: 0.45rem;
        align-items: center;
    }

    .btn-sm {
        border-radius: 999px;
        padding: 0.55rem 1rem;
        font-weight: 600;
        font-size: 0.83rem;
        border: none;
        transition: transform 0.18s ease, box-shadow 0.18s ease;
    }

    .btn-sm:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-sm);
    }

    .btn-sm.btn-info {
        background: rgba(125, 211, 252, 0.22);
        color: var(--accent-dark);
        border: 1px solid rgba(125, 211, 252, 0.35);
    }

    .btn-sm.btn-warning {
        background: rgba(250, 204, 21, 0.22);
        color: #92400e;
        border: 1px solid rgba(250, 204, 21, 0.35);
    }

    .btn-sm.btn-primary {
        background: rgba(147, 197, 253, 0.22);
        color: #1d4ed8;
        border: 1px solid rgba(147, 197, 253, 0.35);
    }

    .btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.4rem;
        font-weight: 600;
        border-radius: 999px;
        cursor: pointer;
        transition: transform 0.18s ease, box-shadow 0.18s ease;
        text-decoration: none;
    }

    .btn-primary {
        background: linear-gradient(135deg, var(--primary), var(--primary-dark));
        color: var(--surface);
        border: none;
        padding: 0.75rem 1.4rem;
        box-shadow: 0 14px 30px rgba(247, 168, 108, 0.28);
    }

    .btn-secondary {
        background: rgba(255, 255, 255, 0.95);
        color: var(--neutral-700);
        border: 1px solid rgba(148, 163, 184, 0.25);
        padding: 0.75rem 1.4rem;
    }

    .btn:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-sm);
    }

    .empty-state {
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
        color: var(--neutral-500);
        font-size: 0.82rem;
        font-weight: 500;
    }

    .status-badge {
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

    .service-highlight {
        background: rgba(125, 211, 252, 0.12);
    }

    .plan-highlight {
        background: rgba(187, 247, 208, 0.14);
    }

.custom-modal {
    display: none;
    position: fixed;
        inset: 0;
    z-index: 1050;
        background-color: rgba(17, 24, 39, 0.55);
        backdrop-filter: blur(6px);
        padding: 1.5rem;
}

.custom-modal-content {
        background: var(--surface);
        border-radius: var(--radius-lg);
        border: 1px solid var(--border-soft);
        box-shadow: var(--shadow-lg);
        width: min(640px, 100%);
        max-height: 90vh;
        overflow-y: auto;
        animation: fadeIn 0.24s ease;
    display: flex;
    flex-direction: column;
}

.custom-modal-header {
        padding: 1.6rem 1.9rem;
        border-bottom: 1px solid rgba(247, 168, 108, 0.22);
        background: rgba(255, 255, 255, 0.9);
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.custom-modal-title {
    margin: 0;
        font-size: 1.2rem;
        font-weight: 600;
        color: var(--neutral-900);
}

.custom-modal-close {
    background: none;
    border: none;
    font-size: 1.5rem;
        color: var(--neutral-500);
    cursor: pointer;
}

.custom-modal-body {
        padding: 1.8rem 1.9rem;
    flex: 1;
}

.custom-modal-footer {
        padding: 1.4rem 1.9rem;
        border-top: 1px solid rgba(247, 168, 108, 0.22);
        background: rgba(255, 255, 255, 0.95);
    display: flex;
    justify-content: flex-end;
        gap: 0.75rem;
}

.file-preview {
    margin-top: 1rem;
    padding: 0.75rem;
        background: rgba(255, 244, 232, 0.45);
        border-radius: var(--radius-sm);
        color: var(--neutral-700);
    }

    .reschedule-calendar {
        border: 1px solid rgba(226, 232, 240, 0.8);
        border-radius: var(--radius-sm);
        padding: 1.2rem;
        background: var(--surface);
    }

    .calendar-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1rem;
    }

    .calendar-nav {
        background: rgba(255, 255, 255, 0.9);
        border: 1px solid rgba(226, 232, 240, 0.8);
        border-radius: 999px;
        width: 38px;
        height: 38px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        color: var(--primary-dark);
    cursor: pointer;
    }

    .calendar-month-year {
        font-weight: 600;
        color: var(--neutral-900);
    }

    .calendar-grid {
        display: grid;
        grid-template-columns: repeat(7, 1fr);
        gap: 2px;
    }

    .calendar-day-header {
        background: rgba(255, 244, 232, 0.6);
        padding: 0.5rem 0.25rem;
        text-align: center;
        font-size: 0.72rem;
        font-weight: 600;
        color: var(--neutral-500);
    }

    .calendar-day {
        padding: 0.55rem 0.25rem;
        text-align: center;
        background: var(--surface);
        border-radius: 8px;
        cursor: pointer;
        font-size: 0.9rem;
    }

    .calendar-day.available {
        background: rgba(187, 247, 208, 0.32);
        color: #166534;
        font-weight: 600;
    }

    .calendar-day.selected {
        background: rgba(125, 211, 252, 0.35);
        border: 1px solid rgba(125, 211, 252, 0.45);
        color: var(--accent-dark);
    }

    .calendar-day.unavailable,
    .calendar-day.other-month,
    .calendar-day.past-date {
        background: rgba(243, 244, 246, 0.8);
        color: var(--neutral-500);
        cursor: not-allowed;
}

.time-slots-container {
        border: 1px solid rgba(226, 232, 240, 0.8);
        border-radius: var(--radius-sm);
        padding: 0.9rem;
        max-height: 220px;
    overflow-y: auto;
        background: rgba(255, 255, 255, 0.9);
}

.time-slot-option {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 0.45rem 0.9rem;
        border-radius: 999px;
        margin: 0.35rem;
        background: rgba(125, 211, 252, 0.18);
        color: var(--accent-dark);
        border: 1px solid rgba(125, 211, 252, 0.32);
    cursor: pointer;
        font-size: 0.85rem;
        font-weight: 600;
}

.time-slot-option.selected {
        border-color: rgba(247, 168, 108, 0.45);
        background: rgba(247, 168, 108, 0.28);
        color: var(--primary-dark);
}

.time-slot-option.disabled {
        background: rgba(243, 244, 246, 0.8);
        color: var(--neutral-500);
        border-color: rgba(229, 231, 235, 0.8);
    cursor: not-allowed;
    }

    @media (max-width: 992px) {
        .content-wrapper {
            padding: 2.4rem 1.2rem 2.8rem;
        }

        .filter-card {
            padding: 1.8rem 1.6rem;
        }

        .search-form {
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
        }

        .data-table {
            min-width: 960px;
        }
    }

    @media (max-width: 768px) {
        html,
        body {
            overflow-x: hidden;
        }

        .content-wrapper {
            padding: 2rem 1rem 2.4rem;
        }

        .upcoming-hero {
            padding: 2.1rem 1.8rem;
        }

        .hero-meta h3 {
            font-size: 1.85rem;
        }

        .search-buttons {
            flex-direction: column;
            align-items: stretch;
        }

        .search-buttons .btn-primary,
        .search-buttons .btn-secondary {
            width: 100%;
            text-align: center;
        }

        .content-section {
            padding: 1.6rem 1.2rem;
        }

        .table-wrapper {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }

        .data-table {
            min-width: 840px;
        }

        .custom-modal-content {
            width: 100%;
        }

        .time-slot-option {
            width: calc(50% - 0.8rem);
    justify-content: center;
        }
    }

    @media (max-width: 540px) {
        html,
        body {
            overflow-x: hidden;
        }

        .content-wrapper {
            padding: 1.8rem 0.9rem 2.2rem;
            width: 362px;
        }

        .upcoming-hero {
            padding: 1.9rem 1.5rem;
        }

        .filter-card {
            padding: 1.6rem 1.4rem;
        }

        .search-form {
            grid-template-columns: 1fr;
        }

        .content-section {
            padding: 1.4rem 1.1rem;
        }

        .table-wrapper {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }

        .data-table {
            min-width: 780px;
        }

        .custom-modal-content {
            margin: 8% auto;
        }

        .time-slot-option {
            width: 100%;
        }
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(-6px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
    }
}
</style>
@endsection

@section('content')
<div class="content-wrapper">
    <section class="upcoming-hero">
        <div class="hero-meta">
            <h3>Upcoming Appointments</h3>
            <p>Stay ahead of your schedule by reviewing pending consultations, joining upcoming sessions, and keeping documents up to date.</p>
            <span class="stats-pill">
                <i class="fas fa-clock"></i>
                {{ $bookings->count() }} {{ Str::plural('upcoming appointment', $bookings->count()) }}
            </span>
        </div>
        <ul class="hero-breadcrumb">
            <li><a href="{{ route('user.dashboard') }}">Home</a></li>
            <li class="active">Upcoming Appointments</li>
        </ul>
    </section>

    <section class="filter-card">
        <header>
            <h4>Filter Upcoming Sessions</h4>
        </header>
        <form action="{{ route('user.upcoming-appointment.index') }}" method="GET" class="search-form">
            <div class="form-group">
                <label for="search_name">Search</label>
                <input type="text" name="search_name" id="search_name" value="{{ request('search_name') }}" placeholder="Search appointment">
            </div>

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
            
            <div class="form-group">
                <label for="plan_type">Plan Type</label>
                <select name="plan_type" id="plan_type" class="form-control">
                    <option value="all">All Plans</option>
                    @foreach($planTypeOptions as $planType)
                        <option value="{{ $planType }}" {{ request('plan_type') == $planType ? 'selected' : '' }}>
                            {{ $formattedPlanTypes[$planType] ?? $planType }}
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
                <a href="{{ route('user.upcoming-appointment.index') }}" class="btn-secondary">Reset</a>
            </div>
        </form>
    </section>

    <section class="content-section">
        <div class="section-header mb-3 d-flex justify-content-between align-items-center">
            <h4>
                Results: {{ $bookings->count() }} {{ Str::plural('appointment', $bookings->count()) }}
                @if(request('service') && request('service') != 'all')
                    for <strong>{{ request('service') }}</strong>
                @endif
                @if(request('plan_type') && request('plan_type') != 'all')
                    with plan <strong>{{ $formattedPlanTypes[request('plan_type')] ?? request('plan_type') }}</strong>
                @endif
                <small class="d-block">Showing all pending and confirmed future appointments</small>
            </h4>   
        </div>

        <div class="table-wrapper">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>S.No</th>
                        <th>Date</th>
                        <th>Month</th>
                        <th>Day</th>
                        <th>Time</th>
                        <th>Professional Name</th>
                        <th>Service Category</th>
                        <th>Sub-Service</th>
                        <th>Plan Type</th>
                        <th>Sessions Taken</th>
                        <th>Sessions Remaining</th>
                        <th>Meet Link</th>
                        <th>Upload document</th>
                        <th>Professional document</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($bookings as $index => $booking)
                        @php
                            $upcomingTimedate = $booking->timedates->first();
                            $isFilteredService = request('service') == $booking->service_name;
                            $isFilteredPlan = request('plan_type') == $booking->plan_type;
                            $planTypeClass = 'plan-type-badge';
                            $planTypeLower = strtolower($booking->plan_type ?? '');
                            
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
                        
                        @if($upcomingTimedate)
                            <tr class="{{ $isFilteredService ? 'service-highlight' : '' }} {{ $isFilteredPlan ? 'plan-highlight' : '' }}">
                                <td>{{ $index + 1 }}</td>
                                <td>
                                    <div>
                                        <p class="mb-0 fw-semibold">{{ \Carbon\Carbon::parse($upcomingTimedate->date)->format('M d, Y') }}</p>
                                        <p class="mb-0 text-muted fs-12">{{ \Carbon\Carbon::parse($upcomingTimedate->date)->format('l') }}</p>
                                    </div>
                                </td>
                                <td>{{ \Carbon\Carbon::parse($upcomingTimedate->date)->format('F') }}</td>
                                <td>{{ \Carbon\Carbon::parse($upcomingTimedate->date)->format('D') }}</td>
                                <td>
                                    <p class="mb-0 fw-semibold">{{ $upcomingTimedate->time_slot }}</p>
                                </td>
                                <td>{{ $booking->professional->name ?? 'Not Assigned' }}</td>
                                <td>
                                    @if($isFilteredService)
                                        <strong>{{ $booking->service_name }}</strong>
                                    @else
                                        {{ $booking->service_name }}
                                    @endif
                                </td>
                                <td>
                                    @if($booking->sub_service_name)
                                        <span class="subservice-pill">{{ $booking->sub_service_name }}</span>
                                    @else
                                        <span class="empty-state">-</span>
                                    @endif
                                </td>
                                <td>
                                    @if($booking->plan_type)
                                        <span class="{{ $planTypeClass }}">{{ $booking->formatted_plan_type }}</span>
                                    @else
                                        <span class="empty-state">No Plan</span>
                                    @endif
                                </td>
                                <td>{{ $booking->sessions_taken ?? 0 }}</td>
                                <td>{{ $booking->sessions_remaining ?? 0 }}</td>
                                <td>
                                    @if($upcomingTimedate->meeting_link)
                                        <a href="{{ $upcomingTimedate->meeting_link }}" target="_blank" class="meet-link-btn">
                                            <i class="fas fa-video"></i> Join
                                        </a>
                                    @else
                                        <span class="empty-state">No link</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="document-actions">
                                        @if($booking->customer_document)
                                            <a href="{{ asset('storage/' . $booking->customer_document) }}" 
                                               class="btn btn-sm btn-info" 
                                               target="_blank" 
                                               title="View Document">
                                                <i class="fas fa-file"></i>
                                            </a>
                                        @endif
                                        <button type="button" 
                                                class="btn btn-sm {{ $booking->customer_document ? 'btn-warning' : 'btn-primary' }} upload-btn" 
                                                data-booking-id="{{ $booking->id }}"
                                                title="{{ $booking->customer_document ? 'Update Document' : 'Upload Document' }}">
                                            <i class="fas {{ $booking->customer_document ? 'fa-edit' : 'fa-upload' }}"></i>
                                        </button>
                                    </div>
                                </td>
                                <td>
                                    @if($booking->professional_documents)
                                        @foreach(explode(',', $booking->professional_documents) as $document)
                                            <a href="{{ asset('storage/' . $document) }}" 
                                               class="btn btn-sm btn-info mb-1" 
                                               target="_blank" 
                                               title="View Professional Document">
                                                <i class="fas fa-file"></i>
                                            </a>
                                        @endforeach
                                    @else
                                        <span class="empty-state">No documents</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="action-buttons">
                                        @php
                                            $rescheduleEnabled = $booking->reschedule_count < $booking->max_reschedules_allowed;
                                            $remainingReschedules = $booking->max_reschedules_allowed - $booking->reschedule_count;
                                        @endphp
                                        @if($rescheduleEnabled)
                                            <button type="button" 
                                                    class="btn btn-sm btn-warning reschedule-btn" 
                                                    data-booking-id="{{ $booking->id }}"
                                                    title="Reschedule Appointment ({{ $remainingReschedules }} remaining)">
                                                <i class="fas fa-calendar-alt"></i>
                                            </button>
                                        @else
                                            <span class="text-muted small" title="Maximum reschedules reached">
                                                <i class="fas fa-ban"></i>
                                            </span>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endif
                    @empty
                        <tr>
                            <td colspan="15" class="text-center">No upcoming appointments found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>
</div>

<!-- Custom Upload Modal -->
<div id="uploadModal" class="custom-modal">
    <div class="custom-modal-content">
        <div class="custom-modal-header">
            <h5 class="custom-modal-title">Upload Document</h5>
            <button type="button" class="custom-modal-close" onclick="closeModal('uploadModal')">&times;</button>
        </div>
        <div class="custom-modal-body">
            <form id="uploadForm" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="booking_id" id="bookingId">
                <div class="mb-3">
                    <label for="document" class="form-label">Select Document</label>
                    <input type="file" class="form-control" id="document" name="document" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png" required>
                    <div class="form-text">Supported formats: PDF, DOC, DOCX, JPG, JPEG, PNG (Max: 2MB)</div>
                </div>
                <div id="filePreview" class="file-preview" style="display: none;">
                    <h6>Selected File:</h6>
                    <p class="mb-0" id="selectedFileName"></p>
                </div>
            </form>
        </div>
        <div class="custom-modal-footer">
            <button type="button" class="btn btn-secondary" onclick="closeModal('uploadModal')">Cancel</button>
            <button type="button" class="btn btn-primary" id="uploadBtn">Upload</button>
        </div>
    </div>
</div>

<!-- Custom Reschedule Modal -->
<div id="rescheduleModal" class="custom-modal">
    <div class="custom-modal-content" style="max-width: 600px;">
        <div class="custom-modal-header">
            <h5 class="custom-modal-title">Reschedule Appointment</h5>
            <button type="button" class="custom-modal-close" onclick="closeModal('rescheduleModal')">&times;</button>
        </div>
        <div class="custom-modal-body">
            <form id="rescheduleForm">
                @csrf
                <input type="hidden" name="booking_id" id="rescheduleBookingId">
                
                <div class="mb-3">
                    <label class="form-label">Current Appointment</label>
                    <div class="alert alert-info">
                        <div id="currentAppointmentInfo"></div>
                    </div>
                </div>
                
                <div class="mb-3">
                    <label for="rescheduleCalendar" class="form-label">Select New Date</label>
                    <div id="rescheduleCalendar" class="reschedule-calendar"></div>
                    <input type="hidden" id="selectedDate" name="new_date" required>
                    <div class="form-text">
                        <span class="text-success">● Available dates</span> | 
                        <span class="text-muted">● Unavailable dates</span>
                    </div>
                </div>
                
                <div class="mb-3">
                    <label class="form-label">Available Time Slots</label>
                    <div id="rescheduleTimeSlots" class="time-slots-container">
                        <div class="text-muted text-center p-3">Please select a date first</div>
                    </div>
                </div>
                
                <div class="mb-3">
                    <label for="rescheduleReason" class="form-label">Reason for Reschedule <span class="text-danger">*</span></label>
                    <textarea class="form-control" id="rescheduleReason" name="reschedule_reason" rows="3" required placeholder="Please provide a reason for rescheduling..."></textarea>
                </div>
                
                <div id="rescheduleInfo" class="alert alert-warning small" style="display: none;">
                    <i class="fas fa-info-circle"></i> <span id="rescheduleInfoText"></span>
                </div>
            </form>
        </div>
        <div class="custom-modal-footer">
            <button type="button" class="btn btn-secondary" onclick="closeModal('rescheduleModal')">Cancel</button>
            <button type="button" class="btn btn-warning" id="rescheduleBtn" disabled>
                <i class="fas fa-calendar-alt"></i> Reschedule Appointment
            </button>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const uploadForm = document.getElementById('uploadForm');
    const uploadBtn = document.getElementById('uploadBtn');
    const fileInput = document.getElementById('document');
    const filePreview = document.getElementById('filePreview');
    const selectedFileName = document.getElementById('selectedFileName');
    const modal = document.getElementById('uploadModal');

    // Modal functions
    window.openModal = function(modalId) {
        const modal = document.getElementById(modalId);
        modal.style.display = 'block';
        setTimeout(() => {
            modal.classList.add('show');
        }, 10);
        document.body.style.overflow = 'hidden';
    };

    window.closeModal = function(modalId) {
        const modal = document.getElementById(modalId);
        modal.classList.remove('show');
        setTimeout(() => {
            modal.style.display = 'none';
        }, 300);
        document.body.style.overflow = '';
    };

    // Close modal when clicking outside for all modals
    document.querySelectorAll('.custom-modal').forEach(modal => {
        modal.addEventListener('click', function(event) {
            if (event.target === modal) {
                closeModal(modal.id);
            }
        });
    });

    // Prevent modal from closing when clicking inside the modal content for all modals
    document.querySelectorAll('.custom-modal-content').forEach(content => {
        content.addEventListener('click', function(event) {
            event.stopPropagation();
        });
    });

    // Handle ESC key to close modals
    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') {
            document.querySelectorAll('.custom-modal.show').forEach(modal => {
                closeModal(modal.id);
            });
        }
    });

    // Handle file input change
    fileInput.addEventListener('change', function() {
        if (this.files && this.files[0]) {
            const file = this.files[0];
            const allowedTypes = [
                'application/pdf',
                'application/msword',
                'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                'image/jpeg',
                'image/png',
                'image/jpg'
            ];
            if (!allowedTypes.includes(file.type)) {
                toastr.error('Invalid file type. Allowed: PDF, DOC, DOCX, JPG, JPEG, PNG.');
                this.value = '';
                filePreview.style.display = 'none';
                return;
            }
            if (file.size > 2 * 1024 * 1024) {
                toastr.error('File size exceeds 2MB.');
                this.value = '';
                filePreview.style.display = 'none';
                return;
            }
            selectedFileName.textContent = file.name;
            filePreview.style.display = 'block';
        } else {
            filePreview.style.display = 'none';
        }
    });

    // Handle upload button click
    document.querySelectorAll('.upload-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            document.getElementById('bookingId').value = this.dataset.bookingId;
            filePreview.style.display = 'none';
            uploadForm.reset();
            openModal('uploadModal');
        });
    });

    // Handle file upload
    uploadBtn.addEventListener('click', function() {
        const formData = new FormData(uploadForm);

        // Disable the upload button and show loading state
        uploadBtn.disabled = true;
        uploadBtn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Uploading...';

        fetch('{{ route("user.upload.document") }}', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                toastr.success(data.message);
                setTimeout(() => {
                    window.location.reload();
                }, 1500);
            } else {
                if (data.errors) {
                    // Show all validation errors
                    Object.values(data.errors).forEach(msgArr => {
                        if (Array.isArray(msgArr)) {
                            msgArr.forEach(msg => toastr.error(msg));
                        } else {
                            toastr.error(msgArr);
                        }
                    });
                } else {
                    toastr.error(data.message);
                }
            }
        })
        .catch(error => {
            console.error('Error:', error);
            toastr.error('Error uploading document');
        })
        .finally(() => {
            // Re-enable the upload button and restore original text
            uploadBtn.disabled = false;
            uploadBtn.innerHTML = 'Upload';
        });
    });

    // Reschedule functionality
    let selectedTimeSlot = null;
    let currentBookingData = null;
    let availableDates = [];
    let currentCalendarDate = new Date();
    let professionalAvailabilityData = [];
    let existingBookings = {};

    // Handle reschedule button click
    document.querySelectorAll('.reschedule-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const bookingId = this.dataset.bookingId;
            openRescheduleModal(bookingId);
        });
    });

    // Open reschedule modal
    function openRescheduleModal(bookingId) {
        // Find booking data from the current page
        const row = document.querySelector(`[data-booking-id="${bookingId}"]`).closest('tr');
        const cells = row.querySelectorAll('td');
        
        // Extract current appointment info
        const currentDate = cells[1].textContent.trim();
        const currentTime = cells[4].textContent.trim();
        const professionalName = cells[5].textContent.trim();
        const serviceName = cells[6].textContent.trim();
        
        currentBookingData = {
            id: bookingId,
            currentDate: currentDate,
            currentTime: currentTime,
            professionalName: professionalName,
            serviceName: serviceName
        };

        // Set booking ID in form
        document.getElementById('rescheduleBookingId').value = bookingId;

        // Set current appointment info
        document.getElementById('currentAppointmentInfo').innerHTML = `
            <strong>Service:</strong> ${serviceName}<br>
            <strong>Professional:</strong> ${professionalName}<br>
            <strong>Current Date:</strong> ${currentDate}<br>
            <strong>Current Time:</strong> ${currentTime}
        `;

        // Reset form
        document.getElementById('rescheduleForm').reset();
        document.getElementById('rescheduleBookingId').value = bookingId; // Set again after reset
        document.getElementById('rescheduleTimeSlots').innerHTML = '<div class="text-muted text-center p-3">Please select a date first</div>';
        document.getElementById('rescheduleBtn').disabled = true;
        selectedTimeSlot = null;
        currentCalendarDate = new Date();

        // Load professional availability and render calendar
        loadProfessionalAvailability(bookingId);

        openModal('rescheduleModal');
    }

    // Load professional availability data
    function loadProfessionalAvailability(bookingId) {
        const calendarContainer = document.getElementById('rescheduleCalendar');
        calendarContainer.innerHTML = '<div class="calendar-loading"><i class="fas fa-spinner fa-spin"></i> Loading calendar...</div>';

        console.log('Loading availability for booking ID:', bookingId);

        fetch(`{{ url('/user/upcoming-appointment') }}/${bookingId}/professional-availability`)
            .then(response => {
                console.log('Response status:', response.status);
                return response.json();
            })
            .then(data => {
                console.log('Received availability data:', data);
                if (data.success) {
                    professionalAvailabilityData = data.data;
                    existingBookings = data.existing_bookings || {};
                    console.log('Professional availability data:', professionalAvailabilityData);
                    console.log('Existing bookings:', existingBookings);
                    generateAvailableDates();
                    renderCalendar();
                } else {
                    console.error('API returned error:', data.message);
                    calendarContainer.innerHTML = `<div class="text-danger text-center p-3">${data.message}</div>`;
                }
            })
            .catch(error => {
                console.error('Error loading professional availability:', error);
                calendarContainer.innerHTML = '<div class="text-danger text-center p-3">Error loading calendar. Please try again.</div>';
            });
    }

    // Generate available dates from professional availability
    function generateAvailableDates() {
        availableDates = [];
        const today = new Date();
        today.setHours(0, 0, 0, 0);

        professionalAvailabilityData.forEach(availability => {
            const monthYear = availability.month; // Format: "2025-11"
            const [year, month] = monthYear.split('-').map(Number);
            const weeklySlots = availability.weekly_slots;

            // Generate dates for the entire month
            const daysInMonth = new Date(year, month, 0).getDate();
            
            for (let day = 1; day <= daysInMonth; day++) {
                const date = new Date(year, month - 1, day);
                
                // Skip past dates (only allow future dates)
                if (date < today) continue;

                // Get weekday name
                const weekdayMap = ['sun', 'mon', 'tue', 'wed', 'thu', 'fri', 'sat'];
                const weekday = weekdayMap[date.getDay()];

                // Check if professional has slots for this weekday
                if (weeklySlots && weeklySlots[weekday] && weeklySlots[weekday].length > 0) {
                    availableDates.push(date.toISOString().split('T')[0]);
                }
            }
        });
        
        console.log('Generated available dates:', availableDates);
    }

    // Render calendar
    function renderCalendar() {
        const calendarContainer = document.getElementById('rescheduleCalendar');
        const year = currentCalendarDate.getFullYear();
        const month = currentCalendarDate.getMonth();

        const monthNames = [
            'January', 'February', 'March', 'April', 'May', 'June',
            'July', 'August', 'September', 'October', 'November', 'December'
        ];

        const dayNames = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];

        // Calculate first day of month and number of days
        const firstDay = new Date(year, month, 1).getDay();
        const daysInMonth = new Date(year, month + 1, 0).getDate();
        const daysInPrevMonth = new Date(year, month, 0).getDate();

        let calendarHtml = `
            <div class="calendar-header">
                <button type="button" class="calendar-nav" onclick="navigateMonth(-1)">
                    <i class="fas fa-chevron-left"></i>
                </button>
                <div class="calendar-month-year">
                    ${monthNames[month]} ${year}
                </div>
                <button type="button" class="calendar-nav" onclick="navigateMonth(1)">
                    <i class="fas fa-chevron-right"></i>
                </button>
            </div>
            <div class="calendar-grid">
        `;

        // Add day headers
        dayNames.forEach(day => {
            calendarHtml += `<div class="calendar-day-header">${day}</div>`;
        });

        // Add empty cells for days before month starts
        for (let i = firstDay - 1; i >= 0; i--) {
            const day = daysInPrevMonth - i;
            calendarHtml += `<div class="calendar-day other-month">${day}</div>`;
        }

        // Add days of current month
        const today = new Date();
        today.setHours(0, 0, 0, 0);

        for (let day = 1; day <= daysInMonth; day++) {
            const date = new Date(year, month, day);
            const dateString = date.toISOString().split('T')[0];
            
            let dayClass = 'calendar-day';
            let clickHandler = '';

            if (date < today) {
                dayClass += ' past-date';
            } else if (availableDates.includes(dateString)) {
                dayClass += ' available';
                clickHandler = `onclick="selectCalendarDate('${dateString}')"`;
            } else {
                dayClass += ' unavailable';
            }

            calendarHtml += `<div class="${dayClass}" ${clickHandler}>${day}</div>`;
        }

        // Add empty cells for days after month ends
        const totalCells = Math.ceil((firstDay + daysInMonth) / 7) * 7;
        const remainingCells = totalCells - (firstDay + daysInMonth);
        for (let day = 1; day <= remainingCells; day++) {
            calendarHtml += `<div class="calendar-day other-month">${day}</div>`;
        }

        calendarHtml += '</div>';
        calendarContainer.innerHTML = calendarHtml;
    }

    // Navigate calendar months
    window.navigateMonth = function(direction) {
        const today = new Date();
        const newDate = new Date(currentCalendarDate);
        newDate.setMonth(newDate.getMonth() + direction);
        
        // Allow navigation from current month to 6 months ahead
        const maxDate = new Date(today);
        maxDate.setMonth(maxDate.getMonth() + 6);
        
        // Don't allow navigation to past months or more than 6 months ahead
        if (newDate < new Date(today.getFullYear(), today.getMonth(), 1) || newDate > maxDate) {
            return;
        }
        
        currentCalendarDate = newDate;
        renderCalendar();
    };

    // Select calendar date
    window.selectCalendarDate = function(dateString) {
        // Remove previous selection
        document.querySelectorAll('.calendar-day').forEach(day => {
            day.classList.remove('selected');
        });

        // Select current date
        event.target.classList.add('selected');
        document.getElementById('selectedDate').value = dateString;

        // Load time slots for selected date
        loadAvailableTimeSlots(currentBookingData.id, dateString);
    };

    // Load available time slots for selected date
    function loadAvailableTimeSlots(bookingId, date) {
        const slotsContainer = document.getElementById('rescheduleTimeSlots');
        slotsContainer.innerHTML = '<div class="loading-slots"><i class="fas fa-spinner fa-spin"></i> Loading available time slots...</div>';

        displayTimeSlots(professionalAvailabilityData, date);
    }

    // Display time slots
    function displayTimeSlots(availabilityData, selectedDate) {
        const slotsContainer = document.getElementById('rescheduleTimeSlots');
        const dateObj = new Date(selectedDate);
        
        // Get day name (convert to lowercase 3-letter format expected by backend)
        const dayNames = ['sun', 'mon', 'tue', 'wed', 'thu', 'fri', 'sat'];
        const dayName = dayNames[dateObj.getDay()];
        
        let availableSlots = [];
        let bookedSlots = existingBookings[selectedDate] || [];
        
        console.log('=== TIME SLOT GENERATION DEBUG ===');
        console.log('Selected date:', selectedDate);
        console.log('Date object:', dateObj);
        console.log('Day name:', dayName);
        console.log('Availability data:', availabilityData);
        console.log('Booked slots for this date:', bookedSlots);
        
        // Find slots for the selected day
        availabilityData.forEach((availability, index) => {
            console.log(`Processing availability ${index}:`, availability);
            
            if (availability.weekly_slots && availability.weekly_slots[dayName]) {
                console.log(`Found slots for ${dayName}:`, availability.weekly_slots[dayName]);
                
                availability.weekly_slots[dayName].forEach((slot, slotIndex) => {
                    console.log(`Processing slot ${slotIndex}:`, slot);
                    
                    // Generate time slots based on session duration
                    const sessionDuration = availability.session_duration || 60;
                    const startTime = slot.start_time;
                    const endTime = slot.end_time;
                    
                    console.log(`Slot details - Start: ${startTime}, End: ${endTime}, Duration: ${sessionDuration} mins`);
                    
                    const start = new Date(`2023-01-01 ${startTime}`);
                    const end = new Date(`2023-01-01 ${endTime}`);
                    
                    console.log('Start date object:', start);
                    console.log('End date object:', end);
                    
                    let slotCounter = 0;
                    while (start < end && slotCounter < 20) { // Safety limit
                        const slotStart = start.toTimeString().substr(0, 5);
                        const slotEnd = new Date(start.getTime() + sessionDuration * 60000).toTimeString().substr(0, 5);
                        
                        console.log(`Generated slot ${slotCounter}: ${slotStart} - ${slotEnd}`);
                        
                        // Skip if end time exceeds availability end time
                        if (new Date(`2023-01-01 ${slotEnd}`) > end) {
                            console.log('Slot end time exceeds availability, breaking');
                            break;
                        }
                        
                        // Convert to 12-hour format
                        const slotStart12 = formatTo12Hour(slotStart);
                        const slotEnd12 = formatTo12Hour(slotEnd);
                        const timeSlot = `${slotStart12} - ${slotEnd12}`;
                        
                        console.log(`Formatted slot: ${timeSlot}`);
                        
                        availableSlots.push(timeSlot);
                        start.setMinutes(start.getMinutes() + sessionDuration);
                        slotCounter++;
                    }
                });
            } else {
                console.log(`No slots found for ${dayName} in availability:`, availability.weekly_slots);
            }
        });

        console.log('Final generated available slots:', availableSlots);

        if (availableSlots.length === 0) {
            console.log('No available slots found, showing message');
            slotsContainer.innerHTML = '<div class="no-slots-available">No available time slots for this date</div>';
            return;
        }

        // Remove duplicates and sort
        availableSlots = [...new Set(availableSlots)];
        console.log('After removing duplicates:', availableSlots);
        
        availableSlots.sort((a, b) => {
            const timeA = a.split(' - ')[0];
            const timeB = b.split(' - ')[0];
            return convertTo24Hour(timeA).localeCompare(convertTo24Hour(timeB));
        });

        console.log('After sorting:', availableSlots);

        // Display slots
        let slotsHtml = '';
        availableSlots.forEach(slot => {
            const isBooked = bookedSlots.includes(slot);
            const slotClass = isBooked ? 'time-slot-option disabled' : 'time-slot-option';
            const clickHandler = isBooked ? '' : `onclick="selectTimeSlot('${slot}')"`;
            const statusText = isBooked ? '<small class="d-block text-danger">Booked</small>' : '';
            
            slotsHtml += `
                <div class="${slotClass}" ${clickHandler}>
                    ${slot}
                    ${statusText}
                </div>
            `;
        });

        console.log('Generated HTML:', slotsHtml);
        slotsContainer.innerHTML = slotsHtml;
        console.log('=== END TIME SLOT DEBUG ===');
    }
                </div>
            `;
        });

        slotsContainer.innerHTML = slotsHtml;
    }

    // Convert 12-hour to 24-hour format for sorting
    function convertTo24Hour(time12) {
        const [time, modifier] = time12.split(' ');
        let [hours, minutes] = time.split(':');
        if (hours === '12') {
            hours = '00';
        }
        if (modifier === 'PM') {
            hours = parseInt(hours, 10) + 12;
        }
        return `${hours}:${minutes}`;
    }

    // Convert 24-hour to 12-hour format
    function formatTo12Hour(time24) {
        const [hours, minutes] = time24.split(':');
        const hour12 = hours % 12 || 12;
        const ampm = hours >= 12 ? 'PM' : 'AM';
        return `${hour12}:${minutes} ${ampm}`;
    }

    // Select time slot
    window.selectTimeSlot = function(timeSlot) {
        // Don't select if slot is disabled
        if (event.target.classList.contains('disabled')) {
            return;
        }

        // Remove previous selection
        document.querySelectorAll('.time-slot-option').forEach(option => {
            option.classList.remove('selected');
        });

        // Select current option
        event.target.classList.add('selected');
        selectedTimeSlot = timeSlot;

        // Enable reschedule button if all required fields are filled
        checkRescheduleFormValidity();
    };

    // Check if reschedule form is valid
    function checkRescheduleFormValidity() {
        const date = document.getElementById('selectedDate').value;
        const reason = document.getElementById('rescheduleReason').value.trim();
        const rescheduleBtn = document.getElementById('rescheduleBtn');

        rescheduleBtn.disabled = !(date && selectedTimeSlot && reason);
    }

    // Handle reason textarea change
    document.getElementById('rescheduleReason').addEventListener('input', checkRescheduleFormValidity);

    // Handle reschedule submission
    document.getElementById('rescheduleBtn').addEventListener('click', function() {
        if (!selectedTimeSlot || !currentBookingData) {
            toastr.error('Please select a time slot');
            return;
        }

        const formData = new FormData();
        formData.append('_token', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
        formData.append('new_date', document.getElementById('selectedDate').value);
        formData.append('new_time_slot', selectedTimeSlot);
        formData.append('reschedule_reason', document.getElementById('rescheduleReason').value);

        // Disable button and show loading
        this.disabled = true;
        this.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Rescheduling...';

        fetch(`{{ url('/user/upcoming-appointment') }}/${currentBookingData.id}/reschedule`, {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                toastr.success(data.message);
                closeModal('rescheduleModal');
                // Reload page after short delay
                setTimeout(() => {
                    window.location.reload();
                }, 2000);
            } else {
                if (data.errors) {
                    Object.values(data.errors).forEach(msgArr => {
                        if (Array.isArray(msgArr)) {
                            msgArr.forEach(msg => toastr.error(msg));
                        } else {
                            toastr.error(msgArr);
                        }
                    });
                } else {
                    toastr.error(data.message);
                }
            }
        })
        .catch(error => {
            console.error('Error:', error);
            toastr.error('Error rescheduling appointment');
        })
        .finally(() => {
            // Re-enable button
            this.disabled = false;
            this.innerHTML = '<i class="fas fa-calendar-alt"></i> Reschedule Appointment';
        });
    });
});
</script>
@endsection