@extends('admin.layouts.layout')

@section('content')
<div class="main-content app-content">
    <div class="container-fluid">
        <!-- Page Header -->
        <div class="my-4 page-header-breadcrumb d-flex align-items-center justify-content-between flex-wrap gap-2">
            <div>
                <h1 class="page-title fw-medium fs-18 mb-2">Job Application Details</h1>
                <nav>
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="javascript:void(0);">Admin</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.job-applications.index') }}">Job Applications</a></li>
                        <li class="breadcrumb-item active" aria-current="page">View</li>
                    </ol>
                </nav>
            </div>
        </div>
        <!-- Page Header Close -->

        <div class="row">
            <div class="col-xxl-8 col-xl-8">
                <div class="card custom-card">
                    <div class="card-header justify-content-between">
                        <div class="card-title">Application Details</div>
                    </div>
                    <div class="card-body p-4">
                        <div class="row gy-3">
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Job Title</label>
                                <p>{{ $application->career->title ?? 'N/A' }}</p>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Applicant Name</label>
                                <p>{{ $application->full_name }}</p>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Email</label>
                                <p>{{ $application->email }}</p>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Phone Number</label>
                                <p>{{ $application->phone_country ? '+' . $application->phone_country . ' ' : '' }}{{ $application->phone_number }}</p>
                            </div>
                            @if($application->compensation_expectation)
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Compensation Expectation</label>
                                <p>{{ $application->compensation_expectation }}</p>
                            </div>
                            @endif
                            @if($application->why_perfect_fit)
                            <div class="col-md-12">
                                <label class="form-label fw-bold">Why Perfect Fit</label>
                                <p>{{ $application->why_perfect_fit }}</p>
                            </div>
                            @endif
                            @if($application->cv_resume)
                            <div class="col-md-6">
                                <label class="form-label fw-bold">CV/Resume</label>
                                <p>
                                    <a href="{{ asset('storage/' . $application->cv_resume) }}" target="_blank" class="btn btn-sm btn-primary">
                                        <i class="fas fa-download"></i> Download CV
                                    </a>
                                </p>
                            </div>
                            @endif
                            @if($application->cover_letter_file)
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Cover Letter (File)</label>
                                <p>
                                    <a href="{{ asset('storage/' . $application->cover_letter_file) }}" target="_blank" class="btn btn-sm btn-primary">
                                        <i class="fas fa-download"></i> Download Cover Letter
                                    </a>
                                </p>
                            </div>
                            @endif
                            @if($application->cover_letter_text)
                            <div class="col-md-12">
                                <label class="form-label fw-bold">Cover Letter (Text)</label>
                                <p>{{ $application->cover_letter_text }}</p>
                            </div>
                            @endif
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Applied Date</label>
                                <p>{{ $application->created_at->format('d M Y, h:i A') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xxl-4 col-xl-4">
                <div class="card custom-card">
                    <div class="card-header justify-content-between">
                        <div class="card-title">Update Status</div>
                    </div>
                    <div class="card-body p-4">
                        <form action="{{ route('admin.job-applications.update-status', $application->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            
                            <div class="mb-3">
                                <label for="status" class="form-label">Status</label>
                                <select class="form-control" name="status" id="status" required>
                                    <option value="pending" {{ $application->status === 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="reviewed" {{ $application->status === 'reviewed' ? 'selected' : '' }}>Reviewed</option>
                                    <option value="shortlisted" {{ $application->status === 'shortlisted' ? 'selected' : '' }}>Shortlisted</option>
                                    <option value="rejected" {{ $application->status === 'rejected' ? 'selected' : '' }}>Rejected</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="admin_notes" class="form-label">Admin Notes</label>
                                <textarea class="form-control" name="admin_notes" id="admin_notes" rows="4" placeholder="Add notes...">{{ old('admin_notes', $application->admin_notes) }}</textarea>
                            </div>

                            <button type="submit" class="btn btn-primary">Update Status</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

