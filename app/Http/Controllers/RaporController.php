<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Nilai;
use App\Models\MataPelajaran;
use App\Models\BiodataSiswa;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class RaporController extends Controller
{
    public function cetakRapor(Request $request)
{
    $namaSiswa = $request->query('nama_siswa');

    // Ambil data siswa dan wali kelas
    $siswa = BiodataSiswa::where('nama_siswa', $namaSiswa)->first();
    $waliKelas = Auth::user()->name;

    if (!$siswa) {
        return redirect()->back()->with('error', 'Siswa tidak ditemukan.');
    }

    // Ambil nilai siswa berdasarkan nama
    $nilaiSiswa = Nilai::where('nama_siswa', $namaSiswa)->get(['id_mapel', 'nilai_rapor', 'grade']);

    // Ambil nama mata pelajaran dari id_mapel, menggunakan kolom `name`
    $nilaiSiswa->map(function ($nilai) {
        $mapel = MataPelajaran::find($nilai->id_mapel);
        $nilai->nama_mapel = $mapel ? $mapel->name : 'Tidak Diketahui';
        return $nilai;
    });

    // Hitung total nilai rapor dan grade rata-rata
    $totalNilai = $nilaiSiswa->sum('nilai_rapor');
    $jumlahMapel = $nilaiSiswa->count();
    $rataRata = $jumlahMapel > 0 ? round($totalNilai / $jumlahMapel, 2) : 0;

    // Tentukan grade rata-rata
    $grade = $this->getGrade($rataRata);

    return view('rapor.cetak', compact('siswa', 'waliKelas', 'nilaiSiswa', 'totalNilai', 'rataRata', 'grade'));
}

// Fungsi untuk menentukan grade berdasarkan nilai rata-rata
private function getGrade($nilai)
{
    if ($nilai >= 85) return 'A';
    if ($nilai >= 70) return 'B';
    if ($nilai >= 55) return 'C';
    if ($nilai >= 40) return 'D';
    return 'E';
}

}