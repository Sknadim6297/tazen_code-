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
        // Drop chat_messages first (due to foreign key constraint)
        Schema::dropIfExists('chat_messages');
        
        // Drop and recreate chats table with correct enum values
        Schema::dropIfExists('chats');
        
        Schema::create('chats', function (Blueprint $table) {
            $table->id();
            $table->enum('participant_type_1', ['admin', 'professional', 'user']);
            $table->unsignedBigInteger('participant_id_1');
            $table->enum('participant_type_2', ['admin', 'professional', 'user']);
            $table->unsignedBigInteger('participant_id_2');
            $table->timestamp('last_message_at')->nullable();
            $table->unsignedBigInteger('last_message_by')->nullable();
            $table->enum('last_message_by_type', ['admin', 'professional', 'user'])->nullable();
            $table->timestamps();
            
            // Indexes for performance
            $table->index(['participant_type_1', 'participant_id_1']);
            $table->index(['participant_type_2', 'participant_id_2']);
            $table->unique(['participant_type_1', 'participant_id_1', 'participant_type_2', 'participant_id_2'], 'unique_chat_participants');
        });

        // Recreate chat_messages table with correct enum values
        Schema::create('chat_messages', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('chat_id');
            $table->enum('sender_type', ['admin', 'professional', 'user']);
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

        // Recreate user_activities table with correct enum values
        Schema::dropIfExists('user_activities');
        Schema::create('user_activities', function (Blueprint $table) {
            $table->id();
            $table->enum('user_type', ['admin', 'professional', 'user']);
            $table->unsignedBigInteger('user_id');
            $table->timestamp('last_seen_at')->nullable();
            $table->boolean('is_online')->default(false);
            $table->timestamps();
            
            // Unique constraint and indexes
            $table->unique(['user_type', 'user_id']);
            $table->index(['user_type', 'user_id', 'is_online']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Drop chat_messages first (due to foreign key constraint)
        Schema::dropIfExists('chat_messages');
        
        // Revert back to original enum values
        Schema::dropIfExists('chats');
        
        Schema::create('chats', function (Blueprint $table) {
            $table->id();
            $table->enum('participant_type_1', ['admin', 'professional', 'customer']);
            $table->unsignedBigInteger('participant_id_1');
            $table->enum('participant_type_2', ['admin', 'professional', 'customer']);
            $table->unsignedBigInteger('participant_id_2');
            $table->timestamp('last_message_at')->nullable();
            $table->unsignedBigInteger('last_message_by')->nullable();
            $table->enum('last_message_by_type', ['admin', 'professional', 'customer'])->nullable();
            $table->timestamps();
            
            // Indexes for performance
            $table->index(['participant_type_1', 'participant_id_1']);
            $table->index(['participant_type_2', 'participant_id_2']);
            $table->unique(['participant_type_1', 'participant_id_1', 'participant_type_2', 'participant_id_2'], 'unique_chat_participants');
        });

        // Recreate chat_messages table with original enum values
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

        // Recreate user_activities table with original enum values
        Schema::create('user_activities', function (Blueprint $table) {
            $table->id();
            $table->enum('user_type', ['admin', 'professional', 'customer']);
            $table->unsignedBigInteger('user_id');
            $table->timestamp('last_seen_at')->nullable();
            $table->boolean('is_online')->default(false);
            $table->timestamps();
            
            // Unique constraint and indexes
            $table->unique(['user_type', 'user_id']);
            $table->index(['user_type', 'user_id', 'is_online']);
        });
    }
};
