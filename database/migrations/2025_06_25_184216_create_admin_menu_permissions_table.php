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
        Schema::create('admin_menu_permissions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('admin_id');
            $table->unsignedBigInteger('admin_menu_id');
            $table->timestamps();
            
            // Foreign keys
            $table->foreign('admin_id')->references('id')->on('admins')->onDelete('cascade');
            $table->foreign('admin_menu_id')->references('id')->on('admin_menus')->onDelete('cascade');
            
            // Unique constraint to prevent duplicate permissions
            $table->unique(['admin_id', 'admin_menu_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admin_menu_permissions');
    }
};
