<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsuariosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Lista de roles, nomes e emails personalizados
        $roles = [
            'admin-master' => [
                'name' => 'Admin Master',
                'email' => 'admin-master@admin.com',
            ],
            'admin' => [
                'name' => 'Administrador',
                'email' => 'admin@admin.com',
            ],
            'atendente' => [
                'name' => 'Atendente',
                'email' => 'atendente@atendente.com',
            ],
            'medico' => [
                'name' => 'Médico',
                'email' => 'medico@medico.com',
            ],
            'paciente' => [
                'name' => 'Paciente',
                'email' => 'paciente@paciente.com',
            ],
        ];

        foreach ($roles as $role => $details) {
            DB::table('usuarios')->insert([
                'nome_completo' => $details['name'],
                'email' => $details['email'], // Email personalizado
                'password' => Hash::make('password123'), // Senha padrão
                'data_nascimento' => '1990-01-01',
                'sexo' => 'Masculino',
                'rg' => fake()->numerify('#########'),
                'cpf' => fake()->numerify('###########'),
                'nome_social' => $details['name'],
                'telefone' => fake()->phoneNumber(),
                'celular' => fake()->phoneNumber(),
                'unidade' => null,
                'role' => $role,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
