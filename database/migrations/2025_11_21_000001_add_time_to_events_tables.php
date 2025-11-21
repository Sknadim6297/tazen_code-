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
        // Add time column to all_events table
        Schema::table('all_events', function (Blueprint $table) {
            $table->time('time')->nullable()->after('date');
        });

        // Add time column to event_details table (for admin events)
        Schema::table('event_details', function (Blueprint $table) {
            $table->time('time')->nullable()->after('starting_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('all_events', function (Blueprint $table) {
            $table->dropColumn('time');
        });

        Schema::table('event_details', function (Blueprint $table) {
            $table->dropColumn('time');
        });
    }
};
