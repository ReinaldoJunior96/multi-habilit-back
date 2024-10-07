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
            $table->foreignId('atendente')->constrained('atendentes')->onDelete('cascade'); // Chave estrangeira para a tabela 'atendentes'
            $table->foreignId('paciente')->constrained('usuarios')->onDelete('cascade'); // Chave estrangeira para a tabela 'usuarios'
            $table->foreignId('medico')->constrained('medicos')->onDelete('cascade'); // Chave estrangeira para a tabela 'medicos'
            $table->dateTime('data_agendada'); // Data do agendamento
            $table->tinyInteger('status'); // Status do agendamento
            $table->timestamps(); // Campos 'created_at' e 'updated_at'
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
