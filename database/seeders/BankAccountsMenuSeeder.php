<?php

namespace Database\Seeders;

use App\Models\AdminMenu;
use Illuminate\Database\Seeder;

class BankAccountsMenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create the Bank Accounts menu item
        $bankAccountsMenu = AdminMenu::updateOrCreate(
            ['name' => 'bank_accounts'],
            [
                'display_name' => 'Bank Accounts',
                'route_name' => 'admin.bank-accounts.index',
                'icon' => 'ri-bank-line',
                'parent_id' => null,
                'order' => 13, // Position after re-requested services
            ]
        );

        // Add submenu items if needed in the future
        $subMenus = [
            [
                'name' => 'bank_accounts.index',
                'display_name' => 'All Bank Accounts',
                'route_name' => 'admin.bank-accounts.index',
                'order' => 1
            ],
            [
                'name' => 'bank_accounts.verified',
                'display_name' => 'Verified Accounts',
                'route_name' => 'admin.bank-accounts.index',
                'order' => 2
            ],
            [
                'name' => 'bank_accounts.pending',
                'display_name' => 'Pending Verification',
                'route_name' => 'admin.bank-accounts.index',
                'order' => 3
            ]
        ];

        foreach ($subMenus as $subMenu) {
            AdminMenu::updateOrCreate(
                ['name' => $subMenu['name']],
                [
                    'display_name' => $subMenu['display_name'],
                    'route_name' => $subMenu['route_name'],
                    'icon' => null,
                    'parent_id' => $bankAccountsMenu->id,
                    'order' => $subMenu['order']
                ]
            );
        }

        $this->command->info('Bank Accounts menu items created successfully.');
    }
}