@extends('admin.layouts.layout')
@section('content')
<div class="main-content app-content">
    <div class="container">
        <form action="{{ route('admin.aboutexperiences.update', $aboutexperience->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="row gy-3">
                <div class="col-md-6">
                    <label>Section Heading</label>
                    <input type="text" name="section_heading" class="form-control" value="{{ $aboutexperience->section_heading }}" required>
                </div>
    
                <div class="col-md-6">
                    <label>Section Sub Heading</label>
                    <input type="text" name="section_subheading" class="form-control" value="{{ $aboutexperience->section_subheading }}">
                </div>
    
                <div class="col-md-6">
                    <label>Content Heading</label>
                    <input type="text" name="content_heading" class="form-control" value="{{ $aboutexperience->content_heading }}">
                </div>
    
                <div class="col-md-6">
                    <label>Content Sub Heading</label>
                    <input type="text" name="content_subheading" class="form-control" value="{{ $aboutexperience->content_subheading }}">
                </div>
    
                @for ($i = 1; $i <= 3; $i++)
                    <div class="col-md-4">
                        <label>Experience Heading {{ $i }}</label>
                        <input type="text" class="form-control" name="experience_heading{{ $i }}" value="{{ $aboutexperience->{'experience_heading'.$i} }}">
                    </div>
    
                    <div class="col-md-4">
                        <label>Experience Percentage {{ $i }}</label>
                        <input type="number" class="form-control" name="experience_percentage{{ $i }}" value="{{ $aboutexperience->{'experience_percentage'.$i} }}" max="100" min="0">
                    </div>
    
                    <div class="col-md-4">
                        <label>Description {{ $i }}</label>
                        <textarea class="form-control" name="description{{ $i }}" rows="2">{{ $aboutexperience->{'description'.$i} }}</textarea>
                    </div>
                @endfor
            </div>
    
            <div class="mt-4">
                <button class="btn btn-secondary" type="submit">Update</button>
            </div>
        </form>
    </div>

</div>
@endsection