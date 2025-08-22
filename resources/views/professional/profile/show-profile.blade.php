@extends('professional.layout.layout')
@section('content')
<div class="content-wrapper">
    @foreach($profiles as $profile)
    <div class="profile-box mb-4">
        {{-- Profile Header --}}
        <div class="profile-header">
            <div class="header-content">
                <h3>Professional Profile</h3>
                <p class="profile-meta">Last updated: {{ $profile->updated_at->diffForHumans() }}</p>
            </div>
            <a href="{{ route('professional.profile.edit', ['profile' => $profile->id]) }}">
            <button class="btn-edit-profile">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                    <path d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z"/>
                </svg>
                <span>Edit Profile</span>
            </button>
            </a>
        </div>

        <div class="profile-content">
            {{-- Left Photo --}}
            <div class="profile-photo-container">
                <div class="profile-photo">
                    <img src="{{ $profile->photo ? asset('storage/'.$profile->photo) : asset('default.jpg') }}" alt="Profile Photo">
                    <div class="photo-overlay">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="#fff" viewBox="0 0 16 16">
                            <path d="M4.502 9a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3z"/>
                            <path d="M14.002 13a2 2 0 0 1-2 2h-10a2 2 0 0 1-2-2V5A2 2 0 0 1 2 3a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2v8a2 2 0 0 1-1.998 2zM14 2H4a1 1 0 0 0-1 1h9.002a2 2 0 0 1 2 2v7A1 1 0 0 0 15 11V3a1 1 0 0 0-1-1zM2.002 4a1 1 0 0 0-1 1v8l2.646-2.354a.5.5 0 0 1 .63-.062l2.66 1.773 3.71-3.71a.5.5 0 0 1 .577-.094l1.777 1.947V5a1 1 0 0 0-1-1h-10z"/>
                        </svg>
                    </div>
                </div>
                <div class="profile-status">
                    <span class="status-indicator active"></span>
                    <span>Verified Professional</span>
                </div>
            </div>

            {{-- Profile Details --}}
            <div class="profile-details-container">
                <div class="detail-cards">
                    <div class="detail-card">
                        <h4 class="card-title">Personal Information</h4>
                        <div class="card-content">
                            <div class="detail-item">
                                <span class="detail-label">Full Name</span>
                                <span class="detail-value">{{ $profile->professional->name ?? 'N/A' }}</span>
                                @if(!$profile->professional->name) <span class="warning-badge">Required</span> @endif
                            </div>
                            <div class="detail-item">
                                <span class="detail-label">Email</span>
                                <span class="detail-value">{{ $profile->email ?? 'N/A' }}</span>
                                @if(!$profile->email) <span class="warning-badge">Required</span> @endif
                            </div>
                            <div class="detail-item">
                                <span class="detail-label">Phone</span>
                                <span class="detail-value">{{ $profile->phone ?? 'N/A' }}</span>
                                @if(!$profile->phone) <span class="warning-badge">Required</span> @endif
                            </div>
                            <div class="detail-item">
                                <span class="detail-label">Address</span>
                                <span class="detail-value">{{ $profile->address ?? 'N/A' }}</span>
                                @if(!$profile->address) <span class="warning-badge">Required</span> @endif
                            </div>
                        </div>
                    </div>

                    <div class="detail-card">
                        <h4 class="card-title">Professional Details</h4>
                        <div class="card-content">
                            <div class="detail-item">
                                <span class="detail-label">Specialization</span>
                                <span class="detail-value">{{ $profile->specialization ?? 'N/A' }}</span>
                                @if(!$profile->specialization) <span class="warning-badge">Required</span> @endif
                            </div>
                            <div class="detail-item">
                                <span class="detail-label">Experience(in Yrs)</span>
                                <span class="detail-value">{{ $profile->experience ?? 'N/A' }}</span>
                                @if(!$profile->experience) <span class="warning-badge">Required</span> @endif
                            </div>
                            <div class="detail-item">
                                <span class="detail-label">Starting Price</span>
                                <span class="detail-value">
                                    @if($profile->starting_price)
                                        @if(str_contains($profile->starting_price, '-'))
                                            ₹{{ $profile->starting_price }} per session
                                        @else
                                            ₹{{ $profile->starting_price }} per session
                                        @endif
                                    @else
                                        N/A
                                    @endif
                                </span>
                                @if(!$profile->starting_price) <span class="warning-badge">Required</span> @endif
                            </div>
                            <div class="detail-item">
                                <span class="detail-label">Education</span>
                                <span class="detail-value">{{ $profile->education ?? 'N/A' }}</span>
                                @if(!$profile->education) <span class="warning-badge">Required</span> @endif
                            </div>
                              <div class="detail-item">
                                <span class="detail-label">Margin (%)</span>
                                <span class="detail-value">{{ $profile->professional->margin ?? 'N/A' }}</span>
                                @if(!$profile->professional->margin) <span class="warning-badge">Required</span> @endif
                            </div>
                            @if($profile->gst_number)
                            <div class="detail-item">
                                <span class="detail-label">GST Number</span>
                                <span class="detail-value">{{ $profile->gst_number }}</span>
                            </div>
                            @endif
                            @if($profile->state_code)
                            <div class="detail-item">
                                <span class="detail-label">State Code</span>
                                <span class="detail-value">{{ $profile->state_code }} - {{ $profile->state_name ?? 'N/A' }}</span>
                            </div>
                            @endif
                            @if($profile->gst_address)
                            <div class="detail-item">
                                <span class="detail-label">GST Address</span>
                                <span class="detail-value">{{ $profile->gst_address }}</span>
                            </div>
                            @endif
                            </div>
                        </div>
                    </div>

                    <div class="detail-card">
                        <h4 class="card-title">About Me</h4>
                        <div class="card-content">
                            <p class="bio-content">{{ $profile->bio ?? 'No bio provided' }}</p>
                            @if(!$profile->bio) <span class="warning-badge">Add your bio</span> @endif
                        </div>
                    </div>

                    <div class="detail-card">
                        <h4 class="card-title">Verification Documents</h4>
                        <div class="card-content">
                            <div class="document-item">
                                <div class="document-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="#4f46e5" viewBox="0 0 16 16">
                                        <path d="M5.5 7a.5.5 0 0 0 0 1h5a.5.5 0 0 0 0-1h-5zM5 9.5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5zm0 2a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5z"/>
                                        <path d="M9.5 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V4.5L9.5 0zm0 1v2A1.5 1.5 0 0 0 11 4.5h2V14a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h5.5z"/>
                                    </svg>
                                </div>
                                <div class="document-info">
                                    <span class="document-name">Qualification Document</span>
                                    @if($profile->qualification_document)
                                        <a href="{{ asset('storage/'.$profile->qualification_document) }}" target="_blank" class="document-link">View Document</a>
                                    @else 
                                        <span class="warning-badge">Not Uploaded</span>
                                    @endif
                                </div>
                            </div>

                            <div class="document-item">
                                <div class="document-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="#4f46e5" viewBox="0 0 16 16">
                                        <path d="M5.5 7a.5.5 0 0 0 0 1h5a.5.5 0 0 0 0-1h-5zM5 9.5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5zm0 2a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5z"/>
                                        <path d="M9.5 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V4.5L9.5 0zm0 1v2A1.5 1.5 0 0 0 11 4.5h2V14a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h5.5z"/>
                                    </svg>
                                </div>
                                <div class="document-info">
                                    <span class="document-name">ID Proof Document (Aadhaar / PAN Card)</span>
                                    @if($profile->id_proof_document)
                                        <a href="{{ asset('storage/'.$profile->id_proof_document) }}" target="_blank" class="document-link">View Document</a>
                                    @else 
                                        <span class="warning-badge">Not Uploaded</span>
                                    @endif
                                </div>
                            </div>

                            @if($profile->gst_number)
                            <div class="document-item">
                                <div class="document-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="#4f46e5" viewBox="0 0 16 16">
                                        <path d="M5.5 7a.5.5 0 0 0 0 1h5a.5.5 0 0 0 0-1h-5zM5 9.5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5zm0 2a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5z"/>
                                        <path d="M9.5 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V4.5L9.5 0zm0 1v2A1.5 1.5 0 0 0 11 4.5h2V14a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h5.5z"/>
                                    </svg>
                                </div>
                                <div class="document-info">
                                    <span class="document-name">GST Certificate</span>
                                    @if($profile->gst_certificate)
                                        <a href="{{ asset('storage/'.$profile->gst_certificate) }}" target="_blank" class="document-link">View Document</a>
                                    @else 
                                        <span class="warning-badge">Not Uploaded</span>
                                    @endif
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Gallery --}}
        <div class="gallery-section">
            <div class="section-header">
                <h4>Portfolio Gallery</h4>
                {{-- <button class="btn-add-more">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                        <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"/>
                    </svg>
                    Add More
                </button> --}}
            </div>
            <div class="gallery-grid">
                @php
                    $gallery = is_array($profile->gallery) ? $profile->gallery : json_decode($profile->gallery, true);
                @endphp
                @if ($gallery && is_array($gallery))
                    @foreach ($gallery as $img)
                        <div class="gallery-item">
                            <img src="{{ asset('storage/'.$img) }}" alt="Gallery Image">
                            <div class="gallery-overlay">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="#fff" viewBox="0 0 16 16">
                            <path d="M4.502 9a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3z"/>
                            <path d="M14.002 13a2 2 0 0 1-2 2h-10a2 2 0 0 1-2-2V5A2 2 0 0 1 2 3a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2v8a2 2 0 0 1-1.998 2zM14 2H4a1 1 0 0 0-1 1h9.002a2 2 0 0 1 2 2v7A1 1 0 0 0 15 11V3a1 1 0 0 0-1-1zM2.002 4a1 1 0 0 0-1 1v8l2.646-2.354a.5.5 0 0 1 .63-.062l2.66 1.773 3.71-3.71a.5.5 0 0 1 .577-.094l1.777 1.947V5a1 1 0 0 0-1-1h-10z"/>
                        </svg>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="empty-gallery">
                        <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="#ccc" viewBox="0 0 16 16">
                            <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                            <path d="M4.5 5a.5.5 0 0 0-.5.5v7a.5.5 0 0 0 1 0v-7a.5.5 0 0 0-.5-.5zm3 0a.5.5 0 0 0-.5.5v7a.5.5 0 0 0 1 0v-7a.5.5 0 0 0-.5-.5zm3 0a.5.5 0 0 0-.5.5v7a.5.5 0 0 0 1 0v-7a.5.5 0 0 0-.5-.5z"/>
                        </svg>
                        <p>No portfolio images available</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
    @endforeach

    @if($profiles->isEmpty())
        <div class="empty-state">
            <div class="empty-content">
                <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" fill="#4f46e5" viewBox="0 0 16 16">
                    <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                    <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"/>
                </svg>
                <h3>No Profiles Found</h3>
                <p>You haven't created any professional profiles yet. Get started by adding your first profile.</p>
                <button class="btn-primary">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                        <path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0zm4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4zm-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10c-2.29 0-3.516.68-4.168 1.332-.678.678-.83 1.418-.832 1.664h10z"/>
                    </svg>
                    Create New Profile
                </button>
            </div>
        </div>
    @endif
