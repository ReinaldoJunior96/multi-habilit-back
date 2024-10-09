<?php

namespace Database\Factories;

use App\Models\Paciente;
use App\Models\Usuario;
use Illuminate\Database\Eloquent\Factories\Factory;

class PacienteFactory extends Factory
{
    protected $model = Paciente::class;

    public function definition()
    {
        return [
            'estado_civil' => $this->faker->randomElement(['Solteiro', 'Casado', 'Divorciado']),
            'nome_mae' => $this->faker->name('female'),
            'nome_pai' => $this->faker->optional()->name('male'),
            'prefrencial' => $this->faker->boolean(),
            'cns' => $this->faker->optional()->numerify('###########'),
            'nome_conjuge' => $this->faker->optional()->name(),
            'cor_raca' => $this->faker->randomElement(['Branco', 'Negro', 'Pardo', 'Amarelo', 'Indígena']),
            'profissao' => $this->faker->jobTitle(),
            'instrucao' => $this->faker->randomElement(['Fundamental', 'Médio', 'Superior']),
            'nacionalidade' => $this->faker->country(),
            'tipo_sanguineo' => $this->faker->randomElement(['O+', 'O-', 'A+', 'A-', 'B+', 'B-', 'AB+', 'AB-']),
            'id_usuario' => Usuario::factory(),
        ];
    }
}
