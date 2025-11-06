<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Management Report</title>
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 12px;
            color: #333;
            line-height: 1.4;
            margin: 0;
            padding: 20px;
        }
        
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #2c3e50;
            padding-bottom: 20px;
        }
        
        .header h1 {
            color: #2c3e50;
            margin: 0;
            font-size: 24px;
            font-weight: bold;
        }
        
        .header p {
            color: #7f8c8d;
            margin: 5px 0 0 0;
            font-size: 14px;
        }
        
        .stats-container {
            margin-bottom: 30px;
            display: table;
            width: 100%;
        }
        
        .stat-box {
            display: table-cell;
            width: 20%;
            text-align: center;
            padding: 15px;
            margin: 0 10px;
            background-color: #f8f9fa;
            border: 1px solid #dee2e6;
            border-radius: 5px;
        }
        
        .stat-number {
            font-size: 18px;
            font-weight: bold;
            color: #2c3e50;
            display: block;
        }
        
        .stat-label {
            font-size: 10px;
            color: #6c757d;
            margin-top: 5px;
        }
        
        .users-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            font-size: 10px;
        }
        
        .users-table th {
            background-color: #2c3e50;
            color: white;
            padding: 10px 8px;
            text-align: left;
            font-weight: bold;
            border: 1px solid #34495e;
        }
        
        .users-table td {
            padding: 8px;
            border: 1px solid #dee2e6;
            vertical-align: top;
        }
        
        .users-table tr:nth-child(even) {
            background-color: #f8f9fa;
        }
        
        .users-table tr:hover {
            background-color: #e9ecef;
        }
        
        .status-badge {
            padding: 3px 6px;
            border-radius: 3px;
            font-size: 9px;
            font-weight: bold;
            color: white;
        }
        
        .status-completed {
            background-color: #28a745;
        }
        
        .status-incomplete {
            background-color: #ffc107;
            color: #212529;
        }
        
        .status-verified {
            background-color: #17a2b8;
        }
        
        .status-not-verified {
            background-color: #dc3545;
        }
        
        .footer {
            position: fixed;
            bottom: 20px;
            left: 20px;
            right: 20px;
            text-align: center;
            font-size: 10px;
            color: #6c757d;
            border-top: 1px solid #dee2e6;
            padding-top: 10px;
        }
        
        .page-break {
            page-break-before: always;
        }
        
        .no-data {
            text-align: center;
            padding: 40px;
            color: #6c757d;
            font-style: italic;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>User Management Report</h1>
        <p>Generated on {{ date('F d, Y \a\t h:i A') }}</p>
    </div>

    @if($users->count() > 0)
        <div class="stats-container">
            <div class="stat-box">
                <span class="stat-number">{{ $users->count() }}</span>
                <div class="stat-label">Total Users</div>
            </div>
            <div class="stat-box">
                <span class="stat-number">{{ $users->where('registration_completed', true)->count() }}</span>
                <div class="stat-label">Completed</div>
            </div>
            <div class="stat-box">
                <span class="stat-number">{{ $users->where('registration_completed', false)->count() }}</span>
                <div class="stat-label">Incomplete</div>
            </div>
            <div class="stat-box">
                <span class="stat-number">{{ $users->where('email_verified', true)->count() }}</span>
                <div class="stat-label">Email Verified</div>
            </div>
            <div class="stat-box">
                <span class="stat-number">{{ $users->where('email_verified', false)->count() }}</span>
                <div class="stat-label">Email Pending</div>
            </div>
        </div>

        <table class="users-table">
            <thead>
                <tr>
                    <th style="width: 8%;">ID</th>
                    <th style="width: 20%;">Name</th>
                    <th style="width: 22%;">Email</th>
                    <th style="width: 15%;">Phone</th>
                    <th style="width: 12%;">Registration</th>
                    <th style="width: 10%;">Email Status</th>
                    <th style="width: 13%;">Reg. Date</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->phone ?? 'N/A' }}</td>
                        <td>
                            @if($user->registration_completed)
                                <span class="status-badge status-completed">Completed</span>
                            @else
                                <span class="status-badge status-incomplete">Incomplete</span>
                            @endif
                        </td>
                        <td>
                            @if($user->email_verified)
                                <span class="status-badge status-verified">Verified</span>
                            @else
                                <span class="status-badge status-not-verified">Pending</span>
                            @endif
                        </td>
                        <td>{{ $user->created_at->format('M d, Y') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <div class="no-data">
            <h3>No Users Found</h3>
            <p>No users match the selected filters.</p>
        </div>
    @endif

    <div class="footer">
        <p>User Management Report - Tazen.in Admin Panel - Page <span class="pagenum"></span></p>
    </div>
</body>
</html>