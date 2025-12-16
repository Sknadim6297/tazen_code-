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
        if (!Schema::hasTable('plans')) {
            Schema::create('plans', function (Blueprint $table) {
                $table->id();
                $table->string('name'); // Bronze, Silver, Gold, Platinum
                $table->decimal('price', 10, 2);
                $table->integer('lead_limit'); // 20, 50, 100, etc.
                $table->json('features')->nullable(); // Array of features
                $table->integer('validity_days')->nullable(); // Optional validity in days
                $table->enum('status', ['active', 'inactive'])->default('active');
                $table->text('description')->nullable();
                $table->integer('order')->default(0); // For sorting display
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plans');
    }
};
