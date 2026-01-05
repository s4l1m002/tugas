<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('properties') || ! Schema::hasTable('tabel_transaksi')) {
            return;
        }

        $propertyIds = DB::table('tabel_transaksi')
            ->where('status_pembayaran', 'paid')
            ->pluck('property_id')
            ->unique()
            ->toArray();

        if (! empty($propertyIds)) {
            DB::table('properties')
                ->whereIn('id', $propertyIds)
                ->update([
                    'imb_complete' => true,
                    'pbb_complete' => true,
                    'sertifikat_complete' => true,
                ]);
        }
    }

    public function down(): void
    {
        if (! Schema::hasTable('properties') || ! Schema::hasTable('tabel_transaksi')) {
            return;
        }

        $propertyIds = DB::table('tabel_transaksi')
            ->where('status_pembayaran', 'paid')
            ->pluck('property_id')
            ->unique()
            ->toArray();

        if (! empty($propertyIds)) {
            DB::table('properties')
                ->whereIn('id', $propertyIds)
                ->update([
                    'imb_complete' => false,
                    'pbb_complete' => false,
                    'sertifikat_complete' => false,
                ]);
        }
    }
};
