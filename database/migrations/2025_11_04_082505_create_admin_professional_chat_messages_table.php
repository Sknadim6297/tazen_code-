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
        Schema::create('admin_professional_chat_messages', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('chat_id');
            $table->text('message')->nullable();
            $table->string('sender_type'); // App\Models\Admin, App\Models\Professional, App\Models\User
            $table->unsignedBigInteger('sender_id');
            $table->boolean('is_read')->default(false);
            $table->timestamp('read_at')->nullable();
            $table->timestamps();

            // Foreign key constraint
            $table->foreign('chat_id')->references('id')->on('admin_professional_chats')->onDelete('cascade');

            // Indexes for better performance
            $table->index('chat_id');
            $table->index(['sender_type', 'sender_id']);
            $table->index('is_read');
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admin_professional_chat_messages');
    }
};
