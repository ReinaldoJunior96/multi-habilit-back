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

        // Cria 10 convênios
        Convenio::factory()->count(10)->create();
    }
}
