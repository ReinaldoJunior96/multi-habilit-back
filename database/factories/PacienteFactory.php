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
            'estado_civil' => $this->faker->randomElement(['solteiro', 'casado', 'viúvo', 'divorciado']),
            'nome_mae' => $this->faker->name('female'),
            'nome_pai' => $this->faker->name('male'),
            'preferencial' => $this->faker->boolean,
            'cns' => $this->faker->numerify('###############'), // CNS com 15 números
            'nome_conjuge' => $this->faker->name,
            'cor_raca' => $this->faker->randomElement(['branca', 'parda', 'negra', 'amarela', 'indígena']),
            'profissao' => $this->faker->jobTitle,
            'instrucao' => $this->faker->text,
            'nacionalidade' => $this->faker->country,
            'tipo_sanguineo' => $this->faker->randomElement(['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-']),
            'id_usuario' => Usuario::factory(), // Cria e associa ao usuário
        ];
    }
}
