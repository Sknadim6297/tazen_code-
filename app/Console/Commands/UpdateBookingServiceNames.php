<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Booking;
use App\Models\ProfessionalService;

class UpdateBookingServiceNames extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'booking:update-service-names';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update null/empty service names in existing bookings';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting to update booking service names...');
        
        // Find bookings with null or empty service names
        $bookings = Booking::where(function($query) {
            $query->whereNull('service_name')
                  ->orWhere('service_name', '')
                  ->orWhere('service_name', 'N/A');
        })->get();
        
        $this->info("Found {$bookings->count()} bookings with missing service names.");
        
        $updated = 0;
        $bar = $this->output->createProgressBar($bookings->count());
        $bar->start();
        
        foreach ($bookings as $booking) {
            $serviceName = null;
            
            // Try to get service name from professional's service
            if ($booking->professional_id) {
                $professionalService = ProfessionalService::with('service')
                    ->where('professional_id', $booking->professional_id)
                    ->first();
                
                if ($professionalService) {
                    if ($professionalService->service && $professionalService->service->name) {
                        $serviceName = $professionalService->service->name;
                    } elseif ($professionalService->service_name) {
                        $serviceName = $professionalService->service_name;
                    }
                }
            }
            
            if ($serviceName) {
                $booking->update(['service_name' => $serviceName]);
                $updated++;
            }
            
            $bar->advance();
        }
        
        $bar->finish();
        $this->newLine();
        $this->info("Updated {$updated} bookings with proper service names.");
        
        return 0;
    }
}
