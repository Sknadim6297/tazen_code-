<?php

namespace Database\Seeders;

use App\Models\AdminMenu;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ManageControlMenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Add the manage_control menu with its permissions
        $manageControlMenu = AdminMenu::updateOrCreate(
            ['name' => 'manage_control'],
            [
                'display_name' => 'Manage Control',
                'route_name' => null,
                'icon' => 'ri-settings-line',
                'order' => 100 // High number to place it at the end of the menu
            ]
        );

        // Add child menus
        $childMenus = [
            [
                'name' => 'admin.users',
                'display_name' => 'Manage Admins',
                'route_name' => 'admin.manage_admins.index',
                'order' => 1
            ],
            [
                'name' => 'admin.menu_permissions',
                'display_name' => 'Menu Permissions',
                'route_name' => 'admin.admin_menus.index',
                'order' => 2
            ]
        ];

        foreach ($childMenus as $childData) {
            AdminMenu::updateOrCreate(
                ['name' => $childData['name']],
                array_merge($childData, ['parent_id' => $manageControlMenu->id])
            );
        }
    }
}
