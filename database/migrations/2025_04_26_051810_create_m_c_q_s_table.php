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
        Schema::create('m_c_q_s', function (Blueprint $table) {
            $table->id();
            $table->string('question1');
            $table->string('option1_a');
            $table->string('option1_b');
            $table->string('option1_c');
            $table->string('option1_d');
            $table->string('question2');
            $table->string('option2_a');
            $table->string('option2_b');
            $table->string('option2_c');
            $table->string('option2_d');
            $table->string('question3');
            $table->string('option3_a');
            $table->string('option3_b');
            $table->string('option3_c');
            $table->string('option3_d');
            $table->string('question4');
            $table->string('option4_a');
            $table->string('option4_b');
            $table->string('option4_c');
            $table->string('option4_d');
            $table->string('question5');
            $table->string('option5_a');
            $table->string('option5_b');
            $table->string('option5_c');
            $table->string('option5_d');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('m_c_q_s');
    }
};
