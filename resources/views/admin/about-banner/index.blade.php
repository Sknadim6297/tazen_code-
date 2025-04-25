@extends('admin.layouts.layout')
@section('content')
<div class="main-content app-content">
    <div class="container-fluid">

            
        <!-- Page Header -->
        <div class="my-4 page-header-breadcrumb d-flex align-items-center justify-content-between flex-wrap gap-2">
            <div>
                <h1 class="page-title fw-medium fs-18 mb-2">Task List View</h1>
                <div class="">
                    <nav>
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="javascript:void(0);">Apps</a></li>
                            <li class="breadcrumb-item"><a href="javascript:void(0);">Task</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Task List View</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <!-- Page Header Close -->



        <!-- Start::row-2 -->
        <div class="row">
            <div class="col-xxl-12 col-xl-12">
                <div class="card custom-card">
                    <div class="card-header justify-content-between">
                        <div class="card-title">
                            Total Tasks
                        </div>
                        <div class="d-flex">
                            <button class="btn btn-sm btn-primary btn-wave waves-light" data-bs-toggle="modal" data-bs-target="#create-task"><i class="ri-add-line fw-medium align-middle me-1"></i> Create About Banner</button>
                            <!-- Start::add task modal -->
                            <div class="modal fade" id="create-task" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <form action="{{ route('admin.about-banner.store') }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h6 class="modal-title">Add About Banner</h6>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body px-4">
                                                <div class="row gy-3">
                                                    {{-- Banner Heading --}}
                                                    <div class="col-xl-6">
                                                        <label for="heading" class="form-label">Banner Heading</label>
                                                        <input type="text" class="form-control" id="heading" name="heading" placeholder="Enter Banner Heading" required>
                                                    </div>
                                    
                                                    {{-- Banner Sub Heading --}}
                                                    <div class="col-xl-6">
                                                        <label for="sub_heading" class="form-label">Sub Heading</label>
                                                        <input type="text" class="form-control" id="sub_heading" name="sub_heading" placeholder="Enter Sub Heading">
                                                    </div>
                                    
                                                    {{-- Banner Image --}}
                                                    <div class="col-xl-12">
                                                        <label for="banner_image" class="form-label">Banner Image</label>
                                                        <input type="file" class="form-control" name="banner_image" id="banner_image" accept="image/*">
                                                    </div>
                                    
                                                    {{-- Status --}}
                                                    <div class="col-xl-12">
                                                        <label for="status" class="form-label">Status</label>
                                                        <select class="form-control" name="status" id="status" required>
                                                            <option value="active">Active</option>
                                                            <option value="inactive">Inactive</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                    
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                                                <button type="submit" class="btn btn-primary">Add Banner</button>
                                            </div>
                                        </div>
                                    </form>                                    
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table text-nowrap">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Heading</th>
                                        <th>Sub Heading</th>
                                        <th>Image</th>
                                        <th>Status</th>
                                        <th>Created At</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($banners as $index => $banner)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $banner->heading }}</td>
                                            <td>{{ $banner->sub_heading }}</td>
                                            <td>
                                                @if($banner->banner_image)
                                                    <img src="{{ asset('storage/' . $banner->banner_image) }}" alt="Banner Image" style="max-width: 100px; height: auto;">
                                                @else
                                                    <span>No Image</span>
                                                @endif
                                            </td>
                                            <td>
                                                <span class="badge bg-{{ $banner->status == 'active' ? 'success' : 'secondary' }}">
                                                    {{ ucfirst($banner->status) }}
                                                </span>
                                            </td>
                                            <td>{{ $banner->created_at->format('d M Y') }}</td>
                                            <td>
                                                <a href="{{ route('admin.about-banner.edit', $banner->id) }}" class="btn btn-primary-light btn-icon btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Edit">
                                                    <i class="ri-edit-line"></i>
                                                </a>
                                                <form action="{{ route('admin.about-banner.destroy', $banner->id) }}" method="POST" style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger-light btn-icon ms-1 btn-sm task-delete-btn" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Delete">
                                                        <i class="ri-delete-bin-5-line"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                
                            </table>
                        </div>
                    </div>
                    <div class="card-footer border-top-0">
                        <nav aria-label="Page navigation">
                            <ul class="pagination mb-0 float-end">
                                <li class="page-item disabled">
                                    <a class="page-link">Previous</a>
                                </li>
                                <li class="page-item"><a class="page-link" href="javascript:void(0);">1</a></li>
                                <li class="page-item active" aria-current="page">
                                    <a class="page-link" href="javascript:void(0);">2</a>
                                </li>
                                <li class="page-item"><a class="page-link" href="javascript:void(0);">3</a></li>
                                <li class="page-item">
                                    <a class="page-link" href="javascript:void(0);">Next</a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
        <!--End::row-2 -->


    </div>
</div>
@endsection