@extends('professional.layout.layout')
@section('style')
@endsection
@section('content')

    <!-- Page Header -->
    <div class="page-header">
        <div class="page-title">
            <h3>Dashboard</h3>
        </div>
        <ul class="breadcrumb">
            <li>Home</li>
            <li class="active">Dashboard</li>
        </ul>
    </div>

    <!-- Dashboard Cards -->
    <div class="card-grid">
        <div class="card card-primary">
            <div class="card-icon">
                <i class="fas fa-calendar-check"></i>
            </div>
            <div class="card-info">
                <h4>Total Bookings</h4>
                <h2>24</h2>
                <p class="positive"><i class="fas fa-arrow-up"></i> 12% from last month</p>
            </div>
        </div>

        <div class="card card-success">
            <div class="card-icon">
                <i class="fas fa-dollar-sign"></i>
            </div>
            <div class="card-info">
                <h4>Total Revenue</h4>
                <h2>₹12,600</h2>
                <p class="positive"><i class="fas fa-arrow-up"></i> 8% from last month</p>
            </div>
        </div>

        <div class="card card-warning">
            <div class="card-icon">
                <i class="fas fa-users"></i>
            </div>
            <div class="card-info">
                <h4>Active Clients</h4>
                <h2>15</h2>
                <p class="negative"><i class="fas fa-arrow-down"></i> 2% from last month</p>
            </div>
        </div>

        <div class="card card-danger">
            <div class="card-icon">
                <i class="fas fa-tasks"></i>
            </div>
            <div class="card-info">
                <h4>Pending Tasks</h4>
                <h2>7</h2>
                <p class="positive"><i class="fas fa-arrow-up"></i> 3 new today</p>
            </div>
        </div>
    </div>

    <!-- Recent Bookings -->
    <!-- Recent Bookings -->
    <div class="content-card">
        <div class="card-header">
            <h4>Recent Bookings</h4>
            <div class="card-action">
                <button>View All</button>
                <button>Export</button>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Customer</th>
                        <th>Service</th>
                        <th>Date</th>
                        <th>Time</th>
                        <th>Amount</th>
                        <th>Status</th>
                        <th>Meeting Link</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <div class="user-profile" style="margin-left: 0;">
                                <img src="https://randomuser.me/api/portraits/women/65.jpg" alt="User"
                                    style="width: 30px; height: 30px;">
                                <div class="user-info">
                                    <h5>Ishita</h5>
                                </div>
                            </div>
                        </td>
                        <td>Weekly Session</td>
                        <td>07-01-2025</td>
                        <td>12:00-12:30</td>
                        <td>₹1000</td>
                        <td><span class="status-badge success">Completed</span></td>
                        <td>
                            <a href="https://meet.google.com/abc-xyz-123" target="_blank"
                                class="action-btn">
                                <i class="fas fa-video"></i> Join
                            </a>
                        </td>
                        <td>
                            <div class="action-btn"><i class="fas fa-eye"></i></div>
                            <div class="action-btn"><i class="fas fa-edit"></i></div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="user-profile" style="margin-left: 0;">
                                <img src="https://randomuser.me/api/portraits/women/33.jpg" alt="User"
                                    style="width: 30px; height: 30px;">
                                <div class="user-info">
                                    <h5>Chanchal</h5>
                                </div>
                            </div>
                        </td>
                        <td>Monthly Package</td>
                        <td>12-01-2025</td>
                        <td>1:00-1:30</td>
                        <td>₹4800</td>
                        <td><span class="status-badge warning">Pending</span></td>
                        <td>
                            <span class="text-gray">Not scheduled</span>
                        </td>
                        <td>
                            <div class="action-btn"><i class="fas fa-eye"></i></div>
                            <div class="action-btn"><i class="fas fa-edit"></i></div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="user-profile" style="margin-left: 0;">
                                <img src="https://randomuser.me/api/portraits/men/75.jpg" alt="User"
                                    style="width: 30px; height: 30px;">
                                <div class="user-info">
                                    <h5>Rohit</h5>
                                </div>
                            </div>
                        </td>
                        <td>Quarterly Package</td>
                        <td>14-01-2025</td>
                        <td>6:00-6:30</td>
                        <td>₹6800</td>
                        <td><span class="status-badge info">Confirmed</span></td>
                        <td>
                            <a href="https://meet.google.com/def-uvw-456" target="_blank"
                                class="action-btn">
                                <i class="fas fa-video"></i> Join
                            </a>
                        </td>
                        <td>
                            <div class="action-btn"><i class="fas fa-eye"></i></div>
                            <div class="action-btn"><i class="fas fa-edit"></i></div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
@endsection

