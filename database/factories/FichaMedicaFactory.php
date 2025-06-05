<?php

namespace Database\Factories;

use App\Models\FichaMedica;
use App\Models\Paciente;
use App\Models\Convenio;
use Illuminate\Database\Eloquent\Factories\Factory;

class FichaMedicaFactory extends Factory
{
    protected $model = FichaMedica::class;

    public function definition()
    {
        return [
            'id_paciente' => Paciente::factory(),
            'ficha' => [
                // Informações da guia
                'id_convenio' => Convenio::inRandomOrder()->first()?->id ?? Convenio::factory()->create()->id,
                'convenio' => $this->faker->company,
                'registro_ans' => $this->faker->numerify('########'),
                'numero_guia_principal' => $this->faker->uuid,
                'data_autorizacao' => $this->faker->date(),
                'senha' => $this->faker->bothify('SENHA####'),
                'data_validade_senha' => $this->faker->date('+1 month'),
                'numero_guia_operadora' => $this->faker->uuid,

                // Dados do Beneficiário
                'numero_carteira' => $this->faker->numerify('##########'),
                'validade_carteira' => $this->faker->date('+1 year'),
                'nome_social' => $this->faker->name,
                'nome' => $this->faker->name,
                'atendimento_rn' => $this->faker->boolean,

                // Dados do Solicitante
                'codigo_operadora' => $this->faker->numerify('OPER###'),
                'nome_contratado' => $this->faker->company,
                'nome_profissional_solicitante' => $this->faker->name,
                'conselho_profissional' => 'CRM',
                'numero_conselho' => $this->faker->numerify('######-SP'),
                'uf' => 'SP',
                'codigo_cbo' => $this->faker->numerify('######'),
                'assinatura_profissional_solicitante' => 'assinatura_base64',

                // Dados da Solicitação
                'carater_atendimento' => $this->faker->randomElement(['Eletivo', 'Urgência']),
                'data_solicitacao' => $this->faker->date(),
                'indicacao_clinica' => $this->faker->sentence,
                'indicador_cobertura_especial' => $this->faker->boolean,
                'procedimento' => [
                    [
                        'tabela' => '22',
                        'codigo' => '12345678',
                        'descricao' => 'Consulta médica',
                        'qtde_solicitada' => 1,
                        'qtde_autorizada' => 1
                    ]
                ],

                // Dados do Contrato Executante
                'codigo_operadora_contrato_executante' => $this->faker->numerify('EXE###'),
                'nome_contratado_completo_executante' => $this->faker->company,
                'codigo_cnes' => $this->faker->numerify('#######'),

                // Dados do Atendimento
                'tipo_atendimento' => 'Ambulatorial',
                'indicacao_acidente' => 'Não',
                'tipo_consulta' => 'Primeira vez',
                'motivo_encerramento_atendimento' => 'Tratamento concluído',
                'regime_atendimento' => 'Hospital dia',
                'saude_ocupacional' => $this->faker->boolean,

                // Procedimentos e Exames Realizados
                'data' => $this->faker->date(),
                'hora_inicial' => '08:00',
                'hora_final' => '08:30',
                'tabela' => '22',
                'codigo_procedimento' => '998877',
                'descricao' => 'Procedimento Exemplo',
                'quantidade' => 1,
                'via' => 'Oral',
                'tec' => 'Simples',
                'fator_red_acrec' => 1.0,
                'valor_unitario' => 100.0,
                'valor_total' => 100.0,

                // Identificação dos profissionais executantes
                'seq_ref' => '001',
                'grau_part' => '1',
                'codigo_operadora_profissional_executante' => $this->faker->numerify('IPE###'),
                'nome_profissional_executante' => $this->faker->name,
                'conselho_profissional_executante' => 'CRM',
                'numero_conselho_executante' => $this->faker->numerify('######-SP'),
                'uf_profissional_executante' => 'SP',
                'codigo_cbo_executante' => $this->faker->numerify('######'),
                'data_realizacao_procedimento_em_serie' => $this->faker->date(),
                'assinatura_beneficiario_profissional_executante' => 'assinatura_base64',
                'data_realizacao_profissional_executante' => $this->faker->date(),
                'observacao_justificacao' => $this->faker->sentence,
                'total_procedimentos' => 100.0,
                'taxa_alugueis' => 0.0,
                'total_materiais' => 0.0,
                'total_opme' => 0.0,
                'total_medicamentos' => 0.0,
                'total_gases_medicinais' => 0.0,
                'total_geral' => 100.0,
                'assinatura_responsavel_autorizacao' => 'assinatura_base64',
                'assinatura_beneficiario_responsavel' => 'assinatura_base64',
                'assinatura_contratado' => 'assinatura_base64',
                'status' => 'Pendente',
                'tipo_ficha' => 'terapia',
            ],
            'created_at' => now(),
        ];
    }
}
