<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class ConvenioRequest extends FormRequest
{
    public function authorize()
    {
        return true; // Permite que qualquer usuário autorizado faça a solicitação.
    }

    public function rules()
    {
        $convenioId = $this->route('id'); // Pega o ID da rota, usado para ignorar o único na edição.

        return [
            'codigo' => ['nullable', 'string', 'max:255'],
            'modo_recebimento' => 'nullable|string|max:255',
            'descricao' => 'nullable|string|max:255',
            'razao_social' => 'nullable|string|max:255',
            'cnpj' => ['nullable', 'string', 'size:14'],
            'inscricao_estadual' => 'nullable|string|max:255',
            'inscricao_municipal' => 'nullable|string|max:255',
            'telefone' => 'nullable|string|max:20',
            'contato' => 'nullable|string|max:255',
            'site' => 'nullable|url|max:255',
            'email' => 'nullable|email|max:255',
            'observacao' => 'nullable|string',

            'procedimentos' => 'nullable|string',
            'medicamentos' => 'nullable|string',
            'taxas' => 'nullable|string',
            'materiais' => 'nullable|string',
            'valor_filme' => 'nullable|numeric|min:0',

            'dias_retorno_eletivo' => 'nullable|integer|min:0',
            'dias_retorno_emergencia' => 'nullable|integer|min:0',
            'vencimento_contrato' => 'nullable|date',

            'tag_impressao_de_saia' => 'nullable|string|max:255',
            'plano_de_contas' => 'nullable|string|max:255',
            'alerta_ficha_atendimento' => 'nullable|string|max:255',

            'apresenta_valor_do_procedimento' => 'nullable|boolean',
            'convenio_apenas_solic_exame_cirurgia' => 'nullable|boolean',
            'informa_procedimento_na_agenda' => 'nullable|boolean',
            'nao_lista_agenda_web_wpp' => 'nullable|boolean',
            'nao_entregar_laudo_web' => 'nullable|boolean',

            'plataforma' => 'nullable|string|max:255',
            'codigo_interface' => 'nullable|string|max:255',
            'eligibilidade' => 'nullable|string|max:255',
            'solicitacao_procedimento' => 'nullable|string|max:255',

            'local_externo' => 'nullable|string|max:255',

            'repetir_numero_senha' => 'nullable|boolean',
            'exigir_numero_guia' => 'nullable|boolean',
            'exigir_numero_carteira' => 'nullable|boolean',
            'termo_anexo' => 'nullable|boolean',
            'nao_replicar_numero_guia' => 'nullable|boolean',
            'guia_sadt_consulta' => 'nullable|boolean',
            'ocultar_valores_guias' => 'nullable|boolean',
            'criticar_guia_repetida' => 'nullable|boolean',
            'exige_numero_senha' => 'nullable|boolean',
            'exige_numero_guia_principal' => 'nullable|boolean',
            'exige_validade_carteira' => 'nullable|boolean',
            'editar_valor_procedimento' => 'nullable|boolean',
            'editar_valor_opme' => 'nullable|boolean',
            'obrigar_local_ext_sadt' => 'nullable|boolean',
            'agrupar_procedimento' => 'nullable|boolean',

            'check_identificacao_fonte_pagadora' => 'nullable|string|max:255',
            'input_identificacao_fonte_pagadora' => 'nullable|string|max:255',
            'check_origem_cnpj_cpf' => 'nullable|string|max:255',
            'input_codigo_prestador_operador' => 'nullable|string|max:255',
            'destino' => 'nullable|string|max:255',
            'empresa_credenciada' => 'nullable|string|max:255',

            'qtd_digitos_matricula' => 'nullable|integer|min:0',
            'codigo_credenciado' => 'nullable|string|max:255',
            'numero_registro_ans' => 'nullable|string|max:255',
            'versao_padrao' => 'nullable|string|max:255',
            'tabela_tiss_proced' => 'nullable|string|max:255',
            'tabela_tiss_taxa' => 'nullable|string|max:255',
            'mascara_guia' => 'nullable|string|max:255',
            'mascara_guia_principal' => 'nullable|string|max:255',

            'documentos_executantes' => 'nullable|string',
            'documentos_solicitantes' => 'nullable|string',
            'padrao_posicao_profissional' => 'nullable|string|max:255',

            'numeracao_automatica_guia' => 'nullable|boolean',
            'numeracao_guia_inicio' => 'nullable|integer|min:0',
            'numeracao_guia_fim' => 'nullable|integer|min:0',
            'numeracao_guia_atual' => 'nullable|integer|min:0',

            'numeracao_automatica_consulta' => 'nullable|boolean',
            'numeracao_consulta_inicio' => 'nullable|integer|min:0',
            'numeracao_consulta_fim' => 'nullable|integer|min:0',
            'numeracao_consulta_atual' => 'nullable|integer|min:0',

            'numeracao_automatica_exame' => 'nullable|boolean',
            'numeracao_exame_inicio' => 'nullable|integer|min:0',
            'numeracao_exame_fim' => 'nullable|integer|min:0',
            'numeracao_exame_atual' => 'nullable|integer|min:0',

            'numeracao_automatica_peq_atendimento' => 'nullable|boolean',
            'numeracao_peq_atendimento_inicio' => 'nullable|integer|min:0',
            'numeracao_peq_atendimento_fim' => 'nullable|integer|min:0',
            'numeracao_peq_atendimento_atual' => 'nullable|integer|min:0',

            'coparticipacao_consulta' => 'nullable|numeric|min:0',
            'coparticipacao_exame' => 'nullable|numeric|min:0',
            'coparticipacao_internacao' => 'nullable|numeric|min:0',
            'coparticipacao_peq_atendimento' => 'nullable|numeric|min:0',
        ];
    }


    public function messages()
    {
        return [
            'codigo.string' => 'O campo código deve ser um texto.',
            'modo_recebimento.string' => 'O campo modo de recebimento deve ser um texto.',
            'descricao.string' => 'O campo descrição deve ser um texto.',
            'razao_social.string' => 'O campo razão social deve ser um texto.',
            'cnpj.string' => 'O campo CNPJ deve ser um texto.',
            'inscricao_estadual.string' => 'O campo inscrição estadual deve ser um texto.',
            'inscricao_municipal.string' => 'O campo inscrição municipal deve ser um texto.',
            'telefone.string' => 'O campo telefone deve ser um texto.',
            'contato.string' => 'O campo contato deve ser um texto.',
            'site.string' => 'O campo site deve ser um texto.',
            'email.email' => 'O campo email deve ser um endereço de email válido.',
            'observacao.string' => 'O campo observação deve ser um texto.',
            'procedimentos.string' => 'O campo procedimentos deve ser um texto.',
            'medicamentos.string' => 'O campo medicamentos deve ser um texto.',
            'taxas.string' => 'O campo taxas deve ser um texto.',
            'materiais.string' => 'O campo materiais deve ser um texto.',
            'valor_filme.numeric' => 'O campo valor filme deve ser um número.',
            'dias_retorno_eletivo.integer' => 'O campo dias de retorno eletivo deve ser um número inteiro.',
            'dias_retorno_emergencia.integer' => 'O campo dias de retorno emergência deve ser um número inteiro.',
            'vencimento_contrato.date' => 'O campo vencimento do contrato deve ser uma data válida.',
            'tag_impressao_de_saia.string' => 'O campo tag de impressão de saia deve ser um texto.',
            'plano_de_contas.string' => 'O campo plano de contas deve ser um texto.',
            'alerta_ficha_atendimento.string' => 'O campo alerta ficha de atendimento deve ser um texto.',

            'apresenta_valor_do_procedimento.boolean' => 'O campo apresenta valor do procedimento deve ser verdadeiro ou falso.',
            'convenio_apenas_solic_exame_cirurgia.boolean' => 'O campo convênio apenas solicitação de exame/cirurgia deve ser verdadeiro ou falso.',
            'informa_procedimento_na_agenda.boolean' => 'O campo informa procedimento na agenda deve ser verdadeiro ou falso.',
            'nao_lista_agenda_web_wpp.boolean' => 'O campo não listar na agenda web/wpp deve ser verdadeiro ou falso.',
            'nao_entregar_laudo_web.boolean' => 'O campo não entregar laudo web deve ser verdadeiro ou falso.',

            'plataforma.string' => 'O campo plataforma deve ser um texto.',
            'codigo_interface.string' => 'O campo código interface deve ser um texto.',
            'eligibilidade.string' => 'O campo elegibilidade deve ser um texto.',
            'solicitacao_procedimento.string' => 'O campo solicitação procedimento deve ser um texto.',
            'local_externo.string' => 'O campo local externo deve ser um texto.',

            'repetir_numero_senha.boolean' => 'O campo repetir número senha deve ser verdadeiro ou falso.',
            'exigir_numero_guia.boolean' => 'O campo exigir número guia deve ser verdadeiro ou falso.',
            'exigir_numero_carteira.boolean' => 'O campo exigir número carteira deve ser verdadeiro ou falso.',
            'termo_anexo.boolean' => 'O campo termo anexo deve ser verdadeiro ou falso.',
            'nao_replicar_numero_guia.boolean' => 'O campo não replicar número guia deve ser verdadeiro ou falso.',
            'guia_sadt_consulta.boolean' => 'O campo guia SADT consulta deve ser verdadeiro ou falso.',
            'ocultar_valores_guias.boolean' => 'O campo ocultar valores das guias deve ser verdadeiro ou falso.',
            'criticar_guia_repetida.boolean' => 'O campo criticar guia repetida deve ser verdadeiro ou falso.',
            'exige_numero_senha.boolean' => 'O campo exige número senha deve ser verdadeiro ou falso.',
            'exige_numero_guia_principal.boolean' => 'O campo exige número guia principal deve ser verdadeiro ou falso.',
            'exige_validade_carteira.boolean' => 'O campo exige validade da carteira deve ser verdadeiro ou falso.',
            'editar_valor_procedimento.boolean' => 'O campo editar valor do procedimento deve ser verdadeiro ou falso.',
            'editar_valor_opme.boolean' => 'O campo editar valor de OPME deve ser verdadeiro ou falso.',
            'obrigar_local_ext_sadt.boolean' => 'O campo obrigar local externo SADT deve ser verdadeiro ou falso.',
            'agrupar_procedimento.boolean' => 'O campo agrupar procedimento deve ser verdadeiro ou falso.',

            'check_identificacao_fonte_pagadora.string' => 'O campo identificação da fonte pagadora deve ser um texto.',
            'input_identificacao_fonte_pagadora.string' => 'O campo input identificação fonte pagadora deve ser um texto.',
            'check_origem_cnpj_cpf.string' => 'O campo origem CNPJ/CPF deve ser um texto.',
            'input_codigo_prestador_operador.string' => 'O campo código do prestador operador deve ser um texto.',
            'destino.string' => 'O campo destino deve ser um texto.',
            'empresa_credenciada.string' => 'O campo empresa credenciada deve ser um texto.',

            'qtd_digitos_matricula.integer' => 'O campo quantidade de dígitos da matrícula deve ser um número inteiro.',
            'codigo_credenciado.string' => 'O campo código credenciado deve ser um texto.',
            'numero_registro_ans.string' => 'O campo número de registro ANS deve ser um texto.',
            'versao_padrao.string' => 'O campo versão padrão deve ser um texto.',
            'tabela_tiss_proced.string' => 'O campo tabela TISS procedimento deve ser um texto.',
            'tabela_tiss_taxa.string' => 'O campo tabela TISS taxa deve ser um texto.',
            'mascara_guia.string' => 'O campo máscara guia deve ser um texto.',
            'mascara_guia_principal.string' => 'O campo máscara guia principal deve ser um texto.',

            'documentos_executantes.string' => 'O campo documentos executantes deve ser um texto.',
            'documentos_solicitantes.string' => 'O campo documentos solicitantes deve ser um texto.',
            'padrao_posicao_profissional.string' => 'O campo padrão posição profissional deve ser um texto.',

            'numeracao_automatica_guia.boolean' => 'O campo numeração automática guia deve ser verdadeiro ou falso.',
            'numeracao_guia_inicio.integer' => 'O campo início da numeração da guia deve ser um número inteiro.',
            'numeracao_guia_fim.integer' => 'O campo fim da numeração da guia deve ser um número inteiro.',
            'numeracao_guia_atual.integer' => 'O campo numeração atual da guia deve ser um número inteiro.',

            'numeracao_automatica_consulta.boolean' => 'O campo numeração automática consulta deve ser verdadeiro ou falso.',
            'numeracao_consulta_inicio.integer' => 'O campo início da numeração da consulta deve ser um número inteiro.',
            'numeracao_consulta_fim.integer' => 'O campo fim da numeração da consulta deve ser um número inteiro.',
            'numeracao_consulta_atual.integer' => 'O campo numeração atual da consulta deve ser um número inteiro.',

            'numeracao_automatica_exame.boolean' => 'O campo numeração automática exame deve ser verdadeiro ou falso.',
            'numeracao_exame_inicio.integer' => 'O campo início da numeração do exame deve ser um número inteiro.',
            'numeracao_exame_fim.integer' => 'O campo fim da numeração do exame deve ser um número inteiro.',
            'numeracao_exame_atual.integer' => 'O campo numeração atual do exame deve ser um número inteiro.',

            'numeracao_automatica_peq_atendimento.boolean' => 'O campo numeração automática pequeno atendimento deve ser verdadeiro ou falso.',
            'numeracao_peq_atendimento_inicio.integer' => 'O campo início da numeração do pequeno atendimento deve ser um número inteiro.',
            'numeracao_peq_atendimento_fim.integer' => 'O campo fim da numeração do pequeno atendimento deve ser um número inteiro.',
            'numeracao_peq_atendimento_atual.integer' => 'O campo numeração atual do pequeno atendimento deve ser um número inteiro.',

            'coparticipacao_consulta.numeric' => 'O campo coparticipação consulta deve ser um número.',
            'coparticipacao_exame.numeric' => 'O campo coparticipação exame deve ser um número.',
            'coparticipacao_internacao.numeric' => 'O campo coparticipação internação deve ser um número.',
            'coparticipacao_peq_atendimento.numeric' => 'O campo coparticipação pequeno atendimento deve ser um número.',
        ];
    }



    protected function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {
        // Personaliza a resposta JSON em caso de erro de validação
        throw new HttpResponseException(response()->json([
            'message' => 'Os dados fornecidos são inválidos.',
            'errors' => $validator->errors(),
        ], 422));
    }
}
