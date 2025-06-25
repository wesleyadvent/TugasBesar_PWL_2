<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;
use App\Models\User;

class AuthenticatedSessionController extends Controller
{
    /**
     * Menampilkan halaman login.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Menangani permintaan login yang masuk.
     */
    public function store(Request $request): RedirectResponse
    {
        // Validasi input
        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // Cari user berdasarkan email
        $user = User::where('email', $request->email)->first();

        // Jika user tidak ditemukan atau password salah
        if (!$user || !Hash::check($request->password, $user->password)) {
            return back()->withErrors([
                'email' => 'Email atau password salah.',
            ]);
        }

        // Jika akun tidak aktif
        if ($user->status !== 'aktif') {
            return back()->withErrors([
                'email' => 'Akun Anda tidak aktif.',
            ]);
        }

        // Login manual
        Auth::login($user, $request->boolean('remember'));
        $request->session()->regenerate();

        // Arahkan sesuai role
        switch ($user->role) {
            case 'administrator':
                return redirect()->route('administrator.dashboard');
            case 'keuangan':
                return redirect()->route('keuangan.dashboard');
            case 'panitia':
                return redirect()->route('panitia.dashboard');
            case 'member':
                return redirect()->route('member.dashboard');
            default:
                Auth::logout();
                return redirect()->route('login')->withErrors([
                    'role' => 'Role tidak dikenali.',
                ]);
        }
    }

    /**
     * Logout dan hancurkan sesi.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
