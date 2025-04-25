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
        Schema::create('event_f_a_q_s', function (Blueprint $table) {
            $table->id();
            $table->string('question1')->nullable();
            $table->text('answer1')->nullable();
            $table->string('question2')->nullable();
            $table->text('answer2')->nullable();
            $table->string('question3')->nullable();
            $table->text('answer3')->nullable();
            $table->string('question4')->nullable();
            $table->text('answer4')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('event_f_a_q_s');
    }
};
