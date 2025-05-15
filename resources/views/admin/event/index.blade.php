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
            <form action="" class="d-flex gap-2">
           
            <div class="col-xl-4">
                <input type="search" class="form-control" id="autoComplete" placeholder="Search by name or email" spellcheck="false" autocomplete="off" autocapitalize="off">
            </div>
             <div class="col-xl-6">
            <div class="">
                <div class="card-body">
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-text text-muted"> <i class="ri-calendar-line"></i> </div>
                            <input type="text" class="form-control" id="daterange" placeholder="Choose dates">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
        </form>
<a href="{{ route('user.customer-event.index') }}">User Events</a>
<a href="{{ route('admin.eventpage.index') }}">Admin Events</a>
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
                            <table class="table text-nowrap">
                                <thead>
                                    <tr>
                                        <th><input class="form-check-input check-all" type="checkbox" id="all-professionals" aria-label="..."></th>
                                        <th scope="col">Sl.No</th>
                                        <th scope="col">Customer#</th>
                                        <th scope="col">Event name</th>
                                          <th scope="col">Event date</th>
                                             <th scope="col">Location</th>
                                                   <th scope="col">Amount</th>
                                             <th scope="col">Gmeet#</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Created At</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                       <tbody>
    <tr>
        <td><input class="form-check-input" type="checkbox"></td>
        <td>1</td>
        <td>CUST001</td>
        <td>Wedding Ceremony</td>
        <td>2025-06-01</td>
        <td>Kolkata</td>
        <td>₹20,000</td>
        <td>gmeet.com/xyz123</td>
        <td><span class="badge bg-success">Confirmed</span></td>
        <td>2025-05-10</td>
        <td>
            <a href="#" class="btn btn-sm btn-primary">Edit</a>
            <a href="#" class="btn btn-sm btn-danger">Delete</a>
        </td>
    </tr>
    <tr>
        <td><input class="form-check-input" type="checkbox"></td>
        <td>2</td>
        <td>CUST002</td>
        <td>Birthday Party</td>
        <td>2025-06-05</td>
        <td>New Town</td>
        <td>₹10,000</td>
        <td>gmeet.com/abc456</td>
        <td><span class="badge bg-warning text-dark">Pending</span></td>
        <td>2025-05-11</td>
        <td>
            <a href="#" class="btn btn-sm btn-primary">Edit</a>
            <a href="#" class="btn btn-sm btn-danger">Delete</a>
        </td>
    </tr>
    <tr>
        <td><input class="form-check-input" type="checkbox"></td>
        <td>3</td>
        <td>CUST003</td>
        <td>Corporate Meeting</td>
        <td>2025-06-10</td>
        <td>Salt Lake</td>
        <td>₹35,000</td>
        <td>gmeet.com/def789</td>
        <td><span class="badge bg-danger">Cancelled</span></td>
        <td>2025-05-12</td>
        <td>
            <a href="#" class="btn btn-sm btn-primary">Edit</a>
            <a href="#" class="btn btn-sm btn-danger">Delete</a>
        </td>
    </tr>
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
