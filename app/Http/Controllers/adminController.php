<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\BiodataSiswa;
use App\Models\MataPelajaran;
use App\Models\Nilai;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class adminController extends Controller
{

    public function adminDashboard()
    {
        $totalSiswa = BiodataSiswa::count(); // Total semua siswa
        $totalLaki = BiodataSiswa::where('jenis_kelamin', 'Laki-laki')->count(); // Total siswa laki-laki
        $totalPerempuan = BiodataSiswa::where('jenis_kelamin', 'Perempuan')->count(); // Total siswa perempuan
        $totalGuru = User::where('role', '!=', 'Admin')->count();

        return view('admin.dashboard', compact('totalSiswa', 'totalLaki', 'totalPerempuan', 'totalGuru')); // Pastikan view ini tersedia
    }

    public function profile(Request $request)
    {
        $user = $request->user(); // Mengambil data pengguna yang sedang login

        if (!$user) {   
            // Jika pengguna tidak ditemukan, alihkan ke halaman login
            return redirect()->route('login')->with('error', 'Harap login untuk mengakses halaman ini.');
        }

        return view('admin.profile', compact('user'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:15',
            'address' => 'nullable|string|max:255',
            'about' => 'nullable|string|max:1000',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Validasi file gambar
        ]);

        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login')->with('error', 'Please log in to access this page.');
        }

        // Update data profil
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->phone = $request->input('phone');
        $user->address = $request->input('address');
        $user->about = $request->input('about');

        // Cek apakah ada file yang diunggah
        if ($request->hasFile('profile_picture')) {
            // Hapus gambar lama jika ada
            $oldFile = public_path('fotoprofile/' . basename($user->profile_picture));
            if ($user->profile_picture && file_exists($oldFile)) {
                unlink($oldFile);
            }

            // Simpan gambar yang baru ke public/fotoprofile
            $file = $request->file('profile_picture');
            $fileName = time() . '.' . $file->getClientOriginalExtension();
            $destinationPath = public_path('fotoprofile'); // Path ke folder public/fotoprofile
            $file->move($destinationPath, $fileName);

            // Simpan path ke database (tanpa storage)
            $user->profile_picture = 'fotoprofile/' . $fileName;
        }

        if ($user->save()) {
            return redirect()->route('admin.profile')->with('success', 'Profile updated successfully.');
        } else {
            return redirect()->back()->with('error', 'Failed to update profile. Please try again.');
        }
    }

    public function changePassword(Request $request)
    {
        // Validasi input
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:8|confirmed', // Pastikan konfirmasi password cocok
        ]);

        $user = Auth::user(); // Ambil pengguna yang sedang login

        // Periksa apakah password lama cocok
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Password lama tidak sesuai.']);
        }

        // Update password
        $user->password = Hash::make($request->new_password);
        $user->save();

        return back()->with('success', 'Password berhasil diperbarui.');
    }

    public function datasiswa()
    {
        // Mengambil semua data biodata siswa
        $siswa = BiodataSiswa::all();
        
        // Menampilkan data ke view kelola
        return view('admin.datasiswa', compact('siswa'));
    }

    public function matapelajaran()
    {
        $mata_pelajaran = MataPelajaran::all(); // Mengambil semua data dari database
        return view('admin.matapelajaran', compact('mata_pelajaran'));
    }

    public function nilai(Request $request)
    {
        $id_mapel = $request->query('id_mapel'); // Ambil id_mapel dari URL
        $nilaiList = Nilai::where('id_mapel', $id_mapel)->get();
        $mataPelajaran = MataPelajaran::find($id_mapel);
        return view('admin.nilai', compact('nilaiList', 'id_mapel', 'mataPelajaran'));
    }

    public function chart()
    {
        // Ambil data nilai rapor dan pastikan tidak null
        $nilaiSiswa = Nilai::whereNotNull('nilai_rapor')->get(['nama', 'nilai_rapor']);

        // Pastikan data tidak kosong
        if ($nilaiSiswa->isEmpty()) {
            return view('chart.index', ['labels' => [], 'data' => []]);
        }

        // Kirim data ke tampilan dalam format array
        return view('admin.chart', [
            'labels' => $nilaiSiswa->pluck('nama')->toArray(),
            'data' => $nilaiSiswa->pluck('nilai_rapor')->toArray(),
        ]);
    }

}