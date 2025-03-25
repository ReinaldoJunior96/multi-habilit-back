<?php

namespace Database\Factories;

use App\Models\Endereco;
use App\Models\Paciente;
use Illuminate\Database\Eloquent\Factories\Factory;

class EnderecoFactory extends Factory
{
    protected $model = Endereco::class;

    public function definition(): array
    {
        return [
            'cep' => $this->faker->postcode(),
            'logradouro' => $this->faker->streetAddress(),
            'complemento' => $this->faker->optional()->secondaryAddress(),
            'bairro' => $this->faker->citySuffix(),
            'municipio' => $this->faker->city(),
            'numero' => $this->faker->buildingNumber(),
            'estado' => $this->faker->state(),
            'uf' => $this->faker->stateAbbr(),
            'id_paciente' => Paciente::factory(), // Vincula corretamente ao paciente
        ];
    }
}
