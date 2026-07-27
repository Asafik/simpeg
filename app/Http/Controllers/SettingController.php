<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\Pegawai;
use App\Models\Sekolah;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class SettingController extends Controller
{
    /**
     * Display user profile settings view.
     */
    public function profile()
    {
        $user = Auth::user();
        $user->load('sekolah');
        return view('settings.profile', compact('user'));
    }

    /**
     * Update user profile information.
     */
    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        $validated = $request->validate([
            'name' => 'required|string|max:150',
            'email' => 'required|email|max:150|unique:users,email,' . $user->id,
        ]);

        $user->update($validated);

        return back()->with('success', 'Profil pengguna berhasil diperbarui.');
    }

    /**
     * Update user password.
     */
    public function updatePassword(Request $request)
    {
        $user = Auth::user();
        $validated = $request->validate([
            'current_password' => 'required|string',
            'new_password' => 'required|string|min:6|confirmed',
        ]);

        if (!Hash::check($validated['current_password'], $user->password)) {
            return back()->withErrors(['current_password' => 'Password saat ini tidak sesuai.']);
        }

        $user->update([
            'password' => Hash::make($validated['new_password']),
        ]);

        return back()->with('success', 'Password berhasil diubah. Silakan gunakan password baru pada login berikutnya.');
    }

    /**
     * Display system configuration view (Logo, Favicon, Theme).
     */
    public function app()
    {
        return view('settings.app');
    }

    /**
     * Process system application configuration update (Admin Only).
     */
    public function updateApp(Request $request)
    {
        $user = Auth::user();
        if ($user && method_exists($user, 'isOperatorSekolah') && $user->isOperatorSekolah()) {
            return back()->with('error', 'Akses Ditolak: Hanya Admin Dinas yang berhak memperbarui Pengaturan Aplikasi.');
        }

        return back()->with('success', 'Pengaturan Aplikasi berhasil diperbarui.');
    }

    /**
     * Display user activity logs audit trail view.
     * Admin Dinas sees ALL logs.
     * Operator Sekolah sees ONLY logs belonging to their own school.
     */
    public function logs(Request $request)
    {
        $user = Auth::user();
        $query = ActivityLog::with(['user', 'loggable']);

        // Scope logs by user role
        if ($user && method_exists($user, 'isOperatorSekolah') && $user->isOperatorSekolah()) {
            $sekolahId = $user->sekolah_id;
            $query->where(function ($q) use ($user, $sekolahId) {
                $q->where('user_id', $user->id);
                if ($sekolahId) {
                    $q->orWhereHasMorph('loggable', [Pegawai::class], function ($qPegawai) use ($sekolahId) {
                        $qPegawai->where('sekolah_id', $sekolahId);
                    })
                    ->orWhereHasMorph('loggable', [Sekolah::class], function ($qSekolah) use ($sekolahId) {
                        $qSekolah->where('id', $sekolahId);
                    });
                }
            });
        }

        // Search Filter (Keyword in label, user_name, user_role, ip_address)
        if ($request->filled('search')) {
            $search = trim($request->search);
            $query->where(function ($q) use ($search) {
                $q->where('label', 'like', "%{$search}%")
                  ->orWhere('user_name', 'like', "%{$search}%")
                  ->orWhere('user_role', 'like', "%{$search}%")
                  ->orWhere('action', 'like', "%{$search}%")
                  ->orWhere('ip_address', 'like', "%{$search}%");
            });
        }

        // Action Filter
        if ($request->filled('action')) {
            $query->where('action', $request->action);
        }

        $logs = $query->latest('id')->paginate(20)->withQueryString();

        return view('settings.logs', compact('logs'));
    }
}
