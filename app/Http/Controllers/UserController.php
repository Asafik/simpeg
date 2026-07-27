<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Sekolah;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Helper to ensure only Admin Dinas can access user management.
     */
    private function ensureAdminAccess()
    {
        $user = Auth::user();
        if ($user && method_exists($user, 'isOperatorSekolah') && $user->isOperatorSekolah()) {
            return redirect()->route('dashboard')->with('error', 'Akses Ditolak: Hanya Admin Dinas yang berhak mengelola akun pengguna sistem.');
        }
        return null;
    }

    /**
     * Display listing of system users (Admin Dinas & Operator Sekolah).
     */
    public function index(Request $request)
    {
        if ($redirect = $this->ensureAdminAccess()) return $redirect;

        $search = $request->query('search');
        $role = $request->query('role');

        $query = User::with('sekolah')->latest();

        if (!empty($search)) {
            $cleanSearch = preg_replace('/[^a-zA-Z0-9]/', '', strtolower($search));
            $query->where(function ($q) use ($search, $cleanSearch) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('username', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhereRaw("REPLACE(LOWER(name), ' ', '') LIKE ?", ["%{$cleanSearch}%"])
                  ->orWhereRaw("REPLACE(LOWER(username), ' ', '') LIKE ?", ["%{$cleanSearch}%"])
                  ->orWhereHas('sekolah', function ($qSekolah) use ($search, $cleanSearch) {
                      $qSekolah->where('nama_sekolah', 'like', "%{$search}%")
                               ->orWhereRaw("REPLACE(LOWER(nama_sekolah), ' ', '') LIKE ?", ["%{$cleanSearch}%"])
                               ->orWhere('npsn', 'like', "%{$search}%");
                  });
            });
        }

        if (!empty($role)) {
            $query->where('role', $role);
        }

        $users = $query->paginate(15)->withQueryString();

        $totalUsers = User::count();
        $totalAdminDinas = User::where('role', 'ADMIN_DINAS')->count();
        $totalOperatorSekolah = User::where('role', 'OPERATOR_SEKOLAH')->count();

        return view('users.index', compact(
            'users',
            'totalUsers',
            'totalAdminDinas',
            'totalOperatorSekolah',
            'search',
            'role'
        ));
    }

    /**
     * Show form to create new user.
     */
    public function create()
    {
        if ($redirect = $this->ensureAdminAccess()) return $redirect;

        $sekolahs = Sekolah::orderBy('nama_sekolah')->get();
        return view('users.create', compact('sekolahs'));
    }

    /**
     * Store a newly created user in database.
     */
    public function store(Request $request)
    {
        if ($redirect = $this->ensureAdminAccess()) return $redirect;

        $request->validate([
            'name'       => 'required|string|max:255',
            'username'   => 'required|string|max:255|unique:users,username',
            'email'      => 'required|string|email|max:255|unique:users,email',
            'password'   => 'required|string|min:6',
            'role'       => 'required|in:ADMIN_DINAS,OPERATOR_SEKOLAH',
            'sekolah_id' => 'nullable|required_if:role,OPERATOR_SEKOLAH|exists:sekolahs,id',
        ], [
            'name.required'       => 'Nama lengkap wajib diisi.',
            'username.required'   => 'Username wajib diisi.',
            'username.unique'     => 'Username tersebut sudah terdaftar.',
            'email.required'      => 'Email wajib diisi.',
            'email.unique'        => 'Alamat email tersebut sudah terdaftar.',
            'password.required'   => 'Password wajib diisi.',
            'password.min'        => 'Password minimal 6 karakter.',
            'role.required'       => 'Role / peranan pengguna wajib dipilih.',
            'sekolah_id.required_if' => 'Satuan Pendidikan wajib dipilih untuk Operator Sekolah.',
        ]);

        $user = User::create([
            'name'       => trim($request->name),
            'username'   => trim($request->username),
            'email'      => trim($request->email),
            'password'   => Hash::make($request->password),
            'role'       => $request->role,
            'sekolah_id' => $request->role === 'OPERATOR_SEKOLAH' ? $request->sekolah_id : null,
        ]);

        ActivityLog::record($user, 'created', [
            'name' => ['data' => $user->name],
            'username' => ['data' => $user->username],
            'role' => ['data' => $user->role],
        ], "Akun pengguna '{$user->username}' dibuat");

        return redirect()->route('users.index')
            ->with('success', "Akun pengguna '{$user->name}' (Username: {$user->username}) berhasil dibuat!");
    }

    /**
     * Show form to edit existing user.
     */
    public function edit(User $user)
    {
        if ($redirect = $this->ensureAdminAccess()) return $redirect;

        $sekolahs = Sekolah::orderBy('nama_sekolah')->get();
        return view('users.create', compact('user', 'sekolahs'));
    }

    /**
     * Update user details in database.
     */
    public function update(Request $request, User $user)
    {
        if ($redirect = $this->ensureAdminAccess()) return $redirect;

        $request->validate([
            'name'       => 'required|string|max:255',
            'username'   => ['required', 'string', 'max:255', Rule::unique('users')->ignore($user->id)],
            'email'      => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'password'   => 'nullable|string|min:6',
            'role'       => 'required|in:ADMIN_DINAS,OPERATOR_SEKOLAH',
            'sekolah_id' => 'nullable|required_if:role,OPERATOR_SEKOLAH|exists:sekolahs,id',
        ], [
            'name.required'          => 'Nama lengkap wajib diisi.',
            'username.required'      => 'Username wajib diisi.',
            'username.unique'        => 'Username tersebut sudah terdaftar.',
            'email.required'         => 'Email wajib diisi.',
            'email.unique'           => 'Alamat email tersebut sudah terdaftar.',
            'password.min'           => 'Password minimal 6 karakter jika ingin diubah.',
            'role.required'          => 'Role / peranan pengguna wajib dipilih.',
            'sekolah_id.required_if' => 'Satuan Pendidikan wajib dipilih untuk Operator Sekolah.',
        ]);

        $data = [
            'name'       => trim($request->name),
            'username'   => trim($request->username),
            'email'      => trim($request->email),
            'role'       => $request->role,
            'sekolah_id' => $request->role === 'OPERATOR_SEKOLAH' ? $request->sekolah_id : null,
        ];

        if (!empty($request->password)) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        ActivityLog::record($user, 'updated', [
            'name' => ['data' => $user->name],
            'username' => ['data' => $user->username],
            'role' => ['data' => $user->role],
        ], "Akun pengguna '{$user->username}' diperbarui");

        return redirect()->route('users.index')
            ->with('success', "Akun pengguna '{$user->name}' berhasil diperbarui!");
    }

    /**
     * Reset password for user.
     */
    public function resetPassword(User $user)
    {
        if ($redirect = $this->ensureAdminAccess()) return $redirect;

        $newPassword = 'password';
        $user->update([
            'password' => Hash::make($newPassword),
        ]);

        ActivityLog::record($user, 'updated', [], "Password akun '{$user->username}' di-reset oleh Admin");

        return redirect()->route('users.index')
            ->with('success', "Password akun '{$user->name}' (Username: {$user->username}) berhasil di-reset menjadi '{$newPassword}'.");
    }

    /**
     * Remove user from database.
     */
    public function destroy(User $user)
    {
        if ($redirect = $this->ensureAdminAccess()) return $redirect;

        if (Auth::id() === $user->id) {
            return redirect()->route('users.index')
                ->with('error', 'Anda tidak dapat menghapus akun Anda sendiri yang sedang aktif digunakan.');
        }

        $userName = $user->name;
        $userUsername = $user->username;

        ActivityLog::record($user, 'deleted', [], "Akun pengguna '{$userUsername}' dihapus");
        $user->delete();

        return redirect()->route('users.index')
            ->with('success', "Akun pengguna '{$userName}' ({$userUsername}) berhasil dihapus.");
    }
}
