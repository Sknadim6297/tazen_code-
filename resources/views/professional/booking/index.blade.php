@extends('professional.layout.layout')

@section('styles')
<style>
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
                                    <th>Summary/Remarks</th>
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
                                <td>{{ $booking->created_at }}</td>
                                <td>
                                    <a href="{{ $booking->meeting_link }}" target="_blank" class="btn btn-link">Join</a>
                                </td>
                                <td>
                                    <button class="btn btn-info btn-sm view-details"
                                        data-booking-id="{{ $booking->id }}">
                                        View
                                    </button>
                                </td>
                                <td>Kuch bhi</td>
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
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const viewButtons = document.querySelectorAll('.view-details');
    const modal = document.getElementById('bookingDetailModal');
    const closeModal = document.querySelector('.close-modal');
    const tableBody = document.querySelector('#details-table tbody');

    viewButtons.forEach(button => {
        button.addEventListener('click', function () {
            const bookingId = this.dataset.bookingId;

            fetch(`/professional/bookings/${bookingId}/details`)
                .then(res => {
                    if (!res.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return res.json();
                })
                .then(data => {
                    tableBody.innerHTML = '';

                    data.dates.forEach((item, index) => {
                        item.time_slot.forEach(slot => {
                            tableBody.innerHTML += `
                                <tr>
                                    <td>${item.date}</td>
                                    <td>${slot}</td>
                                    <td>
                                        <select class="status-select" data-row="${index}">
                                            <option value="Pending" ${item.status === 'Pending' ? 'selected' : ''}>Pending</option>
                                            <option value="Scheduled" ${item.status === 'Scheduled' ? 'selected' : ''}>Scheduled</option>
                                            <option value="Complete" ${item.status === 'Complete' ? 'selected' : ''}>Complete</option>
                                        </select>
                                    </td>
                                    <td>
                                        <button class="btn btn-primary btn-sm">Update</button>
                                    </td>
                                </tr>
                            `;
                        });
                    });

                    modal.style.display = 'block';
                })
                .catch(err => {
                    console.error('Error fetching booking details:', err);
                    alert('Something went wrong fetching booking details.');
                });
        });
    });

    closeModal.addEventListener('click', function () {
        modal.style.display = 'none';
    });

    window.addEventListener('click', function (event) {
        if (event.target === modal) {
            modal.style.display = 'none';
        }
    });
});



</script>
@endsection
