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
            ]);

            // Ambil data guru yang dipilih
            $guru = User::findOrFail($request->guru_id);

            // Update role guru menjadi wali kelas
            $guru->update([
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 'Wali Kelas',
            ]);

            return redirect()->route('wali_kelas.kelola')->with('success', 'Wali Kelas berhasil ditambahkan');

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
            $request->validate([
                'email' => 'required|email|unique:users,email,' . $id,
                'password' => 'nullable|min:8', // Password opsional
            ]);

            $wali_kelas = User::findOrFail($id);

            // Cek apakah password dikosongkan
            $data = [
                'email' => $request->email,
            ];

            if (!empty($request->password)) {
                $data['password'] = Hash::make($request->password);
            }

            // Update data
            $wali_kelas->update($data);

            return redirect()->route('wali_kelas.kelola')->with('success', 'Data Wali Kelas berhasil diperbarui');

        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Gagal memperbarui Wali Kelas: ' . $e->getMessage());
        }
    }

    // Menghapus wali kelas
    public function destroy($id)
    {
        User::findOrFail($id)->delete();
        return redirect()->route('wali_kelas.kelola')->with('success', 'Wali Kelas berhasil dihapus');
    }
}
