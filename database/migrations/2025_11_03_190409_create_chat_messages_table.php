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
            $table->string('sender_type'); // App\Models\User or App\Models\Professional
            $table->unsignedBigInteger('sender_id');
            $table->text('message')->nullable();
            $table->string('message_type')->default('text'); // text, file, image
            $table->boolean('is_read')->default(false);
            $table->timestamp('read_at')->nullable();
            $table->json('metadata')->nullable(); // For storing additional data like file info
            $table->timestamps();

            // Indexes for better performance
            $table->index('chat_id');
            $table->index('created_at');
            $table->index('is_read');
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
