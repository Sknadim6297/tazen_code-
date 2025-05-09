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
                            <button class="btn btn-sm btn-primary btn-wave waves-light" data-bs-toggle="modal" data-bs-target="#create-task"><i class="ri-add-line fw-medium align-middle me-1"></i> Create About Us</button>
                            <!-- Start::add task modal -->
                            <div class="modal fade" id="create-task" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <form action="{{ route('admin.aboutus.store') }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h6 class="modal-title">Add About Us Info</h6>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                    
                                            <div class="modal-body px-4">
                                                <div class="row gy-3">
                                                    {{-- Heading --}}
                                                    <div class="col-xl-6">
                                                        <label for="heading" class="form-label">Heading</label>
                                                        <input type="text" class="form-control" id="heading" name="heading" placeholder="Enter Heading" required>
                                                    </div>
                                    
                                                    {{-- Year of Experience --}}
                                                    <div class="col-xl-6">
                                                        <label for="year_of_experience" class="form-label">Year of Experience</label>
                                                        <input type="number" class="form-control" id="year_of_experience" name="year_of_experience" placeholder="Enter Years of Experience" required>
                                                    </div>
                                    
                                                    {{-- Description --}}
                                                    <div class="col-xl-12">
                                                        <label for="description" class="form-label">Description</label>
                                                        <textarea class="form-control" id="description" name="description" rows="3" placeholder="Enter Description" required></textarea>
                                                    </div>
                                    
                                                    {{-- Line 1 --}}
                                                    <div class="col-xl-6">
                                                        <label for="line1" class="form-label">Line 1</label>
                                                        <input type="text" class="form-control" id="line1" name="line1" placeholder="Enter Line 1">
                                                    </div>
                                    
                                                    {{-- Line 2 --}}
                                                    <div class="col-xl-6">
                                                        <label for="line2" class="form-label">Line 2</label>
                                                        <input type="text" class="form-control" id="line2" name="line2" placeholder="Enter Line 2">
                                                    </div>
                                    
                                                    {{-- Image --}}
                                                    <div class="col-xl-12">
                                                        <label for="image" class="form-label">Upload Image</label>
                                                        <input type="file" class="form-control" name="image" id="image" accept="image/*">
                                                    </div>
                                                </div>
                                            </div>
                                    
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                                                <button type="submit" class="btn btn-primary">Add</button>
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
                                        <th>Description</th>
                                        <th>Line 1</th>
                                        <th>Line 2</th>
                                        <th>Year of Experience</th>
                                        <th>Image</th>
                                        <th>Created At</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                
                                <tbody>
                                    @foreach ($aboutuses as $key => $about)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $about->heading }}</td>
                                            <td>{{ $about->description }}</td>
                                            <td>{{ $about->line1 }}</td>
                                            <td>{{ $about->line2 }}</td>
                                            <td>{{ $about->year_of_experience }} years</td>
                                            <td>
                                                @if ($about->image)
                                                    <img src="{{ asset('uploads/aboutus/' . $about->image) }}" alt="About Image" style="height: 60px;">
                                                @else
                                                    N/A
                                                @endif
                                            </td>
                                            <td>{{ $about->created_at->format('d M Y') }}</td>
                                            <td>
                                                <a href="{{ route('admin.aboutus.edit', $about->id) }}" class="btn btn-sm btn-primary">Edit</a>
                                                <form action="{{ route('admin.aboutus.destroy', $about->id) }}" method="POST" style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
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