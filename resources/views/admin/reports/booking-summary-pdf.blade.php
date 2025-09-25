<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Summary Report</title>
    <style>
        body {
            font-family: 'DejaVu Sans', Arial, sans-serif;
            font-size: 8px;
            margin: 0;
            padding: 15px;
            background-color: #fff;
        }
        
        .header {
            text-align: center;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 2px solid #333;
        }
        
        .header h1 {
            color: #333;
            font-size: 18px;
            margin: 0;
            font-weight: bold;
        }
        
        .header h2 {
            color: #666;
            font-size: 14px;
            margin: 5px 0;
            font-weight: normal;
        }
        
        .filter-info {
            background-color: #f8f9fa;
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 5px;
            border: 1px solid #dee2e6;
        }
        
        .filter-info h3 {
            margin: 0 0 8px 0;
            font-size: 12px;
            color: #333;
        }
        
        .filter-info p {
            margin: 3px 0;
            font-size: 9px;
            color: #666;
        }
        
        .report-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            font-size: 7px;
        }
        
        .report-table th,
        .report-table td {
            border: 1px solid #ddd;
            padding: 4px;
            text-align: center;
            vertical-align: middle;
        }
        
        .report-table th {
            background-color: #4CAF50;
            color: white;
            font-weight: bold;
            font-size: 8px;
        }
        
        .report-table .sub-header {
            background-color: #e3f2fd;
            color: #333;
            font-weight: bold;
            font-size: 7px;
        }
        
        .report-table .section-header {
            background-color: #f5f5f5;
            color: #333;
            font-weight: bold;
            font-size: 9px;
        }
        
        .report-table .professional-name {
            background-color: #fff3e0;
            font-weight: bold;
            text-align: left;
            padding-left: 8px;
            font-size: 8px;
        }
        
        .report-table .amount {
            font-weight: bold;
            color: #2e7d32;
        }
        
        .report-table .invoice-no {
            font-family: 'Courier New', monospace;
            font-size: 7px;
        }
        
        .footer {
            margin-top: 20px;
            text-align: center;
            font-size: 7px;
            color: #666;
            border-top: 1px solid #ddd;
            padding-top: 10px;
        }
        
        .no-data {
            text-align: center;
            padding: 30px;
            color: #666;
            font-size: 12px;
        }
        
        .page-break {
            page-break-after: always;
        }
        
        @media print {
            body {
                margin: 0;
                padding: 10px;
            }
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Booking Summary Report</h1>
        <h2>Professional & Customer Billing Details</h2>
    </div>
    
    <div class="filter-info">
        <h3>Report Filters</h3>
        <p><strong>Date Range:</strong> {{ $filterInfo['start_date'] }} to {{ $filterInfo['end_date'] }}</p>
        <p><strong>Professional:</strong> {{ $filterInfo['professional_name'] }}</p>
        <p><strong>Plan Type:</strong> {{ $filterInfo['plan_type'] }}</p>
        <p><strong>Generated On:</strong> {{ $generatedDate }}</p>
        <p><strong>Total Records:</strong> {{ count($bookings) }}</p>
    </div>
    
    @if(count($bookings) > 0)
        <table class="report-table">
            <thead>
                <tr>
                    <th rowspan="2" style="width: 12%;">Professional Name</th>
                    <th colspan="4" style="width: 20%;">Bill to the Customers</th>
                    <th colspan="4" style="width: 20%;">Bill to the Professional by platform for our services</th>
                    <th colspan="4" style="width: 20%;">TCS to be collected @1% on the net supply</th>
                    <th colspan="4" style="width: 20%;">Amount to be paid to the Professional</th>
                </tr>
                <tr>
                    <!-- Customer Bill Headers -->
                    <th class="sub-header">Invoice No</th>
                    <th class="sub-header">Date</th>
                    <th class="sub-header">Basic Amount</th>
                    <th class="sub-header">GST Total</th>
                    
                    <!-- Platform Bill Headers -->
                    <th class="sub-header">Invoice No</th>
                    <th class="sub-header">Date</th>
                    <th class="sub-header">Basic Amount</th>
                    <th class="sub-header">GST Total</th>
                    
                    <!-- TCS Headers -->
                    <th class="sub-header">Basic Amount</th>
                    <th class="sub-header">CGST</th>
                    <th class="sub-header">SGST</th>
                    <th class="sub-header">Total TCS</th>
                    
                    <!-- Professional Amount Headers -->
                    <th class="sub-header">Basic Amount</th>
                    <th class="sub-header">CGST</th>
                    <th class="sub-header">SGST</th>
                    <th class="sub-header">Total Amount</th>
                </tr>
            </thead>
            <tbody>
                @foreach($bookings as $booking)
                    @php
                        // Calculate customer bill (what customer pays)
                        $customerBasicAmount = $booking->base_amount ?? 0;
                        $customerCGST = $booking->cgst_amount ?? 0;
                        $customerSGST = $booking->sgst_amount ?? 0;
                        $customerIGST = $booking->igst_amount ?? 0;
                        $customerGSTTotal = $customerCGST + $customerSGST + $customerIGST;

                        // Calculate platform commission (assuming 20% of base amount)
                        $platformCommissionRate = 0.20;
                        $platformBasicAmount = $customerBasicAmount * $platformCommissionRate;
                        $platformCGST = $platformBasicAmount * 0.09; // 9% CGST
                        $platformSGST = $platformBasicAmount * 0.09; // 9% SGST
                        $platformGSTTotal = $platformCGST + $platformSGST;

                        // Calculate TCS @1% on net supply
                        $netSupply = $customerBasicAmount - $platformBasicAmount;
                        $tcsBasicAmount = $netSupply * 0.01;
                        $tcsCGST = $tcsBasicAmount * 0.09;
                        $tcsSGST = $tcsBasicAmount * 0.09;
                        $tcsTotal = $tcsBasicAmount + $tcsCGST + $tcsSGST;

                        // Calculate amount to be paid to professional
                        $professionalBasicAmount = $customerBasicAmount - $platformBasicAmount - $tcsBasicAmount;
                        $professionalCGST = $customerCGST - $platformCGST - $tcsCGST;
                        $professionalSGST = $customerSGST - $platformSGST - $tcsSGST;
                        $professionalTotal = $professionalBasicAmount + $professionalCGST + $professionalSGST;
                    @endphp
                    <tr>
                        <td class="professional-name">{{ $booking->professional->name ?? 'N/A' }}</td>
                        
                        <!-- Customer Bill -->
                        <td class="invoice-no">INV-{{ str_pad($booking->id, 6, '0', STR_PAD_LEFT) }}</td>
                        <td>{{ $booking->created_at->format('d/m/Y') }}</td>
                        <td class="amount">₹{{ number_format($customerBasicAmount, 2) }}</td>
                        <td class="amount">₹{{ number_format($customerGSTTotal, 2) }}</td>
                        
                        <!-- Platform Bill -->
                        <td class="invoice-no">PLT-{{ str_pad($booking->id, 6, '0', STR_PAD_LEFT) }}</td>
                        <td>{{ $booking->created_at->format('d/m/Y') }}</td>
                        <td class="amount">₹{{ number_format($platformBasicAmount, 2) }}</td>
                        <td class="amount">₹{{ number_format($platformGSTTotal, 2) }}</td>
                        
                        <!-- TCS -->
                        <td class="amount">₹{{ number_format($tcsBasicAmount, 2) }}</td>
                        <td class="amount">₹{{ number_format($tcsCGST, 2) }}</td>
                        <td class="amount">₹{{ number_format($tcsSGST, 2) }}</td>
                        <td class="amount">₹{{ number_format($tcsTotal, 2) }}</td>
                        
                        <!-- Professional Amount -->
                        <td class="amount">₹{{ number_format($professionalBasicAmount, 2) }}</td>
                        <td class="amount">₹{{ number_format($professionalCGST, 2) }}</td>
                        <td class="amount">₹{{ number_format($professionalSGST, 2) }}</td>
                        <td class="amount">₹{{ number_format($professionalTotal, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        
        <div class="footer">
            <p>This report contains {{ count($bookings) }} booking records with detailed billing information.</p>
            <p>Generated on {{ $generatedDate }} | Tazen Admin Panel</p>
        </div>
    @else
        <div class="no-data">
            <p>No booking records found for the selected criteria.</p>
        </div>
    @endif
</body>
</html>
