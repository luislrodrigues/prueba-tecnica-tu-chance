<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Alumno>
 */
class AlumnoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nombre' => $this->faker->name(),
            'fecha_nacimiento' => $this->faker->date('Y-m-d', '2015-01-01'),
            'nombre_padre' => $this->faker->name('male'),
            'nombre_madre' => $this->faker->name('female'),
            'grado' => $this->faker->numberBetween(1, 12),
            'seccion' => $this->faker->randomElement(['A', 'B', 'C']),
            'fecha_ingreso' => $this->faker->date('Y-m-d', '2023-01-01'),
        ];
    }
}
