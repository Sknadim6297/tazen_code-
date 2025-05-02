<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAvailabilitySlotsTable extends Migration
{
    public function up(): void
    {
        Schema::create('availability_slots', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('availability_id');
            $table->time('start_time');
            $table->string('start_period', 2); 
            $table->time('end_time');
            $table->string('end_period', 2); 
            $table->timestamps();

            $table->foreign('availability_id')->references('id')->on('availabilities')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('availability_slots');
    }
}
