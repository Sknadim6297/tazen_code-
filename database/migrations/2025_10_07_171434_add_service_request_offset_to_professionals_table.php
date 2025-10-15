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
        Schema::table('professionals', function (Blueprint $table) {
            // Check if service_request_margin doesn't exist before adding
            if (!Schema::hasColumn('professionals', 'service_request_margin')) {
                $table->decimal('service_request_margin', 5, 2)->default(0)->after('margin')
                    ->comment('Commission percentage for additional service requests (admin share)');
            }
            
            // Check if service_request_offset doesn't exist before adding
            if (!Schema::hasColumn('professionals', 'service_request_offset')) {
                $table->decimal('service_request_offset', 5, 2)->default(0)->after('service_request_margin')
                    ->comment('Maximum percentage users can negotiate down from original service price');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('professionals', function (Blueprint $table) {
            $table->dropColumn(['service_request_margin', 'service_request_offset']);
        });
    }
};
