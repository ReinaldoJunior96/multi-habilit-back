<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('pacientes', function (Blueprint $table) {
            $table->id();

            // Informações do Paciente
            $table->string('nome')->nullable();
            $table->string('nome_social')->nullable();
            $table->date('nascimento')->nullable();
            $table->string('sexo')->nullable();
            $table->string('estado_civil')->nullable();
            $table->boolean('preferencial')->nullable();
            $table->boolean('select_preferencial')->nullable();
            $table->string('inscricao_municipal')->nullable();
            $table->string('telefone')->nullable();
            $table->string('identidade_rg')->nullable();
            $table->string('cns')->nullable();
            $table->string('cpf')->nullable();
            $table->string('mae')->nullable();
            $table->string('pai')->nullable();
            $table->boolean('rn')->nullable();
            $table->boolean('oncologico')->nullable();
            $table->string('conjuge')->nullable();
            $table->string('cor_raca')->nullable();
            $table->string('nacionalidade')->nullable();
            $table->string('profissao')->nullable();
            $table->string('instrucao')->nullable();

            // Dados do Responsável
            $table->string('responsavel_nome')->nullable();
            $table->string('responsavel_cpf')->nullable();
            $table->string('responsavel_rg')->nullable();
            $table->string('responsavel_telefone')->nullable();
            $table->string('responsavel_parentesco')->nullable();
            $table->string('responsavel_ocupacao')->nullable();
            $table->string('responsavel_email')->nullable();

            // Contatos adicionais
            $table->string('contato_celular')->nullable();
            $table->string('contato_email')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pacientes');
    }
};
