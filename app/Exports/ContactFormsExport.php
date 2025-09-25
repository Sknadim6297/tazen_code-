<?php

namespace App\Exports;

use Illuminate\Support\Collection;

class ContactFormsExport
{
    protected $submissions;

    public function __construct($submissions)
    {
        $this->submissions = $submissions;
    }

    public function toCsv()
    {
        $filename = 'contact-forms-' . date('Y-m-d') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() {
            $file = fopen('php://output', 'w');
            
            // Add CSV headers
            fputcsv($file, [
                'Sl.No',
                'Name',
                'Email',
                'Phone',
                'Message',
                'Verification Answer',
                'Submitted At',
            ]);

            // Add data rows
            $index = 1;
            foreach ($this->submissions as $submission) {
                fputcsv($file, [
                    $index++,
                    $submission->name,
                    $submission->email,
                    $submission->phone ?? 'N/A',
                    $submission->message,
                    $submission->verification_answer ?? 'N/A',
                    $submission->created_at->format('d M Y H:i'),
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
