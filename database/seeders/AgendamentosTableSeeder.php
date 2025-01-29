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
        $pacientes = Paciente::all();
        $atendentes = Usuario::factory()->count(5)->create();
        $convenios = Convenio::factory()->count(5)->create();

        // Médico específico
        $usuario = Usuario::where('email', '=', 'medico@medico.com')->first();
        $medicoEspecifico = Medico::where('id_usuario', '=', $usuario->id)->first();
        $mesAtual = Carbon::now()->month;
        $anoAtual = Carbon::now()->year;

        foreach (range(1, 2) as $dia) {
            $numeroAgendamentos = rand(2, 5); // Entre 2 e 5 agendamentos por dia

            for ($i = 0; $i < $numeroAgendamentos; $i++) {
                $paciente = $pacientes->random();
                $atendente = $atendentes->random();
                $convenio = $convenios->random();
                $hora = rand(8, 17);
                $minuto = [0, 30][rand(0, 1)];
                $dataAgendada = Carbon::create($anoAtual, $mesAtual, $dia, $hora, $minuto);

                Agendamento::create([
                    'atendente' => $atendente->id,
                    'paciente' => $paciente->id,
                    // Médico específico
                    'medico_id' => $medicoEspecifico->id,
                    'data_agendada' => $dataAgendada,
                    'status' => rand(0, 1),
                    'convenio' => $convenio->id,
                    'numero_guia' => 'GUID-' . strtoupper(bin2hex(random_bytes(3))),
                ]);
            }
        }
    }
}