</div>

<style>
    :root {
    --primary: #4f46e5;
    --primary-light: #6366f1;
    --primary-dark: #4338ca;
    --secondary: #10b981;
    --danger: #ef4444;
    --warning: #f59e0b;
    --gray-100: #f3f4f6;
    --gray-200: #e5e7eb;
    --gray-300: #d1d5db;
    --gray-400: #9ca3af;
    --gray-500: #6b7280;
    --gray-600: #4b5563;
    --gray-700: #374151;
    --gray-800: #1f2937;
    --gray-900: #111827;
}

* {
    box-sizing: border-box;
    margin: 0;
    padding: 0;
}

body {
    font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
    line-height: 1.5;
    color: var(--gray-800);
    background-color: #f9fafb;
}

.content-wrapper {
    max-width: 1200px;
    margin: 0 auto;
    padding: 2rem;
}
.page-header {
        margin-bottom: 2rem;
        position: relative;
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 1rem;
    }

.profile-box {
    background: white;
    border-radius: 16px;
    box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05), 0 8px 10px -6px rgba(0, 0, 0, 0.05);
    overflow: hidden;
    margin-bottom: 2.5rem;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    border: 1px solid var(--gray-200);
}

.profile-box:hover {
    box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
    transform: translateY(-2px);
}

.profile-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 1.5rem 2rem;
        background: linear-gradient(135deg, #ed9706, #1e21a3);
    color: white;
}

.header-content h3 {
    font-size: 1.5rem;
    font-weight: 600;
    margin-bottom: 0.25rem;
}

.profile-meta {
    font-size: 0.875rem;
    opacity: 0.9;
}

.btn-edit-profile {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.625rem 1.25rem;
    background: rgba(255, 255, 255, 0.15);
    color: white;
    border: none;
    border-radius: 8px;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.2s ease;
    backdrop-filter: blur(4px);
}

.btn-edit-profile:hover {
    background: rgba(255, 255, 255, 0.25);
    transform: translateY(-1px);
}

.btn-edit-profile svg {
    flex-shrink: 0;
}

.profile-content {
    display: grid;
    grid-template-columns: 240px 1fr;
    gap: 2rem;
    padding: 2rem;
}

@media (max-width: 768px) {
    .profile-content {
        grid-template-columns: 1fr;
    }
}

.profile-photo-container {
    display: flex;
    flex-direction: column;
    gap: 1.5rem;
}

.profile-photo {
    position: relative;
    border-radius: 12px;
    overflow: hidden;
    aspect-ratio: 1/1;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
}

.profile-photo img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.photo-overlay {
    position: absolute;
    inset: 0;
    background: rgba(0, 0, 0, 0.3);
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    transition: opacity 0.3s ease;
}

