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
        if (Schema::hasTable('prof_service_sub_services')) {
            return;
        }

        Schema::create('prof_service_sub_services', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('professional_service_id');
            $table->unsignedBigInteger('sub_service_id');
            $table->timestamps();

            // Use short, explicit foreign key names to avoid MySQL identifier length errors
            $table->foreign('professional_service_id', 'pss_prof_svc_fk')
                  ->references('id')->on('professional_services')->onDelete('cascade');

            $table->foreign('sub_service_id', 'pss_sub_svc_fk')
                  ->references('id')->on('sub_services')->onDelete('cascade');

            $table->unique(['professional_service_id', 'sub_service_id'], 'prof_svc_sub_unique');
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
