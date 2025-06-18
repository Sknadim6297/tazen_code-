@extends('admin.layouts.layout')
@section('content')
<div class="main-content app-content">
    <div class="container-fluid">
        <!-- Page Header -->
        <div class="my-4 page-header-breadcrumb d-flex align-items-center justify-content-between flex-wrap gap-2">
            <div>
                <h1 class="page-title fw-medium fs-18 mb-2">Contact Form Submissions</h1>
                <div class="">
                    <nav>
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="javascript:void(0);">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Contact Form Submissions</li>
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
                            Contact Form Submissions
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table text-nowrap">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Message</th>
                                        <th>Verification Answer</th>
                                        <th>Submitted At</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($submissions as $key => $submission)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $submission->name }}</td>
                                            <td>{{ $submission->email }}</td>
                                            <td>{{ $submission->phone }}</td>
                                            <td>{{ Str::limit($submission->message, 50) }}</td>
                                            <td>{{ $submission->verification_answer }}</td>
                                            <td>{{ $submission->created_at->format('d M, Y H:i') }}</td>
                                            <td>
                                                <button type="button" class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#viewModal{{ $submission->id }}">
                                                    View
                                                </button>
                                                <form action="{{ route('admin.contact-forms.destroy', $submission->id) }}" method="POST" style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this submission?')">Delete</button>
                                                </form>
                                            </td>
                                        </tr>

                                        <!-- View Modal -->
                                        <div class="modal fade" id="viewModal{{ $submission->id }}" tabindex="-1" aria-labelledby="viewModalLabel{{ $submission->id }}" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="viewModalLabel{{ $submission->id }}">Contact Form Submission Details</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p><strong>Name:</strong> {{ $submission->name }}</p>
                                                        <p><strong>Email:</strong> {{ $submission->email }}</p>
                                                        <p><strong>Message:</strong> {{ $submission->message }}</p>
                                                        <p><strong>Verification Answer:</strong> {{ $submission->verification_answer }}</p>
                                                        <p><strong>Submitted At:</strong> {{ $submission->created_at->format('d M, Y H:i') }}</p>
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
                        {{ $submissions->links() }}
                    </div>
                </div>
            </div>
        </div>
        <!--End::row-2 -->
    </div>
</div>
@endsection