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
                    <label for="event_id" class="form-label">Event Name</label>
                    <select class="form-select" name="event_id" id="event_id" required onchange="fetchEventDetails(this.value)">
                        <option value="" disabled>Select Event</option>
                        @foreach(\App\Models\AllEvent::all() as $event)
                            <option value="{{ $event->id }}" 
                                {{ $eventdetail->event_id == $event->id ? 'selected' : '' }}
                                data-mini-heading="{{ $event->mini_heading }}"
                                data-fees="{{ $event->starting_fees }}">
                                {{ $event->heading }}
                            </option>
                        @endforeach
                    </select>
                </div>
    
                {{-- Event Type (Mini Heading) --}}
                <div class="col-xl-6">
                    <label for="event_type" class="form-label">Event Type</label>
                    <input type="text" class="form-control" name="event_type" id="event_type" value="{{ old('event_type', $eventdetail->event_type) }}" required readonly>
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
                    <input type="number" class="form-control" name="starting_fees" id="starting_fees" value="{{ old('starting_fees', $eventdetail->starting_fees) }}" min="0" required readonly>
                </div>

                {{-- Event Mode --}}
                <div class="col-xl-6">
                    <label for="event_mode" class="form-label">Event Mode</label>
                    <select class="form-select" name="event_mode" id="event_mode" required onchange="toggleCityField(this.value)">
                        <option value="" disabled>Select Mode</option>
                        <option value="online" {{ $eventdetail->event_mode === 'online' ? 'selected' : '' }}>Online</option>
                        <option value="offline" {{ $eventdetail->event_mode === 'offline' ? 'selected' : '' }}>Offline</option>
                    </select>
                </div>

                {{-- City Name (Only for Offline Mode) --}}
                <div class="col-xl-6" id="cityField" style="display: {{ $eventdetail->event_mode === 'offline' ? 'block' : 'none' }};">
                    <label for="city" class="form-label">City Name</label>
                    <select class="form-select" name="city" id="city" {{ $eventdetail->event_mode === 'offline' ? 'required' : '' }}>
                        <option value="" disabled selected>Select City</option>
                        <option value="Mumbai" {{ $eventdetail->city === 'Mumbai' ? 'selected' : '' }}>Mumbai</option>
                        <option value="Pune" {{ $eventdetail->city === 'Pune' ? 'selected' : '' }}>Pune</option>
                        <option value="Kolkata" {{ $eventdetail->city === 'Kolkata' ? 'selected' : '' }}>Kolkata</option>
                        <option value="Delhi" {{ $eventdetail->city === 'Delhi' ? 'selected' : '' }}>Delhi</option>
                        <option value="Bangalore" {{ $eventdetail->city === 'Bangalore' ? 'selected' : '' }}>Bangalore</option>
                    </select>
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
    
            </div>
    
            <div class="mt-4">
                <a href="{{ route('admin.eventdetails.index') }}" class="btn btn-light">Cancel</a>
                <button type="submit" class="btn btn-primary">Update Event</button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
function fetchEventDetails(eventId) {
    // Get the selected option
    const selectedOption = document.querySelector(`#event_id option[value="${eventId}"]`);
    
    if (selectedOption) {
        // Get the data attributes
        const miniHeading = selectedOption.getAttribute('data-mini-heading');
        const eventFees = selectedOption.getAttribute('data-fees');
        
        // Populate the fields
        document.getElementById('event_type').value = miniHeading || '';
        document.getElementById('starting_fees').value = eventFees || '';
    }
}

function toggleCityField(mode) {
    const cityField = document.getElementById('cityField');
    const citySelect = document.getElementById('city');

    if (mode === 'offline') {
        cityField.style.display = 'block';
        citySelect.required = true;
    } else {
        cityField.style.display = 'none';
        citySelect.required = false;
        citySelect.value = ''; // Clear city value
    }
}

// Initialize fields on page load
document.addEventListener('DOMContentLoaded', function() {
    const eventId = document.getElementById('event_id').value;
    if (eventId) {
        fetchEventDetails(eventId);
    }
    
    const eventMode = document.getElementById('event_mode').value;
    if (eventMode) {
        toggleCityField(eventMode);
    }
});
</script>
@endsection