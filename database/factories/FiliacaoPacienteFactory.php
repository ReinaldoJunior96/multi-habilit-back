<?php

namespace Database\Factories;

use App\Models\FiliacaoPaciente;
use App\Models\Paciente;
use Illuminate\Database\Eloquent\Factories\Factory;

class FiliacaoPacienteFactory extends Factory
{
    protected $model = FiliacaoPaciente::class;

    public function definition(): array
    {
        return [
            'paciente_id' => Paciente::factory(),

            // Pai
            'cpf_pai' => $this->faker->numerify('###########'),
            'ocupacao_pai' => $this->faker->jobTitle(),
            'email_pai' => $this->faker->safeEmail(),
            'telefone_pai' => $this->faker->phoneNumber,
            'celular_pai' => $this->faker->phoneNumber,

            // Mãe
            'cpf_mae' => $this->faker->numerify('###########'),
            'ocupacao_mae' => $this->faker->jobTitle(),
            'email_mae' => $this->faker->safeEmail(),
            'telefone_mae' => $this->faker->phoneNumber,
            'celular_mae' => $this->faker->phoneNumber,

            // Nota Fiscal
            'nome_nf' => $this->faker->name(),
            'cpf_nf' => $this->faker->numerify('###########'),
            'ocupacao_nf' => $this->faker->jobTitle(),
            'email_nf' => $this->faker->safeEmail(),
            'telefone_nf' => $this->faker->phoneNumber,
            'celular_nf' => $this->faker->phoneNumber,
        ];
    }
}
