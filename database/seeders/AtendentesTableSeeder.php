<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Atendente;
use App\Models\Usuario;

class AtendentesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Encontra ou cria um usuário fixo, ou você pode definir um ID específico
        $usuario = Usuario::factory()->create();// Ou use Usuario::find(1) para um usuário existente

        // Cria um atendente associado ao usuário
        Atendente::create([
            'id_usuario' => $usuario->id, // Associação ao usuário
        ]);
    }
}
