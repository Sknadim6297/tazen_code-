<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Blog Comments Export</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            margin: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        .title {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 10px;
        }
        .date {
            font-size: 12px;
            color: #666;
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
            vertical-align: top;
        }
        th {
            background-color: #f5f5f5;
            font-weight: bold;
        }
        .status-approved {
            color: #28a745;
            font-weight: bold;
        }
        .status-pending {
            color: #ffc107;
            font-weight: bold;
        }
        .comment-text {
            max-width: 200px;
            word-wrap: break-word;
        }
        .blog-title {
            max-width: 150px;
            word-wrap: break-word;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="title">Blog Comments Report</div>
        <div class="date">Generated on: {{ date('d M Y H:i') }}</div>
        <div class="date">Total Comments: {{ count($comments) }}</div>
    </div>

    <table>
        <thead>
            <tr>
                <th width="5%">Sl.No</th>
                <th width="15%">Blog Post</th>
                <th width="12%">Commenter</th>
                <th width="12%">Email</th>
                <th width="10%">Mobile</th>
                <th width="25%">Comment</th>
                <th width="10%">Status</th>
                <th width="11%">Date</th>
            </tr>
        </thead>
        <tbody>
            @foreach($comments as $index => $comment)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td class="blog-title">{{ $comment->blogPost->blog->title ?? 'N/A' }}</td>
                <td>{{ $comment->name }}</td>
                <td>{{ $comment->email }}</td>
                <td>{{ $comment->mobile ?? 'N/A' }}</td>
                <td class="comment-text">{{ Str::limit($comment->comment, 100) }}</td>
                <td>
                    @if($comment->is_approved)
                        <span class="status-approved">Approved</span>
                    @else
                        <span class="status-pending">Pending</span>
                    @endif
                </td>
                <td>{{ $comment->created_at->format('d M Y') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    @if(count($comments) == 0)
        <div style="text-align: center; margin-top: 50px; color: #666;">
            No comments found for the selected criteria.
        </div>
    @endif
</body>
</html>