.profile-photo:hover .photo-overlay {
    opacity: 1;
}

.profile-status {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 0.875rem;
    color: var(--gray-600);
    padding: 0.75rem 1rem;
    background: var(--gray-100);
    border-radius: 8px;
}

.status-indicator {
    display: inline-block;
    width: 10px;
    height: 10px;
    border-radius: 50%;
}

.status-indicator.active {
    background: var(--secondary);
    box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.2);
}

.detail-cards {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 1.5rem;
}

.detail-card {
    background: white;
    border-radius: 12px;
    border: 1px solid var(--gray-200);
    overflow: hidden;
    transition: all 0.3s ease;
}

.detail-card:hover {
    border-color: var(--gray-300);
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03);
}

.card-title {
    font-size: 1rem;
    font-weight: 600;
    padding: 1rem 1.5rem;
    background: var(--gray-100);
    border-bottom: 1px solid var(--gray-200);
}

.card-content {
    padding: 1.5rem;
}

.detail-item {
    display: flex;
    flex-direction: column;
    gap: 0.25rem;
    margin-bottom: 1rem;
}

.detail-item:last-child {
    margin-bottom: 0;
}

.detail-label {
    font-size: 0.75rem;
    color: var(--gray-500);
    text-transform: uppercase;
    letter-spacing: 0.05em;
    font-weight: 500;
}

.detail-value {
    font-size: 0.9375rem;
    font-weight: 500;
    color: var(--gray-800);
}

.warning-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.25rem;
    font-size: 0.75rem;
    padding: 0.25rem 0.5rem;
    background: rgba(239, 68, 68, 0.1);
    color: var(--danger);
    border-radius: 999px;
    margin-top: 0.25rem;
}

.warning-badge::before {
    content: "!";
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 16px;
    height: 16px;
    background: var(--danger);
    color: white;
    border-radius: 50%;
    font-weight: bold;
}

.bio-content {
    font-size: 0.9375rem;
    line-height: 1.6;
    color: var(--gray-700);
}

.document-item {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 0.75rem 0;
    border-bottom: 1px solid var(--gray-100);
}

.document-item:last-child {
    border-bottom: none;
}

.document-icon {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 40px;
    height: 40px;
    background: rgba(79, 70, 229, 0.1);
    border-radius: 8px;
}

.document-info {
    flex: 1;
}

.document-name {
    display: block;
    font-size: 0.875rem;
    font-weight: 500;
    color: var(--gray-700);
}

.document-link {
    font-size: 0.8125rem;
    color: var(--primary);
    text-decoration: none;
    transition: color 0.2s ease;
}

.document-link:hover {
    color: var(--primary-dark);
    text-decoration: underline;
}

.gallery-section {
    padding: 0 2rem 2rem;
}

.section-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1.5rem;
}

.section-header h4 {
    font-size: 1.125rem;
    font-weight: 600;
    color: var(--gray-800);
}

