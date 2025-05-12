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
            'id_atendente' => Usuario::factory(),
            'id_paciente' => Paciente::factory(),
            'id_medico' => Medico::factory(),
            'id_medico_substituto' => Medico::factory(),
            'id_convenio' => Convenio::factory(),
            'data_agendada' => $this->faker->dateTimeBetween('now', '+1 month'),
            'status' => $this->faker->randomElement([0, 1]),
        ];
    }
}
