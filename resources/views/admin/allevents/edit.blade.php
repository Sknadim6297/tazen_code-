@extends('admin.layouts.layout')
@section('content')
<div class="main-content app-content">
    <div class="container">
        <h4>Edit Event</h4>
        <form action="{{ route('admin.allevents.update', $allevent->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
    
            <div class="row gy-3">
    
                {{-- Existing Image Preview --}}
                <div class="col-xl-12">
                    <label for="card_image" class="form-label">Event Image</label><br>
                    @if ($allevent->card_image)
                        <img src="{{ asset('storage/' . $allevent->card_image) }}" width="150" class="mb-2 rounded">
                    @endif
                    <input type="file" class="form-control" id="card_image" name="card_image" accept="image/*">
                    <small class="text-muted">Leave blank to keep existing image.</small>
                </div>
    
                {{-- Date --}}
                <div class="col-xl-6">
                    <label for="date" class="form-label">Event Date</label>
                    <input type="date" class="form-control" id="date" name="date" value="{{ old('date', $allevent->date) }}" required>
                </div>
    
                {{-- Time --}}
                <div class="col-xl-6">
                    <label for="time" class="form-label">Event Time</label>
                    <input type="time" class="form-control" id="time" name="time" value="{{ old('time', $allevent->time) }}" required>
                </div>
    
                {{-- Starting Fees --}}
                <div class="col-xl-6">
                    <label for="starting_fees" class="form-label">Starting Fees</label>
                    <input type="number" class="form-control" id="starting_fees" name="starting_fees" value="{{ old('starting_fees', $allevent->starting_fees) }}" required>
                </div>
    
                {{-- Mini Heading --}}
                <div class="col-xl-12">
                    <label for="mini_heading" class="form-label">Mini Heading</label>
                    <input type="text" class="form-control" id="mini_heading" name="mini_heading" value="{{ old('mini_heading', $allevent->mini_heading) }}" required>
                </div>
    
                {{-- Heading --}}
                <div class="col-xl-12">
                    <label for="heading" class="form-label">Main Heading</label>
                    <input type="text" class="form-control" id="heading" name="heading" value="{{ old('heading', $allevent->heading) }}" required>
                </div>
    
                {{-- Short Description --}}
                <div class="col-xl-12">
                    <label for="short_description" class="form-label">Short Description</label>
                    <textarea class="form-control" id="short_description" name="short_description" rows="4" required>{{ old('short_description', $allevent->short_description) }}</textarea>
                </div>

                {{-- Meet Link (Only for Approved Events - Both Admin and Professional) --}}
                @if($allevent->isApproved())
                <div class="col-xl-12">
                    <label for="meet_link" class="form-label">Google Meet Link</label>
                    <input type="url" class="form-control" id="meet_link" name="meet_link" value="{{ old('meet_link', $allevent->meet_link) }}" placeholder="https://meet.google.com/xxx-xxxx-xxx">
                    <small class="text-muted">Provide the Google Meet link for this approved event.</small>
                </div>
                @endif
    
            </div>
    
            <div class="mt-4">
                <a href="{{ route('admin.allevents.index') }}" class="btn btn-secondary">Cancel</a>
                <button type="submit" class="btn btn-primary">Update Event</button>
            </div>
        </form>
    </div>
</div>
@endsection