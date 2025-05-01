@extends('professional.layout.layout')

@section('style')

@endsection

@section('content')

<div class="content-wrapper">
    <div class="page-header">
        <div class="page-title">
            <h3>All Billing</h3>
        </div>
        <ul class="breadcrumb">
            <li>Home</li>
            <li class="active">All Billing</li>
        </ul>
    </div>

    <div class="card">
        <div class="card-header">
            <h4>Billing Details</h4>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Customer Name</th>
                            <th>Session Type</th>
                            <th>Month</th>
                            <th>Amount (₹)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Ishita</td>
                            <td>Weekly</td>
                            <td>Jan</td>
                            <td>1000</td>
                        </tr>
                        <tr>
                            <td>Chanchal</td>
                            <td>Monthly</td>
                            <td>Jan</td>
                            <td>4800</td>
                        </tr>
                        <tr>
                            <td>Rohit</td>
                            <td>Quarterly</td>
                            <td>Jan</td>
                            <td>6800</td>
                        </tr>
                        <tr style="background-color: #f5f7fb; font-weight: 600;">
                            <td colspan="3" style="text-align: right;">Total Billing:</td>
                            <td>12600</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')

@endsection
