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
        Schema::create('contacts', function (Blueprint $table) {
    $table->id();
    $table->foreignId('property_id')->constrained('properties'); // Properti yang diminati
    $table->foreignId('marketing_id')->constrained('users');     // Marketing yang dituju
    $table->foreignId('pelanggan_id')->constrained('users');     // Pelanggan yang menghubungi
    $table->text('pesan')->nullable();                        // Pesan dari pelanggan
    $table->string('status')->default('pending');             // Status kontak: pending, solved
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contacts');
    }
};
