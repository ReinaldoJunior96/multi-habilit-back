<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Agendamento;
use App\Models\Atendente;
use App\Models\Usuario;
use App\Models\Medico;

class AgendamentosTableSeeder extends Seeder
{
    public function run()
    {
        // Cria múltiplos usuários, médicos e atendentes
        $usuarios = Usuario::factory()->count(10)->create(); // Cria 10 pacientes (usuários)
        $medicos = Medico::factory()->count(5)->create(); // Cria 5 médicos
        $atendentes = Atendente::factory()->count(3)->create(); // Cria 3 atendentes

        // Gera múltiplos agendamentos com combinações variadas
        foreach (range(1, 20) as $index) { // Cria 20 agendamentos
            $paciente = $usuarios->random(); // Seleciona um paciente aleatório
            $medico = $medicos->random(); // Seleciona um médico aleatório
            $atendente = $atendentes->random(); // Seleciona um atendente aleatório

            Agendamento::create([
                'atendente' => $atendente->id,
                'paciente' => $paciente->id,
                'medico' => $medico->id,
                'data_agendada' => now()->addDays(rand(1, 30))->setTime(rand(8, 17), rand(0, 59)), // Gera uma data e hora entre 8h e 17h nos próximos 30 dias
                'status' => rand(0, 1), // Status aleatório (0 ou 1)
            ]);
        }
    }
}
