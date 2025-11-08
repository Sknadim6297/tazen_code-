<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Service;
use App\Models\ServiceMCQ;
use App\Models\McqAnswer;
use App\Models\User;

class CreateSampleMCQData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create:mcq-data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create sample MCQ questions and answers for testing';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Creating sample MCQ data...');

        // Get first service
        $service = Service::first();
        if (!$service) {
            $this->error('No service found! Please create a service first.');
            return 1;
        }

        $this->info("Using service: " . $service->name);

        // Create sample MCQ questions
        $questions = [
            [
                'question' => 'What is your primary goal for this consultation?',
                'options' => ['Career Change', 'Skill Development', 'Job Search', 'Personal Growth'],
                'has_other_option' => true
            ],
            [
                'question' => 'What is your current experience level?',
                'options' => ['Beginner', 'Intermediate', 'Advanced', 'Expert'],
                'has_other_option' => false
            ],
            [
                'question' => 'Which area do you need the most help with?',
                'options' => ['Technical Skills', 'Soft Skills', 'Industry Knowledge', 'Networking'],
                'has_other_option' => true
            ]
        ];

        foreach ($questions as $questionData) {
            ServiceMCQ::updateOrCreate(
                [
                    'service_id' => $service->id,
                    'question' => $questionData['question']
                ],
                [
                    'question_type' => 'mcq',
                    'options' => $questionData['options'],
                    'has_other_option' => $questionData['has_other_option']
                ]
            );
        }

        $this->info('Sample MCQ questions created successfully!');

        // Create sample answers
        $user = User::first();
        if (!$user) {
            $this->error('No user found! Please create a user first.');
            return 1;
        }

        $this->info("Creating sample answers for user: " . $user->name);

        $mcqQuestions = ServiceMCQ::where('service_id', $service->id)->get();
        $sampleAnswers = [
            'Career Change',
            'Intermediate', 
            'Technical Skills'
        ];

        foreach ($mcqQuestions as $index => $question) {
            McqAnswer::updateOrCreate(
                [
                    'user_id' => $user->id,
                    'service_mcq_id' => $question->id,
                    'service_id' => $service->id
                ],
                [
                    'question' => $question->question,
                    'selected_answer' => $sampleAnswers[$index] ?? 'Sample Answer',
                    'other_answer' => null
                ]
            );
        }

        $this->info('Sample MCQ answers created successfully!');
        $this->info('You can now test the MCQ display in admin panel and professional views.');

        return 0;
    }
}
