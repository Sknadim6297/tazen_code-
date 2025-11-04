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
        Schema::table('admin_professional_chats', function (Blueprint $table) {
            // Drop existing unique constraints that don't handle nulls properly
            $table->dropUnique('unique_admin_professional_chat');
            $table->dropUnique('unique_admin_customer_chat');
        });
        
        // Add conditional unique constraints using raw SQL for better null handling
        DB::statement('
            ALTER TABLE admin_professional_chats 
            ADD CONSTRAINT unique_admin_professional_chat 
            UNIQUE (admin_id, professional_id, chat_type)
        ');
        
        DB::statement('
            ALTER TABLE admin_professional_chats 
            ADD CONSTRAINT unique_admin_customer_chat 
            UNIQUE (admin_id, customer_id, chat_type)
        ');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('admin_professional_chats', function (Blueprint $table) {
            // Drop the constraints
            $table->dropUnique('unique_admin_professional_chat');
            $table->dropUnique('unique_admin_customer_chat');
        });
        
        // Restore original constraint
        Schema::table('admin_professional_chats', function (Blueprint $table) {
            $table->unique(['admin_id', 'professional_id', 'chat_type'], 'unique_admin_professional_chat');
            $table->unique(['admin_id', 'customer_id', 'chat_type'], 'unique_admin_customer_chat');
        });
    }
};
