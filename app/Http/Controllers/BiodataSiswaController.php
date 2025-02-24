<?php

namespace App\Http\Controllers;

use App\Models\BiodataSiswa;
use App\Models\User;
use Illuminate\Http\Request;

class BiodataSiswaController extends Controller
{
    /**
     * Menampilkan form tambah biodata siswa.
     */
    public function create()
    {
        return view('biodata_siswa.create'); // Pastikan ada file view ini di resources/views/biodata_siswa/create.blade.php
    }

    /**
     * Menyimpan data ke dalam database.
     */
    public function store(Request $request)
    {
        try {
            $data = $request->validate([
                'nama_siswa' => 'required|string|max:255',
                'nisn' => 'required|string|unique:biodata_siswa,nisn',
                'kelas' => 'nullable|string',
                'alamat' => 'nullable|string',
                'agama' => 'nullable|string',
                'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
                'tempat_lahir' => 'nullable|string',
                'tanggal_lahir' => 'nullable|date',
                'nama_ayah' => 'nullable|string',
                'pekerjaan_ayah' => 'nullable|string',
                'nama_ibu' => 'nullable|string',
                'pekerjaan_ibu' => 'nullable|string',
            ]);

            // Simpan ke database
            BiodataSiswa::create($data);

            return redirect()->route('biodata_siswa.kelola')->with('success', 'Biodata siswa berhasil ditambahkan!');
        } catch (\Exception $e) {
            dd($e->getMessage()); // Menampilkan error jika terjadi masalah
        }
    }

    /**
     * Menampilkan daftar biodata siswa.
     */
    public function kelola(Request $request)
    {
        // Ambil daftar kelas yang tersedia dan urutkan dari yang terkecil
        $daftarKelas = BiodataSiswa::select('kelas')->distinct()->orderBy('kelas')->get();

        // Tentukan kelas terkecil sebagai default jika tidak ada yang dipilih
        $kelasDipilih = $request->query('kelas', optional($daftarKelas->first())->kelas);

        // Ambil data siswa berdasarkan kelas yang dipilih
        $siswa = BiodataSiswa::where('kelas', $kelasDipilih)->get();

        // Ambil wali kelas berdasarkan kelas yang dipilih
        $waliKelas = User::where('role', 'Wali Kelas')->where('kelas', $kelasDipilih)->first();

        return view('biodata_siswa.kelola', compact('siswa', 'daftarKelas', 'kelasDipilih', 'waliKelas'));
    }

    public function edit($id)
    {
        $siswa = BiodataSiswa::findOrFail($id);
        return view('biodata_siswa.edit', compact('siswa'));
    }

    public function update(Request $request, $id)
    {
        $siswa = BiodataSiswa::findOrFail($id);

        $request->validate([
            'nama_siswa' => 'required|string|max:255',
            'nisn' => 'required|string|unique:biodata_siswa,nisn,' . $id,
            'kelas' => 'nullable|string',
            'alamat' => 'nullable|string',
            'agama' => 'nullable|string',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'tempat_lahir' => 'nullable|string',
            'tanggal_lahir' => 'nullable|date',
            'nama_ayah' => 'nullable|string',
            'pekerjaan_ayah' => 'nullable|string',
            'nama_ibu' => 'nullable|string',
            'pekerjaan_ibu' => 'nullable|string',
        ]);

        $siswa->update($request->all());

        return redirect()->route('biodata_siswa.kelola')->with('success', 'Biodata siswa berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $siswa = BiodataSiswa::findOrFail($id);
        $siswa->delete();

        return redirect()->route('biodata_siswa.kelola')->with('success', 'Biodata siswa berhasil dihapus!');
    }

}
