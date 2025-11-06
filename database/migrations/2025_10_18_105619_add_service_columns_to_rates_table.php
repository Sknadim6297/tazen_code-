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
        Schema::table('rates', function (Blueprint $table) {
            // Only add service_id column (sub_service_id and features already exist)
            if (!Schema::hasColumn('rates', 'service_id')) {
                $table->unsignedBigInteger('service_id')->nullable()->after('professional_id');
                
                // Add foreign key constraint
                $table->foreign('service_id')->references('id')->on('services')->onDelete('cascade');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('rates', function (Blueprint $table) {
            // Drop foreign key and column only if they exist
            if (Schema::hasColumn('rates', 'service_id')) {
                $table->dropForeign(['service_id']);
                $table->dropColumn('service_id');
            }
        });
    }
};
