<?php

namespace Database\Seeders;

use App\Models\Grado;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GradoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $grados = [
            ['nombre' => 'Primero'],
            ['nombre' => 'Segundo'],
            ['nombre' => 'Tercero'],
            ['nombre' => 'Cuarto'],
            ['nombre' => 'Quinto'],
            ['nombre' => 'Sexto'],
            ['nombre' => 'Septimo'],
            ['nombre' => 'Octavo'],
            ['nombre' => 'Noveno'],
            ['nombre' => 'Decimo'],
        ];

        Grado::insert($grados);
    }
}
