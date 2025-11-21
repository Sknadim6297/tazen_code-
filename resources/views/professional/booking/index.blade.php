@extends('professional.layout.layout')

@section('styles')
<style>
    :root {
        --primary: #4f46e5;
        --primary-dark: #4338ca;
        --secondary: #0ea5e9;
        --accent: #22c55e;
        --page-bg: #f4f6fb;
        --card-bg: #ffffff;
        --border: rgba(148, 163, 184, 0.22);
        --text-dark: #0f172a;
        --text-muted: #64748b;
    }

    body,
    .app-content {
        background: var(--page-bg);
    }

    .content-wrapper.bookings-page {
        background: transparent;
        padding: 0;
    }

    .bookings-page {
        width: 100%;
        padding: 2.6rem 1.35rem 3.5rem;
    }

    .bookings-shell {
        max-width: 1200px;
        margin: 0 auto;
        display: flex;
        flex-direction: column;
        gap: 2rem;
    }

    .bookings-header {
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

    .bookings-header::before,
    .bookings-header::after {
        content: "";
        position: absolute;
        border-radius: 50%;
        pointer-events: none;
    }

    .bookings-header::before {
        width: 320px;
        height: 320px;
        top: -45%;
        right: -12%;
        background: rgba(79, 70, 229, 0.2);
    }

    .bookings-header::after {
        width: 220px;
        height: 220px;
        bottom: -40%;
        left: -10%;
        background: rgba(59, 130, 246, 0.18);
    }

    .bookings-header > * {
        position: relative;
        z-index: 1;
    }

    .hero-meta {
        display: flex;
        flex-direction: column;
        gap: 0.75rem;
        color: var(--text-muted);
    }

    .hero-eyebrow {
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        padding: 0.35rem 1rem;
        border-radius: 999px;
        font-size: 0.72rem;
        font-weight: 600;
        letter-spacing: 0.12em;
        text-transform: uppercase;
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

    .hero-breadcrumb {
        margin: 0;
        padding: 0;
        list-style: none;
        display: flex;
        flex-wrap: wrap;
        gap: 0.6rem;
        font-size: 0.86rem;
        color: var(--text-muted);
    }

    .hero-breadcrumb li a {
        color: var(--primary);
        text-decoration: none;
    }

    .header-actions {
        display: flex;
        align-items: center;
        gap: 0.85rem;
        flex-wrap: wrap;
    }

    .bookings-header .btn {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        border-radius: 999px;
        padding: 0.75rem 1.6rem;
        font-weight: 600;
        font-size: 0.9rem;
        text-decoration: none;
        cursor: pointer;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
        border: none;
        background: linear-gradient(135deg, var(--primary), var(--primary-dark));
        color: #ffffff;
        box-shadow: 0 18px 38px rgba(79, 70, 229, 0.22);
    }

    .bookings-header .btn:hover {
        transform: translateY(-1px);
    }

    .filter-card {
        background: var(--card-bg);
        border-radius: 20px;
        border: 1px solid var(--border);
        box-shadow: 0 16px 40px rgba(15, 23, 42, 0.08);
        padding: 1.85rem;
        display: flex;
        flex-direction: column;
        gap: 1.35rem;
    }

    .filter-card h3 {
        margin: 0;
        font-size: 1.05rem;
        font-weight: 700;
        color: var(--text-dark);
    }

    .search-form {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 1.1rem;
    }

    .search-form .form-group {
        display: flex;
        flex-direction: column;
        gap: 0.45rem;
    }

    .search-form label {
        font-size: 0.85rem;
        font-weight: 600;
        color: var(--text-muted);
    }

    .search-form select,
    .search-form input {
        width: 100%;
        border-radius: 12px;
        border: 1px solid rgba(148, 163, 184, 0.35);
        padding: 0.72rem 0.85rem;
        font-size: 0.95rem;
        transition: border-color 0.2s ease, box-shadow 0.2s ease;
        background: #ffffff;
        color: var(--text-dark);
    }

    .search-form select:focus,
    .search-form input:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.15);
        outline: none;
    }

    .search-buttons {
        display: flex;
        gap: 0.85rem;
        align-items: center;
        flex-wrap: wrap;
        margin-top: 0.2rem;
    }

    .search-buttons .btn,
    .btn {
        border-radius: 12px;
        padding: 0.75rem 1.45rem;
        font-weight: 600;
        border: none;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 0.45rem;
        transition: transform 0.15s ease, box-shadow 0.15s ease;
    }

    .search-buttons .btn-primary,
    .btn-primary {
        background: linear-gradient(135deg, var(--primary), var(--primary-dark));
        color: #ffffff;
        box-shadow: 0 12px 28px rgba(79, 70, 229, 0.2);
    }

    .search-buttons .btn-secondary,
    .btn-secondary {
        background: rgba(79, 70, 229, 0.08);
        color: var(--primary-dark);
        border: 1px solid rgba(79, 70, 229, 0.18);
    }

    .search-buttons .btn:hover,
    .btn:hover {
        transform: translateY(-1px);
    }

    .btn-sm {
        padding: 0.45rem 0.9rem;
        font-size: 0.8rem;
        border-radius: 10px;
    }

    .btn-info {
        background: rgba(14, 165, 233, 0.18);
        color: #0369a1;
        border: 1px solid rgba(14, 165, 233, 0.35);
    }

    .btn-info:hover {
        background: rgba(14, 165, 233, 0.26);
    }

    .btn-link {
        background: rgba(79, 70, 229, 0.12);
        color: var(--primary-dark);
        border-radius: 10px;
        padding: 0.45rem 0.9rem;
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
        text-decoration: none;
    }

    .btn-link:hover {
        background: rgba(79, 70, 229, 0.18);
        text-decoration: none;
    }

    .bookings-card {
        background: var(--card-bg);
        border-radius: 22px;
        border: 1px solid var(--border);
        box-shadow: 0 18px 40px rgba(15, 23, 42, 0.1);
        overflow: hidden;
    }

    .bookings-card__head {
        padding: 1.6rem 2.2rem 1.2rem;
        border-bottom: 1px solid rgba(148, 163, 184, 0.2);
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 1rem;
    }

    .bookings-card__head h3 {
        margin: 0;
        font-size: 1.15rem;
        font-weight: 700;
        color: var(--text-dark);
    }

    .bookings-card__body {
        padding: 1.9rem 2.2rem;
    }

    .text-muted {
        color: var(--text-muted);
    }

    .empty-state {
        padding: 2.4rem 1.6rem;
        text-align: center;
        color: var(--text-muted);
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 0.75rem;
        font-size: 0.95rem;
    }

    .empty-state i {
        font-size: 2rem;
        color: var(--primary);
    }

    .table-wrapper {
        border-radius: 18px;
        border: 1px solid rgba(226, 232, 240, 0.85);
        overflow-x: auto;
        overflow-y: hidden;
        position: relative;
        -webkit-overflow-scrolling: touch;
    }

    .data-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
    }

    .data-table thead {
        background: rgba(79, 70, 229, 0.08);
    }

    .data-table th {
        padding: 0.95rem 1rem;
        font-size: 0.86rem;
        font-weight: 700;
        color: var(--text-dark);
        text-transform: uppercase;
        letter-spacing: 0.05em;
        border-bottom: 1px solid rgba(148, 163, 184, 0.2);
        white-space: nowrap;
    }

    .data-table td {
        padding: 0.85rem 1rem;
        border-bottom: 1px solid rgba(226, 232, 240, 0.8);
        font-size: 0.9rem;
        color: var(--text-dark);
    }

    .data-table tr:last-child td {
        border-bottom: none;
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

    .data-table {
        min-width: 1100px;
    }

    .badge {
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
        padding: 0.3rem 0.7rem;
        border-radius: 999px;
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }

    .badge.bg-success {
        background: rgba(34, 197, 94, 0.15) !important;
        color: #16a34a !important;
    }

    .badge.bg-warning {
        background: rgba(250, 204, 21, 0.2) !important;
        color: #b45309 !important;
    }

    .badge.bg-info {
        background: rgba(14, 165, 233, 0.18) !important;
        color: #0c4a6e !important;
    }

    .questionnaire-info {
        margin-left: 0.35rem;
        padding: 0.4rem 0.55rem;
        font-size: 0.74rem;
        border-radius: 999px;
        border: none;
        background: rgba(79, 70, 229, 0.1);
        color: var(--primary-dark);
        transition: all 0.2s ease;
    }

    .questionnaire-info:hover {
        background: rgba(79, 70, 229, 0.2);
    }

    /* Enhanced Questionnaire Styles */
    .questionnaire-details {
        max-height: 70vh;
        overflow-y: auto;
    }

    .questionnaire-header {
        background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
        border: 1px solid #e2e8f0;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
    }

    .answer-card {
        transition: all 0.3s ease;
        background: #ffffff;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
    }

    .answer-card:hover {
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        transform: translateY(-1px);
    }

    .question-number .badge {
        width: 32px;
        height: 32px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.9rem;
        font-weight: 600;
    }

    .bg-gradient-primary {
        background: linear-gradient(135deg, #4f46e5, #3b82f6);
    }

    .question-content {
        font-size: 1rem;
        line-height: 1.5;
        color: #475569;
    }

    .answer-content {
        font-size: 1.05rem;
        line-height: 1.4;
        color: #059669;
    }

    .metadata .badge {
        font-size: 0.75rem;
    }

    .border-success {
        border-color: #10b981 !important;
    }

    .custom-modal .modal-content {
        max-width: 900px;
        margin: 2rem auto;
    }

    .chat-button {
        position: relative;
        display: inline-flex;
        align-items: center;
        gap: 0.45rem;
        padding: 0.55rem 1.05rem;
        border-radius: 999px;
        background: linear-gradient(135deg, #2563eb, #1d4ed8);
        color: #ffffff !important;
        font-size: 0.82rem;
        font-weight: 600;
        border: none;
        box-shadow: 0 14px 26px rgba(37, 99, 235, 0.2);
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .chat-button:hover {
        transform: translateY(-2px);
        box-shadow: 0 18px 32px rgba(37, 99, 235, 0.24);
    }

    .chat-badge {
        position: absolute;
        top: -6px;
        right: -6px;
        font-size: 0.62rem;
        min-width: 18px;
        height: 18px;
        border-radius: 999px;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 0 5px;
        background: #ef4444;
        color: #ffffff;
        box-shadow: 0 0 0 2px #ffffff;
        animation: pulse 2s infinite;
    }

    .document-preview {
        display: inline-flex;
        align-items: center;
        gap: 0.55rem;
        padding: 0.5rem 0.75rem;
        border-radius: 12px;
        border: 1px solid rgba(226, 232, 240, 0.85);
        background: rgba(248, 250, 252, 0.9);
        text-decoration: none;
        transition: border-color 0.2s ease, box-shadow 0.2s ease;
    }

    .document-preview:hover {
        border-color: var(--primary);
        box-shadow: 0 10px 18px rgba(79, 70, 229, 0.12);
    }

    .document-preview img {
        width: 22px;
        height: 22px;
    }

    .document-preview .doc-name {
        font-size: 0.78rem;
        color: var(--text-dark);
        max-width: 160px;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .no-doc-message {
        background: rgba(226, 232, 240, 0.35);
        border: 1px dashed rgba(148, 163, 184, 0.65);
        padding: 0.65rem;
        border-radius: 12px;
        font-size: 0.82rem;
        color: var(--text-muted);
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
    }

    .status-slider {
        position: relative;
        display: inline-block;
        width: 58px;
        height: 30px;
    }

    .status-slider input {
        opacity: 0;
        width: 0;
        height: 0;
    }

    .status-slider .slider {
        position: absolute;
        inset: 0;
        background: rgba(148, 163, 184, 0.55);
        border-radius: 30px;
        transition: 0.3s ease;
    }

    .status-slider .slider::before {
        content: "";
        position: absolute;
        height: 22px;
        width: 22px;
        left: 4px;
        bottom: 4px;
        border-radius: 50%;
        background: #ffffff;
        box-shadow: 0 6px 16px rgba(15, 23, 42, 0.12);
        transition: 0.3s ease;
    }

    .status-slider input:checked + .slider {
        background: linear-gradient(135deg, var(--primary), var(--primary-dark));
    }

    .status-slider input:checked + .slider::before {
        transform: translateX(28px);
    }

    .status-text {
        display: inline-block;
        margin-left: 0.55rem;
        font-size: 0.82rem;
        color: var(--text-muted);
    }

    .custom-modal,
    .upload-modal {
        display: none;
        position: fixed;
        inset: 0;
        background: rgba(15, 23, 42, 0.45);
        z-index: 9999;
        padding: 2rem 1rem;
        overflow-y: auto;
    }

    .custom-modal-content,
    .upload-modal-content {
        background: #ffffff;
        margin: 0 auto;
        border-radius: 20px;
        max-width: 720px;
        width: 100%;
        padding: 1.8rem;
        box-shadow: 0 24px 50px rgba(15, 23, 42, 0.25);
        position: relative;
    }

    .close-modal,
    .close-upload-modal {
        position: absolute;
        top: 18px;
        right: 20px;
        font-size: 1.4rem;
        color: var(--text-muted);
        cursor: pointer;
        transition: color 0.2s ease;
    }

    .close-modal:hover,
    .close-upload-modal:hover {
        color: var(--primary);
    }

    .modal-header {
        border-radius: 16px;
        padding: 1rem 1.4rem;
        margin: -1.8rem -1.8rem 1.4rem;
        background: linear-gradient(135deg, var(--primary), var(--primary-dark));
        color: #ffffff;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .modal-header h3 {
        margin: 0;
        font-size: 1.2rem;
        font-weight: 700;
    }

    .modal-body {
        padding: 0 0.3rem;
    }

    .answers-list {
        margin-top: 1.1rem;
        display: grid;
        gap: 1rem;
    }

    .answer-item {
        border-radius: 14px;
        border: 1px solid rgba(226, 232, 240, 0.9);
        background: rgba(248, 250, 252, 0.82);
        padding: 1.1rem;
    }

    .answer-item .question {
        font-weight: 600;
        color: var(--text-dark);
        margin-bottom: 0.4rem;
    }

    .answer-item .answer {
        color: var(--text-muted);
        margin: 0;
    }

    .upload-form .form-group {
        display: flex;
        flex-direction: column;
        gap: 0.55rem;
        margin-bottom: 1.3rem;
    }

    .upload-form input[type="file"] {
        border-radius: 12px;
        border: 1px solid rgba(148, 163, 184, 0.35);
        padding: 0.7rem;
        background: rgba(248, 250, 252, 0.95);
    }

    .upload-form .btn-upload {
        align-self: flex-start;
        padding: 0.75rem 1.45rem;
        border-radius: 12px;
        border: none;
        background: linear-gradient(135deg, #3b82f6, #2563eb);
        color: #ffffff;
        font-weight: 600;
        cursor: pointer;
        box-shadow: 0 14px 30px rgba(37, 99, 235, 0.22);
        transition: transform 0.2s ease;
    }

    .upload-form .btn-upload:hover {
        transform: translateY(-1px);
    }

    @keyframes pulse {
        0%, 100% {
            transform: scale(1);
        }
        50% {
            transform: scale(1.12);
        }
    }

    @media (max-width: 1024px) {
        .bookings-page {
            padding: 2.1rem 1.1rem 3rem;
        }

        .bookings-header {
            padding: 1.8rem 1.9rem;
        }

        .bookings-card__body {
            padding: 1.6rem 1.8rem;
        }
    }

    @media (max-width: 768px) {
        .bookings-header {
            padding: 1.75rem 1.6rem;
        }

        .bookings-header h1 {
            font-size: 1.75rem;
        }

        .header-actions {
            width: 100%;
        }

        .header-actions .btn {
            width: 100%;
            justify-content: center;
        }

        .search-form {
            grid-template-columns: repeat(auto-fit, minmax(100%, 1fr));
        }

        .search-buttons {
            flex-direction: column;
            align-items: stretch;
        }

        .search-buttons .btn {
            width: 100%;
            justify-content: center;
        }

        .table-wrapper {
            overflow-x: auto;
        }

        .data-table {
            min-width: 900px;
        }

        .custom-modal-content,
        .upload-modal-content {
            padding: 1.4rem;
        }
    }
</style>
@endsection


@section('content')
<div class="content-wrapper bookings-page">
    <div class="bookings-shell">
        <header class="bookings-header">
            <div class="hero-meta">
                <span class="hero-eyebrow"><i class="fas fa-calendar-check"></i>Bookings</span>
                <h1>All Bookings</h1>
                <ul class="hero-breadcrumb">
                    <li><a href="{{ route('professional.dashboard') }}">Home</a></li>
                    <li class="active" aria-current="page">Bookings</li>
                </ul>
            </div>
            <div class="header-actions">
                <a href="{{ route('professional.dashboard') }}" class="btn">
                    <i class="fas fa-arrow-left"></i>
                    Back to Dashboard
                </a>
            </div>
        </header>

        <section class="filter-card">
            <h3>Filter Bookings</h3>
            <form action="{{ route('professional.booking.index') }}" method="GET" class="search-form">
                <div class="form-group">
                    <label for="plan_type">Plan Type</label>
                    <select name="plan_type" id="plan_type">
                        <option value="">-- Select Plan --</option>
                        @foreach($planTypes as $type)
                            <option value="{{ $type }}" {{ request('plan_type') == $type ? 'selected' : '' }}>
                                {{ ucfirst(str_replace('_', ' ', $type)) }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="status">Status</label>
                    <select name="status" id="status">
                        <option value="">All Status</option>
                        <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="search_name">Search</label>
                    <input type="text" name="search_name" id="search_name" value="{{ request('search_name') }}" placeholder="Customer or Service Name">
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
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-search"></i>
                        Search
                    </button>
                    <a href="{{ route('professional.booking.index') }}" class="btn btn-secondary">
                        <i class="fas fa-undo"></i>
                        Reset
                    </a>
                </div>
            </form>
        </section>

        <section class="bookings-card">
            <div class="bookings-card__head">
                <h3>Bookings Overview</h3>
                <span class="text-muted" style="font-size: 0.9rem;">Monitor customer bookings, manage slots, and access documents from a single place.</span>
            </div>
            <div class="bookings-card__body">
                <div class="table-wrapper">
                    @if($bookings->isEmpty())
                        <div class="empty-state">
                            <i class="fas fa-calendar-times"></i>
                            <p>No bookings available at the moment.</p>
                        </div>
                    @else
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>Customer Name</th>
                                    <th>Plan Type</th>
                                    <th>Service Name</th>
                                    <th>Sub-Service</th>
                                    <th>Time Slot</th>
                                    <th>Booking Date</th>
                                    <th>Meeting Link</th>
                                    <th>Details</th>
                                    <th>Status</th>
                                    <th>Admin Remarks</th>
                                    <th>Upload Documents (PDF)</th>
                                    <th>Customer Document</th>
                                    <th>Chat</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($bookings as $booking)
                                    @php
                                        $earliestTimedate = $booking->timedates && $booking->timedates->count() > 0 
                                            ? $booking->timedates
                                                ->filter(function($timedate) {
                                                    return \Carbon\Carbon::parse($timedate->date)->isFuture();
                                                })
                                                ->sortBy('date')
                                                ->first()
                                            : null;
                                        $allSlots = $booking->timedates;
                                        $allCompleted = $allSlots->count() > 0 && $allSlots->every(function($timedate) {
                                            return $timedate->status === 'completed';
                                        });
                                    @endphp
                                    <tr>
                                        <td>
                                            {{ $booking->customer_name }}
                       				        <button class="btn btn-info btn-sm questionnaire-info" data-booking-id="{{ $booking->id }}" title="View Questionnaire Answers">
                                                <i class="fas fa-info-circle"></i>
                                            </button>
                                        </td>
                                        <td>{{ $booking->plan_type }}</td>
                                        <td>{{ $booking->service_name }}</td>
                                        <td>
                                            @if($booking->sub_service_name)
                                                <span class="badge bg-info">{{ $booking->sub_service_name }}</span>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td>{!! $earliestTimedate ? str_replace(',', '<br>', $earliestTimedate->time_slot) : '-' !!}</td>
                                        <td>{{ \Carbon\Carbon::parse($booking->booking_date)->format('d-m-Y') }}</td>
                                        <td>
                                            @if($booking->meeting_link)
                                                <a href="{{ $booking->meeting_link }}" class="btn btn-link" target="_blank">
                                                    <i class="fas fa-video"></i> Join Meeting
                                                </a>
                                            @elseif($booking->timedates && $booking->timedates->count() > 0 && $booking->timedates->first()->meeting_link)
                                                <a href="{{ $booking->timedates->first()->meeting_link }}" class="btn btn-link" target="_blank">
                                                    <i class="fas fa-video"></i> Join Meeting
                                                </a>
                                            @else
                                                <span class="badge bg-warning">Meeting link not given by admin</span>
                                            @endif
                                        </td>
                                        <td>
                                            <button class="btn btn-info btn-sm view-details" data-booking-id="{{ $booking->id }}">
                                                View
                                            </button>
                                        </td>
                                        <td>
                                            <span class="badge {{ $allCompleted ? 'bg-success' : 'bg-warning' }}">
                                                {{ $allCompleted ? 'Completed' : 'Pending' }}
                                            </span>
                                        </td>
                                        <td>{{ $booking->remarks ?? 'No remarks' }}</td>
                                        <td>
                                            <div class="d-flex flex-wrap gap-2">
                                                @if ($booking->professional_documents)
                                                    @php
                                                        $doc = $booking->professional_documents;
                                                        $extension = pathinfo($doc, PATHINFO_EXTENSION);
                                                        $fileName = basename($doc);
                                                        $icon = match(strtolower($extension)) {
                                                            'pdf' => 'pdf',
                                                            'doc', 'docx' => 'word',
                                                            'jpg', 'jpeg', 'png' => 'image',
                                                            default => 'file'
                                                        };
                                                    @endphp
                                                    <a href="{{ asset('storage/' . $doc) }}" 
                                                       class="document-preview" 
                                                       target="_blank"
                                                       title="View {{ $fileName }}">
                                                        <img src="{{ asset('images/' . $icon . '-icon.png') }}" 
                                                             alt="{{ strtoupper($extension) }}">
                                                        <div class="doc-info">
                                                            <span class="doc-name">{{ $fileName }}</span>
                                                            <span class="doc-type">{{ strtoupper($extension) }} Document</span>
                                                        </div>
                                                    </a>
                                                @endif
                                                <button class="btn btn-sm btn-primary upload-btn" 
                                                        onclick="openUploadModal('{{ $booking->id }}')"
                                                        title="Upload/Update Document">
                                                    <i class="fas fa-{{ $booking->professional_documents ? 'sync' : 'upload' }}"></i>
                                                    {{ $booking->professional_documents ? 'Update' : 'Upload' }}
                                                </button>
                                            </div>
                                        </td>
                                        <td>
                                            @if ($booking->customer_document)
                                                @php
                                                    $customerDocs = explode(',', $booking->customer_document);
                                                @endphp
                                                <div class="d-flex flex-wrap gap-2">
                                                    @foreach ($customerDocs as $doc)
                                                        @php
                                                            $extension = pathinfo($doc, PATHINFO_EXTENSION);
                                                            $fileName = basename($doc);
                                                            $icon = match(strtolower($extension)) {
                                                                'pdf' => 'pdf',
                                                                'doc', 'docx' => 'word',
                                                                'jpg', 'jpeg', 'png' => 'image',
                                                                default => 'file'
                                                            };
                                                        @endphp
                                                        <a href="{{ asset('storage/' . $doc) }}" 
                                                           class="document-preview" 
                                                           target="_blank"
                                                           title="View {{ $fileName }}">
                                                            <img src="{{ asset('images/' . $icon . '-icon.png') }}" 
                                                                 alt="{{ strtoupper($extension) }}">
                                                            <div class="doc-info">
                                                                <span class="doc-name">{{ $fileName }}</span>
                                                                <span class="doc-type">{{ strtoupper($extension) }} Document</span>
                                                            </div>
                                                        </a>
                                                    @endforeach
                                                </div>
                                            @else
                                                <div class="no-doc-message">
                                                    <i class="fas fa-file-alt"></i>
                                                    No documents provided
                                                </div>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('professional.chat.open', $booking->id) }}" 
                                               class="chat-button position-relative chat-btn-{{ $booking->id }}" 
                                               target="_blank" 
                                               title="Chat with Customer"
                                               data-booking-id="{{ $booking->id }}">
                                                <i class="fas fa-comments chat-icon"></i>
                                                <span class="chat-label">Chat</span>
                                                <span class="chat-badge badge bg-danger d-none" id="chat-badge-{{ $booking->id }}">
                                                    0
                                                </span>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>
        </section>
    </div>
</div>

<!-- Custom Modal -->
<div id="bookingDetailModal" class="custom-modal">
    <div class="custom-modal-content">
        <span class="close-modal">&times;</span>
        <h4>Booking Details</h4>
        <table class="table table-bordered" id="details-table">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Time Slot</th>
                    <th>Remarks</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>
</div>

<!-- Questionnaire Modal -->
<div id="questionnaireModal" class="custom-modal">
    <div class="custom-modal-content">
        <span class="close-modal" id="closeQuestionnaireModal">&times;</span>
        <h4>Questionnaire Answers</h4>
        <div id="questionnaireContent">
            <!-- Content will be loaded here -->
        </div>
    </div>
</div>

<!-- Booking Chat Modal -->
<div id="bookingChatModal" class="custom-modal" style="display: none;">
    <div class="custom-modal-content" style="max-width: 700px;">
        <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #ddd; padding: 15px;">
            <div id="chatModalTitle" style="flex: 1;">Chat with Customer</div>
            <span class="close-modal" id="closeChatModal" style="font-size: 24px; cursor: pointer;" onclick="closeChatModal()">&times;</span>
        </div>
        <div id="chatMessages" style="height: 400px; overflow-y: auto; padding: 1rem; background: #f8f9fa; border-radius: 8px; margin: 1rem;">
            <!-- Messages will be loaded here -->
        </div>
        <div style="padding: 0 1rem 1rem 1rem;">
            <div id="selectedFileName" style="color: #007bff; margin-bottom: 10px; min-height: 20px; font-size: 14px;"></div>
            <div style="display: flex; gap: 0.5rem; align-items: center;">
            </div>
        </div>
    </div>
</div>

<!-- Upload Modal -->
<div id="uploadModal" class="upload-modal" style="display: none;">
    <div class="upload-modal-content">
        <div class="modal-header">
            <h3>Upload Document</h3>
            <span class="close-upload-modal">&times;</span>
        </div>
        <div class="modal-body">
            <form id="uploadForm" class="upload-form" enctype="multipart/form-data">
                @csrf
                <input type="hidden" id="booking_id" name="booking_id" value="">
                
                <div class="form-group">
                    <label for="document">Select PDF Document:</label>
                    <input type="file" id="document" name="document" accept=".pdf" required>
                    <small class="form-text text-muted">Only PDF files are allowed. Max size: 10MB</small>
                </div>
                
                <div class="form-group">
                    <button type="submit" class="btn-upload">
                        <i class="fas fa-upload"></i> Upload Document
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    const modal = document.getElementById('bookingDetailModal');
    const questionnaireModal = document.getElementById('questionnaireModal');
    const closeModal = document.querySelector('.close-modal');
    const closeQuestionnaireModal = document.getElementById('closeQuestionnaireModal');
    const tableBody = document.querySelector('#details-table tbody');
    const questionnaireContent = document.getElementById('questionnaireContent');

    // View details button click
    document.querySelectorAll('.view-details').forEach(button => {
        button.addEventListener('click', () => {
            const bookingId = button.dataset.bookingId;
            fetchBookingDetails(bookingId);
        });
    });

    // Fetch booking details from server
    function fetchBookingDetails(bookingId) {
        fetch(`/professional/bookings/${bookingId}/details`)
            .then(response => {
                if (!response.ok) throw new Error('Network response was not ok');
                return response.json();
            })
            .then(data => {
                populateTable(data.dates, bookingId);
                modal.style.display = 'block';
            })
            .catch(error => {
                console.error('Error fetching booking details:', error);
                alert('Something went wrong while fetching booking details.');
            });
    }

    // Populate the modal table
    function populateTable(dates, bookingId) {
        tableBody.innerHTML = '';

        dates.forEach(item => {
            item.time_slot.forEach(slot => {
                const isCompleted = item.status === 'completed';
                const isChecked = isCompleted ? 'checked' : '';
                const sliderClass = 'status-slider';
                const remarks = item.remarks || '';

                const row = `
                    <tr>
                        <td>${item.date}</td>
                        <td>${slot}</td>
                        <td>
                            <input type="text" class="form-control remark-input" value="${remarks}" 
                                   placeholder="Remarks">
                        </td>
                        <td>
                            <label class="${sliderClass}"
                                   data-booking-id="${bookingId}" 
                                   data-date="${item.date}" 
                                   data-slot="${slot}">
                                <input type="checkbox" class="status-checkbox" ${isChecked}>
                                <span class="slider"></span>
                            </label>
                            <span class="status-text">${isCompleted ? 'Completed' : 'Pending'}</span>
                        </td>
                    </tr>
                `;

                tableBody.insertAdjacentHTML('beforeend', row);
            });
        });

        attachCheckboxListeners();
    }

    // Attach change event to status checkboxes
    function attachCheckboxListeners() {
        document.querySelectorAll('.status-checkbox').forEach(checkbox => {
            checkbox.addEventListener('change', async (e) => {
                const label = checkbox.closest('.status-slider');
                const bookingId = label.dataset.bookingId;
                const date = label.dataset.date;
                const slot = label.dataset.slot;
                const remarks = checkbox.closest('tr').querySelector('.remark-input').value.trim();
                const status = checkbox.checked ? 'completed' : 'pending';

                // Check if remarks are empty and show confirmation
                if (!remarks) {
                    if (!confirm('Are you sure you want to proceed without adding any remarks?')) {
                        // If user cancels, revert the checkbox state
                        checkbox.checked = !checkbox.checked;
                        return;
                    }
                }

                // Send AJAX request to update status and remarks
                fetch('/professional/bookings/update-status', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        booking_id: bookingId,
                        date: date,
                        slot: slot,
                        remarks: remarks,
                        status: status
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        toastr.success(data.message);
                        // Update the UI to reflect the new status
                        const statusText = checkbox.closest('td').querySelector('.status-text');
                        statusText.textContent = status === 'completed' ? 'Completed' : 'Pending';
                        
                        // Keep remarks input always enabled
                        const remarksInput = checkbox.closest('tr').querySelector('.remark-input');
                        remarksInput.readOnly = false;
                        
                        // Keep slider always enabled
                        label.className = 'status-slider';
                    } else {
                        toastr.error(data.message);
                        // Revert the checkbox state
                        checkbox.checked = !checkbox.checked;
                    }
                })
                .catch(error => {
                    console.error('Error updating status:', error);
                    toastr.error('Failed to update status.');
                    // Revert the checkbox state
                    checkbox.checked = !checkbox.checked;
                });
            });
        });
    }

    // Handle questionnaire info button clicks
    document.querySelectorAll('.questionnaire-info').forEach(button => {
        button.addEventListener('click', () => {
            const bookingId = button.dataset.bookingId;
            fetchQuestionnaireAnswers(bookingId);
        });
    });

    // Fetch questionnaire answers
    function fetchQuestionnaireAnswers(bookingId) {
        fetch(`/professional/bookings/${bookingId}/questionnaire`)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    let html = `<div class="questionnaire-details">
                        <h5>Customer: ${data.booking_details.customer_name}</h5>
                        <h6>Service: ${data.booking_details.service_name}</h6>
                        ${data.booking_details.sub_service_name ? '<h6>Sub-Service: <span class="badge bg-info">' + data.booking_details.sub_service_name + '</span></h6>' : ''}
                        <div class="answers-list">`;
                    
                    data.answers.forEach(item => {
                        html += `
                            <div class="answer-item">
                                <p class="question"><strong>Q:</strong> ${item.question}</p>
                                <p class="answer"><strong>A:</strong> ${item.answer}</p>
                            </div>
                        `;
                    });
                    
                    html += `</div></div>`;
                    questionnaireContent.innerHTML = html;
                } else {
                    questionnaireContent.innerHTML = `<p class="text-center text-muted">${data.message}</p>`;
                }
                questionnaireModal.style.display = 'block';
            })
            .catch(error => {
                console.error('Error fetching questionnaire answers:', error);
                questionnaireContent.innerHTML = '<p class="text-center text-danger">Error loading questionnaire answers.</p>';
                questionnaireModal.style.display = 'block';
            });
    }

    // Modal close handlers
    closeModal.addEventListener('click', () => modal.style.display = 'none');
    closeQuestionnaireModal.addEventListener('click', () => questionnaireModal.style.display = 'none');
    
    window.addEventListener('click', event => {
        if (event.target === modal) modal.style.display = 'none';
        if (event.target === questionnaireModal) questionnaireModal.style.display = 'none';
    });
});

