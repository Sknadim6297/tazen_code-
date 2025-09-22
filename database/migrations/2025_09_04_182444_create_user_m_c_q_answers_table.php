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
        Schema::create('user_m_c_q_answers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('service_id');
            $table->unsignedBigInteger('service_mcq_id');
            $table->unsignedBigInteger('booking_id')->nullable(); // Link to booking if needed
            $table->string('question');
            $table->string('selected_answer');
            $table->text('other_answer')->nullable(); // For "Other" option
            $table->timestamps();

            // Foreign keys
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('service_id')->references('id')->on('services')->onDelete('cascade');
            $table->foreign('service_mcq_id')->references('id')->on('service_m_c_q_s')->onDelete('cascade');
            
            // Indexes
            $table->index(['user_id', 'service_id']);
            $table->index(['booking_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_m_c_q_answers');
    }
};
