<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail; // Menambahkan ini untuk verifikasi email
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail  // Implementasi interface ini
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password', 
        'kelas',  // Tambahkan ini
        'mata_pelajaran', // Tambahkan ini
        'about',
        'address',
        'phone',
        'profile_picture',
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime', // Pastikan email_verified_at cast ke datetime
            'password' => 'hashed', // Hash password
        ];
    }
}
