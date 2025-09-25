@extends('admin.layouts.layout')

@section('style')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" />
@endsection

@section('content')
<div class="main-content app-content">
    <div class="container-fluid">
        <div class="my-4 page-header-breadcrumb d-flex align-items-center justify-content-between flex-wrap gap-2">
            <div>
                <h1 class="page-title fw-medium fs-18 mb-2">All Customers</h1>
                <div>
                    <nav>
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="javascript:void(0);">Customer</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Manage Customers</li>
                        </ol>
                    </nav>
                </div>
            </div>
         <form action="{{ route('admin.manage-customer.index') }}" method="GET" class="d-flex gap-2">
           <div class="col-xl-6">
        <div class="card-body">
            <div class="form-group">
                <div class="input-group">
                    <div class="input-group-text text-muted"><i class="ri-calendar-line"></i></div>
                    <input type="date" class="form-control"  placeholder="Choose Start Date" name="start_date" id="start_date">
                    <span class="input-group-text">to</span>
                    <input type="date" class="form-control"  placeholder="Choose End Date" name="end_date" id="end_date">
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-4">
        <div class="card custom-card">
            <input type="search" name="search" class="form-control" id="autoComplete" placeholder="Search">
        </div>
    </div>
    <div class="col-xl-2">
        <button type="submit" class="btn btn-primary">Search</button>
    </div>
</form>
</div>
        <div class="row">
            <div class="col-xxl-12 col-xl-12">
                <div class="card custom-card">
                    <div class="card-header justify-content-between">
                        <div class="card-title">
                            Total Customers
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table text-nowrap">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Email</th>
                                        <th scope="col">Created At</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody id="customer-table-body">
                                    @foreach ($users as $user)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $user->name }}</td>
                                            <td>{{ $user->email }}</td>
                                            <td>{{ $user->created_at->format('d M, Y') }}</td>
                                            <td>
                                                <a href="{{ route('admin.manage-customer.show', $user->id) }}" class="btn btn-success-light btn-icon btn-sm" data-bs-toggle="tooltip" title="View">
                                                    <i class="ri-eye-line"></i>
                                                </a>
                                                <button type="button" class="btn btn-info-light btn-icon btn-sm ms-1 chat-btn" 
                                                        data-participant-type="user" 
                                                        data-participant-id="{{ $user->id }}" 
                                                        data-bs-toggle="tooltip" 
                                                        title="Chat">
                                                    <i class="ri-message-3-line"></i>
                                                </button>
                                                <form method="POST" action="{{ route('admin.manage-customer.destroy', $user->id) }}" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="btn btn-danger-light btn-icon btn-sm ms-1" data-bs-toggle="tooltip" title="Delete" onclick="return confirm('Are you sure?')">
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
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
@endsection
