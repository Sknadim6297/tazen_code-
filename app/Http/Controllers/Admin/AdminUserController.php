<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\AdminMenu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class AdminUserController extends Controller
{
    /**
     * Display a listing of admin users
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $adminUsers = Admin::all();
        return view('admin.admin_users.index', compact('adminUsers'));
    }

    /**
     * Show the form for creating a new admin user
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.admin_users.create');
    }

    /**
     * Store a newly created admin user in storage
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:admins',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:super_admin,admin',
            'is_active' => 'boolean'
        ]);

        $admin = Admin::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => $validated['role'],
            'is_active' => $request->has('is_active') ? 1 : 0
        ]);

        return redirect()->route('admin.admin-users.index')
            ->with('success', 'Admin user created successfully!');
    }

    /**
     * Show the form for editing the specified admin user
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $adminUser = Admin::findOrFail($id);
        $parentMenus = AdminMenu::whereNull('parent_id')->with('children')->orderBy('order')->get();
        $adminMenuIds = $adminUser->menus->pluck('id')->toArray();
        
        return view('admin.admin_users.edit', compact('adminUser', 'parentMenus', 'adminMenuIds'));
    }

    /**
     * Update the specified admin user in storage
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $adminUser = Admin::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('admins')->ignore($adminUser->id),
            ],
            'password' => 'nullable|string|min:8|confirmed',
            'role' => 'required|in:super_admin,admin',
            'is_active' => 'boolean',
            'menu_permissions' => 'nullable|array',
            'menu_permissions.*' => 'exists:admin_menus,id'
        ]);

        $adminUser->name = $validated['name'];
        $adminUser->email = $validated['email'];
        $adminUser->role = $validated['role'];
        $adminUser->is_active = $request->has('is_active') ? 1 : 0;
        if (!empty($validated['password'])) {
            $adminUser->password = Hash::make($validated['password']);
        }

        $adminUser->save();
        if ($validated['role'] !== 'super_admin') {
            $menuIds = $request->input('menu_permissions', []);
            $adminUser->menus()->sync($menuIds);
        } else {
            $adminUser->menus()->detach();
        }

        return redirect()->route('admin.admin-users.index')
            ->with('success', 'Admin user updated successfully!');
    }

    /**
     * Remove the specified admin user from storage
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (auth()->guard('admin')->id() == $id) {
            return redirect()->route('admin.admin-users.index')
                ->with('error', 'You cannot delete your own account!');
        }

        $adminUser = Admin::findOrFail($id);
        $adminUser->delete();

        return redirect()->route('admin.admin-users.index')
            ->with('success', 'Admin user deleted successfully!');
    }

    /**
     * Show menu permissions for the specified admin user
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showPermissions($id)
    {
        $adminUser = Admin::findOrFail($id);
        if ($adminUser->role === 'super_admin') {
            return redirect()->route('admin.admin-users.index')
                ->with('error', 'Super Admin users already have access to all menus.');
        }
        $parentMenus = AdminMenu::whereNull('parent_id')->with('children')->orderBy('order')->get();
        $adminMenuIds = $adminUser->menus->pluck('id')->toArray();
        
        return view('admin.admin_users.permissions', compact('adminUser', 'parentMenus', 'adminMenuIds'));
    }

    /**
     * Update menu permissions for the specified admin user
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updatePermissions(Request $request, $id)
    {
        $adminUser = Admin::findOrFail($id);
        if ($adminUser->role === 'super_admin') {
            return redirect()->route('admin.admin-users.index')
                ->with('error', 'Super Admin users already have access to all menus.');
        }

        $validated = $request->validate([
            'menu_permissions' => 'nullable|array',
            'menu_permissions.*' => 'exists:admin_menus,id'
        ]);
        $menuIds = $request->input('menu_permissions', []);
        $adminUser->menus()->sync($menuIds);

        return redirect()->route('admin.admin-users.index')
            ->with('success', 'Menu permissions updated successfully for ' . $adminUser->name);
    }
}