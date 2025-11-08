<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\McqAnswer;
use App\Models\ServiceMCQ;
use App\Models\User;

class TestMCQData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:mcq-data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test MCQ data relationships';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Testing MCQ data relationships...');
        
        // Check table names and counts
        $this->info('ServiceMCQ table: ' . (new ServiceMCQ())->getTable());
        $this->info('McqAnswer table: ' . (new McqAnswer())->getTable());
        
        $this->info('ServiceMCQ count: ' . ServiceMCQ::count());
        $this->info('McqAnswer count: ' . McqAnswer::count());
        
        // Check a specific user's answers
        $user = User::where('email', 'tania.titli2017@gmail.com')->first();
        if ($user) {
            $this->info('Found user: ' . $user->name . ' (ID: ' . $user->id . ')');
            
            $answers = McqAnswer::where('user_id', $user->id)->get();
            $this->info('User has ' . $answers->count() . ' MCQ answers');
            
            foreach ($answers as $answer) {
                $this->info('Answer ID: ' . $answer->id . 
                           ', service_mcq_id: ' . $answer->service_mcq_id . 
                           ', selected_answer: ' . $answer->selected_answer);
                           
                // Try to load the question
                $question = ServiceMCQ::find($answer->service_mcq_id);
                if ($question) {
                    $this->info('  -> Question found: ' . substr($question->question, 0, 50) . '...');
                } else {
                    $this->error('  -> Question NOT found for service_mcq_id: ' . $answer->service_mcq_id);
                }
            }
        } else {
            $this->error('User tania.titli2017@gmail.com not found');
        }
        
        return 0;
    }
}
