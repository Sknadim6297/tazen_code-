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
            // Make professional_id nullable to support admin-customer chats
            $table->unsignedBigInteger('professional_id')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('admin_professional_chats', function (Blueprint $table) {
            // Revert professional_id to not nullable
            $table->unsignedBigInteger('professional_id')->nullable(false)->change();
        });
    }
};
