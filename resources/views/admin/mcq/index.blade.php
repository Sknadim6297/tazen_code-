@extends('admin.layouts.layout')

@section('content')
<div class="main-content app-content">
<div class="container-fluid">
    <!-- Page Header -->
    <div class="page-header">
        <div class="page-title">
            <h3>MCQ Answers Management</h3>
        </div>
        <ul class="breadcrumb">
            <li>Dashboard</li>
            <li class="active">MCQ Answers</li>
        </ul>
    </div>

    <!-- Filter Section -->
    <div class="card mb-4">
        <div class="card-header">
            <h4>Filter Options</h4>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.mcq-answers.index') }}" method="GET" id="filter-form">
                <div class="row">
                    <div class="col-md-3 mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" class="form-control" id="username" name="username" 
                               value="{{ request('username') }}" placeholder="Search by username">
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="service" class="form-label">Service Name</label>
                        <select class="form-control" id="service" name="service">
                            <option value="">All Services</option>
                            @foreach($services as $service)
                                <option value="{{ $service->id }}" {{ request('service') == $service->id ? 'selected' : '' }}>
                                    {{ $service->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="start_date" class="form-label">Start Date</label>
                        <input type="date" class="form-control" id="start_date" name="start_date" 
                               value="{{ request('start_date') }}">
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="end_date" class="form-label">End Date</label>
                        <input type="date" class="form-control" id="end_date" name="end_date" 
                               value="{{ request('end_date') }}">
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-search"></i> Apply Filters
                        </button>
                        <a href="{{ route('admin.mcq-answers.index') }}" class="btn btn-secondary">
                            <i class="fas fa-times"></i> Reset
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">MCQ Answers</h3>
                    <div class="card-tools">
                        <span class="badge badge-info">{{ $filteredRecords }} of {{ $totalRecords }} Records</span>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <!-- Filter Status Display -->
                    @if(request('username') || request('service') || request('start_date') || request('end_date'))
                    <div class="alert alert-info mb-3">
                        <strong>Active Filters:</strong>
                        @if(request('username'))
                            <span class="badge badge-primary me-2">Username: {{ request('username') }}</span>
                        @endif
                        @if(request('service'))
                            @php
                                $selectedService = $services->find(request('service'));
                            @endphp
                            <span class="badge badge-primary me-2">Service: {{ $selectedService ? $selectedService->name : 'Unknown' }}</span>
                        @endif
                        @if(request('start_date'))
                            <span class="badge badge-primary me-2">From: {{ request('start_date') }}</span>
                        @endif
                        @if(request('end_date'))
                            <span class="badge badge-primary me-2">To: {{ request('end_date') }}</span>
                        @endif
                        <a href="{{ route('admin.mcq-answers.index') }}" class="btn btn-sm btn-outline-danger ms-2">
                            <i class="fas fa-times"></i> Clear All
                        </a>
                    </div>
                    @endif

                    @if($mcqAnswers->count() > 0)
                    <div class="table-responsive" style="overflow-x: auto; width: 100%;">
                        <table id="mcqTable" class="table table-bordered table-striped" style="width: 100%; min-width: 800px;">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>User</th>
                                    <th>Service</th>
                                    <th>Question</th>
                                    <th>Answer</th>
                                    <th>Created At</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($mcqAnswers as $answer)
                                <tr>
                                    <td>{{ $answer->id }}</td>
                                    <td>
                                        <strong>{{ $answer->user->name ?? 'N/A' }}</strong>
                                        @if($answer->user)
                                            <br><small class="text-muted">{{ $answer->user->email ?? '' }}</small>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge badge-secondary">{{ $answer->service->name ?? 'N/A' }}</span>
                                    </td>
                                    <td>{{ Str::limit($answer->question->question ?? 'N/A', 50) }}</td>
                                    <td>{{ Str::limit($answer->answer, 30) }}</td>
                                    <td>{{ $answer->created_at->format('M d, Y H:i') }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @else
                    <div class="alert alert-warning text-center">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        @if(request('username') || request('service') || request('start_date') || request('end_date'))
                            No records found matching your current filters.
                            <a href="{{ route('admin.mcq-answers.index') }}" class="btn btn-sm btn-outline-primary ms-2">
                                Clear Filters
                            </a>
                        @else
                            No MCQ answers found in the system.
                        @endif
                    </div>
                    @endif
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->
</div>
</div>
<!-- /.container-fluid -->

<style>
    /* Modern Page Header */
    .page-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 2rem;
        border-radius: 15px;
        margin-bottom: 2rem;
        box-shadow: 0 8px 25px rgba(102, 126, 234, 0.15);
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 1rem;
    }

    .page-title h3 {
        font-size: 1.75rem;
        font-weight: 700;
        margin: 0;
        text-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }

    .breadcrumb {
        background: none;
        padding: 0;
        margin: 0;
        list-style: none;
        display: flex;
        gap: 0.5rem;
        font-size: 0.9rem;
        opacity: 0.9;
    }

    .breadcrumb li {
        position: relative;
    }

    .breadcrumb li:not(:last-child)::after {
        content: '>';
        margin-left: 0.5rem;
        opacity: 0.7;
    }

    .breadcrumb li.active {
        font-weight: 600;
    }

    /* Card Styling */
    .card {
        border: none;
        border-radius: 15px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.08);
        overflow: hidden;
        margin-bottom: 2rem;
        background: white;
    }

    .card-header {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        border-bottom: 1px solid #e9ecef;
        padding: 1.5rem 2rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .card-header h3, .card-header h4 {
        margin: 0;
        font-size: 1.25rem;
        font-weight: 600;
        color: #2d3748;
    }

    .card-body {
        padding: 2rem;
    }

    /* Form Controls */
    .form-control {
        border: 2px solid #e2e8f0;
        border-radius: 10px;
        padding: 0.75rem 1rem;
        font-size: 0.95rem;
        transition: all 0.3s ease;
        background: #f8f9fa;
    }

    .form-control:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        background: white;
        outline: none;
    }

    .form-label {
        font-weight: 600;
        color: #4a5568;
        margin-bottom: 0.5rem;
        display: block;
    }

    /* Buttons */
    .btn {
        border-radius: 10px;
        padding: 0.75rem 1.5rem;
        font-weight: 600;
        transition: all 0.3s ease;
        border: none;
        cursor: pointer;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }

    .btn-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(102, 126, 234, 0.3);
        color: white;
    }

    .btn-secondary {
        background: #6c757d;
        color: white;
    }

    .btn-secondary:hover {
        background: #5a6268;
        transform: translateY(-2px);
        color: white;
    }

    /* Badge Styling */
    .badge {
        padding: 0.5rem 1rem;
        border-radius: 20px;
        font-weight: 600;
        font-size: 0.85rem;
    }

    .badge-info {
        background: linear-gradient(135deg, #4299e1 0%, #3182ce 100%);
        color: white;
    }

    .badge-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
    }

    .badge-secondary {
        background: linear-gradient(135deg, #6c757d 0%, #5a6268 100%);
        color: white;
    }

    /* Alert Styling */
    .alert {
        border: none;
        border-radius: 15px;
        padding: 1rem 1.5rem;
        font-weight: 500;
    }

    .alert-info {
        background: linear-gradient(135deg, #e3f2fd 0%, #bbdefb 100%);
        color: #1565c0;
        border-left: 4px solid #2196f3;
    }

    .alert-warning {
        background: linear-gradient(135deg, #fff3e0 0%, #ffe0b2 100%);
        color: #ef6c00;
        border-left: 4px solid #ff9800;
    }

    /* Button Styling for Filter Status */
    .btn-sm {
        padding: 0.4rem 0.8rem;
        font-size: 0.8rem;
        border-radius: 8px;
    }

    .btn-outline-danger {
        border: 2px solid #dc3545;
        color: #dc3545;
        background: transparent;
    }

    .btn-outline-danger:hover {
        background: #dc3545;
        color: white;
        transform: translateY(-1px);
    }

    .btn-outline-primary {
        border: 2px solid #667eea;
        color: #667eea;
        background: transparent;
    }

    .btn-outline-primary:hover {
        background: #667eea;
        color: white;
        transform: translateY(-1px);
    }

    /* Text Utilities */
    .text-muted {
        color: #6c757d !important;
    }

    .me-2 {
        margin-right: 0.5rem !important;
    }

    .ms-2 {
        margin-left: 0.5rem !important;
    }

    .mb-3 {
        margin-bottom: 1rem !important;
    }

    /* Table Styling */
    .table {
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 4px 15px rgba(0,0,0,0.05);
    }

    .table thead th {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        font-weight: 600;
        border: none;
        padding: 1rem;
    }

    .table tbody td {
        padding: 1rem;
        border-bottom: 1px solid #f1f5f9;
        vertical-align: middle;
    }

    .table tbody tr:hover {
        background: #f8f9fa;
        transform: scale(1.01);
        transition: all 0.3s ease;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .page-header {
            padding: 1.5rem;
            flex-direction: column;
            align-items: flex-start;
        }

        .page-title h3 {
            font-size: 1.5rem;
        }

        .card-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 1rem;
            padding: 1rem 1.5rem;
        }

        .card-body {
            padding: 1rem;
        }

        .btn {
            padding: 0.6rem 1rem;
            font-size: 0.85rem;
        }
    }

    /* Animation */
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .card {
        animation: fadeInUp 0.6s ease-out;
    }
</style>
@endsection

@section('scripts')
<script>
    $(function () {
        $("#mcqTable").DataTable({
            "responsive": true,
            "lengthChange": false,
            "autoWidth": false,
            "buttons": ["copy", "csv", "excel", "pdf", "print"]
        }).buttons().container().appendTo('#mcqTable_wrapper .col-md-6:eq(0)');
    });
</script>
@endsection 