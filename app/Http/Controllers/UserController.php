<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    /**
     * Menampilkan daftar pengguna.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        // Menambahkan fitur pencarian berdasarkan nama atau email
        $search = $request->get('search');
        
        // Mengambil semua pengguna yang terdaftar dengan pencarian dan pagination
        $users = User::when($search, function ($query, $search) {
                return $query->where('name', 'like', "%$search%")
                             ->orWhere('email', 'like', "%$search%");
            })
            ->paginate(10);  // 10 per halaman, bisa disesuaikan sesuai kebutuhan

        // Mengembalikan view dengan data pengguna
        return view('users.index', compact('users'));
    }
}
