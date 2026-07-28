<?php

namespace App\Http\Controllers;

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
            $user = Auth::user();
            if ($user && method_exists($user, 'isOperatorSekolah') && $user->isOperatorSekolah()) {
                return redirect()->route('operator.dashboard');
            }
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
            $user = Auth::user();
            if ($user && method_exists($user, 'isOperatorSekolah') && $user->isOperatorSekolah()) {
                return redirect()->route('operator.dashboard');
            }
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
            if ($user && method_exists($user, 'isOperatorSekolah') && $user->isOperatorSekolah()) {
                return redirect()->intended(route('operator.dashboard'))
                    ->with('success', 'Selamat datang kembali, Operator!');
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
        Auth::logout();

        if ($request && method_exists($request, 'session')) {
            $request->session()->invalidate();
            $request->session()->regenerateToken();
        }

        return redirect()->route('login')->with('info', 'Anda telah berhasil keluar dari sistem.');
    }
}
