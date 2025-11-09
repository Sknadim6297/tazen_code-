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

    .events-index-page {
        width: 100%;
        padding: 2.5rem 1.35rem 3.5rem;
    }

    .events-shell {
        max-width: 1200px;
        margin: 0 auto;
        display: flex;
        flex-direction: column;
        gap: 2rem;
    }

    .events-header {
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

    .events-header::before,
    .events-header::after {
        content: "";
        position: absolute;
        border-radius: 50%;
        pointer-events: none;
    }

    .events-header::before {
        width: 320px;
        height: 320px;
        top: -45%;
        right: -12%;
        background: rgba(79, 70, 229, 0.18);
    }

    .events-header::after {
        width: 220px;
        height: 220px;
        bottom: -40%;
        left: -10%;
        background: rgba(59, 130, 246, 0.16);
    }

    .events-header > * {
        position: relative;
        z-index: 1;
    }

    .events-header .pretitle {
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

    .events-header h1 {
        margin: 1rem 0 0.55rem;
        font-size: 2rem;
        font-weight: 700;
        color: var(--text-dark);
    }

    .events-header .breadcrumb {
        margin: 0;
        padding: 0;
        background: transparent;
        font-size: 0.9rem;
        color: var(--text-muted);
    }

    .events-header .breadcrumb a {
        color: var(--primary);
        text-decoration: none;
    }

    .events-header .breadcrumb .active {
        color: var(--text-muted);
    }

    .header-actions {
        display: flex;
        align-items: center;
        gap: 0.85rem;
        flex-wrap: wrap;
    }

    .header-actions .btn {
        display: inline-flex;
        align-items: center;
        gap: 0.45rem;
        padding: 0.82rem 1.6rem;
        border-radius: 999px;
        border: none;
        font-weight: 600;
        background: linear-gradient(135deg, var(--primary), var(--primary-dark));
        color: #ffffff;
        box-shadow: 0 16px 32px rgba(79, 70, 229, 0.22);
        transition: transform 0.2s ease, box-shadow 0.2s ease;
        text-decoration: none;
    }

    .header-actions .btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 20px 40px rgba(79, 70, 229, 0.28);
    }

    .events-card {
        background: var(--card-bg);
        border-radius: 22px;
        border: 1px solid var(--border);
        box-shadow: 0 18px 42px rgba(15, 23, 42, 0.12);
        overflow: hidden;
    }

    .events-card__head {
        padding: 1.6rem 2.2rem 1.1rem;
        border-bottom: 1px solid rgba(148, 163, 184, 0.2);
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 1rem;
    }

    .events-card__head h3 {
        margin: 0;
        font-size: 1.18rem;
        font-weight: 700;
        color: var(--text-dark);
    }

    .events-card__head .card-subtitle {
        font-size: 0.9rem;
        color: var(--text-muted);
    }

    .events-card__body {
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
        min-width: 960px;
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

    .event-cell {
        display: flex;
        gap: 0.75rem;
        align-items: center;
    }

    .event-thumb {
        width: 56px;
        height: 56px;
        border-radius: 14px;
        object-fit: cover;
        box-shadow: 0 8px 20px rgba(15, 23, 42, 0.18);
    }

    .event-info {
        display: flex;
        flex-direction: column;
        gap: 0.25rem;
    }

    .event-info strong {
        font-size: 0.95rem;
        color: var(--text-dark);
    }

    .event-info small {
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
        background: rgba(79, 70, 229, 0.12);
        color: var(--primary-dark);
    }

    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
        padding: 0.4rem 0.85rem;
        border-radius: 999px;
        font-size: 0.76rem;
        font-weight: 600;
        letter-spacing: 0.05em;
    }

    .status-badge.pending {
        background: rgba(250, 204, 21, 0.2);
        color: #b45309;
    }

    .status-badge.approved {
        background: rgba(34, 197, 94, 0.2);
        color: #15803d;
    }

    .status-badge.rejected {
        background: rgba(248, 113, 113, 0.2);
        color: #b91c1c;
    }

    .meeting-link {
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        background: rgba(34, 197, 94, 0.12);
        color: #15803d;
        padding: 0.45rem 0.85rem;
        border-radius: 10px;
        font-size: 0.82rem;
        text-decoration: none;
        transition: background 0.2s ease;
    }

    .meeting-link:hover {
        background: rgba(34, 197, 94, 0.2);
    }

    .no-link {
        color: var(--text-muted);
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        font-size: 0.82rem;
    }

    .table-actions {
        display: inline-flex;
        gap: 0.45rem;
        flex-wrap: wrap;
    }

    .table-actions a,
    .table-actions button {
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

    .table-actions a.btn-view {
        background: rgba(14, 165, 233, 0.18);
        color: #0369a1;
    }

    .table-actions a.btn-edit {
        background: rgba(34, 197, 94, 0.18);
        color: #15803d;
    }

    .table-actions button.btn-delete {
        background: rgba(248, 113, 113, 0.18);
        color: #b91c1c;
    }

    .table-actions a:hover,
    .table-actions button:hover {
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
        .events-index-page {
            padding: 2.1rem 1.1rem 3rem;
        }

        .events-card__body {
            padding: 1.7rem 1.8rem;
        }
    }

    @media (max-width: 768px) {
        .events-header {
            padding: 1.75rem 1.6rem;
        }

        .events-header h1 {
            font-size: 1.75rem;
        }

        .header-actions .btn {
            width: 100%;
            justify-content: center;
        }

        .data-table {
            min-width: 900px;
        }
    }
</style>
@endsection

@section('content')
<div class="content-wrapper events-index-page">
    <div class="events-shell">
        <header class="events-header">
            <div>
                <span class="pretitle"><i class="ri-calendar-event-line"></i>Events</span>
                <h1>My Events</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('professional.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Events</li>
                    </ol>
                </nav>
            </div>
            <div class="header-actions">
                <a href="{{ route('professional.events.create') }}" class="btn">
                    <i class="ri-add-line"></i>
                    Add Event
                </a>
            </div>
        </header>

        <section class="events-card">
            <div class="events-card__head">
                <h3>Event List</h3>
                <span class="card-subtitle">Track upcoming and completed events, update meeting links, and keep your audience informed.</span>
            </div>
            <div class="events-card__body">
                <div class="table-wrapper">
                    @if($events->count() > 0)
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>Event</th>
                                    <th>Date</th>
                                    <th>Type</th>
                                    <th>Fees</th>
                                    <th>Status</th>
                                    <th>Meet Link</th>
                                    <th>Created</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($events as $event)
                                    <tr>
                                        <td>
                                            <div class="event-cell">
                                                <img src="{{ asset('storage/' . $event->card_image) }}" alt="{{ $event->heading }}" class="event-thumb">
                                                <div class="event-info">
                                                    <strong>{{ $event->heading }}</strong>
                                                    <small>{{ \Illuminate\Support\Str::limit($event->short_description, 60) }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>{{ \Carbon\Carbon::parse($event->date)->format('M d, Y') }}</td>
                                        <td><span class="badge bg-info">{{ $event->mini_heading }}</span></td>
                                        <td>₹{{ number_format($event->starting_fees, 2) }}</td>
                                        <td>
                                            <span class="status-badge {{ $event->status }}">
                                                @if($event->status === 'pending')
                                                    <i class="ri-time-line"></i> Pending
                                                @elseif($event->status === 'approved')
                                                    <i class="ri-checkbox-circle-line"></i> Approved
                                                @else
                                                    <i class="ri-close-circle-line"></i> Rejected
                                                @endif
                                            </span>
                                        </td>
                                        <td>
                                            @if($event->meet_link)
                                                <a href="{{ $event->meet_link }}" target="_blank" class="meeting-link">
                                                    <i class="ri-video-line"></i> Join Meeting
                                                </a>
                                            @else
                                                <span class="no-link"><i class="ri-close-circle-line"></i> Not set</span>
                                            @endif
                                        </td>
                                        <td>{{ $event->created_at->format('M d, Y') }}</td>
                                        <td>
                                            <div class="table-actions">
                                                <a href="{{ route('professional.events.show', $event) }}" class="btn-view">
                                                    <i class="ri-eye-line"></i> View
                                                </a>
                                                @if($event->status !== 'approved')
                                                    <a href="{{ route('professional.events.edit', $event) }}" class="btn-edit">
                                                        <i class="ri-edit-line"></i> Edit
                                                    </a>
                                                    <button type="button" class="btn-delete" onclick="deleteEvent({{ $event->id }})">
                                                        <i class="ri-delete-bin-line"></i> Delete
                                                    </button>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <div class="empty-state">
                            <i class="ri-calendar-event-line"></i>
                            <h4>No events yet</h4>
                            <p>Create your first event to engage your audience and share your expertise.</p>
                            <a href="{{ route('professional.events.create') }}">
                                <i class="ri-add-line"></i>
                                Create Your First Event
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </section>
    </div>
</div>
@endsection

@section('scripts')
<script>
function deleteEvent(eventId) {
    if (confirm('Are you sure you want to delete this event? This action cannot be undone.')) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `/professional/events/${eventId}`;

        const methodInput = document.createElement('input');
        methodInput.type = 'hidden';
        methodInput.name = '_method';
        methodInput.value = 'DELETE';

        const tokenInput = document.createElement('input');
        tokenInput.type = 'hidden';
        tokenInput.name = '_token';
        tokenInput.value = '{{ csrf_token() }}';

        form.appendChild(methodInput);
        form.appendChild(tokenInput);
        document.body.appendChild(form);
        form.submit();
    }
}
</script>
@endsection
