<?php

namespace Database\Seeders;

use App\Models\Medico;
use App\Models\Usuario;
use Illuminate\Database\Seeder;

class MedicoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Cria um usuário para associar ao médico
        $medico = Usuario::factory()->create();
        $medicoFixoTest = Usuario::create([
            'nome_completo' => 'Médico Fixo',
            'email' => 'medico@example.com',
            'password' => bcrypt('password123'),  // Define a senha fixa
            'data_nascimento' => '1980-01-01',
            'sexo' => 'Masculino',
            'rg' => '123456789',
            'cpf' => '12345678901',
            'nome_social' => 'Médico Fixo',
            'telefone' => '123456789',
            'celular' => '987654321'
        ]);
        // Cria um médico associado ao usuário
        Medico::create([
            'regime_trabalhista' => 1,
            'carga_horaria' => 40,
            'cnpj' => '12345678000123',
            'id_usuario' => $medicoFixoTest->id,
        ]);
    }
}
