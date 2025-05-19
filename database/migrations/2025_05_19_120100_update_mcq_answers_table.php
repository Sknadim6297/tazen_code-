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
        Schema::table('mcq_answers', function (Blueprint $table) {
            // Drop existing columns if they exist
            if (Schema::hasColumn('mcq_answers', 'q1')) {
                $table->dropColumn(['q1', 'q2', 'q3', 'q4', 'q5']);
            }

            // Add new columns if they don't exist
            if (!Schema::hasColumn('mcq_answers', 'service_id')) {
                $table->unsignedBigInteger('service_id')->nullable();
                $table->foreign('service_id')->references('id')->on('services')->onDelete('cascade');
            }

            if (!Schema::hasColumn('mcq_answers', 'question_id')) {
                $table->unsignedBigInteger('question_id')->nullable();
                $table->foreign('question_id')->references('id')->on('service_m_c_q_s')->onDelete('cascade');
            }

            if (!Schema::hasColumn('mcq_answers', 'answer')) {
                $table->string('answer')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('mcq_answers', function (Blueprint $table) {
            // Remove new columns
            $table->dropForeign(['service_id']);
            $table->dropForeign(['question_id']);
            $table->dropColumn(['service_id', 'question_id', 'answer']);

            // Restore old columns
            $table->string('q1')->nullable();
            $table->string('q2')->nullable();
            $table->string('q3')->nullable();
            $table->string('q4')->nullable();
            $table->string('q5')->nullable();
        });
    }
};
