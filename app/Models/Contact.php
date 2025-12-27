<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Contact
 *
 * @property int $id
 * @property int|null $property_id
 * @property int|null $marketing_id
 * @property int|null $pelanggan_id
 * @property string|null $pesan
 * @property string|null $status
 */

class Contact extends Model
{
    use HasFactory;

    // gunakan tabel 'contacts' sesuai migration
    protected $table = 'contacts';

    protected $fillable = [
        'property_id',
        'marketing_id',
        'pelanggan_id',
        'pesan',
        'status', // new, read, replied
    ];

    public function property()
    {
        return $this->belongsTo(Property::class);
    }
    
    public function marketing()
    {
        return $this->belongsTo(User::class, 'marketing_id');
    }

    public function pelanggan()
    {
        return $this->belongsTo(User::class, 'pelanggan_id');
    }
}