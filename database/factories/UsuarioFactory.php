<?php

namespace Database\Factories;

use App\Models\Usuario;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

class UsuarioFactory extends Factory
{
    protected $model = Usuario::class;

    /**
     * Define o estado padrão para o modelo.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'nome_completo' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'password' => Hash::make('password123'), // Senha criptografada
            'data_nascimento' => $this->faker->date('Y-m-d'),
            'sexo' => $this->faker->randomElement(['Masculino', 'Feminino']),
            'rg' => $this->faker->regexify('[0-9]{9}'),
            'cpf' => $this->faker->regexify('[0-9]{11}'),
            'nome_social' => $this->faker->optional()->name,
            'telefone' => $this->faker->phoneNumber,
            'celular' => $this->faker->phoneNumber,
        ];
    }
}
