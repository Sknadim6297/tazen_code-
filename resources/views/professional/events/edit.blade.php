@extends('professional.layout.layout')

@section('styles')
<style>
    :root {
        --primary: #4f46e5;
        --primary-dark: #4338ca;
        --secondary: #0ea5e9;
        --accent: #22c55e;
        --danger: #ef4444;
        --warning: #f97316;
        --surface: #ffffff;
        --muted: #64748b;
        --border: rgba(148, 163, 184, 0.22);
        --page-bg: #f5f7fb;
    }

    body,
    .app-content {
        background: var(--page-bg);
    }

    .events-edit-page {
        width: 100%;
        padding: 2.6rem 1.4rem 3.6rem;
    }

    .events-edit-shell {
        max-width: 1100px;
        margin: 0 auto;
        display: flex;
        flex-direction: column;
        gap: 2rem;
    }

    .events-edit-hero {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        justify-content: space-between;
        gap: 1.4rem;
        padding: 2.1rem 2.4rem;
        border-radius: 28px;
        background: linear-gradient(135deg, rgba(79, 70, 229, 0.12), rgba(14, 165, 233, 0.14));
        border: 1px solid rgba(79, 70, 229, 0.18);
        position: relative;
        overflow: hidden;
        box-shadow: 0 24px 54px rgba(79, 70, 229, 0.16);
    }

    .events-edit-hero::before,
    .events-edit-hero::after {
        content: "";
        position: absolute;
        border-radius: 50%;
        pointer-events: none;
    }

    .events-edit-hero::before {
        width: 340px;
        height: 340px;
        top: -48%;
        right: -14%;
        background: rgba(79, 70, 229, 0.2);
    }

    .events-edit-hero::after {
        width: 240px;
        height: 240px;
        bottom: -45%;
        left: -12%;
        background: rgba(14, 165, 233, 0.18);
    }

    .events-edit-hero > * {
        position: relative;
        z-index: 1;
    }

    .hero-meta {
        display: flex;
        flex-direction: column;
        gap: 0.75rem;
        color: var(--muted);
    }

    .hero-meta .hero-eyebrow {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.4rem 1.05rem;
        border-radius: 999px;
        background: rgba(255, 255, 255, 0.38);
        border: 1px solid rgba(255, 255, 255, 0.6);
        font-size: 0.76rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.14em;
        color: #0f172a;
    }

    .hero-meta h1 {
        margin: 0;
        font-size: 2.05rem;
        font-weight: 700;
        color: #0f172a;
    }

    .breadcrumb-sm {
        display: flex;
        flex-wrap: wrap;
        gap: 0.6rem;
        padding: 0;
        margin: 0;
        list-style: none;
        font-size: 0.86rem;
        color: var(--muted);
    }

    .breadcrumb-sm li a {
        color: var(--primary);
        text-decoration: none;
    }

    .status-chip {
        display: inline-flex;
        align-items: center;
        gap: 0.45rem;
        padding: 0.5rem 1rem;
        border-radius: 999px;
        font-weight: 600;
        font-size: 0.82rem;
        letter-spacing: 0.04em;
        background: rgba(79, 70, 229, 0.12);
        color: var(--primary-dark);
    }

    .status-chip.pending { background: rgba(250, 204, 21, 0.2); color: #a16207; }
    .status-chip.approved { background: rgba(34, 197, 94, 0.2); color: #15803d; }
    .status-chip.rejected { background: rgba(248, 113, 113, 0.2); color: #b91c1c; }

    .events-edit-card {
        background: var(--surface);
        border-radius: 24px;
        border: 1px solid var(--border);
        box-shadow: 0 20px 48px rgba(15, 23, 42, 0.14);
        overflow: hidden;
    }

    .events-edit-card__head {
        padding: 1.8rem 2.3rem 1.2rem;
        border-bottom: 1px solid rgba(148, 163, 184, 0.2);
        display: flex;
        flex-direction: column;
        gap: 0.35rem;
    }

    .events-edit-card__head h2 {
        margin: 0;
        font-size: 1.2rem;
        font-weight: 700;
        color: #0f172a;
    }

    .events-edit-card__head p {
        margin: 0;
        color: var(--muted);
        font-size: 0.92rem;
    }

    .events-edit-card__body {
        padding: 2.1rem 2.3rem;
        display: flex;
        flex-direction: column;
        gap: 1.9rem;
    }

    .alert-modern {
        padding: 1.15rem 1.3rem;
        border-radius: 16px;
        border: 1px solid rgba(15, 23, 42, 0.08);
        display: flex;
        gap: 0.85rem;
        align-items: flex-start;
    }

    .alert-modern i {
        font-size: 1.35rem;
    }

    .alert-modern strong {
        display: block;
        margin-bottom: 0.35rem;
    }

    .alert-warning-modern { background: rgba(250, 204, 21, 0.12); color: #a16207; }
    .alert-info-modern { background: rgba(59, 130, 246, 0.12); color: #1d4ed8; }
    .alert-danger-modern { background: rgba(248, 113, 113, 0.12); color: #b91c1c; }

    .edit-form {
        display: flex;
        flex-direction: column;
        gap: 1.8rem;
    }

    .form-section {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
        gap: 1.6rem;
    }

    .form-section.full {
        grid-template-columns: 1fr;
    }

    .form-section-title {
        font-size: 0.92rem;
        text-transform: uppercase;
        letter-spacing: 0.12em;
        color: var(--muted);
        font-weight: 600;
    }

    .form-group-custom {
        display: flex;
        flex-direction: column;
        gap: 0.55rem;
    }

    .form-group-custom label {
        font-weight: 600;
        color: #0f172a;
        font-size: 0.92rem;
    }

    .form-group-custom .form-text {
        font-size: 0.78rem;
        color: var(--muted);
    }

    .form-control-custom {
        border-radius: 14px !important;
        border: 1px solid rgba(148, 163, 184, 0.35);
        padding: 0.75rem 1rem;
        font-size: 0.94rem;
        transition: border 0.2s ease, box-shadow 0.2s ease;
    }

    .form-control-custom:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.12);
    }

    textarea.form-control-custom {
        min-height: 180px;
        resize: vertical;
    }

    .image-preview {
        display: flex;
        align-items: center;
        gap: 1rem;
        flex-wrap: wrap;
    }

    .current-image,
    .preview-image {
        width: 140px;
        height: 140px;
        border-radius: 22px;
        overflow: hidden;
        box-shadow: 0 12px 28px rgba(15, 23, 42, 0.16);
        border: 1px solid rgba(148, 163, 184, 0.2);
        background: #f8fafc;
    }

    .current-image img,
    .preview-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .form-footer {
        margin-top: 0.5rem;
        display: flex;
        flex-wrap: wrap;
        justify-content: space-between;
        gap: 1rem;
        align-items: center;
    }

    .form-footer-actions {
        display: inline-flex;
        gap: 0.8rem;
        flex-wrap: wrap;
    }

    .btn-secondary-ghost,
    .btn-neutral,
    .btn-primary-pill {
        display: inline-flex;
        align-items: center;
        gap: 0.45rem;
        border-radius: 999px;
        padding: 0.85rem 1.6rem;
        font-weight: 600;
        text-decoration: none;
        cursor: pointer;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
        border: none;
    }

    .btn-secondary-ghost {
        background: rgba(226, 232, 240, 0.6);
        color: #0f172a;
    }

    .btn-neutral {
        background: rgba(148, 163, 184, 0.16);
        color: #0f172a;
        border: 1px solid rgba(148, 163, 184, 0.35);
    }

    .btn-primary-pill {
        background: linear-gradient(135deg, var(--primary), var(--primary-dark));
        color: #ffffff;
        box-shadow: 0 18px 38px rgba(79, 70, 229, 0.2);
    }

    .btn-secondary-ghost:hover,
    .btn-neutral:hover,
    .btn-primary-pill:hover {
        transform: translateY(-1px);
    }

    .char-count {
        font-size: 0.78rem;
        color: var(--muted);
    }

    .admin-notes {
        background: rgba(248, 113, 113, 0.12);
        border: 1px dashed rgba(248, 113, 113, 0.45);
        border-radius: 16px;
        padding: 1rem 1.15rem;
        color: #b91c1c;
        margin-top: 0.75rem;
        font-size: 0.9rem;
    }

    @media (max-width: 768px) {
        .events-edit-page {
            padding: 2.2rem 1rem 3.2rem;
        }

        .events-edit-hero {
            padding: 1.7rem 1.6rem;
        }

        .events-edit-card__body {
            padding: 1.7rem 1.6rem;
        }

        .form-footer {
            flex-direction: column;
            align-items: stretch;
        }

        .form-footer-actions {
            width: 100%;
        }

        .btn-secondary-ghost,
        .btn-neutral,
        .btn-primary-pill {
            width: 100%;
            justify-content: center;
        }
    }
</style>
@endsection

@section('content')
<div class="content-wrapper events-edit-page">
    <div class="events-edit-shell">
        <section class="events-edit-hero">
            <div class="hero-meta">
                <span class="hero-eyebrow"><i class="ri-edit-line"></i>Edit Event</span>
                <h1>{{ $event->heading }}</h1>
                <ul class="breadcrumb-sm">
                    <li><a href="{{ route('professional.dashboard') }}">Dashboard</a></li>
                    <li><a href="{{ route('professional.events.index') }}">Events</a></li>
                    <li><a href="{{ route('professional.events.show', $event->id) }}">{{ \Illuminate\Support\Str::limit($event->heading, 26) }}</a></li>
                    <li class="active" aria-current="page">Edit</li>
                </ul>
            </div>
            <div>
                <span class="status-chip {{ $event->status }}">
                    @if($event->status === 'pending')
                        <i class="ri-time-line"></i> Pending
                    @elseif($event->status === 'approved')
                        <i class="ri-checkbox-circle-line"></i> Approved
                    @else
                        <i class="ri-close-circle-line"></i> Rejected
                    @endif
                </span>
            </div>
        </section>

        <article class="events-edit-card">
            <header class="events-edit-card__head">
                <h2>Update Event Details</h2>
                <p>Refresh your event information, update the visuals, or tweak the schedule without altering any logic.</p>
            </header>
            <div class="events-edit-card__body">
                @if($event->status === 'approved')
                    <div class="alert-modern alert-warning-modern">
                        <i class="ri-information-line"></i>
                        <div>
                            <strong>Heads up!</strong>
                            This event is currently approved. Saving changes will move it back to pending status for admin review.
                        </div>
                    </div>
                @elseif($event->status === 'rejected')
                    <div class="alert-modern alert-danger-modern">
                        <i class="ri-error-warning-line"></i>
                        <div>
                            <strong>Action Required</strong>
                            Update the event using the feedback below and resubmit for approval.
                            @if($event->admin_notes)
                                <div class="admin-notes"><strong>Admin Notes:</strong> {{ $event->admin_notes }}</div>
                            @endif
                        </div>
                    </div>
                @else
                    <div class="alert-modern alert-info-modern">
                        <i class="ri-lightbulb-line"></i>
                        <div>
                            <strong>Quick reminder</strong>
                            Pending events are editable. Ensure the event date is not in the past and all required fields are complete.
                        </div>
                    </div>
                @endif

                <form class="edit-form" action="{{ route('professional.events.update', $event->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="form-section full">
                        <div class="form-group-custom">
                            <span class="form-section-title">Current Artwork</span>
                            <div class="image-preview">
                                <div class="current-image">
                                    <img src="{{ asset('storage/' . $event->card_image) }}" alt="Current event image">
                                </div>
                                <div class="form-group-custom" style="gap:0.4rem;">
                                    <label for="card_image">Upload New Image</label>
                                    <input type="file" class="form-control form-control-custom @error('card_image') is-invalid @enderror" id="card_image" name="card_image" accept="image/*">
                                    <span class="form-text">Optional — keep empty to retain current image. JPEG/PNG/GIF up to 2MB.</span>
                                    @error('card_image')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                    <div id="imagePreview" class="preview-image" style="display:none;">
                                        <img id="previewImg" src="" alt="New image preview">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-section">
                        <div class="form-group-custom">
                            <label for="date">Event Date <span class="text-danger">*</span></label>
                            <input type="date" class="form-control form-control-custom @error('date') is-invalid @enderror" id="date" name="date" value="{{ old('date', $event->date) }}" min="{{ date('Y-m-d') }}" required>
                            @error('date')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group-custom">
                            <label for="starting_fees">Starting Fees (₹) <span class="text-danger">*</span></label>
                            <input type="number" class="form-control form-control-custom @error('starting_fees') is-invalid @enderror" id="starting_fees" name="starting_fees" value="{{ old('starting_fees', $event->starting_fees) }}" min="0" step="0.01" placeholder="0.00" required>
                            <span class="form-text">Enter the base price participants will see.</span>
                            @error('starting_fees')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-section">
                        <div class="form-group-custom">
                            <label for="mini_heading">Event Type <span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-custom @error('mini_heading') is-invalid @enderror" id="mini_heading" name="mini_heading" value="{{ old('mini_heading', $event->mini_heading) }}" maxlength="100" placeholder="Workshop, Seminar, Masterclass..." required>
                            <span class="form-text">Keep this short and descriptive (max 100 characters).</span>
                            @error('mini_heading')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group-custom">
                            <label for="heading">Event Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-custom @error('heading') is-invalid @enderror" id="heading" name="heading" value="{{ old('heading', $event->heading) }}" maxlength="150" placeholder="Enter the main event title" required>
                            <span class="form-text">Displayed as the headline on listings and cards.</span>
                            @error('heading')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-section full">
                        <div class="form-group-custom">
                            <label for="short_description">Event Description <span class="text-danger">*</span></label>
                            <textarea class="form-control form-control-custom @error('short_description') is-invalid @enderror" id="short_description" name="short_description" maxlength="1000" rows="6" placeholder="Describe the experience, agenda, and key outcomes." required>{{ old('short_description', $event->short_description) }}</textarea>
                            <div class="form-text"><span id="charCount">{{ strlen(old('short_description', $event->short_description)) }}</span>/1000 characters</div>
                            @error('short_description')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <footer class="form-footer">
                        <a href="{{ route('professional.events.show', $event->id) }}" class="btn-secondary-ghost">
                            <i class="ri-arrow-left-line"></i>
                            Back to Event
                        </a>
                        <div class="form-footer-actions">
                            <a href="{{ route('professional.events.index') }}" class="btn-neutral">
                                <i class="ri-close-line"></i>
                                Cancel
                            </a>
                            <button type="submit" class="btn-primary-pill">
                                <i class="ri-save-line"></i>
                                @if($event->status === 'rejected') Resubmit for Approval @else Update Event @endif
                            </button>
                        </div>
                    </footer>
                </form>
            </div>
        </article>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const imageInput = document.getElementById('card_image');
    const previewWrapper = document.getElementById('imagePreview');
    const previewImg = document.getElementById('previewImg');
    const description = document.getElementById('short_description');
    const charCount = document.getElementById('charCount');
    const form = document.querySelector('.edit-form');

    if (imageInput) {
        imageInput.addEventListener('change', (event) => {
            const file = event.target.files[0];
            if (!file) {
                previewWrapper.style.display = 'none';
                previewImg.src = '';
                return;
            }

            const reader = new FileReader();
            reader.onload = (e) => {
                previewImg.src = e.target.result;
                previewWrapper.style.display = 'block';
            };
            reader.readAsDataURL(file);
        });
    }

    const updateCounter = () => {
        if (!description || !charCount) return;
        const count = description.value.length;
        charCount.textContent = count;

        charCount.style.color = count >= 960 ? '#b91c1c' : count >= 820 ? '#b45309' : '#64748b';
        charCount.style.fontWeight = count >= 820 ? '700' : '500';
    };

    description?.addEventListener('input', updateCounter);
    updateCounter();

    form?.addEventListener('submit', (e) => {
        if ('{{ $event->status }}' === 'approved') {
            const confirmMessage = 'Editing this approved event will move it back to pending for admin approval. Continue?';
            if (!confirm(confirmMessage)) {
                e.preventDefault();
                return;
            }
        }

        const requiredFields = form.querySelectorAll('[required]');
        let isValid = true;

        requiredFields.forEach((field) => {
            if (!field.value.trim()) {
                field.classList.add('is-invalid');
                isValid = false;
            } else {
                field.classList.remove('is-invalid');
            }
        });

        if (!isValid) {
            e.preventDefault();
            alert('Please complete all required fields before submitting.');
        }
    });
});
</script>
@endsection