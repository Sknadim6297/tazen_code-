@extends('admin.layouts.layout')
@section('style')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" />
@endsection
@section('content')
<div class="main-content app-content">
    <div class="container-fluid">
        <!-- Page Header -->
        <div class="my-4 page-header-breadcrumb d-flex align-items-center justify-content-between flex-wrap gap-2">
            <div>
                <h1 class="page-title fw-medium fs-18 mb-2">All Professionals</h1>
                <div>
                    <nav>
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="javascript:void(0);">Professional</a></li>
                            <li class="breadcrumb-item active" aria-current="page">All Professional</li>
                        </ol>
                    </nav>
                </div>
            </div>
          <form action="{{ route('admin.eventpage.index') }}" method="GET" class="d-flex gap-2">

    <div class="col-xl-2">
        <select name="status" class="form-control">
            <option value=""> payment status</option>
            @foreach($statusList as $status)
                <option value="{{ $status }}" {{ request('status') == $status ? 'selected' : '' }}>
                    {{ ucfirst($status) }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="col-xl-4">
        <input type="search" name="search" class="form-control" placeholder="Search by name or event" value="{{ request('search') }}">
    </div>
    <div class="col-xl-4">
        <div class="input-group">
            <input type="date" class="form-control" name="start_date" value="{{ request('start_date') }}">
            <span class="input-group-text">to</span>
            <input type="date" class="form-control" name="end_date" value="{{ request('end_date') }}">
        </div>
    </div>

    <div class="col-xl-2">
        <button type="submit" class="btn btn-primary">Search</button>
    </div>
</form>


        <div class="row">
            <div class="col-xxl-12 col-xl-12">
                <div class="card custom-card">
                    <div class="card-header justify-content-between">
                        <div class="card-title">
                            Total Professionals
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>Sl.No</th>
            <th>Customer Name</th>
            <th>Event Name</th>
            <th>Event Date</th>
            <th>Location</th>
            <th>Type</th>
            <th>No. of Persons</th>
            <th>Phone</th>
            <th>Price</th>
            <th>Total Price</th>
            <th>Gmeet Link</th>
            <th>Payment Status</th>
            <th>Order ID</th>
            <th>Payment Failure Reason</th>
            <th>Payment Date</th>
        </tr>
    </thead>
    <tbody>
        @foreach($bookings as $index => $booking)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $booking->user->name ?? 'N/A' }}</td>
                <td>{{ $booking->event->heading ?? 'N/A' }}</td>
                <td>{{ $booking->event_date }}</td>
                <td>{{ $booking->location ?? 'N/A' }}</td>
                <td>{{ $booking->type ?? 'N/A' }}</td>
                <td>{{ $booking->persons ?? 'N/A' }}</td>
                <td>{{ $booking->phone ?? 'N/A' }}</td>
                <td>₹{{ number_format($booking->price, 2) }}</td>
                <td>₹{{ number_format($booking->total_price, 2) }}</td>
                <td>
    <form action="{{ route('admin.event.updateGmeetLink', $booking->id) }}" method="POST">
        @csrf
        <input type="text" name="gmeet_link" class="form-control" value="{{ $booking->gmeet_link ?? 'N/A' }}" style="width: 320px">
        <button type="submit" class="btn btn-primary mt-1">Save</button>
    </form>
</td>

                <td>
                    @if($booking->payment_status == 'success')
                        <span class="badge bg-success">Confirmed</span>
                    @elseif($booking->payment_status == 'failed')
                        <span class="badge bg-warning text-dark">Failed</span>
                    @else
                        <span class="badge bg-danger">Unknown</span>
                    @endif
                </td>
                <td>{{ $booking->order_id ?? 'N/A' }}</td>
                <td>{{ $booking->payment_failure_reason ?? 'N/A' }}</td>
                <td>{{ $booking->created_at->format('Y-m-d H:i') }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

                        </div>
                    </div>
                    <div class="card-footer border-top-0">
                        <nav aria-label="Page navigation">
                            <ul class="pagination mb-0 float-end">
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection
@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
@endsection
