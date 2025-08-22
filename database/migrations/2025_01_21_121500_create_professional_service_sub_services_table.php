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
        Schema::create('professional_service_sub_services', function (Blueprint $table) {
            $table->id();
            $table->foreignId('professional_service_id')->constrained('professional_services')->onDelete('cascade');
            $table->foreignId('sub_service_id')->constrained('sub_services')->onDelete('cascade');
            $table->timestamps();

            // Ensure a professional service can't have the same sub-service twice
            $table->unique(['professional_service_id', 'sub_service_id'], 'prof_service_sub_service_unique');
            
            // Add indexes for performance
            $table->index('professional_service_id', 'prof_service_id_idx');
            $table->index('sub_service_id', 'sub_service_id_idx');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('professional_service_sub_services');
    }
};
