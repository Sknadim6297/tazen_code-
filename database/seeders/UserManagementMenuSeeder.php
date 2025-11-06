<?php

namespace Database\Seeders;

use App\Models\AdminMenu;
use Illuminate\Database\Seeder;

class UserManagementMenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create the User Management menu item
        $userManagementMenu = AdminMenu::updateOrCreate(
            ['name' => 'user_management'],
            [
                'display_name' => 'User Management',
                'route_name' => 'admin.user-management.index',
                'icon' => 'ri-user-search-line',
                'parent_id' => null,
                'order' => 14, // Position after bank accounts
            ]
        );

        $this->command->info('User Management menu item created successfully.');
    }
}