@extends('professional.layout.layout')

@section('styles')
<style>
    /* Core layout styles */
    .content-wrapper {
        background: linear-gradient(135deg, #f8fafc 0%, #e9ecef 100%);
        padding: 2rem 1rem;
        min-height: calc(100vh - 60px);
        border-radius: 18px;
        box-shadow: 0 8px 32px rgba(0,0,0,0.07);
    }
    .page-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 1.5rem 2rem;
        border-radius: 15px;
        margin-bottom: 2rem;
        box-shadow: 0 8px 25px rgba(102, 126, 234, 0.10);
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
    .breadcrumb li:not(:last-child)::after {
        content: '>';
        margin-left: 0.5rem;
        opacity: 0.7;
    }
    .breadcrumb li.active {
        font-weight: 600;
    }
    .search-container {
        background: #fff;
        padding: 1.5rem 1rem;
        border-radius: 12px;
        margin-bottom: 2rem;
        box-shadow: 0 2px 8px rgba(0,0,0,0.06);
    }
    .search-form {
        display: flex;
        flex-wrap: wrap;
        gap: 1rem;
    }
    .search-form .form-group {
        flex: 1 1 180px;
        min-width: 180px;
    }
    .search-form label {
        font-weight: 600;
        color: #4a5568;
        margin-bottom: 0.5rem;
        display: block;
    }
    .search-form select,
    .search-form input {
        width: 100%;
        padding: 0.6rem 0.9rem;
        border: 2px solid #e2e8f0;
        border-radius: 8px;
        background: #f8f9fa;
        font-size: 0.95rem;
        transition: all 0.3s;
    }
    .search-form select:focus,
    .search-form input:focus {
        border-color: #667eea;
        background: #fff;
        outline: none;
    }
    .search-buttons {
        display: flex;
        gap: 0.75rem;
        align-items: flex-end;
    }
    .btn-success, .btn-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border: none;
        border-radius: 8px;
        padding: 0.6rem 1.5rem;
        font-size: 1rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s;
        box-shadow: 0 2px 8px rgba(102, 126, 234, 0.10);
    }
    .btn-success:hover, .btn-primary:hover {
        background: linear-gradient(135deg, #764ba2 0%, #667eea 100%);
        color: #fff;
        transform: translateY(-2px);
    }
    .btn-secondary {
        background: #6c757d;
        color: white;
        border: none;
        border-radius: 8px;
        padding: 0.6rem 1.5rem;
        font-size: 1rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s;
    }
    .btn-secondary:hover {
        background: #5a6268;
        color: #fff;
        transform: translateY(-2px);
    }
    .btn-info {
        background: #17a2b8;
        color: white;
        border: none;
        border-radius: 8px;
        padding: 0.4rem 1rem;
        font-size: 0.95rem;
        cursor: pointer;
        font-weight: 600;
    }
    .btn-link {
        background: #007bff;
        color: white;
        text-decoration: none;
        border-radius: 8px;
        padding: 0.4rem 1rem;
        font-size: 0.95rem;
        display: inline-block;
        font-weight: 600;
    }
    .btn-info:hover { background: #138496; }
    .btn-link:hover { background: #0069d9; }
    .badge {
        display: inline-block;
        padding: 0.35rem 0.8rem;
        font-size: 0.85rem;
        font-weight: 600;
        border-radius: 1rem;
        text-transform: uppercase;
        letter-spacing: 0.03em;
    }
    .bg-success { background: linear-gradient(135deg, #28a745 0%, #43e97b 100%) !important; color: white; }
    .bg-warning { background: linear-gradient(135deg, #ffc107 0%, #ffb347 100%) !important; color: #212529; }
    .card {
        background: #fff;
        border-radius: 15px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.08);
        margin-bottom: 2rem;
        overflow: hidden;
        animation: fadeInUp 0.6s ease-out;
    }
    .card-body {
        padding: 2rem 1.5rem;
    }
    
    /* Table scrolling styles */
    .table-responsive-container {
        width: 100%;
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
        border-radius: 10px;
        margin-bottom: 1rem;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
    }
    
    .table-responsive-container::-webkit-scrollbar {
        height: 8px;
        background-color: #f5f5f5;
    }
    
    .table-responsive-container::-webkit-scrollbar-thumb {
        background-color: #667eea;
        border-radius: 4px;
    }
    
    .table-responsive-container::-webkit-scrollbar-track {
        background-color: #f5f5f5;
        border-radius: 4px;
    }
    
    .data-table {
        width: 100%;
        min-width: 1200px;
        border-collapse: separate;
        border-spacing: 0;
        margin-bottom: 0;
    }
    
    .data-table th {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        font-weight: 700;
        border: none;
        padding: 1rem;
        white-space: nowrap;
    }
    .data-table td {
        padding: 1rem;
        border-bottom: 1px solid #f1f5f9;
        vertical-align: middle;
        background: #fff;
    }
    .data-table tbody tr:hover {
        background: #f8f9fa;
        transform: scale(1.01);
        transition: all 0.3s ease;
    }
    .document-preview {
        display: inline-flex;
        align-items: center;
        padding: 0.5rem 0.75rem;
        margin: 0.25rem;
        background-color: #f8f9fa;
        border: 1px solid #dee2e6;
        border-radius: 0.375rem;
        transition: all 0.2s;
        text-decoration: none;
    }
    .document-preview:hover {
        background-color: #e9ecef;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
    .document-preview img {
        width: 24px;
        height: 24px;
        margin-right: 0.5rem;
    }
    .doc-info {
        display: flex;
        flex-direction: column;
    }
    .doc-name {
        font-size: 0.75rem;
        color: #495057;
        max-width: 150px;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }
    .doc-type {
        font-size: 0.625rem;
        color: #6c757d;
    }
    .no-doc-message {
        color: #6c757d;
        font-style: italic;
        padding: 0.625rem;
        text-align: center;
        background-color: #f8f9fa;
        border-radius: 0.375rem;
        border: 1px dashed #dee2e6;
    }
    /* Modal styles */
    .custom-modal, .upload-modal {
        display: none;
        position: fixed;
        z-index: 9999;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgba(0, 0, 0, 0.5);
    }
    .custom-modal-content, .upload-modal-content {
        background-color: #fff;
        margin: 5% auto;
        padding: 2rem 1.5rem;
        border-radius: 0.5rem;
        width: 95%;
        max-width: 700px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        position: relative;
    }
    .close-modal, .close-upload-modal {
        color: #aaa;
        position: absolute;
        right: 1.25rem;
        top: 1rem;
        font-size: 1.5rem;
        font-weight: bold;
        cursor: pointer;
    }
    .close-modal:hover, .close-upload-modal:hover { color: #000; }
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
    /* Responsive styles */
    @media (max-width: 991px) {
        .content-wrapper {
            padding: 1rem 0.5rem;
        }
        .page-header {
            padding: 1rem 1rem;
            flex-direction: column;
            align-items: flex-start;
        }
        .search-form {
            flex-direction: column;
            gap: 0.75rem;
        }
        .search-form .form-group {
            width: 100%;
        }
        .search-buttons {
            flex-direction: column;
            width: 100%;
        }
        .search-buttons button,
        .search-buttons a {
            width: 100%;
            margin-bottom: 0.5rem;
        }
        .card-body {
            padding: 1rem 0.5rem;
        }
        .custom-modal-content, .upload-modal-content {
            width: 99%;
            margin: 5% auto;
            padding: 1rem;
        }
        .data-table {
            min-width: 1100px;
        }
    }
    @media (max-width: 767px) {
        .table-responsive-container {
            border-left: 1px solid #dee2e6;
            border-right: 1px solid #dee2e6;
        }
    }
    @media (max-width: 600px) {
        .content-wrapper {
            padding: 0.5rem 0.2rem;
        }
        .page-header {
            padding: 0.7rem 0.5rem;
        }
        .card-body {
            padding: 0.5rem 0.2rem;
        }
        .custom-modal-content, .upload-modal-content {
            padding: 0.5rem;
        }
    }
</style>
@endsection

@section('content')
<div class="content-wrapper">
    <div class="page-header">
        <div class="page-title">
            <h3>All Bookings</h3>
        </div>
        <ul class="breadcrumb">
            <li>Home</li>
            <li class="active">All Bookings</li>
        </ul>
    </div>
    <div class="search-container">
        <form action="{{ route('professional.booking.index') }}" method="GET" class="search-form">
            <div class="form-group">
                <label for="plan_type">Plan Type</label>
                <select name="plan_type" id="plan_type">
                    <option value="">-- Select Plan --</option>
                    @foreach($planTypes as $type)
                        <option value="{{ $type }}" {{ request('plan_type') == $type ? 'selected' : '' }}>
                            {{ ucfirst(str_replace('_', ' ', $type)) }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="status">Status</label>
                <select name="status" id="status" class="form-control">
                    <option value="">All Status</option>
                    <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                </select>
            </div>
            <div class="form-group">
                <label for="search_name">Search</label>
                <input type="text" name="search_name" id="search_name" value="{{ request('search_name') }}" placeholder="Customer or Service Name">
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
                <a href="{{ route('professional.booking.index') }}" class="btn-secondary">Reset</a>
            </div>
        </form>
    </div>
    <div class="card">
        <div class="card-body">
            @if($bookings->isEmpty())
                <div class="text-center py-5 text-muted">
                    <p>No bookings available at the moment.</p>
                </div>
            @else
                <div class="table-responsive-container">
                    <table class="data-table table table-bordered">
                        <thead>
                            <tr>
                                <th>Customer Name</th>
                                <th>Plan Type</th>
                                <th>Service Name</th>
                                <th>Month</th>
                                <th>Days</th>
                                <th>Time Slot</th>
                                <th>Booking Date</th>
                                <th>Meeting Link</th>
                                <th>Details</th>
                                <th>Status</th>
                                <th>Admin Remarks</th>
                                <th>Upload Documents (PDF)</th>
                                <th>Customer Document</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($bookings as $booking)
                            @php
                                $earliestTimedate = $booking->timedates && $booking->timedates->count() > 0 
                                    ? $booking->timedates
                                        ->filter(function($timedate) {
                                            return \Carbon\Carbon::parse($timedate->date)->isFuture();
                                        })
                                        ->sortBy('date')
                                        ->first()
                                    : null;
                            @endphp
                            
                            <tr>
                                <td>
                                    {{ $booking->customer_name }}
                                    <button class="btn btn-info btn-sm questionnaire-info" 
                                            data-booking-id="{{ $booking->id }}" 
                                            title="View Questionnaire Answers">
                                        <i class="fas fa-info-circle"></i>
                                    </button>
                                </td>
                                <td>{{ $booking->plan_type }}</td>
                                <td>{{ $booking->service_name }}</td>
                                <td>{{ $earliestTimedate ? \Carbon\Carbon::parse($earliestTimedate->date)->format('F') : '-' }}</td>
                                <td>{{ $earliestTimedate ? \Carbon\Carbon::parse($earliestTimedate->date)->format('d M Y') : '-' }}</td>
                                <td>{!! $earliestTimedate ? str_replace(',', '<br>', $earliestTimedate->time_slot) : '-' !!}</td>         
                                <td>{{ \Carbon\Carbon::parse($booking->booking_date)->format('d-m-Y') }}</td>
                                <td>
                                    @if($booking->meeting_link)
                                        <a href="{{ $booking->meeting_link }}" class="btn btn-link" target="_blank">
                                            Join Meeting
                                        </a>
                                    @elseif($booking->timedates && $booking->timedates->count() > 0 && $booking->timedates->first()->meeting_link)
                                        <a href="{{ $booking->timedates->first()->meeting_link }}" class="btn btn-link" target="_blank">
                                            Join Meeting
                                        </a>
                                    @else
                                        <span class="badge bg-warning">Meeting link not given by admin</span>
                                    @endif
                                </td>
                                <td>
                                    <button class="btn btn-info btn-sm view-details"
                                        data-booking-id="{{ $booking->id }}">
                                        View
                                    </button>
                                </td>
                                <td>
                                    @php
                                        $allSlots = $booking->timedates;
                                        $allCompleted = $allSlots->count() > 0 && $allSlots->every(function($timedate) {
                                            return $timedate->status === 'completed';
                                        });
                                    @endphp
                                    <span class="badge {{ $allCompleted ? 'bg-success' : 'bg-warning' }}">
                                        {{ $allCompleted ? 'Completed' : 'Pending' }}
                                    </span>
                                </td>
                                <td>{{ $booking->remarks ?? 'No remarks' }}</td>
                                <td>
                                    <div class="d-flex flex-wrap gap-2">
                                        @if ($booking->professional_documents)
                                            @php
                                                $doc = $booking->professional_documents;
                                                $extension = pathinfo($doc, PATHINFO_EXTENSION);
                                                $fileName = basename($doc);
                                                $icon = match(strtolower($extension)) {
                                                    'pdf' => 'pdf',
                                                    'doc', 'docx' => 'word',
                                                    'jpg', 'jpeg', 'png' => 'image',
                                                    default => 'file'
                                                };
                                            @endphp
                                            <a href="{{ asset('storage/' . $doc) }}" 
                                               class="document-preview" 
                                               target="_blank"
                                               title="View {{ $fileName }}">
                                                <img src="{{ asset('images/' . $icon . '-icon.png') }}" 
                                                     alt="{{ strtoupper($extension) }}">
                                                <div class="doc-info">
                                                    <span class="doc-name">{{ $fileName }}</span>
                                                    <span class="doc-type">{{ strtoupper($extension) }} Document</span>
                                                </div>
                                            </a>
                                        @endif
                                        <button class="btn btn-sm btn-primary upload-btn" 
                                                onclick="openUploadModal('{{ $booking->id }}')"
                                                title="Upload/Update Document">
                                            <i class="fas fa-{{ $booking->professional_documents ? 'sync' : 'upload' }}"></i>
                                            {{ $booking->professional_documents ? 'Update' : 'Upload' }}
                                        </button>
                                    </div>
                                </td>
                                <td>
                                    @if ($booking->customer_document)
                                        @php
                                            $customerDocs = explode(',', $booking->customer_document);
                                        @endphp
                                        <div class="d-flex flex-wrap gap-2">
                                            @foreach ($customerDocs as $doc)
                                                @php
                                                    $extension = pathinfo($doc, PATHINFO_EXTENSION);
                                                    $fileName = basename($doc);
                                                    $icon = match(strtolower($extension)) {
                                                        'pdf' => 'pdf',
                                                        'doc', 'docx' => 'word',
                                                        'jpg', 'jpeg', 'png' => 'image',
                                                        default => 'file'
                                                    };
                                                @endphp
                                                <a href="{{ asset('storage/' . $doc) }}" 
                                                   class="document-preview" 
                                                   target="_blank"
                                                   title="View {{ $fileName }}">
                                                    <img src="{{ asset('images/' . $icon . '-icon.png') }}" 
                                                         alt="{{ strtoupper($extension) }}">
                                                    <div class="doc-info">
                                                        <span class="doc-name">{{ $fileName }}</span>
                                                        <span class="doc-type">{{ strtoupper($extension) }} Document</span>
                                                    </div>
                                                </a>
                                            @endforeach
                                        </div>
                                    @else
                                        <div class="no-doc-message">
                                            <i class="fas fa-file-alt me-2"></i>
                                            No documents provided
                                        </div>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Custom Modal -->
<div id="bookingDetailModal" class="custom-modal">
    <div class="custom-modal-content">
        <span class="close-modal">&times;</span>
        <h4>Booking Details</h4>
        <table class="table table-bordered" id="details-table">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Time Slot</th>
                    <th>Remarks</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>
</div>

<!-- Questionnaire Modal -->
<div id="questionnaireModal" class="custom-modal">
    <div class="custom-modal-content">
        <span class="close-modal" id="closeQuestionnaireModal">&times;</span>
        <h4>Questionnaire Answers</h4>
        <div id="questionnaireContent">
            <!-- Content will be loaded here -->
        </div>
    </div>
</div>

<!-- Upload Modal -->
<div id="uploadModal" class="upload-modal">
    <div class="upload-modal-content">
        <span class="close-upload-modal">&times;</span>
        <div class="upload-modal-header">
            <h4>Upload Document</h4>
        </div>
        <form id="uploadForm" class="upload-form" enctype="multipart/form-data">
            @csrf
            <input type="hidden" id="booking_id" name="booking_id">
            <div class="form-group">
                <label for="document">Select PDF Document (Max 2MB)</label>
                <input type="file" name="document" id="document" accept=".pdf" required>
            </div>
            <button type="submit" class="btn-upload">Upload Document</button>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    const modal = document.getElementById('bookingDetailModal');
    const questionnaireModal = document.getElementById('questionnaireModal');
    const closeModal = document.querySelector('.close-modal');
    const closeQuestionnaireModal = document.getElementById('closeQuestionnaireModal');
    const tableBody = document.querySelector('#details-table tbody');
    const questionnaireContent = document.getElementById('questionnaireContent');

    // View details button click
    document.querySelectorAll('.view-details').forEach(button => {
        button.addEventListener('click', () => {
            const bookingId = button.dataset.bookingId;
            fetchBookingDetails(bookingId);
        });
    });

    // Fetch booking details from server
    function fetchBookingDetails(bookingId) {
        fetch(`/professional/bookings/${bookingId}/details`)
            .then(response => {
                if (!response.ok) throw new Error('Network response was not ok');
                return response.json();
            })
            .then(data => {
                populateTable(data.dates, bookingId);
                modal.style.display = 'block';
            })
            .catch(error => {
                console.error('Error fetching booking details:', error);
                alert('Something went wrong while fetching booking details.');
            });
    }

    // Populate the modal table
    function populateTable(dates, bookingId) {
        tableBody.innerHTML = '';

        dates.forEach(item => {
            item.time_slot.forEach(slot => {
                const isCompleted = item.status === 'completed';
                const isChecked = isCompleted ? 'checked' : '';
                const sliderClass = 'status-slider';
                const remarks = item.remarks || '';

                const row = `
                    <tr>
                        <td>${item.date}</td>
                        <td>${slot}</td>
                        <td>
                            <input type="text" class="form-control remark-input" value="${remarks}" 
                                   placeholder="Remarks">
                        </td>
                        <td>
                            <label class="${sliderClass}"
                                   data-booking-id="${bookingId}" 
                                   data-date="${item.date}" 
                                   data-slot="${slot}">
                                <input type="checkbox" class="status-checkbox" ${isChecked}>
                                <span class="slider"></span>
                            </label>
                            <span class="status-text">${isCompleted ? 'Completed' : 'Pending'}</span>
                        </td>
                    </tr>
                `;

                tableBody.insertAdjacentHTML('beforeend', row);
            });
        });

        attachCheckboxListeners();
    }

    // Attach change event to status checkboxes
    function attachCheckboxListeners() {
        document.querySelectorAll('.status-checkbox').forEach(checkbox => {
            checkbox.addEventListener('change', async (e) => {
                const label = checkbox.closest('.status-slider');
                const bookingId = label.dataset.bookingId;
                const date = label.dataset.date;
                const slot = label.dataset.slot;
                const remarks = checkbox.closest('tr').querySelector('.remark-input').value.trim();
                const status = checkbox.checked ? 'completed' : 'pending';

                // Check if remarks are empty and show confirmation
                if (!remarks) {
                    if (!confirm('Are you sure you want to proceed without adding any remarks?')) {
                        // If user cancels, revert the checkbox state
                        checkbox.checked = !checkbox.checked;
                        return;
                    }
                }

                // Send AJAX request to update status and remarks
                fetch('/professional/bookings/update-status', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        booking_id: bookingId,
                        date: date,
                        slot: slot,
                        remarks: remarks,
                        status: status
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        toastr.success(data.message);
                        // Update the UI to reflect the new status
                        const statusText = checkbox.closest('td').querySelector('.status-text');
                        statusText.textContent = status === 'completed' ? 'Completed' : 'Pending';
                        
                        // Keep remarks input always enabled
                        const remarksInput = checkbox.closest('tr').querySelector('.remark-input');
                        remarksInput.readOnly = false;
                        
                        // Keep slider always enabled
                        label.className = 'status-slider';
                    } else {
                        toastr.error(data.message);
                        // Revert the checkbox state
                        checkbox.checked = !checkbox.checked;
                    }
                })
                .catch(error => {
                    console.error('Error updating status:', error);
                    toastr.error('Failed to update status.');
                    // Revert the checkbox state
                    checkbox.checked = !checkbox.checked;
                });
            });
        });
    }

    // Handle questionnaire info button clicks
    document.querySelectorAll('.questionnaire-info').forEach(button => {
        button.addEventListener('click', () => {
            const bookingId = button.dataset.bookingId;
            fetchQuestionnaireAnswers(bookingId);
        });
    });

    // Fetch questionnaire answers
    function fetchQuestionnaireAnswers(bookingId) {
        fetch(`/professional/bookings/${bookingId}/questionnaire`)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    let html = `<div class="questionnaire-details">
                        <h5>Customer: ${data.booking_details.customer_name}</h5>
                        <h6>Service: ${data.booking_details.service_name}</h6>
                        <div class="answers-list">`;
                    
                    data.answers.forEach(item => {
                        html += `
                            <div class="answer-item">
                                <p class="question"><strong>Q:</strong> ${item.question}</p>
                                <p class="answer"><strong>A:</strong> ${item.answer}</p>
                            </div>
                        `;
                    });
                    
                    html += `</div></div>`;
                    questionnaireContent.innerHTML = html;
                } else {
                    questionnaireContent.innerHTML = `<p class="text-center text-muted">${data.message}</p>`;
                }
                questionnaireModal.style.display = 'block';
            })
            .catch(error => {
                console.error('Error fetching questionnaire answers:', error);
                questionnaireContent.innerHTML = '<p class="text-center text-danger">Error loading questionnaire answers.</p>';
                questionnaireModal.style.display = 'block';
            });
    }

    // Modal close handlers
    closeModal.addEventListener('click', () => modal.style.display = 'none');
    closeQuestionnaireModal.addEventListener('click', () => questionnaireModal.style.display = 'none');
    
    window.addEventListener('click', event => {
        if (event.target === modal) modal.style.display = 'none';
        if (event.target === questionnaireModal) questionnaireModal.style.display = 'none';
    });
});

// Upload modal functionality
const uploadModal = document.getElementById('uploadModal');
const closeUploadModal = document.querySelector('.close-upload-modal');
const uploadForm = document.getElementById('uploadForm');
const bookingIdInput = document.getElementById('booking_id');

function openUploadModal(bookingId) {
    bookingIdInput.value = bookingId;
    uploadModal.style.display = 'block';
}

closeUploadModal.onclick = function() {
    uploadModal.style.display = 'none';
}

window.onclick = function(event) {
    if (event.target == uploadModal) {
        uploadModal.style.display = 'none';
    }
}

uploadForm.onsubmit = function(e) {
    e.preventDefault();
    const formData = new FormData(uploadForm);
    const bookingId = bookingIdInput.value;
    
    // Get the file input and check if a file is selected
    const fileInput = document.getElementById('document');
    if (fileInput.files.length === 0) {
        toastr.error('Please select a file to upload');
        return;
    }

    // Add the single file to formData
    formData.append('document', fileInput.files[0]);

    fetch(`/professional/bookings/${bookingId}/upload-documents`, {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            toastr.success(data.message);
            uploadModal.style.display = 'none';
            location.reload(); 
        } else {
            toastr.error(data.message || 'Upload failed');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        toastr.error('An error occurred while uploading');
    });
};
</script>
@endsection