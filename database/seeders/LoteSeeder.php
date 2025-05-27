<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LoteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Cria 10 lotes, cada um com até 100 fichas médicas aleatórias
        \App\Models\Lote::factory()->count(10)->create();
    }
}
