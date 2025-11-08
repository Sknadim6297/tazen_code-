<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Booking;

class FixBookingServiceId extends Command
{
    protected $signature = 'fix:booking-service-id {bookingId}';
    protected $description = 'Fix booking service_id';

    public function handle()
    {
        $bookingId = $this->argument('bookingId');
        $booking = Booking::find($bookingId);
        
        if (!$booking) {
            $this->error("Booking {$bookingId} not found");
            return 1;
        }
        
        $this->info("Current booking {$bookingId} service_id: " . ($booking->service_id ?? 'NULL'));
        
        // Set service_id to 3 (Career Counsellor)
        $booking->service_id = 3;
        $booking->save();
        
        $this->info("Updated booking {$bookingId} service_id to 3");
        
        return 0;
    }
}