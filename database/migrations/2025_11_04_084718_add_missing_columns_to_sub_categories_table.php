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
        Schema::table('sub_categories', function (Blueprint $table) {
            $table->unsignedBigInteger('category_box_id')->after('id');
            $table->unsignedBigInteger('service_id')->nullable()->after('category_box_id');
            $table->string('name')->after('service_id');
            $table->string('image')->nullable()->after('name');
            $table->boolean('status')->default(true)->after('image');
            
            // Add foreign key constraints
            $table->foreign('category_box_id')->references('id')->on('category_boxes')->onDelete('cascade');
            $table->foreign('service_id')->references('id')->on('services')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sub_categories', function (Blueprint $table) {
            $table->dropForeign(['category_box_id']);
            $table->dropForeign(['service_id']);
            $table->dropColumn(['category_box_id', 'service_id', 'name', 'image', 'status']);
        });
    }
};
