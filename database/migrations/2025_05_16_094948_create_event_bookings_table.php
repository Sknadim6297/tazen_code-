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
        Schema::create('event_bookings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('event_id');
            $table->string('event_name');
            $table->date('event_date');
            $table->string('location')->nullable();
            $table->string('type')->nullable();
            $table->integer('persons')->nullable();
            $table->string('phone')->nullable();
            $table->decimal('price', 10, 2)->nullable();
            $table->decimal('total_price', 10, 2)->nullable();
            $table->string('gmeet_link')->nullable();
            $table->string('payment_status')->default('pending');
            $table->string('order_id')->nullable();
            $table->string('razorpay_payment_id')->nullable();
            $table->string('razorpay_signature')->nullable();
            $table->string('payment_failure_reason')->nullable();

            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('event_id')->references('id')->on('all_events')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('event_bookings');
    }
};
