<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\MataPelajaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class GuruController extends Controller
{
    // Menampilkan daftar guru
    public function index()
    {
        $guru = User::where('role', '!=', 'Admin')->orWhereNull('role')->get();
        return view('guru.kelola', compact('guru'));
    }

    // Menampilkan form tambah guru
    public function create()
    {
        $mata_pelajaran = MataPelajaran::all();
        return view('guru.create', compact('mata_pelajaran'));
    }

    // Menyimpan data guru
    public function store(Request $request)
    {
        try {
            // Validasi Input
            $request->validate([
                'name' => 'required|string|max:255',
                'kelas' => 'required|integer|between:1,6',
                'mata_pelajaran' => 'nullable|array', // Validasi array dari checkbox
                'mata_pelajaran.*' => 'string|max:255', // Validasi setiap item dalam array
                'address' => 'nullable|string|max:255',
                'phone' => 'nullable|string|max:15',
            ]);

            // Ubah array mata pelajaran menjadi string dipisahkan koma
            $mataPelajaranString = $request->mata_pelajaran ? implode(', ', $request->mata_pelajaran) : null;

            // Simpan ke database
            User::create([
                'name' => $request->name,
                'kelas' => $request->kelas,
                'mata_pelajaran' => $mataPelajaranString,
                'address' => $request->address,
                'phone' => $request->phone,
            ]);

            return redirect()->route('guru.kelola')->with('success', 'Guru berhasil ditambahkan');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Gagal menambahkan guru: ' . $e->getMessage());
        }
    }

    // Menampilkan form edit guru
    public function edit($id)
    {
        $guru = User::findOrFail($id);
        $mata_pelajaran = MataPelajaran::all();

        // Ubah string mata_pelajaran menjadi array agar checkbox bisa tetap terpilih
        $selectedMataPelajaran = explode(', ', $guru->mata_pelajaran);
        return view('guru.edit', compact('guru', 'mata_pelajaran', 'selectedMataPelajaran'));
    }

    // Menyimpan perubahan data guru
    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'kelas' => 'required|integer|between:1,6',
                'mata_pelajaran' => 'nullable|array', // Mata pelajaran sebagai array
                'mata_pelajaran.*' => 'string|max:255', 
                'address' => 'nullable|string|max:255',
                'phone' => 'nullable|string|max:15',
            ]);

            $guru = User::findOrFail($id);

            // Ubah array mata pelajaran menjadi string dipisahkan koma
            $mataPelajaranString = $request->mata_pelajaran ? implode(', ', $request->mata_pelajaran) : null;

            // Update data
            $guru->update([
                'name' => $request->name,
                'kelas' => $request->kelas,
                'mata_pelajaran' => $mataPelajaranString,
                'address' => $request->address,
                'phone' => $request->phone,
            ]);

            return redirect()->route('guru.kelola')->with('success', 'Data guru berhasil diperbarui');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Gagal memperbarui guru: ' . $e->getMessage());
        }
    }

    // Menghapus data guru
    public function destroy($id)
    {
        User::findOrFail($id)->delete();
        return redirect()->route('guru.kelola')->with('success', 'Guru berhasil dihapus');
    }
}
