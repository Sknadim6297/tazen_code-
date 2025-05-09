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
        <!-- Page Header Close -->

        <div class="row">
            <div class="col-xxl-12 col-xl-12">
                <div class="card custom-card">
                    <div class="card-header justify-content-between">
                        <div class="card-title">Edit Testimonial</div>
                    </div>
                    <div class="card-body p-4">
                        <form action="{{ route('admin.testimonials.update', $testimonial->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="row gy-3">
                                <!-- Image -->
                                <div class="col-xl-6">
                                    <label for="image" class="form-label">Image</label>
                                    <input type="file" class="form-control" name="image" id="image">
                                    @if($testimonial->image)
                                        <img src="{{ asset('storage/' . $testimonial->image) }}" width="100" class="mt-2">
                                    @endif
                                </div>

                                <!-- Description -->
                                <div class="col-xl-12">
                                    <label for="description" class="form-label">Description</label>
                                    <textarea class="form-control" name="description" id="description" rows="3" placeholder="Enter Description" required>{{ old('description', $testimonial->description) }}</textarea>
                                </div>
                            </div>

                            <div class="modal-footer mt-4">
                                <a href="{{ route('admin.testimonials.index') }}" class="btn btn-light">Cancel</a>
                                <button type="submit" class="btn btn-primary">Update</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
