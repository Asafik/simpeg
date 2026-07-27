<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Display the login view page.
     */
    public function showLoginForm()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }

        return view('auth.login');
    }

    /**
     * Display the login view page (alias).
     */
    public function login()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }

        return view('auth.login');
    }

    /**
     * Process authentication request.
     */
    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'login' => 'required|string',
            'password' => 'required|string',
        ]);

        $fieldType = filter_var($credentials['login'], FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        if (Auth::attempt([$fieldType => $credentials['login'], 'password' => $credentials['password']], $request->remember)) {
            $request->session()->regenerate();
            $user = Auth::user();

            // Record ActivityLog on Login
            try {
                ActivityLog::create([
                    'loggable_type' => User::class,
                    'loggable_id'   => $user->id,
                    'action'        => 'login',
                    'label'         => "Login ke dalam sistem SIMPEG-SP",
                    'changes'       => null,
                    'user_id'       => $user->id,
                    'user_name'     => $user->name,
                    'user_role'     => $user->role === 'ADMIN_DINAS' ? 'Admin Dinas' : 'Operator Sekolah',
                    'ip_address'    => $request->ip(),
                ]);
            } catch (\Throwable $e) {
                // Ignore failure
            }

            return redirect()->intended(route('dashboard'))
                ->with('success', 'Selamat datang kembali!');
        }

        return back()->withErrors([
            'login' => 'Username/Email atau password salah.',
        ])->onlyInput('login');
    }

    /**
     * Logout user session.
     */
    public function logout(Request $request)
    {
        $user = Auth::user();
        if ($user) {
            try {
                ActivityLog::create([
                    'loggable_type' => User::class,
                    'loggable_id'   => $user->id,
                    'action'        => 'logout',
                    'label'         => "Logout dari sistem SIMPEG-SP",
                    'changes'       => null,
                    'user_id'       => $user->id,
                    'user_name'     => $user->name,
                    'user_role'     => $user->role === 'ADMIN_DINAS' ? 'Admin Dinas' : 'Operator Sekolah',
                    'ip_address'    => $request->ip(),
                ]);
            } catch (\Throwable $e) {
                // Ignore failure
            }
        }

        Auth::logout();

        if ($request && method_exists($request, 'session')) {
            $request->session()->invalidate();
            $request->session()->regenerateToken();
        }

        return redirect()->route('login')->with('info', 'Anda telah berhasil keluar dari sistem.');
    }
}
