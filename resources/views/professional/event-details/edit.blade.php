@extends('professional.layout.layout')

@section('styles')
<style>
    .event-edit-wrapper {
        padding: 2.5rem 2.4rem 3rem;
        background: #f9fafc;
    }

    .event-edit-shell {
        display: flex;
        flex-direction: column;
        gap: 2rem;
    }

    .event-editor-card {
        background: #ffffff;
        border-radius: 26px;
        border: 1px solid rgba(203, 213, 225, 0.6);
        box-shadow: 0 28px 60px rgba(15, 23, 42, 0.12);
        padding: 2.1rem 2.2rem 2.4rem;
        display: flex;
        flex-direction: column;
        gap: 2rem;
    }

    .event-editor-head {
        display: flex;
        flex-wrap: wrap;
        align-items: flex-start;
        justify-content: space-between;
        gap: 1.4rem;
    }

    .event-editor-head h2 {
        margin: 0;
        font-size: 1.45rem;
        font-weight: 700;
        color: #0f172a;
    }

    .event-editor-head p {
        margin: 0.4rem 0 0;
        color: #475569;
        font-size: 0.94rem;
        max-width: 520px;
    }

    .event-edit-summary {
        background: linear-gradient(135deg, rgba(59, 130, 246, 0.14), rgba(37, 99, 235, 0.16));
        border: 1px solid rgba(59, 130, 246, 0.26);
        border-radius: 22px;
        padding: 1.8rem 1.9rem;
        display: flex;
        flex-direction: column;
        gap: 1.4rem;
        box-shadow: 0 20px 44px rgba(15, 23, 42, 0.18);
    }

    .event-edit-summary-top {
        display: flex;
        flex-wrap: wrap;
        align-items: flex-start;
        justify-content: space-between;
        gap: 1.3rem;
    }

    .event-edit-summary-heading h3 {
        margin: 0;
        font-size: 1.28rem;
        font-weight: 700;
        color: #0f172a;
    }

    .event-edit-summary-heading span {
        display: block;
        margin-top: 0.35rem;
        color: rgba(15, 23, 42, 0.82);
        font-size: 0.94rem;
    }

    .event-edit-badges {
        display: flex;
        flex-wrap: wrap;
        gap: 0.55rem;
        align-items: center;
    }

    .event-edit-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.45rem;
        padding: 0.42rem 0.95rem;
        border-radius: 999px;
        background: rgba(255, 255, 255, 0.78);
        border: 1px solid rgba(255, 255, 255, 0.86);
        color: #1e293b;
        font-weight: 600;
        font-size: 0.8rem;
        letter-spacing: 0.06em;
        text-transform: uppercase;
    }

    .event-edit-highlight {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
        gap: 1rem;
    }

    .event-edit-highlight-card {
        background: rgba(255, 255, 255, 0.88);
        border: 1px solid rgba(148, 163, 184, 0.3);
        border-radius: 18px;
        padding: 1rem 1.15rem;
        display: flex;
        flex-direction: column;
        gap: 0.45rem;
        box-shadow: 0 16px 32px rgba(15, 23, 42, 0.12);
    }

    .event-edit-highlight-card span {
        font-size: 0.76rem;
        font-weight: 600;
        color: #64748b;
        letter-spacing: 0.08em;
        text-transform: uppercase;
    }

    .event-edit-highlight-card strong {
        font-size: 1.05rem;
        color: #0f172a;
    }

    .event-editor-actions {
        display: inline-flex;
        gap: 0.6rem;
        flex-wrap: wrap;
    }

    .event-editor-actions .btn {
        border-radius: 12px;
        padding: 0.6rem 1.1rem;
        font-weight: 600;
        font-size: 0.86rem;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }

    .form-section {
        border-radius: 22px;
        border: 1px solid rgba(226, 232, 240, 0.55);
        background: rgba(255, 255, 255, 0.96);
        padding: 1.7rem 1.9rem;
        display: flex;
        flex-direction: column;
        gap: 1.2rem;
        box-shadow: 0 12px 28px rgba(15, 23, 42, 0.1);
    }

    .form-section header {
        display: flex;
        align-items: center;
        gap: 0.8rem;
    }

    .form-section header h3 {
        margin: 0;
        font-size: 1.05rem;
        font-weight: 700;
        color: #0f172a;
    }

    .form-section header i {
        color: #3b82f6;
        font-size: 1rem;
    }

    .form-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
        gap: 1.4rem 1.6rem;
    }

    .form-media-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(120px, 1fr));
        gap: 1rem;
    }

    .form-media-grid img {
        width: 100%;
        aspect-ratio: 4 / 3.1;
        object-fit: cover;
        border-radius: 14px;
        border: 1px solid rgba(148, 163, 184, 0.32);
        box-shadow: 0 12px 26px rgba(15, 23, 42, 0.14);
    }

    .form-label {
        font-weight: 600;
        color: #0f172a;
        font-size: 0.92rem;
        margin-bottom: 0.4rem;
    }

    .form-control,
    .form-select,
    textarea.form-control {
        border-radius: 14px;
        border: 1px solid rgba(203, 213, 225, 0.9);
        padding: 0.85rem 1.05rem;
        transition: border 0.2s ease, box-shadow 0.2s ease;
    }

    .form-control:focus,
    .form-select:focus,
    textarea.form-control:focus {
        border-color: #3b82f6;
        box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.18);
    }

    .form-text {
        color: #64748b;
        font-size: 0.78rem;
        margin-top: 0.45rem;
    }

    .editor-action-bar {
        display: flex;
        flex-wrap: wrap;
        gap: 0.85rem;
        align-items: center;
        margin-top: 0.4rem;
    }

    .editor-action-bar .btn {
        border-radius: 14px;
        padding: 0.78rem 1.55rem;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 0.6rem;
    }

    @media (max-width: 1024px) {
        .event-edit-wrapper {
            padding: 2rem 1.6rem 2.6rem;
        }

        .event-editor-card {
            padding: 1.9rem 1.8rem;
        }

        .form-section {
            padding: 1.5rem 1.6rem;
        }
    }

    @media (max-width: 768px) {
        .event-edit-wrapper {
            padding: 1.6rem 1.2rem 2.2rem;
        }

        .event-editor-head {
            flex-direction: column;
            align-items: flex-start;
        }

        .event-editor-actions {
            width: 100%;
        }

        .event-editor-actions .btn {
            flex: 1;
            justify-content: center;
        }

        .form-grid {
            grid-template-columns: 1fr;
        }

        .editor-action-bar {
            flex-direction: column;
            align-items: stretch;
        }

        .event-edit-summary {
            padding: 1.4rem 1.45rem;
        }

        .event-edit-highlight {
            grid-template-columns: 1fr;
        }

        .editor-action-bar .btn {
            justify-content: center;
        }
    }
