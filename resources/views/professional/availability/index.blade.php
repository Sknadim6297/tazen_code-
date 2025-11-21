@extends('professional.layout.layout')

@section('styles')
<style>
    :root {
        --primary: #4f46e5;
        --primary-dark: #4338ca;
        --accent: #22c55e;
        --background: #f4f6fb;
        --card-bg: #ffffff;
        --text-dark: #111827;
        --text-muted: #6b7280;
        --border: #e5e7eb;
    }

    body,
    .app-content {
        background: var(--background);
    }

    .availability-page {
        width: 100%;
        padding: 0 1.25rem 3rem;
    }

    .availability-shell {
        max-width: 1180px;
        margin: 0 auto;
    }

    .availability-header {
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

    .availability-header::before,
    .availability-header::after {
        content: "";
        position: absolute;
        border-radius: 50%;
        pointer-events: none;
    }

    .availability-header::before {
        width: 320px;
        height: 320px;
        top: -45%;
        right: -12%;
        background: rgba(79, 70, 229, 0.2);
    }

    .availability-header::after {
        width: 220px;
        height: 220px;
        bottom: -40%;
        left: -10%;
        background: rgba(59, 130, 246, 0.18);
    }

    .availability-header > * {
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

    .availability-header .btn {
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

    .availability-header .btn:hover {
        transform: translateY(-1px);
    }

    .filter-card {
        background: var(--card-bg);
        border-radius: 18px;
        padding: 1.85rem;
        border: 1px solid var(--border);
        box-shadow: 0 12px 30px rgba(15, 23, 42, 0.09);
        margin-bottom: 2rem;
    }

    .filter-card form {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 1.2rem;
        align-items: end;
    }

    .filter-card label {
        font-size: 0.85rem;
        font-weight: 600;
        color: var(--text-muted);
        margin-bottom: 0.4rem;
        display: block;
    }

    .filter-card select,
    .filter-card button {
        width: 100%;
        border-radius: 12px;
        border: 1px solid var(--border);
        padding: 0.65rem 0.85rem;
        font-size: 0.95rem;
        transition: border-color 0.2s ease, box-shadow 0.2s ease;
    }

    .filter-card select:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.15);
    }

    .filter-card .btn {
        padding: 0.75rem 1rem;
        border-radius: 12px;
        font-weight: 600;
    }

    .filter-card .btn-outline-primary {
        border: 1px solid rgba(79, 70, 229, 0.45);
        color: var(--primary-dark);
        background: #fff;
    }

    .filter-card .btn-outline-primary:hover {
        background: rgba(79, 70, 229, 0.1);
    }

    .filter-card .btn-outline-secondary {
        border: 1px solid var(--border);
        color: var(--text-muted);
        background: #fff;
    }

    .filter-card .btn-outline-secondary:hover {
        background: rgba(15, 23, 42, 0.05);
    }

    .filter-actions {
        display: flex;
        gap: 0.75rem;
        align-items: center;
    }

    .filter-actions .btn {
        flex: 1;
    }

    .availability-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
        gap: 1.6rem;
    }

    .availability-card {
        background: var(--card-bg);
        border-radius: 22px;
        border: 1px solid rgba(229, 231, 235, 0.85);
        display: flex;
        flex-direction: column;
        min-height: 100%;
        box-shadow: 0 14px 35px rgba(15, 23, 42, 0.12);
        transition: transform 0.25s ease, box-shadow 0.25s ease;
    }

    .availability-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 20px 48px rgba(79, 70, 229, 0.18);
    }

    .availability-card .card-top {
        padding: 1.55rem 1.8rem 1.2rem;
        border-bottom: 1px solid var(--border);
        display: flex;
        flex-direction: column;
        gap: 0.8rem;
    }

    .card-top .card-meta {
        display: flex;
        justify-content: space-between;
        gap: 1rem;
        align-items: flex-start;
    }

    .card-top .month-title {
        margin: 0;
        font-size: 1.12rem;
        font-weight: 700;
        color: var(--text-dark);
        letter-spacing: -0.01em;
    }

    .card-top .month-info {
        margin: 0.35rem 0 0;
        font-size: 0.92rem;
        color: var(--text-muted);
    }

    .card-actions {
        display: flex;
        gap: 0.65rem;
        flex-wrap: wrap;
    }

    .card-actions .btn {
        border-radius: 999px;
        padding: 0.45rem 1rem;
        font-weight: 600;
        font-size: 0.85rem;
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
    }

    .card-actions .btn-outline-primary {
        border: 1px solid rgba(79, 70, 229, 0.35);
        color: var(--primary-dark);
        background: #fff;
    }

    .card-actions .btn-outline-primary:hover {
        background: rgba(79, 70, 229, 0.08);
    }

    .card-actions .btn-outline-danger {
        border: 1px solid rgba(239, 68, 68, 0.35);
        color: #dc2626;
        background: #fff;
    }

    .card-actions .btn-outline-danger:hover {
        background: rgba(239, 68, 68, 0.08);
    }

    .card-actions .label-text {
        display: none;
    }

    .availability-card .card-body {
        padding: 1.75rem;
        display: flex;
        flex-direction: column;
        gap: 1.45rem;
    }

    .weekly-title {
        display: flex;
        align-items: center;
        justify-content: space-between;
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.82rem;
        letter-spacing: 0.08em;
        color: var(--text-muted);
        border-bottom: 1px dashed var(--border);
        padding-bottom: 0.65rem;
    }

    .weekly-title i {
        font-size: 1.05rem;
        color: var(--accent);
    }

    .day-schedule {
        display: grid;
        gap: 1rem;
    }

    .day-entry {
        padding: 0.9rem 1rem;
        border-radius: 14px;
        border: 1px solid rgba(226, 232, 240, 0.9);
        background: rgba(248, 250, 252, 0.85);
        transition: background 0.2s ease, border-color 0.2s ease;
    }

    .day-entry:hover {
        background: rgba(219, 234, 254, 0.45);
        border-color: rgba(59, 130, 246, 0.45);
    }

    .day-entry .day-name {
        font-weight: 600;
        font-size: 0.92rem;
        color: var(--text-dark);
        margin-bottom: 0.5rem;
        display: flex;
        align-items: center;
        gap: 0.4rem;
    }

    .day-entry .day-name::before {
        content: "";
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background: var(--primary);
        display: inline-block;
    }

    .time-pill-group {
        display: flex;
        flex-wrap: wrap;
        gap: 0.45rem;
    }

    .time-pill {
        background: rgba(79, 70, 229, 0.12);
        color: var(--primary-dark);
        padding: 0.4rem 0.65rem;
        border-radius: 999px;
        font-size: 0.78rem;
        font-weight: 600;
        letter-spacing: 0.02em;
    }

    .no-slots {
        margin: 0;
        color: var(--text-muted);
        font-weight: 500;
    }

    .empty-state {
        background: #fff;
        border-radius: 22px;
        border: 1px dashed rgba(79, 70, 229, 0.35);
        padding: 3.5rem 1rem;
        text-align: center;
        box-shadow: 0 14px 32px rgba(79, 70, 229, 0.12);
        display: flex;
        flex-direction: column;
        gap: 1rem;
        color: var(--text-muted);
    }

    .empty-state i {
        font-size: 3rem;
        color: var(--primary);
    }

    .empty-state h4 {
        margin: 0;
        font-size: 1.35rem;
        color: var(--text-dark);
    }

    .empty-state p {
        margin: 0;
    }

    .empty-state .btn {
        align-self: center;
        padding: 0.85rem 1.85rem;
        border-radius: 999px;
        background: linear-gradient(135deg, var(--primary), var(--primary-dark));
        border: none;
        color: #fff;
        font-weight: 600;
        box-shadow: 0 18px 38px rgba(79, 70, 229, 0.22);
        transition: transform 0.2s ease;
    }

    .empty-state .btn:hover {
        transform: translateY(-3px);
    }

    @media (min-width: 576px) {
        .card-actions .label-text {
            display: inline;
        }
    }

    @media (max-width: 992px) {
        .filter-card form {
            grid-template-columns: 1fr;
        }

        .filter-actions {
            flex-wrap: wrap;
        }
    }

    @media (max-width: 768px) {
        .availability-page {
            padding: 0 1rem 2.5rem;
        }

        .availability-header {
            padding: 1.8rem 1.6rem;
        }

        .availability-header h1 {
            font-size: 1.45rem;
        }

        .availability-grid {
            grid-template-columns: 1fr;
        }

        .card-actions {
            flex-direction: column;
        }

        .card-actions .btn {
            width: 100%;
            justify-content: center;
        }

        .filter-actions {
            flex-direction: column;
        }

        .filter-actions .btn {
            width: 100%;
        }
    }
