<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\FAQ;

class FAQSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faqs = [
            [
                'question' => 'What are the benefits of outsourcing financial services?',
                'answer' => 'Outsourcing financial services provides cost savings, access to specialized expertise, improved efficiency, and allows you to focus on core business activities while ensuring compliance and accuracy in financial management.',
                'order' => 1,
                'status' => true,
            ],
            [
                'question' => 'How do I choose the right financial consultant for my business?',
                'answer' => 'Look for consultants with relevant experience in your industry, proper certifications, positive client reviews, clear communication skills, and a proven track record of helping businesses achieve their financial goals.',
                'order' => 2,
                'status' => true,
            ],
            [
                'question' => 'Do I need to prepare something for my financial consultant?',
                'answer' => 'Yes, prepare your financial statements, tax returns, business plans, bank statements, and any specific questions or goals you want to discuss. The more organized your information, the better advice you\'ll receive.',
                'order' => 3,
                'status' => true,
            ],
            [
                'question' => 'What type of services can I find in the Finance category?',
                'answer' => 'Our Finance category includes bookkeeping, tax preparation, financial planning, investment advice, business consulting, accounting services, financial modeling, and compliance assistance.',
                'order' => 4,
                'status' => true,
            ],
            [
                'question' => 'How do I find good financial experts on our platform?',
                'answer' => 'Browse our verified financial experts, read their profiles and reviews, check their portfolios, and communicate directly to ensure they understand your specific needs before making a decision.',
                'order' => 5,
                'status' => true,
            ],
            [
                'question' => 'Can I hire a financial consultant in less than 48 hours?',
                'answer' => 'Yes, many of our financial consultants are available for quick turnaround projects. Look for professionals with "Express Delivery" badges or contact them directly to discuss urgent requirements.',
                'order' => 6,
                'status' => true,
            ],
        ];

        foreach ($faqs as $faq) {
            FAQ::create($faq);
        }
    }
}
