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
                        <form action="{{ route('admin.admin.testimonial.update', $testimonial->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="row gy-3">
                                <!-- Section Sub Heading -->
                                <div class="col-xl-12">
                                    <label for="section_sub_heading" class="form-label">Section Sub Heading</label>
                                    <input type="text" class="form-control" name="section_sub_heading" id="section_sub_heading" value="{{ old('section_sub_heading', $testimonial->section_sub_heading) }}" placeholder="Enter Sub Heading">
                                </div>

                                <!-- Testimonial Fields -->
                                @for ($i = 1; $i <= 4; $i++)
                                    <div class="col-xl-12 mt-4">
                                        <h6>Testimonial {{ $i }}</h6>
                                    </div>

                                    <div class="col-xl-6">
                                        <label for="image{{ $i }}" class="form-label">Image {{ $i }}</label>
                                        <input type="file" class="form-control" name="image{{ $i }}" id="image{{ $i }}">
                                        @if($testimonial->{'image'.$i})
                                            <img src="{{ asset('storage/' . $testimonial->{'image' . $i}) }}" width="100" class="mt-2">
                                        @endif
                                    </div>

                                    <div class="col-xl-12">
                                        <label for="description{{ $i }}" class="form-label">Description {{ $i }}</label>
                                        <textarea class="form-control" name="description{{ $i }}" id="description{{ $i }}" rows="3" placeholder="Enter Description">{{ old('description' . $i, $testimonial->{'description' . $i}) }}</textarea>
                                    </div>
                                @endfor
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
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
