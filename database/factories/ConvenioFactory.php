<?php

namespace Database\Factories;

use App\Models\Convenio;
use App\Models\Paciente;
use Illuminate\Database\Eloquent\Factories\Factory;

class ConvenioFactory extends Factory
{
    protected $model = Convenio::class;

    public function definition()
    {
        return [
            'empresa' => $this->faker->company(),
            'tipo' => $this->faker->randomElement(['Plano Completo', 'Plano Parcial', 'Plano Emergencial']),
            'vencimento' => $this->faker->dateTimeBetween('+1 year', '+2 years'),
            'percentual_coparticipacao' => $this->faker->numberBetween(0, 100),
            'particular' => $this->faker->boolean(),
            'id_paciente' => Paciente::factory(),  // Cria ou associa um paciente automaticamente
        ];
    }
}

