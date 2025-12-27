<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;
    
    protected $table = 'tabel_transaksi'; 

    protected $fillable = [
        'property_id',
        'marketing_id',
        'tanggal_transaksi',
        'harga_jual',
        'komisi_persen',
        'komisi_marketing',
        'status_pembayaran',
        'pelanggan_id',
        'pembayaran_metode',
        'pembayaran_rekening',
    ];

    public function property()
    {
        return $this->belongsTo(Property::class, 'property_id');
    }

    public function marketing()
    {
        
        return $this->belongsTo(User::class, 'marketing_id');
    }
}