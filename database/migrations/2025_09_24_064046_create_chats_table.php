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
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chats');
    }
};
