<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // 1) bila belum ada kolom user_id, tambahkan
        Schema::table('properties', function (Blueprint $table) {
            if (! Schema::hasColumn('properties', 'user_id')) {
                $table->unsignedBigInteger('user_id')->nullable()->after('marketing_id');
            }
        });

        // 2) bila ada marketing_id dan user_id kosong, pindahkan nilainya
        if (Schema::hasColumn('properties', 'marketing_id')) {
            DB::statement('UPDATE properties SET user_id = marketing_id WHERE (user_id IS NULL OR user_id = 0) AND marketing_id IS NOT NULL');
        }

        // 3) jika kolom marketing_id masih ada, hapus saja (sudah dipindahkan)
        Schema::table('properties', function (Blueprint $table) {
            if (Schema::hasColumn('properties', 'marketing_id')) {
                $table->dropColumn('marketing_id');
            }
        });
    }

    public function down(): void
    {
        // kembalikan marketing_id jika belum ada
        Schema::table('properties', function (Blueprint $table) {
            if (! Schema::hasColumn('properties', 'marketing_id')) {
                $table->unsignedBigInteger('marketing_id')->nullable()->after('id');
            }
        });

        // pindah kembali user_id -> marketing_id
        if (Schema::hasColumn('properties', 'user_id')) {
            DB::statement('UPDATE properties SET marketing_id = user_id WHERE marketing_id IS NULL AND user_id IS NOT NULL');
        }

        // hapus user_id bila ada
        Schema::table('properties', function (Blueprint $table) {
            if (Schema::hasColumn('properties', 'user_id')) {
                $table->dropColumn('user_id');
            }
        });
    }
};