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
        Schema::create('user_activities', function (Blueprint $table) {
            $table->id();
            $table->enum('user_type', ['admin', 'professional', 'customer']);
            $table->unsignedBigInteger('user_id');
            $table->timestamp('last_seen_at')->nullable();
            $table->boolean('is_online')->default(false);
            $table->timestamps();
            
            // Unique constraint and indexes
            $table->unique(['user_type', 'user_id']);
            $table->index(['user_type', 'user_id', 'is_online']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_activities');
    }
};
