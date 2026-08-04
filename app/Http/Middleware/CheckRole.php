<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();
        $userRole = $user->role;

        foreach ($roles as $role) {
            if ($userRole === $role) {
                return $next($request);
            }
        }

        // Redirect berdasarkan role
        if ($userRole === 'super_admin' || $userRole === 'admin') {
            return redirect()->route('superadmin.dashboard')->with('error', 'Akses ditolak!');
        }
        if ($userRole === 'manager' || $userRole === 'admin_maskapai') {
            return redirect()->route('manager.dashboard')->with('error', 'Akses ditolak!');
        }
        return redirect()->route('user.dashboard')->with('error', 'Akses ditolak!');
    }
}