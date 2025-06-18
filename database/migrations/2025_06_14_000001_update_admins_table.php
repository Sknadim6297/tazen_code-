<?php

// filepath: c:\xampp\htdocs\tazen_marge_code\Tazen_multi\database\migrations\2025_06_14_000001_update_admins_table.php

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
        if (!Schema::hasTable('admins')) {
            Schema::create('admins', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('email')->unique();
                $table->timestamp('email_verified_at')->nullable();
                $table->string('password');
                $table->enum('role', ['super_admin', 'admin'])->default('admin');
                $table->boolean('is_active')->default(true);
                $table->rememberToken();
                $table->timestamps();
            });
        } else {
            // Check if columns exist and add them if they don't
            Schema::table('admins', function (Blueprint $table) {
                if (!Schema::hasColumn('admins', 'role')) {
                    $table->enum('role', ['super_admin', 'admin'])->default('admin')->after('password');
                }
                
                if (!Schema::hasColumn('admins', 'is_active')) {
                    $table->boolean('is_active')->default(true)->after('role');
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Only drop columns if they were added in this migration
        if (Schema::hasTable('admins')) {
            // We don't want to drop the whole table or remove columns that might have been added elsewhere
        }
    }
};