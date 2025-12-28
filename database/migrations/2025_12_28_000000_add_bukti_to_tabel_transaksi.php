<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        if (Schema::hasTable('tabel_transaksi') && ! Schema::hasColumn('tabel_transaksi', 'bukti')) {
            Schema::table('tabel_transaksi', function (Blueprint $table) {
                $table->string('bukti')->nullable()->after('pembayaran_rekening');
            });
        }
    }

    public function down()
    {
        if (Schema::hasTable('tabel_transaksi') && Schema::hasColumn('tabel_transaksi', 'bukti')) {
            Schema::table('tabel_transaksi', function (Blueprint $table) {
                $table->dropColumn('bukti');
            });
        }
    }
};
