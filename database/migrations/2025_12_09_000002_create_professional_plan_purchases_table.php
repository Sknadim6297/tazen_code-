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
        if (!Schema::hasTable('professional_plan_purchases')) {
            Schema::create('professional_plan_purchases', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('professional_id');
                $table->unsignedBigInteger('plan_id');
                $table->string('plan_name'); // Store plan name for history
                $table->decimal('price', 10, 2);
                $table->json('features')->nullable(); // Store features at time of purchase
                $table->integer('lead_limit');
                $table->integer('leads_used')->default(0); // Track used leads
                $table->enum('payment_status', ['pending', 'success', 'failed'])->default('pending');
                $table->string('payment_id')->nullable(); // Razorpay/Stripe payment ID
                $table->string('payment_method')->nullable(); // razorpay, stripe, manual
                $table->timestamp('start_date')->nullable();
                $table->timestamp('end_date')->nullable();
                $table->text('admin_notes')->nullable();
                $table->timestamps();

                // Foreign keys
                $table->foreign('professional_id')->references('id')->on('professionals')->onDelete('cascade');
                $table->foreign('plan_id')->references('id')->on('plans')->onDelete('cascade');
                
                // Indexes
                $table->index(['professional_id', 'payment_status']);
                $table->index('plan_id');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('professional_plan_purchases');
    }
};
