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
        Schema::create('professional_payments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('professional_id');
            $table->unsignedBigInteger('admin_id');
            $table->decimal('amount', 10, 2);
            $table->enum('payment_type', ['consultation_fee', 'bonus', 'referral_commission', 'other']);
            $table->enum('payment_method', ['bank_transfer', 'upi', 'cheque']);
            $table->text('description')->nullable();
            $table->string('transaction_reference')->nullable();
            $table->enum('status', ['recorded', 'pending', 'completed', 'failed'])->default('recorded');
            $table->timestamp('payment_date')->nullable();
            $table->timestamps();

            $table->foreign('professional_id')->references('id')->on('professionals')->onDelete('cascade');
            $table->foreign('admin_id')->references('id')->on('admins')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('professional_payments');
    }
};