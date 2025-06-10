@extends('admin.layouts.layout')
@section('content')
<div class="main-content app-content">
    <div class="container-fluid">
        <!-- Page Header -->
        <div class="my-4 page-header-breadcrumb d-flex align-items-center justify-content-between flex-wrap gap-2">
            <div>
                <h1 class="page-title fw-medium fs-18 mb-2">Help & FAQ Management</h1>
                <div class="">
                    <nav>
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="javascript:void(0);">Admin</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Help & FAQ</li>
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
                            Help & FAQ List
                        </div>
                        <div class="d-flex gap-2">
                            {{-- Category Filter --}}
                            <form action="{{ route('admin.help.index') }}" method="GET" class="d-flex gap-2">
                                <select name="category_filter" class="form-select" onchange="this.form.submit()">
                                    <option value="">All Categories</option>
                                    @foreach(App\Models\Help::CATEGORIES as $category)
                                        <option value="{{ $category }}" {{ request('category_filter') == $category ? 'selected' : '' }}>
                                            {{ $category }}
                                        </option>
                                    @endforeach
                                </select>
                                @if(request('category_filter'))
                                    <a href="{{ route('admin.help.index') }}" class="btn btn-light">Clear Filter</a>
                                @endif
                            </form>
                            <button class="btn btn-sm btn-primary btn-wave waves-light" data-bs-toggle="modal" data-bs-target="#create-help">
                                <i class="ri-add-line fw-medium align-middle me-1"></i> Add New FAQ
                            </button>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table text-nowrap">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Category</th>
                                        <th>Question</th>
                                        <th>Answer</th>
                                        <th>Status</th>
                                        <th>Created At</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($helps as $index => $help)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $help->category }}</td>
                                        <td>{{ Str::limit($help->question, 50) }}</td>
                                        <td>{{ Str::limit($help->answer, 50) }}</td>
                                        <td>
                                            <span class="badge bg-{{ $help->status === 'active' ? 'success' : 'danger' }}">
                                                {{ ucfirst($help->status) }}
                                            </span>
                                        </td>
                                        <td>{{ $help->created_at->format('d M Y') }}</td>
                                        <td>
                                            <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#edit-help-{{ $help->id }}">
                                                Edit
                                            </button>
                                            <form action="{{ route('admin.help.destroy', $help->id) }}" method="POST" style="display:inline-block;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" onclick="return confirm('Are you sure you want to delete this FAQ?')" class="btn btn-sm btn-danger">
                                                    Delete
                                                </button>
                                            </form>
                                        </td>
                                    </tr>

                                    <!-- Edit Modal -->
                                    <div class="modal fade" id="edit-help-{{ $help->id }}" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <form action="{{ route('admin.help.update', $help->id) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h6 class="modal-title">Edit FAQ</h6>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body px-4">
                                                        <div class="row gy-3">
                                                            <div class="col-xl-12">
                                                                <label for="category" class="form-label">Category</label>
                                                                <select class="form-select" id="category" name="category" required>
                                                                    @foreach(App\Models\Help::CATEGORIES as $category)
                                                                        <option value="{{ $category }}" {{ $help->category == $category ? 'selected' : '' }}>
                                                                            {{ $category }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <div class="col-xl-12">
                                                                <label for="question" class="form-label">Question</label>
                                                                <input type="text" class="form-control" id="question" name="question" value="{{ $help->question }}" required>
                                                            </div>
                                                            <div class="col-xl-12">
                                                                <label for="answer" class="form-label">Answer</label>
                                                                <textarea class="form-control" id="answer" name="answer" rows="4" required>{{ $help->answer }}</textarea>
                                                            </div>
                                                            <div class="col-xl-12">
                                                                <label for="status" class="form-label">Status</label>
                                                                <select class="form-select" id="status" name="status" required>
                                                                    <option value="active" {{ $help->status == 'active' ? 'selected' : '' }}>Active</option>
                                                                    <option value="inactive" {{ $help->status == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                                                        <button type="submit" class="btn btn-primary">Update FAQ</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--End::row-2 -->
    </div>
</div>

<!-- Create Modal -->
<div class="modal fade" id="create-help" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <form action="{{ route('admin.help.store') }}" method="POST">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title">Add New FAQ</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body px-4">
                    <div class="row gy-3">
                        <div class="col-xl-12">
                            <label for="category" class="form-label">Category</label>
                            <select class="form-select" id="category" name="category" required>
                                <option value="">Select Category</option>
                                @foreach(App\Models\Help::CATEGORIES as $category)
                                    <option value="{{ $category }}">{{ $category }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-xl-12">
                            <label for="question" class="form-label">Question</label>
                            <input type="text" class="form-control" id="question" name="question" required>
                        </div>
                        <div class="col-xl-12">
                            <label for="answer" class="form-label">Answer</label>
                            <textarea class="form-control" id="answer" name="answer" rows="4" required></textarea>
                        </div>
                        <div class="col-xl-12">
                            <label for="status" class="form-label">Status</label>
                            <select class="form-select" id="status" name="status" required>
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Add FAQ</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection