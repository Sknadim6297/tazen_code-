<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\AdditionalService;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Check if the table exists before trying to alter it
        if (Schema::hasTable('additional_services')) {
            // Check if column doesn't already exist
            if (!Schema::hasColumn('additional_services', 'original_professional_price')) {
                Schema::table('additional_services', function (Blueprint $table) {
                    // Add column to preserve original professional price
                    $table->decimal('original_professional_price', 10, 2)->nullable()->after('base_price');
                });
                
                // Migrate existing data
                $this->migrateExistingData();
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('additional_services') && Schema::hasColumn('additional_services', 'original_professional_price')) {
            Schema::table('additional_services', function (Blueprint $table) {
                $table->dropColumn('original_professional_price');
            });
        }
    }
    
    /**
     * Migrate existing data to preserve original prices
     */
    private function migrateExistingData()
    {
        // Get all additional services
        $services = AdditionalService::all();
        
        foreach ($services as $service) {
            $originalPrice = null;
            
            // Strategy to recover original professional price
            if ($service->negotiation_status === 'user_negotiated' && $service->user_negotiated_price) {
                // If user negotiated and base_price equals negotiated price, estimate original
                if ($service->base_price == $service->user_negotiated_price) {
                    // Assume user got ~10% discount, reverse calculate
                    $originalPrice = round($service->user_negotiated_price / 0.9, 2);
                } else {
                    $originalPrice = $service->base_price;
                }
            } elseif ($service->negotiation_status === 'admin_responded' && $service->admin_final_negotiated_price) {
                // If admin responded and base_price was corrupted
                if ($service->base_price == $service->admin_final_negotiated_price) {
                    // Try to estimate from user's original offer
                    if ($service->user_negotiated_price) {
                        $originalPrice = round($service->user_negotiated_price / 0.9, 2);
                    } else {
                        $originalPrice = round($service->admin_final_negotiated_price / 0.9, 2);
                    }
                } else {
                    $originalPrice = $service->base_price;
                }
            } else {
                // No negotiation - use current base_price
                $originalPrice = $service->base_price;
            }
            
            // Ensure original price is not less than current base_price
            if ($originalPrice < $service->base_price) {
                $originalPrice = $service->base_price;
            }
            
            // Set a reasonable minimum (e.g., if calculated price is too low)
            if ($originalPrice < 1000) {
                $originalPrice = max($originalPrice, $service->base_price, 8000); // Default to 8000 if too low
            }
            
            // Update the record
            $service->update(['original_professional_price' => $originalPrice]);
        }
    }
};
