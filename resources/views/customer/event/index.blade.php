@extends('customer.layout.layout')

@section('styles')
<link rel="stylesheet" href="{{ asset('customer-css/assets/css/appointment.css') }}" />

<style>
    /* Custom Modal Styles */
    .custom-modal {
        display: none;
        position: fixed;
        z-index: 1050;
        left: 0; top: 0;
        width: 100%; height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
    }

    .custom-modal-content {
        background-color: #fff;
        margin: 5% auto;
        padding: 20px;
        width: 90%;
        max-width: 800px;
        border-radius: 10px;
        position: relative;
    }

    .custom-modal .close-modal {
        position: absolute;
        right: 15px;
        top: 10px;
        font-size: 24px;
        font-weight: bold;
        color: #aaa;
        cursor: pointer;
    }

    .custom-modal .close-modal:hover {
        color: #e74c3c;
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
</style>
@endsection

@section('content')
<div class="content-wrapper">

    <!-- Page Header -->
    <div class="page-header">
        <div class="page-title">
            <h3>Summary of your appointments</h3>
        </div>
        <ul class="breadcrumb">
            <li>Home</li>
            <li class="active">Appointment</li>
        </ul>
    </div>
<div class="search-container">
    <form action="{{ route('user.all-appointment.index') }}" method="GET" class="search-form">
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
            <a href="{{ route('user.all-appointment.index') }}" class="btn-secondary">Reset</a>
        </div>
    </form>
</div>


    <!-- Appointments Summary -->
    <div class="content-section">
        <div class="section-header mb-3">
            <button class="btn btn-primary">Download Full Report</button>
        </div>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>S.No</th>
                    <th>Booking date</th>
                    <th>Event Name</th>
                      <th>Event Category</th>
                    <th>Event date</th>
                    <th>Amount Paid</th>
                    <th>Venue</th>
                    <th>Address</th>
                    <th>Status  </th>
                </tr>
            </thead>
       <tbody>
    <tr>
        <td>1</td>
        <td>2025-05-10</td>
        <td>Wedding Ceremony</td>
        <td>Personal</td>
        <td>2025-06-01</td>
        <td>₹25,000</td>
        <td>Grand Palace</td>
        <td>123 Park Street, Kolkata</td>
        <td><span class="badge bg-success">Confirmed</span></td>
    </tr>
    <tr>
        <td>2</td>
        <td>2025-05-11</td>
        <td>Corporate Meetup</td>
        <td>Corporate</td>
        <td>2025-06-05</td>
        <td>₹40,000</td>
        <td>ITC Sonar</td>
        <td>EM Bypass, Kolkata</td>
        <td><span class="badge bg-warning text-dark">Pending</span></td>
    </tr>
    <tr>
        <td>3</td>
        <td>2025-05-12</td>
        <td>Birthday Bash</td>
        <td>Personal</td>
        <td>2025-06-07</td>
        <td>₹15,000</td>
        <td>Fun Fiesta Hall</td>
        <td>Behala, Kolkata</td>
        <td><span class="badge bg-danger">Cancelled</span></td>
    </tr>
    <tr>
        <td>4</td>
        <td>2025-05-13</td>
        <td>Music Night</td>
        <td>Entertainment</td>
        <td>2025-06-10</td>
        <td>₹30,000</td>
        <td>Eco Park Auditorium</td>
        <td>New Town, Kolkata</td>
        <td><span class="badge bg-success">Confirmed</span></td>
    </tr>
</tbody>
        </table>
    </div>

</div>

@endsection
@section('scripts')

@endsection


