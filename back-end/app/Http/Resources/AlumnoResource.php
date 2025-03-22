<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AlumnoResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'                => $this->id,
            'nombre'            => $this->nombre,
            'fecha_nacimiento'  => $this->fecha_nacimiento,
            'nombre_padre'      => $this->nombre_padre,
            'nombre_madre'      => $this->nombre_madre,
            'grado'             => $this->grado,
            'seccion'           => $this->seccion,
            'fecha_ingreso'     => $this->fecha_ingreso,
            'creado_en'         => $this->created_at->format('Y-m-d H:i:s'),
            'actualizado_en'    => $this->updated_at->format('Y-m-d H:i:s'),
        ];
    }
}
