@extends('professional.layout.layout')

@section('style')
<style>
    .profile-box {
        background: #fff;
        padding: 25px;
        border-radius: 12px;
        box-shadow: 0 0 15px rgba(0,0,0,0.05);
        margin-bottom: 30px;
    }
    .profile-photo {
        width: 130px;
        height: 130px;
        border-radius: 50%;
        object-fit: cover;
    }
    .gallery-img {
        width: 80px;
        height: 80px;
        object-fit: cover;
        border-radius: 8px;
    }
    .profile-warning {
        color: red;
        font-weight: bold;
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
            <p class="fw-bold mb-0">{{ $profile->professional->name ?? 'N/A' }}</p>
        </div>

        {{-- Details --}}
        <div class="col-md-9">
            <p><strong>First Name:</strong> {{ $profile->first_name ?? 'N/A' }} 
                @if(!$profile->first_name) <span class="profile-warning">Please edit your profile</span> @endif
            </p>
            <p><strong>Last Name:</strong> {{ $profile->last_name ?? 'N/A' }} 
                @if(!$profile->last_name) <span class="profile-warning">Please edit your profile</span> @endif
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
            <p><strong>Gallery:</strong></p>
            <div class="d-flex flex-wrap gap-2">
                @php
                    $gallery = is_array($profile->gallery) ? $profile->gallery : json_decode($profile->gallery, true);
                @endphp
                @if ($gallery && is_array($gallery))
                    @foreach ($gallery as $img)
                        <img src="{{ asset('upload/gallery/'.$img) }}" alt="Gallery" class="gallery-img">
                    @endforeach
                @else
                    <p><span class="profile-warning">No gallery images available</span></p>
                @endif
            </div>
        </div>
    </div>
    @endforeach

    @if($profiles->isEmpty())
        <div class="alert alert-warning">No profiles found.</div>
    @endif
</div>
@endsection
