@extends('admin.layouts.layout')
@section('content')
<div class="main-content app-content">
    <div class="container-fluid">

        <!-- Page Header -->
        <div class="my-4 page-header-breadcrumb d-flex align-items-center  flex-wrap gap-2" >
            <div>
                <h1 class="page-title fw-medium fs-18 mb-2">Services List View</h1>
                <div class="">
                    <nav>
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="javascript:void(0);">Service</a></li>
                            <li class="breadcrumb-item"><a href="javascript:void(0);"></a></li>
                            {{-- <li class="breadcrumb-item active" aria-current="page">Task List View</li> --}}
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
                                    <form action="{{ route('admin.blogs.store') }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h6 class="modal-title">Add Blog</h6>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body px-4">
                                                <div class="row gy-2">
                                                    <!-- Blog Title -->
                                                    <div class="col-xl-12">
                                                        <label for="blog-title" class="form-label">Blog Title</label>
                                                        <input type="text" class="form-control" name="title" id="blog-title" placeholder="Enter blog title" required>
                                                    </div>
                                    
                                                    <!-- Short Description (to display on homepage) -->
                                                   <!-- Short Description -->
                                                    <div class="col-xl-12">
                                                        <label for="short_description" class="form-label">Short Description</label>
                                                        <textarea class="form-control" name="short_description" id="short_description" placeholder="Enter Short Description" required></textarea>
                                                        <small id="short_description_count" class="text-muted">0/15 words</small>
                                                        <div id="short_description_error" class="text-danger" style="display:none;">Maximum 15 words allowed.</div>
                                                    </div>

                                    
                                                    <!-- Blog Image -->
                                                    <div class="col-xl-12">
                                                        <label for="blog-image" class="form-label">Blog Image</label>
                                                        <input type="file" class="form-control" name="image" id="blog-image" accept="image/*">
                                                    </div>
                                    
                                                    <!-- Created By -->
                                                    <div class="col-xl-12">
                                                        <label for="created_by" class="form-label">Created By</label>
                                                        <input type="text" class="form-control" name="created_by" id="created_by" placeholder="e.g. By Tania Ghosh Jan 10, 2025" required>
                                                    </div>
                                    
                                                    <!-- Status -->
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
                                                <button type="submit" class="btn btn-primary">Add Blog</button>
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
                                        <th>
                                            <input class="form-check-input check-all" type="checkbox" id="all-tasks" value="" aria-label="...">
                                        </th>
                                        <th scope="col">Blog Title</th>
                                        <th scope="col">Short Description</th>
                                        <th scope="col">Image</th>
                                        <th scope="col">Created By</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($blogs as $key => $blog)
                                        <tr class="task-list">
                                            <td class="task-checkbox">
                                                <input class="form-check-input" type="checkbox" value="" aria-label="...">
                                            </td>
                                            <td>
                                                <span class="fw-medium">{{ $blog->title }}</span>
                                            </td>
                                            <td>
                                                <span class="fw-medium">{{ Str::limit($blog->description_short, 50) }}</span>
                                            </td>
                                            <td>
                                                @if($blog->image)
                                                    <img src="{{ asset('storage/' . $blog->image) }}" width="50" height="50" alt="Blog Image">
                                                @else
                                                    N/A
                                                @endif
                                            </td>
                                            <td>
                                                <span class="fw-medium">{{ $blog->created_by }}</span>
                                            </td>
                                            <td>
                                                <span class="fw-medium 
                                                    @if($blog->status == 'active') 
                                                        bg-success text-white px-2 py-1 rounded
                                                    @else 
                                                        bg-secondary text-white px-2 py-1 rounded
                                                    @endif
                                                ">
                                                    {{ ucfirst($blog->status) }}
                                                </span>
                                            </td>
                            
                                            <td>
                                                <a href="{{ route('admin.blogs.edit', $blog->id) }}" class="btn btn-primary-light btn-icon btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Edit">
                                                    <i class="ri-edit-line"></i>
                                                </a>
                                                <form action="{{ route('admin.blogs.destroy', $blog->id) }}" method="POST" style="display:inline;">
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

<script>
document.addEventListener('DOMContentLoaded', function() {
    var textarea = document.getElementById('short_description');
    var countDisplay = document.getElementById('short_description_count');
    var errorDisplay = document.getElementById('short_description_error');
    function updateWordCount() {
        let words = textarea.value.match(/\S+/g) || [];
        let wordCount = words.length;
        countDisplay.textContent = wordCount + '/15 words';
        if (wordCount > 15) {
            errorDisplay.style.display = 'block';
            textarea.value = words.slice(0, 15).join(' ');
            countDisplay.textContent = '15/15 words';
        } else {
            errorDisplay.style.display = 'none';
        }
    }
    textarea.addEventListener('input', updateWordCount);
    // Initialize on page load
    updateWordCount();
});
</script>
@endsection