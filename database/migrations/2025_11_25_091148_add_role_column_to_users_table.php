<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Tambahkan kolom 'role' ke tabel 'users'
        Schema::table('users', function (Blueprint $table) {
            // Tipe data string dengan nilai default 'user'
            $table->string('role')->default('user')->after('password'); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Hapus kolom 'role' jika migrasi di-rollback
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('role');
        });
    }
};