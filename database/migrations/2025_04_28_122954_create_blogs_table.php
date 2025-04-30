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
        Schema::create('blogs', function (Blueprint $table) {
            $table->id();
            $table->string('image')->nullable(); // Blog Image
            $table->string('title'); // Blog Title
            $table->text('description_short'); // Short Description for Homepage
            $table->string('created_by'); // e.g., By Tania Ghosh Jan 10, 2025
            $table->enum('status', ['active', 'inactive'])->default('active'); // Blog Status
            $table->timestamps(); // created_at and updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('blogs');
    }
};
