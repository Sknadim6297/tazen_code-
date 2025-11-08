<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Booking;
use App\Models\McqAnswer;

class ListBookings extends Command
{
    protected $signature = 'list:bookings';
    protected $description = 'List all bookings with details';

    public function handle()
    {
        $this->info('All Bookings:');
        
        $bookings = Booking::select('id', 'customer_name', 'service_name', 'user_id', 'service_id')->get();
        
        foreach ($bookings as $booking) {
            $serviceIdDisplay = $booking->service_id ?? 'NULL';
            $this->info("ID: {$booking->id}, Customer: {$booking->customer_name}, Service: {$booking->service_name}, User: {$booking->user_id}, Service ID: {$serviceIdDisplay}");
            
            // Check MCQ answers for this booking
            $linkedAnswers = McqAnswer::where('booking_id', $booking->id)->count();
            $userAnswers = McqAnswer::where('user_id', $booking->user_id)->count();
            $userServiceAnswers = McqAnswer::where('user_id', $booking->user_id)->where('service_id', 3)->count(); // Career Counsellor is service_id 3
            $this->info("  - Linked MCQ answers: {$linkedAnswers}, Total user answers: {$userAnswers}, Career Counsellor answers: {$userServiceAnswers}");
        }
        
        // Show user 2's MCQ answers by service
        $this->info("\nUser 2's MCQ answers by service:");
        $userAnswers = McqAnswer::where('user_id', 2)->get(['id', 'service_id', 'selected_answer']);
        foreach ($userAnswers as $answer) {
            $answerText = substr($answer->selected_answer, 0, 30) . '...';
            $this->info("  Answer ID: {$answer->id}, Service ID: {$answer->service_id}, Answer: {$answerText}");
        }
        
        return 0;
    }
}
