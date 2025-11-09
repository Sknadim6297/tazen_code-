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
            if (!Schema::hasColumn('event_details', 'creator_type')) {
                $table->string('creator_type')->default('admin')->after('id');
            }
            if (!Schema::hasColumn('event_details', 'creator_id')) {
                $table->unsignedBigInteger('creator_id')->nullable()->after('creator_type');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('event_details', function (Blueprint $table) {
            if (Schema::hasColumn('event_details', 'creator_type')) {
                $table->dropColumn('creator_type');
            }
            if (Schema::hasColumn('event_details', 'creator_id')) {
                $table->dropColumn('creator_id');
            }
        });
    }
};
