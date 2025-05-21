@extends('professional.layout.layout')

@section('styles')
<style>
    /* Questionnaire styles */
    .questionnaire-info {
        margin-left: 8px;
        padding: 2px 6px;
        font-size: 12px;
    }

    .questionnaire-details {
        padding: 15px;
    }

    .answers-list {
        margin-top: 20px;
    }

    .answer-item {
        background-color: #f8f9fa;
        border-radius: 8px;
        padding: 15px;
        margin-bottom: 15px;
    }

    .answer-item .question {
        color: #2c3e50;
        margin-bottom: 8px;
        font-size: 14px;
    }

    .answer-item .answer {
        color: #34495e;
        margin-bottom: 0;
        font-size: 14px;
        padding-left: 20px;
    }

   /* Style for the slider container */
.status-slider {
    position: relative;
    display: inline-block;
    width: 60px;
    height: 30px;
    cursor: pointer;
}

.status-slider.disabled {
    cursor: not-allowed;
    opacity: 0.6;
}

/* Hide the checkbox but keep its functionality */
.status-slider input {
    opacity: 0;
    width: 0;
    height: 0;
}

/* The slider track */
.status-slider .slider {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: #ccc;
    border-radius: 30px;
    transition: 0.4s;
}

/* The round toggle knob */
.status-slider .slider:before {
    content: "";
    position: absolute;
    height: 22px;
    width: 22px;
    border-radius: 50%;
    left: 4px;
    bottom: 4px;
    background-color: white;
    transition: 0.4s;
}
.status-slider input:checked + .slider {
    background-color: #2196F3; 
}
.status-slider input:checked + .slider:before {
    transform: translateX(30px);
}
.status-slider.disabled input:checked + .slider {
    background-color: #ccc;
}
    .content-wrapper {
        background-color: #f8f9fa;
        padding: 20px;
    }

    .page-title h3 {
        font-size: 22px;
        font-weight: 600;
        margin-bottom: 10px;
    }

    .card {
        background-color: #fff;
        border: none;
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        padding: 15px;
    }

    .table-wrapper {
        overflow-x: auto;
        padding-right: 10px;
    }

    .data-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 13px;
    }

    .data-table th,
    .data-table td {
        padding: 10px;
        border: 1px solid #dee2e6;
        vertical-align: top;
    }

    .data-table th {
        background-color: #f1f1f1;
        font-weight: 600;
    }

    .btn-link {
        color: #007bff;
        text-decoration: none;
    }

    .btn-link:hover {
        text-decoration: underline;
    }

    .form-control {
        font-size: 13px;
        padding: 5px 8px;
    }

    /* Custom Modal */
    .custom-modal {
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

    .custom-modal-content {
        background-color: #fff;
        margin: 10% auto;
        padding: 20px;
        border-radius: 8px;
        width: 80%;
        max-width: 700px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
    }

    .close-modal {
        color: #aaa;
        float: right;
        font-size: 24px;
        font-weight: bold;
        cursor: pointer;
    }

    .close-modal:hover {
        color: #000;
    }

    .status-select {
        width: 100%;
        padding: 8px;
        border: 1px solid #ddd;
        border-radius: 4px;
    }
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
        align-items: center;
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
    .search-form select {
    padding: 10px;
    border-radius: 6px;
    border: 1px solid #ccc;
    font-size: 14px;
    background-color: white;
}

/* Add these styles for the questionnaire modal */
.questionnaire-details {
    padding: 15px;
}

.answers-list {
    margin-top: 20px;
}

.answer-item {
    background-color: #f8f9fa;
    border-radius: 8px;
    padding: 15px;
    margin-bottom: 15px;
}

.answer-item .question {
    color: #2c3e50;
    margin-bottom: 8px;
    font-size: 14px;
}

.answer-item .answer {
    color: #34495e;
    margin-bottom: 0;
    font-size: 14px;
    padding-left: 20px;
}

.questionnaire-info {
    margin-left: 8px;
    padding: 2px 6px;
    font-size: 12px;
}

/* Add these new styles for document display */
.document-preview {
    display: inline-flex;
    align-items: center;
    padding: 8px 12px;
    margin: 4px;
    background-color: #f8f9fa;
    border: 1px solid #dee2e6;
    border-radius: 6px;
    transition: all 0.3s ease;
}

.document-preview:hover {
    background-color: #e9ecef;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.document-preview img {
    width: 24px;
    height: 24px;
    margin-right: 8px;
}

.document-preview .doc-info {
    display: flex;
    flex-direction: column;
}

.document-preview .doc-name {
    font-size: 12px;
    color: #495057;
    max-width: 150px;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}

.document-preview .doc-type {
    font-size: 10px;
    color: #6c757d;
}

.no-doc-message {
    color: #6c757d;
    font-style: italic;
    padding: 10px;
    text-align: center;
    background-color: #f8f9fa;
    border-radius: 6px;
    border: 1px dashed #dee2e6;
}

/* Add these new styles for status badges */
.badge {
    padding: 1px 5px;
    font-size: 12px;
    font-weight: 500;
    border-radius: 20px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.bg-success {
    background-color: #28a745 !important;
    color: white;
}

.bg-warning {
    background-color: #ffc107 !important;
    color: #000;
}

/* Add styles for upload modal */
.upload-modal {
    display: none;
    position: fixed;
    z-index: 9999;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
}

.upload-modal-content {
    background-color: #fff;
    margin: 10% auto;
    padding: 25px;
    border-radius: 8px;
    width: 90%;
    max-width: 500px;
    position: relative;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

.upload-modal-header {
    margin-bottom: 20px;
    padding-bottom: 15px;
    border-bottom: 1px solid #eee;
}

.upload-modal-header h4 {
    margin: 0;
    font-size: 18px;
    color: #333;
}

.close-upload-modal {
    position: absolute;
    right: 20px;
    top: 20px;
    font-size: 24px;
    cursor: pointer;
    color: #666;
}

.close-upload-modal:hover {
    color: #000;
}

.upload-form {
    margin-top: 20px;
}

.upload-form .form-group {
    margin-bottom: 20px;
}

.upload-form label {
    display: block;
    margin-bottom: 8px;
    color: #555;
}

.upload-form input[type="file"] {
    width: 100%;
    padding: 8px;
    border: 1px solid #ddd;
    border-radius: 4px;
    background-color: #f8f9fa;
}

.upload-form .btn-upload {
    background-color: #007bff;
    color: white;
    padding: 10px 20px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    font-size: 14px;
}

.upload-form .btn-upload:hover {
    background-color: #0056b3;
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
            <div class="table-wrapper">
                @if($bookings->isEmpty())
                    <div class="text-center py-5 text-muted">
                        <p>No bookings available at the moment.</p>
                    </div>
                @else
                    <div class="table-responsive">
                        <table class="data-table">
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
                                    <th>Customer Document</th> <!-- Add this line -->
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
                                    <a href="{{ $booking->meeting_link }}" target="_blank" class="btn btn-link">Join</a>
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

// Add this new JavaScript code
const questionnaireModal = document.getElementById('questionnaireModal');
const closeQuestionnaireModal = document.getElementById('closeQuestionnaireModal');
const questionnaireContent = document.getElementById('questionnaireContent');

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
                questionnaireModal.style.display = 'block';
            } else {
                questionnaireContent.innerHTML = `<p class="text-center text-muted">${data.message}</p>`;
                questionnaireModal.style.display = 'block';
            }
        })
        .catch(error => {
            console.error('Error fetching questionnaire answers:', error);
            questionnaireContent.innerHTML = '<p class="text-center text-danger">Error loading questionnaire answers.</p>';
            questionnaireModal.style.display = 'block';
        });
}

// Close questionnaire modal
closeQuestionnaireModal.addEventListener('click', () => {
    questionnaireModal.style.display = 'none';
});

// Close modal when clicking outside
window.addEventListener('click', event => {
    if (event.target === questionnaireModal) {
        questionnaireModal.style.display = 'none';
    }
});

// Add this after your existing JavaScript
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
            location.reload(); // Reload to show new document
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