<?php

namespace App\View\Composers;

use Illuminate\View\View;
use App\Models\AdminMenu;

class SidebarComposer
{
    /**
     * Bind data to the view.
     *
     * @param  \Illuminate\View\View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $admin = auth('admin')->user();
        $adminMenus = [];

        if ($admin) {
            if ($admin->role === 'super_admin') {
                // Super admin sees all menus
                $adminMenus = AdminMenu::all()->pluck('name')->toArray();
            } else {
                // Regular admin only sees permitted menus
                $adminMenus = $admin->menus->pluck('name')->toArray();
            }
        }

        $view->with('adminMenus', $adminMenus);
        
        // Define the isMenuAccessible function for the view
        $isMenuAccessible = function($menuName) use ($admin, $adminMenus) {
            if (!$admin) {
                return false;
            }
            
            // Special case: manage_control is only for super_admin
            if ($menuName === 'manage_control') {
                return $admin->role === 'super_admin';
            }
            
            if ($admin->role === 'super_admin') {
                return true;
            }
            
            return in_array($menuName, $adminMenus);
        };
        
        $view->with('isMenuAccessible', $isMenuAccessible);
    }
}
