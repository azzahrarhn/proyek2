<?php

namespace App\Http\Controllers;

use App\Models\Grade;
use Illuminate\Http\Request;

class GradeController extends Controller
{
    public function storeTpValue(Request $request)
    {
        $request->validate([
            'studentId' => 'required|integer',
            'tpIndex' => 'required|integer|min:1|max:30',
            'tpValue' => 'required|integer|min:0|max:100',
        ]);

        Grade::updateOrCreate(
            [
                'student_id' => $request->studentId,
                'tp_index' => $request->tpIndex,
            ],
            ['value' => $request->tpValue]
        );

        return response()->json(['success' => true]);
    }

    public function index()
    {
        $grades = Grade::all();
        return response()->json($grades);
    }
}