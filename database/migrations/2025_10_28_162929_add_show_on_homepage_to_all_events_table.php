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
        Schema::table('all_events', function (Blueprint $table) {
            $table->boolean('show_on_homepage')->default(false)->after('meet_link');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('all_events', function (Blueprint $table) {
            $table->dropColumn('show_on_homepage');
        });
    }
};
