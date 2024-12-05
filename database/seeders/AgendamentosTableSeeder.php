<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Agendamento;
use App\Models\Paciente;
use App\Models\Usuario;
use App\Models\Medico;
use App\Models\Convenio;
use Carbon\Carbon;

class AgendamentosTableSeeder extends Seeder
{
    public function run()
    {
        $pacientes = Paciente::all(); // Obtém todos os pacientes
        $medicos = Medico::factory()->count(10)->create(); // Cria 10 médicos
        $atendentes = Usuario::factory()->count(5)->create(); // Cria 5 atendentes
        $convenios = Convenio::factory()->count(5)->create(); // Cria 5 convênios

        $mesAtual = Carbon::now()->month;
        $anoAtual = Carbon::now()->year;

        foreach (range(1, Carbon::now()->daysInMonth) as $dia) {
            $numeroAgendamentos = rand(2, 5); // Entre 2 e 5 agendamentos por dia

            for ($i = 0; $i < $numeroAgendamentos; $i++) {
                $paciente = $pacientes->random(); // Seleciona um paciente existente
                $medico = $medicos->random(); // Seleciona um médico existente
                $atendente = $atendentes->random(); // Seleciona um atendente existente
                $convenio = $convenios->random(); // Seleciona um convênio existente

                $hora = rand(8, 17); // Horário de 08:00 a 17:00
                $minuto = [0, 30][rand(0, 1)]; // Minutos 00 ou 30
                $dataAgendada = Carbon::create($anoAtual, $mesAtual, $dia, $hora, $minuto);

                Agendamento::create([
                    'atendente' => $atendente->id,
                    'paciente' => $paciente->id,
                    'medico' => $medico->id,
                    'data_agendada' => $dataAgendada,
                    'status' => rand(0, 1), // Status aleatório
                    'convenio' => $convenio->id,
                    'numero_guia' => 'GUID-' . strtoupper(bin2hex(random_bytes(3))), // Número de guia aleatório
                ]);
            }
        }
    }
}
