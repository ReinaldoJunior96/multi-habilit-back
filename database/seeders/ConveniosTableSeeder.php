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
        // Cria alguns pacientes para associar aos convênios
        $pacientes = Paciente::factory()->count(5)->create();

        foreach ($pacientes as $paciente) {
            Convenio::create([
                'empresa' => 'Convenio ' . $paciente->id,
                'tipo' => 'Plano Completo',
                'vencimento' => now()->addYear(),
                'percentual_coparticipacao' => 20,
                'particular' => false,
                'id_paciente' => $paciente->id,
            ]);
        }
    }
}
