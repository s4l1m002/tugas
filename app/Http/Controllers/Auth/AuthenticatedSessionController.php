<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Menampilkan tampilan login.
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
        $request->authenticate();

        $request->session()->regenerate();

        // Mengarahkan user berdasarkan role setelah login berhasil
        $user = Auth::user();
        if ($user->role === 'admin' || $user->role === 'ketua') {
            return redirect()->intended(route('admin.pending', absolute: false));
        } elseif ($user->role === 'marketing') {
            return redirect()->intended(route('marketing.my_properties', absolute: false));
        } elseif ($user->role === 'pajak') {
            return redirect()->intended(route('pajak.report', absolute: false));
        } else {
            // Role 'pelanggan' atau role lain
            return redirect()->intended(route('home', absolute: false));
        }
    }

    /**
     * Menghancurkan sesi otentikasi (logout).
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}