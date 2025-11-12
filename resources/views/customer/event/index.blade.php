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
        --danger: #ef4444;
        --neutral-900: #2c1b0f;
        --neutral-700: #6b4c33;
        --neutral-500: #a08873;
        --neutral-300: #e6cec0;
        --surface: #ffffff;
        --surface-soft: rgba(255, 255, 255, 0.94);
        --border-soft: rgba(247, 168, 108, 0.28);
        --shadow-lg: 0 24px 48px rgba(122, 63, 20, 0.14);
        --shadow-md: 0 16px 32px rgba(122, 63, 20, 0.12);
        --shadow-sm: 0 10px 20px rgba(15, 23, 42, 0.08);
        --radius-lg: 28px;
        --radius-md: 20px;
        --radius-sm: 14px;
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

    .events-hero {
        background: linear-gradient(135deg, rgba(251, 209, 173, 0.95), rgba(255, 244, 232, 0.95));
        border-radius: var(--radius-lg);
        padding: 2.6rem 2.4rem;
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
        gap: 1.8rem 2.2rem;
        position: relative;
        overflow: hidden;
        box-shadow: var(--shadow-lg);
    }

    .events-hero::before,
    .events-hero::after {
        content: '';
        position: absolute;
        border-radius: 999px;
        pointer-events: none;
    }

    .events-hero::before {
        width: 320px;
        height: 320px;
        top: -200px;
        right: -140px;
        background: rgba(247, 168, 108, 0.26);
    }

    .events-hero::after {
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
        font-size: 0.85rem;
        text-transform: uppercase;
        letter-spacing: 0.08em;
    }

    .hero-meta h3 {
        margin: 0;
        font-size: 2.1rem;
        font-weight: 700;
        letter-spacing: -0.02em;
        color: var(--neutral-900);
    }

    .hero-meta p {
        margin: 0;
        max-width: 520px;
        line-height: 1.6;
        color: rgba(47, 47, 47, 0.72);
    }

    .hero-actions {
        display: flex;
        flex-direction: column;
        align-items: flex-start;
        gap: 0.8rem;
        position: relative;
        z-index: 1;
    }

    .hero-breadcrumb {
        display: flex;
        gap: 0.6rem;
        padding: 0;
        margin: 0;
        flex-wrap: wrap;
        list-style: none;
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

    .filter-card header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 1rem;
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

    .content-section {
        margin-top: 2.4rem;
        background: var(--surface);
        border-radius: var(--radius-md);
        border: 1px solid var(--border-soft);
        box-shadow: var(--shadow-md);
        padding: 1.9rem 1.6rem;
    }

    .section-heading {
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
        margin-bottom: 1.6rem;
    }

    .section-heading h4 {
        margin: 0;
        font-size: 1.2rem;
        font-weight: 600;
    }

    .section-heading small {
        font-size: 0.84rem;
        color: var(--neutral-500);
    }

    .cards-view {
        display: block;
    }

    .events-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 1.4rem;
    }

    .event-card {
        background: var(--surface);
        border-radius: var(--radius-sm);
        border: 1px solid rgba(255, 255, 255, 0.6);
        padding: 1.6rem 1.5rem;
        box-shadow: var(--shadow-sm);
        display: flex;
        flex-direction: column;
        gap: 1.2rem;
    }

    .event-card__head {
        display: flex;
        flex-direction: column;
        gap: 0.4rem;
        border-bottom: 1px solid rgba(226, 232, 240, 0.7);
        padding-bottom: 1rem;
    }

    .event-card__title {
        font-size: 1.15rem;
        font-weight: 600;
        margin: 0;
        color: var(--neutral-900);
    }

    .event-card__date {
        font-size: 0.9rem;
        color: var(--neutral-500);
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }

    .event-card__grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 1rem 1.2rem;
    }

    .info-item {
        display: flex;
        flex-direction: column;
        gap: 0.3rem;
    }

    .info-label {
        font-size: 0.78rem;
        text-transform: uppercase;
        letter-spacing: 0.08em;
        color: var(--neutral-500);
        font-weight: 600;
    }

    .info-value {
        font-size: 0.95rem;
        color: var(--neutral-700);
        font-weight: 600;
    }

    .status-badge,
    .type-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        padding: 0.45rem 0.9rem;
        border-radius: 999px;
        font-size: 0.82rem;
        font-weight: 600;
        letter-spacing: 0.02em;
    }

    .status-success { background: rgba(187, 247, 208, 0.32); color: #166534; border: 1px solid rgba(187, 247, 208, 0.52); }
    .status-warning { background: rgba(254, 240, 138, 0.36); color: #854d0e; border: 1px solid rgba(254, 240, 138, 0.52); }
    .status-danger { background: rgba(254, 202, 202, 0.34); color: #b91c1c; border: 1px solid rgba(254, 202, 202, 0.5); }

    .type-online { background: rgba(125, 211, 252, 0.24); color: var(--accent-dark); border: 1px solid rgba(125, 211, 252, 0.4); }
    .type-offline { background: rgba(200, 250, 230, 0.3); color: #047857; border: 1px solid rgba(200, 250, 230, 0.46); }

    .price-text {
        font-size: 1.05rem;
        font-weight: 700;
        color: var(--success);
    }

    .join-btn {
        background: linear-gradient(135deg, rgba(125, 211, 252, 0.32), rgba(14, 165, 233, 0.28));
        color: var(--accent-dark);
        border: 1px solid rgba(125, 211, 252, 0.45);
        padding: 0.65rem 1.25rem;
        font-size: 0.85rem;
        font-weight: 600;
    }

    .event-card__footer {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 0.8rem;
        border-top: 1px solid rgba(226, 232, 240, 0.7);
        padding-top: 1rem;
    }

    .empty-state {
        text-align: center;
        padding: 3rem 1.5rem;
        border-radius: var(--radius-md);
        background: var(--surface);
        border: 1px dashed rgba(247, 168, 108, 0.35);
        box-shadow: var(--shadow-sm);
        display: grid;
        gap: 0.8rem;
        justify-items: center;
    }

    .empty-state i {
        font-size: 2.8rem;
        color: rgba(247, 168, 108, 0.5);
    }

    .table-view {
        display: none;
    }

    .table-container {
        margin-top: 1.6rem;
        border-radius: var(--radius-sm);
        border: 1px solid rgba(226, 232, 240, 0.7);
        overflow-x: auto;
        box-shadow: var(--shadow-sm);
    }

    .table {
        width: 100%;
        min-width: 960px;
        border-collapse: separate;
        border-spacing: 0;
    }

    .table thead th {
        background: rgba(255, 244, 232, 0.7);
        color: var(--neutral-700);
        font-weight: 600;
        font-size: 0.78rem;
        letter-spacing: 0.08em;
        text-transform: uppercase;
        padding: 1rem 0.95rem;
        border-bottom: 1px solid rgba(247, 168, 108, 0.18);
        text-align: center;
        white-space: nowrap;
    }

    .table tbody td {
        padding: 1rem 0.95rem;
        border-bottom: 1px solid rgba(226, 232, 240, 0.7);
        text-align: center;
        color: var(--neutral-700);
        font-weight: 500;
    }

    .table tbody tr:hover td {
        background: rgba(251, 209, 173, 0.12);
    }

    @media (max-width: 992px) {
        .content-wrapper {
            padding: 2.4rem 1.2rem 2.8rem;
        }

        .events-hero {
            padding: 2.2rem 1.9rem;
        }

        .filter-card {
            padding: 1.8rem 1.6rem;
        }

        .table {
            min-width: 900px;
        }
    }

    @media (max-width: 768px) {
        .content-wrapper {
            padding: 2rem 1rem 2.4rem;
        }

        .events-hero {
            padding: 2rem 1.6rem;
        }

        .hero-meta h3 {
            font-size: 1.85rem;
        }

        .hero-actions {
            width: 100%;
        }

        .search-buttons {
            flex-direction: column;
            align-items: stretch;
        }

        .search-buttons .btn {
            width: 100%;
            text-align: center;
        }

        .event-card__grid {
            grid-template-columns: 1fr;
        }

        .event-card__footer {
            flex-direction: column;
            align-items: stretch;
        }

        .table {
            min-width: 840px;
        }
    }

    @media (max-width: 540px) {
        .content-wrapper {
            padding: 1.8rem 0.9rem 2.2rem;
        }

        .events-hero {
            padding: 1.8rem 1.4rem;
        }

        .filter-card {
            padding: 1.6rem 1.3rem;
        }

        .search-form {
            grid-template-columns: 1fr;
        }

        .events-grid {
            grid-template-columns: 1fr;
        }

        .table {
            min-width: 780px;
        }
    }
</style>
@endsection

@section('content')
<div class="content-wrapper">

    <section class="events-hero">
        <div class="hero-meta">
            <span class="hero-eyebrow"><i class="fas fa-calendar-alt"></i> Event Bookings</span>
            <h3>Summary of Your Event Bookings</h3>
            <p>Review upcoming sessions, revisit key details, and join events directly. Use the filters to find the exact booking you need.</p>
            <span class="stats-pill">
                <i class="fas fa-clock"></i>
                {{ $bookings->count() }} {{ Str::plural('event', $bookings->count()) }} booked
            </span>
        </div>
        <div class="hero-actions">
            <ul class="hero-breadcrumb">
                <li><a href="{{ route('user.dashboard') }}">Home</a></li>
                <li class="active">Events</li>
            </ul>
            <a href="{{ route('user.customer-event.index') }}" class="btn btn-outline">
                <i class="fas fa-sync"></i> Refresh List
            </a>
        </div>
    </section>

    <section class="filter-card">
        <header>
            <h4>Filter Event Bookings</h4>
        </header>
        <form action="{{ route('user.customer-event.index') }}" method="GET" class="search-form">
            <div class="form-group">
                <label for="search_name">Search</label>
                <input type="text" name="search_name" id="search_name" value="{{ request('search_name') }}" placeholder="Search event">
            </div>

            <div class="form-group">
                <label for="search_type">Event Type</label>
                <select name="search_type" id="search_type">
                    <option value="">All Types</option>
                    <option value="online" {{ request('search_type') == 'online' ? 'selected' : '' }}>Online</option>
                    <option value="offline" {{ request('search_type') == 'offline' ? 'selected' : '' }}>Offline</option>
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
                <button type="submit" class="btn btn-primary">Search</button>
                <a href="{{ route('user.customer-event.index') }}" class="btn btn-outline">Reset</a>
            </div>
        </form>
    </section>

    <section class="content-section">
        <div class="section-heading">
            <h4>
                {{ $bookings->count() }} {{ Str::plural('booking', $bookings->count()) }} found
            </h4>
            <small>Showing confirmed and past event reservations that match your filters.</small>
        </div>

        @if($bookings->count() > 0)
            <div class="cards-view">
                <div class="events-grid">
                    @foreach($bookings as $index => $booking)
                        <article class="event-card">
                            <header class="event-card__head">
                                <h5 class="event-card__title">{{ $booking->event->heading ?? 'Event Title Not Available' }}</h5>
                                <span class="event-card__date">
                                    <i class="far fa-calendar"></i>
                                    {{ \Carbon\Carbon::parse($booking->event_date)->format('d M Y') }}
                                </span>
                            </header>

                            <div class="event-card__grid">
                                <div class="info-item">
                                    <span class="info-label">Venue / Address</span>
                                    <span class="info-value">{{ $booking->location ?? 'Not provided' }}</span>
                                </div>
                                <div class="info-item">
                                    <span class="info-label">Type</span>
                                    <span class="info-value">
                                        @if($booking->type == 'online')
                                            <span class="type-badge type-online"><i class="fas fa-video"></i> Online</span>
                                        @elseif($booking->type == 'offline')
                                            <span class="type-badge type-offline"><i class="fas fa-map-marker-alt"></i> Offline</span>
                                        @else
                                            <span class="type-badge type-offline">{{ $booking->type ?? 'Not specified' }}</span>
                                        @endif
                                    </span>
                                </div>
                                <div class="info-item">
                                    <span class="info-label">Attendees</span>
                                    <span class="info-value">{{ $booking->persons ?? 'Not specified' }}</span>
                                </div>
                                <div class="info-item">
                                    <span class="info-label">Total Price</span>
                                    <span class="info-value price-text">₹{{ number_format($booking->total_price, 2) }}</span>
                                </div>
                            </div>

                            <footer class="event-card__footer">
                                <div>
                                    @if($booking->payment_status == 'success')
                                        <span class="status-badge status-success"><i class="fas fa-check-circle"></i> Confirmed</span>
                                    @elseif($booking->payment_status == 'failed')
                                        <span class="status-badge status-warning"><i class="fas fa-exclamation-triangle"></i> Failed</span>
                                    @else
                                        <span class="status-badge status-danger"><i class="fas fa-times-circle"></i> Unknown</span>
                                    @endif
                                </div>
                                @if($booking->event && $booking->event->meet_link)
                                    <a href="{{ $booking->event->meet_link }}" target="_blank" class="btn join-btn">
                                        <i class="fas fa-video"></i> Join Event
                                    </a>
                                @elseif($booking->gmeet_link)
                                    <a href="{{ $booking->gmeet_link }}" target="_blank" class="btn join-btn">
                                        <i class="fas fa-video"></i> Join Event
                                    </a>
                                @else
                                    <span class="info-value" style="color: var(--neutral-500);">No link available</span>
                                @endif
                            </footer>
                        </article>
                    @endforeach
                </div>
            </div>

            <div class="table-view">
                <div class="table-container">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Sl.No</th>
                                <th>Event Name</th>
                                <th>Event Date</th>
                                <th>Address</th>
                                <th>Type</th>
                                <th>Persons</th>
                                <th>Price</th>
                                <th>Link</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($bookings as $index => $booking)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $booking->event->heading ?? 'N/A' }}</td>
                                    <td>{{ \Carbon\Carbon::parse($booking->event_date)->format('d-m-Y') }}</td>
                                    <td>{{ $booking->location ?? 'N/A' }}</td>
                                    <td>
                                        @if($booking->type == 'online')
                                            <span class="type-badge type-online"><i class="fas fa-video"></i> Online</span>
                                        @elseif($booking->type == 'offline')
                                            <span class="type-badge type-offline"><i class="fas fa-map-marker-alt"></i> Offline</span>
                                        @else
                                            <span class="type-badge type-offline">{{ $booking->type ?? 'N/A' }}</span>
                                        @endif
                                    </td>
                                    <td>{{ $booking->persons ?? 'N/A' }}</td>
                                    <td><span class="price-text">₹{{ number_format($booking->total_price, 2) }}</span></td>
                                    <td>
                                        @if($booking->event && $booking->event->meet_link)
                                            <a href="{{ $booking->event->meet_link }}" target="_blank" class="btn join-btn"><i class="fas fa-video"></i> Join</a>
                                        @elseif($booking->gmeet_link)
                                            <a href="{{ $booking->gmeet_link }}" target="_blank" class="btn join-btn"><i class="fas fa-video"></i> Join</a>
                                        @else
                                            <span class="info-value" style="color: var(--neutral-500);">No link</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($booking->payment_status == 'success')
                                            <span class="status-badge status-success"><i class="fas fa-check-circle"></i> Confirmed</span>
                                        @elseif($booking->payment_status == 'failed')
                                            <span class="status-badge status-warning"><i class="fas fa-exclamation-triangle"></i> Failed</span>
                                        @else
                                            <span class="status-badge status-danger"><i class="fas fa-times-circle"></i> Unknown</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @else
            <div class="empty-state">
                <i class="fas fa-calendar-times"></i>
                <h4>No Events Found</h4>
                <p>You haven't booked any events yet. Start exploring our events to confirm your first session!</p>
            </div>
        @endif
    </section>

</div>
@endsection

@section('scripts')

@endsection


