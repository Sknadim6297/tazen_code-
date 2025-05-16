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
        Schema::table('professionals', function (Blueprint $table) {
            // Change 'margin' column to unsignedTinyInteger with default 0
            $table->unsignedTinyInteger('margin')->default(0)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('professionals', function (Blueprint $table) {
            // Revert 'margin' column back to decimal(5,2)
            $table->decimal('margin', 5, 2)->default(0)->change();
        });
    }
};
