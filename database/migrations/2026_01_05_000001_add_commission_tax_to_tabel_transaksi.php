<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('tabel_transaksi')) return;

        Schema::table('tabel_transaksi', function (Blueprint $table) {
            if (! Schema::hasColumn('tabel_transaksi', 'office_fee')) {
                $table->decimal('office_fee', 15, 2)->nullable()->after('komisi_marketing');
            }
            if (! Schema::hasColumn('tabel_transaksi', 'marketing_gross')) {
                $table->decimal('marketing_gross', 15, 2)->nullable()->after('office_fee');
            }
            if (! Schema::hasColumn('tabel_transaksi', 'office_share')) {
                $table->decimal('office_share', 15, 2)->nullable()->after('marketing_gross');
            }
            if (! Schema::hasColumn('tabel_transaksi', 'marketing_tax')) {
                $table->decimal('marketing_tax', 15, 2)->nullable()->after('office_share');
            }
            if (! Schema::hasColumn('tabel_transaksi', 'marketing_net')) {
                $table->decimal('marketing_net', 15, 2)->nullable()->after('marketing_tax');
            }
            if (! Schema::hasColumn('tabel_transaksi', 'buyer_seller_tax')) {
                $table->decimal('buyer_seller_tax', 15, 2)->nullable()->after('marketing_net');
            }
        });
    }

    public function down(): void
    {
        if (! Schema::hasTable('tabel_transaksi')) return;

        Schema::table('tabel_transaksi', function (Blueprint $table) {
            if (Schema::hasColumn('tabel_transaksi', 'buyer_seller_tax')) {
                $table->dropColumn('buyer_seller_tax');
            }
            if (Schema::hasColumn('tabel_transaksi', 'marketing_net')) {
                $table->dropColumn('marketing_net');
            }
            if (Schema::hasColumn('tabel_transaksi', 'marketing_tax')) {
                $table->dropColumn('marketing_tax');
            }
            if (Schema::hasColumn('tabel_transaksi', 'office_share')) {
                $table->dropColumn('office_share');
            }
            if (Schema::hasColumn('tabel_transaksi', 'marketing_gross')) {
                $table->dropColumn('marketing_gross');
            }
            if (Schema::hasColumn('tabel_transaksi', 'office_fee')) {
                $table->dropColumn('office_fee');
            }
        });
    }
};
