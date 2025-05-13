@extends('admin.layouts.layout')
@section('content')
<div class="main-content app-content">
    <div class="container-fluid">
        <!-- Page Header -->
        <div class="my-4 page-header-breadcrumb d-flex align-items-center justify-content-between flex-wrap gap-2">
            <div>
                <h1 class="page-title fw-medium fs-18 mb-2">Free Hand Booking</h1>
                <div class="">
                    <nav>
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="javascript:void(0);">Booking</a></li>
                            <li class="breadcrumb-item"><a href="javascript:void(0);">Booking Details</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Free Hand Booking</li>
                        </ol>
                    </nav>
                </div>
            </div>
     <form action="{{ route('admin.monthly') }}" method="GET" class="d-flex gap-2">
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
                        <div class="table-responsive">
                            <table class="table text-nowrap">
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
                                        <th>Add link for the Service</th>
                                        <th>Details</th>
                                    </tr>
                                </thead>
                                
                                <tbody>
                                    @foreach ($bookings as $key => $booking)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>
                                                {{ $booking->customer_name }} <br>
                                            {{-- (    {{ $booking->customerProfile->phone }} ) --}}
                                            </td>
                                            <td>{{ $booking->professional->name }}</td>
                                            <td>{{ $booking->service_name }}</td>
                                            <td>Null</td>
                                            <td>
                                                {{ is_array($booking->days) ? count($booking->days) : count(json_decode($booking->days, true)) }}
                                            </td>                                          
                                            <td>0</td>
                                            <td>0</td>
                                            <td>{{ $booking->month }}</td>
                                            <td>{{ $booking->days }} {{ $booking->month }}</td>
                                            <td>{{ $booking->time_slot }}</td>
                                            <td>
                                                <form action="{{ route('admin.add-link', ['id' => $booking->id]) }}" method="POST">
                                                    @csrf
                                                    <div class="d-flex">
                                                        <input type="url" name="meeting_link" class="form-control" value="{{ $booking->meeting_link }}" placeholder="Add Link" required>
                                                        <button type="submit" class="btn btn-sm btn-primary ms-2">Save</button>
                                                    </div>
                                                </form>
                                            </td>
                                      <td>
                                        <a href="javascript:void(0);" class="btn btn-sm btn-primary">See Details</a>
                                      </td>

                                        </tr>
                                    @endforeach
                                </tbody>
                            

                            </table>
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
@endsection