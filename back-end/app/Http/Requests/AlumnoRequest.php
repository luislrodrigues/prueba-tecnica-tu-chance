<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use App\Helpers\ApiResponse;
class AlumnoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        switch ($this->method()) {
            case 'POST': // Crear alumno
                return [
                    'nombre'            => ['bail', 'required', 'string', 'max:255'],
                    'fecha_nacimiento'  => ['bail', 'required', 'date'],
                    'nombre_padre'      => ['bail', 'required', 'string', 'max:255'],
                    'nombre_madre'      => ['bail', 'required', 'string', 'max:255'],
                    'grado_id'          => ['bail', 'required', 'exists:grados,id'],
                    'seccion'           => ['bail', 'required', 'string', 'max:10'],
                    'fecha_ingreso'     => ['bail', 'required', 'date','after:fecha_nacimiento'],
                ];
                
            case 'PUT': // Actualizar alumno
                return [
                    'nombre'            => ['bail', 'required', 'string', 'max:255'],
                    'fecha_nacimiento'  => ['bail', 'required', 'date'],
                    'nombre_padre'      => ['bail', 'required', 'string', 'max:255'],
                    'nombre_madre'      => ['bail', 'required', 'string', 'max:255'],
                    'grado_id'          => ['bail', 'required', 'exists:grados,id'],
                    'seccion'           => ['bail', 'required', 'string', 'max:10'],
                    'fecha_ingreso'     => ['bail', 'required', 'date','after:fecha_nacimiento'],
                ];
                
            default:
                return [];
        }
    }

    protected function failedValidation(Validator $validator)
    {
        // Convertir errores en un array plano
        $errores = collect($validator->errors())->flatten()->all();
    
        throw new HttpResponseException(
            ApiResponse::error('Errores de validación', 422, $errores)
        );
    }

    
}
