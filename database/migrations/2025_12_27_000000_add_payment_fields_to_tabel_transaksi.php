<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('tabel_transaksi')) {
            Schema::table('tabel_transaksi', function (Blueprint $table) {
                if (! Schema::hasColumn('tabel_transaksi', 'pelanggan_id')) {
                    $table->foreignId('pelanggan_id')->nullable()->constrained('users')->nullOnDelete();
                }
                if (! Schema::hasColumn('tabel_transaksi', 'pembayaran_metode')) {
                    $table->string('pembayaran_metode')->nullable()->after('komisi_marketing');
                }
                if (! Schema::hasColumn('tabel_transaksi', 'pembayaran_rekening')) {
                    $table->string('pembayaran_rekening')->nullable()->after('pembayaran_metode');
                }
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('tabel_transaksi')) {
            Schema::table('tabel_transaksi', function (Blueprint $table) {
                if (Schema::hasColumn('tabel_transaksi', 'pembayaran_rekening')) {
                    $table->dropColumn('pembayaran_rekening');
                }
                if (Schema::hasColumn('tabel_transaksi', 'pembayaran_metode')) {
                    $table->dropColumn('pembayaran_metode');
                }
                if (Schema::hasColumn('tabel_transaksi', 'pelanggan_id')) {
                    $table->dropForeign(['pelanggan_id']);
                    $table->dropColumn('pelanggan_id');
                }
            });
        }
    }
};
