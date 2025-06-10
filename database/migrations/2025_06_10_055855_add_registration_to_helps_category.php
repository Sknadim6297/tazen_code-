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
        // First, modify the column to allow NULL temporarily
        DB::statement("ALTER TABLE helps MODIFY category ENUM('General', 'Account', 'Booking', 'Payment', 'Events', 'Technical', 'Registration') NULL");
        
        // Then, set it back to NOT NULL
        DB::statement("ALTER TABLE helps MODIFY category ENUM('General', 'Account', 'Booking', 'Payment', 'Events', 'Technical', 'Registration') NOT NULL");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Remove 'Registration' from the enum
        DB::statement("ALTER TABLE helps MODIFY category ENUM('General', 'Account', 'Booking', 'Payment', 'Events', 'Technical') NOT NULL");
    }
}; 