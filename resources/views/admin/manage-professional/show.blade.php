@extends('admin.layouts.layout')

@section('content')
<div class="main-content app-content">
    <div class="container-fluid">

        @foreach($profiles as $profile)
            <div class="card mb-4 shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">{{ $profile->professional->name ?? 'Professional Profile' }}</h5>
                </div>

                <div class="card-body row g-4">
                    {{-- Profile Image --}}
                    <div class="col-md-3 text-center">
                        <img src="{{ $profile->photo ? asset($profile->photo) : asset('default.jpg') }}" 
                             class="img-thumbnail rounded-circle mb-3" width="150" alt="Profile Image">
                    </div>

                    {{-- Basic Details --}}
                    <div class="col-md-9">
                        <div class="row">
                            <div class="col-md-6"><strong>First Name:</strong> {{ $profile->first_name }}</div>
                            <div class="col-md-6"><strong>Last Name:</strong> {{ $profile->last_name }}</div>
                            <div class="col-md-6"><strong>Email:</strong> {{ $profile->email }}</div>
                            <div class="col-md-6"><strong>Phone:</strong> {{ $profile->phone }}</div>
                            <div class="col-md-6"><strong>Specialization:</strong> {{ $profile->specialization }}</div>
                            <div class="col-md-6"><strong>Experience:</strong> {{ $profile->experience }}</div>
                            <div class="col-md-6"><strong>Starting Price:</strong> ₹{{ $profile->starting_price }}</div>
                            <div class="col-md-6"><strong>Address:</strong> {{ $profile->address }}</div>
                            <div class="col-md-6"><strong>Education:</strong> {{ $profile->education }}</div>
                            <div class="col-md-6"><strong>Created At:</strong> {{ \Carbon\Carbon::parse($profile->created_at)->format('d-M-Y') }}</div>
                        </div>

                        <div class="mt-3">
                            <strong>Comments:</strong>
                            <p>{{ $profile->comments }}</p>
                            <strong>Bio:</strong>
                            <p>{{ $profile->bio }}</p>
                        </div>
                    </div>

         {{-- Documents --}}
<div class="col-md-12 mt-3">
    <h6 class="fw-bold">Documents</h6>
    <ul class="list-inline">
        <li class="list-inline-item me-4">
            <strong>Qualification:</strong>
            @if($profile->qualification_document)
                <a href="{{ asset('upload/docs/'.$profile->qualification_document) }}" target="_blank" class="btn btn-outline-primary btn-sm">
                    <i class="fas fa-file-pdf"></i> View
                </a>
            @else
                <span class="text-muted">N/A</span>
            @endif
        </li>
        <li class="list-inline-item me-4">
            <strong>Aadhaar:</strong>
            @if($profile->aadhaar_card)
                <a href="{{ asset('upload/docs/'.$profile->aadhaar_card) }}" target="_blank" class="btn btn-outline-success btn-sm">
                    <i class="fas fa-id-card"></i> View
                </a>
            @else
                <span class="text-muted">N/A</span>
            @endif
        </li>
        <li class="list-inline-item">
            <strong>PAN:</strong>
            @if($profile->pan_card)
                <a href="{{ asset('upload/docs/'.$profile->pan_card) }}" target="_blank" class="btn btn-outline-warning btn-sm">
                    <i class="fas fa-credit-card"></i> View
                </a>
            @else
                <span class="text-muted">N/A</span>
            @endif
        </li>
    </ul>
</div>


                    {{-- Gallery --}}
                    <div class="col-md-12 mt-3">
                        <h6 class="fw-bold">Gallery</h6>
                        <div class="d-flex flex-wrap gap-2">
                            @php
                                $gallery = is_array($profile->gallery) ? $profile->gallery : json_decode($profile->gallery, true);
                            @endphp

                            @if ($gallery && is_array($gallery))
                                @foreach ($gallery as $img)
                                    <img src="{{ asset('upload/gallery/'.$img) }}" alt="Gallery" class="img-thumbnail" width="80">
                                @endforeach
                            @else
                                <p>No images available</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @endforeach

    </div>
</div>
@endsection
