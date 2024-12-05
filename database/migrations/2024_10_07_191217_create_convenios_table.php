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
            $table->json('procedimentos')->nullable(); // Procedimentos (array JSON)
            $table->json('medicamentos')->nullable(); // Medicamentos (array JSON)
            $table->json('taxas')->nullable(); // Taxas (array JSON)
            $table->json('materiais')->nullable(); // Materiais (array JSON)
            $table->decimal('valor_filme', 10, 2)->default(0); // Valor Filme
            $table->integer('dias_retorno_eletivo')->nullable(); // Dias Retorno Eletivo
            $table->integer('dias_retorno_emergencia')->nullable(); // Dias Retorno Emergência
            $table->date('vencimento_contrato')->nullable(); // Vencimento do Contrato
            $table->string('tag_impressao_de_saia')->nullable(); // Tag de Impressão de Saia
            $table->string('plano_de_contas')->nullable(); // Plano de Contas
            $table->string('alerta_ficha_atendimento')->nullable(); // Alerta Ficha de Atendimento

            // Endereço
            $table->string('cep')->nullable(); // CEP
            $table->string('cidade')->nullable(); // Cidade
            $table->string('estado')->nullable(); // Estado
            $table->string('endereco')->nullable(); // Endereço
            $table->string('numero')->nullable(); // Número
            $table->string('complemento')->nullable(); // Complemento
            $table->string('bairro')->nullable(); // Bairro

            $table->timestamps(); // Campos de criação e atualização
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
