<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('availability_slots', function (Blueprint $table) {
            // $table->dropColumn('start_period');
            // $table->dropColumn('end_period');
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('availability_slots', function (Blueprint $table) {
            //
        });
    }
};
