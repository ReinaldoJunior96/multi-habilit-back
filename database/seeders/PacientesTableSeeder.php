<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Paciente;
use App\Models\FichaMedica;

class PacientesTableSeeder extends Seeder
{
    public function run()
    {
        Paciente::factory()
            ->count(10)
            ->create()
            ->each(function ($paciente) {
                FichaMedica::factory()->create([
                    'id_paciente' => $paciente->id
                ]);
            });
    }
}
