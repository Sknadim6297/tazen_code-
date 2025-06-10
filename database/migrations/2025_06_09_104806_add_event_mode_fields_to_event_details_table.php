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
        Schema::table('event_details', function (Blueprint $table) {
            $table->string('city')->nullable()->after('event_gallery');
            $table->enum('event_mode', ['online', 'offline'])->nullable()->after('city');
            $table->string('meeting_link')->nullable()->after('event_mode');
            $table->string('landmark')->nullable()->after('meeting_link');
            $table->dropColumn('map_link'); // Remove the old map_link column
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('event_details', function (Blueprint $table) {
            $table->string('map_link')->nullable();
            $table->dropColumn(['city', 'event_mode', 'meeting_link', 'landmark']);
        });
    }
}; 