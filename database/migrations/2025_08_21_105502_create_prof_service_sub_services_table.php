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
        Schema::create('prof_service_sub_services', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('professional_service_id');
            $table->unsignedBigInteger('sub_service_id');
            $table->timestamps();

            // Foreign key constraints with custom names
            $table->foreign('professional_service_id', 'prof_svc_id_fk')
                  ->references('id')->on('professional_services')->onDelete('cascade');
            $table->foreign('sub_service_id', 'sub_svc_id_fk')
                  ->references('id')->on('sub_services')->onDelete('cascade');

            // Ensure a professional service can't have the same sub-service twice
            $table->unique(['professional_service_id', 'sub_service_id'], 'prof_svc_sub_svc_unique');
            
            // Add indexes for performance
            $table->index('professional_service_id', 'prof_svc_id_idx');
            $table->index('sub_service_id', 'sub_svc_id_idx');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prof_service_sub_services');
    }
};
