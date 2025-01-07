<?php

namespace Database\Seeders;

use App\Models\Horario;
use App\Models\Medico;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class HorarioSeeder extends Seeder
{
    public function run(): void
    {
        $medicos = Medico::all();

        foreach ($medicos as $medico) {
            // Criação de horários para o médico com base na data atual
            $horarios = [
                [
                    'data_hora_inicial' => Carbon::now()->addDay()->setTime(8, 0),  // Amanhã às 08:00
                    'data_hora_final' => Carbon::now()->addDay()->setTime(8, 50),   // Amanhã às 08:50
                ],
                [
                    'data_hora_inicial' => Carbon::now()->addDay()->setTime(9, 0),  // Amanhã às 09:00
                    'data_hora_final' => Carbon::now()->addDay()->setTime(9, 50),   // Amanhã às 09:50
                ],
                [
                    'data_hora_inicial' => Carbon::now()->addDays(3)->setTime(14, 0), // Daqui 3 dias às 14:00
                    'data_hora_final' => Carbon::now()->addDays(3)->setTime(14, 50),  // Daqui 3 dias às 14:50
                ],
            ];

            foreach ($horarios as $horario) {
                Horario::create([
                    'medico_id' => $medico->id,
                    'data_hora_inicial' => $horario['data_hora_inicial'],
                    'data_hora_final' => $horario['data_hora_final'],
                    'disponivel' => true,
                ]);
            }
        }
    }
}
