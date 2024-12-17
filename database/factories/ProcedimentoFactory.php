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
            'codigo' => $this->faker->unique()->numerify('PROC-#####'),
            'nome' => $this->faker->word(),
            'valor_ch' => $this->faker->randomFloat(2, 0, 200),
            'porte_anestesia' => $this->faker->numberBetween(1, 5),
            'ch_anestesista' => $this->faker->numberBetween(1, 10),
            'custo_operacional' => $this->faker->randomFloat(2, 0, 500),
            'codigo_tuss' => $this->faker->unique()->numerify('TUSS-#####'),
            'num_auxiliares' => $this->faker->numberBetween(0, 5),
            'tempo' => $this->faker->numberBetween(10, 240),
            'valor_filme' => $this->faker->randomFloat(2, 0, 50),
            'convenio_id' => Convenio::factory(), // Cria automaticamente um convênio para cada procedimento
        ];
    }
}
