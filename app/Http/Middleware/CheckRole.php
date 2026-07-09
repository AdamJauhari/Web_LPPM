<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    /**
     * Handle an incoming request.
     * Cek apakah user yang login memiliki salah satu role yang diizinkan.
     *
     * Penggunaan di route: ->middleware('role:admin_lppm,admin_uppm')
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string[]  ...$roles
     * @return mixed
     */
    public function handle($request, Closure $next, ...$roles)
    {
        if (!Auth::check()) {
            return redirect('/login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $userRole = Auth::user()->role;

        if (empty($roles) || in_array($userRole, $roles)) {
            return $next($request);
        }

        // Jika role tidak sesuai, redirect ke halaman yang sesuai
        if ($userRole === 'dosen') {
            return redirect('/dosen/dashboard')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
        }

        return redirect('/login')->with('error', 'Akses ditolak. Role Anda tidak memiliki izin.');
    }
}
