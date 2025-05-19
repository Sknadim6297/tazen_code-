@extends('customer.layout.layout')
@section('styles')
<link rel="stylesheet" href="{{ asset('customer-css/assets/css/add-profile.css') }}" />
<link rel="stylesheet" href="{{ asset('frontend/assets/css/responsive2.css') }}" media="screen and (max-width: 992px)">
<style>
    :root {
        --primary-color: #3498db;
        --primary-hover: #2980b9;
        --secondary-color: #2c3e50;
        --text-color: #34495e;
        --light-text: #7f8c8d;
        --border-color: #e0e6ed;
        --bg-color: #f7f9fc;
        --card-bg: #ffffff;
        --success-color: #2ecc71;
        --warning-color: #f39c12;
        --danger-color: #e74c3c;
        --shadow-sm: 0 2px 4px rgba(0,0,0,0.05);
        --shadow-md: 0 5px 15px rgba(0,0,0,0.07);
        --shadow-lg: 0 15px 30px rgba(0,0,0,0.1);
        --transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
        --border-radius: 8px;
    }

    body {
        font-family: 'Inter', 'Segoe UI', Roboto, sans-serif;
        color: var(--text-color);
        background-color: var(--bg-color);
    }
    
    /* Content Wrapper */
    .content-wrapper {
        padding: 2rem;
        background-color: var(--bg-color);
        min-height: calc(100vh - 60px);
        transition: var(--transition);
        max-width: 1200px;
        margin: 0 auto;
    }

    /* Page Header */
    .page-header {
        margin-bottom: 2rem;
        position: relative;
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 1rem;
    }

    .page-title h3 {
        font-size: 1.75rem;
        font-weight: 700;
        color: var(--secondary-color);
        margin: 0;
        position: relative;
        display: inline-block;
    }

    .page-title h3::after {
        content: "";
        position: absolute;
        bottom: -6px;
        left: 0;
        width: 40px;
        height: 3px;
        background-color: var(--primary-color);
        border-radius: 2px;
    }

    /* Breadcrumb */
    .breadcrumb {
        list-style: none;
        padding: 0;
        display: flex;
        gap: 10px;
        font-size: 0.85rem;
        color: var(--light-text);
        margin: 0;
    }

    .breadcrumb li {
        display: flex;
        align-items: center;
    }
    
    .breadcrumb li:not(:last-child)::after {
        content: "/";
        margin-left: 10px;
        color: #bdc3c7;
    }

    .breadcrumb li.active {
        font-weight: 600;
        color: var(--secondary-color);
    }

    /* Profile Card */
    .profile-card {
        background: var(--card-bg);
        border-radius: var(--border-radius);
        padding: 2rem;
        box-shadow: var(--shadow-md);
        transition: var(--transition);
        border: 1px solid var(--border-color);
        position: relative;
        overflow: hidden;
    }

    .profile-card:hover {
        box-shadow: var(--shadow-lg);
    }

    .profile-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 5px;
        background: linear-gradient(90deg, var(--primary-color), var(--primary-hover));
    }

    /* Profile Header */
    .profile-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 2rem;
        position: relative;
    }

    .profile-header h3 {
        font-size: 1.75rem;
        font-weight: 700;
        color: var(--secondary-color);
        position: relative;
        display: inline-block;
    }

    .profile-header h3::after {
        content: '';
        position: absolute;
        bottom: -8px;
        left: 0;
        width: 50px;
        height: 3px;
        background: var(--primary-color);
        border-radius: 2px;
    }

    /* Button */
    .btn-edit-profile {
        padding: 0.75rem 1.5rem;
        background: linear-gradient(135deg, var(--primary-color), var(--primary-hover));
        color: white;
        border-radius: 50px;
        border: none;
        cursor: pointer;
        font-weight: 600;
        font-size: 0.95rem;
        transition: var(--transition);
        box-shadow: 0 4px 15px rgba(52, 152, 219, 0.3);
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .btn-edit-profile:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(52, 152, 219, 0.4);
        background: linear-gradient(135deg, var(--primary-hover), var(--primary-color));
    }

    .btn-edit-profile a {
        color: white;
        text-decoration: none;
    }

    /* Profile Photo */
    .profile-photo {
        text-align: center;
        margin-bottom: 2rem;
    }

    .profile-photo img {
        width: 200px;
        height: 200px;
        border-radius: 50%;
        object-fit: cover;
        border: 5px solid white;
        box-shadow: var(--shadow-md);
        transition: var(--transition);
    }

    .profile-photo img:hover {
        transform: scale(1.05);
        box-shadow: var(--shadow-lg);
    }

    /* Profile Details */
    .profile-details {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 1.5rem;
    }

    .profile-details p {
        margin: 0;
        padding: 1rem;
        background: rgba(248, 249, 250, 0.6);
        border-radius: var(--border-radius);
        font-size: 0.95rem;
        transition: var(--transition);
        border-left: 4px solid var(--primary-color);
    }

    .profile-details p:hover {
        background: white;
        transform: translateX(5px);
        box-shadow: var(--shadow-sm);
    }

    .profile-details strong {
        font-weight: 600;
        color: var(--primary-color);
        margin-right: 8px;
    }

    /* Gallery */
    .gallery {
        margin-top: 2rem;
    }

    .gallery h4 {
        font-size: 1.25rem;
        margin-bottom: 1rem;
        color: var(--secondary-color);
        position: relative;
        padding-bottom: 0.5rem;
    }

    .gallery h4::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 40px;
        height: 3px;
        background: var(--primary-color);
        border-radius: 2px;
    }

    .gallery-images {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
        gap: 1rem;
    }

    .gallery-images img {
        width: 100%;
        height: 180px;
        border-radius: var(--border-radius);
        object-fit: cover;
        transition: var(--transition);
        cursor: pointer;
        box-shadow: var(--shadow-sm);
    }

    .gallery-images img:hover {
        transform: scale(1.03);
        box-shadow: var(--shadow-md);
    }

    /* Alert */
    .alert {
        padding: 1rem;
        border-radius: var(--border-radius);
        background: rgba(248, 215, 218, 0.8);
        color: #721c24;
        border-left: 4px solid #f5c6cb;
        margin: 1rem 0;
    }

    /* Animations */
    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .fade-in {
        animation: fadeIn 0.6s ease forwards;
    }

    /* Responsive Design */
    @media (max-width: 992px) {
        .content-wrapper {
            padding: 1.5rem;
        }
        
        .profile-card {
            padding: 1.5rem;
        }
    }

    @media (max-width: 768px) {
        .profile-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 1rem;
        }
        
        .profile-details {
            grid-template-columns: 1fr;
        }

        .profile-photo img {
            width: 150px;
            height: 150px;
        }

        .gallery-images {
            grid-template-columns: repeat(auto-fill, minmax(120px, 1fr));
        }
    }

    @media (max-width: 576px) {
        .content-wrapper {
            padding: 1rem;
        }
        
        .profile-card {
            padding: 1.25rem;
        }
        
        .profile-header h3 {
            font-size: 1.5rem;
        }
    }

    /* Dark Mode Support */
    @media (prefers-color-scheme: dark) {
        :root {
            --bg-color: #121212;
            --card-bg: #1e1e1e;
            --text-color: #e4e6eb;
            --light-text: #b0b3b8;
            --border-color: #2a2a2a;
            --secondary-color: #e4e6eb;
        }
        
        .profile-details p {
            background-color: #242424;
        }
        
        .profile-details p:hover {
            background-color: #2d2d2d;
        }
    }
