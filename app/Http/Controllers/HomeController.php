<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\BiodataSiswa;
use Illuminate\Support\Facades\Auth;
class HomeController extends Controller
{

    public function index()
    {
        // Ambil user yang sedang login
        $user = Auth::user();

        // Pastikan wali kelas memiliki informasi kelas
        if (!$user->kelas) {
            return view('index')->with('error', 'Kelas tidak ditemukan.');
        }

        // Ambil jumlah siswa hanya dari kelas wali kelas yang login
        $totalSiswa = BiodataSiswa::where('kelas', $user->kelas)->count();
        $totalLaki = BiodataSiswa::where('kelas', $user->kelas)->where('jenis_kelamin', 'Laki-laki')->count();
        $totalPerempuan = BiodataSiswa::where('kelas', $user->kelas)->where('jenis_kelamin', 'Perempuan')->count();

        return view('index', compact('totalSiswa', 'totalLaki', 'totalPerempuan'));
    }
    
    public function register(){

        $data = User::get();

        return view('auth.register',compact('data'));
    }
}