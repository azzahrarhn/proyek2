<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProfileWaliKelas extends Model
{
    use HasFactory;

    /**
     * Nama tabel di database.
     *
     * @var string
     */
    protected $table = 'profile_wali_kelas';

    /**
     * Kolom yang dapat diisi (mass assignable).
     *
     * @var array
     */
    protected $fillable = [
        'nama',
        'email',
        'no_telp',
        'jenis_kelamin',
        'alamat',
        'tanggal_lahir',
        'foto_profil',
    ];

    /**
     * Menentukan tipe data untuk kolom tertentu.
     *
     * @var array
     */
    protected $casts = [
        'tanggal_lahir' => 'date',
    ];
}
