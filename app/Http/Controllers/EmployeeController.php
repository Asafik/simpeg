<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    /**
     * Display listing of employees (PTK) with 7 criteria multi-filtering.
     */
    public function index()
    {
        return view('pegawai.index');
    }

    /**
     * Show form for creating a new employee.
     */
    public function create()
    {
        return view('pegawai.create');
    }

    /**
     * Display detailed employee profile & PDF attachments.
     */
    public function show($id)
    {
        return view('pegawai.show');
    }
}
