<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Password default untuk semua user: 123456
        $password = Hash::make('123456');

        $users = [
            [
                'name' => 'Admin Utama', 
                'email' => 'admin@mail.com', 
                'password' => $password, 
                'role' => 'admin'
            ],
            [
                'name' => 'Ketua Perusahaan', 
                'email' => 'ketua@mail.com', 
                'password' => $password, 
                'role' => 'ketua'
            ],
            [
                'name' => 'Petugas Pajak', 
                'email' => 'pajak@mail.com', 
                'password' => $password, 
                'role' => 'pajak'
            ],
            [
                'name' => 'Marketing Handal', 
                'email' => 'marketing@mail.com', 
                'password' => $password, 
                'role' => 'marketing'
            ],
            [
                'name' => 'Pelanggan Baru', 
                'email' => 'pelanggan@mail.com', 
                'password' => $password, 
                'role' => 'pelanggan'
            ],
        ];
DB::table('users');
    }
}
