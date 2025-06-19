<!-- filepath: c:\xampp\htdocs\tazen_marge_code\Tazen_multi\resources\views\admin\manage-professional\professionals.blade.php -->
<!DOCTYPE html>
<html>
<head>
    <title>{{ $title }}</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <style type="text/css">
        @page {
            margin: 2cm;
        }
        
        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 11px;
            color: #333;
            margin: 0;
            padding: 0;
            line-height: 1.4;
        }
        
        .invoice-container {
            max-width: 100%;
            margin: 0 auto;
            padding: 0;
        }
        
        .header {
            display: block;
            width: 100%;
            border-bottom: 3px solid #4472C4;
            margin-bottom: 25px;
            padding-bottom: 10px;
        }
        
        .header-content {
            position: relative;
            width: 100%;
            height: 90px;
        }
        
        .logo {
            position: absolute;
            top: 0;
            left: 0;
            width: 25%;
        }
        
        .logo img {
            max-width: 100%;
            height: 70px;
        }
        
        .company-details {
            position: absolute;
            top: 0;
            right: 0;
            width: 40%;
            text-align: right;
        }
        
        .company-name {
            font-size: 16px;
            color: #4472C4;
            font-weight: bold;
            margin-bottom: 5px;
        }
        
        .document-title {
            font-size: 18px;
            text-align: center;
            font-weight: bold;
            margin: 25px 0 20px 0;
            color: #4472C4;
        }
        
        .report-info {
            border: 1px solid #ddd;
            border-radius: 5px;
            background-color: #f9f9f9;
            padding: 10px;
            margin-bottom: 20px;
        }
        
        .info-row {
            display: block;
            margin-bottom: 5px;
        }
        
        .info-label {
            font-weight: bold;
            color: #4472C4;
            display: inline-block;
            width: 120px;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            font-size: 10px;
        }
        
        table, th, td {
            border: 1px solid #ddd;
        }
        
        th {
            background-color: #4472C4;
            color: white;
            font-weight: bold;
            padding: 8px;
            font-size: 11px;
            text-transform: uppercase;
        }
        
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        
        td {
            padding: 7px 8px;
            vertical-align: middle;
        }
        
        .total-row {
            font-weight: bold;
            background-color: #f3f3f3;
        }
        
        .status-badge {
            padding: 3px 6px;
            border-radius: 10px;
            font-size: 9px;
            font-weight: bold;
            color: white;
            display: inline-block;
        }
        
        .status-approved {
            background-color: #28a745;
        }
        
        .status-pending {
            background-color: #ffc107;
            color: #212529;
        }
        
        .status-rejected {
            background-color: #dc3545;
        }
        
        .note-container {
            border-top: 1px dashed #ddd;
            padding-top: 15px;
            margin-top: 20px;
            font-style: italic;
            font-size: 10px;
            color: #666;
        }
        
        .footer {
            position: fixed;
            bottom: 30px;
            width: 100%;
            border-top: 1px solid #ddd;
            padding-top: 10px;
            font-size: 10px;
            color: #666;
            text-align: center;
            line-height: 1.5;
        }
    </style>
</head>
<body>
    <div class="invoice-container">
        <!-- Header with Logo -->
        <div class="header">
            <div class="header-content">
                <div class="logo">
                    <!-- Replace with your actual logo -->
                    <img src="data:image/png;base64,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" alt="Tazen Logo">
                </div>
                <div class="company-details">
                    <div class="company-name">TAZEN</div>
                    <div>info@tazen.com</div>
                    <div>www.tazen.com</div>
                    <div>+123 456 7890</div>
                </div>
            </div>
        </div>
        
        <div class="document-title">{{ $title }}</div>
        
        <!-- Report Information -->
        <div class="report-info">
            <div class="info-row">
                <span class="info-label">Report Date:</span> {{ now()->format('d M, Y') }}
            </div>
            <div class="info-row">
                <span class="info-label">Report ID:</span> PRO-{{ now()->format('YmdHis') }}
            </div>
            <div class="info-row">
                <span class="info-label">Generated By:</span> Administrator
            </div>
            <div class="info-row">
                <span class="info-label">Total Records:</span> {{ count($professionals) }}
            </div>
        </div>
        
        <!-- Professionals Data Table -->
        <table>
            <thead>
                <tr>
                    <th style="width: 5%;">ID</th>
                    <th style="width: 15%;">Name</th>
                    <th style="width: 20%;">Email</th>
                    <th style="width: 10%;">Phone</th>
                    <th style="width: 15%;">Specialization</th>
                    <th style="width: 7%;">Margin</th>
                    <th style="width: 10%;">Status</th>
                    <th style="width: 8%;">Active</th>
                    <th style="width: 10%;">Registered</th>
                </tr>
            </thead>
            <tbody>
                @foreach($professionals as $professional)
                    <tr>
                        <td>{{ $professional->id }}</td>
                        <td>{{ $professional->name }}</td>
                        <td>{{ $professional->email }}</td>
                        <td>{{ $professional->phone }}</td>
                        <td>{{ $professional->profile ? $professional->profile->specialization : 'Not specified' }}</td>
                        <td>{{ $professional->margin ?? '0' }}%</td>
                        <td>
                            @if($professional->status == 'accepted')
                                <span class="status-badge status-approved">Approved</span>
                            @elseif($professional->status == 'pending')
                                <span class="status-badge status-pending">Pending</span>
                            @elseif($professional->status == 'rejected')
                                <span class="status-badge status-rejected">Rejected</span>
                            @endif
                        </td>
                        <td>{{ $professional->active ? 'Yes' : 'No' }}</td>
                        <td>{{ $professional->created_at->format('d M Y') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        
        <!-- Summary Section -->
        @php
            $activeCount = $professionals->where('active', true)->count();
            $inactiveCount = $professionals->count() - $activeCount;
            $acceptedCount = $professionals->where('status', 'accepted')->count();
            $pendingCount = $professionals->where('status', 'pending')->count();
            $rejectedCount = $professionals->where('status', 'rejected')->count();
        @endphp
        
        <table>
            <thead>
                <tr>
                    <th colspan="4">Summary</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td width="25%"><strong>Total Professionals:</strong> {{ $professionals->count() }}</td>
                    <td width="25%"><strong>Active:</strong> {{ $activeCount }}</td>
                    <td width="25%"><strong>Inactive:</strong> {{ $inactiveCount }}</td>
                    <td width="25%"><strong>Average Margin:</strong> {{ $professionals->avg('margin') ? round($professionals->avg('margin'), 2) : 0 }}%</td>
                </tr>
                <tr>
                    <td><strong>Approved:</strong> {{ $acceptedCount }}</td>
                    <td><strong>Pending:</strong> {{ $pendingCount }}</td>
                    <td><strong>Rejected:</strong> {{ $rejectedCount }}</td>
                    <td></td>
                </tr>
            </tbody>
        </table>
        
        <!-- Notes -->
        <div class="note-container">
            <p><strong>Note:</strong> This report provides a comprehensive overview of all professionals registered in the system. Use this information for administrative and management purposes only. Confidential data should be handled according to company policies.</p>
        </div>
    </div>
    
    <!-- Footer -->
    <div class="footer">
        <div>{{ config('app.name', 'Tazen') }} | Professional Management System</div>
        <div>Report generated on {{ now()->format('d/m/Y H:i:s') }} | Page 1</div>
    </div>
</body>
</html>