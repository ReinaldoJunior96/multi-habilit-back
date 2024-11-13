<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Agendamento;
use App\Models\Atendente;
use App\Models\Usuario;
use App\Models\Medico;
use Carbon\Carbon;

class AgendamentosTableSeeder extends Seeder
{
    public function run()
    {
        // Cria múltiplos usuários, médicos e atendentes
        $usuarios = Usuario::factory()->count(10)->create(); // Cria 10 pacientes (usuários)
        $medicos = Medico::factory()->count(5)->create(); // Cria 5 médicos
        $atendentes = Atendente::factory()->count(3)->create(); // Cria 3 atendentes

        // Itera por cada mês de 2024
        foreach (range(1, 12) as $mes) {
            // Define o primeiro dia do mês atual
            $dataInicioMes = Carbon::create(2024, $mes, 1);

            // Gera uma quantidade aleatória de agendamentos para o mês (entre 30 e 50)
            $quantidadeAgendamentos = rand(30, 70);

            foreach (range(1, $quantidadeAgendamentos) as $index) {
                $paciente = $usuarios->random(); // Seleciona um paciente aleatório
                $medico = $medicos->random(); // Seleciona um médico aleatório
                $atendente = $atendentes->random(); // Seleciona um atendente aleatório

                // Define uma data aleatória dentro do mês
                $dataAgendada = $dataInicioMes->copy()->addDays(rand(0, $dataInicioMes->daysInMonth - 1))->setTime(rand(8, 17), rand(0, 59));

                Agendamento::create([
                    'atendente' => $atendente->id,
                    'paciente' => $paciente->id,
                    'medico' => $medico->id,
                    'data_agendada' => $dataAgendada,
                    'status' => rand(0, 1), // Status aleatório (0 ou 1)
                ]);
            }
        }
    }
}
