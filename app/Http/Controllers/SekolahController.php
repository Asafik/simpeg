<?php

namespace App\Http\Controllers;

use App\Models\Sekolah;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class SekolahController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->query('search');

        try {
            if (class_exists(Sekolah::class)) {
                $query = Sekolah::withCount('pegawais')->latest();

                if ($search) {
                    $query->where(function ($q) use ($search) {
                        $q->where('nama_sekolah', 'like', "%{$search}%")
                          ->orWhere('npsn', 'like', "%{$search}%")
                          ->orWhere('kecamatan', 'like', "%{$search}%")
                          ->orWhere('nama_kepala_sekolah', 'like', "%{$search}%");
                    });
                }

                $sekolahs = $query->paginate(15)->withQueryString();

                return view('sekolah.index', compact('sekolahs', 'search'));
            }
        } catch (\Throwable $e) {
            // UI preview fallback
        }

        return view('sekolah.index');
    }

    public function create()
    {
        return view('sekolah.index');
    }

    public function store(Request $request)
    {
        return redirect()->route('sekolah.index');
    }

    public function show($id)
    {
        return view('sekolah.index');
    }

    public function edit($id)
    {
        return view('sekolah.index');
    }

    public function update(Request $request, $id)
    {
        return redirect()->route('sekolah.index');
    }

    public function destroy($id)
    {
        return redirect()->route('sekolah.index');
    }
}
