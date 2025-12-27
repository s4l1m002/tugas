<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth; // WAJIB: Import Facade Auth

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $role): Response // string $role adalah peran yang diharapkan
    {
        // Pengecekan 1: Pastikan user sudah login
        if (!Auth::check()) {
            return redirect()->route('login'); // Arahkan ke halaman login jika belum login
        }

        // Pengecekan 2: Ambil user yang sedang login
        $user = Auth::user();

        // Pengecekan 3: Bandingkan role user dengan role yang diminta
        // $role adalah string tunggal (misal: 'admin')
        if ($user->role !== $role) {
            return redirect('/')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
        }

        // Lanjutkan jika pengecekan berhasil
        return $next($request);
    }
}