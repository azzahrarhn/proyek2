<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileWaliKelasController extends Controller
{
    /**
     * Menampilkan halaman profil wali kelas.
     */
    public function index(Request $request)
    {
        $user = $request->user(); // Mengambil data pengguna yang sedang login

        if (!$user) {
            // Jika pengguna tidak ditemukan, alihkan ke halaman login
            return redirect()->route('login')->with('error', 'Harap login untuk mengakses halaman ini.');
        }

        return view('profile_wali_kelas.index', compact('user'));
    }
    
    public function edit(Request $request)
    {
        $user = $request->user(); // Mendapatkan data pengguna yang sedang login
        return view('profile_wali_kelas.edit', compact('user'));
    }
    /**
     * Memperbarui profil wali kelas.
     */
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
            return redirect()->route('profile_wali_kelas.index')->with('success', 'Profile updated successfully.');
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
}
