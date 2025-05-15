@extends('admin.layouts.layout')
@section('styles')
<style>
    /* Base Card Styling */
    .profile-card {
        background-color: #ffffff;
        border-radius: 16px;
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.08);
        overflow: hidden;
        transition: transform 0.3s ease;
    }

    .profile-card:hover {
        transform: translateY(-4px);
    }

    .profile-card .card-header {
        background: linear-gradient(135deg, #4e54c8, #8f94fb);
        color: #fff;
        font-size: 1.5rem;
        font-weight: 600;
        padding: 20px;
        text-align: center;
        letter-spacing: 1px;
    }

    .profile-card .card-body {
        padding: 25px;
    }

    /* Profile Image */
    .profile-img {
        border-radius: 50%;
        border: 4px solid #4e54c8;
        width: 120px;
        height: 120px;
        object-fit: cover;
        margin: 0 auto 20px;
        display: block;
    }

    .comment-text,
    .bio-text {
        color: #333;
        font-size: 1rem;
        line-height: 1.7;
        margin-bottom: 1rem;
    }

    .documents-section,
    .gallery-section {
        margin-top: 30px;
    }

    .gallery-section h4 {
        font-weight: 600;
        margin-bottom: 10px;
    }

    .gallery-images {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
    }

    .gallery-images img {
        width: 100px;
        height: 100px;
        object-fit: cover;
        border-radius: 8px;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .gallery-images img:hover {
        transform: scale(1.05);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    }

    .availability-section p,
    .services-section p {
        color: #555;
        font-size: 1rem;
        margin-bottom: 8px;
    }

    .service-card {
        background-color: #f8f9fc;
        border: 1px solid #e0e6ed;
        border-radius: 12px;
        padding: 15px;
        transition: box-shadow 0.3s ease;
    }

    .service-card:hover {
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.05);
    }

    .service-img {
        border-radius: 10px;
        width: 100%;
        height: auto;
    }

    /* Buttons */
    .btn-outline-primary,
    .btn-outline-success,
    .btn-outline-warning {
        border-radius: 8px;
        font-size: 0.9rem;
        padding: 8px 16px;
        transition: all 0.3s ease;
    }

    .btn-outline-primary:hover {
        background-color: #4e54c8;
        color: white;
        border-color: #4e54c8;
    }

    .btn-outline-success:hover {
        background-color: #28a745;
        color: white;
        border-color: #28a745;
    }

    .btn-outline-warning:hover {
        background-color: #ffc107;
        color: white;
        border-color: #ffc107;
    }
</style>

@endsection

@section('content')
<div class="main-content app-content">
    <div class="container-fluid">

        @foreach($profiles as $profile)
            <div class="card profile-card mb-4 shadow-lg">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">{{ $profile->professional->name ?? 'Professional Profile' }}</h5>
                </div>

                <div class="card-body row g-4">
                    {{-- Profile Image --}}
                    <div class="col-md-3 text-center">
                        <img src="{{ $profile->photo ? asset($profile->photo) : asset('default.jpg') }}" 
                             class="img-thumbnail rounded-circle profile-img mb-3" width="150" alt="Profile Image">
                    </div>

                    {{-- Basic Details --}}
                    <div class="col-md-9">
                        <div class="row">
                            <div class="col-md-6"><strong>Name:</strong> {{ $profile->name }}</div>
                            <div class="col-md-6"><strong>Email:</strong> {{ $profile->email }}</div>
                            <div class="col-md-6"><strong>Phone:</strong> {{ $profile->phone }}</div>
                            <div class="col-md-6"><strong>Specialization:</strong> {{ $profile->specialization }}</div>
                            <div class="col-md-6"><strong>Experience:</strong> {{ $profile->experience }} years</div>
                            <div class="col-md-6"><strong>Starting Price:</strong> ₹{{ $profile->starting_price }}</div>
                            <div class="col-md-6"><strong>Address:</strong> {{ $profile->address }}</div>
                            <div class="col-md-6"><strong>Education:</strong> {{ $profile->education }}</div>
                            <div class="col-md-6"><strong>Created At:</strong> {{ \Carbon\Carbon::parse($profile->created_at)->format('d-M-Y') }}</div>
                        </div>

                        <div class="mt-3">
                            <strong>Comments:</strong>
                            <p class="comment-text">{{ $profile->comments }}</p>
                            <strong>Bio:</strong>
                            <p class="bio-text">{{ $profile->bio }}</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Documents --}}
            <div class="documents-section">
                <h6 class="fw-bold">Documents</h6>
                <ul class="list-inline">
                    <li class="list-inline-item">
                        <strong>Qualification:</strong>
                        @if($profile->qualification_document)
                            <a href="{{ asset($profile->qualification_document) }}" target="_blank" class="btn btn-outline-primary btn-sm">
                                <i class="fas fa-file-pdf"></i> View
                            </a>
                        @else
                            <span class="text-muted">N/A</span>
                        @endif
                    </li>
                    <li class="list-inline-item">
                        <strong>Aadhaar:</strong>
                        @if($profile->aadhaar_card)
                            <a href="{{ asset($profile->aadhaar_card) }}" target="_blank" class="btn btn-outline-success btn-sm">
                                <i class="fas fa-id-card"></i> View
                            </a>
                        @else
                            <span class="text-muted">N/A</span>
                        @endif
                    </li>
                    <li class="list-inline-item">
                        <strong>PAN:</strong>
                        @if($profile->pan_card)
                            <a href="{{ asset($profile->pan_card) }}" target="_blank" class="btn btn-outline-warning btn-sm">
                                <i class="fas fa-credit-card"></i> View
                            </a>
                        @else
                            <span class="text-muted">N/A</span>
                        @endif
                    </li>
                </ul>
            </div>

            {{-- Gallery --}}
            <div class="gallery-section mt-3">
                <h6 class="fw-bold">Gallery</h6>
                <div class="gallery-images">
                    @php
                        $gallery = is_array($profile->gallery) ? $profile->gallery : json_decode($profile->gallery, true);
                    @endphp
                    @if ($gallery && is_array($gallery))
                        @foreach ($gallery as $img)
                            <img src="{{ asset($img) }}" alt="Gallery Image" class="img-thumbnail gallery-img" width="120">
                        @endforeach
                    @else
                        <p>No images available</p>
                    @endif
                </div>
            </div>

            {{-- Availability --}}
            <div class="availability-section mt-4">
                <h5>Availability:</h5>
                @foreach($availabilities as $availability)
                    <p><strong>Month:</strong> {{ $availability->month }}</p>
                    <p><strong>Session Duration:</strong> {{ $availability->session_duration }} minutes</p>
                    <p><strong>Weekdays:</strong> {{ implode(', ', json_decode($availability->weekdays)) }}</p>
                    <p><strong>Slots:</strong></p>
                    @foreach($availability->slots as $slot)
                        <p>{{ $slot->start_time }} - {{ $slot->end_time }} ({{ $slot->start_period }} - {{ $slot->end_period }})</p>
                    @endforeach
                @endforeach
            </div>

            {{-- Services --}}
            <div class="services-section mt-4">
                <h5>Services:</h5>
                @foreach($services as $service)
                    <div class="service-card mb-3 p-3 border rounded shadow-sm">
                        <p><strong>Service Name:</strong> {{ $service->service_name }}</p>
                        <p><strong>Category:</strong> {{ $service->category }}</p>
                        <p><strong>Duration:</strong> {{ $service->duration }} minutes</p>

                        @if($service->image_path)
                            <p><strong>Image:</strong> <img src="{{ asset($service->image_path) }}" alt="{{ $service->service_name }}" class="service-img" width="120"></p>
                        @else
                            <p><strong>Image:</strong> No image available</p>
                        @endif

                        <p><strong>Description:</strong> {{ $service->description }}</p>

                        @if($service->features)
                            <p><strong>Features:</strong>
                                <ul>
                                    @foreach(json_decode($service->features) as $feature)
                                        <li>{{ $feature }}</li>
                                    @endforeach
                                </ul>
                            </p>
                        @else
                            <p><strong>Features:</strong> No features available</p>
                        @endif

                        @if($service->tags)
                            <p><strong>Tags:</strong> {{ $service->tags }}</p>
                        @else
                            <p><strong>Tags:</strong> No tags available</p>
                        @endif

                        @if($service->requirements)
                            <p><strong>Requirements:</strong> {{ $service->requirements }}</p>
                        @else
                            <p><strong>Requirements:</strong> No requirements listed</p>
                        @endif
                    </div>
                @endforeach
            </div>
                
                
                {{-- Ratings --}}
                <div class="ratings-section mt-4">
                    <h5>Ratings:</h5>
                    @foreach($rates as $rate)
                        <div class="rate-card mb-3 p-3" style="background-color: #f1f1f1; border-radius: 8px;">
                            <p><strong>Session Type:</strong> {{ $rate->session_type }}</p>
                            <p><strong>Number of Sessions:</strong> {{ $rate->num_sessions }}</p>
                            <p><strong>Rate per Session:</strong> ₹{{ number_format($rate->rate_per_session, 2) }}</p>
                            <p><strong>Final Rate:</strong> ₹{{ number_format($rate->final_rate, 2) }}</p>
                            <p><strong>Duration:</strong> {{ $rate->duration }}</p>
                            <p><strong>Professional:</strong> {{ $rate->professional->name ?? 'N/A' }}</p>
                            <p><strong>Date:</strong> {{ \Carbon\Carbon::parse($rate->created_at)->format('d-M-Y') }}</p>
                        </div>
                        <hr>
                    @endforeach
                </div>
                
        @endforeach
        {{-- {{ Rate }} --}}
  
    </div>
</div>
@endsection
