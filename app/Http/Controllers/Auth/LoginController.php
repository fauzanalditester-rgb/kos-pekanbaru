<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class LoginController extends Controller
{
    // ===== SUPER ADMIN LOGIN =====
    public function showSuperAdminLoginForm()
    {
        return view('auth.login-superadmin');
    }

    public function loginSuperAdmin(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $user = Auth::user();
            if (!$user->isSuperAdmin()) {
                Auth::logout();
                return back()->withErrors(['email' => 'Akun ini bukan Super Admin.']);
            }
            $request->session()->regenerate();
            return redirect('/super-admin');
        }

        return back()->withErrors(['email' => 'Email atau password salah.'])->onlyInput('email');
    }

    // ===== ADMIN LOGIN =====
    public function showAdminLoginForm()
    {
        return view('auth.login-admin');
    }

    public function loginAdmin(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $user = Auth::user();
            if (!$user->isAdmin() && !$user->isSuperAdmin()) {
                Auth::logout();
                return back()->withErrors(['email' => 'Akun ini bukan Admin.']);
            }
            $request->session()->regenerate();
            return redirect('/admin');
        }

        return back()->withErrors(['email' => 'Email atau password salah.'])->onlyInput('email');
    }

    // ===== CUSTOMER LOGIN =====
    public function showCustomerLoginForm()
    {
        return view('auth.login-customer');
    }

    public function loginCustomer(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $user = Auth::user();
            if (!$user->isCustomer()) {
                Auth::logout();
                return back()->withErrors(['email' => 'Akun ini bukan Customer.']);
            }
            $request->session()->regenerate();
            return redirect('/customer');
        }

        return back()->withErrors(['email' => 'Email atau password salah.'])->onlyInput('email');
    }

    // ===== LEGACY LOGIN (FALLBACK) =====
    public function showLoginForm()
    {
        return view('auth.login-simple');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            $user = Auth::user();
            
            if ($user->isSuperAdmin() || $user->isAdmin()) {
                return redirect('/admin');
            } elseif ($user->isCustomer()) {
                return redirect('/customer');
            }

            return redirect()->intended('/');
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login-simple');
    }
}
