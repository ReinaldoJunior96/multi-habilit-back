<?php

namespace Database\Seeders;

use App\Models\Paciente;
use App\Models\Endereco;
use Illuminate\Database\Seeder;

class EnderecosTableSeeder extends Seeder
{
    public function run(): void
    {
        Paciente::factory()->count(50)->create()->each(function ($paciente) {
            Endereco::factory()->create([
                'id_paciente' => $paciente->id,
            ]);
        });
    }
}
