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
            if (!Schema::hasColumn('professional_services', 'service_id')) {
                $table->unsignedBigInteger('service_id')->nullable()->after('professional_id');
            }
        });
        
        // Add foreign key and index with try-catch
        try {
            Schema::table('professional_services', function (Blueprint $table) {
                if (Schema::hasColumn('professional_services', 'service_id')) {
                    $table->foreign('service_id')->references('id')->on('services')->onDelete('cascade');
                    $table->index('service_id');
                }
            });
        } catch (\Exception $e) {
            // Foreign key/index might already exist
        }
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
