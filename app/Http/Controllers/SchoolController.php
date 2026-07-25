<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SchoolController extends Controller
{
    /**
     * Display listing of schools (Satuan Pendidikan) & operator accounts.
     */
    public function index()
    {
        return view('sekolah.index');
    }
}
