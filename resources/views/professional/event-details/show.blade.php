@extends('professional.layout.layout')

@section('content')
<div class="content-wrapper">
    <div class="page-header">
        <ul class="breadcrumb">
            <li>Home</li>
            <li><a href="{{ route('professional.event-details.index') }}">Event Details</a></li>
            <li class="active">View</li>
        </ul>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div>
                    <h4 class="mb-0">Event Details</h4>
                    <small class="text-muted">{{ $eventDetail->event->heading ?? 'Event Details' }}</small>
                </div>
                <div class="card-actions">
                    <a href="{{ route('professional.event-details.edit', $eventDetail) }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-edit mr-1"></i>Edit Details
                    </a>
                    <a href="{{ route('professional.event-details.index') }}" class="btn btn-secondary btn-sm">
                        <i class="fas fa-arrow-left mr-1"></i>Back to List
                    </a>
                </div>
            </div>
            
            <!-- Event Basic Information -->
            <div class="row mb-4">
                <div class="col-md-6">
                    <strong>Event Name:</strong>
                    <p class="mb-2">{{ $eventDetail->event->heading ?? 'N/A' }}</p>
                </div>
                <div class="col-md-6">
                    <strong>Event Type:</strong>
                    <p class="mb-2">
                        <span class="badge badge-primary">{{ $eventDetail->event_type }}</span>
                    </p>
                </div>
            </div>

            <div class="row mb-4">
                <div class="col-md-6">
                    <strong>Starting Date:</strong>
                    <p class="mb-2">{{ $eventDetail->starting_date ? $eventDetail->starting_date->format('l, F j, Y') : 'N/A' }}</p>
                </div>
                <div class="col-md-6">
                    <strong>Starting Fees:</strong>
                    <p class="mb-2">
                        <span class="text-success font-weight-bold">₹{{ number_format($eventDetail->starting_fees, 2) }}</span>
                    </p>
                </div>
            </div>

            <div class="row mb-4">
                <div class="col-md-6">
                    <strong>Event Mode:</strong>
                    <p class="mb-2">
                        @if($eventDetail->event_mode)
                            <span class="badge badge-{{ $eventDetail->event_mode === 'online' ? 'info' : 'warning' }}">
                                <i class="fas fa-{{ $eventDetail->event_mode === 'online' ? 'globe' : 'map-marker-alt' }} mr-1"></i>
                                {{ ucfirst($eventDetail->event_mode) }}
                            </span>
                        @else
                            <span class="text-muted">Not specified</span>
                        @endif
                    </p>
                </div>
                <div class="col-md-6">
                    <strong>City:</strong>
                    <p class="mb-2">{{ $eventDetail->city ?? 'N/A' }}</p>
                </div>
            </div>

            <!-- Event Details -->
            <div class="mb-4">
                <strong>Event Details:</strong>
                <div class="mt-2 p-3 bg-light rounded">
                    {!! nl2br(e($eventDetail->event_details)) !!}
                </div>
            </div>

            <!-- Banner Images -->
            @if($eventDetail->banner_image)
                <div class="mb-4">
                    <strong>Banner Images:</strong>
                    <div class="row mt-2">
                        @php
                            $bannerImages = json_decode($eventDetail->banner_image);
                        @endphp
                        @if(is_array($bannerImages))
                            @foreach($bannerImages as $image)
                                <div class="col-md-4 mb-3">
                                    <img src="{{ asset('storage/' . $image) }}" alt="Banner Image" class="img-fluid rounded" style="max-height: 200px; object-fit: cover; width: 100%;">
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            @endif

            <!-- Gallery Images -->
            @if($eventDetail->event_gallery)
                @php
                    $galleryImages = json_decode($eventDetail->event_gallery);
                @endphp
                @if(is_array($galleryImages) && count($galleryImages) > 0)
                    <div class="mb-4">
                        <strong>Gallery Images:</strong>
                        <div class="row mt-2">
                            @foreach($galleryImages as $image)
                                <div class="col-md-3 mb-3">
                                    <img src="{{ asset('storage/' . $image) }}" alt="Gallery Image" class="img-fluid rounded" style="max-height: 150px; object-fit: cover; width: 100%;">
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            @endif

            <!-- Action Buttons -->
            <div class="d-flex gap-2 mt-4">
                <a href="{{ route('professional.event-details.edit', $eventDetail) }}" class="btn btn-primary">
                    <i class="fas fa-edit mr-1"></i>Edit Event Details
                </a>
                <form action="{{ route('professional.event-details.destroy', $eventDetail) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this event detail? This action cannot be undone.')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-trash mr-1"></i>Delete Event Details
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection