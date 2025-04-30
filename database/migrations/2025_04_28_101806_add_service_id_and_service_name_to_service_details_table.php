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
    Schema::table('service_details', function (Blueprint $table) {
        $table->unsignedBigInteger('service_id');
        $table->string('service_name');  // To store the service name
        $table->foreign('service_id')->references('id')->on('services')->onDelete('cascade');
    });
}

public function down()
{
    Schema::table('service_details', function (Blueprint $table) {
        $table->dropForeign(['service_id']);
        $table->dropColumn(['service_id', 'service_name']);
    });
}

};
