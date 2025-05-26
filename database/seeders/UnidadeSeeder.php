<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UnidadeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Cria 10 endereços e associa cada um a uma unidade
        \App\Models\Endereco::factory()->count(10)->create()->each(function ($endereco) {
            \App\Models\Unidade::factory()->create([
                'id_endereco' => $endereco->id
            ]);
        });
    }
}
