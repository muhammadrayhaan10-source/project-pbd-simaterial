<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // Menampilkan halaman login
    public function showLogin()
    {
        if (session()->has('iduser')) {
            return redirect('/dashboard');
        }

        return view('auth.login');
    }

    // Memproses login menggunakan Raw SQL
    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ], [
            'username.required' => 'Username wajib diisi.',
            'password.required' => 'Password wajib diisi.',
        ]);

        $users = DB::select('
            SELECT u.iduser, u.username, u.password, u.idrole, r.nama_role
            FROM user u
            LEFT JOIN role r ON u.idrole = r.idrole
            WHERE u.username = ?
            LIMIT 1
        ', [$request->username]);

        $user = $users[0] ?? null;

        if (!$user || !$this->isPasswordValid($request->password, (string) $user->password)) {
            return redirect()->back()->withInput()->withErrors([
                'error' => 'Username atau password salah.',
            ]);
        }

        $request->session()->regenerate();
        session([
            'iduser'    => $user->iduser,
            'username'  => $user->username,
            'idrole'    => $user->idrole,
            'nama_role' => $user->nama_role ?? 'User',
        ]);

        return redirect('/dashboard')->with(
            'success',
            "Selamat datang, {$user->username} ({$user->nama_role})!"
        );
    }

    // Memproses logout
    public function logout(Request $request)
    {
        $request->session()->forget(['iduser', 'username', 'idrole', 'nama_role']);
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login')->with('success', 'Anda telah berhasil logout.');
    }

    // Mencocokkan password (bcrypt/argon, SHA-256, MD5, atau plain text)
    private function isPasswordValid(string $inputPassword, string $dbPassword): bool
    {
        if (str_starts_with($dbPassword, '$2y$') || str_starts_with($dbPassword, '$2a$') || str_starts_with($dbPassword, '$argon')) {
            return Hash::check($inputPassword, $dbPassword);
        }

        if (strlen($dbPassword) === 64 && hash('sha256', $inputPassword) === strtolower($dbPassword)) {
            return true;
        }

        if (strlen($dbPassword) === 32 && md5($inputPassword) === strtolower($dbPassword)) {
            return true;
        }

        return $inputPassword === $dbPassword;
    }
}
