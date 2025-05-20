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
        Schema::table('mcq_answers', function (Blueprint $table) {
            $table->unsignedBigInteger('booking_id')->nullable()->after('service_id');
        });
    }

    public function down()
    {
        Schema::table('mcq_answers', function (Blueprint $table) {
            $table->dropColumn('booking_id');
        });
    }
};
