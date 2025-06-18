<!-- filepath: c:\xampp\htdocs\tazen_marge_code\Tazen_multi\resources\views\admin\Requested_professional\pdf\professionals.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Professional Requests</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            font-size: 12px;
        }
        h1 {
            text-align: center;
            margin-bottom: 20px;
            font-size: 18px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }
        .logo {
            text-align: center;
            margin-bottom: 20px;
        }
        .logo img {
            max-width: 150px;
        }
        .filters {
            margin-bottom: 20px;
            padding: 10px;
            background-color: #f9f9f9;
            border: 1px solid #ddd;
        }
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 10px;
            color: #666;
        }
        .status-badge {
            padding: 3px 8px;
            border-radius: 12px;
            font-size: 11px;
        }
        .status-pending {
            background-color: #fff3cd;
            color: #856404;
        }
        .status-approved {
            background-color: #d4edda;
            color: #155724;
        }
        .status-rejected {
            background-color: #f8d7da;
            color: #721c24;
        }
        .specialization {
            font-style: italic;
            color: #155724;
        }
    </style>
</head>
<body>
    <div class="logo">
        <!-- Replace with your logo path -->
        <img src="{{ public_path('images/logo.png') }}" alt="Logo">
    </div>
    
    <h1>Professional Requests Report</h1>
    
    <div class="filters">
        <p><strong>Filters Applied:</strong></p>
        <p>Search: {{ request('search') ?: 'None' }}</p>
        <p>Specialization: {{ request('specialization') ?: 'All' }}</p>
        <p>Date Range: {{ request('start_date') ? request('start_date') . ' to ' . (request('end_date') ?: 'Present') : 'All Time' }}</p>
        <p>Generated on: {{ \Carbon\Carbon::now()->format('d M Y, h:i A') }}</p>
    </div>
    
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Email</th>
                <th>Specialization</th>
                <th>Status</th>
                <th>Created Date</th>
                <th>Type</th>
                <th>Rejection Reason</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($professionals as $index => $professional)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $professional->name }}</td>
                    <td>{{ $professional->email }}</td>
                    <td class="specialization">
                        {{ $professional->profile ? ($professional->profile->specialization ?: 'Not specified') : 'Not specified' }}
                    </td>
                    <td>
                        @if($professional->status == 'approved')
                            <span class="status-badge status-approved">Approved</span>
                        @elseif($professional->status == 'pending')
                            <span class="status-badge status-pending">Pending</span>
                        @elseif($professional->status == 'rejected')
                            <span class="status-badge status-rejected">Rejected</span>
                        @endif
                    </td>
                    <td>{{ $professional->created_at->format('d/m/Y') }}</td>
                    <td>
                        @if($professional->professionalRejection->first())
                            <span class="status-badge status-rejected">Rejected</span>
                        @else
                            <span class="status-badge">New Application</span>
                        @endif
                    </td>
                    <td>
                        @if($professional->professionalRejection->first())
                            {{ $professional->professionalRejection->first()->reason }}
                        @else
                            New application - No reason
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" style="text-align: center;">No professionals found</td>
                </tr>
            @endforelse
        </tbody>
    </table>
    
    <div class="footer">
        <p>© {{ date('Y') }} Tazen Multi. All rights reserved.</p>
        <p>This is a system-generated report.</p>
    </div>
</body>
</html>