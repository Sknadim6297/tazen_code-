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
            if (!Schema::hasColumn('sub_categories', 'category_box_id')) {
                $table->unsignedBigInteger('category_box_id')->after('id');
            }
            if (!Schema::hasColumn('sub_categories', 'service_id')) {
                $table->unsignedBigInteger('service_id')->nullable()->after('category_box_id');
            }
            if (!Schema::hasColumn('sub_categories', 'name')) {
                $table->string('name')->after('service_id');
            }
            if (!Schema::hasColumn('sub_categories', 'image')) {
                $table->string('image')->nullable()->after('name');
            }
            if (!Schema::hasColumn('sub_categories', 'status')) {
                $table->boolean('status')->default(true)->after('image');
            }
        });
        
        // Add foreign key constraints with try-catch to handle if they already exist
        try {
            Schema::table('sub_categories', function (Blueprint $table) {
                if (Schema::hasColumn('sub_categories', 'category_box_id')) {
                    $table->foreign('category_box_id')->references('id')->on('category_boxes')->onDelete('cascade');
                }
                if (Schema::hasColumn('sub_categories', 'service_id')) {
                    $table->foreign('service_id')->references('id')->on('services')->onDelete('set null');
                }
            });
        } catch (\Exception $e) {
            // Foreign keys might already exist, continue
        }
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
