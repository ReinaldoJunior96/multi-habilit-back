<?php

namespace Database\Factories;

use App\Models\Medico;
use App\Models\Usuario;
use Illuminate\Database\Eloquent\Factories\Factory;

class MedicoFactory extends Factory
{
    protected $model = Medico::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'nome_completo' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'data_nascimento' => $this->faker->date('Y-m-d', '-20 years'),
            'sexo' => $this->faker->randomElement(['Masculino', 'Feminino', 'Outro']),
            'cpf' => $this->faker->unique()->numerify('###########'),
            'telefone' => $this->faker->numerify('###########'),
            'tipo' => 'terapeuta',
            'regime_trabalhista' => $this->faker->randomElement([0, 1]),
            'carga_horaria' => $this->faker->numberBetween(20, 40),
            'cnpj' => $this->faker->numerify('##############'),
        ];
    }
}
