<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    // In the generated migration file
public function up()
{
    Schema::table('booking_timedates', function (Blueprint $table) {
        $table->string('meeting_link')->nullable()->after('remarks');
    });
}

public function down()
{
    Schema::table('booking_timedates', function (Blueprint $table) {
        $table->dropColumn('meeting_link');
    });
}

};
