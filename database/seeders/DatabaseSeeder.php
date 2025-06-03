<?php

namespace Database\Seeders;

use App\Models\Especialidade;
use Illuminate\Database\Seeder;
use Database\Seeders\FichaMedicaSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UsuariosTableSeeder::class,          // Cria os usuários
            MedicoSeeder::class,                 // Médicos independentes
            //HorarioSeeder::class,
            PacientesTableSeeder::class,         // Pacientes antes dos convênios
            //EnderecosTableSeeder::class,
            ConveniosTableSeeder::class,
            ProcedimentoSeeder::class,
            //ConvenioProcedimentoSeeder::class,         // Convênios antes dos agendamentos
            //AgendamentosTableSeeder::class,      // Agendamentos dependem de convênios
            //AtendimentoSeeder::class,
            EspecialidadeTableSeeder::class,
            OrcamentoTableSeeder::class,
            UnidadeSeeder::class,
            FichaMedicaSeeder::class,            // Cria as fichas médicas
            //LoteSeeder::class
            ContaAPagarSeeder::class,
        ]);
    }
}
