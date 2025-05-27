<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\FichaMedica;

class FichaMedicaSeeder extends Seeder
{
    public function run()
    {
        $convenios = \App\Models\Convenio::inRandomOrder()->limit(5)->get();
        $meses = [
            ['mes' => 5, 'ano' => 2025], // Maio
            ['mes' => 6, 'ano' => 2025], // Junho
            ['mes' => 7, 'ano' => 2025], // Julho
        ];

        // Cria 100 fichas para cada mês (total 300)
        foreach ($meses as $mesData) {
            for ($i = 0; $i < 100; $i++) {
                $convenio = $convenios->random();
                $dia = rand(1, 28); // Para evitar problemas com meses menores
                $createdAt = \Carbon\Carbon::create($mesData['ano'], $mesData['mes'], $dia, rand(0, 23), rand(0, 59), rand(0, 59));
                \App\Models\FichaMedica::factory()->create([
                    'ficha' => function () use ($convenio) {
                        $ficha = \App\Models\FichaMedica::factory()->make()->ficha;
                        $ficha['id_convenio'] = $convenio->id;
                        return $ficha;
                    },
                    'created_at' => $createdAt,
                ]);
            }
        }
    }
}
