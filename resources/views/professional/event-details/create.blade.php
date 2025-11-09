@extends('professional.layout.layout')

@section('content')
<div class="content-wrapper">
    <div class="page-header">
        <ul class="breadcrumb">
            <li>Home</li>
            <li><a href="{{ route('professional.event-details.index') }}">Event Details</a></li>
            <li class="active">Add Details</li>
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
                <h4>Add Event Details</h4>
                <div class="card-actions">
                    <a href="{{ route('professional.event-details.index') }}" class="btn btn-secondary btn-sm">
                        <i class="fas fa-arrow-left mr-1"></i>Back to List
                    </a>
                </div>
            </div>
                        <form action="{{ route('professional.event-details.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            
                            <div class="row">
                                <!-- Event Selection -->
                                <div class="col-xl-12 mb-3">
                                    <label for="event_id" class="form-label">Select Event <span class="text-danger">*</span></label>
                                    <select class="form-select" id="event_id" name="event_id" required>
                                        <option value="">Choose an event...</option>
                                        @foreach($availableEvents as $event)
                                            <option value="{{ $event->id }}" 
                                                    data-starting-date="{{ $event->date ? \Carbon\Carbon::parse($event->date)->format('Y-m-d') : '' }}"
                                                    data-starting-fees="{{ $event->starting_fees ?? '' }}"
                                                    data-description="{{ $event->short_description ?? '' }}"
                                                    data-heading="{{ $event->heading ?? '' }}"
                                                    data-mini-heading="{{ $event->mini_heading ?? '' }}"
                                                    {{ (old('event_id') ?? request('event_id')) == $event->id ? 'selected' : '' }}>
                                                {{ $event->heading }} - {{ $event->date ? \Carbon\Carbon::parse($event->date)->format('M d, Y') : 'No date' }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @if($availableEvents->count() === 0)
                                        <div class="form-text text-warning">
                                            <i class="fas fa-exclamation-triangle mr-1"></i>All your events already have details or you haven't created any events yet.
                                            <a href="{{ route('professional.events.create') }}" class="text-primary">Create a new event</a>
                                        </div>
                                    @endif
                                    <div class="form-text text-info">
                                        <i class="fas fa-info-circle mr-1"></i>Selecting an event will auto-fill: Event Type (from category), Starting Date, Starting Fees, and Event Details (from description)
                                    </div>
                                </div>

                                <!-- Banner Images -->
                                <div class="col-xl-12 mb-3">
                                    <label for="banner_image" class="form-label">Banner Images <span class="text-danger">*</span></label>
                                    <input type="file" class="form-control" id="banner_image" name="banner_image[]" multiple accept="image/*" required>
                                    <div class="form-text">Upload one or more banner images (JPG, PNG, WebP, max 2MB each)</div>
                                </div>

                                <!-- Event Type -->
                                <div class="col-xl-6 mb-3">
                                    <label for="event_type" class="form-label">Event Type <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="event_type" name="event_type" value="{{ old('event_type') }}" required placeholder="e.g., Workshop, Webinar, Conference">
                                    <div class="form-text text-muted">
                                        <i class="fas fa-magic mr-1"></i>Auto-filled from selected event's category
                                    </div>
                                </div>

                                <!-- Starting Date -->
                                <div class="col-xl-6 mb-3">
                                    <label for="starting_date" class="form-label">Starting Date <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control" id="starting_date" name="starting_date" value="{{ old('starting_date') }}" required>
                                    <div class="form-text text-muted">
                                        <i class="fas fa-magic mr-1"></i>Auto-filled from selected event's date
                                    </div>
                                </div>

                                <!-- Starting Fees -->
                                <div class="col-xl-6 mb-3">
                                    <label for="starting_fees" class="form-label">Starting Fees (₹) <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control" id="starting_fees" name="starting_fees" value="{{ old('starting_fees') }}" min="0" step="0.01" required>
                                    <div class="form-text text-muted">
                                        <i class="fas fa-magic mr-1"></i>Auto-filled from selected event's starting fees
                                    </div>
                                </div>

                                <!-- Event Mode -->
                                <div class="col-xl-6 mb-3">
                                    <label for="event_mode" class="form-label">Event Mode <span class="text-danger">*</span></label>
                                    <select class="form-select" id="event_mode" name="event_mode" required>
                                        <option value="">Select event mode...</option>
                                        <option value="online" {{ old('event_mode') === 'online' ? 'selected' : '' }}>Online</option>
                                        <option value="offline" {{ old('event_mode') === 'offline' ? 'selected' : '' }}>Offline</option>
                                    </select>
                                </div>

                                <!-- City (for offline events) -->
                                <div class="col-xl-12 mb-3" id="city_field" style="display: none;">
                                    <label for="city" class="form-label">City <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="city" name="city" value="{{ old('city') }}" placeholder="Enter city name">
                                    <div class="form-text">Required for offline events</div>
                                </div>

                                <!-- Event Details -->
                                <div class="col-xl-12 mb-3">
                                    <label for="event_details" class="form-label">Event Details <span class="text-danger">*</span></label>
                                    <textarea class="form-control" id="event_details" name="event_details" rows="6" required placeholder="Provide detailed information about the event, agenda, what participants will learn, etc.">{{ old('event_details') }}</textarea>
                                    <div class="form-text text-muted">
                                        <i class="fas fa-magic mr-1"></i>Auto-filled from selected event's description. You can edit and expand this content.
                                    </div>
                                </div>

                                <!-- Gallery Images -->
                                <div class="col-xl-12 mb-3">
                                    <label for="event_gallery" class="form-label">Gallery Images (Optional)</label>
                                    <input type="file" class="form-control" id="event_gallery" name="event_gallery[]" multiple accept="image/*">
                                    <div class="form-text">Upload additional images for the event gallery (JPG, PNG, WebP, max 2MB each)</div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-xl-12">
                                    <div class="d-flex gap-2">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-save mr-1"></i>Save Event Details
                                        </button>
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
    const eventSelect = document.getElementById('event_id');
    const eventModeSelect = document.getElementById('event_mode');
    const cityField = document.getElementById('city_field');
    const cityInput = document.getElementById('city');

    // Auto-fill form when event is selected
    function fillFormFromEvent() {
        const selectedOption = eventSelect.options[eventSelect.selectedIndex];
        
        if (selectedOption.value) {
            // Fill event type (use mini_heading as a suggestion)
            const miniHeading = selectedOption.getAttribute('data-mini-heading');
            if (miniHeading) {
                document.getElementById('event_type').value = miniHeading;
            }
            
            // Fill starting date
            const startingDate = selectedOption.getAttribute('data-starting-date');
            if (startingDate) {
                document.getElementById('starting_date').value = startingDate;
            }
            
            // Fill starting fees
            const startingFees = selectedOption.getAttribute('data-starting-fees');
            if (startingFees) {
                document.getElementById('starting_fees').value = startingFees;
            }
            
            // Fill description in event details
            const description = selectedOption.getAttribute('data-description');
            if (description) {
                const descriptionField = document.getElementById('event_details');
                if (descriptionField) {
                    descriptionField.value = description;
                }
            }
            
            // Note: event_mode and city are not pre-filled as they don't exist in AllEvent
            // User needs to manually select these for EventDetail
            
        } else {
            // Clear form if no event selected
            document.getElementById('event_type').value = '';
            document.getElementById('starting_date').value = '';
            document.getElementById('starting_fees').value = '';
            const descriptionField = document.getElementById('event_details');
            if (descriptionField) {
                descriptionField.value = '';
            }
            eventModeSelect.value = '';
            cityInput.value = '';
        }
        
        // Always trigger city field toggle after changes
        toggleCityField();
    }

    function toggleCityField() {
        if (eventModeSelect.value === 'offline') {
            cityField.style.display = 'block';
            cityInput.required = true;
        } else {
            cityField.style.display = 'none';
            cityInput.required = false;
            if (!eventSelect.value) {
                cityInput.value = '';
            }
        }
    }

    // Event listeners
    eventSelect.addEventListener('change', fillFormFromEvent);
    eventModeSelect.addEventListener('change', toggleCityField);
    
    // Initialize on page load
    toggleCityField();
    
    // Auto-fill if an event is pre-selected (from URL parameter)
    if (eventSelect.value) {
        fillFormFromEvent();
    }
});
</script>
@endsection