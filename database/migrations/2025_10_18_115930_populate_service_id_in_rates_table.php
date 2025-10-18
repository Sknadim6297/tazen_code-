<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     * 
     * This migration updates existing rates that have NULL service_id
     * by deriving the service_id from either:
     * 1. The sub_service's parent service_id, or
     * 2. The professional's primary service_id
     */
    public function up(): void
    {
        // Get all rates with NULL service_id
        $rates = DB::table('rates')->whereNull('service_id')->get();
        
        foreach ($rates as $rate) {
            $serviceId = null;
            
            // Try to get service_id from sub_service
            if ($rate->sub_service_id) {
                $subService = DB::table('sub_services')
                    ->where('id', $rate->sub_service_id)
                    ->first();
                
                if ($subService) {
                    $serviceId = $subService->service_id;
                }
            }
            
            // If still no service_id, try to get from professional's service
            if (!$serviceId) {
                $professionalService = DB::table('professional_services')
                    ->where('professional_id', $rate->professional_id)
                    ->first();
                
                if ($professionalService) {
                    $serviceId = $professionalService->service_id;
                }
            }
            
            // Update the rate with the found service_id
            if ($serviceId) {
                DB::table('rates')
                    ->where('id', $rate->id)
                    ->update(['service_id' => $serviceId]);
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // We don't reverse this migration as it fixes data integrity
        // Setting service_id back to NULL would break the functionality
    }
};
