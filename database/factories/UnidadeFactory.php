<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Unidade>
 */
class UnidadeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Garante que existe pelo menos um endereço
        $enderecoId = \App\Models\Endereco::inRandomOrder()->first()?->id ?? \App\Models\Endereco::factory()->create()->id;
        return [
            'nome' => $this->faker->company,
            'id_endereco' => $enderecoId,
            'telefone' => $this->faker->phoneNumber,
            'email' => $this->faker->unique()->safeEmail,
            'cnpj' => $this->faker->numerify('##############'),
            'responsavel' => $this->faker->name,
            'horario_funcionamento' => '08:00-18:00',
            'status' => $this->faker->randomElement(['ativo', 'inativo']),
            'tipo' => $this->faker->randomElement(['matriz', 'filial']),
        ];
    }
}
