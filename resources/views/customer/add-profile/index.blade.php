@extends('customer.layout.layout')
@section('styles')
<link rel="stylesheet" href="{{ asset('customer-css/assets/css/add-profile.css') }}" />
<style>
    .content-wrapper {
        padding: 20px;
    }

    .profile-box {
        background: #f9f9f9;
        border-radius: 8px;
        padding: 20px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        margin-bottom: 20px;
    }

    .profile-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }

    .profile-header h3 {
        font-size: 24px;
        font-weight: 600;
    }

    .btn-edit-profile {
        padding: 6px 15px;
        background-color: #007bff;
        color: #fff;
        border-radius: 4px;
        border: none;
        cursor: pointer;
    }

    .btn-edit-profile a {
        color: #fff;
        text-decoration: none;
    }

    .profile-photo {
        text-align: center;
        margin-bottom: 20px;
    }

    .profile-photo img {
        max-width: 200px;
        border-radius: 8px;
        object-fit: cover;
        height: 200px;
    }

    .profile-details p {
        margin-bottom: 10px;
        font-size: 16px;
    }

    .profile-details strong {
        font-weight: 600;
    }

    .warning {
        color: #ff4d4d;
        font-size: 14px;
    }

    .gallery {
        margin-top: 20px;
    }

    .gallery-images {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
    }

    .gallery-images img {
        width: 150px;
        height: 150px;
        border-radius: 8px;
        object-fit: cover;
        transition: transform 0.3s ease;
    }

    .gallery-images img:hover {
        transform: scale(1.05);
    }

    @media (max-width: 768px) {
        .profile-header {
            flex-direction: column;
            align-items: flex-start;
        }

        .profile-header h3 {
            font-size: 20px;
            margin-bottom: 10px;
        }

        .profile-photo img {
            height: 150px;
            max-width: 100%;
        }

        .gallery-images img {
            width: 100%;
            height: auto;
            max-width: 120px;
        }
    }
</style>
@endsection

@section('content')
<div class="content-wrapper">
    @forelse($profiles as $profile)
        <div class="profile-box">
            <div class="profile-header">
                <h3>Profile Details</h3>
                <button class="btn-edit-profile">
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
        </div>
    @empty
        <div class="alert alert-warning">No profile found.</div>
    @endforelse
</div>

@endsection
