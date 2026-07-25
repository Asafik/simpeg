<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    /**
     * Display the split-screen Hope UI login page.
     */
    public function login()
    {
        return view('auth.login');
    }

    /**
     * Logout user session.
     */
    public function logout()
    {
        return redirect()->route('login');
    }
}
