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
        Schema::table('admin_professional_chats', function (Blueprint $table) {
            // Add customer_id field to support admin-customer chats
            $table->unsignedBigInteger('customer_id')->nullable()->after('professional_id');
            
            // Add foreign key constraint for customer_id
            $table->foreign('customer_id')->references('id')->on('users')->onDelete('cascade');
            
            // Add index for customer_id
            $table->index(['admin_id', 'customer_id']);
            
            // Drop the old unique constraint
            $table->dropUnique('unique_admin_professional_chat');
            
            // Add new unique constraints for both chat types
            $table->unique(['admin_id', 'professional_id', 'chat_type'], 'unique_admin_professional_chat');
            $table->unique(['admin_id', 'customer_id', 'chat_type'], 'unique_admin_customer_chat');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('admin_professional_chats', function (Blueprint $table) {
            // Drop unique constraints
            $table->dropUnique('unique_admin_professional_chat');
            $table->dropUnique('unique_admin_customer_chat');
            
            // Drop foreign key and index
            $table->dropForeign(['customer_id']);
            $table->dropIndex(['admin_id', 'customer_id']);
            
            // Drop customer_id column
            $table->dropColumn('customer_id');
            
            // Restore original unique constraint
            $table->unique(['admin_id', 'professional_id', 'chat_type'], 'unique_admin_professional_chat');
        });
    }
};
