@extends('customer.layout.layout')

@section('styles')
<link rel="stylesheet" href="{{ asset('customer-css/assets/css/upcoming-appointment.css') }}" />
<style>
     .search-container {
        background: #f5f7fa;
        padding: 20px;
        border-radius: 10px;
        margin-bottom: 20px;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
    }

    .search-form {
        display: flex;
        flex-wrap: wrap;
        gap: 15px;
        align-items: flex-end;
    }

    .search-form .form-group {
        flex: 1;
        min-width: 200px;
        display: flex;
        flex-direction: column;
    }

    .search-form label {
        margin-bottom: 5px;
        font-weight: 600;
        color: #333;
    }

    .search-form input[type="text"],
    .search-form input[type="date"] {
        padding: 10px;
        border-radius: 6px;
        border: 1px solid #ccc;
        font-size: 14px;
    }

    .search-buttons {
        display: flex;
        gap: 10px;
    }

    .search-buttons button,
    .search-buttons a {
        padding: 10px 20px;
        font-size: 14px;
        border-radius: 6px;
        cursor: pointer;
        text-decoration: none;
        border: none;
    }

    .btn-success {
        background-color: #28a745;
        color: white;
    }

    .btn-secondary {
        background-color: #6c757d;
        color: white;
    }

    .btn-success:hover {
        background-color: #218838;
    }

    .btn-secondary:hover {
        background-color: #5a6268;
    }
    @media screen and (max-width: 767px) {
    /* Fix header to prevent horizontal scrolling */
    .page-header {
        position: sticky;
        top: 0;
        z-index: 10;
        background-color: #f8f9fa;
        padding-top: 10px;
        padding-bottom: 10px;
        width: 100%;
        max-width: 100vw;
        overflow-x: hidden;
    }
    
    /* Make table container scrollable horizontally */
    .table-wrapper {
        overflow-x: auto;
        max-width: 100%;
        -webkit-overflow-scrolling: touch; /* Better scrolling on iOS */
    }
    
    /* Ensure the table takes full width of container */
    .data-table {
        width: 100%;
        table-layout: auto;
    }
    
    /* Fix the search container from overflowing */
    .search-container {
        width: 100%;
        max-width: 100%;
        overflow-x: hidden;
    }
    
    /* Ensure content wrapper doesn't cause horizontal scroll */
    .content-wrapper {
        overflow-x: hidden;
        width: 100%;
        max-width: 100vw;
        padding: 20px 10px;
    }
    
    /* Fix card width */
    .card {
        width: 100%;
        overflow-x: hidden;
    }
    
    /* Ensure the card body doesn't cause overflow */
    .card-body {
        padding: 10px 5px;
    }
    
    /* Optional: Make some table columns width-responsive */
    .data-table th,
    .data-table td {
        white-space: nowrap;
    }
}

/* Modal Styles */
.custom-modal {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
    z-index: 1050;
    opacity: 0;
    transition: opacity 0.3s ease-in-out;
}

.custom-modal.show {
    opacity: 1;
}

.custom-modal-content {
    position: relative;
    background-color: #fff;
    margin: 10% auto;
    padding: 0;
    width: 90%;
    max-width: 500px;
    border-radius: 8px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
    transform: translateY(-20px);
    transition: transform 0.3s ease-in-out;
}

.custom-modal.show .custom-modal-content {
    transform: translateY(0);
}

