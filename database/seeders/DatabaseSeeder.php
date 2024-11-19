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
            UsuariosTableSeeder::class,
            MedicoSeeder::class,
            EnderecosTableSeeder::class,
            AtendentesTableSeeder::class,
            PacientesTableSeeder::class, // Pacientes precisam existir antes dos convênios
            ConveniosTableSeeder::class, // Convenios precisam ser criados antes dos agendamentos
            AgendamentosTableSeeder::class, // Depende de convenios
            EnderecoSeeder::class,
        ]);
    }
}
