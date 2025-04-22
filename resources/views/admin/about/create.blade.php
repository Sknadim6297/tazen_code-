@extends('admin.layout.layout')

@section('styles')

@endsection

@section('content')
<h2>About Page Details</h2>
<form action="{{ route('about.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <div class="mb-3">
        <label for="heading" class="form-label">Heading</label>
        <input type="text" name="heading" id="heading">
    </div>

    <div class="mb-3">
        <label for="description" class="form-label">Description</label>
        <textarea name="description" id="description" rows="4"></textarea>
    </div>

    <div class="mb-3">
        <label for="line_1" class="form-label">Line 1</label>
        <input type="text" name="line_1" id="line_1">
    </div>

    <div class="mb-3">
        <label for="line_2" class="form-label">Line 2</label>
        <input type="text" name="line_2" id="line_2">
    </div>

    <div class="mb-3">
        <label for="image" class="form-label">Image</label>
        <input type="file" name="image" id="image">
    </div>

    <div class="mb-3">
        <label for="year_of_experience" class="form-label">Year of Experience</label>
        <input type="number" name="year_of_experience" id="year_of_experience" min="0">
    </div>

    <div class="mb-3">
        <label for="banner_image" class="form-label">Banner Image</label>
        <input type="file" name="banner_image" id="banner_image">
    </div>

    <div class="mb-3">
        <label for="status" class="form-label">Status</label>
        <select name="status" id="status">
            <option value="active" selected>Active</option>
            <option value="inactive">Inactive</option>
        </select>
    </div>

    <button type="submit" class="btn">Save About Info</button>
</form>
@endsection
