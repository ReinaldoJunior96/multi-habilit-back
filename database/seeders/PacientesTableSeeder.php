<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Paciente;
use App\Models\Usuario;

class PacientesTableSeeder extends Seeder
{
    public function run()
    {
        $usuarios = Usuario::factory()->count(50)->create(); // Cria 50 usuários

        // Cria pacientes associados aos usuários
        foreach ($usuarios as $usuario) {
            Paciente::create([
                'estado_civil' => fake()->randomElement(['solteiro', 'casado', 'viúvo', 'divorciado']),
                'nome_mae' => fake()->name('female'),
                'nome_pai' => fake()->name('male'),
                'preferencial' => fake()->boolean,
                'cns' => fake()->numerify('###############'), // CNS com 15 números
                'nome_conjuge' => fake()->name,
                'cor_raca' => fake()->randomElement(['branca', 'parda', 'negra', 'amarela', 'indígena']),
                'profissao' => fake()->jobTitle,
                'instrucao' => fake()->text,
                'nacionalidade' => fake()->country,
                'tipo_sanguineo' => fake()->randomElement(['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-']),
                'id_usuario' => $usuario->id, // Relaciona o paciente ao usuário
            ]);
        }
    }
}
