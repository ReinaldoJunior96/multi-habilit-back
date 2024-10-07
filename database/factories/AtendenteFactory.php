<?php

namespace Database\Factories;

use App\Models\Atendente;
use App\Models\Usuario;
use Illuminate\Database\Eloquent\Factories\Factory;

class AtendenteFactory extends Factory
{
    protected $model = Atendente::class;

    /**
     * Define o estado padrão do modelo.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'id_usuario' => Usuario::factory(), // Cria ou associa um usuário existente
        ];
    }
}