.custom-modal-header {
    padding: 1rem;
    border-bottom: 1px solid #dee2e6;
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.custom-modal-title {
    margin: 0;
    font-size: 1.25rem;
    font-weight: 500;
    color: #333;
}

.custom-modal-close {
    background: none;
    border: none;
    font-size: 1.5rem;
    font-weight: 700;
    color: #666;
    cursor: pointer;
    padding: 0;
    line-height: 1;
}

.custom-modal-close:hover {
    color: #333;
}

.custom-modal-body {
    padding: 1.5rem;
}

.custom-modal-footer {
    padding: 1rem;
    border-top: 1px solid #dee2e6;
    display: flex;
    justify-content: flex-end;
    gap: 0.5rem;
}

.file-preview {
    margin-top: 1rem;
    padding: 0.75rem;
    background-color: #f8f9fa;
    border-radius: 4px;
}

.file-preview h6 {
    margin-bottom: 0.5rem;
    color: #495057;
}

/* Form Styles */
.form-label {
    font-weight: 500;
    color: #495057;
    margin-bottom: 0.5rem;
}

.form-control {
    border: 1px solid #ced4da;
    border-radius: 4px;
    padding: 0.5rem;
    width: 100%;
}

.form-text {
    font-size: 0.875rem;
    color: #6c757d;
    margin-top: 0.25rem;
}

/* Button Styles */
.btn {
    padding: 0.5rem 1rem;
    border-radius: 4px;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.2s ease-in-out;
}

.btn-primary {
    background-color: #007bff;
    border: 1px solid #007bff;
    color: #fff;
}

.btn-primary:hover {
    background-color: #0056b3;
    border-color: #0056b3;
}

.btn-secondary {
    background-color: #6c757d;
    border: 1px solid #6c757d;
    color: #fff;
}

.btn-secondary:hover {
    background-color: #5a6268;
    border-color: #545b62;
}

/* Animation Classes */
.modal-fade-in {
    animation: fadeIn 0.3s ease-in-out;
}

.modal-fade-out {
    animation: fadeOut 0.3s ease-in-out;
}

@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(-20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes fadeOut {
    from {
        opacity: 1;
        transform: translateY(0);
    }
    to {
        opacity: 0;
        transform: translateY(-20px);
    }
}

@media only screen and (min-width: 768px) and (max-width: 1024px) {

         /* Fix header to prevent horizontal scrolling */
        .page-header {
            position: sticky;
            top: 0;
            z-index: 10;
            background-color: #f8f9fa;
            padding-top: 10px;
            padding-bottom: 10px;
            width: 100%;
            max-width: 100vw;
            overflow-x: hidden;
        }
        
        /* Make table container scrollable horizontally */
        .content-section {
            overflow-x: auto;
            max-width: 100%;
            -webkit-overflow-scrolling: touch; /* Better scrolling on iOS */
            padding: 10px;
        }
        
        /* Ensure the table takes full width of container */
        .table {
            width: 100%;
            min-width: 800px; /* Minimum width to ensure all columns are visible */
        }
        
        /* Fix the search container from overflowing */
        .search-container {
        width: 100%;
        max-width: 100%;
        overflow-x: hidden;
        padding: 15px;
    }
        
        /* Ensure content wrapper doesn't cause horizontal scroll */
        .content-wrapper {
            overflow-x: hidden;
            width: 100%;
            max-width: 100vw;
            padding: 15px 10px;
        }
        
        /* Make table columns width-responsive */
        .table th,
        .table td {
            white-space: nowrap;
            padding: 8px;
        }
        
        /* Adjust button sizes for mobile */
        .btn-sm {
            padding: 4px 8px;
            font-size: 12px;
        }
        
        /* Ensure modal content is properly sized on mobile */
        .custom-modal-content {
            width: 95%;
            margin: 10% auto;
            padding: 15px;
        }
    }

/* Mobile Responsive Styles */
@media (max-width: 576px) {
    .custom-modal-content {
        width: 95%;
        margin: 5% auto;
    }

    .custom-modal-header {
        padding: 0.75rem;
    }

    .custom-modal-body {
        padding: 1rem;
    }

    .custom-modal-footer {
        padding: 0.75rem;
    }
}
</style>
@endsection

@section('content')
<div class="content-wrapper">
    <!-- Page Header -->
    <div class="page-header">
        <div class="page-title">
            <h3>Upcoming Details of Your Appointments</h3>
        </div>
        <ul class="breadcrumb">
            <li>Home</li>
            <li class="active">upcoming-appointment</li>
        </ul>
    </div>
<div class="search-container">
    <form action="{{ route('user.upcoming-appointment.index') }}" method="GET" class="search-form">
        <div class="form-group">
            <label for="search_name">Search</label>
            <input type="text" name="search_name" id="search_name" value="{{ request('search_name') }}" placeholder="Search appointment">
        </div>

        <div class="form-group">
            <label for="search_date_from">From Date</label>
            <input type="date" name="search_date_from" value="{{ request('search_date_from') }}">
        </div>

        <div class="form-group">
            <label for="search_date_to">To Date</label>
            <input type="date" name="search_date_to" value="{{ request('search_date_to') }}">
        </div>

        <div class="search-buttons">
            <button type="submit" class="btn-success">Search</button>
            <a href="{{ route('user.upcoming-appointment.index') }}" class="btn-secondary">Reset</a>
        </div>
    </form>
</div>

    <div class="content-section">
        <div class="section-header">
            
            <button class="btn btn-primary">Add New Appointment</button>
        </div>
        <div class="table-wrapper">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>S.No</th>
                        <th>Date</th>
                        <th>Month</th>
                        <th>Day</th>
                        <th>Time</th>
                        <th>Professional Name</th>
                        <th>Service Category</th>
                        <th>Sessions Taken</th>
                        <th>Sessions Remaining</th>
                        <th>Meet Link</th>
                        <th>Upload document</th>
                        <th>Professional document</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($bookings as $index => $booking)
                        @php
                            // Filter for future timedates and get the first upcoming one
                            $upcomingTimedate = $booking->timedates->filter(function ($timedate) {
                                return \Carbon\Carbon::parse($timedate->date)->isFuture(); 
                            })->first(); 
                            
                            // Calculate sessions taken (completed sessions)
                            $sessionsTaken = $booking->timedates->where('status', 'completed')->count();
                            
                            // Get total booked sessions (actual number of sessions booked)
                            $totalSessions = $booking->timedates->count();
                            
                            // Calculate remaining sessions
                            $sessionsRemaining = $totalSessions - $sessionsTaken;
                        @endphp
            
                        @if ($upcomingTimedate)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ \Carbon\Carbon::parse($upcomingTimedate->date)->format('d-m-Y') }}</td>
                                <td>{{ \Carbon\Carbon::parse($upcomingTimedate->date)->format('F') }}</td>
                                <td>{{ \Carbon\Carbon::parse($upcomingTimedate->date)->format('D') }}</td>
                                <td>{{ $upcomingTimedate->time_slot}}</td>
                                <td>{{ $booking->professional->name }}</td>
                                <td>{{ $booking->service_name }}</td>
                                <td>{{ $sessionsTaken }}</td>
                                <td>{{ $sessionsRemaining }}</td>
                                <td><button class="btn btn-primary" style="padding: 4px 8px;"><a href="{{ $booking->meeting_link }}" style="color:white">Join</a></button></td>
                                <td>
                                    <div class="document-actions">
                                        @if($booking->customer_document)
                                            <a href="{{ asset('storage/' . $booking->customer_document) }}" 
                                               class="btn btn-sm btn-info" 
                                               target="_blank" 
                                               title="View Document">
                                                <i class="fas fa-file"></i>
                                            </a>
                                        @endif
                                        <button type="button" 
                                                class="btn btn-sm {{ $booking->customer_document ? 'btn-warning' : 'btn-primary' }} upload-btn" 
                                                data-booking-id="{{ $booking->id }}"
                                                title="{{ $booking->customer_document ? 'Update Document' : 'Upload Document' }}">
                                            <i class="fas {{ $booking->customer_document ? 'fa-edit' : 'fa-upload' }}"></i>
                                        </button>
                                    </div>
                                </td>
                                <td>
                                    @if($booking->professional_documents)
                                        @foreach(explode(',', $booking->professional_documents) as $document)
                                            <a href="{{ asset('storage/' . $document) }}" 
                                               class="btn btn-sm btn-info mb-1" 
                                               target="_blank" 
                                               title="View Professional Document">
                                                <i class="fas fa-file"></i>
                                            </a>
                                        @endforeach
                                    @else
                                        <span class="text-muted">No documents</span>
                                    @endif
                                </td>
                            </tr>
                        @endif
                    @endforeach
                </tbody>
            </table>
            
           
        </div>
    </div>
