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
        Schema::create('all_events', function (Blueprint $table) {
        $table->id();
        $table->string('card_image');
        $table->string('date'); // You can also use ->date() if you prefer storing real date
        $table->string('mini_heading');
        $table->string('heading');
        $table->text('short_description');
        $table->decimal('starting_fees', 10, 2)->nullable();
        $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('all_events');
    }
};
