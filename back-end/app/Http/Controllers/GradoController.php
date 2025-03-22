<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use App\Models\Grado;
use Exception;

class GradoController extends Controller
{
    public function index()
    {
        try {
                $grados = Grado::where('estado','activo')->get();
                return response()->json($grados);
            
            } catch (Exception $e) {
                return ApiResponse::error('Error al obtener la lista de grados', 500, ['exception' => $e->getMessage()]);
            }
    }
}
