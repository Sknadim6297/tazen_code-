<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Booking;
use App\Models\McqAnswer;
use App\Models\User;

class DebugBookingIssue extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'debug:booking-issue {bookingId=15}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Debug specific booking MCQ issue';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $bookingId = $this->argument('bookingId');
        
        $this->info("Debugging booking ID: {$bookingId}");
        
        // Get the booking
        $booking = Booking::find($bookingId);
        
        if (!$booking) {
            $this->error("Booking {$bookingId} not found");
            return 1;
        }
        
        $this->info("Booking Details:");
        $this->info("  - ID: {$booking->id}");
        $this->info("  - User ID: {$booking->user_id}");
        $this->info("  - Service ID: " . ($booking->service_id ?? 'NULL'));
        $this->info("  - Service Name: " . ($booking->service_name ?? 'NULL'));
        $this->info("  - Customer: {$booking->customer_name}");
        $this->info("  - Professional ID: " . ($booking->professional_id ?? 'NULL'));
        
        // Get the user
        $user = User::find($booking->user_id);
        if ($user) {
            $this->info("  - User Email: {$user->email}");
        }
        
        // Check MCQ answers for this user
        $this->info("\nMCQ Answers for User {$booking->user_id}:");
        $mcqAnswers = McqAnswer::where('user_id', $booking->user_id)->get();
        
        if ($mcqAnswers->count() === 0) {
            $this->warn("No MCQ answers found for this user");
        } else {
            foreach ($mcqAnswers as $answer) {
                $this->info("  - Answer ID: {$answer->id}");
                $this->info("    Service ID: " . ($answer->service_id ?? 'NULL'));
                $this->info("    Booking ID: " . ($answer->booking_id ?? 'NULL'));
                $this->info("    Answer: {$answer->selected_answer}");
                $this->info("    ---");
            }
        }
        
        // Check if we can fix the booking by setting service_id
        if (!$booking->service_id && $mcqAnswers->count() > 0) {
            $serviceId = $mcqAnswers->first()->service_id;
            if ($serviceId) {
                $this->info("\nFound service_id {$serviceId} from MCQ answers");
                
                if ($this->confirm("Do you want to update booking {$bookingId} with service_id {$serviceId}?")) {
                    $booking->update(['service_id' => $serviceId]);
                    $this->info("Booking updated with service_id: {$serviceId}");
                }
            }
        }
        
        // Check if we can link MCQ answers to this booking
        if ($booking->service_id) {
            $orphanAnswers = McqAnswer::where('user_id', $booking->user_id)
                ->where('service_id', $booking->service_id)
                ->whereNull('booking_id')
                ->get();
            
            if ($orphanAnswers->count() > 0) {
                $this->info("\nFound {$orphanAnswers->count()} MCQ answers that can be linked to this booking");
                
                if ($this->confirm("Do you want to link these MCQ answers to booking {$bookingId}?")) {
                    McqAnswer::where('user_id', $booking->user_id)
                        ->where('service_id', $booking->service_id)
                        ->whereNull('booking_id')
                        ->update(['booking_id' => $booking->id]);
                    
                    $this->info("MCQ answers linked to booking {$bookingId}");
                }
            }
        }
        
        return 0;
    }
}
