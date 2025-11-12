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

    .profile-actions .btn:hover {
        background: rgba(255, 255, 255, 0.9) !important;
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(79, 70, 229, 0.3);
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
                                <img src="{{ $profile->photo ? asset('storage/'.$profile->photo) : asset('default.jpg') }}" 
                                     class="profile-img" alt="Profile">
                                <div class="profile-status"></div>
                            </div>
                            <div class="profile-info">
                                <h2>{{ $profile->name }}</h2>
                                <p class="profile-subtitle">
                                    @if($services->count() > 0)
                                        {{ $services->first()->service->name ?? $services->first()->service_name ?? $profile->specialization }}
                                    @else
                                        {{ $profile->specialization ?? 'Professional' }}
                                    @endif
                                </p>
                            </div>
                        </div>
                        
                        <div class="profile-stats">
                            <div class="stat-item">
                                <div class="stat-value">{{ $profile->experience }}</div>
                                <div class="stat-label">Years Exp.</div>
                            </div>
                            <div class="stat-item">
                                <div class="stat-value">
                                    @if($profile->starting_price)
                                        ₹{{ $profile->starting_price }}
                                    @else
                                        N/A
                                    @endif
                                </div>
                                <div class="stat-label">Starting Price</div>
                            </div>
                            <div class="stat-item">
                                <div class="stat-value">{{ \Carbon\Carbon::parse($profile->created_at)->format('M Y') }}</div>
                                <div class="stat-label">Member Since</div>
                            </div>
                        </div>
                        
                        <!-- Edit Button -->
                        <div class="profile-actions" style="margin-top: 1.5rem;">
                            <button onclick="confirmEdit({{ $professional->id }})" class="btn btn-primary" style="background: var(--white); color: var(--primary); border: 2px solid var(--white);">
                                <i class="fas fa-edit"></i>
                                Edit Professional
                            </button>
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
                                <div class="detail-item">
                                    <div class="detail-label">Address</div>
                                    <div class="detail-value">{{ $profile->address ?: 'Not provided' }}</div>
                                </div>
                                @if($profile->gst_number)
                                <div class="detail-item">
                                    <div class="detail-label">GST Number</div>
                                    <div class="detail-value">{{ $profile->gst_number }}</div>
                                </div>
                                @endif
                                @if($profile->state_code)
                                <div class="detail-item">
                                    <div class="detail-label">State Code</div>
                                    <div class="detail-value">{{ $profile->state_code }} - {{ $profile->state_name ?? 'N/A' }}</div>
                                </div>
                                @endif
                                @if($profile->gst_address)
                                <div class="detail-item">
                                    <div class="detail-label">GST Address</div>
                                    <div class="detail-value">{{ $profile->gst_address }}</div>
                                </div>
                                @endif
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
                                            <a href="{{ asset('storage/'.$profile->qualification_document) }}" target="_blank" class="document-action">
                                                <i class="fas fa-eye"></i>
                                                View Document
                                            </a>
                                        @else
                                            <span style="color: var(--gray-400);">Not uploaded</span>
                                        @endif
                                    </div>
                                </div>
                                
                                <div class="document-card {{ $profile->id_proof_document ? 'has-file' : '' }}">
                                    <div class="document-icon">
                                        <i class="fas fa-id-card"></i>
                                    </div>
                                    <div class="document-name">ID Proof Document (Aadhaar / PAN Card)</div>
                                    <div class="document-status">
                                        @if($profile->id_proof_document)
                                            <a href="{{ asset('storage/'.$profile->id_proof_document) }}" target="_blank" class="document-action">
                                                <i class="fas fa-eye"></i>
                                                View Document
                                            </a>
                                        @else
                                            <span style="color: var(--gray-400);">Not uploaded</span>
                                        @endif
                                    </div>
                                </div>
                            
                                @if($profile->gst_number)
                                <div class="document-card {{ $profile->gst_certificate ? 'has-file' : '' }}">
                                    <div class="document-icon">
                                        <i class="fas fa-file-invoice-dollar"></i>
                                    </div>
                                    <div class="document-name">GST Certificate</div>
                                    <div class="document-status">
                                        @if($profile->gst_certificate)
                                            <a href="{{ asset('storage/'.$profile->gst_certificate) }}" target="_blank" class="document-action">
                                                <i class="fas fa-eye"></i>
                                                View Document
                                            </a>
                                        @else
                                            <span style="color: var(--gray-400);">Not uploaded</span>
                                        @endif
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>

                        <!-- Bank Account Details -->
                        <div class="profile-section">
                            <div class="section-header">
                                <h3 class="section-title">
                                    <i class="fas fa-university"></i>
                                    Bank Account Details
                                </h3>
                                <div class="header-actions">
                                    @if($profile->account_number && $profile->ifsc_code && $profile->account_holder_name && $profile->bank_name)
                                        <button onclick="downloadBankDetails({{ $profile->id }})" class="btn btn-outline">
                                            <i class="fas fa-download"></i>
                                            Download Details
                                        </button>
                                    @endif
                                </div>
                            </div>
                            
                            <div class="details-grid">
                                <div class="detail-item">
                                    <div class="detail-label">Account Holder Name</div>
                                    <div class="detail-value">{{ $profile->account_holder_name ?: 'Not provided' }}</div>
                                </div>
                                <div class="detail-item">
                                    <div class="detail-label">Bank Name</div>
                                    <div class="detail-value">{{ $profile->bank_name ?: 'Not provided' }}</div>
                                </div>
                                <div class="detail-item">
                                    <div class="detail-label">Account Number</div>
                                    <div class="detail-value">
                                        @if($profile->account_number)
                                            <span id="account-{{ $profile->id }}" style="display: none;">{{ $profile->account_number }}</span>
                                            <span id="masked-{{ $profile->id }}">{{ str_repeat('*', strlen($profile->account_number) - 4) . substr($profile->account_number, -4) }}</span>
                                            <button onclick="toggleAccountNumber({{ $profile->id }})" class="btn" style="padding: 0.25rem 0.5rem; margin-left: 0.5rem; font-size: 0.75rem;">
                                                <i id="eye-{{ $profile->id }}" class="fas fa-eye"></i>
                                            </button>
                                        @else
                                            Not provided
                                        @endif
                                    </div>
                                </div>
                                <div class="detail-item">
                                    <div class="detail-label">IFSC Code</div>
                                    <div class="detail-value">{{ $profile->ifsc_code ?: 'Not provided' }}</div>
                                </div>
                                @if($profile->account_type)
                                <div class="detail-item">
                                    <div class="detail-label">Account Type</div>
                                    <div class="detail-value">{{ ucfirst($profile->account_type) }}</div>
                                </div>
                                @endif
                                @if($profile->bank_branch)
                                <div class="detail-item">
                                    <div class="detail-label">Branch</div>
                                    <div class="detail-value">{{ $profile->bank_branch }}</div>
                                </div>
                                @endif
                            </div>
                            
                            @if($profile->bank_document)
                            <div class="documents-grid" style="margin-top: 1.5rem;">
                                <div class="document-card has-file">
                                    <div class="document-icon">
                                        <i class="fas fa-file-invoice"></i>
                                    </div>
                                    <div class="document-name">Bank Account Proof</div>
                                    <div class="document-status">
                                        <a href="{{ asset('storage/'.$profile->bank_document) }}" target="_blank" class="document-action">
                                            <i class="fas fa-eye"></i>
                                            View Document
                                        </a>
                                    </div>
                                </div>
                            </div>
                            @else
                            <div class="empty-state" style="padding: 1.5rem; margin-top: 1rem;">
                                <i class="fas fa-file-invoice"></i>
                                <h3>No Bank Document</h3>
                                <p>Professional hasn't uploaded bank account proof yet</p>
                            </div>
                            @endif
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
                                            <img src="{{ asset('storage/'.$img) }}" alt="Gallery Image" class="gallery-img">
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
                                <div class="header-actions">
                                    <button onclick="editServices({{ $professional->id }})" class="btn btn-outline">
                                        <i class="fas fa-edit"></i>
                                        Edit Services
                                    </button>
                                </div>
                            </div>
                            
                            @if($services->count() > 0)
                                <div class="services-list">
                                    @foreach($services as $service)
                                        <div class="service-item" style="background: white; border: 1px solid var(--gray-200); border-radius: var(--radius); padding: 1.5rem; margin-bottom: 1rem; box-shadow: var(--shadow-sm);">
                                            <!-- Service Header -->
                                            <div class="service-header" style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 1rem;">
                                                <div style="flex: 1;">
                                                    <h6 style="margin: 0 0 0.5rem 0; color: var(--gray-800); font-weight: 600; font-size: 1.1rem;">
                                                        <i class="fas fa-concierge-bell" style="color: var(--primary); margin-right: 0.5rem;"></i>
                                                        {{ $service->service->name ?? $service->service_name }}
                                                    </h6>
                                                    
                                                    <!-- Service Meta Information -->
                                                    <div style="display: flex; flex-wrap: wrap; gap: 0.5rem; margin-bottom: 0.75rem;">
                                                        @if($service->price)
                                                            <span style="background: #dcfce7; color: #166534; padding: 0.25rem 0.75rem; border-radius: 4px; font-size: 0.75rem; font-weight: 500;">
                                                                <i class="fas fa-rupee-sign" style="margin-right: 0.25rem;"></i>{{ number_format($service->price, 2) }}
                                                            </span>
                                                        @endif
                                                        @if($service->category)
                                                            <span style="background: #fef3c7; color: #92400e; padding: 0.25rem 0.75rem; border-radius: 4px; font-size: 0.75rem; font-weight: 500;">
                                                                <i class="fas fa-tag" style="margin-right: 0.25rem;"></i>{{ $service->category }}
                                                            </span>
                                                        @endif
                                                    </div>
                                                </div>
                                                
                                                <!-- Service Image -->
                                                @if($service->image_path)
                                                    <div style="width: 80px; height: 80px; border-radius: 8px; overflow: hidden; margin-left: 1rem; flex-shrink: 0;">
                                                        <img src="{{ asset($service->image_path) }}" alt="{{ $service->service_name }}" style="width: 100%; height: 100%; object-fit: cover;">
                                                    </div>
                                                @else
                                                    <div style="width: 80px; height: 80px; border-radius: 8px; background: var(--gray-100); display: flex; align-items: center; justify-content: center; margin-left: 1rem; flex-shrink: 0; border: 1px solid var(--gray-200);">
                                                        <i class="fas fa-image" style="color: var(--gray-400); font-size: 1.5rem;"></i>
                                                    </div>
                                                @endif
                                            </div>

                                            <!-- Service Description -->
                                            @if($service->description)
                                                <div style="margin-bottom: 1rem; padding: 0.75rem; background: var(--gray-50); border-radius: 6px; border-left: 3px solid var(--primary);">
                                                    <strong style="color: var(--gray-700); font-size: 0.9rem;">Description:</strong>
                                                    <p style="margin: 0.5rem 0 0 0; color: var(--gray-600); line-height: 1.5;">{{ $service->description }}</p>
                                                </div>
                                            @endif

                                            <!-- Service Requirements -->
                                            @if($service->requirements)
                                                <div style="margin-bottom: 1rem; padding: 0.75rem; background: #fef7cd; border-radius: 6px; border-left: 3px solid #f59e0b;">
                                                    <strong style="color: #92400e; font-size: 0.9rem;">Requirements:</strong>
                                                    <p style="margin: 0.5rem 0 0 0; color: #92400e; line-height: 1.5;">{{ $service->requirements }}</p>
                                                </div>
                                            @endif

                                            <!-- Service Features -->
                                            @php
                                                $serviceFeatures = $service->features;
                                                if (is_string($serviceFeatures)) {
                                                    $decoded = json_decode($serviceFeatures, true);
                                                    $serviceFeatures = is_array($decoded) ? $decoded : [];
                                                }
                                                if (!is_array($serviceFeatures)) {
                                                    $serviceFeatures = [];
                                                }
                                            @endphp
                                            @if(count($serviceFeatures) > 0)
                                                <div style="margin-bottom: 1rem;">
                                                    <strong style="color: var(--gray-600); display: block; margin-bottom: 0.75rem; font-size: 0.9rem;">
                                                        <i class="fas fa-star" style="margin-right: 0.25rem;"></i>Features:
                                                    </strong>
                                                    <div style="display: flex; flex-wrap: wrap; gap: 0.5rem;">
                                                        @foreach($serviceFeatures as $feature)
                                                            <span style="background: #f0f9ff; color: #0369a1; padding: 0.4rem 0.8rem; border-radius: 4px; font-size: 0.85rem; border: 1px solid #bae6fd;">
                                                                <i class="fas fa-check" style="font-size: 0.75rem; margin-right: 0.25rem;"></i> {{ ucfirst(str_replace(['_', '-'], ' ', $feature)) }}
                                                            </span>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            @endif

                                            <!-- Service Tags -->
                                            @if($service->tags)
                                                <div style="margin-bottom: 1rem;">
                                                    <strong style="color: var(--gray-600); display: block; margin-bottom: 0.75rem; font-size: 0.9rem;">
                                                        <i class="fas fa-tags" style="margin-right: 0.25rem;"></i>Tags:
                                                    </strong>
                                                    <div style="background: var(--gray-50); padding: 0.75rem; border-radius: 6px; border: 1px solid var(--gray-200); font-size: 0.9rem; color: var(--gray-700);">
                                                        {{ $service->tags }}
                                                    </div>
                                                </div>
                                            @endif

                                            <!-- Sub-Services (if any) -->
                                            @if($service->subServices && $service->subServices->count() > 0)
                                                <div style="margin-top: 1rem;">
                                                    <strong style="color: var(--gray-600); display: block; margin-bottom: 0.75rem; font-size: 0.9rem;">
                                                        <i class="fas fa-list" style="margin-right: 0.25rem;"></i>Sub-Services:
                                                    </strong>
                                                    <div style="display: flex; flex-wrap: wrap; gap: 0.5rem;">
                                                        @foreach($service->subServices as $subService)
                                                            <span style="background: #e0f2fe; color: #0277bd; padding: 0.4rem 0.8rem; border-radius: 4px; font-size: 0.85rem; border: 1px solid #b3e5fc;">
                                                                <i class="fas fa-arrow-right" style="font-size: 0.75rem; margin-right: 0.25rem;"></i> {{ $subService->name }}
                                                            </span>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            @endif
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
                                <div class="header-actions">
                                    <button onclick="editRates({{ $professional->id }})" class="btn btn-outline">
                                        <i class="fas fa-edit"></i>
                                        Edit Rates
                                    </button>
                                </div>
                            </div>
                            
                            @if($rates->count() > 0)
                                <div class="pricing-list">
                                    @foreach($rates as $rate)
                                        <div class="pricing-item" style="background: white; border: 1px solid var(--gray-200); border-radius: var(--radius); padding: 1.5rem; margin-bottom: 1rem; box-shadow: var(--shadow-sm);">
                                            <!-- Rate Header -->
                                            <div class="pricing-header" style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 1rem;">
                                                <div style="flex: 1;">
                                                    <h6 style="margin: 0 0 0.5rem 0; color: var(--gray-800); font-weight: 600; font-size: 1.1rem;">
                                                        <i class="fas fa-money-bill-wave" style="color: var(--primary); margin-right: 0.5rem;"></i>
                                                        {{ $rate->session_type }}
                                                    </h6>
                                                    
                                                    <!-- Service/Sub-Service Information -->
                                                    @if($rate->sub_service_id && $rate->subService)
                                                        <div style="margin-bottom: 0.75rem;">
                                                            <span style="background: #dbeafe; color: #1e40af; padding: 0.25rem 0.75rem; border-radius: 4px; font-size: 0.75rem; font-weight: 500; margin-right: 0.5rem;">
                                                                Service: {{ $rate->subService->service->name ?? 'N/A' }}
                                                            </span>
                                                            <span style="background: #f3f4f6; color: #374151; padding: 0.25rem 0.75rem; border-radius: 4px; font-size: 0.75rem; font-weight: 500;">
                                                                Sub-Service: {{ $rate->subService->name }}
                                                            </span>
                                                        </div>
                                                    @else
                                                        @php
                                                            // For general rates, show the main service name from professional's services
                                                            $mainService = $services->first()->service_name ?? 'General Service';
                                                        @endphp
                                                        <div style="margin-bottom: 0.75rem;">
                                                            <span style="background: #dcfce7; color: #166534; padding: 0.25rem 0.75rem; border-radius: 4px; font-size: 0.75rem; font-weight: 500; margin-right: 0.5rem;">
                                                                Service: {{ $mainService }}
                                                            </span>
                                                            <span style="background: #dbeafe; color: #1e40af; padding: 0.25rem 0.75rem; border-radius: 4px; font-size: 0.75rem; font-weight: 500;">
                                                                General Rate (All Sub-Services)
                                                            </span>
                                                        </div>
                                                    @endif
                                                </div>
                                                
                                                <!-- Total Amount -->
                                                <div style="text-align: right;">
                                                    <div style="font-size: 1.5rem; font-weight: 700; color: var(--primary); margin: 0;">
                                                        ₹{{ number_format($rate->final_rate, 2) }}
                                                    </div>
                                                    <small style="color: var(--gray-500); font-size: 0.75rem;">Total Amount</small>
                                                </div>
                                            </div>

                                            <!-- Rate Details -->
                                            <div class="pricing-meta" style="margin-bottom: 1rem;">
                                                <div style="display: flex; gap: 1rem; flex-wrap: wrap; margin-bottom: 0.5rem;">
                                                    <div style="display: flex; align-items: center; gap: 0.5rem;">
                                                        <i class="fas fa-calendar-check" style="color: var(--primary);"></i>
                                                        <strong>Sessions:</strong> {{ $rate->num_sessions }}
                                                    </div>
                                                    <div style="display: flex; align-items: center; gap: 0.5rem;">
                                                        <i class="fas fa-rupee-sign" style="color: var(--primary);"></i>
                                                        <strong>Per Session:</strong> ₹{{ number_format($rate->rate_per_session, 2) }}
                                                    </div>
                                                </div>
                                                
                                                <!-- Calculation Display -->
                                                <div style="background: var(--gray-50); padding: 0.75rem; border-radius: 6px; border: 1px solid var(--gray-200); font-size: 0.9rem; color: var(--gray-700);">
                                                    <i class="fas fa-calculator" style="margin-right: 0.5rem; color: var(--primary);"></i>
                                                    <strong>Calculation:</strong> {{ $rate->num_sessions }} × ₹{{ number_format($rate->rate_per_session, 2) }} = ₹{{ number_format($rate->final_rate, 2) }}
                                                </div>
                                            </div>

                                            <!-- Features (if available) -->
                                            @if($rate->features && count($rate->features) > 0)
                                                <div style="margin-top: 1rem;">
                                                    <strong style="color: var(--gray-600); display: block; margin-bottom: 0.75rem; font-size: 0.9rem;">
                                                        <i class="fas fa-list-check" style="margin-right: 0.25rem;"></i>Features Included:
                                                    </strong>
                                                    <div style="display: flex; flex-wrap: wrap; gap: 0.5rem;">
                                                        @foreach($rate->features as $feature)
                                                            @if(trim($feature))
                                                                <span style="background: #f0f9ff; color: #0369a1; padding: 0.4rem 0.8rem; border-radius: 4px; font-size: 0.85rem; border: 1px solid #bae6fd;">
                                                                    <i class="fas fa-check" style="font-size: 0.75rem; margin-right: 0.25rem;"></i> {{ $feature }}
                                                                </span>
                                                            @endif
                                                        @endforeach
                                                    </div>
                                                </div>
                                            @endif
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

                        <!-- Commission & Service Request Settings -->
                        <div class="profile-section">
                            <div class="section-header">
                                <h3 class="section-title">
                                    <i class="fas fa-percentage"></i>
                                    Commission & Service Request Settings
                                </h3>
                                <div class="header-actions">
                                    <button onclick="editCommissionSettings({{ $professional->id }})" class="btn btn-outline">
                                        <i class="fas fa-edit"></i>
                                        Edit Settings
                                    </button>
                                </div>
                            </div>
                            
                            <div class="details-grid">
                                <!-- Regular Session Margin -->
                                <div class="detail-item" style="border-left-color: var(--primary);">
                                    <div class="detail-label">
                                        <i class="fas fa-handshake"></i>
                                        Regular Session Margin
                                    </div>
                                    <div class="detail-value">
                                        {{ number_format($professional->margin ?? 0, 2) }}%
                                    </div>
                                    <small style="color: var(--gray-500); font-size: 0.75rem; margin-top: 0.25rem; display: block;">
                                        Commission for regular booking sessions
                                    </small>
                                </div>

                                <!-- Service Request Margin -->
                                <div class="detail-item" style="border-left-color: var(--success);">
                                    <div class="detail-label">
                                        <i class="fas fa-plus-circle"></i>
                                        Service Request Margin
                                    </div>
                                    <div class="detail-value">
                                        {{ number_format($professional->service_request_margin ?? 0, 2) }}%
                                    </div>
                                    <small style="color: var(--gray-500); font-size: 0.75rem; margin-top: 0.25rem; display: block;">
                                        Commission for additional service requests
                                    </small>
                                </div>

                                <!-- Negotiation Offset -->
                                <div class="detail-item" style="border-left-color: var(--warning);">
                                    <div class="detail-label">
                                        <i class="fas fa-arrows-alt-v"></i>
                                        Negotiation Offset
                                    </div>
                                    <div class="detail-value">
                                        {{ number_format($professional->service_request_offset ?? 0, 2) }}%
                                    </div>
                                    <small style="color: var(--gray-500); font-size: 0.75rem; margin-top: 0.25rem; display: block;">
                                        Maximum negotiation limit for customers
                                    </small>
                                </div>
                            </div>

                            <!-- Earnings Calculator -->
                            <div style="margin-top: 2rem; padding: 1.5rem; background: var(--gray-50); border-radius: var(--radius); border: 1px solid var(--gray-200);">
                                <h4 style="margin: 0 0 1rem 0; color: var(--gray-800); font-size: 1rem; font-weight: 600;">
                                    <i class="fas fa-calculator" style="color: var(--primary);"></i>
                                    Earnings Calculator (Example for ₹1000 service)
                                </h4>
                                
                                <div class="details-grid" style="gap: 1rem;">
                                    <div style="background: var(--white); padding: 1rem; border-radius: var(--radius); border: 1px solid var(--gray-200);">
                                        <div style="font-size: 0.75rem; font-weight: 600; color: var(--primary); text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 0.5rem;">
                                            Regular Session
                                        </div>
                                        <div style="font-size: 1.25rem; font-weight: 700; color: var(--gray-800);">
                                            ₹{{ number_format(1000 - (1000 * ($professional->margin ?? 0) / 100), 2) }}
                                        </div>
                                        <div style="font-size: 0.75rem; color: var(--gray-500);">
                                            Professional receives
                                        </div>
                                    </div>

                                    <div style="background: var(--white); padding: 1rem; border-radius: var(--radius); border: 1px solid var(--gray-200);">
                                        <div style="font-size: 0.75rem; font-weight: 600; color: var(--success); text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 0.5rem;">
                                            Service Request
                                        </div>
                                        <div style="font-size: 1.25rem; font-weight: 700; color: var(--gray-800);">
                                            ₹{{ number_format(1000 - (1000 * ($professional->service_request_margin ?? 0) / 100), 2) }}
                                        </div>
                                        <div style="font-size: 0.75rem; color: var(--gray-500);">
                                            Professional receives
                                        </div>
                                    </div>

                                    <div style="background: var(--white); padding: 1rem; border-radius: var(--radius); border: 1px solid var(--gray-200);">
                                        <div style="font-size: 0.75rem; font-weight: 600; color: var(--warning); text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 0.5rem;">
                                            Min Negotiated Price
                                        </div>
                                        <div style="font-size: 1.25rem; font-weight: 700; color: var(--gray-800);">
                                            ₹{{ number_format(1000 - (1000 * ($professional->service_request_offset ?? 0) / 100), 2) }}
                                        </div>
                                        <div style="font-size: 0.75rem; color: var(--gray-500);">
                                            Customer can't go below
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Availability -->
                        <div class="profile-section">
                            <div class="section-header">
                                <h3 class="section-title">
                                    <i class="fas fa-calendar-check"></i>
                                    Availability Schedule
                                </h3>
                                <div class="header-actions">
                                    <button onclick="editAvailability({{ $professional->id }})" class="btn btn-outline">
                                        <i class="fas fa-edit"></i>
                                        Edit Availability
                                    </button>
                                </div>
                            </div>
                            
                            @if($availabilities->count() > 0)
                                <div class="availability-list">
                                    @foreach($availabilities as $availability)
                                        <div class="availability-item" style="background: white; border: 1px solid var(--gray-200); border-radius: var(--radius); padding: 1.5rem; margin-bottom: 1rem; box-shadow: var(--shadow-sm);">
                                            @php
                                                // Normalize month display: handle 'all_months', 'Y-m' and old short names
                                                $monthValue = $availability->month;

                                                if ($monthValue === 'all_months') {
                                                    $months = [];
                                                    $currentDate = now();
                                                    for ($i = 0; $i < 6; $i++) {
                                                        $months[] = $currentDate->copy()->addMonths($i)->format('F Y');
                                                    }
                                                    $fullMonth = implode(', ', $months);
                                                } elseif (strpos($monthValue, '-') !== false) {
                                                    try {
                                                        $fullMonth = \Carbon\Carbon::createFromFormat('Y-m', $monthValue)->format('F Y');
                                                    } catch (\Exception $e) {
                                                        $fullMonth = $monthValue;
                                                    }
                                                } else {
                                                    $monthNames = [
                                                        'jan' => 'January', 'feb' => 'February', 'mar' => 'March',
                                                        'apr' => 'April', 'may' => 'May', 'jun' => 'June',
                                                        'jul' => 'July', 'aug' => 'August', 'sep' => 'September',
                                                        'oct' => 'October', 'nov' => 'November', 'dec' => 'December'
                                                    ];
                                                    $fullMonth = $monthNames[strtolower($monthValue)] ?? ucfirst($monthValue);
                                                }
                                            @endphp
                                            
                                            <!-- Month Header -->
                                            <div class="availability-header" style="margin-bottom: 1rem;">
                                                <h6 style="margin: 0; color: var(--gray-800); font-weight: 600; font-size: 1.1rem;">
                                                    <i class="fas fa-calendar" style="color: var(--primary); margin-right: 0.5rem;"></i>
                                                    {{ $fullMonth }}
                                                </h6>
                                            </div>

                                            <!-- Session Duration -->
                                            <div class="availability-meta" style="margin-bottom: 1rem;">
                                                <div class="meta-item" style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 0.5rem;">
                                                    <i class="fas fa-clock" style="color: var(--primary);"></i>
                                                    <strong>Session:</strong> {{ $availability->session_duration }} min
                                                </div>
                                                
                                                @if($availability->weekdays)
                                                    @php
                                                        $weekdays = json_decode($availability->weekdays, true) ?? [];
                                                        $dayNames = [
                                                            'mon' => 'Mon', 'tue' => 'Tue', 'wed' => 'Wed', 
                                                            'thu' => 'Thu', 'fri' => 'Fri', 'sat' => 'Sat', 'sun' => 'Sun'
                                                        ];
                                                    @endphp
                                                    <div class="meta-item" style="display: flex; align-items: center; gap: 0.5rem; flex-wrap: wrap;">
                                                        <i class="fas fa-calendar" style="color: var(--primary);"></i>
                                                        <strong>Days:</strong>
                                                        <div style="display: flex; gap: 0.25rem; flex-wrap: wrap; margin-left: 0.5rem;">
                                                            @foreach($weekdays as $day)
                                                                <span style="background: #e0e7ff; color: #5b21b6; padding: 0.25rem 0.6rem; border-radius: 4px; font-size: 0.75rem; font-weight: 500;">
                                                                    {{ $dayNames[$day] ?? $day }}
                                                                </span>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>

                                            @if($availability->slots && $availability->slots->count() > 0)
                                                <div>
                                                    <strong style="color: var(--gray-600); display: block; margin-bottom: 0.75rem; font-size: 0.9rem;">
                                                        <i class="fas fa-clock" style="margin-right: 0.25rem;"></i>Time Slots by Weekday:
                                                    </strong>
                                                    @php
                                                        $dayNames = [
                                                            'mon' => 'Monday', 'tue' => 'Tuesday', 'wed' => 'Wednesday', 
                                                            'thu' => 'Thursday', 'fri' => 'Friday', 'sat' => 'Saturday', 'sun' => 'Sunday'
                                                        ];
                                                        $dayOrder = ['mon', 'tue', 'wed', 'thu', 'fri', 'sat', 'sun'];
                                                        
                                                        // Check if slots have weekday field
                                                        $firstSlot = $availability->slots->first();
                                                        $hasWeekdayField = $firstSlot && isset($firstSlot->weekday);
                                                        
                                                        if ($hasWeekdayField) {
                                                            // Group slots by their individual weekday field
                                                            $slotsByDay = $availability->slots->groupBy('weekday');
                                                        } else {
                                                            // Fallback: Show all slots under "All Days" if no weekday field exists
                                                            $slotsByDay = collect(['general' => $availability->slots]);
                                                        }
                                                        
                                                        // Sort by weekday order (if we have weekday-specific slots)
                                                        $sortedSlotsByDay = collect();
                                                        if ($hasWeekdayField) {
                                                            foreach ($dayOrder as $day) {
                                                                if ($slotsByDay->has($day)) {
                                                                    $sortedSlotsByDay->put($day, $slotsByDay->get($day));
                                                                }
                                                            }
                                                        } else {
                                                            $sortedSlotsByDay = $slotsByDay;
                                                        }
                                                    @endphp
                                                    
                                                    @if($sortedSlotsByDay->count() > 0)
                                                        @foreach($sortedSlotsByDay as $weekday => $daySlots)
                                                            <div style="margin-bottom: 1rem;">
                                                                <div style="display: flex; align-items: center; margin-bottom: 0.5rem;">
                                                                    @if($weekday === 'general')
                                                                        <span style="background: #e0e7ff; color: #5b21b6; padding: 0.25rem 0.6rem; border-radius: 4px; font-size: 0.75rem; font-weight: 500; margin-right: 0.5rem;">All Days</span>
                                                                    @else
                                                                        <span style="background: #e0e7ff; color: #5b21b6; padding: 0.25rem 0.6rem; border-radius: 4px; font-size: 0.75rem; font-weight: 500; margin-right: 0.5rem;">{{ $dayNames[$weekday] ?? ucfirst($weekday) }}</span>
                                                                    @endif
                                                                    <span style="color: var(--gray-500); font-size: 0.85rem;">({{ $daySlots->count() }} slot{{ $daySlots->count() > 1 ? 's' : '' }})</span>
                                                                </div>
                                                                <div style="display: flex; flex-wrap: wrap; gap: 0.5rem;">
                                                                    @foreach($daySlots as $slot)
                                                                        <span style="background: var(--gray-100); color: var(--gray-700); padding: 0.4rem 0.8rem; border-radius: 4px; font-size: 0.85rem; border: 1px solid var(--gray-200);">
                                                                            @php
                                                                                try {
                                                                                    $startTime = \Carbon\Carbon::parse($slot->start_time)->format('g:i A');
                                                                                } catch (\Exception $e) {
                                                                                    $startTime = $slot->start_time;
                                                                                }
                                                                                try {
                                                                                    $endTime = \Carbon\Carbon::parse($slot->end_time)->format('g:i A');
                                                                                } catch (\Exception $e) {
                                                                                    $endTime = $slot->end_time;
                                                                                }
                                                                            @endphp
                                                                            <i class="fas fa-clock" style="font-size: 0.75rem; margin-right: 0.25rem;"></i> {{ $startTime }} - {{ $endTime }}
                                                                        </span>
                                                                    @endforeach
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    @else
                                                        <div style="color: var(--gray-500); font-size: 0.9rem;">
                                                            <i class="fas fa-info-circle"></i> No slots could be displayed. Please check the availability configuration.
                                                        </div>
                                                    @endif
                                                </div>
                                            @else
                                                <div style="color: var(--gray-500); font-size: 0.9rem; text-align: center; padding: 1rem; background: var(--gray-50); border-radius: var(--radius);">
                                                    <i class="fas fa-exclamation-circle"></i> No time slots configured
                                                </div>
                                            @endif
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

<!-- Commission Settings Modal -->
<div class="modal fade" id="commissionModal" tabindex="-1" role="dialog" aria-labelledby="commissionModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content" style="border-radius: var(--radius-lg); border: none; box-shadow: var(--shadow-lg);">
            <div class="modal-header" style="background: linear-gradient(135deg, var(--primary), var(--primary-light)); color: white; border-radius: var(--radius-lg) var(--radius-lg) 0 0;">
                <h5 class="modal-title" id="commissionModalLabel" style="font-weight: 700;">
                    <i class="fas fa-percentage"></i>
                    Commission & Service Request Settings
                </h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close" style="color: white; opacity: 0.8;">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="commissionForm">
                @csrf
                <div class="modal-body" style="padding: 2rem;">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="margin" class="form-label">
                                    <i class="fas fa-handshake" style="color: var(--primary);"></i>
                                    Regular Session Margin (%)
                                </label>
                                <input type="number" class="form-control" id="margin" name="margin" 
                                       value="{{ number_format($professional->margin ?? 0, 2) }}" min="0" max="100" step="0.01"
                                       style="border-radius: var(--radius); border: 2px solid var(--gray-200);">
                                <small class="form-text text-muted">Commission percentage for regular booking sessions</small>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="service_request_margin" class="form-label">
                                    <i class="fas fa-plus-circle" style="color: var(--success);"></i>
                                    Service Request Margin (%)
                                </label>
                                <input type="number" class="form-control" id="service_request_margin" name="service_request_margin" 
                                       value="{{ number_format($professional->service_request_margin ?? $professional->margin ?? 0, 2) }}" min="0" max="100" step="0.01"
                                       style="border-radius: var(--radius); border: 2px solid var(--gray-200);">
                                <small class="form-text text-muted">Defaults to Regular Session Margin but is editable</small>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="service_request_offset" class="form-label">
                                    <i class="fas fa-arrows-alt-v" style="color: var(--warning);"></i>
                                    Negotiation Offset (%)
                                </label>
                                <input type="number" class="form-control" id="service_request_offset" name="service_request_offset" 
                                       value="{{ number_format($professional->service_request_offset ?? 10, 2) }}" min="0" max="100" step="0.01"
                                       style="border-radius: var(--radius); border: 2px solid var(--gray-200);">
                                <small class="form-text text-muted">Defaults to 10% but is editable</small>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Live Calculator -->
                    <div class="mt-4" style="padding: 1.5rem; background: var(--gray-50); border-radius: var(--radius); border: 1px solid var(--gray-200);">
                        <h6 style="margin: 0 0 1rem 0; color: var(--gray-800); font-weight: 600;">
                            <i class="fas fa-calculator" style="color: var(--primary);"></i>
                            Live Earnings Calculator (₹1000 Service Example)
                        </h6>
                        
                        <div class="row">
                            <div class="col-md-4">
                                <div style="background: var(--white); padding: 1rem; border-radius: var(--radius); border: 1px solid var(--gray-200); text-align: center;">
                                    <div style="font-size: 0.75rem; font-weight: 600; color: var(--primary); margin-bottom: 0.5rem;">
                                        Regular Session Professional Earns
                                    </div>
                                    <div id="regularEarning" style="font-size: 1.5rem; font-weight: 700; color: var(--success);">
                                        ₹{{ number_format(1000 - (1000 * ($professional->margin ?? 0) / 100), 2) }}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div style="background: var(--white); padding: 1rem; border-radius: var(--radius); border: 1px solid var(--gray-200); text-align: center;">
                                    <div style="font-size: 0.75rem; font-weight: 600; color: var(--success); margin-bottom: 0.5rem;">
                                        Service Request Professional Earns
                                    </div>
                                    <div id="serviceRequestEarning" style="font-size: 1.5rem; font-weight: 700; color: var(--success);">
                                        ₹{{ number_format(1000 - (1000 * ($professional->service_request_margin ?? $professional->margin ?? 0) / 100), 2) }}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div style="background: var(--white); padding: 1rem; border-radius: var(--radius); border: 1px solid var(--gray-200); text-align: center;">
                                    <div style="font-size: 0.75rem; font-weight: 600; color: var(--warning); margin-bottom: 0.5rem;">
                                        Min Customer Can Pay
                                    </div>
                                    <div id="minNegotiatedPrice" style="font-size: 1.5rem; font-weight: 700; color: var(--warning);">
                                        ₹{{ number_format(1000 - (1000 * ($professional->service_request_offset ?? 10) / 100), 2) }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer" style="padding: 1.5rem 2rem; border-top: 1px solid var(--gray-200);">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" 
                            style="border-radius: var(--radius); padding: 0.75rem 1.5rem;">
                        <i class="fas fa-times"></i> Cancel
                    </button>
                    <button type="submit" class="btn" 
                            style="background: var(--primary); color: white; border-radius: var(--radius); padding: 0.75rem 1.5rem; border: none;">
                        <i class="fas fa-save"></i> Save Changes
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
// Toggle account number visibility
function toggleAccountNumber(profileId) {
    const accountSpan = document.getElementById(`account-${profileId}`);
    const maskedSpan = document.getElementById(`masked-${profileId}`);
    const eyeIcon = document.getElementById(`eye-${profileId}`);
    
    if (accountSpan.style.display === 'none') {
        accountSpan.style.display = 'inline';
        maskedSpan.style.display = 'none';
        eyeIcon.className = 'fas fa-eye-slash';
    } else {
        accountSpan.style.display = 'none';
        maskedSpan.style.display = 'inline';
        eyeIcon.className = 'fas fa-eye';
    }
}

// Download bank details
function downloadBankDetails(profileId) {
    // Redirect to export route with professional ID
    window.location.href = `{{ route('admin.professional.bank-details.export') }}?professional_id=${profileId}`;
}

// Confirm edit action
function confirmEdit(professionalId) {
    if (confirm('Are you sure you want to edit this professional\'s details?')) {
        // Redirect to edit page
        window.location.href = '/admin/manage-professional/' + professionalId + '/edit';
    }
}

// Edit Services
function editServices(professionalId) {
    if (confirm('Edit services for this professional?')) {
        // Redirect to admin professional services management page
        window.location.href = '/admin/professional/' + professionalId + '/services';
    }
}

// Edit Rates
function editRates(professionalId) {
    if (confirm('Edit rates/pricing for this professional?')) {
        // Redirect to admin professional rates management page
        window.location.href = '/admin/professional/' + professionalId + '/rates';
    }
}

// Edit Availability
function editAvailability(professionalId) {
    if (confirm('Edit availability schedule for this professional?')) {
        // Redirect to admin professional availability management page
        window.location.href = '/admin/professional/' + professionalId + '/availability';
    }
}

// Edit Commission Settings
function editCommissionSettings(professionalId) {
    console.log('Opening commission modal for professional:', professionalId);
    
    // Use Bootstrap's modal methods with better compatibility
    if (typeof $ !== 'undefined' && $.fn.modal) {
        console.log('Using jQuery modal');
        $('#commissionModal').modal('show');
    } else if (typeof bootstrap !== 'undefined' && bootstrap.Modal) {
        // Fallback for Bootstrap 5 vanilla JS
        console.log('Using Bootstrap 5 vanilla JS modal');
        const modal = document.getElementById('commissionModal');
        if (modal) {
            const bootstrapModal = new bootstrap.Modal(modal);
            bootstrapModal.show();
        }
    } else {
        // Final fallback - show modal manually
        console.log('Using manual modal display');
        const modal = document.getElementById('commissionModal');
        if (modal) {
            modal.style.display = 'block';
            modal.classList.add('show');
            document.body.classList.add('modal-open');
        }
    }
}

// Wait for DOM and jQuery to be ready
$(document).ready(function() {
    console.log('jQuery is loaded and DOM is ready');
    
    // Initialize modal event handlers
    $('#commissionModal').on('shown.bs.modal', function() {
        // Set default values if not already set
        setDefaultValues();
        // Load current values and update calculator
        updateCalculator();
    });
    
    function setDefaultValues() {
        const margin = parseFloat($('#margin').val()) || 0;
        const serviceMargin = parseFloat($('#service_request_margin').val());
        const offset = parseFloat($('#service_request_offset').val());
        
        // If service request margin is empty or 0, default to regular session margin
        if (!serviceMargin || serviceMargin === 0) {
            $('#service_request_margin').val(margin.toFixed(2));
        }
        
        // If negotiation offset is empty or 0, default to 10%
        if (!offset || offset === 0) {
            $('#service_request_offset').val('10.00');
        }
    }
    
    function updateCalculator() {
        const margin = parseFloat($('#margin').val()) || 0;
        const serviceMargin = parseFloat($('#service_request_margin').val()) || margin;
        const offset = parseFloat($('#service_request_offset').val()) || 10;
        
        const baseAmount = 1000;
        
        // Calculate earnings
        const regularEarning = baseAmount - (baseAmount * margin / 100);
        const serviceEarning = baseAmount - (baseAmount * serviceMargin / 100);
        const minPrice = baseAmount - (baseAmount * offset / 100);
        
        // Update display
        $('#regularEarning').text('₹' + regularEarning.toFixed(2));
        $('#serviceRequestEarning').text('₹' + serviceEarning.toFixed(2));
        $('#minNegotiatedPrice').text('₹' + minPrice.toFixed(2));
    }
    
    // Sync service request margin with regular session margin when it changes
    $('#margin').on('input', function() {
        const margin = parseFloat($(this).val()) || 0;
        const serviceMargin = parseFloat($('#service_request_margin').val()) || 0;
        
        // Only update service margin if it was previously equal to the old regular margin or empty
        // This allows for independent editing while maintaining the default sync behavior
        if (serviceMargin === 0 || $('#service_request_margin').data('sync-with-margin') !== false) {
            $('#service_request_margin').val(margin.toFixed(2));
        }
        updateCalculator();
    });
    
    // Mark service request margin as independently edited when user manually changes it
    $('#service_request_margin').on('input', function() {
        $(this).data('sync-with-margin', false);
        updateCalculator();
    });
    
    // Update calculator on input change for offset
    $('#service_request_offset').on('input', updateCalculator);
    
    // Commission form submission
    $('#commissionForm').on('submit', function(e) {
        e.preventDefault();
        
        const professionalId = {{ $professional->id }};
        const formData = {
            _token: $('meta[name="csrf-token"]').attr('content') || $('input[name="_token"]').val(),
            margin: $('#margin').val(),
            service_request_margin: $('#service_request_margin').val(),
            service_request_offset: $('#service_request_offset').val()
        };
        
        console.log('Submitting form data:', formData);
        
        // Show loading state
        const submitBtn = $(this).find('button[type="submit"]');
        const originalText = submitBtn.html();
        submitBtn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Saving...');
        
        $.ajax({
            url: `/admin/manage-professional/${professionalId}/update-commission`,
            type: 'POST',
            data: formData,
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') || $('input[name="_token"]').val(),
                'Accept': 'application/json',
                'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'
            },
            success: function(response) {
                console.log('Success response:', response);
                if (response.success) {
                    // Close modal and reload page
                    $('#commissionModal').modal('hide');
                    
                    // Show success message
                    if (typeof toastr !== 'undefined') {
                        toastr.success('Commission settings updated successfully!');
                    } else {
                        alert('Commission settings updated successfully!');
                    }
                    
                    // Reload page after short delay
                    setTimeout(() => location.reload(), 1000);
                } else {
                    alert('Error: ' + (response.message || 'Unknown error occurred'));
                }
            },
            error: function(xhr, status, error) {
                console.error('AJAX Error:', xhr, status, error);
                console.error('Response Text:', xhr.responseText);
                
                let errorMessage = 'An error occurred while updating commission settings.';
                
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMessage = xhr.responseJSON.message;
                } else if (xhr.responseJSON && xhr.responseJSON.errors) {
                    errorMessage = Object.values(xhr.responseJSON.errors).flat().join('\n');
                } else if (xhr.responseText) {
                    errorMessage = 'Server error: ' + xhr.status + ' ' + xhr.statusText;
                }
                
                alert(errorMessage);
            },
            complete: function() {
                // Restore button state
                submitBtn.prop('disabled', false).html(originalText);
            }
        });
    });
    
    // Initial calculator update
    updateCalculator();
});
</script>

@endsection