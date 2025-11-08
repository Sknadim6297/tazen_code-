<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\McqAnswer;
use App\Models\User;

class TestPDFData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:pdf-data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test the exact data that goes to PDF export';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Testing PDF export data...');
        
        // Simulate the exact query that the PDF export uses
        $user = User::where('email', 'tania.titli2017@gmail.com')->first();
        
        if (!$user) {
            $this->error('User not found');
            return 1;
        }
        
        $query = McqAnswer::with(['user', 'service', 'serviceMcq', 'booking.professional.profile']);
        $query->where('user_id', $user->id);
        
        $mcqAnswers = $query->orderBy('user_id')
                           ->orderBy('service_id')
                           ->orderBy('created_at')
                           ->get();
        
        $this->info('Found ' . $mcqAnswers->count() . ' answers for PDF export');
        
        // Simulate the grouping that happens in the PDF export
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
        
        $this->info('Grouped into ' . count($groupedAnswers) . ' groups');
        
        // Test each answer in each group - exactly like the PDF template does
        foreach ($groupedAnswers as $key => $group) {
            $this->info('Group: ' . $key);
            $this->info('  User: ' . ($group['user']->name ?? 'N/A'));
            $this->info('  Service: ' . ($group['service']->name ?? 'N/A'));
            $this->info('  Answers: ' . count($group['answers']));
            
            foreach ($group['answers'] as $index => $answer) {
                $questionText = $answer->serviceMcq->question ?? 'Question not found';
                $selectedAnswer = $answer->selected_answer ?? 'No answer';
                
                $this->info('    Answer ' . ($index + 1) . ':');
                $this->info('      Question: ' . substr($questionText, 0, 50) . '...');
                $this->info('      Answer: ' . $selectedAnswer);
                $this->info('      Relationship loaded: ' . ($answer->serviceMcq ? 'YES' : 'NO'));
                $this->info('      service_mcq_id: ' . $answer->service_mcq_id);
                
                if ($answer->serviceMcq) {
                    $this->info('      Question ID: ' . $answer->serviceMcq->id);
                    $this->info('      Question text: ' . ($answer->serviceMcq->question ?? 'NULL'));
                    $this->info('      Question exists: ' . (!empty($answer->serviceMcq->question) ? 'YES' : 'NO'));
                } else {
                    $this->error('      No serviceMcq relationship!');
                }
            }
        }
        
        return 0;
    }
}
