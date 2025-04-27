<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Convenio extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'convenios';
    protected $fillable = [
        'codigo',
        'modo_recebimento',
        'descricao',
        'razao_social',
        'cnpj',
        'inscricao_estadual',
        'inscricao_municipal',
        'telefone',
        'contato',
        'site',
        'email',
        'observacao',
        'procedimentos',
        'medicamentos',
        'taxas',
        'materiais',
        'valor_filme',
        'dias_retorno_eletivo',
        'dias_retorno_emergencia',
        'vencimento_contrato',
        'tag_impressao_de_saia',
        'plano_de_contas',
        'alerta_ficha_atendimento',
        'apresenta_valor_do_procedimento',
        'convenio_apenas_solic_exame_cirurgia',
        'informa_procedimento_na_agenda',
        'nao_lista_agenda_web_wpp',
        'nao_entregar_laudo_web',
        'plataforma',
        'codigo_interface',
        'eligibilidade',
        'solicitacao_procedimento',
        'local_externo',
        'repetir_numero_senha',
        'exigir_numero_guia',
        'exigir_numero_carteira',
        'termo_anexo',
        'nao_replicar_numero_guia',
        'guia_sadt_consulta',
        'ocultar_valores_guias',
        'criticar_guia_repetida',
        'exige_numero_senha',
        'exige_numero_guia_principal',
        'exige_validade_carteira',
        'editar_valor_procedimento',
        'editar_valor_opme',
        'obrigar_local_ext_sadt',
        'agrupar_procedimento',
        'check_identificacao_fonte_pagadora',
        'input_identificacao_fonte_pagadora',
        'check_origem_cnpj_cpf',
        'input_codigo_prestador_operador',
        'destino',
        'empresa_credenciada',
        'qtd_digitos_matricula',
        'codigo_credenciado',
        'numero_registro_ans',
        'versao_padrao',
        'tabela_tiss_proced',
        'tabela_tiss_taxa',
        'mascara_guia',
        'mascara_guia_principal',
        'documentos_executantes',
        'documentos_solicitantes',
        'padrao_posicao_profissional',
        'numeracao_automatica_guia',
        'numeracao_guia_inicio',
        'numeracao_guia_fim',
        'numeracao_guia_atual',
        'numeracao_automatica_consulta',
        'numeracao_consulta_inicio',
        'numeracao_consulta_fim',
        'numeracao_consulta_atual',
        'numeracao_automatica_exame',
        'numeracao_exame_inicio',
        'numeracao_exame_fim',
        'numeracao_exame_atual',
        'numeracao_automatica_peq_atendimento',
        'numeracao_peq_atendimento_inicio',
        'numeracao_peq_atendimento_fim',
        'numeracao_peq_atendimento_atual',
        'coparticipacao_consulta',
        'coparticipacao_exame',
        'coparticipacao_internacao',
        'coparticipacao_peq_atendimento',
    ];


    public function procedimentos()
    {
        return $this->hasMany(Procedimento::class, 'convenio_id', 'id');
    }

    public function endereco()
    {
        return $this->belongsTo(Convenio::class, 'id_convenio');
    }
}