// Add this new JavaScript code
const questionnaireModal = document.getElementById('questionnaireModal');
const closeQuestionnaireModal = document.getElementById('closeQuestionnaireModal');
const questionnaireContent = document.getElementById('questionnaireContent');

// Handle questionnaire info button clicks
document.querySelectorAll('.questionnaire-info').forEach(button => {
    button.addEventListener('click', () => {
        const bookingId = button.dataset.bookingId;
        fetchQuestionnaireAnswers(bookingId);
    });
});

// Fetch questionnaire answers
function fetchQuestionnaireAnswers(bookingId) {
    // Show loading indicator
    questionnaireContent.innerHTML = '<div class="text-center"><i class="fas fa-spinner fa-spin"></i> Loading questionnaire answers...</div>';
    questionnaireModal.style.display = 'block';
    
    fetch(`/professional/bookings/${bookingId}/questionnaire`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                let html = `<div class="questionnaire-details">
                    <!-- Header Section -->
                    <div class="questionnaire-header mb-4 p-3 bg-light rounded">
                        <div class="row align-items-center">
                            <div class="col-md-8">
                                <h5 class="mb-1"><i class="fas fa-user text-primary"></i> ${data.booking_details.customer_name}</h5>
                                <p class="mb-1"><i class="fas fa-cog text-info"></i> <strong>Service:</strong> ${data.booking_details.service_name}</p>
                                ${data.booking_details.sub_service_name ? '<p class="mb-1"><i class="fas fa-puzzle-piece text-warning"></i> <strong>Sub-Service:</strong> <span class="badge bg-info">' + data.booking_details.sub_service_name + '</span></p>' : ''}
                            </div>
                            <div class="col-md-4 text-end">
                                ${data.booking_details.booking_date ? '<p class="mb-1"><i class="fas fa-calendar text-success"></i> ' + new Date(data.booking_details.booking_date).toLocaleDateString('en-US', { year: 'numeric', month: 'long', day: 'numeric' }) + '</p>' : ''}
                                <span class="badge bg-primary fs-6"><i class="fas fa-question-circle"></i> ${data.booking_details.answers_count || data.answers.length} Answers</span>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Answers Section -->
                    <div class="answers-list">`;
                
                if (data.answers && data.answers.length > 0) {
                    data.answers.forEach((item, index) => {
                        // Format date nicely
                        let formattedDate = '';
                        if (item.created_at) {
                            const date = new Date(item.created_at);
                            formattedDate = date.toLocaleDateString('en-US', { 
                                month: 'numeric', 
                                day: 'numeric', 
                                year: 'numeric' 
                            });
                        }
                        
                        html += `
                            <div class="answer-card mb-3 border rounded">
                                <div class="card-body p-3">
                                    <div class="d-flex align-items-start">
                                        <div class="question-number me-3 mt-1">
                                            <span class="badge bg-gradient-primary rounded-pill fs-6">${index + 1}</span>
                                        </div>
                                        <div class="flex-grow-1">
                                            <div class="question-text mb-3">
                                                <h6 class="text-dark mb-2"><i class="fas fa-question-circle text-primary me-2"></i>Question:</h6>
                                                <p class="question-content mb-0 text-muted">${item.question}</p>
                                            </div>
                                            <div class="answer-text mb-3">
                                                <h6 class="text-dark mb-2"><i class="fas fa-check-circle text-success me-2"></i>Answer:</h6>
                                                <div class="answer-content p-2 bg-light rounded border-start border-success border-3">
                                                    <strong class="text-success">${item.answer}</strong>
                                                </div>
                                            </div>
                                            <div class="metadata d-flex justify-content-between align-items-center">
                                                <div>
                                                    ${item.question_type ? '<span class="badge bg-secondary"><i class="fas fa-tag me-1"></i>Type: ' + item.question_type + '</span>' : ''}
                                                </div>
                                                <div>
                                                    ${formattedDate ? '<small class="text-muted"><i class="fas fa-clock me-1"></i>Answered on: ' + formattedDate + '</small>' : ''}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        `;
                    });
                } else {
                    html += `
                        <div class="text-center py-5">
                            <i class="fas fa-exclamation-triangle text-warning fs-1 mb-3"></i>
                            <h5 class="text-muted">No MCQ Answers Found</h5>
                            <p class="text-muted">The customer hasn't filled out the questionnaire yet.</p>
                        </div>
                    `;
                }
                
                html += `</div></div>`;
                questionnaireContent.innerHTML = html;
            } else {
                let errorHtml = `
                    <div class="alert alert-warning">
                        <h6><i class="fas fa-exclamation-triangle"></i> No MCQ Answers Found</h6>
                        <p>${data.message}</p>
                `;
                
                if (data.debug_info) {
                    errorHtml += `
                        <details class="mt-3">
                            <summary>Debug Information</summary>
                            <small class="text-muted">
                                <br>Booking ID: ${data.debug_info.booking_id}
                                <br>Customer: ${data.debug_info.customer_name || 'N/A'}
                                <br>Service: ${data.debug_info.service_name || 'N/A'}
                                <br>User ID: ${data.debug_info.user_id || 'N/A'}
                                <br>Service ID: ${data.debug_info.service_id || 'N/A'}
                                ${data.debug_info.sub_service_id ? '<br>Sub-Service ID: ' + data.debug_info.sub_service_id : ''}
                            </small>
                        </details>
                    `;
                }
                
                errorHtml += '</div>';
                questionnaireContent.innerHTML = errorHtml;
            }
        })
        .catch(error => {
            console.error('Error fetching questionnaire answers:', error);
            questionnaireContent.innerHTML = `
                <div class="alert alert-danger">
                    <h6><i class="fas fa-exclamation-circle"></i> Error Loading Questionnaire</h6>
                    <p>There was an error loading the questionnaire answers. Please try again.</p>
                    <small class="text-muted">Error: ${error.message}</small>
                </div>
            `;
        });
}

