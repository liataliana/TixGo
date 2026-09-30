<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    // ... kode lainnya ...

    protected function authenticated(Request $request, $user)
    {
        if ($user->role === 'super_admin' || $user->role === 'admin') {
            return redirect('/superadmin/dashboard');
        }
        if ($user->role === 'manager' || $user->role === 'admin_maskapai') {
            return redirect('/manager/dashboard');
        }
        return redirect('/user/home');
    }

    // Hapus atau comment $redirectTo = '/home';
}