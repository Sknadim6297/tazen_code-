<?php

// filepath: c:\xampp\htdocs\tazen_marge_code\Tazen_multi\database\seeders\AdminMenuSeeder.php

namespace Database\Seeders;

use App\Models\AdminMenu;
use Illuminate\Database\Seeder;

class AdminMenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Define menus with their hierarchy
        $menus = [
            [
                'name' => 'dashboard',
                'display_name' => 'Dashboard',
                'route_name' => 'admin.dashboard',
                'icon' => 'ri-dashboard-line',
                'order' => 1
            ],
            // Professional section
            [
                'name' => 'professionals',
                'display_name' => 'Professional',
                'route_name' => null,
                'icon' => 'ri-user-line',
                'order' => 2,
                'children' => [
                    [
                        'name' => 'professional.requests',
                        'display_name' => 'Manage Professional',
                        'route_name' => 'admin.professional.requests',
                        'order' => 1
                    ],
                    [
                        'name' => 'professional.all',
                        'display_name' => 'All Professionals',
                        'route_name' => 'admin.manage-professional.index',
                        'order' => 2
                    ],
                    [
                        'name' => 'professional.billing',
                        'display_name' => 'Professional Billing',
                        'route_name' => 'admin.professional.billing',
                        'order' => 3
                    ]
                ]
            ],
            // Customer section
            [
                'name' => 'customers',
                'display_name' => 'Customers',
                'route_name' => null,
                'icon' => 'ri-team-line',
                'order' => 3,
                'children' => [
                    [
                        'name' => 'customer.all',
                        'display_name' => 'All Customers',
                        'route_name' => 'admin.manage-customer.index',
                        'order' => 1
                    ],
                    [
                        'name' => 'customer.billing',
                        'display_name' => 'Customer Billing',
                        'route_name' => 'admin.customer.billing',
                        'order' => 2
                    ]
                ]
            ],
            // Booking section
            [
                'name' => 'bookings',
                'display_name' => 'Bookings',
                'route_name' => null,
                'icon' => 'ri-calendar-line',
                'order' => 4,
                'children' => [
                    [
                        'name' => 'bookings.onetime',
                        'display_name' => 'One Time',
                        'route_name' => 'admin.onetime',
                        'order' => 1
                    ],
                    [
                        'name' => 'bookings.monthly',
                        'display_name' => 'Monthly',
                        'route_name' => 'admin.monthly',
                        'order' => 2
                    ],
                    [
                        'name' => 'bookings.freehand',
                        'display_name' => 'Free Hand',
                        'route_name' => 'admin.freehand',
                        'order' => 3
                    ],
                    [
                        'name' => 'bookings.quarterly',
                        'display_name' => 'Quarterly',
                        'route_name' => 'admin.quaterly',
                        'order' => 4
                    ]
                ]
            ],
            // Website content
            [
                'name' => 'website_content',
                'display_name' => 'Website Content',
                'route_name' => null,
                'icon' => 'ri-pages-line',
                'order' => 5,
                'children' => [
                    [
                        'name' => 'content.banners',
                        'display_name' => 'Banners',
                        'route_name' => 'admin.banners.index',
                        'order' => 1
                    ],
                    [
                        'name' => 'content.services',
                        'display_name' => 'Services',
                        'route_name' => 'admin.service.index',
                        'order' => 2
                    ],
                    [
                        'name' => 'content.testimonials',
                        'display_name' => 'Testimonials',
                        'route_name' => 'admin.testimonials.index',
                        'order' => 3
                    ],
                ]
            ],
            // Admin Users (super_admin only)
            [
                'name' => 'admin_management',
                'display_name' => 'Admin Management',
                'route_name' => null,
                'icon' => 'ri-shield-user-line',
                'order' => 6,
                'children' => [
                    [
                        'name' => 'admin.users',
                        'display_name' => 'Admin Users',
                        'route_name' => 'admin.admin-users.index',
                        'order' => 1
                    ]
                ]
            ],
        ];

        // Create main menus
        foreach ($menus as $menuData) {
            $children = $menuData['children'] ?? [];
            unset($menuData['children']);
            
            $menu = AdminMenu::updateOrCreate(
                ['name' => $menuData['name']],
                $menuData
            );
            
            // Create children menus
            foreach ($children as $childData) {
                AdminMenu::updateOrCreate(
                    ['name' => $childData['name']],
                    array_merge($childData, ['parent_id' => $menu->id])
                );
            }
        }
    }
}