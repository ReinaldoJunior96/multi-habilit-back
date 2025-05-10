<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class OrcamentoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nome_paciente' => $this->faker->name,
            'tipo_servico' => $this->faker->word,
            'numero_sessoes' => $this->faker->numberBetween(1, 20),
            'valor_unitario' => $this->faker->randomFloat(2, 50, 500),
            'desconto' => $this->faker->randomFloat(2, 0, 100),
            'observacoes' => $this->faker->sentence,
        ];
    }
}
