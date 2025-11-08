<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\McqAnswer;
use App\Models\Booking;
use App\Models\User;
use App\Models\Professional;
use App\Models\BookingTimedate;
use Carbon\Carbon;

class FixMCQBookingLinks extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fix:mcq-booking-links';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a test booking and link MCQ answers to it';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Creating test booking and linking MCQ answers...');
        
        // Get the user (Tania Ghosh)
        $user = User::where('email', 'tania.titli2017@gmail.com')->first();
        if (!$user) {
            $this->error('User not found');
            return 1;
        }
        
        // Get any professional (we'll use the first one)
        $professional = Professional::first();
        if (!$professional) {
            $this->error('No professional found');
            return 1;
        }
        
        // Check if there are MCQ answers without booking_id
        $orphanAnswers = McqAnswer::where('user_id', $user->id)->whereNull('booking_id')->get();
        
        if ($orphanAnswers->count() === 0) {
            $this->info('No orphan MCQ answers found');
            return 0;
        }
        
        $this->info("Found {$orphanAnswers->count()} MCQ answers without booking_id");
        
        // Create a test booking
        $booking = Booking::create([
            'user_id' => $user->id,
            'professional_id' => $professional->id,
            'customer_name' => $user->name,
            'customer_email' => $user->email,
            'customer_phone' => '1234567890',
            'booking_date' => Carbon::today(),
            'plan_type' => 'monthly',
            'month' => 'November 2025',
            'days' => '1',
            'time_slot' => '10:00 AM - 11:00 AM'
        ]);
        
        $this->info("Created test booking with ID: {$booking->id}");
        
        // Create a booking timedate
        BookingTimedate::create([
            'booking_id' => $booking->id,
            'date' => Carbon::today()->format('Y-m-d'),
            'time_slot' => '10:00 AM - 11:00 AM',
            'status' => 'pending'
        ]);
        
        // Link MCQ answers to this booking
        $updatedCount = McqAnswer::where('user_id', $user->id)
            ->where('service_id', 3)
            ->whereNull('booking_id')
            ->update(['booking_id' => $booking->id]);
        
        $this->info("Linked {$updatedCount} MCQ answers to booking {$booking->id}");
        
        // Verify the linking
        $linkedAnswers = McqAnswer::where('booking_id', $booking->id)->count();
        $this->info("Verification: {$linkedAnswers} MCQ answers are now linked to the booking");
        
        $this->info('Fix completed successfully!');
        return 0;
    }
}
