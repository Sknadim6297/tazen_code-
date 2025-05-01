@extends('admin.layouts.layout')

@section('content')
<div class="main-content app-content">
    <div class="container-fluid">
        <!-- Page Header -->
        <div class="my-4 page-header-breadcrumb d-flex align-items-center justify-content-between flex-wrap gap-2">
            <div>
                <h1 class="page-title fw-medium fs-18 mb-2">Edit Testimonial</h1>
                <nav>
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="javascript:void(0);">Apps</a></li>
                        <li class="breadcrumb-item"><a href="javascript:void(0);">Testimonial</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Edit Testimonial</li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="row">
        <div class="col-xxl-12 col-xl-12">
            <div class="card custom-card">
                <div class="card-header">
                    <div class="card-title">
                        Edit How It Works Section
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.howworks.update', $howwork->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label for="section_sub_heading">Section Sub Heading</label>
                            <input type="text" name="section_sub_heading" class="form-control" value="{{ old('section_sub_heading', $howwork->section_sub_heading) }}" required>
                        </div>

                        <!-- Image 1 -->
                        <div class="form-group">
                            <label for="image1">Image 1</label>
                            <input type="file" name="image1" class="form-control">
                            @if ($howwork->image1)
                                <img src="{{ asset('storage/howworks/' . $howwork->image1) }}" alt="Image 1" width="100">
                            @endif
                        </div>

                        <!-- Heading 1 -->
                        <div class="form-group">
                            <label for="heading1">Heading 1</label>
                            <input type="text" name="heading1" class="form-control" value="{{ old('heading1', $howwork->heading1) }}">
                        </div>

                        <!-- Description 1 -->
                        <div class="form-group">
                            <label for="description1">Description 1</label>
                            <textarea name="description1" class="form-control">{{ old('description1', $howwork->description1) }}</textarea>
                        </div>

                        <!-- Image 2 -->
                        <div class="form-group">
                            <label for="image2">Image 2</label>
                            <input type="file" name="image2" class="form-control">
                            @if ($howwork->image2)
                                <img src="{{ asset('storage/howworks/' . $howwork->image2) }}" alt="Image 2" width="100">
                            @endif
                        </div>

                        <!-- Heading 2 -->
                        <div class="form-group">
                            <label for="heading2">Heading 2</label>
                            <input type="text" name="heading2" class="form-control" value="{{ old('heading2', $howwork->heading2) }}">
                        </div>

                        <!-- Description 2 -->
                        <div class="form-group">
                            <label for="description2">Description 2</label>
                            <textarea name="description2" class="form-control">{{ old('description2', $howwork->description2) }}</textarea>
                        </div>

                        <!-- Image 3 -->
                        <div class="form-group">
                            <label for="image3">Image 3</label>
                            <input type="file" name="image3" class="form-control">
                            @if ($howwork->image3)
                                <img src="{{ asset('storage/howworks/' . $howwork->image3) }}" alt="Image 3" width="100">
                            @endif
                        </div>

                        <!-- Heading 3 -->
                        <div class="form-group">
                            <label for="heading3">Heading 3</label>
                            <input type="text" name="heading3" class="form-control" value="{{ old('heading3', $howwork->heading3) }}">
                        </div>

                        <!-- Description 3 -->
                        <div class="form-group">
                            <label for="description3">Description 3</label>
                            <textarea name="description3" class="form-control">{{ old('description3', $howwork->description3) }}</textarea>
                        </div>

                        <button type="submit" class="btn btn-primary">Update</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
