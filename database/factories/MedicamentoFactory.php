<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Medicamento>
 */
class MedicamentoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'descripcion' => $this->faker->word(),
            'presentacion' => $this->faker->word(),
            'unidad' => $this->faker->randomElement(['ml', 'mg', 'g', 'cc']),
            'stock_max' => $this->faker->numberBetween(1, 1000),
            'stock_fisico' => $this->faker->numberBetween(1, 100),
            'solicitado' => $this->faker->numberBetween(1, 100),
        ];
    }
}
