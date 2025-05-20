<?php

namespace Database\Factories;

use App\Models\FichaMedica;
use App\Models\Paciente;
use Illuminate\Database\Eloquent\Factories\Factory;

class FichaMedicaFactory extends Factory
{
    protected $model = FichaMedica::class;

    public function definition()
    {
        return [
            'id_paciente' => Paciente::factory(),

            'ficha' => [
                'registro_ans' => $this->faker->numerify('########'),
                'numero_guia_principal' => $this->faker->uuid,
                'data_autorizacao' => $this->faker->date(),
                'senha' => $this->faker->bothify('SENHA####'),
                'data_validade_senha' => $this->faker->date('+1 month'),
                'numeroGuiaAtribuidoPelaOperadora' => $this->faker->uuid,
                'numeroCarteira' => $this->faker->numerify('##########'),
                'validadeCarteira' => $this->faker->date('+1 year'),
                'nomeSocial' => $this->faker->name,
                'nome' => $this->faker->name,
                'atendimentoRn' => $this->faker->boolean,

                'codigoOperadora' => $this->faker->numerify('OPER###'),
                'nomeContratado' => $this->faker->company,
                'nomeProfissionalSolicitante' => $this->faker->name,
                'conselhoProfissional' => 'CRM',
                'numeroConselho' => $this->faker->numerify('######-SP'),
                'uf' => 'SP',
                'codigoCbo' => $this->faker->numerify('######'),
                'assinaturaProfissionalSolicitante' => 'assinatura_base64',

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
                        'qtde_autorizada' => 1,
                    ]
                ],

                'codigo_operadora_contrato_executante' => $this->faker->numerify('EXE###'),
                'nome_contratado_dados_contrato_executante' => $this->faker->company,
                'codigoCnes' => $this->faker->numerify('#######'),

                'tipoAtendimento' => 'Ambulatorial',
                'indicacaoAcidente' => 'Não',
                'tipoConsulta' => 'Primeira vez',
                'motivoEncerramentoAtendimento' => 'Tratamento concluído',
                'regimeAtendimento' => 'Hospital dia',
                'saudeOcupacional' => $this->faker->boolean,

                'data' => $this->faker->date(),
                'horaInicial' => '08:00',
                'horaFinal' => '08:30',
                'tabela' => '22',
                'codigoProcedimento' => '998877',
                'descricao' => 'Procedimento Exemplo',
                'quantidade' => 1,
                'via' => 'Oral',
                'tec' => 'Simples',
                'fatorRedAcresc' => 1.0,
                'valorUnitario' => 100.0,
                'valorTotal' => 100.0,

                'seqRef' => '001',
                'grauPart' => '1',
                'codigoOperadoraIPE' => 'IPE123',
                'nomeProfissional' => $this->faker->name,
                'conselhoProfissionalIdentificacao' => 'CRM',
                'numeroConselhoIdentificacao' => $this->faker->numerify('######-SP'),
                'ufIdentificacao' => 'SP',
                'codigoCboIdentificacao' => $this->faker->numerify('######'),
                'dataRealizacaoProcedimentoEmSerie' => $this->faker->date(),
                'assinaturaBeneficiarioResponsavel' => 'assinatura_base64',
                'observacaoJustificacao' => $this->faker->sentence,
                'totalProcedimento' => 100.0,
                'totalTaxasAlugueis' => 0.0,
                'totalMateriais' => 0.0,
                'totalOpme' => 0.0,
                'totalMedicamentos' => 0.0,
                'totalGasesMedicinais' => 0.0,
                'totalGeral' => 100.0,
                'assinaturaResponsavelAutorizacao' => 'assinatura_base64',
                'assinaturaBeneficiarioResponsavelFinal' => 'assinatura_base64',
                'assinaturaContrato' => 'assinatura_base64',
            ]
        ];
    }
}
