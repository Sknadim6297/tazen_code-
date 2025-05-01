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
        Schema::create('event_details', function (Blueprint $table) {
            $table->id();
            $table->string('banner_image');               // Event banner image

            // Replace event_name with event_id
            $table->unsignedBigInteger('event_id');       // FK to events table
            $table->foreign('event_id')->references('id')->on('events')->onDelete('cascade');

            $table->string('event_type');                 // Type of the event
            $table->text('event_details');                // Full description/details
            $table->date('starting_date');                // Event starting date
            $table->decimal('starting_fees', 10, 2);      // Starting registration fees
            $table->json('event_gallery')->nullable();    // Gallery images (JSON array)
            $table->string('map_link')->nullable();       // Event Location Map Link
            $table->timestamps();  
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('event_details');
    }
};
