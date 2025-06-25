<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Role
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  mixed ...$roles
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        $user = $request->user();

        if (!$user) {
            // User belum login, redirect ke login
            return redirect()->route('login');
        }

        if (!in_array($user->role, $roles)) {
            // Jika role user tidak ada dalam daftar role yang diizinkan
            abort(403, 'Anda tidak memiliki akses ke halaman ini.');
            // Atau bisa redirect ke dashboard:
            // return redirect('dashboard')->with('error', 'Anda tidak memiliki akses.');
        }

        return $next($request);
    }
}
