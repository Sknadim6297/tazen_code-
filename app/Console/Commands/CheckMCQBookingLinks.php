<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\McqAnswer;
use App\Models\Booking;
use App\Models\User;

class CheckMCQBookingLinks extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check:mcq-booking-links';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check MCQ answers and their booking relationships';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Checking MCQ-Booking relationships...');
        
        // Get the user (Tania Ghosh)
        $user = User::where('email', 'tania.titli2017@gmail.com')->first();
        if (!$user) {
            $this->error('User not found');
            return 1;
        }
        
        $this->info("Checking for user: {$user->name} (ID: {$user->id})");
        
        // Get all MCQ answers for this user
        $mcqAnswers = McqAnswer::where('user_id', $user->id)->get();
        $this->info("Found {$mcqAnswers->count()} MCQ answers");
        
        foreach ($mcqAnswers as $answer) {
            $this->info("Answer ID: {$answer->id}");
            $this->info("  - Service ID: {$answer->service_id}");
            $this->info("  - Booking ID: " . ($answer->booking_id ?? 'NULL'));
            $this->info("  - Answer: {$answer->selected_answer}");
        }
        
        // Get all bookings for this user
        $bookings = Booking::where('user_id', $user->id)->get();
        $this->info("\nFound {$bookings->count()} bookings for this user");
        
        foreach ($bookings as $booking) {
            $this->info("Booking ID: {$booking->id}");
            $this->info("  - Service: {$booking->service_name}");
            $this->info("  - Professional: {$booking->professional_name}");
            $this->info("  - Date: {$booking->booking_date}");
            
            // Check MCQ answers for this booking
            $bookingAnswers = McqAnswer::where('booking_id', $booking->id)->get();
            $this->info("  - MCQ Answers: {$bookingAnswers->count()}");
            
            if ($bookingAnswers->count() === 0) {
                $this->warn("    WARNING: No MCQ answers linked to this booking!");
            }
        }
        
        // Check for MCQ answers without booking_id
        $orphanAnswers = McqAnswer::where('user_id', $user->id)->whereNull('booking_id')->get();
        if ($orphanAnswers->count() > 0) {
            $this->error("\nFound {$orphanAnswers->count()} MCQ answers without booking_id!");
            foreach ($orphanAnswers as $answer) {
                $this->error("  - Answer ID: {$answer->id}, Service ID: {$answer->service_id}");
            }
        }
        
        return 0;
    }
}
