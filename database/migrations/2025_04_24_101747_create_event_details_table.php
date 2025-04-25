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
        $table->string('banner_image');           // Event banner image
        $table->string('event_name');             // Name of the event
        $table->string('event_type');             // Type of the event
        $table->text('event_details');            // Full description/details
        $table->date('starting_date');            // Event starting date
        $table->decimal('starting_fees', 10, 2);  // Starting registration fees
        $table->json('event_gallery')->nullable(); // Gallery images (can be stored as array)
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