// Close questionnaire modal
closeQuestionnaireModal.addEventListener('click', () => {
    questionnaireModal.style.display = 'none';
});

// Close modal when clicking outside
window.addEventListener('click', event => {
    if (event.target === questionnaireModal) {
        questionnaireModal.style.display = 'none';
    }
});

// Upload Modal Functionality
document.addEventListener('DOMContentLoaded', function() {
    const uploadModal = document.getElementById('uploadModal');
    const closeUploadModal = document.querySelector('.close-upload-modal');
    const uploadForm = document.getElementById('uploadForm');
    const bookingIdInput = document.getElementById('booking_id');

    // Check if elements exist before adding event listeners
    if (!uploadModal || !closeUploadModal || !uploadForm || !bookingIdInput) {
        console.error('Upload modal elements not found');
        return;
    }

    window.openUploadModal = function(bookingId) {
        bookingIdInput.value = bookingId;
        uploadModal.style.display = 'block';
    }

    closeUploadModal.onclick = function() {
        uploadModal.style.display = 'none';
    }

    window.onclick = function(event) {
        if (event.target == uploadModal) {
            uploadModal.style.display = 'none';
        }
    }

    uploadForm.onsubmit = function(e) {
        e.preventDefault();
        const formData = new FormData(uploadForm);
        const bookingId = bookingIdInput.value;
        
        // Get the file input and check if a file is selected
        const fileInput = document.getElementById('document');
        if (fileInput.files.length === 0) {
            toastr.error('Please select a file to upload');
            return;
        }

        // Add the single file to formData
        formData.append('document', fileInput.files[0]);

        fetch(`/professional/bookings/${bookingId}/upload-documents`, {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                toastr.success(data.message);
                uploadModal.style.display = 'none';
                location.reload(); 
            } else {
                toastr.error(data.message || 'Upload failed');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            toastr.error('An error occurred while uploading');
        });
    };
});

// Load unread chat counts for all bookings
function loadUnreadChatCounts() {
    $('[data-booking-id]').each(function() {
        const bookingId = $(this).data('booking-id');
        const badgeElement = $(`#chat-badge-${bookingId}`);
        
        $.ajax({
            url: `/professional/chat/booking/${bookingId}/unread-count`,
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