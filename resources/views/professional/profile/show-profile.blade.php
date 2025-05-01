@extends('professional.layout.layout')

@section('styles')
<style>
    .content-wrapper {
        padding: 20px;
        background-color: #f9f9f9;
    }
    
    .profile-box {
        background: #fff;
        border-radius: 10px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.08);
        margin-bottom: 30px;
        padding: 20px;
        transition: 0.3s;
    }
    
    .profile-box:hover {
        transform: translateY(-5px);
    }
    
    /* Header Styling */
    .page-header {
        border-bottom: 2px solid #eee;
        padding-bottom: 10px;
        margin-bottom: 20px;
    }
    
    .page-title h3 {
        font-weight: 600;
        color: #333;
    }
    
    /* Edit Profile Button */
    .page-header button {
        background-color: #007bff;
        color: #fff;
        border: none;
        padding: 8px 20px;
        font-size: 14px;
        border-radius: 6px;
        cursor: pointer;
        transition: background-color 0.3s;
    }
    
    .page-header button:hover {
        background-color: #0056b3;
    }
    
    .page-header button a {
        color: #fff;
        text-decoration: none;
    }
    
    /* Profile Photo */
    .profile-photo {
        width: 150px;
        height: 150px;
        object-fit: cover;
        border-radius: 50%;
        border: 3px solid #007bff;
        margin-bottom: 10px;
    }
    
    /* Profile Details */
    .col-md-9 p {
        margin-bottom: 10px;
        font-size: 15px;
        color: #555;
    }
    
    .col-md-9 p strong {
        width: 160px;
        display: inline-block;
        color: #222;
    }
    
    /* Warning Message */
    .profile-warning {
        color: #d9534f;
        font-size: 13px;
        margin-left: 10px;
    }
    
    /* Documents and Gallery */
    .d-flex.gap-2 {
        gap: 10px;
    }
    
    .gallery-img {
        width: 100px;
        height: 100px;
        object-fit: cover;
        border-radius: 8px;
        border: 1px solid #ddd;
        transition: 0.3s;
    }
    
    .gallery-img:hover {
        transform: scale(1.05);
        border-color: #007bff;
    }
    
    /* Responsive */
    @media (max-width: 768px) {
        .profile-photo {
            width: 120px;
            height: 120px;
        }
        .gallery-img {
            width: 80px;
            height: 80px;
        }
    }
    </style>
    
@endsection

@section('content')
<div class="content-wrapper">

    @foreach($profiles as $profile)
    <div class="profile-box row">
        {{-- Profile Header --}}
        <div class="col-md-12">
            <div class="page-header mb-4" style="display: flex; justify-content: space-between; align-items: center;">
                <div class="page-title">
                    <h3>All Profiles</h3>
                </div>
                <!-- Styled Edit Profile Button -->
                <button style="padding: 6px 15px; border-radius: 4px; font-size: 14px; background-color: #007bff; color: #fff; border: none;">
                    <a href="{{ route('professional.profile.edit', ['profile' => $profile->id]) }}" style="color: #fff; text-decoration: none;">Edit Profile</a>
                </button>
                
            </div>
        </div>

        {{-- Left Photo --}}
        <div class="col-md-3 text-center">
            <img src="{{ $profile->photo ? asset($profile->photo) : asset('default.jpg') }}" alt="Photo" class="profile-photo mb-3">
        </div>

        {{-- Details --}}
        <div class="col-md-9">
            <p><strong>Name</strong> {{ $profile->professional->name ?? 'N/A' }} 
                @if(!$profile->professional->name) <span class="profile-warning">Please edit your profile</span> @endif
            </p>
            <p><strong>Email:</strong> {{ $profile->email ?? 'N/A' }} 
                @if(!$profile->email) <span class="profile-warning">Please edit your profile</span> @endif
            </p>
            <p><strong>Phone:</strong> {{ $profile->phone ?? 'N/A' }} 
                @if(!$profile->phone) <span class="profile-warning">Please edit your profile</span> @endif
            </p>
            <p><strong>Specialization:</strong> {{ $profile->specialization ?? 'N/A' }} 
                @if(!$profile->specialization) <span class="profile-warning">Please edit your profile</span> @endif
            </p>
            <p><strong>Experience:</strong> {{ $profile->experience ?? 'N/A' }} 
                @if(!$profile->experience) <span class="profile-warning">Please edit your profile</span> @endif
            </p>
            <p><strong>Starting Price:</strong> ₹{{ $profile->starting_price ?? 'N/A' }} 
                @if(!$profile->starting_price) <span class="profile-warning">Please edit your profile</span> @endif
            </p>
            <p><strong>Address:</strong> {{ $profile->address ?? 'N/A' }} 
                @if(!$profile->address) <span class="profile-warning">Please edit your profile</span> @endif
            </p>
            <p><strong>Education:</strong> {{ $profile->education ?? 'N/A' }} 
                @if(!$profile->education) <span class="profile-warning">Please edit your profile</span> @endif
            </p>
            <p><strong>Comments:</strong> {{ $profile->comments ?? 'N/A' }} 
                @if(!$profile->comments) <span class="profile-warning">Please edit your profile</span> @endif
            </p>
            <p><strong>Bio:</strong> {{ $profile->bio ?? 'N/A' }} 
                @if(!$profile->bio) <span class="profile-warning">Please edit your profile</span> @endif
            </p>
            <p><strong>Created At:</strong> {{ $profile->created_at->format('d M, Y') }}</p>

            {{-- Documents --}}
            <p><strong>Qualification Document:</strong> 
                @if($profile->qualification_document)
                    <a href="{{ asset($profile->qualification_document) }}" target="_blank">View</a>
                @else 
                    <span class="profile-warning">Please upload document</span>
                @endif
            </p>
            <p><strong>Aadhaar Card:</strong> 
                @if($profile->aadhaar_card)
                    <a href="{{ asset($profile->aadhaar_card) }}" target="_blank">View</a>
                @else 
                    <span class="profile-warning">Please upload Aadhaar card</span>
                @endif
            </p>
            <p><strong>PAN Card:</strong> 
                @if($profile->pan_card)
                    <a href="{{ asset($profile->pan_card) }}" target="_blank">View</a>
                @else 
                    <span class="profile-warning">Please upload PAN card</span>
                @endif
            </p>

            {{-- Gallery --}}
          
        </div>
        
    </div>
    <p><strong>Gallery:</strong></p>
    <div class="d-flex flex-wrap gap-2">
        @php
            $gallery = is_array($profile->gallery) ? $profile->gallery : json_decode($profile->gallery, true);
        @endphp
        @if ($gallery && is_array($gallery))
            @foreach ($gallery as $img)
                <img src="{{ asset($img) }}" alt="Gallery" class="gallery-img">
            @endforeach
        @else
            <p><span class="profile-warning">No gallery images available</span></p>
        @endif
    </div>
    @endforeach

    @if($profiles->isEmpty())
        <div class="alert alert-warning">No profiles found.</div>
    @endif
</div>
@endsection
