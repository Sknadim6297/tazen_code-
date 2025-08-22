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
        Schema::table('event_bookings', function (Blueprint $table) {
            // Drop foreign key constraint first
            $table->dropForeign(['event_id']);
            
            // Make event_id nullable
            $table->unsignedBigInteger('event_id')->nullable()->change();
            
            // Re-add foreign key constraint
            $table->foreign('event_id')->references('id')->on('all_events')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('event_bookings', function (Blueprint $table) {
            // Drop foreign key constraint
            $table->dropForeign(['event_id']);
            
            // Make event_id not nullable
            $table->unsignedBigInteger('event_id')->nullable(false)->change();
            
            // Re-add foreign key constraint
            $table->foreign('event_id')->references('id')->on('all_events')->onDelete('cascade');
        });
    }
};
