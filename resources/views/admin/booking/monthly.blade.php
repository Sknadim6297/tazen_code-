@extends('admin.layouts.layout')
@section('content')
<div class="main-content app-content">
    <div class="container-fluid">
        <!-- Page Header -->
        <div class="my-4 page-header-breadcrumb d-flex align-items-center justify-content-between flex-wrap gap-2">
            <div>
                <h1 class="page-title fw-medium fs-18 mb-2">Monthly Booking</h1>
                <div class="">
                    <nav>
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="javascript:void(0);">Booking</a></li>
                            <li class="breadcrumb-item"><a href="javascript:void(0);">Monthly</a></li>
                        </ol>
                    </nav>
                </div>
            </div>
     <form action="{{ route('admin.monthly') }}" method="GET" class="d-flex gap-2">
           
    <div class="col-xl-4">
        <div class="card custom-card">
            <input type="search" name="search" class="form-control" id="autoComplete" placeholder="Search">
        </div>
    </div>
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
    <div class="col-xl-2">
        <button type="submit" class="btn btn-primary">Search</button>
    </div>
</form>
        <!-- Page Header Close -->



        <!-- Start::row-2 -->
        <div class="row">
            <div class="col-xxl-12 col-xl-12">
                <div class="card custom-card">
                    <div class="card-header justify-content-between">
                        <div class="card-title">
                            Total Free Hand Bookings: 
                        </div>
                    </div>
                    <div class="card-body p-0">
    <div class="table-responsive" style="overflow-x: auto; -webkit-overflow-scrolling: touch;">
        <table class="table text-nowrap" style="min-width: 1200px;"> <!-- Set a minimum width larger than mobile screens -->
            <thead>
                <tr>
                    <th>Sl. No</th>
                    <th>Customer Name</th>
                    <th>Professional Name</th>
                    <th>Service Required</th>
                    <th>Paid Amount</th>
                    <th>Number Of Session</th>
                    <th>Number Of Session Taken</th>
                    <th>Number Of Session Pending</th>
                    <th>Validity Till</th>
                    <th>Current Service Date On</th>
                    <th>Current Service Time</th>
                    <th>Details</th>
                    <th>Professional Document</th>
                    <th>Customer Document</th>
                    <th>Status</th>
                    <th>Admin remarks to professional</th>
                    <th>Telecaller Remarks </th>
                </tr>
            </thead>

            <tbody>
                @foreach ($bookings as $key => $booking)
                @php
                // Get earliest upcoming date
                $earliestTimedate = $booking->timedates && $booking->timedates->count() > 0 
                    ? $booking->timedates
                        ->filter(fn($td) => \Carbon\Carbon::parse($td->date)->isFuture())
                        ->sortBy('date')
                        ->first()
                    : null;

                $completedSessions = 0;
                $pendingSessions = 0;

                if ($booking->timedates && $booking->timedates->count() > 0) {
                    foreach ($booking->timedates as $td) {
                        $slots = explode(',', $td->time_slot);
                        if ($td->status === 'completed') {
                            $completedSessions += count($slots);
                        } else {
                            $pendingSessions += count($slots);
                        }
                    }
                }
                @endphp

                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $booking->customer_name}}
                    <br>
                    ({{ $booking->customer_phone }})
                    </td>
                    <td>{{ $booking->professional->name }}
                    <br>
                    ({{ $booking->professional->phone }})
                    </td>
                    <td>{{ $booking->service_name }}</td>
                    <td>Null</td>
                    <td>{{ is_array($booking->days) ? count($booking->days) : count(json_decode($booking->days, true)) }}</td>                                          
                    <td>{{ $completedSessions }}</td>
                    <td>{{ $pendingSessions }}</td>  
                    <td>{{ $booking->month }}</td>

                    <td>{{ $earliestTimedate ? \Carbon\Carbon::parse($earliestTimedate->date)->format('d M Y') : '-' }}</td>

                    <td>{!! $earliestTimedate ? str_replace(',', '<br>', $earliestTimedate->time_slot) : '-' !!}</td>
                    <td>
                    <a href="javascript:void(0);" class="btn btn-sm btn-primary see-details-btn" data-id="{{ $booking->id }}">
                        See Details
                    </a>
                    </td>
                    <td>
             @if(!empty($booking->professional_documents))
        @foreach(explode(',', $booking->professional_documents) as $doc)
            <a href="{{ asset('storage/' . $doc) }}" target="_blank"
               class="d-inline-flex justify-content-center align-items-center me-2 mb-1"
               style="width: 40px; height: 40px; border: 1px solid #ddd; border-radius: 5px;">
                <i class="bi bi-download fs-4 text-primary"></i>
            </a>
        @endforeach
    @else
        No Document
    @endif
</td>
<td>
    @if(!empty($booking->customer_document))
        @foreach(explode(',', $booking->customer_document) as $doc)
            <a href="{{ asset('storage/' . $doc) }}" target="_blank"
               class="d-inline-flex justify-content-center align-items-center me-2 mb-1"
               style="width: 40px; height: 40px; border: 1px solid #ddd; border-radius: 5px;">
                <i class="bi bi-download fs-4 text-primary"></i>
            </a>
        @endforeach
    @else
        No Document
    @endif
