<?php

namespace Database\Factories;

use App\Models\Endereco;
use App\Models\Usuario;
use Illuminate\Database\Eloquent\Factories\Factory;

class EnderecoFactory extends Factory
{
    protected $model = Endereco::class;

    public function definition()
    {
        return [
            'cep' => $this->faker->postcode(),
            'logradouro' => $this->faker->streetAddress(),
            'complemento' => $this->faker->optional()->secondaryAddress(),
            'bairro' => $this->faker->citySuffix(),
            'uf' => $this->faker->stateAbbr(),
            'id_usuario' => Usuario::factory(), // Cria ou associa um usuário automaticamente
        ];
    }
}
