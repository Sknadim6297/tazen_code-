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
        Schema::create('admin_professional_chats', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('professional_id')->nullable();
            $table->unsignedBigInteger('customer_id')->nullable();
            $table->enum('chat_type', ['admin_professional', 'admin_customer'])->default('admin_professional');
            $table->timestamp('last_message_at')->nullable();
            $table->unsignedBigInteger('last_message_by')->nullable();
            $table->timestamps();

            // Foreign key constraints
            $table->foreign('professional_id')->references('id')->on('professionals')->onDelete('cascade');
            $table->foreign('customer_id')->references('id')->on('users')->onDelete('cascade');

            // Indexes for better performance
            $table->index(['professional_id', 'chat_type']);
            $table->index(['customer_id', 'chat_type']);
            $table->index('last_message_at');

            // Unique constraints
            $table->unique(['professional_id', 'chat_type'], 'unique_professional_chat');
            $table->unique(['customer_id', 'chat_type'], 'unique_customer_chat');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admin_professional_chats');
    }
};
