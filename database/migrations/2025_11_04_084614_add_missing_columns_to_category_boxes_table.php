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
        Schema::table('category_boxes', function (Blueprint $table) {
            $table->string('name')->after('id');
            $table->text('description')->nullable()->after('name');
            $table->string('image')->nullable()->after('description');
            $table->boolean('status')->default(true)->after('image');
            $table->integer('order')->default(0)->after('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('category_boxes', function (Blueprint $table) {
            $table->dropColumn(['name', 'description', 'image', 'status', 'order']);
        });
    }
};
