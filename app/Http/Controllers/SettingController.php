<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SettingController extends Controller
{
    /**
     * Display user profile settings view.
     */
    public function profile()
    {
        return view('settings.profile');
    }

    /**
     * Display system configuration view (Logo, Favicon, Theme).
     */
    public function app()
    {
        return view('settings.app');
    }

    /**
     * Display user activity logs audit trail view.
     */
    public function logs()
    {
        return view('settings.logs');
    }
}
