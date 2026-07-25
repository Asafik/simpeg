<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display listing of system users (Admin Dinas & Operator Sekolah).
     */
    public function index()
    {
        return view('users.index');
    }
}
