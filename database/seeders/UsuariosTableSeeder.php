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
        DB::table('usuarios')->insert([
            [
                'nome_completo' => 'John Doe',
                'email' => 'john@example.com',
                'password' => Hash::make('password123'),
                'data_nascimento' => '1990-01-01',
                'sexo' => 'Masculino',
                'rg' => '123456789',
                'cpf' => '12345678901',
                'nome_social' => 'Johnny',
                'telefone' => '123456789',
                'celular' => '987654321'
            ],
            [
                'nome_completo' => 'Jane Smith',
                'email' => 'jane@example.com',
                'password' => Hash::make('password123'),
                'data_nascimento' => '1992-05-12',
                'sexo' => 'Feminino',
                'rg' => '987654321',
                'cpf' => '10987654321',
                'nome_social' => null,
                'telefone' => '123456780',
                'celular' => '987654320'
            ]
        ]);
    }
}