</td>
<td>Pending</td>
<td>
                                                <form action="{{ route('admin.professional-add-remarks', ['id' => $booking->id]) }}" method="POST">
                                                    @csrf
                                                    <div class="d-flex">
                                                        <input id="remarks_for_professional" class="form-control" type="text" name="remarks_for_professional" placeholder="Remarks" style="width: 350px;" value="{{ $booking->remarks_for_professional}}">
                                                        <button type="submit" class="btn btn-sm btn-primary ms-2">Save</button>
                                                    </div>
                                                </form>
                                            </td>
                                           <td>
                                                <form action="{{ route('admin.add-remarks', ['id' => $booking->id]) }}" method="POST">
                                                    @csrf
                                                    <div class="d-flex">
                                                        <input id="marks" class="form-control" type="text" name="remarks" placeholder="Remarks" style="width: 350px;" value="{{ $booking->remarks }}">
                                                        <button type="submit" class="btn btn-sm btn-primary ms-2">Save</button>
                                                    </div>
                                                </form>
                                            </td>
            </tr>
        @endforeach
    </tbody>
</table>

                        </div>
                    </div>
                    <!-- Modal -->
<div class="modal fade" id="detailsModal" tabindex="-1" aria-labelledby="detailsModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="detailsModalLabel">Booking Details</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" id="detailsModalBody">
        <!-- Data will be inserted here -->
      </div>
    </div>
  </div>
</div>

                    <div class="card-footer border-top-0">
                        <nav aria-label="Page navigation">
                            <ul class="pagination mb-0 float-end">
                                <li class="page-item disabled">
                                    <a class="page-link">Previous</a>
                                </li>
                                <li class="page-item"><a class="page-link" href="javascript:void(0);">1</a></li>
                                <li class="page-item active" aria-current="page">
                                    <a class="page-link" href="javascript:void(0);">2</a>
                                </li>
                                <li class="page-item"><a class="page-link" href="javascript:void(0);">3</a></li>
                                <li class="page-item">
                                    <a class="page-link" href="javascript:void(0);">Next</a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
        <!--End::row-2 -->
    </div>
</div>
<style>
    @media (max-width: 767.98px) {
    .table-responsive {
        display: block;
        width: 100%;
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }
    
    .table {
        width: auto;
        min-width: 100%;
    }
    
    /* Optional: prevent page scrolling when table is being scrolled */
    html, body {
        overflow-x: hidden;
        width: 100%;
    }
}
</style>
@endsection
@section('scripts')
<script>
    function formatDate(dateString) {
    const date = new Date(dateString);
    const day = String(date.getDate()).padStart(2, '0');
    const month = String(date.getMonth() + 1).padStart(2, '0'); // Months are 0-based
    const year = date.getFullYear();
    return `${day}-${month}-${year}`;
}

</script>
    <script>
        $(document).ready(function () {
            $('.see-details-btn').click(function () {
                let bookingId = $(this).data('id');
                let csrf = '{{ csrf_token() }}';
                let route = '{{ url("admin/booking/add-link") }}';

                $.ajax({
                    url: '/admin/booking/details/' + bookingId,
                    type: 'GET',
                    success: function (response) {
                        if (response.dates.length > 0) {
                            let html = `
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped align-middle" style="background-color: #e6f7ff;">
                                        <thead class="table-primary text-center">
                                            <tr>
                                                <th>Date</th>
                                                <th>Time Slot</th>
                                                <th>Status</th>
                                                <th>Professional Remarks to customer</th>
                                                <th>Meeting Link</th>
                                            </tr>
                                        </thead>
                                        <tbody>`;

                            response.dates.forEach(dateInfo => {
                                html += `
                                    <tr>
                                        <td>${formatDate(dateInfo.date)}</td>
                                        <td>${dateInfo.time_slot}</td>
                                        <td>${dateInfo.status}</td>
                                          <td>${dateInfo.remarks ?? '-'}</td>
                                        <td>
                                            <form action="${route}" method="POST" class="d-flex">
                                                <input type="hidden" name="_token" value="${csrf}">
                                                <input type="hidden" name="timedate_id" value="${dateInfo.id}">
                                                <input type="url" name="meeting_link" class="form-control" placeholder="Add Link" value="${dateInfo.meeting_link || ''}" required>
                                                <button type="submit" class="btn btn-sm btn-primary ms-2">Save</button>
                                            </form>
                                        </td>
                                    </tr>`;
                            });

                            html += `</tbody></table></div>`;
                            $('#detailsModalBody').html(html);
                        } else {
                            $('#detailsModalBody').html('<p>No booking dates available.</p>');
                        }

                        $('#detailsModal').modal('show');
                    },
                    error: function () {
                        $('#detailsModalBody').html('<p>Error fetching booking details.</p>');
                        $('#detailsModal').modal('show');
                    }
                });
            });
        });
    </script>


@endsection