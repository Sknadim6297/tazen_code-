<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Change sender_type from ENUM to VARCHAR in chat_messages table
        // This fixes the SQL binding error: "Data truncated for column 'sender_type'"
        
        DB::statement('ALTER TABLE chat_messages MODIFY sender_type VARCHAR(20) NOT NULL');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert back to ENUM (if needed for rollback)
        DB::statement("ALTER TABLE chat_messages MODIFY sender_type ENUM('admin', 'professional', 'customer') NOT NULL");
    }
};
