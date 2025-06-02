@extends('admin.layouts.layout')

@section('content')
<div class="main-content app-content">
    <div class="container-fluid">
        <!-- Page Header -->
        <div class="my-4 page-header-breadcrumb d-flex align-items-center justify-content-between flex-wrap gap-2">
            <div>
                <h1 class="page-title fw-medium fs-18 mb-2">Edit How It Works Section</h1>
                <nav>
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="javascript:void(0);">Apps</a></li>
                        <li class="breadcrumb-item"><a href="javascript:void(0);">How It Works</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Edit Section</li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="row">
            <div class="col-xxl-12 col-xl-12">
                <div class="card custom-card">
                    <div class="card-header justify-content-between">
                        <div class="card-title">
                            Edit How It Works Content
                        </div>
                        <div class="d-flex">
                            <a href="{{ route('admin.howworks.index') }}" class="btn btn-sm btn-primary">
                                <i class="bi bi-arrow-left me-1"></i>Back to List
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.howworks.update', $howwork->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="row mb-4">
                                <div class="col-md-12">
                                    <label for="section_sub_heading" class="form-label">Section Sub Heading</label>
                                    <input type="text" name="section_sub_heading" class="form-control" 
                                           value="{{ old('section_sub_heading', $howwork->section_sub_heading) }}" required>
                                    @error('section_sub_heading')
                                        <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Step 1 -->
                            <div class="row mb-4 border-bottom pb-3">
                                <h5 class="mb-3 text-primary">Step 1</h5>
                                
                                <div class="col-md-4 mb-3">
                                    <label for="image1" class="form-label">Image</label>
                                    <input type="file" name="image1" class="form-control" accept="image/*">
                                    @if ($howwork->image1)
                                        <div class="mt-2">
                                            <img src="{{ asset('storage/' . $howwork->image1) }}" 
                                                 alt="Image 1" class="img-thumbnail" width="150">
                                            <div class="form-check mt-2">
                                                <input class="form-check-input" type="checkbox" name="remove_image1" id="remove_image1">
                                                
                                            </div>
                                        </div>
                                    @endif
                                    @error('image1')
                                        <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="col-md-8">
                                    <div class="mb-3">
                                        <label for="heading1" class="form-label">Heading</label>
                                        <input type="text" name="heading1" class="form-control" 
                                               value="{{ old('heading1', $howwork->heading1) }}">
                                        @error('heading1')
                                            <div class="text-danger small">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="description1" class="form-label">Description</label>
                                        <textarea name="description1" class="form-control" rows="3">{{ old('description1', $howwork->description1) }}</textarea>
                                        @error('description1')
                                            <div class="text-danger small">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Step 2 -->
                            <div class="row mb-4 border-bottom pb-3">
                                <h5 class="mb-3 text-primary">Step 2</h5>
                                
                                <div class="col-md-4 mb-3">
                                    <label for="image2" class="form-label">Image</label>
                                    <input type="file" name="image2" class="form-control" accept="image/*">
                                    @if ($howwork->image2)
                                        <div class="mt-2">
                                            <img src="{{ asset('storage/' . $howwork->image2) }}" 
                                                 alt="Image 2" class="img-thumbnail" width="150">
                                            <div class="form-check mt-2">
                                                <input class="form-check-input" type="checkbox" name="remove_image2" id="remove_image2">
                                                
                                            </div>
                                        </div>
                                    @endif
                                    @error('image2')
                                        <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="col-md-8">
                                    <div class="mb-3">
                                        <label for="heading2" class="form-label">Heading</label>
                                        <input type="text" name="heading2" class="form-control" 
                                               value="{{ old('heading2', $howwork->heading2) }}">
                                        @error('heading2')
                                            <div class="text-danger small">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="description2" class="form-label">Description</label>
                                        <textarea name="description2" class="form-control" rows="3">{{ old('description2', $howwork->description2) }}</textarea>
                                        @error('description2')
                                            <div class="text-danger small">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Step 3 -->
                            <div class="row mb-4">
                                <h5 class="mb-3 text-primary">Step 3</h5>
                                
                                <div class="col-md-4 mb-3">
                                    <label for="image3" class="form-label">Image</label>
                                    <input type="file" name="image3" class="form-control" accept="image/*">
                                    @if ($howwork->image3)
                                        <div class="mt-2">
                                            <img src="{{ asset('storage/' . $howwork->image3) }}" 
                                                 alt="Image 3" class="img-thumbnail" width="150">
                                            <div class="form-check mt-2">
                                                <input class="form-check-input" type="checkbox" name="remove_image3" id="remove_image3">
                                                
                                            </div>
                                        </div>
                                    @endif
                                    @error('image3')
                                        <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="col-md-8">
                                    <div class="mb-3">
                                        <label for="heading3" class="form-label">Heading</label>
                                        <input type="text" name="heading3" class="form-control" 
                                               value="{{ old('heading3', $howwork->heading3) }}">
                                        @error('heading3')
                                            <div class="text-danger small">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="description3" class="form-label">Description</label>
                                        <textarea name="description3" class="form-control" rows="3">{{ old('description3', $howwork->description3) }}</textarea>
                                        @error('description3')
                                            <div class="text-danger small">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12 text-end">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="bi bi-check-circle-fill me-1"></i>Update
                                    </button>
                                    <a href="{{ route('admin.howworks.index') }}" class="btn btn-light ms-2">
                                        <i class="bi bi-x-circle-fill me-1"></i>Cancel
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection