<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Nilai;
use App\Models\BiodataSiswa;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ChartController extends Controller
{
    public function index()
{
    $user = Auth::user();

    // Pastikan wali kelas memiliki informasi kelas
    if (!$user->kelas) {
        return view('chart.index', ['labels' => [], 'data' => []])->with('error', 'Kelas tidak ditemukan.');
    }

    // Ambil siswa dari kelas wali kelas
    $siswaKelas = BiodataSiswa::where('kelas', $user->kelas)->pluck('nama_siswa');

    // Ambil dan hitung rata-rata nilai rapor per siswa
    $nilaiSiswa = Nilai::whereIn('nama_siswa', $siswaKelas)
        ->select('nama_siswa', DB::raw('SUM(nilai_rapor) as total_nilai'), DB::raw('COUNT(id_mapel) as jumlah_mapel'))
        ->groupBy('nama_siswa')
        ->get();

    // Hitung rata-rata nilai per siswa
    $nilaiSiswa = $nilaiSiswa->map(function ($item) {
        $item->rata_rata = $item->jumlah_mapel > 0 ? round($item->total_nilai / $item->jumlah_mapel, 2) : 0;
        return $item;
    });

    // Pastikan data tidak kosong
    if ($nilaiSiswa->isEmpty()) {
        return view('chart.index', ['labels' => [], 'data' => []]);
    }

    // Kirim data ke tampilan dalam format array
    return view('chart.index', [
        'labels' => $nilaiSiswa->pluck('nama_siswa')->toArray(),
        'data' => $nilaiSiswa->pluck('rata_rata')->toArray(),
    ]);
}


public function getPieChartData() 
{
    $user = Auth::user();

    if (!$user->kelas) {
        return response()->json(['error' => 'Kelas tidak ditemukan.'], 404);
    }

    $siswaKelas = BiodataSiswa::where('kelas', $user->kelas)->pluck('nama_siswa');

    // Hitung total nilai per siswa dan jumlah mata pelajaran
    $nilaiSiswa = DB::table('nilai')
        ->whereIn('nama_siswa', $siswaKelas)
        ->select('nama_siswa', DB::raw('SUM(nilai_rapor) as total_nilai'), DB::raw('COUNT(id_mapel) as jumlah_mapel'))
        ->groupBy('nama_siswa')
        ->get();

    // Hitung rata-rata nilai dan tentukan grade
    $nilaiSiswa = $nilaiSiswa->map(function ($item) {
        $rata_rata = $item->jumlah_mapel > 0 ? round($item->total_nilai / $item->jumlah_mapel, 2) : 0;
        $item->grade = $this->getGrade($rata_rata);
        return $item;
    });

    // Hitung jumlah siswa per kategori grade
    $gradeCounts = [
        'baik_sekali' => $nilaiSiswa->where('grade', 'A')->count(),
        'baik' => $nilaiSiswa->where('grade', 'B')->count(),
        'cukup' => $nilaiSiswa->where('grade', 'C')->count(),
        'kurang' => $nilaiSiswa->whereIn('grade', ['D', 'E'])->count(),
    ];

    return response()->json($gradeCounts);
}

// Fungsi untuk menentukan grade dari rata-rata nilai rapor
private function getGrade($nilaiRapor)
{
    if ($nilaiRapor >= 85) return 'A';
    if ($nilaiRapor >= 70) return 'B';
    if ($nilaiRapor >= 55) return 'C';
    if ($nilaiRapor >= 40) return 'D';
    return 'E';
}
}
