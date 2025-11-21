@extends('professional.layout.layout')

@section('styles')
<style>
    :root {
        --primary: #4f46e5;
        --primary-dark: #4338ca;
        --success: #16a34a;
        --warning: #f59e0b;
        --danger: #dc2626;
        --slate-900: #0f172a;
        --slate-700: #334155;
        --slate-500: #64748b;
        --surface: #ffffff;
        --surface-soft: #f8fafc;
        --accent-bg: linear-gradient(135deg, rgba(79, 70, 229, 0.18), rgba(14, 165, 233, 0.22));
        --shadow-lg: 0 26px 48px rgba(15, 23, 42, 0.12);
        --radius-xl: 26px;
    }

    body {
        background: #eef1f8;
    }

    .event-show-page {
        padding: 2.6rem 1.6rem 3.4rem;
        background: linear-gradient(180deg, rgba(79, 70, 229, 0.08), rgba(255, 255, 255, 0.9));
        min-height: 100vh;
    }

    .event-show-shell {
        max-width: 1240px;
        margin: 0 auto;
        display: flex;
        flex-direction: column;
        gap: 2rem;
    }

    .event-hero {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
        gap: 1.8rem;
        padding: 2.4rem 2.6rem;
        border-radius: var(--radius-xl);
        background: var(--accent-bg);
        position: relative;
        overflow: hidden;
        box-shadow: var(--shadow-lg);
    }

    .event-hero::before,
    .event-hero::after {
        content: '';
        position: absolute;
        border-radius: 50%;
        pointer-events: none;
        opacity: 0.45;
    }

    .event-hero::before {
        width: 320px;
        height: 320px;
        top: -140px;
        right: -120px;
        background: rgba(79, 70, 229, 0.35);
    }

    .event-hero::after {
        width: 220px;
        height: 220px;
        bottom: -140px;
        left: -90px;
        background: rgba(14, 165, 233, 0.35);
    }

    .event-hero > * {
        position: relative;
        z-index: 1;
    }

    .event-hero__meta {
        display: flex;
        flex-direction: column;
        gap: 0.75rem;
        color: var(--slate-700);
    }

    .event-hero__eyebrow {
        display: inline-flex;
        align-items: center;
        gap: 0.45rem;
        background: rgba(255, 255, 255, 0.7);
        border-radius: 999px;
        padding: 0.45rem 1.3rem;
        font-size: 0.76rem;
        font-weight: 700;
        letter-spacing: 0.12em;
        text-transform: uppercase;
        color: var(--slate-900);
        border: 1px solid rgba(255, 255, 255, 0.75);
    }

    .event-hero__title {
        margin: 0;
        font-size: 2.4rem;
        font-weight: 700;
        color: var(--slate-900);
        letter-spacing: -0.02em;
    }

    .event-hero__subtitle {
        margin: 0;
        font-size: 1.05rem;
        color: var(--slate-700);
        max-width: 520px;
        line-height: 1.55;
    }

    .event-hero__breadcrumbs {
        display: flex;
        flex-wrap: wrap;
        gap: 0.55rem;
        list-style: none;
        padding: 0;
        margin: 0.5rem 0 0;
        font-size: 0.9rem;
        color: var(--slate-500);
    }

    .event-hero__breadcrumbs li {
        display: inline-flex;
        align-items: center;
        gap: 0.55rem;
    }

    .event-hero__breadcrumbs li + li::before {
        content: '›';
        color: rgba(15, 23, 42, 0.35);
    }

    .event-hero__breadcrumbs a {
        color: var(--primary-dark);
        text-decoration: none;
        font-weight: 600;
    }

    .event-hero__side {
        display: flex;
        flex-direction: column;
        gap: 1.1rem;
        justify-content: space-between;
    }

    .event-status-pill {
        align-self: flex-start;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        border-radius: 999px;
        padding: 0.65rem 1.4rem;
        font-weight: 600;
        letter-spacing: 0.04em;
        text-transform: uppercase;
        box-shadow: 0 18px 36px rgba(15, 23, 42, 0.15);
    }

    .event-status-pill i {
        font-size: 1rem;
    }

    .event-status-pill.is-approved {
        background: rgba(22, 163, 74, 0.12);
        color: var(--success);
        border: 1px solid rgba(22, 163, 74, 0.3);
    }

    .event-status-pill.is-pending {
        background: rgba(245, 158, 11, 0.14);
        color: #b45309;
        border: 1px solid rgba(245, 158, 11, 0.28);
    }

    .event-status-pill.is-rejected {
        background: rgba(220, 38, 38, 0.16);
        color: var(--danger);
        border: 1px solid rgba(220, 38, 38, 0.28);
    }

    .event-hero__figure {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        font-size: 1.2rem;
        color: var(--slate-700);
        margin-top: auto;
    }

    .event-hero__figure strong {
        font-size: 2.2rem;
        color: var(--success);
        letter-spacing: -0.03em;
    }

    .event-layout {
        display: grid;
        grid-template-columns: 340px 1fr;
        gap: 1.6rem;
    }

    .event-card {
        background: var(--surface);
        border-radius: 22px;
        border: 1px solid rgba(148, 163, 184, 0.18);
        box-shadow: 0 18px 42px rgba(15, 23, 42, 0.12);
        overflow: hidden;
        display: flex;
        flex-direction: column;
        gap: 0;
    }

    .event-card + .event-card {
        margin-top: 1.4rem;
    }

    .event-card__body {
        padding: 1.8rem 2rem;
    }

    .event-preview__image {
        width: 100%;
        aspect-ratio: 4/3;
        object-fit: cover;
        border-radius: 20px;
        box-shadow: 0 18px 36px rgba(15, 23, 42, 0.14);
    }

    .event-preview__placeholder {
        height: 280px;
        border-radius: 20px;
        background: rgba(226, 232, 240, 0.6);
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--slate-500);
        font-size: 2.6rem;
    }

    .event-details-list {
        display: flex;
        flex-direction: column;
        gap: 1rem;
        padding: 0;
        margin: 0;
        list-style: none;
    }

    .event-details-item {
        display: flex;
        gap: 1rem;
        padding: 1rem 1.2rem;
        border-radius: 16px;
        background: rgba(248, 250, 255, 0.8);
        border: 1px solid rgba(148, 163, 184, 0.16);
    }

    .event-details-icon {
        width: 42px;
        height: 42px;
        border-radius: 12px;
        background: rgba(79, 70, 229, 0.12);
        color: var(--primary-dark);
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 1.1rem;
    }

    .event-details-content {
        flex: 1;
    }

    .event-details-label {
        font-size: 0.82rem;
        text-transform: uppercase;
        letter-spacing: 0.12em;
        font-weight: 700;
        color: var(--slate-500);
    }

    .event-details-value {
        margin-top: 0.25rem;
        font-size: 1.05rem;
        font-weight: 600;
        color: var(--slate-900);
    }

    .event-description {
        margin-top: 1.5rem;
        padding: 1.6rem 1.8rem;
        border-radius: 22px;
        background: var(--surface-soft);
        border: 1px solid rgba(148, 163, 184, 0.18);
        color: var(--slate-700);
        line-height: 1.65;
        font-size: 1rem;
        white-space: pre-wrap;
    }

    .timeline {
        display: flex;
        flex-direction: column;
        gap: 1.4rem;
        position: relative;
        padding-left: 1.6rem;
    }

    .timeline::before {
        content: '';
        position: absolute;
        top: 0.6rem;
        bottom: 0.6rem;
        left: 0.55rem;
        width: 2px;
        background: linear-gradient(180deg, rgba(79, 70, 229, 0.35), rgba(14, 165, 233, 0.35));
    }

    .timeline__item {
        position: relative;
        padding-left: 1.6rem;
    }

    .timeline__item::before {
        content: '';
        position: absolute;
        left: -0.05rem;
        top: 0.35rem;
        width: 14px;
        height: 14px;
        border-radius: 50%;
        background: var(--surface);
        border: 3px solid var(--primary);
        box-shadow: 0 0 0 6px rgba(79, 70, 229, 0.12);
    }

    .timeline__item.is-success::before {
        border-color: var(--success);
        box-shadow: 0 0 0 6px rgba(34, 197, 94, 0.18);
    }

    .timeline__item.is-warning::before {
        border-color: var(--warning);
        box-shadow: 0 0 0 6px rgba(245, 158, 11, 0.18);
    }

    .timeline__card {
        background: var(--surface);
        border-radius: 16px;
        padding: 1.1rem 1.4rem;
        box-shadow: 0 10px 24px rgba(15, 23, 42, 0.12);
    }

    .timeline__title {
        margin: 0;
        font-size: 1rem;
        font-weight: 700;
        color: var(--slate-900);
    }

    .timeline__time {
        margin: 0.35rem 0;
        font-size: 0.9rem;
        color: var(--slate-500);
        font-weight: 600;
    }

    .timeline__desc {
        margin: 0;
        font-size: 0.95rem;
        color: var(--slate-700);
    }

    .action-bar {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        gap: 0.9rem;
        padding: 1.8rem;
        border-radius: 20px;
        background: var(--surface-soft);
        border: 1px solid rgba(148, 163, 184, 0.22);
    }

    .action-btn {
        position: relative;
        display: inline-flex;
        align-items: center;
        gap: 0.55rem;
        padding: 1.2rem 3rem;
        min-width: 260px;
        justify-content: center;
        border-radius: 12px;
        font-weight: 600;
        text-decoration: none;
        border: none;
        cursor: pointer;
        background: transparent;
        color: var(--surface);
        overflow: hidden;
        transition: transform 0.16s ease, box-shadow 0.16s ease;
    }

    .action-btn::before {
        content: '';
        position: absolute;
        inset: 0;
        border-radius: inherit;
        background: rgba(255, 255, 255, 0.2);
        opacity: 0;
        transition: opacity 0.2s ease;
    }

    .action-btn i {
        font-size: 1rem;
        z-index: 1;
    }

    .action-btn span {
        z-index: 1;
    }

    .action-btn.primary {
        background: linear-gradient(135deg, var(--primary), var(--primary-dark));
        box-shadow: 0 18px 32px rgba(79, 70, 229, 0.25);
    }

    .action-btn.secondary {
        background: linear-gradient(135deg, #475569, #334155);
        box-shadow: 0 18px 32px rgba(71, 85, 105, 0.22);
    }

    .action-btn.warning {
        background: linear-gradient(135deg, #f59e0b, #f97316);
        box-shadow: 0 18px 32px rgba(245, 158, 11, 0.22);
        color: #1f2937;
    }

    .action-btn.danger {
        background: linear-gradient(135deg, #ef4444, #dc2626);
        box-shadow: 0 18px 32px rgba(239, 68, 68, 0.25);
    }

    .action-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 22px 38px rgba(15, 23, 42, 0.16);
    }

    .action-btn:hover::before {
        opacity: 1;
    }


    .admin-note {
        border-left: 4px solid var(--danger);
        background: rgba(248, 113, 113, 0.12);
        color: #991b1b;
        padding: 1.2rem 1.4rem;
        border-radius: 18px;
        line-height: 1.6;
    }

    @media (max-width: 1100px) {
        .event-layout {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 768px) {
        .event-show-page {
            padding: 2.2rem 1.1rem 2.6rem;
        }

        .event-hero {
            padding: 2rem 1.9rem;
        }

        .event-hero__title {
            font-size: 2rem;
        }

        .action-bar {
            flex-direction: column;
        }

        .action-btn {
            justify-content: center;
        }
    }
</style>
@endsection

@section('content')
<div class="event-show-page">
    <div class="event-show-shell">
        <section class="event-hero">
            <div class="event-hero__meta">
                <span class="event-hero__eyebrow"><i class="ri-calendar-event-line"></i>Event Overview</span>
                <h1 class="event-hero__title">{{ $event->heading }}</h1>
                @if($event->mini_heading)
                    <p class="event-hero__subtitle">{{ $event->mini_heading }}</p>
                @endif
                <ul class="event-hero__breadcrumbs">
                    <li><a href="{{ route('professional.dashboard') }}">Dashboard</a></li>
                    <li><a href="{{ route('professional.events.index') }}">Events</a></li>
                    <li class="active" aria-current="page">{{ $event->heading }}</li>
                </ul>
            </div>
            <div class="event-hero__side">
                <span class="event-status-pill is-{{ $event->status }}">
                    @if($event->status === 'approved')
                        <i class="ri-check-line"></i> Approved
                    @elseif($event->status === 'pending')
                        <i class="ri-time-line"></i> Pending Review
                    @elseif($event->status === 'rejected')
                        <i class="ri-close-line"></i> Rejected
                    @endif
                </span>
                <div class="event-hero__figure">
                    <i class="ri-money-rupee-circle-line"></i>
                    <div>
                        <span class="event-details-label">Starting from</span>
                        <strong>₹{{ number_format($event->starting_fees, 2) }}</strong>
                    </div>
                </div>
            </div>
        </section>

        <section class="event-layout">
            <aside class="event-layout__aside">
                <div class="event-card">
                    <div class="event-card__body">
                        @if($event->card_image)
                            <img src="{{ asset('storage/' . $event->card_image) }}"
                                 alt="{{ $event->heading }}"
                                 class="event-preview__image">
                        @else
                            <div class="event-preview__placeholder">
                                <i class="ri-image-line"></i>
                            </div>
                        @endif
                    </div>
                </div>

                @if($event->created_at || $event->updated_at || $event->approved_at)
                    <div class="event-card">
                        <div class="event-card__body">
                            <h3 class="event-details-label" style="letter-spacing:0.16em;">Timeline</h3>
                            <div class="timeline">
                                @if($event->approved_at)
                                    <div class="timeline__item is-success">
                                        <div class="timeline__card">
                                            <p class="timeline__title">Event Approved</p>
                                            <p class="timeline__time">{{ $event->approved_at->format('M d, Y \a\t H:i A') }}</p>
                                            <p class="timeline__desc">Your event has been approved and is now live.</p>
                                        </div>
                                    </div>
                                @endif

                                @if($event->updated_at->gt($event->created_at))
                                    <div class="timeline__item is-warning">
                                        <div class="timeline__card">
                                            <p class="timeline__title">Event Updated</p>
                                            <p class="timeline__time">{{ $event->updated_at->format('M d, Y \a\t H:i A') }}</p>
                                            <p class="timeline__desc">Event details were modified.</p>
                                        </div>
                                    </div>
                                @endif

                                <div class="timeline__item">
                                    <div class="timeline__card">
                                        <p class="timeline__title">Event Created</p>
                                        <p class="timeline__time">{{ $event->created_at->format('M d, Y \a\t H:i A') }}</p>
                                        <p class="timeline__desc">Event was submitted for review.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </aside>

            <div class="event-layout__main">
                <div class="event-card">
                    <div class="event-card__body">
                        <h3 class="event-details-label" style="letter-spacing:0.16em;">Event Information</h3>
                        <ul class="event-details-list">
                            <li class="event-details-item">
                                <span class="event-details-icon"><i class="ri-calendar-line"></i></span>
                                <div class="event-details-content">
                                    <span class="event-details-label">Event Date & Time</span>
                                    <div class="event-details-value">
                                        {{ \Carbon\Carbon::parse($event->date)->format('l, F j, Y') }}
                                        @if($event->time)
                                            at {{ \Carbon\Carbon::parse($event->time)->format('h:i A') }}
                                        @endif
                                    </div>
                                </div>
                            </li>
                            <li class="event-details-item">
                                <span class="event-details-icon"><i class="ri-price-tag-3-line"></i></span>
                                <div class="event-details-content">
                                    <span class="event-details-label">Event Type</span>
                                    <div class="event-details-value">{{ $event->mini_heading }}</div>
                                </div>
                            </li>
                            <li class="event-details-item">
                                <span class="event-details-icon"><i class="ri-money-rupee-circle-line"></i></span>
                                <div class="event-details-content">
                                    <span class="event-details-label">Starting Fees</span>
                                    <div class="event-details-value" style="color: var(--success);">₹{{ number_format($event->starting_fees, 2) }}</div>
                                </div>
                            </li>
                            <li class="event-details-item">
                                <span class="event-details-icon"><i class="ri-video-line"></i></span>
                                <div class="event-details-content">
                                    <span class="event-details-label">Meet Link</span>
                                    <div class="event-details-value">
                                        @if($event->meet_link)
                                            <a href="{{ $event->meet_link }}" target="_blank" class="meet-link-btn">
                                                <i class="ri-external-link-line me-2"></i>Join Meeting
                                            </a>
                                        @else
                                            <span style="color: var(--slate-500);">
                                                <i class="ri-close-circle-line me-1"></i>Not set by admin yet
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </li>
                        </ul>

                        <div class="event-description">
                            <span class="event-details-label" style="display:block; margin-bottom:0.8rem;">Description</span>
                            {{ $event->short_description }}
                        </div>
                    </div>
                </div>

                @if($event->admin_notes)
                    <div class="event-card">
                        <div class="event-card__body">
                            <h3 class="event-details-label" style="letter-spacing:0.16em;">Admin Notes</h3>
                            <div class="admin-note">
                                {{ $event->admin_notes }}
                            </div>
                        </div>
                    </div>
                @endif

                <div class="event-card">
                    <div class="event-card__body">
                        <div class="action-bar">
                            <a href="{{ route('professional.events.index') }}" class="action-btn secondary">
                                <i class="ri-arrow-left-line"></i>Back to Events
                            </a>

                            @if($event->status !== 'approved')
                                <a href="{{ route('professional.events.edit', $event) }}" class="action-btn warning">
                                    <i class="ri-edit-line"></i>Edit Event
                                </a>

                                <button type="button" onclick="deleteEvent()" class="action-btn danger">
                                    <i class="ri-delete-bin-line"></i>Delete Event
                                </button>
                            @endif

                            @if($event->status === 'approved')
                                <a href="{{ route('event.details', $event->id) }}" class="action-btn primary" target="_blank">
                                    <i class="ri-external-link-line"></i>View on Frontend
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>
@endsection

@section('script')
<script>
function deleteEvent() {
    if (confirm('Are you sure you want to delete this event? This action cannot be undone.')) {
        // Create a form to submit DELETE request
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '{{ route('professional.events.destroy', $event) }}';
        
        // Add CSRF token
        const csrfToken = document.createElement('input');
        csrfToken.type = 'hidden';
        csrfToken.name = '_token';
        csrfToken.value = '{{ csrf_token() }}';
        form.appendChild(csrfToken);
        
        // Add METHOD spoofing for DELETE
        const methodInput = document.createElement('input');
        methodInput.type = 'hidden';
        methodInput.name = '_method';
        methodInput.value = 'DELETE';
        form.appendChild(methodInput);
        
        // Submit the form
        document.body.appendChild(form);
        form.submit();
    }
}
</script>
