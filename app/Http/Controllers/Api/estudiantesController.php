<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Estudiantes;

class estudiantesController extends Controller
{
    public function index()
    {
        $ListaEstudiantes = Estudiantes::all();
        $data = [
            'content' => $ListaEstudiantes,
            'status' => 200
        ];

        return response()->json($data, 200);
         //   return 'obteniendo lista de estudiantes desde el controller' ;
    }
}
