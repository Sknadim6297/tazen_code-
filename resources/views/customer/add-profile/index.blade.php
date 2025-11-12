@extends('customer.layout.layout')
@section('styles')
<link rel="stylesheet" href="{{ asset('customer-css/assets/css/add-profile.css') }}" />
<link rel="stylesheet" href="{{ asset('frontend/assets/css/responsive2.css') }}" media="screen and (max-width: 992px)">
<style>
    :root {
        --profile-primary: #f97316;
        --profile-primary-dark: #ea580c;
        --profile-secondary: #0ea5e9;
        --profile-muted: #64748b;
        --profile-neutral: #1f2937;
        --profile-bg: #f6f7fb;
        --profile-surface: #ffffff;
        --profile-border: rgba(148, 163, 184, 0.22);
        --profile-shadow: 0 24px 52px rgba(15, 23, 42, 0.12);
    }

    body,
    .app-content {
        background: var(--profile-bg) !important;
    }

    .customer-profile-page {
        width: 100%;
        padding: 2.6rem 1.45rem 3.6rem;
    }

    .customer-profile-shell {
        max-width: 980px;
        margin: 0 auto;
        display: flex;
        flex-direction: column;
        gap: 2rem;
    }

    .customer-profile-hero {
        position: relative;
        overflow: hidden;
        padding: 2.2rem 2.6rem;
        border-radius: 32px;
        border: 1px solid rgba(249, 115, 22, 0.2);
        background: linear-gradient(135deg, rgba(249, 115, 22, 0.14), rgba(14, 165, 233, 0.18));
        box-shadow: 0 28px 64px rgba(249, 115, 22, 0.18);
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        justify-content: space-between;
        gap: 1.6rem;
    }

    .customer-profile-hero::before,
    .customer-profile-hero::after {
        content: "";
        position: absolute;
        border-radius: 50%;
        pointer-events: none;
    }

    .customer-profile-hero::before {
        width: 340px;
        height: 340px;
        top: -48%;
        right: -14%;
        background: rgba(249, 115, 22, 0.22);
    }

    .customer-profile-hero::after {
        width: 220px;
        height: 220px;
        bottom: -46%;
        left: -16%;
        background: rgba(14, 165, 233, 0.22);
    }

    .customer-profile-hero > * { position: relative; z-index: 1; }

    .customer-profile-hero .hero-copy {
        display: flex;
        flex-direction: column;
        gap: 0.75rem;
        color: #422006;
    }

    .customer-profile-hero .hero-eyebrow {
        display: inline-flex;
        align-items: center;
        gap: 0.45rem;
        padding: 0.45rem 1.05rem;
        border-radius: 999px;
        font-size: 0.78rem;
        font-weight: 600;
        letter-spacing: 0.1em;
        text-transform: uppercase;
        background: rgba(255, 255, 255, 0.52);
        border: 1px solid rgba(255, 255, 255, 0.6);
    }

    .customer-profile-hero h1 {
        margin: 0;
        font-size: 2rem;
        font-weight: 700;
    }

    .customer-profile-hero p {
        margin: 0;
        font-size: 0.96rem;
        max-width: 420px;
        color: rgba(66, 32, 6, 0.78);
    }

    .customer-profile-hero .hero-cta {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        padding: 0.8rem 1.5rem;
        border-radius: 999px;
        background: linear-gradient(135deg, var(--profile-primary), var(--profile-primary-dark));
        color: #ffffff;
        text-decoration: none;
        font-weight: 600;
        box-shadow: 0 22px 40px rgba(249, 115, 22, 0.24);
    }

    .customer-profile-hero .hero-illustration {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 140px;
        height: 140px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.68);
        border: 1px solid rgba(255, 255, 255, 0.72);
        box-shadow: inset 0 18px 36px rgba(255, 255, 255, 0.42);
        color: rgba(66, 32, 6, 0.76);
        font-size: 3rem;
    }

    .customer-profile-card {
        background: var(--profile-surface);
        border-radius: 28px;
        border: 1px solid var(--profile-border);
        box-shadow: var(--profile-shadow);
        padding: 2.3rem 2.5rem;
        display: flex;
        flex-direction: column;
        gap: 2rem;
    }

    .customer-profile-card header {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        justify-content: space-between;
        gap: 1.2rem;
        border-bottom: 1px solid rgba(226, 232, 240, 0.82);
        padding-bottom: 1.4rem;
    }

    .customer-profile-card header h2 {
        margin: 0;
        font-size: 1.28rem;
        font-weight: 700;
        color: var(--profile-neutral);
    }

    .customer-profile-card .profile-edit-btn {
        display: inline-flex;
        align-items: center;
        gap: 0.45rem;
        padding: 0.75rem 1.45rem;
        border-radius: 999px;
        background: linear-gradient(135deg, var(--profile-secondary), #0284c7);
        color: #ffffff;
        text-decoration: none;
        font-weight: 600;
        box-shadow: 0 20px 38px rgba(14, 165, 233, 0.24);
    }

    .customer-profile-avatar {
        display: flex;
        justify-content: center;
    }

    .customer-profile-avatar img {
        width: 196px;
        height: 196px;
        border-radius: 50%;
        object-fit: cover;
        border: 5px solid #ffffff;
        box-shadow: 0 24px 48px rgba(15, 23, 42, 0.18);
    }

    .customer-profile-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
        gap: 1.4rem;
    }

    .customer-profile-tile {
        padding: 1.1rem 1.2rem;
        border-radius: 18px;
        background: rgba(249, 250, 251, 0.92);
        border: 1px solid rgba(226, 232, 240, 0.78);
        display: flex;
        flex-direction: column;
        gap: 0.45rem;
        transition: transform 0.18s ease, box-shadow 0.18s ease, border-color 0.18s ease;
    }

    .customer-profile-tile:hover {
        transform: translateY(-2px);
        box-shadow: 0 20px 38px rgba(15, 23, 42, 0.12);
        border-color: rgba(249, 115, 22, 0.3);
        background: #ffffff;
    }

    .customer-profile-tile strong {
        font-size: 0.82rem;
        text-transform: uppercase;
        letter-spacing: 0.08em;
        color: var(--profile-muted);
    }

    .customer-profile-tile span {
        font-size: 1rem;
        font-weight: 600;
        color: var(--profile-neutral);
    }

    .customer-profile-gallery {
        display: flex;
        flex-direction: column;
        gap: 1.2rem;
    }

    .customer-profile-gallery h3 {
        margin: 0;
        font-size: 1.1rem;
        font-weight: 700;
        color: var(--profile-neutral);
    }

    .customer-profile-gallery-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(160px, 1fr));
        gap: 1rem;
    }

    .customer-profile-gallery-grid img {
        width: 100%;
        height: 160px;
        border-radius: 18px;
        object-fit: cover;
        box-shadow: 0 16px 32px rgba(15, 23, 42, 0.14);
        transition: transform 0.18s ease, box-shadow 0.18s ease;
    }

    .customer-profile-gallery-grid img:hover {
        transform: scale(1.04);
        box-shadow: 0 22px 44px rgba(15, 23, 42, 0.18);
    }

    .customer-profile-empty {
        text-align: center;
        padding: 3.2rem 1.6rem;
        border-radius: 24px;
        border: 1px dashed rgba(148, 163, 184, 0.4);
        background: rgba(248, 250, 252, 0.92);
        color: var(--profile-muted);
    }

    .customer-profile-empty i {
        font-size: 3rem;
        margin-bottom: 1rem;
        opacity: 0.5;
    }

    @media (max-width: 768px) {
        .customer-profile-page { padding: 2.2rem 1.05rem 3.1rem;
        margin: -10px;
     }
        .customer-profile-hero { padding: 1.9rem 1.6rem; }
        .customer-profile-hero .hero-illustration { width: 110px; height: 110px; font-size: 2.4rem; }
        .customer-profile-card { padding: 2rem 1.9rem; }
        .customer-profile-grid { grid-template-columns: 1fr; }
    }
