@extends('professional.layout.layout')

@section('content')
<div class="content-wrapper">
    <div class="page-header">
        <ul class="breadcrumb">
            <li>Home</li>
            <li><a href="{{ route('professional.event-details.index') }}">Event Details</a></li>
            <li class="active">Edit</li>
        </ul>
    </div>

    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            <div class="card-header">
                <h4>Edit Event Details</h4>
                <div class="card-actions">
                    <a href="{{ route('professional.event-details.index') }}" class="btn btn-secondary btn-sm">
                        <i class="fas fa-arrow-left mr-1"></i>Back to List
                    </a>
                    <a href="{{ route('professional.event-details.show', $eventDetail) }}" class="btn btn-info btn-sm">
                        <i class="fas fa-eye mr-1"></i>View Details
                    </a>
                </div>
            </div>
            <small class="text-muted">Editing details for "{{ $eventDetail->event->heading ?? 'Event' }}"</small>
                        <form action="{{ route('professional.event-details.update', $eventDetail) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            
                            <div class="row">
                                <!-- Event (Read-only) -->
                                <div class="col-xl-12 mb-3">
                                    <label class="form-label">Event</label>
                                    <input type="hidden" name="event_id" value="{{ $eventDetail->event_id }}">
                                    <input type="text" class="form-control" value="{{ $eventDetail->event->heading ?? 'N/A' }} - {{ $eventDetail->event->date ? \Carbon\Carbon::parse($eventDetail->event->date)->format('M d, Y') : 'No date' }}" readonly>
                                    <div class="form-text">Event cannot be changed when editing details</div>
                                </div>

                                <!-- Current Banner Images -->
                                @if($eventDetail->banner_image)
                                    <div class="col-xl-12 mb-3">
                                        <label class="form-label">Current Banner Images</label>
                                        <div class="row">
                                            @php
                                                $bannerImages = json_decode($eventDetail->banner_image);
                                            @endphp
                                            @if(is_array($bannerImages))
                                                @foreach($bannerImages as $image)
                                                    <div class="col-md-3 mb-2">
                                                        <img src="{{ asset('storage/' . $image) }}" alt="Current Banner" class="img-fluid rounded" style="max-height: 100px; object-fit: cover;">
                                                    </div>
                                                @endforeach
                                            @endif
                                        </div>
                                    </div>
                                @endif

                                <!-- New Banner Images -->
                                <div class="col-xl-12 mb-3">
                                    <label for="banner_image" class="form-label">Replace Banner Images (Optional)</label>
                                    <input type="file" class="form-control" id="banner_image" name="banner_image[]" multiple accept="image/*">
                                    <div class="form-text">Leave empty to keep current images. Upload new images to replace all current banner images (JPG, PNG, WebP, max 2MB each)</div>
                                </div>

                                <!-- Event Type -->
                                <div class="col-xl-6 mb-3">
                                    <label for="event_type" class="form-label">Event Type <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="event_type" name="event_type" value="{{ old('event_type', $eventDetail->event_type) }}" required placeholder="e.g., Workshop, Webinar, Conference">
                                </div>

                                <!-- Starting Date -->
                                <div class="col-xl-6 mb-3">
                                    <label for="starting_date" class="form-label">Starting Date <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control" id="starting_date" name="starting_date" value="{{ old('starting_date', $eventDetail->starting_date ? $eventDetail->starting_date->format('Y-m-d') : '') }}" required>
                                </div>

                                <!-- Starting Fees -->
                                <div class="col-xl-6 mb-3">
                                    <label for="starting_fees" class="form-label">Starting Fees (₹) <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control" id="starting_fees" name="starting_fees" value="{{ old('starting_fees', $eventDetail->starting_fees) }}" min="0" step="0.01" required>
                                </div>

                                <!-- Event Mode -->
                                <div class="col-xl-6 mb-3">
                                    <label for="event_mode" class="form-label">Event Mode <span class="text-danger">*</span></label>
                                    <select class="form-select" id="event_mode" name="event_mode" required>
                                        <option value="">Select event mode...</option>
                                        <option value="online" {{ old('event_mode', $eventDetail->event_mode) === 'online' ? 'selected' : '' }}>Online</option>
                                        <option value="offline" {{ old('event_mode', $eventDetail->event_mode) === 'offline' ? 'selected' : '' }}>Offline</option>
                                    </select>
                                </div>

                                <!-- City (for offline events) -->
                                <div class="col-xl-12 mb-3" id="city_field" style="display: none;">
                                    <label for="city" class="form-label">City <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="city" name="city" value="{{ old('city', $eventDetail->city) }}" placeholder="Enter city name">
                                    <div class="form-text">Required for offline events</div>
                                </div>

                                <!-- Event Details -->
                                <div class="col-xl-12 mb-3">
                                    <label for="event_details" class="form-label">Event Details <span class="text-danger">*</span></label>
                                    <textarea class="form-control" id="event_details" name="event_details" rows="6" required placeholder="Provide detailed information about the event, agenda, what participants will learn, etc.">{{ old('event_details', $eventDetail->event_details) }}</textarea>
                                </div>

                                <!-- Current Gallery Images -->
                                @if($eventDetail->event_gallery)
                                    @php
                                        $galleryImages = json_decode($eventDetail->event_gallery);
                                    @endphp
                                    @if(is_array($galleryImages) && count($galleryImages) > 0)
                                        <div class="col-xl-12 mb-3">
                                            <label class="form-label">Current Gallery Images</label>
                                            <div class="row">
                                                @foreach($galleryImages as $image)
                                                    <div class="col-md-2 mb-2">
                                                        <img src="{{ asset('storage/' . $image) }}" alt="Current Gallery" class="img-fluid rounded" style="max-height: 80px; object-fit: cover;">
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif
                                @endif

                                <!-- New Gallery Images -->
                                <div class="col-xl-12 mb-3">
                                    <label for="event_gallery" class="form-label">Replace Gallery Images (Optional)</label>
                                    <input type="file" class="form-control" id="event_gallery" name="event_gallery[]" multiple accept="image/*">
                                    <div class="form-text">Leave empty to keep current images. Upload new images to replace all current gallery images (JPG, PNG, WebP, max 2MB each)</div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-xl-12">
                                    <div class="d-flex gap-2">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-save mr-1"></i>Update Event Details
                                        </button>
                                        <a href="{{ route('professional.event-details.show', $eventDetail) }}" class="btn btn-secondary">
                                            <i class="fas fa-eye mr-1"></i>View Details
                                        </a>
                                        <a href="{{ route('professional.event-details.index') }}" class="btn btn-light">
                                            <i class="fas fa-arrow-left mr-1"></i>Back to List
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const eventModeSelect = document.getElementById('event_mode');
    const cityField = document.getElementById('city_field');
    const cityInput = document.getElementById('city');

    function toggleCityField() {
        if (eventModeSelect.value === 'offline') {
            cityField.style.display = 'block';
            cityInput.required = true;
        } else {
            cityField.style.display = 'none';
            cityInput.required = false;
        }
    }

    eventModeSelect.addEventListener('change', toggleCityField);
    
    // Initialize on page load
    toggleCityField();
});
</script>
@endsection