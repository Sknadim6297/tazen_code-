<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Drop chat-related tables in reverse order of dependencies
        Schema::dropIfExists('chat_typing_indicators');
        Schema::dropIfExists('chat_notifications');
        Schema::dropIfExists('booking_chat_messages');
        Schema::dropIfExists('booking_chats');
        Schema::dropIfExists('chat_messages');
        Schema::dropIfExists('chats');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Recreate basic chat tables structure if needed (optional)
        // Note: This is a placeholder - adjust if you need to restore tables
    }
};
