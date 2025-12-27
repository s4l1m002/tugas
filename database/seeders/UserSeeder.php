<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@example.test'],
            ['name' => 'Admin Tester', 'password' => Hash::make('password123'), 'role' => 'admin']
        );

        User::updateOrCreate(
            ['email' => 'marketing@example.test'],
            ['name' => 'Marketing Tester', 'password' => Hash::make('password123'), 'role' => 'marketing']
        );

        User::updateOrCreate(
            ['email' => 'pelanggan@example.test'],
            ['name' => 'Pelanggan Tester', 'password' => Hash::make('password123'), 'role' => 'pelanggan']
        );
        User::updateOrCreate(
            ['email' => 'ketua@example.test'],
            ['name' => 'Ketua Tester', 'password' => Hash::make('password123'), 'role' => 'ketua']
);
    }
}