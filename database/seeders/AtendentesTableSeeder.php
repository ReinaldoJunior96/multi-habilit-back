<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AtendentesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Busca o ID do usuário Admin
        $adminId = DB::table('usuarios')->where('email', 'admin@admin.com')->value('id');

        // Cria o registro na tabela atendentes
        if ($adminId) {
            DB::table('atendentes')->insert([
                'id_usuario' => $adminId, // Campo correto da chave estrangeira
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
