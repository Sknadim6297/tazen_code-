<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('event_details', function (Blueprint $table) {
            $table->text('banner_image')->change();
        });
    }

    public function down()
    {
        Schema::table('event_details', function (Blueprint $table) {
            $table->string('banner_image', 255)->change();
        });
    }
}; 