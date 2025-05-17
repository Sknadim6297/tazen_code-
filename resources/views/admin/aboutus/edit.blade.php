@extends('admin.layouts.layout')
@section('content')
<div class="main-content app-content">
    <div class="container mt-4">
        <h4>Edit About Us Info</h4>
    
        <form action="{{ route('admin.aboutus.update', $about->id) }}" method="POST" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="row mb-3">
                <label for="heading" class="col-form-label col-md-2">Heading</label>
                <div class="col-md-10">
                    <input type="text" name="heading" class="form-control" id="heading" value="{{ old('heading', $about->heading) }}" required>
                </div>
            </div>
    
            <div class="row mb-3">
                <label for="year_of_experience" class="col-form-label col-md-2">Year of Experience</label>
                <div class="col-md-10">
                    <input type="number" name="year_of_experience" class="form-control" id="year_of_experience" value="{{ old('year_of_experience', $about->year_of_experience) }}" required>
                </div>
            </div>
    
            <div class="row mb-3">
                <label for="description" class="col-form-label col-md-2">Description</label>
                <div class="col-md-10">
                    <textarea name="description" class="form-control" id="description" rows="3" required>{{ old('description', $about->description) }}</textarea>
                </div>
            </div>
    
            <div class="row mb-3">
                <label for="line1" class="col-form-label col-md-2">Line 1</label>
                <div class="col-md-10">
                    <input type="text" name="line1" class="form-control" id="line1" value="{{ old('line1', $about->line1) }}">
                </div>
            </div>
    
            <div class="row mb-3">
                <label for="line2" class="col-form-label col-md-2">Line 2</label>
                <div class="col-md-10">
                    <input type="text" name="line2" class="form-control" id="line2" value="{{ old('line2', $about->line2) }}">
                </div>
            </div>
    
            <div class="row mb-3">
                <label for="image" class="col-form-label col-md-2">Image</label>
                <div class="col-md-10">
                    <input type="file" name="image" class="form-control" id="image" accept="image/*">
                    @if ($about->image)
                        <img src="{{ asset('uploads/aboutus/' . $about->image) }}" alt="About Image" width="150" class="mt-2">
                    @endif
                </div>
            </div>
    
            <div class="text-end">
                <a href="{{ route('admin.aboutus.index') }}" class="btn btn-secondary">Back</a>
                <button type="submit" class="btn btn-primary">Update</button>
            </div>
        </form>
    </div>

</div>
@endsection