</style>
@endsection

@section('content')
<div class="content-wrapper event-edit-wrapper">
    <div class="page-header">
        <ul class="breadcrumb">
            <li>Home</li>
            <li><a href="{{ route('professional.event-details.index') }}">Event Details</a></li>
            <li class="active">Edit</li>
        </ul>
    </div>

    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @php
        $bannerImages = $eventDetail->banner_image ? json_decode($eventDetail->banner_image, true) : [];
        $galleryImages = $eventDetail->event_gallery ? json_decode($eventDetail->event_gallery, true) : [];
        $bannerCount = is_array($bannerImages) ? count($bannerImages) : 0;
        $galleryCount = is_array($galleryImages) ? count($galleryImages) : 0;
    @endphp

    <div class="event-edit-shell">
        <section class="event-editor-card">
            <div class="event-editor-head">
                <div>
                    <h2>Edit Event Details</h2>
                    <p>Update the event information, media, and logistics. Changes are reflected across the professional portal immediately.</p>
                </div>
                <div class="event-editor-actions">
                    <a href="{{ route('professional.event-details.index') }}" class="btn btn-light">
                        <i class="fas fa-list"></i> Back to List
                    </a>
                    <a href="{{ route('professional.event-details.show', $eventDetail) }}" class="btn btn-outline-primary">
                        <i class="fas fa-eye"></i> View Details
                    </a>
                </div>
            </div>
            <span class="text-muted" style="font-size: 0.88rem;">Editing details for “{{ $eventDetail->event->heading ?? 'Event' }}”</span>

            <section class="event-edit-summary">
                <div class="event-edit-summary-top">
                    <div class="event-edit-summary-heading">
                        <h3>{{ $eventDetail->event->heading ?? 'Event Title Not Set' }}</h3>
                        <span>{{ $eventDetail->event_short_description ?? 'Keep your attendees informed by maintaining accurate event information.' }}</span>
                    </div>
                    <div class="event-edit-badges">
                        <span class="event-edit-badge">
                            <i class="fas fa-tag"></i>{{ $eventDetail->event_type ?? 'Uncategorised' }}
                        </span>
                        <span class="event-edit-badge">
                            <i class="fas fa-{{ $eventDetail->event_mode === 'online' ? 'globe' : 'map-marker-alt' }}"></i>
                            {{ $eventDetail->event_mode ? ucfirst($eventDetail->event_mode) : 'Mode Not Set' }}
                        </span>
                        @if($eventDetail->city)
                            <span class="event-edit-badge">
                                <i class="fas fa-city"></i>{{ $eventDetail->city }}
                            </span>
                        @endif
                    </div>
                </div>
                <div class="event-edit-highlight">
                    <div class="event-edit-highlight-card">
                        <span>Starting Date</span>
                        <strong>{{ $eventDetail->starting_date ? $eventDetail->starting_date->format('l, F j, Y') : 'Not Scheduled' }}</strong>
                    </div>
                    <div class="event-edit-highlight-card">
                        <span>Starting Fees</span>
                        <strong class="text-success">₹{{ number_format($eventDetail->starting_fees, 2) }}</strong>
                    </div>
                    <div class="event-edit-highlight-card">
                        <span>Banner Images</span>
                        <strong>{{ $bannerCount }} {{ \Illuminate\Support\Str::plural('image', $bannerCount) }}</strong>
                    </div>
                    <div class="event-edit-highlight-card">
                        <span>Gallery Images</span>
                        <strong>{{ $galleryCount }} {{ \Illuminate\Support\Str::plural('image', $galleryCount) }}</strong>
                    </div>
                </div>
            </section>

            <form action="{{ route('professional.event-details.update', $eventDetail) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <section class="form-section">
                    <header>
                        <i class="fas fa-info-circle"></i>
                        <h3>Essential Information</h3>
                    </header>
                    <div class="form-grid">
                        <div class="form-group">
                            <label class="form-label">Event</label>
                            <input type="hidden" name="event_id" value="{{ $eventDetail->event_id }}">
                            <input type="text" class="form-control" value="{{ $eventDetail->event->heading ?? 'N/A' }} — {{ $eventDetail->event->date ? \Carbon\Carbon::parse($eventDetail->event->date)->format('M d, Y') : 'No date' }}" readonly>
                            <div class="form-text">Event cannot be changed when editing details.</div>
                        </div>
                        <div class="form-group">
                            <label for="event_type" class="form-label">Event Type <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="event_type" name="event_type" value="{{ old('event_type', $eventDetail->event_type) }}" required placeholder="e.g., Workshop, Webinar, Conference">
                        </div>
                        <div class="form-group">
                            <label for="starting_date" class="form-label">Starting Date <span class="text-danger">*</span></label>
                            <input type="date" class="form-control" id="starting_date" name="starting_date" value="{{ old('starting_date', $eventDetail->starting_date ? $eventDetail->starting_date->format('Y-m-d') : '') }}" required>
                        </div>
                        <div class="form-group">
                            <label for="starting_fees" class="form-label">Starting Fees (₹) <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" id="starting_fees" name="starting_fees" value="{{ old('starting_fees', $eventDetail->starting_fees) }}" min="0" step="0.01" required>
                        </div>
                        <div class="form-group">
                            <label for="event_mode" class="form-label">Event Mode <span class="text-danger">*</span></label>
                            <select class="form-select" id="event_mode" name="event_mode" required>
                                <option value="">Select event mode...</option>
                                <option value="online" {{ old('event_mode', $eventDetail->event_mode) === 'online' ? 'selected' : '' }}>Online</option>
                                <option value="offline" {{ old('event_mode', $eventDetail->event_mode) === 'offline' ? 'selected' : '' }}>Offline</option>
                            </select>
                            <div class="form-text">Choose how attendees will participate.</div>
                        </div>
                        <div class="form-group" id="city_field" style="display: none;">
                            <label for="city" class="form-label">City <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="city" name="city" value="{{ old('city', $eventDetail->city) }}" placeholder="Enter city name">
                            <div class="form-text">Required for offline events.</div>
                        </div>
                    </div>
                </section>

                <section class="form-section">
                    <header>
                        <i class="fas fa-align-left"></i>
                        <h3>Event Description</h3>
                    </header>
                    <div class="form-group">
                        <label for="event_details" class="form-label">Event Details <span class="text-danger">*</span></label>
                        <textarea class="form-control" id="event_details" name="event_details" rows="6" required placeholder="Provide detailed information about the event, agenda, what participants will learn, etc.">{{ old('event_details', $eventDetail->event_details) }}</textarea>
                    </div>
                </section>

                <section class="form-section">
                    <header>
                        <i class="fas fa-image"></i>
                        <h3>Banner Images</h3>
                    </header>
                    @if(is_array($bannerImages) && count($bannerImages))
                        <div class="form-media-grid">
                            @foreach($bannerImages as $image)
                                <img src="{{ asset('storage/' . $image) }}" alt="Current Banner">
                            @endforeach
                        </div>
                    @else
                        <div class="text-muted" style="font-size: 0.9rem;">No banner images uploaded yet.</div>
                    @endif
                    <div class="form-group">
                        <label for="banner_image" class="form-label">Replace Banner Images (Optional)</label>
                        <input type="file" class="form-control" id="banner_image" name="banner_image[]" multiple accept="image/*">
                        <div class="form-text">Leave empty to keep current images. Upload new images to replace all current banner images (JPG, PNG, WebP, max 2MB each).</div>
                    </div>
                </section>

                <section class="form-section">
                    <header>
                        <i class="fas fa-photo-video"></i>
                        <h3>Gallery Images</h3>
                    </header>
                    @if(is_array($galleryImages) && count($galleryImages))
                        <div class="form-media-grid">
                            @foreach($galleryImages as $image)
                                <img src="{{ asset('storage/' . $image) }}" alt="Current Gallery Image">
                            @endforeach
                        </div>
                    @else
                        <div class="text-muted" style="font-size: 0.9rem;">No gallery images uploaded yet.</div>
                    @endif
                    <div class="form-group">
                        <label for="event_gallery" class="form-label">Replace Gallery Images (Optional)</label>
                        <input type="file" class="form-control" id="event_gallery" name="event_gallery[]" multiple accept="image/*">
                        <div class="form-text">Leave empty to keep current images. Upload new images to replace all current gallery images (JPG, PNG, WebP, max 2MB each).</div>
                    </div>
                </section>

                <div class="editor-action-bar">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Update Event Details
                    </button>
                    <a href="{{ route('professional.event-details.show', $eventDetail) }}" class="btn btn-outline-secondary">
                        <i class="fas fa-eye"></i> View Details
                    </a>
                    <a href="{{ route('professional.event-details.index') }}" class="btn btn-light">
                        <i class="fas fa-arrow-left"></i> Back to List
                    </a>
                </div>
            </form>
        </section>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const eventModeSelect = document.getElementById('event_mode');
    const cityField = document.getElementById('city_field');
    const cityInput = document.getElementById('city');

    function toggleCityField() {
        if (eventModeSelect.value === 'offline') {
            cityField.style.display = 'block';
            cityInput.required = true;
        } else {
            cityField.style.display = 'none';
            cityInput.required = false;
        }
    }

    eventModeSelect.addEventListener('change', toggleCityField);
    toggleCityField();
});
</script>
@endsection