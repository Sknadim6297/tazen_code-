@extends('admin.layouts.layout')
@section('style')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" />
<style>
    .filter-row {
        display: flex;
        gap: 10px;
        align-items: flex-end;
        flex-wrap: wrap;
        margin-bottom: 20px;
    }
    
    .filter-item {
        flex: 1;
        min-width: 200px;
    }
    
    .filter-actions {
        display: flex;
        gap: 10px;
    }
    
    .export-buttons {
        margin-left: auto;
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
        .filter-row {
            flex-direction: column;
            gap: 15px;
        }
        
        .filter-item, .filter-actions {
            width: 100%;
        }
        
        .filter-actions button {
            flex: 1;
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

        <!-- Search and Filters -->
        <form action="{{ route('admin.professional.requests') }}" method="GET" id="filter-form">
            <div class="filter-row">
                <div class="filter-item">
                    <label class="form-label">Search</label>
                    <input type="search" name="search" class="form-control" id="autoComplete" placeholder="Search by name or email" value="{{ request('search') }}">
                </div>
                
                <div class="filter-item">
                    <label class="form-label">Specialization</label>
                    <select name="specialization" class="form-select">
                        <option value="">All Specializations</option>
                        @foreach($specializations as $specialization)
                            <option value="{{ $specialization }}" {{ request('specialization') == $specialization ? 'selected' : '' }}>
                                {{ $specialization }}
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <div class="filter-item">
                    <label class="form-label">Date Range</label>
                    <div class="input-group">
                        <div class="input-group-text text-muted"><i class="ri-calendar-line"></i></div>
                        <input type="date" class="form-control" placeholder="Start Date" name="start_date" id="start_date" value="{{ request('start_date') }}">
                        <span class="input-group-text">to</span>
                        <input type="date" class="form-control" placeholder="End Date" name="end_date" id="end_date" value="{{ request('end_date') }}">
                    </div>
                </div>
                
                <div class="filter-actions">
                    <button type="submit" class="btn btn-primary">Search</button>
                    <a href="{{ route('admin.professional.requests') }}" class="btn btn-secondary">Reset</a>
                    
                    <!-- Export Buttons -->
                    <div class="export-buttons">
                        <button type="button" class="export-btn export-btn-excel" onclick="exportData('excel')">
                            <i class="fas fa-file-excel"></i> Export Excel
                        </button>
                        <button type="button" class="export-btn export-btn-pdf" onclick="exportData('pdf')">
                            <i class="fas fa-file-pdf"></i> Export PDF
                        </button>
                    </div>
                </div>
            </div>
            <!-- Hidden field for export type -->
            <input type="hidden" name="export" id="export-type">
        </form>

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
  $(document).on('click', '.approve-btn', function(e) {
    e.preventDefault();

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
            console.error('Error:', error);
            toastr.error('Server error occurred!');
        });
    });
});

// Export functionality
function exportData(type) {
    // Create a new form
    const form = document.getElementById('filter-form');
    
    // Set export type
    document.getElementById('export-type').value = type;
    
    // Submit the form
    form.submit();
    
    // Reset the export type after submission
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