</style>
@endsection

@section('content')
<div class="customer-profile-page">
    <div class="customer-profile-shell">
        <section class="customer-profile-hero">
            <div class="hero-copy">
                <span class="hero-eyebrow"><i class="ri-user-heart-line"></i>Profile</span>
                <h1>Your Profile Details</h1>
                <p>Review and manage the information associated with your account. Keeping your profile updated helps us serve you better.</p>
                @if($profiles->isNotEmpty())
                    <a href="{{ route('user.profile.edit', ['profile' => $profiles->first()->id]) }}" class="hero-cta">
                        <i class="ri-edit-line"></i>
                        Update Profile
                    </a>
                @endif
            </div>
            <div class="hero-illustration">
                <i class="ri-user-smile-line"></i>
            </div>
        </section>

        @forelse($profiles as $profile)
            <section class="customer-profile-card">
                <header>
                    <h2>Personal Information</h2>
                    <a href="{{ route('user.profile.edit', ['profile' => $profile->id]) }}" class="profile-edit-btn">
                        <i class="ri-pencil-line"></i>
                        Edit Profile
                    </a>
                </header>

                <div class="customer-profile-avatar">
                    <img src="{{ $profile->customerProfile && $profile->customerProfile->profile_image ? asset($profile->customerProfile->profile_image) : asset('default-avatar.png') }}" alt="Profile Photo">
                </div>

                <div class="customer-profile-grid">
                    <div class="customer-profile-tile">
                        <strong>Name</strong>
                        <span>{{ $profile->name ?? 'N/A' }}</span>
                    </div>
                    <div class="customer-profile-tile">
                        <strong>Email</strong>
                        <span>{{ $profile->email ?? 'N/A' }}</span>
                    </div>
                    <div class="customer-profile-tile">
                        <strong>Phone</strong>
                        <span>{{ $profile->customerProfile->phone ?? 'N/A' }}</span>
                    </div>
                    <div class="customer-profile-tile">
                        <strong>Address</strong>
                        <span>{{ $profile->customerProfile->address ?? 'N/A' }}</span>
                    </div>
                    <div class="customer-profile-tile">
                        <strong>City</strong>
                        <span>{{ $profile->customerProfile->city ?? 'N/A' }}</span>
                    </div>
                    <div class="customer-profile-tile">
                        <strong>State</strong>
                        <span>{{ $profile->customerProfile->state ?? 'N/A' }}</span>
                    </div>
                    <div class="customer-profile-tile">
                        <strong>Zip Code</strong>
                        <span>{{ $profile->customerProfile->zip_code ?? 'N/A' }}</span>
                    </div>
                    <div class="customer-profile-tile">
                        <strong>Notes</strong>
                        <span>{{ $profile->customerProfile->notes ?? 'No notes available' }}</span>
                    </div>
                </div>

                @php
                    $customerProfile = $profile->customerProfile;
                    $gallery = $customerProfile && $customerProfile->gallery
                        ? (is_array($customerProfile->gallery) ? $customerProfile->gallery : json_decode($customerProfile->gallery, true))
                        : [];
                @endphp

                @if(!empty($gallery))
                    <div class="customer-profile-gallery">
                        <h3>Gallery</h3>
                        <div class="customer-profile-gallery-grid">
                            @foreach($gallery as $img)
                                <img src="{{ asset($img) }}" alt="Gallery Image">
                            @endforeach
                        </div>
                    </div>
                @endif
            </section>
        @empty
            <div class="customer-profile-empty">
                <i class="ri-folder-user-line"></i>
                <h4>No profile found</h4>
                <p>Add your profile details so we can tailor your experience and keep your bookings in sync.</p>
            </div>
        @endforelse
    </div>
</div>
@endsection