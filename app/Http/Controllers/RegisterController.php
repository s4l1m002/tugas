<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Auth; // WAJIB: Import Facade Session

class RegisterController extends Controller
{
    /**
     * Tampilkan formulir pendaftaran.
     */
    public function showRegistrationForm()
    {
        return view('register');
    }

    /**
     * Tangani proses pendaftaran, simpan user, dan lakukan login manual.
     */
    public function register(Request $request)
    {
        // 1. Validasi Data
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()], 
        ]);

        // 2. Buat User Baru
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            // Set default role sesuai yang dipakai di view ('pelanggan')
            'role' => 'pelanggan',
        ]);

        // 3. Login Otomatis dengan Session Manual (TIDAK ADA auth()->login() LAGI)
        Auth::login($user);
        return redirect()->route('dashboard')->with('success', 'Pendaftaran berhasil dan Anda telah masuk.');
    }
}