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
        Schema::create('chat_messages', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('chat_id');
            $table->enum('sender_type', ['admin', 'professional', 'customer']);
            $table->unsignedBigInteger('sender_id');
            $table->text('message');
            $table->enum('message_type', ['text', 'file', 'image'])->default('text');
            $table->string('file_path')->nullable();
            $table->boolean('is_read')->default(false);
            $table->timestamp('read_at')->nullable();
            $table->timestamps();
            
            // Foreign key and indexes
            $table->foreign('chat_id')->references('id')->on('chats')->onDelete('cascade');
            $table->index(['chat_id', 'created_at']);
            $table->index(['sender_type', 'sender_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chat_messages');
    }
};
