<?php

namespace Database\Factories;

use App\Models\Procedimento;
use App\Models\Convenio;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProcedimentoFactory extends Factory
{
    protected $model = Procedimento::class;

    public function definition()
    {
        return [
            'id_convenio' => Convenio::factory(), // Cria um convenio automaticamente se precisar
            'tabela' => $this->faker->randomElement(['BRADESCO', 'UNIMED', 'AMIL']),
            'codigo' => $this->faker->numerify('######'),
            'procedimento' => $this->faker->sentence(2),
            'procedimento_padrao' => $this->faker->randomElement(['Sim', 'Não']),
            'grupo' => $this->faker->randomElement(['SESSÃO', 'CONSULTA', 'EXAME']),
            'vacina' => $this->faker->randomElement(['Sim', 'Não']),
            'valor_ch' => $this->faker->randomFloat(2, 50, 500),
            'filme' => $this->faker->randomFloat(2, 0, 10),
            'porte_anestesia' => $this->faker->numberBetween(0, 5),
            'ch_anestesista' => $this->faker->randomFloat(2, 0, 500),
            'custo_operacional' => $this->faker->randomFloat(2, 0, 500),
            'numero_auxiliares' => $this->faker->numberBetween(0, 5),
            'codigo_tuss' => $this->faker->numerify('######'),
            'instrumentador' => $this->faker->randomElement(['Sim', 'Não']),
            'porte_honorario' => $this->faker->numberBetween(0, 5),
            'tempo' => $this->faker->numerify('## minutos'),
        ];
    }
}
