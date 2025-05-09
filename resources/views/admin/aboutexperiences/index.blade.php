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
                            <button class="btn btn-sm btn-primary btn-wave waves-light" data-bs-toggle="modal" data-bs-target="#create-task"><i class="ri-add-line fw-medium align-middle me-1"></i> Add Experiences</button>
                            <!-- Start::add task modal -->
                            <div class="modal fade" id="create-task" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <form action="{{ route('admin.aboutexperiences.store') }}" method="POST">
                                        @csrf
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h6 class="modal-title">Add About Experience</h6>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                    
                                            <div class="modal-body px-4">
                                                <div class="row gy-3">
                                                    <div class="col-md-6">
                                                        <label for="section_heading" class="form-label">Section Heading</label>
                                                        <input type="text" class="form-control" name="section_heading" id="section_heading" required>
                                                    </div>
                                    
                                                    <div class="col-md-6">
                                                        <label for="section_subheading" class="form-label">Section Sub Heading</label>
                                                        <input type="text" class="form-control" name="section_subheading" id="section_subheading">
                                                    </div>
                                    
                                                    <div class="col-md-6">
                                                        <label for="content_heading" class="form-label">Content Heading</label>
                                                        <input type="text" class="form-control" name="content_heading" id="content_heading">
                                                    </div>
                                    
                                                    <div class="col-md-6">
                                                        <label for="content_subheading" class="form-label">Content Sub Heading</label>
                                                        <input type="text" class="form-control" name="content_subheading" id="content_subheading">
                                                    </div>
                                    
                                                    @for ($i = 1; $i <= 3; $i++)
                                                        <div class="col-md-4">
                                                            <label for="experience_heading{{ $i }}" class="form-label">Experience Heading {{ $i }}</label>
                                                            <input type="text" class="form-control" name="experience_heading{{ $i }}" id="experience_heading{{ $i }}">
                                                        </div>
                                    
                                                        <div class="col-md-4">
                                                            <label for="experience_percentage{{ $i }}" class="form-label">Experience Percentage {{ $i }}</label>
                                                            <input type="number" class="form-control" name="experience_percentage{{ $i }}" id="experience_percentage{{ $i }}" max="100" min="0">
                                                        </div>
                                    
                                                        <div class="col-md-4">
                                                            <label for="description{{ $i }}" class="form-label">Description {{ $i }}</label>
                                                            <textarea class="form-control" name="description{{ $i }}" id="description{{ $i }}" rows="2"></textarea>
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
                                        <th>Section Heading</th>
                                        <th>Section Sub Heading</th>
                                        <th>Content Heading</th>
                                        <th>Content Sub Heading</th>
                                
                                        <th>Experience Heading 1</th>
                                        <th>Experience Percentage 1</th>
                                        <th>Description 1</th>
                                
                                        <th>Experience Heading 2</th>
                                        <th>Experience Percentage 2</th>
                                        <th>Description 2</th>
                                
                                        <th>Experience Heading 3</th>
                                        <th>Experience Percentage 3</th>
                                        <th>Description 3</th>
                                
                                        <th>Created At</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                
                                
                                <tbody>
                                    @foreach ($aboutexperiences as $key => $exp)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $exp->section_heading }}</td>
                                            <td>{{ $exp->section_subheading }}</td>
                                            <td>{{ $exp->content_heading }}</td>
                                            <td>{{ $exp->content_subheading }}</td>
                                
                                            <td>{{ $exp->experience_heading1 }}</td>
                                            <td>{{ $exp->experience_percentage1 }}%</td>
                                            <td>{{ $exp->description1 }}</td>
                                
                                            <td>{{ $exp->experience_heading2 }}</td>
                                            <td>{{ $exp->experience_percentage2 }}%</td>
                                            <td>{{ $exp->description2 }}</td>
                                
                                            <td>{{ $exp->experience_heading3 }}</td>
                                            <td>{{ $exp->experience_percentage3 }}%</td>
                                            <td>{{ $exp->description3 }}</td>
                                
                                            <td>{{ $exp->created_at->format('d M Y') }}</td>
                                
                                            <td>
                                                <a href="{{ route('admin.aboutexperiences.edit', $exp->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                                <form action="{{ route('admin.aboutexperiences.destroy', $exp->id) }}" method="POST" style="display:inline-block;">
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