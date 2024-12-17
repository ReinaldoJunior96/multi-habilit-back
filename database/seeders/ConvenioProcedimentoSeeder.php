<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Convenio;
use App\Models\Procedimento;

class ConvenioProcedimentoSeeder extends Seeder
{
    public function run(): void
    {
        // Cria 5 convênios
        $convenios = Convenio::factory(5)->create();

        // Para cada convênio, cria Procedimentos associados
        $convenios->each(function ($convenio) {
            Procedimento::factory(10)->create([
                'convenio_id' => $convenio->id, // Associa o procedimento ao convênio
            ]);
        });
    }
}
