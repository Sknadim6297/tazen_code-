@extends('professional.layout.layout')

@section('styles')
<style>
    .event-view-wrapper {
        padding: 2.5rem 2.4rem 3rem;
        background: #f9fafc;
    }

    .event-view-shell {
        display: flex;
        flex-direction: column;
        gap: 1.8rem;
    }

    .event-summary-card {
        background: linear-gradient(135deg, rgba(59, 130, 246, 0.12), rgba(37, 99, 235, 0.15));
        border-radius: 26px;
        border: 1px solid rgba(59, 130, 246, 0.2);
        box-shadow: 0 24px 48px rgba(15, 23, 42, 0.15);
        padding: 2.1rem 2rem;
        display: flex;
        flex-direction: column;
        gap: 1.8rem;
    }

    .event-summary-top {
        display: flex;
        flex-wrap: wrap;
        align-items: flex-start;
        justify-content: space-between;
        gap: 1.6rem;
    }

    .event-summary-heading h2 {
        margin: 0;
        font-size: 1.55rem;
        font-weight: 700;
        color: #0f172a;
    }

    .event-summary-heading p {
        margin: 0.35rem 0 0;
        color: rgba(15, 23, 42, 0.78);
        font-size: 0.98rem;
    }

    .event-badge-group {
        display: flex;
        flex-wrap: wrap;
        gap: 0.6rem;
        align-items: center;
    }

    .event-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.45rem;
        border-radius: 999px;
        padding: 0.45rem 1rem;
        background: rgba(255, 255, 255, 0.75);
        border: 1px solid rgba(255, 255, 255, 0.8);
        color: #1e293b;
        font-weight: 600;
        font-size: 0.84rem;
        text-transform: uppercase;
        letter-spacing: 0.08em;
    }

    .event-highlight {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
        gap: 1rem;
    }

    .event-highlight-card {
        background: rgba(255, 255, 255, 0.85);
        border-radius: 20px;
        padding: 1.2rem 1.3rem;
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
        border: 1px solid rgba(148, 163, 184, 0.26);
        box-shadow: 0 12px 28px rgba(15, 23, 42, 0.1);
    }

    .event-highlight-card span {
        font-size: 0.8rem;
        font-weight: 600;
        color: #475569;
        letter-spacing: 0.08em;
        text-transform: uppercase;
    }

    .event-highlight-card strong {
        font-size: 1.1rem;
        color: #0f172a;
    }

    .event-info-section {
        background: #ffffff;
        border-radius: 24px;
        border: 1px solid rgba(203, 213, 225, 0.6);
        box-shadow: 0 20px 40px rgba(15, 23, 42, 0.12);
        padding: 2rem 2.2rem;
        display: flex;
        flex-direction: column;
        gap: 1.6rem;
    }

    .event-info-section header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 1rem;
    }

    .event-info-section header h3 {
        margin: 0;
        font-size: 1.18rem;
        font-weight: 700;
        color: #0f172a;
    }

    .event-info-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 1.4rem;
    }

    .event-info-item {
        padding: 1.1rem 1.2rem;
        border-radius: 18px;
        border: 1px solid rgba(226, 232, 240, 0.7);
        background: rgba(248, 250, 252, 0.92);
        display: flex;
        flex-direction: column;
        gap: 0.35rem;
    }

    .event-info-item span {
        font-size: 0.78rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.08em;
        color: #64748b;
    }

    .event-info-item strong {
        font-size: 1rem;
        color: #0f172a;
    }

    .event-info-item .badge {
        align-self: flex-start;
        padding: 0.35rem 0.8rem;
        border-radius: 999px;
        font-weight: 600;
        font-size: 0.8rem;
    }

    .event-details-box {
        background: rgba(248, 250, 252, 0.6);
        border: 1px solid rgba(203, 213, 225, 0.6);
        border-radius: 20px;
        padding: 1.6rem 1.8rem;
        line-height: 1.6;
        color: #334155;
        font-size: 0.95rem;
    }

    .event-section-title {
        font-size: 1.05rem;
        font-weight: 700;
        color: #0f172a;
        margin-bottom: 0.85rem;
        display: flex;
        align-items: center;
        gap: 0.55rem;
    }

    .event-section-title i {
        color: #3b82f6;
    }

    .event-media-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 1.2rem;
    }

    .event-media-grid img {
        width: 100%;
        aspect-ratio: 4 / 3;
        object-fit: cover;
        border-radius: 18px;
        box-shadow: 0 16px 32px rgba(15, 23, 42, 0.18);
        border: 1px solid rgba(226, 232, 240, 0.6);
    }

    .event-action-bar {
        display: flex;
        flex-wrap: wrap;
        gap: 0.8rem;
        align-items: center;
    }

    .event-action-bar .btn {
        padding: 0.75rem 1.4rem;
        border-radius: 14px;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }

    @media (max-width: 1024px) {
        .event-view-wrapper {
            padding: 2rem 1.6rem 2.4rem;
        }

        .event-summary-card {
            padding: 1.8rem 1.6rem;
        }

        .event-info-section {
            padding: 1.8rem 1.9rem;
        }
    }

    @media (max-width: 768px) {
        .event-view-wrapper {
            padding: 1.6rem 1.2rem 2rem;
        }

        .event-summary-heading h2 {
            font-size: 1.35rem;
        }

        .event-summary-card {
            padding: 1.6rem 1.4rem;
        }

        .event-info-section {
            padding: 1.6rem 1.5rem;
        }

        .event-media-grid {
            grid-template-columns: 1fr;
        }

        .event-action-bar {
            flex-direction: column;
            align-items: stretch;
        }

        .event-action-bar .btn {
            justify-content: center;
        }
    }
