<?php

namespace Database\Factories;

use App\Models\Agendamento;
use App\Models\Atendente;
use App\Models\Usuario;
use App\Models\Medico;
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
            'atendente' => Atendente::factory(),
            'paciente' => Usuario::factory(),
            'medico' => Medico::factory(),
            'data_agendada' => $this->faker->dateTimeBetween('now', '+1 month'), // Gera uma data e hora aleatória nos próximos 30 dias
            'status' => $this->faker->randomElement([0, 1]), // Status aleatório
        ];
    }
}
