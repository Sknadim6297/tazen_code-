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
                            <button class="btn btn-sm btn-primary btn-wave waves-light" data-bs-toggle="modal" data-bs-target="#create-task"><i class="ri-add-line fw-medium align-middle me-1"></i>Add How we works</button>
                            <!-- Start::add task modal -->
                            <div class="modal fade" id="create-task" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <form action="{{ route('admin.abouthowweworks.store') }}" method="POST">
                                        @csrf
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h6 class="modal-title">Add How We Work</h6>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                    
                                            <div class="modal-body px-4">
                                                <div class="row gy-3">
                                                    <div class="col-md-6">
                                                        <label for="section_heading" class="form-label">Section Heading</label>
                                                        <input type="text" class="form-control" name="section_heading" id="section_heading" required>
                                                    </div>
                                    
                                                    <div class="col-md-6">
                                                        <label for="section_sub_heading" class="form-label">Section Sub Heading</label>
                                                        <input type="text" class="form-control" name="section_sub_heading" id="section_sub_heading">
                                                    </div>
                                    
                                                    <div class="col-md-6">
                                                        <label for="content_heading" class="form-label">Content Heading</label>
                                                        <input type="text" class="form-control" name="content_heading" id="content_heading">
                                                    </div>
                                    
                                                    <div class="col-md-6">
                                                        <label for="content_sub_heading" class="form-label">Content Sub Heading</label>
                                                        <input type="text" class="form-control" name="content_sub_heading" id="content_sub_heading">
                                                    </div>
                                    
                                                    @for ($i = 1; $i <= 4; $i++)
                                                        <div class="col-md-6">
                                                            <label for="step{{ $i }}_heading" class="form-label">Step {{ $i }} Heading</label>
                                                            <input type="text" class="form-control" name="step{{ $i }}_heading" id="step{{ $i }}_heading">
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label for="step{{ $i }}_description" class="form-label">Step {{ $i }} Description</label>
                                                            <textarea class="form-control" name="step{{ $i }}_description" id="step{{ $i }}_description" rows="2"></textarea>
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
                                <thead class="table-dark">
                                    <tr>
                                        <th>#</th>
                                        <th>Section Heading</th>
                                        <th>Section Sub Heading</th>
                                        <th>Content Heading</th>
                                        <th>Content Sub Heading</th>
                                        <th>Step 1 Heading</th>
                                        <th>Step 1 Description</th>
                                        <th>Step 2 Heading</th>
                                        <th>Step 2 Description</th>
                                        <th>Step 3 Heading</th>
                                        <th>Step 3 Description</th>
                                        <th>Step 4 Heading</th>
                                        <th>Step 4 Description</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($abouthowweworks as $key => $item)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $item->section_heading }}</td>
                                            <td>{{ $item->section_sub_heading }}</td>
                                            <td>{{ $item->content_heading }}</td>
                                            <td>{{ $item->content_sub_heading }}</td>
                                            <td>{{ $item->step1_heading }}</td>
                                            <td>{{ $item->step1_description }}</td>
                                            <td>{{ $item->step2_heading }}</td>
                                            <td>{{ $item->step2_description }}</td>
                                            <td>{{ $item->step3_heading }}</td>
                                            <td>{{ $item->step3_description }}</td>
                                            <td>{{ $item->step4_heading }}</td>
                                            <td>{{ $item->step4_description }}</td>
                                            <td>
                                                <a href="{{ route('admin.abouthowweworks.edit', $item->id) }}" class="btn btn-warning">Edit</a>
                                                <form action="{{ route('admin.abouthowweworks.destroy', $item->id) }}" method="POST" style="display:inline-block;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger">Delete</button>
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