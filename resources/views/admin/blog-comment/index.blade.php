@extends('admin.layouts.layout')
@section('content')
<div class="main-content app-content">
    <div class="container-fluid">

        <!-- Page Header -->
        <div class="my-4 page-header-breadcrumb d-flex align-items-center  flex-wrap gap-2" >
            <div>
                <h1 class="page-title fw-medium fs-18 mb-2">Blog Comments</h1>
                <div class="">
                    <nav>
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="javascript:void(0);">Comments</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Manage Comments</li>
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
                            Pending Comments
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
                                        <th scope="col">Blog Post</th>
                                        <th scope="col">Commenter</th>
                                        <th scope="col">Email</th>
                                        <th scope="col">Website</th>
                                        <th scope="col">Comment</th>
                                        <th scope="col">Date</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($comments as $comment)
                                        <tr class="task-list">
                                            <td class="task-checkbox">
                                                <input class="form-check-input" type="checkbox" value="" aria-label="...">
                                            </td>
                                            <td>
                                                <span class="fw-medium">{{ $comment->blogPost->blog->title }}</span>
                                            </td>
                                            <td>
                                                <span class="fw-medium">{{ $comment->name }}</span>
                                            </td>
                                            <td>
                                                <span class="fw-medium">{{ $comment->email }}</span>
                                            </td>
                                            <td>
                                                @if($comment->website)
                                                    <a href="{{ $comment->website }}" target="_blank" class="fw-medium">{{ $comment->website }}</a>
                                                @else
                                                    <span class="fw-medium">N/A</span>
                                                @endif
                                            </td>
                                            <td>
                                                <span class="fw-medium">{{ Str::limit($comment->comment, 50) }}</span>
                                            </td>
                                            <td>
                                                <span class="fw-medium">{{ $comment->created_at->format('d M Y') }}</span>
                                            </td>
                                            <td>
                                                <span class="fw-medium 
                                                    @if($comment->is_approved) 
                                                        bg-success text-white px-2 py-1 rounded
                                                    @else 
                                                        bg-warning text-white px-2 py-1 rounded
                                                    @endif
                                                ">
                                                    {{ $comment->is_approved ? 'Approved' : 'Pending' }}
                                                </span>
                                            </td>
                                            <td>
                                                <button type="button" class="btn btn-info-light btn-icon btn-sm" data-bs-toggle="modal" data-bs-target="#viewComment{{ $comment->id }}" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="View">
                                                    <i class="ri-eye-line"></i>
                                                </button>
                                                @if(!$comment->is_approved)
                                                    <form action="{{ route('admin.comments.approve', $comment->id) }}" method="POST" style="display:inline;">
                                                        @csrf
                                                        <button type="submit" class="btn btn-success-light btn-icon btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Approve">
                                                            <i class="ri-check-line"></i>
                                                        </button>
                                                    </form>
                                                @endif
                                                <form action="{{ route('admin.comments.destroy', $comment->id) }}" method="POST" style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger-light btn-icon ms-1 btn-sm task-delete-btn" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Delete">
                                                        <i class="ri-delete-bin-5-line"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>

                                        <!-- View Comment Modal -->
                                        <div class="modal fade" id="viewComment{{ $comment->id }}" tabindex="-1" aria-labelledby="viewCommentLabel{{ $comment->id }}" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="viewCommentLabel{{ $comment->id }}">Comment Details</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="mb-3">
                                                            <h6>Blog Post:</h6>
                                                            <p>{{ $comment->blogPost->blog->title }}</p>
                                                        </div>
                                                        <div class="mb-3">
                                                            <h6>Commenter:</h6>
                                                            <p>{{ $comment->name }}</p>
                                                        </div>
                                                        <div class="mb-3">
                                                            <h6>Email:</h6>
                                                            <p>{{ $comment->email }}</p>
                                                        </div>
                                                        @if($comment->website)
                                                        <div class="mb-3">
                                                            <h6>Website:</h6>
                                                            <p><a href="{{ $comment->website }}" target="_blank">{{ $comment->website }}</a></p>
                                                        </div>
                                                        @endif
                                                        <div class="mb-3">
                                                            <h6>Comment:</h6>
                                                            <p>{{ $comment->comment }}</p>
                                                        </div>
                                                        <div class="mb-3">
                                                            <h6>Date:</h6>
                                                            <p>{{ $comment->created_at->format('d M Y H:i:s') }}</p>
                                                        </div>
                                                        <div class="mb-3">
                                                            <h6>Status:</h6>
                                                            <p>
                                                                <span class="fw-medium 
                                                                    @if($comment->is_approved) 
                                                                        bg-success text-white px-2 py-1 rounded
                                                                    @else 
                                                                        bg-warning text-white px-2 py-1 rounded
                                                                    @endif
                                                                ">
                                                                    {{ $comment->is_approved ? 'Approved' : 'Pending' }}
                                                                </span>
                                                            </p>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    
                    <div class="card-footer border-top-0">
                        <nav aria-label="Page navigation">
                            {{ $comments->links() }}
                        </nav>
                    </div>
                </div>
            </div>
        </div>
        <!--End::row-2 -->
    </div>
</div>
@endsection