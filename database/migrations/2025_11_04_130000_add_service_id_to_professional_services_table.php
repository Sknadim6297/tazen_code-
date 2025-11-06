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
        Schema::table('professional_services', function (Blueprint $table) {
            // Add service_id column after professional_id
            $table->unsignedBigInteger('service_id')->nullable()->after('professional_id');
            
            // Add foreign key constraint
            $table->foreign('service_id')->references('id')->on('services')->onDelete('cascade');
            
            // Add index for better query performance
            $table->index('service_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('professional_services', function (Blueprint $table) {
            $table->dropForeign(['service_id']);
            $table->dropColumn('service_id');
        });
    }
};
