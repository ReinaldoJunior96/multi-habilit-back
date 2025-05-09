<?php

namespace Database\Factories;

use App\Models\Paciente;
use Illuminate\Database\Eloquent\Factories\Factory;

class PacienteFactory extends Factory
{
    protected $model = Paciente::class;

    public function definition(): array
    {
        return [
            // Informações do Paciente
            'nome' => $this->faker->name,
            'nome_social' => $this->faker->name,
            'nascimento' => $this->faker->date(),
            'sexo' => $this->faker->randomElement(['Masculino', 'Feminino', 'Outro']),
            'estado_civil' => $this->faker->randomElement(['Solteiro', 'Casado', 'Divorciado', 'Viúvo']),
            'preferencial' => $this->faker->boolean(),
            'inscricao_municipal' => $this->faker->numerify('###########'),
            'telefone' => $this->faker->phoneNumber,
            'identidade_rg' => $this->faker->numerify('##.###.###-#'),
            'cns' => $this->faker->numerify('###############'),
            'cpf' => $this->faker->numerify('###########'),
            'mae' => $this->faker->name('female'),
            'pai' => $this->faker->name('male'),
            'rn' => $this->faker->boolean,
            'oncologico' => $this->faker->boolean,
            'conjuge' => $this->faker->name,
            'cor_raca' => $this->faker->randomElement(['Branca', 'Parda', 'Preta', 'Amarela', 'Indígena']),
            'nacionalidade' => $this->faker->country,
            'profissao' => $this->faker->jobTitle,
            'instrucao' => $this->faker->randomElement(['Fundamental', 'Médio', 'Superior', 'Pós-graduação']),

            // Responsável
            'responsavel_nome' => $this->faker->name,
            'responsavel_rg' => $this->faker->numerify('##.###.###-#'),
            'responsavel_telefone' => $this->faker->phoneNumber,
            'responsavel_parentesco' => $this->faker->randomElement(['Pai', 'Mãe', 'Tio(a)', 'Avô(ó)', 'Outro']),
            'responsavel_ocupacao' => $this->faker->jobTitle,
            'responsavel_email' => $this->faker->safeEmail,

            // Contatos adicionais
            'contato_celular' => $this->faker->phoneNumber,
            'contato_email' => $this->faker->safeEmail,
        ];
    }
}
