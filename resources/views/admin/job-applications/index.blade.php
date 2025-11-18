@extends('admin.layouts.layout')
@section('content')
<div class="main-content app-content">
    <div class="container-fluid">

        <!-- Page Header -->
        <div class="my-4 page-header-breadcrumb d-flex align-items-center justify-content-between flex-wrap gap-2">
            <div>
                <h1 class="page-title fw-medium fs-18 mb-2">Job Applications</h1>
                <div class="">
                    <nav>
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="javascript:void(0);">Admin</a></li>
                            <li class="breadcrumb-item"><a href="javascript:void(0);">Career</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Job Applications</li>
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
                            All Job Applications
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table text-nowrap">
                                <thead class="table-light">
                                    <tr>
                                        <th style="border: 1px solid #dee2e6;">#</th>
                                        <th style="border: 1px solid #dee2e6;">Job Title</th>
                                        <th style="border: 1px solid #dee2e6;">Applicant Name</th>
                                        <th style="border: 1px solid #dee2e6;">Email</th>
                                        <th style="border: 1px solid #dee2e6;">Phone</th>
                                        <th style="border: 1px solid #dee2e6;">Status</th>
                                        <th style="border: 1px solid #dee2e6;">Applied Date</th>
                                        <th style="border: 1px solid #dee2e6;">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($applications as $index => $application)
                                        <tr>
                                            <td style="border: 1px solid #dee2e6;">{{ $index + 1 }}</td>
                                            <td style="border: 1px solid #dee2e6;">{{ $application->career->title ?? 'N/A' }}</td>
                                            <td style="border: 1px solid #dee2e6;">{{ $application->full_name }}</td>
                                            <td style="border: 1px solid #dee2e6;">{{ $application->email }}</td>
                                            <td style="border: 1px solid #dee2e6;">{{ $application->phone_country ? '+' . $application->phone_country . ' ' : '' }}{{ $application->phone_number }}</td>
                                            <td style="border: 1px solid #dee2e6;">
                                                <span class="badge bg-{{ $application->status === 'pending' ? 'warning' : ($application->status === 'shortlisted' ? 'success' : ($application->status === 'rejected' ? 'danger' : 'info')) }}">
                                                    {{ ucfirst($application->status) }}
                                                </span>
                                            </td>
                                            <td style="border: 1px solid #dee2e6;">{{ $application->created_at->format('d M Y') }}</td>
                                            <td style="border: 1px solid #dee2e6;">
                                                <a href="{{ route('admin.job-applications.show', $application->id) }}" class="btn btn-sm btn-info">View</a>
                                                <form action="{{ route('admin.job-applications.destroy', $application->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this application?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="8" class="text-center" style="border: 1px solid #dee2e6;">No job applications found</td>
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

