<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Convenio;
use App\Models\Procedimento;

class ConvenioProcedimentoSeeder extends Seeder
{
    public function run()
    {
        // Criar 5 convênios
        $convenios = Convenio::factory(5)->create();

        // Criar 10 procedimentos
        $procedimentos = Procedimento::factory(10)->create();

        // Associar procedimentos a convênios
        foreach ($convenios as $convenio) {
            $procedimentosAleatorios = $procedimentos->random(3); // Selecionar 3 procedimentos aleatórios
            foreach ($procedimentosAleatorios as $procedimento) {
                $convenio->procedimentos()->attach($procedimento->id, [
                    'preco' => fake()->randomFloat(2, 100, 1000), // Preço aleatório
                ]);
            }
        }
    }
}
