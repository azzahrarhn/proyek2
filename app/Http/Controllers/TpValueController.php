<?php  
  
namespace App\Http\Controllers;  
  
use Illuminate\Http\Request;  
  
class TpValueController extends Controller  
{  
    public function store(Request $request)  
    {  
        // Validate the incoming request data  
        $validatedData = $request->validate([  
            'studentId' => 'required|integer',  
            'tpIndex' => 'required|integer',  
            'tpValue' => 'required|numeric',  
        ]);  
  
        // Here you would typically save the data to a database  
        // For demonstration purposes, we'll just return a success response  
        return response()->json(['success' => true, 'data' => $validatedData]);  
    }  
}  
