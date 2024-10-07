<?php

namespace Database\Seeders;

use App\Models\Endereco;
use App\Models\Usuario;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EnderecosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $usuario = Usuario::factory()->create(); // ou User::find(1); para encontrar um específico

        // Cria um endereço associado ao usuário
        Endereco::create([
            'cep' => '12345678',
            'logradouro' => 'Rua Exemplo',
            'complemento' => 'Apto 101',
            'bairro' => 'Centro',
            'uf' => 'SP',
            'id_usuario' => $usuario->id, // Associação ao usuário
        ]);
    }
}
