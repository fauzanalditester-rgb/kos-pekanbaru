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
            
            return redirect()->route('admin.dashboard')
                ->with('error', 'Anda tidak memiliki akses ke halaman tersebut.');
        }

        return $next($request);
    }
}
