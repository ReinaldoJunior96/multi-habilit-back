<?php

namespace Database\Factories;

use App\Models\Procedimento;
use App\Models\Convenio;
use App\Models\Especialidade;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProcedimentoFactory extends Factory
{
    protected $model = Procedimento::class;

    public function definition()
    {
        return [
            'id_convenio' => Convenio::factory(),
            'id_especialidade' => Especialidade::factory(),
            'tabela' => $this->faker->word,
            'codigo' => $this->faker->numerify('COD-###'), // Removido o unique()
            'procedimento' => $this->faker->sentence(3),
            'procedimento_padrao' => $this->faker->sentence(3),
            'grupo' => $this->faker->word,
            'vacina' => $this->faker->word,
            'valor_ch' => $this->faker->randomFloat(2, 0, 1000),
            'filme' => $this->faker->randomFloat(2, 0, 100),
            'porte_anestesia' => $this->faker->numberBetween(1, 5),
            'ch_anestesista' => $this->faker->randomFloat(2, 0, 500),
            'custo_operacional' => $this->faker->randomFloat(2, 0, 1000),
            'numero_auxiliares' => $this->faker->numberBetween(0, 5),
            'codigo_tuss' => $this->faker->numerify('TUSS-####'),
            'instrumentador' => $this->faker->word,
            'porte_honorario' => $this->faker->numberBetween(1, 5),
            'tempo' => $this->faker->time(),
        ];
    }
}
