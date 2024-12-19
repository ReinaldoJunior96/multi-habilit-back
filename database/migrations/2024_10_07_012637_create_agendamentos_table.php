<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAgendamentosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('agendamentos', function (Blueprint $table) {
            $table->id(); // Primary key com auto-incremento
            $table->unsignedBigInteger('atendente'); // Chave estrangeira para a tabela 'usuarios'
            $table->unsignedBigInteger('paciente');  // Chave estrangeira para a tabela 'pacientes'
            $table->unsignedBigInteger('medico_id');    // Chave estrangeira para a tabela 'medicos'
            $table->unsignedBigInteger('convenio');
            $table->dateTime('data_agendada');       // Data do agendamento
            $table->tinyInteger('status');          // Status do agendamento
            $table->timestamps();                   // Campos 'created_at' e 'updated_at'
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('agendamentos');
    }
}