</style>
@endsection

@section('content')
<div class="content-wrapper">
    <div class="page-header">
        <div class="page-title">
            <h3>Profile Details</h3>
        </div>
        <ul class="breadcrumb">
            <li>Home</li>
            <li class="active">Profile</li>
        </ul>
    </div>

    @forelse($profiles as $profile)
        <div class="profile-card fade-in">
            <div class="profile-header">
                <h3>Your Profile Information</h3>
                <button class="btn-edit-profile" data-tooltip="Edit your profile">
                    <a href="{{ route('user.profile.edit', ['profile' => $profile->id]) }}">Edit Profile</a>
                </button>
            </div>

            <div class="profile-photo">
                <img src="{{ $profile->customerProfile && $profile->customerProfile->profile_image ? asset($profile->customerProfile->profile_image) : asset('default-avatar.png') }}" alt="Profile Photo">
            </div>

            <div class="profile-details">
                <p><strong>Name:</strong> {{ $profile->name ?? 'N/A' }}</p>
                <p><strong>Email:</strong> {{ $profile->email ?? 'N/A' }}</p>
                <p><strong>Phone:</strong> {{ $profile->customerProfile->phone ?? 'N/A' }}</p>
                <p><strong>Address:</strong> {{ $profile->customerProfile->address ?? 'N/A' }}</p>
                <p><strong>City:</strong> {{ $profile->customerProfile->city ?? 'N/A' }}</p>
                <p><strong>State:</strong> {{ $profile->customerProfile->state ?? 'N/A' }}</p>
                <p><strong>Zip Code:</strong> {{ $profile->customerProfile->zip_code ?? 'N/A' }}</p>
                <p><strong>Notes:</strong> {{ $profile->customerProfile->notes ?? 'No notes available' }}</p>
            </div>

            @if($profile->customerProfile && $profile->customerProfile->gallery)
                <div class="gallery">
                    <h4>Gallery</h4>
                    <div class="gallery-images">
                        @php
                            $gallery = is_array($profile->customerProfile->gallery) 
                                      ? $profile->customerProfile->gallery 
                                      : json_decode($profile->customerProfile->gallery, true);
                        @endphp
                        @foreach($gallery as $img)
                            <img src="{{ asset($img) }}" alt="Gallery Image">
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    @empty
        <div class="alert alert-warning">No profile found.</div>
    @endforelse
</div>
@endsection