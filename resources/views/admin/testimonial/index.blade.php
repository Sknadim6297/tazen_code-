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
                            <button class="btn btn-sm btn-primary btn-wave waves-light" data-bs-toggle="modal" data-bs-target="#create-task"><i class="ri-add-line fw-medium align-middle me-1"></i> Create Testimonials</button>
                            <!-- Start::add task modal -->
                            <div class="modal fade" id="create-task" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <form action="{{ route('admin.admin.testimonial.store') }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h6 class="modal-title">Add Testimonial Section</h6>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                    
                                            <div class="modal-body px-4">
                                                <div class="row gy-3">
                                                    {{-- Section Sub Heading --}}
                                                    <div class="col-xl-12">
                                                        <label for="section_sub_heading" class="form-label">Section Sub Heading</label>
                                                        <input type="text" class="form-control" name="section_sub_heading" id="section_sub_heading" placeholder="Enter Sub Heading">
                                                    </div>
                                    
                                                    {{-- Image and Description Cards --}}
                                                    @for ($i = 1; $i <= 4; $i++)
                                                        <div class="col-xl-12 mt-4">
                                                            <h6>Testimonial {{ $i }}</h6>
                                                        </div>
                                    
                                                        <div class="col-xl-6">
                                                            <label for="image{{ $i }}" class="form-label">Image {{ $i }}</label>
                                                            <input type="file" class="form-control" name="image{{ $i }}" id="image{{ $i }}">
                                                        </div>
                                    
                                                        <div class="col-xl-12">
                                                            <label for="description{{ $i }}" class="form-label">Description {{ $i }}</label>
                                                            <textarea class="form-control" name="description{{ $i }}" id="description{{ $i }}" rows="3" placeholder="Enter Description"></textarea>
                                                        </div>
                                                    @endfor
                                                </div>
                                            </div>
                                    
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                                                <button type="submit" class="btn btn-primary">Save</button>
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
                                        <th>Section Sub Heading</th>
                                        @for ($i = 1; $i <= 4; $i++)
                                        <th>Image {{ $i }}</th>
                                        <th>Description {{ $i }}</th>
                                        @endfor
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($testimonial)
                                    <tr>
                                        <td>1</td>
                                        <td>{{ $testimonial->section_sub_heading }}</td>
                            
                                        @for ($i = 1; $i <= 4; $i++)
                                            <td>
                                                @if ($testimonial->{'image'.$i})
                                                <img src="{{ asset('storage/' . $testimonial->{'image' . $i}) }}" width="100">
                                                @else
                                                    N/A
                                                @endif
                                            </td>
                                            <td>{{ $testimonial->{'description'.$i} }}</td>
                                        @endfor
                            
                                        <td>
                                            <a href="{{ route('admin.admin.testimonial.edit', $testimonial->id) }}" class="btn btn-sm btn-info">Edit</a>
                            
                                            <form action="{{ route('admin.admin.testimonial.destroy', $testimonial->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @else
                                    <tr>
                                        <td colspan="11" class="text-center">No data available</td>
                                    </tr>
                                @endif
                            
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