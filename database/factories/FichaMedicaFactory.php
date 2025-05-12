<?php

namespace Database\Factories;

use App\Models\FichaMedica;
use App\Models\Paciente;
use Illuminate\Database\Eloquent\Factories\Factory;

class FichaMedicaFactory extends Factory
{
    protected $model = FichaMedica::class;

    public function definition()
    {
        return [
            'id_paciente' => Paciente::factory(), // Cria um paciente se não houver
            'ficha' => [
                'altura' => $this->faker->randomFloat(2, 1.5, 2),
                'peso' => $this->faker->randomFloat(1, 40, 120),
                'historico' => $this->faker->paragraph,
                'alergias' => $this->faker->words(3),
                'medicamentos_uso_continuo' => $this->faker->words(2),
                'pressao_arterial' => $this->faker->randomElement(['120/80', '130/85', '140/90']),
            ],
        ];
    }
}
