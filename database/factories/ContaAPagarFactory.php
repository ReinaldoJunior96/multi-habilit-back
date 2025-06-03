<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ContaAPagarFactory extends Factory
{
    protected $model = \App\Models\ContaAPagar::class;

    public function definition(): array
    {
        $categorias = ['Água', 'Luz', 'Internet', 'Aluguel', 'Material', 'Serviço'];
        $status = ['pendente', 'pago', 'atrasado'];
        $tipos = ['fixa', 'variável'];

        return [
            'descricao' => $this->faker->sentence(3),
            'categoria' => $this->faker->randomElement($categorias),
            'valor' => $this->faker->randomFloat(2, 50, 5000),
            'vencimento' => $this->faker->dateTimeBetween('-1 month', '+2 months')->format('Y-m-d'),
            'status' => $this->faker->randomElement($status),
            'tipo' => $this->faker->randomElement($tipos),
        ];
    }
}
