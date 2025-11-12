@extends('customer.layout.layout')
@section('styles')
<link rel="stylesheet" href="{{ asset('customer-css/assets/css/add-profile.css') }}" />
<style>
    :root {
        --primary: #f7a86c;
        --primary-dark: #eb8640;
        --primary-soft: #fde5cd;
        --accent: #7dd3fc;
        --muted: #a08873;
        --neutral: #2c1b0f;
        --surface: #ffffff;
        --shell-bg: linear-gradient(180deg, #fff9f3 0%, #fff4e8 100%);
        --border: rgba(247, 168, 108, 0.28);
        --shadow-lg: 0 24px 48px rgba(122, 63, 20, 0.14);
        --shadow-md: 0 18px 36px rgba(122, 63, 20, 0.12);
        --shadow-sm: 0 10px 20px rgba(15, 23, 42, 0.08);
        --radius-lg: 32px;
        --radius-md: 24px;
        --radius-sm: 16px;
    }

    body,
    .app-content {
        background: var(--shell-bg);
    }

    .customer-profile-edit-page {
        width: 100%;
        padding: 2.8rem 1.6rem 3.4rem;
        box-sizing: border-box;
        overflow-x: hidden;
    }

    .customer-profile-edit-shell {
        max-width: 880px;
        margin: 0 auto;
        display: flex;
        flex-direction: column;
        gap: 2rem;
    }

    .edit-hero {
        position: relative;
        overflow: hidden;
        border-radius: var(--radius-lg);
        border: 1px solid rgba(247, 168, 108, 0.24);
        padding: 2.3rem 2.6rem;
        background: linear-gradient(135deg, rgba(251, 209, 173, 0.95), rgba(255, 244, 232, 0.95));
        box-shadow: var(--shadow-lg);
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        justify-content: space-between;
        gap: 1.4rem;
    }

    .edit-hero::before,
    .edit-hero::after {
        content: "";
        position: absolute;
        border-radius: 50%;
        pointer-events: none;
    }

    .edit-hero::before {
        width: 320px;
        height: 320px;
        top: -40%;
        right: -14%;
        background: rgba(247, 168, 108, 0.26);
    }

    .edit-hero::after {
        width: 240px;
        height: 240px;
        bottom: -48%;
        left: -18%;
        background: rgba(255, 236, 214, 0.36);
    }

    .edit-hero > * { position: relative; z-index: 1; }

    .hero-copy {
        display: flex;
        flex-direction: column;
        gap: 0.75rem;
        color: var(--neutral);
    }

    .hero-eyebrow {
        display: inline-flex;
        align-items: center;
        gap: 0.45rem;
        padding: 0.45rem 1.05rem;
        border-radius: 999px;
        font-size: 0.78rem;
        font-weight: 600;
        letter-spacing: 0.1em;
        text-transform: uppercase;
        background: rgba(255, 255, 255, 0.6);
        border: 1px solid rgba(247, 168, 108, 0.32);
    }

    .hero-copy h1 {
        margin: 0;
        font-size: 2rem;
        font-weight: 700;
    }

    .hero-copy p {
        margin: 0;
        font-size: 0.95rem;
        max-width: 420px;
        color: rgba(44, 27, 15, 0.72);
    }

    .edit-hero-illustration {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 130px;
        height: 130px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.75);
        border: 1px solid rgba(255, 255, 255, 0.8);
        box-shadow: inset 0 18px 36px rgba(255, 255, 255, 0.45);
        color: rgba(44, 27, 15, 0.76);
        font-size: 2.8rem;
    }

    .profile-form-card {
        background: var(--surface);
        border-radius: var(--radius-md);
        border: 1px solid var(--border);
        box-shadow: var(--shadow-md);
        padding: 2.4rem 2.5rem;
        display: flex;
        flex-direction: column;
        gap: 1.8rem;
    }

    .form-section {
        display: flex;
        flex-direction: column;
        gap: 1.4rem;
    }

    .form-section header {
        display: flex;
        flex-wrap: wrap;
        justify-content: space-between;
        align-items: center;
        gap: 1rem;
        border-bottom: 1px solid rgba(247, 168, 108, 0.22);
        padding-bottom: 1.2rem;
    }

    .form-section header h2 {
        margin: 0;
        font-size: 1.12rem;
        font-weight: 700;
        color: var(--neutral);
    }

    .form-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 1.3rem;
    }

    .form-group {
        display: flex;
        flex-direction: column;
        gap: 0.55rem;
    }

    .form-group label {
        font-weight: 600;
        font-size: 0.88rem;
        color: var(--neutral);
    }

    .form-control,
    input[type="file"],
    textarea {
        border-radius: 16px;
        border: 1px solid rgba(226, 232, 240, 0.9);
        padding: 0.95rem 1.05rem;
        font-size: 0.96rem;
        transition: border 0.18s ease, box-shadow 0.18s ease, background 0.18s ease;
        background: rgba(255, 255, 255, 0.82);
        color: var(--neutral);
    }

    .form-control:focus,
    textarea:focus,
    input[type="file"]:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 4px rgba(247, 168, 108, 0.2);
        background: var(--surface);
        outline: none;
    }

    textarea {
        resize: vertical;
        min-height: 120px;
        width: 100%;
    }

    .avatar-preview {
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .avatar-preview img {
        width: 96px;
        height: 96px;
        border-radius: 18px;
        object-fit: cover;
        box-shadow: var(--shadow-sm);
    }

    .form-actions {
        display: flex;
        justify-content: flex-end;
        gap: 0.8rem;
    }

    .btn-primary {
        background: linear-gradient(135deg, var(--primary), var(--primary-dark));
        border: none;
        padding: 0.9rem 1.7rem;
        color: white;
        border-radius: 999px;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        box-shadow: 0 20px 40px rgba(247, 168, 108, 0.28);
    }

    .btn-secondary {
        border: 1px solid rgba(148, 163, 184, 0.35);
        background: #ffffff;
        color: var(--muted);
        padding: 0.9rem 1.55rem;
        border-radius: 999px;
        font-weight: 600;
    }

    .btn-primary:hover,
    .btn-secondary:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-sm);
    }

    @media (max-width: 1024px) {
        .customer-profile-edit-page {
            padding: 2.5rem 1.3rem 3.1rem;
        }

        .edit-hero {
            padding: 2rem 2.2rem;
        }

        .profile-form-card {
            padding: 2.2rem 2.2rem;
        }
    }

    @media (max-width: 820px) {
        .edit-hero {
            padding: 1.8rem 1.7rem;
            flex-direction: column;
            align-items: flex-start;
        }

        .edit-hero-illustration {
            width: 110px;
            height: 110px;
            font-size: 2.4rem;
        }

        .profile-form-card {
            padding: 2.1rem 2rem;
        }
    }

    @media (max-width: 768px) {
        .customer-profile-edit-page {
            padding: 2.2rem 1.1rem 2.8rem;
        }

        .profile-form-card {
            padding: 2rem 1.9rem;
        }

        .form-grid {
            grid-template-columns: 1fr;
        }

        .form-group[style*="grid-column: span 2"] {
            grid-column: auto;
        }

        .avatar-preview {
            flex-direction: column;
            align-items: flex-start;
        }

        .form-actions {
            flex-direction: column;
            align-items: stretch;
        }
    }

    @media (max-width: 620px) {
        .customer-profile-edit-page {
            padding: 2.1rem 0.95rem 2.5rem;
        }

        .edit-hero {
            padding: 1.8rem 1.6rem;
            border-radius: 26px;
        }

        .hero-copy h1 {
            font-size: 1.8rem;
        }

        .hero-copy p {
            font-size: 0.92rem;
        }

        .profile-form-card {
            padding: 1.85rem 1.7rem;
            border-radius: 22px;
            gap: 1.5rem;
        }
    }

    @media (max-width: 480px) {
        .customer-profile-edit-page {
            padding: 1.9rem 0.8rem 2.2rem;
        }

        .edit-hero {
            padding: 1.6rem 1.4rem;
        }

        .edit-hero-illustration {
            width: 90px;
            height: 90px;
            font-size: 2rem;
        }

        .profile-form-card {
            padding: 1.7rem 1.5rem;
        }

        .form-section header {
            flex-direction: column;
            align-items: flex-start;
            gap: 0.6rem;
        }

        .btn-primary,
        .btn-secondary {
            width: 100%;
            justify-content: center;
            text-align: center;
        }
    }
