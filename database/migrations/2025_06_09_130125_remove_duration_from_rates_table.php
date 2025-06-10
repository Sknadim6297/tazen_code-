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
        Schema::table('rates', function (Blueprint $table) {
            // Option 1: Set a default value for existing records
            $table->string('duration')->default('60 mins')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('rates', function (Blueprint $table) {
            // Option 1: Revert the default value
            $table->string('duration')->change();
            
            // Option 2: Revert nullable
            // $table->string('duration')->nullable(false)->change();
            
            // Option 3: Add the column back if you dropped it
            // $table->string('duration');
        });
    }
};
