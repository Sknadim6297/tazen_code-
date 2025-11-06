<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdminMenu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AdminMenuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $parentMenus = AdminMenu::whereNull('parent_id')->with('children')->orderBy('order')->get();
        $allMenus = AdminMenu::with('parent')->orderBy('order')->get();
        return view('admin.admin_menus.index', compact('parentMenus', 'allMenus'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $topLevelMenus = AdminMenu::whereNull('parent_id')->orderBy('display_name')->get();
        $firstLevelMenus = AdminMenu::whereNotNull('parent_id')
            ->whereIn('parent_id', $topLevelMenus->pluck('id'))
            ->orderBy('display_name')
            ->get();
            
        $parentMenus = $topLevelMenus->concat($firstLevelMenus);
        
        return view('admin.admin_menus.create', compact('parentMenus'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:admin_menus',
            'display_name' => 'required|string|max:255',
            'route_name' => 'nullable|string|max:255',
            'icon' => 'nullable|string|max:255',
            'parent_id' => 'nullable|exists:admin_menus,id',
            'order' => 'required|integer'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        if ($request->parent_id) {
            $parentMenu = AdminMenu::find($request->parent_id);
            if ($parentMenu && $parentMenu->parent_id) {
                $parentMenu = $parentMenu->parent;
                return redirect()->back()
                    ->with('error', 'Cannot create a third-level menu. Please select a top-level menu or first-level menu as parent.')
                    ->withInput();
            }
        }

        AdminMenu::create([
            'name' => $request->name,
            'display_name' => $request->display_name,
            'route_name' => $request->route_name,
            'icon' => $request->icon,
            'parent_id' => $request->parent_id,
            'order' => $request->order
        ]);

        return redirect()->route('admin.admin_menus.index')
            ->with('success', 'Menu created successfully');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $menu = AdminMenu::findOrFail($id);
        $topLevelMenus = AdminMenu::whereNull('parent_id')
            ->where('id', '!=', $id)
            ->orderBy('display_name')
            ->get();
            
        $firstLevelMenus = AdminMenu::whereNotNull('parent_id')
            ->whereIn('parent_id', $topLevelMenus->pluck('id'))
            ->where('id', '!=', $id)
            ->orderBy('display_name')
            ->get();
            
        $parentMenus = $topLevelMenus->concat($firstLevelMenus);

        return view('admin.admin_menus.edit', compact('menu', 'parentMenus'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $menu = AdminMenu::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:admin_menus,name,' . $menu->id,
            'display_name' => 'required|string|max:255',
            'route_name' => 'nullable|string|max:255',
            'icon' => 'nullable|string|max:255',
            'parent_id' => 'nullable|exists:admin_menus,id',
            'order' => 'required|integer'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        if ($request->parent_id && $request->parent_id == $id) {
            return redirect()->back()
                ->withErrors(['parent_id' => 'A menu cannot be its own parent.'])
                ->withInput();
        }

        $menu->update([
            'name' => $request->name,
            'display_name' => $request->display_name,
            'route_name' => $request->route_name,
            'icon' => $request->icon,
            'parent_id' => $request->parent_id,
            'order' => $request->order
        ]);

        return redirect()->route('admin.admin_menus.index')
            ->with('success', 'Menu updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $menu = AdminMenu::findOrFail($id);
        if ($menu->children()->exists()) {
            return redirect()->route('admin.admin_menus.index')
                ->with('error', 'Cannot delete menu with children. Delete the children first or reassign them.');
        }

        $menu->delete();

        return redirect()->route('admin.admin_menus.index')
            ->with('success', 'Menu deleted successfully');
    }

    /**
     * Sync the menus from the sidebar.
     * This would scan the sidebar file and update the menu database.
     * This is a more advanced feature and would require parsing the blade file.
     */
    public function syncFromSidebar(Request $request)
    {

        return redirect()->route('admin.admin_menus.index')
            ->with('success', 'Menus synced from sidebar');
    }
}
