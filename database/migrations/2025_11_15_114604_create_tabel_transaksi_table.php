<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! \Illuminate\Support\Facades\Schema::hasTable('tabel_transaksi')) {
            Schema::create('tabel_transaksi', function (Blueprint $table) {
                $table->id();
                $table->foreignId('property_id')->constrained('properties')->onDelete('cascade');
                $table->foreignId('marketing_id')->constrained('users')->onDelete('restrict');
                $table->date('tanggal_transaksi');
                $table->decimal('harga_jual', 15, 2);
                $table->decimal('komisi_persen', 5, 2);
                $table->decimal('komisi_marketing', 15, 2);
                $table->string('status_pembayaran')->default('pending');
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('tabel_transaksi');
    }
};