<?php

namespace Database\Factories;

use App\Models\Agendamento;
use App\Models\Atendente;
use App\Models\Usuario;
use App\Models\Medico;
use App\Models\Paciente;
use Illuminate\Database\Eloquent\Factories\Factory;

class AgendamentoFactory extends Factory
{
    protected $model = Agendamento::class;

    /**
     * Define o estado padrão do modelo.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'atendente' => Usuario::factory()->create()->id,
            'paciente' => Paciente::factory()->create()->id,
            'medico' => Medico::factory()->create()->id,
            'data_agendada' => $this->faker->dateTimeBetween('now', '+1 month'),
            'status' => $this->faker->randomElement([0, 1]),
            'convenio' => \App\Models\Convenio::factory()->create()->id,
            'numero_guia' => 'GUID-' . strtoupper(bin2hex(random_bytes(3))),
        ];
    }
}
