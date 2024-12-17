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
            Horario::create([
                'medico_id' => $medico->id,
                'data_hora' => Carbon::now()->addDays(1)->setTime(8, 0), // Exemplo: Amanhã às 08:00
            ]);

            Horario::create([
                'medico_id' => $medico->id,
                'data_hora' => Carbon::now()->addDays(3)->setTime(14, 0), // Exemplo: Daqui 3 dias às 14:00
            ]);
        }
    }
}
