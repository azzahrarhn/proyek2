<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MataPelajaran extends Model
{
    use HasFactory;

    protected $table = 'mata_pelajaran'; // Nama tabel

    protected $fillable = ['name']; // Kolom yang dapat diisi

    public $timestamps = true; // Menggunakan timestamps
}
