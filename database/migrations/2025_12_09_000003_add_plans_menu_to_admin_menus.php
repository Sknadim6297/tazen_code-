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
        // Check if admin_menus table exists
        if (Schema::hasTable('admin_menus')) {
            // Add Plans menu if it doesn't exist
            $existingMenu = DB::table('admin_menus')->where('name', 'plans')->first();
            
            if (!$existingMenu) {
                DB::table('admin_menus')->insert([
                    'name' => 'plans',
                    'display_name' => 'Plans & Features',
                    'route_name' => 'admin.plans.index',
                    'icon' => 'fe-package',
                    'parent_id' => null,
                    'order' => 100,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('admin_menus')) {
            DB::table('admin_menus')->where('name', 'plans')->delete();
        }
    }
};
