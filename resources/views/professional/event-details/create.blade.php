@extends('professional.layout.layout')

@section('styles')
<style>
    :root {
        --primary: #4f46e5;
        --primary-dark: #4338ca;
        --secondary: #0ea5e9;
        --accent: #22c55e;
        --danger: #ef4444;
        --muted: #64748b;
        --page-bg: #f4f6fb;
        --card-bg: #ffffff;
        --border: rgba(148, 163, 184, 0.22);
        --shadow-lg: 0 28px 56px rgba(15, 23, 42, 0.14);
    }

    .event-details-create-page {
        width: 100%;
        min-height: 100%;
        background: var(--page-bg);
        padding: 2.6rem 1.45rem 3.6rem;
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
        max-width: 520px;
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

    .alert {
        border-radius: 16px;
        border: none;
        padding: 1rem 1.4rem;
        font-weight: 500;
        box-shadow: 0 18px 38px rgba(15, 23, 42, 0.1);
        display: flex;
        gap: 0.8rem;
        align-items: flex-start;
    }

    .alert ul { margin: 0; padding-left: 1.1rem; }

    .alert-danger { background: rgba(239, 68, 68, 0.12); color: #b91c1c; }
    .alert-success { background: rgba(34, 197, 94, 0.14); color: #047857; }

    .alert .btn-close {
        border-radius: 50%;
        background: rgba(148, 163, 184, 0.2);
        width: 2rem;
        height: 2rem;
        opacity: 1;
        color: var(--muted);
        margin-left: auto;
        transition: background 0.18s ease, color 0.18s ease;
    }

    .alert .btn-close:hover {
        background: rgba(148, 163, 184, 0.34);
        color: #0f172a;
    }

    .form-card {
        background: var(--card-bg);
        border-radius: 24px;
        border: 1px solid var(--border);
        box-shadow: var(--shadow-lg);
        overflow: hidden;
    }

    .form-card__head {
        padding: 1.8rem 2.2rem 1.1rem;
        border-bottom: 1px solid rgba(148, 163, 184, 0.18);
        display: flex;
        flex-direction: column;
        gap: 0.55rem;
    }

    .form-card__head h2 {
        margin: 0;
        font-size: 1.2rem;
        font-weight: 700;
        color: #0f172a;
        display: inline-flex;
        align-items: center;
        gap: 0.6rem;
    }

    .form-card__head p {
        margin: 0;
        color: var(--muted);
        font-size: 0.92rem;
        max-width: 620px;
    }

    .form-card__body {
        padding: 2.1rem 2.2rem 2.4rem;
        display: flex;
        flex-direction: column;
        gap: 1.8rem;
    }

    .form-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
        gap: 1.3rem 1.6rem;
    }

    .form-grid__item--full {
        grid-column: 1 / -1;
    }

    label.form-label {
        font-weight: 600;
        color: #0f172a;
        margin-bottom: 0.55rem;
        display: block;
    }

    .form-control,
    .form-select,
    input[type="file"] {
        border-radius: 14px;
        border: 1px solid rgba(148, 163, 184, 0.35);
        padding: 0.72rem 0.9rem;
        font-size: 0.92rem;
        color: #0f172a;
        background: #ffffff;
        transition: border 0.18s ease, box-shadow 0.18s ease;
    }

    .form-control:focus,
    .form-select:focus,
    input[type="file"]:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.12);
        outline: none;
    }

    input[type="file"] {
        padding: 0.6rem 0.9rem;
    }

    textarea.form-control {
        resize: vertical;
        min-height: 140px;
    }

    .form-note {
        margin-top: 0.55rem;
        font-size: 0.82rem;
        display: flex;
        align-items: flex-start;
        gap: 0.4rem;
        line-height: 1.4;
    }

    .form-note i { margin-top: 0.1rem; }

    .form-note--info { color: var(--secondary); }
    .form-note--muted { color: var(--muted); }
    .form-note--warning { color: #b45309; }

    .form-actions {
        display: flex;
        flex-wrap: wrap;
        gap: 0.75rem;
        justify-content: flex-end;
    }

    .form-actions .btn {
        display: inline-flex;
        align-items: center;
        gap: 0.45rem;
        border-radius: 12px;
        font-weight: 600;
        padding: 0.7rem 1.35rem;
        border: none;
        cursor: pointer;
        transition: transform 0.18s ease, box-shadow 0.18s ease;
    }

    .btn-primary {
        background: linear-gradient(135deg, var(--primary), var(--primary-dark));
        color: #fff;
        box-shadow: 0 18px 38px rgba(79, 70, 229, 0.22);
    }

    .btn-primary:hover { transform: translateY(-1px); }

    .btn-secondary {
        background: rgba(148, 163, 184, 0.18);
        color: #0f172a;
    }

    .btn-secondary:hover {
        transform: translateY(-1px);
        background: rgba(148, 163, 184, 0.26);
    }

    .form-text-link {
        color: var(--primary);
        text-decoration: none;
        font-weight: 600;
    }

    .form-text-link:hover { text-decoration: underline; }

    @media (max-width: 1024px) {
        .event-details-create-page {
            padding: 2.3rem 1.2rem 3.2rem;
        }

        .form-card__body {
            padding: 1.9rem 1.9rem 2.2rem;
        }

        .form-card__head {
            padding: 1.6rem 1.8rem 1rem;
        }
    }

    @media (max-width: 768px) {
        .event-details-create-page {
            padding: 2rem 1rem 2.6rem;
        }

        .services-hero {
            padding: 1.6rem 1.7rem;
        }

        .hero-meta h1 { font-size: 1.7rem; }

        .form-card__body {
            padding: 1.6rem 1.5rem 2rem;
        }

        .form-card__head {
            padding: 1.5rem 1.5rem 0.9rem;
        }

        .hero-actions {
            width: 100%;
            justify-content: stretch;
        }

        .btn-primary-pill,
        .btn-outline-pill {
            width: 100%;
            justify-content: center;
        }

        .form-actions {
            flex-direction: column;
            align-items: stretch;
        }

        .form-actions .btn {
            justify-content: center;
        }
    }
</style>
@endsection

@section('content')
<div class="event-details-create-page">
    <div class="event-details-shell">
        <section class="services-hero">
            <div class="hero-meta">
                <span class="hero-eyebrow"><i class="fas fa-calendar-alt"></i>Event Management</span>
                <h1>Add Event Details</h1>
                <p>Enrich your event with detailed information, imagery, and delivery specifics to help customers prepare.</p>
                <ul class="hero-breadcrumb">
                    <li><a href="{{ route('professional.dashboard') }}">Home</a></li>
                    <li><a href="{{ route('professional.event-details.index') }}">Event Details</a></li>
                    <li class="active" aria-current="page">Add Details</li>
                </ul>
            </div>
            <div class="hero-actions">
                <a href="{{ route('professional.event-details.index') }}" class="btn-outline-pill">
                    <i class="fas fa-arrow-left"></i>
                    Back to List
                </a>
                <a href="{{ route('professional.events.create') }}" class="btn-primary-pill">
                    <i class="fas fa-calendar-plus"></i>
                    Create Event
                </a>
            </div>
        </section>

        @if(session('success'))
            <div class="alert alert-success" role="alert">
                <i class="fas fa-check-circle"></i>
                <div>
                    {{ session('success') }}
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger" role="alert">
                <i class="fas fa-exclamation-circle"></i>
                <div>
                    <strong>We found a few issues:</strong>
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <section class="form-card">
            <header class="form-card__head">
                <h2><i class="fas fa-edit"></i>Event Detail Information</h2>
                <p>Complete the fields below. Selecting an existing event will auto-fill several fields that you can fine-tune.</p>
            </header>
            <div class="form-card__body">
                <form action="{{ route('professional.event-details.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="form-grid">
                        <div class="form-grid__item form-grid__item--full">
                            <label for="event_id" class="form-label">Select Event <span class="text-danger">*</span></label>
                            <select class="form-select" id="event_id" name="event_id" required>
                                <option value="">Choose an event...</option>
                                @foreach($availableEvents as $event)
                                    <option value="{{ $event->id }}"
                                            data-starting-date="{{ $event->date ? \Carbon\Carbon::parse($event->date)->format('Y-m-d') : '' }}"
                                            data-starting-fees="{{ $event->starting_fees ?? '' }}"
                                            data-description="{{ $event->short_description ?? '' }}"
                                            data-heading="{{ $event->heading ?? '' }}"
                                            data-mini-heading="{{ $event->mini_heading ?? '' }}"
                                            {{ (old('event_id') ?? request('event_id')) == $event->id ? 'selected' : '' }}>
                                        {{ $event->heading }} - {{ $event->date ? \Carbon\Carbon::parse($event->date)->format('M d, Y') : 'No date' }}
                                    </option>
                                @endforeach
                            </select>
                            @if($availableEvents->count() === 0)
                                <p class="form-note form-note--warning">
                                    <i class="fas fa-exclamation-triangle"></i>
                                    All your events already have details or you haven't created any events yet.
                                    <a href="{{ route('professional.events.create') }}" class="form-text-link">Create a new event</a>
                                </p>
                            @endif
                            <p class="form-note form-note--info">
                                <i class="fas fa-info-circle"></i>
                                Selecting an event will auto-fill the event type, starting date, starting fees, and description.
                            </p>
                        </div>

                        <div class="form-grid__item form-grid__item--full">
                            <label for="banner_image" class="form-label">Banner Images <span class="text-danger">*</span></label>
                            <input type="file" class="form-control" id="banner_image" name="banner_image[]" multiple accept="image/*" required>
                            <p class="form-note form-note--muted">
                                <i class="fas fa-image"></i>
                                Upload one or more banner images (JPG, PNG, WebP, max 2MB each).
                            </p>
                        </div>

                        <div class="form-grid__item">
                            <label for="event_type" class="form-label">Event Type <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="event_type" name="event_type" value="{{ old('event_type') }}" required placeholder="e.g., Workshop, Webinar, Conference">
                            <p class="form-note form-note--muted">
                                <i class="fas fa-magic"></i>
                                Auto-filled from the selected event's category.
                            </p>
                        </div>

                        <div class="form-grid__item">
                            <label for="starting_date" class="form-label">Starting Date <span class="text-danger">*</span></label>
                            <input type="date" class="form-control" id="starting_date" name="starting_date" value="{{ old('starting_date') }}" required>
                            <p class="form-note form-note--muted">
                                <i class="fas fa-magic"></i>
                                Auto-filled from the selected event's date.
                            </p>
                        </div>

                        <div class="form-grid__item">
                            <label for="starting_fees" class="form-label">Starting Fees (₹) <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" id="starting_fees" name="starting_fees" value="{{ old('starting_fees') }}" min="0" step="0.01" required>
                            <p class="form-note form-note--muted">
                                <i class="fas fa-magic"></i>
                                Auto-filled from the selected event's pricing.
                            </p>
                        </div>

                        <div class="form-grid__item">
                            <label for="event_mode" class="form-label">Event Mode <span class="text-danger">*</span></label>
                            <select class="form-select" id="event_mode" name="event_mode" required>
                                <option value="">Select event mode...</option>
                                <option value="online" {{ old('event_mode') === 'online' ? 'selected' : '' }}>Online</option>
                                <option value="offline" {{ old('event_mode') === 'offline' ? 'selected' : '' }}>Offline</option>
                            </select>
                        </div>

                        <div class="form-grid__item form-grid__item--full" id="city_field" style="display: none;">
                            <label for="city" class="form-label">City <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="city" name="city" value="{{ old('city') }}" placeholder="Enter city name">
                            <p class="form-note form-note--muted">
                                <i class="fas fa-location-dot"></i>
                                Required for offline events.
                            </p>
                        </div>

                        <div class="form-grid__item form-grid__item--full">
                            <label for="event_details" class="form-label">Event Details <span class="text-danger">*</span></label>
                            <textarea class="form-control" id="event_details" name="event_details" rows="6" required placeholder="Provide detailed information about the event, agenda, what participants will learn, etc.">{{ old('event_details') }}</textarea>
                            <p class="form-note form-note--muted">
                                <i class="fas fa-magic"></i>
                                Auto-filled from the selected event's description. Edit or expand as needed.
                            </p>
                        </div>

                        <div class="form-grid__item form-grid__item--full">
                            <label for="event_gallery" class="form-label">Gallery Images (Optional)</label>
                            <input type="file" class="form-control" id="event_gallery" name="event_gallery[]" multiple accept="image/*">
                            <p class="form-note form-note--muted">
                                <i class="fas fa-images"></i>
                                Upload additional images for the event gallery (JPG, PNG, WebP, max 2MB each).
                            </p>
                        </div>
                    </div>

                    <div class="form-actions">
                        <a href="{{ route('professional.event-details.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i>
                            Cancel
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i>
                            Save Event Details
                        </button>
                    </div>
                </form>
            </div>
        </section>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const eventSelect = document.getElementById('event_id');
    const eventModeSelect = document.getElementById('event_mode');
    const cityField = document.getElementById('city_field');
    const cityInput = document.getElementById('city');

    function fillFormFromEvent() {
        const selectedOption = eventSelect.options[eventSelect.selectedIndex];

        if (selectedOption.value) {
            const miniHeading = selectedOption.getAttribute('data-mini-heading');
            if (miniHeading) {
                document.getElementById('event_type').value = miniHeading;
            }

            const startingDate = selectedOption.getAttribute('data-starting-date');
            if (startingDate) {
                document.getElementById('starting_date').value = startingDate;
            }

            const startingFees = selectedOption.getAttribute('data-starting-fees');
            if (startingFees) {
                document.getElementById('starting_fees').value = startingFees;
            }

            const description = selectedOption.getAttribute('data-description');
            if (description) {
                document.getElementById('event_details').value = description;
            }
        } else {
            document.getElementById('event_type').value = '';
            document.getElementById('starting_date').value = '';
            document.getElementById('starting_fees').value = '';
            document.getElementById('event_details').value = '';
            eventModeSelect.value = '';
            cityInput.value = '';
        }

        toggleCityField();
    }

    function toggleCityField() {
        if (eventModeSelect.value === 'offline') {
            cityField.style.display = 'block';
            cityInput.required = true;
        } else {
            cityField.style.display = 'none';
            cityInput.required = false;
            if (!eventSelect.value) {
                cityInput.value = '';
            }
        }
    }

    eventSelect.addEventListener('change', fillFormFromEvent);
    eventModeSelect.addEventListener('change', toggleCityField);

    toggleCityField();

    if (eventSelect.value) {
        fillFormFromEvent();
    }
});
</script>
@endsection