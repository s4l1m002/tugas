<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PropertySeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();

        // cari id user marketing
        $marketing = DB::table('users')->where('role', 'marketing')->first();

        if (! $marketing) {
            $this->command->info('No marketing user found, skipping property seeding.');
            return;
        }

        $props = [
            [
                'user_id' => $marketing->id,
                'judul' => 'Rumah Minimalis Contoh',
                'deskripsi' => 'Rumah 2 kamar, lokasi strategis.',
                'harga' => 450000000,
                'alamat' => 'Jl. Contoh No.1',
                'luas_tanah' => 100,
                'luas_bangunan' => 80,
                'gambar' => null,
                'status' => 'published',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'user_id' => $marketing->id,
                'judul' => 'Ruko Siap Pakai',
                'deskripsi' => 'Ruko 2 lantai cocok untuk usaha.',
                'harga' => 750000000,
                'alamat' => 'Jl. Contoh No.2',
                'luas_tanah' => 120,
                'luas_bangunan' => 200,
                'gambar' => null,
                'status' => 'published',
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ];

        foreach ($props as $p) {
            DB::table('properties')->insert($p);
        }
    }
}