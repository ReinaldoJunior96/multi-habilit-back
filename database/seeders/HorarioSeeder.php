<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class HorarioSeeder extends Seeder
{
    public function run(): void
    {
        $diasSemana = [
            'segunda-feira',
            'terca-feira',
            'quarta-feira',
            'quinta-feira',
            'sexta-feira',
            'sabado',
            'domingo'
        ];
        $horariosBase = [];
        $horaInicial = 8;
        for ($i = 0; $i < 5; $i++) {
            $inicio = sprintf('%02d:00:00', $horaInicial + $i * 2);
            $fim = date('H:i:s', strtotime($inicio . ' +50 minutes'));
            $horariosBase[] = [
                'horario' => $inicio,
                'horario_final' => $fim
            ];
        }
        $medicos = \App\Models\Medico::all();
        foreach ($medicos as $medico) {
            foreach (array_slice($diasSemana, 0, 5) as $dia) { // só dias úteis
                foreach ($horariosBase as $h) {
                    \App\Models\Horario::create([
                        'id_medico' => $medico->id,
                        'horario' => $h['horario'],
                        'dia_semana' => $dia,
                        'disponivel' => true,
                        'data_hora_inicial' => null,
                        'data_hora_final' => null,
                        'observacao' => null,
                    ]);
                }
            }
        }
    }
}
