<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Professional;
use App\Models\Availability; 
use App\Models\AvailabilitySlot;

class CreateSampleAvailability extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create:availability';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create sample availability data for testing reschedule functionality';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Creating availability data...');

        // Get the first professional
        $professional = Professional::first();

        if (!$professional) {
            $this->error('No professional found! Please create a professional first.');
            return 1;
        }

        $this->info("Professional found: " . $professional->name);

        // Create availability for next 6 months
        for ($i = 0; $i < 6; $i++) {
            $month = now()->addMonths($i)->format('Y-m');
            $this->info("Creating availability for month: " . $month);
            
            // Create or update availability record
            $availability = Availability::updateOrCreate(
                [
                    'professional_id' => $professional->id,
                    'month' => $month
                ],
                [
                    'session_duration' => 30,
                    'weekdays' => ['mon', 'tue', 'wed'] // Include weekdays
                ]
            );
            
            // Create availability slots (matching your example)
            
            // Monday: 2:01 PM - 4:00 PM
            AvailabilitySlot::updateOrCreate(
                [
                    'availability_id' => $availability->id,
                    'weekday' => 'mon'
                ],
                [
                    'start_time' => '14:01:00',
                    'end_time' => '16:00:00'
                ]
            );
            
            // Tuesday: 8:34 AM - 10:00 AM  
            AvailabilitySlot::updateOrCreate(
                [
                    'availability_id' => $availability->id,
                    'weekday' => 'tue'
                ],
                [
                    'start_time' => '08:34:00',
                    'end_time' => '10:00:00'
                ]
            );
            
            // Wednesday: 5:00 PM - 6:30 PM
            AvailabilitySlot::updateOrCreate(
                [
                    'availability_id' => $availability->id,
                    'weekday' => 'wed'
                ],
                [
                    'start_time' => '17:00:00',
                    'end_time' => '18:30:00'
                ]
            );
        }

        $this->info('Availability data created successfully!');
        $this->info("Professional: " . $professional->name . " now has availability:");
        $this->info("- Monday: 2:01 PM - 4:00 PM");
        $this->info("- Tuesday: 8:34 AM - 10:00 AM");  
        $this->info("- Wednesday: 5:00 PM - 6:30 PM");
        $this->info("Session duration: 30 minutes");
        
        return 0;
    }
}
