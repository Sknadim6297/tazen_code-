@extends('admin.layouts.layout')
@section('content')
<div class="main-content app-content">
    <div class="container">
        <h4>Edit Event Details</h4>
    
        <form action="{{ route('admin.eventdetails.update', $eventdetail->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
    
            <div class="row gy-3">
    
                {{-- Banner Image --}}
                <div class="col-xl-12">
                    <label for="banner_image" class="form-label">Banner Image</label>
                    <input type="file" class="form-control" name="banner_image" id="banner_image" accept="image/*">
                    @if($eventdetail->banner_image)
                        <img src="{{ asset('storage/' . $eventdetail->banner_image) }}" class="mt-2" width="200">
                    @endif
                </div>
    
                {{-- Event Name Dropdown --}}
                <div class="col-xl-6">
                    <label for="event_name" class="form-label">Event Name</label>
                    <select class="form-select" name="event_name" id="event_name" required>
                        <option value="" disabled>Select Event</option>
                        @foreach(\App\Models\AllEvent::all() as $event)
                            <option value="{{ $event->heading }}" {{ $eventdetail->event_name == $event->heading ? 'selected' : '' }}>
                                {{ $event->heading }}
                            </option>
                        @endforeach
                    </select>
                </div>
    
                {{-- Event Type --}}
                <div class="col-xl-6">
                    <label for="event_type" class="form-label">Event Type</label>
                    <input type="text" class="form-control" name="event_type" id="event_type" value="{{ old('event_type', $eventdetail->event_type) }}" required>
                </div>
    
                {{-- Event Details --}}
                <div class="col-xl-12">
                    <label for="event_details" class="form-label">Event Details</label>
                    <textarea class="form-control" name="event_details" id="event_details" rows="4" required>{{ old('event_details', $eventdetail->event_details) }}</textarea>
                </div>
    
                {{-- Starting Date --}}
                <div class="col-xl-6">
                    <label for="starting_date" class="form-label">Starting Date</label>
                    <input type="date" class="form-control" name="starting_date" id="starting_date" value="{{ old('starting_date', $eventdetail->starting_date) }}" required>
                </div>
    
                {{-- Starting Fees --}}
                <div class="col-xl-6">
                    <label for="starting_fees" class="form-label">Starting Fees</label>
                    <input type="number" class="form-control" name="starting_fees" id="starting_fees" value="{{ old('starting_fees', $eventdetail->starting_fees) }}" min="0" required>
                </div>
    
                {{-- Event Gallery --}}
                <div class="col-xl-12">
                    <label for="event_gallery" class="form-label">Event Gallery (Multiple Images)</label>
                    <input type="file" class="form-control" name="event_gallery[]" id="event_gallery" accept="image/*" multiple>
                    @if($eventdetail->event_gallery)
                        <div class="mt-2">
                            @foreach(json_decode($eventdetail->event_gallery, true) as $img)
                                <img src="{{ asset('storage/' . $img) }}" width="100" class="me-2 mb-2">
                            @endforeach
                        </div>
                    @endif
                </div>
    
                {{-- Map Location Link --}}
                <div class="col-xl-12">
                    <label for="map_link" class="form-label">Event Location Map Link</label>
                    <input type="text" class="form-control" name="map_link" id="map_link" value="{{ old('map_link', $eventdetail->map_link) }}" placeholder="Paste Google Map URL">
                    <small class="text-muted">Example: https://www.google.com/maps/place/Chandannagar,+West+Bengal</small>
                </div>
    
            </div>
    
            <div class="mt-4">
                <a href="{{ route('admin.eventdetails.index') }}" class="btn btn-light">Cancel</a>
                <button type="submit" class="btn btn-primary">Update Event</button>
            </div>
        </form>
    </div>

</div>
@endsection