@extends('admin.layouts.layout')
@section('styles')
<style>
    :root {
        --primary: #4f46e5;
        --primary-light: #818cf8;
        --secondary: #06b6d4;
        --accent: #f59e0b;
        --success: #10b981;
        --warning: #f59e0b;
        --danger: #ef4444;
        --dark: #1f2937;
        --gray-50: #f9fafb;
        --gray-100: #f3f4f6;
        --gray-200: #e5e7eb;
        --gray-300: #d1d5db;
        --gray-400: #9ca3af;
        --gray-500: #6b7280;
        --gray-600: #4b5563;
        --gray-700: #374151;
        --gray-800: #1f2937;
        --white: #ffffff;
        --shadow-sm: 0 1px 2px 0 rgb(0 0 0 / 0.05);
        --shadow: 0 1px 3px 0 rgb(0 0 0 / 0.1), 0 1px 2px -1px rgb(0 0 0 / 0.1);
        --shadow-lg: 0 10px 15px -3px rgb(0 0 0 / 0.1), 0 4px 6px -4px rgb(0 0 0 / 0.1);
        --radius: 12px;
        --radius-lg: 16px;
    }

    * {
        box-sizing: border-box;
    }

    /* Sidebar */
    .sidebar {
        width: 280px;
        background: var(--white);
        border-right: 1px solid var(--gray-200);
        padding: 2rem 0;
        position: fixed;
        height: 100vh;
        left: 0;
        top: 0;
        z-index: 100;
        box-shadow: var(--shadow);
    }

    .sidebar-header {
        padding: 0 2rem 2rem 2rem;
        border-bottom: 1px solid var(--gray-200);
        margin-bottom: 2rem;
    }

    .sidebar-logo {
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--primary);
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .sidebar-nav {
        padding: 0 1rem;
    }

    .nav-item {
        margin-bottom: 0.5rem;
    }

    .nav-link {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        padding: 0.75rem 1rem;
        color: var(--gray-600);
        text-decoration: none;
        border-radius: var(--radius);
        transition: all 0.2s ease;
        font-weight: 500;
    }

    .nav-link:hover,
    .nav-link.active {
        background: var(--primary);
        color: var(--white);
    }

    .nav-link i {
        width: 20px;
        font-size: 1.1rem;
    }

    /* Main Content */
    .main-content {
        flex: 1;
        margin-left: 280px;
        padding: 2rem;
        background: var(--gray-50);
        min-height: 100vh;
    }

    /* Header */
    .content-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 2rem;
        background: var(--white);
        padding: 1.5rem 2rem;
        border-radius: var(--radius-lg);
        box-shadow: var(--shadow);
    }

    .page-title {
        font-size: 1.75rem;
        font-weight: 700;
        color: var(--gray-800);
        margin: 0;
    }

    .header-actions {
        display: flex;
        gap: 1rem;
        align-items: center;
    }

    .btn {
        padding: 0.75rem 1.5rem;
        border-radius: var(--radius);
        font-weight: 600;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        transition: all 0.2s ease;
        border: none;
        cursor: pointer;
        font-size: 0.875rem;
    }

    .btn-primary {
        background: var(--primary);
        color: var(--white);
    }

    .btn-primary:hover {
        background: var(--primary-light);
        transform: translateY(-1px);
    }

    .btn-outline {
        background: transparent;
        border: 1px solid var(--gray-300);
        color: var(--gray-700);
    }

    .btn-outline:hover {
        background: var(--gray-100);
    }

    /* Profile Cards */
    .profile-grid {
        display: grid;
        gap: 2rem;
        margin-top: 70px;
    }

    .profile-card {
        background: var(--white);
        border-radius: var(--radius-lg);
        box-shadow: var(--shadow);
        overflow: hidden;
        transition: all 0.3s ease;
    }

    .profile-card:hover {
        box-shadow: var(--shadow-lg);
        transform: translateY(-2px);
    }

    /* Profile Header */
    .profile-header {
        background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
        padding: 2rem;
        color: var(--white);
        position: relative;
        overflow: hidden;
    }

    .profile-header::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -20%;
        width: 200px;
        height: 200px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
    }

    .profile-main {
        display: flex;
        align-items: center;
        gap: 1.5rem;
        position: relative;
        z-index: 2;
    }

    .profile-avatar {
        position: relative;
    }

    .profile-img {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        object-fit: cover;
        border: 3px solid rgba(255, 255, 255, 0.3);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    }

    .profile-status {
        position: absolute;
        bottom: 2px;
        right: 2px;
        width: 16px;
        height: 16px;
        background: var(--success);
        border: 2px solid var(--white);
        border-radius: 50%;
    }

    .profile-info h2 {
        margin: 0 0 0.5rem 0;
        font-size: 1.5rem;
        font-weight: 700;
    }

    .profile-subtitle {
        opacity: 0.9;
        font-size: 1rem;
        margin: 0;
    }

    .profile-stats {
        display: flex;
        gap: 2rem;
        margin-top: 1.5rem;
    }

    .stat-item {
        text-align: center;
    }

    .stat-value {
        font-size: 1.25rem;
        font-weight: 700;
        margin: 0;
    }

    .stat-label {
        font-size: 0.875rem;
        opacity: 0.8;
        margin: 0;
    }

    /* Profile Content */
    .profile-content {
        padding: 0;
    }

    .profile-section {
        padding: 2rem;
        border-bottom: 1px solid var(--gray-200);
    }

    .profile-section:last-child {
        border-bottom: none;
    }

    .section-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 1.5rem;
    }

    .section-title {
        font-size: 1.125rem;
        font-weight: 600;
        color: var(--gray-800);
        margin: 0;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .section-title i {
        color: var(--primary);
    }

    /* Details Grid */
    .details-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1.5rem;
    }

    .detail-item {
        background: var(--gray-50);
        padding: 1rem;
        border-radius: var(--radius);
        border-left: 3px solid var(--primary);
    }

    .detail-label {
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: var(--gray-500);
        margin-bottom: 0.5rem;
    }

    .detail-value {
        font-size: 1rem;
        font-weight: 600;
        color: var(--gray-800);
    }

    /* Documents */
    .documents-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 1rem;
    }

    .document-card {
        background: var(--gray-50);
        border: 2px dashed var(--gray-300);
        border-radius: var(--radius);
        padding: 1.5rem;
        text-align: center;
        transition: all 0.2s ease;
    }

    .document-card:hover {
        border-color: var(--primary);
        background: var(--white);
    }

    .document-card.has-file {
        background: var(--white);
        border: 1px solid var(--gray-200);
        border-color: var(--success);
    }

    .document-icon {
        width: 48px;
        height: 48px;
        margin: 0 auto 1rem;
        background: var(--primary);
        color: var(--white);
        border-radius: var(--radius);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
    }

    .document-card.has-file .document-icon {
        background: var(--success);
    }

    .document-name {
        font-weight: 600;
        color: var(--gray-800);
        margin-bottom: 0.5rem;
    }

    .document-status {
        font-size: 0.875rem;
        color: var(--gray-500);
    }

    .document-action {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        color: var(--primary);
        font-weight: 600;
        text-decoration: none;
        font-size: 0.875rem;
        margin-top: 0.5rem;
    }

    .document-action:hover {
        color: var(--primary-light);
    }

    /* Gallery */
    .gallery-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(120px, 1fr));
        gap: 1rem;
    }

    .gallery-item {
        position: relative;
        aspect-ratio: 1;
        border-radius: var(--radius);
        overflow: hidden;
        box-shadow: var(--shadow);
        transition: all 0.3s ease;
    }

    .gallery-item:hover {
        transform: scale(1.05);
        box-shadow: var(--shadow-lg);
    }

    .gallery-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .gallery-more {
        background: var(--gray-100);
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 600;
        color: var(--gray-600);
        border: 2px dashed var(--gray-300);
    }

    /* Services */
    .services-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 1.5rem;
    }

    .service-card {
        background: var(--white);
        border: 1px solid var(--gray-200);
        border-radius: var(--radius);
        overflow: hidden;
        transition: all 0.3s ease;
    }

    .service-card:hover {
        box-shadow: var(--shadow-lg);
        transform: translateY(-2px);
        border-color: var(--primary);
    }

    .service-img-container {
        height: 160px;
        background: var(--gray-100);
        position: relative;
        overflow: hidden;
    }

    .service-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .service-placeholder {
        display: flex;
        align-items: center;
        justify-content: center;
        height: 100%;
        color: var(--gray-400);
        font-size: 2rem;
    }

    .service-content {
        padding: 1.5rem;
    }

    .service-name {
        font-size: 1.125rem;
        font-weight: 600;
        color: var(--gray-800);
        margin-bottom: 0.75rem;
    }

    .service-meta {
        display: flex;
        gap: 1rem;
        align-items: center;
    }

    .service-badge {
        background: var(--primary);
        color: var(--white);
        padding: 0.25rem 0.75rem;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 600;
    }

    .service-duration {
        color: var(--gray-500);
        font-size: 0.875rem;
    }

    /* Pricing */
    .pricing-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
        gap: 1.5rem;
    }

    .pricing-card {
        background: var(--white);
        border: 1px solid var(--gray-200);
        border-radius: var(--radius);
        padding: 1.5rem;
        position: relative;
        transition: all 0.3s ease;
    }

    .pricing-card:hover {
        border-color: var(--primary);
        box-shadow: var(--shadow-lg);
        transform: translateY(-2px);
    }

    .pricing-header {
        text-align: center;
        margin-bottom: 1rem;
    }

    .pricing-type {
        font-size: 0.875rem;
        font-weight: 600;
        color: var(--gray-600);
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .pricing-amount {
        font-size: 2rem;
        font-weight: 800;
        color: var(--primary);
        margin: 0.5rem 0;
    }

    .pricing-details {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding-top: 1rem;
        border-top: 1px solid var(--gray-200);
        font-size: 0.875rem;
        color: var(--gray-600);
    }

    /* Availability */
    .availability-list {
        space-y: 1rem;
    }

    .availability-item {
        background: var(--gray-50);
        border-radius: var(--radius);
        padding: 1.5rem;
        margin-bottom: 1rem;
    }

    .availability-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1rem;
    }

    .availability-month {
        font-size: 1.125rem;
        font-weight: 600;
        color: var(--gray-800);
    }

    .availability-duration {
        background: var(--primary);
        color: var(--white);
        padding: 0.25rem 0.75rem;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 600;
    }

    .availability-slots {
        display: flex;
        flex-wrap: wrap;
        gap: 0.75rem;
    }

    .slot-badge {
        background: var(--white);
        border: 1px solid var(--gray-300);
        padding: 0.5rem 1rem;
        border-radius: 20px;
        font-size: 0.875rem;
        font-weight: 500;
        color: var(--gray-700);
        transition: all 0.2s ease;
    }

    .slot-badge:hover {
        border-color: var(--primary);
        background: var(--primary);
        color: var(--white);
    }

    /* Empty States */
    .empty-state {
        text-align: center;
        padding: 3rem 2rem;
        color: var(--gray-500);
    }

    .empty-state i {
        font-size: 3rem;
        color: var(--gray-300);
        margin-bottom: 1rem;
    }

    .empty-state h3 {
        margin: 0 0 0.5rem 0;
        color: var(--gray-600);
    }

    /* Responsive */
    @media (max-width: 1024px) {
        .sidebar {
            transform: translateX(-100%);
        }
        
        .main-content {
            margin-left: 0;
        }
        
        .details-grid {
            grid-template-columns: 1fr;
        }
        
        .services-grid,
        .pricing-grid {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 640px) {
        .main-content {
            padding: 1rem;
        }
        
        .content-header {
            flex-direction: column;
            gap: 1rem;
            text-align: center;
        }
        
        .profile-main {
            flex-direction: column;
            text-align: center;
        }
        
        .profile-stats {
            justify-content: center;
        }
    }
</style>
@endsection

@section('content')
<div class="dashboard-container">

    <!-- Main Content -->
    <div class="main-content">
        <!-- Header -->
        <!-- Profile Grid -->
        <div class="profile-grid">
            @foreach($profiles as $profile)
                <div class="profile-card">
                    <!-- Profile Header -->
                    <div class="profile-header">
                        <div class="profile-main">
                            <div class="profile-avatar">
                                <img src="{{ $profile->photo ? asset($profile->photo) : asset('default.jpg') }}" 
                                     class="profile-img" alt="Profile">
                                <div class="profile-status"></div>
                            </div>
                            <div class="profile-info">
                                <h2>{{ $profile->name }}</h2>
                                <p class="profile-subtitle">{{ $profile->specialization }}</p>
                            </div>
                        </div>
                        
                        <div class="profile-stats">
                            <div class="stat-item">
                                <div class="stat-value">{{ $profile->experience }}</div>
                                <div class="stat-label">Years Exp.</div>
                            </div>
                            <div class="stat-item">
                                <div class="stat-value">₹{{ number_format($profile->starting_price) }}</div>
                                <div class="stat-label">Starting Price</div>
                            </div>
                            <div class="stat-item">
                                <div class="stat-value">{{ \Carbon\Carbon::parse($profile->created_at)->format('M Y') }}</div>
                                <div class="stat-label">Member Since</div>
                            </div>
                        </div>
                    </div>

                    <!-- Profile Content -->
                    <div class="profile-content">
                        <!-- Basic Details -->
                        <div class="profile-section">
                            <div class="section-header">
                                <h3 class="section-title">
                                    <i class="fas fa-user"></i>
                                    Contact Information
                                </h3>
                            </div>
                            
                            <div class="details-grid">
                                <div class="detail-item">
                                    <div class="detail-label">Email Address</div>
                                    <div class="detail-value">{{ $profile->email }}</div>
                                </div>
                                <div class="detail-item">
                                    <div class="detail-label">Phone Number</div>
                                    <div class="detail-value">{{ $profile->phone }}</div>
                                </div>
                            </div>
                        </div>

                        <!-- Documents -->
                        <div class="profile-section">
                            <div class="section-header">
                                <h3 class="section-title">
                                    <i class="fas fa-file-alt"></i>
                                    Documents
                                </h3>
                            </div>
                            
                            <div class="documents-grid">
                                <div class="document-card {{ $profile->qualification_document ? 'has-file' : '' }}">
                                    <div class="document-icon">
                                        <i class="fas fa-graduation-cap"></i>
                                    </div>
                                    <div class="document-name">Qualification Certificate</div>
                                    <div class="document-status">
                                        @if($profile->qualification_document)
                                            <a href="{{ asset($profile->qualification_document) }}" target="_blank" class="document-action">
                                                <i class="fas fa-eye"></i>
                                                View Document
                                            </a>
                                        @else
                                            <span style="color: var(--gray-400);">Not uploaded</span>
                                        @endif
                                    </div>
                                </div>
                                
                                <div class="document-card {{ $profile->aadhaar_card ? 'has-file' : '' }}">
                                    <div class="document-icon">
                                        <i class="fas fa-id-card"></i>
                                    </div>
                                    <div class="document-name">Aadhaar Card</div>
                                    <div class="document-status">
                                        @if($profile->aadhaar_card)
                                            <a href="{{ asset($profile->aadhaar_card) }}" target="_blank" class="document-action">
                                                <i class="fas fa-eye"></i>
                                                View Document
                                            </a>
                                        @else
                                            <span style="color: var(--gray-400);">Not uploaded</span>
                                        @endif
                                    </div>
                                </div>
                                
                                <div class="document-card {{ $profile->pan_card ? 'has-file' : '' }}">
                                    <div class="document-icon">
                                        <i class="fas fa-credit-card"></i>
                                    </div>
                                    <div class="document-name">PAN Card</div>
                                    <div class="document-status">
                                        @if($profile->pan_card)
                                            <a href="{{ asset($profile->pan_card) }}" target="_blank" class="document-action">
                                                <i class="fas fa-eye"></i>
                                                View Document
                                            </a>
                                        @else
                                            <span style="color: var(--gray-400);">Not uploaded</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Gallery -->
                        <div class="profile-section">
                            <div class="section-header">
                                <h3 class="section-title">
                                    <i class="fas fa-images"></i>
                                    Gallery
                                </h3>
                            </div>
                            
                            @php
                                $gallery = is_array($profile->gallery) ? $profile->gallery : json_decode($profile->gallery, true);
                            @endphp
                            
                            @if ($gallery && is_array($gallery) && count($gallery) > 0)
                                <div class="gallery-grid">
                                    @foreach (array_slice($gallery, 0, 8) as $img)
                                        <div class="gallery-item">
                                            <img src="{{ asset($img) }}" alt="Gallery Image" class="gallery-img">
                                        </div>
                                    @endforeach
                                    @if(count($gallery) > 8)
                                        <div class="gallery-item gallery-more">
                                            +{{ count($gallery) - 8 }} more
                                        </div>
                                    @endif
                                </div>
                            @else
                                <div class="empty-state">
                                    <i class="fas fa-images"></i>
                                    <h3>No Images</h3>
                                    <p>No gallery images have been uploaded yet.</p>
                                </div>
                            @endif
                        </div>

                        <!-- Services -->
                        <div class="profile-section">
                            <div class="section-header">
                                <h3 class="section-title">
                                    <i class="fas fa-concierge-bell"></i>
                                    Services Offered
                                </h3>
                            </div>
                            
                            @if($services->count() > 0)
                                <div class="services-grid">
                                    @foreach($services as $service)
                                        <div class="service-card">
                                            <div class="service-img-container">
                                                @if($service->image_path)
                                                    <img src="{{ asset($service->image_path) }}" alt="{{ $service->service_name }}" class="service-img">
                                                @else
                                                    <div class="service-placeholder">
                                                        <i class="fas fa-image"></i>
                                                    </div>
                                                @endif
                                            </div>
                                            
                                            <div class="service-content">
                                                <h4 class="service-name">{{ $service->service_name }}</h4>
                                                <div class="service-meta">
                                                    <span class="service-badge">{{ $service->category }}</span>
                                                    <span class="service-duration">{{ $service->duration }} mins</span>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="empty-state">
                                    <i class="fas fa-concierge-bell"></i>
                                    <h3>No Services</h3>
                                    <p>No services have been listed yet.</p>
                                </div>
                            @endif
                        </div>

                        <!-- Pricing -->
                        <div class="profile-section">
                            <div class="section-header">
                                <h3 class="section-title">
                                    <i class="fas fa-money-bill-wave"></i>
                                    Pricing Plans
                                </h3>
                            </div>
                            
                            @if($rates->count() > 0)
                                <div class="pricing-grid">
                                    @foreach($rates as $rate)
                                        <div class="pricing-card">
                                            <div class="pricing-header">
                                                <div class="pricing-type">{{ $rate->session_type }}</div>
                                                <div class="pricing-amount">₹{{ number_format($rate->final_rate, 2) }}</div>
                                            </div>
                                            <div class="pricing-details">
                                                <span>{{ $rate->num_sessions }} sessions</span>
                                                <span>{{ $rate->duration }}</span>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="empty-state">
                                    <i class="fas fa-money-bill-wave"></i>
                                    <h3>No Pricing</h3>
                                    <p>No pricing information has been set up yet.</p>
                                </div>
                            @endif
                        </div>

                        <!-- Availability -->
                        <div class="profile-section">
                            <div class="section-header">
                                <h3 class="section-title">
                                    <i class="fas fa-calendar-check"></i>
                                    Availability Schedule
                                </h3>
                            </div>
                            
                            @if($availabilities->count() > 0)
                                <div class="availability-list">
                                    @foreach($availabilities as $availability)
                                        <div class="availability-item">
                                            <div class="availability-header">
                                                <div class="availability-month">{{ $availability->month }}</div>
                                                <div class="availability-duration">{{ $availability->session_duration }} min sessions</div>
                                            </div>
                                            
                                            <div class="availability-slots">
                                                @foreach($availability->slots as $slot)
                                                    <div class="slot-badge">
                                                        {{ $slot->start_time }} - {{ $slot->end_time }}
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="empty-state">
                                    <i class="fas fa-calendar-times"></i>
                                    <h3>No Availability</h3>
                                    <p>No availability schedule has been set up yet.</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection