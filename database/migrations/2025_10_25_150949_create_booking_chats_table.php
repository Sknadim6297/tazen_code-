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
        Schema::create('booking_chats', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('booking_id');
            $table->unsignedBigInteger('sender_id');
            $table->string('sender_type'); // 'customer' or 'professional'
            $table->text('message')->nullable();
            $table->string('attachment')->nullable(); // File path
            $table->boolean('is_read')->default(false);
            $table->boolean('is_system_message')->default(false);
            $table->timestamps();

            // Foreign key
            $table->foreign('booking_id')->references('id')->on('bookings')->onDelete('cascade');
            
            // Index for faster queries
            $table->index(['booking_id', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('booking_chats');
    }
};
