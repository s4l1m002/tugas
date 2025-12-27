<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('properties')) {
            Schema::create('properties', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('marketing_id')->nullable();
                $table->string('judul');
                $table->text('deskripsi');
                $table->decimal('harga', 15, 2);
                $table->string('alamat');
                $table->integer('luas_tanah')->nullable();
                $table->integer('luas_bangunan')->nullable();
                $table->string('gambar')->nullable();
                $table->string('status')->default('pending');
                $table->timestamp('tanggal_upload')->useCurrent();
                $table->unsignedBigInteger('approved_by')->nullable();
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('properties');
    }
};