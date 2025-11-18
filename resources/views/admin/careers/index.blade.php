@extends('admin.layouts.layout')
@section('content')
<div class="main-content app-content">
    <div class="container-fluid">

        <!-- Page Header -->
        <div class="my-4 page-header-breadcrumb d-flex align-items-center justify-content-between flex-wrap gap-2">
            <div>
                <h1 class="page-title fw-medium fs-18 mb-2">Career Management</h1>
                <div class="">
                    <nav>
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="javascript:void(0);">Admin</a></li>
                            <li class="breadcrumb-item"><a href="javascript:void(0);">Career</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Career List</li>
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
                            Career Jobs
                        </div>
                        <div class="d-flex">
                            <a href="{{ route('admin.careers.create') }}" class="btn btn-sm btn-primary btn-wave waves-light">
                                <i class="ri-add-line fw-medium align-middle me-1"></i> Create Career Job
                            </a>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table text-nowrap">
                                <thead class="table-light">
                                    <tr>
                                        <th style="border: 1px solid #dee2e6;">#</th>
                                        <th style="border: 1px solid #dee2e6;">Title</th>
                                        <th style="border: 1px solid #dee2e6;">Location</th>
                                        <th style="border: 1px solid #dee2e6;">Job Type</th>
                                        <th style="border: 1px solid #dee2e6;">Department</th>
                                        <th style="border: 1px solid #dee2e6;">Status</th>
                                        <th style="border: 1px solid #dee2e6;">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($careers as $index => $career)
                                        <tr>
                                            <td style="border: 1px solid #dee2e6;">{{ $index + 1 }}</td>
                                            <td style="border: 1px solid #dee2e6;">{{ $career->title ?? 'N/A' }}</td>
                                            <td style="border: 1px solid #dee2e6;">{{ $career->location ?? 'N/A' }}</td>
                                            <td style="border: 1px solid #dee2e6;">{{ $career->job_type ?? 'N/A' }}</td>
                                            <td style="border: 1px solid #dee2e6;">{{ $career->department ?? 'N/A' }}</td>
                                            <td style="border: 1px solid #dee2e6;">
                                                <span class="badge bg-{{ $career->status === 'active' ? 'success' : 'secondary' }}">
                                                    {{ ucfirst($career->status) }}
                                                </span>
                                            </td>
                                            <td style="border: 1px solid #dee2e6;">
                                                <a href="{{ route('admin.careers.edit', $career->id) }}" class="btn btn-sm btn-info">Edit</a>
                                                <form action="{{ route('admin.careers.destroy', $career->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="text-center" style="border: 1px solid #dee2e6;">No career jobs found</td>
                                        </tr>
                                    @endforelse
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
@endsection

