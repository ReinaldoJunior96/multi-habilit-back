<?php

namespace Database\Seeders;

use App\Models\Procedimento;
use App\Models\Convenio;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProcedimentoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Cria 5 convênios
        $convenios = Convenio::factory(50)->create();

        // Para cada convênio, cria Procedimentos associados
        foreach ($convenios as $convenio) {
            Procedimento::factory(10)->create([
                'id_convenio' => $convenio->id, // Relaciona com o convênio criado
            ]);
        }
    }
}
