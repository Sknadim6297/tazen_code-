@extends('professional.layout.layout')
@section('content')
<div class="content-wrapper">
    @foreach($profiles as $profile)
    <div class="profile-box mb-4">
        {{-- Profile Header --}}
        <div class="profile-header">
            <h3>Add Profiles</h3>
            <button class="btn-edit-profile">
                <a href="{{ route('professional.profile.edit', ['profile' => $profile->id]) }}">Edit Profile</a>
            </button>
        </div>

        {{-- Left Photo --}}
        <div class="profile-photo">
            <img src="{{ $profile->photo ? asset($profile->photo) : asset('default.jpg') }}" alt="Profile Photo">
        </div>

        {{-- Profile Details --}}
        <div class="profile-details">
            <p><strong>Name:</strong> {{ $profile->professional->name ?? 'N/A' }} 
                @if(!$profile->professional->name) <span class="warning">Please edit your profile</span> @endif
            </p>
            <p><strong>Email:</strong> {{ $profile->email ?? 'N/A' }} 
                @if(!$profile->email) <span class="warning">Please edit your profile</span> @endif
            </p>
            <p><strong>Phone:</strong> {{ $profile->phone ?? 'N/A' }} 
                @if(!$profile->phone) <span class="warning">Please edit your profile</span> @endif
            </p>
            <p><strong>Specialization:</strong> {{ $profile->specialization ?? 'N/A' }} 
                @if(!$profile->specialization) <span class="warning">Please edit your profile</span> @endif
            </p>
            <p><strong>Experience:</strong> {{ $profile->experience ?? 'N/A' }} 
                @if(!$profile->experience) <span class="warning">Please edit your profile</span> @endif
            </p>
            <p><strong>Starting Price:</strong> ₹{{ $profile->starting_price ?? 'N/A' }} 
                @if(!$profile->starting_price) <span class="warning">Please edit your profile</span> @endif
            </p>
            <p><strong>Address:</strong> {{ $profile->address ?? 'N/A' }} 
                @if(!$profile->address) <span class="warning">Please edit your profile</span> @endif
            </p>
            <p><strong>Education:</strong> {{ $profile->education ?? 'N/A' }} 
                @if(!$profile->education) <span class="warning">Please edit your profile</span> @endif
            </p>
            <p><strong>Comments:</strong> {{ $profile->comments ?? 'N/A' }} 
                @if(!$profile->comments) <span class="warning">Please edit your profile</span> @endif
            </p>
            <p><strong>About me:</strong> {{ $profile->bio ?? 'N/A' }} 
                @if(!$profile->bio) <span class="warning">Please edit your profile</span> @endif
            </p>
            <p><strong>Created At:</strong> {{ $profile->created_at->format('d M, Y') }}</p>

            {{-- Documents --}}
            <p><strong>Qualification Document:</strong> 
                @if($profile->qualification_document)
                    <a href="{{ asset($profile->qualification_document) }}" target="_blank">View</a>
                @else 
                    <span class="warning">Please upload document</span>
                @endif
            </p>
            <p><strong>Aadhaar Card:</strong> 
                @if($profile->aadhaar_card)
                    <a href="{{ asset($profile->aadhaar_card) }}" target="_blank">View</a>
                @else 
                    <span class="warning">Please upload Aadhaar card</span>
                @endif
            </p>
            <p><strong>PAN Card:</strong> 
                @if($profile->pan_card)
                    <a href="{{ asset($profile->pan_card) }}" target="_blank">View</a>
                @else 
                    <span class="warning">Please upload PAN card</span>
                @endif
            </p>
        </div>

        {{-- Gallery --}}
        <div class="gallery">
            <p><strong>Gallery:</strong></p>
            <div class="gallery-images">
                @php
                    $gallery = is_array($profile->gallery) ? $profile->gallery : json_decode($profile->gallery, true);
                @endphp
                @if ($gallery && is_array($gallery))
                    @foreach ($gallery as $img)
                        <img src="{{ asset($img) }}" alt="Gallery Image">
                    @endforeach
                @else
                    <p><span class="warning">No gallery images available</span></p>
                @endif
            </div>
        </div>

    </div>
    @endforeach

    @if($profiles->isEmpty())
        <div class="alert alert-warning">No profiles found.</div>
    @endif
</div>

<style>

    .content-wrapper {
        padding: 20px;
    }

    .profile-box {
        background: #f9f9f9;
        border-radius: 8px;
        padding: 20px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
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

    .profile-photo img {
        max-width: 100%;
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

        .profile-photo {
            text-align: center;
        }

        .profile-photo img {
            height: 150px;
        }

        .gallery-images img {
            width: 100%;
            height: auto;
            max-width: 120px;
        }
    }
</style>

@endsection
