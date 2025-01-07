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
        // Busca o usuário com o e-mail medico@medico.com criado na UsuariosTableSeeder
        $usuarioMedico = Usuario::where('email', 'medico@medico.com')->first();

        // Verifica se o usuário existe
        if ($usuarioMedico) {
            // Cria o médico associado ao usuário encontrado
            Medico::create([
                'regime_trabalhista' => 1,
                'carga_horaria' => 40,
                'cnpj' => '12345678000123',
                'id_usuario' => $usuarioMedico->id, // Associa ao usuário existente
            ]);
        } else {
            // Caso o usuário não exista, lança uma mensagem de erro
            throw new \Exception("Usuário com o e-mail 'medico@medico.com' não encontrado.");
        }

        Medico::factory(10)->create();
    }
}