</style>
@endsection
@section('content')
<div class="customer-profile-edit-page">
    <div class="customer-profile-edit-shell">
        <section class="edit-hero">
            <div class="hero-copy">
                <span class="hero-eyebrow"><i class="ri-user-settings-line"></i>Edit Profile</span>
                <h1>Update Your Information</h1>
                <p>Keep your contact and profile details up to date so we can notify you about bookings and new offers without interruption.</p>
            </div>
            <div class="edit-hero-illustration">
                <i class="ri-draft-line"></i>
            </div>
        </section>

        <section class="profile-form-card">
            <form id="profileForm" enctype="multipart/form-data">
                @csrf

                <div class="form-section">
                    <header>
                        <h2>Profile Photo</h2>
                    </header>
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="profile_image">Upload a new photo</label>
                            <input type="file" id="profile_image" name="profile_image" accept="image/*">
                            @if($profile->customerProfile && $profile->customerProfile->profile_image)
                                <div class="avatar-preview">
                                    <img src="{{ asset('storage/'.$profile->customerProfile->profile_image) }}" alt="Current Photo">
                                    <span class="text-muted">Current photo</span>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="form-section">
                    <header>
                        <h2>Contact Details</h2>
                    </header>
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" id="name" name="name" value="{{ old('name', $profile->name ?? 'N/A' ) }}" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Email Address</label>
                            <input type="email" id="email" name="email" value="{{ old('email', $profile->email) }}" required>
                        </div>
                        <div class="form-group">
                            <label for="phone">Phone Number</label>
                            <input type="tel" id="phone" name="phone" value="{{ old('phone', $profile->customerProfile ? $profile->customerProfile->phone : '') }}">
                        </div>
                    </div>
                </div>

                <div class="form-section">
                    <header>
                        <h2>Address</h2>
                    </header>
                    <div class="form-grid">
                        <div class="form-group" style="grid-column: span 2;">
                            <label for="address">Street Address</label>
                            <textarea id="address" name="address" rows="3">{{ old('address', $profile->customerProfile ? $profile->customerProfile->address : '') }}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="city">City</label>
                            <input id="city" name="city" value="{{ old('city', $profile->customerProfile?->city) }}" required>
                        </div>
                        <div class="form-group">
                            <label for="state">State</label>
                            <input id="state" name="state" value="{{ old('state', $profile->customerProfile?->state) }}" required>
                        </div>
                        <div class="form-group">
                            <label for="zip_code">Zip Code</label>
                            <input id="zip_code" name="zip_code" value="{{ old('zip_code', $profile->customerProfile?->zip_code) }}" required>
                        </div>
                    </div>
                </div>

                <div class="form-section">
                    <header>
                        <h2>Additional Notes</h2>
                    </header>
                    <div class="form-grid">
                        <div class="form-group" style="grid-column: span 2;">
                            <label for="notes">Notes</label>
                            <textarea id="notes" name="notes" rows="3">{{ old('notes', $profile->customerProfile ? $profile->customerProfile->notes : '') }}</textarea>
                        </div>
                    </div>
                </div>

                <div class="form-actions">
                    <a href="{{ route('user.profile.index') }}" class="btn-secondary">Cancel</a>
                    <button type="submit" class="btn-primary"><i class="ri-save-3-line"></i> Save Profile</button>
                </div>
            </form>
        </section>
    </div>
</div>
@endsection
@section('scripts')
<script>
$('#profileForm').submit(function(e) {
    e.preventDefault();
    let form = this;
    let formData = new FormData(form);
    formData.append('_method', 'PUT'); 

    $.ajax({
        url: "{{ route('user.profile.update', ['profile' => $profile->id]) }}", 
        method: "POST", 
        data: formData,
        contentType: false, 
        processData: false, 
        cache: false, 
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {
            if (response.status === 'success') {
                toastr.success(response.message);
                form.reset();
                setTimeout(function() {
                    window.location.href = "{{ route('user.profile.index') }}";
                }, 1500);
            } else {
                toastr.error(response.message || "Something went wrong");
            }
        },
        error: function(xhr) {
            if (xhr.status === 422) {
                let errors = xhr.responseJSON.errors;
                $.each(errors, function(key, value) {
                    toastr.error(value[0]);
                });
            } else {
                toastr.error(xhr.responseJSON.message || "An unexpected error occurred");
            }
        }
    });
});
</script>
@endsection
