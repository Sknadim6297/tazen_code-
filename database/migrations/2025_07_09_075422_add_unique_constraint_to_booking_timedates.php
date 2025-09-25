<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('booking_timedates', function (Blueprint $table) {
            // First, need to get the professional_id from the related booking
            // Add a composite unique constraint to prevent double bookings
            // This will require the professional_id, date, and time_slot to be unique together
            // But since professional_id is in bookings table, we'll add this at the application level
            // and create a unique index on the combination that makes business sense
            
            // For now, let's add a unique constraint on booking_id, date, time_slot
            // to prevent duplicate entries for the same booking
            $table->unique(['booking_id', 'date', 'time_slot'], 'unique_booking_timedate');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('booking_timedates', function (Blueprint $table) {
            $table->dropUnique('unique_booking_timedate');
        });
    }
};
