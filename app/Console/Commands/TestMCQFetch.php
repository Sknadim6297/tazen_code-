<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\ServiceMCQ;

class TestMCQFetch extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:mcq-fetch';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test MCQ question fetching for Career Counsellor service';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Testing MCQ question fetching...');
        
        // Get Career Counsellor service ID (assuming it's service ID 3 based on the context)
        $serviceId = 3; // Career Counsellor service
        
        $this->info('Fetching questions for service ID: ' . $serviceId);
        
        // Test the old method (only MCQ)
        $mcqOnly = ServiceMCQ::where('service_id', $serviceId)
                             ->where('question_type', 'mcq')
                             ->get();
        
        $this->info('MCQ questions only: ' . $mcqOnly->count());
        
        // Test the new method (MCQ + Text)
        $allQuestions = ServiceMCQ::getQuestionsForService($serviceId);
        
        $this->info('All questions (MCQ + Text): ' . $allQuestions->count());
        
        $this->info('Questions breakdown:');
        foreach ($allQuestions as $index => $question) {
            $this->info(($index + 1) . '. [' . strtoupper($question->question_type) . '] ' . 
                       substr($question->question, 0, 50) . '...');
        }
        
        return 0;
    }
}
