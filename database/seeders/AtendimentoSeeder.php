<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Atendimento;

class AtendimentoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Atendimento::factory()->count(10)->create();
    }
}
