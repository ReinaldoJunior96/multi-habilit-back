<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConveniosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('convenios', function (Blueprint $table) {
            $table->id(); // ID Primária
            $table->string('codigo')->nullable(); // Código do convênio
            $table->string('modo_recebimento')->nullable(); // Modo de recebimento
            $table->string('descricao')->nullable(); // Descrição
            $table->string('razao_social')->nullable(); // Razão Social
            $table->string('cnpj', 20)->nullable(); // CNPJ
            $table->string('inscricao_estadual')->nullable(); // Inscrição Estadual
            $table->string('inscricao_municipal')->nullable(); // Inscrição Municipal
            $table->string('telefone')->nullable(); // Telefone
            $table->string('contato')->nullable(); // Contato
            $table->string('site')->nullable(); // Site
            $table->string('email')->nullable(); // Email
            $table->text('observacao')->nullable(); // Observação
            //$table->json('procedimentos')->nullable(); // Procedimentos (array JSON)
            $table->string('medicamentos')->nullable(); // Medicamentos (array JSON)
            $table->string('taxas')->nullable(); // Taxas (array JSON)
            $table->string('materiais')->nullable(); // Materiais (array JSON)
            $table->decimal('valor_filme', 10, 2)->default(0)->nullable(); // Valor Filme
            $table->integer('dias_retorno_eletivo')->nullable(); // Dias Retorno Eletivo
            $table->integer('dias_retorno_emergencia')->nullable(); // Dias Retorno Emergência
            $table->date('vencimento_contrato')->nullable(); // Vencimento do Contrato
            $table->string('tag_impressao_de_saia')->nullable(); // Tag de Impressão de Saia
            $table->string('plano_de_contas')->nullable(); // Plano de Contas
            $table->string('alerta_ficha_atendimento')->nullable(); // Alerta Ficha de Atendimento

            $table->boolean('apresenta_valor_do_procedimento')->default(false);
            $table->boolean('convenio_apenas_solic_exame_cirurgia')->default(false);
            $table->boolean('informa_procedimento_na_agenda')->default(false);
            $table->boolean('nao_lista_agenda_web_wpp')->default(false);
            $table->boolean('nao_entregar_laudo_web')->default(false);


            $table->string('plataforma')->nullable();
            $table->string('codigo_interface')->nullable();


            $table->string('eligibilidade')->nullable();
            $table->string('solicitacao_procedimento')->nullable();


            $table->string('local_externo')->nullable();


            $table->boolean('repetir_numero_senha')->default(false);
            $table->boolean('exigir_numero_guia')->default(false);
            $table->boolean('exigir_numero_carteira')->default(false);
            $table->boolean('termo_anexo')->default(false);
            $table->boolean('nao_replicar_numero_guia')->default(false);
            $table->boolean('guia_sadt_consulta')->default(false);
            $table->boolean('ocultar_valores_guias')->default(false);
            $table->boolean('criticar_guia_repetida')->default(false);
            $table->boolean('exige_numero_senha')->default(false);
            $table->boolean('exige_numero_guia_principal')->default(false);
            $table->boolean('exige_validade_carteira')->default(false);
            $table->boolean('editar_valor_procedimento')->default(false);
            $table->boolean('editar_valor_opme')->default(false);
            $table->boolean('obrigar_local_ext_sadt')->default(false);
            $table->boolean('agrupar_procedimento')->default(false);



            //cabeçalho guia
            $table->string('check_identificacao_fonte_pagadora')->nullable();
            $table->string('input_identificacao_fonte_pagadora')->nullable();
            $table->string('check_origem_cnpj_cpf')->nullable();
            $table->string('input_codigo_prestador_operador')->nullable();
            $table->string('destino')->nullable();
            $table->string('empresa_credenciada')->nullable();


            //config
            $table->integer('qtd_digitos_matricula')->nullable();
            $table->string('codigo_credenciado')->nullable();
            $table->string('numero_registro_ans')->nullable();
            $table->string('versao_padrao')->nullable();
            $table->string('tabela_tiss_proced')->nullable();
            $table->string('tabela_tiss_taxa')->nullable();
            $table->string('mascara_guia')->nullable();
            $table->string('mascara_guia_principal')->nullable();

            //dados
            $table->string('documentos_executantes')->nullable();
            $table->string('documentos_solicitantes')->nullable();
            $table->string('padrao_posicao_profissional')->nullable();


            //regra geral guia
            $table->boolean('numeracao_automatica_guia')->default(false);
            $table->integer('numeracao_guia_inicio')->nullable();
            $table->integer('numeracao_guia_fim')->nullable();
            $table->integer('numeracao_guia_atual')->nullable();

            //regra geral consulta
            $table->boolean('numeracao_automatica_consulta')->default(false);
            $table->integer('numeracao_consulta_inicio')->nullable();
            $table->integer('numeracao_consulta_fim')->nullable();
            $table->integer('numeracao_consulta_atual')->nullable();


            //regra geral exame
            $table->boolean('numeracao_automatica_exame')->default(false);
            $table->integer('numeracao_exame_inicio')->nullable();
            $table->integer('numeracao_exame_fim')->nullable();
            $table->integer('numeracao_exame_atual')->nullable();


            //regra pequeno atendimento
            $table->boolean('numeracao_automatica_peq_atendimento')->default(false);
            $table->integer('numeracao_peq_atendimento_inicio')->nullable();
            $table->integer('numeracao_peq_atendimento_fim')->nullable();
            $table->integer('numeracao_peq_atendimento_atual')->nullable();


            //coorparticipação
            $table->string('coparticipacao_consulta')->nullable();
            $table->string('coparticipacao_exame')->nullable();
            $table->string('coparticipacao_internacao')->nullable();
            $table->string('coparticipacao_peq_atendimento')->nullable();


            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('convenios');
    }
}
