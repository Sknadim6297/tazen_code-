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
                            <button class="btn btn-sm btn-primary btn-wave waves-light" data-bs-toggle="modal" data-bs-target="#create-task"><i class="ri-add-line fw-medium align-middle me-1"></i> Create Blog Post</button>
                            <!-- Start::add task modal -->
                            <div class="modal fade" id="create-task" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <form action="{{ route('admin.blogposts.store') }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h6 class="modal-title">Add Blog Post</h6>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body px-4">
                                                <div class="row gy-3">
                                    
                                                    {{-- Blog Image --}}
                                                    <div class="col-xl-6">
                                                        <label for="image" class="form-label">Blog Image</label>
                                                        <input type="file" class="form-control" id="image" name="image" accept="image/*" required>
                                                    </div>
                                    
                                                    {{-- Category --}}
                                                    <div class="col-xl-6">
                                                        <label for="category" class="form-label">Category</label>
                                                        <input type="text" class="form-control" id="category" name="category" placeholder="Enter Category" required>
                                                    </div>
                                    
                                                    {{-- Published Date --}}
                                                    <div class="col-xl-6">
                                                        <label for="published_at" class="form-label">Published Date</label>
                                                        <input type="date" class="form-control" id="published_at" name="published_at" required>
                                                    </div>
                                    
                                                    {{-- Blog Title --}}
                                                    <div class="col-xl-6">
                                                        <label for="title" class="form-label">Title</label>
                                                        <input type="text" class="form-control" id="title" name="title" placeholder="Enter Title" required>
                                                    </div>
                                    
                                                    {{-- Content --}}
                                                    <div class="col-xl-12">
                                                        <label for="content" class="form-label">Content</label>
                                                        <textarea class="form-control" id="content" name="content" rows="5" placeholder="Enter Blog Content" required></textarea>
                                                    </div>
                                    
                                                    {{-- Author Name --}}
                                                    <div class="col-xl-6">
                                                        <label for="author_name" class="form-label">Author Name</label>
                                                        <input type="text" class="form-control" id="author_name" name="author_name" placeholder="Enter Author Name" required>
                                                    </div>
                                    
                                                    {{-- Author Avatar --}}
                                                    <div class="col-xl-6">
                                                        <label for="author_avatar" class="form-label">Author Avatar</label>
                                                        <input type="file" class="form-control" id="author_avatar" name="author_avatar" accept="image/*">
                                                    </div>
                                    
                                                    {{-- Comment Count --}}
                                                    <div class="col-xl-6">
                                                        <label for="comment_count" class="form-label">Comment Count</label>
                                                        <input type="number" class="form-control" id="comment_count" name="comment_count" value="0" min="0">
                                                    </div>
                                    
                                                </div>
                                            </div>
                                    
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                                                <button type="submit" class="btn btn-primary">Add Blog Post</button>
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
                                <table class="table text-nowrap">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Image</th>
                                            <th>Category</th>
                                            <th>Published Date</th>
                                            <th>Title</th>
                                            <th>Content</th>
                                            <th>Author Name</th>
                                            <th>Author Avatar</th>
                                            <th>Comment Count</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($blogposts as $key => $post)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>
                                                    <img src="{{ asset('storage/' . $post->image) }}" alt="Blog Image" style="width: 100px; height: 60px;">
                                                </td>
                                                <td>{{ $post->category }}</td>
                                                <td>{{ $post->published_at->format('d M Y') }}</td>
                                                <td>{{ $post->title }}</td>
                                                <td>{{ Str::limit($post->content, 50) }}</td>
                                                <td>{{ $post->author_name }}</td>
                                                <td>
                                                    <img src="{{ asset('storage/' . $post->author_avatar) }}" alt="Author Avatar" style="width: 40px; height: 40px; border-radius: 50%;">
                                                </td>
                                                <td>{{ $post->comment_count }}</td>
                                                <td>
                                                    <a href="{{ route('admin.blogposts.edit', $post->id) }}" class="btn btn-sm btn-primary">Edit</a>
                                                    <form action="{{ route('admin.blogposts.destroy', $post->id) }}" method="POST" style="display:inline-block;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                                                                 
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