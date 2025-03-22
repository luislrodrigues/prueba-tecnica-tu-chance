<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use App\Http\Requests\AlumnoRequest;
use App\Http\Resources\AlumnoResource;
use App\Models\Alumno;
use Exception;
use Illuminate\Http\Request;

class AlumnoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        {
            try {
                $query = Alumno::query();
                
                    if ($request->filled('grado')) {
                        $query->where('grado_id', $request->grado);
                    }
                    
                    if ($request->filled('nombre')) {
                        $query->where('nombre', 'like', '%' . $request->nombre . '%');
                    }
                    
                    $alumnos = $query->with('grado')->paginate(10);
                    
                    return response()->json($alumnos);
                
                } catch (Exception $e) {
                    return ApiResponse::error('Error al obtener la lista de alumnos', 500, ['exception' => $e->getMessage()]);
                }
        }
    }
    

    /**
     * Store a newly created resource in storage.
     */
    public function store(AlumnoRequest $request)
    {
        try {
            $alumno = Alumno::create($request->validated());
    
            return ApiResponse::success($alumno,'Alumno creado exitosamente', 201);
        } catch (\Exception $e) {
            return ApiResponse::error('Error al registrar el alumno', 500, $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try {
            if (!is_numeric($id) || $id <= 0) {
                return ApiResponse::error('El ID del alumno debe ser un número válido.', 400);
            }
    
            $alumno = Alumno::find($id);
    
            if (!$alumno) {
                return ApiResponse::error('Alumno no encontrado.', 404);
            }
    
            return ApiResponse::success(new AlumnoResource($alumno), 'Alumno encontrado correctamente');
        
        } catch (Exception $e) {
            return ApiResponse::error('Error al obtener el alumno', 500, ['exception' => $e->getMessage()]);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AlumnoRequest $request, Alumno $alumno)
    {
        try {
            $alumno->update($request->validated());
    
            return ApiResponse::success('Alumno actualizado exitosamente', $alumno);
        } catch (\Exception $e) {
            return ApiResponse::error('Error al actualizar el alumno', 500, $e->getMessage());
        }
    }
    

    /**
     * Remove the specified resource from storage.
     */
 
     public function destroy($id)
     {
         try {
             $alumno = Alumno::findOrFail($id);
             $alumno->delete();
     
             return ApiResponse::success('Alumno eliminado correctamente');
         } catch (\Exception $e) {
             return ApiResponse::error('Error al eliminar el alumno', 500, $e->getMessage());
         }
     }
}
