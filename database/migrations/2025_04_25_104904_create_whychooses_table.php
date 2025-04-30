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
            $table->string('section_heading');
            $table->string('section_sub_heading');
            $table->string('card1_mini_heading');
            $table->string('card1_heading');
            $table->string('card1_icon');
            $table->text('card1_description');
            $table->string('card2_mini_heading');
            $table->string('card2_heading');
            $table->string('card2_icon');
            $table->text('card2_description');
            $table->string('card3_mini_heading');
            $table->string('card3_heading');
            $table->string('card3_icon');
            $table->text('card3_description');
            $table->string('card4_mini_heading');
            $table->string('card4_heading');
            $table->string('card4_icon');
            $table->text('card4_description');
            $table->string('card5_mini_heading');
            $table->string('card5_heading');
            $table->string('card5_icon');
            $table->text('card5_description');
            $table->string('card6_mini_heading');
            $table->string('card6_heading');
            $table->string('card6_icon');
            $table->text('card6_description');
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
