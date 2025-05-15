<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('customer_profiles', function (Blueprint $table) {
            // Check if the column doesn't exist before adding it
            if (!Schema::hasColumn('customer_profiles', 'user_id')) {
                $table->foreignId('user_id')->after('id')->constrained()->onDelete('cascade')->unique();
            }
        });
    }

    public function down(): void
    {
        Schema::table('customer_profiles', function (Blueprint $table) {
            // Drop foreign key constraint and column
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');
        });
    }
};
