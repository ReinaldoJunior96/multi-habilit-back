<?php

namespace Database\Factories;

use App\Models\Agendamento;
use App\Models\Usuario;
use App\Models\Paciente;
use App\Models\Medico;
use App\Models\Convenio;
use Illuminate\Database\Eloquent\Factories\Factory;

class AgendamentoFactory extends Factory
{
    protected $model = Agendamento::class;

    public function definition(): array
    {
        return [
            'atendente' => Usuario::factory(),
            'paciente' => Paciente::factory(),
            'medico_id' => Medico::factory(),
            'medico_substituto' => Medico::factory(),
            'convenio' => Convenio::factory(),
            'procedimento' => null,
            'data_agendada' => $this->faker->dateTimeBetween('now', '+1 month'),
            'unidade' => $this->faker->randomElement(['Unidade 1', 'Unidade 2']),
            'status' => $this->faker->randomElement([0, 1]),
        ];
    }
}
