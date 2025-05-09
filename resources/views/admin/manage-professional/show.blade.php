@extends('admin.layouts.layout')
@section('styles')
<style>
        .profile-card {
        background-color: #f9f9f9;
        border-radius: 10px;
    }

    .profile-card .card-header {
        background-color: #007bff;
        color: white;
        font-size: 1.2rem;
        text-align: center;
    }

    .profile-card .card-body {
        padding: 20px;
    }

    .profile-img {
        border: 5px solid #007bff;
    }

    .comment-text, .bio-text {
        color: #555;
        line-height: 1.6;
    }

    .documents-section {
        margin-top: 30px;
    }

    .gallery-section {
        margin-top: 20px;
    }

    .gallery-images img {
        margin: 5px;
        transition: transform 0.3s ease;
    }

    .gallery-images img:hover {
        transform: scale(1.1);
    }

    .availability-section p, .services-section p {
        color: #333;
        font-size: 1rem;
    }

    .service-card {
        background-color: #f4f6f9;
        border: 1px solid #ddd;
        border-radius: 8px;
    }

    .service-img {
        border-radius: 8px;
    }

    /* Button styling */
    .btn-outline-primary, .btn-outline-success, .btn-outline-warning {
        border-radius: 5px;
        font-size: 0.875rem;
        transition: background-color 0.3s ease;
    }

    .btn-outline-primary:hover, .btn-outline-success:hover, .btn-outline-warning:hover {
        background-color: rgba(0, 123, 255, 0.1);
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
                            <div class="col-md-6"><strong>First Name:</strong> {{ $profile->first_name }}</div>
                            <div class="col-md-6"><strong>Last Name:</strong> {{ $profile->last_name }}</div>
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
