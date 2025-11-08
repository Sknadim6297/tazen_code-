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
        Schema::table('event_details', function (Blueprint $table) {
            $table->string('creator_type')->default('admin')->after('event_id'); // 'admin' or 'professional'
            $table->unsignedBigInteger('creator_id')->nullable()->after('creator_type'); // admin_id or professional_id
            
            // Add indexes for performance
            $table->index(['creator_type', 'creator_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('event_details', function (Blueprint $table) {
            $table->dropIndex(['creator_type', 'creator_id']);
            $table->dropColumn(['creator_type', 'creator_id']);
        });
    }
};
