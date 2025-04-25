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
                            <button class="btn btn-sm btn-primary btn-wave waves-light" data-bs-toggle="modal" data-bs-target="#create-task"><i class="ri-add-line fw-medium align-middle me-1"></i> Create Contact Details</button>
                            <!-- Start::add task modal -->
                            <div class="modal fade" id="create-task" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <form action="{{ route('admin.contactdetails.store') }}" method="POST">
                                        @csrf
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h6 class="modal-title">Add Contact Details</h6>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                    
                                            <div class="modal-body px-4">
                                                <div class="row gy-3">
                                                    {{-- Section 1 --}}
                                                    <div class="col-xl-3">
                                                        <label for="icon1" class="form-label">Icon 1</label>
                                                        <input type="text" class="form-control" name="icon1" id="icon1" placeholder="e.g., fas fa-phone" required>
                                                    </div>
                                    
                                                    <div class="col-xl-3">
                                                        <label for="heading1" class="form-label">Heading 1</label>
                                                        <input type="text" class="form-control" name="heading1" id="heading1" placeholder="Enter Heading 1" required>
                                                    </div>
                                    
                                                    <div class="col-xl-3">
                                                        <label for="sub_heading1" class="form-label">Sub Heading 1</label>
                                                        <input type="text" class="form-control" name="sub_heading1" id="sub_heading1" placeholder="Enter Sub Heading 1">
                                                    </div>
                                    
                                                    <div class="col-xl-3">
                                                        <label for="description1" class="form-label">Description 1</label>
                                                        <textarea class="form-control" name="description1" id="description1" rows="2" placeholder="Enter Description 1"></textarea>
                                                    </div>
                                    
                                                    {{-- Section 2 --}}
                                                    <div class="col-xl-3">
                                                        <label for="icon2" class="form-label">Icon 2</label>
                                                        <input type="text" class="form-control" name="icon2" id="icon2" placeholder="e.g., fas fa-envelope" required>
                                                    </div>
                                    
                                                    <div class="col-xl-3">
                                                        <label for="heading2" class="form-label">Heading 2</label>
                                                        <input type="text" class="form-control" name="heading2" id="heading2" placeholder="Enter Heading 2" required>
                                                    </div>
                                    
                                                    <div class="col-xl-3">
                                                        <label for="sub_heading2" class="form-label">Sub Heading 2</label>
                                                        <input type="text" class="form-control" name="sub_heading2" id="sub_heading2" placeholder="Enter Sub Heading 2">
                                                    </div>
                                    
                                                    <div class="col-xl-3">
                                                        <label for="description2" class="form-label">Description 2</label>
                                                        <textarea class="form-control" name="description2" id="description2" rows="2" placeholder="Enter Description 2"></textarea>
                                                    </div>
                                    
                                                    {{-- Section 3 --}}
                                                    <div class="col-xl-3">
                                                        <label for="icon3" class="form-label">Icon 3</label>
                                                        <input type="text" class="form-control" name="icon3" id="icon3" placeholder="e.g., fas fa-map-marker-alt" required>
                                                    </div>
                                    
                                                    <div class="col-xl-3">
                                                        <label for="heading3" class="form-label">Heading 3</label>
                                                        <input type="text" class="form-control" name="heading3" id="heading3" placeholder="Enter Heading 3" required>
                                                    </div>
                                    
                                                    <div class="col-xl-3">
                                                        <label for="sub_heading3" class="form-label">Sub Heading 3</label>
                                                        <input type="text" class="form-control" name="sub_heading3" id="sub_heading3" placeholder="Enter Sub Heading 3">
                                                    </div>
                                    
                                                    <div class="col-xl-3">
                                                        <label for="description3" class="form-label">Description 3</label>
                                                        <textarea class="form-control" name="description3" id="description3" rows="2" placeholder="Enter Description 3"></textarea>
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
                                                <button type="submit" class="btn btn-primary">Add Contact Details</button>
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
                                        <th>Icon 1</th>
                                        <th>Heading 1</th>
                                        <th>Sub Heading 1</th>
                                        <th>Description 1</th>
                                        <th>Icon 2</th>
                                        <th>Heading 2</th>
                                        <th>Sub Heading 2</th>
                                        <th>Description 2</th>
                                        <th>Icon 3</th>
                                        <th>Heading 3</th>
                                        <th>Sub Heading 3</th>
                                        <th>Description 3</th>
                                        <th>Status</th>
                                        <th>Created At</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                
                                <tbody>
                                    @foreach ($contactdetails as $key => $detail)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td><i class="{{ $detail->icon1 }}"></i></td>
                                            <td>{{ $detail->heading1 }}</td>
                                            <td>{{ $detail->sub_heading1 }}</td>
                                            <td>{{ $detail->description1 }}</td>
                                
                                            <td><i class="{{ $detail->icon2 }}"></i></td>
                                            <td>{{ $detail->heading2 }}</td>
                                            <td>{{ $detail->sub_heading2 }}</td>
                                            <td>{{ $detail->description2 }}</td>
                                
                                            <td><i class="{{ $detail->icon3 }}"></i></td>
                                            <td>{{ $detail->heading3 }}</td>
                                            <td>{{ $detail->sub_heading3 }}</td>
                                            <td>{{ $detail->description3 }}</td>
                                
                                            <td>
                                                <span class="badge bg-{{ $detail->status == 'active' ? 'success' : 'secondary' }}">
                                                    {{ ucfirst($detail->status) }}
                                                </span>
                                            </td>
                                            <td>{{ $detail->created_at->format('d M, Y') }}</td>
                                            <td>
                                                <a href="{{ route('admin.contactdetails.edit', $detail->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                                <form action="{{ route('admin.contactdetails.destroy', $detail->id) }}" method="POST" style="display:inline;">
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