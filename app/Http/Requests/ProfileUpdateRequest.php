<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Tentukan apakah pengguna diizinkan untuk membuat permintaan ini.
     *
     * Di sini kita kembalikan true karena hanya pengguna terautentikasi yang
     * harus dapat memperbarui profilnya.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Dapatkan aturan validasi yang berlaku untuk permintaan.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        // Mendapatkan instance user yang sedang login
        $user = $this->user();
        
        // Aturan validasi
        return [
            // Nama tidak boleh kosong, harus berupa string, dan maksimal 255 karakter
            'name' => ['required', 'string', 'max:255'],

            // Email tidak boleh kosong, harus berupa format email valid, dan unik di tabel 'users'.
            // Namun, lewati validasi unik jika email tersebut adalah email milik user saat ini.
            'email' => ['required', 'email', 'max:255', Rule::unique(User::class)->ignore($user->id)],

            // Tambahan: Contoh validasi untuk kolom 'nohp' (nomor handphone) jika ada di tabel User.
            // Aturan: Tidak boleh kosong, harus berupa string/angka, unik (kecuali milik user saat ini), dan minimal 10 digit.
            'nohp' => ['required', 'string', 'min:10', 'max:15', Rule::unique(User::class)->ignore($user->id)],
        ];
    }
    
    /**
     * Dapatkan pesan kustom untuk aturan validasi yang ditentukan.
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Nama tidak boleh kosong.',
            'name.max' => 'Nama maksimal 255 karakter.',
            
            'email.required' => 'Email tidak boleh kosong.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email ini sudah terdaftar. Silakan gunakan email lain.',
            
            'nohp.required' => 'Nomor Handphone tidak boleh kosong.',
            'nohp.unique' => 'Nomor Handphone ini sudah terdaftar.',
            'nohp.min' => 'Nomor Handphone minimal 10 digit.',
        ];
    }
}