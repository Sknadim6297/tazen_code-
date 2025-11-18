<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\AdminMenu;

class AdminMenuAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Get the authenticated admin
        $admin = auth('admin')->user();

        // If no admin is authenticated, redirect to login
        if (!$admin) {
            return redirect()->route('admin.login');
        }

        // Super admins have access to everything
        if ($admin->role === 'super_admin') {
            return $next($request);
        }

        // Get current route name
        $routeName = $request->route()->getName();

        // Always allow access to essential routes
        $alwaysAllowedRoutes = ['admin.dashboard', 'admin.logout'];
        if (in_array($routeName, $alwaysAllowedRoutes)) {
            return $next($request);
        }

        // Find menu by route name
        $menu = AdminMenu::where('route_name', $routeName)->first();

        // If no menu matches this route, allow access (could be a common route)
        // You may want to adjust this logic based on your needs
        if (!$menu) {
            return $next($request);
        }

        // Check if admin has access
        if ($admin->menus->contains($menu->id)) {
            return $next($request);
        }

        // Check if it's a child route and the admin has access to parent
        if ($menu->parent_id) {
            $parentMenu = AdminMenu::find($menu->parent_id);
            if ($parentMenu && $admin->menus->contains($parentMenu->id)) {
                return $next($request);
            }
        }

        // Access denied - redirect with error message
        return redirect()->route('admin.dashboard')
            ->with('error', 'You do not have permission to access that page.');
    }
}
