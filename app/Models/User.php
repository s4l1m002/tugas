<?php

namespace App\Models;

// Hapus use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
// use Laravel\Sanctum\HasApiTokens; // Dihapus

class User extends Authenticatable
{
    use HasFactory, Notifiable;
    // Hapus HasApiTokens dari daftar traits di bawah

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role', // Kolom role (admin, marketing, user)
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
    
    // RELASI UNTUK ROLE
    public function hasRole($role)
    {
        return $this->role === $role;
    }

    // Relasi untuk Properti yang diunggah oleh user ini (jika role-nya marketing)
    public function properties()
    {
        return $this->hasMany(Property::class, 'marketing_id');
    }
}