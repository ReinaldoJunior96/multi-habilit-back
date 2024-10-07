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
            AgendamentosTableSeeder::class,
        ]);
    }
}
