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
        if (!Schema::hasTable('professional_scheduled_sessions')) {
            Schema::create('professional_scheduled_sessions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('professional_id');
            $table->string('title');
            $table->text('description')->nullable();
            $table->date('session_date');
            $table->time('start_time');
            $table->time('end_time');
            $table->decimal('price', 10, 2);
            $table->integer('max_participants')->default(1);
            $table->integer('booked_participants')->default(0);
            $table->enum('session_type', ['individual', 'group'])->default('individual');
            $table->enum('session_mode', ['online', 'offline', 'hybrid'])->default('online');
            $table->string('location')->nullable(); // For offline sessions
            $table->text('meeting_link')->nullable(); // For online sessions
            $table->text('preparation_notes')->nullable();
            $table->enum('status', ['active', 'cancelled', 'completed'])->default('active');
            $table->boolean('is_recurring')->default(false);
            $table->enum('recurring_type', ['daily', 'weekly', 'monthly'])->nullable();
            $table->date('recurring_end_date')->nullable();
            $table->json('recurring_days')->nullable(); // For weekly recurring sessions
            $table->timestamps();

            // Foreign keys
            $table->foreign('professional_id')->references('id')->on('professionals')->onDelete('cascade');
            
            // Indexes with custom names
            $table->index(['professional_id', 'session_date'], 'ps_prof_date_idx');
            $table->index(['status', 'session_date'], 'ps_status_date_idx');
            $table->index(['session_date', 'start_time'], 'ps_date_time_idx');
        });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('professional_scheduled_sessions');
    }
};