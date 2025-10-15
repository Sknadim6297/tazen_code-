<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Update all existing users who have passwords but registration_completed is false
        DB::table('users')
            ->whereNotNull('password')
            ->where('registration_completed', false)
            ->update([
                'registration_completed' => true,
                'password_set_at' => now(),
                'updated_at' => now()
            ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert the changes (set registration_completed back to false for users updated in up())
        DB::table('users')
            ->whereNotNull('password')
            ->where('registration_completed', true)
            ->whereNotNull('password_set_at')
            ->update([
                'registration_completed' => false,
                'password_set_at' => null,
                'updated_at' => now()
            ]);
    }
};
