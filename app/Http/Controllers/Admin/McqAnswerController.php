<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\McqAnswer;
use App\Models\Service;
use App\Models\User;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class McqAnswerController extends Controller
{
    public function index(Request $request)
    {
        $query = McqAnswer::with(['user', 'service', 'question', 'booking.professional.profile']);
        if ($request->has('username') && !empty(trim($request->username))) {
            $username = trim($request->username);
            $query->whereHas('user', function ($q) use ($username) {
                $q->where('name', 'like', '%' . $username . '%')
                  ->orWhere('email', 'like', '%' . $username . '%');
            });
        }
        if ($request->has('service') && $request->service != '') {
            $query->where('service_id', $request->service);
        }
        if ($request->has('start_date') && !empty($request->start_date)) {
            $startDate = date('Y-m-d 00:00:00', strtotime($request->start_date));
            $query->where('created_at', '>=', $startDate);
        }
        if ($request->has('end_date') && !empty($request->end_date)) {
            $endDate = date('Y-m-d 23:59:59', strtotime($request->end_date));
            $query->where('created_at', '<=', $endDate);
        }
        $mcqAnswers = $query->orderBy('user_id')
                           ->orderBy('service_id')
                           ->orderBy('created_at')
                           ->paginate(100)->appends($request->all());
        $groupedAnswers = [];
        foreach ($mcqAnswers as $answer) {
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
        $services = Service::orderBy('name')->get();
        $totalRecords = McqAnswer::count();
        $filteredRecords = $mcqAnswers->total();

        return view('admin.mcq.index', compact('mcqAnswers', 'groupedAnswers', 'services', 'totalRecords', 'filteredRecords'));
    }

    public function export(Request $request)
    {
        $query = McqAnswer::with(['user', 'service', 'question', 'booking.professional.profile']);
        
        // Filter by specific user_id (for single group download)
        if ($request->has('user_id') && $request->user_id != '') {
            $query->where('user_id', $request->user_id);
        }
        
        // Filter by username search (for general export)
        if ($request->has('username') && !empty(trim($request->username))) {
            $username = trim($request->username);
            $query->whereHas('user', function ($q) use ($username) {
                $q->where('name', 'like', '%' . $username . '%')
                  ->orWhere('email', 'like', '%' . $username . '%');
            });
        }

        if ($request->has('service') && $request->service != '') {
            $query->where('service_id', $request->service);
        }

        if ($request->has('start_date') && !empty($request->start_date)) {
            $startDate = date('Y-m-d 00:00:00', strtotime($request->start_date));
            $query->where('created_at', '>=', $startDate);
        }

        if ($request->has('end_date') && !empty($request->end_date)) {
            $endDate = date('Y-m-d 23:59:59', strtotime($request->end_date));
            $query->where('created_at', '<=', $endDate);
        }

        $mcqAnswers = $query->orderBy('user_id')
                           ->orderBy('service_id')
                           ->orderBy('created_at')
                           ->get();

        if ($request->type === 'excel') {
            return $this->exportMcqAnswersToExcel($mcqAnswers);
        }

        if ($request->type === 'pdf') {
            return $this->exportMcqAnswersToPdf($mcqAnswers, $request);
        }

        return redirect()->back()->with('error', 'Invalid export type.');
    }

    /**
     * Export MCQ answers data to Excel (CSV format).
     */
    public function exportMcqAnswersToExcel($mcqAnswers)
    {
        $filename = 'mcq_answers_report_' . date('Y_m_d_His') . '.csv';
        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ];
        $callback = function() use ($mcqAnswers) {
            $file = fopen('php://output', 'w');
            fputs($file, "\xEF\xBB\xBF");
            fputcsv($file, [
                'ID',
                'User Name',
                'User Email',
                'Service Name',
                'Professional Name',
                'Professional Specialization',
                'Question',
                'Answer',
                'Date'
            ]);
            foreach ($mcqAnswers as $answer) {
                fputcsv($file, [
                    $answer->id,
                    $answer->user->name ?? 'N/A',
                    $answer->user->email ?? 'N/A',
                    $answer->service->name ?? 'N/A',
                    $answer->booking && $answer->booking->professional ? $answer->booking->professional->name : 'Not Assigned',
                    $answer->booking && $answer->booking->professional && $answer->booking->professional->profile ? $answer->booking->professional->profile->specialization : 'N/A',
                    $answer->question->question ?? 'Question not found',
                    $answer->answer,
                    $answer->created_at->format('Y-m-d H:i:s')
                ]);
            }
            
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Export MCQ answers data to PDF.
     */
    public function exportMcqAnswersToPdf($mcqAnswers, $request = null)
    {
        $groupedAnswers = [];
        foreach ($mcqAnswers as $answer) {
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

        // Generate filename
        $filename = 'mcq-answers-';
        
        // If downloading single group, add user name to filename
        if ($request && $request->has('user_id') && count($groupedAnswers) == 1) {
            $firstGroup = reset($groupedAnswers);
            $userName = $firstGroup['user']->name ?? 'user';
            $serviceName = $firstGroup['service']->name ?? 'service';
            $filename .= strtolower(str_replace(' ', '-', $userName)) . '-' . strtolower(str_replace(' ', '-', $serviceName)) . '-';
        }
        
        $filename .= date('Y-m-d') . '.pdf';

        $pdf = Pdf::loadView('admin.mcq.mcq-answers-pdf', compact('groupedAnswers'))
                  ->setPaper('a4', 'portrait');
        
        return $pdf->download($filename);
    }
}