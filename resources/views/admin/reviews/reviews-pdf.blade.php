<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Customer Reviews Report</title>
    <style>
        @font-face {
            font-family: 'DejaVu Sans';
            src: url('{{ storage_path('fonts/DejaVuSans.ttf') }}');
            font-weight: normal;
            font-style: normal;
        }
        
        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 12px;
            line-height: 1.5;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .logo {
            max-width: 150px;
            margin-bottom: 10px;
        }
        h1 {
            font-size: 18px;
            margin-bottom: 5px;
        }
        .date {
            font-size: 12px;
            margin-bottom: 20px;
        }
        .filter-info {
            font-size: 10px;
            margin-bottom: 15px;
            padding: 5px;
            background-color: #f8f9fa;
            border-radius: 4px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 5px;
            text-align: left;
            font-size: 10px;
        }
        th {
            background-color: #f2f2f2;
        }
        .summary {
            margin-top: 20px;
            margin-bottom: 30px;
            width: 50%;
        }
        .footer {
            margin-top: 30px;
            font-size: 10px;
            text-align: center;
            color: #777;
        }
        .ratings {
            color: #FFD700;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>CUSTOMER REVIEWS REPORT</h1>
        <div class="date">Generated on: {{ $filterInfo['generated_at'] }}</div>
    </div>
    
    <div class="filter-info">
        <strong>Filter:</strong> Date: {{ $filterInfo['start_date'] }} to {{ $filterInfo['end_date'] }} | 
        Rating: {{ $filterInfo['rating'] }} | Professional: {{ $filterInfo['professional'] }}
    </div>
    
    <div class="summary">
        <table>
            <tr>
                <th colspan="2">Summary</th>
            </tr>
            <tr>
                <td>Total Reviews</td>
                <td>{{ $totalReviews }}</td>
            </tr>
            <tr>
                <td>Average Rating</td>
                <td>{{ number_format($averageRating, 1) }} / 5.0</td>
            </tr>
            <tr>
                <td>5 Star Reviews</td>
                <td>{{ $ratingDistribution[5] }} ({{ $totalReviews > 0 ? number_format(($ratingDistribution[5] / $totalReviews) * 100, 1) : 0 }}%)</td>
            </tr>
            <tr>
                <td>4 Star Reviews</td>
                <td>{{ $ratingDistribution[4] }} ({{ $totalReviews > 0 ? number_format(($ratingDistribution[4] / $totalReviews) * 100, 1) : 0 }}%)</td>
            </tr>
            <tr>
                <td>3 Star Reviews</td>
                <td>{{ $ratingDistribution[3] }} ({{ $totalReviews > 0 ? number_format(($ratingDistribution[3] / $totalReviews) * 100, 1) : 0 }}%)</td>
            </tr>
            <tr>
                <td>2 Star Reviews</td>
                <td>{{ $ratingDistribution[2] }} ({{ $totalReviews > 0 ? number_format(($ratingDistribution[2] / $totalReviews) * 100, 1) : 0 }}%)</td>
            </tr>
            <tr>
                <td>1 Star Reviews</td>
                <td>{{ $ratingDistribution[1] }} ({{ $totalReviews > 0 ? number_format(($ratingDistribution[1] / $totalReviews) * 100, 1) : 0 }}%)</td>
            </tr>
        </table>
    </div>
    
    <table>
        <thead>
            <tr>
                <th>No.</th>
                <th>Date</th>
                <th>Customer Name</th>
                <th>Professional Name</th>
                <th>Rating</th>
                <th>Review Text</th>
            </tr>
        </thead>
        <tbody>
            @forelse($reviews as $key => $review)
            <tr>
                <td>{{ $key + 1 }}</td>
                <td>{{ $review->created_at->format('d M Y') }}</td>
                <td>{{ $review->user->name ?? 'N/A' }}</td>
                <td>{{ $review->professional->name ?? 'N/A' }}</td>
                <td>{{ $review->rating }}/5</td>
                <td>{{ $review->review_text }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="6" style="text-align:center">No reviews found</td>
            </tr>
            @endforelse
        </tbody>
    </table>
    
    <div class="footer">
        © {{ date('Y') }} Tazen - Customer Reviews Report
    </div>
    
    <script type="text/php">
        if (isset($pdf)) {
            $text = "Page {PAGE_NUM} of {PAGE_COUNT}";
            $size = 8;
            $font = $fontMetrics->getFont("DejaVu Sans");
            $width = $fontMetrics->get_text_width($text, $font, $size) / 2;
            $x = ($pdf->get_width() - $width) - 15;
            $y = $pdf->get_height() - 15;
            $pdf->page_text($x, $y, $text, $font, $size);
        }
    </script>
</body>
</html>