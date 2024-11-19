<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Agendamento;
use App\Models\Atendente;
use App\Models\Usuario;
use App\Models\Medico;
use App\Models\Convenio;
use Carbon\Carbon;

class AgendamentosTableSeeder extends Seeder
{
    public function run()
    {
        // Cria múltiplos usuários, médicos e atendentes
        $usuarios = Usuario::factory()->count(10)->create(); // Cria 10 pacientes (usuários)
        $medicos = Medico::factory()->count(5)->create(); // Cria 5 médicos
        $atendentes = Atendente::factory()->count(3)->create(); // Cria 3 atendentes
        $convenios = Convenio::all(); // Obtém todos os convênios disponíveis

        // Define os horários permitidos entre 08:00 e 18:00
        $horariosPermitidos = [];
        for ($hora = 8; $hora <= 17; $hora++) {
            $horariosPermitidos[] = sprintf('%02d:00', $hora); // Hora cheia (ex: 08:00)
            $horariosPermitidos[] = sprintf('%02d:30', $hora); // Meia hora (ex: 08:30)
        }

        // Itera por cada mês de 2024
        foreach (range(1, 12) as $mes) {
            // Define o primeiro dia do mês atual
            $dataInicioMes = Carbon::create(2024, $mes, 1);

            // Gera uma quantidade aleatória de agendamentos para o mês (entre 30 e 70)
            $quantidadeAgendamentos = rand(30, 70);

            foreach (range(1, $quantidadeAgendamentos) as $index) {
                $paciente = $usuarios->random(); // Seleciona um paciente aleatório
                $medico = $medicos->random(); // Seleciona um médico aleatório
                $atendente = $atendentes->random(); // Seleciona um atendente aleatório
                $convenio = $convenios->random(); // Seleciona um convênio aleatório

                // Define uma data aleatória dentro do mês
                $diaAgendado = $dataInicioMes->copy()->addDays(rand(0, $dataInicioMes->daysInMonth - 1));
                $horarioAleatorio = $horariosPermitidos[array_rand($horariosPermitidos)]; // Seleciona um horário aleatório

                // Combina a data e o horário
                $dataAgendada = Carbon::parse($diaAgendado->format('Y-m-d') . ' ' . $horarioAleatorio);

                // Cria o agendamento com o convênio associado
                Agendamento::create([
                    'atendente' => $atendente->id,
                    'paciente' => $paciente->id,
                    'medico' => $medico->id,
                    'data_agendada' => $dataAgendada,
                    'status' => rand(0, 1), // Status aleatório (0 ou 1)
                    'convenio' => $convenio->id, // Associa o convênio ao agendamento
                ]);
            }
        }
    }
}
