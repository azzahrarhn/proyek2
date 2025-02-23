<?php

namespace App\Http\Controllers;

use App\Models\BiodataSiswa;
use App\Models\User;
use App\Models\Nilai;
use App\Models\MataPelajaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; 

class NilaiController extends Controller
{
    public function index(Request $request)
{
    $user = Auth::user();
    $id_mapel = $request->query('id_mapel');

    if (!$id_mapel) {
        return redirect('/dashboard')->with('error', 'Pilih mata pelajaran terlebih dahulu.');
    }

    // Ambil siswa berdasarkan kelas wali kelas
    $siswaList = BiodataSiswa::where('kelas', $user->kelas)->get();

    // Ambil nilai siswa yang sudah ada di database berdasarkan nama_siswa
    $nilaiList = Nilai::where('id_mapel', $id_mapel)->get()->keyBy('nama_siswa');

    $mataPelajaran = MataPelajaran::find($id_mapel);

    // Gabungkan data siswa dan nilai
    $dataSiswaNilai = $siswaList->map(function ($siswa) use ($nilaiList) {
        $nilai = $nilaiList[$siswa->nama_siswa] ?? null; // Cari berdasarkan nama_siswa

        return (object) [
            'id_siswa' => $siswa->id,
            'nama_siswa' => $siswa->nama_siswa,
            'id_nilai' => $nilai ? $nilai->id : null,
            'formatif_tp1' => $nilai ? $nilai->formatif_tp1 : 0,
            'formatif_tp2' => $nilai ? $nilai->formatif_tp2 : 0,
            'formatif_tp3' => $nilai ? $nilai->formatif_tp3 : 0,
            'formatif_tp4' => $nilai ? $nilai->formatif_tp4 : 0,
            'formatif_tp5' => $nilai ? $nilai->formatif_tp5 : 0,
            'sumatif_lingkup_tp1' => $nilai ? $nilai->sumatif_lingkup_tp1 : 0,
            'sumatif_lingkup_tp2' => $nilai ? $nilai->sumatif_lingkup_tp2 : 0,
            'sumatif_lingkup_tp3' => $nilai ? $nilai->sumatif_lingkup_tp3 : 0,
            'sumatif_lingkup_tp4' => $nilai ? $nilai->sumatif_lingkup_tp4 : 0,
            'sumatif_lingkup_tp5' => $nilai ? $nilai->sumatif_lingkup_tp5 : 0,
            'sumatif_akhir_tp1' => $nilai ? $nilai->sumatif_akhir_tp1 : 0,
            'sumatif_akhir_tp2' => $nilai ? $nilai->sumatif_akhir_tp2 : 0,
            'sumatif_akhir_tp3' => $nilai ? $nilai->sumatif_akhir_tp3 : 0,
            'sumatif_akhir_tp4' => $nilai ? $nilai->sumatif_akhir_tp4 : 0,
            'sumatif_akhir_tp5' => $nilai ? $nilai->sumatif_akhir_tp5 : 0,
            'nilai_rapor' => $nilai ? $nilai->nilai_rapor : 0,
            'grade' => $nilai ? $nilai->grade : '-',
        ];
    });

    return view('nilai.create', compact('dataSiswaNilai', 'id_mapel', 'mataPelajaran'));
}

public function updateNilai(Request $request) 
{
    try {
        $request->validate([
            'id_siswa' => 'required',
            'id_mapel' => 'required',
            'field' => 'required',
            'nilai' => 'required|numeric'
        ]);

        // Ambil nama siswa dari tabel biodata_siswa berdasarkan id_siswa
        $biodataSiswa = BiodataSiswa::where('id', $request->id_siswa)->first();

        if (!$biodataSiswa) {
            return response()->json([
                'success' => false,
                'message' => 'Siswa tidak ditemukan di database.'
            ], 404);
        }

        $namaSiswa = $biodataSiswa->nama_siswa;

        // Cek apakah nilai sudah ada berdasarkan nama_siswa dan id_mapel
        $nilai = Nilai::where('nama_siswa', $namaSiswa)
                      ->where('id_mapel', $request->id_mapel)
                      ->first();

        if ($nilai) {
            // Jika data sudah ada, lakukan update
            $nilai->{$request->field} = $request->nilai;
        } else {
            // Jika belum ada, buat data baru
            $nilai = new Nilai();
            $nilai->nama_siswa = $namaSiswa; // Simpan nama siswa, bukan id_siswa
            $nilai->id_mapel = $request->id_mapel;
            $nilai->{$request->field} = $request->nilai;
        }

        // Simpan perubahan (insert atau update)
        $nilai->save();
         // Perbarui nilai rapor dan grade setelah menyimpan perubahan
        $this->updateRaporAndGrade($nilai);

        return response()->json([
            'success' => true,
            'message' => 'Nilai berhasil disimpan!',
            'nilai_rapor' => $nilai->nilai_rapor, // Kirim nilai rapor ke frontend
            'grade' => $nilai->grade 
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Terjadi kesalahan: ' . $e->getMessage()
        ], 500);
    }
}
    
    private function updateRaporAndGrade($nilai)
    {
        // Ambil semua nilai yang berkontribusi pada nilai rapor
        $totalNilai = 0;
        $count = 0;
    
        foreach (['formatif', 'sumatif_lingkup', 'sumatif_akhir'] as $category) {
            for ($i = 1; $i <= 10; $i++) {
                $field = "{$category}_tp{$i}";
                if (!is_null($nilai->$field)) {
                    $totalNilai += $nilai->$field;
                    $count++;
                }
            }
        }
    
        // Hitung nilai rapor dan grade jika ada nilai yang dihitung
        if ($count > 0) {
            $nilaiRapor = min(100, round($totalNilai / $count));
            $grade = $this->getGrade($nilaiRapor);
    
            // Simpan ke database
            $nilai->update([
                'nilai_rapor' => $nilaiRapor,
                'grade' => $grade
            ]);
        }
    }
    
    private function getGrade($nilaiRapor)
    {
        if ($nilaiRapor >= 85) return 'A';
        if ($nilaiRapor >= 70) return 'B';
        if ($nilaiRapor >= 55) return 'C';
        if ($nilaiRapor >= 40) return 'D';
        return 'E';
    }    
    

    public function destroy($id)
    {
        $nilai = Nilai::findOrFail($id);
        $nilai->delete();

        return response()->json(['success' => true, 'message' => 'Data berhasil dihapus!']);
    }

    public function updateRapor(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:nilai,id',
            'nilai_rapor' => 'required|integer|min:0|max:100',
            'grade' => 'required|string|max:1'
        ]);

        $nilai = Nilai::find($request->id);
        $nilai->nilai_rapor = $request->nilai_rapor;
        $nilai->grade = $request->grade;
        $nilai->save();

        return response()->json(['success' => true, 'message' => 'Nilai rapor diperbarui!']);
    }

    public function getNilai($id)
    {
        $nilai = Nilai::find($id);

        if (!$nilai) {
            return response()->json(['success' => false, 'message' => 'Data tidak ditemukan.']);
        }

        return response()->json(['success' => true, 'nilai' => $nilai]);
    }

}