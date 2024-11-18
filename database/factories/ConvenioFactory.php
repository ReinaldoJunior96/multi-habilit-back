<?php

namespace Database\Factories;

use App\Models\Convenio;
use App\Models\Paciente;
use Illuminate\Database\Eloquent\Factories\Factory;

class ConvenioFactory extends Factory
{
    protected $model = Convenio::class;

    public function definition(): array
    {
        return [
            'empresa' => $this->faker->company,
            'cnpj' => $this->faker->numerify('##############'), // 14 números
            'valor_convenio' => $this->faker->randomFloat(2, 100, 10000), // Valor entre 100 e 10.000
        ];
    }
}
