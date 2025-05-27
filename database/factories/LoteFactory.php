<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Lote>
 */
class LoteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Busca até 100 fichas médicas aleatórias para compor o lote
        $idsFichas = \App\Models\FichaMedica::inRandomOrder()->limit(100)->pluck('id')->toArray();

        return [
            'lote' => $this->faker->unique()->bothify('LOTE-####-??'),
            'ids_fichas' => $idsFichas,
        ];
    }
}
