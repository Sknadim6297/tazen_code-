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
                                    <form id="blogPostForm" action="{{ route('admin.blogposts.store') }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h6 class="modal-title">Add Blog Post</h6>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body px-4 py-3">
                                                <div class="row gy-3">
                                                    <div class="col-xl-12 mb-3">
                                                        <label for="blog_id" class="form-label">Blog Title</label>
                                                        <select name="blog_id" id="blog_id" class="form-select" required>
                                                            <option value="">Select Blog</option>
                                                            @foreach($blogTitles as $blog)
                                                                <option value="{{ $blog->id }}">{{ $blog->title }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-xl-6 mb-3">
                                                        <label for="image" class="form-label">Blog Image</label>
                                                        <input type="file" class="form-control" id="image" name="image" accept="image/*" required>
                                                    </div>
                                                    <div class="col-xl-6 mb-3">
                                                        <label for="category" class="form-label">Category</label>
                                                        <input type="text" class="form-control" id="category" name="category" placeholder="Enter Category" required>
                                                    </div>
                                                    <div class="col-xl-6 mb-3">
                                                        <label for="published_at" class="form-label">Published Date</label>
                                                        <input type="date" class="form-control" id="published_at" name="published_at" required>
                                                    </div>
                                                    <div class="col-xl-12 mb-3">
                                                        <label for="content" class="form-label">Content</label>
                                                        <textarea class="form-control" id="content" name="content" rows="10" placeholder="Enter Blog Content" required></textarea>
                                                    </div>
                                                    <div class="col-xl-6 mb-3">
                                                        <label for="author_name" class="form-label">Author Name</label>
                                                        <input type="text" class="form-control" id="author_name" name="author_name" placeholder="Enter Author Name" required>
                                                    </div>
                                                    <div class="col-xl-6 mb-3">
                                                        <label for="author_avatar" class="form-label">Author Avatar</label>
                                                        <input type="file" class="form-control" id="author_avatar" name="author_avatar" accept="image/*">
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
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th scope="col">Blog Image</th>
                                        <th scope="col">Category</th>
                                        <th scope="col">Published Date</th>
                                        <th scope="col">Blog Title</th>
                                        <th scope="col">Content</th>
                                        <th scope="col">Author Name</th>
                                        <th scope="col">Author Avatar</th>
                                        {{-- <th scope="col">Comment Count</th> --}}
                                        <th scope="col">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($blogPosts as $blogPost)
                                        <tr>
                                            <td>
                                                <img src="{{ asset('storage/' . $blogPost->image) }}" alt="Blog Image" width="100" height="100">
                                            </td>
                                            <td>{{ $blogPost->category }}</td>
                                            <td>{{ $blogPost->published_at->format('Y-m-d') }}</td>
                                            <td>{{ $blogPost->blog->title }}</td> <!-- Assuming the blog relationship exists -->
                                            <td>{!! Str::limit(strip_tags($blogPost->content), 100) !!}</td> <!-- Displaying truncated content without HTML tags -->
                                            <td>{{ $blogPost->author_name }}</td>
                                            <td>
                                                @if($blogPost->author_avatar)
                                                    <img src="{{ asset('storage/' . $blogPost->author_avatar) }}" alt="Author Avatar" width="50" height="50">
                                                @endif
                                            </td>
                                            {{-- <td>{{ $blogPost->comment_count }}</td> --}}
                                            <td>
                                                <!-- You can add action buttons like Edit or Delete here -->
                                                <a href="{{ route('admin.blogposts.edit', $blogPost->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                                <form action="{{ route('admin.blogposts.destroy', $blogPost->id) }}" method="POST" style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this blog post?')">
                                                        Delete
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

@section('scripts')
<!-- CKEditor CDN -->
<script src="https://cdn.ckeditor.com/ckeditor5/40.0.0/classic/ckeditor.js"></script>
<script>
    let editor;
    
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize CKEditor for the content textarea
        ClassicEditor
            .create(document.querySelector('#content'), {
                toolbar: [
                    'heading',
                    '|',
                    'bold',
                    'italic',
                    'link',
                    'bulletedList',
                    'numberedList',
                    '|',
                    'outdent',
                    'indent',
                    '|',
                    'blockQuote',
                    'insertTable',
                    'undo',
                    'redo'
                ],
                placeholder: 'Enter Blog Content...',
                height: '300px'
            })
            .then(newEditor => {
                editor = newEditor;
                console.log('CKEditor initialized successfully');
            })
            .catch(error => {
                console.error('Error initializing CKEditor:', error);
            });

        // Handle form submission to sync CKEditor content
        const form = document.getElementById('blogPostForm');
        if (form) {
            form.addEventListener('submit', function(e) {
                console.log('Form submission detected');
                // Update the textarea with CKEditor content before form submission
                if (editor) {
                    const content = editor.getData();
                    document.querySelector('#content').value = content;
                    console.log('Content synced:', content);
                } else {
                    console.log('Editor not found');
                }
            });
        } else {
            console.log('Form not found');
        }

        // Also handle the submit button click directly
        const submitBtn = document.querySelector('#blogPostForm button[type="submit"]');
        if (submitBtn) {
            submitBtn.addEventListener('click', function(e) {
                console.log('Submit button clicked');
                if (editor) {
                    const content = editor.getData();
                    document.querySelector('#content').value = content;
                    console.log('Content synced from button click');
                }
            });
        }
    });
</script>
@endsection