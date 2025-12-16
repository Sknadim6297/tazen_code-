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
            if (!Schema::hasColumn('category_boxes', 'name')) {
                $table->string('name')->after('id');
            }
            if (!Schema::hasColumn('category_boxes', 'description')) {
                $table->text('description')->nullable()->after('name');
            }
            if (!Schema::hasColumn('category_boxes', 'image')) {
                $table->string('image')->nullable()->after('description');
            }
            if (!Schema::hasColumn('category_boxes', 'status')) {
                $table->boolean('status')->default(true)->after('image');
            }
            if (!Schema::hasColumn('category_boxes', 'order')) {
                $table->integer('order')->default(0)->after('status');
            }
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