</style>
@endsection

@section('content')
<div class="content-wrapper event-view-wrapper">
    <div class="page-header">
        <ul class="breadcrumb">
            <li>Home</li>
            <li><a href="{{ route('professional.event-details.index') }}">Event Details</a></li>
            <li class="active">View</li>
        </ul>
    </div>

    @php
        $bannerImages = $eventDetail->banner_image ? json_decode($eventDetail->banner_image, true) : [];
        $galleryImages = $eventDetail->event_gallery ? json_decode($eventDetail->event_gallery, true) : [];
    @endphp

    <div class="event-view-shell">
        <section class="event-summary-card">
            <div class="event-summary-top">
                <div class="event-summary-heading">
                    <h2>{{ optional($eventDetail->event)->heading ?? 'Event Details' }}</h2>
                    <p>{{ $eventDetail->event_short_description ?? 'Manage and review key information for this event.' }}</p>
                </div>
                <div class="event-badge-group">
                    <span class="event-badge">
                        <i class="fas fa-tag"></i>{{ $eventDetail->event_type ?? 'General' }}
                    </span>
                    <span class="event-badge">
                        <i class="fas fa-{{ $eventDetail->event_mode === 'online' ? 'globe' : 'map-marker-alt' }}"></i>
                        {{ $eventDetail->event_mode ? ucfirst($eventDetail->event_mode) : 'Mode Not Set' }}
                    </span>
                    @if($eventDetail->city)
                        <span class="event-badge">
                            <i class="fas fa-city"></i>{{ $eventDetail->city }}
                        </span>
                    @endif
                </div>
            </div>

            <div class="event-highlight">
                <div class="event-highlight-card">
                    <span>Starting Date</span>
                    <strong>{{ $eventDetail->starting_date ? $eventDetail->starting_date->format('l, F j, Y') : 'Not Scheduled' }}</strong>
                </div>
                <div class="event-highlight-card">
                    <span>Starting Fees</span>
                    <strong class="text-success">₹{{ number_format($eventDetail->starting_fees, 2) }}</strong>
                </div>
                <div class="event-highlight-card">
                    <span>Created On</span>
                    <strong>{{ $eventDetail->created_at ? $eventDetail->created_at->format('M d, Y') : 'N/A' }}</strong>
                </div>
            </div>
        </section>

        <section class="event-info-section">
            <header>
                <h3>Key Information</h3>
            </header>
            <div class="event-info-grid">
                <div class="event-info-item">
                    <span>Event Name</span>
                    <strong>{{ optional($eventDetail->event)->heading ?? 'N/A' }}</strong>
                </div>
                <div class="event-info-item">
                    <span>Event Type</span>
                    <strong>{{ $eventDetail->event_type ?? 'N/A' }}</strong>
                </div>
                <div class="event-info-item">
                    <span>Event Mode</span>
                    @if($eventDetail->event_mode)
                        <span class="badge badge-{{ $eventDetail->event_mode === 'online' ? 'info' : 'warning' }}">
                            <i class="fas fa-{{ $eventDetail->event_mode === 'online' ? 'globe' : 'map-marker-alt' }} mr-1"></i>
                            {{ ucfirst($eventDetail->event_mode) }}
                        </span>
                    @else
                        <strong class="text-muted">Not Specified</strong>
                    @endif
                </div>
                <div class="event-info-item">
                    <span>City</span>
                    <strong>{{ $eventDetail->city ?? 'N/A' }}</strong>
                </div>
            </div>

            <div>
                <div class="event-section-title">
                    <i class="fas fa-align-left"></i>
                    Event Details
                </div>
                <div class="event-details-box">
                    {!! nl2br(e($eventDetail->event_details ?? 'No additional details provided.')) !!}
                </div>
            </div>
        </section>

        @if(is_array($bannerImages) && count($bannerImages))
            <section class="event-info-section">
                <div class="event-section-title">
                    <i class="fas fa-images"></i>
                    Banner Images
                </div>
                <div class="event-media-grid">
                    @foreach($bannerImages as $image)
                        <img src="{{ asset('storage/' . $image) }}" alt="Banner Image">
                    @endforeach
                </div>
            </section>
        @endif

        @if(is_array($galleryImages) && count($galleryImages))
            <section class="event-info-section">
                <div class="event-section-title">
                    <i class="fas fa-photo-video"></i>
                    Gallery Images
                </div>
                <div class="event-media-grid">
                    @foreach($galleryImages as $image)
                        <img src="{{ asset('storage/' . $image) }}" alt="Gallery Image">
                    @endforeach
                </div>
            </section>
        @endif

        <section class="event-info-section">
            <div class="event-action-bar">
                <a href="{{ route('professional.event-details.edit', $eventDetail) }}" class="btn btn-primary">
                    <i class="fas fa-edit"></i> Edit Event Details
                </a>
                <a href="{{ route('professional.event-details.index') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left"></i> Back to List
                </a>
                <form action="{{ route('professional.event-details.destroy', $eventDetail) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this event detail? This action cannot be undone.')" class="ml-auto">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-outline-danger">
                        <i class="fas fa-trash"></i> Delete Event Details
                    </button>
                </form>
            </div>
        </section>
    </div>
</div>
@endsection