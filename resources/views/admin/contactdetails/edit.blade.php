@extends('admin.layouts.layout')

@section('content')
<div class="container mt-5">
    <h2>Edit Contact Details</h2>

    <form action="{{ route('admin.contactdetails.update', $contactdetail->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="row">

            {{-- First Set --}}
            <div class="col-md-3">
                <label>Icon 1</label>
                <input type="text" name="icon1" class="form-control" value="{{ old('icon1', $contactdetail->icon1) }}" required>
            </div>
            <div class="col-md-3">
                <label>Heading 1</label>
                <input type="text" name="heading1" class="form-control" value="{{ old('heading1', $contactdetail->heading1) }}" required>
            </div>
            <div class="col-md-3">
                <label>Sub Heading 1</label>
                <input type="text" name="sub_heading1" class="form-control" value="{{ old('sub_heading1', $contactdetail->sub_heading1) }}">
            </div>
            <div class="col-md-3">
                <label>Description 1</label>
                <textarea name="description1" class="form-control">{{ old('description1', $contactdetail->description1) }}</textarea>
            </div>

            {{-- Second Set --}}
            <div class="col-md-3 mt-3">
                <label>Icon 2</label>
                <input type="text" name="icon2" class="form-control" value="{{ old('icon2', $contactdetail->icon2) }}" required>
            </div>
            <div class="col-md-3 mt-3">
                <label>Heading 2</label>
                <input type="text" name="heading2" class="form-control" value="{{ old('heading2', $contactdetail->heading2) }}" required>
            </div>
            <div class="col-md-3 mt-3">
                <label>Sub Heading 2</label>
                <input type="text" name="sub_heading2" class="form-control" value="{{ old('sub_heading2', $contactdetail->sub_heading2) }}">
            </div>
            <div class="col-md-3 mt-3">
                <label>Description 2</label>
                <textarea name="description2" class="form-control">{{ old('description2', $contactdetail->description2) }}</textarea>
            </div>

            {{-- Third Set --}}
            <div class="col-md-3 mt-3">
                <label>Icon 3</label>
                <input type="text" name="icon3" class="form-control" value="{{ old('icon3', $contactdetail->icon3) }}" required>
            </div>
            <div class="col-md-3 mt-3">
                <label>Heading 3</label>
                <input type="text" name="heading3" class="form-control" value="{{ old('heading3', $contactdetail->heading3) }}" required>
            </div>
            <div class="col-md-3 mt-3">
                <label>Sub Heading 3</label>
                <input type="text" name="sub_heading3" class="form-control" value="{{ old('sub_heading3', $contactdetail->sub_heading3) }}">
            </div>
            <div class="col-md-3 mt-3">
                <label>Description 3</label>
                <textarea name="description3" class="form-control">{{ old('description3', $contactdetail->description3) }}</textarea>
            </div>


            {{-- Status --}}
            <div class="col-md-12 mt-4">
                <label>Status</label>
                <select name="status" class="form-control" required>
                    <option value="active" {{ $contactdetail->status == 'active' ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ $contactdetail->status == 'inactive' ? 'selected' : '' }}>Inactive</option>
                </select>
            </div>

            {{-- Submit Buttons --}}
            <div class="col-md-12 mt-4">
                <button type="submit" class="btn btn-primary">Update</button>
                <a href="{{ route('admin.contactdetails.index') }}" class="btn btn-secondary">Back</a>
            </div>

        </div>
    </form>
</div>
@endsection
