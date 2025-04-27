<?php

namespace Database\Factories;

use App\Models\Convenio;
use App\Models\Paciente;
use Illuminate\Database\Eloquent\Factories\Factory;

class ConvenioFactory extends Factory
{
    protected $model = Convenio::class;

    public function definition(): array
    {
        return [
            'codigo' => $this->faker->unique()->numerify('CONV-###'), // Código único
            'modo_recebimento' => $this->faker->randomElement(['Manual', 'Automático']), // Exemplo de modo de recebimento
            'descricao' => $this->faker->sentence(3), // Descrição
            'razao_social' => $this->faker->company, // Razão social
            'cnpj' => $this->faker->numerify('##############'), // CNPJ
            'inscricao_estadual' => $this->faker->numerify('########'), // Inscrição estadual
            'inscricao_municipal' => $this->faker->numerify('########'), // Inscrição municipal
            'telefone' => $this->faker->phoneNumber, // Telefone
            'contato' => $this->faker->name, // Nome do contato
            'site' => $this->faker->url, // URL do site
            'email' => $this->faker->unique()->safeEmail, // Email único
            'observacao' => $this->faker->text(100), // Observação curta
            'procedimentos' => $this->faker->word, // Procedimentos em JSON
            'medicamentos' => $this->faker->word, // Medicamentos em JSON
            'taxas' => $this->faker->word, // Taxas em JSON
            'materiais' => $this->faker->word, // Materiais em JSON
            'valor_filme' => $this->faker->randomFloat(2, 0, 1000), // Valor filme entre 0 e 1000
            'dias_retorno_eletivo' => $this->faker->numberBetween(1, 30), // Dias retorno eletivo
            'dias_retorno_emergencia' => $this->faker->numberBetween(1, 30), // Dias retorno emergência
            'vencimento_contrato' => $this->faker->date, // Data de vencimento do contrato
            'tag_impressao_de_saia' => $this->faker->word, // Tag de impressão
            'plano_de_contas' => $this->faker->word, // Plano de contas
            'alerta_ficha_atendimento' => $this->faker->sentence(3), // Alerta na ficha

            'apresenta_valor_do_procedimento' => $this->faker->boolean(),
            'convenio_apenas_solic_exame_cirurgia' => $this->faker->boolean(),
            'informa_procedimento_na_agenda' => $this->faker->boolean(),
            'nao_lista_agenda_web_wpp' => $this->faker->boolean(),
            'nao_entregar_laudo_web' => $this->faker->boolean(),

            'plataforma' => $this->faker->word(),
            'codigo_interface' => $this->faker->uuid(),

            'eligibilidade' => $this->faker->word(),
            'solicitacao_procedimento' => $this->faker->word(),

            'local_externo' => $this->faker->city(),

            'repetir_numero_senha' => $this->faker->boolean(),
            'exigir_numero_guia' => $this->faker->boolean(),
            'exigir_numero_carteira' => $this->faker->boolean(),
            'termo_anexo' => $this->faker->boolean(),
            'nao_replicar_numero_guia' => $this->faker->boolean(),
            'guia_sadt_consulta' => $this->faker->boolean(),
            'ocultar_valores_guias' => $this->faker->boolean(),
            'criticar_guia_repetida' => $this->faker->boolean(),
            'exige_numero_senha' => $this->faker->boolean(),
            'exige_numero_guia_principal' => $this->faker->boolean(),
            'exige_validade_carteira' => $this->faker->boolean(),
            'editar_valor_procedimento' => $this->faker->boolean(),
            'editar_valor_opme' => $this->faker->boolean(),
            'obrigar_local_ext_sadt' => $this->faker->boolean(),
            'agrupar_procedimento' => $this->faker->boolean(),

            'check_identificacao_fonte_pagadora' => $this->faker->word(),
            'input_identificacao_fonte_pagadora' => $this->faker->word(),
            'check_origem_cnpj_cpf' => $this->faker->word(),
            'input_codigo_prestador_operador' => $this->faker->word(),
            'destino' => $this->faker->city(),
            'empresa_credenciada' => $this->faker->company(),

            'qtd_digitos_matricula' => $this->faker->randomElement([6, 8, 10]),
            'codigo_credenciado' => $this->faker->word(),
            'numero_registro_ans' => $this->faker->numerify('########'),
            'versao_padrao' => '3.05.00',
            'tabela_tiss_proced' => '00',
            'tabela_tiss_taxa' => '00',
            'mascara_guia' => '##########',
            'mascara_guia_principal' => '##########',

            'documentos_executantes' => json_encode(['CPF', 'RG']),
            'documentos_solicitantes' => json_encode(['CPF', 'CRM']),
            'padrao_posicao_profissional' => $this->faker->word(),

            'numeracao_automatica_guia' => $this->faker->boolean(),
            'numeracao_guia_inicio' => 1000,
            'numeracao_guia_fim' => 9999,
            'numeracao_guia_atual' => 1000,

            'numeracao_automatica_consulta' => $this->faker->boolean(),
            'numeracao_consulta_inicio' => 2000,
            'numeracao_consulta_fim' => 2999,
            'numeracao_consulta_atual' => 2000,

            'numeracao_automatica_exame' => $this->faker->boolean(),
            'numeracao_exame_inicio' => 3000,
            'numeracao_exame_fim' => 3999,
            'numeracao_exame_atual' => 3000,

            'numeracao_automatica_peq_atendimento' => $this->faker->boolean(),
            'numeracao_peq_atendimento_inicio' => 4000,
            'numeracao_peq_atendimento_fim' => 4999,
            'numeracao_peq_atendimento_atual' => 4000,

            'coparticipacao_consulta' => $this->faker->randomFloat(2, 0, 100),
            'coparticipacao_exame' => $this->faker->randomFloat(2, 0, 200),
            'coparticipacao_internacao' => $this->faker->randomFloat(2, 0, 500),
            'coparticipacao_peq_atendimento' => $this->faker->randomFloat(2, 0, 150),

            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
