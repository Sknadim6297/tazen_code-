@extends('admin.layouts.layout')
@section('content')
<div class="main-content app-content">
    <div class="container mt-5">
        <form action="{{ route('admin.service-details.update', $serviceDetail->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
        
            <!-- Service Name -->
            <div class="card mb-4">
                <div class="card-header bg-light">
                    <h6>Service Name</h6>
                </div>
                <div class="card-body">
                    <select class="form-select" name="service_id" required>
                        @foreach($services as $service)
                            <option value="{{ $service->id }}" {{ $service->id == $serviceDetail->service_id ? 'selected' : '' }}>
                                {{ $service->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
        
            <!-- Banner Section -->
            <div class="card mb-4">
                <div class="card-header bg-light"><h6>Banner Section</h6></div>
                <div class="card-body">
                    <input type="file" class="form-control" name="banner_image">
                    @if($serviceDetail->banner_image)
                        <img src="{{ asset('storage/'.$serviceDetail->banner_image) }}" class="img-fluid mt-2" width="150">
                    @endif
                    <input type="text" class="form-control mt-2" name="banner_heading" value="{{ $serviceDetail->banner_heading }}" required>
                    <input type="text" class="form-control mt-2" name="banner_sub_heading" value="{{ $serviceDetail->banner_sub_heading }}">
                </div>
            </div>
        
            <!-- About Section -->
            <div class="card mb-4">
                <div class="card-header bg-light"><h6>About Section</h6></div>
                <div class="card-body">
                    <input type="file" class="form-control" name="about_image">
                    @if($serviceDetail->about_image)
                        <img src="{{ asset('storage/'.$serviceDetail->about_image) }}" class="img-fluid mt-2" width="150">
                    @endif
                    <input type="text" class="form-control mt-2" name="about_heading" value="{{ $serviceDetail->about_heading }}" required>
                    <input type="text" class="form-control mt-2" name="about_subheading" value="{{ $serviceDetail->about_subheading }}">
                    <textarea class="form-control mt-2" name="about_description" rows="4">{{ $serviceDetail->about_description }}</textarea>
                </div>
            </div>
        
            <!-- How It Works Section -->
            <div class="card mb-4">
                <div class="card-header bg-light"><h6>How It Works</h6></div>
                <div class="card-body">
                    <input type="file" class="form-control" name="background_image">
                    @if($serviceDetail->background_image)
                        <img src="{{ asset('storage/'.$serviceDetail->background_image) }}" class="img-fluid mt-2" width="150">
                    @endif
                    <input type="text" class="form-control mt-2" name="how_it_works_subheading" value="{{ $serviceDetail->how_it_works_subheading }}">
                    <input type="text" class="form-control mt-2" name="content_heading" value="{{ $serviceDetail->content_heading }}" required>
                    <input type="text" class="form-control mt-2" name="content_sub_heading" value="{{ $serviceDetail->content_sub_heading }}">
        
                    <hr>
                    <h6>Steps</h6>
                    @for($i = 1; $i <= 3; $i++)
                        <input type="text" class="form-control mb-2" name="step{{ $i }}_heading" value="{{ $serviceDetail->{'step'.$i.'_heading'} }}">
                        <textarea class="form-control mb-3" name="step{{ $i }}_description" rows="3">{{ $serviceDetail->{'step'.$i.'_description'} }}</textarea>
                    @endfor
                </div>
            </div>
        
            <div class="d-flex justify-content-end">
                <a href="{{ route('admin.service-details.index') }}" class="btn btn-secondary me-2">Cancel</a>
                <button type="submit" class="btn btn-primary">Update</button>
            </div>
        </form>
        
    </div>
</div>
@endsection