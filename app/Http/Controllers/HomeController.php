<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\BiodataSiswa;

class HomeController extends Controller
{

    public function index(){

    $totalSiswa = BiodataSiswa::count(); // Total semua siswa
    $totalLaki = BiodataSiswa::where('jenis_kelamin', 'Laki-laki')->count(); // Total siswa laki-laki
    $totalPerempuan = BiodataSiswa::where('jenis_kelamin', 'Perempuan')->count(); // Total siswa perempuan

        return view('index', compact('totalSiswa', 'totalLaki', 'totalPerempuan'));
    }
    
    public function register(){

        $data = User::get();

        return view('auth.register',compact('data'));
    }
}