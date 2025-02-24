<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class WaliKelasController extends Controller
{
    // Menampilkan daftar wali kelas
    public function index()
    {
        $wali_kelas = User::where('role', 'Wali Kelas')->get();
        return view('wali_kelas.kelola', compact('wali_kelas'));
    }

    // Menampilkan form tambah wali kelas
    public function create()
    {
        $guru = User::where('role', '!=', 'Admin')->orWhereNull('role')->get();
        return view('wali_kelas.create', compact('guru'));
    }

    // Menyimpan data wali kelas
    public function store(Request $request)
{
    try {
        // Validasi Input
        $request->validate([
            'guru_id' => 'required|exists:users,id',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8',
            'kelas' => 'required',
        ]);

        // Cek apakah guru sudah menjadi wali kelas
        $guru = User::findOrFail($request->guru_id);
        if ($guru->role === 'Wali Kelas') {
            return back()->withInput()->with('error', 'Guru ini sudah menjadi Wali Kelas dan tidak bisa dipilih lagi.');
        }

        // Cek apakah kelas sudah memiliki wali kelas
        $waliKelas = User::where('role', 'Wali Kelas')->where('kelas', $request->kelas)->first();
        if ($waliKelas) {
            return back()->withInput()->with('error', 'Kelas ini sudah memiliki Wali Kelas.');
        }

        // Update role guru menjadi wali kelas
        $guru->update([
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'Wali Kelas',
            'kelas' => $request->kelas, // Simpan kelas yang diampu
        ]);

        return redirect()->route('wali_kelas.kelola')->with('success', 'Wali Kelas berhasil ditambahkan.');

    } catch (\Exception $e) {
        return back()->withInput()->with('error', 'Gagal menambahkan Wali Kelas: ' . $e->getMessage());
    }
}

    // Menampilkan form edit wali kelas
    public function edit($id)
    {
        $wali_kelas = User::findOrFail($id);
        return view('wali_kelas.edit', compact('wali_kelas'));
    }

    // Menyimpan perubahan wali kelas
    public function update(Request $request, $id)
{
    try {
        // Validasi Input
        $request->validate([
            'email' => 'required|email|unique:users,email,' . $id,
            'password' => 'nullable|min:8', // Password opsional
            'kelas' => 'required',
        ]);

        $wali_kelas = User::findOrFail($id);

        // Cek apakah ada guru lain yang sudah menjadi wali kelas untuk kelas ini
        $waliKelasLain = User::where('role', 'Wali Kelas')
                            ->where('kelas', $request->kelas)
                            ->where('id', '!=', $id) // Hindari cek diri sendiri
                            ->first();

        if ($waliKelasLain) {
            return back()->withInput()->with('error', 'Kelas ini sudah memiliki Wali Kelas lain.');
        }

        // Perbarui data wali kelas
        $data = [
            'email' => $request->email,
            'kelas' => $request->kelas,
        ];

        // Cek apakah password dikosongkan atau ingin diubah
        if (!empty($request->password)) {
            $data['password'] = Hash::make($request->password);
        }

        $wali_kelas->update($data);

        return redirect()->route('wali_kelas.kelola')->with('success', 'Data Wali Kelas berhasil diperbarui');

    } catch (\Exception $e) {
        return back()->withInput()->with('error', 'Gagal memperbarui Wali Kelas: ' . $e->getMessage());
    }
}

    // Menghapus wali kelas
    public function destroy($id)
{
    try {
        $waliKelas = User::findOrFail($id);

        // Pastikan yang dihapus benar-benar wali kelas
        if ($waliKelas->role !== 'Wali Kelas') {
            return back()->with('error', 'Hanya Wali Kelas yang dapat dihapus.');
        }

        // Update kolom tanpa menghapus data dan tanpa mengubah kelas
        $waliKelas->update([
            'email' => null,
            'password' => null,
            'role' => 'Guru',
        ]);

        return redirect()->route('wali_kelas.kelola')->with('success', 'Wali Kelas berhasil dikembalikan menjadi Guru.');
    } catch (\Exception $e) {
        return back()->with('error', 'Gagal menghapus Wali Kelas: ' . $e->getMessage());
    }
}
}
