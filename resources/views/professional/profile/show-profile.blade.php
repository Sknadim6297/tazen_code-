@extends('professional.layout.layout')

@section('styles')
<style>
    :root {
        --primary: #4f46e5;
        --primary-dark: #4338ca;
        --secondary: #0ea5e9;
        --success: #16a34a;
        --warning: #f59e0b;
        --danger: #dc2626;
        --page-bg: #f3f4ff;
        --surface: #ffffff;
        --card-border: rgba(99, 102, 241, 0.12);
        --text-dark: #0f172a;
        --text-muted: #64748b;
        --shadow-lg: 0 26px 48px rgba(15, 23, 42, 0.12);
    }

    body,
    .app-content {
        background: var(--page-bg);
    }

    .profile-view-page {
        padding: 2.8rem 1.6rem 3.4rem;
    }

    .profile-shell {
        max-width: 1200px;
        margin: 0 auto;
        display: flex;
        flex-direction: column;
        gap: 2.2rem;
    }

    .profile-hero {
        position: relative;
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
        gap: 1.8rem;
        padding: 2.3rem 2.6rem;
        border-radius: 30px;
        background: linear-gradient(135deg, rgba(79, 70, 229, 0.14), rgba(14, 165, 233, 0.16));
        overflow: hidden;
        box-shadow: var(--shadow-lg);
    }

    .profile-hero::before,
    .profile-hero::after {
        content: '';
        position: absolute;
        border-radius: 50%;
        pointer-events: none;
    }

    .profile-hero::before {
        width: 320px;
        height: 320px;
        top: -160px;
        right: -140px;
        background: rgba(79, 70, 229, 0.38);
    }

    .profile-hero::after {
        width: 240px;
        height: 240px;
        bottom: -160px;
        left: -120px;
        background: rgba(14, 165, 233, 0.2);
    }

    .profile-hero > * {
        position: relative;
        z-index: 1;
    }

    .profile-hero__meta {
        display: flex;
        flex-direction: column;
        gap: 0.8rem;
        color: var(--text-muted);
    }

    .profile-hero__eyebrow {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.45rem 1.2rem;
        border-radius: 999px;
        background: rgba(255, 255, 255, 0.65);
        border: 1px solid rgba(255, 255, 255, 0.75);
        font-size: 0.78rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.12em;
        color: var(--text-dark);
    }

    .profile-hero__meta h1 {
        margin: 0;
        font-size: 2.3rem;
        font-weight: 700;
        color: var(--text-dark);
        letter-spacing: -0.02em;
    }

    .profile-hero__meta p {
        margin: 0;
        line-height: 1.6;
        max-width: 520px;
    }

    .profile-hero__actions {
        display: flex;
        flex-wrap: wrap;
        gap: 0.9rem;
        align-items: center;
        justify-content: flex-end;
    }

    .btn-pill {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.95rem 1.9rem;
        border-radius: 999px;
        font-weight: 600;
        text-decoration: none;
        transition: transform 0.18s ease, box-shadow 0.18s ease, background 0.18s ease, color 0.18s ease;
    }

    .btn-pill--primary {
        background: linear-gradient(135deg, var(--primary), var(--primary-dark));
        color: #ffffff;
        box-shadow: 0 20px 38px rgba(79, 70, 229, 0.28);
    }

    .btn-pill--primary:hover {
        transform: translateY(-2px);
    }

    .btn-pill--outline {
        background: rgba(79, 70, 229, 0.1);
        color: var(--primary-dark);
        border: 1px solid rgba(79, 70, 229, 0.3);
    }

    .btn-pill--outline:hover {
        background: rgba(79, 70, 229, 0.18);
        transform: translateY(-1px);
    }

    .profile-list {
        display: flex;
        flex-direction: column;
        gap: 2rem;
    }

    .profile-card {
        display: grid;
        grid-template-columns: 320px 1fr;
        gap: 2.2rem;
        background: var(--surface);
        border-radius: 28px;
        border: 1px solid var(--card-border);
        box-shadow: var(--shadow-lg);
        padding: 2.2rem 2.4rem;
    }

    .profile-card__sidebar {
        display: flex;
        flex-direction: column;
        gap: 1.4rem;
        position: relative;
    }

    .profile-card__photo {
        position: relative;
        border-radius: 24px;
        overflow: hidden;
        aspect-ratio: 1/1;
        box-shadow: 0 20px 40px rgba(15, 23, 42, 0.18);
        border: 4px solid rgba(79, 70, 229, 0.08);
    }

    .profile-card__photo img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .profile-card__status {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.6rem 1.25rem;
        border-radius: 999px;
        background: rgba(34, 197, 94, 0.14);
        color: #047857;
        font-weight: 600;
        font-size: 0.88rem;
        width: max-content;
    }

    .profile-card__status-dot {
        width: 10px;
        height: 10px;
        border-radius: 50%;
        background: #22c55e;
        box-shadow: 0 0 0 4px rgba(34, 197, 94, 0.18);
    }

    .profile-card__updated {
        font-size: 0.85rem;
        color: var(--text-muted);
    }

    .profile-card__actions {
        display: flex;
        flex-wrap: wrap;
        gap: 0.6rem;
    }

    .profile-card__actions .btn-pill {
        padding: 0.7rem 1.4rem;
        border-radius: 12px;
    }

    .profile-card__actions .btn-pill--ghost {
        background: rgba(148, 163, 184, 0.16);
        color: var(--text-dark);
    }

    .profile-card__actions .btn-pill--ghost:hover {
        background: rgba(148, 163, 184, 0.26);
    }

    .profile-card__content {
        display: flex;
        flex-direction: column;
        gap: 1.8rem;
    }

    .profile-section {
        background: rgba(248, 250, 255, 0.75);
        border-radius: 22px;
        border: 1px solid rgba(148, 163, 184, 0.18);
        padding: 1.8rem 2rem;
        box-shadow: 0 20px 36px rgba(15, 23, 42, 0.08);
    }

    .profile-section__header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 1.2rem;
        gap: 1rem;
    }

    .profile-section__header h3 {
        margin: 0;
        font-size: 1.1rem;
        font-weight: 700;
        color: var(--text-dark);
        display: inline-flex;
        align-items: center;
        gap: 0.55rem;
    }

    .detail-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 1.1rem;
    }

    .detail-tile {
        background: var(--surface);
        border-radius: 18px;
        border: 1px solid rgba(148, 163, 184, 0.18);
        padding: 1.1rem 1.3rem;
        display: flex;
        flex-direction: column;
        gap: 0.45rem;
        box-shadow: 0 16px 32px rgba(15, 23, 42, 0.08);
    }

    .detail-tile__label {
        font-size: 0.78rem;
        text-transform: uppercase;
        letter-spacing: 0.1em;
        color: var(--text-muted);
        font-weight: 600;
    }

    .detail-tile__value {
        font-size: 1.02rem;
        font-weight: 600;
        color: var(--text-dark);
        line-height: 1.4;
    }

    .detail-tile__note {
        font-size: 0.8rem;
        color: var(--text-muted);
    }

    .badge-warning {
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        padding: 0.28rem 0.75rem;
        border-radius: 999px;
        background: rgba(239, 68, 68, 0.12);
        color: var(--danger);
        font-size: 0.75rem;
        font-weight: 600;
        width: max-content;
    }

    .badge-warning i {
        font-size: 0.72rem;
    }

    .commission-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1rem;
    }

    .commission-pill {
        display: flex;
        flex-direction: column;
        gap: 0.35rem;
        padding: 1rem 1.2rem;
        border-radius: 16px;
        color: var(--text-dark);
        background: rgba(79, 70, 229, 0.12);
        border: 1px solid rgba(79, 70, 229, 0.24);
    }

    .commission-pill.is-warning {
        background: rgba(245, 158, 11, 0.14);
        border-color: rgba(245, 158, 11, 0.28);
    }

    .commission-pill.is-success {
        background: rgba(34, 197, 94, 0.14);
        border-color: rgba(34, 197, 94, 0.26);
    }

    .documents-list,
    .bank-list {
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }

    .document-row {
        display: flex;
        align-items: center;
        gap: 1rem;
        padding: 0.9rem 1rem;
        border-radius: 14px;
        background: var(--surface);
        border: 1px solid rgba(148, 163, 184, 0.14);
        box-shadow: 0 10px 20px rgba(15, 23, 42, 0.06);
    }

    .document-row__icon {
        width: 44px;
        height: 44px;
        border-radius: 12px;
        background: rgba(79, 70, 229, 0.14);
        color: var(--primary-dark);
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 1.05rem;
    }

    .document-row__content {
        flex: 1;
    }

    .document-row__title {
        font-weight: 600;
        font-size: 0.92rem;
        color: var(--text-dark);
    }

    .document-link {
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
        font-size: 0.82rem;
        color: var(--primary-dark);
        text-decoration: none;
    }

    .document-link:hover {
        text-decoration: underline;
    }

    .profile-gallery {
        background: var(--surface);
        border-radius: 24px;
        border: 1px solid rgba(148, 163, 184, 0.18);
        box-shadow: var(--shadow-lg);
        padding: 2rem 2.2rem 2.4rem;
    }

    .profile-gallery__header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 1rem;
        margin-bottom: 1.4rem;
    }

    .profile-gallery__grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
        gap: 1.1rem;
    }

    .profile-gallery__item {
        position: relative;
        border-radius: 16px;
        overflow: hidden;
        aspect-ratio: 1/1;
        box-shadow: 0 16px 32px rgba(15, 23, 42, 0.12);
    }

    .profile-gallery__item img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.3s ease;
    }

    .profile-gallery__item:hover img {
        transform: scale(1.05);
    }

    .profile-gallery__item::after {
        content: 'View';
        position: absolute;
        left: 50%;
        bottom: 1rem;
        transform: translateX(-50%);
        padding: 0.38rem 1.2rem;
        background: rgba(15, 23, 42, 0.8);
        color: #fff;
        font-size: 0.8rem;
        border-radius: 999px;
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .profile-gallery__item:hover::after {
        opacity: 1;
    }

    .gallery-empty {
        grid-column: 1 / -1;
        padding: 3rem 1.8rem;
        text-align: center;
        border: 2px dashed rgba(148, 163, 184, 0.28);
        border-radius: 18px;
        color: var(--text-muted);
    }

    .profile-empty-state {
        display: flex;
        flex-direction: column;
        gap: 1.2rem;
        align-items: center;
        justify-content: center;
        padding: 3.4rem 1.8rem;
        background: var(--surface);
        border-radius: 26px;
        border: 1px dashed rgba(79, 70, 229, 0.3);
        box-shadow: var(--shadow-lg);
        text-align: center;
    }

    @media (max-width: 1024px) {
        .profile-card {
            grid-template-columns: 1fr;
            padding: 2rem;
        }

        .profile-card__sidebar {
            flex-direction: row;
            align-items: flex-start;
            gap: 1.4rem;
        }

        .profile-card__photo {
            width: 180px;
        }

        .profile-card__sidebar-block {
            flex: 1;
        }
    }

    @media (max-width: 768px) {
        .profile-view-page {
            padding: 2.2rem 1.1rem 2.6rem;
        }

        .profile-card {
            padding: 1.8rem 1.6rem;
        }

        .profile-card__sidebar {
            flex-direction: column;
        }

        .profile-card__photo {
            width: 100%;
            max-width: 220px;
            align-self: center;
        }

        .profile-hero {
            padding: 2rem 1.8rem;
        }

        .profile-hero__actions {
            justify-content: stretch;
        }

        .btn-pill {
            width: 100%;
            justify-content: center;
        }
    }
</style>
@endsection

@section('content')
<div class="profile-view-page">
    <div class="profile-shell">
        <section class="profile-hero">
            <div class="profile-hero__meta">
                <span class="profile-hero__eyebrow"><i class="ri-user-3-line"></i>Profile Overview</span>
                <h1>Your Professional Identity</h1>
                <p>Review your professional information, ensure key details are complete, and keep your portfolio updated to build trust with potential clients.</p>
            </div>
            <div class="profile-hero__actions">
                <a href="{{ route('professional.profile.index') }}" class="btn-pill btn-pill--outline">
                    <i class="ri-arrow-left-line"></i>
                    Back to Overview
                </a>
            </div>
        </section>

        @if($profiles->count())
            <div class="profile-list">
                @foreach($profiles as $profile)
                    <article class="profile-card">
                        <aside class="profile-card__sidebar">
                            <div class="profile-card__photo">
                                @php
                                    $photoPath = $profile->photo ? asset('storage/'.$profile->photo) : asset('default.jpg');
                                    if ($profile->photo && !file_exists(public_path('storage/'.$profile->photo))) {
                                        $photoPath = asset('img/default-avatar.jpg');
                                    }
                                @endphp
                                <img src="{{ $photoPath }}" alt="{{ $profile->professional->name ?? $profile->name ?? 'Profile photo' }}">
                            </div>
                            <div class="profile-card__sidebar-block">
                                <div class="profile-card__status">
                                    <span class="profile-card__status-dot"></span>
                                    Verified Professional
                                </div>
                                <div class="profile-card__updated">
                                    Last updated {{ $profile->updated_at->diffForHumans() }}
                                </div>
                            </div>
                            <div class="profile-card__actions">
                                <a href="{{ route('professional.profile.edit', ['profile' => $profile->id]) }}" class="btn-pill btn-pill--primary">
                                    <i class="ri-edit-line"></i>
                                    Edit Profile
                                </a>
                                <a href="mailto:{{ $profile->email }}" class="btn-pill btn-pill--ghost">
                                    <i class="ri-mail-send-line"></i>
                                    Contact
                                </a>
                            </div>
                        </aside>

                        <div class="profile-card__content">
                            <section class="profile-section">
                                <div class="profile-section__header">
                                    <h3><i class="ri-information-line"></i>Personal Overview</h3>
                                </div>
                                <div class="detail-grid">
                                    <div class="detail-tile">
                                        <span class="detail-tile__label">Full Name</span>
                                        <span class="detail-tile__value">{{ $profile->name ?? ($profile->professional->name ?? 'Not provided') }}</span>
                                        @if(!$profile->name && !$profile->professional->name)
                                            <span class="badge-warning"><i class="ri-alert-line"></i>Required</span>
                                        @endif
                                    </div>
                                    <div class="detail-tile">
                                        <span class="detail-tile__label">Email</span>
                                        <span class="detail-tile__value">{{ $profile->email ?? 'Not provided' }}</span>
                                        @if(!$profile->email)
                                            <span class="badge-warning"><i class="ri-alert-line"></i>Required</span>
                                        @endif
                                    </div>
                                    <div class="detail-tile">
                                        <span class="detail-tile__label">Phone</span>
                                        <span class="detail-tile__value">{{ $profile->phone ?? 'Not provided' }}</span>
                                        @if(!$profile->phone)
                                            <span class="badge-warning"><i class="ri-alert-line"></i>Add phone number</span>
                                        @endif
                                    </div>
                                    <div class="detail-tile">
                                        <span class="detail-tile__label">Address</span>
                                        <span class="detail-tile__value">{{ $profile->address ?? 'Not provided' }}</span>
                                        @if(!$profile->address)
                                            <span class="badge-warning"><i class="ri-alert-line"></i>Add address</span>
                                        @endif
                                    </div>
                                </div>
                            </section>

                            <section class="profile-section">
                                <div class="profile-section__header">
                                    <h3><i class="ri-briefcase-4-line"></i>Professional Details</h3>
                                </div>
                                <div class="detail-grid">
                                    <div class="detail-tile">
                                        <span class="detail-tile__label">Specialization</span>
                                        <span class="detail-tile__value">{{ $profile->specialization ?? 'Not provided' }}</span>
                                        @if(!$profile->specialization)
                                            <span class="badge-warning"><i class="ri-alert-line"></i>Add specialization</span>
                                        @endif
                                    </div>
                                    <div class="detail-tile">
                                        <span class="detail-tile__label">Experience (Years)</span>
                                        <span class="detail-tile__value">{{ $profile->experience ?? 'Not provided' }}</span>
                                        @if(!$profile->experience)
                                            <span class="badge-warning"><i class="ri-alert-line"></i>Add experience</span>
                                        @endif
                                    </div>
                                    <div class="detail-tile">
                                        <span class="detail-tile__label">Starting Price</span>
                                        <span class="detail-tile__value" style="color: var(--success);">
                                            @if($profile->starting_price)
                                                ₹{{ $profile->starting_price }} per session
                                            @else
                                                Not provided
                                            @endif
                                        </span>
                                        @if(!$profile->starting_price)
                                            <span class="badge-warning"><i class="ri-alert-line"></i>Add pricing</span>
                                        @endif
                                    </div>
                                    <div class="detail-tile">
                                        <span class="detail-tile__label">Education</span>
                                        <span class="detail-tile__value">{{ $profile->education ?? 'Not provided' }}</span>
                                        @if(!$profile->education)
                                            <span class="badge-warning"><i class="ri-alert-line"></i>Add education</span>
                                        @endif
                                    </div>
                                </div>
                                @php
                                    $serviceRequestMargin = $profile->professional->service_request_margin ?? 10.00;
                                    $negotiationOffset = $profile->professional->service_request_offset ?? 20.00;
                                    $mainMargin = $profile->professional->margin ?? 20.00;
                                @endphp
                                <div class="commission-grid" style="margin-top: 1.2rem;">
                                    <div class="commission-pill">
                                        <span class="detail-tile__label">Service Request Margin</span>
                                        <span class="detail-tile__value">{{ number_format($serviceRequestMargin, 2) }}%</span>
                                        <span class="detail-tile__note">Commission for additional service requests</span>
                                    </div>
                                    <div class="commission-pill is-warning">
                                        <span class="detail-tile__label">Negotiation Offset</span>
                                        <span class="detail-tile__value">{{ number_format($negotiationOffset, 2) }}%</span>
                                        <span class="detail-tile__note">Maximum negotiation allowance</span>
                                    </div>
                                    <div class="commission-pill is-success">
                                        <span class="detail-tile__label">Platform Margin</span>
                                        <span class="detail-tile__value">{{ number_format($mainMargin, 2) }}%</span>
                                        <span class="detail-tile__note">Platform commission on confirmed bookings</span>
                                    </div>
                                </div>
                                <div class="detail-grid" style="margin-top: 1.1rem;">
                                    @if($profile->gst_number)
                                        <div class="detail-tile">
                                            <span class="detail-tile__label">GST Number</span>
                                            <span class="detail-tile__value">{{ $profile->gst_number }}</span>
                                        </div>
                                    @endif
                                    @if($profile->state_code)
                                        <div class="detail-tile">
                                            <span class="detail-tile__label">State Code</span>
                                            <span class="detail-tile__value">{{ $profile->state_code }} {{ $profile->state_name ? '- '.$profile->state_name : '' }}</span>
                                        </div>
                                    @endif
                                    @if($profile->gst_address)
                                        <div class="detail-tile detail-tile--full">
                                            <span class="detail-tile__label">GST Address</span>
                                            <span class="detail-tile__value">{{ $profile->gst_address }}</span>
                                        </div>
                                    @endif
                                </div>
                            </section>

                            <section class="profile-section">
                                <div class="profile-section__header">
                                    <h3><i class="ri-user-voice-line"></i>About</h3>
                                </div>
                                <div class="detail-grid">
                                    <div class="detail-tile detail-tile--full">
                                        <span class="detail-tile__label">Biography</span>
                                        <span class="detail-tile__value" style="font-weight:500; line-height:1.7;">
                                            {{ $profile->bio ?? 'No bio provided yet.' }}
                                        </span>
                                        @if(!$profile->bio)
                                            <span class="badge-warning"><i class="ri-alert-line"></i>Add a short bio</span>
                                        @endif
                                    </div>
                                </div>
                            </section>

                            <section class="profile-section">
                                <div class="profile-section__header">
                                    <h3><i class="ri-shield-check-line"></i>Verification Documents</h3>
                                </div>
                                <div class="documents-list">
                                    <div class="document-row">
                                        <span class="document-row__icon"><i class="ri-contacts-book-line"></i></span>
                                        <div class="document-row__content">
                                            <span class="document-row__title">Qualification Document</span>
                                            @if($profile->qualification_document)
                                                <a href="{{ asset('storage/'.$profile->qualification_document) }}" target="_blank" class="document-link">
                                                    <i class="ri-external-link-line"></i>View document
                                                </a>
                                            @else
                                                <span class="badge-warning"><i class="ri-alert-line"></i>Not uploaded</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="document-row">
                                        <span class="document-row__icon"><i class="ri-id-card-line"></i></span>
                                        <div class="document-row__content">
                                            <span class="document-row__title">ID Proof (Aadhaar / PAN)</span>
                                            @if($profile->id_proof_document)
                                                <a href="{{ asset('storage/'.$profile->id_proof_document) }}" target="_blank" class="document-link">
                                                    <i class="ri-external-link-line"></i>View document
                                                </a>
                                            @else
                                                <span class="badge-warning"><i class="ri-alert-line"></i>Not uploaded</span>
                                            @endif
                                        </div>
                                    </div>
                                    @if($profile->gst_number)
                                        <div class="document-row">
                                            <span class="document-row__icon"><i class="ri-file-paper-line"></i></span>
                                            <div class="document-row__content">
                                                <span class="document-row__title">GST Certificate</span>
                                                @if($profile->gst_certificate)
                                                    <a href="{{ asset('storage/'.$profile->gst_certificate) }}" target="_blank" class="document-link">
                                                        <i class="ri-external-link-line"></i>View document
                                                    </a>
                                                @else
                                                    <span class="badge-warning"><i class="ri-alert-line"></i>Not uploaded</span>
                                                @endif
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </section>

                            <section class="profile-section">
                                <div class="profile-section__header">
                                    <h3><i class="ri-bank-card-line"></i>Bank Details</h3>
                                </div>
                                <div class="bank-list">
                                    <div class="detail-grid">
                                        <div class="detail-tile">
                                            <span class="detail-tile__label">Account Holder</span>
                                            <span class="detail-tile__value">{{ $profile->account_holder_name ?? 'Not provided' }}</span>
                                            @if(!$profile->account_holder_name)
                                                <span class="badge-warning"><i class="ri-alert-line"></i>Required</span>
                                            @endif
                                        </div>
                                        <div class="detail-tile">
                                            <span class="detail-tile__label">Bank Name</span>
                                            <span class="detail-tile__value">{{ $profile->bank_name ?? 'Not provided' }}</span>
                                            @if(!$profile->bank_name)
                                                <span class="badge-warning"><i class="ri-alert-line"></i>Required</span>
                                            @endif
                                        </div>
                                        <div class="detail-tile">
                                            <span class="detail-tile__label">Account Number</span>
                                            <span class="detail-tile__value">
                                                @if($profile->account_number)
                                                    {{ str_repeat('*', max(strlen($profile->account_number) - 4, 0)) . substr($profile->account_number, -4) }}
                                                @else
                                                    Not provided
                                                @endif
                                            </span>
                                            @if(!$profile->account_number)
                                                <span class="badge-warning"><i class="ri-alert-line"></i>Required</span>
                                            @endif
                                        </div>
                                        <div class="detail-tile">
                                            <span class="detail-tile__label">IFSC Code</span>
                                            <span class="detail-tile__value">{{ $profile->ifsc_code ?? 'Not provided' }}</span>
                                            @if(!$profile->ifsc_code)
                                                <span class="badge-warning"><i class="ri-alert-line"></i>Required</span>
                                            @endif
                                        </div>
                                        <div class="detail-tile">
                                            <span class="detail-tile__label">Account Type</span>
                                            <span class="detail-tile__value">{{ ucfirst($profile->account_type ?? 'Not specified') }}</span>
                                        </div>
                                        @if($profile->bank_branch)
                                            <div class="detail-tile">
                                                <span class="detail-tile__label">Branch</span>
                                                <span class="detail-tile__value">{{ $profile->bank_branch }}</span>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="document-row">
                                        <span class="document-row__icon"><i class="ri-file-list-3-line"></i></span>
                                        <div class="document-row__content">
                                            <span class="document-row__title">Bank Account Proof</span>
                                            @if($profile->bank_document)
                                                <a href="{{ asset('storage/'.$profile->bank_document) }}" target="_blank" class="document-link">
                                                    <i class="ri-external-link-line"></i>View document
                                                </a>
                                            @else
                                                <span class="badge-warning"><i class="ri-alert-line"></i>Not uploaded</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </section>

                            <section class="profile-gallery">
                                <div class="profile-gallery__header">
                                    <h3><i class="ri-gallery-line"></i>Portfolio Gallery</h3>
                                </div>
                                @php
                                    $gallery = is_array($profile->gallery) ? $profile->gallery : json_decode($profile->gallery, true);
                                    $gallery = is_array($gallery) ? $gallery : [];
                                @endphp
                                @if(!empty($gallery))
                                    <div class="profile-gallery__grid">
                                        @foreach($gallery as $img)
                                            @php
                                                $imagePath = null;
                                                
                                                if (!empty($img)) {
                                                    // Check if it's already a full URL
                                                    if (filter_var($img, FILTER_VALIDATE_URL)) {
                                                        $imagePath = $img;
                                                    } elseif (str_starts_with($img, 'storage/') || str_starts_with($img, '/storage/')) {
                                                        // If path already includes storage/, use asset() directly
                                                        $imagePath = asset(ltrim($img, '/'));
                                                    } elseif (str_starts_with($img, 'uploads/')) {
                                                        // If path starts with uploads/, prepend storage/
                                                        $imagePath = asset('storage/' . $img);
                                                    } elseif (str_starts_with($img, 'gallery/')) {
                                                        // If path starts with gallery/, prepend storage/uploads/profiles/
                                                        $imagePath = asset('storage/uploads/profiles/' . $img);
                                                    } else {
                                                        // Default: assume path is relative to storage/app/public
                                                        // This handles paths like: uploads/profiles/gallery/filename.jpg
                                                        $imagePath = asset('storage/' . $img);
                                                    }
                                                }
                                            @endphp
                                            @if($imagePath)
                                                <div class="profile-gallery__item">
                                                    <img src="{{ $imagePath }}" alt="Gallery image" onerror="this.style.display='none'; this.parentElement.style.display='none';">
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                @else
                                    <div class="gallery-empty">
                                        <i class="ri-image-line" style="font-size:2rem;"></i>
                                        <p>No gallery images available.</p>
                                    </div>
                                @endif
                            </section>
                        </div>
                    </article>
                @endforeach
            </div>
        @else
            <div class="profile-empty-state">
                <i class="ri-user-smile-line" style="font-size:3rem; color:var(--primary-dark);"></i>
                <h3>No profiles yet</h3>
                <p>Build your professional presence by creating your first profile. Clients are more likely to reach out when your profile is complete and polished.</p>
                <a href="{{ route('professional.profile.create') }}" class="btn-pill btn-pill--primary">
                    <i class="ri-add-line"></i>
                    Create Profile
                </a>
            </div>
        @endif
    </div>
</div>
@endsection
