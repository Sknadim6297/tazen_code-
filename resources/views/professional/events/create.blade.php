@extends('professional.layout.layout')

@section('styles')
<style>
    :root {
        --primary: #4f46e5;
        --primary-dark: #4338ca;
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

    .events-create-page {
        width: 100%;
        padding: 2.6rem 1.4rem 3.4rem;
    }

    .events-shell {
        max-width: 1080px;
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
        gap: 1.3rem;
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
        width: 300px;
        height: 300px;
        top: -45%;
        right: -14%;
        background: rgba(79, 70, 229, 0.18);
    }

    .events-header::after {
        width: 200px;
        height: 200px;
        bottom: -42%;
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

    .events-card {
        border-radius: 24px;
        border: 1px solid var(--border);
        background: var(--card-bg);
        box-shadow: 0 20px 44px rgba(15, 23, 42, 0.12);
        overflow: hidden;
    }

    .events-card__head {
        padding: 1.8rem 2.3rem 1.4rem;
        border-bottom: 1px solid rgba(148, 163, 184, 0.18);
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 1rem;
    }

    .events-card__head h3 {
        margin: 0;
        font-size: 1.25rem;
        font-weight: 700;
        color: var(--text-dark);
        display: flex;
        align-items: center;
        gap: 0.6rem;
    }

    .events-card__head h3 i {
        color: var(--primary);
    }

    .draft-pill {
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        padding: 0.4rem 0.9rem;
        border-radius: 999px;
        background: rgba(14, 165, 233, 0.1);
        color: #0c4a6e;
        font-size: 0.78rem;
        font-weight: 600;
    }

    .events-card__body {
        padding: 2.15rem 2.3rem;
        display: flex;
        flex-direction: column;
        gap: 1.8rem;
    }

    .info-alert {
        border-radius: 18px;
        border: 1px solid rgba(59, 130, 246, 0.18);
        background: rgba(59, 130, 246, 0.08);
        padding: 1.2rem 1.4rem;
        color: var(--text-dark);
    }

    .info-alert h6 {
        margin: 0 0 0.6rem;
        font-size: 1rem;
        font-weight: 700;
        display: flex;
        align-items: center;
        gap: 0.45rem;
        color: var(--primary);
    }

    .info-alert ul {
        margin: 0;
        padding-left: 1.2rem;
        color: var(--text-muted);
    }

    .events-form {
        display: flex;
        flex-direction: column;
        gap: 1.5rem;
    }

    .form-section {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
        gap: 1.3rem;
    }

    .form-group {
        display: flex;
        flex-direction: column;
        gap: 0.55rem;
    }

    .form-label {
        font-size: 0.9rem;
        font-weight: 600;
        color: var(--text-dark);
        display: flex;
        align-items: center;
        gap: 0.4rem;
    }

    .form-control {
        border-radius: 12px;
        border: 1px solid rgba(148, 163, 184, 0.35);
        padding: 0.8rem 1rem;
        font-size: 0.95rem;
        color: var(--text-dark);
        transition: border-color 0.2s ease, box-shadow 0.2s ease;
    }

    .form-control:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.16);
        outline: none;
    }

    .form-text {
        font-size: 0.8rem;
        color: var(--text-muted);
    }

    #imagePreview {
        display: none;
        margin-top: 0.75rem;
    }

    #previewImg {
        max-width: 240px;
        border-radius: 14px;
        box-shadow: 0 12px 30px rgba(15, 23, 42, 0.15);
    }

    .form-actions {
        display: flex;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 1rem;
        padding-top: 1.4rem;
        border-top: 1px solid rgba(148, 163, 184, 0.15);
    }

    .btn {
        display: inline-flex;
        align-items: center;
        gap: 0.45rem;
        border-radius: 12px;
        padding: 0.8rem 1.6rem;
        font-weight: 600;
        border: none;
        cursor: pointer;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .btn-light {
        background: rgba(79, 70, 229, 0.08);
        color: var(--primary-dark);
        border: 1px solid rgba(79, 70, 229, 0.18);
    }

    .btn-primary {
        background: linear-gradient(135deg, var(--primary), var(--primary-dark));
        color: #ffffff;
        box-shadow: 0 16px 32px rgba(79, 70, 229, 0.22);
    }

    .btn:hover {
        transform: translateY(-1px);
    }

    .invalid-feedback {
        font-size: 0.8rem;
    }

    @media (max-width: 992px) {
        .events-page {
            padding: 2.2rem 1.1rem 3.1rem;
        }

        .events-card__body {
            padding: 1.8rem;
        }
    }

    @media (max-width: 768px) {
        .events-header {
            padding: 1.75rem 1.6rem;
        }

        .events-header h1 {
            font-size: 1.75rem;
        }

        .form-actions {
            flex-direction: column;
            align-items: stretch;
        }

        .form-actions .btn {
            width: 100%;
            justify-content: center;
        }
    }
</style>
@endsection

@section('content')
<div class="content-wrapper events-create-page">
    <div class="events-shell">
        <header class="events-header">
            <div>
                <span class="pretitle"><i class="ri-calendar-event-line"></i>Create Event</span>
                <h1>Launch A New Experience</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('professional.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('professional.events.index') }}">Events</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Create</li>
                    </ol>
                </nav>
            </div>
            <a href="{{ route('professional.events.index') }}" class="btn btn-light">
                <i class="ri-arrow-left-line"></i>
                Back to Events
            </a>
        </header>

        <section class="events-card">
            <div class="events-card__head">
                <h3><i class="ri-add-line"></i>Create New Event</h3>
                <span class="draft-pill">
                    <i class="ri-draft-line"></i>
                    Draft Mode
                </span>
            </div>
            <div class="events-card__body">
                <div class="info-alert" role="alert">
                    <h6><i class="ri-information-line"></i>Event Creation Guidelines</h6>
                    <ul class="mb-0">
                        <li>Your event will be reviewed by admin before going live.</li>
                        <li>Ensure all information is accurate and complete.</li>
                        <li>Event date must be today or in the future.</li>
                        <li>Upload a high-quality event image for better visibility.</li>
                    </ul>
                </div>

                <form class="events-form" action="{{ route('professional.events.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="form-section">
                        <div class="form-group">
                            <label for="card_image" class="form-label">Event Image <span class="text-danger">*</span></label>
                            <input type="file" class="form-control @error('card_image') is-invalid @enderror"
                                   id="card_image" name="card_image" accept="image/*" required>
                            <div class="form-text">Upload a high-quality image (JPEG, PNG, JPG, GIF). Max size: 2MB</div>
                            @error('card_image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div id="imagePreview">
                                <img id="previewImg" src="" alt="Preview">
                            </div>
                        </div>
                    </div>

                    <div class="form-section">
                        <div class="form-group">
                            <label for="date" class="form-label">Event Date <span class="text-danger">*</span></label>
                            <input type="date" class="form-control @error('date') is-invalid @enderror"
                                   id="date" name="date" min="{{ date('Y-m-d') }}"
                                   value="{{ old('date') }}" required>
                            @error('date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="time" class="form-label">Event Time <span class="text-danger">*</span></label>
                            <input type="time" class="form-control @error('time') is-invalid @enderror"
                                   id="time" name="time" value="{{ old('time') }}" required>
                            @error('time')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="starting_fees" class="form-label">Event Fees (₹) <span class="text-danger">*</span></label>
                            <input type="number" class="form-control @error('starting_fees') is-invalid @enderror"
                                   id="starting_fees" name="starting_fees" placeholder="Enter event fees"
                                   min="0" step="0.01" value="{{ old('starting_fees') }}" required>
                            @error('starting_fees')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="mini_heading" class="form-label">Event Type <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('mini_heading') is-invalid @enderror"
                               id="mini_heading" name="mini_heading" placeholder="e.g., Workshop, Seminar, Consultation"
                               maxlength="100" value="{{ old('mini_heading') }}" required>
                        <div class="form-text">Brief category or type of event (max 100 characters)</div>
                        @error('mini_heading')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="heading" class="form-label">Event Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('heading') is-invalid @enderror"
                               id="heading" name="heading" placeholder="Enter Main Event Title"
                               maxlength="150" value="{{ old('heading') }}" required>
                        <div class="form-text">Main title of your event (max 150 characters)</div>
                        @error('heading')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="short_description" class="form-label">Event Description <span class="text-danger">*</span></label>
                        <textarea class="form-control @error('short_description') is-invalid @enderror"
                                  id="short_description" name="short_description" rows="6"
                                  placeholder="Provide a detailed description of your event, including what participants will learn, duration, agenda, etc."
                                  maxlength="1000" required>{{ old('short_description') }}</textarea>
                        <div class="form-text"><span id="charCount">0</span>/1000 characters</div>
                        @error('short_description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-actions">
                        <a href="{{ route('professional.events.index') }}" class="btn btn-light">
                            <i class="ri-arrow-left-line"></i>
                            Back to Events
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="ri-send-plane-line"></i>
                            Submit & Next
                        </button>
                    </div>
                </form>
            </div>
        </section>
    </div>
</div>
@endsection

@section('script')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Image preview functionality
    const imageInput = document.getElementById('card_image');
    const preview = document.getElementById('imagePreview');
    const previewImg = document.getElementById('previewImg');

    imageInput.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                previewImg.src = e.target.result;
                preview.style.display = 'block';
            };
            reader.readAsDataURL(file);
        } else {
            preview.style.display = 'none';
        }
    });

    // Character count for description
    const textarea = document.getElementById('short_description');
    const charCount = document.getElementById('charCount');

    function updateCharCount() {
        const count = textarea.value.length;
        charCount.textContent = count;
        
        if (count > 800) {
            charCount.className = 'text-warning';
        } else if (count > 950) {
            charCount.className = 'text-danger';
        } else {
            charCount.className = '';
        }
    }

    textarea.addEventListener('input', updateCharCount);
    updateCharCount(); // Initial count

    // Form validation enhancement
    const form = document.querySelector('form');
    form.addEventListener('submit', function(e) {
        const requiredFields = form.querySelectorAll('[required]');
        let isValid = true;

        requiredFields.forEach(field => {
            if (!field.value.trim()) {
                isValid = false;
                field.classList.add('is-invalid');
            } else {
                field.classList.remove('is-invalid');
            }
        });

        if (!isValid) {
            e.preventDefault();
            alert('Please fill in all required fields.');
        }
    });
});
</script>
@endsection