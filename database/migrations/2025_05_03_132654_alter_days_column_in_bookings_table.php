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
        Schema::table('bookings', function (Blueprint $table) {
            // Add service_name column
            $table->string('service_name')->after('professional_id')->nullable();

            // Convert days to JSON
            $table->json('days')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            // // Drop service_name column
            // $table->dropColumn('service_name');

            // Revert days back to string
            $table->string('days')->change();
        });
    }
};
