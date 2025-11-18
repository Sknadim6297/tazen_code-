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

    .event-bookings-page {
        width: 100%;
        padding: 2.5rem 1.35rem 3.5rem;
    }

    .event-bookings-shell {
        max-width: 1200px;
        margin: 0 auto;
        display: flex;
        flex-direction: column;
        gap: 2rem;
    }

    .event-bookings-header {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        justify-content: space-between;
        gap: 1.2rem;
        padding: 2rem 2.3rem;
        border-radius: 26px;
        border: 1px solid rgba(79, 70, 229, 0.18);
        background: linear-gradient(135deg, rgba(79, 70, 229, 0.1), rgba(14, 165, 233, 0.12));
        position: relative;
        overflow: hidden;
        box-shadow: 0 24px 48px rgba(79, 70, 229, 0.16);
    }

    .event-bookings-header::before,
    .event-bookings-header::after {
        content: "";
        position: absolute;
        border-radius: 50%;
        pointer-events: none;
    }

    .event-bookings-header::before {
        width: 320px;
        height: 320px;
        top: -45%;
        right: -12%;
        background: rgba(79, 70, 229, 0.18);
    }

    .event-bookings-header::after {
        width: 220px;
        height: 220px;
        bottom: -40%;
        left: -10%;
        background: rgba(59, 130, 246, 0.16);
    }

    .event-bookings-header > * {
        position: relative;
        z-index: 1;
    }

    .event-bookings-header .pretitle {
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
        color: var(--text-dark);
    }

    .event-bookings-header h1 {
        margin: 1rem 0 0.55rem;
        font-size: 2rem;
        font-weight: 700;
        color: var(--text-dark);
    }

    .event-bookings-header .breadcrumb {
        margin: 0;
        padding: 0;
        background: transparent;
        font-size: 0.9rem;
        color: var(--text-muted);
    }

    .event-bookings-header .breadcrumb a {
        color: var(--primary);
        text-decoration: none;
    }

    .event-bookings-header .breadcrumb .active {
        color: var(--text-muted);
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

    .search-buttons .btn {
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

    .search-buttons .btn-primary {
        background: linear-gradient(135deg, var(--primary), var(--primary-dark));
        color: #ffffff;
        box-shadow: 0 12px 28px rgba(79, 70, 229, 0.2);
    }

    .search-buttons .btn-secondary {
        background: rgba(79, 70, 229, 0.08);
        color: var(--primary-dark);
        border: 1px solid rgba(79, 70, 229, 0.18);
    }

    .search-buttons .btn:hover {
        transform: translateY(-1px);
    }

    .event-bookings-card {
        background: var(--card-bg);
        border-radius: 22px;
        border: 1px solid var(--border);
        box-shadow: 0 18px 42px rgba(15, 23, 42, 0.12);
        overflow: hidden;
    }

    .event-bookings-card__head {
        padding: 1.6rem 2.2rem 1.1rem;
        border-bottom: 1px solid rgba(148, 163, 184, 0.2);
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 1rem;
    }

    .event-bookings-card__head h3 {
        margin: 0;
        font-size: 1.18rem;
        font-weight: 700;
        color: var(--text-dark);
    }

    .event-bookings-card__head .card-subtitle {
        font-size: 0.9rem;
        color: var(--text-muted);
    }

    .event-bookings-card__body {
        padding: 1.9rem 2.2rem;
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

    .data-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
        min-width: 1000px;
    }

    .data-table thead {
        background: rgba(79, 70, 229, 0.08);
    }

    .data-table th {
        padding: 0.95rem 1rem;
        font-size: 0.85rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        color: var(--text-dark);
        border-bottom: 1px solid rgba(148, 163, 184, 0.2);
        white-space: nowrap;
    }

    .data-table td {
        padding: 0.85rem 1rem;
        border-bottom: 1px solid rgba(226, 232, 240, 0.8);
        font-size: 0.9rem;
        color: var(--text-dark);
        vertical-align: middle;
        background: transparent;
    }

    .data-table tr:last-child td {
        border-bottom: none;
    }

    .customer-cell {
        display: flex;
        gap: 0.75rem;
        align-items: center;
    }

    .customer-avatar {
        width: 48px;
        height: 48px;
        border-radius: 50%;
        background: linear-gradient(135deg, var(--primary), var(--secondary));
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: 600;
        font-size: 1.1rem;
    }

    .customer-info {
        display: flex;
        flex-direction: column;
        gap: 0.2rem;
    }

    .customer-info strong {
        font-size: 0.95rem;
        color: var(--text-dark);
    }

    .customer-info small {
        color: var(--text-muted);
        font-size: 0.78rem;
    }

    .badge {
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
        padding: 0.35rem 0.75rem;
        border-radius: 999px;
        font-size: 0.74rem;
        font-weight: 600;
        letter-spacing: 0.04em;
    }

    .badge.bg-info-subtle {
        background: rgba(14, 165, 233, 0.12);
        color: #0369a1;
    }

    .badge.bg-secondary-subtle {
        background: rgba(100, 116, 139, 0.12);
        color: #475569;
    }

    .badge.bg-success-subtle {
        background: rgba(34, 197, 94, 0.15);
        color: #16a34a;
    }

    .badge.bg-warning-subtle {
        background: rgba(250, 204, 21, 0.2);
        color: #b45309;
    }

    .badge.bg-danger-subtle {
        background: rgba(248, 113, 113, 0.2);
        color: #b91c1c;
    }

    .table-actions {
        display: inline-flex;
        gap: 0.45rem;
        flex-wrap: wrap;
    }

    .table-actions .btn {
        border: none;
        border-radius: 10px;
        padding: 0.45rem 0.85rem;
        font-size: 0.8rem;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
        cursor: pointer;
        transition: transform 0.15s ease, box-shadow 0.15s ease;
        text-decoration: none;
    }

    .table-actions .btn-view {
        background: rgba(14, 165, 233, 0.18);
        color: #0369a1;
    }

    .table-actions .btn-status {
        background: rgba(34, 197, 94, 0.18);
        color: #15803d;
    }

    .table-actions .btn:hover {
        transform: translateY(-1px);
    }

    .empty-state {
        text-align: center;
        padding: 3.5rem 1.5rem;
        display: flex;
        flex-direction: column;
        gap: 0.85rem;
        color: var(--text-muted);
    }

    .empty-state i {
        font-size: 2rem;
        color: var(--primary);
    }

    .empty-state h4 {
        margin: 0;
        color: var(--text-dark);
    }

    .empty-state a {
        align-self: center;
        margin-top: 0.5rem;
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        padding: 0.75rem 1.5rem;
        border-radius: 12px;
        background: linear-gradient(135deg, var(--primary), var(--primary-dark));
        color: #ffffff;
        text-decoration: none;
        box-shadow: 0 16px 32px rgba(79, 70, 229, 0.22);
        transition: transform 0.2s ease;
    }

    .empty-state a:hover {
        transform: translateY(-2px);
    }

    @media (max-width: 1024px) {
        .event-bookings-page {
            padding: 2.1rem 1.1rem 3rem;
        }

        .event-bookings-card__body {
            padding: 1.7rem 1.8rem;
        }
    }

    @media (max-width: 768px) {
        .event-bookings-header {
            padding: 1.75rem 1.6rem;
        }

        .event-bookings-header h1 {
            font-size: 1.75rem;
        }

        .search-form {
            grid-template-columns: 1fr;
        }

        .data-table {
            min-width: 900px;
        }
    }
</style>
@endsection

@section('content')
<div class="content-wrapper event-bookings-page">
    <div class="event-bookings-shell">
        <header class="event-bookings-header">
            <div>
                <span class="pretitle"><i class="ri-calendar-check-line"></i>Event Bookings</span>
                <h1>My Event Bookings</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('professional.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Event Bookings</li>
                    </ol>
                </nav>
            </div>
        </header>

        <!-- Filters -->
        <section class="filter-card">
            <h3>Search & Filter</h3>
            <form method="GET" action="{{ route('professional.event-bookings.index') }}" class="search-form">
                <div class="form-group">
                    <label>Search Name/Event</label>
                    <input type="text" name="search_name" 
                           value="{{ request('search_name') }}" 
                           placeholder="Customer name or event name">
                </div>
                <div class="form-group">
                    <label>From Date</label>
                    <input type="date" name="search_date_from" 
                           value="{{ request('search_date_from') }}">
                </div>
                <div class="form-group">
                    <label>To Date</label>
                    <input type="date" name="search_date_to" 
                           value="{{ request('search_date_to') }}">
                </div>
                <div class="form-group">
                    <label>Payment Status</label>
                    <select name="payment_status">
                        <option value="">All Status</option>
                        @foreach($paymentStatuses as $status)
                            <option value="{{ $status }}" 
                                    {{ request('payment_status') == $status ? 'selected' : '' }}>
                                {{ ucfirst($status) }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label>Event Type</label>
                    <select name="event_type">
                        <option value="">All Types</option>
                        @foreach($eventTypes as $type)
                            <option value="{{ $type }}" 
                                    {{ request('event_type') == $type ? 'selected' : '' }}>
                                {{ ucfirst($type) }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </form>
            <div class="search-buttons">
                <button type="submit" form="{{ 'search-form' }}" class="btn btn-primary">
                    <i class="ri-search-line"></i> Search
                </button>
                <a href="{{ route('professional.event-bookings.index') }}" class="btn btn-secondary">
                    <i class="ri-refresh-line"></i> Clear
                </a>
            </div>
        </section>

        <!-- Main Content -->
        <section class="event-bookings-card">
            <div class="event-bookings-card__head">
                <h3>Event Bookings</h3>
                <span class="card-subtitle">Manage customer bookings for your events and track payment status.</span>
            </div>
            <div class="event-bookings-card__body">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <div class="table-wrapper">
                    @if($bookings->count() > 0)
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>Customer</th>
                                    <th>Event</th>
                                    <th>Event Date</th>
                                    <th>Location</th>
                                    <th>Persons</th>
                                    <th>Amount</th>
                                    <th>Payment Status</th>
                                    <th>Booking Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($bookings as $booking)
                                    <tr>
                                        <td>
                                            <div class="customer-cell">
                                                <div class="customer-avatar">
                                                    {{ strtoupper(substr($booking->user->name ?? 'N', 0, 1)) }}
                                                </div>
                                                <div class="customer-info">
                                                    <strong>{{ $booking->user->name ?? 'N/A' }}</strong>
                                                    <small>{{ $booking->user->email ?? 'N/A' }}</small>
                                                    @if($booking->phone)
                                                        <small>{{ $booking->phone }}</small>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div>
                                                <strong>{{ $booking->event_name }}</strong>
                                                <div class="mt-1">
                                                    <span class="badge bg-info-subtle">{{ ucfirst($booking->type ?? 'offline') }}</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="fw-medium">
                                                {{ $booking->event_date ? \Carbon\Carbon::parse($booking->event_date)->format('d M Y') : 'N/A' }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="text-muted">{{ $booking->location ?? 'N/A' }}</span>
                                        </td>
                                        <td>
                                            <span class="badge bg-secondary-subtle">
                                                {{ $booking->persons }} {{ Str::plural('person', $booking->persons) }}
                                            </span>
                                        </td>
                                        <td>
                                            <div>
                                                <span class="fw-semibold text-success">₹{{ number_format($booking->total_price, 2) }}</span>
                                                @if($booking->price != $booking->total_price)
                                                    <small class="text-muted d-block">Base: ₹{{ number_format($booking->price, 2) }}</small>
                                                @endif
                                            </div>
                                        </td>
                                        <td>
                                            @php
                                                $statusMap = [
                                                    'paid' => ['bg-success-subtle', 'ri-check-circle-line'],
                                                    'pending' => ['bg-warning-subtle', 'ri-time-line'],
                                                    'failed' => ['bg-danger-subtle', 'ri-close-circle-line'],
                                                    'refunded' => ['bg-secondary-subtle', 'ri-refund-line']
                                                ];
                                                $status = $statusMap[$booking->payment_status] ?? $statusMap['pending'];
                                            @endphp
                                            <span class="badge {{ $status[0] }}">
                                                <i class="{{ $status[1] }}"></i> {{ ucfirst($booking->payment_status) }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="text-muted">
                                                {{ $booking->created_at->format('d M Y') }}
                                            </span>
                                        </td>
                                        <td>
                                            <div class="table-actions">
                                                <a href="{{ route('professional.event-bookings.show', $booking->id) }}" class="btn btn-view">
                                                    <i class="ri-eye-line"></i> View
                                                </a>
                                                @if(in_array($booking->payment_status, ['pending', 'failed']))
                                                    <button type="button" class="btn btn-status" 
                                                            onclick="updateStatus({{ $booking->id }}, 'paid')">
                                                        <i class="ri-check-line"></i> Mark Paid
                                                    </button>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <!-- Pagination -->
                        <div class="d-flex justify-content-between align-items-center mt-4">
                            <div>
                                <p class="text-muted mb-0">
                                    Showing {{ $bookings->firstItem() ?? 0 }} to {{ $bookings->lastItem() ?? 0 }} 
                                    of {{ $bookings->total() }} bookings
                                </p>
                            </div>
                            <div>
                                {{ $bookings->links() }}
                            </div>
                        </div>
                    @else
                        <div class="empty-state">
                            <i class="ri-calendar-check-line"></i>
                            <h4>No Event Bookings Found</h4>
                            <p>
                                @if(request()->hasAny(['search_name', 'search_date_from', 'search_date_to', 'payment_status', 'event_type']))
                                    No bookings match your current filters. Try adjusting your search criteria.
                                @else
                                    You haven't received any event bookings yet. When customers book your events, they will appear here.
                                @endif
                            </p>
                            @if(request()->hasAny(['search_name', 'search_date_from', 'search_date_to', 'payment_status', 'event_type']))
                                <a href="{{ route('professional.event-bookings.index') }}">
                                    <i class="ri-refresh-line"></i> Clear Filters
                                </a>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        </section>
    </div>
</div>

<!-- Status Update Form -->
<form id="statusUpdateForm" method="POST" style="display: none;" action="">
    @csrf
    @method('PATCH')
    <input type="hidden" name="payment_status" id="newStatus">
</form>

<!-- Update form action to make it work with search form -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchForm = document.querySelector('.search-form');
        if (searchForm) {
            searchForm.setAttribute('id', 'search-form');
        }
    });
</script>
@endsection

@section('scripts')
<script>
function updateStatus(bookingId, status) {
    if (confirm(`Are you sure you want to mark this booking as ${status}?`)) {
        const form = document.getElementById('statusUpdateForm');
        form.action = `{{ route('professional.event-bookings.index') }}/${bookingId}/update-status`;
        document.getElementById('newStatus').value = status;
        form.submit();
    }
}
</script>
@endsection