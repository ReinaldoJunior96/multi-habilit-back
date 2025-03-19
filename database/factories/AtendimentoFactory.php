<?php

namespace Database\Factories;

use App\Models\Paciente;
use Illuminate\Database\Eloquent\Factories\Factory;

class AtendimentoFactory extends Factory
{
    public function definition(): array
    {
        return [
            'id_paciente' => Paciente::factory(),
            'encaminhador' => $this->faker->name(),
            'convenio' => $this->faker->company,
            'plano' => $this->faker->word(),
            'carteira' => $this->faker->numerify('##########'),
            'cadastro_antecipado' => $this->faker->boolean(),
            'aguardando_autorizacao' => $this->faker->boolean(),
            'titular' => $this->faker->name,
            'tipo_consulta' => $this->faker->randomElement(['Consulta Inicial', 'Retorno']),
            'dias_coparticipacao' => $this->faker->numberBetween(0, 30),
            'tipo_atendimento' => $this->faker->randomElement(['Ambulatorial', 'Internação']),
            'local_externo' => $this->faker->word(),
            'clinica_indicacao' => $this->faker->word(),
            'cid' => $this->faker->numerify('###'),
            'local_atendimento' => $this->faker->word(),
            'tipo_atendimento_eletiva_emergencia' => $this->faker->randomElement(['Eletiva', 'Emergência']),
            'setor_emergencia' => $this->faker->word(),
            'tipo_acomodacao' => $this->faker->randomElement(['Enfermaria', 'Apartamento']),
            'leito' => $this->faker->word(),
            'diarias_aut' => $this->faker->numberBetween(1, 10),
            'solicitante' => $this->faker->name,
            'realizante' => $this->faker->name,
            'especialidade' => $this->faker->word(),
            'numero_guia' => $this->faker->uuid(),
            'autorizacao_data' => $this->faker->date(),
            'senha' => $this->faker->password(),
            'senha_validade' => $this->faker->date(),
            'guia_principal' => $this->faker->uuid(),
            'guia_operadora' => $this->faker->uuid(),
            'observacao_cliente' => $this->faker->sentence(),
            'indicador_acidente' => $this->faker->randomElement(['Trabalho', 'Trânsito', 'Outros', 'N/I']),
            'tipo_saida' => $this->faker->randomElement(['Alta', 'Transferência', 'Óbito']),
            'tipo_doenca' => $this->faker->randomElement(['Aguda', 'Crônica']),
            'tempo_doenca' => $this->faker->randomElement(['0-7 dias', '8-30 dias', 'Mais de 30 dias']),
        ];
    }
}
