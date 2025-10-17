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
            // Add service_id if it doesn't exist
            if (!Schema::hasColumn('bookings', 'service_id')) {
                $table->unsignedBigInteger('service_id')->nullable()->after('professional_id');
                $table->foreign('service_id')->references('id')->on('services')->onDelete('set null');
            }
            
            // Add sub_service_name if it doesn't exist
            if (!Schema::hasColumn('bookings', 'sub_service_name')) {
                $table->string('sub_service_name')->nullable()->after('service_name');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            // Drop foreign key and column for service_id
            if (Schema::hasColumn('bookings', 'service_id')) {
                $table->dropForeign(['service_id']);
                $table->dropColumn('service_id');
            }
            
            // Drop sub_service_name column
            if (Schema::hasColumn('bookings', 'sub_service_name')) {
                $table->dropColumn('sub_service_name');
            }
        });
    }
};
