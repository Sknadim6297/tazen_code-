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
        Schema::create('additional_services', function (Blueprint $table) {
            $table->id();
            $table->foreignId('professional_id')->constrained('professionals')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('booking_id')->constrained('bookings')->onDelete('cascade');
            $table->string('service_name');
            $table->text('reason');
            $table->decimal('base_price', 10, 2);
            $table->decimal('cgst', 10, 2)->default(0.00);
            $table->decimal('sgst', 10, 2)->default(0.00);
            $table->decimal('igst', 10, 2)->default(0.00);
            $table->decimal('total_price', 10, 2);
            $table->decimal('professional_percentage_amount', 10, 2)->nullable();
            $table->decimal('professional_final_amount', 10, 2)->nullable();
            $table->decimal('platform_commission', 10, 2)->nullable();
            $table->timestamp('earnings_calculated_at')->nullable();
            $table->enum('professional_status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->enum('admin_status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->enum('user_status', ['pending', 'paid', 'later'])->default('pending');
            $table->string('consulting_status')->default('in_progress');
            $table->text('admin_reason')->nullable();
            $table->decimal('modified_base_price', 10, 2)->nullable();
            $table->decimal('modified_total_price', 10, 2)->nullable();
            $table->decimal('user_negotiated_price', 10, 2)->nullable();
            $table->text('user_negotiation_reason')->nullable();
            $table->enum('negotiation_status', ['none', 'user_negotiated', 'admin_responded'])->default('none');
            $table->boolean('price_modified_by_admin')->default(false);
            $table->text('price_modification_reason')->nullable();
            $table->text('admin_negotiation_response')->nullable();
            $table->decimal('admin_final_negotiated_price', 10, 2)->nullable();
            $table->timestamp('admin_reviewed_at')->nullable();
            $table->timestamp('user_responded_at')->nullable();
            $table->timestamp('professional_completed_at')->nullable();
            $table->timestamp('customer_confirmed_at')->nullable();
            $table->timestamp('delivery_date')->nullable();
            $table->boolean('delivery_date_set')->default(false);
            $table->enum('professional_payment_status', ['pending', 'processed'])->default('pending');
            $table->timestamp('professional_payment_processed_at')->nullable();
            $table->string('payment_id')->nullable();
            $table->enum('payment_status', ['pending', 'paid', 'failed'])->default('pending');
            $table->timestamp('user_completion_date')->nullable();
            $table->timestamps();
            
            // Add indexes for better performance
            $table->index(['professional_id', 'user_id']);
            $table->index(['booking_id']);
            $table->index(['professional_status', 'admin_status', 'user_status'], 'status_index');
            $table->index(['payment_status']);
            $table->index(['created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('additional_services');
    }
};