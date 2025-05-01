@extends('admin.layouts.layout')

@section('content')
<div class="main-content app-content">
    <div class="container-fluid">
        <h1 class="mb-4">Edit Contact Banner</h1>

        <form action="{{ route('admin.contactbanner.update', $contactbanner->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="row">
                {{-- Banner Heading --}}
                <div class="col-md-6 mb-3">
                    <label for="heading" class="form-label">Banner Heading</label>
                    <input type="text" class="form-control" name="heading" id="heading" value="{{ $contactbanner->heading }}" required>
                </div>

                {{-- Banner Sub Heading --}}
                <div class="col-md-6 mb-3">
                    <label for="sub_heading" class="form-label">Sub Heading</label>
                    <input type="text" class="form-control" name="sub_heading" id="sub_heading" value="{{ $contactbanner->sub_heading }}">
                </div>

                {{-- Current Image --}}
                <div class="col-md-6 mb-3">
                    <label class="form-label">Current Image:</label><br>
                    @if ($contactbanner->banner_image)
                        <img src="{{ asset('uploads/contactbanner/' . $contactbanner->banner_image) }}" width="120">
                    @else
                        N/A
                    @endif
                </div>

                {{-- New Image --}}
                <div class="col-md-6 mb-3">
                    <label for="banner_image" class="form-label">Change Image</label>
                    <input type="file" class="form-control" name="banner_image" id="banner_image">
                </div>

                {{-- Status --}}
                <div class="col-md-6 mb-3">
                    <label for="status" class="form-label">Status</label>
                    <select name="status" id="status" class="form-control">
                        <option value="active" {{ $contactbanner->status == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ $contactbanner->status == 'inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>

            </div>

            <button type="submit" class="btn btn-primary">Update</button>
            <a href="{{ route('admin.contactbanner.index') }}" class="btn btn-secondary">Cancel</a>

        </form>
    </div>
</div>
@endsection