</style>
@endsection

@section('content')
<div class="content-wrapper">
    <div class="availability-page">
        <div class="availability-shell">
        <header class="availability-header">
            <div class="hero-meta">
                <span class="hero-eyebrow"><i class="ri-calendar-line"></i>Availability</span>
                <h1>My Availability</h1>
                <ul class="hero-breadcrumb">
                    <li><a href="{{ route('professional.dashboard') }}">Home</a></li>
                    <li class="active" aria-current="page">Availability</li>
                </ul>
            </div>
            <a href="{{ route('professional.availability.create') }}" class="btn btn-primary">
                <i class="ri-add-line"></i>
                Add New Availability
            </a>
        </header>

        <section class="filter-card">
            <form method="GET" action="{{ route('professional.availability.index') }}">
                <div>
                    <label for="search_month">Search by Month</label>
                    <select name="search_month" id="search_month">
                        <option value="">All Months</option>
                        @foreach($availableMonths as $month)
                            <option value="{{ $month }}" {{ request('search_month') == $month ? 'selected' : '' }}>
                                {{ \Carbon\Carbon::parse($month . '-01')->format('F Y') }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="filter-actions">
                    <button type="submit" class="btn btn-outline-primary">
                        <i class="ri-search-line"></i>Search
                    </button>
                    @if(request('search_month'))
                        <a href="{{ route('professional.availability.index') }}" class="btn btn-outline-secondary">
                            <i class="ri-refresh-line"></i>Clear
                        </a>
                    @endif
                </div>
            </form>
        </section>

        @if($availability->count() > 0)
            <section class="availability-grid">
                @foreach($availability as $avail)
                    <article class="availability-card">
                        <div class="card-top">
                            <div class="card-meta">
                                <div>
                                    <h2 class="month-title">{{ \Carbon\Carbon::parse($avail->month . '-01')->format('F Y') }}</h2>
                                    <p class="month-info">Session Duration: {{ $avail->session_duration }} minutes</p>
                                </div>
                                <div class="card-actions">
                                    <a href="{{ route('professional.availability.edit', $avail->id) }}"
                                       class="btn btn-outline-primary" title="Edit Availability">
                                        <i class="ri-edit-line"></i>
                                        <span class="label-text">Edit</span>
                                    </a>
                                    <button type="button"
                                            class="btn btn-outline-danger delete-availability"
                                            data-id="{{ $avail->id }}"
                                            data-month="{{ \Carbon\Carbon::parse($avail->month . '-01')->format('F Y') }}"
                                            title="Delete Availability">
                                        <i class="ri-delete-bin-line"></i>
                                        <span class="label-text">Delete</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            @if($avail->slots && $avail->slots->count() > 0)
                                <div class="weekly-block">
                                    <div class="weekly-title">
                                        <span>Weekly Schedule</span>
                                        <i class="ri-calendar-check-line"></i>
                                    </div>
                                    @php
                                        $weekdays = ['mon', 'tue', 'wed', 'thu', 'fri', 'sat', 'sun'];
                                        $dayNames = [
                                            'mon' => 'Monday',
                                            'tue' => 'Tuesday',
                                            'wed' => 'Wednesday',
                                            'thu' => 'Thursday',
                                            'fri' => 'Friday',
                                            'sat' => 'Saturday',
                                            'sun' => 'Sunday'
                                        ];
                                        $slotsByDay = $avail->slots->groupBy('weekday');
                                    @endphp

                                    <div class="day-schedule">
                                        @foreach($weekdays as $day)
                                            @if(isset($slotsByDay[$day]) && $slotsByDay[$day]->count() > 0)
                                                <div class="day-entry">
                                                    <div class="day-name">{{ $dayNames[$day] }}</div>
                                                    <div class="time-pill-group">
                                                        @foreach($slotsByDay[$day] as $slot)
                                                            <span class="time-pill">
                                                                {{ \Carbon\Carbon::parse($slot->start_time)->format('g:i A') }} –
                                                                {{ \Carbon\Carbon::parse($slot->end_time)->format('g:i A') }}
                                                            </span>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            @else
                                <p class="no-slots">No time slots configured for this month.</p>
                            @endif
                        </div>
                    </article>
                @endforeach
            </section>
        @else
            <section class="empty-state">
                <i class="ri-calendar-line"></i>
                <h4>No Availability Set</h4>
                <p>You haven't configured your availability yet. Set up your schedule to start receiving bookings.</p>
                <a href="{{ route('professional.availability.create') }}" class="btn">
                    <i class="ri-add-line"></i>
                    <span>Add Your First Availability</span>
                </a>
            </section>
        @endif
        </div>
    </div>

</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Delete availability functionality
    document.querySelectorAll('.delete-availability').forEach(button => {
        button.addEventListener('click', function() {
            const availabilityId = this.getAttribute('data-id');
            const monthName = this.getAttribute('data-month');
            
            if (confirm(`Are you sure you want to delete availability for ${monthName}? This action cannot be undone.`)) {
                fetch(`{{ route('professional.availability.index') }}/${availabilityId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Content-Type': 'application/json',
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Remove the card from DOM
                        this.closest('.availability-card').remove();
                        
                        // Show success message
                        alert('Availability deleted successfully!');
                        
                        // Reload page if no more cards
                        if (document.querySelectorAll('.availability-card').length === 0) {
                            window.location.reload();
                        }
                    } else {
                        alert('Error: ' + (data.message || 'Failed to delete availability'));
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('An error occurred while deleting the availability');
                });
            }
        });
    });
});
</script>
@endsection
