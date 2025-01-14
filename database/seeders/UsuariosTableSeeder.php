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



        $usuariosPersonalizados = [
            [
                'nome_completo' => 'Lucas',
                'email' => 'lucas@admin.com',
                'password' => Hash::make('password123'),
                'data_nascimento' => '1985-06-15',
                'sexo' => 'Masculino',
                'rg' => '123456789',
                'cpf' => '11122233344',
                'nome_social' => 'jorge',
                'telefone' => '123456789',
                'celular' => '987654321',
                'unidade' => 'Unidade 1',
                'role' => 'admin',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nome_completo' => 'jorge',
                'email' => 'jorge@admin.com',
                'password' => Hash::make('password123'),
                'data_nascimento' => '1992-03-10',
                'sexo' => 'Feminino',
                'rg' => '987654321',
                'cpf' => '55566677788',
                'nome_social' => 'jorge',
                'telefone' => '123456789',
                'celular' => '987654321',
                'unidade' => 'Unidade 2',
                'role' => 'admin',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nome_completo' => 'erik',
                'email' => 'erik@admin.com',
                'password' => Hash::make('password123'),
                'data_nascimento' => '1978-09-25',
                'sexo' => 'Masculino',
                'rg' => '543216789',
                'cpf' => '99988877766',
                'nome_social' => 'Erike',
                'telefone' => '123456789',
                'celular' => '987654321',
                'unidade' => null,
                'role' => 'admin',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        // Insere os usuários personalizados
        foreach ($usuariosPersonalizados as $usuario) {
            DB::table('usuarios')->insert($usuario);
        }
    }
}
