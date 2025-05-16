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
                            <td data-label="Customer Name">Ishita</td>
                            <td data-label="Session Type"><span class="badge badge-weekly">Weekly</span></td>
                            <td data-label="Month">Jan</td>
                            <td data-label="Amount">₹1,000</td>
                        </tr>
                        <tr>
                            <td data-label="Customer Name">Chanchal</td>
                            <td data-label="Session Type"><span class="badge badge-monthly">Monthly</span></td>
                            <td data-label="Month">Jan</td>
                            <td data-label="Amount">₹4,800</td>
                        </tr>
                        <tr>
                            <td data-label="Customer Name">Rohit</td>
                            <td data-label="Session Type"><span class="badge badge-quarterly">Quarterly</span></td>
                            <td data-label="Month">Jan</td>
                            <td data-label="Amount">₹6,800</td>
                        </tr>
                        <tr class="total-row">
                            <td colspan="3" style="text-align: right;">Total Billing:</td>
                            <td>₹12,600</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<style>
    :root {
        --primary: #5a67d8;
        --primary-light: #7f9cf5;
        --primary-dark: #4c51bf;
        --secondary: #48bb78;
        --danger: #f56565;
        --warning: #ed8936;
        --gray-100: #f7fafc;
        --gray-200: #edf2f7;
        --gray-300: #e2e8f0;
        --gray-400: #cbd5e0;
        --gray-500: #a0aec0;
        --gray-600: #718096;
        --gray-700: #4a5568;
        --gray-800: #2d3748;
        --gray-900: #1a202c;
    }

    .content-wrapper {
        background-color: #f8fafc;
        min-height: calc(100vh - 60px);
        padding: 30px;
    }

    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 30px;
        flex-wrap: wrap;
        gap: 15px;
    }

    .page-title h3 {
        font-size: 1.75rem;
        font-weight: 700;
        color: var(--gray-800);
        margin: 0;
        position: relative;
        padding-left: 15px;
    }

    .page-title h3::before {
        content: '';
        position: absolute;
        left: 0;
        top: 5px;
        bottom: 5px;
        width: 4px;
        background: var(--primary);
        border-radius: 4px;
    }

    .breadcrumb {
        display: flex;
        list-style: none;
        padding: 0;
        margin: 0;
        align-items: center;
        font-size: 0.875rem;
    }

    .breadcrumb li {
        color: var(--gray-600);
        display: flex;
        align-items: center;
    }

    .breadcrumb li:not(:last-child)::after {
        content: '/';
        margin: 0 8px;
        color: var(--gray-400);
    }

    .breadcrumb li.active {
        color: var(--primary);
        font-weight: 500;
    }

    .card {
        background: white;
        border-radius: 12px;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03);
        border: none;
        overflow: hidden;
        margin-bottom: 30px;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .card:hover {
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        transform: translateY(-2px);
    }

    .card-header {
        padding: 20px 25px;
        background: white;
        border-bottom: 1px solid var(--gray-200);
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .card-header h4 {
        font-size: 1.25rem;
        font-weight: 600;
        color: var(--gray-800);
        margin: 0;
    }

    .card-body {
        padding: 25px;
    }

    .table-responsive {
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }

    /* Updated table styling for bordered design */
    .data-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
        font-size: 0.9375rem;
        border: 1px solid var(--gray-300);
        border-radius: 8px;
    }

    .data-table thead th {
        background: var(--gray-100);
        color: var(--gray-700);
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.8125rem;
        letter-spacing: 0.5px;
        padding: 14px 15px;
        text-align: left;
        position: sticky;
        top: 0;
        z-index: 10;
        border-bottom: 2px solid var(--gray-300);
        border-right: 1px solid var(--gray-300);
    }

    .data-table thead th:last-child {
        border-right: none;
    }

    .data-table tbody tr {
        transition: background-color 0.2s ease;
    }

    .data-table tbody tr:hover {
        background-color: var(--gray-50);
    }

    .data-table tbody td {
        padding: 15px;
        color: var(--gray-700);
        border-bottom: 1px solid var(--gray-300);
        border-right: 1px solid var(--gray-300);
        vertical-align: middle;
    }

    .data-table tbody td:last-child {
        border-right: none;
    }

    .data-table tbody tr:last-child td {
        border-bottom: none;
    }

    .data-table tbody tr.total-row {
        background-color: var(--gray-100);
        font-weight: 600;
        color: var(--gray-800);
    }

    .data-table tbody tr.total-row:hover {
        background-color: var(--gray-100);
    }

    .data-table tbody tr.total-row td {
        border-top: 2px solid var(--gray-400);
    }

    .badge {
        display: inline-block;
        padding: 4px 8px;
        border-radius: 12px;
        font-size: 0.75rem;
        font-weight: 600;
        line-height: 1;
    }

    .badge-weekly {
        background-color: rgba(56, 178, 172, 0.1);
        color: #38b2ac;
    }

    .badge-monthly {
        background-color: rgba(102, 126, 234, 0.1);
        color: #667eea;
    }

    .badge-quarterly {
        background-color: rgba(237, 137, 54, 0.1);
        color: #ed8936;
    }

    /* Export button styling */
    .btn-export {
        display: flex;
        align-items: center;
        gap: 8px;
        background-color: var(--primary);
        color: white;
        border: none;
        border-radius: 6px;
        padding: 8px 16px;
        font-size: 0.875rem;
        font-weight: 500;
        cursor: pointer;
        transition: background-color 0.2s ease;
    }

    .btn-export:hover {
        background-color: var(--primary-dark);
    }

    @media (max-width: 768px) {
        .content-wrapper {
            padding: 20px 15px;
        }
        
        .card-header {
            padding: 15px 20px;
        }
        
        .card-body {
            padding: 20px;
        }
        
        .data-table thead {
            display: none;
        }
        
        .data-table tbody tr {
            display: block;
            margin-bottom: 15px;
            border: 1px solid var(--gray-300);
            border-radius: 8px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }
        
        .data-table tbody td {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 12px 15px;
            border-bottom: 1px solid var(--gray-300);
            border-right: none;
        }
        
        .data-table tbody td::before {
            content: attr(data-label);
            font-weight: 600;
            color: var(--gray-600);
            margin-right: 15px;
            flex: 1;
        }
        
        .data-table tbody td span {
            flex: 2;
            text-align: right;
        }
        
        .data-table tbody tr.total-row {
            background-color: var(--gray-100);
            border-top: 2px solid var(--gray-400);
        }
        
        .data-table tbody tr.total-row td {
            display: flex;
            justify-content: space-between;
            text-align: right;
        }
    }
</style>
@endsection

@section('scripts')
<script>
    // Add any necessary JavaScript here
    document.addEventListener('DOMContentLoaded', function() {
        // Add interactive elements if needed
    });
</script>
@endsection