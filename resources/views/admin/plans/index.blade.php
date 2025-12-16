@extends('admin.layouts.layout')
@section('content')
<div class="main-content app-content">
    <div class="container-fluid">
        <!-- Page Header -->
        <div class="my-4 page-header-breadcrumb d-flex align-items-center justify-content-between flex-wrap gap-2">
            <div>
                <h1 class="page-title fw-medium fs-18 mb-2">Manage Plans</h1>
                <nav>
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Plans</li>
                    </ol>
                </nav>
            </div>
            <div>
                <a href="{{ route('admin.plans.create') }}" class="btn btn-primary btn-wave waves-effect waves-light">
                    <i class="ri-add-line fw-medium align-middle me-1"></i> Add New Plan
                </a>
            </div>
        </div>
        <!-- Page Header Close -->

        <div class="row">
            <div class="col-12">
                <div class="card custom-card">
                    <div class="card-header">
                        <div class="card-title">All Plans</div>
                    </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>ID</th>
                                    <th>Plan Name</th>
                                    <th>Price</th>
                                    <th>Lead Limit</th>
                                    <th>Validity</th>
                                    <th>Status</th>
                                    <th>Order</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($plans as $plan)
                                    <tr>
                                        <td>{{ $plan->id }}</td>
                                        <td><strong>{{ $plan->name }}</strong></td>
                                        <td>{{ $plan->formatted_price }}</td>
                                        <td>{{ $plan->lead_limit }} leads</td>
                                        <td>
                                            @if($plan->validity_days)
                                                {{ $plan->validity_days }} days
                                            @else
                                                <span class="text-muted">Unlimited</span>
                                            @endif
                                        </td>
                                        <td>
                                            <span class="badge bg-{{ $plan->status === 'active' ? 'success' : 'danger' }}">
                                                {{ ucfirst($plan->status) }}
                                            </span>
                                        </td>
                                        <td>{{ $plan->order }}</td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('admin.plans.edit', $plan->id) }}" 
                                                   class="btn btn-sm btn-info" title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form action="{{ route('admin.plans.toggle-status', $plan->id) }}" 
                                                      method="POST" class="d-inline">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="btn btn-sm btn-warning" title="Toggle Status">
                                                        <i class="fas fa-toggle-on"></i>
                                                    </button>
                                                </form>
                                                <form action="{{ route('admin.plans.destroy', $plan->id) }}" 
                                                      method="POST" class="d-inline"
                                                      onsubmit="return confirm('Are you sure you want to delete this plan?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger" title="Delete">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center text-muted py-4">
                                            No plans found. <a href="{{ route('admin.plans.create') }}">Create one now</a>
                                        </td>
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
</div>
@endsection
