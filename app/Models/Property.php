<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Transaction;

/**
 * App\Models\Property
 *
 * @property int $id
 * @property string $judul
 * @property string|null $deskripsi
 * @property int|null $harga
 * @property string|null $alamat
 * @property float|null $luas_tanah
 * @property float|null $luas_bangunan
 * @property string|null $gambar
 * @property string|null $status
 * @property int|null $marketing_id
 * @property int|null $user_id
 */

class Property extends Model
{
    use HasFactory;

    // WAJIB: Tentukan nama tabel yang non-standar (sesuai database Anda)
    protected $table = 'properties';

    /**
     * The attributes that are mass assignable.
     * Pastikan semua kolom yang diisi di Seeder/Controller ada di sini.
     *
     * @var array<int, string>
     */
    /**
     * Fields that are mass assignable.
     * Using $fillable so Property::create($data) can set these attributes.
     */
    protected $fillable = [
        'judul',
        'deskripsi',
        'harga',
        'alamat',
        'luas_tanah',
        'luas_bangunan',
        'gambar',
        'status',
        'visited',
        'marketing_id',
        'user_id',
    ];

    /**
     * Relasi dengan user (marketing) yang mengupload properti.
     */
    public function marketing()
    {
        // Asumsi relasi ke Model User
        return $this->belongsTo(User::class, 'marketing_id');
    }

    /**
     * Get the owner user for this property, tolerant to either
     * `marketing_id` or legacy `user_id` column.
     * Returns a User model or null.
     */
    public function owner()
    {
        $ownerId = $this->marketing_id ?? $this->user_id ?? null;
        if (! $ownerId) {
            return null;
        }

        return User::find($ownerId);
    }

    /**
     * Relasi ke transaksi yang terkait dengan properti ini.
     */
    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'property_id');
    }

    /**
     * Apakah properti sudah terjual (ada transaksi berstatus 'paid').
     */
    public function isSold()
    {
        return $this->transactions()->where('status_pembayaran', 'paid')->exists();
    }

    /**
     * Akses dinamika untuk memeriksa sold status dari blade: $property->is_sold
     */
    public function getIsSoldAttribute()
    {
        return $this->isSold();
    }

    // Anda bisa menambahkan relasi lain di sini jika diperlukan
}