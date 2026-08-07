<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        if (!auth()->check()) {
            return redirect('/login');
        }
        
        $userRole = auth()->user()->role;
        
        if (!in_array($userRole, $roles)) {
            // [Magfi Adi Radza Putra] - Redirect ke dashboard sesuai role
            if ($userRole === 'super_admin') {
                return redirect()->route('superadmin.dashboard')->with('error', 'Akses ditolak!');
            } elseif ($userRole === 'manager') {
                return redirect()->route('manager.dashboard')->with('error', 'Akses ditolak!');
            }
            return redirect()->route('user.dashboard')->with('error', 'Akses ditolak!');
        }
        
        return $next($request);
    }
}