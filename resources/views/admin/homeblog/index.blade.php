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
                            <button class="btn btn-sm btn-primary btn-wave waves-light" data-bs-toggle="modal" data-bs-target="#create-task"><i class="ri-add-line fw-medium align-middle me-1"></i> Create Blog</button>
                            <!-- Start::add task modal -->
                            <div class="modal fade" id="create-task" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <form action="{{ route('admin.homeblog.store') }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h6 class="modal-title">Add Home Blog</h6>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                    
                                            <div class="modal-body px-4">
                                                <div class="row gy-3">
                                                    {{-- Section Sub Heading --}}
                                                    <div class="col-xl-12">
                                                        <label for="section_sub_heading" class="form-label">Section Sub Heading</label>
                                                        <input type="text" class="form-control" id="section_sub_heading" name="section_sub_heading" placeholder="Enter Section Sub Heading" required>
                                                    </div>
                                    
                                                    @for ($i = 1; $i <= 3; $i++)
                                                    {{-- Image --}}
                                                    <div class="col-xl-4">
                                                        <label for="image{{ $i }}" class="form-label">Image {{ $i }}</label>
                                                        <input type="file" class="form-control" name="image{{ $i }}" id="image{{ $i }}" accept="image/*">
                                                    </div>
                                    
                                                    {{-- Heading --}}
                                                    <div class="col-xl-4">
                                                        <label for="heading{{ $i }}" class="form-label">Heading {{ $i }}</label>
                                                        <input type="text" class="form-control" name="heading{{ $i }}" id="heading{{ $i }}" placeholder="Enter Heading {{ $i }}">
                                                    </div>
                                    
                                                    {{-- Description --}}
                                                    <div class="col-xl-4">
                                                        <label for="description{{ $i }}" class="form-label">Description {{ $i }}</label>
                                                        <textarea class="form-control" name="description{{ $i }}" id="description{{ $i }}" rows="2" placeholder="Enter Description {{ $i }}"></textarea>
                                                    </div>
                                    
                                                    {{-- By Whom --}}
                                                    <div class="col-xl-12">
                                                        <label for="by_whom{{ $i }}" class="form-label">By Whom {{ $i }}</label>
                                                        <input type="text" class="form-control" name="by_whom{{ $i }}" id="by_whom{{ $i }}" placeholder="e.g. By Robert Haven Dec 25, 2019">
                                                    </div>
                                                    @endfor
                                                </div>
                                            </div>
                                    
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                                                <button type="submit" class="btn btn-primary">Add Blog Section</button>
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

<th>Image 1</th>
<th>Heading 1</th>
<th>Description 1</th>
<th>By Whom 1</th>

<th>Image 2</th>
<th>Heading 2</th>
<th>Description 2</th>
<th>By Whom 2</th>

<th>Image 3</th>
<th>Heading 3</th>
<th>Description 3</th>
<th>By Whom 3</th>

<th>Status</th>
<th>Created At</th>
<th>Actions</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($homeblogs as $index => $homeblog)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $homeblog->section_sub_heading }}</td>
                                
                                            <td>
                                                @if($homeblog->image1)
                                                    <img src="{{ asset('storage/' . $homeblog->image1) }}" alt="Image 1" width="80">
                                                @endif
                                            </td>
                                            <td>{{ $homeblog->heading1 }}</td>
                                            <td>{{ $homeblog->description1 }}</td>
                                            <td>{{ $homeblog->by_whom1 }}</td>
                                
                                            <td>
                                                @if($homeblog->image2)
                                                    <img src="{{ asset('storage/' . $homeblog->image2) }}" alt="Image 2" width="80">
                                                @endif
                                            </td>
                                            <td>{{ $homeblog->heading2 }}</td>
                                            <td>{{ $homeblog->description2 }}</td>
                                            <td>{{ $homeblog->by_whom2 }}</td>
                                
                                            <td>
                                                @if($homeblog->image3)
                                                    <img src="{{ asset('storage/' . $homeblog->image3) }}" alt="Image 3" width="80">
                                                @endif
                                            </td>
                                            <td>{{ $homeblog->heading3 }}</td>
                                            <td>{{ $homeblog->description3 }}</td>
                                            <td>{{ $homeblog->by_whom3 }}</td>
                                
                                            <td>
                                                <span class="badge bg-{{ $homeblog->status === 'active' ? 'success' : 'danger' }}">
                                                    {{ ucfirst($homeblog->status) }}
                                                </span>
                                            </td>
                                            <td>{{ $homeblog->created_at->format('d M Y') }}</td>
                                            <td>
                                                <a href="{{ route('admin.homeblog.edit', $homeblog->id) }}" class="btn btn-sm btn-primary">Edit</a>
                                                <form action="{{ route('admin.homeblog.destroy', $homeblog->id) }}" method="POST" style="display:inline-block;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" onclick="return confirm('Are you sure?')" class="btn btn-sm btn-danger">Delete</button>
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