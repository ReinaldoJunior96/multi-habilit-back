<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFiliacaoPacienteTable extends Migration
{
    public function up()
    {
        Schema::create('filiacao_paciente', function (Blueprint $table) {
            $table->id();
            $table->foreignId('paciente_id')->constrained()->onDelete('cascade');

            // Dados do Pai
            $table->string('cpf_pai')->nullable();
            $table->string('ocupacao_pai')->nullable();
            $table->string('email_pai')->nullable();
            $table->string('telefone_pai')->nullable();
            $table->string('celular_pai')->nullable();

            // Dados da Mãe
            $table->string('cpf_mae')->nullable();
            $table->string('ocupacao_mae')->nullable();
            $table->string('email_mae')->nullable();
            $table->string('telefone_mae')->nullable();
            $table->string('celular_mae')->nullable();

            // Dados para Emissão de Nota Fiscal
            $table->string('nome_nf')->nullable();
            $table->string('cpf_nf')->nullable();
            $table->string('ocupacao_nf')->nullable();
            $table->string('email_nf')->nullable();
            $table->string('telefone_nf')->nullable();
            $table->string('celular_nf')->nullable();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('filiacao_paciente');
    }
}
