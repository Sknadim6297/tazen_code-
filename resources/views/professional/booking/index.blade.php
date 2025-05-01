@extends('professional.layout.layout')

@section('style')
    <style>
        .content-wrapper {
            margin-top: 20px;
            font-family: 'Arial', sans-serif;
        }

        .page-header {
            background-color: #f7f9fc;
            padding: 15px 25px;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        .page-title h3 {
            font-size: 26px;
            font-weight: bold;
            color: #333;
        }

        .breadcrumb {
            background: none;
            padding: 0;
            margin-top: 10px;
        }

        .breadcrumb li {
            display: inline;
            font-size: 14px;
        }

        .breadcrumb li + li::before {
            content: ">";
            padding: 0 5px;
            color: #6c757d;
        }

        .card {
            border: none;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            overflow: hidden;
        }

        .card-body {
            padding: 25px;
        }

        .table-responsive {
            overflow-x: auto;
        }

        .data-table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
        }

        .data-table th,
        .data-table td {
            padding: 15px;
            text-align: center;
            border: 1px solid #ddd;
            font-size: 14px;
        }

        .data-table th {
            background-color: #007bff;
            color: white;
            font-size: 16px;
            font-weight: 600;
        }

        .data-table td {
            background-color: #f9f9f9;
        }

        .actions button {
            margin: 5px;
            width: 90px;
            font-size: 13px;
        }

        .actions .btn {
            width: 100%;
            padding: 10px 0;
            border-radius: 5px;
        }

        .actions .btn:hover {
            cursor: pointer;
        }

        .no-bookings {
            text-align: center;
            font-size: 18px;
            color: #6c757d;
            padding: 30px;
        }

        .table-wrapper {
            margin: 0 auto;
            max-width: 1200px;
        }

        .btn-link {
            color: #007bff;
            text-decoration: none;
        }

        .btn-link:hover {
            text-decoration: underline;
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
                    <div class="no-bookings">
                        <p>No bookings available at the moment.</p>
                    </div>
                @else
                    <div class="table-responsive">
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>Customer Name</th>
                                    <th>Session Type</th>
                                    <th>Month</th>
                                    <th>Days</th>
                                    <th>Date</th>
                                    <th>Time Slot</th>
                                    <th>Meeting Link</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($bookings as $booking)
                                    <tr>
                                        <td>{{ $booking->customer_name }}</td>
                                        <td>{{ $booking->session_type }}</td>
                                        <td>{{ $booking->month }}</td>
                                        <td>{{ $booking->days }}</td>
                                        <td>{{ $booking->booking_date }}</td>
                                        <td>{{ $booking->time_slot }}</td>
                                        <td><a href="{{ $booking->meeting_link }}" target="_blank" class="btn btn-link">Join Meeting</a></td>
                                        <td class="actions">
                                            <!-- Accept Button -->
                                            <form action="#" method="POST" style="display: inline-block;">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-success">
                                                    <i class="fas fa-check"></i> Accept
                                                </button>
                                            </form>
                                            <!-- Reject Button -->
                                            <form action="" method="POST" style="display: inline-block;">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-danger">
                                                    <i class="fas fa-times"></i> Reject
                                                </button>
                                            </form>
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
@endsection

@section('scripts')
    <!-- Add your custom scripts here -->
@endsection
