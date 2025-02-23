<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nilai extends Model
{
    use HasFactory;

    protected $table = 'nilai';

    protected $fillable = [
        'nama',
        'formatif_tp1', 'formatif_tp2', 'formatif_tp3', 'formatif_tp4', 'formatif_tp5',
        'formatif_tp6', 'formatif_tp7', 'formatif_tp8', 'formatif_tp9', 'formatif_tp10',
        'sumatif_lingkup_tp1', 'sumatif_lingkup_tp2', 'sumatif_lingkup_tp3', 'sumatif_lingkup_tp4', 'sumatif_lingkup_tp5',
        'sumatif_lingkup_tp6', 'sumatif_lingkup_tp7', 'sumatif_lingkup_tp8', 'sumatif_lingkup_tp9', 'sumatif_lingkup_tp10',
        'sumatif_akhir_tp1', 'sumatif_akhir_tp2', 'sumatif_akhir_tp3', 'sumatif_akhir_tp4', 'sumatif_akhir_tp5',
        'sumatif_akhir_tp6', 'sumatif_akhir_tp7', 'sumatif_akhir_tp8', 'sumatif_akhir_tp9', 'sumatif_akhir_tp10',
        'nilai_rapor', 'grade','id_mapel',
    ];

    public function mataPelajaran()
    {
        return $this->belongsTo(MataPelajaran::class, 'id_mapel');
    }

}
