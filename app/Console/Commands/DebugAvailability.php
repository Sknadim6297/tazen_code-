<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Availability;
use Carbon\Carbon;

class DebugAvailability extends Command
{
    protected $signature = 'debug:availability';
    protected $description = 'Debug availability data';

    public function handle()
    {
        $this->info('=== CHECKING AVAILABILITY DATA ===');
        
        $availabilities = Availability::with('slots')->get();
        $this->info("Total availabilities: " . $availabilities->count());
        
        foreach ($availabilities as $availability) {
            $this->line("ID: {$availability->id}");
            $this->line("Professional ID: {$availability->professional_id}");
            $this->line("Month: '{$availability->month}'");
            $this->line("Weekdays: '{$availability->weekdays}'");
            $this->line("Session Duration: {$availability->session_duration}");
            $this->line("Slots count: " . $availability->slots->count());
            foreach ($availability->slots as $slot) {
                $this->line("  Slot: {$slot->start_time} - {$slot->end_time}");
            }
            $this->line("---");
        }
        
        $this->info('=== TESTING CURRENT MONTH MATCHING ===');
        $currentMonth = strtolower(Carbon::now()->format('M'));
        $this->line("Current month: '$currentMonth'");
        $this->line("October: " . ($currentMonth === 'oct' ? 'MATCH' : 'NO MATCH'));
        $this->line("December: " . ($currentMonth === 'dec' ? 'MATCH' : 'NO MATCH'));
        
        $this->info('=== TESTING WEEKDAY PARSING ===');
        $testWeekdays = "tue fri";
        $this->line("Original weekdays: '$testWeekdays'");
        
        // Split by space
        $weekdaysArray = preg_split('/[\s,]+/', trim($testWeekdays));
        $weekdaysArray = array_filter($weekdaysArray);
        $this->line("After splitting: " . json_encode($weekdaysArray));
        
        $this->info('=== TESTING CURRENT WEEKDAYS ===');
        for ($i = 0; $i < 7; $i++) {
            $date = Carbon::now()->addDays($i);
            $dayShort = strtolower($date->format('D'));
            $matches = in_array($dayShort, $weekdaysArray);
            
            $this->line("Date: " . $date->format('Y-m-d') . " ({$date->format('l')}) - Day: $dayShort, Matches: " . ($matches ? 'YES' : 'NO'));
        }
        
        $this->info('=== TESTING DECEMBER DATES ===');
        $decemberStart = Carbon::create(2025, 12, 1); // December 1, 2025
        for ($i = 0; $i < 7; $i++) {
            $date = $decemberStart->copy()->addDays($i);
            $dayShort = strtolower($date->format('D'));
            $matches = in_array($dayShort, $weekdaysArray);
            
            $this->line("Date: " . $date->format('Y-m-d') . " ({$date->format('l')}) - Day: $dayShort, Matches: " . ($matches ? 'YES' : 'NO'));
        }
        
        $this->info('=== TESTING AVAILABILITY FILTER FOR DECEMBER ===');
        $prof16Availability = $availabilities->where('professional_id', 16)->where('month', 'dec');
        $this->line("Professional 16 December availability count: " . $prof16Availability->count());
        
        foreach ($prof16Availability as $avail) {
            $this->line("- Month: {$avail->month}, Weekdays: {$avail->weekdays}, Slots: {$avail->slots->count()}");
        }
        
        return 0;
    }
}