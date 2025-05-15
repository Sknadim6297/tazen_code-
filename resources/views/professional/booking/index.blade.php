@extends('professional.layout.layout')

@section('styles')
<style>
   /* Style for the slider container */
.status-slider {
    position: relative;
    display: inline-block;
    width: 60px;
    height: 30px;
    cursor: pointer;
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
                <option value="one_time" {{ request('plan_type') == 'one_time' ? 'selected' : '' }}>One Time</option>
                <option value="free_hand" {{ request('plan_type') == 'free_hand' ? 'selected' : '' }}>Free Hand</option>
                <option value="ttc" {{ request('plan_type') == 'ttc' ? 'selected' : '' }}>TTC</option>
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

        <!-- ✅ Plan Type Dropdown -->
   

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
                                    <th>Upload Documents (PDF)</th>
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
                                <td>{{ $booking->customer_name }}</td>
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
                                    <form action="{{ route('professional.doc.upload', $booking->id) }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <input type="file" name="documents[]" class="form-control" accept=".pdf" multiple>
                                        <button type="submit" class="btn btn-primary btn-sm mt-2">Upload</button>
                                    </form>
                                
                                    {{-- PDF view icon --}}
                                    @if ($booking->professional_documents)
                                        @php
                                            $documents = explode(',', $booking->professional_documents);
                                        @endphp
                                        @foreach ($documents as $document)
                                            <a href="{{ asset('storage/' . $document) }}" class="btn btn-sm btn-secondary mt-1" target="_blank">
                                                <img src="{{ asset('images/pdf-icon.png') }}" alt="PDFs" style="width: 20px;">
                                            </a>
                                        @endforeach
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
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    const modal = document.getElementById('bookingDetailModal');
    const closeModal = document.querySelector('.close-modal');
    const tableBody = document.querySelector('#details-table tbody');

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
                const isChecked = item.status === 'Complete' ? 'checked' : '';
                const remarks = item.remarks || '';

                const row = `
                    <tr>
                        <td>${item.date}</td>
                        <td>${slot}</td>
                        <td>
                            <input type="text" class="form-control remark-input" value="${remarks}" placeholder="Remarks">
                        </td>
                        <td>
                            <label class="status-slider" 
                                   data-booking-id="${bookingId}" 
                                   data-date="${item.date}" 
                                   data-slot="${slot}">
                                <input type="checkbox" class="status-checkbox" ${isChecked}>
                                <span class="slider"></span>
                            </label>
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
            checkbox.addEventListener('change', () => {
                const label = checkbox.closest('.status-slider');
                const bookingId = label.dataset.bookingId;
                const date = label.dataset.date;
                const slot = label.dataset.slot;
                const remarks = checkbox.closest('tr').querySelector('.remark-input').value;

                // Always send status = Complete on toggle
                const status = checkbox.checked ? 'Complete' : 'Pending';
                
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
                        remarks: remarks
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        toastr.success(data.message);
                    } else {
                           toastr.error(data.message);
                        checkbox.checked = false; 
                    }
                })
                .catch(error => {
                    console.error('Error updating status:', error);
                    alert('Failed to update status.');
                    checkbox.checked = false; // rollback
                });
            });
        });
    }

    // Modal close handlers
    closeModal.addEventListener('click', () => modal.style.display = 'none');
    window.addEventListener('click', event => {
        if (event.target === modal) modal.style.display = 'none';
    });
});
</script>



@endsection
