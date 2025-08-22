<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Update existing bookings that don't have GST breakdown
        DB::statement("
            UPDATE bookings 
            SET 
                base_amount = CASE 
                    WHEN base_amount IS NULL OR base_amount = 0 THEN amount / 1.18 
                    ELSE base_amount 
                END,
                cgst_amount = CASE 
                    WHEN cgst_amount IS NULL OR cgst_amount = 0 THEN (amount / 1.18) * 0.09 
                    ELSE cgst_amount 
                END,
                sgst_amount = CASE 
                    WHEN sgst_amount IS NULL OR sgst_amount = 0 THEN (amount / 1.18) * 0.09 
                    ELSE sgst_amount 
                END,
                igst_amount = CASE 
                    WHEN igst_amount IS NULL THEN 0 
                    ELSE igst_amount 
                END
            WHERE amount > 0
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Don't reverse this data migration
        // DB::statement("UPDATE bookings SET base_amount = NULL, cgst_amount = NULL, sgst_amount = NULL, igst_amount = NULL");
    }
};