</div>

<!-- Custom Upload Modal -->
<div id="uploadModal" class="custom-modal">
    <div class="custom-modal-content">
        <div class="custom-modal-header">
            <h5 class="custom-modal-title">Upload Document</h5>
            <button type="button" class="custom-modal-close" onclick="closeModal('uploadModal')">&times;</button>
        </div>
        <div class="custom-modal-body">
            <form id="uploadForm" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="booking_id" id="bookingId">
                <div class="mb-3">
                    <label for="document" class="form-label">Select Document</label>
                    <input type="file" class="form-control" id="document" name="document" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png" required>
                    <div class="form-text">Supported formats: PDF, DOC, DOCX, JPG, JPEG, PNG (Max: 2MB)</div>
                </div>
                <div id="filePreview" class="file-preview" style="display: none;">
                    <h6>Selected File:</h6>
                    <p class="mb-0" id="selectedFileName"></p>
                </div>
            </form>
        </div>
        <div class="custom-modal-footer">
            <button type="button" class="btn btn-secondary" onclick="closeModal('uploadModal')">Cancel</button>
            <button type="button" class="btn btn-primary" id="uploadBtn">Upload</button>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const uploadForm = document.getElementById('uploadForm');
    const uploadBtn = document.getElementById('uploadBtn');
    const fileInput = document.getElementById('document');
    const filePreview = document.getElementById('filePreview');
    const selectedFileName = document.getElementById('selectedFileName');
    const modal = document.getElementById('uploadModal');

    // Modal functions
    window.openModal = function(modalId) {
        const modal = document.getElementById(modalId);
        modal.style.display = 'block';
        setTimeout(() => {
            modal.classList.add('show');
        }, 10);
        document.body.style.overflow = 'hidden';
    };

    window.closeModal = function(modalId) {
        const modal = document.getElementById(modalId);
        modal.classList.remove('show');
        setTimeout(() => {
            modal.style.display = 'none';
        }, 300);
        document.body.style.overflow = '';
    };

    // Close modal when clicking outside
    modal.addEventListener('click', function(event) {
        if (event.target === modal) {
            closeModal('uploadModal');
        }
    });

    // Prevent modal from closing when clicking inside the modal content
    document.querySelector('.custom-modal-content').addEventListener('click', function(event) {
        event.stopPropagation();
    });

    // Handle file input change
    fileInput.addEventListener('change', function() {
        if (this.files && this.files[0]) {
            selectedFileName.textContent = this.files[0].name;
            filePreview.style.display = 'block';
        } else {
            filePreview.style.display = 'none';
        }
    });

    // Handle upload button click
    document.querySelectorAll('.upload-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            document.getElementById('bookingId').value = this.dataset.bookingId;
            filePreview.style.display = 'none';
            uploadForm.reset();
            openModal('uploadModal');
        });
    });

    // Handle file upload
    uploadBtn.addEventListener('click', function() {
        const formData = new FormData(uploadForm);

        // Disable the upload button and show loading state
        uploadBtn.disabled = true;
        uploadBtn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Uploading...';

        fetch('/customer/upload-document', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                toastr.success(data.message);
                setTimeout(() => {
                    window.location.reload();
                }, 1500);
            } else {
                toastr.error(data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            toastr.error('Error uploading document');
        })
        .finally(() => {
            // Re-enable the upload button and restore original text
            uploadBtn.disabled = false;
            uploadBtn.innerHTML = 'Upload';
        });
    });
});
</script>
@endsection
