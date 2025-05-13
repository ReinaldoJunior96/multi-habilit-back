<?php

namespace Database\Seeders;

use App\Models\Procedimento;
use App\Models\Convenio;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProcedimentoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Cria um convênio manualmente com modo_recebimento 'Particular' e todos os campos da factory
        $convenio = \App\Models\Convenio::create([
            'codigo' => 'CONV-001',
            'modo_recebimento' => 'Particular',
            'descricao' => 'Convênio Particular',
            'razao_social' => 'Convênio Exemplo',
            'cnpj' => '12345678000199',
            'inscricao_estadual' => '12345678',
            'inscricao_municipal' => '87654321',
            'telefone' => '(11) 99999-9999',
            'contato' => 'Fulano de Tal',
            'site' => 'https://convenioexemplo.com',
            'email' => 'contato@convenio.com',
            'observacao' => 'Observação teste',
            'medicamentos' => json_encode(['med1', 'med2']),
            'taxas' => json_encode(['taxa1', 'taxa2']),
            'materiais' => json_encode(['mat1', 'mat2']),
            'valor_filme' => 123.45,
            'dias_retorno_eletivo' => 10,
            'dias_retorno_emergencia' => 5,
            'vencimento_contrato' => '2025-12-31',
            'tag_impressao_de_saia' => 'TAG1',
            'plano_de_contas' => 'Plano1',
            'alerta_ficha_atendimento' => 'Alerta teste',
            'apresenta_valor_do_procedimento' => true,
            'convenio_apenas_solic_exame_cirurgia' => false,
            'informa_procedimento_na_agenda' => true,
            'nao_lista_agenda_web_wpp' => false,
            'nao_entregar_laudo_web' => false,
            'plataforma' => 'Web',
            'codigo_interface' => 'UUID-1234',
            'eligibilidade' => 'Sim',
            'solicitacao_procedimento' => 'Solicitado',
            'local_externo' => 'São Paulo',
            'repetir_numero_senha' => false,
            'exigir_numero_guia' => true,
            'exigir_numero_carteira' => false,
            'termo_anexo' => false,
            'nao_replicar_numero_guia' => false,
            'guia_sadt_consulta' => false,
            'ocultar_valores_guias' => false,
            'criticar_guia_repetida' => false,
            'exige_numero_senha' => false,
            'exige_numero_guia_principal' => false,
            'exige_validade_carteira' => false,
            'editar_valor_procedimento' => false,
            'editar_valor_opme' => false,
            'obrigar_local_ext_sadt' => false,
            'agrupar_procedimento' => false,
            'check_identificacao_fonte_pagadora' => 'check1',
            'input_identificacao_fonte_pagadora' => 'input1',
            'check_origem_cnpj_cpf' => 'check2',
            'input_codigo_prestador_operador' => 'input2',
            'destino' => 'Destino1',
            'empresa_credenciada' => 'Empresa Credenciada',
            'qtd_digitos_matricula' => 8,
            'codigo_credenciado' => 'CODCRED',
            'numero_registro_ans' => '12345678',
            'versao_padrao' => '3.05.00',
            'tabela_tiss_proced' => '00',
            'tabela_tiss_taxa' => '00',
            'mascara_guia' => '##########',
            'mascara_guia_principal' => '##########',
            'documentos_executantes' => json_encode(['CPF', 'RG']),
            'documentos_solicitantes' => json_encode(['CPF', 'CRM']),
            'padrao_posicao_profissional' => 'padrao1',
            'numeracao_automatica_guia' => false,
            'numeracao_guia_inicio' => 1000,
            'numeracao_guia_fim' => 9999,
            'numeracao_guia_atual' => 1000,
            'numeracao_automatica_consulta' => false,
            'numeracao_consulta_inicio' => 2000,
            'numeracao_consulta_fim' => 2999,
            'numeracao_consulta_atual' => 2000,
            'numeracao_automatica_exame' => false,
            'numeracao_exame_inicio' => 3000,
            'numeracao_exame_fim' => 3999,
            'numeracao_exame_atual' => 3000,
            'numeracao_automatica_peq_atendimento' => false,
            'numeracao_peq_atendimento_inicio' => 4000,
            'numeracao_peq_atendimento_fim' => 4999,
            'numeracao_peq_atendimento_atual' => 4000,
            'coparticipacao_consulta' => '10.00',
            'coparticipacao_exame' => '20.00',
            'coparticipacao_internacao' => '30.00',
            'coparticipacao_peq_atendimento' => '40.00',
        ]);

        // Cria vários procedimentos para esse convênio
        \App\Models\Procedimento::factory(5)->create([
            'id_convenio' => $convenio->id,
        ]);
    }
}
