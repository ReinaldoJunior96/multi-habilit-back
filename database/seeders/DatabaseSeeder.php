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
            //HorarioSeeder::class,
            PacientesTableSeeder::class,         // Pacientes antes dos convênios
            //EnderecosTableSeeder::class,
            ConveniosTableSeeder::class,
            ProcedimentoSeeder::class,
            //ConvenioProcedimentoSeeder::class,         // Convênios antes dos agendamentos
            //AgendamentosTableSeeder::class,      // Agendamentos dependem de convênios
            //AtendimentoSeeder::class,
        ]);
    }
}
