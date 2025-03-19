<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('atendimentos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_paciente')->constrained('pacientes')->onDelete('cascade');
            $table->string('encaminhador')->nullable();
            $table->string('convenio')->nullable();
            $table->string('plano')->nullable();
            $table->string('carteira')->nullable();
            $table->boolean('cadastro_antecipado')->nullable();
            $table->boolean('aguardando_autorizacao')->nullable();
            $table->string('titular')->nullable();
            $table->string('tipo_consulta')->nullable();
            $table->string('dias_coparticipacao')->nullable();
            $table->string('tipo_atendimento')->nullable();
            $table->string('local_externo')->nullable();
            $table->string('clinica_indicacao')->nullable();
            $table->string('cid')->nullable();
            $table->string('local_atendimento')->nullable();
            $table->string('tipo_atendimento_eletiva_emergencia')->nullable();
            $table->string('setor_emergencia')->nullable();
            $table->string('tipo_acomodacao')->nullable();
            $table->string('leito')->nullable();
            $table->string('diarias_aut')->nullable();

            $table->string('solicitante')->nullable();
            $table->string('realizante')->nullable();
            $table->string('especialidade')->nullable();

            $table->string('numero_guia')->nullable();
            $table->date('autorizacao_data')->nullable();
            $table->string('senha')->nullable();
            $table->date('senha_validade')->nullable();
            $table->string('guia_principal')->nullable();
            $table->string('guia_operadora')->nullable();
            $table->string('observacao_cliente')->nullable();

            $table->string('indicador_acidente')->nullable();
            $table->string('tipo_saida')->nullable();
            $table->string('tipo_doenca')->nullable();
            $table->string('tempo_doenca')->nullable();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('atendimentos');
    }
};
