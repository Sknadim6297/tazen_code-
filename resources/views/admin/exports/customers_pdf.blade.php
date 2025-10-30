<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Customers Export - {{ $exportDate }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            margin: 0;
            padding: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #4472C4;
            padding-bottom: 15px;
        }
        .header h1 {
            color: #4472C4;
            margin: 0;
            font-size: 24px;
        }
        .header p {
            margin: 5px 0;
            color: #666;
        }
        .summary {
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        .summary h3 {
            margin: 0 0 10px 0;
            color: #4472C4;
        }
        .filters {
            margin-bottom: 20px;
        }
        .filters h4 {
            margin: 0 0 10px 0;
            color: #333;
        }
        .filter-item {
            display: inline-block;
            margin-right: 20px;
            background-color: #e9ecef;
            padding: 5px 10px;
            border-radius: 3px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
            font-size: 10px;
        }
        th {
            background-color: #4472C4;
            color: white;
            font-weight: bold;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        tr:hover {
            background-color: #f5f5f5;
        }
        .status-active {
            color: #28a745;
            font-weight: bold;
        }
        .status-inactive {
            color: #dc3545;
            font-weight: bold;
        }
        .verified {
            color: #28a745;
        }
        .not-verified {
            color: #dc3545;
        }
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 10px;
            color: #666;
            border-top: 1px solid #ddd;
            padding-top: 15px;
        }
        .page-break {
            page-break-after: always;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Customer Management Report</h1>
        <p>Generated on: {{ $exportDate }}</p>
        <p>Total Customers: {{ $totalCustomers }}</p>
    </div>

    @if($filters['search'] || $filters['start_date'] || $filters['end_date'])
    <div class="filters">
        <h4>Applied Filters:</h4>
        @if($filters['search'])
            <span class="filter-item"><strong>Search:</strong> {{ $filters['search'] }}</span>
        @endif
        @if($filters['start_date'])
            <span class="filter-item"><strong>From:</strong> {{ $filters['start_date'] }}</span>
        @endif
        @if($filters['end_date'])
            <span class="filter-item"><strong>To:</strong> {{ $filters['end_date'] }}</span>
        @endif
    </div>
    @endif

    <div class="summary">
        <h3>Summary</h3>
        <p><strong>Total Customers:</strong> {{ $totalCustomers }}</p>
        <p><strong>Verified Customers:</strong> {{ $users->where('email_verified_at', '!=', null)->count() }}</p>
        <p><strong>Unverified Customers:</strong> {{ $users->where('email_verified_at', null)->count() }}</p>
        <p><strong>Complete Profiles:</strong> {{ $customerProfiles->count() }}</p>
        <p><strong>Incomplete Profiles:</strong> {{ $totalCustomers - $customerProfiles->count() }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Verified</th>
                <th>Registration</th>
                <th>Status</th>
                <th>Gender</th>
                <th>City</th>
                <th>Profile</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
                @php
                    $customerProfile = $customerProfiles->get($user->id);
                @endphp
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->phone ?? 'N/A' }}</td>
                    <td class="{{ $user->email_verified_at ? 'verified' : 'not-verified' }}">
                        {{ $user->email_verified_at ? 'Yes' : 'No' }}
                    </td>
                    <td>{{ $user->created_at->format('Y-m-d') }}</td>
                    <td class="{{ $user->is_active ? 'status-active' : 'status-inactive' }}">
                        {{ $user->is_active ? 'Active' : 'Inactive' }}
                    </td>
                    <td>{{ $customerProfile ? ($customerProfile->gender ?? 'N/A') : 'N/A' }}</td>
                    <td>{{ $customerProfile ? ($customerProfile->city ?? 'N/A') : 'N/A' }}</td>
                    <td>{{ $customerProfile ? 'Complete' : 'Incomplete' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <p>This report was generated from the Customer Management System</p>
        <p>Report contains {{ $totalCustomers }} customer records</p>
    </div>
</body>
</html>