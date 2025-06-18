<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\AdminMenu;
use App\Models\AdminMenuPermission;

class MenuAccessController extends Controller
{
    /**
     * Display the menu access management page
     */
    public function index()
    {
        $menus = AdminMenu::all();
        return view('admin.menus.index', compact('menus'));
    }
    
    /**
     * Show form to assign menu permissions to admin user
     */
    public function show($id)
    {
        $admin = Admin::findOrFail($id);
        $menus = AdminMenu::all();
        $assignedMenus = $admin->menus->pluck('id')->toArray();
        
        return view('admin.menus.assign', compact('admin', 'menus', 'assignedMenus'));
    }
    
    /**
     * Update menu permissions for an admin user
     */
    public function update(Request $request, $id)
    {
        $admin = Admin::findOrFail($id);
        
        // Delete existing permissions
        AdminMenuPermission::where('admin_id', $admin->id)->delete();
        
        // Assign new permissions
        if ($request->has('menus')) {
            foreach ($request->menus as $menuId) {
                AdminMenuPermission::create([
                    'admin_id' => $admin->id,
                    'admin_menu_id' => $menuId
                ]);
            }
        }
        
        return redirect()->back()->with('success', 'Menu permissions updated successfully');
    }
}