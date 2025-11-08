<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Service;
use App\Models\ServiceMCQ;

class ServiceMCQSeeder extends Seeder
{
    public function run(): void
    {
        // Get the first service for testing
        $service = Service::first();
        
        if (!$service) {
            $this->command->error('No services found. Please create services first.');
            return;
        }

        $this->command->info("Creating MCQ questions for service: {$service->name} (ID: {$service->id})");

        // Create sample MCQ questions
        $mcqQuestions = [
            [
                'service_id' => $service->id,
                'question' => 'How would you rate the overall quality of our service?',
                'question_type' => 'single_choice',
                'options' => json_encode(['Excellent', 'Good', 'Average', 'Poor']),
                'has_other_option' => false
            ],
            [
                'service_id' => $service->id,
                'question' => 'What aspects of our service did you find most valuable? (Select all that apply)',
                'question_type' => 'multiple_choice',
                'options' => json_encode(['Speed of delivery', 'Quality of work', 'Communication', 'Pricing', 'Professional expertise']),
                'has_other_option' => true
            ],
            [
                'service_id' => $service->id,
                'question' => 'Would you recommend our service to others?',
                'question_type' => 'single_choice',
                'options' => json_encode(['Definitely yes', 'Probably yes', 'Not sure', 'Probably no', 'Definitely no']),
                'has_other_option' => false
            ],
            [
                'service_id' => $service->id,
                'question' => 'How did you hear about our service?',
                'question_type' => 'single_choice',
                'options' => json_encode(['Social media', 'Website', 'Friend referral', 'Search engine', 'Advertisement']),
                'has_other_option' => true
            ]
        ];

        foreach ($mcqQuestions as $mcq) {
            ServiceMCQ::create($mcq);
        }

        $this->command->info('Successfully created ' . count($mcqQuestions) . ' MCQ questions.');
    }
}
