@extends('admin.layouts.layout')

@section('style')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" />
<style>
    .export-buttons .dropdown-toggle {
        border-radius: 6px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
    .export-buttons .dropdown-menu {
        border-radius: 8px;
        box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        border: 1px solid #e3e6f0;
    }
    .export-buttons .dropdown-item {
        padding: 10px 16px;
        transition: all 0.3s ease;
    }
    .export-buttons .dropdown-item:hover {
        background-color: #f8f9fc;
        transform: translateX(3px);
    }
    .export-buttons .dropdown-item i {
        margin-right: 8px;
        width: 16px;
    }
</style>
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
         <form id="customer-filter-form" action="{{ route('admin.manage-customer.index') }}" method="GET" class="d-flex gap-2">
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
                        <div class="export-buttons">
                            <div class="btn-group" role="group">
                                <button type="button" class="btn btn-success btn-sm dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="ri-download-line"></i> Export
                                </button>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a class="dropdown-item" href="#" onclick="exportData('excel')">
                                            <i class="ri-file-excel-line text-success"></i> Export to Excel
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="#" onclick="exportData('pdf')">
                                            <i class="ri-file-pdf-line text-danger"></i> Export to PDF
                                        </a>
                                    </li>
                                </ul>
                            </div>
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
                                        <th scope="col">Phone</th>
                                        <th scope="col">Send Email</th>
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
                                            <td>{{ $user->phone ?? 'N/A' }}</td>
                                            <td>
                                                <button type="button" class="btn btn-sm btn-info send-email-btn" 
                                                    data-email="{{ $user->email }}" 
                                                    data-name="{{ $user->name }}"
                                                    data-type="customer"
                                                    title="Send Email">
                                                    <i class="ri-mail-send-line"></i> Email
                                                </button>
                                            </td>
                                            <td>{{ $user->created_at->format('d M, Y') }}</td>
                                            <td>
                                                <a href="{{ route('admin.manage-customer.show', $user->id) }}" class="btn btn-success-light btn-icon btn-sm" data-bs-toggle="tooltip" title="View">
                                                    <i class="ri-eye-line"></i>
                                                </a>
                                                {{-- TEMPORARILY DISABLED - Admin Chat with Customer --}}
                                                {{-- <button type="button" class="btn btn-info-light btn-icon btn-sm ms-1 chat-btn" 
                                                        data-participant-type="user" 
                                                        data-participant-id="{{ $user->id }}" 
                                                        data-bs-toggle="tooltip" 
                                                        title="Chat">
                                                    <i class="ri-message-3-line"></i>
                                                </button> --}}
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

<!-- Email Modal -->
<div class="modal fade" id="emailModal" tabindex="-1" aria-labelledby="emailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="emailModalLabel">
                    <i class="ri-mail-send-line me-2"></i>Send Email to Customer
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="emailForm">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="recipientName" class="form-label">Recipient Name</label>
                        <input type="text" class="form-control" id="recipientName" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="recipientEmail" class="form-label">Recipient Email</label>
                        <input type="email" class="form-control" id="recipientEmail" name="recipient_email" readonly>
                    </div>
                    <input type="hidden" id="recipientType" name="recipient_type">
                    <div class="mb-3">
                        <label for="emailSubject" class="form-label">Subject <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="emailSubject" name="subject" required placeholder="Enter email subject">
                    </div>
                    <div class="mb-3">
                        <label for="emailMessage" class="form-label">Message <span class="text-danger">*</span></label>
                        <textarea class="form-control" id="emailMessage" name="message" rows="8" required placeholder="Enter your message here..."></textarea>
                    </div>
                    <div class="alert alert-info">
                        <i class="ri-information-line me-2"></i>
                        <strong>Note:</strong> This email will be sent from the admin email address configured in your system.
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="ri-close-line me-1"></i>Cancel
                    </button>
                    <button type="submit" class="btn btn-primary" id="sendEmailBtn">
                        <i class="ri-send-plane-fill me-1"></i>Send Email
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
<script>
    $(document).ready(function() {
        // Handle Send Email button click
        $(document).on('click', '.send-email-btn', function() {
            const email = $(this).data('email');
            const name = $(this).data('name');
            const type = $(this).data('type');
            
            // Populate modal fields
            $('#recipientName').val(name);
            $('#recipientEmail').val(email);
            $('#recipientType').val(type);
            
            // Clear previous form data
            $('#emailSubject').val('');
            $('#emailMessage').val('');
            
            // Show modal
            $('#emailModal').modal('show');
        });

        // Handle Email Form Submission
        $('#emailForm').on('submit', function(e) {
            e.preventDefault();
            
            const submitBtn = $('#sendEmailBtn');
            const originalBtnText = submitBtn.html();
            
            // Get form data
            const formData = {
                recipient_email: $('#recipientEmail').val(),
                recipient_type: $('#recipientType').val(),
                subject: $('#emailSubject').val(),
                message: $('#emailMessage').val(),
                _token: $('meta[name="csrf-token"]').attr('content')
            };
            
            // Disable button and show loading state
            submitBtn.prop('disabled', true).html('<i class="ri-loader-4-line fa-spin me-1"></i>Sending...');
            
            $.ajax({
                url: '{{ route("admin.send-email") }}',
                method: 'POST',
                data: formData,
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        toastr.success(response.message || 'Email sent successfully!');
                        $('#emailModal').modal('hide');
                        $('#emailForm')[0].reset();
                    } else {
                        toastr.error(response.message || 'Failed to send email.');
                    }
                },
                error: function(xhr) {
                    let errorMsg = 'Failed to send email. Please try again.';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMsg = xhr.responseJSON.message;
                    } else if (xhr.responseJSON && xhr.responseJSON.errors) {
                        const errors = xhr.responseJSON.errors;
                        errorMsg = Object.values(errors).flat().join(', ');
                    }
                    toastr.error(errorMsg);
                },
                complete: function() {
                    // Restore button state
                    submitBtn.prop('disabled', false).html(originalBtnText);
                }
            });
        });
    });

    // Export function
    function exportData(format) {
        // Get current form data (search filters)
        const form = document.getElementById('customer-filter-form');
        const formData = new FormData(form);
        
        // Convert FormData to URL parameters
        const params = new URLSearchParams();
        for (let [key, value] of formData) {
            if (value) {
                params.append(key, value);
            }
        }
        
        // Construct export URL
        let exportUrl;
        if (format === 'excel') {
            exportUrl = '{{ route("admin.manage-customer.export.excel") }}';
        } else if (format === 'pdf') {
            exportUrl = '{{ route("admin.manage-customer.export.pdf") }}';
        }
        
        // Add parameters if any
        const queryString = params.toString();
        if (queryString) {
            exportUrl += '?' + queryString;
        }
        
        // Show loading message
        toastr.info('Preparing export... Please wait.');
        
        // Trigger download
        window.location.href = exportUrl;
    }
</script>
@endsection
