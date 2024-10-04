<?php

namespace Database\Factories;

use App\Models\Medico;
use App\Models\Usuario;
use Illuminate\Database\Eloquent\Factories\Factory;

class MedicoFactory extends Factory
{
    protected $model = Medico::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'regime_trabalhista' => $this->faker->randomElement([0, 1]), // CLT ou PJ
            'carga_horaria' => $this->faker->numberBetween(20, 40),
            'cnpj' => $this->faker->numerify('########0000##'), // CNPJ fictício
            'id_usuario' => Usuario::factory(), // Cria um usuário automaticamente
        ];
    }
}
