<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\AdminMenu;
use App\Models\AdminMenuPermission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Create super admin if it doesn't exist
        Admin::firstOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'name' => 'Super Admin',
                'password' => Hash::make('admin123'),
                'role' => 'super_admin',
                'is_active' => true
            ]
        );
        
        // Create a regular admin with limited permissions
        $adminEmail = 'regular@example.com';
        $admin = Admin::withTrashed()->where('email', $adminEmail)->first();
        
        if (!$admin) {
            $admin = Admin::create([
                'email' => $adminEmail,
                'name' => 'Regular Admin',
                'password' => Hash::make('password123'),
                'role' => 'admin',
                'is_active' => true
            ]);
        } elseif ($admin->trashed()) {
            // Restore the soft-deleted admin
            $admin->restore();
            $admin->update([
                'name' => 'Regular Admin',
                'password' => Hash::make('password123'),
                'role' => 'admin',
                'is_active' => true
            ]);
        }
        
        // Assign some menu permissions to the regular admin
        // Get some menu IDs (adjust as needed)
        $menuIds = AdminMenu::whereIn('name', [
            'dashboard', 
            'booking',
            'contacts',
            'blog_comments'
        ])->pluck('id')->toArray();
        
        // Assign permissions (check for existing permissions first)
        foreach ($menuIds as $menuId) {
            AdminMenuPermission::firstOrCreate([
                'admin_id' => $admin->id,
                'admin_menu_id' => $menuId
            ]);
        }
    }
}
