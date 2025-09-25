<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class McqAnswersExport implements FromView, WithTitle, ShouldAutoSize
{
    protected $mcqAnswers;

    public function __construct($mcqAnswers)
    {
        $this->mcqAnswers = $mcqAnswers;
    }

    public function view(): View
    {
        // Group the results by user and service
        $groupedAnswers = [];
        foreach ($this->mcqAnswers as $answer) {
            $key = $answer->user_id . '_' . $answer->service_id;
            if (!isset($groupedAnswers[$key])) {
                $groupedAnswers[$key] = [
                    'user' => $answer->user,
                    'service' => $answer->service,
                    'professional' => $answer->booking ? $answer->booking->professional : null,
                    'answers' => [],
                    'created_at' => $answer->created_at
                ];
            }
            $groupedAnswers[$key]['answers'][] = $answer;
        }

        return view('admin.mcq.mcq-answers-excel', compact('groupedAnswers'));
    }

    public function title(): string
    {
        return 'MCQ Answers';
    }
}
