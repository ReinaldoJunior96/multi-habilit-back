<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UsuariosTableSeeder::class,          // Cria os usuários
            //MedicoSeeder::class,                 // Médicos independentes
            //EnderecosTableSeeder::class,         // Endereços para usuários/médicos
            //PacientesTableSeeder::class,         // Pacientes antes dos convênios
            //ConveniosTableSeeder::class,
            //ConvenioProcedimentoSeeder::class,         // Convênios antes dos agendamentos
            //AgendamentosTableSeeder::class,      // Agendamentos dependem de convênios
        ]);
    }
}
