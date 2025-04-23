<?php

use Illuminate\Database\Seeder;
use App\Models\FiliacaoPaciente;

class FiliacaoPacienteSeeder extends Seeder
{
    public function run(): void
    {
        FiliacaoPaciente::factory()->count(10)->create();
    }
}
