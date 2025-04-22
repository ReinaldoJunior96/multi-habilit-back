<?php

use Illuminate\Database\Seeder;
use App\Models\FichaMedica;

class FichaMedicaSeeder extends Seeder
{
    public function run()
    {
        FichaMedica::factory()->count(10)->create(); // Cria 10 fichas médicas
    }
}
