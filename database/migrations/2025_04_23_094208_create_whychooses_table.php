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
        Schema::create('whychooses', function (Blueprint $table) {
            $table->id();

            // Section Headings
            $table->string('section_heading');
            $table->string('section_sub_heading')->nullable();

            // Card 1
            $table->string('card1_mini_heading')->nullable();
            $table->string('card1_heading')->nullable();
            $table->string('card1_icon')->nullable();
            $table->text('card1_description')->nullable();

            // Card 2
            $table->string('card2_mini_heading')->nullable();
            $table->string('card2_heading')->nullable();
            $table->string('card2_icon')->nullable();
            $table->text('card2_description')->nullable();

            // Card 3
            $table->string('card3_mini_heading')->nullable();
            $table->string('card3_heading')->nullable();
            $table->string('card3_icon')->nullable();
            $table->text('card3_description')->nullable();

            // Card 4
            $table->string('card4_mini_heading')->nullable();
            $table->string('card4_heading')->nullable();
            $table->string('card4_icon')->nullable();
            $table->text('card4_description')->nullable();

            // Card 5
            $table->string('card5_mini_heading')->nullable();
            $table->string('card5_heading')->nullable();
            $table->string('card5_icon')->nullable();
            $table->text('card5_description')->nullable();

            // Card 6
            $table->string('card6_mini_heading')->nullable();
            $table->string('card6_heading')->nullable();
            $table->string('card6_icon')->nullable();
            $table->text('card6_description')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('whychooses');
    }
};
