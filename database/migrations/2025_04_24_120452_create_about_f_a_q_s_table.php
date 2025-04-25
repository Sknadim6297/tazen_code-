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
        Schema::create('about_f_a_q_s', function (Blueprint $table) {
            $table->id();
            $table->text('faq_description'); // FAQ description
            $table->string('question1'); // Question 1
            $table->text('answer1'); // Answer for Question 1
            $table->string('question2')->nullable(); // Question 2
            $table->text('answer2')->nullable(); // Answer for Question 2
            $table->string('question3')->nullable(); // Question 3
            $table->text('answer3')->nullable(); // Answer for Question 3
            $table->string('question4')->nullable(); // Question 4
            $table->text('answer4')->nullable(); // Answer for Question 4
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('about_f_a_q_s');
    }
};
