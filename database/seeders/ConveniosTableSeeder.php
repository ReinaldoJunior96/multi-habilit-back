<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Convenio;
use App\Models\Paciente;

class ConveniosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Cria 20 pacientes
        $pacientes = Paciente::factory()->count(20)->create();

        // Cria 10 convênios e associa pacientes a eles
        Convenio::factory()->count(10)->create()->each(function ($convenio) use ($pacientes) {
            // Associa entre 3 e 7 pacientes ao convênio
            $convenio->pacientes()->attach(
                $pacientes->random(rand(3, 7))->pluck('id')->toArray()
            );
        });
    }
}
