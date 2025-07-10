<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EmployeePermissionMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if user is authenticated
        if (!auth()->check()) {
            return redirect()->route('admin.login');
        }

        $user = auth()->user();

        // Allow admins to do everything
        if ($user->isAdmin()) {
            return $next($request);
        }

        // For employees, check if the action is allowed
        if ($user->isEmployee()) {
            $route = $request->route();
            $routeName = $route->getName();
            $method = $request->method();

            // Define allowed actions for employees
            $allowedRoutes = [
                // Dashboard
                'admin.dashboard',
                
                // Owners - full access (edit/delete will be pending)
                'admin.owners.index',
                'admin.owners.create',
                'admin.owners.store',
                'admin.owners.show',
                'admin.owners.edit',
                'admin.owners.update',
                'admin.owners.destroy',
                
                // Sold Products - full access (edit/delete will be pending)
                'admin.sold-products.index',
                'admin.sold-products.create',
                'admin.sold-products.store',
                'admin.sold-products.show',
                'admin.sold-products.edit',
                'admin.sold-products.update',
                'admin.sold-products.destroy',
                
                // Products - full access (edit/delete will be pending)
                'admin.products.index',
                'admin.products.create',
                'admin.products.store',
                'admin.products.show',
                'admin.products.edit',
                'admin.products.update',
                'admin.products.destroy',
                'admin.products.toggleStatus',
                
                // Messages - only view (index and show)
                'admin.contact-messages.index',
                'admin.contact-messages.show',
                
                // Profile management
                'admin.profile.edit',
                'admin.profile.update',
                
                // Logout
                'admin.logout',
            ];
            
            // Additional routes for admins only
            $adminOnlyRoutes = [
                'admin.pending-changes.index',
                'admin.pending-changes.show',
                'admin.pending-changes.approve',
                'admin.pending-changes.reject',
                'admin.pending-changes.history',
                'admin.users.index',
                'admin.users.create',
                'admin.users.store',
                'admin.users.show',
                'admin.users.edit',
                'admin.users.update',
                'admin.users.destroy',
                'admin.users.toggle-status',
                'admin.product-categories.index',
                'admin.product-categories.create',
                'admin.product-categories.store',
                'admin.product-categories.show',
                'admin.product-categories.edit',
                'admin.product-categories.update',
                'admin.product-categories.destroy',
            ];

            // Check if the current route is allowed for employees
            if (!in_array($routeName, $allowedRoutes)) {
                return redirect()->route('admin.dashboard')
                    ->with('error', 'Access denied. You do not have permission to perform this action.');
            }

            return $next($request);
        }

        // If user is neither admin nor employee, deny access
        auth()->logout();
        return redirect()->route('admin.login')->with('error', 'Access denied. Invalid user role.');
    }
}
