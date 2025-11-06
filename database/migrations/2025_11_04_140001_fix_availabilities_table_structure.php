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
            // Check and add missing columns
            if (!Schema::hasColumn('availabilities', 'professional_id')) {
                $table->unsignedBigInteger('professional_id')->after('id');
                $table->foreign('professional_id')->references('id')->on('professionals')->onDelete('cascade');
            }
            
            if (!Schema::hasColumn('availabilities', 'month')) {
                $table->string('month')->after('professional_id');
            }
            
            if (!Schema::hasColumn('availabilities', 'session_duration')) {
                $table->integer('session_duration')->after('month');
            }
            
            if (!Schema::hasColumn('availabilities', 'weekdays')) {
                $table->json('weekdays')->after('session_duration');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('availabilities', function (Blueprint $table) {
            if (Schema::hasColumn('availabilities', 'professional_id')) {
                $table->dropForeign(['professional_id']);
                $table->dropColumn('professional_id');
            }
            if (Schema::hasColumn('availabilities', 'month')) {
                $table->dropColumn('month');
            }
            if (Schema::hasColumn('availabilities', 'session_duration')) {
                $table->dropColumn('session_duration');
            }
            if (Schema::hasColumn('availabilities', 'weekdays')) {
                $table->dropColumn('weekdays');
            }
        });
    }
};
