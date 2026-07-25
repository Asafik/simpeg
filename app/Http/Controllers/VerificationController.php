<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class VerificationController extends Controller
{
    /**
     * Display document verification queue (SK, Serdik, Ijazah).
     */
    public function index()
    {
        return view('verifikasi.index');
    }
}
