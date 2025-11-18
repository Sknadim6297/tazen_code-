<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\AdminMenu;
use App\Models\AdminMenuPermission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ManageAdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $admins = Admin::where('id', '!=', auth()->guard('admin')->user()->id)->get();
        return view('admin.manage_admins.index', compact('admins'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.manage_admins.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:admins',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:admin,super_admin'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $admin = Admin::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'is_active' => true,
        ]);

        // Give new admin basic dashboard access by default
        $dashboardMenu = AdminMenu::where('route_name', 'admin.dashboard')->first();
        if ($dashboardMenu) {
            AdminMenuPermission::create([
                'admin_id' => $admin->id,
                'admin_menu_id' => $dashboardMenu->id
            ]);
        }

        return redirect()->route('admin.manage_admins.index')
            ->with('success', 'Admin created successfully. Default dashboard permission has been granted.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $admin = Admin::findOrFail($id);
        return view('admin.manage_admins.edit', compact('admin'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $admin = Admin::findOrFail($id);

        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:admins,email,' . $admin->id,
            'role' => 'required|in:admin,super_admin',
            'is_active' => 'boolean'
        ];
        if ($request->filled('password')) {
            $rules['password'] = 'string|min:8|confirmed';
        }

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $admin->name = $request->name;
        $admin->email = $request->email;
        $admin->role = $request->role;
        $admin->is_active = $request->has('is_active');
        
        if ($request->filled('password')) {
            $admin->password = Hash::make($request->password);
        }

        $admin->save();

        return redirect()->route('admin.manage_admins.index')
            ->with('success', 'Admin updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $admin = Admin::findOrFail($id);
        $admin->delete();

        return redirect()->route('admin.manage_admins.index')
            ->with('success', 'Admin deleted successfully');
    }

    /**
     * Show the form for managing admin's menu permissions
     */
    public function showPermissions($id)
    {
        $admin = Admin::findOrFail($id);
        $menus = AdminMenu::with('children')->whereNull('parent_id')->orderBy('order')->get();
        $adminMenuIds = $admin->menus->pluck('id')->toArray();

        return view('admin.manage_admins.permissions', compact('admin', 'menus', 'adminMenuIds'));
    }

    /**
     * Update the admin's menu permissions
     */
    public function updatePermissions(Request $request, $id)
    {
        $admin = Admin::findOrFail($id);
        $validator = Validator::make($request->all(), [
            'menu_ids' => 'array',
            'menu_ids.*' => 'exists:admin_menus,id',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        AdminMenuPermission::where('admin_id', $admin->id)->delete();
        if ($request->has('menu_ids')) {
            foreach ($request->menu_ids as $menuId) {
                AdminMenuPermission::create([
                    'admin_id' => $admin->id,
                    'admin_menu_id' => $menuId
                ]);
            }
        }

        return redirect()->route('admin.manage_admins.index')
            ->with('success', 'Admin permissions updated successfully');
    }
}
