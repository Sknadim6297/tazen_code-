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
            if (!Schema::hasColumn('bookings', 'sub_service_id')) {
                $table->unsignedBigInteger('sub_service_id')->nullable()->after('professional_id');
                $table->foreign('sub_service_id')->references('id')->on('sub_services')->onDelete('set null');
            }
            
            if (!Schema::hasColumn('bookings', 'sub_service_name')) {
                $table->string('sub_service_name')->nullable()->after('sub_service_id');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            if (Schema::hasColumn('bookings', 'sub_service_id')) {
                $table->dropForeign(['sub_service_id']);
                $table->dropColumn('sub_service_id');
            }
            
            if (Schema::hasColumn('bookings', 'sub_service_name')) {
                $table->dropColumn('sub_service_name');
            }
        });
    }
};
