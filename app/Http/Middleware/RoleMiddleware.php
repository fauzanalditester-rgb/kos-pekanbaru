<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, string $roles): Response
    {
        $user = auth()->user();
        
        if (!$user) {
            return redirect()->route('login');
        }

        $allowedRoles = explode(',', $roles);
        
        if (!in_array($user->role, $allowedRoles)) {
            // Redirect to appropriate dashboard based on role
            if ($user->isCustomer()) {
                return redirect()->route('customer.dashboard');
            }
            
            // If user is admin/super_admin but trying to access wrong page, 
            // redirect to admin dashboard
            if ($user->isAdmin() || $user->isSuperAdmin()) {
                return redirect()->route('admin.dashboard');
            }
            
            // Fallback - logout and redirect to login
            auth()->logout();
            return redirect()->route('login')
                ->with('error', 'Anda tidak memiliki akses.');
        }

        return $next($request);
    }
}
