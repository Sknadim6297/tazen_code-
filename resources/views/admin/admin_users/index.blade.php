@extends('admin.layouts.layout')
@section('content')
<!-- Start::row-1 -->
<div class="main-content app-content">
<div class="row">
    <div class="col-xl-12">
        <div class="card custom-card">
            <div class="card-header d-flex justify-content-between">
                <div class="card-title">
                    Admin Users Management
                </div>
                <div>
                    <a href="{{ route('admin.admin-users.create') }}" class="btn btn-primary">
                        <i class="ri-add-line me-1"></i> Add New Admin
                    </a>
                </div>
            </div>
            <div class="card-body">
                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif
                
                <div class="table-responsive">
                    <table class="table table-bordered text-nowrap">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($adminUsers as $admin)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $admin->name }}</td>
                                    <td>{{ $admin->email }}</td>
                                    <td>
                                        <span class="badge bg-{{ $admin->role == 'super_admin' ? 'danger' : 'primary' }}">
                                            {{ ucfirst(str_replace('_', ' ', $admin->role)) }}
                                        </span>
                                    </td>
                                    <td>
                                        @if ($admin->is_active)
                                            <span class="badge bg-success">Active</span>
                                        @else
                                            <span class="badge bg-danger">Inactive</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.admin-users.edit', $admin->id) }}" class="btn btn-primary btn-sm">
                                            <i class="ri-pencil-line"></i> Edit
                                        </a>
                                        
                                        @if($admin->role !== 'super_admin')
                                            <a href="{{ route('admin.admin-users.permissions', $admin->id) }}" class="btn btn-info btn-sm">
                                                <i class="ri-lock-line"></i> Permissions
                                            </a>
                                        @endif
                                        
                                        @if (auth()->guard('admin')->id() != $admin->id)
                                            <form action="{{ route('admin.admin-users.destroy', $admin->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this admin user?')">
                                                    <i class="ri-delete-bin-line"></i> Delete
                                                </button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center">No admin users found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<!-- End::row-1 -->
@endsection