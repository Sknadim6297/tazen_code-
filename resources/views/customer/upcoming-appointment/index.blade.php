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
<<<<<<< Updated upstream

    .document-actions {
        display: flex;
        gap: 0.5rem;
        align-items: center;
    }
    .modal-body .document-info {
        padding: 1rem;
        background: #f8f9fa;
        border-radius: 0.5rem;
    }
    .document-info p {
        margin-bottom: 0.5rem;
    }
    .file-preview {
        margin-top: 1rem;
        padding: 1rem;
        border: 1px solid #dee2e6;
        border-radius: 0.5rem;
    }

    /* Custom Modal Styles */
    .custom-modal {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        z-index: 1000;
    }

    .custom-modal-content {
        position: relative;
        background-color: #fff;
        width: 90%;
        max-width: 500px;
        margin: 50px auto;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }

    .custom-modal-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }

    .custom-modal-title {
        font-size: 1.25rem;
        font-weight: 600;
        margin: 0;
    }

    .custom-modal-close {
        background: none;
        border: none;
        font-size: 1.5rem;
        cursor: pointer;
        padding: 0;
        color: #666;
    }

    .custom-modal-body {
        margin-bottom: 20px;
    }

    .custom-modal-footer {
        display: flex;
        justify-content: flex-end;
        gap: 10px;
    }

    /* Animation */
    .modal-fade-in {
        animation: fadeIn 0.3s ease-in-out;
    }

    .modal-fade-out {
        animation: fadeOut 0.3s ease-in-out;
    }

    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }

    @keyframes fadeOut {
        from { opacity: 1; }
        to { opacity: 0; }
    }
=======
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
>>>>>>> Stashed changes
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
        <table>
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

    // Modal functions
    window.openModal = function(modalId) {
        const modal = document.getElementById(modalId);
        modal.style.display = 'block';
        modal.classList.add('modal-fade-in');
        document.body.style.overflow = 'hidden';
    };

    window.closeModal = function(modalId) {
        const modal = document.getElementById(modalId);
        modal.classList.add('modal-fade-out');
        setTimeout(() => {
            modal.style.display = 'none';
            modal.classList.remove('modal-fade-out', 'modal-fade-in');
            document.body.style.overflow = '';
        }, 300);
    };

    // Close modal when clicking outside
    window.addEventListener('click', function(event) {
        if (event.target.classList.contains('custom-modal')) {
            closeModal(event.target.id);
        }
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
