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
        Schema::create('payment_failure_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('professional_id')->nullable();
            $table->string('booking_type')->default('appointment'); // appointment, event
            $table->unsignedBigInteger('booking_id')->nullable();
            
            // Razorpay specific fields
            $table->string('razorpay_payment_id')->nullable();
            $table->string('razorpay_order_id')->nullable();
            $table->bigInteger('amount')->default(0); // Amount in paise
            $table->string('currency', 3)->default('INR');
            
            // Error details
            $table->string('error_code')->nullable();
            $table->text('error_description')->nullable();
            $table->string('error_source')->nullable();
            $table->string('error_step')->nullable();
            $table->string('error_reason')->nullable();
            
            // Tracking and resolution
            $table->string('reference_id')->unique()->nullable();
            $table->json('user_details')->nullable();
            $table->integer('payment_attempt_count')->default(1);
            $table->boolean('notifications_sent')->default(false);
            $table->timestamp('admin_notified_at')->nullable();
            $table->timestamp('professional_notified_at')->nullable();
            $table->timestamp('resolved_at')->nullable();
            $table->string('resolution_type')->nullable(); // customer_retry_success, manual_booking, cancelled, etc.
            $table->text('notes')->nullable();
            
            $table->timestamps();
            
            // Indexes
            $table->index(['user_id', 'created_at']);
            $table->index(['professional_id', 'created_at']);
            $table->index(['booking_type', 'created_at']);
            $table->index(['error_code', 'created_at']);
            $table->index(['resolved_at']);
            $table->index(['notifications_sent', 'created_at']);
            
            // Foreign keys
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('professional_id')->references('id')->on('professionals')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_failure_logs');
    }
};