.btn-add-more {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.5rem 1rem;
    background: var(--primary);
    color: white;
    border: none;
    border-radius: 6px;
    font-size: 0.875rem;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.2s ease;
}

.btn-add-more:hover {
    background: var(--primary-dark);
    transform: translateY(-1px);
}

.gallery-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
    gap: 1rem;
}

.gallery-item {
    position: relative;
    border-radius: 8px;
    overflow: hidden;
    aspect-ratio: 1/1;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
}

.gallery-item img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.gallery-overlay {
    position: absolute;
    inset: 0;
    background: rgba(0, 0, 0, 0.5);
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    opacity: 0;
    transition: opacity 0.3s ease;
}

.gallery-item:hover .gallery-overlay {
    opacity: 1;
}

.gallery-item:hover img {
    transform: scale(1.05);
}

.btn-view, .btn-delete {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 36px;
    height: 36px;
    border-radius: 50%;
    border: none;
    background: rgba(255, 255, 255, 0.9);
    color: var(--gray-800);
    cursor: pointer;
    transition: all 0.2s ease;
}

.btn-view:hover {
    background: var(--primary);
    color: white;
}

.btn-delete:hover {
    background: var(--danger);
    color: white;
}

.empty-gallery {
    grid-column: 1 / -1;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    gap: 1rem;
    padding: 3rem;
    background: var(--gray-100);
    border-radius: 8px;
    color: var(--gray-500);
}

.empty-state {
    display: flex;
    align-items: center;
    justify-content: center;
    min-height: 400px;
    background: white;
    border-radius: 16px;
    box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05), 0 8px 10px -6px rgba(0, 0, 0, 0.05);
}

.empty-content {
    text-align: center;
    max-width: 400px;
    padding: 2rem;
}

.empty-content svg {
    margin-bottom: 1.5rem;
}

.empty-content h3 {
    font-size: 1.25rem;
    font-weight: 600;
    margin-bottom: 0.75rem;
    color: var(--gray-800);
}

.empty-content p {
    color: var(--gray-600);
    margin-bottom: 1.5rem;
}

.btn-primary {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.75rem 1.5rem;
    background: var(--primary);
    color: white;
    border: none;
    border-radius: 8px;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.2s ease;
    box-shadow: 0 4px 6px -1px rgba(79, 70, 229, 0.15), 0 2px 4px -1px rgba(79, 70, 229, 0.1);
}

.btn-primary:hover {
    background: var(--primary-dark);
    transform: translateY(-1px);
    box-shadow: 0 6px 10px -1px rgba(79, 70, 229, 0.2), 0 4px 6px -1px rgba(79, 70, 229, 0.15);
}


@media only screen and (min-width: 768px) and (max-width: 1024px) {
    .user-profile-wrapper{
                margin-top: -57px;
            }
}
/* Additional responsive styles */
@media (max-width: 640px) {
    .content-wrapper {
        padding: 1rem;
    }
    
    .profile-header {
        flex-direction: column;
        gap: 1rem;
        align-items: flex-start;
    }
    
    .detail-cards {
        grid-template-columns: 1fr;
    }
    
    .gallery-grid {
        grid-template-columns: repeat(auto-fill, minmax(120px, 1fr));
    }
    
    .btn-edit-profile, .btn-add-more {
        width: 100%;
        justify-content: center;
    }
}

/* Animation for elements */
@keyframes fadeIn {
    from { opacity: 0; transform: translateY(10px); }
    to { opacity: 1; transform: translateY(0); }
}

.profile-box, .detail-card, .gallery-item {
    animation: fadeIn 0.5s ease forwards;
}

.detail-card:nth-child(2) {
    animation-delay: 0.1s;
}

.detail-card:nth-child(3) {
    animation-delay: 0.2s;
}

.detail-card:nth-child(4) {
    animation-delay: 0.3s;
}

/* Focus styles for accessibility */
button:focus, a:focus {
    outline: 2px solid var(--primary);
    outline-offset: 2px;
}

/* Print styles */
@media print {
    .profile-box {
        box-shadow: none;
        border: 1px solid #ddd;
        break-inside: avoid;
    }
    
    .btn-edit-profile, .btn-add-more, .gallery-overlay, .photo-overlay {
        display: none;
    }
    
    body {
        background: white;
    }
}

</style>

@endsection