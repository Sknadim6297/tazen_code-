@extends('admin.layouts.layout')
@section('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" />
<style>
    .export-buttons {
        display: flex;
        gap: 10px;
        margin-left: 10px;
    }
    .export-btn {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 0.375rem 0.75rem;
        font-size: 0.875rem;
        border-radius: 0.25rem;
        cursor: pointer;
        transition: all 0.2s;
    }
    .export-btn-excel {
        background-color: #1f7244;
        color: white;
        border: none;
    }
    .export-btn-excel:hover {
        background-color: #155a33;
    }
    .export-btn-pdf {
        background-color: #c93a3a;
        color: white;
        border: none;
    }
    .export-btn-pdf:hover {
        background-color: #a52929;
    }
    .filter-card {
        border: none;
        box-shadow: 0 2px 10px rgba(0,0,0,0.08);
        border-radius: 12px;
        transition: all 0.3s ease;
    }
    .filter-card:hover {
        box-shadow: 0 4px 20px rgba(0,0,0,0.12);
    }
    .filter-card .card-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border-radius: 12px 12px 0 0;
        border: none;
        padding: 1rem 1.5rem;
    }
    .filter-card .card-title {
        color: white;
        font-weight: 600;
        font-size: 1.1rem;
    }
    .filter-card .card-body {
        padding: 1.5rem;
        background: #fafbfc;
    }
    .form-label {
        font-size: 0.875rem;
        font-weight: 500;
        color: #6c757d;
        margin-bottom: 0.5rem;
    }
    .input-group {
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 2px 4px rgba(0,0,0,0.04);
        transition: all 0.3s ease;
    }
    .input-group:focus-within {
        box-shadow: 0 4px 12px rgba(102, 126, 234, 0.15);
        transform: translateY(-1px);
    }
    .input-group-text {
        background: #f8f9fa;
        border: 1px solid #e9ecef;
        color: #6c757d;
        font-size: 0.875rem;
        padding: 0.75rem 1rem;
    }
    .form-control, .form-select {
        border: 1px solid #e9ecef;
        padding: 0.75rem 1rem;
        font-size: 0.875rem;
        transition: all 0.3s ease;
    }
    .form-control:focus, .form-select:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
    }
    .btn-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: none;
        border-radius: 8px;
        padding: 0.75rem 1.5rem;
        font-weight: 500;
        transition: all 0.3s ease;
        box-shadow: 0 2px 8px rgba(102, 126, 234, 0.3);
    }
    .btn-primary:hover {
        background: linear-gradient(135deg, #5a6fd8 0%, #6a4190 100%);
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
    }
    .btn-outline-secondary {
        border: 2px solid #6c757d;
        color: #6c757d;
        border-radius: 8px;
        padding: 0.75rem 1.5rem;
        font-weight: 500;
        transition: all 0.3s ease;
    }
    .btn-outline-secondary:hover {
        background: #6c757d;
        border-color: #6c757d;
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(108, 117, 125, 0.3);
    }
    .specialization-badge {
        display: inline-block;
        padding: 4px 10px;
        font-size: 0.75rem;
        font-weight: 500;
        background-color: #e9f8f3;
        color: #198754;
        border-radius: 12px;
        border: 1px solid #d1e7dd;
    }
    @media (max-width: 768px) {
        .filter-card .card-body {
            padding: 1rem;
        }
        .input-group {
            margin-bottom: 1rem;
        }
        .btn {
            width: 100%;
            margin-bottom: 0.5rem;
        }
        .export-buttons {
            margin-left: 0;
            margin-top: 10px;
            display: flex;
            width: 100%;
            gap: 10px;
        }
        .export-buttons .export-btn {
            flex: 1;
        }
    }
</style>
@endsection
@section('content')
<div class="main-content app-content">
    <div class="container-fluid">
        <!-- Page Header -->
        <div class="my-4 page-header-breadcrumb d-flex align-items-center justify-content-between flex-wrap gap-2">
            <div>
                <h1 class="page-title fw-medium fs-18 mb-2">Manage Professionals</h1>
                <div>
                    <nav>
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="javascript:void(0);">Professional</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Manage Professional</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <!-- Filter Section - Modern Design -->
        <div class="card custom-card filter-card mb-4">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="ri-filter-3-line me-2 text-primary"></i>
                    Filter Professionals
                </h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.professional.requests') }}" method="GET" id="searchForm">
                    <div class="row g-3">
                        <!-- Search Input -->
                        <div class="col-lg-3 col-md-6">
                            <label for="searchInput" class="form-label fw-medium text-muted mb-2">
                                <i class="ri-search-line me-1"></i>Search
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0">
                                    <i class="ri-user-line text-muted"></i>
                                </span>
                                <input type="search" name="search" class="form-control border-start-0" 
                                       id="searchInput" placeholder="Search by name or email" value="{{ request('search') }}">
                            </div>
                        </div>
                        <!-- Specialization Filter -->
                        <div class="col-lg-3 col-md-6">
                            <label for="specializationFilter" class="form-label fw-medium text-muted mb-2">
                                <i class="ri-award-line me-1"></i>Specialization
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0">
                                    <i class="ri-briefcase-line text-muted"></i>
                                </span>
                                <select name="specialization" class="form-select border-start-0" id="specializationFilter">
                                    <option value="">All Specializations</option>
                                    @foreach($specializations as $specialization)
                                        <option value="{{ $specialization }}" {{ request('specialization') == $specialization ? 'selected' : '' }}>
                                            {{ $specialization }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <!-- Date Range -->
                        <div class="col-lg-3 col-md-6">
                            <label class="form-label fw-medium text-muted mb-2">
                                <i class="ri-calendar-line me-1"></i>Date Range
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0">
                                    <i class="ri-calendar-event-line text-muted"></i>
                                </span>
                                <input type="date" class="form-control border-start-0 border-end-0" 
                                       placeholder="Start Date" name="start_date" id="start_date" value="{{ request('start_date') }}">
                                <span class="input-group-text bg-light border-start-0 border-end-0 text-muted">to</span>
                                <input type="date" class="form-control border-start-0" 
                                       placeholder="End Date" name="end_date" id="end_date" value="{{ request('end_date') }}">
                            </div>
                        </div>
                        <!-- Action Buttons -->
                        <div class="col-lg-3 col-md-6 d-flex align-items-end justify-content-end gap-2">
                            <button type="submit" class="btn btn-primary px-4">
                                <i class="ri-search-line me-1"></i>Search
                            </button>
                            <a href="{{ route('admin.professional.requests') }}" class="btn btn-outline-secondary px-4">
                                <i class="ri-refresh-line me-1"></i>Reset
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!-- Add Export buttons outside the filter form -->
        <div class="d-flex justify-content-end mb-3">
            <div class="export-buttons">
                <button type="button" class="export-btn export-btn-excel" onclick="exportData('excel')">
                    <i class="ri-file-excel-line me-1"></i> Export Excel
                </button>
                <button type="button" class="export-btn export-btn-pdf" onclick="exportData('pdf')">
                    <i class="ri-file-pdf-line me-1"></i> Export PDF
                </button>
            </div>
        </div>
        <!-- Add this hidden form for export -->
        <form id="export-form" method="GET" action="{{ route('admin.professional.requests') }}">
            <input type="hidden" name="search" id="export-search">
            <input type="hidden" name="specialization" id="export-specialization">
            <input type="hidden" name="start_date" id="export-start-date">
            <input type="hidden" name="end_date" id="export-end-date">
            <input type="hidden" name="export" id="export-type">
        </form>

        <!-- Loader Overlay -->
        <div id="loader-overlay" style="display:none;position:fixed;top:0;left:0;width:100vw;height:100vh;z-index:9999;background:rgba(255,255,255,0.7);backdrop-filter:blur(2px);align-items:center;justify-content:center;">
            <div style="text-align:center;">
                <div class="spinner-border text-primary" style="width:3rem;height:3rem;" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
                <div style="margin-top:1rem;font-weight:500;color:#333;font-size:1.2rem;">Processing...</div>
            </div>
        </div>

        <!-- Professionals Table -->
        <div class="row">
            <div class="col-xxl-12 col-xl-12">
                <div class="card custom-card">
                    <div class="card-header justify-content-between">
                        <div class="card-title">
                            Total Professionals
                        </div>
                        <div>
                            <span class="badge bg-primary">{{ $requestedProfessionals->count() }} Professionals</span>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table text-nowrap">
                                <thead>
                                    <tr>
                                        <th><input class="form-check-input check-all" type="checkbox" id="all-professionals" aria-label="..."></th>
                                        <th scope="col">Sl.No</th>
                                        <th scope="col">Professional Name</th>
                                        <th scope="col">Email</th>
                                        <th scope="col">Specialization</th>
                                        <th scope="col">Created At</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Type</th>
                                        <th scope="col">Reason of rejection</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                
                                <tbody>
                                    @forelse ($requestedProfessionals as $professional)
                                        <tr class="professional-list">
                                            <td class="professional-checkbox">
                                                <input class="form-check-input" type="checkbox" value="{{ $professional->id }}" aria-label="...">
                                            </td>
                                            <td>
                                                <span class="fw-medium">{{ $loop->iteration }}</span>
                                            </td>
                                            <td>
                                                <span class="fw-medium">{{ $professional->name }}</span>
                                            </td>
                                            <td>
                                                <span class="fw-medium">{{ $professional->email }}</span>
                                            </td>
                                            <td>
                                                <!-- Specialization Column -->
                                                @if($professional->profile && $professional->profile->specialization)
                                                    <span class="specialization-badge">{{ $professional->profile->specialization }}</span>
                                                @else
                                                    <span class="text-muted">Not specified</span>
                                                @endif
                                            </td>
                                            <td>
                                                <span class="fw-medium">{{ $professional->created_at->format('d/m/Y') }}</span>
                                            </td>
                                            <td>
                                                @if($professional->status == 'approved')
                                                    <span class="badge bg-success">Approved</span>
                                                @elseif($professional->status == 'pending')
                                                    <span class="badge bg-warning">Pending</span>
                                                @elseif($professional->status == 'rejected')
                                                    <span class="badge bg-danger">Rejected</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($professional->professionalRejection->first())
                                                    <span class="badge bg-danger">Rejected</span>
                                                @else
                                                    <span class="badge bg-primary">New Application</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($professional->professionalRejection->first())
                                                    <span class="fw-medium">{{ $professional->professionalRejection->first()->reason }}</span>
                                                @else
                                                    <span class="fw-medium">New application - No reason</span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="d-flex gap-2 items-center">
                                                    <button class="btn btn-success btn-sm approve-btn" data-id="{{ $professional->id }}" data-url="{{ route('admin.professional.requests.approve', $professional->id) }}" data-bs-toggle="tooltip" title="Accept">
                                                        <i class="fas fa-check"></i> Accept
                                                    </button>
                                                    <!-- Reject Button -->
                                                    <button type="button"
                                                            class="btn btn-danger btn-sm reject-btn"
                                                            data-id="{{ $professional->id }}"
                                                            data-name="{{ $professional->name }}"
                                                            data-url="{{ route('admin.professional.requests.reject', $professional->id) }}"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#rejectModal"
                                                            title="Reject">
                                                        <i class="fas fa-times"></i> Reject
                                                    </button>
                                                

                                                    <a href="{{ route('admin.manage-professional.show', $professional->id) }}" class="btn btn-primary btn-sm" data-bs-toggle="tooltip" data-bs-title="view">
                                                        <i class="fas fa-eye"></i> View
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="10" class="text-center">
                                                <div class="py-4">
                                                    <h5 class="mb-0 text-muted">No Pending Professionals Found.</h5>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer border-top-0">
                        <!-- Pagination (if needed) -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Rejection Modal -->
<div class="modal fade" id="rejectModal" tabindex="-1" aria-labelledby="rejectModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form id="rejectForm" method="POST">
            @csrf
            <input type="hidden" name="_method" value="POST">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="rejectModalLabel">Rejection Reason</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p><strong id="professionalName"></strong> rejected for which reason?</p>
                    <div class="form-group">
                        <textarea name="reason" id="reason" class="form-control" rows="3" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-danger">Reject</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script>
  // Loader functions
  function showLoader() {
    document.getElementById('loader-overlay').style.display = 'flex';
  }
  function hideLoader() {
    document.getElementById('loader-overlay').style.display = 'none';
  }

  $(document).on('click', '.approve-btn', function(e) {
    e.preventDefault();
    showLoader();
    var button = $(this);
    var url = button.data('url');
    var id = button.data('id'); 
    $.ajax({
        type: 'POST',
        url: url,
        data: {
            _token: '{{ csrf_token() }}',
            id: id
        },
        success: function(response) {
            hideLoader();
            if(response.status === 'success') {
                toastr.success(response.message); 
                setTimeout(function() {
                    window.location.reload();
                }, 1500);
            } else {
                toastr.error("Something went wrong! Please try again.");
            }
        },
        error: function(xhr) {
            hideLoader();
            if (xhr.status === 422) {
                let errors = xhr.responseJSON.errors;
                $.each(errors, function(key, value) {
                    toastr.error(value[0]); 
                });
            } else {
                toastr.error(xhr.responseJSON.message || "Something went wrong. Please try again.");
            }
        }
    });
  });

  document.addEventListener('DOMContentLoaded', function () {
    const rejectButtons = document.querySelectorAll('.reject-btn');
    const form = document.getElementById('rejectForm');
    const reasonField = document.getElementById('reason');
    const nameField = document.getElementById('professionalName');
    let currentUrl = ''; 
    rejectButtons.forEach(button => {
        button.addEventListener('click', function () {
            const id = this.getAttribute('data-id');
            const name = this.getAttribute('data-name');
            const url = this.getAttribute('data-url');
            currentUrl = url;
            form.setAttribute('action', url);
            nameField.textContent = name;
            reasonField.value = ''; 
        });
    });
    form.addEventListener('submit', function (e) {
        e.preventDefault();
        showLoader();
        const formData = new FormData(form);
        fetch(currentUrl, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                'Accept': 'application/json'
            },
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            hideLoader();
            if (data.status === 'success') {
                toastr.success(data.message);
                const rejectModal = new bootstrap.Modal(document.getElementById('rejectModal'));
                rejectModal.hide();
                setTimeout(() => {
                    location.reload();
                }, 1500);
            } else {
                toastr.error(data.message || 'Something went wrong!');
            }
        })
        .catch(error => {
            hideLoader();
            console.error('Error:', error);
            toastr.error('Server error occurred!');
        });
    });
  });

// Export functionality
function exportData(type) {
    // Copy current filter values to the export form
    document.getElementById('export-search').value = document.getElementById('searchInput')?.value || '';
    document.getElementById('export-specialization').value = document.getElementById('specializationFilter')?.value || '';
    document.getElementById('export-start-date').value = document.getElementById('start_date')?.value || '';
    document.getElementById('export-end-date').value = document.getElementById('end_date')?.value || '';
    document.getElementById('export-type').value = type;
    document.getElementById('export-form').submit();
    setTimeout(() => {
        document.getElementById('export-type').value = '';
    }, 100);
}
</script>
<script>
    flatpickr("#start_date", {
      dateFormat: "d-m-Y",  
      altInput: true,  
      altFormat: "d-m-Y", 
    });

    flatpickr("#end_date", {
      dateFormat: "d-m-Y", 
      altInput: true,  
      altFormat: "d-m-Y", 
    });
</script>
@endsection
