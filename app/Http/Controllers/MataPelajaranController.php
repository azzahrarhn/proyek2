<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MataPelajaran;

class MataPelajaranController extends Controller
{
    /**
     * Menampilkan halaman input mata pelajaran.
     */
    public function create()
    {
        $mata_pelajaran = MataPelajaran::all(); // Mengambil semua data dari database
        return view('mata_pelajaran.create', compact('mata_pelajaran'));
    }

    /**
     * Menyimpan mata pelajaran ke database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|unique:mata_pelajaran,name|max:255'
        ]);

        MataPelajaran::create([
            'name' => $request->name
        ]);

        return response()->json(['success' => true]);
    }

    /**
     * Mengambil daftar mata pelajaran untuk sidebar.
     */

    public function getSubjectsForSidebar()
    {
        $subjects = MataPelajaran::select('id', 'name')->get();
        return response()->json($subjects);
    }     

    public function getSubjectsForTable()
    {
        $subjects = MataPelajaran::all();
        return response()->json($subjects);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|unique:mata_pelajaran,name,' . $id . '|max:255'
        ]);

        $subject = MataPelajaran::findOrFail($id);
        $subject->update([
            'name' => $request->name
        ]);

        return response()->json(['success' => true]);
    }

    public function destroy($id)
    {
        $subject = MataPelajaran::findOrFail($id);
        $subject->delete();

        return response()->json(['success' => true]);
    }
}