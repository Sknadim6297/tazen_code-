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
        Schema::table('availabilities', function (Blueprint $table) {
            // Add professional_service_id to link availability to specific services
            $table->unsignedBigInteger('professional_service_id')->nullable()->after('professional_id');
            
            // Add foreign key constraint
            $table->foreign('professional_service_id')->references('id')->on('professional_services')->onDelete('cascade');
            
            // Add index for better query performance
            $table->index(['professional_id', 'professional_service_id'], 'avail_prof_service_idx');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('availabilities', function (Blueprint $table) {
            $table->dropForeign(['professional_service_id']);
            $table->dropIndex('avail_prof_service_idx');
            $table->dropColumn('professional_service_id');
        });
    }
};
