<?php

namespace App\Exports;

use Illuminate\Support\Collection;

class CommentsExport
{
    protected $comments;

    public function __construct($comments)
    {
        $this->comments = $comments;
    }

    public function toCsv()
    {
        $filename = 'blog-comments-' . date('Y-m-d') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() {
            $file = fopen('php://output', 'w');
            
            // Add CSV headers
            fputcsv($file, [
                'Sl.No',
                'Blog Post',
                'Commenter Name',
                'Email',
                'Mobile',
                'Comment',
                'Website',
                'Status',
                'Date Created',
            ]);

            // Add data rows
            $index = 1;
            foreach ($this->comments as $comment) {
                fputcsv($file, [
                    $index++,
                    $comment->blogPost->blog->title ?? 'N/A',
                    $comment->name,
                    $comment->email,
                    $comment->mobile ?? 'N/A',
                    $comment->comment,
                    $comment->website ?? 'N/A',
                    $comment->is_approved ? 'Approved' : 'Pending',
                    $comment->created_at->format('d M Y H:i'),
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
