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
        // Change ENUM columns to VARCHAR to fix MariaDB binding issues
        DB::statement('ALTER TABLE chats MODIFY participant_type_1 VARCHAR(20) NOT NULL');
        DB::statement('ALTER TABLE chats MODIFY participant_type_2 VARCHAR(20) NOT NULL');
        DB::statement('ALTER TABLE chats MODIFY last_message_by_type VARCHAR(20) NULL');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert back to ENUM if needed
        DB::statement("ALTER TABLE chats MODIFY participant_type_1 ENUM('admin', 'professional', 'customer') NOT NULL");
        DB::statement("ALTER TABLE chats MODIFY participant_type_2 ENUM('admin', 'professional', 'customer') NOT NULL");
        DB::statement("ALTER TABLE chats MODIFY last_message_by_type ENUM('admin', 'professional', 'customer') NULL");
    }
};
