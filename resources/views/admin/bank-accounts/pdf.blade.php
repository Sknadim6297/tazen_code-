<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Professional Bank Accounts Report</title>
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
            border-bottom: 2px solid #333;
            padding-bottom: 10px;
        }
        
        .header h1 {
            margin: 0;
            color: #333;
            font-size: 24px;
        }
        
        .header p {
            margin: 5px 0 0 0;
            color: #666;
            font-size: 14px;
        }
        
        .summary {
            background-color: #f8f9fa;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 20px;
            text-align: center;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        
        th {
            background-color: #4472c4;
            color: white;
            padding: 8px 5px;
            text-align: left;
            font-weight: bold;
            font-size: 10px;
            border: 1px solid #ddd;
        }
        
        td {
            padding: 6px 5px;
            border: 1px solid #ddd;
            font-size: 9px;
            vertical-align: top;
        }
        
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        
        tr:hover {
            background-color: #f5f5f5;
        }
        
        .status-active {
            background-color: #d1edff;
            color: #0c63e4;
            padding: 2px 5px;
            border-radius: 3px;
            font-size: 8px;
            font-weight: bold;
        }
        
        .status-inactive {
            background-color: #f8d7da;
            color: #721c24;
            padding: 2px 5px;
            border-radius: 3px;
            font-size: 8px;
            font-weight: bold;
        }
        
        .status-pending {
            background-color: #fff3cd;
            color: #856404;
            padding: 2px 5px;
            border-radius: 3px;
            font-size: 8px;
            font-weight: bold;
        }
        
        .account-type-savings {
            background-color: #d4edda;
            color: #155724;
            padding: 2px 5px;
            border-radius: 3px;
            font-size: 8px;
            font-weight: bold;
        }
        
        .account-type-current {
            background-color: #cce5ff;
            color: #004085;
            padding: 2px 5px;
            border-radius: 3px;
            font-size: 8px;
            font-weight: bold;
        }
        
        .verification-verified {
            background-color: #d1ecf1;
            color: #0c5460;
            padding: 2px 5px;
            border-radius: 3px;
            font-size: 8px;
            font-weight: bold;
        }
        
        .verification-pending {
            background-color: #fff3cd;
            color: #856404;
            padding: 2px 5px;
            border-radius: 3px;
            font-size: 8px;
            font-weight: bold;
        }
        
        .account-details {
            font-family: 'Courier New', monospace;
            font-weight: bold;
        }
        
        .ifsc-code {
            font-family: 'Courier New', monospace;
            font-weight: bold;
            color: #6f42c1;
        }
        
        .footer {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            text-align: center;
            font-size: 10px;
            color: #666;
            padding: 10px;
            border-top: 1px solid #ddd;
        }
        
        .page-number {
            position: fixed;
            bottom: 10px;
            right: 20px;
            font-size: 10px;
            color: #666;
        }
        
        @page {
            margin: 20px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Professional Bank Accounts Report</h1>
        <p>Generated on {{ now()->format('M d, Y h:i A') }}</p>
    </div>
    
    <div class="summary">
        <strong>Total Bank Accounts: {{ $bankAccounts->count() }}</strong>
    </div>
    
    @if($bankAccounts->count() > 0)
        <table>
            <thead>
                <tr>
                    <th>Professional</th>
                    <th>Email</th>
                    <th>Status</th>
                    <th>Account Holder</th>
                    <th>Bank Name</th>
                    <th>Branch</th>
                    <th>Account Number</th>
                    <th>IFSC Code</th>
                    <th>Type</th>
                    <th>Verification</th>
                    <th>Created</th>
                </tr>
            </thead>
            <tbody>
                @foreach($bankAccounts as $account)
                    <tr>
                        <td>{{ $account->professional->name ?? 'N/A' }}</td>
                        <td>{{ $account->professional->email ?? 'N/A' }}</td>
                        <td>
                            <span class="status-{{ $account->professional->status ?? 'pending' }}">
                                {{ ucfirst($account->professional->status ?? 'pending') }}
                            </span>
                        </td>
                        <td>{{ $account->account_holder_name ?? 'N/A' }}</td>
                        <td>{{ $account->bank_name ?? 'N/A' }}</td>
                        <td>{{ $account->bank_branch ?? 'N/A' }}</td>
                        <td class="account-details">{{ $account->account_number ?? 'N/A' }}</td>
                        <td class="ifsc-code">{{ $account->ifsc_code ?? 'N/A' }}</td>
                        <td>
                            <span class="account-type-{{ $account->account_type ?? 'savings' }}">
                                {{ ucfirst($account->account_type ?? 'savings') }}
                            </span>
                        </td>
                        <td>
                            <span class="verification-{{ $account->verification_status }}">
                                {{ ucfirst($account->verification_status) }}
                            </span>
                        </td>
                        <td>{{ $account->created_at ? $account->created_at->format('M d, Y') : 'N/A' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <div style="text-align: center; padding: 50px; color: #666;">
            <h3>No Bank Accounts Found</h3>
            <p>No professional bank accounts match the current filters.</p>
        </div>
    @endif
    
    <div class="footer">
        Tazen Admin Panel - Professional Bank Accounts Report
    </div>
    
    <div class="page-number">
        Page <span class="pagenum"></span>
    </div>
</body>
</html>