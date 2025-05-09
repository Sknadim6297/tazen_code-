@extends('admin.layouts.layout')
@section('content')
<div class="main-content app-content">
<div class="container">
    <h4>Edit How We Work</h4>
    <form action="{{ route('admin.abouthowweworks.update', $howwework->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="row gy-3">
            <div class="col-md-6">
                <label>Section Heading</label>
                <input type="text" class="form-control" name="section_heading" value="{{ old('section_heading', $howwework->section_heading) }}" required>
            </div>

            <div class="col-md-6">
                <label>Section Sub Heading</label>
                <input type="text" class="form-control" name="section_sub_heading" value="{{ old('section_sub_heading', $howwework->section_sub_heading) }}">
            </div>

            <div class="col-md-6">
                <label>Content Heading</label>
                <input type="text" class="form-control" name="content_heading" value="{{ old('content_heading', $howwework->content_heading) }}">
            </div>

            <div class="col-md-6">
                <label>Content Sub Heading</label>
                <input type="text" class="form-control" name="content_sub_heading" value="{{ old('content_sub_heading', $howwework->content_sub_heading) }}">
            </div>

            @for ($i = 1; $i <= 4; $i++)
                <div class="col-md-6">
                    <label>Step {{ $i }} Heading</label>
                    <input type="text" class="form-control" name="step{{ $i }}_heading" value="{{ old("step{$i}_heading", $howwework->{'step' . $i . '_heading'}) }}">
                </div>
                <div class="col-md-6">
                    <label>Step {{ $i }} Description</label>
                    <textarea class="form-control" name="step{{ $i }}_description" rows="2">{{ old("step{$i}_description", $howwework->{'step' . $i . '_description'}) }}</textarea>
                </div>
            @endfor
        </div>

        <button type="submit" class="btn btn-success mt-3">Update</button>
    </form>
</div>
</div>
@endsection